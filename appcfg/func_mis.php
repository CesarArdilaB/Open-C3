<?
@session_start();

date_default_timezone_set('America/Bogota');

//$ipruta = $_SERVER['SERVER_ADDR']; 
$ipruta="172.19.47.181";
// ruta de la carpeta raiz d la aplicacion

$RAIZ=$_SERVER['DOCUMENT_ROOT']."/openc3";
$RAIZHTTP = "/openc3";

//Verificamos la seguridad.
$NobreArr = explode("/",$_SERVER[SCRIPT_NAME]);
$nombreP = $NobreArr[count($NobreArr)-1];

if($_SESSION[user_ID] == "" and $nombreP != "index.php"){

/*echo ("<script language='JavaScript'>document.location.href='/openc3/index.php';</script>");*/
header ("Location: /openc3/index.php");	
	
    	}
//Verificamos la seguridad.

?>

<script language="javascript">

function disp_text(combo,destino)
   {
   var w = combo.selectedIndex;
   var selected_text = combo.options[w].id;
   destino.value = selected_text;
   }

//-----------------------------------------------------

function div_text(combo,destino)
   {
   var w = combo.selectedIndex;
   var selected_text = combo.options[w].id;
   document.getElementById(destino).innerHTML = selected_text;
   }
   
//---------------------------------------------


function EnviarLinkJ(destino,urlpagina,varstr,sinefecto){

	var divdestino =  document.getElementById(destino);

	if(sinefecto != 1){//------------------
	
	$(divdestino).hide();
	$("#cargando").css("display", "inline");
	
	}//---------------comprueba si poner efecto o no.
	
    $(divdestino).load(urlpagina,{varid: varstr},function(){$("#cargando").css("display", "none");});
	
	if(sinefecto != 1){//------------------
	
	$(divdestino).show('drop');
	
	}//---------------comprueba si poner efecto o no.

}//cierra la funcion grande que espera los datos para el ajax.

function MarcarLinkJ(destino,urlpagina,varstr,sinefecto){

	var oForm = document.forms[0];
	var divdestino  =  document.getElementById(destino);
	var valtelefono =  oForm.elements[varstr].value;

	if(sinefecto != 1){//------------------
	
	$(divdestino).hide();
	$("#cargando").css("display", "inline");
	
	}//---------------comprueba si poner efecto o no.
	
    $(divdestino).load(urlpagina,{telefono: valtelefono},function(){$("#cargando").css("display", "none");});
	
	if(sinefecto != 1){//------------------
	
	$(divdestino).show('drop');
	
	}//---------------comprueba si poner efecto o no.

}//cierra la funcion grande que espera los datos para el ajax.

function desactivaralerto(){
	
	$(window).unbind('beforeunload');
		
}

function EnviarLinkForm(destino,urlpagina,formulario){

	var divdestino =  document.getElementById(destino);
	//$("#cargando").css("display", "inline");
	
	$(divdestino).hide();
	
	$("#cargando").css("display", "inline");
    $(divdestino).load(urlpagina, $(formulario).serialize(),function(){$("#cargando").css("display", "none");});

	$(divdestino).show('drop');

}//cierra la funcion grande que espera los datos para el ajax.

function EnviaFormPost(destino,urlpagina,formulario){

   	var data = new FormData();
   

	var divdestino = document.getElementById(destino);
	var data = $(formulario).serialize();

	$.post(urlpagina,data,function(respuesta){$(divdestino).html(respuesta)});

	return false;

}//cierra la funcion grande que espera los datos para el ajax.

function BorrarCampos(campo){
	
	var campoborrar = document.getElementById(campo);
	
	campoborrar.value = "";
	
	}
	
function MostrarOcultar(divmo,accion){

var divdaccion =  document.getElementById(divmo);
	
	if(accion === 1){
		
		$(divdaccion).show('fold');
	
	} if(accion === 0){
		
		$(divdaccion).hide('fold');
	
		
		 }
	
	}
	
//-----------------------------------------------------------------

	$(function() {
		$( "#selectable" ).selectable();
	});

//-----------------------------------------------------------------

     function imprimir(id)

        {

      var div, imp;

            div = document.getElementById(id);//seleccionamos el objeto

            imp = window.open(" ","Formato de Impresion"); //damos un titulo

            imp.document.open();     //abrimos

           // imp.document.write('style: ...'); //tambien podriamos agregarle un <link ...

            imp.document.write(div.innerHTML);//agregamos el objeto

            imp.document.close();

            imp.print();   //Abrimos la opcion de imprimir

            imp.close(); //cerramos la ventana nueva
        }

</script>

<style>

 .cargandoANDO{
	            position: absolute;
                left: 50%;
                top: 50%;
                width: 200px;
                height: 200px;
                margin-top: 100px;
                margin-left: 0px;
                overflow: auto;
                font-family:Arial, Helvetica, sans-serif;
				font-size:12px;
				display:none;
				z-index:1000;
	 		}

</style>
	
<div id="cargando" class="cargandoANDO" align="center"><img src="<?=$RAIZHTTP?>/libs/cargando.gif"/></div>

<?php
	function genera_modalF($linkclase="",$ancho="",$alto="",$urlform="",$div=""){
		
			?>
<script>
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$(".<?=$linkclase?>").colorbox({
			width:"<?=$ancho?>", height:"<?=$alto?>",top:"2%",iframe:true<? if($urlform != "" ){  ?>,
			onClosed:function(){ EnviarLinkJ('<?=$div?>','<?=$urlform?>');}
			<? } ?>});
			//Example of preserving a JavaScript event for inline calls.
			$("#click").click(function(){ 
				$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});
		});
</script>
    
		<?
		
		}
///////////////

function redirect ( $pageName ) 
{
	echo ("<script language='JavaScript'>document.location.href='" . $pageName . "';</script>");
}


///////////////////////////

//funcion para incertar registros
function inser($tabla,$campos,$var){
$query = "INSERT INTO $tabla ($campos) VALUES ($var)";
$req = mysql_query($query);

if (!$req)
{ echo "***".mysql_error()."****" ;
}

}
//////////////Termina la de incertar registros*************
function borrar($tabla,$com1,$com2){
/////////////////AKI finaliza la funcion para borrar registros

$query = "DELETE FROM $tabla WHERE $com1 = '$com2' ";
$req = mysql_query($query);

if (!$req)
{ echo "<B>Error ".mysql_errno()." :</B> ".mysql_error()."";
exit; }

$aff_rows = mysql_affected_rows();

} ///////////////AKI finaliza la funcion para borrar registros
//////////*****************************************************

function excelexp($idtabla){
	
?>
<script language="javascript">  
$(document).ready(function() {  
     $(".botonExcel").click(function(event) {  
     $("#datos_a_enviar").val( $("<div>").append( $("#<?=$idtabla?>").eq(0).clone()).html());  
     $("#FormularioExportacion").submit();  
});  
});  
</script>  

<form action="/openc3/libs/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">  
<p>Exportar a Excel  <img src="/openc3/imgs/export_to_excel.gif" class="botonExcel" /></p>  
<div style="display:none"><textarea id="datos_a_enviar" name="datos_a_enviar" cols="" rows=""></textarea></div>
</form>  

<?	
	
	}


////////////////////-------------------------------Reparador de funciones----------

function GeneraFechas($fecha_inicial,$fecha_final)	{
	
	
$datetime1 = new DateTime(date($fecha_inicial));
$datetime2 = new DateTime(date($fecha_final));
$daysDifference = round(abs($datetime1->format('U') - $datetime2->format('U')) / (60*60*24));  

$segundosDia = 86400;

$factual = $datetime1->format('U');

$Arrfechas[] 	= $fecha_inicial;
$Arrdias[] 		= date("n-j",$datetime1->format('U'));

	for($i=0 ; $i < $daysDifference ; $i++){
		
$fechaagregada 	= $factual + $segundosDia;
$Arrfechas[]	= date("Y-n-j",$fechaagregada);
$Arrdias[]		= date("n-j",$fechaagregada);
$factual = $fechaagregada;
											}

	
	return 	array("fecha" => $Arrfechas,"dia" => $Arrdias);								}


//-----------------------------------------------------------------

function traer_grabacion($archivo,$textoLink){
	
	$ejecutado = shell_exec("locate $archivo");
		
	$RutaFile=explode("/",$ejecutado);
	
	$ultpos=count($RutaFile)-1;
	
//	echo $ejecutado."** $ultpos **";
				
	if($ultpos == 0){return "<font color='red' face='Verdana' size='1'><b>No Existe Grabacion</b></font>";}else{	
            
    return "<a class='$textoLink' href='/grabaciones/$RutaFile[$ultpos]' target=\"reproductor\"><b>$textoLink</b></a>"; }
	
	}

function act($tabla,$cadena,$comu1,$comu2){///////Esta es la funcion para actualizar registros////
$query = "UPDATE $tabla SET $cadena WHERE $comu1 = '$comu2'";
$req = mysql_query($query);

//echo "$query <br>";

if (!$req)
{ echo "<B>Error ".mysql_errno()." :</B> ".mysql_error()."";
exit; }

$aff_rows = mysql_affected_rows();

}///////////////////////////////////////////////////////////

function Leer_IP( ) {
if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )

return $_SERVER['HTTP_X_FORWARDED_FOR'];

if( isset($_SERVER['HTTP_CLIENT_IP']) )

return $_SERVER['HTTP_CLIENT_IP'];

return $_SERVER['REMOTE_ADDR'];
}


$ip=Leer_IP();

function alerta($texto){//////////////////////////////////
echo"<Script>
         alert('".$texto."');window.history.back();
     </script>";
}/////////////////////////////////////////////////
function alerta2($texto,$pagina){//////////////////////////////////
echo"<Script>
         alert('".$texto."');document.location.href='".$pagina."';
     </script>";
exit;
}/////////////////////////////////////////////////

$var="";
function paginar($tabla,$numero,$pagina,$com,$var){///////////////////////////////////////////////////

$query = "SELECT id FROM $tabla $com";
$req = mysql_query($query);
$res = mysql_num_rows($req);
$npag=$res/$numero;
$npag=ceil($npag);
for($i=0;$i<$npag;$i++){////////Genera el numero de paginas para la paginacion
$inc++;
$st=$st+$numero;
$en=$numero;
if($inc==1){////////Comprueba las variables limites
$st=0;
$en=$numero;
}/////////////////

echo "<a href='$pagina?str=$st&end=$en&tabla=$tabla&$var'>".$inc."</a> | ";

}/////////////
}////////////////////////////////////////////////////////////////////////////////////////////


//echo "<script type='text/JavaScript'>
//<!--
//function VENTANA(theURL,winName,features) { //v2.0
//  window.open(theURL,winName,features);
//}
////-->
///

//asigna las fechas y hora para cada registro
$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");
//-----------------------------------------------
$year=date("Y");
$month=date("m");
$tb_history="his-historial";
//termina de cuadrar fecha y hora

//------------------------------------------------------------------
if(isset($fecha_ini)){
$fecha_mes1=explode("-",$fecha_ini);
$fecha_mes_unix1=@mktime(0,0,0,$fecha_mes1[1],$fecha_mes1[2],$fecha_mes1[0]);

$year=date("Y",$fecha_mes_unix1);
$month=date("m",$fecha_mes_unix1);

$tb_history = "his-historial";
}//------------------------------------------------------------------

//------------------------------------------------------------------
if(isset($_GET[fecha])){
$fecha_mes1=explode("-",$_GET[fecha]);
$fecha_mes_unix1=mktime(0,0,0,$fecha_mes1[1],$fecha_mes1[2],$fecha_mes1[0]);

$year=date("Y",$fecha_mes_unix1);
$month=date("m",$fecha_mes_unix1);
$tb_history="his-historial";
}//------------------------------------------------------------------

?>