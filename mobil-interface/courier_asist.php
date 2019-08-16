<?
include '../appcfg/cc.php';
			
$actualizar = "UPDATE mensajeros SET asistencia = 1 WHERE mobilin = '$_GET[uuid]'";

echo " OK ";

mysql_query($actualizar);

?>