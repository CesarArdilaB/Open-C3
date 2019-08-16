<?
if($_GET[op] != 1 and $_GET[op] != 2){

//error_reporting(E_ERROR | E_WARNING | E_PARSE);

?>
<div align="center"><h3>Permisos De Acceso</h3></div>
<br>
<br>
<div align="center">
  <table border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="1" class="rounded-corners-blue">
        <tr>
          <td class="textos_titulos">Filtrar Por Grupo de usuarios</td>
          <td><? 
	$parametrosGrupoUsr=array(
	"tabla"=>"groups",
	"campo1"=>"id_group",
	"campo2"=>"group_name",
	"campoid"=>"id_group",
	"condiorden"=>"1",
	"direccion"=>"$RAIZHTTP/modules/admin/admin_permisos.php?op=1");
	echo $formulario->select_envia_link("","idgrupo","","","",$parametrosGrupoUsr,0,"","MustrarGH"); ?></td>
        </tr>
      </table></td>
      <td align="left" valign="middle"><a href="?sec=admin&amp;mod=admin_permisos_files"></a>
        <table border="0" cellpadding="0" cellspacing="1" class="rounded-corners-blue">
          <tr>
            <td class="textos_titulos"><a href="?sec=admin&amp;mod=admin_permisos_files">Documentacion Relacionada</a></td>
            <td class="textos_titulos"><a href="?sec=admin&amp;mod=admin_permisos_compmodules">Modulos Complementarios</a></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<p>
<? }//aqui termina la validacion ?>
</p>
<div align="center" id="MustrarGH">
<p><br>
<? if($_GET[op] == 1){ 

include("../../appcfg/cc.php");
include("../../appcfg/func_mis.php");
include("../../appcfg/class_forms.php");
include("../../appcfg/class_sqlman.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm= new Man_Mysql();


?>
  <table border="0" cellpadding="0" cellspacing="1" class="rounded-corners-blue">
    <tr>
      <td class="textos_titulos">Grupo de Herramientas</td>
      <td><? 
	$parametrosGrupoHerr=array(
	"tabla"=>"page_modules",
	"campo1"=>"id_page_module",
	"campo2"=>"modulegroup",
	"campoid"=>"modulegroup",
	"condiorden"=>"1 GROUP BY modulegroup",
	"direccion"=>"$RAIZHTTP/modules/admin/admin_permisos.php?op=2&gusuarios=$_POST[varid]");
	echo $formulario->select_envia_link("","idgrupoher","","","",$parametrosGrupoHerr,0,"","MustraPAG"); ?></td>
    </tr>
  </table>
<? } ?>
</p></div>
<div align="center" id="MustraPAG"><p>
<? if($_GET[op] == 2){ 
include("../../appcfg/cc.php");
include("../../appcfg/func_mis.php");
include("../../appcfg/class_forms.php");
include("../../appcfg/class_sqlman.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm= new Man_Mysql();


$seleccionar = $sqlm->sql_select("page_modules","id_page_module,page_title,modulegroup,module_folder,module_permission","modulegroup LIKE CONVERT( _utf8 '$_POST[varid]'USING latin1 ) COLLATE latin1_spanish_ci",0); 

?></p>

</p>
  <table border="0" align="center" cellpadding="0" cellspacing="1" class="rounded-corners-blue">
    <tr>
      <td class="textos_titulos">Nombre del Modulo</td>
      <td class="textos_titulos">Permiso de Acceso</td>
      <td align="center" class="textos_titulos">Guardar</td>
    </tr>
    <tr>
      <td colspan="3" class="textos">
 
 <? for($i=0 ; $i < count($seleccionar) ; $i++){ 

$permisoASIG="";

$permisoASIG = $sqlm->sql_select("module_permissions","idgroup,id_page,id_permission","idgroup = '$_GET[gusuarios]' AND id_page = '".$seleccionar[$i]["id_page_module"]."'",0); 

$idactual=$seleccionar[$i]["id_page_module"];

if($permisoASIG == "No hay resultados"){ $checkBOX=0;$guargadoVAL=0; }else{ $checkBOX=1; $guargadoVAL=$permisoASIG[0][	id_permission]; }

echo $formulario->g_form("formulario$i","","A",0); 
?>
      
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="55%"><?=utf8_encode($seleccionar[$i]["page_title"])?></td>
          <td width="20%"><div align="center">
            <?=$formulario->c_check("","permiso","","","$idactual","","",$checkBOX)?>
          </div></td>
          <td width="25%">
          <input name="grupousuarios" type="hidden" id="hiddenField" value="<?=$_GET[gusuarios]?>" />
          <input name="guardado" type="hidden" id="hiddenField" value="<?=$guargadoVAL?>" />
            <input type="button" name="ok" id="ok" value="Guardar"  onclick="EnviarLinkForm('formguardar','<?=$RAIZHTTP?>/libs/formsrecuest.php',this.form);"/></td>
        </tr>
      </table>
      
      <? echo $formulario->g_form("formulario$i","","",0); } ?>
      
      </td>
    </tr>

    </table>
  <p><br><br>
  
  <div align="center" id="formguardar"></div>
  
<?  } ?>
  </p>
</div>