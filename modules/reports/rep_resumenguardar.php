<? 
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5){
include '../../appcfg/general_config.php';

$grupos = $sqlm->sql_select("autoform_grupos","labelgrupo,id_autoformgrupos","idtabla_rel = '".$_GET[idform]."' ORDER BY posiciongrupo",0); 


?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<div class="textos_titulos">
<div style="float:none;"  class="textos_titulos">Seleccione el campo a resumir y graficar:

  <select name="camposver" onchange="EnviarLinkJ('campomostrar','modules/reports/rep_resumenguardar.php?op=2&filtroid=<?=$_GET[filtroid]?>',this.options[this.selectedIndex].value);">
  <option value="Seleccione" selected="selected">Seleccione</option>

<? for($i=0 ; $i < count($grupos) ; $i++){
$campos = $sqlm->sql_select("autoform_config","labelcampo,nombrecampo,poscampo,tipocampo,requerido,historial","idgrupo = '".$grupos[$i][id_autoformgrupos]."' AND tipocampo IN ('select','autocom','fecha') ORDER BY poscampo",0);	
?>
<optgroup label="<?=$grupos[$i][labelgrupo]?>">


<? 
if(is_array($campos)){
for($o=0 ; $o < count($campos) ; $o++){?>
<option value="<?=$campos[$o][nombrecampo]?>-<?=$campos[$o][tipocampo]?>-<?=$_GET[idform]?>"><?=$campos[$o][labelcampo]?></option>
<? 
}
} //termina el for de los campos  a comparar ?>



</optgroup>
<? } //termina el for que saca los grupos. ?>
</select>
</div> 
<div class="textos_titulos">
    <!--aqui va la parte de los campos espesiales-->
    <?

$gruposESP = $sqlm->sql_select("acampos_esp","mudulon","1 GROUP BY mudulon",0); 


?>
    Campos de módulos especiales para resumir y graficar:
    <select name="camposver2" onchange="EnviarLinkJ('campomostrar','modules/reports/rep_resumenguardar.php?op=2&amp;filtroid=<?=$_GET[filtroid]?>',this.options[this.selectedIndex].value);">
    <option value="" selected="selected">Seleccione</option>
    <? for($i=0 ; $i < count($gruposESP) ; $i++){
$campos = $sqlm->sql_select("acampos_esp","*","mudulon = '".$gruposESP[$i][mudulon]."' AND tipocampo != 'fecha'",0);	
?>
    <optgroup label="<?=$gruposESP[$i][mudulon]?>">
      <? for($o=0 ; $o < count($campos) ; $o++){?>
      <option value="<?=$campos[$o][campon]?>-<?=$campos[$o][tipocampo]?>">
        <?=$campos[$o][labelcampo]?>
      </option>
      <? } //termina el for de los campos  a comparar ?>
      </optgroup>
    <? } //termina el for que saca los grupos. ?>
  </select>
  </div>
<div style="float:none; margin-top:5px" id="campomostrar">
</div>

<hr>

<div style="float:none;"  class="textos_titulos">Seleccione Los Campos a mostrar en el resumen:

  <select name="camposver" onchange="EnviarLinkJ('CamposDetalle','modules/reports/rep_resumenguardar.php?op=4&filtroid=<?=$_GET[filtroid]?>',this.options[this.selectedIndex].value);">
  <option value="Seleccione" selected="selected">Seleccione</option>

<? for($i=0 ; $i < count($grupos) ; $i++){
$campos = $sqlm->sql_select("autoform_config","labelcampo,nombrecampo,poscampo,tipocampo,requerido,historial","idgrupo = '".$grupos[$i][id_autoformgrupos]."' ORDER BY poscampo",0);	
?>
<optgroup label="<?=$grupos[$i][labelgrupo]?>">
<? for($o=0 ; $o < count($campos) ; $o++){?>
<option value="<?=$campos[$o][nombrecampo]?>-<?=$campos[$o][tipocampo]?>-<?=$_GET[idform]?>"><?=$campos[$o][labelcampo]?></option>
<? } //termina el for de los campos  a comparar ?>
</optgroup>
<? } //termina el for que saca los grupos. ?>
</select>
</div>

<div class="textos_titulos">


<!--aqui va la parte de los campos espesiales-->

<?

$gruposESP = $sqlm->sql_select("acampos_esp","mudulon","1 GROUP BY mudulon",0); 


?>
Campos de módulos especiales:

<select name="camposver" onchange="EnviarLinkJ('CamposDetalle','modules/reports/rep_resumenguardar.php?op=4&filtroid=<?=$_GET[filtroid]?>',this.options[this.selectedIndex].value);">
  <option value="" selected="selected">Seleccione</option>

<? for($i=0 ; $i < count($gruposESP) ; $i++){
$campos = $sqlm->sql_select("acampos_esp","*","mudulon = '".$gruposESP[$i][mudulon]."'",0);	
?>
<optgroup label="<?=$gruposESP[$i][mudulon]?>">
<? for($o=0 ; $o < count($campos) ; $o++){?>
<option value="<?=$campos[$o][campon]?>-<?=$campos[$o][tipocampo]?>"><?=$campos[$o][labelcampo]?></option>
<? } //termina el for de los campos  a comparar ?>
</optgroup>
<? } //termina el for que saca los grupos. ?>
</select>
</div>

<div style="float:none; margin-top:5px" id="CamposDetalle"></div>

<script>
EnviarLinkJ('CamposDetalle','modules/reports/rep_resumenguardar.php?op=4&filtroid=<?=$_GET[filtroid]?>');
</script>


<? } //aqui termina el por defecto sin ninguna opcion.
if( $_GET[op] == 2 ){
include '../../appcfg/general_config.php';

if($_POST[varid] != "" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------

$cdatos=explode("-",$varid);

//aqui pulimos la parte de seleccionar el nombre de la tabla

$TraeCondiciones = $sqlm->sql_select("repdina_compare,repdina_config","*","idrelconfig = '$_GET[filtroid]' AND idrelconfig = id_rep",0);

$TablaDatos = $sqlm->sql_select("autoform_tablas","nombretabla,campoid","campaignid = '".$TraeCondiciones[0][id_cam]."'",0);

//aqui pulimos la parte de seleccionar el nombre de la tabla

if($cdatos[2]){

if($cdatos[1] == "text" or $cdatos[1] == "textarea" or $cdatos[1] == "fecha"){
	

$DataCampo = $sqlm->sql_select($TablaDatos[0][nombretabla],$cdatos[0]." as valor,".$cdatos[0]." as identificador","1 GROUP BY ".$cdatos[0],0);


		/*aqui enviamos los parametros al autocompletar.*/					}
else{
	
$DataCampo = $sqlm->sql_select("autof_".$cdatos[0],"id_".$cdatos[0]." as identificador,field1 as valor","1",0);


		/*aqui enviamos los parametros de los otros tipos de campo.*/						}
	
	
		}//aqui sacamos los normalongos
		else 	{
	
$CesCFG = $sqlm->sql_select("acampos_esp","*","campon = '$cdatos[0]'",0);

		if($CesCFG[0][tipocampo] == "text" or $CesCFG[0][tipocampo] == "fecha" ){
			
			
$DataCampo = $sqlm->sql_select($CesCFG[0][tabla],$CesCFG[0][campoid]." as identificador,".$CesCFG[0][campon]." as valor","1 GROUP BY ".$CesCFG[0][campon],0);
		$cdatos[0] = "cme_".$cdatos[0];	
			
								}else{

			
$paramARR=explode(",",$CesCFG[0][paramcampo]);
$DataCampo = $sqlm->sql_select($paramARR[0],$paramARR[3]." as identificador,$paramARR[2] as valor","1",0);
		$cdatos[0] = "cme_".$cdatos[0];	

								}//cuando son de otra tabla
				
				}
?>
<div align="center">
  <table width="0" border="0" cellspacing="3" cellpadding="0">
    <tr>
      <td align="center" class="textos_titulos">Valores Disponibles</td>
      <td class="textos_titulos">Valores en el Reporte</td>
    </tr>
    <tr>
      <td align="center" valign="top"><table width="0" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2" align="center" class="textos_titulos">Valores</td>
        </tr>
        <? for($i = 0 ;$i < count($DataCampo) ; $i++) { ?>
        <tr>
          <td class="textospadding"><?=utf8_encode($DataCampo[$i][valor])?>
            &nbsp;</td>
          <td><a href="javascript:EnviarLinkJ('DatosMos','modules/reports/rep_resumenguardar.php?op=3&amp;filtroid=<?=$_GET[filtroid]?>&amp;add=1&amp;datav=<?=urlencode($DataCampo[$i][valor])?>&amp;dataid=<?=urlencode($DataCampo[$i][identificador])?>&amp;campo=<?=$cdatos[0]?>');">Agregar</a>&nbsp;</td>
        </tr>
        <? } ?>
      </table></td>
      <td align="left" valign="top">
      <div id="DatosMos"></div>
      </td>
    </tr>
  </table>
</div>
<script>
EnviarLinkJ('DatosMos','modules/reports/rep_resumenguardar.php?op=3&filtroid=<?=$_GET[filtroid]?>');
</script>

<? 
}if($_GET[op]==3){ 
include '../../appcfg/general_config.php';

if($_GET[add] == 1){
	
//$condicion = "$campon $condicion '$valor_hidden'";
$GuardaCData = $sqlm->inser_data("repdina_datashow","valor,identificador,ncampo,id_rep","'$_GET[datav]','$_GET[dataid]','$_GET[campo]','$_GET[filtroid]'",0);

}


if($_GET[del] == 1){
	
//$condicion = "$campon $condicion '$valor_hidden'";
mysql_query("DELETE FROM repdina_datashow WHERE id_datashow = '$_GET[idcondicion]'");

}

$DataMostrar = $sqlm->sql_select("repdina_datashow","*","id_rep = '$_GET[filtroid]'",0);


 if(is_array($DataMostrar)){ ?>
<table width="0" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2" align="center" class="textos_titulos">Valores</td>
          </tr>
<? for($i = 0 ;$i < count($DataMostrar) ; $i++) { ?>
        <tr>
          <td class="textospadding"><?=$DataMostrar[$i][valor]?></td>
          <td>
          
          <a href="javascript:EnviarLinkJ('DatosMos','modules/reports/rep_resumenguardar.php?op=3&filtroid=<?=$_GET[filtroid]?>&del=1&idcondicion=<?=$DataMostrar[$i][id_datashow]?>');"><img style="float:right; margin-left:5px" src="<?=$RAIZHTTPCONF?>/imgs/delimg.png" width="16" height="16" /></a>
          
          </td>
        </tr>
<? } ?> 
        <tr>
          <td colspan="2" class="textos_titulos">
          <? genera_modalF("VerReporte",1200,700,"rep_resumenguardar.php","DatosMos"); ?>
          <a href="modules/reports/rep_resgraf_vewer.php?idrep=<?=$_GET[filtroid]?>" class="VerReporte">Vista Previa</a>
          </td>
        </tr>

      </table>
<? } ?>

<? 
}if($_GET[op] == 4){

include '../../appcfg/general_config.php';

if($_GET[del] == 1){
	
//$condicion = "$campon $condicion '$valor_hidden'";
mysql_query("DELETE FROM repdina_camposm WHERE id_camposm = '$_GET[idcampo]'");

}



if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------

$cdatos=explode("-",$varid);


if($varid)		{


	if($cdatos[2]){ 
	
	$sqlm->inser_data("repdina_camposm","campom,idfiltro","'$cdatos[0]','$_GET[filtroid]'",0);
	
	}
	
	else{
	
	$sqlm->inser_data("repdina_camposm","campom,idfiltro","'cme_$cdatos[0]','$_GET[filtroid]'",0);
	
		}

				}
	
	
	$TraeMos = $sqlm->sql_select("repdina_camposm","*","idfiltro = '$_GET[filtroid]'",0);

for($i=0 ; $i<count($TraeMos);$i++){


	//interceptamos y comparamos si el campo es de modulo espesial o de los normales
	if(substr($TraeMos[$i][campom],0,4) == "cme_"){ 

@$CampoData = $sqlm->sql_select("acampos_esp","*","campon = '".substr($TraeMos[$i][campom],4,20)."'",0);
//	$TraeCondiciones[$i][campo] = substr($TraeCondiciones[$i][campo],4,20);
	
	 }else { 

@$CampoData = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$TraeMos[$i][campom]."'",0);

			}





?>

<div id="condi<?=$i?>" align="center" style="margin-top:5px" class="rounded-corners-blue">
<?=$CampoData[0][labelcampo]?> 

<a href="javascript:EnviarLinkJ('CamposDetalle','modules/reports/rep_resumenguardar.php?op=4&filtroid=<?=$_GET[filtroid]?>&del=1&idcampo=<?=$TraeMos[$i][id_camposm]?>');"><img style="float:right; margin-left:5px" src="<?=$RAIZHTTPCONF?>/imgs/delimg.png" width="16" height="16" /></a></div>

<?
$camposm .= $TraeMos[$i][campom].",";

 } /*Aqui termino el for que muestra los filtro*/ 
 } ?>