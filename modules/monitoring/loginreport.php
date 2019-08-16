<?
session_start();
if($op != 1 and $op != 2 and $op != 3 and $op != 4 and $op != 5 and $op != 6 and $op != 7){

?>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center">
  <h3>Reporte de Logueo</h3>
</div>

<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onsubmit="EnviarLinkForm('LogReport','<?=$RAIZHTTP?>/modules/monitoring/loginreport.php?op=1',this);return false;">
  
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

require '../../appcfg/class_asterisk.php';
$astm = new ast_man();

mysql_select_db("call_center");
$AgentesLista = $sqlm->sql_select("audit,agent","id_agent,(datetime_init) as Hora_inicio,(datetime_end) as Hora_final,DATE(datetime_init) as Fecha,duration","estatus = 'A' AND agent.id = id_agent AND DATE(datetime_init) BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' AND id_agent != '' GROUP BY id_agent ORDER BY datetime_init ASC",0);

?>

<table width="0" border="0" align="center" cellpadding="0" cellspacing="3" class="rounded-corners-blue">
  <tr>
    <td class="textos_titulos">Nombre Asesor</td>
    <td class="textos_titulos">Loguin Asesor</td>
    <td class="textos_titulos" align="center">Fecha</td>
    <td class="textos_titulos" align="center">Inicio Conexion</td>
    <td class="textos_titulos" align="center">Fin Conexion</td>
    <td class="textos_titulos">Tiempo Conexion</td>
    <td class="textos_titulos">Tiempo ACD</td>
    <td class="textos_titulos">Tiempo Break</td>
    <td class="textos_titulos">Tiempo Disp</td>
    <td class="textos_titulos">Llamadas ACD</td>
  </tr>
<? for($i = 0 ;$i < count($AgentesLista) ; $i++) { 

$finconexion=$reporte->traer_finconexion_callmodule($AgentesLista[$i][id_agent],$fecha_fin);
$idagente=$AgentesLista[$i][id_agent];
$tiempoconexion=$reporte->calcular_segundos_conexion_callmodule($idagente,$AgentesLista[$i][Hora_inicio],$finconexion);
$exten=$reporte->traer_exten_asesor_callmodule($idagente);
$tiempoACD=$reporte->traer_acd_hold_segundos_callmodule($idagente,$AgentesLista[$i][Fecha],$finconexion,"duration",$exten);
$breack=$reporte->traer_breaks_callmodule($idagente,$AgentesLista[$i][Fecha],$finconexion);
$TiempoDisp=$tiempoconexion-$tiempoACD-$breack;
?>
  <tr>
    <td bgcolor="#FFFFFF" class="textos"><?=$reporte->traer_nombre_asesor_callmodule($idagente)?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$reporte->traer_datos_asesor_callmodule($idagente,"number")?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos"><?=$AgentesLista[$i][Fecha]?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos"><?=$AgentesLista[$i][Hora_inicio]?>&nbsp;</td>
    <td bgcolor="#FFFFFF" class="textos"><?=$finconexion?>&nbsp;</td>
    <td bgcolor="#FFFFFF" align="center" class="textos"><?=$reporte->tiempo_segundos($tiempoconexion)?>&nbsp;</td>
    <td bgcolor="#FFFFFF" align="center" class="textos"><?=$reporte->tiempo_segundos($tiempoACD)?>&nbsp;</td>
    <td bgcolor="#FFFFFF" align="center" class="textos"><?=$reporte->tiempo_segundos($breack)?>&nbsp;</td>
    <td bgcolor="#FFFFFF" align="center" class="textos"><?=$reporte->tiempo_segundos($TiempoDisp)?>&nbsp;</td>
    <td bgcolor="#FFFFFF" align="center" class="textos"><?=$reporte->traer_acd_llamadas_callmodule($idagente,$AgentesLista[$i][Fecha],$finconexion,$exten)?>&nbsp;</td>
  </tr>
<? } ?> 
</table>




<? 

//echo $astm->trae_agentes();

} // aqui termina la opcion 1?>
