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


$LabelsGenerales = array("Operador","NUMERO IDENTIFICACION CLIENTE","NOMBRE CLIENTE","PRIMER APELLIDO","SEGUNDO APELLIDO","SEXO","YA LA TENIA","DIR CORRESPONDENCIA","TEL CORRESPONDENCIA","CIUDAD","DEPARTAMENTO","DIR RESIDENCIA","TEL RESIDENCIA","CIUDAD","DEPTO","DIRECCION OFICINA","TEL OFICINA","ciudad","depto","CELULAR","E-MAIL","FECHA VENTA openc3","LINEA TC","BASE","CAMPAÑA","CEDULA Referido","nombre ref","APELLIDO ref","DIR CORESPONDENCIA ref","TELEFONO ref","MAIL ref","CIUDAD ref","DEPTO ref","PRODUCTO ref","TARJETA O CTA PRA EL DEBITO ref","Total Ventas","OBSERVACIONES","PROCESO","CAUSAL","OBERVACIONES CALIDAD");
$CamposGenerales = array("operador","af44_180","af44_197","af44_184","af44_185","af44_218","af44_567","af44_186","af44_187","af44_188","af44_189","af44_190","af44_191","af44_617","af44_618","af44_192","af44_193","af44_619","af44_620","af44_195","af44_194","fechahora","af44_256","af44_219","af44_645","af44_196","af44_197","af44_198","af44_200","af44_201","af44_257","af44_258","af44_199","af44_261","af44_264","af44_551","af44_202","af44_546","af44_549","af44_550");
$camposQgenerales = "id_usuario,af44_180,af44_197,af44_184,af44_185,af44_218,af44_567,af44_186,af44_187,af44_188,af44_189,af44_190,af44_191,af44_617,af44_618,af44_192,af44_193,af44_619,af44_620,af44_195,af44_194,fechahora,af44_256,af44_219,af44_645,af44_196,af44_197,af44_198,af44_200,af44_201,af44_257,af44_258,af44_199,af44_261,af44_264,af44_551,af44_202,af44_546,af44_549,af44_550";

switch($rid){
	
	case "tm";
	

	$labesARRrep  	= array("TARJETA o CUENTA PARA EL DEBITO","LINEA TC","VALOR PRIMA","PRED / IN / OUT /","GESTION TM","AGENDA","ID REGISTRO");
	$camposARRrep	= array("af45_204","af45_203","af45_205","af45_206","af45_220","af45_554","id_reg");
	$camposQrep	 	= "af45_204,af45_203,af45_205,af45_206,af45_220,af45_554,id_reg";
	$tablas		 	= "autof_seguros_4,autof_tm_4,history_4";
	$clausulasD	 	= "af45_220 != '' AND autof_seguros_4_id = id_reg AND autof_tm_4_id = id_reg AND ".$clausulas;
	$campofecha	 	= "fechahora";
	$ClausulasADD 	= "GROUP BY id_reg";

	break;
	
	case "pt";
	

	$labesARRrep  	= array("TARJETA o CUENTA PARA EL DEBITO","LINEA TC","VALOR PRIMA","PRED / IN / OUT /","GESTION TM","AGENDA","ID REGISTRO");
	$camposARRrep	= array("af45_204","af45_203","af45_205","af45_206","af45_220","af45_554","id_reg");
	$camposQrep	 	= "af46_226,af46_225,af46_275,af46_278,af46_227,af46_566,id_reg";
	$tablas		 	= "autof_seguros_4,autof_pt_4,history_4";
	$clausulasD	 	= "af46_227 != '' AND autof_seguros_4_id = id_reg AND autof_pt_4_id = id_reg AND ".$clausulas;
	$campofecha	 	= "fechahora";
	$ClausulasADD 	= "GROUP BY id_reg";

	break;
	
	case "operador";
	

	$labesARRrep  	= array("TARJETA o CUENTA PARA EL DEBITO","LINEA TC","VALOR PRIMA","PRED / IN / OUT /","GESTION TM","AGENDA","ID REGISTRO");
	$camposARRrep	= array("af45_204","af45_203","af45_205","af45_206","af45_220","af45_554","id_reg");
	$camposQrep	 	= "af46_226,af46_225,af46_275,af46_278,af46_227,af46_566,id_reg";
	$tablas		 	= "autof_seguros_4,autof_pt_4,history_4,agents";
	$clausulasD	 	= "autof_seguros_4_id = id_reg AND autof_pt_4_id = id_reg AND ".$clausulas;
	$campofecha	 	= "fechahora";
	$ClausulasADD 	= "GROUP BY id_reg";

	break;
	
	case "dv";
	

	echo "Sin Detalle para Davida";exit;

	break;
	
	}
	


	$labesARR 	= array_merge($LabelsGenerales , $labesARRrep);
	$camposARR	= array_merge($CamposGenerales , $camposARRrep);
	$camposQ	= $camposQgenerales.",".$camposQrep ;

	


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
  

		$OperadorDATA = $sqlm->sql_select("agents,history_4","name","id_reg = '".$consulta[$i][id_reg]."' $IdAgenteQ AND id_agents = id_usuario ORDER BY id_history_4 DESC LIMIT 0,1",0);
  		if(is_array($OperadorDATA)){$TextoPrint = $OperadorDATA[0][name];}else{$TextoPrint = "";}
		$C=2;
  
										   	}


  elseif($camposARR[$o] == "fechaA")		{ 
  
    	$AFechaV = $sqlm->sql_select("agenda","fecha","idregistro = '".$consulta[$i][autof_matrizprincipal_1_id]."'",0);
  		if(is_array($AFechaV)){$TextoPrint = $AFechaV[0][fecha];}else{$TextoPrint = "";}
		$C=2;
  
										   	}

  elseif($camposARR[$o] == "horaA")		{ 
  
    	$AHoraV = $sqlm->sql_select("agenda","hora","idregistro = '".$consulta[$i][autof_matrizprincipal_1_id]."'",0);
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
