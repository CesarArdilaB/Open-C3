<? 
session_start();
if($op != 1 and $op != 2 and $op != 3and $op != 4 and $op != 5 and $op != 6 and $addcampo != 1){ 
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
   <form id="form1" name="form1" method="post" action="asignar_reg.php?op=1">
     <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
       <tr>
         <td align="center" class="textos_titulos"><p>Seleccione Un Agente</p></td>
       </tr>
       <tr>
         <td align="center" class="textospadding">
         <? 
	$parametrosGrupoHerr=array(
	"tabla"=>"agents",
	"campo1"=>"id_agents",
	"campo2"=>"name",
	"campoid"=>"id_agents",
	"condiorden"=>"tipo = 0");
	echo $formulario->c_Auto_select("","agente","","","",$parametrosGrupoHerr,1,"Valor: ","",0,35);
		 ?>         
         </td>
       </tr>
      
		<tr>
         <td align="center" class="textospadding"><input type="submit" name="ok" id="ok" value="Guardar" />
          <input name="idcampaing" type="hidden" id="campaing" value="<?=$camediting?>" />
          <input name="regid" type="hidden" id="reporteid" value="<?=$regediting?>" /></td>
       </tr>
     </table>
   </form>
 </div>
<? }  //termina el primer paso
if($op == 1){ // termina la prime opcion
include '../../appcfg/general_config.php';

 $sqlm->inser_data("asigned_regs","idreg,idcam,idagent,afechahora","".mysql_escape_string($regid).",".mysql_escape_string($idcampaing).",".mysql_escape_string($agente_hidden).",'$fecha_act $hora_act'",0);
 
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
 
 