<? 
session_start();

include("../../appcfg/general_config.php");

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1){ 

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<meta charset="utf-8">
	
<div class="textosbig" align="center">
  <h3>Reporte de Metas</h3>

  <form id="form1" name="form1" method="post" action="">
    Seleccione una fecha<span class="textos_titulos">
    <?=$formulario->c_fecha_input("","fecha_ini","","")?>
    </span>
      <input type="submit" name="gen_ok" id="gen_ok" value="Ver Reporte" />
  </form>
</div>

<? if(isset($_POST[gen_ok])){ 

$DataMeta = $sqlm->sql_select("metas_config","*","id_metas = '".$_GET[idmetas]."' AND '$_POST[fecha_ini]' BETWEEN fdesde AND fhasta",0);

if(!is_array($DataMeta)){ ?>

<div align="center" class="textosbig">No Hay Valores Configurados Para Esta Fecha</div>
<? 
exit;
}

$DataCampana = $sqlm->sql_select("autoform_tablas,autoform_config","*","nombrecampo = '".$DataMeta[0][campo]."' AND idtabla_rel = id_autoformtablas",0);

$gruposARR = explode(",",$DataMeta[0][grupos]);

for($i = 0 ; $i < count($gruposARR);$i++){ if($gruposARR[$i] != ""){ $ClausulaGrupo .= "idagents_group = ".$gruposARR[$i]." OR "; } }
$ClausulaGrupo = substr($ClausulaGrupo,0,-3);

if($DataMeta[0][campo_agentes] == 1){//---------------------------------------------

$DataAgentes = $sqlm->sql_select("agents","name,id_agents","$ClausulaGrupo AND inactivo = 0 ORDER BY idagents_group",0);
$ComparaAG = "agente";

}//-----------------------------------------------------------------------------
else{

$trartablaCampo = $sqlm->sql_select("autoform_config,autoform_tablas","nombretabla","nombrecampo = '".$DataMeta[0][campo_agentes]."' AND idtabla_rel = id_autoformtablas",0);
$DataAgentes = $sqlm->sql_select($trartablaCampo[0][nombretabla].",agents",$DataMeta[0][campo_agentes]." AS id_agents,name",$DataMeta[0][campo_agentes]." = id_agents GROUP BY ".$DataMeta[0][campo_agentes],0);
$ComparaAG = $DataMeta[0][campo_agentes];	
	
}


?>

<div align="center">
  <p>
    <? if(is_array($DataAgentes)) { ?>
  </p>
  <? excelexp("DataMeta"); ?>
  <div id="DataMeta">
  <p><span class="textos_titulos">Viendo la fecha: <?=$fecha_ini?></span></p>
  <table border="0" align="center" cellpadding="2" cellspacing="1" class="rounded-corners-gray">
    <tr>
      <td class="textos_titulos">Agente</td>
      <td class="textos_titulos">Registros</td>
      <td class="textos_titulos">Meta Diaria</td>
      <td class="textos_titulos">Cumplimiento</td>
    </tr>
<? for($i=0 ; $i < count($DataAgentes) ; $i++){//este es el final del for 

//	$ARRregistros = array();

	if($DataMeta[0][valcontador] == 0){
	
	$DataRegistros = $sqlm->sql_select($DataCampana[0][nombretabla].",ident_".$DataMeta[0][idcampana].",history_".$DataMeta[0][idcampana],"count(".$DataMeta[0][campo].") as cuenta","$ComparaAG = '".$DataAgentes[$i][id_agents]."' AND id_ident_".$DataMeta[0][idcampana]." = ".$DataCampana[0][nombretabla]."_id AND ".$DataMeta[0][campo]." = '".$DataMeta[0][valor]."' AND DATE(fechahora) = '".$fecha_ini."' AND id_reg = id_ident_".$DataMeta[0][idcampana]." GROUP BY ".$DataMeta[0][campo],0);
	if(is_array($DataRegistros) and $DataRegistros[0][cuenta] != ""){$CuentaRegs = $DataRegistros[0][cuenta]; } else {$CuentaRegs = "0";}
	
	
	}//-----------------------------------------------------------------------********
	else{
		
	$DataRegistros = $sqlm->sql_select($DataCampana[0][nombretabla].",ident_".$DataMeta[0][idcampana].",history_".$DataMeta[0][idcampana],"".$DataMeta[0][campo]." as cuenta","$ComparaAG = '".$DataAgentes[$i][id_agents]."' AND id_ident_".$DataMeta[0][idcampana]." = ".$DataCampana[0][nombretabla]."_id AND DATE(fechahora) = '".$fecha_ini."' AND id_reg = id_ident_".$DataMeta[0][idcampana]." GROUP BY id_ident_".$DataMeta[0][idcampana],0);
	if(is_array($DataRegistros)){
		
		$ARRCuentaRegs = array();
		for($o = 0 ; $o < count($DataRegistros) ;  $o++){ $ARRCuentaRegs[] = $DataRegistros[$o][cuenta]; }
		
		$CuentaRegs = array_sum($ARRCuentaRegs); 
		
		
		} else {$CuentaRegs = "0";}
		
		
	}//-----------------------------------------------------------------------********

	$ARRregistros[] = $CuentaRegs;
	$ARRmeta[] 		= $DataMeta[0][numero];
	
	?>
    <tr>
      <td class="textospadding"><?=$DataAgentes[$i][name]?>&nbsp;</td>
      <td align="center" class="textospadding"><?=$CuentaRegs?>&nbsp;</td>
      <td align="center" class="textospadding"><?=$DataMeta[0][numero]?>&nbsp;</td>
      <td align="center" class="textospadding"><?=number_format($CuentaRegs/$DataMeta[0][numero]*100,1)?>%&nbsp;</td>
    </tr>
<? } //este es el final del for ?>
    <tr>
      <td class="textos_titulos">Total Call</td>
      <td align="center" class="textospadding"><?=number_format(array_sum($ARRregistros),0,"",".")?>&nbsp;</td>
      <td align="center" class="textospadding"><?=number_format(array_sum($ARRmeta),0,"",".")?>&nbsp;</td>
      <td align="center" class="textospadding"><?=number_format(array_sum($ARRregistros)/array_sum($ARRmeta)*100,0,"",".")?>&nbsp;%</td>
    </tr>
  </table>
  
  <HR>	


<? //// Aqui vamos con la parte de las comisiones en billete verde. /////////////////// 

if(!is_numeric($DataMeta[0][valorreg])){
	
	switch ($DataMeta[0][valorreg]){
		
		case "wek";
		
		$TiempoInt = "Semanal";
		
		break;
		
		case "month";
		
		$TiempoInt = "Mensual";
		
		break;
		
		case "day";
		
		$TiempoInt = "del Dia";
		
		break;
		
		}
	
}

?>

  
    <table border="0" align="center" cellpadding="2" cellspacing="1" class="rounded-corners-gray">
    <tr>
      <td colspan="5" align="center" class="textos_titulos">Comiciones <?=$TiempoInt?></td>
      </tr>
    <tr>
      <td class="textos_titulos">Agente</td>
      <td class="textos_titulos">Registros</td>
      <td class="textos_titulos">Valor</td>
      <td class="textos_titulos">Valor Ganado</td>
      <td class="textos_titulos">Cumplimiento</td>
    </tr>
<? 

$ARRregistros=array();
$ARRmeta=array();

for($i=0 ; $i < count($DataAgentes) ; $i++){//este es el final del for 

$MetaDiaria=0;


if(!is_numeric($DataMeta[0][valorreg])){
	
	$TiempoMedida = $DataMeta[0][valorreg];
	
}else { $TiempoMedida = "DATE"; }


	
	if($DataMeta[0][valcontador] == 0){
	
	$DataRegistros = $sqlm->sql_select($DataCampana[0][nombretabla].",ident_".$DataMeta[0][idcampana].",history_".$DataMeta[0][idcampana],"count(".$DataMeta[0][campo].") as cuenta","$ComparaAG = '".$DataAgentes[$i][id_agents]."' AND id_ident_".$DataMeta[0][idcampana]." = ".$DataCampana[0][nombretabla]."_id AND ".$DataMeta[0][campo]." = '".$DataMeta[0][valor]."' AND $TiempoMedida(fechahora) = $TiempoMedida('".$fecha_ini."') AND id_reg = id_ident_".$DataMeta[0][idcampana]." GROUP BY ".$DataMeta[0][campo],0);
	if(is_array($DataRegistros) and $DataRegistros[0][cuenta] != ""){$CuentaRegs = $DataRegistros[0][cuenta]; } else {$CuentaRegs = "0";}
	
	
	}//-----------------------------------------------------------------------********
	else{
	$ARRCuentaRegs = array();	
	$DataRegistros = $sqlm->sql_select($DataCampana[0][nombretabla].",ident_".$DataMeta[0][idcampana].",history_".$DataMeta[0][idcampana],"".$DataMeta[0][campo]." as cuenta","$ComparaAG = '".$DataAgentes[$i][id_agents]."' AND id_ident_".$DataMeta[0][idcampana]." = ".$DataCampana[0][nombretabla]."_id AND $TiempoMedida(fechahora) = $TiempoMedida('".$fecha_ini."') AND id_reg = id_ident_".$DataMeta[0][idcampana]." GROUP BY id_ident_".$DataMeta[0][idcampana],0);
	if(is_array($DataRegistros)){
		
		
		for($o = 0 ; $o < count($DataRegistros) ;  $o++){ $ARRCuentaRegs[] = $DataRegistros[$o][cuenta]; }
		
		$CuentaRegs = array_sum($ARRCuentaRegs); 
		
		} else {$CuentaRegs = "0";}
		
		
	}//-----------------------------------------------------------------------********
	

//************************ aqui sacamos la cuenta segun los intervalos

if($CuentaRegs != 0 and $CuentaRegs != ""){

if(!is_numeric($DataMeta[0][valorreg])){

$IntervalData = $sqlm->sql_select("metas_interval","*","$CuentaRegs BETWEEN desde AND hasta AND id_meta = '$_GET[idmetas]'",0);

if(is_array($IntervalData)){//si hay intervalos

$MetaDiaria = $CuentaRegs * $IntervalData[0][valor];
$ValorReg = $IntervalData[0][valor];

}//si hay intervalos
else{ echo " Sin Intervalos de valores asignados. ";exit;}



}else{
	
$MetaDiaria = $CuentaRegs * $DataMeta[0][valorreg];
$ValorReg = $DataMeta[0][valorreg];
	
	}
	
}//***********************

	
	
	$ARRregistros[] = $CuentaRegs;
	$ARRmeta[] 		= $MetaDiaria;
	
?>
    <tr>
      <td class="textospadding"><?=$DataAgentes[$i][name]?>&nbsp;</td>
      <td align="center" class="textospadding"><?=number_format($CuentaRegs,0,"",".")?>&nbsp;</td>
      <td align="center" class="textospadding">$<?=number_format($ValorReg,0,"",".")?></td>
      <td align="center" class="textospadding">$<?=number_format($MetaDiaria,0,"",".")?>&nbsp;</td>
      <td align="center" class="textospadding"><?=number_format($CuentaRegs/$MetaDiaria*100,1)?>%&nbsp;</td>
    </tr>
<? } //este es el final del for ?>
    <tr>
      <td class="textos_titulos">Total Call</td>
      <td align="center" class="textospadding">$<?=number_format(array_sum($ARRregistros),0,"",".")?>&nbsp;</td>
      <td align="center" class="textospadding">&nbsp;</td>
      <td align="center" class="textospadding">$<?=number_format(array_sum($ARRmeta),0,"",".")?>&nbsp;</td>
      <td align="center" class="textospadding"><?=number_format(array_sum($ARRregistros)/array_sum($ARRmeta)*100,1,"",".")?>&nbsp;%</td>
    </tr>
  </table>
  

<? }else{ ?>Sin Agentes<? } ?></div></div> <? }//verifica el if del formulario ?>

<? }//para cuando no ahy opciones ?>
