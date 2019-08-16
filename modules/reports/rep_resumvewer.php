<? 
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5){

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

//aqui traemos los campos fecha de los modulos complementarios que estan en el reporte



$CausulaComp = $sqlm->sql_select("repdina_compare","campo,condicion,valor","idrelconfig = '$_GET[repid]'",0);

for($i=0 ; $i < count($CausulaComp) ;$i++){

	if(substr($CausulaComp[$i][campo],0,4) == "cme_")		{ 
	@$CampoData = $sqlm->sql_select("acampos_esp","*","campon = '".substr($CausulaComp[$i][campo],4,20)."'",0);

$Fcdata = $sqlm->sql_select("acampos_esp","campon,labelcampo","tabla = '".$CampoData[0][tabla]."' AND tipocampo = 'fecha'",0);

	for($o=0 ; $o < count($Fcdata) ;$o++)		{
		
		$Arrcampo[] = $CampoData[0][tabla].".".$Fcdata[$o][campon]."|".$Fcdata[$o][labelcampo]; 
		
												}

															}
	}


$CausulaData = $sqlm->sql_select("repdina_datashow","valor,identificador,ncampo","id_rep = '$_GET[repid]'",0);

for($i=0 ; $i < count($CausulaData) ;$i++){

	if(substr($CausulaData[$i][ncampo],0,4) == "cme_")		{ 
	@$CampoData = $sqlm->sql_select("acampos_esp","*","campon = '".substr($CausulaData[$i][ncampo],4,20)."'",0);

$Fcdata = $sqlm->sql_select("acampos_esp","campon,labelcampo","tabla = '".$CampoData[0][tabla]."' AND tipocampo = 'fecha'",0);

	for($o=0 ; $o < count($Fcdata) ;$o++)		{
		
		$Arrcampo[] = $CampoData[0][tabla].".".$Fcdata[$o][campon]."|".$Fcdata[$o][labelcampo]; 
		
												}

															}
	}

//aqui traemos los campos fecha de los modulos complementarios que estan en el reporte

//print_r($Arrcampo);


$Arrcampo = array_unique($Arrcampo);
//print_r($Arrcampo);

?>

<div align="center">
  <form name="form1" onsubmit="EnviarLinkForm('MuestraRep','<?=$RAIZHTTP?>/modules/reports/rep_resumvewer.php?op=2',this);return false;">
    <table border="0" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td colspan="11" align="center" class="textos_titulos">Reporte: </td>
      </tr>
      <tr>
        <? 	if(is_array($Arrcampo)){?>
        <td class="textospadding">Basarse en el campo fecha de</td>
        <td class="textospadding">
        <select name="campofecha" id="campofecha" class="">
          <option value="" selected="selected">Seleccione</option>
          <option value="" >Fecha de Gestion</option>
		<? 
		
		foreach($Arrcampo as $llave => $valor){		
		$Vals = explode("|",$valor);
		//echo $Arrcampo[$o]."<br>";

		?>

          <option value="<?=$Vals[0]?>"><?=$Vals[1]?></option>

		<?  } ?>        
        </select>
        </td>
         <? }
		 else{ 
		 
		 echo "<td class='textospadding'><input name='campofecha' type='hidden' value='' /></td>"; 
		 
		 } ?>
        <td class="textospadding">Fecha Inicial</td>
        <td><span class="textos_titulos">
          <?=$formulario->c_fecha_input("","fecha_ini","","")?>
        </span></td>
        <td class="textospadding">Fecha Final</td>
        <td><span class="textos_titulos">
          <?=$formulario->c_fecha_input("","fecha_fin","","")?>
        </span></td>
        <td>Tipo de grafico</td>
        <td><select name="gaftipe" id="gaftipe">
          <option value="line" selected="selected">Linear</option>
          <option value="bar">Barras</option>
          <option value="area">Area</option>
          <option value="scatter">Puntos</option>
        </select></td>
        <td>Mostrar Tabla de datos</td>
        <td><input name="mostrarT" type="checkbox" id="mostrarT" value="1" checked="checked" /></td>
      </tr>
      <tr>
        <td colspan="11" align="center"><input type="hidden" name="repid" id="repid" value="<?=$_GET[repid]?>" />          <input type="submit" name="button" id="button" value="Generar" /></td>
      </tr>
    </table>
  </form>
</div>


<hr>

<div id="MuestraRep"></div>

<?
}if($_GET[op] == 2){

include '../../appcfg/general_config.php';
require '../../appcfg/class_reports.php';

$JsScripts = new ScriptsSitio();

$JsScripts->rutaserver="$RAIZHTTPCONF";

$JsScripts->CharScripts();

$reporte = new reportes();
$reporte->RutaHTTP="$RAIZHTTP";
	
//	print_r($_GET);
$reporte->Genera_Reporte_Graf($_GET[repid],$_GET[fecha_ini],$_GET[fecha_fin],$_GET[campofecha],$_GET[gaftipe],$_GET[mostrarT]);


}

?>
