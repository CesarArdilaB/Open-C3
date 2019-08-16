<? 
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1 and $_GET[importar] != 1 and $_POST[impop] != 1){ 
?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center">
  <h3>Programar Descarga Automatica de Reportes</h3>
</div>
<br>
<table border="0" align="center" cellpadding="0" cellspacing="2"  class="rounded-corners-gray">
  <tr>
    <td valign="top" bgcolor="#FFFFFF" class="textos_titulos">Seleccione una campana</td>
    <td valign="top" bgcolor="#FFFFFF"><? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"1",
	"direccion"=>"modules/cronjobs/descarga_reportes.php?op=1");
	echo $formulario->select_envia_link("","id_campaign","","","",$parametrosGrupoHerr,0,"","ListaForms"); ?>
    &nbsp;</td>
    <td valign="top" bgcolor="#FFFFFF" class="textos_titulos">Seleccione Un Formulario</td>
    <td valign="top" bgcolor="#FFFFFF"><div id="ListaForms"></div></td>
  </tr>
  <tr>
    <td colspan="4" valign="top" bgcolor="#FFFFFF" class="textos_titulos">Seleccione un reporte</td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="top"><div id="ListaPlantilla"></div></td>
  </tr>
</table>
<? }
if($_GET[op] == 1){ 
include '../../appcfg/general_config.php';
?>


<? $parametrosGrupoHerr=array(
	"tabla"=>"autoform_tablas",
	"campo1"=>"labeltabla",
	"campo2"=>"labeltabla",
	"campoid"=>"id_autoformtablas",
	"condiorden"=>"campaignid = '$_POST[varid]'",
	"direccion"=>"modules/cronjobs/descarga_reportes.php?op=2");
	echo $formulario->select_envia_link("","id_form","","","",$parametrosGrupoHerr,0,"","ListaPlantilla"); ?>
    
    
<? } 
if($_GET[op] == 2){ 
include '../../appcfg/general_config.php';

$ExpCampos = $sqlm->sql_select("repdina_config","*","id_form  = '$_POST[varid]'",0);

?>
<form name="form1" onsubmit="EnviarLinkForm('ListaProgramas','<?=$RAIZHTTP?>/modules/cronjobs/descarga_reportes.php?op=3&idform=<?=$_POST[varid]?>',this);return false;">
  
  
  <table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
 
    <? for($o=0 ; $o < count($ExpCampos) ; $o++ ){ ?>
    
    <tr>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$ExpCampos[$o][nombre]?></td>
      <td align="center" bgcolor="#FFFFFF" class="textospadding"><input type="radio" name="repSel" id="radio" value="<?=$ExpCampos[$o][id_rep]?>"></td>
    </tr>
    
    <? } ?>
    
    <tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF" class="textospadding"><table border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td class="textos_negros">Fecha</td>
          <td><?=$formulario->c_fecha_input("","fecha_prog","","")?>          </td>
          <td class="textos_negros">Hora</td>
          <td><select name="hora" id="hora">
<option value="0" selected="selected">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
          </select></td>
          <td class="textos_titulos">Mail Notificar</td>
          <td><input type="text" name="mail_notif" id="mail_notif" /></td>
          <td rowspan="2"><input type="submit" name="button" id="button" value="Guardar"></td>
        </tr>
        <tr>
          <td class="textos_negros">Fecha Inicial</td>
          <td><?=$formulario->c_fecha_input("","fechaini","","")?></td>
          <td class="textos_negros">Fecha Fina</td>
          <td><?=$formulario->c_fecha_input("","fechafin","","")?></td>
          <td class="textos_titulos">Campo Fecha</td>
          <td><select name="campofecha" id="campofecha">
            <option value="" selected="selected">Fecha de Gestion</option>
            <option value="agenda.fecha">Fecha de Agendamiento</option>
            <option value="inv_inventario.fechasalida">Fecha de salida</option>
            <option value="inv_inventario.fechah">Fecha de Inventario</option>
          </select></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF" class="textospadding"><div id="ListaProgramas"></div></td>
    </tr>

  </table>
</form> 
<script>
EnviarLinkJ('ListaProgramas','<?=$RAIZHTTP?>/modules/cronjobs/descarga_reportes.php?op=3&idform=<?=$_POST[varid]?>');
</script> 
 
<? }if($_GET[op] == 3){ 
include '../../appcfg/general_config.php';

if($_GET[del] != ""){ 

mysql_query("DELETE FROM cron_export WHERE id_cronexport = $_GET[del]"); 

}


if($_GET[fecha_prog] != ""){

$sqlm->inser_data("cron_export","idreport,fecha,hora,mail_notif,fechaini,fechafin,campofecha","'$_GET[repSel]','$_GET[fecha_prog]','$_GET[hora]','$_GET[mail_notif]','$_GET[fechaini]','$_GET[fechafin]','$_GET[campofecha]'",0);

}


$FormsCorns = $sqlm->sql_select("cron_export,repdina_config","*","id_form = $_GET[idform] AND idreport = id_rep",0);

if(is_array($FormsCorns)){
?>

<table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
  <tr>
    <td align="center" class="textos_titulos">Reporte</td>
    <td align="center" class="textos_titulos">Fecha</td>
    <td align="center" class="textos_titulos">Hora</td>
    <td align="center" class="textos_titulos">Mail Notificar</td>
    <td align="center" class="textos_titulos">Fecha Inicial</td>
    <td align="center" class="textos_titulos">Fecha Final</td>
    <td align="center" class="textos_titulos">Campo Fecha</td>
    <td align="center" class="textos_titulos">Descargar Reporte</td>
    <td align="center" class="textos_titulos">Eliminar</td>
  </tr>
<? for( $i = 0 ; $i < count($FormsCorns) ; $i++ ){ ?>

  <tr>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$FormsCorns[$i][nombre]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$FormsCorns[$i][fecha]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding"><?=$FormsCorns[$i][hora]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding"><?=$FormsCorns[$i][mail_notif]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding"><?=$FormsCorns[$i][fechaini]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding"><?=$FormsCorns[$i][fechafin]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding">
    <?
    
	switch($FormsCorns[$i][campofecha]){
		
		case "agenda.fecha";
		echo "Fecha de Agendamiento";
		break;

		case "inv_inventario.fechasalida";
		echo "Fecha de salida";
		break;

		case "inv_inventario.fechah";
		echo "Fecha de Inventario";
		break;
		
	}
	
	?>
    </td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding">
    
    <? 

	if($FormsCorns[$i][autogenerado] == ""){ ?>
      
      No Generado
      
      <? }else{ ?>
		
	 <a href="/openc3/tmp/<?=$FormsCorns[$i][autogenerado]?>" target="_blank">Descargar</a>
		
	<? } ?>
    
    </td>
  
    <td align="center" bgcolor="#FFFFFF" class="textospadding">
      <a href="javascript:EnviarLinkJ('ListaProgramas','<?=$RAIZHTTP?>/modules/cronjobs/descarga_reportes.php?op=3&idform=<?=$_GET[idform]?>&del=<?=$FormsCorns[$i][id_cronexport]?>');"><img src='imgs/delimg.png'></img></a>
    </td>
  </tr>
<?  } ?>
</table>
<? }/*aqui esta esto*/ } ?>