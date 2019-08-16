<?
if($_GET[op] != 1 and $_GET[op] != 2){

//error_reporting(E_ERROR | E_WARNING | E_PARSE);

if($_POST[ok])	{

	$Guardar = $sqlm->ins_from($_POST,"comp_form_rel","ok",0);

				}



if($_POST[act_nodb])	{

	$Guardar = $sqlm->update_recs_auto("comp_form_rel",$_POST,0,"id_modformrel = '$_POST[idmodcomp_nodb]'",0);

						}
						
if($_POST[del_nodb]){
	
	$Consulta = mysql_query("DELETE FROM comp_form_rel WHERE id_modformrel = '$_POST[idmodcomp_nodb]'");
	$Guardar = "El Modulo Fue Retidado";
	
	}

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center">
<h3>Permisos De Acceso Modulos Complementarios</h3></div>
<br>
<div align="center">
  <form method="post">
    <table border="0" cellpadding="o" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td>Formulario</td>
        <td>
        <? 
	$parametrosGrupo=array(
	"tabla"=>"autoform_tablas",
	"campo1"=>"labeltabla",
	"campo2"=>"labeltabla",
	"campoid"=>"id_autoformtablas",
	"condiorden"=>"campaignid != 0");
	echo $formulario->c_select("","idform","","","",$parametrosGrupo,0,0); ?>&nbsp;</td>
      </tr>
      <tr>
        <td>Modulo</td>
        <td><? 
	$parametrosGrupo=array(
	"tabla"=>"comp_modules",
	"campo1"=>"textlink",
	"campo2"=>"textlink",
	"campoid"=>"id_compmod",
	"condiorden"=>"1");
	echo $formulario->c_select("","idcompmod","","","",$parametrosGrupo,0,0); ?></td>
      </tr>
      <tr>
        <td>Perfil de Usuario</td>
        <td><? 
	$parametrosGrupo=array(
	"tabla"=>"groups",
	"campo1"=>"group_name",
	"campo2"=>"group_name",
	"campoid"=>"id_group",
	"condiorden"=>"id_group != 1");
	echo $formulario->c_select("","id_grupo","","","",$parametrosGrupo,0,0); ?></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" name="ok" id="ok" value="Guardar Permiso" /></td>
      </tr>
    </table>
  </form> 
  <p>
  
  <div align="center">
  <?=$Guardar?>
  </div>
  
  </p>
  
  <h3>
 Permisos a Modulos Guardados <br />
  <br />
  </h3>
  
 <?
 
 $DataModules = $sqlm->sql_select("comp_form_rel","*","1",0);
 
 ?> 
  
  <table border="0" cellpadding="o" cellspacing="2" class="rounded-corners-gray">
    <tr>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Formulario</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Modulo</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Perfil de usuario</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Acciones</td>
    </tr>

<? for($i=0 ; $i < count($DataModules) ; $i++){//este es el final del for ?>
<form action="" method="post">
    <tr>
      <td bgcolor="#FFFFFF" class="textospadding"><? 
	$parametrosGrupo=array(
	"tabla"=>"autoform_tablas",
	"campo1"=>"labeltabla",
	"campo2"=>"labeltabla",
	"campoid"=>"id_autoformtablas",
	"condiorden"=>"campaignid != 0");
	echo $formulario->c_select("","idform","","","",$parametrosGrupo,0,0,$DataModules[$i][idform]); ?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><? 
	$parametrosGrupo=array(
	"tabla"=>"comp_modules",
	"campo1"=>"textlink",
	"campo2"=>"textlink",
	"campoid"=>"id_compmod",
	"condiorden"=>"1");
	echo $formulario->c_select("","idcompmod","","","",$parametrosGrupo,0,0,$DataModules[$i][idcompmod]); ?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><? 
	$parametrosGrupo=array(
	"tabla"=>"groups",
	"campo1"=>"group_name",
	"campo2"=>"group_name",
	"campoid"=>"id_group",
	"condiorden"=>"id_group != 1 AND id_group != 3");
	echo $formulario->c_select("","id_grupo","","","",$parametrosGrupo,0,0,$DataModules[$i][id_grupo]); ?></td>
      <td bgcolor="#FFFFFF"><input type="hidden" name="idmodcomp_nodb" value="<?=$DataModules[$i][id_modformrel]?>" id="idmodcomp_nodb" />
        <input type="submit" name="act_nodb" id="act_nodb" value="Guardar" />
        | 
        <input type="submit" name="del_nodb" id="del_nodb" value="Quitar" /></td>
    </tr>
</form>
<? } //este es el final del for ?>
 
    
  </table>
  <p>&nbsp;</p>
</div>
<p>
<? }//aqui termina la validacion ?>
</p>
<div align="center" id="MustrarGH">
<p><br>
</div>
