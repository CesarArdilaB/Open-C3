<?
if($_GET[op] != 1 and $_GET[op] != 2){

@include("../../appcfg/general_config.php");

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
  <tr>
    <td class="textos_negros">Seleccione una Campaña</td>
    <td><? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"1",
	"direccion"=>"modules/inventarios/config_campos.php?op=1");
	echo $formulario->select_envia_link("","id_campaign","","","",$parametrosGrupoHerr,0,"","MuestraCampos"); ?></td>
  </tr>
</table>
<br />
<br />
<div id="MuestraCampos"></div>

<?
} if($_GET[op] == 1){

@include("../../appcfg/general_config.php");

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------

$CampConfig = $campanaC->campana_config($varid);


$InvConf = $sqlm->sql_select("inv_camconfig","*","idcampana = $varid",0);

if(is_array($InvConf)){
	
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][clote]."'",0);
if(is_array($Cname)){ $clote 				= $Cname[0][labelcampo];}

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][cguiain]."'",0);
if(is_array($Cname)){ $cguiain 			= $Cname[0][labelcampo];}

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][cdiasmaxentrega]."'",0);
if(is_array($Cname)){ $cdiasmaxentrega 	= $Cname[0][labelcampo];}

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][cbolsain]."'",0);
if(is_array($Cname)){ $cbolsain 			= $Cname[0][labelcampo];}

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][cpseudocodigo]."'",0);
if(is_array($Cname)){ $cpseudocodigo 		= $Cname[0][labelcampo];}

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][cbolsaout]."'",0);
if(is_array($Cname)){ $cbolsaout 			= $Cname[0][labelcampo];}

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][cguiaout]."'",0);
if(is_array($Cname)){ $cguiaout 			= $Cname[0][labelcampo];}
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][gestioncallc]."'",0);
if(is_array($Cname)){ $gestioncallc 			= $Cname[0][labelcampo];}
	
	}


?>
<table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
  <tr>
    <td>Asignar los campos de los formularios de la campaña <b>
      <?=$CampConfig[nombreCam]?>
    </b> al modulo de inventarios</td>
  </tr>
</table>
<table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
  <tr>
    <td align="center" bgcolor="#FFFFFF" class="textos_negros">Campo del Modulo</td>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Campo Asignado</td>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Acciones</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Lote</td>
    <td bgcolor="#FFFFFF" class="textos">

<? 

genera_modalF("AddLote",350,450,"modules/inventarios/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $clote;

?></td>
    <td bgcolor="#FFFFFF"><a class="AddLote" href="modules/inventarios/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=clote&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Numero de guia</td>
    <td bgcolor="#FFFFFF" class="textos">
    
<? 

genera_modalF("cguiain",350,450,"modules/inventarios/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $cguiain;

?></td>
    <td bgcolor="#FFFFFF"><a class="cguiain" href="modules/inventarios/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=cguiain&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Tiempo maximo de entrega</td>
    <td bgcolor="#FFFFFF" class="textos">
    
<? 

genera_modalF("cdiasmaxentrega",350,450,"modules/inventarios/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $cdiasmaxentrega;

?></td>
    <td bgcolor="#FFFFFF"><a class="cdiasmaxentrega" href="modules/inventarios/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=cdiasmaxentrega&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Bolsa de seguridad</td>
    <td bgcolor="#FFFFFF">
    
      <p class="textos">
        <? 

genera_modalF("cbolsain",350,450,"modules/inventarios/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $cbolsain;

?>
      </p>

    
    </td>
    <td bgcolor="#FFFFFF"><a class="cbolsain" href="modules/inventarios/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=cbolsain&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Pseudocodigo</td>
    <td bgcolor="#FFFFFF" class="textos">

<? 

genera_modalF("cpseudocodigo",350,450,"modules/inventarios/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $cpseudocodigo;

?></td>
    <td bgcolor="#FFFFFF"><a class="cpseudocodigo" href="modules/inventarios/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=cpseudocodigo&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Bolsa de seguridad de salida</td>
    <td bgcolor="#FFFFFF" class="textos">
    
<? 

genera_modalF("cbolsaout",350,450,"modules/inventarios/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $cbolsaout;

?></td>
    <td bgcolor="#FFFFFF"><a class="cbolsaout" href="modules/inventarios/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=cbolsaout&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Numero de guia de salida</td>
    <td bgcolor="#FFFFFF" class="textos">
    
<? 

genera_modalF("cguiaout",350,450,"modules/inventarios/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $cguiaout;

?></td>
    <td bgcolor="#FFFFFF"><a class="cguiaout" href="modules/inventarios/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=cguiaout&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Gestion Call</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("gestioncallc",350,450,"modules/inventarios/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $gestioncallc;

?></td>
    <td bgcolor="#FFFFFF"><a class="gestioncallc" href="modules/inventarios/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=gestioncallc&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
</table>


<? } ?>