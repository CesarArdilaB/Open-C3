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

$ImpCampos = $sqlm->sql_select("importdata","*","idform  = '".mysql_escape_string($_GET[formid])."'",0);

?>
 	<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
 
 
 <div align="center" class="textos_titulos"><br />
   Seleccione el Archivo Para Subir<br /><br />

<form action="import_upload.php?op=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <table width="351" border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
       <tr>
         <td width="49" class="textospadding">Archivo</td>
         <td width="108" class="textospadding">&nbsp;
         <input name="archivo" type="file" id="archivo" size="1" /></td>
         <td width="54" align="center" class="textospadding">Subir Id</td>
         <td width="74" align="center" class="textospadding"><input name="subirid" type="checkbox" id="subirid" value="1" />
           <input name="formid" type="hidden" id="formid" value="<?=$_GET[formid]?>" />
           <input name="campos" type="hidden" id="campos" value="<?=$_GET[campos]?>" />
<label for="subirid"></label></td>
         <td width="64" align="center" class="textospadding"><input type="submit" name="button" id="button" value="Subir" /></td>
       </tr>
       <tr>
         <td colspan="5" align="center"><!--<table border="0" cellpadding="0" cellspacing="0" class="rounded-corners-ALERTA">
           <tr>
             <td><span class="textosbigBlancoSmall">Eliminar Datos Del Formulario</span></td>
             <td align="center">               <span class="textosbigBlancoSmall">
               <input name="deldata" type="checkbox" id="deldata" value="1" />             
              </span></td>
           </tr>
           <tr>
             <td colspan="2" align="center"><span class="textosbigBlancoSmall">IMPORTANTE: !!Esta accion eliminara TODA la gestion almasenada en el presente formulario!!</span></td>
           </tr>
         </table>--></td>
      </tr>
    </table>
</form>
   
 </div>
<? }  //termina el primer paso
if($_GET[op] == 1){ // termina la prime opcion
include '../../appcfg/general_config.php';

//este if desocupa el formulario !!!!
	if($deldata == 1)	{

	$TablaDel=$sqlm->sql_select("autoform_tablas","*","id_autoformtablas = '".mysql_escape_string($formid)."'",0);
	$consulta="TRUNCATE TABLE ".$TablaDel[0][nombretabla];
	mysql_query($consulta);
	
						}
//este if desocupa el formulario !!!!

  //print_r($_POST);

				$copiar=copy($_FILES[archivo][tmp_name],"../../tmp/files/".$_FILES[archivo][name]); //copiamos el archivo csv y lo dejamos pendiente para eliminarlo despues de subir la data
				$filedb = fopen("../../tmp/files/".$_FILES[archivo][name],"r");
				
/*				
				if(!$copiar){ "Error Subiendo El archivo."; }
				print_r($filedb);
				echo $archivo_name." **** ".$copiar;
*/				
	
				$camposP = explode(",",$_POST[campos]);
				
	$subir = $sqlm->subir_csv_form($_POST[formid],$filedb,$camposP,$_POST[subirid],0,$_SESSION["user_ID"]);


$TeblaData=$sqlm->sql_select("autoform_tablas","*","id_autoformtablas = '".mysql_escape_string($_POST[formid])."'",0);

for($o=0 ; $o < count($camposP);$o++)	{//hacemos un ford de los capos select que se esten subiendo para optimizar la consulta.

$TraeCamposSelect=$sqlm->sql_select("autoform_config","nombrecampo","eliminado != 1 AND (tipocampo = 'autocom' OR tipocampo = 'select') AND nombrecampo = '".mysql_escape_string($camposP[$o])."'");

if(is_array($TraeCamposSelect)){
	for($i=0 ; $i < count($TraeCamposSelect) ; $i++ ){

		$ntabla = "autof_".$TraeCamposSelect[$i][nombrecampo];
		$ncampoid = "id_".$TraeCamposSelect[$i][nombrecampo];
		$ncampo = $TraeCamposSelect[$i][nombrecampo];
		$UpdateCamposSelect=$sqlm->update_regs($TeblaData[0][nombretabla].",".$ntabla,"$ncampo = $ncampoid","$ncampo = field1 AND LENGTH($ncampo) > 3",0);
	
			} 
		}
									}//hacemos un ford de los capos select que se esten subiendo para optimizar la consulta.
					
					
	$GuardaHistorialUp = $sqlm->inser_data("his_baseup","fechahora,id_usuario,nombrearchivo,numeroregsok,numeroregsfail,idform","'$fecha_act $hora_act','".$_SESSION["user_ID"]."','".$_FILES[archivo][name]."','".$subir[TotalImportados]."','".$subir[TotalErrores]."','$_POST[formid]'",0);

//aqui hacemos la tabla de los registros duplicados

if($subir[Duplicados] != ""){ // el if que muestra la tabla de los datos temporales.

$DuplicadosData = $sqlm->sql_select($subir[TablaTMP],"*","1");
	
?>
<div align="center" class="textosbig">Registros Duplicados: <?=$subir[Duplicados]?></div>
<form id="form2" name="form2" method="post" action="import_upload.php?op=2">
<div style="width:100%; height:415; overflow:scroll">
  <table border="0" align="center" cellpadding="3" cellspacing="1" class="rounded-corners-gray">
    <tr>
      <td class="textos_negros">Seleccione&nbsp;</td>
      <? for($i=0;$i < count($subir[Capos]);$i++){ 

$CampoPro = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$subir[Capos][$i]."'");

?>
      <td align="center" valign="middle" class="textos_negros"><?=$CampoPro[0][labelcampo]?></td>
      <td align="center" valign="middle" class="textos_negros"><input type="checkbox" name="campos[]" value="<?=$subir[Capos][$i]?>" id="campos[]" /></td>
      <? } ?>
    </tr>
    <? for($i=0;$i < count($DuplicadosData);$i++){ ?>
    <tr>
    <td align="center" bgcolor="#FFFFFF">
      <input type="checkbox" name="llave[]" id="checkbox" value="<?=$DuplicadosData[$i][$subir[llave]]?>" />
    </td>
      <? for($o=0;$o < count($subir[Capos]);$o++){ 
$CampoPro = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$subir[Capos][$o]."'");

?>
      <td colspan="2" bgcolor="#FFFFFF" class="textos"><?=$formulario_auto->armar_campo($CampoPro[0][tipocampo],"valhis","",$DuplicadosData[$i][$subir[Capos][$o]],0,1,0,$CampoPro[0][paramcampo])?>
      &nbsp; </td>
      <? } ?>
    </tr>
    <? } ?>
  </table>
</div>
  <div align="center">
  <table border="0" align="center" cellpadding="3" cellspacing="1" class="rounded-corners-blue">
    <tr>
      <td><input type="radio" name="actualizar" id="radio" value="1" />
        <label for="actualizar">Seleccionados</label>
        <input type="radio" name="actualizar" id="radio2" value="2" />
        <label for="actualizar">Todos
          <input name="actualizar" type="radio" id="radio3" value="3" checked="checked" />
          No Actualizar
          <input name="campollave" type="hidden" id="campollave" value="<?=$subir[llave]?>" />
          <input name="tablatemp" type="hidden" id="tablatemp" value="<?=$subir[TablaTMP]?>" />
          <input name="nombrearchivo" type="hidden" id="nombrearchivo" value="<?=$_FILES[archivo][name]?>" />
          <input name="formid" type="hidden" id="formid" value="<?=$_POST[formid]?>" />
        </label></td>
      <td><input type="submit" name="act" id="act" value="Enviar Orden" /></td>
      </tr>
  </table>
  </div>
</form>


		
<?	
}// el if que muestra la tabla de los datos temporales.


//aqui hacemos la tabla de los registros duplicados

?>
 	<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>



<div align="center">
  <table border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
    <tr>
      <td align="center" class="textos_titulos">Resultado de la Operacion<br><?=$subir[Resuldato]?></td>
    </tr>
  </table>
</div>

<?  } // termina la prime opcion 
if($_GET[op] == 2){
	
include '../../appcfg/general_config.php';

	
 if($_POST[actualizar] == 1){//aqui actualizamos los registros cuando seleccionaron unos espesificos.
	 $campollave;
	 
	for($i=0;$i<count($_POST[campos]);$i++){
	$CampoPro = $sqlm->sql_select("autoform_config,autoform_tablas","*","nombrecampo = '".$_POST[campos][$i]."' AND idtabla_rel = id_autoformtablas");	 
	$ArrTablas[] = $CampoPro[0][nombretabla];
	
	if($_POST[campos][$i] != $_POST[campollave]){
	$CadenaUpdate .= $CampoPro[0][nombretabla].".".$_POST[campos][$i]." = ".$_POST[tablatemp].".".$_POST[campos][$i]." ,";
		}
		 
	}// generamos la cadena de actualizacion de las tablas

	$ArrTablas = array_unique($ArrTablas);

	$CampoLLavePro = $sqlm->sql_select("autoform_config,autoform_tablas","*","nombrecampo = '".$_POST[campos][0]."' AND idtabla_rel = id_autoformtablas",0);
	
	//print_r($campos);
	
	$CampollavePONER = $CampoLLavePro[0][campoid];

	if(substr($campollave,-3) == "_id" or $_POST[campollave] == "id_tmp"){ $CampoComprarLlave = $CampollavePONER ;  } else { $CampoComprarLlave = $_POST[campollave]; }
	
	//echo $_POST[campollave]." **** <br>";
	
	foreach($ArrTablas as $valor)	{ 
	
	$CadenaWhere .= $valor."_id = $CampollavePONER AND "; $CadenaTablas .= $valor.",";
	
									}
	
	$CadenaWhere = substr($CadenaWhere,0,-4);
	$CadenaUpdate = substr($CadenaUpdate,0,-1);
	

	 		for($i=0;$i<count($_POST[llave]);$i++){  

$CadenaUpdateQ = "UPDATE $CadenaTablas ".$_POST[tablatemp]." SET $CadenaUpdate WHERE ".substr($CampollavePONER,0,-3).".$CampoComprarLlave = '".$_POST[llave][$i]."' AND ".$_POST[tablatemp].".".$_POST[campollave]." = '".$_POST[llave][$i]."' AND $CadenaWhere"; 
//echo $CadenaUpdateQ;
$consultaDEF = mysql_query($CadenaUpdateQ);

$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");


$insertarHis = mysql_query("INSERT INTO history_".$CampoPro[0][campaignid]." (accion , id_reg, fechahora,id_usuario) VALUES ('Registro Actualizado' , ".$_POST[llave][$i].", '$fecha_act $hora_act','".$_SESSION["user_ID"]."')");
//echo $CadenaUpdateQ;

	 
			} //aqui guardamos los valores

	$GuardaHistorialUp = $sqlm->inser_data("his_baseup","fechahora,id_usuario,nombrearchivo,numeroregsok,numeroregsfail,idform,numeroact","'$fecha_act $hora_act','".$_SESSION["user_ID"]."','".$_POST[nombrearchivo]."','0','0','$_POST[formid]','".count($_POST[llave])."'",0);
	
	
	$BorraTemporal = mysql_query("DROP TABLE ".$_POST[tablatemp]);		

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<div align="center" class="textosbig"> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> Los registros se actualizaron correctamente. </div>
<?				
	 }//aqui actualizamos los registros cuando seleccionaron unos espesificos.	
	

//----------------------------------------------- EPARAMOS PARA ACTUALIZAR TODOS LOS DE LA TABLA ----------------------------------------------

 if($_POST[actualizar] == 2){//aqui actualizamos los registros cuando se actualizaran todos los registros.	
	 $campollave;
	 
	for($i=0;$i<count($_POST[campos]);$i++){
	$CampoPro = $sqlm->sql_select("autoform_config,autoform_tablas","*","nombrecampo = '".$_POST[campos][$i]."' AND idtabla_rel = id_autoformtablas");	 
	$ArrTablas[] = $CampoPro[0][nombretabla];
	
	if($campos[$i] != $_POST[campollave]){
	$CadenaUpdate .= $CampoPro[0][nombretabla].".".$_POST[campos][$i]." = ".$_POST[tablatemp].".".$_POST[campos][$i]." ,";
		}
		 
	}// generamos la cadena de actualizacion de las tablas

	$ArrTablas = array_unique($ArrTablas);

	$CampoLLavePro = $sqlm->sql_select("autoform_config,autoform_tablas","*","nombrecampo = '".$_POST[campos][0]."' AND idtabla_rel = id_autoformtablas",0);
	
	$CampollavePONER = $CampoLLavePro[0][campoid];

	if(substr($campollave,-3) == "_id" or $_POST[campollave] == "id_tmp"){ $CampoComprarLlave = $CampollavePONER ;  } else { $CampoComprarLlave = $_POST[campollave]; }
	

	foreach($ArrTablas as $valor){ $CadenaWhere .= $valor."_id = $CampollavePONER AND "; $CadenaTablas .= $valor.",";}
	
	$CadenaWhere = substr($CadenaWhere,0,-4);
	$CadenaUpdate = substr($CadenaUpdate,0,-1);


	$TraerDataTMP = $sqlm->sql_select($_POST[tablatemp],$_POST[campollave],"1");
	

	 		for($i=0;$i<count($TraerDataTMP);$i++){  

$CadenaUpdateQ = "UPDATE $CadenaTablas $_POST[tablatemp] SET $CadenaUpdate WHERE ".substr($CampollavePONER,0,-3).".$CampoComprarLlave = '".$TraerDataTMP[$i][$_POST[campollave]]."' AND ".$_POST[tablatemp].".".$_POST[campollave]." = '".$TraerDataTMP[$i][$_POST[campollave]]."' AND $CadenaWhere"; 

$insertarHis = mysql_query("INSERT INTO history_".$CampoPro[0][campaignid]." (accion , id_reg, fechahora,id_usuario) VALUES ('Registro Actualizado' , ".$TraerDataTMP[$i][$_POST[campollave]].", '$fecha_act $hora_act','".$_SESSION["user_ID"]."')");

//echo $CadenaUpdateQ;

$consultaDEF = mysql_query($CadenaUpdateQ);
	 
			} //aqui guardamos los valores
			
$GuardaHistorialUp = $sqlm->inser_data("his_baseup","fechahora,id_usuario,nombrearchivo,numeroregsok,numeroregsfail,idform,numeroact","'$fecha_act $hora_act','".$_SESSION["user_ID"]."','".$_POST[nombrearchivo]."','0','0','$_POST[formid]','".count($TraerDataTMP)."'",0);

			
	$BorraTemporal = mysql_query("DROP TABLE ".$_POST[tablatemp]);		

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<div align="center" class="textosbig"> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> Los registros se actualizaron correctamente. </div>
<?				
	 }//aqui actualizamos los registros cuando se actualizaran todos los registros.	


//----------------------------------------------------

 if($_POST[actualizar] == 3){//aqui boramos la tabla temporal por no actualizar..	

			
	$BorraTemporal = mysql_query("DROP TABLE ".$_POST[tablatemp]);		

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<div align="center" class="textosbig"> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> No se actualizaron registros. </div>
<?				
	 }//aqui boramos la tabla temporal por no actualizar..	


	
	
	}


?>