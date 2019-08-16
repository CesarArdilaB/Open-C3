#!/usr/bin/php
<?php
error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
$dbh=mysql_connect ("www.eldesvare.com", "integracion", "1nt3gr4d3sv4r3") or die ('No se ha realizado conexión a la database: ' . mysql_error());
mysql_select_db ("desvare"); 

$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");

include "/var/www/html/openc3/appcfg/class_sqlman.php";
$sqlm= new Man_Mysql();

// Lo primero es entrar en el Asterisk y ejecutar el comando: "agi set debug on" para ver 
// qué va haciendo el AGI.
// Hay que evitar enviar por la "salida estandar" nada, salvo los comandos para el Asterisk.

// El Asterisk nada más ejecutar el AGI, nos envía información para aburrir...
 $agivars = array();
 while (!feof(STDIN)) {
    $agivar = trim(fgets(STDIN));
    if ($agivar === '') {
      break;
    }
    $agivar = explode(':', $agivar);
    $agivars[$agivar[0]] = trim($agivar[1]);
 }


// Vamos a decirle a Asterisk que haga un Dial al número que le hemos pasado por parámetro:

//echo "EXEC Dial SIP/501";

$idCliente = substr($agivars[agi_arg_1],2,10);
//$idCliente = 48;

//$idCliente = 48;

$Ntel = $sqlm->sql_select("field_data_field_telefono","field_telefono_value","entity_id = '".$idCliente."'",0);

//for($i=0 ; $i < count($Ntel) ; $i++){//aqui empiesa el for que busca los numeros
$i = 0;

if(strlen(trim($Ntel[$i][field_telefono_value])) == 7)		{ $CadenaM="SIP/telmex/".$Ntel[$i][field_telefono_value]; }
elseif(strlen(trim($Ntel[$i][field_telefono_value])) == 10)	{ $CadenaM="SIP/Fonoplus/57".$Ntel[$i][field_telefono_value];}

//Enviamos las variables de regreso a asterisk.

echo "SET VARIABLE RECCODE \"".trim($agivars[agi_arg_2])."\" \n ";
echo "SET VARIABLE MARCAR \"".$CadenaM."\"";

//echo "EXEC Dial LOCAL/11".$Ntel[0][field_telefono_value]."@calltransfer";

include "/var/www/html/openc3/appcfg/cc.php";
$sqlm->inser_data("webtransferrep","idcliente,ncliente,unicoidR,unicoidC,fechahora,medio","'$idCliente','".$Ntel[$i][field_telefono_value]."','".trim($agivars[agi_arg_2])."','".trim($agivars[agi_arg_2])."','$fecha_act $hora_act','Call'",0);						


//										}//aqui termina el for que busca los numeros

?>