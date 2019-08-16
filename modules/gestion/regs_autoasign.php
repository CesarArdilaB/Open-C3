<? 
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1){ 
include("../../appcfg/cc.php");
include("../../appcfg/func_mis.php");
include("../../appcfg/js_scripts.php");
include("../../appcfg/class_sqlman.php");
include("../../appcfg/class_forms.php");
include("../../appcfg/class_autoforms.php");

$sqlm= new Man_Mysql();

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaiz="$RAIZHTTP";
$formulario_auto->RutaHTTP="$RAIZHTTP";


//------------------------------------------------------------- 

 ?>
 	<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
 
 <div align="center">
   <form id="form1" name="form1" method="post" action="regs_autoasign.php?op=1">
     <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
       <tr>
         <td align="center" class="textos_titulos"><p>Guardar Este Registro Para Posterior Gestion</p></td>
       </tr>
       <tr>
         <td align="center" class="textos_negros"><?=$regediting?>&nbsp;</td>
       </tr>
      
		<tr>
         <td align="center" class="textospadding"><input type="submit" name="ok" id="ok" value="Guardar" />
          <input name="idcampaing" type="hidden" id="campaing" value="<?=$_GET[camediting]?>" />
          <input name="regid" type="hidden" id="reporteid" value="<?=$_GET[regediting]?>" /></td>
       </tr>
     </table>
   </form>
 </div>
<? }  //termina el primer paso
if($_GET[op] == 1){ // termina la prime opcion
include '../../appcfg/general_config.php';

 $sqlm->inser_data("asigned_regs","idreg,idcam,idagent,afechahora","".mysql_escape_string($_POST[regid]).",".mysql_escape_string($_POST[idcampaing]).",'".$_SESSION["user_ID"]."','$fecha_act $hora_act'",0);
 
//echo "$cadenaF";
?>
 	<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center"><br />
  <br />
  <br />
  <table border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
    <tr>
      <td align="center" class="textos_titulos">La configuracion fue guardada</td>
    </tr>
  </table>
</div>

<?  } // termina la prime opcion ?>