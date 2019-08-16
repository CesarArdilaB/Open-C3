<?
//**********************************************************************	
	require_once("../appcfg/cc.php");
	require_once("../appcfg/func_mis.php");
	require_once("../appcfg/class_forms.php");
	require_once("../appcfg/class_autoforms.php");
	require_once("../appcfg/class_sqlman.php");

$RAIZCONF = $_SERVER['DOCUMENT_ROOT']."/openc3";
$RAIZHTTP = "/openc3";

//Seteamos variables
$tabla 		= $_GET[tabla];
$camposm 	= $_GET[camposm];
$campoid 	= $_GET[campoid];
//Retemaos Variables


$sqlm= new Man_Mysql();


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZCONF";
$formulario_auto->RutaHTTP="$RAIZHTTP";
$formulario_auto->RutaRaiz="$RAIZHTTP";

//---------------------------------------------------------


$campos = explode(",",$camposm);
$tablaQ = $tabla;

$talbaDATA = $sqlm->sql_select($tablaQ,"*","1");

//-------------------------------------------

for($o=0;$o < count($campos);$o++){ 

$CampoLabel = $sqlm->sql_select("autoform_config","labelcampo","nombrecampo = '$campos[$o]'",0);

if(is_array($CampoLabel)){

$cadenaCSV .= $CampoLabel[0][labelcampo]."|" ; 

}else{

$cadenaCSV .= $campos[$o]."|" ; 

		
	}
};

$cadenaCSV .= "\r";

for($i=0;$i < count($talbaDATA);$i++){ //aqui sacamos la data
	
	for($o=0;$o < count($campos);$o++){ 
	
			if ( $campos[$o] == "fechahorac" )
			{

			$cadenaCSV .= ($talbaDATA[$i][$campos[$o]] == "0" ) ? '-' : $talbaDATA[$i][$campos[$o]]."|";
			
			}
			elseif ( $campos[$o] == "fechahora" )
			{

			$cadenaCSV .= ($talbaDATA[$i][$campos[$o]] == "0" ) ? '-' : $talbaDATA[$i][$campos[$o]]."|";
			
			}
			else if ( $campos[$o] != ' ' and  $campos[$o] != 'agente' and !ereg('id_ident_',$campos[$o]))
			{

			$selectcamposMOSParam=$sqlm->sql_select("autoform_config","tipocampo,paramcampo","nombrecampo = '$campos[$o]'",0);
			
			
	$sustituye 		= array("\r\n", "\n\r", "\n", "\r");
	$preindicacion 	= str_replace($sustituye," - ",$talbaDATA[$i][$campos[$o]]);
	$cdata 			= utf8_decode($preindicacion);

			
			
			$cadenaCSV .= $formulario_auto->armar_campo($selectcamposMOSParam[0][tipocampo],$talbaDATA[$i][$campos[$o]],"",$cdata,0,1,0,$selectcamposMOSParam[0][paramcampo])."|";
			
			}			
			else if ( $campos[$o] == 'agente')		
			{

			$cadenaCSV .= $formulario_auto->armar_campo("autocom","agente","",$talbaDATA[$i][$campos[$o]],0,1,0,"agents,id_agents,name,id_agents,1")."|";
			
			}
			else if ( $campos[$o] == $campoid)		
			{

			$cadenaCSV .= $talbaDATA[$i][$campos[$o]]."|";
			
			}//----------------- campos espesiales
	
	
	}

	$cadenaCSV .= "\r";	
		
} //aqui sacamos la data

//echo $cadenaCSV;

 $unirfecha	 = str_ireplace("-","",$fecha_act);
 
 $new_report = fopen("$RAIZ/tmp/basedatos_".$unirfecha.".csv","w");
 
 fwrite($new_report, $cadenaCSV);
 
 fclose($new_report);
 
?> 
<link rel="stylesheet" type="text/css" href="../css/estilos.css">
<br><br><br><br>
<div align="center" class="rounded-corners-gray">
<a href="../tmp/basedatos_<?=$unirfecha?>.csv" class="textosbig" ><strong>Descargar Reporte</strong></a> <br>
de click secundario y luego la opcion guardar enlace como
</div> 
<?

 //print_r($row);
// echo"================================== <br>";



//echo "SISAS $htm";
//===================================================================================
/*$archivo ="Reporte-".$_POST[fill];
$archivo .= "-".date('YmdHis');
$file = "Content-Disposition: attachment; filename=".$archivo.".xls";
header("Content-type: application/vnd.ms-excel");
header($file);
header("Pragma: no-cache");
header("Expires: 0");*/
//===================================================================================
	//echo $htm;
?>