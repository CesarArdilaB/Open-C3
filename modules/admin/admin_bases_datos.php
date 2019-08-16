<?
include("../appcfg/cc.php");
include("../appcfg/func_mis.php");
include("../appcfg/clas_plantilla.php");
include("../appcfg/class_forms.php");
include("../appcfg/class_autoforms.php");
include("../appcfg/class_sqlman.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaiz="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";

if(isset($_POST[ok])){

$mensaje = $sqlm->ins_from($_POST,"paginas","ok",0);

}
 if($op != 1 and $op != 2){

include("../appcfg/js_scripts.php");

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";	 
$JsScripts->AllScripts();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>administrador de paginas</title>
</head>
<link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../css/petros.css"/>
<body>
<br />
<br />
<br />

<div class="textosbig" align="center">Administracion de bases de datos</div>
<p><br />
<div align="center" class="textosbig"><?=$mensaje?></div>

<p>
  <br />
</p>
<div align="center">
  <table border="0" cellpadding="0" cellspacing="1" class="rounded-corners-blue">
    <tr>
      <td class="textos_titulos">Seleccione La Base de datos que desea administrar</td>
      <td class="textos_titulos"><? 
	$parametrosGrupoHerr=array(
	"tabla"=>"autoform_tablas",
	"campo1"=>"labeltabla",
	"campo2"=>"labeltabla",
	"campoid"=>"id_autoformtablas",
	"condiorden"=>"1",
	"direccion"=>"admin_bases_datos.php?op=1&gusuarios=$_POST[varid]");
	echo $formulario->select_envia_link("","idgrupoher","","","",$parametrosGrupoHerr,0,"","MustraPAG"); ?>&nbsp;</td>
    </tr>
  </table>
</div>
<p>
<? }//aqui termina la validacion ?>
</p>
<div align="center" id="MustraPAG">
<p><br>
<? if($op == 1){ 
include("../appcfg/js_scripts.php");

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->ValFormScripts();

echo $formulario_auto->generar_form_ins($varid,1); 
$op=2;
?>
<hr>
<? } ?>
<div id="MuestraGrid">
<? 
if($op == 2){
if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }
$arrProp=array("op","varid");

echo $formulario_auto->generar_grid($varid,0,1,"admin_bases_datos.php","MuestraGrid",10,$arrProp,$_page_pg,1,1);

}
?>
</div>
</p></div>
</body>
</html>