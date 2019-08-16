<?
if($_GET[op] != 1 and $_GET[op] != 2){

$idreg= $_GET[idreg];


require("../../appcfg/general_config.php");
require("../../appcfg/class_agenda.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();
$agendac = new Agenda();

$agendac->RutaHTTP = $RAIZHTTP;

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();


$CamConfic = $sqlm->sql_select("autoform_tablas","*","campaignid = '$_GET[idcam]'",0);
$tablaIdent = "ident_".$CamConfic[0][campaignid];


$SeguroReg = $sqlm->sql_select($tablaIdent,"1","id_$tablaIdent = $_GET[idreg] AND estado = 1",0);


if(!is_array($SeguroReg))		{ 
	echo "<br><br><br><br><br><br><br><br><br><div align='center'>Primero debe guardar el registro.</div>"; 
	exit;
								}



?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<meta charset="utf-8">
<script>
	$(function() {
	$( "#datepicker" ).datepicker(
	{onSelect: function(value, date) {EnviarLinkJ('MostrarCal','<?=$RAIZHTTP?>/modules/agenda/addcita.php?idregistro=<?=$idreg?>&idcam=<?=$_GET[idcam]?>&op=1&fecham='+value);}
	,dateFormat: 'yy-mm-dd'}
		);
	});
</script>



<div align="center" style="height:100%">
  <table width="0" border="0" align="center" cellpadding="3" cellspacing="3" class="rounded-corners-blue">
    <tr>
      <td align="left" valign="top" class="textos_titulos">
      Historial Para el id: <?=$idreg?>
        <div class="textos">
        <?=$agendac->regdates($idreg,$fecha_act,"<=",$_GET[idcam])?>
      </div>
      Agendas hechas para el id: <?=$idreg?>
        <div class="textos">
        <?=$agendac->regdates($idreg,$fecha_act,">",$_GET[idcam])?>
      </div>
      </td>
      <td align="left" valign="top" class="textos_titulos"> Seleccione Una Fecha:
      <div id="datepicker"></div>
      <div  class="textos_negros"></div></td>
      <td align="left" valign="top" class="textos_titulos"> Agenda Para el Dia:
      <div class="textos" id="MostrarCal">
      <? echo $agendac->show_agenda_agent($fecha_act,1,0,$idreg,$_GET[idcam]); ?>
      </div></td>
    </tr>
  </table>
</div>



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

	
	echo $agendac->show_agenda_agent($_GET[fecham],1,0,$_GET[idregistro],$_GET[idcam]);
		
				}//------------



//---------------------------?>