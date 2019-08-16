<? 
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3){


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->ValFormScripts();

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
  <tr>
    <td class="textos_negros">Seleccione una Campaña</td>
    <td><span class="textos_negros">
      <? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"id_campaign IN (SELECT idcampana FROM inv_camconfig) ",
	"direccion"=>"modules/agenda/feedback_multiple.php?op=1");
	echo $formulario->select_envia_link("","id_campaign","","","",$parametrosGrupoHerr,0,"","MuestraPistolo"); ?>
    </span></td>
  </tr>
</table>
<hr>

<div id="MuestraPistolo"></div>

<? }
if($_GET[op] == 1){

if($inc != 1){ include("../../appcfg/general_config.php"); }
$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->ValFormScripts();

$CfgAg = $sqlm->sql_select("agenda_camconfig","*","idcampana = '$_POST[varid]'",0);
	
?>	

<form action="" id="FormaFeedback" method="post" onSubmit="foco();return false;">
  <div align="center">
    <table width="0" border="0" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td colspan="4" align="center" class="textosbig">Guardar FeedBack</td>
      </tr>
      <tr>
        <td class="textos_titulos">Tipo gestion</td>
        <td><?=$camposman->campoFdata($CfgAg[0][tipogestionc],0,0);?></td>
        <td class="textos_titulos">Tipo Entrega</td>
        <td><?=$camposman->campoFdata($CfgAg[0][tipoentregac],0,0);?></td>
      </tr>
      <tr>
        <td class="textos_titulos">Mes Gestion</td>
        <td><?=$camposman->campoFdata($CfgAg[0][mesgestionc],0,0);?></td>
        <td class="textos_titulos">Codigo Oficina</td>
        <td><?=$camposman->campoFdata($CfgAg[0][codigooficinac],0,0);?></td>
      </tr>
      <tr>
        <td class="textos_titulos">Estado Custodia</td>
        <td><?
	$parametrosGrupo=array(
	"tabla"=>"inv_estado",
	"campo1"=>"id_estado",
	"campo2"=>"estado",
	"campoid"=>"id_estado",
	"condiorden"=>"1");		 
	echo Generar_Formulario::c_select("","idestado","","",":required",$parametrosGrupo,0,0);?></td>
        <td class="textos_titulos">Bodega</td>
        <td><?
	$parametrosGrupo=array(
	"tabla"=>"inv_bodegas",
	"campo1"=>"id_bodegas ",
	"campo2"=>"nombre",
	"campoid"=>"id_bodegas",
	"condiorden"=>"1");		 
	echo Generar_Formulario::c_select("","idbodega","","",":required",$parametrosGrupo,0,0);?></td>
      </tr>
      <tr>
        <td class="textos_titulos">Fecha entrega</td>
        <td><?=$formulario->c_fecha_input("","fechaentrega","","","",":required")?>        </td>
        <td class="textos_titulos">Mensajero</td>
        <td><? 
	$parametrosGrupoHerr=array(
	"tabla"=>"mensajeros",
	"campo1"=>"id_mensajero",
	"campo2"=>"name",
	"campoid"=>"id_mensajero",
	"condiorden"=>"nolabora = 0 AND inactivo = 0");
	echo $formulario->c_Auto_select("","idmensajero","","","",$parametrosGrupoHerr,1,"-","",0,15); ?></td>
      </tr>
      <tr>
        <td colspan="4" align="center">
        
        <script>
		function SoloLectura(){
        $('#lote').attr('readonly', true);
		$('#guia').attr('readonly', true);
		$('#bolsa').attr('readonly', true);
		$('#idcampana').attr('readonly', true);
		$('#tiempomax').attr('readonly', true);

		}
		function NormalLectura(){
        $('#lote').attr('readonly', false);
		$('#guia').attr('readonly', false);
		$('#bolsa').attr('readonly', false);
		$('#idcampana').attr('readonly', false);
		$('#tiempomax').attr('readonly', false);


		}
		
		
		function foco(){
			
		var bolsaso = document.getElementById('ControlBolsa');
		var bolsasoV = document.getElementById('bolsaout');
		var Scode = document.getElementById('pseudocodigo');
		var Formulario = document.getElementById('FormaFeedback');
			
		if	(bolsaso.value == "1")	{ 
		
		$('#pseudocodigo').focus();
		EnviarLinkForm('PistolResult','<?=$RAIZHTTP?>/modules/agenda/feedback_multiple.php?op=3',Formulario);
		$('#pseudocodigo').attr('value','');

		 								}

		
		if	(bolsaso.value == "2")	{
		
		$('#bolsaout').focus();
		EnviarLinkForm('PistolResult','<?=$RAIZHTTP?>/modules/agenda/feedback_multiple.php?op=3',Formulario);
		$('#bolsaout').attr('value','');

					
									}

			}
			
		//esta funcion desactiva la bolsa de seguridad	
		function DesactivaBolsa(){
		
        $('#bolsaout').attr('readonly', true);
		$('#pseudocodigo').attr('readonly', false);
		$('#bolsaout').attr('value','');
		$('#ControlBolsa').attr('value','1');
		$('#pseudocodigo').focus();

			
			}

		//esta funcion activa la bolsa de seguridad	
		function ActivaBolsa(){
		
		$('#pseudocodigo').attr('value','');
        $('#pseudocodigo').attr('readonly', true);
        $('#bolsaout').attr('readonly', false);
		$('#ControlBolsa').attr('value','2');
		$('#bolsaout').focus();

			
			}

		//esta funcion es cuando se termina el pistoleo	
		function focolote(){
		$('#lote').focus();
		$('#lote').attr('value','');
		$('#guia').attr('value','');
		$('#bolsa').attr('value','');
		$('#pseudocodigo').attr('value','');
		$('#idcampana').attr('value','');
		$('#tiempomax').attr('value','');
			}
</script>
        
        <table border="0" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
          <tr>
            <td class="textos_titulos">Bolsa de seguridad</td>
            <td><input name="bolsaout" type="text" id="bolsaout" size="10" readonly /></td>
            <td><input type="radio" name="radio" id="radio" value="radio" onclick="ActivaBolsa()" /></td>
          </tr>
          <tr>
            <td class="textos_titulos">Pseudocodigo</td>
            <td><input type="text" name="pseudocodigo" id="pseudocodigo" /></td>
            <td><input name="radio" type="radio" id="radio2" value="radio" checked="checked" onclick="DesactivaBolsa()" /></td>
          </tr>
        </table>
        <input name="ControlBolsa" type="hidden" id="ControlBolsa" value="1" />
        <input name="idcam" value="<?=$_POST[varid]?>" type="hidden" id="idcam" /></td>
      </tr>
      <tr>
        <td colspan="4" align="center"><input type="submit" name="act" id="act" value="Guardar"></td>
      </tr>
    </table>
  </div>
</form>

<hr>

<div id="PistolResult"></div>	
    
<?	}if($_GET[op] == 3){
require("../../appcfg/general_config.php");

require("../../appcfg/class_agenda.php");
$agendac = new Agenda();
	
	//print_r($_GET);

$CfgAg = $sqlm->sql_select("agenda_camconfig","*","idcampana = '$_GET[idcam]'",0);

$tipogC = $CfgAg[0][tipogestionc];
$tipoeC = $CfgAg[0][tipoentregac];
$mesgC  = $CfgAg[0][mesgestionc];
$codigoofC = $CfgAg[0][codigooficinac];


	
if($_GET[ControlBolsa] == 1 and $_GET[pseudocodigo] != "")		{

$agendac->feedback($_GET[pseudocodigo],1,$_GET[idmensajero_hidden],$_GET[fechaentrega],$_GET[idbodega],$_GET[idestado],$_SESSION["user_ID"],$_GET[$tipogC],$_GET[$tipoeC],$_GET[$mesgC],$_GET[$codigoofC],$_GET[idcam]);

	
									}
									
									
if($_GET[ControlBolsa] == 2 and $_GET[bolsaout] != "")		{

$agendac->feedback($_GET[bolsaout],2,$_GET[idmensajero_hidden],$_GET[fechaentrega],$_GET[idbodega],$_GET[idestado],$_SESSION["user_ID"],$_GET[$tipogC],$_GET[$tipoeC],$_GET[$mesgC],$_GET[$codigoofC],$_GET[idcam]);


									}

//--------------------------------------------------------------------------------------	  

} ?>