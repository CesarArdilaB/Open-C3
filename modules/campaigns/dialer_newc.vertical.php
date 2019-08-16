<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<? 
if($op != 1 and $op != 2 and $op != 3 and $op != 4 and $op != 5){
include '../../appcfg/general_config.php';

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

$JsScripts->ValFormScripts();

mysql_select_db("call_center");

//$CamPre = $sqlm->sql_select("campaign","*","idofill = '".$idfiltro."'");

mysql_select_db("octres");
$TleCampos= $sqlm->sql_select("autoform_config","labelcampo,nombrecampo","idtabla_rel = '".$idform."' AND telefono = 1 and eliminado != 1 ORDER BY poscampo",0);

?>
<div align="center">
  <form id="form1" name="form1" method="post" action="dialer_newc.php?op=1">
    <table border="0" cellpadding="2" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td rowspan="2" align="left" valign="middle" class="textos">Nombre 
          <label for="nombre"></label></td>
        <td rowspan="2" align="left" valign="middle"><input class=":required" type="text" name="nombre" id="nombre" /></td>
        <td class="textos">Fecha de inicial</td>
        <td><?=$formulario->c_fecha_input("","fecha_ini","","",$fecha_act,1,0);?>
        &nbsp;</td>
        <td class="textos">Fecha Final</td>
        <td><?=$formulario->c_fecha_input("","fecha_fin","","","",":required",0);?>
        &nbsp;</td>
      </tr>
      <tr>
        <td class="textos">Hora Inicial</td>
        <td><select name="hora_ini_HH" id="hora_ini_HH"><option value="HH">HH</option>
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
<select name="hora_ini_MM" id="hora_ini_MM"><option value="MM">MM</option>
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
          <option value="HH">HH</option>
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
  <option value="MM">MM</option>
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
        <td align="left" valign="middle"><input class=":required" name="canales" type="text" id="canales" size="5" maxlength="5" /></td>
        <td class="textos">Cola</td>
        <td>
        <? 
	mysql_select_db("asterisk");	
	$parametrosGrupoHerr=array(
	"tabla"=>"queues_config",
	"campo1"=>"extension",
	"campo2"=>"extension",
	"campoid"=>"extension",
	"condiorden"=>"1");
	
	echo $formulario->c_select("","cola","","","",$parametrosGrupoHerr,0,"","MuestraFils"); ?>
		</td>
        <td class="textos">Intentos</td>
        <td><input class=":required" name="intentos" type="text" id="intentos" size="5" maxlength="5" /></td>
      </tr>
      <tr>
        <td colspan="6" align="left" valign="middle" class="textos">Campo Telefonico a Marcar: 
<? for($i = 0 ;$i < count($TleCampos) ; $i++) { ?>
	<?=$TleCampos[$i][labelcampo]?> <input name="telefono" type="radio" value="<?=$TleCampos[$i][nombrecampo]?>" />  
<? } ?> 
        </td>
      </tr>
      <tr>
        <td colspan="6" align="left" valign="middle" class="textos">Script:</td>
      </tr>
      <tr>
        <td colspan="6" align="left" valign="middle">   
	
    <textarea cols="80" id="script" name="script" rows="10"></textarea>

        </td>
      </tr>
      <tr>
        <td colspan="6" align="center" valign="middle"><div align="center">Al guardar la lista de registros de este filtro sera asignada para marcacion predictiva.</div></td>
      </tr>
      <tr>
        <td colspan="6" align="left" valign="middle"><div align="center">
          <input name="idform" type="hidden" id="idform" value="<?=$idform?>" />
          <input name="idfiltro" type="hidden" id="idfiltro" value="<?=$idfiltro?>" />
          <input type="submit" name="button" id="button" value="Guardar" />
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
if($op == 1){
include '../../appcfg/general_config.php';

mysql_select_db("call_center");

$GuardaCam = $sqlm->inser_data("campaign","name,datetime_init,datetime_end,daytime_init,daytime_end,retries,context,queue,max_canales,script,estatus,idofill",
"'$nombre','$fecha_ini','$fecha_fin','$hora_ini_HH:$hora_ini_MM','$hora_fin_HH:$hora_fin_MM','$intentos','from-internal','$cola','$canales','$script','A','$idfiltro'",0);

$MaxCam = $sqlm->sql_select("campaign","MAX(id) as maximo","1");

$GuardaForm = $sqlm->inser_data("campaign_form","id_campaign,id_form","'".$MaxCam[0][maximo]."','1'",0);

//--------------------------------------------------************
mysql_select_db("octres");

$TraeCondiciones = $sqlm->sql_select("firter_conditions","*","idrelconfig = '".$idfiltro."'",0);

for($i=0 ; $i<count($TraeCondiciones);$i++){ /*Aqui termino el for que muestra los filtro*/ 
	
	@$CampoData = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$TraeCondiciones[$i][campo]."'",0);

$condiciones .= "AND ".$TraeCondiciones[$i][campo]." ".$TraeCondiciones[$i][condicion]." '".$TraeCondiciones[$i][valor]."'";

 } 
 
 //---------------------------------------- 
$TraeCampos = $sqlm->sql_select("filter_camposm","*","idfiltro = '".$idfiltro."'",0);
 
for($i=0 ; $i<count($TraeCampos);$i++){ /*Aqui termino el for que muestra los filtro*/ 
	
	@$CampoData = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$TraeCampos[$i][campom]."'",0);

$CamposMos .= ",".$TraeCampos[$i][campom];

$CamposLabel[]=$CampoData[0][labelcampo];

 } 
 
 //---------------------------------------- 
 
$TablaData= $sqlm->sql_select("autoform_tablas","*","id_autoformtablas = '".$CampoData[0][idtabla_rel]."'",0);

$Reduldado = $sqlm->sql_select($TablaData[0][nombretabla],"COUNT(".$TablaData[0][campoid].") as cuenta","1 $condiciones",0);

$CamposMos = $TablaData[0][campoid].$CamposMos.",$telefono";

//trae el filtro personalizado que se aplico

$TraeFillTemplate = $sqlm->sql_select("filter_tamplate,filter_config","clausulas,filter_tamplate.nombre as nombreT,idtemplate","id_filter = '$idfiltro' and id_filtertemplate = idtemplate",0);
if(is_array($TraeFillTemplate)){
$condiciones .= " AND (".$TraeFillTemplate[0][clausulas].")";
}

//trae el filtro personalizado que se aplico

$GetDialerData=$sqlm->sql_select($TablaData[0][nombretabla],"$CamposMos","1 $condiciones",0);

//alimentamos la tabla del marcador predictivo con la lista de registros a marcar.

mysql_select_db("call_center");

for($i=0 ; $i < count($GetDialerData) ; $i++ ){ //aqui guardamos los datos en calls 
	
	$GuardaNumeros = $sqlm->inser_data("calls","id_campaign,phone","'".$MaxCam[0][maximo]."','".$GetDialerData[$i][$telefono]."'",0);
	$MaxCall = $sqlm->sql_select("calls","MAX(id) as maximo","1");
	
		$GuardaAtrribute1 = $sqlm->inser_data("call_attribute","id_call,columna,value,column_number","'".$MaxCall[0][maximo]."','1','".$GetDialerData[$i][$TablaData[0][campoid]]."','1'",0);
		$GuardaAtrribute2 = $sqlm->inser_data("call_attribute","id_call,columna,value,column_number","'".$MaxCall[0][maximo]."','2','".$TablaData[0][campaignid]."','2'",0);
		
		$col=2;
		
		for($o=0 ; $o<count($TraeCampos);$o++){ /*aqui guardamos los datos en call Atribute*/ 
		
		$col++;
		$CamposMos .= $TraeCampos[$i][campom].",";
		$GuardaAtrribute = $sqlm->inser_data("call_attribute","id_call,columna,value,column_number","'".$MaxCall[0][maximo]."','$col','".$GetDialerData[$i][$TraeCampos[$o][campom]]."','$col'",0);

 		} /*aqui guardamos los datos en call Atribute*/ 
		
	} 
//--------------------------------------------------************
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