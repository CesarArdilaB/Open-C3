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
	"direccion"=>"modules/agenda/config_campos.php?op=1");
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


$InvConf = $sqlm->sql_select("agenda_camconfig","*","idcampana = $varid",0);

if(is_array($InvConf)){
	
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][labelc]."'",0);
if(is_array($Cname)){ $labelc				= $Cname[0][labelcampo]; }

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][cedulac]."'",0);
if(is_array($Cname)){ $cedulac 			= $Cname[0][labelcampo]; }

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][nombrec]."'",0);
if(is_array($Cname)){ $nombrec		 	= $Cname[0][labelcampo]; }

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][datosterc]."'",0);
if(is_array($Cname)){ $datosterc 			= $Cname[0][labelcampo]; }

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][direccionenc]."'",0);
if(is_array($Cname)){ $direccionenc 		= $Cname[0][labelcampo]; }

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][tipoentregac]."'",0);
if(is_array($Cname)){ $tipoentregac		= $Cname[0][labelcampo]; }

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][obsevacionesc]."'",0);
if(is_array($Cname)){ $obsevacionesc		= $Cname[0][labelcampo]; }
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][barrioc]."'",0);
if(is_array($Cname)){ $barrioc		= $Cname[0][labelcampo]; }
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][refmensajeroc]."'",0);
if(is_array($Cname)){ $refmensajeroc		= $Cname[0][labelcampo]; }
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][campanac]."'",0);
if(is_array($Cname)){ $campanac		= $Cname[0][labelcampo]; }
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][tipogestionc]."'",0);
if(is_array($Cname)){ $tipogestionc		= $Cname[0][labelcampo]; }
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][mesgestionc]."'",0);
if(is_array($Cname)){ $mesgestionc		= $Cname[0][labelcampo]; }
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][codigooficinac]."'",0);
if(is_array($Cname)){ $codigooficinac		= $Cname[0][labelcampo]; }
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][gestioncallc]."'",0);
if(is_array($Cname)){ $gestioncallc		= $Cname[0][labelcampo]; }
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][documentossolc]."'",0);
if(is_array($Cname)){ $documentossolc		= $Cname[0][labelcampo]; }
	
$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][ciudadc]."'",0);
if(is_array($Cname)){ $ciudadc		= $Cname[0][labelcampo]; }

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][codigosoc]."'",0);
if(is_array($Cname)){ $codigosoc		= $Cname[0][labelcampo]; }

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][emailc]."'",0);
if(is_array($Cname)){ $emailc		= $Cname[0][labelcampo]; }

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][movilc]."'",0);
if(is_array($Cname)){ $movilc		= $Cname[0][labelcampo]; }

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][movil2c]."'",0);
if(is_array($Cname)){ $movil2c		= $Cname[0][labelcampo]; }

$Cname = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '".$InvConf[0][tipoentregainic]."'",0);
if(is_array($Cname)){ $tipoentregainic= $Cname[0][labelcampo]; }


	}


?>
<table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
  <tr>
    <td>Asignar los campos de los formularios de la campaña <b>
      <?=$CampConfig[nombreCam]?>
    </b> al modulo de agenda</td>
  </tr>
</table>
<table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
  <tr>
    <td align="center" bgcolor="#FFFFFF" class="textos_negros">Campo del Modulo</td>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Campo Asignado</td>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Acciones</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Label</td>
    <td bgcolor="#FFFFFF" class="textos">

<? 

genera_modalF("labelc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $labelc;

?></td>
    <td bgcolor="#FFFFFF"><a class="labelc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=labelc&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Cedula</td>
    <td bgcolor="#FFFFFF" class="textos">
    
<? 

genera_modalF("cedulac",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $cedulac;

?></td>
    <td bgcolor="#FFFFFF"><a class="cedulac" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=cedulac&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Nombre del cliente</td>
    <td bgcolor="#FFFFFF" class="textos">
    
<? 

genera_modalF("nombrec",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $nombrec;

?></td>
    <td bgcolor="#FFFFFF"><a class="nombrec" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=nombrec&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Datos tercero autorizado</td>
    <td bgcolor="#FFFFFF">
    
      <p class="textos">
        <? 

genera_modalF("datosterc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $datosterc;

?>
      </p>

    
    </td>
    <td bgcolor="#FFFFFF"><a class="datosterc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=datosterc&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Direccion de entrega</td>
    <td bgcolor="#FFFFFF" class="textos">

<? 

genera_modalF("direccionenc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $direccionenc;

?></td>
    <td bgcolor="#FFFFFF"><a class="direccionenc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=direccionenc&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Tipo entrega</td>
    <td bgcolor="#FFFFFF" class="textos">
    
<? 

genera_modalF("tipoentregac",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $tipoentregac;

?></td>
    <td bgcolor="#FFFFFF"><a class="tipoentregac" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=tipoentregac&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Tipo Entrega Inicial</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("tipoentregainic",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $tipoentregainic;

?></td>
    <td bgcolor="#FFFFFF"><a class="tipoentregac" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=tipoentregainic&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Observaciones Call</td>
    <td bgcolor="#FFFFFF" class="textos">
    
<? 

genera_modalF("obsevacionesc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $obsevacionesc;

?></td>
    <td bgcolor="#FFFFFF"><a class="obsevacionesc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&cins=obsevacionesc&idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Barrio</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("barrioc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $barrioc;

?></td>
    <td bgcolor="#FFFFFF"><a class="barrioc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=barrioc&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Ref Mensajero</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("refmensajeroc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $refmensajeroc;

?></td>
    <td bgcolor="#FFFFFF"><a class="refmensajeroc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=refmensajeroc&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Campana</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("campanac",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $campanac;

?></td>
    <td bgcolor="#FFFFFF"><a class="campanac" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=campanac&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Tipo gestion</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("tipogestionc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $tipogestionc;

?></td>
    <td bgcolor="#FFFFFF"><a class="tipogestionc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=tipogestionc&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Mes gestion</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("mesgestionc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $mesgestionc;

?></td>
    <td bgcolor="#FFFFFF"><a class="mesgestionc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=mesgestionc&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Codigo oficina</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("codigooficinac",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $codigooficinac;

?></td>
    <td bgcolor="#FFFFFF"><a class="codigooficinac" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=codigooficinac&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Gestion Call</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("gestioncallc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $gestioncallc;

?></td>
    <td bgcolor="#FFFFFF"><a class="gestioncallc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=gestioncallc&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Documentos a solicitar</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("documentossolc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $documentossolc;

?></td>
    <td bgcolor="#FFFFFF"><a class="documentossolc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=documentossolc&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Ciudad</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("ciudadc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $ciudadc;

?></td>
    <td bgcolor="#FFFFFF"><a class="ciudadc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=ciudadc&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Codigos de Oficinas</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("codigosoc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $codigosoc;

?></td>
    <td bgcolor="#FFFFFF"><a class="codigosoc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=codigosoc&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Email</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("emailc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $emailc;

?></td>
    <td bgcolor="#FFFFFF"><a class="emailc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=emailc&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Telefono Movil</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("movilc",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $movilc;

?></td>
    <td bgcolor="#FFFFFF"><a class="movilc" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=movilc&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>  <tr>
    <td bgcolor="#FFFFFF" class="textos_negros">Telefono Movil 2</td>
    <td bgcolor="#FFFFFF" class="textos"><? 

genera_modalF("movil2c",350,450,"modules/agenda/config_campos.php?op=1&varid=$varid","MuestraCampos"); 
echo $movil2c;

?></td>
    <td bgcolor="#FFFFFF"><a class="movil2c" href="modules/agenda/config_fields.php?formid=<?=$CampConfig[idForm]?>&amp;cins=movil2c&amp;idcam=<?=$varid?>">Configurar Campo</a></td>
  </tr>
</table>


<? } ?>