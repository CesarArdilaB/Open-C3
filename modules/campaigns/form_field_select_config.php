<?
if($op != 1 and $_GET[op] != 2 and $op != 3 and $op != 4 and $op != 5 and $op != 6 and $addcampo != 1){ 
include("../../appcfg/cc.php");
include("../../appcfg/func_mis.php");
include("../../appcfg/js_scripts.php");
include("../../appcfg/class_sqlman.php");
include("../../appcfg/class_forms.php");
include("../../appcfg/class_autoforms.php");

//activamos los objetos
$sqlm= new Man_Mysql();

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaiz="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";
$formulario_auto->RutaRaiz="$RAIZHTTP";
//validamos el logueo de los usuarios

$SelectTableId = $sqlm->sql_select("autoform_tablas","id_autoformtablas","nombretabla = 'autof_".$_GET[fname]."'",0);


if($SelectTableId == "No hay resultados"){ echo "<br><br><br><br><br><br><br><br><div align='center'>El campo no tiene 
datos porfavor suba un archivo.</div>";exit;}
else{
$fid=$SelectTableId[0][id_autoformtablas];

	}
	
$op=1;
$IncSet=1;



?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center"><h3>Configuracion Avanzada para el Campo: <?=$FieldParams[0]["labelcampo"]?></h3></div>
<div align="center" id="MustraPAG">
  <p><br />
<? } if($op == 1){
	
echo "<div style='width:400px;'>".$formulario_auto->generar_form_ins($fid,1)."</div>"; 

$_GET[op]=2;	}
?>
  </p>
  <hr />
  <div id="MuestraGrid">
 <? 
if($_GET[op] == 2){
	
if($IncSet != 1){include("../../appcfg/general_config.php");}

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

if($_GET[op] != "" ){ $op = $_GET[op]; }
if($_GET[fid] != "" ){ $fid = $_GET[fid]; }

$arrProp=array("op","fid");
echo $formulario_auto->generar_grid($fid,0,"inactivo = 0","form_field_select_config.php","MuestraGrid",10,$arrProp,$_page_pg,1,1,"modules/campaigns/form_field_select_config.php?op=2&fid=$fid","MuestraGrid");

}

?>
  </div>
  </p>
</div>
