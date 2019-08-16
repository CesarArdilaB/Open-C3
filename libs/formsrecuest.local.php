<?
include("../appcfg/cc.php");
include("../appcfg/func_mis.php");
include("../appcfg/js_scripts.php");
include("../appcfg/clas_plantilla.php");
include("../appcfg/class_forms.php");
include("../appcfg/class_autoforms.php");
include("../appcfg/class_sqlman.php");
include("../appcfg/class_campanas.php");

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZCONF";
$formulario_auto->RutaHTTP="$RAIZHTTP";
$formulario_auto->RutaRaiz="$RAIZHTTP";

$sqlm= new Man_Mysql();

$campanaC = new Campana();

//este archivo resive las llamadas de los diferentes formularios para las funciones estandart de la clase de Man_Sql
?>

<link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>

<?
if($_GET[grupousuarios]){ // esta es llamada por la pagina que administra los permisos para asi asignarlos a cada usuario
	
  	if($_GET[guardado] != 0){

	$borrar=$sqlm->del_regs("module_permissions","id_permission = '".$_GET[guardado]."'",0);
		
	echo $borrar;

	}else{

	$guardar=$sqlm->ins_regs("module_permissions","ok","id_page,idgroup","'".$_GET[permiso]."','".$_GET[grupousuarios]."'",0);	

	echo $guardar; }
	
	} //------------------------
	

if ($_GET[guardarFORMest] == 1){ // en esta llamada guardamos un formulario standar (con el comportamiento estandar en los nombres de los campos y la base) o autogenerado 
	
	$camposARR = array();
	
				foreach ($_GET as $llave => $value){
		
				if($llave != "tablaINS" and $llave != "botonNOM" and $llave != "mostrarOP" and $llave != "guardarFORMest"){
					$camposARR[$llave] .= "$value";
												}
				}	
				
	$guardar = $sqlm->insert_recs_auto($_GET[tablaINS],$camposARR,"",$mostrarOP);
	
	echo $guardar;
	
	}

if ($_GET[guardarFORMcampana] == 1){ // en esta llamada guardamos un formulario standar (con el comportamiento estandar en los nombres de los campos y la base) o autogenerado 
	
	$camposARR = array();
	//print_r($_GET);
				foreach ($_GET as $llave => $value){
		
				if($llave != "tablaINS" and $llave != "botonNOM" and $llave != "mostrarOP" and $llave != "idRgistro" and $llave != "idUsuario" and $llave != "idCampana" and $llave != "guardarFORMcampana"){
					
					if(substr($llave,0,4) == "his_"){
						
						$historialARR[$llave] ="$value";
						$logstring=strlen($llave)-4;
						$camposARR[substr($llave,4,$logstring)] .= "$value";
						
						}else{$camposARR[$llave] .= "$value";}
					
						
															}
																				}	
																				
	$camposARR[$_GET[tablaINS]."_id"] .= $_GET[idRgistro];
	$historialARR[id_reg] = $_GET[idRgistro];
	$historialARR[id_usuario] = $_GET[idUsuario];
	$historialARR[fechahora] = "$fecha_act $hora_act";
	$historialARR[accion] = "Registro Creado";

	$guardarhostorial = $sqlm->insert_recs_auto("history_".$_GET[idCampana],$historialARR,"",$_GET[mostrarOP]);			
	$guardar = $sqlm->insert_recs_auto($_GET[tablaINS],$camposARR,"",$_GET[mostrarOP]);
	$actualizaIdent=$sqlm->update_regs("ident_".$_GET[idCampana],"estado = 1, agente='".$_GET[idUsuario]."',fechahorac = '$fecha_act $hora_act'","id_ident_".$_GET[idCampana]." = ".$_GET[idRgistro],$_GET[mostrarOP]);
	
	echo $guardar;
	
	}


if ($_GET[UpdateFORMcampana] == 1){ // en esta llamada guardamos un formulario standar (con el comportamiento estandar en los nombres de los campos y la base) o autogenerado 
	
	$camposARR = array();
	
				foreach ($_GET as $llave => $value){
		
				if($llave != "tablaINS" and $llave != "botonNOM" and $llave != "mostrarOP" and $llave != "idRgistro" and $llave != "idUsuario" and $llave != "idCampana" and $llave != "UpdateFORMcampana"){
					
					if(substr($llave,0,4) == "his_"){
						
						$historialARR[$llave] ="$value";
						$logstring=strlen($llave)-4;
						$camposARR[substr($llave,4,$logstring)] .= "$value";
						
						}else{$camposARR[$llave] .= "$value";}
					
						
															}
																				}	
																				
	//$camposARR[$tablaINS."_id"] .= $_GET[idRgistro];
	$historialARR[id_reg] = $_GET[idRgistro];
	$historialARR[id_usuario] = $_GET[idUsuario];
	$historialARR[fechahora] = "$fecha_act $hora_act";
	$historialARR[accion] = "Registro Modificado";

	$guardarhostorial = $sqlm->insert_recs_auto("history_".$_GET[idCampana],$historialARR,"",$_GET[mostrarOP]);			
	$guardar = $sqlm->update_recs_auto($_GET[tablaINS],$camposARR,0,$_GET[tablaINS]."_id"." = ".$_GET[idRgistro],$_GET[mostrarOP]);
	$actualizaIdent=$sqlm->update_regs("ident_".$_GET[idCampana],"estado = 1 , agente='".$_GET[idUsuario]."'","id_ident_".$_GET[idCampana]." = ".$_GET[idRgistro],$_GET[mostrarOP]);
	
	echo $guardar;
	
	$campanaC->contador_update($_GET[idCampana],$_GET[idRgistro]);
	
	}

if ($_GET[editcelda] == 1){ // en esta generamos un formulario para actualizar una celda puntual. 
	
	switch ($_GET[editpaso]) {
	case 1;
	
	
	$traerPRO =$sqlm->sql_select("autoform_config","nombrecampo,tipocampo,requerido,paramcampo","id_autoform_config = '$_GET[campid]'",0);
	$traerDATO =$sqlm->sql_select($_GET[nombretab],$traerPRO[0][nombrecampo],"$_GET[camid] = '$_GET[idcelda]'",0);
	
	$campomos=$traerPRO[0][nombrecampo];
	
	echo "<div id='$_GET[nombrediv]'><form name='formu$_GET[editcelda]$_GET[campid]$_GET[idcelda]' autocomplete=\"off\" onsubmit=\"EnviarLinkForm('$_GET[nombrediv]','$RAIZHTTP/libs/formsrecuest.php?editcelda=1&editpaso=2&tablaupdate=$_GET[nombretab]&campoupdate=$campomos&campoid=$_GET[camid]&valorid=$_GET[idcelda]&campide=$_GET[campid]',this);return false;\">";
	
	echo $formulario_auto->armar_campo($traerPRO[0][tipocampo],$traerPRO[0][nombrecampo],"",$traerDATO[0][$campomos],$traerPRO[0][requerido],0,0,$traerPRO[0][paramcampo]);
	
	echo "<input type=\"submit\" name=\"ok\" id=\"ok\" value=\"Guardar\"/>
	</form></div>";
	
	break;
	case 2;
	
	$traerPRO =$sqlm->sql_select("autoform_config","nombrecampo,tipocampo,requerido,paramcampo","nombrecampo = '$_GET[campoupdate]'",0);
	$actualizar=$sqlm->update_regs($_GET[tablaupdate],"$_GET[campoupdate] = '".$_GET[$_GET[campoupdate]]."'","$_GET[campoid] = '$_GET[valorid]'",0);
	echo $formulario_auto->armar_campo(@$traerPRO[0][tipocampo],@$traerPRO[0][nombrecampo],"",$_GET[$_GET[campoupdate]],@$traerPRO[0][requerido],1,0,@$traerPRO[0][paramcampo]);
	echo " <a href=\"javascript:EnviarLinkJ('dived".$_GET[valorid]."$_GET[campoupdate]','$RAIZHTTP/libs/formsrecuest.php?campid=".$_GET[campide]."&editcelda=1&editpaso=1&camid=$_GET[campoid]&idcelda=".$_GET[valorid]."&nombretab=$_GET[tablaupdate]&nombrediv=dived".$_GET[valorid]."$_GET[campoupdate]')\">
	<img src='$RAIZHTTP/imgs/editimg.png' width='12' height='12'></img> </a>";
	
	break;
	}
	
	}  // termina la llamada a deit celda de los formularios dinamicos
	
if($_GET[delcelda] == 1){ //aqui empiesa la entrada para eliminar un registro de las filas dinamicas

	$html .= "<div class='rounded-corners-ALERTA' align='center'>";
	$html .= "<samp class='textosbigBlancoSmall'>Esta Seguro que Desea Eliminar Este Registro?</samp>";
	$html .= "<div><br><br>";
	$html .= "<div><a class='textosbigBlancoSmall' href='$RAIZHTTP/libs/formsrecuest.php?idtabla=$_GET[idtabla]&delcelda=ok&camid=$_GET[camid]&idreg=".$_GET[idregs]."'>!! Eliminar !! </a><div>";
	
	echo $html;
	
	} //aqui termina la entrada para eliminar un registro de las filas dinamicas

if($_GET[delcelda] == "ok"){ //aqui empiesa la entrada para eliminar un registro de las filas dinamicas

	$TablaData = $sqlm->sql_select("autoform_tablas","nombretabla","id_autoformtablas = '$_GET[idtabla]'",0);
	$actualizar= $sqlm->update_regs($TablaData[0][nombretabla],"inactivo = 1","$_GET[camid] = '$_GET[idreg]'",0);

	$html .= "<div class='rounded-corners-ALERTA' align='center'>";
	$html .= "<samp class='textosbigBlancoSmall'>Registro Eliminado</samp>";
	$html .= "<div>";
	
	echo $html;
	
	} //aqui termina la entrada para eliminar un registro de las filas dinamicas
?>