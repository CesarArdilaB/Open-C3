<? 
//------------------ general config

$RAIZCONF = $_SERVER['DOCUMENT_ROOT']."/openc3";
$RAIZHTTPCONF = "https://$ipruta/";

include_once("$RAIZCONF/appcfg/cc.php");
include_once("$RAIZCONF/appcfg/js_scripts.php");
include_once("$RAIZCONF/appcfg/class_sqlman.php");
include_once("$RAIZCONF/appcfg/class_forms.php");
include_once("$RAIZCONF/appcfg/class_autoforms.php");
include_once("$RAIZCONF/appcfg/class_campanas.php");
include_once("$RAIZCONF/appcfg/class_campos.php");


$RAIZCONF = $_SERVER['DOCUMENT_ROOT']."/openc3";
$RAIZHTTPCONF = "/openc3";

//activamos los objetos
$sqlm = new Man_Mysql();


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTPCONF";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZCONF";
$formulario_auto->RutaHTTP="$RAIZHTTPCONF";
$formulario_auto->RutaRaiz="$RAIZHTTPCONF";

$campanaC = new Campana();
$camposman = new CamposManage();

$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");
//------------------ general config

require '../../appcfg/class_reports.php';

$SelConImport = $sqlm->sql_select("cron_import,importdata","*","fecha = '$fecha_act' AND hora = '".date("G")."' AND id_importdata = idplantilla",0);

if(is_array($SelConImport))			{
	
	
	
		$filedb = fopen($RAIZ."/tmp/files/".$SelConImport[0][nombre_archivo],"r");
				
/*				
				if(!$copiar){ "Error Subiendo El archivo."; }
				print_r($filedb);
				echo $archivo_name." **** ".$copiar;
*/				
	
				$camposP = explode(",",$SelConImport[0][campos]);
				
$subir = $sqlm->subir_csv_form($SelConImport[0][idform],$filedb,$camposP,0,0,0,"Importado automaticamente");

$TeblaData=$sqlm->sql_select("autoform_tablas","*","id_autoformtablas = '".$SelConImport[0][idform]."'",0);

for($o=0 ; $o < count($camposP);$o++)	{//hacemos un ford de los capos select que se esten subiendo para optimizar la consulta.

$TraeCamposSelect=$sqlm->sql_select("autoform_config","nombrecampo","eliminado != 1 AND (tipocampo = 'autocom' OR tipocampo = 'select') AND nombrecampo = '".mysql_escape_string($camposP[$o])."'");

if(is_array($TraeCamposSelect)){
	for($i=0 ; $i < count($TraeCamposSelect) ; $i++ ){

		$ntabla = "autof_".$TraeCamposSelect[$i][nombrecampo];
		$ncampoid = "id_".$TraeCamposSelect[$i][nombrecampo];
		$ncampo = $TraeCamposSelect[$i][nombrecampo];
		$UpdateCamposSelect=$sqlm->update_regs($TeblaData[0][nombretabla].",".$ntabla,"$ncampo = $ncampoid","$ncampo = field1 AND LENGTH($ncampo) > 3",0);
	
			} 
		}
									}//hacemos un ford de los capos select que se esten subiendo para optimizar la consulta.

										}
		///aqui terminamos de subir el archivo
	
	
//--------------------------------------------------------------------------		

//aqui hacemos la descarga del archivo
$reporte = new reportes();
$reporte->RutaHTTP="$RAIZHTTP";

$hora = date("G");
echo $hora." esta es la hora!!! <br><br>";

$SelConExport = $sqlm->sql_select("cron_export,repdina_config","*","fecha = '$fecha_act' AND hora = '".$hora."' AND id_rep = idreport",1);


if(is_array($SelConExport))					{


echo "Generando reporte...... <br><br>";

$reporte->Genera_csv_repdina($SelConExport[0][idreport],$SelConExport[0][fechaini],$SelConExport[0][fechafin],$SelConExport[0][campofecha],$SelConExport[0][id_cronexport]);


mail($SelConExport[0][mail_notif],"Reporte Generado!!","El reporte programado para la fecha $fecha_act y hora ".date("G")." fue generado correctamente.  \n ");

echo "Reporte generado <br><br>";


						}

?>