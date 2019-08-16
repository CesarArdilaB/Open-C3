<?

class ast_man{ //aqui arranca la clase

	var $host = "127.0.0.1";
	var $usuario = "admin";
	var $secreto =  "elastix456";

function trae_agentes(){// funcion que trae agentes

$socket = fsockopen($this->host,"5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: ".$this->usuario."\r\n");
fputs($socket, "Secret: ".$this->secreto."\r\n\r\n");

//en esta seccion nos conectamos debe estar en todas las funciones mientras nos damos cuenta como funciona

fputs($socket, "Action: Agents\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");


$count=0;
$array;

while (!feof($socket)) {
	
$wrets = fgets($socket, 8192);

$ArrayAgentes []= $wrets;

//echo "$wrets <br>";

}

//---aqui sacamos los datos de una forma absolutamente preciosa.

for($i=0; $i < count($ArrayAgentes); $i++){
	
		$agdata = explode(":",$ArrayAgentes[$i]);
		
		if($agdata[0] == "Agent" ){ 		$agente = $agdata[1];}
		if($agdata[0] == "Status" ){ 		$estado = $agdata[1];}
		if($agdata[0] == "LoggedInChan" ){ 	$extension = $agdata[1];}
		if($agdata[0] == "LoggedInTime" ){ 	$tiempo = $agdata[1];}
		if($agdata[0] == "TalkingTo" ){ 	$ablandocon = $agdata[1];
		
			//Configuramos la hora de logueo";								
			
			if($tiempo != 0){
			$logintime = date("H:i:s", $tiempo);
			}else{$logintime = 0;}
			
			//Configuramos La Extension de Logueo
			
			
			$exten=explode("/",trim($extension));
			$exten2=explode("-",$exten[1]);
			$extension=$exten2[0];
			if($extension == "a"){$extension="n/a"; }
			
		$agenteA[trim($agente)] = array(
			"numero" => trim($agente),
			"estado" => trim($estado) ,
			"extension" => trim($extension),
			"tiempolog" => trim($logintime),
			"ablandocon" => trim($ablandocon)
			);

		}
				
											}
											
	return $agenteA;

fclose($socket);
}// funcion que trae agentes

//----------------------------------------------------------------------------------------------

function trae_llamapro(){// trae propiedades de las llamadas conectadas

$socket = fsockopen($this->host,"5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: ".$this->usuario."\r\n");
fputs($socket, "Secret: ".$this->secreto."\r\n\r\n");

//en esta seccion nos conectamos debe estar en todas las funciones mientras nos damos cuenta como funciona

fputs($socket, "Action: Status\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");


$count=0;
$array;

while (!feof($socket)) {
	
$wrets = fgets($socket, 8192);

//echo $wrets."<br>";

$ArrayLlamadas[] =  $wrets;

}

for($i=0; $i < count($ArrayLlamadas); $i++){
	
		$agdata = explode(":",$ArrayLlamadas[$i]);
		
		
		if($agdata[0] == "Channel" ){ 			$canal = $agdata[1];}
		if($agdata[0] == "CallerID" ){ 			$idcanal = $agdata[1];}
		if($agdata[0] == "CallerIDNum" ){ 		$numerocanal = $agdata[1];}
		if($agdata[0] == "CallerIDName" ){ 		$nombrecanal = $agdata[1];}
		if($agdata[0] == "Account" ){ 			$cuenta = $agdata[1];} 
		if($agdata[0] == "State" ){ 			$estado = $agdata[1];}
		if($agdata[0] == "Link" ){ 				$link = $agdata[1];}
		if($agdata[0] == "Seconds" ){ 			$segundos = $agdata[1];}
		if($agdata[0] == "Uniqueid" ){ 			$uniqueid = trim($agdata[1]); 		
	
		$unicoid=explode(".",$uniqueid);
			
		$llamada[$unicoid[0]] = array(
			"canal" => trim($canal),
			"idcanal" => trim($idcanal),
			"numerocanal" => trim($numerocanal),
			"nombrecanal" => trim($nombrecanal),
			"cuenta" => trim($cuenta),
			"estado" => trim($estado),
			"link" => trim($link),
			"segundos" => trim($segundos),
			"uniqueid" => trim($uniqueid)
			);
	
		}//--------------
				
			}//----------------

	return $llamada;

fclose($socket);
}// trae propiedades de las llamadas conectadas.

function trae_llamadaext(){// funcion que las llamadas conectadas

$socket = fsockopen($this->host,"5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: ".$this->usuario."\r\n");
fputs($socket, "Secret: ".$this->secreto."\r\n\r\n");

//en esta seccion nos conectamos debe estar en todas las funciones mientras nos damos cuenta como funciona

fputs($socket, "Action: Status\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");


$count=0;
$array;

while (!feof($socket)) {
	
$wrets = fgets($socket, 8192);

//echo $wrets."<br>";

$ArrayLlamadas[] =  $wrets;

}

for($i=0; $i < count($ArrayLlamadas); $i++){
	
		$agdata = explode(":",$ArrayLlamadas[$i]);
		
		
		if($agdata[0] == "Channel" ){ 			$canal = $agdata[1];}
		if($agdata[0] == "CallerID" ){ 			$idcanal = $agdata[1];}
		if($agdata[0] == "CallerIDNum" ){ 		$numerocanal = $agdata[1];}
		if($agdata[0] == "CallerIDName" ){ 		$nombrecanal = $agdata[1];}
		if($agdata[0] == "Account" ){ 			$cuenta = $agdata[1];} 
		if($agdata[0] == "State" ){ 			$estado = $agdata[1];}
		if($agdata[0] == "Link" ){ 				$link = $agdata[1];}
		if($agdata[0] == "Uniqueid" ){ 			$uniqueidS = trim($agdata[1]);
		
		$unicoid=explode(".",$uniqueidS);
		
		$propiedades=$this->trae_llamapro();
		
		//print_r($propiedades);
		//echo"<br> $unicoid[0] <br>";
		$uniqueidO=$propiedades[trim($unicoid[0])][uniqueid];
		$segundos=$propiedades[trim($unicoid[0])][segundos];
		
			
			$exten=explode("/",trim($link));
			$exten2=explode("-",$exten[1]);
			$link=$exten2[0];
		
		$llamada[trim($link)] = array(
			"canal" => trim($canal),
			"idcanal" => trim($idcanal),
			"numerocanal" => trim($numerocanal),
			"nombrecanal" => trim($nombrecanal),
			"cuenta" => trim($cuenta),
			"estado" => trim($estado),
			"link" => trim($link),
			"segundos" => trim($segundos),
			"uniqueids" => trim($uniqueidS),
			"uniqueido" => trim($uniqueidO)
			);
	
		}//--------------
				
			}//----------------

	return $llamada;

fclose($socket);
}// funcion que las llamadas conectadas


//----------------------------------------------------------------------------------------------


function trae_colas(){// funcion que trae agentes

$socket = fsockopen($this->host,"5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: ".$this->usuario."\r\n");
fputs($socket, "Secret: ".$this->secreto."\r\n\r\n");

//en esta seccion nos conectamos debe estar en todas las funciones mientras nos damos cuenta como funciona

fputs($socket, "Action: QueueStatus\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");


$count=0;
$array;

while (!feof($socket)) {
	
$wrets = fgets($socket, 8192);

$ArrayColas[] =  $wrets;

//echo $wrets."<br>";

}

//----

for($i=0; $i < count($ArrayColas); $i++){
	
		$agdata = explode(":",$ArrayColas[$i]);
		
		
		if($agdata[0] == "Queue" ){ 			$colanum = $agdata[1];}
		if($agdata[0] == "Calls" ){ 			$llamadas = $agdata[1];}
		if($agdata[0] == "Abandoned" ){ 		$abandonos = $agdata[1];}
		if($agdata[0] == "ServiceLevel" ){ 		$niveldeservicio = $agdata[1];}
		if($agdata[0] == "Max" ){ 				$maximo = $agdata[1];} 
		if($agdata[0] == "ServicelevelPerf" ){ 	$niverservP = $agdata[1];}
		if($agdata[0] == "Weight" ){ 			$tamano = $agdata[1];	
	
		$cola[trim($colanum)] = array(
			"numero" => trim($colanum),
			"llamadas" => $llamadas ,
			"abandonos" => $abandonos,
			"maximo" => $maximo,
			"servicion" => $niveldeservicio,
			"servicioP" => $niverservP,
			"maximo" => $maximo);
	
		}//--------------
				
			}//----------------
			
return $cola;

//----
fclose($socket);
}// funcion que trae agentes

//--------------------------

function trae_comandos(){// funcion que trae agentes

$socket = fsockopen($this->host,"5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: ".$this->usuario."\r\n");
fputs($socket, "Secret: ".$this->secreto."\r\n\r\n");

//en esta seccion nos conectamos debe estar en todas las funciones mientras nos damos cuenta como funciona

fputs($socket, "Action: ListCommands\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");


$count=0;
$array;

while (!feof($socket)) {
	
$wrets = fgets($socket, 8192);

echo $wrets."<br>";

}


fclose($socket);
}// funcion que trae agentes


//----------------------------------------------------------------------------------------------


function trae_colas_agents(){// funcion que trae agentes

$socket = fsockopen($this->host,"5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: ".$this->usuario."\r\n");
fputs($socket, "Secret: ".$this->secreto."\r\n\r\n");

//en esta seccion nos conectamos debe estar en todas las funciones mientras nos damos cuenta como funciona

fputs($socket, "Action: QueueStatus\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");


$count=0;
$array;

while (!feof($socket)) {
	
$wrets = fgets($socket, 8192);

$ArrayColas[] =  $wrets;

//echo $wrets."<br>";

}

//----

for($i=0; $i < count($ArrayColas); $i++){
	
		$agdata = explode(":",$ArrayColas[$i]);
		
		if($agdata[0] == "Name"){ 			$agente = $agdata[1];}
		if($agdata[0] == "Location"){ 		$location = $agdata[1];}
		if($agdata[0] == "Queue"){ 			$cola = $agdata[1];}
		if($agdata[0] == "LastCall"){ 		$ultimallamada = $agdata[1];} 
		if($agdata[0] == "Status"){ 		$estado = $agdata[1];}
		if($agdata[0] == "Paused"){ 		$pausado = $agdata[1];	
		
		$agenum=explode("/",$agente);
	
		$colaAg[trim($agenum[1])] = array(
			"agente" => trim($agenum[1]),
			"location" => $location ,
			"cola" => $cola,
			"ultimallamada" => $ultimallamada,
			"estado" => $estado,
			"pausado" => $pausado
										);
	
		}//--------------
				
			}//----------------
			
return $colaAg;

//----
fclose($socket);
}// funcion que trae el estaus de los agentes en la cosa



}//aqui termina la clase
?>