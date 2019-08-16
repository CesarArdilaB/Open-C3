<?
if($_GET[op] != 1 and $_GET[op] != 2){

/*include("../../appcfg/general_config.php");
include("appcfg/class_agenda.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();
$agendac = new Agenda();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";*/


?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center">
  <h3>Ver Manifiesto</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/agenda/manifiesto.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Inicial: <br></td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_ini","","")?>
          &nbsp;</td>
        <td class="textos_titulos">Mensajero</td>
        <td class="textos_titulos"><? 
	$parametrosGrupoHerr=array(
	"tabla"=>"mensajeros",
	"campo1"=>"id_mensajero",
	"campo2"=>"name",
	"campoid"=>"id_mensajero",
	"condiorden"=>"nolabora = 0");
		
		echo $formulario->c_Auto_select("","mensajero","","","",$parametrosGrupoHerr,1,": ","",0,15); ?>
        &nbsp;</td>
        <td class="textos_titulos">&nbsp;<span class="textosbig">
          <input type="submit" name="button" id="button" value="Buscar" />
        </span></td>
      </tr>
    </table>
  </form>
</div>
<br />
<div id="PersInf" style="height:100%"></div>


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

if($_GET[mensajero_hidden] != "" ){ $consulta .= "AND idmensajero = '$_GET[mensajero_hidden]'"; }


$CitasDia = $sqlm->sql_select("agenda,autof_matrizprincipal_1","*","fecha = '$_GET[fecha_ini]' AND idregistro = autof_matrizprincipal_1_id AND idcampana = 1 $consulta",0);

if(is_array($CitasDia)){//verificamos si es arreglo
?>		

<div align="center">
<? excelexp(tabladata); ?>
  <table id="tabladata" width="0" border="0" align="center" cellpadding="0" cellspacing="3" class="rounded-corners-blue">
    <tr>
      <td colspan="22" align="center" class="textos_titulos">Numero de Citas: <?=count($CitasDia)?></td>
    </tr>
    <tr>
      <td align="center" class="textos_titulos">Id Registro</td>
      <td align="center" class="textos_titulos">Agente que agendo</td>
      <td align="center" class="textos_titulos">LABEL</td>
      <td align="center" class="textos_titulos">CAMPAÑA</td>
      <td align="center" class="textos_titulos">CEDULA</td>
      <td align="center" class="textos_titulos">CLIENTE</td>
      <td align="center" class="textos_titulos">DIRECCION</td>
      <td align="center" class="textos_titulos">ZONA</td>
      <td align="center" class="textos_titulos">LOCALIDAD</td>
      <td align="center" class="textos_titulos">CIUDAD</td>
      <td align="center" class="textos_titulos"># Bolsa de seguridad  de salida</td>
      <td align="center" class="textos_titulos">Tipo de entrega  inicial</td>
      <td align="center" class="textos_titulos">Observaciones call</td>
      <td align="center" class="textos_titulos">DATOS TERCERO AUTORIZADO</td>
      <td align="center" class="textos_titulos">Fecha Cita</td>
      <td align="center" class="textos_titulos">Hora Cita</td>
      <td align="center" class="textos_titulos">Mensajero</td>
      <td align="center" class="textos_titulos">Comentario</td>
      <td align="center" class="textos_titulos">FeedBack</td>
      <td align="center" class="textos_titulos">Geotag</td>
      <td align="center" class="textos_titulos">Reagendar</td>
      <td align="center" class="textos_titulos">Entrego</td>
    </tr>
<? 	for($i = 0 ;$i < count($CitasDia) ; $i++) {
	$MensajeroData = $sqlm->sql_select("mensajeros","*","id_mensajero = '".$CitasDia[$i][idmensajero]."'",0);	
	$MensajeroEntregoData = $sqlm->sql_select("mensajeros","*","id_mensajero = '".$CitasDia[$i][idmensajero_entrego]."'",0);	

	$CampanaData = $formulario_auto->armar_campo("select","nom","",$CitasDia[$i][af13_38],0,1,0,"autof_af13_38,id_af13_38,field1,id_af13_38,1");

//Armamos la direccion

 	$callecra 	= 	$formulario_auto->armar_campo("select","nom","",$CitasDia[$i][af13_71],0,1,0,"autof_af13_71,field2,field1,id_af13_71,1");
	$puntos 	= 	": ".$CitasDia[$i][af13_145];
	$numero 	= 	"# ".$CitasDia[$i][af13_72];
	$casa 		= 	"Conjunto/Casa/Apto/Bloque: ".$CitasDia[$i][af13_81];
	$barrio 	= 	"Barrio: ".$CitasDia[$i][af13_149];
	$ciudad 	= 	$formulario_auto->armar_campo("select","nom","",$CitasDia[$i][af13_67],0,1,0,"autof_af13_67,id_af13_67,field1,id_af13_67,1");
	$zona	 	= 	$formulario_auto->armar_campo("select","nom","",$CitasDia[$i][af13_68],0,1,0,"autof_af13_68,id_af13_68,field1,id_af13_68,1");
	$localidad 	= 	$formulario_auto->armar_campo("select","nom","",$CitasDia[$i][af13_69],0,1,0,"autof_af13_69,id_af13_69,field1,id_af13_69,1");
	$refmensaj 	= 	"Referencia: ".$CitasDia[$i][af13_150];
	
	$DireccionComp = "$callecra $puntos $numero $casa $barrio $refmensaj";					

///	$CampanaData = $sqlm->sql_select("autof_af13_38","field1","id_af13_38 = '".."'",0);		

//campo adicionado en solicitud de daniel el 19 de diciembre de 2012
	$TipoEntIni 	= 	$formulario_auto->armar_campo("select","nom","",$CitasDia[$i][af13_795],0,1,0,"autof_af13_795,id_af13_795,field1,id_af13_795,1");

	$DataAgente 	=	$sqlm->sql_select("agents","name","id_agents = '".$CitasDia[$i][idagente]."'",0);
	if(is_array($DataAgente)){ $AgenteText = $DataAgente[0][name]; } else { $AgenteText = ""; }
	
	 ?>
    <tr>
      <td align="center" class="textos"><a href="/openc3/?sec=gestion&mod=agent_console&regediting=<?=$CitasDia[$i][idregistro]?>&camediting=1"><?=$CitasDia[$i][idregistro]?></a>&nbsp;</td>
      <td align="center" class="textos"><?=$AgenteText?></td>
      <td align="center" class="textos"><?=$CitasDia[$i][af13_51] ?></td>
      <td align="center" class="textos"><?=$CampanaData?></td>
      <td align="center" class="textos"><?=$CitasDia[$i][af13_39]?></td>
      <td align="center" class="textos"><?=$CitasDia[$i][af13_40]?></td>
      <td align="center" class="textos"><?=$DireccionComp?></td>
      <td align="center" class="textos"><?=$zona?></td>
      <td align="center" class="textos"><?=$localidad?></td>
      <td align="center" class="textos"><?=$ciudad?></td>
      <td align="center" class="textos"><?=$CitasDia[$i][af13_152]?>&nbsp;</td>
      <td align="center" class="textos"><?=$TipoEntIni?></td>
      <td align="center" class="textos"><?=$CitasDia[$i][af13_112]?></td>
      <td align="center" class="textos"><?=$CitasDia[$i][af13_794]?></td>
      <td align="center" class="textos"><?=$CitasDia[$i][fecha]?></td>
      <td align="center" class="textos"><?=$CitasDia[$i][hora]?></td>
      <td class="textos">
	  <? genera_modalF("Editar".$i,400,400,"modules/agenda/manifiesto.php?op=1&fecha_ini=$_GET[fecha_ini]","PersInf"); ?>
	  <? if(is_array($MensajeroData)){echo $MensajeroData[0][name];}?> 
      <a class="Editar<?=$i?>" href="modules/agenda/editar_mensajero.php?idcita=<?=$CitasDia[$i][id_agenda]?>">Editar</a>
      </td>
      <td class="textos"><?=$CitasDia[$i][comentarios]?>&nbsp;</td>
      <td align="left" valign="top">
      <? 
	  if($CitasDia[$i][feedback] == 0){
	  genera_modalF("FeedBack",400,400,"modules/agenda/manifiesto.php?op=1&fecha_ini=$_GET[fecha_ini]","PersInf"); ?>
      <a href="modules/agenda/feedback.php?idcita=<?=$CitasDia[$i][id_agenda]?>" class="FeedBack">Enviar</a>&nbsp;          <? }else{ 
	$FeedBackData = $sqlm->sql_select("agenda_estados","estado","id_estado = '".$CitasDia[$i][feedback]."'",0);		
	  ?>
      <? if(is_array($FeedBackData)){ echo $FeedBackData[0][estado]; }?> - <?=$CitasDia[$i][feddbackcoments]?>
	  <? } ?></td>
      <td align="left" valign="top">
	  
	  <? 
	  genera_modalF("mapvew".$i,560,580,"");
	  if($CitasDia[$i][geotag] != ""){ echo "<a target='_blank' class='mapvew$i' href='modules/monitoring/courier_map.php?geoT=".$CitasDia[$i][geotag]."'>Ver Mapa</a>"; } ?>&nbsp;</td>
      <td align="center" valign="top">      
        <? genera_modalF("Link$i",1000,600,"modules/agenda/manifiesto.php?op=1&fecha_ini=$_GET[fecha_ini]",'PersInf'); ?>
      <a class="Link<?=$i?>" href="modules/agenda/addcita_currier.php?idreg=<?=$CitasDia[$i][idregistro]?>">Reagendar</a></td>
      <td align="left" valign="top"><? if(is_array($MensajeroEntregoData)){echo $MensajeroEntregoData[0][name];}?></td>
  
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