<?
include("../../appcfg/cc.php");
include("../../appcfg/func_mis.php");
include("../../appcfg/js_scripts.php");
include("../../appcfg/class_sqlman.php");
include("../../appcfg/class_forms.php");
include("../../appcfg/class_autoforms.php");

//activamos los objetos
$sqlm= new Man_Mysql();

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaiz="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";
//validamos el logueo de los usuarios

$FieldParams = $sqlm->sql_select("autoform_grupos","*","id_autoformgrupos = '$_GET[idgrupo]'",0);

$ListaGroups = $sqlm->sql_select("groups","*","id_group != 1",0);

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center">
  <h3>Configuracion Avanzada para el Grupo: <?=$FieldParams[0]["labelgrupo"]?></h3></div>


<?	
	if(isset($_POST[ok_text])){
	
	//fors para los grupos y sus permisos en el formulario
	for($i=0 ; $i < count($_POST[gver]) ; $i++ ){
	
	$gruponoedit .= "|".$_POST[gver][$i];
	
	} 
	for($i=0 ; $i < count($_POST[gnover]) ; $i++ ){
	
	$gruponover .= "|".$_POST[gnover][$i];
	
	} 
	for($i=0 ; $i < count($_POST[gnoedit]) ; $i++ ){
	
	$gruponoguardaedit .= "|".$_POST[gnoedit][$i];
	
	} 
	//fors para los grupos y sus permisos en el formulario
	
	
	if($_POST[labelgrupo] != "-")		{ $cadenaconsulta .= "labelgrupo = '$_POST[labelgrupo]' ,"; }
	if($_POST[visiblegrupo] != "")		{ $cadenaconsulta .= "visiblegrupo = '$_POST[visiblegrupo]' ,"; }
	if($_POST[columnas] != "")			{ $cadenaconsulta .= "columnas = '$_POST[columnas]' ,"; }
	if($gruponoedit != "")		{ $cadenaconsulta .= "usrpermisos = '$gruponoedit' ,"; }
	if($gruponover != "")		{ $cadenaconsulta .= "usrver = '$gruponover' ,"; }
	if($gruponoguardaedit != "")	{ $cadenaconsulta .= "usredit = '$gruponoguardaedit' ,"; }
	
	$cadenaconsulta = substr($cadenaconsulta,0,-1);
	
	$cadenaconsulta .= ", nota = '$_POST[nota]'"; 
	
	$sqlm->update_regs("autoform_grupos","$cadenaconsulta","id_autoformgrupos = '$_POST[idgrupo]'",0);
	
?>
<div align="center"><br /><br /><br /><br /><br /><br /><br /><br />
 <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td class="textos_titulos" align="center">La Configuracion se guardo Correctamente </td>
      </tr>
    </table>
</div>
<?
	
	}else{
?>

<div align="center"><br />
  <br />
  <form id="form1" name="form1" method="post" action="">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td colspan="2" class="textos_titulos">Nombre</td>
      </tr>
      <tr>
        <td height="28" colspan="2" class="textosHoras"><?=$formulario->c_text("","labelgrupo","","",$FieldParams[0]["labelgrupo"],"","",15)?></td>
      </tr>
      <tr>
        <td height="28" colspan="2" class="textos_titulos">Numero de Colunas</td>
      </tr>
      <tr>
        <td height="28" colspan="2" class="textosHoras"><?=$formulario->c_text("","columnas","","",$FieldParams[0]["columnas"],"","",15)?></td>
      </tr>
      <tr>
        <td colspan="2" class="textos_titulos">Nota</td>
      </tr>
      <tr>
        <td colspan="2"><textarea name="nota" cols="50" rows="5" id="nota"><?=$FieldParams[0]["nota"]?></textarea></td>
      </tr>
      <tr>
        <td class="textos_titulos"><input name="visiblegrupo" type="radio" id="radio" value="1" checked="checked" />
        <label for="visiblegrupo" class="textos">Visible</label></td>
        <td><span class="textos_titulos">
          <input type="radio" name="visiblegrupo" id="radio2" value="0" />
          <label for="visiblegrupo2" class="textos">Oculto</label>
        </span></td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="textos_titulos">Configuracion de Grupos</td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="textos_titulos"><table width="0" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="textos_titulos">Grupo</td>
            <td class="textos_titulos">No Editable</td>
            <td class="textos_titulos">No Visible</td>
            <td class="textos_titulos">Guardar Pero no Editable</td>
          </tr>
<? 

for($i = 0 ;$i < count($ListaGroups) ; $i++) { 

$PermisosVer = $sqlm->sql_select("autoform_grupos","usrpermisos,usrver,usredit","id_autoformgrupos = '".$_GET[idgrupo]."' ",0);

	$VerNoverARR 	= 	explode("|",$PermisosVer[0][usrpermisos]);
	$PermisosARR 	= 	explode("|",$PermisosVer[0][usrver]);
	$NoEditARR 		= 	explode("|",$PermisosVer[0][usredit]);

for($o=0 ; $o < count($VerNoverARR) ; $o++){//este es el final del for

if ( $VerNoverARR[$o] == $ListaGroups[$i][id_group]){ $CkeckVer = "checked='checked'"; $o = count($VerNoverARR); }else { $CkeckVer = ""; 	}

} //este es el final del for

for($o=0 ; $o < count($PermisosARR) ; $o++){//este es el final del for

if ( $PermisosARR[$o] == $ListaGroups[$i][id_group]){ $CkeckNoVer = "checked='checked'"; $o = count($PermisosARR); }else { $CkeckNoVer = ""; 	}

} //este es el final del for

for($o=0 ; $o < count($NoEditARR) ; $o++){//este es el final del for

if ( $NoEditARR[$o] == $ListaGroups[$i][id_group]){ $CkeckNoEdit = "checked='checked'"; $o = count($NoEditARR); }else { $CkeckNoEdit = ""; 	}

} //este es el final del for


?>
          <tr>
            <td><?=$ListaGroups[$i][group_name]?>&nbsp;</td>
            <td align="center"><input name="gver[]" type="checkbox" id="gver[]" <?=$CkeckVer?> value="<?=$ListaGroups[$i][id_group]?>" /></td>
            <td align="center"><input name="gnover[]" type="checkbox" id="gnover[]" <?=$CkeckNoVer?> value="<?=$ListaGroups[$i][id_group]?>" /></td>
            <td align="center"><input name="gnoedit[]" type="checkbox" id="gnoedit[]" <?=$CkeckNoEdit?> value="<?=$ListaGroups[$i][id_group]?>" /></td>
          </tr>
<? } ?> 
        </table></td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="textos_titulos"><input type="submit" name="ok_text" id="ok_text" value="Guardar" />
        <input name="idgrupo" type="hidden" id="idgrupo" value="<?=$_GET[idgrupo]?>" /></td>
      </tr>
    </table>
  </form>
</div>


<? } // sino guardamos muestra el form ?>

</body>
</html>