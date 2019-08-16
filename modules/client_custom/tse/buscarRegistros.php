<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[op] != 7){

?>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center">
  <h3>Reporte de Ventas</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/client_custom/tse/buscarRegistros.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Buscar Cedula</td>
        <td class="textos_titulos"><label for="cedula"></label>
        <input type="text" name="cedula" id="cedula" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><span class="textosbig">
          <input type="submit" name="button" id="button" value="Buscar">
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


$TraeRegistros = $sqlm->sql_select("autof_matrizprincipal_1","autof_matrizprincipal_1_id,af13_155,af13_40,af13_253,af13_39,af13_49,af13_34,af13_41,af13_38,af13_109","af13_39 = '$_GET[cedula]'",0);

if(is_array($TraeRegistros)){


?>
<table width="0" border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
  <tr>
    <td align="center" class="textos_titulos">Id Registro</td>
    <td align="center" class="textos_titulos">Fecha de recibido fisico</td>
    <td align="center" class="textos_titulos">Cliente</td>
    <td align="center" class="textos_titulos">Cedula</td>
    <td align="center" class="textos_titulos">Campaña</td>
    <td align="center" class="textos_titulos">Pseudo Codigo</td>
    <td align="center" class="textos_titulos">Gestion Call</td>
    <td align="center" class="textos_titulos">Bodega</td>
    <td align="center" class="textos_titulos">Estado De Bodega</td>
    <td align="center" class="textos_titulos">Fecha de Salida</td>
    <td align="center" class="textos_titulos">Fecha de Entrega</td>
    <td align="center" class="textos_titulos">Tipo de Tarjeta</td>
    <td align="center" class="textos_titulos">Tipo Entrega</td>
    <td align="center" class="textos_titulos">Acciones</td>
  </tr>
<? for($i = 0 ;$i < count($TraeRegistros) ; $i++) { 
$cuenta++;
$TraeCam = $sqlm->sql_select("autof_af13_38","field1","id_af13_38 = '".$TraeRegistros[$i][af13_38]."'",0);
if(is_array($TraeCam)){$campana = $TraeCam[0][field1];}else{ $campana = ""; }


$TraeCGesCall = $sqlm->sql_select("autof_af13_109","field1","id_af13_109 = '".$TraeRegistros[$i][af13_109]."'",0);
if(is_array($TraeCGesCall)){$callges = $TraeCGesCall[0][field1];}else{ $callges = ""; }

$TipoTarjeta = $sqlm->sql_select("autof_af13_253","field1","id_af13_253 = '".$TraeRegistros[$i][af13_253]."'",0);
if(is_array($TipoTarjeta)){$TipoT = $TipoTarjeta[0][field1];}else{ $TipoT = ""; }

$TipoEntrega = $sqlm->sql_select("autof_af13_155","field1","id_af13_155 = '".$TraeRegistros[$i][af13_155]."'",0);
if(is_array($TipoEntrega)){$TipoENT = $TipoEntrega[0][field1];}else{ $TipoENT = ""; }


$CustodiuaDATA = $sqlm->sql_select("inv_inventario,inv_estado","estado,fechasalida,fechaentrega,fechah,idbodega","idregistro ='".$TraeRegistros[$i][autof_matrizprincipal_1_id]."' AND idestado = id_estado",0);

if(is_array($CustodiuaDATA)){
$BodegaNombre = $sqlm->sql_select("inv_bodegas","nombre","id_bodegas ='".$CustodiuaDATA[0][idbodega]."'",0);
$FechaSal = $CustodiuaDATA[0][fechasalida];
$FechaEnt = $CustodiuaDATA[0][fechaentrega];
}
if(is_array($BodegaNombre)){$BodegaTxt = $BodegaNombre[0][nombre];}else{$BodegaTxt = "";}


if(is_array($CustodiuaDATA)){
	
	$estadoINV = $CustodiuaDATA[0][estado]; 
	$fechaSalidaINV = $CustodiuaDATA[0][fechasalida]; 
	$fechaFisico = $CustodiuaDATA[0][fechah];  
	
	}else {
		
	$estadoINV = "";
	$fechaSalidaINV = ""; 
	
	} 



?>
  <tr>
    <td align="center" bgcolor="#FFFFFF" class="textos"><a href="/openc3/?sec=gestion&mod=agent_console&regediting=<?=$TraeRegistros[$i][autof_matrizprincipal_1_id]?>&camediting=1"><?=$TraeRegistros[$i][autof_matrizprincipal_1_id]?></a>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$TraeRegistros[$i][af13_34]?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$TraeRegistros[$i][af13_40]?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$TraeRegistros[$i][af13_39]?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$campana?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=substr($TraeRegistros[$i][af13_41],-4)?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$callges?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$BodegaTxt?></td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$estadoINV?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$FechaSal?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$FechaEnt?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$TipoT?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><?=$TipoENT?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="textos"><a href="/openc3/?sec=gestion&mod=agent_console&regediting=<?=$TraeRegistros[$i][autof_matrizprincipal_1_id]?>&camediting=1">Ver Registro</a>&nbsp;</td>
  </tr>
<? } ?>
  <tr>
    <td align="center" class="textos_titulos">Total:</td>
    <td colspan="13" align="left" class="textos_titulos"><?=$cuenta?>&nbsp;</td>
  </tr> 
</table>
<? 
}//si es array
//echo $astm->trae_agentes();

} // aqui termina la opcion 1?>
