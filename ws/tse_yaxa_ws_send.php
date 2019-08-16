<?php
require_once('../appcfg/cc.php');
/* comprobamos que el usuario nos viene como un parametro */

if(isset($_GET['user']) && ($_GET['user'])=='yaxaws') {


        /* utilizar la variable que nos viene o establecerla nosotros */
        $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 es por defecto
        $format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml'; //xml es por defecto
        $user_id = intval($_GET['user']); 

        /* conectamos a la bd */
        $link = mysql_connect('localhost','root','admusr') or die('No se puede conectar a la BD');
        mysql_select_db('octres',$link) or die('No se puede seleccionar la BD');

        /* sacamos los posts de bd */
        $query = "select * from autof_matrizprincipalyaxa_18 WHERE 1";
        $result = mysql_query($query,$link) or die('Query no funcional:  '.$query);

        /* creamos el array con los datos */
        $posts = array();
        if(mysql_num_rows($result)) {
               
                while($post = mysql_fetch_assoc($result)) {

        $queryTipoEntrega = "select field1 from autof_af547_2912 WHERE id_af547_2912 = '".$post[af547_2912]."'";
        $resultTipoEntrega = mysql_query($queryTipoEntrega,$link) or die('Query no funcional:  '.$queryTipoEntrega);
        if(mysql_num_rows($resultTipoEntrega)) {while($postR = mysql_fetch_assoc($resultTipoEntrega)){
                $TipoEntrega=$postR[field1];
        }}else{$TipoEntrega = "Sin tipo entrega";}


        $queryTipoEntregaFinal = "select field1 from autof_af547_2929 WHERE id_af547_2929 = '".$post[af547_2929]."'";
        $resultTipoEntregaFinal = mysql_query($queryTipoEntregaFinal,$link) or die('Query no funcional:  '.$queryTipoEntregaFinal);
        if(mysql_num_rows($resultTipoEntregaFinal)) {while($postRR = mysql_fetch_assoc($resultTipoEntregaFinal)){
                $TipoEntregaFinal=$postRR[field1];
        }}else{$TipoEntregaFinal = "Sin tipo entrega final";}

        $EstadoInv = "select fechasalida,fechaentrega,estado from inv_inventario,inv_estado WHERE idcampana = 18 AND idestado = id_estado AND idregistro = '".$post[autof_matrizprincipalyaxa_18_id]."'";
        $resultEstadoInv = mysql_query($EstadoInv,$link) or die('Query no funcional:  '.$query);
        if(mysql_num_rows($resultEstadoInv)) {while($postRRR = mysql_fetch_assoc($resultEstadoInv)){

                $FechaSalida=$postRRR[fechasalida];
                $FechaEntrega=$postRRR[fechaentrega];
                $Estado=$postRRR[estado];

        }}else{

                $FechaSalida="Sin Fecha de salida";
                $FechaEntrega="Sin Fecha de entrega";
                $Estado="Sin Estado";

        }


                $json .= "{";
                $json .= '"id":"'.$post[autof_matrizprincipalyaxa_18_id].'",';
                $json .= '"Nombres y apellidos":"'.$post[af547_2892].'",';
                $json .= '"Identificacion":"'.$post[af547_2893].'",';
                $json .= '"Direccion/barrio":"'.$post[af547_2896].'",';
                $json .= '"Codigo DANE":"'.$post[af547_2897].'",';
                $json .= '"Codigo postal":"'.$post[af547_2910].'",';
                $json .= '"Direccion 1":"'.$post[af547_2902].'",';
                $json .= '"Direccion 2":"'.$post[af547_2903].'",';
                $json .= '"Direccion 3":"'.$post[af547_2904].'",';
                $json .= '"Tel 1":"'.$post[af547_2905].'",';
                $json .= '"Tel 2":"'.$post[af547_2906].'",';
                $json .= '"Tel 3":"'.$post[af547_2907].'",';
                $json .= '"Observaciones":"'.$post[af547_2911].'",';
                $json .= '"Campana":"'.$post[af547_2891].'",';
                $json .= '"Fecha de recibido":"'.$post[af547_2899].'",';
                $json .= '"Proveedor de entrega":"'.$post[af547_2900].'",';
                $json .= '"Tipo de entrega":"'.$post[af547_2901].'",';
                $json .= '"Guia de recepcion paquete":"'.$post[af547_2916].'",';
                $json .= '"Numero de compra":"'.$post[af547_2894].'",';
                $json .= '"Peso":"'.$post[af547_2909].'",';
                $json .= '"Descripcion del producto":"'.$post[af547_2908].'",';
                $json .= '"Tipo Entrega":"'.$TipoEntrega.'",';
                $json .= '"Tipo Entrega Final":"'.$TipoEntregaFinal.'",';
                $json .= '"Fecha Salida":"'.$FechaSalida.'",';
                $json .= '"Fecha  Entrega":"'.$FechaEntrega.'",';
                $json .= '"Estado":"'.$Estado.'"';                                                
                $json .= "}<br><br>";
                                                        }

                

                
        }

     
     echo "$json";

        /* nos desconectamos de la bd */
        @mysql_close($link);
}