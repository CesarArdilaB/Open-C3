<? 
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1 and $_GET[importar] != 1 and $_POST[impop] != 1){ 
?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center">
  <h3>Programar Carga Automatica de Bases</h3>
</div>
<br>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="2"  class="rounded-corners-gray">
  <tr>
    <td valign="top" bgcolor="#FFFFFF" class="textos_titulos">Seleccione una campana</td>
    <td valign="top" bgcolor="#FFFFFF"><? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"1",
	"direccion"=>"modules/cronjobs/carga_bases.php?op=1");
	echo $formulario->select_envia_link("","id_campaign","","","",$parametrosGrupoHerr,0,"","ListaForms"); ?>
    &nbsp;</td>
    <td valign="top" bgcolor="#FFFFFF" class="textos_titulos">Seleccione Un Formulario</td>
    <td valign="top" bgcolor="#FFFFFF"><div id="ListaForms"></div></td>
  </tr>
  <tr>
    <td colspan="4" valign="top" bgcolor="#FFFFFF" class="textos_titulos">Seleccione una plantilla</td>
  </tr>
  <tr>
    <td colspan="4" valign="top"><div id="ListaPlantilla"></div></td>
  </tr>
</table>
<? }
if($_GET[op] == 1){ 
include '../../appcfg/general_config.php';
?>


<? $parametrosGrupoHerr=array(
	"tabla"=>"autoform_tablas",
	"campo1"=>"labeltabla",
	"campo2"=>"labeltabla",
	"campoid"=>"id_autoformtablas",
	"condiorden"=>"campaignid = '$_POST[varid]'",
	"direccion"=>"modules/cronjobs/carga_bases.php?op=2");
	echo $formulario->select_envia_link("","id_form","","","",$parametrosGrupoHerr,0,"","ListaPlantilla"); ?>
    
    
<? } 
if($_GET[op] == 2){ 
include '../../appcfg/general_config.php';

$ImpCampos = $sqlm->sql_select("importdata","*","idform  = '$_POST[varid]'",0);

?>
<form name="form1" onsubmit="EnviarLinkForm('ListaProgramas','<?=$RAIZHTTP?>/modules/cronjobs/carga_bases.php?op=3&idform=<?=$_POST[varid]?>',this);return false;">
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
    <? for($o=0 ; $o < count($ImpCampos) ; $o++ ){
		$camposL = "";
		
		$camposARR = explode(",",$ImpCampos[$o][campos]);
		
		for($i=0 ; $i < count($camposARR) ; $i++){//aqui hacemos la lista de campos para que la entienda el humano
		
		$camposIMP=$sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '$camposARR[$i]'",0); 
		
		if(is_array($camposIMP)){$camposL .= utf8_encode($camposIMP[0][labelcampo]).",";}
				
		}//aqui hacemos la lista de campos para que la entienda el humano
		
		$camposL = substr($camposL,0,-1);
		$camposN = $ImpCampos[$o][campos];
?>
    <tr>
      <td width="112" bgcolor="#FFFFFF" class="textospadding"><div>Plantilla <?=$o?></div></td>
      <td width="539" bgcolor="#FFFFFF" class="textospadding"><?=$camposL?>
        &nbsp;</td>
      <td width="39" align="center" bgcolor="#FFFFFF" class="textospadding"><input type="radio" name="plantillaSel" id="radio" value="<?=$ImpCampos[$o][id_importdata]?>"></td>
    </tr>
    <?  }?>
    <tr>
      <td colspan="3" align="center" bgcolor="#FFFFFF" class="textospadding"><table border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td class="textos_negros">Fecha</td>
          <td><span class="textos_titulos">
            <?=$formulario->c_fecha_input("","fecha_prog","","")?>
          </span></td>
          <td class="textos_negros">Hora</td>
          <td><select name="hora" id="hora">
<option value="0" selected="selected">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
          </select></td>
          <td><input type="submit" name="button" id="button" value="Guardar"></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="3" align="center" bgcolor="#FFFFFF" class="textospadding"><div id="ListaProgramas"></div></td>
    </tr>

  </table>
</form> 
<script>
EnviarLinkJ('ListaProgramas','<?=$RAIZHTTP?>/modules/cronjobs/carga_bases.php?op=3&idform=<?=$_POST[varid]?>');
</script> 
 
<? }if($_GET[op] == 3){ 
include '../../appcfg/general_config.php';

if($_GET[del] != ""){ 

$SelDel = $sqlm->sql_select("cron_import","nombre_archivo","id_cronimport = $_GET[del]",0);

if(is_array($SelDel)){ unlink($RAIZ."/tmp/files/".$SelDel[0][nombre_archivo]); }

mysql_query("DELETE FROM cron_import WHERE id_cronimport = $_GET[del]"); 

}


if($_GET[fecha_prog] != ""){

$sqlm->inser_data("cron_import","idplantilla,fecha,hora","'$_GET[plantillaSel]','$_GET[fecha_prog]','$_GET[hora]'",0);

}

$FormsCorns = $sqlm->sql_select("cron_import,importdata","*","idform = $_GET[idform] AND id_importdata = idplantilla",0);

if(is_array($FormsCorns)){
?>

<table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
  <tr>
    <td align="center" class="textos_titulos">Fecha</td>
    <td align="center" class="textos_titulos">Hora</td>
    <td align="center" class="textos_titulos">Campos</td>
    <td align="center" class="textos_titulos">Archivo</td>
    <td align="center" class="textos_titulos">Eliminar</td>
  </tr>
<? 

for( $i = 0 ; $i < count($FormsCorns) ; $i++ ){ 

		$camposL = "";
		
		$camposARR = explode(",",$FormsCorns[$i][campos]);
		
		for($o=0 ; $o < count($camposARR) ; $o++){//aqui hacemos la lista de campos para que la entienda el humano
		
		$camposIMP=$sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '$camposARR[$o]'",0); 
		
		if(is_array($camposIMP)){$camposL .= utf8_encode($camposIMP[0][labelcampo]).",";}
				
		}//aqui hacemos la lista de campos para que la entienda el humano
		
		$camposL = substr($camposL,0,-1);
		$camposN = $ImpCampos[$o][campos];


?>

  <tr>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$FormsCorns[$i][fecha]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding"><?=$FormsCorns[$i][hora]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding"><?=$camposL?></td>
    <td bgcolor="#FFFFFF" class="textospadding">
      <? 
	genera_modalF("Subefile$i",350,200,"modules/cronjobs/carga_bases.php?op=3&idform=$_GET[idform]","ListaProgramas"); 
	if($FormsCorns[$i][nombre_archivo] == ""){ ?>
      
      <a class="Subefile<?=$i?>" href="modules/cronjobs/carga_uploadf.php?idcron=<?=$FormsCorns[$i][id_cronimport]?>">Subir Archivo</a>
      
      <? }else{
		
	echo $FormsCorns[$i][nombre_archivo];
		
	}
	
	?>
    </td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding">
    <a href="javascript:EnviarLinkJ('ListaProgramas','<?=$RAIZHTTP?>/modules/cronjobs/carga_bases.php?op=3&idform=<?=$_GET[idform]?>&del=<?=$FormsCorns[$i][id_cronimport]?>');"><img src='imgs/delimg.png'></img></a>
    </td>
  </tr>
<?  } ?>
</table>
<? }/*aqui esta esto*/ } ?>