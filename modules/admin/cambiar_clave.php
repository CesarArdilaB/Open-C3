<?

$JsScripts->ValFormScripts();


if(isset($_POST[act_nodb])){

$mensaje = $sqlm->update_recs_auto("agents",$_POST,0,"id_agents = $_POST[idusuario_nodb]",0);

$mensaje = "Password Actualizado";

}

$UserData = $sqlm->sql_select("agents","password,id_agents","id_agents = '$_SESSION[user_ID]'",0);
?>

<div class="textosbig" align="center">
  <h3>Cambiar Password</h3>
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
  <table width="0" border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-gray">
    <tr>
      <td colspan="2" align="center" class="textos_titulos"><?=$mensaje?>&nbsp;</td>
    </tr>
    <tr>
      <td class="textos_titulos">Password Actual</td>
      <td><input name="actpass_nodb" type="hidden" id="actpass_nodb" value="<?=$UserData[0][password]?>" />
        <input name="claveact_nodb" class=":required :same_as;actpass_nodb" type="password" id="claveact_nodb" /></td>
    </tr>
    <tr>
      <td class="textos_titulos">Nuevo Password</td>
      <td><input name="newpass_nodb" type="password" id="newpass_nodb" class=":required"/></td>
    </tr>
    <tr>
      <td class="textos_titulos">Confirmar Password</td>
      <td><input name="password" type="password" id="password" class=":required :same_as;newpass_nodb"/></td>
    </tr>
    <tr>
      <td colspan="2" align="center" class="textos_titulos"><input type="submit" name="act_nodb" id="act_nodb" value="Guardar" />
        <input name="idusuario_nodb" type="hidden" id="idusuario" value="<?=$UserData[0][id_agents]?>" /></td>
    </tr>
  </table>
</div>
<p><? echo $formulario->g_form("formulario1","") ?>
</p>
</body>
</html>