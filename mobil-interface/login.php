<?
include '../appcfg/cc.php';
include '../appcfg/class_sqlman.php';

$sqlm = new Man_Mysql;

	if($_POST[usuario] != "" and $_POST[clave] != ""){

	$Login = $sqlm->sql_select("mensajeros","name,id_mensajero as idm","user = '$_POST[usuario]' AND password = '$_POST[clave]' ",0);

	if(is_array($Login)){
	
	$actualizar = mysql_query("UPDATE mensajeros SET mobilin = '".$_GET[uuid]."' WHERE id_mensajero = '".$Login[0][idm]."'");
	
	}else{
		
		echo "00";
		
		}
	
	
	} //este verifica si hay usuario para mostrar el form de logueo
		
?>