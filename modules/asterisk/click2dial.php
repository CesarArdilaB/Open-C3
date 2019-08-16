llamando....

<?
include '../../appcfg/general_config.php';
include '../../appcfg/cc_asterisk.php';

//----------------------------------------------------

	$cadenaT="Local/".$telefono."@from-internal";

//*******************
$timeout = 10;

$socket = fsockopen($host,"5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: ".$usuario."\r\n");
fputs($socket, "Secret: ".$secreto."\r\n\r\n");
//----------------------------------------------------------
fputs($socket, "Action: originate\r\n");
fputs($socket, "Channel: $cadenaT\r\n");
fputs($socket, "WaitTime: 45\r\n");
fputs($socket, "CallerId: TestInter\r\n");
fputs($socket, "Exten: ".$_GET[extension]."\r\n");
fputs($socket, "Context: from-internal\r\n");
fputs($socket, "Variable: OCID=$id_reg\r\n");
fputs($socket, "Priority: 1\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");



//-----------------------------------------------------------

while (!feof($socket)) {
	
$wrets = fgets($socket, 128);

$r++;

//echo "$wrets $r<br>";

$mensajes[]=$wrets;

}

sleep(2);

fclose($socket);

//print_r($mensajes);

	for($i=0 ; $i < count($mensajes) ; $i++){//for que saca si fue o no fue
		
	$MensajesAst = explode(":",$mensajes[$i]);	
		
		//echo $mensajes[$i]."<br>";
		
		if(trim($mensajes[$i]) ==  trim("Message: Originate successfully queued")){ 
		
	//	echo "Le Pegamos al perro!!!!!!!";
		
		$quedo = $i;
		$NoFallo = 0;
		$unicoid = explode(":",$mensajes[$quedo+24]);
		$mensajeE="Conectada";
		
		break; 
		}
		
		if(trim($mensajes[$i]) ==  trim("Message: Originate failed")){
		
		$quedo = $i;
		$NoFallo = 0;
		$unicoid = explode(":",$mensajes[$quedo+24]);
		$mensajeE="Fallida";	
		break;		
		}
		
		}//for que saca si fue o no fue


//$unicoid = explode(":",$mensajes[$quedo+24]);
	

include '../../appcfg/cc_call.php';

mysql_select_db("asteriskcdrdb");

$GuardarCall = $sqlm->inser_data("openc3_calls","unicoid,tipo,numero,id_registro,id_campana,nombrecampo,resultado","'".trim($unicoid[1])."','out','$telefono',$idreg,$idcam,'$ncampo','$mensajeE'",0)

?>
<?=$mensajeE?>