<?
include '../appcfg/cc.php';
include '../appcfg/class_sqlman.php';

$sqlm = new Man_Mysql;

//print_r($_GET);

	if($_GET[uuid] != ""){

	$actualizar = mysql_query("UPDATE mensajeros SET mobilin = '' WHERE mobilin = '".$_GET[uuid]."'");
	
	echo "Sesion Terminada Gracias.";
			
		}

	
?>