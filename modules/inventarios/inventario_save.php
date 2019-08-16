<?
session_start();
include("../../appcfg/general_config.php");
include("../../appcfg/class_inventario.php");
	
	$idbodega	= $_POST[idbodega];
	$lote		= $_POST[lote];
	$idestado	= $_POST[idestado];
#	$fechah		= $_POST[fechah];
	$idagente	= $_POST[idagente];
	$idregistro	= $_POST[idregistro];
	
	
$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();	
	
$inv =  new Inventario();
$inv->RutaHTTP=$RAIZHTTPCONF; 	

$seleccionaCod = $sqlm->sql_select("inv_inventario,autof_matrizprincipal_1","autof_matrizprincipal_1_id","autof_matrizprincipal_1_id = '$_POST[idregistro]' AND scodigo = af13_41",0);

if(is_array($seleccionaCod)){ //--------------------------
	
$actualizaInv =	$sqlm->update_regs("inv_inventario","idbodega = '$idbodega', idestado = '$idestado' , matchf = 1, idregistro = '".$seleccionaCod[0][autof_matrizprincipal_1_id]."'","scodigo = '".$PseudosBasee[0][af13_41]."'",0);
$guardar = $sqlm->inser_data("inv_historial","idregistro,idbodega_his,idagente_his,idestado_his","'$idregistro','$idbodega','".$_SESSION[user_ID]."','$idestado'");

	
}else	{//--------------------------

$guardar = $sqlm->inser_data("inv_inventario","idregistro,idbodega,idagente,idestado,lote","'$idregistro','$idbodega','".$_SESSION[user_ID]."','$idestado','$lote'");

$guardar = $sqlm->inser_data("inv_historial","idregistro,idbodega_his,idagente_his,,idestado_his","'$idregistro','$idbodega','".$_SESSION[user_ID]."','$idestado'");

		}//--------------------------
?>

<div align="center" class="textosbig">El Registro Fue Guardado Correctamente.</div>

<?
//sleep(2);
redirect($RAIZHTTPCONF."/modules/inventarios/inventario_add.php?idreg=$idregistro");
?>
</div>
</div>