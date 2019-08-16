<?php
require_once('../appcfg/cc.php');
/* comprobamos que el usuario nos viene como un parametro */
$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");
$solohora=date("H");


function sql_select($tabla,$campos,$clausulas=1,$monstrar=0){

                        $seleccionar = "SELECT $campos FROM $tabla WHERE $clausulas";
//echo "$seleccionar <br>";
        if($monstrar == 1){echo "$seleccionar <br>";}

                        $query=mysql_query($seleccionar)or die("Error en la consulta: ".$seleccionar.mysql_error());            
                        
                        $res = mysql_num_rows($query);

                                if ($res == 0){ return "No hay resultados"; } else
 
                                           { while($row = mysql_fetch_array($query))     {
                           
                           $ReturARR[]= $row;
                           
                            }
                        mysql_free_result($query);                      } 
                        
                        return $ReturARR;
                        
}//funcion para insertar formularios automaticamente



$auth = hash('sha256', $fecha_act."-yaxa-tse-".$solohora);
echo $auth;




if($_POST['aut'] == $auth){

$data = json_decode($_POST['datos']);

$guardamain="INSERT INTO  `autof_matrizprincipalyaxa_18` (
`af547_2891` ,
`af547_2892` ,
`af547_2893` ,
`af547_2894` ,
`af547_2895` ,
`af547_2896` ,
`af547_2897` ,
`af547_2898` ,
`af547_2899` ,
`af547_2900` ,
`af547_2901` ,
`af547_2902` ,
`af547_2903` ,
`af547_2904` ,
`af547_2905` ,
`af547_2906` ,
`af547_2907` ,
`af547_2908` ,
`af547_2909` ,
`af547_2910` ,
`af547_2911` 
)
VALUES (
        '".$data->{'Campaña'}."',
        '".$data->{'Nombres y apellidos'}."',
        '".$data->{'Identificacion'}."',  
        '".$data->{'Numero de compra'}."',  
        '".$data->{'Guia de recepcion paquete'}."',  
        '".$data->{'Direccion barrio'}."',  
        '".$data->{'Codigo DANE'}."',  
        '".$data->{'disponible para usar'}."',  
        '".$data->{'Fecha de recibido'}."', 
        '".$data->{'Proveedor de entrega'}."',  
        '".$data->{'Tipo de entrega'}."',  
        '".$data->{'Direccion 1'}."',  
        '".$data->{'Direccion 2'}."',  
        '".$data->{'Direccion 3'}."',  
        '".$data->{'Tel 1'}."',  
        '".$data->{'Tel 2'}."',  
        '".$data->{'Tel 3'}."',  
        '".$data->{'Descripcion del producto'}."',  
        '".$data->{'Peso'}."',  
        '".$data->{'Codigo postal'}."',  
        '".$data->{'Observaciones'}."' 
)";
mysql_query($guardamain) or die("Error en esta vielta 0 <br> $guardamain");

$id = sql_select('autof_matrizprincipalyaxa_18','autof_matrizprincipalyaxa_18_id','1 ORDER BY autof_matrizprincipalyaxa_18_id DESC LIMIT 1',0);

$consulta1="INSERT INTO  `ident_18` (`id_ident_18`,`estado`,`agente`,`fechahorac`) VALUES ('".$id[0]['autof_matrizprincipalyaxa_18_id']."',1,0,'$fecha_act $hora_act')";
mysql_query($consulta1) or die("Error en esta vielta 1 <br> $consulta1");

$consulta2="INSERT INTO  `history_18` (`id_reg`,`fechahora`,`accion`) VALUES ('".$id[0]['autof_matrizprincipalyaxa_18_id']."','$fecha_act $hora_act','Creado por WS Yaxa')";
mysql_query($consulta2) or die("Error en esta vielta 2 <br> $consulta2");

echo "<br><br><br> Ok";

}else{ echo "<br><br><br> Invalid Aut";}


?>