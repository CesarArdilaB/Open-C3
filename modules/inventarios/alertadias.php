<?
if($_GET[op] != 1 and $_GET[op] != 2){

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center">
  <h3>Ver Informe de Alertas Registros Sin Agendar</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/inventarios/alertadias.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Numero de Dias</td>
        <td class="textos_titulos"><label for="ndias"></label>
          <select name="ndias" id="ndias">
            <option value="-" selected="selected">Seleccione</option>
            <option value=">= 2 AND matchf = 0">48 Match</option>
            <option value="BETWEEN 1 AND 5">5</option>
            <option value="BETWEEN 5 AND 10">10</option>
            <option value="BETWEEN 10 AND 15">15</option>
            <option value="BETWEEN 90 AND 1000">90+</option>
            <option value="> 90">Destruir</option>
          </select>          
        &nbsp;</td>
        <td class="textos_titulos">Campaña</td>
        <td class="textos_titulos"><span class="textos_negros">
          <? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"id_campaign IN (SELECT idcampana FROM inv_camconfig) ");
	echo $formulario->c_select("","idcampana","","",":required",$parametrosGrupoHerr,0,"","MuestraCampos"); ?>
        </span></td>
        <td class="textos_titulos">&nbsp;<span class="textosbig">
          <input type="submit" name="button" id="button" value="Buscar" />
        </span></td>
      </tr>
    </table>
  </form>
</div>
<br />
<div id="PersInf"></div>


<?	
}if($_GET[op] == 1)	{//------------

require("../../appcfg/general_config.php");
require("../../appcfg/class_agenda.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();
$agendac = new Agenda();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";

$ConfigInventory = $sqlm->sql_select("inv_camconfig","*","idcampana = '$_GET[idcampana]'",0);
$CampConfig = $campanaC->campana_config($_GET[idcampana]);


$AleraInv= $sqlm->sql_select("inv_inventario,".$CampConfig[tablaP],"*","DATEDIFF('$fecha_act',DATE(af13_34)) $_GET[ndias] AND idregistro = $CampConfig[campoID] AND idestado = 1",0);
/* */
if(is_array($AleraInv)){//verificamos si es arreglo
?>		

<div align="center">
<? excelexp(tabladata); ?>
  <table id="tabladata" width="0" border="0" align="center" cellpadding="0" cellspacing="3" class="rounded-corners-blue">
    <tr>
      <td align="center" class="textos_titulos">Id Registro</td>
      <td align="center" class="textos_titulos">LABEL</td>
      <td align="center" class="textos_titulos">CAMPAÑA</td>
      <td align="center" class="textos_titulos">CEDULA</td>
      <td align="center" class="textos_titulos">CLIENTE</td>
      <td align="center" class="textos_titulos">DIRECCION</td>
    </tr>
	<? 	
	for($i = 0 ;$i < count($AleraInv) ; $i++) {
	$CampanaData = $sqlm->sql_select("autof_af13_38","field1","id_af13_38 = '".$AleraInv[$i][af13_38]."'",0);		
	if(is_array($CampanaData)){ $base = $CampanaData[0][field1]; } else{$base = 'Vasio';};
	?>
    <tr>
      <td align="center" class="textos"><a href="/openc3/?sec=gestion&mod=agent_console&regediting=<?=$AleraInv[$i][idregistro]?>&camediting=1"><?=$AleraInv[$i][idregistro]?></a>&nbsp;</td>
      <td align="center" class="textos"><? /*=$CitasDia[$i][af15_110]*/ ?></td>
      <td align="center" class="textos"><?=$base?></td>
      <td align="center" class="textos"><?=$AleraInv[$i][af13_39]?></td>
      <td align="center" class="textos"><?=$AleraInv[$i][af13_40]?></td>
      <td align="center" class="textos"><?=$AleraInv[$i][af13_46]?> <?=$AleraInv[$i][tiempo]?></td>
    </tr>
<? } ?> 
  </table>
 <? } //Terminamos de Verificar si es arreglo
 else{ 
 ?>
 
 No Hay Resultados.
 
 <? } ?>
</div>


<?				}//------------

//---------------------------?>