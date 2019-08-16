<?
if($_GET[op] != 1 and $_GET[op] != 2){

?>
<div class="textosbig" align="center"><h3>Grupos y Agentes</div>
<p><br />
<div align="center" class="textosbig"><?=$mensaje?></div>

<p>
<div align="center">
  <table border="0" cellpadding="0" cellspacing="1" class="rounded-corners-blue">
    <tr>
      <td class="textos_titulos">Seleccione la seccion a administrar</td>
      <td class="textos_titulos"><? 
	$parametrosGrupoHerr=array(
	"tabla"=>"autoform_tablas",
	"campo1"=>"labeltabla",
	"campo2"=>"labeltabla",
	"campoid"=>"id_autoformtablas",
	"condiorden"=>"1 AND nombretabla = \"agents\" OR nombretabla = \"agents_group\" ORDER BY nombretabla DESC",
	"direccion"=>"modules/staff/agents_groups.php?op=1");
	echo $formulario->select_envia_link("","idgrupoher","","","",$parametrosGrupoHerr,0,"","MustraPAG"); ?>&nbsp;</td>
    </tr>
  </table>
</div>
</p>

<p>
<? }//aqui termina la validacion ?>
</p>
<div align="center" id="MustraPAG">
<p><br>
<? if($_GET[op] == 1){

include("../../appcfg/general_config.php");

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

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }
echo "<div style='width:400px;'>".$formulario_auto->generar_form_ins($_POST[varid],1)."</div>"; 
$_GET[op]=2;
$inc=1;

?>
<hr>
<div id="MuestraGrid">
<? }//---------------------------

if($_GET[op] == 2){ //-------------------------

if($inc != 1){ include("../../appcfg/general_config.php"); }

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }
$op=$_GET[op];
$arrProp=array("op","varid");


if($varid == 9){ $clausulas = "tipo = 0 AND inactivo = 0"; }else {$clausulas = "inactivo = 0";} 

echo $formulario_auto->generar_grid($varid,0,$clausulas,"modules/staff/agents_groups.php","MuestraGrid",10,$arrProp,$_page_pg,1,1,"modules/staff/agents_groups.php?op=2&varid=$varid","MuestraGrid");

}


?>
</div>
</div>