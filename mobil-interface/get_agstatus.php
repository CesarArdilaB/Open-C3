<?
include '../appcfg/cc.php';
include '../appcfg/class_sqlman.php';

$sqlm = new Man_Mysql;

	$IsLoged = $sqlm->sql_select("mensajeros","name,id_mensajero as idm","mobilin = '".$_GET[uuid]."'",0);
	if(is_array($IsLoged)){
		
		//aqui si esta logueado le muestra los registros
		
	$AgendaData = $sqlm->sql_select(
	"agenda_estados",
	"estado,id_estado",
	"inactivo = 0",0);


	if(is_array($AgendaData)){//si ahy resultados

	for($i=0 ; $i < count($AgendaData) ; $i++){//este es el final del for
	
$ArrResult[] = array	(
				"estado" => $AgendaData[$i][estado],
				"id_estado" => $AgendaData[$i][id_estado],
						);	

	
	} //este es el final del for
	
	echo json_encode($ArrResult);
	
	}
			
	}

?>