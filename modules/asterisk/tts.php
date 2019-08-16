<?

/*
exten => 12345,1,Answer()^M
exten => 12345,n,Wait(2)^M
exten => 12345,n,AGI(swift.agi, ${MSG} )^M
exten => 12345,n,hangup()^M

*/


if(isset($ok)){

$host = "127.0.0.1";
$usuario = "admin";
$secreto =  "elastix456";



if($pref == "cel"){
	
	$cadenaT="SIP/Celulares-Todos/$numero";
	$tipoC="Celular";
	
	}else{
		
	$cadenaT="SIP/Telmex-New/".$pref.$numero;
	$tipoC="Fijo Nacional";			
				
		}


$socket = fsockopen($host,"5038", $errno, $errstr, $timeout);
fputs($socket, "Action: Login\r\n");
fputs($socket, "UserName: ".$usuario."\r\n");
fputs($socket, "Secret: ".$secreto."\r\n\r\n");
//----------------------------------------------------------
fputs($socket, "Action: originate\r\n");
fputs($socket, "Channel: $cadenaT\r\n");
fputs($socket, "WaitTime: 45\r\n");
fputs($socket, "CallerId: TestInter\r\n");
fputs($socket, "Exten: 12345\r\n");
fputs($socket, "Context: from-internal\r\n");
fputs($socket, "Variable: MSG=$msg\r\n");
fputs($socket, "Priority: 1\r\n\r\n");
fputs($socket, "Action: Logoff\r\n\r\n");

//-----------------------------------------------------------

while (!feof($socket)) {
	
$wrets = fgets($socket, 8192);

$r++;

//echo "$wrets $r<br>";

$mensajes[]=$wrets;

}

sleep(2);
fclose($socket);

//print_r($mensajes);

	
	$men=explode(":",$mensajes[5]);
	
		if(trim($men[1]) == "Originate failed" and trim($men[0]) == "Message"){
	
	$mensajeE="Sin Canales Para Llamar O Marcacion Errada";
		
		}else{
		
	$mensajeE="Mensage Entregado Al Numero";		
			
			}


$mensaje =  "$mensajeE $tipoC: $numero";

}

//echo $mensajes[6];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Esta es la prueba para Call Center</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="0" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#006699">
    <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC"><h3>
          <?=$mensaje?>
      &nbsp;</h3></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC"><h4>Prueba De TTS Call Center Intercobros</h4></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">Numero Telefonico </td>
      <td bgcolor="#CCCCCC"><label for="numero"></label>
        <select name="pref" id="pref">
          <option value="0810" selected="selected">Bogota</option>
          <option value="0840">Medellin</option>
          <option value="cel">Celular</option>
        </select>
      <input type="text" name="numero" id="numero"  value="<?=$numero?>"/></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">Mensaje</td>
      <td bgcolor="#CCCCCC"><label for="msg">
        <textarea name="msg" cols="30" rows="6" id="msg"><?=$msg?></textarea>
      </label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC"><input type="submit" name="ok" id="ok" value="Llamar" /></td>
    </tr>
  </table>
</form>
</body>
</html>