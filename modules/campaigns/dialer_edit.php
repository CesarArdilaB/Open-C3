<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<? 
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5){
include '../../appcfg/general_config.php';

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

$JsScripts->ValFormScripts();

include '../../appcfg/cc_call.php';		

mysql_select_db("call_center");

//$CamPre = $sqlm->sql_select("campaign","*","idofill = '".$idfiltro."'");

$CamParam= $sqlm->sql_select("campaign","*","id = '$_GET[idcam]'",0);

$horaAI = explode(":",$CamParam[0][daytime_init]);
$horaAP = explode(":",$CamParam[0][daytime_end]);

?>
<div align="center">
  <form id="form1" name="form1" method="post" action="dialer_edit.php?op=1">
    <table border="0" cellpadding="2" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td rowspan="2" align="left" valign="middle" class="textos">Nombre 
          <label for="nombre"></label></td>
        <td rowspan="2" align="left" valign="middle"><input name="nombre" type="text" class=":required" id="nombre" value="<?=$CamParam[0][name]?>" /></td>
        <td class="textos">Fecha de inicial</td>
        <td><?=$formulario->c_fecha_input("","fecha_ini","","",$CamParam[0][datetime_init],1,0);?>
        &nbsp;</td>
        <td class="textos">Fecha Final</td>
        <td><?=$formulario->c_fecha_input("","fecha_fin","","",$CamParam[0][datetime_end],":required",0);?>
        &nbsp;</td>
      </tr>
      <tr>
        <td class="textos">Hora Inicial</td>
        <td><select name="hora_ini_HH" id="hora_ini_HH"><option value="<?=$horaAI[0]?>"><?=$horaAI[0]?></option>
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option></select> :
<select name="hora_ini_MM" id="hora_ini_MM"><option value="<?=$horaAI[1]?>"><?=$horaAI[1]?></option>
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option></select>
</td>
        <td class="textos">Hora Final</td>
        <td><select name="hora_fin_HH" id="hora_fin_HH">
          <option value="<?=$horaAP[0]?>"><?=$horaAP[0]?></option>
          <option value="00">00</option>
          <option value="01">01</option>
          <option value="02">02</option>
          <option value="03">03</option>
          <option value="04">04</option>
          <option value="05">05</option>
          <option value="06">06</option>
          <option value="07">07</option>
          <option value="08">08</option>
          <option value="09">09</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
        </select>
:
<select name="hora_fin_MM" id="hora_fin_MM">
          <option value="<?=$horaAP[1]?>"><?=$horaAP[1]?></option>
  <option value="00">00</option>
  <option value="01">01</option>
  <option value="02">02</option>
  <option value="03">03</option>
  <option value="04">04</option>
  <option value="05">05</option>
  <option value="06">06</option>
  <option value="07">07</option>
  <option value="08">08</option>
  <option value="09">09</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
  <option value="32">32</option>
  <option value="33">33</option>
  <option value="34">34</option>
  <option value="35">35</option>
  <option value="36">36</option>
  <option value="37">37</option>
  <option value="38">38</option>
  <option value="39">39</option>
  <option value="40">40</option>
  <option value="41">41</option>
  <option value="42">42</option>
  <option value="43">43</option>
  <option value="44">44</option>
  <option value="45">45</option>
  <option value="46">46</option>
  <option value="47">47</option>
  <option value="48">48</option>
  <option value="49">49</option>
  <option value="50">50</option>
  <option value="51">51</option>
  <option value="52">52</option>
  <option value="53">53</option>
  <option value="54">54</option>
  <option value="55">55</option>
  <option value="56">56</option>
  <option value="57">57</option>
  <option value="58">58</option>
  <option value="59">59</option>
</select></td>
      </tr>
      <tr>
        <td align="left" valign="middle" class="textos">Canales a Usar</td>
        <td align="left" valign="middle"><input class=":required" value="<?=$CamParam[0][max_canales]?>" name="canales" type="text" id="canales" size="5" maxlength="5" /></td>
        <td class="textos">Cola</td>
        <td>
        <? 
	include '../../appcfg/cc_call.php';		
	mysql_select_db("asterisk");	
	$parametrosGrupoHerr=array(
	"tabla"=>"queues_config",
	"campo1"=>"extension",
	"campo2"=>"extension",
	"campoid"=>"extension",
	"condiorden"=>"1");
	
	echo $formulario->c_select("","cola","","","",$parametrosGrupoHerr,0,"",$CamParam[0][queue]); ?>
		</td>
        <td class="textos">Intentos</td>
        <td><input class=":required" name="intentos" value="<?=$CamParam[0][retries]?>" type="text" id="intentos" size="5" maxlength="5" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle" class="textos">Estado:        </td>
        <td colspan="5" align="left" valign="middle" class="textos">
        <select name="estatus">
          <option value="<?=$CamParam[0][estatus]?>" selected="selected">Seleccione</option>
          <option value="A">Activa</option>
          <option value="I">Inactiva</option>
        </select></td>
      </tr>
      <tr>
        <td colspan="6" align="left" valign="middle" class="textos">Script:</td>
      </tr>
      <tr>
        <td colspan="6" align="left" valign="middle">   
	
    <textarea cols="80" id="script" name="script" rows="10"><?=$CamParam[0][script]?></textarea>

        </td>
      </tr>
      <tr>
        <td colspan="6" align="left" valign="middle"><div align="center">
          <input name="idcam" type="hidden" id="idcam" value="<?=$_GET[idcam]?>" />
          <input type="submit" name="button" id="button" value="Actualizar" />
        </div></td>
      </tr>
    </table>
  </form>
</div>

  <? 
 
 	// Include the CKEditor class.
	include "../../libs/ckeditor/ckeditor.php";
	// Create a class instance.
	$CKEditor = new CKEditor();
	// Path to the CKEditor directory, ideally use an absolute path instead of a relative dir.
	//   $CKEditor->basePath = '/ckeditor/'
	// If not set, CKEditor will try to detect the correct path.
	$CKEditor->basePath = "$RAIZHTTP/libs/ckeditor/";
	// Replace a textarea element with an id (or name) of "editor1".
	$CKEditor->config[toolbar]="Basic";
	$CKEditor->replace("script");
  
  ?>   

<?
}//el primer if queda aqui. 
if($_GET[op] == 1){
include '../../appcfg/general_config.php';

include '../../appcfg/cc_call.php';		

mysql_select_db("call_center");

$ActualizarCam = $sqlm->update_regs("campaign","name  = '$_POST[nombre]' , datetime_init = '$_POST[fecha_ini]', datetime_end = '$_POST[fecha_fin]', daytime_init = '$_POST[hora_ini_HH]:$_POST[hora_ini_MM]', daytime_end = '$_POST[hora_fin_HH]:$_POST[hora_fin_MM]', queue 	 = '$_POST[cola]' , retries = '$_POST[intentos]' , max_canales = '$_POST[canales]' , script = '$_POST[script]' , estatus = '$_POST[estatus]'","id = $_POST[idcam]");


?>

<div align="center"><br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <table border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
    <tr>
      <td align="center" class="textos_titulos">La configuracion fue guardada</td>
    </tr>
  </table>
</div>

	
<? } //termina la opcion 1 que guarla ?>