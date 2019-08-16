<?
if($op != 1 and $op != 2){

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

if($_GET[ok] == 1)	{
	
	$Variable = $sqlm->inser_data("agenda","idregistro,feedback,fecha","$_GET[idregistro],10,'$fecha_act'",0);
	$sqlm->del_regs("agenda_tmp","idregistro = '$_GET[idregistro]'");
	echo "<br><br><br><br><br>
		<link rel='stylesheet' type='text/css' href='../../css/estilos.css'/>
		<link rel='stylesheet' type='text/css' href='../../css/style.css'/>
		<div class='textos_titulos' align='center'> La cita fue Cancelada. </div";
		exit;
					}


?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<meta charset="utf-8">

<div align="center"><br />
<br />

  <table width="0" border="0" align="center" cellpadding="3" cellspacing="3" class="rounded-corners-ALERTA">
    <tr>
      <td align="left" valign="top" class="textos_titulos"><span class="textosbigBlanco">Seguro  desea cancelar esta cita?
        </span>
        <div id="datepicker"></div>
      <div  class="textos_negros"></div></td>
    </tr>
    <tr>
      <td align="center" valign="top" class="textosbigBlanco"><a href="calcelar_cita.php?ok=1&idregistro=<?=$_GET[idreg]?>" class="textosbigBlanco">SI</a></td>
    </tr>
  </table>
</div>



<?	
} ?>