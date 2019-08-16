<?
/* esta clase va a manejar los campos dinamicos y los predefinidos de los modulos desarrollados en el openc3 esto tambien con consultas generadas de los modulos que usan los mencionados campos

Aqui los cambios que tiene en cada actualizacion:

*/

class CamposManage {
	
	var $RutaRaizINC;
	var $RutaHTTP;
	var $RutaRaiz;


	//con esta funcion armamos un campo de formulario dinamico y traemos su valor en la base de datos
	function campoFdata($nombrecampo,$idregistro=0,$editable=1,$requerido=""){
	
	if($nombrecampo != "")	{
		
	$campoprop = Man_Mysql::sql_select("autoform_config,autoform_tablas","*","nombrecampo = '$nombrecampo' AND idtabla_rel = id_autoformtablas",0);
		
			if(is_array($campoprop)){ //--------------------------				


	if($idregistro != 0){

$campodata = Man_Mysql::sql_select($campoprop[0][nombretabla],"$nombrecampo",$campoprop[0][campoid]." = '$idregistro'",0);

	}else{ $campodata[0][$nombrecampo] = ""; }


	//echo "$nombrecampo <br>";
	//echo $campodata[0][$nombrecampo]."   -   $nombrecampo <br>";


if(is_array($campodata)){

	$resultado = Auto_Forms::armar_campo($campoprop[0][tipocampo],$nombrecampo,"",$campodata[0][$nombrecampo],$requerido,$editable,"",$campoprop[0][paramcampo],"","","","",0,0);

}


	return $resultado;
				
			} //------------------------------------
				
				}
				

	}

//esta funcion actualiza la data de los campo

	function UpdateDataAF($Arrcampos,$idregistro,$idusuario,$HistorialComment=""){

$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");


	foreach ($Arrcampos as $llave => $value){ //empieza el foreach de campos de archivos

		if(substr($llave,0,2) == "af") 	{ 


	$campoprop = Man_Mysql::sql_select("autoform_config,autoform_tablas","*","nombrecampo = '$llave' AND idtabla_rel = id_autoformtablas",0);

	//aqui actualizamos
	Man_Mysql::update_regs($campoprop[0][nombretabla],"$llave = '$value'",$campoprop[0][nombretabla]."_id = $idregistro",0);

	//aqui actualizamos la ident
	Man_Mysql::update_regs("ident_".$campoprop[0][campaignid],"agente = '$idusuario'","id_ident_".$campoprop[0][campaignid]." = $idregistro",0);
	
	//aqui si es historial metemos el mismo.
	
		if($campoprop[0][historial] == 1)	{
	
			$Campos .= "his_$llave,";
			$Valores .= "'$value',";
		
											}

	
											}
											
							}//termina el for
			
			$Campos .= "fechahora,accion,id_reg,id_usuario";								
			$Valores .= "'$fecha_act $hora_act','$HistorialComment','$idregistro','$idusuario'";								

											
	Man_Mysql::inser_data("history_".$campoprop[0][campaignid],$Campos,$Valores,0);
		

	}

	//aqui sacamos la consulta que genera el filtro
	
	
	function Consulta_Filtro($idfiltro)			{
		
		$campos = "";
		$condiciones = "";

$ArmaClausulas = Man_Mysql::sql_select("firter_conditions","*","idrelconfig = '".$idfiltro."'",0);
$ArmaComtrar = Man_Mysql::sql_select("filter_camposm","*","idfiltro = '".$idfiltro."'",0);
$tablaID= Man_Mysql::sql_select("autoform_config","idtabla_rel","nombrecampo = '".$ArmaComtrar[0][campom]."'",0);
$tablaNombre = Man_Mysql::sql_select("autoform_tablas","nombretabla,campoid,campaignid","id_autoformtablas = '".$tablaID[0][idtabla_rel]."'",0);


$TraerTemplateData = Man_Mysql::sql_select("filter_tamplate,filter_config","clausulas","id_filter = '".$idfiltro."' AND id_filtertemplate = idtemplate",0);

if(is_array($TraerTemplateData)){ $TmplateClausula = " AND ".$TraerTemplateData[0][clausulas]; }else { $TmplateClausula = ""; }


	for($o=0 ; $o < count($ArmaClausulas) ; $o++){//sacamos la consulta de los campos
		
	$condiciones .= "AND ".$ArmaClausulas[$o][campo]." ".$ArmaClausulas[$o][condicion]." '".$ArmaClausulas[$o][valor]."' ";
		
		}

	for($o=0 ; $o < count($ArmaComtrar) ; $o++){//sacamos la consulta de los campos
		
	$campos .= $ArmaComtrar[$o][campom].",";
	$span++;
		
		}

$campos = $campos.$tablaNombre[0][campoid];



return array(
	
	"tabla" => $tablaNombre[0][nombretabla],
	"campos" => $campos,
	"condiciones" => "1 ".$condiciones." $TmplateClausula"
	
			);

												}

	//aqui generamos una tabla con registros pasandole en un arreglo tabla,campo y condiciones
		//si seleccionar es = a 1 muestra una lista de checkboxes que debuelve un arreglo con el id del registro en cada seleccion y la camapana separadon por un -
	
function genera_tabla($ArrgloParam,$seleccionar=0,$limite=0){
		
$TableName = Man_Mysql::sql_select(autoform_tablas,"campaignid","nombretabla = '$ArrgloParam[tabla]'",0);
		
		if($limite != 0){ $limit = " LIMIT 0,$limite"; }
		
$GetDataG = Man_Mysql::sql_select($ArrgloParam[tabla],$ArrgloParam[campos],$ArrgloParam[condiciones].$limit,0);

$camposARR = explode(",",$ArrgloParam[campos]);


if(is_array($GetDataG)){

?>

<table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <? 

	for($o=0 ; $o < count($camposARR)-1 ; $o++){//sacamos la consulta de los campos
	@$CampoData = Man_Mysql::sql_select("autoform_config","*","nombrecampo = '".$camposARR[$o]."'",0);

 ?>
    <td class="textos_negros"><?=$CampoData[0][labelcampo]?></td>
  <? } //sacamos la consulta de los campos ?> 
    <td class="textos_negros">Id</td>
  <? if($seleccionar == 1){ ?>
    <td class="textos_negros">Seleccionar</td>
  <? } ?>
  </tr>
<? for($f=0 ; $f <count($GetDataG) ; $f++){ //traemos la data del reporte?>
  <tr>
 <? for($o=0 ; $o < count($camposARR)-1 ; $o++){//sacamos la consulta de los campos
 
 	@$CampoParams = Man_Mysql::sql_select("autoform_config","*","nombrecampo = '".$camposARR[$o]."'",0);
 
 ?>
 <td class="textos">
 <?=Auto_Forms::armar_campo($CampoParams[0][tipocampo],$GetDataG[$f][$camposARR[$o]],0,$GetDataG[$f][$camposARR[$o]],0,1,0,$CampoParams[0][paramcampo]);?>
 </td>
<? } //sacamos la consulta de los campos ?> 
  <td class="textos">
  
  <a href="/openc3/?sec=gestion&mod=agent_console&regediting=<?=$GetDataG[$f][$ArrgloParam[tabla]."_id"]?>&camediting=<?=$TableName[0][campaignid]?>"><?=$GetDataG[$f][$ArrgloParam[tabla]."_id"]?></a>
  
  </td>
  <? if($seleccionar == 1){ ?>
  <td align="center" class="textos"><input type="checkbox" name="idRegCamSel[]" value="<?=$GetDataG[$f][$ArrgloParam[tabla]."_id"]?>-<?=$TableName[0][campaignid]?>" id="checkbox" /></td>
  <? } ?>
  </tr>
<? } //traemos la data del reporte?> 
</table>
		
<?	} /* - este es el final de la tabla - */	
		
		} 
	
	

}//termina la classe
?>