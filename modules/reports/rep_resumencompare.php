<? 
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5){
include '../../appcfg/general_config.php';

$grupos = $sqlm->sql_select("autoform_grupos","labelgrupo,id_autoformgrupos","idtabla_rel = '".$_GET[idform]."' ORDER BY posiciongrupo",0); 


?>

<div class="textos_titulos">


<!--aqui va la parte de los campos espesiales-->
Campos a Comparar:

<?

$gruposESP = $sqlm->sql_select("acampos_esp","mudulon","1 GROUP BY mudulon",0); 


?>
Campos de módulos especiales:

<select name="camposver" onchange="EnviarLinkJ('comp<?=$nc?>','modules/reports/rep_resumencompare.php?op=2&idfiltro=<?=$_GET[idrep]?>',this.options[this.selectedIndex].value);">
  <option value="Seleccione" selected="selected">Seleccione</option>

<? for($i=0 ; $i < count($gruposESP) ; $i++){
$campos = $sqlm->sql_select("acampos_esp","*","mudulon = '".$gruposESP[$i][mudulon]."' AND tipocampo != 'fecha'",0);	
?>
<optgroup label="<?=$gruposESP[$i][mudulon]?>">
<? for($o=0 ; $o < count($campos) ; $o++){?>
<option value="<?=$campos[$o][campon]?>-<?=$campos[$o][tipocampo]?>"><?=$campos[$o][labelcampo]?></option>
<? } //termina el for de los campos  a comparar ?>
</optgroup>
<? } //termina el for que saca los grupos. ?>
</select>
</div> 

<!--aqui va la parte de los campos espesiales-->


<div style="float:left;"  class="textos_titulos">
Formulario:

<select name="camposver" onchange="EnviarLinkJ('comp<?=$nc?>','modules/reports/rep_resumencompare.php?op=2&idfiltro=<?=$_GET[idrep]?>',this.options[this.selectedIndex].value);">
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
<div style="float:left;" id="comp<?=$nc?>"  class="textos_titulos"></div>

<br>
<div style="float:none; margin-top:35px" id="condiciones"></div>

<script>
EnviarLinkJ('condiciones','modules/reports/rep_resumencompare.php?op=3&filtroid=<?=$_GET[idrep]?>');
EnviarLinkJ('GuardaResumen','modules/reports/rep_resumenguardar.php?idform=<?=$_GET[idform]?>&filtroid=<?=$_GET[idrep]?>');
</script>

<div id="GuardaResumen"></div>

<? } //aqui termina el por defecto sin ninguna opcion.
if( $_GET[op] == 2 ){
include '../../appcfg/general_config.php';

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------


$cdatos=explode("-",$varid);

if($cdatos[2]){

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


} else{ 

$CamposCFG = $sqlm->sql_select("acampos_esp","*","campon = '$cdatos[0]'",0);


if($CamposCFG[0][tipocampo] != "autocom" and $CamposCFG[0][tipocampo] != "select"){
	

$parametrosGrupoHerr=array(
	"tabla"=>$CamposCFG[0][tabla],
	"campo1"=>$cdatos[0],
	"campo2"=>$cdatos[0],
	"campoid"=>$cdatos[0],
	"condiorden"=>"1 GROUP BY $cdatos[0]");		

//print_r($parametrosGrupoHerr);

$cdatos[0] = "cme_".$cdatos[0];

		/*aqui enviamos los parametros al autocompletar.*/					}
else{
	
	$paramARR=explode(",",$CamposCFG[0][paramcampo]);
	$parametrosGrupoHerr=array(
	"tabla"=>$paramARR[0],
	"campo1"=>$paramARR[1],
	"campo2"=>$paramARR[2],
	"campoid"=>$paramARR[3],
	"condiorden"=>$paramARR[4]
					   

					   );
		/*aqui enviamos los parametros de los otros tipos de campo.*/						}
$cdatos[0] = "cme_".$cdatos[0];

 }
?>
<form name="forma1">

<select name="condicion" id="condicion">
<option value="=" selected="selected">Igual</option>
  <option value="!=">Diferente</option>
</select>

<? echo $formulario->c_Auto_select("","valor","","","",$parametrosGrupoHerr,1,"Valor: ","",0,35); ?>
<input name="campon" type="hidden" value="<?=$cdatos[0]?>" />
<input name="filtroid" type="hidden" value="<?=$_GET[idfiltro]?>" />		
<input type="button" onclick="EnviarLinkForm('condiciones','<?=$RAIZHTTP?>/modules/reports/rep_resumencompare.php?op=3',document.forma1);document.forma1.reset()" name="ok" id="ok" value="Agregar" />

<label for="checkbox"></label>
</form>

<? 
}if($_GET[op] == 3){ 
include '../../appcfg/general_config.php';

if($_GET[condicion] != ""){
	
//$condicion = "$campon $condicion '$valor_hidden'";
$GuardaCondi = $sqlm->inser_data("repdina_compare","campo,condicion,valor,idrelconfig","'$_GET[campon]','$_GET[condicion]','$_GET[valor_hidden]','$_GET[filtroid]'",0);

}


if($_GET[del] == 1){
	
//$condicion = "$campon $condicion '$valor_hidden'";
mysql_query("DELETE FROM repdina_compare WHERE id_compare = '$_GET[idcondicion]'");
}


//-----------qio borramos el filtro plantilla si se requiere

$TraeCondiciones = $sqlm->sql_select("repdina_compare,repdina_config","*","idrelconfig = '$_GET[filtroid]' AND idrelconfig = id_rep",0);

$TablaData= $sqlm->sql_select("autoform_tablas","*","campaignid = '".$TraeCondiciones[0][id_cam]."'",0);


for($i=0 ; $i<count($TraeCondiciones);$i++){
	
	//interceptamos y comparamos si el campo es de modulo espesial o de los normales
	if(substr($TraeCondiciones[$i][campo],0,4) == "cme_"){ 

@$CampoData = $sqlm->sql_select("acampos_esp","*","campon = '".substr($TraeCondiciones[$i][campo],4,20)."'",0);
	$ARRtablas[] = $CampoData[0][tabla];
	$ArrCondiciones[] = $CampoData[0][tabla].".idregistro = ".$TablaData[0][campoid];
	$TraeCondiciones[$i][campo] = substr($TraeCondiciones[$i][campo],4,20);
	
	 }else { 

@$CampoData = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$TraeCondiciones[$i][campo]."'",0);

			}


?>

<div id="condi<?=$i?>" align="center" style="margin-top:5px" class="rounded-corners-blue"><?=$CampoData[0][labelcampo]." ".$TraeCondiciones[$i][condicion]?> 

<?
if($TraeCondiciones[$i][valor] != ""){
echo $formulario_auto->armar_campo($CampoData[0][tipocampo],$TraeCondiciones[$i][campo],"",$TraeCondiciones[$i][valor],0,1,0,$CampoData[0][paramcampo]);
}else{ echo "Vacio"; }
?> 

<a href="javascript:EnviarLinkJ('condiciones','modules/reports/rep_resumencompare.php?op=3&filtroid=<?=$_GET[filtroid]?>&del=1&idcondicion=<?=$TraeCondiciones[$i][id_compare]?>');"><img style="float:right; margin-left:5px" src="<?=$RAIZHTTPCONF?>/imgs/delimg.png" width="16" height="16" /></a></div>

<?
$condiciones .= " AND ".$TraeCondiciones[$i][campo]." ".$TraeCondiciones[$i][condicion]." '".$TraeCondiciones[$i][valor]."'";

 } /*Aqui termino el for que muestra los filtro*/ 

//aqui traemos las tablas de los complementarios, esta parte sirve tambien para la funcion

if(is_array($ARRtablas))	{ 

		$NuevoARRtablas = array_unique($ARRtablas);
		$TablasNuevas = implode(",",$NuevoARRtablas);
		$TablasNuevas = ",".$TablasNuevas;
		
		$NuevoArrCondiciones = array_unique($ArrCondiciones);
		$CondicionesNuevas = implode(" AND ",$NuevoArrCondiciones);
		$CondicionesNuevas = " AND ".$CondicionesNuevas;

							 }


$Reduldado = $sqlm->sql_select($TablaData[0][nombretabla].$TablasNuevas,"COUNT(".$TablaData[0][campoid].") as cuenta","1 $condiciones $CondicionesNuevas",0);
?>

<div align="center" class="rounded-corners-gray">Registros Con Este Filtro: <?=$Reduldado[0][cuenta]?></div>

<? }
?>