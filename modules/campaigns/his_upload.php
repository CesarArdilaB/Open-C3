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

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();
//------------------------------------------------------------- 

?>
 	<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
 
 
 <div align="center">
   <h3>Historiar de Bases de Datos Importadas</h3>
 </div>
   
 <form name="form1" method="post" onSubmit="EnviarLinkForm('showhis','<?=$RAIZHTTP?>/modules/campaigns/his_upload.php?op=1',this);return false;">
   <div align="center">
     <table width="0" border="0" align="center" cellpadding="0" cellspacing="0">
       <tr>
         <td class="textos_titulos"><input name="formid" type="hidden" id="formid" value="<?=$_GET[formid]?>" />
         Fecha</td>
         <td><span class="textos_titulos">
           <?=$formulario->c_fecha_input("","fecha","","")?>
         </span></td>
         <td><input type="submit" name="button" id="button" value="Buscar" /></td>
       </tr>
     </table>
   </div>
 </form>
 <div id="showhis"></div>
<? }  //termina el primer paso
if($_GET[op] == 1){ // termina la prime opcion
include '../../appcfg/general_config.php';
//echo "Aqui estamos a tope a tope. $fecha - $formid";

$SelHisUpload = $sqlm->sql_select("his_baseup","*","idform  = '$_GET[formid]' AND DATE(fechahora) = '$_GET[fecha]'",0);

?>
<div align="center">
<? if(is_array($SelHisUpload)) { //verificamos si es array ?>  
<table width="0" border="0" cellpadding="2" cellspacing="2" class="rounded-corners-blue">
    <tr>
      <td align="center" class="textos_titulos">Fecha y Hora</td>
      <td align="center" valign="baseline" class="textos_titulos">Usuario</td>
      <td align="center" class="textos_titulos">Nombre del Archivo</td>
      <td align="center" class="textos_titulos">Registros Ok</td>
      <td align="center" class="textos_titulos">Registros Actualizados</td>
      <td align="center" class="textos_titulos">Registros con Error</td>
    </tr>
<? for($i = 0 ;$i < count($SelHisUpload) ; $i++) { 
$UsuarioData = $sqlm->sql_select("agents","*","id_agents = '".$SelHisUpload[$i][id_usuario ]."'",0);	
?>
    <tr>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$SelHisUpload[$i][fechahora]?>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$UsuarioData[0][name]?>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$SelHisUpload[$i][nombrearchivo]?>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$SelHisUpload[$i][numeroregsok]?>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$SelHisUpload[$i][numeroact]?></td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$SelHisUpload[$i][numeroregsfail]?>&nbsp;</td>
    </tr>
<? } ?> 
  </table><? }else{ //verificamos si es array ?>
<br><br><br><br><div align="center">No Ahy Datos.</div>
<? } ?></div>	<? } // termina la primer opcion ?>