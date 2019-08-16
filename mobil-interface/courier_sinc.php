<?
include '../appcfg/cc.php';
include '../appcfg/class_sqlman.php';
$sqlm = new Man_Mysql();

date_default_timezone_set('America/Bogota');
$hora_act=date("H:i:s");

//print_r($_POST[datasinc]);
//echo " <br>";

$ArreglO = $_POST[datasinc];

for($i = 0 ; $i < count($ArreglO) ; $i++){
	
	$Dataf = explode("|",$ArreglO[$i]);
	
	$TipoAgenda = $sqlm->sql_select("agenda","tipoag,numeroref","id_agenda = '$Dataf[4]'",0);

	if(is_array($TipoAgenda)){
		
	if($TipoAgenda[0][tipoag] == 1){

	$Consulta = "UPDATE agenda SET 
	feedback 			= '$Dataf[0]' , 
	geotag				= '$Dataf[1]' , 
	idmensajero 		= '$Dataf[2]' , 
	idmensajero_entrego = '$Dataf[2]' , 
	feddbackcoments 	= '$Dataf[3]' ,
	horaup				= '$hora_act' ,
	aut					= '$Dataf[5]'
	WHERE id_agenda 	= '$Dataf[4]' ";
	
		
	}elseif($TipoAgenda[0][tipoag] == 2){
	
	$Consulta = "UPDATE agenda SET 
	feedback 			= '$Dataf[0]' , 
	geotag				= '$Dataf[1]' , 
	idmensajero 		= '$Dataf[2]' , 
	idmensajero_entrego = '$Dataf[2]' , 
	feddbackcoments 	= '$Dataf[3]' ,
	horaup				= '$hora_act' ,
	aut					= '$Dataf[5]'
	WHERE numeroref 	= '".$TipoAgenda[0][numeroref]."' ";

		
	}elseif($TipoAgenda[0][tipoag] == 3){
		
	$Consulta = "UPDATE agenda SET 
	feedback 			= '$Dataf[0]' , 
	geotag				= '$Dataf[1]' , 
	idmensajero 		= '$Dataf[2]' , 
	idmensajero_entrego = '$Dataf[2]' , 
	feddbackcoments 	= '$Dataf[3]' ,
	horaup				= '$hora_act' ,
	aut					= '$Dataf[5]'
	WHERE id_agenda 	= '$Dataf[4]' ";

	
	}	
		
	}
		
	mysql_query($Consulta);
	}
	
	//echo $Consulta;
	
?>