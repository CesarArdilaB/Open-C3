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
	
			$sqlm->ins_from($_POST,"agenda","ok",0);
		$sqlm->del_regs("agenda_tmp","idregistro = '$_POST[idregistro]'");
		
		echo "<br><br><br><br><br>
		<link rel='stylesheet' type='text/css' href='../../css/estilos.css'/>
		<link rel='stylesheet' type='text/css' href='../../css/style.css'/>
		<div class='textos_titulos' align='center'> La cita fue guardada correctamente. </div";
		exit;
		
					}//cuardamos las citas

//----------------------------------------------------------------------

$TraerMensajero = $sqlm->sql_select("mensajeros","name,maxcitas","id_mensajero = '$_GET[idmensajero]'",0);

$TraerDataTemp = $sqlm->sql_select("agenda_tmp","comentarios,hora,idagente","idregistro = '$_GET[idregistro]'",0);

$ncitasAG = $agendac->numerocitas($_GET[fecha],$_GET[idmensajero]);
$ncitasMAX = $TraerMensajero[0][maxcitas];
$ncitasDISP = $ncitasMAX - $ncitasAG;

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<meta charset="utf-8">

<div align="center">
  <form id="form1" name="form1" method="post" action="">
    <table width="0" border="0" cellpadding="0" cellspacing="3" class="rounded-corners-blue">
      <tr>
        <td class="textosbig"><div align="center">Agendar Cita para:
          <?=$TraerMensajero[0][name]?>
          en la fecha
          <?=$fecha?>
Horario          
<select name="hora" id="hora">
<? if(is_array($TraerDataTemp)){ ?>
  <option selected="selected" value="<?=$TraerDataTemp[0][hora]?>"><?=$TraerDataTemp[0][hora]?></option>
<? }else{ ?>
  <option value="Mañana">Mañana</option>
<? } ?>
  <option value="Mañana">Mañana</option>
  <option value="Tarde">Tarde</option>
</select>
Citas disponibles:
<?=$ncitasDISP?>
        </div></td>
      </tr>
      <tr>
        <td class="textos_titulos"><p>Comentario:<br />
          <label for="comentarios"></label>
          <textarea name="comentarios" cols="60" rows="6" id="comentarios"><? if(is_array($TraerDataTemp)){echo $TraerDataTemp[0][comentarios] ;}?></textarea>
        </p></td>
      </tr>
      <tr>
        <td align="center"><input name="idmensajero" type="hidden" id="idmensajero" value="<?=$_GET[idmensajero]?>" />
        <input name="fecha" type="hidden" id="fecha" value="<?=$_GET[fecha]?>" />
        <input name="idregistro" type="hidden" id="idregistro" value="<?=$_GET[idregistro]?>" />        
        <input name="idagente" type="hidden" id="idagente" value="<?=$TraerDataTemp[0][idagente]?>" />
        <input type="hidden" name="idcampana" value="<?=$_GET[idcampana]?>" id="hiddenField" />
        <input name="tipoag" type="hidden" id="tipoag" value="3" />
        <input name="numeroref" type="hidden" id="numeroref" value="<?=$_GET[idregistro]?>" /><input type="submit" name="ok" id="ok" value="Guardar" /></td>
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

	
	echo $agendac->show_agenda($_GET[fecham],1,0,$_GET[idregistro]);
		
				}//------------

//---------------------------?>