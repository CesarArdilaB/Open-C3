<?
session_start();
include("../../../appcfg/general_config.php");

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();
 
 //recuperamos las variables por get
	$tablas 		= $_GET[qt];
	$clausulas 		= $_GET[qc];
	$fechacomp		= $_GET[qf];
	$datocomp		= $_GET[qd];
	$campocompara	= $_GET[compc];
	$valorcompara	= $_GET[qd];
	$fechageneral	= $_GET[qfy];
 //recuperamos las variables por get

switch($_GET[rid]){
	
	case "custodia1";
	
	if($qd==4){
		
	$labesARR 	= array("Campaña","Label","Cedula","Pseudocodigo","Fecha Recibido Fisico","Fecha Entrega","Estado","Bodega","Lote","Nombre del Cliente","Bolsa Seguridad Salida","Tipo de Tarjeta","Codigo Oficina","Direccion Oficina","Tipo Entrega","Gestion Call","Gestion Mesa","Activacion","Fecha de Activacion","Cupo","Feed Back","Mensajero","Id Registro");
	$camposARR	= array("af13_38","af13_51","af13_39","af13_41","af13_34","fechasalida","idestado","idbodega","af13_167","af13_40","af13_152","af13_253","af13_61","af13_47","af13_155","af13_109","af13_100","af13_126","af13_128","af13_42","feedback","idmensajero","autof_matrizprincipal_1_id");
	$camposQ	= "af13_38,af13_51,af13_39,af13_41,fechasalida,idestado,idbodega,af13_167,af13_40,af13_152,af13_253,af13_61,af13_47,af13_155,af13_109,af13_100,af13_126,af13_128,autof_matrizprincipal_1_id";
	$tablas		.= ",autof_matrizprincipal_1";
	$clausulasD	= "autof_matrizprincipal_1_id = inv_inventario.idregistro AND ".$clausulas;
	$campofecha	= "fechah";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id ORDER BY id_inventario";
		
		}
	else{
	$labesARR 	= array("Campaña","Label","Cedula","Pseudocodigo","Fecha Recibido Fisico","Fecha Entrega","Estado","Bodega","Lote","Nombre del Cliente","Bolsa Seguridad Salida","Tipo de Tarjeta","Codigo Oficina","Direccion Oficina","Tipo Entrega","Gestion Call","Gestion Mesa","Activacion","Fecha de Activacion","Cupo","Id Registro");
	$camposARR	= array("af13_38","af13_51","af13_39","af13_41","af13_34","fechasalida","idestado","idbodega","af13_167","af13_40","af13_152","af13_253","af13_61","af13_47","af13_155","af13_109","af13_100","af13_126","af13_109","af13_42","autof_matrizprincipal_1_id");
	$camposQ	= "af13_38,af13_51,af13_39,af13_41,fechasalida,idestado,idbodega,af13_167,af13_40,af13_152,af13_253,af13_61,af13_47,af13_155,af13_109,af13_100,af13_126,af13_128,af13_42,autof_matrizprincipal_1_id";
	$tablas		.= ",autof_matrizprincipal_1";
	$clausulasD	= "autof_matrizprincipal_1_id = idregistro AND ".$clausulas;
	$campofecha	= "fechah";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

	}
	
	
	break;
	
	case "custodia2";
	$labesARR 	= array("Campaña","Label","Cedula","Pseudocodigo","Fecha Entrega","Estado","Bodega","Lote","Nombre del Cliente","Bolsa Seguridad Salida","Tipo de Tarjeta","Gestion Call","Gestion Mesa","Activacion","Fecha de Activacion","Tipo Entrega","Cupo","Id Registro");
	$camposARR	= array("af13_38","af13_51","af13_39","af13_41","fechasalida","idestado","idbodega","af13_167","af13_40","af13_152","af13_253","af13_109","af13_100","af13_126","af13_128","af13_155","af13_42","autof_matrizprincipal_1_id");
	$camposQ	= "af13_38,af13_51,af13_39,af13_41,fechasalida,idestado,idbodega,af13_167,af13_40,af13_152,af13_253,af13_109,af13_100,af13_126,af13_128,af13_155,af13_42,autof_matrizprincipal_1_id";
	$tablas		.= "";
	$clausulasD	= "autof_matrizprincipal_1_id = idregistro AND ".$clausulas;
	$campofecha	= "fechah";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

	break;
	
	case "custodia3";
	$labesARR 	= array("Campaña","Label","Cedula","Pseudocodigo","Fecha Entrega","Estado","Bodega","Lote","Nombre del Cliente","Bolsa Seguridad Salida","Tipo de Tarjeta","Gestion Call","Gestion Mesa","Activacion","Fecha de Activacion","Tipo Entrega","Cupo","Feed Back","Mensajero","Id Registro");
	$camposARR	= array("af13_38","af13_51","af13_39","af13_41","fechasalida","idestado","idbodega","af13_167","af13_40","af13_152","af13_253","af13_109","af13_100","af13_126","af13_128","af13_155","af13_42","feedback","idmensajeroentrego","autof_matrizprincipal_1_id");
	$camposQ	= "af13_38,af13_51,af13_39,af13_41,fechasalida,idestado,idbodega,af13_167,af13_40,af13_152,af13_253,af13_109,af13_100,af13_126,af13_128,af13_155,af13_42,autof_matrizprincipal_1_id";
	$tablas		.= "";
	$clausulasD	= "autof_matrizprincipal_1_id = idregistro AND ".$clausulas;
	$campofecha	= "fechah";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

	break;
	
	case "mesa1";
	
	if($qd==4){
		
	$labesARR 	= array("Punto de venta","Asesor Punto","Campana Documentos","Nombre del Cliente","CEDULA","PSEUDOCODIGO","CAMPANA","TELEFONO","FECHA VENTA","LABEL","No. De Precinto","Proceso","Activacion","Fecha Activacion","Entrego","Fecha Entrega","Tipo de Tarjeta","Tipo Entrega","Feed Back","Mensajero","Id Registro");
	$camposARR	= array("af13_92","af13_90","af13_129","af13_40","af13_39","af13_41","af13_38","af13_43","af13_93","af13_51","af13_179","af13_97","af13_126","af13_128","af13_158","fechasalida","af13_253","af13_155","feedback","idmensajero","autof_matrizprincipal_1_id");
	$camposQ	= "af13_92,af13_90,af13_129,af13_40,af13_39,af13_41,af13_38,af13_43,af13_93,af13_51,af13_179,af13_97,af13_126,af13_128,af13_158,fechasalida,af13_253,af13_155,autof_matrizprincipal_1_id";
	$tablas		.= ",autof_matrizprincipal_1";
	$clausulasD	= "autof_matrizprincipal_1_id = inv_inventario.idregistro AND ".$clausulas;
	$campofecha	= "fechah";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

		
		}
	else{
	
	$labesARR 	= array("Punto de venta","Asesor Punto","Campana Documentos","Nombre del Cliente","CEDULA","PSEUDOCODIGO","CAMPANA","TELEFONO","FECHA VENTA","LABEL","No. De Precinto","Proceso","Activacion","Fecha Activacion","Entrego","Fecha Entrega","Tipo de Tarjeta","Tipo Entrega","Id Registro");
	$camposARR	= array("af13_92","af13_90","af13_129","af13_40","af13_39","af13_41","af13_38","af13_43","af13_93","af13_51","af13_179","af13_97","af13_126","af13_128","af13_158","fechasalida","af13_253","af13_155","autof_matrizprincipal_1_id");
	$camposQ	= "af13_92,af13_90,af13_129,af13_40,af13_39,af13_41,af13_38,af13_43,af13_93,af13_51,af13_179,af13_97,af13_126,af13_128,af13_158,fechasalida,af13_253,af13_155,autof_matrizprincipal_1_id";
	$tablas		.= ",autof_matrizprincipal_1";
	$clausulasD	= "autof_matrizprincipal_1_id = idregistro AND ".$clausulas;
	$campofecha	= "fechah";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

	
	}
	
	break;	
	
	case "mesa2";
	$labesARR 	= array("Punto de venta","Asesor Punto","Campana Documentos","Nombre del Cliente","CEDULA","PSEUDOCODIGO","CAMPANA","TELEFONO","FECHA VENTA","LABEL","No. De Precinto","Proceso","Activacion","Fecha Activacion","Entrego","Tipo de Tarjeta","Tipo Entrega","Id Registro");
	$camposARR	= array("af13_92","af13_90","af13_129","af13_40","af13_39","af13_41","af13_38","af13_43","af13_93","af13_51","af13_179","af13_97","af13_126","af13_128","af13_158","af13_253","af13_155","autof_matrizprincipal_1_id");
	$camposQ	= "af13_92,af13_90,af13_129,af13_40,af13_39,af13_41,af13_38,af13_43,af13_93,af13_51,af13_179,af13_97,af13_126,af13_128,af13_158,af13_253,af13_155,autof_matrizprincipal_1_id";
	$tablas		.= "";
	$clausulasD	= "".$clausulas;
	$campofecha	= "fechah";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

	break;
	
	
	case "mesa3";
	$labesARR 	= array("Punto de venta","Asesor Punto","Campana Documentos","Nombre del Cliente","CEDULA","PSEUDOCODIGO","CAMPANA","TELEFONO","FECHA VENTA","LABEL","No. De Precinto","Proceso","Activacion","Fecha Activacion","Entrego","Tipo de Tarjeta","Tipo Entrega","Id Registro");
	$camposARR	= array("af13_92","af13_90","af13_129","af13_40","af13_39","af13_41","af13_38","af13_43","af13_93","af13_51","af13_179","af13_97","af13_126","af13_128","af13_158","af13_253","af13_155","autof_matrizprincipal_1_id");
	$camposQ	= "af13_92,af13_90,af13_129,af13_40,af13_39,af13_41,af13_38,af13_43,af13_93,af13_51,af13_179,af13_97,af13_126,af13_128,af13_158,af13_253,af13_155,autof_matrizprincipal_1_id";
	$tablas		.= "";
	$clausulasD	= "".$clausulas;
	$campofecha	= "fechahora";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

	break;
	
	case "callcenter1";
	$labesARR 	= array("Cedula","Nombre del Cliente","Campaña","Telefono","Ciudad","Operador","Tipo de Tarjeta","Gestion Call","Gestion Mesa","Activacion","Fecha de Activacion","Fecha Agendamiento","Hora Agendamiento","Id Registro");
	$camposARR	= array("af13_39","af13_40","af13_38","af13_43","af13_67","name","af13_253","af13_109","af13_100","af13_126","af13_128","fechaA","horaA","autof_matrizprincipal_1_id");
	$camposQ	= "af13_39,af13_40,af13_38,af13_43,af13_67,name,af13_253,af13_109,af13_100,af13_126,af13_128,autof_matrizprincipal_1_id";
	$tablas		.= ",autof_matrizprincipal_1";
	$clausulasD	= "autof_matrizprincipal_1_id = id_reg AND ".$clausulas;
	$campofecha	= "fechahora";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

	break;	
	
	case "callcenter2";
	$labesARR 	= array("Cedula","Nombre del Cliente","Campaña","Telefono","Ciudad","Operador","Tipo de Tarjeta","Gestion Call","Gestion Mesa","Activacion","Fecha de Activacion","Fecha Agendamiento","Hora Agendamiento","Id Registro");
	$camposARR	= array("af13_39","af13_40","af13_38","af13_43","af13_67","name","af13_253","af13_109","af13_100","af13_126","af13_128","fechaA","horaA","autof_matrizprincipal_1_id");
	$camposQ	= "af13_39,af13_40,af13_38,af13_43,af13_67,name,af13_253,af13_109,af13_100,af13_126,af13_128,autof_matrizprincipal_1_id";
	$tablas		.= ",autof_matrizprincipal_1,agents";
	$clausulasD	= "autof_matrizprincipal_1_id = id_reg AND id_usuario = id_agents AND ".$clausulas;
	$campofecha	= "fechahora";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

	break;	

	case "callcenter3";
	$labesARR 	= array("Cedula","Nombre del Cliente","Campaña","Telefono","Ciudad","Operador","Tipo de Tarjeta","Gestion Call","Gestion Mesa","Activacion","Fecha de Activacion","Fecha Agendamiento","Hora Agendamiento","Id Registro");
	$camposARR	= array("af13_39","af13_40","af13_38","af13_43","af13_67","name","af13_253","af13_109","af13_100","af13_126","af13_128","fechaA","horaA","autof_matrizprincipal_1_id");
	$camposQ	= "af13_39,af13_40,af13_38,af13_43,af13_67,name,af13_253,af13_109,af13_100,af13_126,af13_128,autof_matrizprincipal_1_id";
	$tablas		.= ",agents";
	$clausulasD	= "autof_matrizprincipal_1_id = id_reg AND id_usuario = id_agents AND ".$clausulas;
	$campofecha	= "fechahora";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

	break;	
	
	case "courier1";
	$labesARR 	= array("Cedula","Nombre del Cliente","Campaña","Telefono","Ciudad","Operador","Id Registro","Tipo de Tarjeta","Gestion Call","Gestion Mesa","Activacion","Fecha de Activacion","Mensajero","FeedBack");
	$camposARR	= array("af13_39","af13_40","af13_38","af13_43","af13_67","operador","autof_matrizprincipal_1_id","af13_253","af13_109","af13_100","af13_126","af13_128","idmensajero","feedback");
	$camposQ	= "af13_39,af13_40,af13_38,af13_43,af13_67,autof_matrizprincipal_1_id,af13_253,af13_109,af13_100,af13_126,af13_128";
	$tablas		.= ",mensajeros";
	$clausulasD	= "autof_matrizprincipal_1_id = idregistro AND idmensajero = id_mensajero AND ".$clausulas;
	$campofecha	= "fecha";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

	break;	
	
	case "courier2";
	$labesARR 	= array("Cedula","Nombre del Cliente","Campaña","Telefono","Ciudad","Operador","Id Registro","Tipo de Tarjeta","Gestion Call","Gestion Mesa","Activacion","Fecha de Activacion","Mensajero","FeedBack");
	$camposARR	= array("af13_39","af13_40","af13_38","af13_43","af13_67","operador","autof_matrizprincipal_1_id","af13_253","af13_109","af13_100","af13_126","af13_128","idmensajero","feedback");
	$camposQ	= "af13_39,af13_40,af13_38,af13_43,af13_67,autof_matrizprincipal_1_id,af13_253,af13_109,af13_100,af13_126,af13_128";
	$tablas		.= "";
	$clausulasD	= "autof_matrizprincipal_1_id = idregistro AND idmensajero = id_mensajero AND ".$clausulas;
	$campofecha	= "fecha";
	$ClausulasADD = "GROUP BY autof_matrizprincipal_1_id";

	break;	
	
	case "espdaniel";
	$labesARR 	= array("Pseudocódigo ","Cupo ","Punto de venta","Asesor punto","Cedula asesor pto","Asesor beta","Cedula asesor beta","Campana documentos","Fecha venta","Fecha de envio","No. Guía mesa","Proceso","Gestion mesa","Fecha de radicación","Fecha de devolución","Observaciones mesa","No. De precinto");
	$camposARR	= array("af13_41","af13_42","af13_92","af13_90","af13_91","af13_558","af13_559","af13_129","af13_93","af13_94","af13_95","af13_97","af13_100","af13_210","af13_211","af13_99","af13_179");
	$camposQ	= "af13_41,af13_42,af13_92,af13_90,af13_91,af13_558,af13_559,af13_129,af13_93,af13_94,af13_95,af13_97,af13_100,af13_210,af13_211,af13_99,af13_179";
	$tablas		.= "";
	$clausulasD	= "autof_matrizprincipal_1_id = id_reg AND ".$clausulas;
	$campofecha	= "fechahora";
	$ClausulasADD = "GROUP BY id_reg";

	break;	
	
	}

$consulta = $sqlm->sql_select($tablas,$camposQ,$clausulasD." = ".$fechacomp." AND  YEAR($campofecha) = YEAR('".$fechageneral."') $ClausulasADD",0);

?>
<link rel="stylesheet" type="text/css" href="../../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../../css/style.css"/>

<div align="center" style="overflow:scroll; height:100%">
<? excelexp("TablaData"); ?>
  <table width="0" border="0" cellspacing="0" cellpadding="0" id="TablaData" class="rounded-corners-blue">
    <tr>
      <td align="center" colspan="<?=count($camposARR)?>" class="textos_titulos">
      <div align="center">Registros: <?=count($consulta)?></div>
      </td>
    </tr>
    <tr>
  <? for($i = 0 ;$i < count($labesARR) ; $i++) { 
  
  /*esto es para los campos meterles los parametros propios*/
  
  
  
  ?>
      <td align="center" class="textos_titulos"><?=$labesARR[$i]?>&nbsp;</td>
  <? } ?> 
    </tr>
  <? for($i = 0 ;$i < count($consulta) ; $i++) { ?>
    <tr>
  <? for($o = 0 ;$o < count($camposARR) ; $o++) { 
 
	/*aqui cuadramos los campos pesonalizados de cada reporte*/
  
  if($camposARR[$o] == "idestado")	{$parametro = "inv_estado,id_estado,estado,id_estado,1"; $tipoc = "select"; $C=1;}
  
  elseif($camposARR[$o] == "idbodega"){ $parametro = "inv_bodegas,id_bodegas,nombre,id_bodegas,1"; $tipoc = "select"; $C=1;}
  
  elseif($camposARR[$o] == "idmensajero")	{ 
  
  
  		$MensajeroV = $sqlm->sql_select("agenda,mensajeros","name","idregistro = '".$consulta[$i][autof_matrizprincipal_1_id]."' AND  idmensajero = id_mensajero",0);
  		if(is_array($MensajeroV)){$TextoPrint = $MensajeroV[0][name];}else{$TextoPrint = "";}
		$C=2;
		
											}
											
  elseif($camposARR[$o] == "idmensajeroentrego")	{ 
  
  
  		$MensajeroV = $sqlm->sql_select("agenda,mensajeros","name","idregistro = '".$consulta[$i][autof_matrizprincipal_1_id]."' AND  idmensajero_entrego = id_mensajero",0);
  		if(is_array($MensajeroV)){$TextoPrint = $MensajeroV[0][name];}else{$TextoPrint = "";}
		$C=2;
		
											}
											
											
  elseif($camposARR[$o] == "feedback")		{ 
  
    	$AEstadoV = $sqlm->sql_select("agenda,agenda_estados","estado","idregistro = '".$consulta[$i][autof_matrizprincipal_1_id]."' AND  id_estado = feedback ORDER BY fecha DESC LIMIT 1",0);
  		if(is_array($AEstadoV)){$TextoPrint = $AEstadoV[0][estado];}else{$TextoPrint = "";}
		$C=2;
  
										   	}

  elseif($camposARR[$o] == "operador")		{ 
  
		$OperadorDATA = $sqlm->sql_select("agents,history_1","name","id_reg = '".$consulta[$i][autof_matrizprincipal_1_id]."' AND id_agents = id_usuario AND tipo = 0 ORDER BY id_history_1 DESC LIMIT 0,1",0);
  		if(is_array($OperadorDATA)){$TextoPrint = $OperadorDATA[0][name];}else{$TextoPrint = "";}
		$C=2;
  
										   	}

  elseif($camposARR[$o] == "fechaA")		{ 
  
    	$AFechaV = $sqlm->sql_select("agenda","fecha","idregistro = '".$consulta[$i][autof_matrizprincipal_1_id]."' ORDER BY id_agenda DESC",0);
  		if(is_array($AFechaV)){$TextoPrint = $AFechaV[0][fecha];}else{$TextoPrint = "";}
		$C=2;
  
										   	}

  elseif($camposARR[$o] == "horaA")		{ 
  
    	$AHoraV = $sqlm->sql_select("agenda","hora","idregistro = '".$consulta[$i][autof_matrizprincipal_1_id]."' ORDER BY id_agenda DESC",0);
  		if(is_array($AHoraV)){$TextoPrint = $AHoraV[0][hora];}else{$TextoPrint = "";}
		$C=2;
  
										   	}
	/*aqui cuadramos los campos pesonalizados de cada reporte*/
    
  else	{

	$CampoConfig =   $sqlm->sql_select("autoform_config","*","nombrecampo = '".$camposARR[$o]."'",0);	  


	if(is_array($CampoConfig)){ 
  	$parametro = $CampoConfig[0][paramcampo]; $tipoc = $CampoConfig[0][tipocampo]; ; $C=1;
  	}	else	{ $C=0;}


  }
  
  
  ?>
<td align="center" valign="middle" bgcolor="#FFFFFF" class="textos">
<? 	


	if		($C == 1){
	
	echo $formulario_auto->armar_campo($tipoc,"valhis","",$consulta[$i][$camposARR[$o]],0,1,0,$parametro);
				 }
	elseif	($C == 2){echo $TextoPrint;}
	
	else{
	
 	echo utf8_encode($consulta[$i][$camposARR[$o]]);
	
	} 
	
	
	?>&nbsp;
</td>
  <? } ?> 
    </tr>
  <? } ?> 
  </table>
</div>
