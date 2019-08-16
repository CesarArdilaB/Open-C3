<?
if($_GET[op] != 1 and $_GET[op] != 2){

include("../../appcfg/general_config.php");
include("../../appcfg/class_inventario.php");
	
$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();	
	
$inv =  new Inventario();
$inv->RutaHTTP=$RAIZHTTPCONF; 	

$inventario = $inv->historial_4id($_GET[idreg],$_GET[idcam]);

$op=2;
$inc=1;
?>

<div id="MuestraGrid">
<? }//---------------------------

if($_GET[op] == 2){ //-------------------------


}?>
</div>
</div>