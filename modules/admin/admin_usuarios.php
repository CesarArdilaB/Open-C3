<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<?
if(isset($_POST[ok])){

$mensaje = $sqlm->ins_from($_POST,"agents","ok",0);

}

if(isset($_POST[okact_nodb])){

$mensaje = $sqlm->update_recs_auto("agents",$_POST,0,"id_agents = $_POST[id_nodb]",0);

}


$seleccionar = $sqlm->sql_select("agents","name,id_agents,user,idgroup,password","tipo = 1 AND idgroup != 1",0);

?>

<div class="textosbig" align="center">
  <h3>Administracion de Usuarios</h3>
</div>
<p><br />

<? echo $formulario->g_form("formulario1","","A") ?></p>

<div align="center" class="textosbig"><?=$mensaje?></div>

<p>

</p>
<div align="center">
  <table border="0" align="center" cellpadding="4" cellspacing="1" class="rounded-corners-blue">
    <tr>
      <td class="textos_titulos">Nombre</td>
      <td> <?=$formulario->c_text("","name","","","","",0)?>
      &nbsp;</td>
    </tr>
    <tr>
      <td class="textos_titulos">Usuario</td>
      <td> <?=$formulario->c_text("","user","","","","",0)?>
      &nbsp;</td>
    </tr>
    <tr>
      <td class="textos_titulos">Contraseña</td>
      <td><?=$formulario->c_text("","password","","","","",0)?>
      &nbsp;</td>
    </tr>
    <tr>
      <td class="textos_titulos">Grupo
      <input name="tipo" type="hidden" id="tipo" value="1" /></td>
      <td><? 
	$parametrosGrupo=array(
	"tabla"=>"groups",
	"campo1"=>"group_name",
	"campo2"=>"group_name",
	"campoid"=>"id_group",
	"condiorden"=>"id_group != 1 AND id_group != 3");
	echo $formulario->c_select("","idgroup","","","",$parametrosGrupo,0,0); ?>
      &nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center" class="textos_titulos"><input type="submit" name="ok" id="ok" value="Guardar" /></td>
    </tr>
  </table>
</div>
<p><? echo $formulario->g_form("formulario1","") ?>
</p><br /><hr><br>
<p>
<div align="center">
  <table border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
    <tr>
      <td align="center" class="textos_titulos">Nombre</td>
      <td align="center" class="textos_titulos">Usuario</td>
      <td align="center" class="textos_titulos">Contraseña</td>
      <td align="center" class="textos_titulos">Grupo</td>
      <td align="center" class="textos_titulos">Acciones</td>
    </tr>
    
<? for($i = 0 ;$i < count($seleccionar) ; $i++) { ?>
<form enctype="application/x-www-form-urlencoded" method='post' autocomplete="off">
	<tr>
    <td bgcolor="#FFFFFF"><?=$formulario->c_text("","name","","",$seleccionar[$i][name],"",0)?></td>
	<td bgcolor="#FFFFFF"><?=$formulario->c_text("","user","","",$seleccionar[$i][user],"",0)?></td>
	<td bgcolor="#FFFFFF"><?=$formulario->c_text("","password","","",$seleccionar[$i][password],"",0)?></td>
	<td bgcolor="#FFFFFF"><? 
	$parametrosGrupo=array(
	"tabla"=>"groups",
	"campo1"=>"id_group",
	"campo2"=>"group_name",
	"campoid"=>"id_group",
	"condiorden"=>"id_group != 1 AND id_group != 3");
	echo $formulario->c_select("","idgroup","","","",$parametrosGrupo,0,"",$seleccionar[$i][idgroup]); ?></td>
	<td align="center" bgcolor="#FFFFFF"><span class="textos_titulos">
	  <input name="id_nodb" type="hidden" id="tipo2" value="<?=$seleccionar[$i][id_agents]?>" />
	</span>	  <input type="submit" name="okact_nodb" id="okact_nodb" value="Actualizar" /></td>
    </tr>
</form>
<? } ?> 
    
  </table>
</div>