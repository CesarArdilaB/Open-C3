<?
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[_pagi_pg] == ""){

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
	
echo "<div style='width:400px;'>".$formulario_auto->generar_form_ins(29,1,0,"'MuestraGrid','modules/agenda/estados.php?op=2'",0)."</div>"; 
$_GET[op]=2;
$inc=1;

?>
<hr>

<div id="MuestraGrid">
<? }//---------------------------

if($_GET[op] == 2 or $_GET[_pagi_pg] != ""){ //-------------------------

if($inc != 1){ include("../../appcfg/general_config.php"); }

$arrProp=array("op");


 //$clausulas = "inactivo = 0"; 
	
	$clausulas = "inactivo = 0";
	 
echo $formulario_auto->generar_grid(29,0,$clausulas,"modules/agenda/estados.php","MuestraGrid",10,$arrProp,$_page_pg,1,1,"modules/agenda/estados.php?op=2","MuestraGrid");

}


?>
</div>
</div>