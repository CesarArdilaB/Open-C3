<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[op] != 7){

$ListaBodegas = $sqlm->sql_select("inv_bodegas,inv_inventario","count(idbodega) as cuenta, nombre","idbodega = id_bodegas GROUP BY idbodega",0);
?>
<link rel="stylesheet" type="text/css" href="../../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../../css/estilos.css"/>

<div align="center">
  <h3>Reporte de Bodegas<br>
    <br>
  </h3>
</div>
<table border="0" align="center" cellpadding="2" cellspacing="1" class="rounded-corners-gray">
  <tr>
    <td align="center" class="textos_titulos">Bodega</td>
    <td align="center" class="textos_titulos">Numero de Tarjetas</td>
  </tr>
<? for($i=0 ; $i < count($ListaBodegas) ; $i++){//este es el final del for 

//$ValTarjetas = $sqlm->sql_select("inv_inventario","campos","clausulas",0);

?>


  <tr>
    <td bgcolor="#FFFFFF" class="textos"><?=$ListaBodegas[$i][nombre]?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?=$ListaBodegas[$i][cuenta]?>&nbsp;</td>
  </tr>
<? } //este es el final del for ?>
</table>
<br />
<div id="PersInf"></div>
<? 
}//este es el que saca si no ahy ninguna opcion

?>