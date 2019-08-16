<?
if($_GET[op] != 1 and $_GET[op] != 2){

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

$JsScripts= new ScriptsSitio();
$JsScripts->RutaHTTP="$RAIZHTTP";
$JsScripts->AllScripts();

	if(isset($_POST[ok]))	{//cuardamos las citas
	
$agendac->agendarTMP($_POST[idregistro],$_POST[idcampana],$_SESSION["user_ID"],$_POST[fecha],"F",$_POST[recoleccion],$_POST[hora],$_POST[comentarios]);
		
		echo "<br><br><br><br><br>
		<link rel='stylesheet' type='text/css' href='../../css/estilos.css'/>
		<link rel='stylesheet' type='text/css' href='../../css/style.css'/>
		<div class='textos_titulos' align='center'> La cita fue guardada correctamente.</div";
		exit;
		
		
					}//cuardamos las citas

//----------------------------------------------------------------------

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<meta charset="utf-8">

<div align="center">
  <form id="form1" name="form1" method="post" action="">
    <table width="0" border="0" cellpadding="0" cellspacing="3" class="rounded-corners-blue">
      <tr>
        <td align="left" class="textosbig"><div align="left">Agendar Cita para:
          <?=$TraerMensajero[0][name]?>
          en la fecha
          <?=$_GET[fecha]?> 
Horario          
<select name="hora" id="hora">
  <option value="Mañana">Mañana</option>
  <option value="Tarde">Tarde</option>
</select>
        </div></td>
      </tr>
      <tr>
        <td class="textosbig">Recoleccion de documentos 
        <input name="recoleccion" type="checkbox" id="recoleccion" value="1" /></td>
      </tr>
      <tr>
        <td class="textos_titulos"><p>Comentario:<br />
          <label for="comentarios"></label>
          <textarea name="comentarios" cols="60" rows="6" id="comentarios"></textarea>
        </p></td>
      </tr>
      <tr>
        <td align="center"><input name="fecha" type="hidden" id="fecha" value="<?=$_GET[fecha]?>" />
        <input name="idregistro" type="hidden" id="idregistro" value="<?=$_GET[idregistro]?>" />
        <input name="idcampana" type="hidden" id="idregistro" value="<?=$_GET[idcam]?>" />
        <input name="idagente" type="hidden" id="idagente" value="<?=$_SESSION["user_ID"]?>" />
        <input type="submit" name="ok" id="ok" value="Guardar" /></td>
      </tr>
    </table>
</form></div>

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

	
	echo $agendac->show_agenda($fecham,1,0,$idregistro);
		
				}//------------

//---------------------------?>