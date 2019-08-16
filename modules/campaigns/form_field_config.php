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

$FieldParams = $sqlm->sql_select("autoform_config","*","nombrecampo = '$_GET[fname]'",0);

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center"><h3>Configuracion Avanzada para el Campo: <?=$FieldParams[0]["labelcampo"]?></h3></div>
<?  // seccion de eliminar campos
if(isset($_POST[del_DEF])){

	$sqlm->update_regs("autoform_config","eliminado = 1","nombrecampo = '$_POST[idfield]'",0);

?>	
	
<div align="center"><br /><br /><br /><br /><br /><br /><br /><br />
 <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td class="textos_titulos" align="center">El Campo Fue Eliminado</td>
      </tr>
    </table>
</div>
	
<? exit;					}

if(isset($_POST[del_campo])){ ?>
<br><br><br><br><br>
<div align="center" class="textosbig">esta seguro que desea eliminar el campo <?=$FieldParams[0]["labelcampo"]?>? <br> tenga en cuenta que si confirma esta accion la informacion almacenada en el mismo no se podra recuperar.</div>
<br><br>
<form id="formdel" name="form1" method="post" action="">
<div align="center" class="textosbig">para eliminar haga click en <input type="submit" name="del_DEF" id="del" value="ELIMINAR" /> de lo contrario cierre esta ventana</div>
<input name="idfield" type="hidden" id="idfield" value="<?=$_POST[idfield]?>" />
</form>

<?	}
else{ //empieza el else de eliminar campos

			if ($FieldParams[0]["tipocampo"] == "text" or $FieldParams[0]["tipocampo"] == "textarea") {
				

	
	if(isset($_POST[ok_text])){
	
	
	if($_POST[idgrupo] != "-"){ $cadenaconsulta .= "idgrupo = '$_POST[idgrupo]' ,"; }
	
	if($_POST[labelcampo] != "-"){ $cadenaconsulta .= "labelcampo = '$_POST[labelcampo]' ,"; }
	
	if($_POST[historial] != ""){ $cadenaconsulta .= "historial = '$_POST[historial]' , generado = 0,"; }
	
	if($_POST[unico] != ""){ $cadenaconsulta .= "unico = '$_POST[unico]' ,"; }
	
	if($_POST[largo] != ""){ $cadenaconsulta .= "largo = '$_POST[largo]' ,"; }
	
	if($_POST[telefono] != ""){ $cadenaconsulta .= "telefono = '$_POST[telefono]' ,"; }

	if($_POST[mascara] != ""){ $cadenaconsulta .= "mascara = '$_POST[mascara]' ,"; }

	if($_POST[tipoval] == ":float" and $caracteresn != ""){$cadenaVal .= "$_POST[tipoval] :length;$_POST[caracteresn]";}
	
	if($_POST[tipoval] == ":email"){ $cadenaVal .= $_POST[tipoval]; }
	
	
	$cadenaVal .= " $_POST[requerido]";
	
	$sqlm->update_regs("autoform_config","$cadenaconsulta requerido = '".$cadenaVal."',mascara = '$_POST[mascara]'","nombrecampo = '$_POST[idfield]'",0);
	
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
  <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td colspan="2" class="textos_titulos">Nombre</td>
      </tr>
      <tr>
        <td colspan="2" class="textosHoras"><?=$formulario->c_text("","labelcampo","","",$FieldParams[0]["labelcampo"],"","",25)?></td>
      </tr>
      <tr>
        <td colspan="2" class="textosHoras">Campo historial <span class="textos">
          <input name="historial" type="checkbox" id="checkbox2" value="1" />
        si chekea este campo quedara guardando<br />
un historial de los diferentes cambios que tenga.</span></td>
      </tr>
      <tr>
        <td colspan="2" class="textos_titulos">Validacion</td>
      </tr>
      <tr>
        <td class="textos_titulos"><span class="textos">Campo Numerico</span></td>
        <td><span class="textos">
          <input type="radio" name="tipoval" id="radio" value=":float" />        
        </span></td>
      </tr>
      <tr>
        <td class="textos_titulos"><span class="textos">Numero de Caracteres</span></td>
        <td valign="middle" class="textos_titulos">          <span class="textos">
          <input name="caracteresn" type="text" id="caracteresn" size="2" />
          * 
          (opcional)</span></td>
      </tr>
      <tr>
        <td class="textos_titulos"><span class="textos">Campo Email</span></td>
        <td><span class="textos">
          <input type="radio" name="tipoval" id="radio2" value=":email" />
        </span></td>
      </tr>
      <tr>
        <td class="textos_titulos"><span class="textos">Requerido</span></td>
        <td><span class="textos">
          <input name="requerido" type="checkbox" id="checkbox" value=":required" />        
        </span></td>
      </tr>
      <tr>
        <td align="left" class="textos_titulos">Campo de Telefono</td>
        <td align="left"><input name="telefono" type="checkbox" id="checkbox8" value="1" /></td>
      </tr>
      <tr>
        <td align="left" class="textos_titulos">Unico </td>
        <td align="left"><input name="unico" type="checkbox" id="checkbox4" value="1" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle" class="textos_titulos">Campo Encriptado</td>
        <td align="left" valign="middle" class="textos"><input name="mascara" type="checkbox" id="mascara" value="1" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle" class="textos_titulos">Grupo</td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="textos_titulos"><? $parametrosGrupoHerr=array(
	"tabla"=>"autoform_grupos",
	"campo1"=>"labelgrupo",
	"campo2"=>"labelgrupo",
	"campoid"=>"id_autoformgrupos",
	"condiorden"=>"idtabla_rel = '".$FieldParams[0]["idtabla_rel"]."'");
	echo $formulario->c_select("Grupo Del Campo","idgrupo","","textos","",$parametrosGrupoHerr,0,"",$FieldParams[0]["idgrupo"]); ?></td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="textos_titulos">Largo</td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="textos_titulos"><span class="textosHoras">
          <?=$formulario->c_text("","largo","","",15,"","",25)?>
        </span></td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="textos_titulos"><input type="submit" name="ok_text" id="ok_text" value="Guardar" />
          <input type="submit" name="del_campo" id="del" value="Eliminar" />
        <input name="idfield" type="hidden" id="idfield" value="<?=$_GET[fname]?>" /></td>
      </tr>
    </table>
  </form>
</div>


<? } // sino guardamos muestra el form
			}//termina if para text y textarea
    
	elseif( $FieldParams[0]["tipocampo"] ==  "autocom" or $FieldParams[0]["tipocampo"] ==  "select" ){

// aqui configuramos los campos de autocompletar y de seleccion

		if(isset($_POST[ok_autoselect])){

			if($_FILES[archivo][name] != ""){ //esta es la parte de subida de archivos
	
				$arrCampos[]=array("nombrec" => "field1" , "tipoc" => "VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL");
				$arrCampos[]=array("nombrec" => "field2" , "tipoc" => "VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL");
				$arrCampos[]=array("nombrec" => "id_".$_POST[idfield] , "tipoc" => "INT NOT NULL AUTO_INCREMENT PRIMARY KEY");
				$arrCampos[]=array("nombrec" => "inactivo" , "tipoc" => "INT NOT NULL");


				$sqlm->sql_creatabla("autof_".$_POST[idfield],$arrCampos,0);

//aqui insertamos la configuracion de la tabla para el manejador de formularios
				
				$sqlm->inser_data("autoform_tablas","labeltabla,nombretabla,campoid,tipotabla,descripcion","'$labelcampo base','autof_".$_POST[idfield]."','id_".$_POST[idfield]."',2,'Tabla de campo generada automaticamente.'");
				$maxidtabla=$sqlm->sql_select("autoform_tablas","MAX(id_autoformtablas) as idultimo","1");
				$sqlm->inser_data("autoform_grupos","labelgrupo,posiciongrupo,visiblegrupo,columnas,idtabla_rel","'General',0,1,1,'".$maxidtabla[0][idultimo]."'");
				$maxidgrupo=$sqlm->sql_select("autoform_grupos","MAX(id_autoformgrupos) as idultimo","1");
				$sqlm->inser_data("autoform_config","labelcampo,nombrecampo,poscampo,tipocampo,requerido,historial,largo,idgrupo,idtabla_rel","'Campo 1','field1',0,'text',0,0,15,'".$maxidgrupo[0][idultimo]."','".$maxidtabla[0][idultimo]."'");
				$sqlm->inser_data("autoform_config","labelcampo,nombrecampo,poscampo,tipocampo,requerido,historial,largo,idgrupo,idtabla_rel","'Campo 2','field2',1,'text',0,0,15,'".$maxidgrupo[0][idultimo]."','".$maxidtabla[0][idultimo]."'");

//aqui insertamos la configuracion de la tabla para el manejador de formularios

				if($_POST[columnas] == 1){ $campostabla=array("field1"); $camposmostrar="id_".$_POST[idfield].",field1"; }
				if($_POST[columnas] == 2){ $campostabla=array("field1" , "field2"); $camposmostrar="field2,field1"; }


	//print_r($_FILES);

				$copiar=copy($_FILES[archivo][tmp_name],"../../tmp/files/".$_FILES[archivo][name])or die("No esta copiando verifique permisos"); //copiamos el archivo csv y lo dejamos pendiente para eliminarlo despues de subir la data
				$filedb = fopen("../../tmp/files/".$_FILES[archivo][name],"r");
	
				$sqlm->subir_csv("autof_".$_POST[idfield],$filedb,$campostabla,0);
	
				unlink("/tmp/files/".$_FILES[archivo][name]);
				
				$cadenaconsulta .= "paramcampo = '"."autof_".$_POST[idfield].",$camposmostrar,id_".$_POST[idfield].",inactivo = 0' ,";
	
								} //esta es la parte de subida de archivos

			if($_POST[historial] != ""){ $cadenaconsulta .= "historial = '$_POST[historial]' ,"; }
			if($_POST[idgrupo] != "-"){ $cadenaconsulta .= "idgrupo = '$_POST[idgrupo]' ,"; }
			if($_POST[unico] != ""){ $cadenaconsulta .= "unico = '$_POST[unico]' ,"; }
			if($_POST[labelcampo] != "-"){ $cadenaconsulta .= "labelcampo = '$_POST[labelcampo]' ,"; }
			$cadenaVal .= " $_POST[requerido]";
	
	$sqlm->update_regs("autoform_config","$cadenaconsulta requerido = '".$cadenaVal."'","nombrecampo = '$_POST[idfield]'",0);
	
?>
<div align="center"><br /><br /><br /><br /><br /><br /><br /><br />
 <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td class="textos_titulos" align="center">La Configuracion se guardo Correctamente </td>
      </tr>
    </table>
</div>
<?
exit;	
	}
	
?>

<div align="center"><br />
  <br />
  <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td colspan="2" class="textos_titulos">Nombre</td>
      </tr>
      <tr>
        <td colspan="2" class="textosHoras"><?=$formulario->c_text("","labelcampo","","",$FieldParams[0]["labelcampo"],"","",25)?></td>
      </tr>
      <tr>
        <td colspan="2" class="textos_titulos"><span class="textos">Campo historial <span class="textos">
        <input name="historial" type="checkbox" id="checkbox3" value="1" />
si chekea este campo quedara <br> guardando un historial de los diferentes cambios que tenga.</span></span></td>
      </tr>
      <tr>
        <td colspan="2" class="textos_titulos">Archivos de datos</td>
      </tr>
      <tr>
        <td class="textos"><p>
        <label for="archivo"></label>
        Busque el archivo de datos  para este campo
        <br />        
        <input name="archivo" type="file" id="archivo" size="1" />
        <br />
        este archivo debe ser un csv separado por comas. ej: Nombres, Identificacion</p></td>
        <td class="textospadding"><a href="form_field_select_config.php?fname=<?=$_GET[fname]?>">Editar Datos</a></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle" class="textos">Una Columna 
          <input name="columnas" type="radio" id="radio3" value="1" checked="checked" />
        - Dos Columnas 
        <label for="columnas">
          <input type="radio" name="columnas" id="radio4" value="2" />
        </label></td>
      </tr>
      <tr>
        <td colspan="2" class="textos_titulos">Validacion</td>
      </tr>
      <tr>
        <td class="textos_titulos"><span class="textos">Requerido</span></td>
        <td><span class="textos">
          <input name="requerido" type="checkbox" id="checkbox" value=":required" />        
        </span></td>
      </tr>
      <tr>
        <td align="left" class="textos_titulos">Unico</td>
        <td align="left"><input name="unico" type="checkbox" id="checkbox5" value="1" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="textos_titulos">Grupo</td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="textos_titulos"><? $parametrosGrupoHerr=array(
	"tabla"=>"autoform_grupos",
	"campo1"=>"labelgrupo",
	"campo2"=>"labelgrupo",
	"campoid"=>"id_autoformgrupos",
	"condiorden"=>"idtabla_rel = '".$FieldParams[0]["idtabla_rel"]."'");
	echo $formulario->c_select("Grupo Del Campo","idgrupo","","textos","",$parametrosGrupoHerr,0,"",$FieldParams[0]["idgrupo"]); ?></td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="textos_titulos"><input type="submit" name="ok_autoselect" id="ok_autoselect" value="Guardar" />
          <input type="submit" name="del_campo" id="del" value="Eliminar" />
          <input name="idfield" type="hidden" id="idfield" value="<?=$_GET[fname]?>" /></td>
      </tr>
    </table>
  </form>
</div>

<? }

     	elseif($FieldParams[0]["tipocampo"] ==  "check"){
  
// aqui configuramos los campos de checkbox

		if(isset($ok_fecha)){

			if($_POST[historial] != ""){ $cadenaconsulta .= "historial = '$_POST[historial]' ,"; }
			if($_POST[idgrupo] != "-"){ $cadenaconsulta .= "idgrupo = '$_POST[idgrupo]' ,"; }
			if($_POST[unico] != ""){ $cadenaconsulta .= "unico = '$_POST[unico]' ,"; }
			if($_POST[labelcampo] != "-"){ $cadenaconsulta .= "labelcampo = '$_POST[labelcampo]' ,"; }
			$cadenaVal .= "$_POST[requerido]";
	
	$sqlm->update_regs("autoform_config","$cadenaconsulta requerido = '".$cadenaVal."'","nombrecampo = '$idfield'",0);
	
?>
<div align="center"><br /><br /><br /><br /><br /><br /><br /><br />
 <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td class="textos_titulos" align="center">La Configuracion se guardo Correctamente </td>
      </tr>
    </table>
</div>
<?
exit;	
	
	}
	
?>

<div align="center"><br />
  <br />
  <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td colspan="2" class="textos_titulos">Nombre</td>
      </tr>
      <tr>
        <td colspan="2" class="textosHoras"><?=$formulario->c_text("","labelcampo","","",$FieldParams[0]["labelcampo"],"","",25)?></td>
      </tr>
      <tr>
        <td colspan="2" class="textos_titulos"><span class="textos">Campo historial <span class="textos">
        <input name="historial" type="checkbox" id="checkbox3" value="1" />
si chekea este campo quedara <br />
guardando
un historial de los diferentes cambios que tenga.</span></span></td>
      </tr>
      <tr>
        <td colspan="2" class="textos_titulos">Validacion</td>
      </tr>
      <tr>
        <td class="textos_titulos"><span class="textos">Requerido</span></td>
        <td><span class="textos">
          <input name="requerido" type="checkbox" id="checkbox" value=":accept" />        
        </span></td>
      </tr>
      <tr>
        <td align="left" class="textos_titulos">Unico</td>
        <td align="left"><input name="unico" type="checkbox" id="checkbox6" value="1" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="textos_titulos">Grupo</td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="textos_titulos"><? $parametrosGrupoHerr=array(
	"tabla"=>"autoform_grupos",
	"campo1"=>"labelgrupo",
	"campo2"=>"labelgrupo",
	"campoid"=>"id_autoformgrupos",
	"condiorden"=>"idtabla_rel = '".$FieldParams[0]["idtabla_rel"]."'");
	echo $formulario->c_select("Grupo Del Campo","idgrupo","","textos","",$parametrosGrupoHerr,0,"",$FieldParams[0]["idgrupo"]); ?></td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="textos_titulos"><input type="submit" name="ok_fecha" id="ok_fecha" value="Guardar" />
          <input type="submit" name="del_campo" id="del" value="Eliminar" />
          <input name="idfield" type="hidden" id="idfield" value="<?=$_GET[fname]?>" /></td>
      </tr>
    </table>
  </form>
</div>


<?
		}


elseif($FieldParams[0]["tipocampo"] ==  "fecha"){

// aqui configuramos los campos de fecha

		if(isset($_POST[ok_fecha])){

			if($_POST[historial] != ""){ $cadenaconsulta .= "historial = '$_POST[historial]' ,"; }
			if($_POST[idgrupo] != "-"){ $cadenaconsulta .= "idgrupo = '$_POST[idgrupo]' ,"; }
			if($_POST[labelcampo] != "-"){ $cadenaconsulta .= "labelcampo = '$_POST[labelcampo]' ,"; }
			if($_POST[unico] != ""){ $cadenaconsulta .= "unico = '$_POST[unico]' ,"; }

			$cadenaVal .= " $_POST[requerido]";
	
	$sqlm->update_regs("autoform_config","$cadenaconsulta requerido = '".$cadenaVal."'","nombrecampo = '$_POST[idfield]'",0);
	
?>
<div align="center"><br /><br /><br /><br /><br /><br /><br /><br />
 <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td class="textos_titulos" align="center">La Configuracion se guardo Correctamente </td>
      </tr>
    </table>
</div>
<?
exit;	
	}
	
?>

<div align="center"><br />
  <br />
  <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td colspan="2" class="textos_titulos">Nombre</td>
      </tr>
      <tr>
        <td colspan="2" class="textosHoras"><?=$formulario->c_text("","labelcampo","","",$FieldParams[0]["labelcampo"],"","",25)?></td>
      </tr>
      <tr>
        <td colspan="2" class="textos_titulos"><span class="textos">Campo historial <span class="textos">
        <input name="historial" type="checkbox" id="checkbox3" value="1" />
si chekea este campo quedara <br> guardando un historial de los diferentes cambios que tenga.</span></span></td>
      </tr>
      <tr>
        <td colspan="2" class="textos_titulos">Validacion</td>
      </tr>
      <tr>
        <td class="textos_titulos"><span class="textos">Requerido</span></td>
        <td><span class="textos">
          <input name="requerido" type="checkbox" id="checkbox" value=":required" />        
        </span></td>
      </tr>
      <tr>
        <td align="left" class="textos_titulos">Unico</td>
        <td align="left" class="textos"><input name="unico" type="checkbox" id="checkbox7" value="1" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="textos_titulos">Grupo</td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="textos_titulos"><? $parametrosGrupoHerr=array(
	"tabla"=>"autoform_grupos",
	"campo1"=>"labelgrupo",
	"campo2"=>"labelgrupo",
	"campoid"=>"id_autoformgrupos",
	"condiorden"=>"idtabla_rel = '".$FieldParams[0]["idtabla_rel"]."'");
	echo $formulario->c_select("Grupo Del Campo","idgrupo","","textos","",$parametrosGrupoHerr,0,"",$FieldParams[0]["idgrupo"]); ?></td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="textos_titulos"><input type="submit" name="ok_fecha" id="ok_fecha" value="Guardar" />
          <input type="submit" name="del_campo" id="del" value="Eliminar" />
          <input name="idfield" type="hidden" id="idfield" value="<?=$_GET[fname]?>" /></td>
      </tr>
    </table>
  </form>
</div>

<?
}
							
								}//termina el else de eliminar campos

?>