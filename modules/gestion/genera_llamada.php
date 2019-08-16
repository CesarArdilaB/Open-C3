<?
	echo "
	
	<br><br>
	<center> 
	
	Conctando al numero <br> $_GET[telcliente] <br> Con la extension <br> $_GET[ext] 
	
	<br>
	<br> 
	
	<button onClick='window.close()'>Cerrar</button>
	
	</center>
	
	
	";
	
	//Aqui arriba el texto chimbilaco

/*

$host = "192.168.0.15";
$usuario = "phpagi";
$secreto =  "phpagi";

$cadenaT="LOCAL/".$_GET[telcliente]."@from-internal";

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
fputs($socket, "Exten: ".$_GET[ext]."\r\n");
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
	
	echo "Llamada conectada.";
					
	}else{
							
	echo "No fue posible conectar la llamada";						
								
		 }
*/		 
	
?>