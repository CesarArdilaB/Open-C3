<?
session_start();

if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[op] != 7){
	
	
	if(isset($_GET[okasist])){
	include '../../appcfg/cc.php';	
		
$actualizar = "UPDATE mensajeros SET asistencia = 0 WHERE id_mensajero = '$_GET[okasist]'";
mysql_query($actualizar);

		
		}
	
	
?>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center">
  <h3>Panel En Tiempo Real de Mensajeros</h3>
</div>

<script>
setInterval( "EnviarLinkJ('AgentsEstatus','modules/monitoring/courier_realtimepanel.php?op=1','',1)", 2000 );
</script>
<br />

<div id="AgentsEstatus"></div>

<? 
}//este es el que saca si no ahy ninguna opcion
if($_GET[op] == 1){ // aqui termina la opcion 1
include '../../appcfg/general_config.php';
require '../../appcfg/class_reports.php';
$reporte = new reportes();
$reporte->RutaHTTP="$RAIZHTTP";

mysql_select_db("octres");

$MensajerosLista = $sqlm->sql_select("mensajeros","*","inactivo = 0 AND nolabora = 0",0);

//print_r($agentesQe);
?>

<div align="center">

<table width="0" border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
  <tr>
    <td align="center" class="textos_titulos">Nombre</td>
    <td align="center" class="textos_titulos">Estado</td>
    <td align="center" class="textos_titulos">Ultima Gestion</td>
    <td align="center" class="textos_titulos">Ultima Ubicacion</td>
    <td align="center" class="textos_titulos">Numero de Entregas</td>
    <td align="center" class="textos_titulos">Entregadas</td>
    <td align="center" class="textos_titulos">Autenticadas</td>
    <td align="center" class="textos_titulos">Semaforo</td>
  </tr>
<? for($i = 0 ;$i < count($MensajerosLista) ; $i++) {

$Autenticadas = 0;

genera_modalF("mapvew".$i,560,580,"");

if($MensajerosLista[$i][mobilin] != ""){ 

$estado = "Conectado"; $colorf = "#9BFF9B"; 

$LastDateData = $sqlm->sql_select("agenda","geotag,horaup,aut","idmensajero = '".$MensajerosLista[$i][id_mensajero]."' AND fecha = '$fecha_act' AND feedback != '0' ORDER BY horaup DESC",0);




if(is_array($LastDateData)){
	
	
	$Entregadas = count($LastDateData);



//--------------------

for( $z=0 ; $z < count($LastDateData) ; $z++ ){ 

if($LastDateData[$z][aut] != 0){ $Autenticadas++; } 

}

$ARRauten[] = $Autenticadas;

//--------------------


}else{ $Entregadas=0; }



$CitasAgendadas = $sqlm->sql_select("agenda","feedback","idmensajero = '".$MensajerosLista[$i][id_mensajero]."' AND fecha = '$fecha_act'",0);

if(is_array($CitasAgendadas)){$Agendadas = count($CitasAgendadas);}else{ $Agendadas=0; }


$Percent = ($Entregadas / $Agendadas)*100;


$ARRagendadas[] 	= $Agendadas;
$ARRentregadas[] 	= $Entregadas;

if($Percent < 35){ 						$CellColor = "bgcolor='red'"; }
if($Percent > 35 and $Percent < 70){ 	$CellColor = "bgcolor='yellow'"; }
if($Percent > 70){ 						$CellColor = "bgcolor='green'"; }


if(is_array($LastDateData)){

$horaUltima = $LastDateData[0][horaup];
$geotagU = "<a target='_blank' class='mapvew$i' href='modules/monitoring/courier_map.php?geoT=".$LastDateData[0][geotag]."'>Ver Mapa</a>";

if($LastDateData[0][geotag] == ""){ $geotagU = ""; }

}else{
	
$horaUltima = "";
$geotagU = "";
	
	}
	
	
	
	
	
if($MensajerosLista[$i][asistencia ] == "1"){ 


$estado = "Solicita Asistencia!! <a href='?sec=monitoring&mod=courier_realtimepanel&okasist=".$MensajerosLista[$i][id_mensajero]."'><img src='imgs/check.gif' width='20' height='20' /></a>"; 
$colorf = "#FFC4C4"; 


}

}
else{ 

$estado = "Desconectado"; 
$colorf = "#FFF"; 
$horaUltima = ""; 
$geotagU = "";
$Entregadas = "";
$Agendadas = "";
$Percent ="";
$CellColor="";

}
	
?>
  <tr bgcolor="<?=$colorf?>">
    <td class="textos_titulos"><?=$MensajerosLista[$i][name]?>&nbsp;</td>
    <td align="left" class="textospadding"><?=$estado?>&nbsp;</td>
    <td align="left" class="textospadding"><?=$horaUltima?>&nbsp;</td>
    <td align="left" class="textospadding"><?=$geotagU?>&nbsp;</td>
    <td align="center" class="textospadding"><?=$Agendadas?>&nbsp;</td>
    <td align="center" class="textospadding"><?=$Entregadas?>&nbsp;</td>
    <td align="center" class="textospadding"><?=$Autenticadas?></td>
    <td align="center" class="textosbig" <?=$CellColor?> ><?=number_format($Percent,0,",",".")?>%&nbsp;</td>
  </tr>
<? } 

$TOTALPercent = (array_sum($ARRentregadas) / array_sum($ARRagendadas))*100;

if($TOTALPercent < 35){ 						$CellTColor = "bgcolor='red'"; }
if($TOTALPercent > 35 and $Percent < 70){ 		$CellTColor = "bgcolor='yellow'"; }
if($TOTALPercent > 70){ 						$CellTColor = "bgcolor='green'"; }


?>   

<tr bgcolor="#CCCCCC">
    <td colspan="4" align="right" class="textos_titulos">General:</td>
    <td align="center" class="textospadding"><?=number_format(array_sum($ARRagendadas),0,"",".")?>&nbsp;</td>
    <td align="center" class="textospadding"><?=number_format(array_sum($ARRentregadas),0,"",".")?>&nbsp;</td>
    <td align="center" class="textospadding"><?=number_format(array_sum($ARRauten),0,",",".")?></td>
    <td align="center" class="textosbig" <?=$CellTColor?>><?=number_format($TOTALPercent,0,",",".")?>%&nbsp;</td>
  </tr>
<tr bgcolor="#CCCCCC">
  <td colspan="8" align="center" bgcolor="#FFFFFF" class="textos_titulos">
  
  <br />
  <table width="415" border="0" align="center" cellpadding="o" cellspacing="o" class="rounded-corners-blue">
  <tr>
    <td align="center" class="textosbig">Porcentaje Global de Entragas</td>
  </tr>
  <tr>
    <td align="center" class="textosbig">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><div class="timer"></div><div class="timer fill"></div></div></td>
  </tr>
</table>
  &nbsp;</td>
  </tr>

  </table>

		<style>
			.timer {
				position:relative;
				font-size: 200px;
				width:1em;
				height:1em;
				float: left;
			}
			.timer > .percent {
				position: absolute;
				top: 1.05em;
				left: 0;
				width: 3.33em;
				font-size: 0.3em;
				text-align:center;
			}
			.timer > #slice {
				position:absolute;
				width:1em;
				height:1em;
				clip:rect(0px,1em,1em,0.5em);
			}
			.timer > #slice.gt50 {
				clip:rect(auto, auto, auto, auto);
			}
			.timer > #slice > .pie {
				border: 0.1em solid #c0c0c0;
				position:absolute;
				width:0.8em; /* 1 - (2 * border width) */
				height:0.8em; /* 1 - (2 * border width) */
				clip:rect(0em,0.5em,1em,0em);
				-moz-border-radius:0.5em;
				-webkit-border-radius:0.5em; 
				border-radius:0.5em; 
			}
			.timer > #slice > .pie.fill {
				-moz-transform:rotate(180deg) !important;
				-webkit-transform:rotate(180deg) !important;
				-o-transform:rotate(180deg) !important;
				transform:rotate(180deg) !important;
			}
			.timer.fill > .percent {
				display: none;
			}
			.timer.fill > #slice > .pie {
				border: transparent;
				background-color: #c0c0c0;
				width:1em;
				height:1em;
			}
		</style>
		<script type="text/javascript">
			var timer;
			var timerCurrent;
			var timerFinish;
			var timerSeconds;
			function drawTimer(percent){
				$('div.timer').html('<div class="percent"></div><div id="slice"'+(percent > 50?' class="gt50"':'')+'><div class="pie"></div>'+(percent > 50?'<div class="pie fill"></div>':'')+'</div>');
				var deg = 360/100*percent;
				$('#slice .pie').css({
					'-moz-transform':'rotate('+deg+'deg)',
					'-webkit-transform':'rotate('+deg+'deg)',
					'-o-transform':'rotate('+deg+'deg)',
					'transform':'rotate('+deg+'deg)'
				});
				$('.percent').html(Math.round(percent)+'%');
			}
			function stopWatch(){
				var seconds = (timerFinish-(new Date().getTime()))/1000;
				if(seconds <= 0){
					drawTimer(100);
					clearInterval(timer);
					$('input[type=button]#watch').val('Start');
					alert('Finished counting down from '+timerSeconds);
				}else{
					var percent = 100-((seconds/timerSeconds)*100);
					drawTimer(percent);
				}
			}
            $(document).ready(function(){
				$('input[type=button]#percent').click(function(e){
					e.preventDefault();
					drawTimer($('input[type=hidden]#percent').val());
				});
				
				
				
				$('input[type=button]#percent').click();

			});
		</script>

		<input type="button" id="percent" style="display:none" value="Set timer to" /> 
		<input type="hidden" id="percent" size="2" value="<?=number_format($TOTALPercent,0)?>" />
		
</div>
<? 

//echo $astm->trae_agentes();

} // aqui termina la opcion 1?>