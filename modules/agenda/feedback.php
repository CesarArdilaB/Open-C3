<? 
include("../../appcfg/general_config.php");
include("../../appcfg/class_agenda.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();
$agendac = new Agenda();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

if(isset($_GET[act])){
	
$guardar = $sqlm->update_regs("agenda","feedback = '$_GET[feedback]' , feddbackcoments = '$_GET[feddbackcoments]' , idmensajero_entrego = '$_GET[idmensajero_entrego_hidden]'","id_agenda = '$_GET[idcita]'",0);
	
	}
?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<form action="" method="get">
  <div align="center">
    <table width="0" border="0" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td colspan="2" align="center" class="textosbig">Guardar FeedBack</td>
      </tr>
      <tr>
        <td class="textos_negros">Estado</td>
        <td><?
	$parametrosGrupo=array(
	"tabla"=>"agenda_estados",
	"campo1"=>"id_estado ",
	"campo2"=>"estado",
	"campoid"=>"id_estado",
	"condiorden"=>"inactivo = 0");		 
	echo Generar_Formulario::c_select("","feedback","","","",$parametrosGrupo,0,0);?>
        &nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="textos_negros">Entrago Por</td>
        <td><? 
	$parametrosGrupoHerr=array(
	"tabla"=>"mensajeros",
	"campo1"=>"id_mensajero",
	"campo2"=>"name",
	"campoid"=>"id_mensajero",
	"condiorden"=>"nolabora = 0 AND inactivo = 0");
	echo $formulario->c_Auto_select("","idmensajero_entrego","","","",$parametrosGrupoHerr,1,"-","",0,15); ?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="textos_negros">Comentarios
        <input name="idcita" type="hidden" id="idcita" value="<?=$_GET[idcita]?>" /></td>
        <td><label for=""></label>
        <textarea name="feddbackcoments" cols="20" rows="6" id="feddbackcoments"></textarea></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" name="act" id="act" value="Guardar"></td>
      </tr>
    </table>
  </div>
</form>