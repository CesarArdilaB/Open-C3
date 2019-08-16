<?
if($_GET[op] != 1 and $_GET[op] != 2){

//include_once("../../appcfg/general_config.php");
include("appcfg/class_agenda.php");


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
$JsScripts->ValFormScripts();

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<meta charset="utf-8">
<script>
	$(function() {
	$( "#datepicker" ).datepicker(
	{onSelect: function(value, date) {EnviarLinkJ('MostrarCal','modules/agenda/agenda.php?op=1&fecham='+value);}
	,dateFormat: 'yy-mm-dd'}
		);
	});

</script>

<table width="0" border="0" align="center" cellpadding="3" cellspacing="3" class="rounded-corners-blue">
  <tr>
    <td align="left" valign="top">
    <div class="textos_negros"> Seleccione Una Fecha:
      <div id="datepicker"></div>
    </div></td>
    <td align="left" valign="top">
    <div class="textos_negros"> Agenda Para el Dia:<div class="textos" id="MostrarCal">
    <? echo $agendac->show_agenda($fecha_act,0,0,0); ?>
    </div></div></td>
  </tr>
</table>



<?	
}if($_GET[op] == 1)	{//------------

require("../../appcfg/general_config.php");
require("../../appcfg/class_agenda.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();
$agendac = new Agenda();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";

	
	echo $agendac->show_agenda($_GET[fecham],0,0,$_GET[idregistro]);
		
				}//------------


//---------------------------?>