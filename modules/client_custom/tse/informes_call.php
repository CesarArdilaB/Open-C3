<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[op] != 7){

?>
<link rel="stylesheet" type="text/css" href="../../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../../css/estilos.css"/>

<div align="center">
  <h3>Informes de Call Center</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/client_custom/tse/informes_call.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Inicial: <br></td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_ini","","")?>
          &nbsp;</td>
        <td class="textos_titulos">Seleccione un Criterio</td>
        <td class="textos_titulos"> Operador</td>
        <td class="textos_titulos"><input type="radio" name="camporep" id="radio" value="operador" /></td>
        <td class="textos_titulos">Gestion Call Center</td>
        <td class="textos_titulos"><input type="radio" name="camporep" id="radio2" value="callcenter" /></td>
        <td class="textos_titulos">Ciudad</td>
        <td class="textos_titulos"><input type="radio" name="camporep" id="radio3" value="ciudad" /></td>
        <td rowspan="2" class="textos_titulos"><span class="textosbig">
          <input type="submit" name="button" id="button" value="Generar">
        </span></td>
      </tr>
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Final: </td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_fin","","")?></td>
        <td class="textos_titulos">Seleccione un Intervalo:</td>
        <td class="textos_titulos">Diario</td>
        <td class="textos_titulos"><input type="radio" name="intervalo" id="radio7" value="DAYOFYEAR"></td>
        <td class="textos_titulos">Semanal</td>
        <td class="textos_titulos"><input type="radio" name="intervalo" id="radio6" value="WEEKOFYEAR"></td>
        <td class="textos_titulos">Mensual</td>
        <td class="textos_titulos"><input type="radio" name="intervalo" id="radio5" value="MONTH"></td>
      </tr>
    </table>
  </form>
</div>
<br />
<div id="PersInf"></div>
<? 
}//este es el que saca si no ahy ninguna opcion
if($_GET[op] == 1){ // aqui termina la opcion 1
include '../../../appcfg/general_config.php';

$JsScripts = new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTPCONF";
$JsScripts->CharScripts();


switch($_GET[intervalo]){
	
	case "DAYOFYEAR";
	$LabelT = "Dia";
	$ValosM = "DAY";
	break;
	
	case "WEEKOFYEAR";
	$LabelT = "Semana";
	$ValosM = "WEEK";
	break;
	
	case "MONTH";
	$LabelT = "Mes";
	$ValosM = "MONTH";
	break;
	
	}


//--- aqui seleccionamos las fechas 
$SelectFechas = $sqlm->sql_select("history_1","$_GET[intervalo](fechahora) as FechaInt, DATE(fechahora) fecha , $ValosM(fechahora) as fmostrar","fechahora BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' GROUP BY $_GET[intervalo](fechahora)",0);

if(is_array($SelectFechas)){ //verifica que exta la fecha

					// aqui verificamos los estados para asignar tablas y clausulas. 
if($_GET[camporep] == "operador"){ 
	
	$tablas 		= "history_1,agents";
	$clausulas 		= "id_usuario = id_agents AND his_af13_109 = 1 AND $_GET[intervalo](fechahora)";
	$campos 		= "count(his_af13_109) as cuenta";
	$comparalabel	= "id_usuario";
	$campofecha		= "fechah_his";
	$ConsultaLabels = $sqlm->sql_select("agents","name as LabelC , id_agents as IdComp","tipo = 0 AND name != '' AND inactivo = 0",0);
	$reporteid		= "callcenter1";
	$agrupadero		= " GROUP BY id_reg";
	
	}
	

if($_GET[camporep] == "callcenter"){ 
	
	$tablas 		= "history_1";
	$clausulas 		= "$_GET[intervalo](fechahora)";
	$campos 		= "count(his_af13_109) as cuenta";
	$comparalabel	= "his_af13_109";
	$campofecha		= "fechah_his";
	$ConsultaLabels = $sqlm->sql_select("history_1,autof_af13_109","field1 as LabelC , his_af13_109 as IdComp","his_af13_109 = id_af13_109 GROUP BY his_af13_109",0);
	$reporteid		= "callcenter2";
	$agrupadero		= " GROUP BY id_reg";
	
	}
	
if($_GET[camporep] == "ciudad"){ 
	
	$tablas 		= "history_1,autof_matrizprincipal_1";
	$clausulas 		= "id_reg = autof_matrizprincipal_1_id AND $_GET[intervalo](fechahora)";
	$campos 		= "count(af13_67) as cuenta";
	$comparalabel	= "af13_67";
	$campofecha		= "fechah_his";
	$ConsultaLabels = $sqlm->sql_select("autof_matrizprincipal_1,autof_af13_67","field1 as LabelC , af13_67 as IdComp","af13_67 = id_af13_67 GROUP BY af13_67",0);
	$reporteid		= "callcenter3";
	$agrupadero		= " GROUP BY id_reg";
	
	}
	
					// aqui verificamos los estados para asignar tablas y clausulas. 
					
		//aqui hacemos el form que saca el informe en cada fecha.
					
for($i=0 ; $i < count($SelectFechas) ; $i++ ){
	

	} 	//aqui hacemos el form que saca el informe en cada fecha.
					
					
	
?>
<div align="center">
<table width="0" border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue" id="tabladatos">
<thead>
  <tr>
    <td align="center" class="textos_titulos">Item</td>
<? for($i = 0 ;$i < count($SelectFechas) ; $i++) { ?>
<th align="center" class="textos_titulos"><?=$LabelT?> - <?=$SelectFechas[$i][fmostrar]?></th>
<? } ?>
  </tr>
 </thead>
 <tbody>
<? for($i = 0 ;$i < count($ConsultaLabels) ; $i++) { ?>
  <tr>
    <th align="left" class="textos"><?=utf8_encode($ConsultaLabels[$i][LabelC])?>&nbsp;</th>
<? 
for($o = 0 ;$o < count($SelectFechas) ; $o++) { 
$SelectDATA = $sqlm->sql_select($tablas,$campos,$clausulas." = ".$SelectFechas[$o][FechaInt]." AND  YEAR(fechahora) = YEAR('".$SelectFechas[$o][fecha]."') AND $comparalabel = ".$ConsultaLabels[$i][IdComp].$agrupadero,0);
?>
<th align="center" class="textos">
<? genera_modalF("Link$i$o",1300,500,"",""); ?>
<a href="<?=$RAIZHTTP?>/modules/client_custom/tse/informes_detail.php?qt=<?=$tablas?>&qc=<?=$clausulas?>&qf=<?=$SelectFechas[$o][FechaInt]?>&qfy=<?=$SelectFechas[$o][fecha]?>&qd=<?=$ConsultaLabels[$i][IdComp]?>&rid=<?=$reporteid?>&compc=<?=$comparalabel?>" class="textos <? echo "Link$i$o"; ?>"><? if (is_array($SelectDATA)){ 


	if($agrupadero != ""){echo count($SelectDATA);}
	 else{echo $SelectDATA[0][cuenta];} 

}else{ echo 0; }?></a>&nbsp;</th>
<? } ?> 
  </tr>
<? } ?> 
</tbody>
</table>



<table id="TabladatosGraf" style="display:none">
<thead>
  <tr>
    <th> </th>
<? for($i = 0 ;$i < count($ConsultaLabels) ; $i++) { ?>
<th><?=utf8_encode($ConsultaLabels[$i][LabelC])?></th>
<? } ?>
  </tr>
 </thead>
 <tbody>
<? for($i = 0 ;$i < count($SelectFechas) ; $i++) { ?>
  <tr>
    <th><?=$LabelT?> <?=$SelectFechas[$i][fmostrar]?></th>
<? for($o = 0 ;$o < count($ConsultaLabels) ; $o++) { 
$SelectDATA = $sqlm->sql_select($tablas,$campos,$clausulas." = ".$SelectFechas[$i][FechaInt]." AND  YEAR(fechahora) = YEAR('".$SelectFechas[$i][fecha]."') AND $comparalabel = ".$ConsultaLabels[$o][IdComp].$agrupadero,0);
?>
<td><? if (is_array($SelectDATA)){ 

		if($agrupadero != ""){echo count($SelectDATA);}
	 	else{echo $SelectDATA[0][cuenta];} 

}else{ echo 0; }?></td>
<? } ?> 
  </tr>
<? } ?> 
</tbody>
</table>



</div>

<script>
// On document ready, call visualize on the datatable.
$(document).ready(function() {
	/**
	 * Visualize an HTML table using Highcharts. The top (horizontal) header
	 * is used for series names, and the left (vertical) header is used
	 * for category names. This function is based on jQuery.
	 * @param {Object} table The reference to the HTML table to visualize
	 * @param {Object} options Highcharts options
	 */
	Highcharts.visualize = function(table, options) {
		// the categories
		options.xAxis.categories = [];
		$('tbody th', table).each( function(i) {
			options.xAxis.categories.push(this.innerHTML);
		});

		// the data series
		options.series = [];
		$('tr', table).each( function(i) {
			var tr = this;
			$('th, td', tr).each( function(j) {
				if (j > 0) { // skip first column
					if (i == 0) { // get the name and init the series
						options.series[j - 1] = {
							name: this.innerHTML,
							data: []
						};
					} else { // add values
						options.series[j - 1].data.push(parseFloat(this.innerHTML));
					}
				}
			});
		});

		var chart = new Highcharts.Chart(options);
	}

	var table = document.getElementById('TabladatosGraf'),
	options = {
		chart: {
			renderTo: 'container',
			type: 'column'
		},
		title: {
			text: 'Informe Grafico'
		},
		xAxis: {
		},
		yAxis: {
			title: {
				text: 'Unidades'
			}
		},
		tooltip: {
			formatter: function() {
				return '<b>'+ this.series.name +'</b><br/>'+
					this.y +' '+ this.x.toLowerCase();
			}
		}
	};

	Highcharts.visualize(table, options);
});
</script>

<div id="container" style="width: 800px; height: 400px"></div>

<? 

}else{ echo "No hay registros para esta fecha"; }

//echo $astm->trae_agentes();

} // aqui termina la opcion 1?>