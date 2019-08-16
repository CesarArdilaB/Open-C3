<?
error_reporting(E_ERROR | E_PARSE | E_COMPILE);


$dbh=mysql_connect ("localhost", "root", "adm52048070usr00abt") or die ('No se ha realizado conexión a la database: ' . mysql_error());
mysql_select_db ("octres");


$DominioAPP 	= "https://181.48.21.123";
$IpInterna	= "https://181.48.21.123";
$DirectorioAPP 	= "openc3";
?>