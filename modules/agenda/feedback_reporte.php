<? 
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3){


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

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<form name="form1" id="form1" onsubmit="EnviarLinkForm('MuestraReporte','<?=$RAIZHTTP?>/modules/agenda/feedback_reporte.php?op=2',this);return false;">
  <table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
    <tr>
      <td colspan="4" align="center" class="textos_titulos">Reporte Feedback</td>
    </tr>
    <tr>
      <td class="textospadding">Fecha Inicial</td>
      <td><span class="textos_titulos">
        <?=$formulario->c_fecha_input("","fecha_ini","","")?>
      </span></td>
      <td class="textospadding">Fecha Final</td>
      <td><span class="textos_titulos">
        <?=$formulario->c_fecha_input("","fecha_fin","","")?>
      </span></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="button" id="button" value="Generar" /></td>
    </tr>
  </table>
</form>
<hr>

<div id="MuestraReporte"></div>

<? }if($_GET[op] == 2){
if($inc != 1){ include("../../appcfg/general_config.php"); }

$DataFeed = $sqlm->sql_select("agenda","feedback,idmensajero,idmensajero_entrego","fecha BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' AND idmensajero != 0 GROUP BY idmensajero",0);

excelexp("datafeed");
?>	
<table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-gray" id="datafeed">
  <tr class="textos_titulos">
    <td class="textos_titulos">Mensajero</td>
    <td class="textos_titulos">Total envios despachados</td>
    <td class="textos_titulos">Cantidad de entregas efectivas</td>
    <td class="textos_titulos">Registros con feedback no efectivo</td>
    <td class="textos_titulos">Resgistros sin feedback</td>
  </tr>
<? 

for( $i = 0 ; $i < count($DataFeed) ; $i++ ){ 

$DataAgen = $sqlm->sql_select("agenda","feedback","fecha BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' AND idmensajero = '".$DataFeed[$i][idmensajero]."'",0);

$efectiva = 0;
$sinfeedback = 0;
$otrosfeedback = 0;

	for( $o = 0 ; $o < count($DataAgen) ; $o++ ){
		
		if($DataAgen[$o][feedback] == 3)	{ $efectiva++; 		}
		if($DataAgen[$o][feedback] == 0)	{ $sinfeedback++; 	}
		if($DataAgen[$o][feedback] != 3 and $DataAgen[$o][feedback] != 0 )	{ $otrosfeedback++;	}
			
	//termina el for de los estados
		
		}	


$Mensajero = $sqlm->sql_select("mensajeros","name","id_mensajero = '".$DataFeed[$i][idmensajero]."'",0);

genera_modalF("Total$i",1000,500,"modules/agenda/feedback_reporte.php?op=2&fecha_ini=$_GET[fecha_ini]&fecha_fin=$_GET[fecha_fin]","MuestraReporte");
genera_modalF("Efectivas$i",1000,500,"modules/agenda/feedback_reporte.php?op=2&fecha_ini=$_GET[fecha_ini]&fecha_fin=$_GET[fecha_fin]","MuestraReporte");
genera_modalF("Noefectivas$i",1000,500,"modules/agenda/feedback_reporte.php?op=2&fecha_ini=$_GET[fecha_ini]&fecha_fin=$_GET[fecha_fin]","MuestraReporte");
genera_modalF("Sinfeed$i",1000,500,"modules/agenda/feedback_reporte.php?op=2&fecha_ini=$_GET[fecha_ini]&fecha_fin=$_GET[fecha_fin]","MuestraReporte");


?>

  <tr>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$Mensajero[0][name]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding">
    <a href="modules/agenda/feedback_detalle.php?idmen=<?=$DataFeed[$i][idmensajero]?>&fecha_ini=<?=$_GET[fecha_ini]?>&fecha_fin=<?=$_GET[fecha_fin]?>&tfeed=all" class="Total<?=$i?>"><?=count($DataAgen)?></a></td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding">
	<a href="modules/agenda/feedback_detalle.php?idmen=<?=$DataFeed[$i][idmensajero]?>&fecha_ini=<?=$_GET[fecha_ini]?>&fecha_fin=<?=$_GET[fecha_fin]?>&tfeed=ok" class="Efectivas<?=$i?>"><?=$efectiva?></a></td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding" >
	<a href="modules/agenda/feedback_detalle.php?idmen=<?=$DataFeed[$i][idmensajero]?>&fecha_ini=<?=$_GET[fecha_ini]?>&fecha_fin=<?=$_GET[fecha_fin]?>&tfeed=nook" class="Noefectivas<?=$i?>"><?=$otrosfeedback?></a></td>
    <td align="center" bgcolor="#FFFFFF" class="textospadding">
	<a href="modules/agenda/feedback_detalle.php?idmen=<?=$DataFeed[$i][idmensajero]?>&fecha_ini=<?=$_GET[fecha_ini]?>&fecha_fin=<?=$_GET[fecha_fin]?>&tfeed=none" class="Sinfeed<?=$i?>"><?=$sinfeedback?></a></td>
  </tr>
<?  } ?>
</table>
<?	} ?>