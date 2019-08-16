<?

/*esta clase sera utilizada para manejar y automatizar las consultas a mysql y en su vercion 1.0

Aqui los cambios que tiene en cada actualizacion:

*/

class Man_Mysql{

function inser_data($tabla="",$campos="",$var="",$mostrar=""){ // insertar normal

$query = "INSERT INTO $tabla ($campos) VALUES ($var)";

if($mostrar==1){echo $query;}

$req = mysql_query($query);

if (!$req)
{ echo "<br><br>***".mysql_error()."****" ;
}

			}// insertar normal

		//funcion para insertar formularios automaticamente
		function ins_from($arreglo,$tabla,$nombreboton,$monstrar=0){
			
			foreach ($arreglo as $llave => $value){
		
				if($nombreboton != $llave){
			
			if(substr($llave,-5) == "_text") 
					
					{$campos .= substr($llave,0,-5).",";}
					else{$campos .= "$llave,";}
					$valores .= "'".utf8_decode($value)."',";}
				
				}	
										
				$campos=substr($campos,0,-1);
				$valores=substr($valores,0,-1);
			
				$insertar = "INSERT INTO $tabla ($campos) VALUES ($valores)";
	
			if($monstrar == 1){echo "$insertar <br>";}
	
				$query=mysql_query($insertar)or die("ERROR MYSQL- "/*.mysql_error()*/);		
			
			return "Registro Guardado Correctamente";
			
		}//funcion para insertar formularios automaticamente

	//funcion para insertar datos de forma convencional
		function ins_regs($tabla,$nombreboton,$campos,$valores,$monstrar=0){
			
		
				$insertar = "INSERT INTO $tabla ($campos) VALUES ($valores)";
	
			if($monstrar == 1){echo "$insertar <br>";}
	
				$query=mysql_query($insertar)or die("ERROR MYSQL: "/*.mysql_error()*/);		
			
			return "Registro Guardado Correctamente";
			
		}	//funcion para insertar datos de forma convencional

	//funcion borrar un registro
		function del_regs($tabla,$clausulas,$monstrar=0){
			
		
				$borrar = "DELETE FROM $tabla WHERE $clausulas";
	
			if($monstrar == 1){echo "$borrar <br>";}
	
				$query=mysql_query($borrar)or die("ERROR MYSQL: "/*.mysql_error()*/);		
			
			return "Registro Borrado";
			
		}	//funcion borrar un registro


	//funcion editar registro
		function update_regs($tabla,$cadena,$clausulas,$monstrar=0){
			
		
				$update = "UPDATE $tabla SET $cadena WHERE $clausulas";
	
			if($monstrar == 1){echo "$update <br>";}
	
				$query=mysql_query($update);		
			
			return "";
			
		}	//funcion borrar un registro


	//funcion que actualiza los registros de forma automatica basado en el arrglo de post
	
		function update_recs_auto($tabla,$varARR,$varFILES,$condicion,$mostrar){
			
		foreach ($varARR as $llave => $value){ //empieza el foreach de campos normales
		
				$pos++;
				$arrverif[$pos] = $llave;
			
			if(substr($llave,-5) != "_nodb"){//verifica los campos que no se insertan	
			
			if(substr($llave,-5) != "_text") { 
			
			if( substr($llave,-7) == "_hidden" ){ 
			
			$nombrecampo = substr($llave,0,-7);
			$cadena .= "$nombrecampo = '$value' ,"; }
			
			else { $cadena .= "$llave = '".utf8_decode($value)."' ,"; }
			
			} 
										}//verifica los campos que no se insertan

				} //termina el foreach
				
				foreach ($varFILES as $llave => $value){ //empieza el foreach de campos de archivos
		
			 $cadena .= substr($llave,0,-5)." = '$value[name]' ,";
			
				} //termina el foreach de campos de archivos
				
		$cadenaFinal = 	substr($cadena,0,-1);
				
			$varR = $this->update_regs($tabla,$cadenaFinal,$condicion,$mostrar);

			return $varR;
			
				}

	//funcion que actualiza los registros de forma automatica basado en el arrglo de post


//funcion que inserta registros a la base de datos.

		function insert_recs_auto($tabla="",$varARR=0,$varFILES=0,$mostrar=0){
			
		foreach ($varARR as $llave => $value){ //empieza el foreach de campos normales
		
				$pos++;
				$arrverif[$pos] = $llave;
			
			if(substr($llave,-5) != "_nodb"){//verifica los campos que no se insertan	
			
			if(substr($llave,-5) != "_text") { 
			
			if( substr($llave,-7) == "_hidden" ){ 
			
			$nombrecampo = substr($llave,0,-7);
			$cadenacampos .= "$nombrecampo ,"; 
			$cadenavalores .= "'$value' ,";}
			
			else {  $cadenacampos .= "$llave ,";
					$cadenavalores .= "'$value' ,";
			 }
			
			} 
										}//verifica los campos que no se insertan

				} //termina el foreach
			
			if(is_array($varFILES))	{//verificamos si existen files	
				
				foreach ($varFILES as $llave => $value){ //empieza el foreach de campos de archivos
		
			 $cadenacampos .= substr($llave,0,-5).",";
			 $cadenavalores .= "'$value[name]' ,";
			
				} //termina el foreach de campos de archivos
			
										}//verificamos si existen files	
				
		$cadenaFinalcam = 	substr($cadenacampos,0,-1);
		$cadenaFinalval = 	substr($cadenavalores,0,-1);

		$varR=$this->inser_data($tabla,$cadenaFinalcam,$cadenaFinalval,$mostrar);

			return $varR;
			
				}
// funcion que inserta registros de manera automatica

		//Seleccionar esta funcion hace un select con sus respectivas clausulas y debuelve un array
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
			mysql_free_result($query); 			} 
			
			return $ReturARR;
			
		}//funcion para insertar formularios automaticamente
		

		//Esta funcion crea una vista.
		function sql_vistaadd($nombrev,$tabla,$campos,$clausulas=1,$monstrar=0){
			
			$seleccionar = "CREATE VIEW $nombrev AS SELECT $campos FROM $tabla WHERE $clausulas";

			if($monstrar == 1){echo "$seleccionar <br>";}

			$query=mysql_query($seleccionar)or die("ERROR MYSQL: "/*.mysql_error()*/);		
			
		}//Esta funcion crea una vista.



//funciones para manejar la estructura y creacion de tablas.

		function sql_creatabla($NombreTabla,$ArrCampos,$ArrUnicos=0,$mostrar){ // funcion para crear tablas

	for( $i = 0 ; $i < count($ArrCampos) ; $i++ ) {
		
		$camposcad .= "`".$ArrCampos[$i]["nombrec"]."` ".$ArrCampos[$i]["tipoc"]." ,";
		
		}
	
				//--------------------
		if($ArrUnicos!=0){	
	for( $i = 0 ; $i < count($ArrUnicos) ; $i++ ) {
		
		$camposunicos .= "`".$ArrUnicos[$i]."`,";
		
		}	
		
		$camposC = substr($camposunicos,0,-1);
		
		$camposunicosd = "UNIQUE ( $camposC )";
			}
				//--------------------
		
		$campos = substr($camposcad,0,-1);
		
		$consulta .= "CREATE TABLE IF NOT EXISTS `".$NombreTabla."` ( ";
		$consulta .= $campos;
		$consulta .= ", INDEX `field1` (`field1`) ) $camposunicosd  ENGINE=MyISAM;";
		
		if($mostrar == 1){ echo $consulta; }
		
		$creaConsulta=mysql_query("$consulta")or die("*** ".$consulta."<br> Error de la consulta");	
			
		} // funcion para crear tablas


		function sql_editatabla($NombreTabla,$ArrCampos,$mostrar){ // funcion para editar tablas

		for( $i = 0 ; $i < count($ArrCampos) ; $i++ ) {
		
		$camposcad .= " ADD `".$ArrCampos[$i]["nombrec"]."` ".$ArrCampos[$i]["tipoc"]." ,";
		
		}
		
		$campos = substr($camposcad,0,-1);
		
		$consulta .= "ALTER TABLE `".$NombreTabla."`";
		$consulta .= $campos;
		$consulta .= ";";
		
		if($mostrar == 1){ echo $consulta."***********"; }
		
		$creaConsulta=mysql_query("$consulta")or die("Error de la consulta ");	
			
		} // funcion para editar tablas
	
	function subir_csv($tabla,$recurso,$ArrCampos,$mostrar){ //funcion para insertar datos de un CSV
		
		while ($data = fgetcsv ($recurso,10000,";")) { //while que reviza el archivo
    		$num = count ($data);

			if($num != count($ArrCampos)){ echo "El numero de Filas no es igual a los campos seleccionados!!!"; exit;}

			for($a=0;$a<$num;$a++){
		
				$data[$a]=str_replace("'"," ",$data[$a]);
			//	$data[$a]=str_replace("/"," ",$data[$a]);
				$data[$a]=str_replace("\\"," ",$data[$a]);
				
				$cadenacampos .= "$ArrCampos[$a] ,";
				$cadenavalores .= "'$data[$a]' ,";
								
								}
			
				$ccamposdef = substr($cadenacampos,0,-1);
				$cvaloresdef = substr($cadenavalores,0,-1);

				$this->ins_regs($tabla,"ok",$ccamposdef,$cvaloresdef,$mostrar);
				
				$cadenacampos="";
				$cadenavalores="";
				
				}//while que reviza el archivo

		}//funcion para insertar datos de un CSV
	
	//---------------------------------------------------------------

	function subir_csv_form($idform,$recurso,$ArrCampos,$SubirId=0,$mostrar,$idusuario=0,$hisText="Registro Importado de Csv"){ //funcion para insertar datos de un CSV
		
$fecha=date("Y-n-j");
$hora=date("H:i:s");

		
		$numeroER=0;
		$numeroREG=0;
		
		$FormParam = $this->sql_select("autoform_tablas","*","id_autoformtablas = '$idform'");
		
		$Ntabla = $FormParam[0][nombretabla];
		$idTabla = $FormParam[0][campoid];
		$TablaIdent = "ident_".$FormParam[0][campaignid];
		$IdIdent = "id_ident_".$FormParam[0][campaignid];
		$HistoriTb = "history_".$FormParam[0][campaignid];
		
		$MaxIdnt=$this->sql_select($TablaIdent,"MAX($IdIdent) as maximo","1");
		
		$Nextid=$MaxIdnt[0][maximo];
		
		/*agregamos el campoidarray_unshift($ArrCampos,$idTabla) ; */
		
		while ($data = fgetcsv ($recurso,10000,";")) { //while que reviza el archivo
    	
		//************ aqui validamos cada campo de la tabla para la validacion*****************************//
		$error = "";
		
		$Nextid++;
		
		if($SubirId != 1){ $num = count ($data); }
		else{ $num = count ($data) - 1 ; }
		
		if($num != count($ArrCampos)){ echo "El numero de Filas no es igual a los campos seleccionados!!!"; exit;}

			for($a=0;$a<$num;$a++){
				
				$data[$a]=str_replace("'"," ",$data[$a]);
			//	$data[$a]=str_replace("/"," ",$data[$a]);
				$data[$a]=str_replace("\\"," ",$data[$a]);		
				
//				$cadenacampos		.= 		"$ArrCampos[$a] ,";
				
		//************ aqui validamos cada campo de la tabla para la validacion*****************************//
		
			$requerido = 0;
			$numerico = 0;
			$longitud = 0;		
		
		$CamParam 	= $this->sql_select("autoform_config","labelcampo,requerido","nombrecampo = '$ArrCampos[$a]'",0);
		if(is_array($CamParam)){
			
			if(ereg("required",$CamParam[0][requerido])){ $requerido = 1;}
			if(ereg("float",$CamParam[0][requerido]))	{ $numerico = 1;}
			if(ereg("length",$CamParam[0][requerido]))	{ 
			$longitud = 1;
			$letras=array("q","w","e","r","t","y","u","i","o","p","a","s","d","f","g","h","j","k","l","z","x","c","v","b","n","m",";",":");
			$longitudcaracteres = str_replace($letras,"",$CamParam[0][requerido]);
														
			if($requerido == 1 and $data[$a] == "")	{ $error .= $CamParam[0][labelcampo]." es requerido - "; $data[$a].=",,,";}
			if($numerico == 1 and !is_numeric($data[$a])){ $error .= $CamParam[0][labelcampo].": $data[$a] no es numerico - "; $data[$a].=",,,";}
			if($longitudcaracteres != "" and strlen($data[$a]) != $longitudcaracteres){ $error .= $CamParam[0][labelcampo]." debe tener $longitudcaracteres caracteres - "; $data[$a].=",,,";}
														}
		}//--------------------------------------------------
		
		//aqui tomamos los campos
		$CampoPropiedades 	= $this->sql_select("autoform_config,autoform_tablas","nombretabla,campoid","nombrecampo = '".$ArrCampos[$a]."' AND idtabla_rel = id_autoformtablas",0);
		$CamposArray[$CampoPropiedades[0][nombretabla]][]	= "$ArrCampos[$a] = '$data[$a]'";
		$CadenaTablas		.= $CampoPropiedades[0][nombretabla]."|";
		//aqui tomamos los campos
				
		$cadenaValoresER 	.= 		"$data[$a],";
			
							} //aqui termina el for que arma las cadenas.
			
			
			//aqui verificamos si se van a importar los id
			if($SubirId == 1){ $idVaL = end($data); $NoBorre = 1;}
			else{ $idVaL = $Nextid; $NoBorre = 0;}
			//aqui verificamos si se van a importar los id

			
			//------------- for para insertar los registros en cada tabla de la campana
			
			foreach($CamposArray as $k => $valor){
				
			//	echo "$k  -<br>";
				$cadenaIN = "";
				foreach ($valor as $y => $value){
					
					$cadenaIN .=" $value ,";
										
					}
					
			if($SubirId != 1){$cadenaID = $k."_id = ".$Nextid;}
			else{ $cadenaID = $k."_id = ".end($data); }
					
			$ConsultaIN = "INSERT INTO `$k` SET $cadenaIN $cadenaID";
			//echo " ----> $ConsultaIN <br><br> ";
			
			//este es el apartado en el que insertamos los datos

				$queryForm=mysql_query($ConsultaIN);
				
				if(!$queryForm){
					$ArrResultado[ids][] = $idVaL; 
					if($error == ""){ $ershow = mysql_error(); }
					
				//aqui tomamos el errror de duplicado y almasenamos estos registros en una tabla para ser posteriormente actualizado
					if(preg_match("/Duplicate/",$ershow)){
						//echo $ershow." ** <br>";
					$DataTablaTMP = "";
					$topeIndex = substr($ershow,-1);
					$Indices = array();
					
					$campoIDq = mysql_query("SHOW INDEX FROM $k");
					while($row = mysql_fetch_array($campoIDq))
					{extract($row); $Indices[] = $Column_name;}
					
					//print_r($Indices); 
					
					if($NoBorre == 1){$campoLLave = "id_tmp"; /*echo "<br>Se quedo id_reg<br>";*/}else{$campoLLave = $Indices[count($Indices)-1]; /*echo "<br>Aqui se paso ".$Indices[count($Indices)-1]." **** <br>";*/}
					
					
					
					$CreaTablaTMP =  "CREATE TABLE IF NOT EXISTS `tmp_regs` (";
					for($c=0;$c < count($ArrCampos) ; $c++){ $CreaTablaTMP .= "`$ArrCampos[$c]` varchar(255) NOT NULL,"; }
					$CreaTablaTMP .= " `id_tmp` int(11) NOT NULL auto_increment,
  										PRIMARY KEY  (`id_tmp`)
										) ENGINE=MyISAM DEFAULT CHARSET=latin1";
					$CraFinal = mysql_query($CreaTablaTMP);		// aqui creamos la tabla de las temporales.			
					
					//----------------------
					
					for($c=0;$c < count($ArrCampos) ; $c++){ 
					
					//*****aqui verificamos si el campo es select para que inserte el dato
					
					$CampoPropT		= $this->sql_select("autoform_config","tipocampo,nombrecampo","nombrecampo = '".$ArrCampos[$c]."'",0);
					
					if($CampoPropT[0][tipocampo] == "select" or $CampoPropT[0][tipocampo] == "autocom"){
						
					$DatoSelAuto 	= $this->sql_select("autof_".$CampoPropT[0][nombrecampo],"id_".$CampoPropT[0][nombrecampo]." as iddato","field1 = '".$data[$c]."'",0);
					if(is_array($DatoSelAuto)){	$DatoInsert	= $DatoSelAuto[0][iddato]; }else{$DatoInsert = $data[$c];}
						
						}else{
						
					$DatoInsert		= $data[$c];	
						
						}
						
					//*****aqui verificamos si el campo es select para que inserte el dato
				
					
					$DataTablaTMP  .= "$ArrCampos[$c] = '".$DatoInsert."',"; 
						
					
					}
					$GuardarTemporal = "INSERT INTO tmp_regs SET $DataTablaTMP id_tmp = $idVaL";
					$GardaFinal = mysql_query($GuardarTemporal);
					// aqui guardamos los repetidos en la temporal.	
					
					$Duplicados++;
					$ershow ="";
					
					}else{ $ershowF = $error." - ".$ershow; $numeroER++; }
				//aqui tomamos el errror de duplicado y almasenamos estos registros en una tabla para ser posteriormente actualizado	
					
					$ErrorRegresa	.= $cvaloresErrf."".$ershowF."\r";
				
				$errorQUERY = true;
					
				//este foreach elimina los registros de todas las tablas en caso de error en alguna
				if($NoBorre == 0)			{//aqui verificamos si debe o no eliminar os registros
				foreach($CamposArray as $k => $valor){
					
					$quieryDEL = "DELETE FROM $k WHERE ".$k."_id = $idVaL";
					mysql_query($quieryDEL);
					
					}
											}//aqui verificamos si debe o no eliminar os registros
				//este foreach elimina los registros de todas las tablas en caso de error en alguna
				
				break; // salimos del bucle por error en el registro
				
								}
				else{ 
				
				$errorQUERY = false;
				 
					}
				
			//este es el apartado en el que insertamos los datos
			
				}
			
			if($errorQUERY == false){
				
			$insertarIdent = "INSERT INTO $TablaIdent (estado , $IdIdent , fechahorac) VALUES (1 , $idVaL , '$fecha $hora')";
			$queryIdent=mysql_query($insertarIdent);
				
			$insertarIdent = "INSERT INTO $HistoriTb (accion , id_reg, fechahora,id_usuario) VALUES ('$hisText' , $idVaL, '$fecha $hora','$idusuario')";
			$queryIdent=mysql_query($insertarIdent);
				
			$numeroREG++;	
				
				}
			
			
				
			//------------- for para insertar los registros en cada tabla de la campana
			
			$CamposArray = array();
			
			
				//-------------------------------------------------------//
			
				$cadenacampos="";
				$cadenavalores="";
				$cadenaValoresER="";
				
				}//while que reviza el archivo*/
				
				if($ErrorRegresa != "")		{
				$new_report=fopen("../../tmp/ERRORES.csv","w");
  				fwrite($new_report, $ErrorRegresa);
 				fclose($new_report);
				?>
				<center> <a href="/openc3/tmp/ERRORES.csv" ><strong>Descargar Registros Con Error</strong></a> <br>
       			de click secundario y luego la opcion guardar enlace como
 				</center>
				
				<?							}
											
				
				$ArrResultado[TotalErrores] = $numeroER;
				$ArrResultado[Capos]=$ArrCampos;
				$ArrResultado[TablaTMP]="tmp_regs";
				$ArrResultado[TotalImportados] = $numeroREG;
				$ArrResultado[Resuldato] = "Total Registros Importados: $numeroREG - Duplicados: $Duplicados - Errores: $numeroER";
				$ArrResultado[ErrorData]= $ErrorRegresa;
				$ArrResultado[Duplicados]= $Duplicados;
				$ArrResultado[llave] = $campoLLave;
				
				return $ArrResultado;

		}//funcion para insertar datos de un CSV
	
	//---------------------------------------------------------------


	function ultimoid($idcampana){ //esta funcion maneja el ultimo id de la tabla de ident para enlazar los formularios de las respectivas campanas.
		
			/* 
			estetos son los estados de un id
			0 = disponible;
			1 = asignado
			2 = reservado
		`	3 = en uso
			4 = intocable
			*/		
			
		$campoid = "id_ident_".$idcampana ;
		$tabla = "ident_".$idcampana;
		
		$fecha_act=date("Y-n-j");
		$hora_act=date("H:i:s");
		
		
		
		$primerFiltro = $this->sql_select($tabla,$campoid,"estado = 0 ORDER BY $campoid ASC LIMIT 0,1");
		
		if($primerFiltro == "No hay resultados"){
		
		$segundoFiltro = $this->sql_select("ident_".$idcampana,"MAX($campoid)+1 as maximo","1 ORDER BY $campoid ASC",0);
		$maximoid=$segundoFiltro[0][maximo];
		$guardeid=$this->inser_data($tabla,"$campoid,estado,fechahorac","$maximoid,2,'$fecha_act $hora_act'",0);
		$LibberaIds=$this->update_regs($tabla,"estado=0 , fechahorac = '0000-00-00 00:00:00'","HOUR(TIMEDIFF('$fecha_act $hora_act',fechahorac)) >= 1 AND estado = 2 AND agente = 0 AND $campoid < $maximoid",0);

		return $maximoid;
			
		}else{
		
		$updateid=$primerFiltro[0][$campoid];
		$guardeid=$this->update_regs($tabla,"estado=2 , fechahorac = '$fecha_act $hora_act'","$campoid = $updateid");
		$LibberaIds=$this->update_regs($tabla,"estado=0 , fechahorac = '0000-00-00 00:00:00'","HOUR(TIMEDIFF('$fecha_act $hora_act',fechahorac)) >= 1 AND estado = 2 AND agente = 0 AND $campoid < $updateid",0);
		return $updateid;
			
			}
	
		}//esta funcion maneja el ultimo id de la tabla de ident para enlazar los formularios de las respectivas campanas.
	
}

?>