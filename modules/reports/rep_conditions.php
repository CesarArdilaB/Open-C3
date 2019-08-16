<? 
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1){ 
include '../../appcfg/general_config.php';

$idform 	= $_GET[idfrom];
$idfiltro 	= $_GET[idfiltro];

$grupos = $sqlm->sql_select("autoform_grupos","labelgrupo,id_autoformgrupos","idtabla_rel = '".$_GET[idform]."' ORDER BY posiciongrupo",0); 

$FilterTamplates = $sqlm->sql_select("filter_tamplate","*","1",0); 


?>
<div class="textos_titulos">

Usar Filtro de Una Plantilla preconfigurada: 
<select name="templatefilter" onchange="EnviarLinkJ('condiciones','modules/reports/rep_conditions.php?op=3&filtroid=<?=$_GET[idfiltro]?>',this.options[this.selectedIndex].value);">
  <option value="Seleccione" selected="selected">Seleccione</option>
  
<? for($o=0 ; $o < count($FilterTamplates) ; $o++){?>

  <option value="<?=$FilterTamplates[$o][id_filtertemplate]?>"><?=$FilterTamplates[$o][nombre]?>;</option>

<? } //termina el for de los campos  a comparar ?>

</select>

y tambien puede agregar:</div>

<div style="float:left;"  class="textos_titulos">
Campos a Comparar:

<select name="camposver" onchange="EnviarLinkJ('comp<?=$nc?>','modules/reports/rep_conditions.php?op=2&idfiltro=<?=$idfiltro?>',this.options[this.selectedIndex].value);">
  <option value="" selected="selected">Seleccione</option>

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
<div style="float:left;" id="comp<?=$nc?>"  class="textos_titulos"></div><br>
<div style="float:none; margin-top:35px" id="condiciones"></div>

<script>
EnviarLinkJ('condiciones','modules/reports/rep_conditions.php?op=3&filtroid=<?=$idfiltro?>');
EnviarLinkJ('mostrar','modules/reports/rep_conditions.php?op=4&idfiltro=<?=$idfiltro?>');
EnviarLinkJ('asignado','modules/reports/rep_conditions.php?op=5&idfiltro=<?=$idfiltro?>');
</script>

<div class="textos_titulos">

Campos a Mostrar: 
<select name="camposver" onchange="EnviarLinkJ('mostrar','modules/reports/rep_conditions.php?op=4&idfiltro=<?=$idfiltro?>',this.options[this.selectedIndex].value);">
  <option value="" selected="selected">Seleccione</option>

<? for($i=0 ; $i < count($grupos) ; $i++){
$campos = $sqlm->sql_select("autoform_config","labelcampo,nombrecampo,poscampo,tipocampo,requerido,historial","idgrupo = '".$grupos[$i][id_autoformgrupos]."' ORDER BY poscampo",0);	
?>
<optgroup label="<?=$grupos[$i][labelgrupo]?>">
<? for($o=0 ; $o < count($campos) ; $o++){?>
<option value="<?=$campos[$o][nombrecampo]?>"><?=$campos[$o][labelcampo]?></option>
<? } //termina el for de los campos  a comparar ?>
</optgroup>
<? } //termina el for que saca los grupos. ?>
</select>

</div>
<div style="float:none; margin-top:15px" id="mostrar"></div>
<div style="float:none; margin-top:15px" id="asignado"></div>

<? } //aqui termina el por defecto sin ninguna opcion.
if( $_GET[op] == 2 ){
include '../../appcfg/general_config.php';
$idfiltro 	= $_GET[idfiltro];

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------
$cdatos=explode("-",$varid);

$TablaDatos = $sqlm->sql_select("autoform_tablas","nombretabla,campoid","id_autoformtablas = '$cdatos[2]'",0);

if($cdatos[1] == "text" or $cdatos[1] == "textarea" or $cdatos[1] == "fecha"){
	
$parametrosGrupoHerr=array(
	"tabla"=>$TablaDatos[0][nombretabla],
	"campo1"=>$cdatos[0],
	"campo2"=>$cdatos[0],
	"campoid"=>$cdatos[0],
	"condiorden"=>"1 GROUP BY $cdatos[0]");		

		/*aqui enviamos los parametros al autocompletar.*/					}
else{
	
	$parametrosGrupoHerr=array(
	"tabla"=>"autof_".$cdatos[0],
	"campo1"=>"id_".$cdatos[0],
	"campo2"=>"field1",
	"campoid"=>"id_".$cdatos[0],
	"condiorden"=>"1");		
	
		/*aqui enviamos los parametros de los otros tipos de campo.*/						}
?>
<form name="forma1">

<select name="condicion" id="condicion">
<option value="=" selected="selected">Igual</option>
  <option value="!=">Diferente</option>
</select>

<? echo $formulario->c_Auto_select("","valor","","","",$parametrosGrupoHerr,1,"Valor: ","",0,35); ?>
<input name="campon" type="hidden" value="<?=$cdatos[0]?>" />
<input name="filtroid" type="hidden" value="<?=$_GET[idfiltro]?>" />		
<input type="button" onclick="EnviarLinkForm('condiciones','<?=$RAIZHTTP?>/modules/reports/rep_conditions.php?op=3',document.forma1);document.forma1.reset()" name="ok" id="ok" value="Agregar" />

<label for="checkbox"></label>
</form>

<? 
}if($_GET[op]==3){ 
include '../../appcfg/general_config.php';

if($_GET[condicion] != ""){
	
//$condicion = "$campon $condicion '$valor_hidden'";
$GuardaCondi = $sqlm->inser_data("rep_conditions","campo,condicion,valor,idrelconfig","'$_GET[campon]','$_GET[condicion]','$_GET[valor_hidden]','$_GET[filtroid]'",0);

}

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------
if($varid != "" and $varid != "undefined"){//asignamos la clausula perzonalizada

$GuardaMos = $sqlm->update_regs("rep_config","idtemplate = $varid","id_filter = $_GET[filtroid]",0);

}//-----	asignamos la clausula perzonalizada------------------

if($_GET[del] == 1){
	
//$condicion = "$campon $condicion '$valor_hidden'";
mysql_query("DELETE FROM rep_conditions WHERE id_condition = '$_GET[idcondicion]'");
}

if($_GET[delFP] == 1){
	
//$condicion = "$campon $condicion '$valor_hidden'";
$GuardaMos = $sqlm->update_regs("rep_config","idtemplate = ''","id_filter = $_GET[filtroid]",0);

}

//-----------qio borramos el filtro plantilla si se requiere

$TraeCondiciones = $sqlm->sql_select("rep_conditions","*","idrelconfig = '$_GET[filtroid]'",0);

for($i=0 ; $i<count($TraeCondiciones);$i++){
	
	@$CampoData = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$TraeCondiciones[$i][campo]."'",0);
?>

<div id="condi<?=$i?>" align="center" style="margin-top:5px" class="rounded-corners-blue"><?=$CampoData[0][labelcampo]." ".$TraeCondiciones[$i][condicion]?> 

<?
if($TraeCondiciones[$i][valor] != ""){
echo $formulario_auto->armar_campo($CampoData[0][tipocampo],$TraeCondiciones[$i][campo],"",$TraeCondiciones[$i][valor],0,1,0,$CampoData[0][paramcampo]);
}else{ echo "Vacio"; }
?> 

<a href="javascript:EnviarLinkJ('condiciones','modules/reports/rep_conditions.php?op=3&filtroid=<?=$_GET[filtroid]?>&del=1&idcondicion=<?=$TraeCondiciones[$i][id_condition]?>');"><img style="float:right; margin-left:5px" src="<?=$RAIZHTTPCONF?>/imgs/delimg.png" width="16" height="16" /></a></div>

<?
$condiciones .= "AND ".$TraeCondiciones[$i][campo]." ".$TraeCondiciones[$i][condicion]." '".$TraeCondiciones[$i][valor]."'";

 } /*Aqui termino el for que muestra los filtro*/ 
$TablaData= $sqlm->sql_select("autoform_tablas","*","id_autoformtablas = '".$CampoData[0][idtabla_rel]."'",0);

//trae el filtro personalizado que se aplico


//trae el filtro personalizado que se aplico

$TraeFillTemplate = $sqlm->sql_select("filter_tamplate,rep_config","clausulas,filter_tamplate.nombre as nombreT,idtemplate","id_filter = '$_GET[filtroid]' and id_filtertemplate = idtemplate",0);
if(is_array($TraeFillTemplate)){
$condiciones .= " AND (".$TraeFillTemplate[0][clausulas].")";
?>
<div id="" align="center" style="margin-top:5px" class="rounded-corners-blue">Aplicando La Plantilla de Filtro: <?=$TraeFillTemplate[0][nombreT]?> 
<a href="javascript:EnviarLinkJ('condiciones','modules/reports/rep_conditions.php?op=3&filtroid=<?=$_GET[filtroid]?>&delFP=1&idTF=<?=$TraeFillTemplate[0][idtemplate]?>');"><img style="float:right; margin-left:5px" src="<?=$RAIZHTTPCONF?>/imgs/delimg.png" width="16" height="16" /></a>
</div>

<? }
//trae el filtro personalizado que se aplico



$Reduldado = $sqlm->sql_select($TablaData[0][nombretabla],"COUNT(".$TablaData[0][campoid].") as cuenta","1 $condiciones",0);
?>

<div align="center" class="rounded-corners-gray">Registros Con Este Filtro: <?=$Reduldado[0][cuenta]?></div>

<? }//aqui termna la opcion 3 

if($_GET[op]==4){ 
include '../../appcfg/general_config.php';

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------
if($varid != "" and $varid != "undefined"){
//$condicion = "$campon $condicion '$valor_hidden'";

$GuardaMos = $sqlm->inser_data("rep_camposm","campom,idfiltro","'$varid','$_GET[idfiltro]'",0);
}

if($_GET[del] == 1){
	
//$condicion = "$campon $condicion '$valor_hidden'";
mysql_query("DELETE FROM rep_camposm WHERE id_camposm = '$_GET[idcampo]'");
}

$TraeMos = $sqlm->sql_select("rep_camposm","*","idfiltro = '$_GET[idfiltro]'",0);

for($i=0 ; $i<count($TraeMos);$i++){

	@$CampoData = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$TraeMos[$i][campom]."'",0);
?>

<div id="condi<?=$i?>" align="center" style="margin-top:5px" class="rounded-corners-blue"><?=$CampoData[0][labelcampo]?> 

<a href="javascript:EnviarLinkJ('mostrar','modules/reports/rep_conditions.php?op=4&idfiltro=<?=$_GET[idfiltro]?>&del=1&idcampo=<?=$TraeMos[$i][id_camposm]?>');"><img style="float:right; margin-left:5px" src="<?=$RAIZHTTPCONF?>/imgs/delimg.png" width="16" height="16" /></a></div>

<?
$camposm .= $TraeMos[$i][campom].",";

 } /*Aqui termino el for que muestra los filtro*/ 

$TraeCondiciones = $sqlm->sql_select("rep_conditions","*","idrelconfig = '$_GET[idfiltro]'",0);

for($i=0;$i<count($TraeCondiciones);$i++){
$condiciones .= "AND ".$TraeCondiciones[$i][campo]." ".$TraeCondiciones[$i][condicion]." '".$TraeCondiciones[$i][valor]."'";	
	}
	
?>
<script>
EnviarLinkJ('asignado','modules/reports/rep_conditions.php?op=5&idfiltro=<?=$_GET[idfiltro]?>');
</script>
<? } //termina la opcion 4
if($_GET[op] == 5){
include '../../appcfg/general_config.php';
$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";

require '../../appcfg/class_reports.php';

$reporte = new reportes();
$reporte->RutaHTTP="$RAIZHTTP";

$JsScripts->ReporteScripts();

$reporte->GeneraRep($_GET[idfiltro],1);
	
} // termina la opcion 5
?>