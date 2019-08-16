<?
include '../appcfg/cc.php';
include '../appcfg/class_sqlman.php';

$sqlm = new Man_Mysql;

	if($_POST[feedback] != "" ){


$actualizar = "UPDATE agenda SET 

				feedback 			= '$_POST[feedback]' ,
				feddbackcoments 	= '$_POST[feddbackcoments]',
				idmensajero 		= '$_POST[idmensajero]',
				idmensajero_entrego = '$_POST[idmensajero_entrego]',
				idregistro 			= '$_POST[idregistro]',
				geotag 				= '$_POST[geotag]',
			
			   WHERE id_agenda = '$_POST[idag]' ";
			
		//echo $actualizar;			
			   
		//mysql_query($actualizar); 
		
	
	//aqui ponemos la data de la agenda de nuevo
	
		$IsLoged = $sqlm->sql_select("mensajeros","name,id_mensajero as idm","mobilin = '".$_GET[uuid]."'",0);
	if(is_array($IsLoged)){
		
		//aqui si esta logueado le muestra los registros
		
	$AgendaData = $sqlm->sql_select(
	"agenda,autof_matrizprincipal_1",
	"af13_40 as nombre, af13_46 as direccion,autof_matrizprincipal_1_id as idreg,id_agenda as idag",
	"idmensajero = '".$IsLoged[0][idm]."' AND idregistro = autof_matrizprincipal_1_id AND fecha = '2012-11-21'",0);


	if(is_array($AgendaData)){//si ahy resultados

	?>
	
    <style>
	
	.Cassillas{
		
		background:#33C;
		color:#FFF; 
		margin-bottom:10px;
		border-radius:10px;
		padding:10px;

		}
		
	.Mensaje{
		
		background:#3CF;
		color:#333; 
		margin-bottom:10px;
		border-radius:10px;
		text-align:center
		
		}
	
	</style>
    <div class="Mensaje"> Registro Guardado </div>
	<?

	for($i=0 ; $i < count($AgendaData) ; $i++){//este es el final del for
	
	?>
    <div class="Cassillas" onclick="GetForm(<?=$AgendaData[$i][idreg]?>,<?=$AgendaData[$i][idag]?>)">Cliente: <?=$AgendaData[$i][nombre]?> | Direccion: <?=$AgendaData[$i][direccion]?></div>
	<?
	
	} //este es el final del for
	
	}//si ahy resultados
	else {
		
	echo "<div align='center'> No tiene citas asignadas. </div>";	
		
		}
	
	}//aqui terminamos de poneer la data
	
	
	
							}
	?>