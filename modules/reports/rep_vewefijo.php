<? 
require './appcfg/class_reports.php';

$reporte = new reportes();
$reporte->RutaHTTP="$RAIZHTTP";

$JsScripts->ReporteScripts();

	$ReporteParam=$sqlm->sql_select("rep_config","nombre,id_filter","id_filter = '".$_GET[repid]."'");
?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<meta charset="utf-8">
	
<div align="center">
  <table border="0" cellspacing="2" cellpadding="0" align="center">
    <tr>
      <td align="center" valign="top"><table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-gray">
        <tr>
          <td class="textos_titulos">Mostrando El Reporte</td>
          <td class="textos_titulos"><?=$ReporteParam[0][nombre]?></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" valign="top"><?=$reporte->GeneraRepFijo($_GET[repid],0,$_POST[buscar])?></td>
    </tr>
  </table>
</div>