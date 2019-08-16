<? 
include("../../appcfg/cc.php");
include("../../appcfg/func_mis.php");
include("../../appcfg/js_scripts.php");
include("../../appcfg/class_sqlman.php");
include("../../appcfg/class_forms.php");
include("../../appcfg/class_autoforms.php");

$sqlm= new Man_Mysql();

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaiz="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";

if($_GET[action]=="make"){
	
	echo "<div align='center'><h3>Actualizando Base de Datos</h3></div>  <br><br><br><br><br><br>";
	
	//aqui generamos la tabla que corresponde a el formulario creado.
	
	$NombreTabla = $sqlm->sql_select("autoform_tablas","nombretabla,campaignid","id_autoformtablas = $_GET[formid]",0);
	$tablaProp = $sqlm->sql_select("autoform_config","*","idtabla_rel = $_GET[formid] AND eliminado !=1",0);
	$tablaProH = $sqlm->sql_select("autoform_config","*","idtabla_rel = $_GET[formid] AND historial = 1 AND eliminado !=1",0);
	
		if($tablaProp == "No hay resultados" or $tablaProH == "No hay resultados"){echo" 
	<div align='center'><br /><br /><br />
 	<table border='0' align='center' cellpadding='0' cellspacing='0' class='rounded-corners-blue'>
      <tr>
        <td class='textos_titulos' align='center'>No Ahy Campos para Guardar O Compruebe que exista por lomenos un campo tipo Historial</td>
      </tr>
    </table>
	</div>"; exit; }
	
	//organizamos los campos de la tabla del formulario
	
	$CamposArray[] = array("nombrec" => $NombreTabla[0]["nombretabla"]."_id" , "tipoc" => "INT NOT NULL AUTO_INCREMENT PRIMARY KEY"); // aqui le agregamos el campo id

 	for( $i=0 ; $i < count($tablaProp) ; $i++ ){ 
		
	if($tablaProp[$i]["unico"] == "1"){ $unicos = $tablaProp[$i]["nombrecampo"] ; }	
		
	if($tablaProp[$i]["tipocampo"] == "text"){ $tipocampo = "VARCHAR( 125 ) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL"; }	
	if($tablaProp[$i]["tipocampo"] == "check"){ $tipocampo = "VARCHAR( 2 ) CHARACTER SET utf8 COLLATE  utf8_spanish_ci NOT NULL"; }
	if($tablaProp[$i]["tipocampo"] == "autocom" or $tablaProp[$i]["tipocampo"] == "select"){ $tipocampo = "VARCHAR( 30 ) CHARACTER SET utf8 COLLATE  utf8_spanish_ci NOT NULL"; }	
	if($tablaProp[$i]["tipocampo"] == "textarea"){ $tipocampo = "TINYTEXT CHARACTER SET utf8 COLLATE  utf8_spanish_ci NOT NULL"; }
	if($tablaProp[$i]["tipocampo"] == "fecha"){ $tipocampo = "DATE NOT NULL"; }
			
	$CamposArray[] = array("nombrec" => $tablaProp[$i]["nombrecampo"] , "tipoc" => $tipocampo);
	$CamposUnicos[] = $unicos;
		
		$sqlm->update_regs("autoform_config","generado = 1","id_autoform_config = ".$tablaProp[$i]["id_autoform_config"]."",0);
		
												} 
	
	//organizamos los campos de la tabla del formulario
	 
	$CreaTabla=$sqlm->sql_creatabla($NombreTabla[0]["nombretabla"],$CamposArray,0);
	
	//creamos la tabla de el formulario seleccionado.

	//creamos las tablas de historiales y entidad de relacion de ids
	
	$arrCamposI[]=array("nombrec" => "id_ident_".$NombreTabla[0]["campaignid"] , "tipoc" => "INT NOT NULL AUTO_INCREMENT PRIMARY KEY");
	$arrCamposI[]=array("nombrec" => "estado" , "tipoc" => "INT NOT NULL");	
	$arrCamposI[]=array("nombrec" => "agente" , "tipoc" => "INT NOT NULL");
	$arrCamposI[]=array("nombrec" => "fechahorac" , "tipoc" => "DATETIME NOT NULL");

	
		$CreaTablaIdent=$sqlm->sql_creatabla("ident_".$NombreTabla[0]["campaignid"],$arrCamposI,0);
		
		$MeterPrimerId=$sqlm->inser_data("ident_".$NombreTabla[0]["campaignid"],"estado","0");
	
	$arrCamposH[]=array("nombrec" => "id_reg" , "tipoc" => "INT NOT NULL");
	$arrCamposH[]=array("nombrec" => "id_usuario" , "tipoc" => "INT NOT NULL");
	$arrCamposH[]=array("nombrec" => "fechahora" , "tipoc" => "DATETIME NOT NULL");
	$arrCamposH[]=array("nombrec" => "accion" , "tipoc" => "VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL");
	
	 	for( $i=0 ; $i < count($tablaProH) ; $i++ ){ //organizamos los campos de la tabla del formulario
		
	if($tablaProH[$i]["tipocampo"] == "text" or $tablaProH[$i]["tipocampo"] == "autocom" or $tablaProH[$i]["tipocampo"] == "check" or $tablaProH[$i]["tipocampo"] == "select"){ $tipocampo = "VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL"; }	
	if($tablaProH[$i]["tipocampo"] == "textarea"){ $tipocampo = "TINYTEXT NOT NULL"; }	
	if($tablaProH[$i]["tipocampo"] == "fecha"){ $tipocampo = "DATE NOT NULL"; }
			
		$arrCamposH[] = array("nombrec" => "his_".$tablaProH[$i]["nombrecampo"] , "tipoc" => $tipocampo);
		
												} //organizamos los campos de la tabla del formulario
	
	$arrCamposH[]=array("nombrec" => "id_history_".$NombreTabla[0]["campaignid"] , "tipoc" => "INT NOT NULL AUTO_INCREMENT PRIMARY KEY");
	
		$CreaTablaHistori=$sqlm->sql_creatabla("history_".$NombreTabla[0]["campaignid"],$arrCamposH,0);
	//creamos las tablas de historiales y entidad de relacion de ids	
	
	echo" 
	<div align='center'><br /><br /><br />
 	<table border='0' align='center' cellpadding='0' cellspacing='0' class='rounded-corners-blue'>
      <tr>
        <td class='textos_titulos' align='center'>Las Tablas Fueron Generadas Correctamente</td>
      </tr>
    </table>
	</div>";
	
}

elseif($_GET[action]=="update"){

	echo "<div align='center'><h3>Actualizando Base de Datos</h3></div>  <br><br><br><br><br><br>";

	//aqui generamos la tabla que corresponde a el formulario creado.
	
	$NombreTabla = $sqlm->sql_select("autoform_tablas","nombretabla,campaignid","id_autoformtablas = $_GET[formid]",0);
	$tablaProp = $sqlm->sql_select("autoform_config","*","idtabla_rel = $_GET[formid] AND eliminado !=1 AND generado = 0",0);
	$tablaProH = $sqlm->sql_select("autoform_config","*","idtabla_rel = $_GET[formid] AND historial = 1 AND eliminado !=1 AND generado = 0",0);
	
	if($tablaProp == "No hay resultados" and $tablaProH == "No hay resultados"){echo" 
	<div align='center'><br /><br /><br />
 	<table border='0' align='center' cellpadding='0' cellspacing='0' class='rounded-corners-blue'>
      <tr>
        <td class='textos_titulos' align='center'>No Ahy Campos para Actualizar</td>
      </tr>
    </table>
	</div>"; exit; }	
	
 	for( $i=0 ; $i < count($tablaProp) ; $i++ ){ //organizamos los campos de la tabla del formulario
		
	if($tablaProp[$i]["tipocampo"] == "text"){ $tipocampo = "VARCHAR( 125 ) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL"; }	
	if($tablaProp[$i]["tipocampo"] == "check"){ $tipocampo = "VARCHAR( 2 ) CHARACTER SET utf8 COLLATE  utf8_spanish_ci NOT NULL"; }
	if($tablaProp[$i]["tipocampo"] == "autocom" or $tablaProp[$i]["tipocampo"] == "select"){ $tipocampo = "VARCHAR( 30 ) CHARACTER SET utf8 COLLATE  utf8_spanish_ci NOT NULL"; }	
	if($tablaProp[$i]["tipocampo"] == "textarea"){ $tipocampo = "TINYTEXT NOT NULL"; }
	if($tablaProp[$i]["tipocampo"] == "fecha"){ $tipocampo = "DATE NOT NULL"; }
			
	$CamposArray[] = array("nombrec" => $tablaProp[$i]["nombrecampo"] , "tipoc" => $tipocampo);
		
		$sqlm->update_regs("autoform_config","generado = 1","id_autoform_config = ".$tablaProp[$i]["id_autoform_config"]."",0);
		
												} //organizamos los campos de la tabla del formulario
	 
	$CreaTabla=$sqlm->sql_editatabla($NombreTabla[0]["nombretabla"],$CamposArray,0);
	
	//creamos la tabla de el formulario seleccionado.

if(is_array($tablaProH)){

	 	for( $i=0 ; $i < count($tablaProH) ; $i++ ){ //organizamos los campos de la tabla del formulario
		
	if($tablaProH[$i]["tipocampo"] == "text" or $tablaProH[$i]["tipocampo"] == "autocom" or $tablaProH[$i]["tipocampo"] == "check" or $tablaProH[$i]["tipocampo"] == "select"){ $tipocampo = "VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL"; }	
	if($tablaProH[$i]["tipocampo"] == "textarea"){ $tipocampo = "TINYTEXT NOT NULL"; }	
	if($tablaProH[$i]["tipocampo"] == "fecha"){ $tipocampo = "DATE NOT NULL"; }
			
		$arrCamposH[] = array("nombrec" => "his_".$tablaProH[$i]["nombrecampo"] , "tipoc" => $tipocampo);
		
												} //organizamos los campos de la tabla del formulario
	
		$CreaTablaHistori=$sqlm->sql_editatabla("history_".$NombreTabla[0]["campaignid"],$arrCamposH,0);
}
	//creamos las tablas de historiales y entidad de relacion de ids	
	
		echo" 
	<div align='center'><br /><br /><br />
 	<table border='0' align='center' cellpadding='0' cellspacing='0' class='rounded-corners-blue'>
      <tr>
        <td class='textos_titulos' align='center'>Las Tablas Fueron Actualizadas Correctamente</td>
      </tr>
    </table>
	</div>";
	
	}
?>