<?
if($_GET[op] != 1 and $_GET[op] != 2){

@include("../../appcfg/general_config.php");

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->ValFormScripts();
	
echo "<div style='width:400px;'>".$formulario_auto->generar_form_ins(12,1,0,"'MuestraGrid','modules/staff/mensajeros.php?op=2'")."</div>"; 
$_GET[op]=2;
$inc=1;

?>
<hr>

<div id="MuestraGrid">
<? }//---------------------------

if($_GET[op] == 2){ //-------------------------
if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------
$op=$_GET[op];
if($inc != 1){ include("../../appcfg/general_config.php"); }

$arrProp=array("op");


 //$clausulas = "inactivo = 0"; 
	
	$clausulas = "nolabora = 0";
	 
echo $formulario_auto->generar_grid(12,0,$clausulas,"modules/staff/mensajeros.php","MuestraGrid",10,$arrProp,$_page_pg,0,1);

}


?>
</div>
</div>