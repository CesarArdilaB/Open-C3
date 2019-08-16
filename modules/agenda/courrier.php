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
  <h3>Organizar Citas</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/agenda/courrier.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha a gestionar: <br></td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_ini","","")?>
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

$CitasDetalle = $sqlm->sql_select("agenda_tmp","*","fecha = '$_GET[fecha_ini]' ORDER BY numeroref",0);

$CuardarCons ="INSERT INTO `agenda_numeroref`(`numeroref`, `contador`)  SELECT bolsaout, COUNT(bolsaout) AS cuenta
FROM  `inv_inventario` WHERE indexado = 0 AND matchf=1 GROUP BY bolsaout";
mysql_query($CuardarCons);

$UpdateCons ="UPDATE inv_inventario SET indexado=1  WHERE indexado=0 AND matchf=1";
mysql_query($UpdateCons);


if(is_array($CitasDetalle)){//verificamos si es arreglo
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
      <td align="center" class="textos_titulos">ZONA</td>
      <td align="center" class="textos_titulos"># Bolsa de seguridad  de salida</td>
      <td align="center" class="textos_titulos">Consecutivo</td>
      <td align="center" class="textos_titulos">Contador de registros por bolsa</td>
      <td align="center" class="textos_titulos">Tipo de entrega  inicial</td>
      <td align="center" class="textos_titulos">Observaciones call</td>
      <td align="center" class="textos_titulos">DATOS TERCERO AUTORIZADO</td>
      <td align="center" class="textos_titulos">LOCALIDAD</td>
      <td align="center" class="textos_titulos">CIUDAD</td>
      <td align="center" class="textos_titulos">Codigo Oficina</td>
	  <td align="center" class="textos_titulos">Codigos de oficinas</td>
	  <td align="center" class="textos_titulos">Email</td>
	  <td align="center" class="textos_titulos">Telefono Movil</td>
	  <td align="center" class="textos_titulos">Fecha Cita</td>
      <td align="center" class="textos_titulos">Hora Cita</td>
      <td align="center" class="textos_titulos">Comentario</td>
      <td align="center" class="textos_titulos">Asignar Mensajero</td>
      <td align="center" class="textos_titulos">Cancelar Cita</td>
    </tr>
<? 	for($i = 0 ;$i < count($CitasDetalle) ; $i++) {


$AgnCfg = $sqlm->sql_select("agenda_camconfig","*","idcampana = '".$CitasDetalle[$i][idcampana]."'",0);
$InvCfg = $sqlm->sql_select("inv_camconfig","cbolsaout","idcampana = '".$CitasDetalle[$i][idcampana]."'",0);


$Label = $camposman->campoFdata($AgnCfg[0][labelc],$CitasDetalle[$i][idregistro]);
$Campana = $camposman->campoFdata($AgnCfg[0][campanac],$CitasDetalle[$i][idregistro]);
$Bolsa = $camposman->campoFdata($InvCfg[0][cbolsaout],$CitasDetalle[$i][idregistro]);
$Cedula = $camposman->campoFdata($AgnCfg[0][cedulac],$CitasDetalle[$i][idregistro]);
$Nombre = $camposman->campoFdata($AgnCfg[0][nombrec],$CitasDetalle[$i][idregistro]);
$Tercero = $camposman->campoFdata($AgnCfg[0][datosterc],$CitasDetalle[$i][idregistro]);
$Direccion = $camposman->campoFdata($AgnCfg[0][direccionenc],$CitasDetalle[$i][idregistro]);
$Tipoe = $camposman->campoFdata($AgnCfg[0][tipoentregainic],$CitasDetalle[$i][idregistro]);
$ref = $camposman->campoFdata($AgnCfg[0][refmensajeroc],$CitasDetalle[$i][idregistro]);
$ibsercacionescall = $camposman->campoFdata($AgnCfg[0][obsevacionesc],$CitasDetalle[$i][idregistro]);
$barrio = $camposman->campoFdata($AgnCfg[0][barrioc],$CitasDetalle[$i][idregistro]);
$ciudad = $camposman->campoFdata($AgnCfg[0][ciudadc],$CitasDetalle[$i][idregistro]);
$codigos = $camposman->campoFdata($AgnCfg[0][codigosoc],$CitasDetalle[$i][idregistro]);
$documentos = $camposman->campoFdata($AgnCfg[0][documentossolc],$CitasDetalle[$i][idregistro]);

#---------------------------------- Nuevos agregados en marzo de 2018 ----------------------------

$codigooficina = $camposman->campoFdata($AgnCfg[0][codigooficinac],$CitasDetalle[$i][idregistro]);
$codigooficinas = $camposman->campoFdata($AgnCfg[0][codigosoc],$CitasDetalle[$i][idregistro]);
$email = $camposman->campoFdata($AgnCfg[0][emailc],$CitasDetalle[$i][idregistro]);
$telmovil = $camposman->campoFdata($AgnCfg[0][movilc],$CitasDetalle[$i][idregistro]);

#---------------------------------- Nuevos agregados en marzo de 2018 ----------------------------

#---------------------- Nuevos agregados en mayo 8 consecutivo y contador de numero de bolsa----------------------

$ContadorQ = $sqlm->sql_select("agenda_numeroref","*","numeroref = '$Bolsa'",0);
if (is_array($ContadorQ)) {
  $Conscutivo = $ContadorQ[0][idnumeroref];
  $Contador = $ContadorQ[0][contador];
}else{
  $Conscutivo = "Pseudo";
  $Contador = "Pseudo";
}

#---------------------- Nuevos agregados en mayo 8 consecutivo y contador de numero de bolsa----------------------

?>
    <tr>
      <td align="center" class="textos"><a href="/openc3/?sec=gestion&amp;mod=agent_console&amp;regediting=<?=$CitasDetalle[$i][idregistro]?>&amp;camediting=<?=$CitasDetalle[$i][idcampana]?>">
        <?=$CitasDetalle[$i][idregistro]?></a></td>
      <td align="center" class="textos"><?=$Label?></td>
      <td align="center" class="textos"><?=$Campana?></td>
      <td align="center" class="textos"><?=$Cedula?></td>
      <td align="center" class="textos"><?=$Nombre?></td>
      <td align="center" class="textos"><?=$Direccion?></td>
      <td align="center" class="textos"><?=$zona?></td>
      <td align="center" class="textos"><?=$Bolsa?></td>
      <td align="center" class="textos"><?=$Conscutivo?></td>
      <td align="center" class="textos"><?=$Contador?></td>
      <td align="center" class="textos"><?=$Tipoe?></td>
      <td align="center" class="textos"><?=$ibsercacionescall?></td>
      <td align="center" class="textos"><?=$Tercero?></td>
      <td align="center" class="textos"><?=$barrio?></td>
      <td align="center" class="textos"><?=$ciudad?></td>
	  <td align="center" class="textos"><?=$codigooficina?></td>
	  <td align="center" class="textos"><?=$codigooficinas?></td>
	  <td align="center" class="textos"><?=$email?></td>
	  <td align="center" class="textos"><?=$telmovil?></td>
      <td align="center" class="textos"><?=$CitasDetalle[$i][fecha]?></td>
      <td align="center" class="textos"><?=$CitasDetalle[$i][hora]?></td>
      <td class="textos"><?=$CitasDetalle[$i][comentarios]?>&nbsp;</td>
      <td align="center" class="textos">
      <? genera_modalF("Link$i",1000,600,"modules/agenda/courrier.php?op=1&fecha_ini=$_GET[fecha_ini]",'PersInf'); ?>
      <a class="Link<?=$i?>" href="modules/agenda/addcita_currier.php?idreg=<?=$CitasDetalle[$i][idregistro]?>&idcam=<?=$CitasDetalle[$i][idcampana]?>">Asignar</a></td>
      <td align="center" class="textos">
      <? genera_modalF("Linuk$i",600,200,"modules/agenda/courrier.php?op=1&fecha_ini=$_GET[fecha_ini]",'PersInf'); ?>
      <a class="Linuk<?=$i?>" href="modules/agenda/calcelar_cita.php?idreg=<?=$CitasDetalle[$i][idregistro]?>&idcam=<?=$CitasDetalle[$i][idcampana]?>">Cancelar</a></td>

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
