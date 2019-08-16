<? 
session_start();

if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1){ 

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<meta charset="utf-8">
	
<div class="textosbig" align="center">
  <h3>Marcacion Predictiva</h3>
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
	"direccion"=>"modules/campaigns/dialer_campaigns.php?op=1");
	echo $formulario->select_envia_link("","id_campaign","","","",$parametrosGrupoHerr,0,"","MuestraFils"); ?>
          &nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><div id="MuestraFils"></div></td>
  </tr>
</table>

<? }//para cuando no ahy opciones 
if( $_GET[op] == 1 ){ //llama los tabs 

include '../../appcfg/general_config.php';

$FiltrosPre = $sqlm->sql_select("filter_config","nombre,idform,id_filter","idcam = '$_POST[varid]' AND dialer = 1",0);

?>
	
<table border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td  valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td class="textos_titulos">Filtros Disponibles Para Campaña</td>
      </tr>
      <tr>
        <td class="textos">
        <div class="textospadding" id="MuestraReportes">
<div class="demo">
<ol id="selectable">        
<? for($i = 0 ;$i < count($FiltrosPre) ; $i++){ 
 
 $Formularios = $formulario->traer_datos_select("autoform_tablas","labeltabla","labeltabla","id_autoformtablas",0,"id_autoformtablas = ".$FiltrosPre[$i][idform]);
 
?>

<li class="ui-widget-content" onmousedown="EnviarLinkJ('ConfigFilter','modules/campaigns/dialer_saver.php?idfiltro=<?=$FiltrosPre[$i][id_filter]?>&idform=<?=$FiltrosPre[$i][idform]?>','este')"><?=$FiltrosPre[$i][nombre]?> | <?=$Formularios[texto]?></li>

<? } ?>        
</ol>
</div>        
        </div></td>
      </tr>
    </table></td>
    <td valign="top">
    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="rounded-corners-gray">
      <tr>
        <td><div id="ConfigFilter">Configuracion</div></td>
      </tr>
    </table>    
  </tr>
</table>

<? } //llama los tabs 