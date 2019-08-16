<link rel="stylesheet" type="text/css" href="css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>

<div class="box_menu">
<h2>
<div><a href="<?="$RAIZHTTP/index.php"?>"><img src="jpg/logoweb.png" width="163" height="50" /></a></div>
<div style="float:right; position:absolute; right:10px; top:15px"><img src="imgs/logocliente.png" width="163" height="50" /></div>

<div style="margin-top:-30px ; margin-left:170px;"> - by: <a href="http://www.parasuempresa.com" target="_blank">p a r a s u e m p r e s a</a></div> 

</h2>
</div>

<? //print_r($_GET);
if($_GET[mensaje] == 1){ 
?>
<div align="center">
<div align="center" style="width:500px" class="rounded-corners-ALERTA"><span class="textosbigBlanco">Clave / Usuario o Codigo incorrectos</span></div>
</div>
<? } ?>
<div class="LoginHome">
  <form id="form1" name="form1" method="post" action="index.php">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
<!--      <tr>
        <td class="textosbigBlancoSmall">Idioma</td>
        <td><div align="center" class="linkbotones"><a class="linkbotones" href="?lan=es">Español</a> | <a class="linkbotones"  href="?lan=en_US">English</a></div></td>
      </tr>
-->
      <tr>
        <td class="textosbigBlancoSmall">Nombre de Usuario</td>
        <td><label for="textfield"></label>
        <input name="user" type="text" class="textosHoras" id="textfield" /></td>
      </tr>
      <tr>
        <td class="textosbigBlancoSmall">Contraseña</td>
        <td><label for="textfield2"></label>
        <input name="password" type="password" class="textosHoras" id="textfield2" /></td>
      </tr>
<?
$capcha = 1;
if($capcha == 1){ // aquegamos el capcha al loguin 

?>

      <tr>
        <td align="center" class="textosbigBlancoSmall">Ingrese El Codigo</td>
        <td align="center" class="textosbigBlanco">
        <img src="libs/imgcapcha.php"/><br>
        <input name="codigo" type="text" class="textosHoras" id="textfield" />
        </td>
      </tr>
      
<? } // --------------- aquegamos el capcha al loguin ?>
      <tr>
        <td colspan="2" align="center" class="textosbigBlanco"><input name="in" type="submit" class="botones" id="in" value="Entrar" /></td>
      </tr>
    </table>
    
    <? if($_GET[test] == 1){ 
	
	$consultaDB = mysql_query("SHOW DATABASES");

	?>
    
    <div align="center">Seleccione la base de datos <select name="DB_name">
    
    <? 	while ($row = mysql_fetch_array($consultaDB)) { 
	
	if(substr($row['Database'],0,6) == "octres"){
	
	?>
    <option value="<?=$row['Database']?>"><?=$row['Database']?></option>
	<? } } ?>
    </select></div>
    
    <? 
	
	} 
	
	?>
    
  </form>
</div>
 <div class="reference_div">
       <span class="reference">
                <a href="">&copy; parasuempresa.com | Open C3 - GNU Project</a>
       </span>
 </div>
