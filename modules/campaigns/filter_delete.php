<? 
session_start();

if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1){ 
include '../../appcfg/general_config.php';


$DataFiltro = $sqlm->sql_select("filter_config","*","id_filter = '$_GET[idfiltro]'",0);

//print_r($DataFiltro);


?>
<br><br><br><br><br><br>
<div align="center" style="width:500px">

<table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-gray">
  <tr>
    <td class="rounded-corners-ALERTA"><div align="center" class="textosbigBlanco">
    Seguro quiere eliminar el filtro: <?=$DataFiltro[0][nombre]?> ?
    </div></td>
  </tr>
  <tr>
    <td align="center">
    
    <input type="submit" onclick="EnviarLinkJ('ConfigReport','modules/campaigns/filter_delete.php?op=1&idfiltro=<?=$_GET[idfiltro]?>&idcam=<?=$DataFiltro[0][idcam]?>','este')" name="button" id="button" value="Si" />
-
	<input type="submit" onclick="EnviarLinkJ('ConfigReport','modules/campaigns/filter_conditions.php?idform=<?=$DataFiltro[0][idform]?>&idfiltro=<?=$_GET[idfiltro]?>','este')" name="button2" id="button2" value="No" /></td>
  </tr>
</table>

</div>
<?
}if($_GET[op] == 1){
	
include '../../appcfg/general_config.php';
	
	$eliminar1 = mysql_query("DELETE FROM filter_config WHERE id_filter = '$_GET[idfiltro]'");
	$eliminar2 = mysql_query("DELETE FROM filter_camposm WHERE idfiltro = '$_GET[idfiltro]'");
	$eliminar3 = mysql_query("DELETE FROM firter_asign WHERE idfiltro = '$_GET[idfiltro]'");
	$eliminar4 = mysql_query("DELETE FROM firter_conditions WHERE idrelconfig = '$_GET[idfiltro]'");	
?>
<script>
EnviarLinkJ('MuestraReportes','modules/campaigns/filter_config.php?op=2&idcampaign=<?=$_GET[idcam]?>');
</script>
<br><br><br><br><br><br>
<div align="center" style="width:500px">

  <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-gray">
    <tr>
      <td class="rounded-corners-orange"><div align="center" class="textosbigBlanco">Se Elimino el Filtro. </div></td>
    </tr>
  </table>

</div>

<? } ?>