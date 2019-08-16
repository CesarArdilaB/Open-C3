<?
session_start();
if($op != 1 and $op != 2 and $op != 3 and $op != 4 and $op != 5 and $op != 6 and $op != 7){

?>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center">
  <h3>Reporte de Gestion</h3>
</div>

<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onsubmit="EnviarLinkForm('LogReport','<?=$RAIZHTTP?>/modules/monitoring/report_gestion.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td>Fecha Inicial: </td>
           <td><?=$formulario->c_fecha_input("","fecha_ini","","")?>
           &nbsp;</td>
           <td>Fecha Final:</td>
           <td><?=$formulario->c_fecha_input("","fecha_fin","","")?>             &nbsp;</td>
           <td><? $parametrosGrupoHerr=array(
	"tabla"=>"agents",
	"campo1"=>"number",
	"campo2"=>"name",
	"campoid"=>"number",
	"condiorden"=>"inactivo = 0 AND tipo = 0");
	echo $formulario->c_select("","id_agente","","","",$parametrosGrupoHerr,0,"","MuestraForms"); ?>
           &nbsp;</td>
           <td><input type="submit" name="button" id="button" value="Generar" /></td>
      </tr>
    </table>
</form></div>
<br />


<div id="LogReport"></div>


<? 
}//este es el que saca si no ahy ninguna opcion
if($op == 1){ // aqui termina la opcion 1
include '../../appcfg/general_config.php';

require '../../appcfg/class_reports.php';
$reporte = new reportes();
$reporte->RutaHTTP="$RAIZHTTP";

require '../../appcfg/class_asterisk.php';
$astm = new ast_man();

	if($id_agente != "-"){
	
	mysql_select_db("call_center");
	$idAg = $sqlm->sql_select("agent","id as agenteid","number = '$id_agente' AND estatus = 'A'",0);
	
	mysql_select_db("octres");
	$extAg= $sqlm->sql_select("agents","extension as agentext","number = '$id_agente'",0);
	
	$clausulaP = "AND id_agent = '".$idAg[0][agenteid]."'";
	
	$clausulaM = "AND src = '".$extAg[0][agentext]."'";
	
	}

//------------------------------------

mysql_select_db("call_center");
$LlamadasListaP = $sqlm->sql_select("calls","phone,uniqueid,fecha_llamada as fechah,uniqueid,duration as tiempod,id_agent as agente","status = 'Success' AND DATE(fecha_llamada) BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' $clausulaP",0);

mysql_select_db("asteriskcdrdb");
$LlamadasListaM = $sqlm->sql_select("cdr","dst as phone,uniqueid,calldate as fechah,uniqueid,billsec as tiempod, src as agente","LENGTH(dst) >= '7' and dst NOT REGEXP '8888' AND disposition = 'ANSWERED' AND DATE(calldate) BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' $clausulaM",0);

?>
<iframe width="100%" height="20px" name="reproductor" scrolling="no" frameborder="0"></iframe>


<table width="0" border="0" align="center" cellpadding="0" cellspacing="3" class="rounded-corners-blue">
  <tr>
    <td align="center" class="textos_titulos">Numero Telefonico</td>
    <td align="center" class="textos_titulos">Hora de Gestion</td>
    <td align="center" class="textos_titulos">Id Registro</td>
    <td align="center" class="textos_titulos">Asesor</td>
    <td align="center" class="textos_titulos">Ciudad</td>
    <td align="center" class="textos_titulos">Base</td>
    <td align="center" class="textos_titulos">Tiempo de Conversacion</td>
    <td align="center" class="textos_titulos">Tipificacion</td>
    <td align="center" class="textos_titulos">Tipo de Marcacion</td>
    <td align="center" class="textos_titulos">Grabacion</td>
  </tr>
<? 
if(is_array($LlamadasListaP)){ 

for($i = 0 ;$i < count($LlamadasListaP) ; $i++) { 

$idregistro = $reporte->traer_id_registro($LlamadasListaP[$i][phone]);
$agente = $reporte->traer_id_asesor_cid($LlamadasListaP[$i][agente],"name");

if($idregistro != "Numero Sin Registro"){
mysql_select_db("octres");

$RegData = $sqlm->sql_select("autof_formulario_1","*","autof_formulario_1_id = '$idregistro'",0);


$TipiFi = $sqlm->sql_select("autof_af11_86","field1,field2","id_af11_86 = '".$RegData[0][af11_86]."'",0);
	if(is_array($TipiFi))	{
	$tipificacion = $TipiFi[0][field1];			
							}

$City = $sqlm->sql_select("autof_af11_45","field1,field2","id_af11_45 = '".$RegData[0][af11_45]."'",0);
	if(is_array($City))	{
	$city = $City[0][field1];			
							}

}else{$RegData = array(""); $TipiFi=array(""); $tipificacion=""; $city="";}


?>
  <tr>
    <td bgcolor="#FFFFFF" class="textos"><?=$LlamadasListaP[$i][phone]?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos"><?=$LlamadasListaP[$i][fechah]?></td>
    <td bgcolor="#FFFFFF" class="textos" align="center"><?=$idregistro?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos"><?=$agente?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos" align="center"><?=$city?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos" align="center"><?=$RegData[0][af11_91]?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos" align="center"><?=number_format($LlamadasListaP[$i][tiempod]/2,1)?> min&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos" align="center"><?=$tipificacion?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos">Predictivo</td>
    <td bgcolor="#FFFFFF" class="textos"><div align="center" id="<?=$LlamadasListaP[$i][uniqueid]?>">
    <a class="textos" href="javascript:EnviarLinkJ('<?=$LlamadasListaP[$i][uniqueid]?>','modules/monitoring/recfinder.php?unicoid=<?=$LlamadasListaP[$i][uniqueid]?>');">Buscar Archivo</a></div>&nbsp;</td>
  </tr>
<? } } //if?> 
  <tr>
    <td colspan="11" bgcolor="#CCCCCC" class="textos">Manuales</td>
  </tr>
<? 
if(is_array($LlamadasListaM)){ 
for($i = 0 ;$i < count($LlamadasListaM) ; $i++) { 

$idregistro = $reporte->traer_id_registro($LlamadasListaM[$i][phone]);
$agente = $reporte->traer_id_asesor_cext($LlamadasListaM[$i][agente],"name");

if($idregistro != "Numero Sin Registro"){
mysql_select_db("octres");

$RegData = $sqlm->sql_select("autof_formulario_1","*","autof_formulario_1_id = '$idregistro'",0);

$TipiFi = $sqlm->sql_select("autof_af11_86","field1,field2","id_af11_86 = '".$RegData[0][af11_86]."'",0);
	if(is_array($TipiFi))	{
	$tipificacion = $TipiFi[0][field1];			
							}

$City = $sqlm->sql_select("autof_af11_45","field1,field2","id_af11_45 = '".$RegData[0][af11_45]."'",0);
	if(is_array($City))	{
	$city = $City[0][field1];			
							}
							
}
else{$RegData = array(""); $TipiFi=array(""); $tipificacion=""; $city="";}

?>
  <tr>
    <td bgcolor="#FFFFFF" class="textos"><?=$LlamadasListaM[$i][phone]?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos"><?=$LlamadasListaM[$i][fechah]?></td>
    <td bgcolor="#FFFFFF" class="textos" align="center"><?=$idregistro?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos"><?=$agente?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos" align="center"><?=$city?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos" align="center"><?=$RegData[0][af11_91]?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos" align="center"><?=number_format($LlamadasListaM[$i][tiempod]/2,1)?> min&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos" align="center"><?=$tipificacion?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos">Manual</td>
    <td bgcolor="#FFFFFF" class="textos"><div align="center" id="<?=$LlamadasListaM[$i][uniqueid]?>">
    <a class="textos" href="javascript:EnviarLinkJ('<?=$LlamadasListaM[$i][uniqueid]?>','modules/monitoring/recfinder.php?unicoid=<?=$LlamadasListaP[$i][uniqueid]?>');">Buscar Archivo</a></div>&nbsp;</td>
  </tr>
<? } } //if?> 
</table>

<? 

//echo $astm->trae_agentes();

} // aqui termina la opcion 1?>
