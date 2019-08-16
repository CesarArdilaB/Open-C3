<?

//------------------ general config

$RAIZCONF = $_SERVER['DOCUMENT_ROOT']."/openc3";
$RAIZHTTPCONF = "https://$ipruta/";

include_once("$RAIZCONF/appcfg/cc.php");
include_once("$RAIZCONF/appcfg/js_scripts.php");
include_once("$RAIZCONF/appcfg/class_sqlman.php");
include_once("$RAIZCONF/appcfg/class_forms.php");
include_once("$RAIZCONF/appcfg/class_autoforms.php");
include_once("$RAIZCONF/appcfg/class_campanas.php");
include_once("$RAIZCONF/appcfg/class_campos.php");


$RAIZCONF = $_SERVER['DOCUMENT_ROOT']."/openc3";
$RAIZHTTPCONF = "/openc3";

//activamos los objetos
$sqlm = new Man_Mysql();


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTPCONF";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZCONF";
$formulario_auto->RutaHTTP="$RAIZHTTPCONF";
$formulario_auto->RutaRaiz="$RAIZHTTPCONF";

$campanaC = new Campana();
$camposman = new CamposManage();

$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");
//------------------ general config

require '../../appcfg/class_reports.php';
//aqui hacemos la descarga del archivo
$reporte = new reportes();
$reporte->RutaHTTP="$RAIZHTTP";

$reporte->Genera_csv_repdina(17,"2014-02-21","2014-09-12","inv_inventario.fechah",662);

?>