<? 
session_start();

if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1){ 

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<meta charset="utf-8">
	
<div class="textosbig" align="center">
  <h3>Administracion De Reportes</h3>
</div>
<table border="0" cellspacing="2" cellpadding="0" align="center">
  <tr>
    <td align="center" valign="top"><table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-gray">
      <tr>
        <td class="textos_titulos">Seleccione Una Campaña</td>
        <td class="textos_titulos"><? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"1",
	"direccion"=>"modules/reports/rep_config.php?op=1");
	echo $formulario->select_envia_link("","id_campaign","","","",$parametrosGrupoHerr,0,"","MuestraForms"); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><div id="MuestraForms"></div></td>
  </tr>
</table>
<? }//para cuando no ahy opciones 
if( $_GET[op] == 1 ){ //llama los tabs 

include '../../appcfg/general_config.php';

?>
	
<table border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td  valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td class="textos_titulos">Filtros para esta Campaña</td>
      </tr>
      <tr>
        <td class="textos_titulos">
        
<script>
EnviarLinkJ('MuestraReportes','modules/reports/rep_config.php?op=2&idcampaign=<?=$_POST[varid]?>');
</script>

<form onSubmit="EnviarLinkForm('MuestraReportes','<?=$RAIZHTTP?>/modules/reports/rep_config.php?op=2',this);this.reset();return false;">
          Nuevo Filtro:<br />
  <?=$formulario->c_text("","Nombre_Filtro","","","",1,"",10);?><br>
  <? $parametrosGrupoHerr=array(
	"tabla"=>"autoform_tablas",
	"campo1"=>"id_autoformtablas",
	"campo2"=>"labeltabla",
	"campoid"=>"id_autoformtablas",
	"condiorden"=>"campaignid = '$_POST[varid]'");
	echo $formulario->c_select("","id_form","","","",$parametrosGrupoHerr,0,"","MuestraForms"); ?>
  <input name="idcampaign" type="hidden" id="idcampaign" value="<?=$_POST[varid]?>" />
  <input name="Submit" type="submit" value="Ok" />
        </form>
     </td>
      </tr>
      <tr>
        <td class="textos"><div class="textospadding" id="MuestraReportes"></div></td>
      </tr>
    </table></td>
  <td valign="top"><div id="ConfigReport">Configuracion</div></tr>
</table>

<? } //Guarda el registro para el filtro. 

if($_GET[op] == 2){ // guardamos el registro
include '../../appcfg/general_config.php';
if($_GET[Nombre_Filtro] != "")			{
$guardarForm = $sqlm->inser_data("rep_config","nombre,idform,idcam","'$_GET[Nombre_Filtro]','$_GET[id_form]','$_GET[idcampaign]'",0);
$seleccIDreps = $sqlm->sql_select("rep_config","MAX(id_filter) as IDmax","1",0);
$guardarParaMenu = $sqlm->inser_data("page_modules","page_title,modulegroup,module_folder,module_file","'".$_GET[Nombre_Filtro]."','Reportes e Informes','reports','rep_vewer&repid=".$seleccIDreps[0][IDmax]."'",0);
									}
	//-----------------------									
$TraerFiltros = $sqlm->sql_select("rep_config","*","idcam = '$_GET[idcampaign]'",0);
?>
<div class="demo">
<ol id="selectable">
<? for($i=0 ; $i < count($TraerFiltros); $i++){ 
@$FormName = $sqlm->sql_select("autoform_tablas","labeltabla","id_autoformtablas = '".$TraerFiltros[$i][idform]."'",0);
if($TraerFiltros[$i][dialer] == 1){ $dialers = "| Pre"; }
?> 

<li class="ui-widget-content" onmousedown="EnviarLinkJ('ConfigReport','modules/reports/rep_conditions.php?idform=<?=$TraerFiltros[$i][idform]?>&idfiltro=<?=$TraerFiltros[$i][id_filter]?>','este')"><?=$TraerFiltros[$i][nombre]?> <?=$dialers?> | <?=$FormName[0][labeltabla]?> | <input class="BotonesBorrar" type="button" value="Eliminar" onclick="EnviarLinkJ('ConfigReport','modules/reports/rep_delete.php?idform=<?=$TraerFiltros[$i][idform]?>&idfiltro=<?=$TraerFiltros[$i][id_filter]?>','este')"  style="position:relative; margin-top:-3px;float: right" /></li>

<?	} //termina el for que saca los filtros
?>
</ol>
</div>
<?


}
?>