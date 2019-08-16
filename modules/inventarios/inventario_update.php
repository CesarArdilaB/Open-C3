<?
session_start();
include("../../appcfg/general_config.php");
include("../../appcfg/class_inventario.php");
	
$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();	
	
$inv =  new Inventario();
$inv->RutaHTTP=$RAIZHTTPCONF; 	



$VerificaInv = $sqlm->sql_select("inv_inventario","*","idregistro = '$_POST[idregistro]' AND idcampana = '$_POST[idcampana]'");

if(is_array($VerificaInv)){ //verificamos primero que el registro este pistoleado.

$guardar = $sqlm->update_regs("inv_inventario","idbodega = '$_POST[idbodega]',idagente = '".$_SESSION[user_ID]."',fechasalida = '$_POST[fechasalida]',idestado = '$_POST[idestado]'","id_inventario = '$_POST[idregINV]'");


//verificamos el estado y blokeamos el registro y esto es una chimbota

$EstadoTipoEnd = $sqlm->sql_select("inv_estado","tipo","id_estado = '$_POST[idestado]' AND tipo = 'end'",0);
if(is_array($EstadoTipoEnd)){ $campanaC->desactiva_reg($_POST[idcampana],$_POST[idregistro]); }

//verificamos el estado y blokeamos el registro y esto es una chimbota

$guardar = $sqlm->inser_data("inv_historial","idregistro,idbodega_his,idagente_his,idestado_his,fechasalida_his,idcampana","'$_POST[idregistro]','$_POST[idbodega]','".$_SESSION[user_ID]."','$_POST[idestado]','$_POST[fechasalida]','$_POST[idcampana]'");

} //verificamos primero que el registro este pistoleado.
else {
	
?>

<div align="center" class="textosbig">Este CODIGO DE TARJETA no esta en inventario primero debe ser pistoleado y estar en match.</div>


<?
exit;	
	
	}


?>

<div align="center" class="textosbig">El Registro Fue Actualizado Correctamente.</div>

<?
//sleep(2);
redirect($RAIZHTTPCONF."/modules/inventarios/inventario_add.php?idreg=$_POST[idregistro]&idcam=$_POST[idcampana]");
?>
</div>
</div>