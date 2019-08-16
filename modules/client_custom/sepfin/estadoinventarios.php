<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[op] != 7){


$TraeRegistros = $sqlm->sql_select("inv_bodegas","*","1 ORDER By nombre ASC",0);

?>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center">
  <h3>Estado Inventarios</h3>
</div>
<div align="center" class="rounded-corners-gray">
<table width="0" border="0" cellspacing="0" cellpadding="0">
    <tr class="textos_titulos">
      <td class="textos_titulos">Bodega</td>
      <td class="textos_titulos">Numero de Tarjetas&nbsp;</td>
    </tr>
<? 

for($i = 0 ;$i < count($TraeRegistros) ; $i++) { 

$Cuenta = $sqlm->sql_select("inv_inventario","count(idregistro) as cuenta","idbodega = '".$TraeRegistros[$i][id_bodegas]."' AND idestado = 1 GROUP BY idbodega",0);


?>



    <tr class="textos_titulos">
      <td class="textos_titulos"><?=$TraeRegistros[$i][nombre]?></td>
      <td align="center" class="textos_titulos"><?=$Cuenta[0][cuenta]?></td>
    </tr>
    
<? } ?>
  </table>
</div>
<br />
<div id="PersInf"></div>
<? 
}//este es el que saca si no ahy ninguna opcion
if($_GET[op] == 1){ // aqui termina la opcion 1

include '../../../appcfg/general_config.php';

//print_r($_GET);

$TraeRegistros = $sqlm->sql_select("autof_formulario1_1,ident_1","*","id_ident_1 = autof_formulario1_1_id AND DATE(fechaact) BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' AND af19_173 = 1",0);

if(is_array($TraeRegistros)){

excelexp("tablac");
?>
<table width="0" border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue" id="tablac">
  <tr>
    <td align="center" class="textos_titulos">TIPO DOCUMENTO</td>
    <td align="center" class="textos_titulos">NUMERO DE DOCUMENTO</td>
    <td align="center" class="textos_titulos">PRIMER APELLIDO</td>
    <td align="center" class="textos_titulos">SEGUNDO APELLIDO</td>
    <td align="center" class="textos_titulos">PRIMER NOMBRE</td>
    <td align="center" class="textos_titulos">SEGUNDO NOMBRE</td>
    <td align="center" class="textos_titulos">TELEFONO</td>
    <td align="center" class="textos_titulos">CELULAR</td>
    <td align="center" class="textos_titulos">NOMBRE DE LA BASE</td>
    <td align="center" class="textos_titulos">CAMPANA</td>
    <td align="center" class="textos_titulos">CUPO APROBADO</td>
    <td align="center" class="textos_titulos">CODIGO PDV</td>
    <td align="center" class="textos_titulos">DIRECCION </td>
  </tr>
<? for($i = 0 ;$i < count($TraeRegistros) ; $i++) { 

$cedula = $TraeRegistros[$i][af19_279];
$nombre = $TraeRegistros[$i][af19_155];
$telefono = $TraeRegistros[$i][af19_157];
$celular = $TraeRegistros[$i][af19_158];
$nbase = $TraeRegistros[$i][af19_226];
$campana = $TraeRegistros[$i][af19_226];
$cupoap = $TraeRegistros[$i][af19_172];// temporal observacion 3
$direccion = $TraeRegistros[$i][af19_164];

//Aqui cuadramos los nombres
$nombredesmenusado = explode(" ",$nombre);

//Aqui la direccion
$caracteres = array(",", ".", "-", "?", "_", "/", "#", ";", "\"", "\\");
$direccion = str_replace($caracteres," ",$direccion);

?>
  <tr>
    <td align="center" bgcolor="#FFFFFF" class="textos">CEDULA DE CIUDADANIA</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$cedula?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$nombredesmenusado[2]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$nombredesmenusado[3]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$nombredesmenusado[0]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$nombredesmenusado[1]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$telefono?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$celular?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$nbase?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$campana?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$cupoap?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos">515</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$direccion?></td>
  </tr>
<? } ?>
</table>
<? 
}//si es array
//echo $astm->trae_agentes();

} // aqui termina la opcion 1?>
