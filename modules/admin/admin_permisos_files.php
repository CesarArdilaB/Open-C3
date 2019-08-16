<?
if($_GET[op] != 1 and $_GET[op] != 2){

//error_reporting(E_ERROR | E_WARNING | E_PARSE);

$selPerfiles = $sqlm->sql_select("groups","*","1");

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center">
<h3>Permisos De Acceso para Documentacion Relacionada</h3></div>
<br>
<div align="center">
  <form onSubmit="EnviarLinkForm('MustrarGH','<?=$RAIZHTTP?>/modules/admin/admin_permisos_files.php?op=1',this);return false;">
    <table border="0" cellpadding="0" cellspacing="1" class="rounded-corners-blue">
      <tr>
        <td align="center" class="textos_titulos">Grupo</td>
        <td align="center" class="textos_titulos">Administar </td>
        <td align="center" class="textos_titulos">Ver</td>
      </tr>
      <? 
	  for($i=0 ; $i < count($selPerfiles) ; $i++){//este es el final del for 
	  
	$PerConsulta = $sqlm->sql_select("files_relacces","ver,adm","id_grupo ='".$selPerfiles[$i][id_group]."'",0);
	if(is_array($PerConsulta))		{
	if( $PerConsulta[0][ver] == 1 ){ $CheVer = "checked='checked'"; } else { $CheVer = ""; }
	if( $PerConsulta[0][adm] == 1 ){ $CheAdm = "checked='checked'"; } else { $CheAdm = ""; }
									}
	  ?>
      <tr>
        <td class="textos"><?=$selPerfiles[$i][group_name]?>
          &nbsp;
          <input name="idgrupo[<?=$i?>]" type="hidden" id="idgrupo[<?=$i?>]" value="<?=$selPerfiles[$i][id_group]?>" /></td>
        <td align="center" class="textos"><input type="checkbox" <?=$CheAdm?> value="1" name="admin[<?=$i?>]" id="admin[<?=$i?>]" /></td>
        <td align="center" class="textos"><input type="checkbox" <?=$CheVer?> value="1" name="vew[<?=$i?>]" id="vew[<?=$i?>]" /></td>
      </tr>

      <? } //este es el final del for ?>      
      <tr>
        <td colspan="3" align="center" class="textos"><input type="submit" name="ok" id="ok" value="Guardar" /></td>
      </tr>
    </table>
  </form>
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

//************************************

for($i=0 ; $i < count($_GET[idgrupo]) ; $i++){//este es el final del for  


$SelPer = $sqlm->sql_select("files_relacces","*","id_grupo = '".$_GET[idgrupo][$i]."'",0);

if(is_array($SelPer)){ $ActConsulta = $sqlm->update_regs("files_relacces"," adm = '".$_GET[admin][$i]."', ver = '".$_GET[vew][$i]."' ","id_grupo = '".$_GET[idgrupo][$i]."'",0); }

else{ $guardarForm = $sqlm->inser_data("files_relacces","id_grupo,adm,ver","'".$_GET[idgrupo][$i]."','".$_GET[admin][$i]."','".$_GET[vew][$i]."'",0); }

} //este es el final del for 

//************************************

?>
  <table border="0" cellpadding="0" cellspacing="1" class="rounded-corners-blue">
    <tr>
      <td align="center" class="textos_titulos">Permiso Guardado</td>
    </tr>
  </table>
<? } ?>
</p></div>
