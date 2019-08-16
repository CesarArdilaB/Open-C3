<?
if(isset($_POST[ok])){
$mensaje = $sqlm->ins_from($_POST,"page_modules","ok",0);
}

if(isset($_POST[act_nodb])){

$mensaje = $sqlm->update_recs_auto("page_modules",$_POST,0,"id_page_module = $_POST[id_nodb]",0);

}



 if($_GET[op] != 1){

?>


<div class="textosbig" align="center"> <h3>Administracion de Modulos de la Aplicacion</h3>
</div>
<p><br />
<? echo $formulario->g_form("formulario1","","A") ?></p>

<div align="center" class="textosbig"><?=$mensaje?></div>

<p><br />
  <br />
</p>
<div align="center">
  <table border="0" align="center" cellpadding="4" cellspacing="1" class="rounded-corners-blue">
    <tr>
      <td class="textos_titulos">Nombre Modulo</td>
      <td> <?=$formulario->c_text("","page_title","","","","",0)?></td>
    </tr>
    <tr>
      <td class="textos_titulos">Grupo de Herramientas</td>
      <td> <? 
	$parametrosGrupo=array(
	"tabla"=>"page_modules",
	"campo1"=>"modulegroup",
	"campo2"=>"modulegroup",
	"campoid"=>"id_page_module",
	"condiorden"=>"1 GROUP BY modulegroup");
	echo $formulario->c_Auto_select("","modulegroup","","","",$parametrosGrupo,0,0); ?></td>
    </tr>
    <tr>
      <td class="textos_titulos">Carpeta</td>
      <td><?=$formulario->c_text("","module_folder","","","","",0)?></td>
    </tr>
    <tr>
      <td class="textos_titulos">Nombre del Archivo</td>
      <td> <?=$formulario->c_text("","module_file","","","","",0)?></td>
    </tr>
    <tr>
      <td class="textos_titulos">Permisos</td>
      <td> <?=$formulario->c_text("","module_permission","","","","",0)?></td>
    </tr>
    <tr>
      <td colspan="2" align="center" class="textos_titulos"><input type="submit" name="ok" id="ok" value="Guardar" /></td>
    </tr>
  </table>
</div>
<p><? echo $formulario->g_form("formulario1","") ?>
</p>
<p><br />
<div align="center">
  <table border="0" cellpadding="0" cellspacing="1" class="rounded-corners-blue">
    <tr>
      <td class="textos_titulos">Filtrar Por Grupo</td>
      <td><? 
	$parametrosGrupo=array(
	"tabla"=>"page_modules",
	"campo1"=>"id_page_module",
	"campo2"=>"modulegroup",
	"campoid"=>"modulegroup",
	"condiorden"=>"1 GROUP BY modulegroup",
	"direccion"=>"$RAIZHTTP/modules/admin/admin_paginas.php?op=1");
	echo $formulario->select_envia_link("","id_page_module","","","",$parametrosGrupo,0,"","MuestaREG",0); ?> </td>
    </tr>
  </table>
</div>
<br><hr><br>
<p>
<div align="center" id="MuestaREG">
<? }
if($_GET[op] == 1){ 

include("../../appcfg/cc.php");
include("../../appcfg/func_mis.php");
include("../../appcfg/class_forms.php");
include("../../appcfg/class_sqlman.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm= new Man_Mysql();

?>


  <table border="0" align="center" cellpadding="4" cellspacing="1" class="rounded-corners-blue">
    <tr>
      <td class="textos_titulos">Modulo</td>
      <td class="textos_titulos">Archivo</td>
      <td class="textos_titulos">Carpeta</td>
      <td class="textos_titulos">Permisos</td>
      <td class="textos_titulos">Acciones <?=$_POST[varid]?></td>
    </tr>
<?
$seleccionar = $sqlm->sql_select("page_modules","id_page_module,page_title,module_folder,module_file,module_permission","modulegroup LIKE CONVERT( _utf8 '$_POST[varid]'USING latin1 ) COLLATE latin1_spanish_ci",0); 
for($i=0 ; $i < count($seleccionar) ; $i++){ 
echo $formulario->g_form("formulario[$i]","","A");
?>
<form method="post" action="">
 	  <tr>
      <td class="textos_titulos"><?=$formulario->c_text("","page_title","","",$seleccionar[$i]["page_title"],"",0)?></td>
      <td class="textos_titulos"><?=$formulario->c_text("","module_file","","",$seleccionar[$i]["module_file"],"",0)?></td>
      <td class="textos_titulos"><?=$formulario->c_text("","module_folder","","",$seleccionar[$i]["module_folder"],"",0)?></td>
      <td class="textos_titulos"><?=$formulario->c_text("","module_permission","","",$seleccionar[$i]["module_permission"],"",0)?></td>
      <td align="center" class="textos_titulos"><input name="id_nodb" type="hidden" id="tipo2" value="<?=$seleccionar[$i][id_page_module]?>" />        <input type="submit" name="act_nodb" id="act_nodb" value="Guardar" /></td>
      </tr>
</form>
<? echo $formulario->g_form("formularioedit[$i]",""); } ?>
  </table>

<? } ?>  
</div>