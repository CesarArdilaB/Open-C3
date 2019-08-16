<?
/*esta clase sera utilizada para generar formularios en tablas 1.0

Aqui los cambios que tiene en cada actualizacion:

*/

class Auto_Forms extends Generar_Formulario{
	
	var $RutaRaizINC;
	var $RutaHTTP;
	var $RutaRaiz;

/*

		estos son los tipos de campo para generar el formulario
							text = Campo de Texto
							autocom = Autocompletar
							check = Check Box
							textarea = Text Area
							select = select box
							fecha = campo de fecha
							rvalor = ejecuta una consulta y regresa el valor
*/

    function generar_form_ins($idtablains="",$numfilas=1,$vernover=0,$divRefrescar="",$mostrarOP=0,$editando="",$editReg="",$CampMode="",$CamParam="",$usuarioPER=0){ //esta funcion genera un formulario para guardar registros segun los parametros entregados
	
	$nombretabla=$this->datostabla_ins($idtablains,"nombretabla"); 
	
	if( $editando == 1 ){
		$this->genera_modal("grupo_title-$idtablains-$id_autoformgrupos",500,420,$idtablains);
		$ordenadorgrupos="
		<div>
		Ordenar Los Grupos <a href='$this->RutaHTTP/modules/campaigns/form_group_order.php?idForm=".$idtablains."' class='grupo_title-$idtablains-$id_autoformgrupos'><img src='".$this->RutaRaiz."/imgs/ordenar.png'></a>
		</div>
		
<!--		<div>
		Ordenar Los Grupos <a href='$this->RutaHTTP/modules/campaigns/form_group_order.php?idForm=".$idtablains."' class='grupo_title-$idtablains-$id_autoformgrupos'><img src='".$this->RutaRaiz."/imgs/ordenar.png'></a>
		</div>
-->		
		";
						}
//esta seccion es la que diferencia la parte dinamica cuando esta trabajando formularios de campana	

	if($CampMode == 1){
	
		if($editReg == 1){	
		
	//modificacion estados de agendas 22/11/2017 por el chacho de chochas

	$FeedBackAG="SELECT feedback FROM agenda WHERE idcampana = ".$CamParam[idCam]." AND idregistro = ".$CamParam[idReg]." ORDER BY id_agenda DESC LIMIT 1"; 
	//echo "$FeedBackAG <br>";
	$FeddBackAGQ = mysql_query($FeedBackAG);
	$ResQFB = mysql_num_rows($FeddBackAGQ);
	if ($ResQFB == 0){ $bloqueo = 0; } else { 

	while($rowFB = mysql_fetch_array($FeddBackAGQ))
    {
		
    extract($rowFB);
	
	//echo " $feedback <br>";
	
	if($feedback == 3){$bloqueo = 1;}else{$bloqueo = 0;}
	
	}
mysql_free_result($FeddBackAGQ);
	
	
	
	
	} 
	
	
		//aqui traemos si el registro esta en 4 que quiere decir intocable paradojicamente.

	$TraeIdentEstado="SELECT estado as ESTADO FROM ident_".$CamParam[idCam]." WHERE id_ident_".$CamParam[idCam]." = ".$CamParam[idReg]; 
	$reqEstado = mysql_query($TraeIdentEstado);
	while($rowEstado = mysql_fetch_array($reqEstado))
    {
		
    extract($rowEstado);
	
	}
	
	//echo "Prueba de Andres Ardila: el estado es: $ESTADO";
		
		
		$paginaRequest = "formsrecuest.php?tablaINS=$nombretabla&botonNOM=ok&mostrarOP=$mostrarOP&idRgistro=".$CamParam[idReg]."&idCampana=".$CamParam[idCam]."&idUsuario=".$CamParam[idUser]."&UpdateFORMcampana=1"; 
		$reset = "";
		$alertat = "Registro Actualizado";
		//print_r($CamParam);
		
	// selecciona el registro ***************		
	$clausulaRegE="SELECT * FROM ".$nombretabla." WHERE ".$nombretabla."_id = ".$CamParam[idReg]; 
	$req = mysql_query($clausulaRegE);
	while($row = mysql_fetch_array($req))
    {
		
    extract($row);
	
	}
	// selecciona el registro ***************
		
		}else{
			
		$paginaRequest = "formsrecuest.php?tablaINS=$nombretabla&botonNOM=ok&mostrarOP=$mostrarOP&idRgistro=".$CamParam[idReg]."&idCampana=".$CamParam[idCam]."&idUsuario=".$CamParam[idUser]."&guardarFORMcampana=1"; 
		$reset = "";
		$alertat = "Registro Guardado";
		//print_r($CamParam);
						
	}
		
	} else { $paginaRequest = "formsrecuest.php?tablaINS=$nombretabla&botonNOM=ok&mostrarOP=$mostrarOP&guardarFORMest=1"; 
			 $reset = ";this.reset()";
			 $alertat = "Registro Guardado"; }
	
	

//esta seccion es la que diferencia la parte dinamica cuando esta trabajando formularios de campana	
	if($divRefrescar != ""){ $divRefrescar = "EnviarLinkJ(".$divRefrescar.");";}

	$html .= "$ordenadorgrupos
	
	<div id='form-$idtablains'>	

		
	<form id='RegistroForm' name='$nombre' autocomplete=\"off\" onsubmit=\"EnviarLinkForm('divgform-$idtablains','$this->RutaHTTP/libs/$paginaRequest',this)$reset;desactivaralerto();alert('$alertat') ; $divRefrescar return false;\">
";	
	$ARRcampos=array();
	
	$spannumfilas=$numfilas*2;
	
	$clausulag="SELECT id_autoformgrupos,labelgrupo,visiblegrupo,id_autoformgrupos,columnas,usrpermisos,usredit,usrver,nota FROM autoform_grupos WHERE idtabla_rel = '$idtablains' ORDER BY posiciongrupo"; 
	
	//echo $clausulag;
	
	$req = mysql_query($clausulag);
	while($row = mysql_fetch_array($req))
            {
    extract($row);
	
	//echo "QUE LE PASA HIJO DE PUTA";
	
	$VerNoverARR 	= 	explode("|",$usrver);
	$PermisosARR 	= 	explode("|",$usrpermisos);
	$NoEditARR 		= 	explode("|",$usredit);
	


	//aqui determinamos si vamos o no a mostrar el drupo
	
	for($u=0 ; $u < count($VerNoverARR) ; $u++){//comienza el for 
		if($VerNoverARR[$u] == $usuarioPER){ $NoMostrar = 1; $u=count($VerNoverARR); }else { $NoMostrar = 0; } 
		//echo $VerNoverARR[$u]."$usuarioPER"."*****".$NoMostrar."<br>";
	}//termina el for
	
	if($NoMostrar != 1 or $editando == 1 or $CampMode != 1){ //aqui mostramos o no todo el grupo
	
	//aqui determinamos si vamos o no a mostrar el drupo
	
	//---- aqui esta la parte de permisos del grupo para edicion o vision de secciones del formulario
	if( $vernover == 0 and $usuarioPER != 0 )			{
		
		for($u=0 ; $u < count($PermisosARR) ; $u++){//comienza el for 
		
		if($PermisosARR[$u] == $usuarioPER){ 
		
		
		$noedite = 1; 
		$u=count($PermisosARR);
		

		}else { $noedite = 0;} 
				
		}//termina el for
		
	if($editReg == 1 and $noedite == 0){	
	
		for($u=0 ; $u < count($NoEditARR) ; $u++){//comienza el for 
		if($NoEditARR[$u] == $usuarioPER){

			$noedite = 1;	
			$u=count($NoEditARR);
			
			} 
			else { 
			
			$noedite = 0; 
			
			} 
		}//termina el for
	
	}//termina if que detecta edicion de registro
		
	}//---- aqui esta la parte de permisos del grupo

	
	if($ESTADO == 4){ $noedite = 1; }//aqui si el estado del registro es 4 no deja editar nada
	
	
	if( $editando == 1 ){
		$this->genera_modal("grupo_title-$idtablains-$id_autoformgrupos",500,500,$idtablains);
		$ordenador="
		<div style='float:right'>
		 <a href='$this->RutaHTTP/modules/campaigns/form_field_order.php?idgrupo=".$id_autoformgrupos."' class='grupo_title-$idtablains-$id_autoformgrupos'><img src='".$this->RutaRaiz."/imgs/ordenar.png'></a>
		</div>
				
		<div style='float:right'>  
		<a href='$this->RutaHTTP/modules/campaigns/form_group_config.php?idgrupo=".$id_autoformgrupos."' class='grupo_title-$idtablains-$id_autoformgrupos'><img src='".$this->RutaRaiz."/imgs/configurar.gif' hspace='5'></a>
		&nbsp; </div>";
						
						}
	
	if($visiblegrupo != 1 and $editando != 1 ){$oculto = "style='display:none'";}else{$oculto="";}
	
	
		$html .= "<div id='grupo_title-$idtablains-$id_autoformgrupos' align='left' class='grupos_titulos'>.: $labelgrupo $ordenador
		
		<a href=\"javascript:MostrarOcultar('grupo-$idtablains-$id_autoformgrupos',1);\"><img src='".$this->RutaRaiz."/imgs/mostrar.gif' width='11' height='11' /></a> 
		<a href=\"javascript:MostrarOcultar('grupo-$idtablains-$id_autoformgrupos',0);\"><img src='".$this->RutaRaiz."/imgs/oxultar.gif' width='11' height='11' /></a></div>
		
		<div id='grupo-$idtablains-$id_autoformgrupos' align='left' $oculto>";
		if($nota != ""){ $html .= "<div align='center' style='color:#F00'><br> $nota <br><br></div>"; }
		$html .= "<table border='0' cellspacing='0' cellpadding='0' bgcolor='#FFFFFF' width='100%'>";
			
			$calumna=1;	
			$clausulaC="SELECT labelcampo,nombrecampo,poscampo,requerido,historial,tipocampo,paramcampo,idtabla_rel,largo,valorc,mascara FROM autoform_config WHERE idtabla_rel = $idtablains AND idgrupo = $id_autoformgrupos AND eliminado  != 1 ORDER BY poscampo"; 

			//echo $clausulaC;
			
			$reqC = mysql_query($clausulaC);
			while($rowC = mysql_fetch_array($reqC))
            
			{ 
               extract($rowC); 
		
		
		if($largo == 0){ $largoF = 15 ; } else { $largoF = $largo ; }
		
		if($calumna == 1 or $calumna > $columnas){$html .= "<tr>"; $calumna=1; }
		
		if($calumna <= $columnas){ $html .= "<td class='textos_titulos'>".utf8_decode($labelcampo)."</td> 
		<td>";		//en esa parte generamos los campos segun los parametros del formulario
		if($labelgrupo == "AGENDAMIENTO" AND $bloqueo == 1){ $noedite = "1";}else{$noedite = $noedite;}
		
		//$html.="$AGBlock -";
		
		$html .= $this->armar_campo($tipocampo,$nombrecampo,"",$$nombrecampo,$requerido,$noedite,$largoF,$paramcampo,$editando,$idtabla_rel,$historial,$$valorc,@$CamParam[idReg],@$CamParam[idCam],$mascara);
		
		//$html .= $requerido." **";
		
		if($requerido == ":telefono "){
			
		$html .= "<img src='imgs/telefono.png' onClick='ventanera()' width='20px' height='20px'> ";
		
		$html .= "<script>
					function ventanera() 	{
						
   					var myWindow = window.open('modules/gestion/genera_llamada.php?telcliente=".$$nombrecampo."&ext=".$_SESSION["ext_NUMBER"]."', '', 'width=200,height=200');
						
											}
				</script>";
		
		}
		
		//echo $mascara." -- Cutibiri";
		
		$ARRcampos[]=$nombrecampo;

		$html .= "</td>"; } //en esa parte generamos los campos segun los parametros del formulario
		
		if($calumna == $columnas)	{ $html .= "</tr>"; $calumna=0;	}
		
		$calumna++; 
		
			}
			mysql_free_result($reqC);	   
		$html .= "
		<tr><td colspan='$spannumfilas'>
		<div id='divgform-$idtablains' align='center' class=\"rounded-corners-blue-pad\" style=\"display:none\"></div>
		</td></tr></table></div>";
			
		$html .= "";	   
	
	
	$VerNoverARR 	= 	array();
	$PermisosARR 	= 	array();
	$NoEditARR 		= 	array();
		
	} /*aqui mostramos o no todo el grupo*/ }
	mysql_free_result($req);
	
	if($ESTADO != 4){ //si el estado es 4 no deja guardar ni mierda
	
	$html .=" <div align='center'> 
		<input class='botonGuardar' type=\"submit\" name=\"ok\" id=\"ok\" value=\"Guardar\" /> 
		</div> </form></div>";
	
	}
	
	return $html;
	
	} //termina la funcion que genera formularios
	
	//---------------------------------------------------------------------------
	
	function generar_grid($idtablains,$vernover=0,$clausulas=1,$nombrepag="",$divShow="",$regmostrar="",$propagar="",$_pagi_pg="",$adel=0,$aedit=0,$urlR="",$divR=""){ //esta funcion genera una tabla con los campos indicados y miestra una lista
	
	$camposllenos=array();
	$campoid=$this->datostabla_ins($idtablains,"campoid"); 
	$coloresARR=array("#E6F7FF","#FFFFFF");

	$html .= "<div id='form-$idtablains'>";		
	
		$html .= "<table border='0' cellspacing='0' cellpadding='0'>
		<tr>";
		
		$clausulaC="SELECT id_autoform_config,labelcampo,nombrecampo,poscampo,requerido,historial,tipocampo,paramcampo FROM autoform_config WHERE idtabla_rel = $idtablains ORDER BY poscampo"; 
		
		//echo $clausulaC;
		
		$reqC = mysql_query($clausulaC);
		while($rowC = mysql_fetch_array($reqC))
        
		    {
        
		extract($rowC); 
		$camposllenos[]=$nombrecampo;
		$camposid[]=$id_autoform_config;
		$camposparametro[]= $paramcampo;
		$tipocamos[] = $tipocampo;
		
		$html .= "<td class='textos_titulos'><div align='center'> ".utf8_encode($labelcampo)." </div></td>";	

			}
			
		if($adel==1){$html .= "<td class='textos_titulos'><div align='center'> Desactivar </div></td>";	}
		
		mysql_free_result($reqC);	
		$html .= "</tr>";	
		
		//aqui saca los datos de la tabla oficial ------------------------------------------------------------
		
		$nombretabla=$this->datostabla_ins($idtablains,"nombretabla");  
		 
		$clausulaC="SELECT * FROM $nombretabla WHERE $clausulas"; 		
		
		//echo $clausulaC;
		
			$_pagi_sql = $clausulaC;
			$_pagi_nav_num_enlaces = 6;
			$_pagi_nombre = $nombrepag;
			$_var_show = $divShow;
			$_pagi_cuantos = $regmostrar;
			$_pagi_propagar = $propagar;

	include $this->RutaRaizINC."/libs/Paginator_Ajax.php";
		
			$reqC = $_pagi_result;
			while($rowC = mysql_fetch_array($reqC))
            {
               extract($rowC); 
			
			if($c == 2 or $c == ""){ $c=0; }
			  
		$html .= "<tr bgcolor='$coloresARR[$c]'>";
	
	for($i=0 ; $i < count($camposllenos) ; $i++){
	$html .= "<td class='textos'><div id='dived".$$campoid.$camposllenos[$i]."'>".$this->armar_campo($tipocamos[$i],$$campoid,"",utf8_decode($$camposllenos[$i]),0,1,0,$camposparametro[$i],$editando);
	
	if($aedit==1){	
	$html .= " <a href=\"javascript:EnviarLinkJ('dived".$$campoid."$camposllenos[$i]','$this->RutaHTTP/libs/formsrecuest.php?campid=$camposid[$i]&editcelda=1&editpaso=1&camid=$campoid&idcelda=".$$campoid."&nombretab=$nombretabla&nombrediv=dived".$$campoid.$camposllenos[$i]."')\"><img src='$this->RutaHTTP/imgs/editimg.png' width='12' height='12'></img></a>";	
				}
	$html .= "</div></td>";		
		}
	
	if($adel==1){ 
	
	$this->genera_modalF_int("clas".$$campoid.$camposllenos[$i],350,200,$urlR,$divR);
		
	$html .= "<td class='textoAzul'><div align='center'>
	 <a href='$this->RutaHTTP/libs/formsrecuest.php?idtabla=$idtablains&delcelda=1&camid=$campoid&idregs=".$$campoid."' class='clas".$$campoid.$camposllenos[$i]."'><img src='$this->RutaHTTP/imgs/delimg.png'></img></a> 
	 </div></td>";	}
	
		$html .= "</tr>";$c++;
			}
			mysql_free_result($reqC);	
		
		$html .= "</table></div><br>";	   

	
	$html .= $_pagi_navegacion ;
		
	return $html;
	
	} //termina la funcion que genera la lista de datos
	
	//-----------------------------------------------------------------------------------------------------
	
	function armar_campo($tipoCampo="",$nombrecampo="",$estilo="",$valor="",$requerido="",$editable="",$long="",$parametros="",$editando="",$idform="",$historial="",$CamValor="",$idreg=0,$idcam=0,$mascara=0){// esta funcion arma los campos segun la clase anterior y los parametros
		
			switch ($tipoCampo) {
				

    case "rvalor":
	
	if ( $editando  == 1 ) { $ConfigStr = "No Permitido"; }
    if ( $historial == 1 ) { $history	= "his_";		  }
	
	    return parent::c_Mvalor($parametros,$CamValor,"cuenta")." $ConfigStr ";
	    break;

    case "text":
	
	if ( $editando == 1 ) { 
	$this->genera_modal($nombrecampo,500,480,$idform);
	$ConfigStr = "<a href='$this->RutaHTTP/modules/campaigns/form_field_config.php?fname=".$nombrecampo."' class='".$nombrecampo."'><img src='".$this->RutaRaiz."/imgs/configurar.gif' width='16' height='14' /></a>"; }
    if ( $historial == 1 ) {$history="his_";}
	    return parent::c_text("",$history.$nombrecampo,$estilo,"",$valor,$requerido,$editable,$long,$mascara,$idreg,$idcam)." $ConfigStr";
	    break;
    
	case "autocom":
	
	if ( $editando == 1 ) { 
	$this->genera_modal($nombrecampo,580,480,$idform);
	$ConfigStr = "<a href='$this->RutaHTTP/modules/campaigns/form_field_config.php?fname=".$nombrecampo."' class='".$nombrecampo."'><img src='".$this->RutaRaiz."/imgs/configurar.gif' width='16' height='14' /></a>"; }
	if ( $historial == 1 ) {$history="his_";}
		$paramARR=explode(",",$parametros);
		$parametrosGrupo=array(
			"tabla"=>$paramARR[0],
			"campo1"=>$paramARR[1],
			"campo2"=>$paramARR[2],
			"campoid"=>$paramARR[3],
			"condiorden"=>$paramARR[4]);
		
		return parent::c_Auto_select("",$history.$nombrecampo,$estilo,"",$requerido,$parametrosGrupo,1," ",$valor,$editable)." $ConfigStr ";
       	break;
  
    case "check":
			
		if ( $editando == 1 ) { 
		$this->genera_modal($nombrecampo,580,480,$idform);
		$ConfigStr = "<a href='$this->RutaHTTP/modules/campaigns/form_field_config.php?fname=".$nombrecampo."' class='".$nombrecampo."'><img src='".$this->RutaRaiz."/imgs/configurar.gif' width='16' height='14' /></a>"; }
		if ( $historial == 1 ) {$history="his_";}
		if ( $valor == 1 ){ $chekeado=1; }
		return parent::c_check("",$history.$nombrecampo,$estilo,"",1,$requerido,$editable,$chekeado)." $ConfigStr ";
		break;
		
	case "textarea":
	
		
	if ( $editando == 1 ) {
		$this->genera_modal($nombrecampo,580,480,$idform);
		$ConfigStr = "<a href='$this->RutaHTTP/modules/campaigns/form_field_config.php?fname=".$nombrecampo."' class='".$nombrecampo."'><img src='".$this->RutaRaiz."/imgs/configurar.gif' width='16' height='14' /></a>"; }
    if ( $historial == 1 ) {$history="his_";}
	    return parent::c_textarea("",$history.$nombrecampo,$estilo,"",$valor,3,16,$requerido,$editable)." $ConfigStr ";
        break;
	
	case "select":
	
	if ( $editando == 1 ) { 
	$this->genera_modal($nombrecampo,580,480,$idform);
	$ConfigStr = "<a href='$this->RutaHTTP/modules/campaigns/form_field_config.php?fname=".$nombrecampo."' class='".$nombrecampo."'><img src='".$this->RutaRaiz."/imgs/configurar.gif' width='16' height='14' /></a>"; }
	if ( $historial == 1 ) {$history="his_";}
		$paramARR=explode(",",$parametros);
		$parametrosGrupo=array(
			"tabla"=>$paramARR[0],
			"campo1"=>$paramARR[1],
			"campo2"=>$paramARR[2],
			"campoid"=>$paramARR[3],
			"condiorden"=>$paramARR[4]
							   );
		return parent::c_select("",$history.$nombrecampo,$estilo,"",$requerido,$parametrosGrupo,1," ",$valor,$editable)." $ConfigStr ";
        break;
	
	case "fecha":
		
		if ( $editando == 1 ) { 
		$this->genera_modal($nombrecampo,580,450,$idform);
		$ConfigStr = "<a href='$this->RutaHTTP/modules/campaigns/form_field_config.php?fname=".$nombrecampo."' class='".$nombrecampo."'><img src='".$this->RutaRaiz."/imgs/configurar.gif' width='16' height='14' /></a>"; }
        if ( $historial == 1 ) {$history="his_";}
			return parent::c_fecha_input("",$history.$nombrecampo,$estilo,"",$valor,$requerido,$editable)." $ConfigStr ";
        	break;
							}
		
		}
	
	function genera_modal($linkclase,$ancho,$alto,$idform){
		
			?>
	<script>
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$(".<?=$linkclase?>").colorbox({
			width:"<?=$ancho?>", height:"<?=$alto?>",top:"2%",iframe:true,
			onClosed:function(){ EnviarLinkJ('FormAdminB','modules/campaigns/form_manager.php?op=5&idform=<?=$idform?>'); }
			});
			//Example of preserving a JavaScript event for inline calls.
			$("#click").click(function(){ 
				$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});
		});
	</script>
			<?
		
		}
	

	function genera_modalF_int($linkclase,$ancho,$alto,$urlform,$div){
		
			?>
	<script>
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$(".<?=$linkclase?>").colorbox({
			width:"<?=$ancho?>", height:"<?=$alto?>",top:"2%",iframe:true,
			onClosed:function(){ EnviarLinkJ('<?=$div?>','<?=$urlform?>'); }
			});
			//Example of preserving a JavaScript event for inline calls.
			$("#click").click(function(){ 
				$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});
		});
	</script>
			<?
		
		}
			
	function datostabla_ins($idtablains,$campop){ //esta funcion tree el nombre de la tabla en la que se guardara el formulario 
		
		$query = "SELECT $campop FROM autoform_tablas WHERE id_autoformtablas = $idtablains";
$req = mysql_query($query);
while($row = @mysql_fetch_array($req))
            {  extract($row);
			
			return $$campop;
			   
		   }
@mysql_free_result($req);
		
								}// aqui termina esta funcion
			
		
}
// Qui termina la classe
?>