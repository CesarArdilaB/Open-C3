
<? 
session_start();
include '../../appcfg/general_config.php';
require '../../appcfg/class_reports.php';

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">

<? if(!$_POST[ok]){ ?>

<form action="" method="post" enctype="multipart/form-data" name="form1">
  <div align="center">
    <p>&nbsp;</p>
    <table border="0" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Subir Archivo para emportar</td>
      </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF"><input type="file" name="archivo" id="archivo"></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF"><input name="idcron" type="hidden" id="idcron" value="<?=$_GET[idcron]?>">
        <input type="submit" name="ok" id="ok" value="Guardar"></td>
      </tr>
    </table>
  </div>
</form>

<? }else{ 

$prefile = date("smhj");

$copiar=copy($_FILES[archivo][tmp_name],"../../tmp/files/".$prefile.$_FILES[archivo][name])or die("No esta copiando verifique permisos"); //copiamos el archivo csv y lo dejamos pendiente para eliminarlo despues de subir la data

$sqlm->update_regs("cron_import","nombre_archivo = '".$prefile.$_FILES[archivo][name]."'","id_cronimport = '$_POST[idcron]'",0);

?>
	
<p>&nbsp;</p>
  	<div align="center" class="rounded-corners-orange textosbig">
    
	<br />
	Archivo Cargado Correctamente 
    <br />
<br />
  	
    </div>

<? } ?>