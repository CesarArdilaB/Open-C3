<? 
session_start();


if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1){ 

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<meta charset="utf-8">
	
<div align="center">
  <h3>Reportes De Resumen y Gráficos</h3></div>
    
    
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
	"direccion"=>"modules/reports/rep_resumengraficos.php?op=1");
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
        <td class="textos_titulos">Para esta Campaña</td>
      </tr>
      <tr>
        <td class="textos_titulos">
        
<script>
EnviarLinkJ('MuestraReportes','modules/reports/rep_resumengraficos.php?op=2&idcampaign=<?=$_POST[varid]?>');
</script>

<form onsubmit="EnviarLinkForm('MuestraReportes','<?=$RAIZHTTP?>/modules/reports/rep_resumengraficos.php?op=2',this);this.reset();return false;">
          Nuevo Reporte:<br />
  
  <?=$formulario->c_text("","Nombre_Informe","","","",1,"",10);?><br>
  <? $parametrosGrupoHerr=array(
	"tabla"=>"autoform_tablas",
	"campo1"=>"id_autoformtablas",
	"campo2"=>"labeltabla",
	"campoid"=>"id_autoformtablas",
	"condiorden"=>"campaignid = '$_POST[varid]'");
	echo $formulario->c_select("","id_form","","","",$parametrosGrupoHerr,0,"","MuestraForms"); ?>
  <input name="idcampaign" type="hidden" id="idcampaign" value="<?=$_POST[varid]?>" />
  <input name="Submit" type="submit" value="Ok" />
        </form></td>
      </tr>
      <tr>
        <td class="textos"><div class="textospadding" id="MuestraReportes"></div></td>
      </tr>

    </table></td>
    <td valign="top"><div id="ConfigReport">Configuración</div></tr>
</table>

<? } //llama los tabs 

if($_GET[op]==2){ //mostramos el formulario
include '../../appcfg/general_config.php';

if($_GET[Nombre_Informe] !="")	{

$guardarReporte = $sqlm->inser_data("repdina_config","nombre,id_cam,id_form","'".$_GET[Nombre_Informe]."','".$_GET[idcampaign]."','$_GET[id_form]'",0);

$seleccIDreps = $sqlm->sql_select("repdina_config","MAX(id_rep) as IDmax","1",0);

$guardarParaMenu = $sqlm->inser_data("page_modules","page_title,modulegroup,module_folder,module_file","'".$_GET[Nombre_Informe]."','Reportes e Informes','reports','rep_resumvewer&repid=".$seleccIDreps[0][IDmax]."'",0);

		}

$seleccreps = $sqlm->sql_select("repdina_config","*","id_cam = '".$_GET[idcampaign]."'",0);

for( $i = 0 ; $i < count($seleccreps) ; $i++ ){
	
	$FormName = $sqlm->sql_select("autoform_tablas","labeltabla","id_autoformtablas = '".$seleccreps[$i][id_form]."'",0);

?>

<a href="javascript:EnviarLinkJ('ConfigReport','modules/reports/rep_resumencompare.php?idform=<?=$seleccreps[$i][id_form]?>&idrep=<?=$seleccreps[$i][id_rep]?>')"><?=$seleccreps[$i][nombre]?> | <?=$FormName[0][labeltabla]?></a><br>

<? }
//termino el for que me trae las formas
 } //mostramos el formulario 
