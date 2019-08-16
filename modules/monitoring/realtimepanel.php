<?
session_start();
if($op != 1 and $op != 2 and $op != 3 and $op != 4 and $op != 5 and $op != 6 and $op != 7){
?>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center">
  <h3>Panel En Tiempo Real</h3>
</div>

<script>
setInterval( "EnviarLinkJ('AgentsEstatus','modules/monitoring/realtimepanel.php?op=1','',1)", 2000 );
</script>
<br />

<div id="AgentsEstatus"></div>

<? 
}//este es el que saca si no ahy ninguna opcion
if($op == 1){ // aqui termina la opcion 1
include '../../appcfg/general_config.php';

require '../../appcfg/class_reports.php';
$reporte = new reportes();
$reporte->RutaHTTP="$RAIZHTTP";

require '../../appcfg/class_asterisk.php';
$astm = new ast_man();

mysql_select_db("octres");

$AgentesLista = $sqlm->sql_select("agents","*","inactivo = 0 AND tipo = 0 AND number != 0",0);

$llamadam=$astm->trae_llamadaext();

$agentesP = $astm->trae_agentes();

$agentesQe = $astm->trae_colas_agents();

//print_r($agentesQe);
?>

<div align="center">

<table width="0" border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
  <tr>
    <td class="textos_titulos">Nombre</td>
    <td class="textos_titulos">Numero</td>
    <td align="center" class="textos_titulos">Estado</td>
    <td class="textos_titulos">Tiempo Conexion</td>
    <td class="textos_titulos">Extencion</td>
    <td class="textos_titulos">Tipo de Llamada</td>
    <td class="textos_titulos">Hablando Con</td>
    <td class="textos_titulos">Tiempo Llamada</td>
    <td class="textos_titulos">Tiempo Sin Llamada</td>
    <td class="textos_titulos">Acciones</td>
  </tr>
<? for($i = 0 ;$i < count($AgentesLista) ; $i++) {

	$numeroA = $AgentesLista[$i][number];
	
	
	
	if($agentesP[$numeroA][estado] == "AGENT_IDLE"){
		
		if($agentesQe[$numeroA][pausado] == 1){
		
		$nombreBreack = $reporte->ultimo_break_nombre_callmodule($numeroA);
		
		$nDescom = explode("|",$nombreBreack);
		
		if($nDescom[0] != ""){ $nDescom[0] = " en: ".$nDescom[0]; }
		$tpausa=$reporte->tiempo_corrido($nDescom[1],$hora_act);

		$estadoA="<font color='#FF9900'><strong>Pausado ".$nDescom[0]." - $tpausa</strong></font>";
		$colorf="#FFFF93";
			
			}else{
		
		$estadoA="<font color='green'><strong>Conectado</strong></font>";
		$colorf="#9BFF9B";
		
				}
			
	}elseif($agentesP[$numeroA][estado] == "AGENT_LOGGEDOFF"){
	
		$estadoA="<font color='red'><strong>Desconectado</strong></font>";
		$colorf="#FFC4C4";
		$_SESSION[ultcallhora][$numeroA] = "";
		
	}elseif($agentesP[$numeroA][estado] == "AGENT_ONCALL"){
		
		$estadoA="<font color='blue'><strong>En LLamada</strong></font>";
		$colorf="#B3E7FF";
		
		//if($agentesP[$numeroA][estado] == "AGENT_ONCAL")
		
		}
	
	//sacamos el tiempo corrido
	if($agentesP[$numeroA][tiempolog] !=0 ){
		
		$tlog=$reporte->tiempo_corrido($agentesP[$numeroA][tiempolog],$hora_act);
		
	}else{ $tlog = 0; }
	
	//verificamos que la extencion de logueo sea igual a la que esta asignada
	
	if($agentesP[$numeroA][extension] != "n/a"){
	
	if($agentesP[$numeroA][extension] == $AgentesLista[$i][extension]){
		
		$extA="<font color='green'><strong>".$agentesP[$numeroA][extension]."</strong></font>";
		$extN=$agentesP[$numeroA][extension];
				
		}else{
		
		$extA="<font color='red'><strong>! Log: ".$agentesP[$numeroA][extension]." - Asig: ".$AgentesLista[$i][extension]." !</strong></font>";
		$extN=$agentesP[$numeroA][extension];
			
		}
	}else{ $extA = "n/a"; $extN=0;}
	
	//verificamos si tiene llamada de predictivo o manual
mysql_select_db("call_center");
$LlamadaDialer = $sqlm->sql_select("current_calls","id_call,TIME(fecha_inicio)as hora,uniqueid,queue,agentnum,event,Channel,ChannelClient,hold ","agentnum = '".$numeroA."'");

	if(is_array($LlamadaDialer)){
		
	$tipocall="Predictivo";
	$duracall=$reporte->tiempo_corrido($LlamadaDialer[0][hora],$hora_act);
	
	$NumeroLLamado = $sqlm->sql_select("calls","phone","id = ".$LlamadaDialer[0][id_call]);
	
	$llamandoN = $NumeroLLamado[0][phone];
	
	$_SESSION[ultcallhora][$numeroA] = $hora_act;
	
	}elseif($llamadam[$extN][numerocanal] != ""){
	
	$llamandoN = $llamadam[$extN][numerocanal];
	$tipocall="Manual";
	$duracall=$llamadam[$extN][segundos];
	
	$tiempoM = number_format($duracall / 60,2);
	if($duracall > 60 and $tiempoM < 60){ $duracall = number_format($duracall / 60,2); $pos="Min";}
	elseif($tiempoM > 60 ){ $duracall = number_format($duracall / 60 / 60,2); $pos="Hor"; }
	else{$pos="Seg";}
	
	$_SESSION[ultcallhora][$numeroA] = $hora_act;

	
	}else{ 
	
	$llamandoN = "";
	$tipocall= "";
	$duracall= "";
	//$_SESSION[ultcallhora][$numeroA] = "";
	 }
	
?>
  <tr bgcolor="<?=$colorf?>">
    <td class="textos_titulos"><?=$AgentesLista[$i][name]?>&nbsp;</td>
    <td class="textos" align="center"><?=$numeroA?>&nbsp;</td>
    <td align="center"><?=$estadoA?>&nbsp;</td>
    <td align="center"><?=$tlog?>&nbsp;</td>
    <td align="center"><?=$extA?>&nbsp;</td>
    <td align="center"><?=$tipocall?>&nbsp;</td>
    <td><?=$llamandoN?>&nbsp;</td>
    <td align="center"><?=$duracall?>&nbsp;</td>
    <td align="center"><? if($_SESSION[ultcallhora][$numeroA] != ""){echo $reporte->tiempo_corrido($_SESSION[ultcallhora][$numeroA],$hora_act);}?>&nbsp;</td>
    <td align="center"> - </td>
  </tr>
<? } ?> 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</div>

<? 

//echo $astm->trae_agentes();

} // aqui termina la opcion 1?>