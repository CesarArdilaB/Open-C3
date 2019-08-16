<?

	 $host = "192.168.1.220";
	 $usuario = "openc3";
	 $secreto =  "oc3";

$timeout = 10;

$socket = fsockopen($host,"5038", $errno, $errstr, $timeout);


fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: ".$usuario."\r\n");
fputs($socket, "Secret: ".$secreto."\r\n\r\n");
fputs($socket, "Action: QueueStatus\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");


$count=0;
$array;

while (!feof($socket)) {
	
$wrets = fgets($socket, 1000);

$ArrayAgentes []= $wrets;

echo "$wrets <br>";

}

echo "********************************** <br>";


print_r($ArrayAgentes);
	

?>