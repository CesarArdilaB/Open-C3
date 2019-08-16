<? 
session_start();

if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1){ 

include("../../appcfg/general_config.php");


$sqlm= new Man_Mysql();

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaiz="$RAIZHTTP";
$formulario_auto->RutaHTTP="$RAIZHTTP";

//------------------------------------------------------------- 

$ImpCampos = $sqlm->sql_select("importdata","*","idform  = '$_GET[formid]'",0);

?>
 	<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
 
 <div align="left"> <span class="textos_titulos">
 
 <div align="center" class="textos_titulos">Para Montar Una Base De Datos Seleccione Una Plantilla</div>
       
  <? if($ImpCampos != "No hay resultados"){ //id de ver los regitros de las plantillas importadoras ?>
       
 </span>     
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
<? genera_modalF("UpLink$o",1200,650,"modules/campaigns/import_data.php?formid=$_GET[formid]","FormAdminB"); ?>
	<form action="rep_generator_fields_show.php?op=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
       <tr>
         <td class="textospadding">&nbsp;Plantilla <?=$o?></td>
         <td class="textospadding"><?=$camposL?>&nbsp;</td>
         <td align="center" class="textospadding"><a href="modules/campaigns/import_upload.php?formid=<?=$_GET[formid]?>&campos=<?=$camposN?>" class="<?="UpLink".$o?>">Subir Archivo</a>
           <input name="formid" type="hidden" id="formid" value="<?=$_GET[formid]?>" />
<input name="camposUP" type="hidden" id="formid" value="<?=$camposN?>" /></td>
         <td align="center" class="textospadding">
         <? genera_modalF("delete$o",500,250,"modules/campaigns/import_data.php?formid=$_GET[formid]","FormAdminB"); ?>
         <a class="delete<?=$o?>" href="modules/campaigns/import_data_delete.php?idplantilla=<?=$ImpCampos[$o][id_importdata]?>">Eliminar</a>
         </td>
       </tr>
    </table>
</form>
       <? 
} // segundo for
?>       
	 

<? } //id de ver los regitros de las plantillas importadoras
else{ echo "No ahy Plantillas";}
genera_modalF("hisupload",800,500,"modules/campaigns/import_data.php?formid=$_GET[formid]","FormAdminB"); ?>

<samp class="textos_titulos"><a class="hisupload" href="modules/campaigns/his_upload.php?formid=<?=$_GET[formid]?>">Ver Historial de Bases Importadas</a><br />
Para subir una base de datos tenga en cuenta lo siguiente:</samp>
<div align="left" class="textospadding">
<ul style="margin-left:15px;">
<li>El archivo csv debe tener las mimas columnas de la plantilla seleccionada</li>
<li>Si Selecciona Subir Id este debe ir en la primera columna del archivo csv</li>
<li>Si en el archivo que intenta subir ahy ids repetidos estos no se actualizaran en la base de datos</li>
<li>Los campos tipo seleccion y auto completar no se podran importar</li>
</ul>
</div>

 </div>
<? }  //termina el primer paso
if($_GET[op] == 1){ // termina la prime opcion
include '../../appcfg/general_config.php';

//print_r($_POST);

for($i=0 ; $i < count($incluir) ; $i++){
	
	if($incluir[$i] != ""){
	$CamposMos .= "$incluir[$i],";
	}
	
	}
 
 $CamposMosF=substr($CamposMos,0,-1);
 
 $sqlm->update_regs("rep_reportes","tablas = CONCAT(tablas,\",$tablan\") , camposmos = CONCAT(camposmos,\",$CamposMosF\")","idrep_reportes = $reporteid",0);
 
//echo "$cadenaF";
?>
 	<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center"><br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <table border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
    <tr>
      <td align="center" class="textos_titulos">La configuracion fue guardada</td>
    </tr>
  </table>
</div>

<?  } // termina la prime opcion ?>