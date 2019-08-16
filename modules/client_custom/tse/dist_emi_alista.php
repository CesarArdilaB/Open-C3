<?
session_start();

require '../../../appcfg/general_config.php';

//date_default_timezone_set('America/Bogota');


$Date = strtotime(date('Y-m-15'));
$dt_elMesPasado = date('Y-m-1',strtotime('-7 month',$Date)) ; 

echo $dt_elMesPasado." -- Modificado";

mysql_query("DELETE FROM autof_matrizprincipal_1 WHERE af13_34 <  '$dt_elMesPasado'");
mysql_query("DELETE FROM history_1 WHERE DATE(fechahora) <  '$dt_elMesPasado'");
mysql_query("DELETE FROM history_1 WHERE  accion !=  'Registro Modificado' AND accion !=  'Agendamiento Masivo'");
mysql_query("DELETE FROM inv_inventario WHERE DATE(`fechasalida`) <  '$dt_elMesPasado' AND  `fechaentrega` <  '$dt_elMesPasado' AND DATE(`fechasalida`) != '0000-00-00' AND fechaentrega != '0000-00-00'");


//AND accion !=  'Registro Actualizado'  por si acaso se requiere este

?> 