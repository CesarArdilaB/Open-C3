<? 
//aqui cuadramos la conexion.

//$TraeClienteN[0][field_telefono_value]    = "4685782";
//$TraeVaradoN[0][field_tel_contacto_value] = "3044138634";

//aqui vamos a ejecutar la llamada.

for($i=0 ; $i < count($TraeClienteN) ; $i++){//este es el final del for

//echo "Llamando ".$TraeClienteN[$i][field_telefono_value]." y ".$TraeVaradoN[0][field_tel_contacto_value]." <br><br>";

//echo $TraeClienteN[$i][field_telefono_value]." *** <br>";

$host = "localhost";
$usuario = "phpagi";
$secreto =  "phpagi";

$cadenaT="LOCAL/".$TraeClienteN[$i][field_telefono_value]."@from-internal";

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
fputs($socket, "Exten: 00".$TraeVaradoN[0][field_tel_contacto_value]."\r\n");
fputs($socket, "Context: webtransfer\r\n");
//fputs($socket, "Variable: OCID=$id_reg\r\n");
fputs($socket, "Priority: 1\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");

//-----------------------------------------------------------

while (!feof($socket)) {
	
$wrets = fgets($socket, 128);

$r++;

$mensajes[]=$wrets;

//echo $wrets."$r <br>";
}

sleep(2);

fclose($socket);

$exploteResp 	= explode(":",$mensajes[8]);
$Resp 		= $exploteResp[1] ; 

$exploteloR 	= explode(":",$mensajes[21]);
$unicoIdR 	= $exploteloR[1] ; 


$UnicoIDcARR 		= explode(".",trim($unicoIdR));
$SegundaParteUID 	= $UnicoIDcARR[1] + 2;
$unicoIdC			= $UnicoIDcARR[0].".".$SegundaParteUID;

//echo "$unicoIdC ***<br>";

//asqui guardamos el registro en la tabla de las llamadas.
if(trim($Resp) == "Success"){
	
	include "../../../appcfg/cc.php";
	$Guarda = $sqlm->inser_data("webtransferrep","idcliente,idvarado,ncliente,nvarado,unicoidR,unicoidC,fechahora,medio","'$idc','$idv','".$TraeClienteN[0][field_telefono_value]."','".$TraeVaradoN[0][field_tel_contacto_value]."','".trim($unicoIdR)."','".trim($unicoIdC)."','$fecha_act $hora_act','Web'",0);						
	echo "Llamada conectada.";
	
	$i =	count($TraeClienteN);					
							
							}else{
							
	echo "No fue posible conectar la llamada";						
								
								 }
				

} //este es el final del for



?>
