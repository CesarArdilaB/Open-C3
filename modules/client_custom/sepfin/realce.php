<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[op] != 7){

?>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center">
  <h3>Reporte Realce Tarjetas</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/client_custom/sepfin/realce.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Inicial: <br></td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_ini","","")?>
          &nbsp;</td>
        <td class="textos_titulos">Fecha Final: </td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_fin","","")?></td>
        <td class="textos_titulos"><span class="textosbig">
          <input type="submit" name="button" id="button" value="Generar">
        </span></td>
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
