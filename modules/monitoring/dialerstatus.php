<?
session_start();
if($op != 1 and $op != 2 and $op != 3 and $op != 4 and $op != 5 and $op != 6 and $op != 7){
?>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center">
  <h3>Marcador Predictivo En Tiempo Real</h3>
</div>

<script>
setInterval( "EnviarLinkJ('DialerEstatus','modules/monitoring/dialerstatus.php?op=1','',1)", 2000 );
</script>
<br />

<div id="DialerEstatus"></div>

<? 
}//este es el que saca si no ahy ninguna opcion
if($op == 1){ // aqui termina la opcion 1
include '../../appcfg/general_config.php';

require '../../appcfg/class_reports.php';
$reporte = new reportes();
$reporte->RutaHTTP="$RAIZHTTP";

require '../../appcfg/class_asterisk.php';
$astm = new ast_man();

mysql_select_db("call_center");
$ColaGroup = $sqlm->sql_select("campaign","queue","estatus 	= 'A'  GROUP BY queue");
?>

<div align="center">
<? 
for($i = 0 ;$i < count($ColaGroup) ; $i++) {
	
$AgentesCola = $sqlm->sql_select("current_calls","id_call,TIME(fecha_inicio)as hora,uniqueid,queue,agentnum,event,Channel,ChannelClient,hold ","queue = '".$ColaGroup[$i][queue]."'");

if(is_array($AgentesCola)){ //verificamos resultado
?>
<table width="0" border="0" cellpadding="0" cellspacing="4" class="rounded-corners-blue">
  <tr>
    <td colspan="3" align="center" class="textos_titulos">Agentes con llamada para la cola: 
      <?=$ColaGroup[$i][queue]?></td>
    </tr>
  <tr>
    <td align="center" class="textos_titulos">Aqente</td>
    <td align="center" class="textos_titulos">Duracion</td>
    <td align="center" class="textos_titulos"> Numero Marcado</td>
    </tr>
<? for($o = 0 ;$o < count($AgentesCola) ; $o++) {

$numeroA=explode("@",$AgentesCola[$o][ChannelClient]);
$numeroB=explode("/",$numeroA[0]);
	
?>
  <tr>
    <td align="left" class="textos"><?=$reporte->trae_dato_agente("name",$AgentesCola[$o][agentnum])?></td>
    <td align="left" class="textos"><?=$reporte->tiempo_corrido($AgentesCola[$o][hora],$hora_act)?></td>
    <td align="left" class="textos"><?=$numeroB[1]?></td>
    </tr>
<? } 

}else{ ?>

<div align="center" class="textos_titulos">Ningun Agente Tiene Llamadas.</div>

<? } ?>  
</table>
<? 
$ColaStatus =  $astm->trae_colas();
?>

<table width="0" border="0" cellpadding="0" cellspacing="4" class="rounded-corners-blue">
  <tr>
    <td colspan="3" align="center" class="textos_titulos">Estado de la Colo:
      <?=$ColaGroup[$i][queue]?></td>
    </tr>
  <tr>
    <td class="textos_titulos"># de LLamadas</td>
    <td class="textos_titulos">Abandonos</td>
    <td class="textos_titulos">Nivel de Servicio</td>
  </tr>
  <tr>
    <td align="center" class="textos"><?=$ColaStatus[$ColaGroup[$i][queue]][llamadas]?>&nbsp;</td>
    <td align="center" class="textos"><?=$ColaStatus[$ColaGroup[$i][queue]][abandonos]?>&nbsp;</td>
    <td align="center" class="textos"><?=$ColaStatus[$ColaGroup[$i][queue]][servicioP]?>&nbsp;</td>
  </tr>
</table>
<?


 } //ve}ridicamos si ahy llamadas
?>
</div>

<? 

//echo $astm->trae_agentes();

} // aqui termina la opcion 1?>