<? 
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1 and $_GET[importar] != 1 and $_POST[impop] != 1){ 
?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center">
  <h3>Formularios de Campaña</h3>
</div>
<br>
<table border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top"><table border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td class="textos_titulos">Seleccione Una Campaña</td>
        </tr>
      <tr>
        <td>
     <div align="center">
	<? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"1",
	"direccion"=>"modules/campaigns/form_manager.php?op=1");
	echo $formulario->select_envia_link("","id_campaign","","","",$parametrosGrupoHerr,0,"","MuestraForms"); ?>
    </div>	</td>
      </tr>
      <tr>
        <td>
        <div class="textos_titulos" id="MuestraForms"></div>
        </td>
      </tr>
    </table></td>
    <td valign="top" class="rounded-corners-gray">
<div id="FormAdminA"></div>
<center><hr></center>
<div id="FormAdminB" align="center" class="rounded-corners-blanco"></div>
	</td>
  </tr>
</table>




<? }if($_GET[op] == 1){
	
include '../../appcfg/general_config.php';

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->ValFormScripts();
?>


<form onsubmit="EnviarLinkForm('FormList','<?=$RAIZHTTP?>/modules/campaigns/form_manager.php?op=2',this);this.reset();return false;">
Nuevo Formulario:<br />
<?=$formulario->c_text("","Nombre_Form","","","",1,"",10);?><input name="idcampaign" type="hidden" id="idcampaign" value="<?=$_POST[varid]?>" /><input name="Submit" type="submit" value="Ok" />
</form>


<br>
Formularios: 
<br>

<? 
$_GET[op]=3; }
if($_GET[op] == 2){ // guardamos el registro
include '../../appcfg/general_config.php';
$guardarForm = $sqlm->inser_data("autoform_tablas","labeltabla,nombretabla,campoid,tipotabla,campaignid,descripcion","'".$_GET[Nombre_Form]."','autof_".strtolower(str_replace(" ","",$_GET[Nombre_Form]))."_".$_GET[idcampaign]."','autof_".strtolower(str_replace(" ","",$_GET[Nombre_Form]))."_".$_GET[idcampaign]."_id','1','".$_GET[idcampaign]."','Generado automaticamente por el manejador de formularios de OpenC3'",0);

?>

<script>
EnviarLinkJ('FormList','modules/campaigns/form_manager.php?op=3&varid=<?=$_GET[idcampaign]?>');
</script>

<?

	}
if($_GET[op] == 3){ // se cierra el for que muestra los formularios

include_once '../../appcfg/general_config.php';
	
	if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------

	
	$seleccforms = $sqlm->sql_select("autoform_tablas","labeltabla,id_autoformtablas,nombretabla","tipotabla = 1 AND campaignid = $varid",0);
	for($i=0 ; $i < count($seleccforms) ; $i++){
	
	if($seleccforms == "No hay resultados"){ echo "No hay formularios."; }else{
		
$genFormC = mysql_query("SHOW COLUMNS FROM `".$seleccforms[$i]["nombretabla"]."`");

	

$formulario_auto->genera_modal($seleccforms[$i]["nombretabla"],500,420,$seleccforms[$i]["id_autoformtablas"]);



if($genFormC == ""){ $formC = "<a class='".$seleccforms[$i]["nombretabla"]."' href='modules/campaigns/form_sqlgen.php?formid=".$seleccforms[$i][id_autoformtablas]."&action=make'><img src='$RAIZHTTPCONF/imgs/guardar.gif' width='14' height='14' title='Generar Tablas En La Base De Datos!!' /></a>"; }
else { $formC = "<a class='".$seleccforms[$i]["nombretabla"]."' href='modules/campaigns/form_sqlgen.php?formid=".$seleccforms[$i][id_autoformtablas]."&action=update'><img src='$RAIZHTTPCONF/imgs/actualizar.gif' width='14' height='14' title='Actualizar Tablas En La Base De Datos!!' /></a>"; }


}		//verificador de formularios;
?>
<div id="FormList" class="textos">
<div>

<a href="javascript:EnviarLinkJ('FormAdminA','modules/campaigns/form_manager.php?op=4&idform=<?=@$seleccforms[$i]["id_autoformtablas"]?>');"><?=@$seleccforms[$i]["labeltabla"]?></a> -  <?=$formC?>

<ul style="margin-left:20px; list-style:circle;">
<li>
<a href="javascript:EnviarLinkJ('FormAdminA','modules/campaigns/form_manager.php?importar=1&idform=<?=@$seleccforms[$i]["id_autoformtablas"]?>');">Importar Datos.</a></li>
<!--<li><a href="javascript:EnviarLinkJ('FormAdminA','modules/campaigns/complementari_modules.php?idform=<?=@$seleccforms[$i]["id_autoformtablas"]?>');">Modulos Complementarios.</a></li>--></ul>
</div>
</div>
<? }// se cierra el for que muestra los formularios
} if($_GET[op]==4){
include '../../appcfg/general_config.php';
$formpro = $sqlm->sql_select("autoform_tablas","labeltabla,id_autoformtablas","id_autoformtablas  = $_GET[idform]",0);

?>
<script>
EnviarLinkJ('FormAdminB','modules/campaigns/form_manager.php?op=5&idform=<?=$_GET[idform]?>');
</script>
<samp class="textos_titulos">Configurando EL Formulario: <?=$formpro[0]["labeltabla"]?></samp>
<div>
<table width="100%" class="textos_titulos" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="textos_titulos">Grupos</td>
    <td rowspan="2" class="textos" width="20px"> 
    |<br />
    |<br />
    |<br />
    |<br />
    |<br />
    |<br />
    |<br />
    |<br />
    |<br />
    |<br />
    |<br />
    </td>
    <td class="textos_titulos">Campos</td>
  </tr>
  <tr>
    <td valign="top">
      <form id="form1" onsubmit="EnviarLinkForm('formcampos','<?=$RAIZHTTP?>/modules/campaigns/form_manager.php?addcampo=1&idform=<?=$formpro[0]["id_autoformtablas"]?>',this);this.reset();return false;">
        <?=$formulario->c_text("Nombre Grupo","labelgrupo","","textos","",1,"",25);?><br>
        
        <?=$formulario->c_text("Posicion","posiciongrupo","","textos","",1,"",2);?><br>
        
        <?=$formulario->c_text("Columnas","columnas","","textos","",1,"",2);?><br>
        
        <input name="visiblegrupo" type="radio" id="radio" value="1" checked="checked" />
        
        <label for="visiblegrupo" class="textos">Visible</label>
        
        <input type="radio" name="visiblegrupo" id="radio2" value="0" />
        
        <label for="visiblegrupo" class="textos">Oculto -</label> 
        
        <input type="submit" name="ok" id="ok" value="Agregar" />
        
        <input name="idtabla_rel" type="hidden" value="<?=$formpro[0]["id_autoformtablas"]?>" />
        
        </form>
      
      <script>
EnviarLinkJ('formcampos','modules/campaigns/form_manager.php?addcampo=1&idform=<?=$formpro[0]["id_autoformtablas"]?>');
</script>
    </td>
    <td valign="top">
      <div id="formcampos"></div>
    </td>
  </tr>

</table>
</div>
<? }if($_GET[op]==5){ 
include '../../appcfg/general_config.php';

if($_GET[labelcampo] != ""){	

$selmaxid = $sqlm->sql_select("autoform_config","MAX(id_autoform_config)+1 AS maximoID","1",0);


$guardarForm = $sqlm->inser_data("autoform_config","labelcampo,nombrecampo,poscampo,tipocampo,requerido,idgrupo,idtabla_rel,largo","'$_GET[labelcampo]','af$_GET[idtabla_rel]"."_".$selmaxid[0]["maximoID"]."','$_GET[poscampo]','$_GET[tipocampo]','$_GET[requerido]','$_GET[idgrupo]','$_GET[idtabla_rel]','$_GET[largo]'",0);


$idforma = $_GET[idtabla_rel];

}else{

$idforma = $_GET[idform];

}
?>
<span class="textos_titulos">Vista Previa</span>
<center><br>
<?=$formulario_auto->generar_form_ins($idforma,2,0,"",0,1);?> 
</center>
<? } ?>

<!--DE AQUI HACIA ABAJO VEMOS LA CONFIGURACION DE LOS CAMPOS COMO TAL-->

<? if($_GET[addcampo] == 1){

include '../../appcfg/general_config.php';


if($_GET[labelgrupo] != ""){	
$guardarForm = $sqlm->inser_data("autoform_grupos","labelgrupo,posiciongrupo,columnas,visiblegrupo,idtabla_rel","'".$_GET[labelgrupo]."','".$_GET[posiciongrupo]."','".$_GET[columnas]."','".$_GET[visiblegrupo]."','".$_GET[idtabla_rel]."'",0);

$idforma = $_GET[idtabla_rel];

}else{

$idforma = $_GET[idform];

}

?>   
    <form id="form1" onsubmit="EnviarLinkForm('FormAdminB','<?=$RAIZHTTP?>/modules/campaigns/form_manager.php?op=5&idform=<?=$_GET[idforma]?>',this);this.reset();return false;">
  	
	<?=$formulario->c_text("Etiqueta del Campo","labelcampo","","textos","",1,"",25);?><br>
    
    <label class="textos">Tipo de Campo</label> <select name="tipocampo">
      <option value="" selected="selected">Seleccione</option>
      <option value="text">Texto O Numero</option>
      <option value="textarea">Area De Texto</option>
      <option value="select">Lista de Seleccion</option>
      <option value="autocom">Lista de Autocompletar</option>
      <option value="check">Chekeo</option>
      <option value="fecha">Fecha</option>
    </select><br>
	
    <? $parametrosGrupoHerr=array(
	"tabla"=>"autoform_grupos",
	"campo1"=>"labelgrupo",
	"campo2"=>"labelgrupo",
	"campoid"=>"id_autoformgrupos",
	"condiorden"=>"idtabla_rel = '".$idforma."'");
	echo $formulario->c_select("Grupo Del Campo","idgrupo","","textos","",$parametrosGrupoHerr,0,"","MuestraForms"); ?>
    
    <br>
    <?=$formulario->c_text("Largo en Caracteres","largo","","textos",15,1,"",2);?>
    <br>
    
    <?=$formulario->c_text("Posicion","poscampo","","textos","",1,"",2);?>
    
    <label class="textos">Requerido</label><input name="requerido" type="checkbox" value=":required" />
    	
    <input name="idtabla_rel" type="hidden" value="<?=$idforma?>" />   
	
    <input type="submit" name="ok" id="ok" value="Agregar" />
    
    </form>

<? } 
if($_GET[importar] == 1){
include '../../appcfg/general_config.php'	
?>

<script>
EnviarLinkJ('FormAdminB','modules/campaigns/import_data.php?formid=<?=$_GET[idform]?>');
</script>

<? genera_modalF("AgregarCampos",350,450,"modules/campaigns/import_data.php?formid=$_GET[idform]","FormAdminB"); ?>

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="rounded-corners-blue">
  <tr>
    <td class="textos_titulos">Campos a Importar - Agregar <a href="modules/campaigns/import_fields.php?formid=<?=$_GET[idform]?>" class="AgregarCampos"><img src="<?=$RAIZHTTPCONF?>/imgs/mostrar.gif" width="11" height="11" /></a></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="textospadding"><? for( $i=0 ; $i <count($seleccforms) ; $i++ ){

	$formulario_auto->genera_modal($seleccforms[$i][nombretabla],700,420,$seleccforms[$i]["id_autoformtablas"]);

		?>
      <?=$seleccforms[$i][labeltabla]?>
      <a href="modules/reports/rep_generator_fields_consult.php?formid=<?=$seleccforms[$i][id_autoformtablas]?>&amp;tname=<?=$seleccforms[$i][nombretabla]?>&amp;idreporte=<?=$idreport?>" class="<?=$seleccforms[$i][nombretabla]?>"> <img src="<?=$RAIZHTTPCONF?>/imgs/mostrar.gif" width="11" height="11" /></a> <br />
      <? for($o=0 ; $o < count($ArrCamposCom) ; $o++){
		
		$selectcamposCOM=$sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '$ArrCamposCom[$o]' AND idtabla_rel = '".$seleccforms[$i][id_autoformtablas]."'"); 
	   	
		if($selectcamposCOM != "No hay resultados"){echo $selectcamposCOM[0][labelcampo]."<br>";}
		
		//echo $ArrCamposCom[$o]."<br>";
		
			}//termina el for de los campos
		echo "<br>";
	    }//termina el for de formularios ?></td>
  </tr>
</table>


<? } ?>