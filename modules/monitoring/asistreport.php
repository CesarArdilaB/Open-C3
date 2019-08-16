<?
session_start();
if($op != 1 and $op != 2 and $op != 3 and $op != 4 and $op != 5 and $op != 6 and $op != 7){

?>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center">
  <h3>Reporte de Asistensia</h3>
</div>

<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onsubmit="EnviarLinkForm('LogReport','<?=$RAIZHTTP?>/modules/monitoring/asistreport.php?op=1',this);return false;">
  
    <p class="textosbig">Fecha Inicial: <?=$formulario->c_fecha_input("","fecha_ini","","")?>- Fecha Final: <?=$formulario->c_fecha_input("","fecha_fin","","")?> 
      <input type="submit" name="button" id="button" value="Generar">
    </p>
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

mysql_select_db("octres");
$AgentesLista = $sqlm->sql_select("agents","name,number,extension","tipo = 0 AND inactivo = 0",0);

mysql_select_db("call_center");
$fechas = $sqlm->sql_select("audit","CONCAT(DAY(datetime_init),'-',MONTH(datetime_init)) as fechaM,DATE(datetime_init) as fechaP","DATE(datetime_init) BETWEEN '$fecha_ini' AND '$fecha_fin' GROUP BY DATE(datetime_init)",0);
?>

<table width="0" border="0" align="center" cellpadding="0" cellspacing="3" class="rounded-corners-blue">
  <tr>
    <td class="textos_titulos">Nombre Asesor</td>
<? for($o = 0 ;$o < count($fechas) ; $o++) { ?>
    <td class="textos_titulos"><?=$fechas[$o][fechaM]?>&nbsp;</td>
<? } ?> 
  </tr>
<? for($i = 0 ;$i < count($AgentesLista) ; $i++) { 

?>
  <tr>
    <td bgcolor="#FFFFFF" class="textos"><?=$AgentesLista[$i][name]?>&nbsp;</td>

<? for($o = 0 ;$o < count($fechas) ; $o++) { ?>
    <td align="center" class="textos"><?=$reporte->traer_asistencia($AgentesLista[$i][number],$fechas[$o][fechaP])?></td>
<? } ?> 

  </tr>
<? } ?> 
</table>




<? 

//echo $astm->trae_agentes();

} // aqui termina la opcion 1?>
