<?
# =================== ARCHIVO DE CONFIGURACION  ============
$filename = "/var/log/asterisk/queue_log";
$newfile = "/var/log/asterisk/queue_log_coping";

# Segundos para medir el nivel de servicio

# Cadena de caracteres con ip del pbx
$ip_pbx="localhost";
# ==================== CONEXION AL SERVIDOR ================
require_once "/var/www/html/ccm/appcfg/cc.php";
mysql_select_db ("asteriskcdrdb");
# =========================================================

# SE VERIFICA QUE EXISTA EL ARCHIVO
file_exists($filename) or die("El archivo $filename no fue encontrado");

# SE GUARDA LA FECHA DE INICIO DEL PROCESO 
$fecha=date("Y-m-d--H:i:s");


#echo "Inicio del proceso $fecha\n";
$newfile = "$filename-$fecha";


#Se copia el archivo a un nuevo destino
copy($filename, $newfile) or die ("No se pudo copiar $filename a $newfile");


$fp = fopen($filename,"w") or die ("No se pudo crear el archivo $filename");
fclose($fp);

# APERTURA DEL ARCHIVO 
#echo "$filename\n";
$fp = fopen($newfile,"r") or die ("No se pudo abrir el archivo");



while ($linea= fgets($fp))
{
        #echo "$linea<br>";
        $arreglo=explode('|',$linea);
        $arreglo[0]=trim($arreglo[0]);
        $arreglo[1]=trim($arreglo[1]);
        $arreglo[2]=trim($arreglo[2]);
        $arreglo[3]=trim($arreglo[3]);
        $arreglo[4]=trim($arreglo[4]);
        $arreglo[5]=trim($arreglo[5]);
        $arreglo[6]=trim($arreglo[6]);
        $arreglo[7]=trim($arreglo[7]);

      
    	$fecha=date('Y-m-d H:i:s',$arreglo[0]);

  $consulta =  "INSERT INTO queue_log (`fecha`,`cdr_uniqueid`,`dcontext`,`agente`,`evento`,`parametro_1`,`parametro_2`,`parametro_3`,`ip_pbx`)
				  	values('$fecha','$arreglo[1]','$arreglo[2]','$arreglo[3]','$arreglo[4]','$arreglo[5]','$arreglo[6]','$arreglo[7]','$ip_pbx' )";
		
		//echo "$consulta \r\n ";
		
       $consultaSQL = mysql_query($consulta);
        
}

# CIERRA ARCHIVO
fclose($fp);
exec ("rm -f /var/log/asterisk/queue_log");
exec ("asterisk -rx \"module reload\" ");

$fecha=date("Y-m-d H:i:s");
echo "Fin del proceso $fecha\n";
?>