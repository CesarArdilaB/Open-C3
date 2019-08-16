<?
/*esta clase sera utilizada para taer datos de configuracion y generales de las campañas asi como los valores de los campos de los formularios dinamicos

Aqui los cambios que tiene en cada actualizacion:

*/

class Campana {
	
	var $RutaRaizINC;
	var $RutaHTTP;
	var $RutaRaiz;


	//esta es la funcion que regresa todos los datos de la camaña en un arreglo
	function campana_config($idcampana){
		
	$camdata = Man_Mysql::sql_select("autoform_tablas,campaigns","*","id_campaign = '$idcampana' AND id_campaign = campaignid AND tipotabla = 1",0);

	return array(
	
	"tablaP" => $camdata[0][nombretabla],
	"labelC" => $camdata[0][labeltabla],
	"identT" => "ident_".$idcampana,
	"campoID" => $camdata[0][campoid],
	"descripcion" => $camdata[0][descripcion],
	"idForm" => $camdata[0][id_autoformtablas],
	"campoID" => $camdata[0][campoid],
	"nombreCam" => $camdata[0][campaign_name]
		
				);

	}

	//trae el proyecto y el cliente de la campana, pronto otros datos de ese tipo.
	
	function campana_parents($idcampana){
		
	$camdata = Man_Mysql::sql_select("clients,projects,campaigns","*","id_campaign = '$idcampana' AND idproject = id_project AND idclient = id_client",0);


	if(is_array($camdata)){

	return array(
	
	"clienteN" 	=> $camdata[0][client_name],
	"proyectoN"	=> $camdata[0][project_name]
		
				);
	}else{ return array("clienteN" => "","proyectoN" => ""); }
	
	
	
	}//--------------------
	
			
		


	function contador_update($idcampana,$idregistro){
	
$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");

		
	
	$CamCFG = Campana::campana_config($idcampana);
	
$ContadorCFG = Man_Mysql::sql_select("contador_config","numero_tipicaciones,numero_estados","idcampana = '$idcampana'",0);

	if(is_array($ContadorCFG)){//verificamos que la campana si tenga configuracion de contador
		
	$CuentaTipiFicaciones = Man_Mysql::sql_select("history_".$idcampana,"count(id_reg) as CUENTA","id_reg = '$idregistro'",0);
	
	$CuentaCourierEstados = Man_Mysql::sql_select("agenda","count(idregistro) as CUENTA","idregistro = '$idregistro' AND idcampana = '$idcampana'",0);
	
		if(is_array($CuentaCourierEstados)){
		
if($CuentaTipiFicaciones[0][CUENTA] >= $ContadorCFG[0][numero_tipicaciones] and $CuentaCourierEstados[0][CUENTA] >= $ContadorCFG[0][numero_estados])
					{ //si la condicion se cumple
	
	$AgCfg = Man_Mysql::sql_select("agenda_camconfig","gestioncallc","idcampana = $idcampana",0);
$Tipi = Man_Mysql::sql_select("autof_".$AgCfg[0][gestioncallc],"id_".$AgCfg[0][gestioncallc]." as tipid","field2 = 'contador'",0);

	Man_Mysql::update_regs($CamCFG[tablaP],$AgCfg[0][gestioncallc]." = ".$Tipi[0][tipid],$CamCFG[tablaP]."_id"." = ".$idregistro,0);
	
	$Campos .= "his_".$AgCfg[0][gestioncallc].",fechahora,accion,id_reg,id_usuario";								
	$Valores .= "'".$Tipi[0][tipid]."','$fecha_act $hora_act','Accion Automatica del sistema','$idregistro',1";								

											
	Man_Mysql::inser_data("history_".$idcampana,$Campos,$Valores,0);

	
					} //si la condicion se cumple
			
		}
	

	}


		
		} 	//aqui la funcion que nos trabaja el contador de los registros
//funcion del contador termina aqui
		
	
	//funcion para desactivar registros
	
	function desactiva_reg($idcampana,$idregistro){
	
$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");

		
	$CamCFG = Campana::campana_config($idcampana);

		
	Man_Mysql::update_regs("ident_".$idcampana,"estado = 4","id_ident_".$idcampana." = ".$idregistro,0);
	
	$AgCfg = Man_Mysql::sql_select("agenda_camconfig","gestioncallc","idcampana = $idcampana",0);

	$Tipi = Man_Mysql::sql_select("autof_".$AgCfg[0][gestioncallc],"id_".$AgCfg[0][gestioncallc]." as tipid","field2 = 'end'",0);

	Man_Mysql::update_regs($CamCFG[tablaP],$AgCfg[0][gestioncallc]." = ".$Tipi[0][tipid],$CamCFG[tablaP]."_id"." = ".$idregistro,0);
	
	$Campos .= "his_".$AgCfg[0][gestioncallc].",fechahora,accion,id_reg,id_usuario";								
	$Valores .= "'".$Tipi[0][tipid]."','$fecha_act $hora_act','Accion Automatica del sistema','$idregistro',1";								

											
	Man_Mysql::inser_data("history_".$idcampana,$Campos,$Valores,0);

		
		}

	//funcion para desactivar registros

}//termina la classe

	
?>