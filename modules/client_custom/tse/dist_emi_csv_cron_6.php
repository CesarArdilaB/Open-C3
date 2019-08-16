<?
session_start();

require '../../../appcfg/general_config.php';

//date_default_timezone_set('America/Bogota');

mail("cac@tse.com.co,andres.ardila@parasuempresa.com","Emision 6 Generadose","Empeso a generarse emision del mes 6"); 


$Date = strtotime(date('Y-m-15'));
$dt_elMesPasado = date('Y-m-',strtotime('-2 month',$Date)) ; // resta 1 mes

//echo $dt_elMesPasado;

//exit;


$SelectDATA = $sqlm->sql_select("autof_matrizprincipal_1","*","DATE(af13_34) BETWEEN '".$dt_elMesPasado."1"."' AND '".$dt_elMesPasado."31"."' ORDER BY autof_matrizprincipal_1_id ASC",0);

//echo "\r".$SelectDATA."\r";

if(is_array($SelectDATA)){

$htm .= "Mes Fisico|Fecha Fisico TSE|Campaña|Estado Custodia|Identificacion Cliente|SEUDOCODIGO|Nombre Cliente|Activacion|Fecha de Activacion|Fecha de Entrega Envio|Fecha de Entrega|DATOS TERCERO AUTORIZADO|Tipo de Entrega|Nombre Asesor Call Center|Gestion Realizada Call|Fecha de Gestion Call Center|Ciudad Base|Cupo|Nombre Base|Bodega|Gestion Mesa|Punto de Venta|Fecha Entrega|Feedback manifiesto|FECHA BANCO BASE AGENDAMIENTO|FECHA RECEPCION BASE TSE|Tipo de entrega inicial|# Bolsa seguridad de salida|Código de dirección|Direccion Cita|TIPO DE EMISION|Fecha Modificacion Agendamiento|Fecha Agendamiento|Mensajero|Agente que Agendo|# de Visita|Antepenultimo Feedback manifiesto|Id Registro \r";

echo $htm;

for($i=0;$i < count($SelectDATA);$i++){ 


$CustodiuaDATA = $sqlm->sql_select("inv_inventario,inv_estado","estado,fechasalida,fechaentrega,idbodega","idregistro ='".$SelectDATA[$i][autof_matrizprincipal_1_id]."' AND idestado = id_estado AND idcampana = 1",0);

if(is_array($CustodiuaDATA)){
$BodegaNombre = $sqlm->sql_select("inv_bodegas","nombre","id_bodegas ='".$CustodiuaDATA[0][idbodega]."'",0);
}

if(is_array($BodegaNombre)){$BodegaTxt = $BodegaNombre[0][nombre];}else{$BodegaTxt = "";}

$campanaDATA= $sqlm->sql_select("autof_af13_38","field1","id_af13_38 ='".$SelectDATA[$i][af13_38]."'",0);
if(is_array($campanaDATA)){	$campanaTEXT = $campanaDATA[0][field1];	}else{ $campanaTEXT = ""; }

$activacionDATA = $sqlm->sql_select("autof_af13_126","field1","id_af13_126 ='".$SelectDATA[$i][af13_126]."'",0);
if(is_array($activacionDATA)){$actData = $activacionDATA[0][field1];	}else{ $actData = ""; }

$tipoentDATA = $sqlm->sql_select("autof_af13_155","field1","id_af13_155 ='".$SelectDATA[$i][af13_155]."'",0);
if(is_array($tipoentDATA)){$entData = $tipoentDATA[0][field1];	}else{ $entData = ""; }

$gescallDATA = $sqlm->sql_select("autof_af13_109","field1","id_af13_109 ='".$SelectDATA[$i][af13_109]."'",0);
if(is_array($gescallDATA)){$gescallText = $gescallDATA[0][field1];	}else{ $gescallText = ""; }


$gmesaDATA = $sqlm->sql_select("autof_af13_100","field1","id_af13_100 ='".$SelectDATA[$i][af13_100]."'",0);
if(is_array($gmesaDATA)){$gmesaText = $gmesaDATA[0][field1];	}else{ $gmesaText = ""; }


$pventaDATA = $sqlm->sql_select("autof_af13_92","field1","id_af13_92 ='".$SelectDATA[$i][af13_92]."'",0);
if(is_array($pventaDATA)){$pventaText = $pventaDATA[0][field1];	}else{ $pventaText = ""; }

$CiudadData = $sqlm->sql_select("autof_af13_67","field1","id_af13_67 ='".$SelectDATA[$i][af13_67]."'",0);
if(is_array($CiudadData)){$CiudadBText = $CiudadData[0][field1];	}else{ $CiudadBText = ""; }


if(is_array($CustodiuaDATA)){
	
	$estadoINV = $CustodiuaDATA[0][estado]; 
	$fechaSalidaINV = $CustodiuaDATA[0][fechasalida]; 
	$fechaEntregaINV = $CustodiuaDATA[0][fechaentrega]; 
	
	}else {
		
	$estadoINV = "";
	$fechaSalidaINV = ""; 
	
	} 

$OperadorDATA = $sqlm->sql_select("agents,history_1","name","id_reg = '".$SelectDATA[$i][autof_matrizprincipal_1_id]."' AND id_agents = id_usuario AND tipo = 0 ORDER BY id_history_1 DESC LIMIT 0,1",0);


if(is_array($OperadorDATA)){$operadorText = $OperadorDATA[0][name];}else{ $operadorText = ""; }


//nuevos campos de soporte adicionados el 13 de diciembre

$AgendaFeed = $sqlm->sql_select("agenda","feedback,DATE(fechahoraag)as fechaag,fecha,idmensajero,idagente","idregistro = '".$SelectDATA[$i][autof_matrizprincipal_1_id]."' ORDER BY id_agenda DESC",0);

if(is_array($AgendaFeed)){

$OperadorAGDATA = $sqlm->sql_select("agents","name","id_agents = '".$AgendaFeed[0][idagente]."'",0);
if(is_array($OperadorAGDATA)){ $OperadorAGDATAT = $OperadorAGDATA[0][name]; }



$MensajeroDATA = $sqlm->sql_select("mensajeros","name","id_mensajero = '".$AgendaFeed[0][idmensajero]."'",0);
if(is_array($MensajeroDATA)){ $MensajeroDATAT = $MensajeroDATA[0][name]; }


$AgendaFeedDATA = $sqlm->sql_select("agenda_estados","estado","id_estado = '".$AgendaFeed[0][feedback]."'",0);
$fechaAG = $AgendaFeed[0][fechaag];
$fechaN = $AgendaFeed[0][fecha];


if(is_array($AgendaFeedDATA)){ $FeedBACKT = $AgendaFeedDATA[0][estado]; }else{ $FeedBACKT = ""; }


$AgendaFeedDATAP = $sqlm->sql_select("agenda_estados","estado","id_estado = '".$AgendaFeed[1][feedback]."'",0);
if(is_array($AgendaFeedDATAP)){ $FeedBACKPT = $AgendaFeedDATAP[0][estado]; }else{ $FeedBACKPT = ""; }	
	
}else{ 

$FeedBACKT = "";
$FeedBACKPT = "";
$fechaAG = "";
$fechaN = "";
$MensajeroDATAT = "";
$OperadorAGDATAT = "";

}

	
//*****

$tentregadataDATA = $sqlm->sql_select("autof_af13_795","field1","id_af13_795 ='".$SelectDATA[$i][af13_795]."'",0);
if(is_array($tentregadataDATA)){$tentregaText = $tentregadataDATA[0][field1];	}else{ $tentregaText = ""; }



$dircodDATA = $sqlm->sql_select("autof_af13_796","field1","id_af13_796 ='".$SelectDATA[$i][af13_796]."'",0);
if(is_array($dircodDATA)){$coddirText = $dircodDATA[0][field1];	}else{ $coddirText = ""; }


	$sustituye = array("\r\n", "\n\r", "\n", "\r");
	$preindicacion = str_replace($sustituye," - ",$SelectDATA[$i][af13_794]);
	$Indicacion	= utf8_decode($preindicacion);


//-----------------------------------------------
	
$ContadorData = $sqlm->sql_select("agenda","COUNT(idregistro) AS cuenta","idregistro ='".$SelectDATA[$i][autof_matrizprincipal_1_id]."'",0);

$contador =  $ContadorData[0][cuenta];

//-----------------------------------------------



$htm .= $SelectDATA[$i][af13_33]."|".$SelectDATA[$i][af13_34]."|".$campanaTEXT."|".$estadoINV."|".$SelectDATA[$i][af13_39]."|".$SelectDATA[$i][af13_41]."|".$SelectDATA[$i][af13_40]."|".$actData."|".$SelectDATA[$i][af13_128]."|".$fechaSalidaINV."|".$fechaEntregaINV."|".$Indicacion."|".$entData."|".$operadorText."|".$gescallText."|".substr($SelectDATA[$i][af13_34],0,10)."|".$CiudadBText."|".$SelectDATA[$i][af13_42]."|".$SelectDATA[$i][af13_171]."|".$BodegaTxt."|".$gmesaText."|".$pventaText."|".$SelectDATA[$i][af13_93]."|".$FeedBACKT."|".$SelectDATA[$i][af13_35]."|".$SelectDATA[$i][af13_36]."|".$tentregaText."|".$SelectDATA[$i][af13_152]."|".$coddirText."|".$SelectDATA[$i][af13_145]."|".$SelectDATA[$i][af13_52]."|$fechaAG|$fechaN|$MensajeroDATAT|$OperadorAGDATAT|".$contador."|".$FeedBACKPT."|".$SelectDATA[$i][autof_matrizprincipal_1_id]."\r";

 } 
 
 
}//aqui si hay resultados

else{ 


$htm .= "No hay registros";


	}



$unirfecha= str_ireplace("-","",date('Y-m-d'));

$new_report=fopen("../../../tmp/emision_distribucion_autogenerado_dia_p6.csv","w");
 
fwrite($new_report, $htm);
 
fclose($new_report);

mail("cac@tse.com.co,andres.ardila@parasuempresa.com","Emision 6 Generadose","Termino de generarse emision del mes 6"); 

 
?> 