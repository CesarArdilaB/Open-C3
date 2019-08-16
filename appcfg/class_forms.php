<?

/*esta clase sera utilizada para generar los formularios de las respectivas platillas del proyecto
creada por andres ardila el 26 de marzo de 2011 y en su vercion 1.2

Aqui los cambios que tiene en cada actualizacion:

*/

class Generar_Formulario{
	
	var $RutaRaiz;

	//funcion que genra los scripts de inicio y final
	function autoScriptsAuto($parte){
		
		if($parte=="I"){
			
	return "<script type=\"text/javascript\">
		
\$().ready(function() {

	function log(event, data, formatted) {
		\$(\"<li>\").html( !data ? \"No match!\" : \"Selected: \" + formatted).appendTo(\"#result\");
	}
	
	function formatItem(row) {
		return row[0] + \" (<strong>id: \" + row[1] + \"</strong>)\";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}";
	
	}elseif($parte=="F"){
		
		return "}); 
		</script>";
		
		}
		
		
		}
	 
	//funcion para traer los items de in select o de grupos de radiobuttons o checkboxes
	function g_RCS_items($tabla="",$campo1=1,$campo2="",$campoid="",$condiorden="1",$tipoCampo="",$valor=0,$RadioNombre="",$direccion="",$mostrarCon=0){
	
$query = "SELECT $campoid,$campo1,$campo2 FROM $tabla WHERE $condiorden";

$req = mysql_query($query);

if($mostrarCon == 1){echo "$query <br>";}

	if($tipoCampo == "C"){$itemRegresar .="<ul>";/*Lista para los radios*/}

/////////


/////////

if($tipoCampo == "SL"){ $DirSelected = $direccion; }else{ $DirSelected = ""; }

////////


if($tipoCampo == "S" or $tipoCampo == "SL"){	   
		  
		   if($valor == 0){
		$itemRegresar = "<option value='$DirSelected' id='' selected=\"selected\">Seleccione</option>";	   
			}else{
		$vareg = Generar_Formulario::traer_datos_select($tabla,$campo1,$campo2,$campoid,0,"$campoid = '$valor'");
		$itemRegresar = "<option value='".$vareg[valor]."' id='".$vareg[valor]."' selected=\"selected\">".$vareg[texto]."</option>";		
				}
		   
	/*tipos de opcion de los campos SELECT*/}

while($row = mysql_fetch_array($req))
            {	extract($row);
		   
	if($tipoCampo == "S"){	   
		   
		   $itemRegresar .= "<option value='".utf8_encode($$campoid)."' id='".utf8_encode($$campo1)."'>".utf8_encode($$campo2)."</option>";
		   
	/*tipos de opcion de los campos SELECT*/}
	
	if($tipoCampo == "SL"){	   
		   
		   $itemRegresar .= "<option value='".$direccion."' id='".utf8_encode($$campoid)."'>".utf8_encode($$campo2)."</option>";
		   
	/*tipos de opcion de los campos SELECT*/}
	
	if($tipoCampo == "C"){	   
		   
$itemRegresar .= "<li><input type=\"radio\" name=\"$RadioNombre\" id=\"$RadioNombre\" value=\"".utf8_encode($$campoid)."\" /><label>".utf8_encode($$campo2)."</label></li>";
		   
	/*tipos de opcion de los campos RADIO*/}
	
		
		    }
mysql_free_result($req);

	if($tipoCampo == "C"){$itemRegresar .="</ul>";/*Lista para los radios*/}
 
 		return $itemRegresar; 					
							
	/*termina funcion de grupos de selects radiobuttons o checkboxes*/}	


	//Genera Etiqueta de Form
	function g_form($nombre="",$enviar="",$abrir_cerrar="",$conDIV=1){
		
		if($conDIV == 1){
			
			$divA="<div id='$nombre'>";
			$divC="</div>";
			
			}
		
		
		if($abrir_cerrar == "A"){
	return "$divA <form enctype=\"application/x-www-form-urlencoded\" method='post' action='$enviar' name='$nombre' autocomplete=\"off\">";
		}else{ return "</form> $divC"; }
		
		
		}
		

	//Genra Campo que usa una consulta para mostrar un valor
	function c_Mvalor($consulta="",$valor="",$regresar=""){
		

$query = $consulta." = '$valor'";
$req = mysql_query($query);

//echo "$query";

if (!$req)
{ /*echo "<B>Error ".mysql_errno()." :</B> traer_datos_select *********".mysql_error()." <br>  $query";*/ }
$res = mysql_num_rows($req);

if ($res == 0)
   { return "0";
   }
else 
   { while($row = mysql_fetch_array($req))
            {
               extract($row);
			   
			   return $$regresar;
			   
			    }
mysql_free_result($req);
}

	
		}//******************************************************



	//Genra Campo de TEXTO
	function c_text($etiqueta="",$nombre="",$estilo="",$etiqueta_estilo="",$valor="",$requerido=0,$noedit=0,$ancho=0,$mascara=0){
		
		
		if($noedit == 0){	
		

		if($ancho != 0){$valencho = " size = '$ancho' ";}

		if($mascara == 1){
		
		$nuevocampo = "<input type='password' class=':same_as;".$nombre."' name=\"".$nombre."_nodb\" value=\"".utf8_encode($valor)."\" id=\"".$nombre."\" $valencho>";
		
		$addvalida = "";
		
		$tipo = "password";	
			
		}else{ $tipo = "text"; }

		if($requerido != ""){$valclase = " class = \"".$requerido."\" ";}
		
		if($etiqueta != ""){$etiquetaPrint="<label class='$etiqueta_estilo' for='$nombre'>$etiqueta</label>";}
		
return " $etiquetaPrint <input type='$tipo' name=\"".$nombre."\" value=\"".utf8_encode($valor)."\" id=\"".$nombre."\" $valclase $valencho> $nuevocampo $VerificaTel";
		}else
		
		{ return utf8_encode($valor);}	
	
		
		
		}
		
	//Genra Campo de CheckBox
	function c_check($etiqueta="",$nombre="",$estilo="",$etiqueta_estilo="",$valor=0,$requerido="",$noedit=0,$chekED=0){
		
	if($etiqueta != ""){$etiquetaPrint="<label class='$etiqueta_estilo' for='$nombre'>$etiqueta</label>";}
	
	if($chekED != 0){$cheKED=" checked='checked' ";}
	
	
	if($noedit == 1 and $chekED != 0){ echo "Si";	}
	elseif($noedit == 1 and $chekED == 0){ echo "No";	}
	
	else{
	
return "<input name=\"".$nombre."\" type=\"checkbox\" id=\"".$estilo."\" value=\"".$valor."\" $cheKED /> $etiquetaPrint";
	
	}
	
		}
		
	
	//Genra Campo de TEXT AREA
	function c_textarea($etiqueta="",$nombre="",$estilo="",$etiqueta_estilo="",$valor="",$alto="",$ancho="",$requerido="",$noedit=0){
		
	if($noedit == 0){	
		if($etiqueta != ""){$etiquetaPrint="<label class='$etiqueta_estilo' for='$nombre'>$etiqueta</label><br>";}
		return "$etiquetaPrint <textarea name=\"".$nombre."\" class=\"".$estilo."\" cols='$ancho' rows='$alto'>".$valor."</textarea>";
	}else{ return utf8_encode($valor);}	

		
		}
		
	//Genra Campo de SELECT NORMAL
	function c_select($etiqueta="",$nombre="",$estilo="",$etiqueta_estilo="",$requerido="",$ParamConsul="",$PasarDatoID=0,$TextoDatoID="",$valor=0,$editable=0){
		
		if($etiqueta != ""){$etiquetaPrint="<label class='$etiqueta_estilo' for='$nombre'>$etiqueta</label>";}
	
	if($editable == 0){//--------------------------------------
	
	$regresar = "<div id='$nombre' style='float:left'> $etiquetaPrint 
	<select name=\"".$nombre."\" id=\"".$nombre."_id\" class=\"".$requerido."\""; 
	
	if($PasarDatoID != 0){$regresar .= "onchange=\"div_text(this.form.elements['$nombre'],'$nombre-lsdmus');";}

//el mismo chepar de TSE
	if($nombre == "his_af13_795"){$regresar .= "verifnumero();";}
	if($nombre == "his_af13_71"){$regresar .= "textoficina(this);";}
//el mismo chepar de TSE

	
	$regresar .= "\">";
	
	$regresar .= Generar_Formulario::g_RCS_items($ParamConsul["tabla"],$ParamConsul["campo1"],$ParamConsul["campo2"],$ParamConsul["campoid"],$ParamConsul["condiorden"],"S",$valor);
	
	$regresar .= "</select>";
	
	}//--------------------------------------
	else{ 
	
	$Valuer = Generar_Formulario::traer_datos_select($ParamConsul["tabla"],$ParamConsul["campo1"],$ParamConsul["campo2"],$ParamConsul["campoid"],0,$ParamConsul["campoid"]."= '$valor'");
	
	$regresar = $Valuer[texto]/*." ".$Valuer[idsel]*/;
	
	 }
	
	if($PasarDatoID != 0 and $editable == 0){$regresar .= " <div id='$nombre-lsdmus'>$TextoDatoID</div>";}
	
	//parche para TSE desarrollo especial solicitado por davivienda
	if($nombre == "his_af13_795"){ 
	
	$regresar .= "
	
	<script>
	
	function verifnumero()	{
		
	var primero = document.getElementById('$nombre-lsdmus');
	var dircita = document.getElementById('his_af13_145');
	var barrio = document.getElementById('af13_149');
	var ciudad = document.getElementById('af13_67_id');
	var oficinas = document.getElementById('his_af13_71_id');
		
	if(primero.innerHTML == '4'){ 
	
	dircita.readOnly = true;
	barrio.disabled = true;
	oficinas.disabled = false;
	
	}else{
	
	dircita.readOnly = false;
	barrio.disabled = false;
	oficinas.disabled = true;	
		
	}
							
							}
							
	function textoficina(texto){
		
	var dircita = document.getElementById('his_af13_145');
	
    var w = texto.selectedIndex;
    var selected_text = texto.options[w].text;
    dircita.value = selected_text;
		
	
	}
		
	</script>
	
	";
	
	
	
	}
	//parche para TSE desarrollo especial solicitado por davivienda
	
		return $regresar;
	
			}
		
	//Campo de fecha con Calendario
function c_fecha_input($etiqueta="",$nombre="",$estilo="",$etiqueta_estilo="",$valor="",$requerido="",$noedit=0,$Diasminimo=""){

if($valor == "0000-00-00"){$valor = "";}

if($Diasminimo != ""){ $AddScript = ",minDate: $Diasminimo"; }

if($noedit == 0){	

if($requerido != ""){$valclase = " class = \"".$requerido."\" ";}
	
 return "<label class='$etiqueta_estilo'> $etiqueta
 <input name=\"".$nombre."\" type=\"text\" $valclase id=\"".$nombre."\" value='".$valor."' size=\"10\" readonly=\"readonly\" />

 	<script>
	$(function() {
		$( \"#".$nombre."\" ).datepicker({
			showOn: \"button\",
			buttonImage: \"/openc3/imgs/calendar.gif\",
			buttonImageOnly: true,
			changeMonth: true,
      		changeYear: true,
			dateFormat: \"yy-mm-dd\"".$AddScript."
		});
	});
	</script> 

     </label>";}else{ return utf8_encode($valor);}	
		
		}

//--------------------------------------------------------

	//Genra Campo de SELECT CON AUTOCOMPLETAR
	function c_Auto_select($etiqueta="",$nombre="",$estilo="",$etiqueta_estilo="",$requerido="",$ParamConsul="",$PasarDatoID=0,$TextoDatoID="",$valorpasar="",$noedit=0,$ancho="",$multiple=0){
		
		if($etiqueta != ""){$etiquetaPrint="<label class='$etiqueta_estilo' for='$nombre'>$etiqueta</label>";}
		
		if($multiple == 1){
		$multipleP="true";
		$pasarD="hidden.value = hidden.value + \";\" + data[2];";
			}else{
		$multipleP="false";
		$pasarD="hidden.value = data[2];";}
		
if( $valorpasar != "" ){ $valor = Generar_Formulario::traer_datos_select($ParamConsul["tabla"],$ParamConsul["campo1"],$ParamConsul["campo2"],$ParamConsul["campoid"],0,$ParamConsul["campoid"]." = '$valorpasar'"); }

	if($noedit == 0){	//si es editable muestra el formulario

if($requerido != ""){$valclase = " class = \"".$requerido."\" ";}

	$regresar = Generar_Formulario::autoScriptsAuto("I");
	
	$regresar .= "
	\$(\"#".$nombre."_text\").autocomplete('/openc3/libs/genetaautos.php?campoid=".$ParamConsul["campoid"]."&campo1=".$ParamConsul["campo1"]."&campo2=".$ParamConsul["campo2"]."&tabla=".$ParamConsul["tabla"]."&condiorden=".$ParamConsul["condiorden"]."', {
		width: 300,
		multiple: $multipleP,
		matchContains: true,
		formatItem: formatItem,
		formatResult: formatResult
	});

	\$(\"#".$nombre."_text\").result(function(event, data, formatted) {
		
		var hidden =  document.getElementById(\"".$nombre."_hidden\");
		$pasarD
		
		var hiddenN =  document.getElementById(\"$nombre-auto\");
		hiddenN.innerHTML = data[1];
		
	});	";
	
	$regresar .= Generar_Formulario::autoScriptsAuto("F");
	
	$regresar .= "<span id='$nombre-div'> $etiquetaPrint"; 

if($TextoDatoID != ""){	$regresar .= "<input name=\"".$nombre."_hidden\" type=\"hidden\" value='".$valor[valor]."' id=\"".$nombre."_hidden\">";}


if($multiple == 1){

$regresar .= "<textarea $valclase name=\"".$nombre."\" id=\"".$nombre."\" cols='$ancho' rows='3'>$valor[texto]</textarea>";
$regresar .= "<br><input type=\"button\" value=\"Borrar Campo\" onclick=\"BorrarCampos('$nombre');BorrarCampos('$nombre"."_hidden');\">";

	}
	else{
	$regresar .= "<input type='text' $valclase name=\"".$nombre."_text\" id=\"".$nombre."_text\" value='".$valor[texto]."' size='$ancho'>";
	}
	
	
if($TextoDatoID != ""){	$regresar .= "$TextoDatoID";}else{ $regresar .="</div>"; }
	
		return $regresar;
	
	}else{ return $valor[texto];}	//si no es editable muestra el valor

	
			}
		
		
		//este es un select que llama la funcion envialink para hacer una carga en la misma pagina de otro contenido.
	function select_envia_link($etiqueta="",$nombre="",$estilo="",$etiqueta_estilo="",$requerido="",$ParamConsul="",$PasarDatoID=0,$TextoDatoID="",$destinoDiv="",$mOStratCON=""){
		
		if($etiqueta != ""){$etiquetaPrint="<label class='$etiqueta_estilo' for='$nombre'>$etiqueta</label>";}
	
	$regresar = "<div id='$nombre'> $etiquetaPrint 
	<select name=\"".$nombre."\" class=\"$estilo\" "; 
	
$regresar .="onchange=\"EnviarLinkJ('$destinoDiv',this.options[this.selectedIndex].value,this.options[this.selectedIndex].id);\"";
	
	$regresar .= ">";
	
$regresar .= Generar_Formulario::g_RCS_items($ParamConsul["tabla"],$ParamConsul["campo2"],$ParamConsul["campo2"],$ParamConsul["campoid"],$ParamConsul["condiorden"],"SL","","",$ParamConsul["direccion"],$mOStratCON);
	
	$regresar .= "</select>";
	
		return $regresar;
			
			}

		//------------------------------------------------------------------------
		
	//funcion para generar campos de subir archivos e imagenes.
	
	function c_file_uoload($etiqueta="",$nombre="",$estilo="",$etiqueta_estilo="",$valor="",$requerido="",$noedit=0,$rutafile=""){
		
		
if($noedit == 0){	
		
		if($requerido != ""){$valclase = " class = \"".$requerido."\" ";}

		if($ancho != 0){$valencho = " size = '$ancho' ";}
		
		if($etiqueta != ""){$etiquetaPrint="<label class='$etiqueta_estilo' for='$nombre'>$etiqueta</label>";}

	return "

<label id='$nombre' class='$etiqueta_estilo'>".Generar_Formulario::Verif_Files($valor,"Ver Archivo",$rutafile)." </label>
<label id='$nombre'> $etiquetaPrint <input name=\"".$nombre."_file\" type=\"file\" id=\"".$nombre."_file\" size=\"1\" $valclase /></label>

		";
	
	}else{ 
	
	return "<label id='$nombre' class='$etiqueta_estilo'>".Generar_Formulario::Verif_Files($valor,"Ver Archivo",$rutafile)." </label>";}	
		
		}
	
	//funcion para generar campos de subir archivos e imagenes.
	
	//--- funcion ligada al campo de archivos para encontrar el archivo en el servidor.
	function Verif_Files($imagen="",$textoLink="",$ruta=""){
	
?>

<script>
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$(".<?=$textoLink?>").colorbox({width:"900", height:"700"});
			//Example of preserving a JavaScript event for inline calls.
			$("#click").click(function(){ 
				$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});
		});
	</script>	
	
<?	$ejecutado = shell_exec("locate $imagen");
		
	$RutaFile=explode("/",$ejecutado);
	
	$ultpos=count($RutaFile)-1;
	
//	echo $ejecutado."** $ultpos **";
				
	if($ultpos == 0){return "<font color='red' face='Verdana' size='1'><b>No Existe Archivo</b></font>";}else{	
            
    return "<a class='$textoLink' href='/openc3/$ruta/$RutaFile[$ultpos]'>$textoLink</a>"; }
	
	}
	//--- funcion de archivos termina
	
	function traer_datos_select($tabla="",$campo1="",$campo2="",$campoid="",$conlosdos="0",$condicion="1",$ordenar=""){
	
	$query = "SELECT $campoid,$campo1,$campo2 FROM $tabla WHERE $condicion $ordenar";
$req = mysql_query($query);

//echo "$query";

if (!$req)
{ //echo "<B>Error ".mysql_errno()." :</B> traer_datos_select *********".mysql_error()." <br>  $query";
 }
$res = mysql_num_rows($req);

if ($res == 0)
   { return array("valor" => "Vacio","idsel" => "Vacio","texto" => "Vacio");
   }
else 
   { while($row = mysql_fetch_array($req))
            {
               extract($row);
			   
			   return array("valor" => $$campoid,"idsel" => $$campo1,"texto" => utf8_encode($$campo2));
			   
			    }
mysql_free_result($req);
} 
	
	}
	
}

?>
