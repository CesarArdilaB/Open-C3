<? 
session_start();
include '../../appcfg/general_config.php';

if($delReg == 1){
	
mysql_query("DELETE FROM asigned_regs WHERE idreg = '$IdReg' AND idagent ='".$_SESSION["user_ID"]."'");
	
	}

//aqui arriba borro el registro --------------------------------

$asigned_grou = $sqlm->sql_select("firter_asign","idfiltro","(idgrupo = '".$_SESSION["groupag_ID"]."' OR idagente = '".$_SESSION["user_ID"]."')",0);

if(is_array($asigned_grou)){//----



for($i = 0 ; $i < count($asigned_grou); $i++){
	
$span=0;
$campos = "";
$condiciones = "";

$ArmaClausulas = $sqlm->sql_select("firter_conditions","*","idrelconfig = '".$asigned_grou[$i][idfiltro]."'",0);
$ArmaComtrar = $sqlm->sql_select("filter_camposm","*","idfiltro = '".$asigned_grou[$i][idfiltro]."'",0);
$tablaID= $sqlm->sql_select("autoform_config","idtabla_rel","nombrecampo = '".$ArmaComtrar[0][campom]."'",0);
$tablaNombre = $sqlm->sql_select("autoform_tablas","nombretabla,campoid,campaignid","id_autoformtablas = '".$tablaID[0][idtabla_rel]."'",0);


$TraerTemplateData = $sqlm->sql_select("filter_tamplate,filter_config","clausulas","id_filter = '".$asigned_grou[$i][idfiltro]."' AND id_filtertemplate = idtemplate",0);

if(is_array($TraerTemplateData)){ $TmplateClausula = " AND ".$TraerTemplateData[0][clausulas]; }else { $TmplateClausula = ""; }


	for($o=0 ; $o < count($ArmaClausulas) ; $o++){//sacamos la consulta de los campos
		
	$condiciones .= "AND ".$ArmaClausulas[$o][campo]." ".$ArmaClausulas[$o][condicion]." '".$ArmaClausulas[$o][valor]."' ";
		
		}

	for($o=0 ; $o < count($ArmaComtrar) ; $o++){//sacamos la consulta de los campos
		
	$campos .= $ArmaComtrar[$o][campom].",";
	$span++;
		
		}

$campos = $campos.$tablaNombre[0][campoid];

//echo "SELECT $campos FROM ".$tablaNombre[0][nombretabla]." WHERE 1 $condiciones <br>";

$GetDataG = $sqlm->sql_select($tablaNombre[0][nombretabla],$campos,"1 ".$condiciones." $TmplateClausula AND estado IN (0,".$_SESSION["user_ID"].") LIMIT 1",0);

$actREG = $sqlm->update_regs($tablaNombre[0][nombretabla],"estado = ".$_SESSION["user_ID"],$tablaNombre[0][nombretabla]."_id = ".$GetDataG[0][$tablaNombre[0][nombretabla]."_id"],0);


//echo "<br> ** ";

if(is_array($GetDataG)){
?>
<table border="0" cellspacing="3" cellpadding="0">
  <tr>
    <? 

	for($o=0 ; $o < count($ArmaComtrar) ; $o++){//sacamos la consulta de los campos
	@$CampoData = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$ArmaComtrar[$o][campom]."'",0);

 ?>
    <td class="textos_negros"><?=$CampoData[0][labelcampo]?></td>
  <? } //sacamos la consulta de los campos ?> 
    <td class="textos_negros">Id</td>
  </tr>
<? for($f=0 ; $f <count($GetDataG) ; $f++){ //traemos la data del reporte?>
  <tr>
 <? for($o=0 ; $o < count($ArmaComtrar) ; $o++){//sacamos la consulta de los campos
 
 $CampoParams = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$ArmaComtrar[$o][campom]."'",0);
 
 ?>
 <td class="textos">
 <?=$formulario_auto->armar_campo($CampoParams[0][tipocampo],$GetDataG[$f][$ArmaComtrar[$o][campom]],0,$GetDataG[$f][$ArmaComtrar[$o][campom]],0,1,0,$CampoParams[0][paramcampo]);?>
 </td>
<? } //sacamos la consulta de los campos ?> 
  <td class="textos"><a href="<?=$RAIZHTTP?>/?sec=gestion&mod=agent_console&regediting=<?=$GetDataG[$f][$tablaNombre[0][campoid]]?>&camediting=<?=$tablaNombre[0][campaignid]?>"><?=$GetDataG[$f][$tablaNombre[0][campoid]]?></a></td>
  </tr>
<? } //traemos la data del reporte?> 
</table>
<? }//este es e iff que verifica el filtro
else {
?>
Este filtro no tiene registros. <br>
<? } ?>

<?	} //aqui termino los asignados por filtros

}//-----

$asigned_Direct = $sqlm->sql_select("asigned_regs","idreg,idcam","idagent = '".$_SESSION["user_ID"]."'",0);

if(is_array($asigned_Direct)){//----
?>

<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center" class="textos_titulos">Por  Gestionar</td>
  </tr>
  <tr>
    <td align="center" class="textos_titulos">Id</td>
    <td align="center" class="textos_titulos">Gestionado</td>
  </tr>
<? for($i=0;$i < count($asigned_Direct ); $i++){ ?>
  <tr>
    <td align="center" class="textos"><a href="<?=$RAIZHTTP?>/?sec=gestion&mod=agent_console&regediting=<?=$asigned_Direct[$i][idreg]?>&camediting=<?=$asigned_Direct[$i][idcam]?>"><?=$asigned_Direct[$i][idreg]?></a></td>
    <td align="center" class="textos"><a href="javascript:EnviarLinkJ('RegistrosAsgnados','modules/gestion/regs_asigned.php?delReg=1&IdReg=<?=$asigned_Direct[$i][idreg]?>','',1)"><img src="<?=$RAIZHTTP?>/imgs/check.gif" width="20" height="20" border="0" /></a></td>
  </tr>
<? } ?> 
</table>
<? } //este es el iff de array de los asignados directo.?>