<? 
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1 and $_GET[importar] != 1 and $_POST[impop] != 1){ 
?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center">
  <h3>Configurar Contadores</h3>
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
	"direccion"=>"modules/agenda/contador.php?op=1");
	echo $formulario->select_envia_link("","id_campaign","","","",$parametrosGrupoHerr,0,"","ListaConfigs"); ?>
    &nbsp;</td>
    <td valign="top" bgcolor="#FFFFFF"><div id="ListaConfigs"></div></td>
  </tr>
</table>
<? }
if($_GET[op] == 1){ 
include '../../appcfg/general_config.php';

if($_POST[varid] != "" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid];  }//-----------------


if($_GET[numero_tipicaciones] != ""){
	
	
$Verif = $sqlm->sql_select("contador_config","id_contadorcfg","idcampana = $varid",0);
	
	if(is_array($Verif)){
	
$sqlm->update_regs("contador_config","`numero_tipicaciones` = '$_GET[numero_tipicaciones]' , `numero_estados` = '$_GET[numero_estados]'","idcampana = '$varid'",0);
	
	}else {
	
$sqlm->inser_data("contador_config","numero_tipicaciones,numero_estados,idcampana","'$_GET[numero_tipicaciones]','$_GET[numero_estados]',$varid",0);	
		
	}

	
	
	}

$SelConfig = $sqlm->sql_select("contador_config","*","idcampana = $varid",0);

if(is_array($SelConfig)){
	
	$ntipi 		= $SelConfig[0][numero_tipicaciones];
	$nestados 	= $SelConfig[0][numero_estados];
	
	}

?>

<div align="center">
  <form name="form1" onsubmit="EnviarLinkForm('ListaConfigs','<?=$RAIZHTTP?>/modules/agenda/contador.php?op=1&varid=<?=$varid?>',this);return false;">
    <table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td class="textos_titulos">Numero de tipificaciones</td>
        <td><input name="numero_tipicaciones" type="text" id="numero_tipicaciones" value="<?=$ntipi?>" size="2" maxlength="2"></td>
      </tr>
      <tr>
        <td class="textos_titulos">Numero de estados courier</td>
        <td><input name="numero_estados" type="text" id="numero_estados" value="<?=$nestados?>" size="2" maxlength="2"></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" name="ok" id="ok" value="Guardar"></td>
      </tr>
    </table>
  </form>
</div>
   
    
<? } ?>