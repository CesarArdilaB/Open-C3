<?
include("../../appcfg/general_config.php");

$sqlm->update_regs("inv_inventario","matchf = 1","idregistro = '$idReg'",0);

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<br><br>
<div align="center"  class="textosbig"> Registro En Match Correctamente </div>