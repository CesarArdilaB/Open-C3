<? 
session_start();

if($op != 1 and $op != 2 and $op != 3and $op != 4 and $op != 5 and $op != 6 and $addcampo != 1){ 
include '../../appcfg/general_config.php';


$DataFiltro = $sqlm->sql_select("rep_config","*","id_filter = '$_GET[idfiltro]'",0);

//print_r($DataFiltro);


?>
<br><br><br><br><br><br>
<div align="center" style="width:500px">

<table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-gray">
  <tr>
    <td class="rounded-corners-ALERTA"><div align="center" class="textosbigBlanco">
    Seguro quiere eliminar el reporte: <?=$DataFiltro[0][nombre]?> ?
    </div></td>
  </tr>
  <tr>
    <td align="center">
    
    <input type="submit" onclick="EnviarLinkJ('ConfigReport','modules/reports/rep_delete.php?op=1&idfiltro=<?=$_GET[idfiltro]?>&idcam=<?=$DataFiltro[0][idcam]?>','este')" name="button" id="button" value="Si" />
-
	<input type="submit" onclick="EnviarLinkJ('ConfigReport','modules/reports/rep_conditions.php?idform=<?=$DataFiltro[0][idform]?>&idfiltro=<?=$_GET[idfiltro]?>','este')" name="button2" id="button2" value="No" /></td>
  </tr>
</table>

</div>
<?
}if($op == 1){
	
include '../../appcfg/general_config.php';
	
	$DataPageModule = $sqlm->sql_select("page_modules","*","module_file = 'rep_vewer&repid=".$_GET[idfiltro]."'",0);
	if(is_array($DataPageModule)){
	$eliminarM1 = mysql_query("DELETE FROM page_modules WHERE id_page_module = '".$DataPageModule[0][id_page_module]."'");
	$eliminarM2 = mysql_query("DELETE FROM module_permissions WHERE id_page = '".$DataPageModule[0][id_page_module]."'");
	}
	
	$eliminar1 = mysql_query("DELETE FROM rep_config WHERE id_filter = '$_GET[idfiltro]'");
	$eliminar2 = mysql_query("DELETE FROM rep_camposm WHERE idfiltro = '$_GET[idfiltro]'");
	$eliminar3 = mysql_query("DELETE FROM rep_asign WHERE idfiltro = '$_GET[idfiltro]'");
	$eliminar4 = mysql_query("DELETE FROM rep_conditions WHERE idrelconfig = '$_GET[idfiltro]'");	
	
	$eliminaVista = mysql_query("DROP VIEW vista_rep_".$_GET[idfiltro]);
	
?>
<script>
EnviarLinkJ('MuestraReportes','modules/reports/rep_config.php?op=2&idcampaign=<?=$_GET[idcam]?>');
</script>
<br><br><br><br><br><br>
<div align="center" style="width:500px">

  <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-gray">
    <tr>
      <td class="rounded-corners-orange"><div align="center" class="textosbigBlanco">Se Elimino el Reporte. </div></td>
    </tr>
  </table>

</div>

<? } ?>