<? 
session_start();

include("../../appcfg/general_config.php");

if($_GET[si]==1){
	
	$Borrar = mysql_query("DELETE FROM importdata WHERE id_importdata = '$_GET[idplantilla]'");
		
				}
?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<meta charset="utf-8">
	
<div class="textosbig" align="center">
  <h3>Eliminar Plantilla</h3>
</div>
<br />
<? if($_GET[si]==1){ ?>
<div align="center">
  <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-gray">
    <tr>
      <td class="rounded-corners-orange"><div align="center" class="textosbigBlanco">Se Elimino La Plantilla. </div></td>
    </tr>
  </table>
</div>
<? }else{ ?>
<table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-gray">
  <tr>
    <td class="rounded-corners-ALERTA"><div align="center" class="textosbigBlanco">Esta Seguro que desea eliminar esta plantilla? esta acción no se podrá deshacer.</div></td>
  </tr>
  <tr>
    <td align="center"><a href="import_data_delete.php?si=1&amp;idplantilla=<?=$_GET[idplantilla]?>">Si</a> - esc para No</td>
  </tr>
</table>
<? } ?>