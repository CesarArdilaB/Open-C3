<?
error_reporting(E_ERROR | E_PARSE | E_COMPILE);


$dbh=mysql_connect ("localhost", "root", "admusr") or die ('No se ha realizado conexión a la database: ' . mysql_error());
mysql_select_db ("octres");

date_default_timezone_set("America/Bogota");

$DominioAPP 	= "http://192.168.0.241";
$IpInterna	= "http://192.168.0.241";
$DirectorioAPP 	= "openc3";

ini_set('memory_limit', '2048M');
ini_set('max_execution_time', 300);
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '1024M');
 
?>