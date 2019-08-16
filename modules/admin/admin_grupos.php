<?

if(isset($_POST[ok])){

$mensaje = $sqlm->ins_from($_POST,"groups","ok",0);

}


if(isset($_POST[act_nodb])){

$mensaje = $sqlm->update_recs_auto("groups",$_POST,0,"id_group = $_POST[id_nodb]",0);

}



$seleccionar = $sqlm->sql_select("groups","group_name,description,id_group",1,0);
?>

<div class="textosbig" align="center">
  <h3>Administracion de Grupos de usuario</h3>
</div>
<p><br />
<? echo $formulario->g_form("formulario1","","A") ?></p>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<div align="center" class="textosbig"><?=$mensaje?></div>

<p><br />
  <br />
</p>
<div align="center">
  <table border="0" align="center" cellpadding="4" cellspacing="1" class="rounded-corners-blue">
    <tr>
      <td class="textoAzul">Nombre Grupo</td>
      <td> <?=$formulario->c_text("","group_name","","","","",0)?></td>
    </tr>
    <tr>
      <td colspan="2" class="textos_titulos"><?=$formulario->c_textarea("Descripcion","description","","","",2,40,"",0)?></td>
    </tr>
    <tr>
      <td colspan="2" align="center" class="textos_titulos"><input type="submit" name="ok" id="ok" value="Guardar" /></td>
    </tr>
  </table>
</div>
<p><? echo $formulario->g_form("formulario1","") ?>
</p><br><hr><br>
<p><div align="center">
  <table border="0" align="center" cellpadding="4" cellspacing="1" class="rounded-corners-blue">
    <tr class="textoAzul">
      <td align="center" class="textoAzul">Nombre Grupo</td>
      <td align="center" class="textoAzul">Descripcion</td>
      <td align="center" class="textoAzul">Acciones</td>
    </tr>
<? for($i=0 ; $i < count($seleccionar) ; $i++){ 
echo $formulario->g_form("formulario[$i]","","A");
?>
<form method="post" action="">
	  <tr>
      <td class="textos_titulos"><?=$formulario->c_text("","group_name","","",$seleccionar[$i]["group_name"],"",0)?></td>
     <td class="textos_titulos"><?=$formulario->c_textarea("","description","","",$seleccionar[$i]["description"],2,15,"",0)?></td>
      <td align="center" class="textos_titulos"><input name="id_nodb" type="hidden" id="tipo2" value="<?=$seleccionar[$i][id_group]?>" />
        <input type="submit" name="act_nodb" id="act_nodb" value="Guardar" /></td>
    </tr>
</form>
 <? echo $formulario->g_form("formularioedit[$i]",""); } ?>       
  </table></div></p>
</body>
</html>