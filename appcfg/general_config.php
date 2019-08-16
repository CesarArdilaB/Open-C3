<?
//$ipruta = $_SERVER['SERVER_ADDR']; 
$ipruta="192.168.0.147";

$RAIZCONF = $_SERVER['DOCUMENT_ROOT']."/openc3";
$RAIZHTTPCONF = "https://$ipruta/";

include_once("$RAIZCONF/appcfg/cc.php");
include_once("$RAIZCONF/appcfg/func_mis.php");
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
//validamos el logueo de los usuarios
?>
