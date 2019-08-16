<?
session_start();
include("../../../appcfg/general_config.php");

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();


$consulta = $sqlm->sql_select("inv_historial","idregistro","`idregistro` NOT IN (SELECT `idregistro` FROM `inv_inventario`) AND `idregistro` IN (SELECT autof_matrizprincipal_1_id FROM autof_matrizprincipal_1) GROUP BY idregistro",0);

 for($i=0;$i < count($consulta);$i++){ 
 
$consultaInv = $sqlm->sql_select("inv_historial","*","idregistro = '".$consulta[$i][idregistro]."' ORDER BY fechah_his DESC LIMIT 0,1",0);
$consultaMatriz = 	$sqlm->sql_select("autof_matrizprincipal_1","*","autof_matrizprincipal_1_id = '".$consulta[$i][idregistro]."'",0);


	$guardar = "INSERT INTO inv_inventario (idregistro,idbodega,idagente,fechah,fechasalida,idestado,lote,bolsa,guia,matchf) 
	VALUES ('".$consulta[$i][idregistro]."','".$consultaInv[0][idbodega_his]."','".$consultaInv[0][idagente_his]."','".$consultaInv[0][fechah_his]."','".$consultaInv[0][fechasalida_his]."','".$consultaInv[0][idestado_his]."','".$consultaMatriz[0][af13_167]."','".$consultaMatriz[0][af13_135]."','".$consultaMatriz[0][af13_117]."',2)";
 
 mysql_query("$guardar");
 
  }


?>

