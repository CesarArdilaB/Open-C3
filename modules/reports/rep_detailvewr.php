<? 
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5){

include '../../appcfg/general_config.php';
require '../../appcfg/class_reports.php';

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();


$reporte = new reportes();
$reporte->RutaHTTP="$RAIZHTTP";
	
//	print_r($_GET);


$reporte->Genera_grid_repdina($_GET[repid],$_GET[fecha],$_GET[campoc],$_GET[valorc]);

}

?>
