<? 
session_start();

if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1){ 

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<meta charset="utf-8">
	
<div class="textosbig" align="center">
  <h3>Asignacion de Metas</h3>
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
	"direccion"=>"modules/campaigns/metas_config.php?op=1");
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
if( $_GET[op] == 1 ){ 

include '../../appcfg/general_config.php';
$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->ValFormScripts();

$GruposLista 		= 	$sqlm->sql_select("agents_group","*","campana = '$_POST[varid]'",0);
$FormulariosLista 	= 	$sqlm->sql_select("autoform_tablas","*","campaignid = '$_POST[varid]'",0);

?>
<script>
EnviarLinkJ('MetasMostrar','modules/campaigns/metas_config.php?op=3&campanaid=<?=$varid?>')
</script>
<form action="" onsubmit="EnviarLinkForm('MetasMostrar','<?=$RAIZHTTP?>/modules/campaigns/metas_config.php?op=3',this);return false;">
  <div align="center">
    <table border="0" align="center" cellpadding="3" cellspacing="1" class="rounded-corners-gray">
      <tr>
        <td class="textos_titulos">Seleccione&nbsp;Un Grupo</td>
        <td class="textos_titulos">Seleccione Un Campo</td>
        <td colspan="2" class="textos_titulos">Configure la Meta</td>
      </tr>
      <tr>
        <td rowspan="5" align="left" valign="top">
  <? for($i=0;$i < count($GruposLista);$i++){ ?>
  <div class="textos">
    <input type="checkbox" name="grupos[]" id="checkbox" value="<?=$GruposLista[$i][id_agents_group]?>" />
    <label for="grupos[]"><?=$GruposLista[$i][name]?></label>
  </div>
  <? } ?> &nbsp;</td>
        <td align="left" valign="top"><label for="select"></label>
          
          
  <select class=":required" name="campo" id="select" onchange="EnviarLinkJ('campovalores','modules/campaigns/metas_config.php?op=2',this.options[this.selectedIndex].value);">
    
    
    <option value="">Seleccione</option>
  <? for($i=0;$i < count($FormulariosLista);$i++){ 
$GruposLista 	= 	$sqlm->sql_select("autoform_grupos","*","idtabla_rel = '".$FormulariosLista[$i][id_autoformtablas]."' ORDER BY posiciongrupo",0);
?>
    <optgroup label="<?=$FormulariosLista[$i][labeltabla]?>"></optgroup>
    
  <? for($o=0;$o < count($GruposLista);$o++){ 
$CamposLista 	= 	$sqlm->sql_select("autoform_config","*","idgrupo = '".$GruposLista[$o][id_autoformgrupos]."' ORDER BY poscampo",0);
?>
    <optgroup label="-><?=$GruposLista[$o][labelgrupo]?>"></optgroup>
    
  <? for($e=0;$e < count($CamposLista);$e++){ ?>
  <option value="<?=$CamposLista[$e][nombrecampo]?>">----><?=$CamposLista[$e][labelcampo]?></option>
  <? }//terser for que saca los campo ?> 
    
  <? }//segundo for de donde sacamos los grupos. ?> 
    
  <? } //primer for de donde sacamos las tablas ?> 
    </select>
  <input name="campanaid" type="hidden" id="campanaid" value="<?=$varid?>" />
<div id="campovalores"></div>      
          
        </td>
        <td align="left" class="textospadding">Numero de Registros</td>
        <td align="left" class="textospadding"><input class=":required" name="NumeroReg" type="text" id="NumeroReg" size="5" maxlength="5" /></td>
      </tr>
      <tr>
        <td rowspan="4" align="left" valign="top">Seleccione el campo de la lista de agentes:
          <br />
          <select class=":required" name="campo_agentes" id="campo">
            <option value="1">Basar en la gestion de los agentes</option>
            <? for($i=0;$i < count($FormulariosLista);$i++){ 
$GruposLista 	= 	$sqlm->sql_select("autoform_grupos","*","idtabla_rel = '".$FormulariosLista[$i][id_autoformtablas]."' ORDER BY posiciongrupo",0);
?>
            <optgroup label="<?=$FormulariosLista[$i][labeltabla]?>"></optgroup>
            <? for($o=0;$o < count($GruposLista);$o++){ 
$CamposLista 	= 	$sqlm->sql_select("autoform_config","*","idgrupo = '".$GruposLista[$o][id_autoformgrupos]."' ORDER BY poscampo",0);
?>
            <optgroup label="-&gt;<?=$GruposLista[$o][labelgrupo]?>"></optgroup>
            <? for($e=0;$e < count($CamposLista);$e++){ ?>
            <option value="<?=$CamposLista[$e][nombrecampo]?>">----&gt;
            <?=$CamposLista[$e][labelcampo]?>
            </option>
            <? }//terser for que saca los campo ?>
            <? }//segundo for de donde sacamos los grupos. ?>
            <? } //primer for de donde sacamos las tablas ?>
        </select></td>
        <td align="left" class="textospadding">Valor Por Registro</td>
        <td align="left" class="textospadding"><input class="" name="valorreg" type="text" id="valorreg" size="10" maxlength="10" />
        o En intervalos 
        <select name="intervalo" id="intervalo">
          <option value="--">Seleccione</option>
          <option value="month">Mensual</option>
          <option value="wek">Semanal</option>
          <option value="day">Diario</option>
        </select></td>
      </tr>
      <tr>
        <td align="left" class="textospadding">Aplica desde </td>
        <td align="left" class="textospadding"><?=$formulario->c_fecha_input("","fdesde","","")?></td>
      </tr>
      <tr>
        <td align="left" class="textospadding">hasta</td>
        <td align="left" class="textospadding"><?=$formulario->c_fecha_input("","fhasta","","")?></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" name="ok" id="ok" value="Guardar" /></td>
      </tr>
    </table>
  </div>
</form>



<div id="MetasMostrar"></div>

<? } 
if($_GET[op] == 2){
include '../../appcfg/general_config.php';

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

<? echo $formulario->c_Auto_select("","valor","","","",$parametrosGrupoHerr,1,"Valor: ","",0,35); ?>
<br />
<input name="valcontador" type="checkbox" id="valcontador" value="1" />
Usar el valor de este campo como contador.
<? }
if($_GET[op] == 3){
include '../../appcfg/general_config.php';	

for($i=0 ; $i < count($_GET[grupos]) ; $i++){ $gruposC .= $_GET[grupos][$i].","; }

if(isset($_GET[valorreg])){//-----------------



if($_GET[intervalo] != "--"){ $valorReg = $_GET[intervalo]; }else{ $valorReg = $_GET[valorreg]; }
$Guardar = $sqlm->inser_data("metas_config","grupos,campo,valor,numero,idcampana,valorreg,fdesde,fhasta,valcontador,campo_agentes","'$gruposC','$_GET[campo]','$_GET[valor_hidden]','$_GET[NumeroReg]','$_GET[campanaid]','$_GET[valorReg]','$_GET[fdesde]','$_GET[fhasta]','$_GET[valcontador]','$_GET[campo_agentes]'",0);
}//-------------------------------

$SeleccionaMetas = $sqlm->sql_select("metas_config","*","idcampana = '$_GET[campanaid]'",0);

?>
	<div align="center">
   <hr>
<? if(is_array($SeleccionaMetas)){ ?>   
	  <table border="0" align="center" cellpadding="3" cellspacing="1" class="rounded-corners-gray">
	    <tr>
	      <td align="center" class="textos_titulos">Grupos</td>
	      <td align="center" class="textos_titulos">Campo y Valor</td>
	      <td align="center" class="textos_titulos">Meta</td>
	      <td align="center" class="textos_titulos">Valor</td>
	      <td align="center" class="textos_titulos">Contador?</td>
	      <td align="center" class="textos_titulos">Rango de Fechas</td>
	      <td align="center" class="textos_titulos">Acciones</td>
        </tr>
<? for($i=0;$i < count($SeleccionaMetas);$i++){ 

$GruposCadena = "";

$CampoData = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$SeleccionaMetas[$i][campo]."'",0);
$valor = $formulario_auto->armar_campo(@$CampoData[0][tipocampo],@$CampoData[0][nombrecampo],"",$SeleccionaMetas[$i][valor],0,1,0,@$CampoData[0][paramcampo]);

$gruposARR = explode(",",$SeleccionaMetas[$i][grupos]);

for($o=0; $o < count($gruposARR) ; $o++){
	
$GruposData = $sqlm->sql_select("agents_group","name","id_agents_group = '".$gruposARR[$o]."'",0);
	if(is_array($GruposData)){ $GruposCadena .= $GruposData[0][name]."<br>";}	
		}
	
$GruposCadena = substr($GruposCadena,0,-4);

genera_modalF("Link$i",1000,600,"modules/campaigns/metas_config.php?op=3&campanaid=$_GET[campanaid]",'MetasMostrar'); ?>
	    <tr>
	      <td align="center" valign="middle" bgcolor="#FFFFFF" class="textospadding"><?=$GruposCadena?>&nbsp;</td>
	      <td align="center" valign="middle" bgcolor="#FFFFFF" class="textospadding"><?=$CampoData[0][labelcampo]?> = <?=$valor?>&nbsp;</td>
	      <td align="center" valign="middle" bgcolor="#FFFFFF" class="textospadding"><?=$SeleccionaMetas[$i][numero]?>&nbsp;</td>
	      <td align="center" valign="middle" bgcolor="#FFFFFF" class="textospadding">
          
          <? 
		  
		  if(is_numeric($SeleccionaMetas[$i][valorreg])){ echo number_format($SeleccionaMetas[$i][valorreg],0,"",".");}
		  
		  else{
			  
			  switch($SeleccionaMetas[$i][valorreg]){
				  
				  case "wek";
				  
				  echo "Semanal";
				  
				  break;
				  
				  case "month";
				  
				  echo "Mensual";
				  
				  break;
				  
				  case "day";
				  
				  echo "Diario";
				  
				  break;
				  
				  
				  
				  
				  }
			  
			  
			  
			  }
		  
		  ?>
          
          </td>
	      <td align="center" valign="middle" bgcolor="#FFFFFF" class="textospadding"><? if($SeleccionaMetas[$i][valcontador] == 1){echo "Si";}else{ echo "No"; } ?>&nbsp;</td>
	      <td align="center" valign="middle" bgcolor="#FFFFFF" class="textospadding"><?=$SeleccionaMetas[$i][fdesde]?> - 
          <?=$SeleccionaMetas[$i][fhasta]?></td>
	      <td align="center" valign="middle" bgcolor="#FFFFFF" class="textospadding"><a class="Link<?=$i?>" href="modules/campaigns/metas_report_vewer.php?idmetas=<?=$SeleccionaMetas[$i][id_metas]?>">Ver Reporte</a> - 
	        <? genera_modalF("linkinterval$i",1000,600,"modules/campaigns/metas_config.php?op=3&campanaid=$_GET[campanaid]",'MetasMostrar'); ?>
          <a class="linkinterval<?=$i?>" href="modules/campaigns/metas_config_interval.php?idmetas=<?=$SeleccionaMetas[$i][id_metas]?>"> Intervalos para Valores</a> - 
          <? genera_modalF("delete$i",500,250,"modules/campaigns/metas_config.php?op=3&campanaid=$_GET[campanaid]",'MetasMostrar'); ?>
          <a class="delete<?=$i?>" href="modules/campaigns/metas_delete.php?idmetas=<?=$SeleccionaMetas[$i][id_metas]?>" >Eliminar</a></td>
        </tr>
<? } ?> 
  </table>
<? } //iff de array?>
</div>

<? }//aqui termina la opcion 3