<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[op] != 7){
include '../../appcfg/general_config.php';
require 'appcfg/cc_call.php';
mysql_select_db("asteriskcdrdb");
?>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center">
  <h3>Reporte de Colas</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/reports/queue_report.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Inicial: <br></td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_ini","","")?>
          &nbsp;</td>
        <td class="textos_titulos">Fecha Final: </td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_fin","","")?>
        &nbsp;</td>
        <td class="textos_titulos">Cola</td>
        <td class="textos_titulos">
<? 
	$parametrosGrupoHerr=array(
	"tabla"=>"queue_log",
	"campo1"=>"dcontext",
	"campo2"=>"dcontext",
	"campoid"=>"dcontext",
	"condiorden"=>"dcontext != 'NONE' GROUP BY dcontext");
	
echo $formulario->c_select("","cola","","","",$parametrosGrupoHerr,0,"","MuestraFils"); ?>&nbsp;</td>
        <td class="textos_titulos"><span class="textosbig">
          <input type="submit" name="button" id="button" value="Generar">
        </span></td>
      </tr>
    </table>
  </form>
</div>
<br />
<div id="PersInf"></div>
<? 
}//este es el que saca si no ahy ninguna opcion
if($_GET[op] == 1){ // aqui termina la opcion 1
include '../../appcfg/general_config.php';
require '../../appcfg/cc_call.php';
mysql_select_db("asteriskcdrdb");

$SelectDATA = $sqlm->sql_select("queue_log","DAY(fecha) as dia, MONTH(fecha) as mes, DATE(fecha) as fecha","dcontext = '$_GET[cola]' AND DATE(fecha) BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' GROUP BY DAY(fecha)",0);

$SelectAgentes = $sqlm->sql_select("queue_log","agente","agente != 'NONE' AND dcontext = '$_GET[cola]' AND DATE(fecha) BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' GROUP BY agente",0);

//print_r($SelectDATA);

if(is_array($SelectDATA)){

excelexp("informe");

?>

<div align="center"><span class="textos_titulos">Cola:
    <?=$cola?>
</span><br />
  <table border="0" cellpadding="2" cellspacing="2" class="rounded-corners-blue">
    <tr>
      <td rowspan="2" class="textos_titulos">Llamadas / Fechas</td>
<? for($i=0 ; $i < count($SelectDATA) ; $i++){//este es el final del for ?>
<td colspan="2" align="center" bgcolor="#FFFFFF" class="textosHoras"><?=$SelectDATA[$i][mes]." - ".$SelectDATA[$i][dia]?>&nbsp;</td>
<? } //este es el final del for ?>
    </tr>
    <tr>
<? for($i=0 ; $i < count($SelectDATA) ; $i++){//este es el final del for ?>
      <td bgcolor="#FFFFFF" class="textosHoras">#</td>
      <td align="center" bgcolor="#FFFFFF" class="textosHoras">%</td>
<? } //este es el final del for ?>

    </tr>
    <tr>
      <td bgcolor="#FFFFFF" class="textos"> Recibidas</td>
<? 
for($i=0 ; $i < count($SelectDATA) ; $i++){//este es el final del for 

//aqui traemos los valores de cada estadistica.

$TotalCalls = $sqlm->sql_select("queue_log","count(dcontext) as cuenta","evento = 'ENTERQUEUE' AND dcontext = '$_GET[cola]' AND DATE(fecha) = '".$SelectDATA[$i][fecha]."'",0);
$TotalCallsCon = $sqlm->sql_select("queue_log","count(dcontext) as cuenta","evento = 'CONNECT' AND dcontext = '$_GET[cola]' AND DATE(fecha) = '".$SelectDATA[$i][fecha]."'",0);
$TotalCallsAban = $sqlm->sql_select("queue_log","count(dcontext) as cuenta","evento = 'ABANDON' AND dcontext = '$_GET[cola]' AND DATE(fecha) = '".$SelectDATA[$i][fecha]."'",0);

$TotalCallsCon10 = $sqlm->sql_select("queue_log","count(dcontext) as cuenta","parametro_1 < 10 AND evento = 'CONNECT' AND dcontext = '$cola' AND DATE(fecha) = '".$SelectDATA[$i][fecha]."'",0);
$TotalCallsCon20 = $sqlm->sql_select("queue_log","count(dcontext) as cuenta","parametro_1 BETWEEN 10 AND 20 AND evento = 'CONNECT' AND dcontext = '$_GET[cola]' AND DATE(fecha) = '".$SelectDATA[$i][fecha]."'",0);



?>
<td bgcolor="#FFFFFF" class="textosHoras"><?=$TotalCalls[0][cuenta]?>&nbsp;</td>
<td bgcolor="#FFFFFF" class="textosHoras">100&nbsp;</td>
<? } //este es el final del for ?>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" class="textos"> Conectadas</td>
<? for($i=0 ; $i < count($SelectDATA) ; $i++){//este es el final del for ?>
      <td bgcolor="#FFFFFF" class="textosHoras"><?=$TotalCallsCon[0][cuenta]?>&nbsp;</td>
      <td bgcolor="#FFFFFF" class="textosHoras"><?=number_format(($TotalCallsCon[0][cuenta]/$TotalCalls[0][cuenta])*100,1)?>&nbsp;</td>
<? } ?>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" class="textos">Abandonos</td>
<? for($i=0 ; $i < count($SelectDATA) ; $i++){//este es el final del for ?>
      <td bgcolor="#FFFFFF" class="textosHoras"><?=$TotalCallsAban[0][cuenta]?>&nbsp;</td>
      <td bgcolor="#FFFFFF" class="textosHoras"><?=number_format(($TotalCallsAban[0][cuenta]/$TotalCalls[0][cuenta])*100,1)?>&nbsp;</td>
<? } ?>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" class="textos">Conectadas &lt; 10 seg</td>
<? for($i=0 ; $i < count($SelectDATA) ; $i++){//este es el final del for ?>

      <td bgcolor="#FFFFFF" class="textosHoras"><?=$TotalCallsCon10[0][cuenta]?>&nbsp;</td>
      <td bgcolor="#FFFFFF" class="textosHoras"><?=number_format(($TotalCallsCon10[0][cuenta]/$TotalCalls[0][cuenta])*100,1)?>&nbsp;</td>
<? } ?>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" class="textos">Conectadas &lt; 20 seg</td>
<? for($i=0 ; $i < count($SelectDATA) ; $i++){//este es el final del for ?>
      <td bgcolor="#FFFFFF" class="textosHoras"><?=$TotalCallsCon20[0][cuenta]?>&nbsp;</td>
      <td bgcolor="#FFFFFF" class="textosHoras"><?=number_format(($TotalCallsCon20[0][cuenta]/$TotalCalls[0][cuenta])*100,1)?>&nbsp;</td>
<? } ?>
    </tr>
    <tr>
      <td bgcolor="#ECF5FF" class="textos_negros" colspan="<?=count($SelectDATA)+4?>">Agentes</td>
    </tr>
<? for($o=0 ; $o < count($SelectAgentes) ; $o++){//este es el final del for ?>
    <tr>
      <td bgcolor="#FFFFFF" class="textos"><?=$SelectAgentes[$o][agente]?>&nbsp;</td>
<? for($i=0 ; $i < count($SelectDATA) ; $i++){//este es el final del for 

$TotalCallsConAg = $sqlm->sql_select("queue_log","count(dcontext) as cuenta","agente = '".$SelectAgentes[$o][agente]."' AND evento = 'CONNECT' AND dcontext = '$_GET[cola]' AND DATE(fecha) = '".$SelectDATA[$i][fecha]."'",0);

?>
      <td bgcolor="#FFFFFF" class="textosHoras"><?=$TotalCallsConAg[$o][cuenta]?>&nbsp;</td>
      <td bgcolor="#FFFFFF" class="textosHoras"><?=number_format(($TotalCallsConAg[$o][cuenta]/$TotalCalls[0][cuenta])*100,1)?>&nbsp;</td>
<? } ?>
    </tr>
<? } //este es el final del for ?>
  </table>
</div>


<?

}

}
?>