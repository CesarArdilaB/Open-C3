<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3){

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->ValFormScripts();
?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">	
<div align="center">
  <form name="form1" onsubmit="EnviarLinkForm('ListaRegs','<?=$RAIZHTTP?>/modules/agenda/registros_aut.php?op=2',this);return false;">
    <table border="0" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td colspan="4" align="center" class="textos_titulos">Pistolear Salida</td>
      </tr>
      <tr>
        <td class="textospadding">Fecha Inicial</td>
        <td><span class="textos_titulos">
          <?=$formulario->c_fecha_input("","fecha_ini","","")?>
        </span></td>
        <td class="textospadding">Fecha Final</td>
        <td><span class="textos_titulos">
          <?=$formulario->c_fecha_input("","fecha_fin","","")?>
        </span></td>
      </tr>
      <tr>
        <td colspan="4" align="center"><input type="submit" name="button" id="button" value="Generar" /></td>
      </tr>
    </table>
  </form>
</div>


<hr>

<div id="ListaRegs"></div>
  <? }//---------------------------

if($_GET[op] == 2){ //-------------------------
if($inc != 1){ include("../../appcfg/general_config.php"); }

$AgData = $sqlm->sql_select("agenda","idregistro,idcampana,claved,clavef","fecha BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' AND claved != '' GROUP BY numeroref",0);

excelexp("Expertable");

?>

<table border="0" align="center" cellpadding="0" id="Expertable" cellspacing="1" class="rounded-corners-gray">
  <tr>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Id Registro</td>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Nombre</td>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Cedula</td>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Email</td>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Celular 1</td>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Celular 2</td>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Clave F</td>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Clave D</td>
  </tr>
<? 

for( $i = 0 ; $i < count($AgData) ; $i++ ){ 

$CamData = $campanaC->campana_config($AgData[$i][idcampana]);

$CamCfg = $sqlm->sql_select("agenda_camconfig","nombrec,cedulac,emailc,movilc,movil2c","idcampana = '".$AgData[$i][idcampana]."'",0);

$RegData = $sqlm->sql_select($CamData[tablaP],"*","$CamData[campoID] = '".$AgData[$i][idregistro]."'",0);

?>
  <tr>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$AgData[$i][idregistro]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$RegData[0][$CamCfg[0][nombrec]]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$RegData[0][$CamCfg[0][cedulac]]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$RegData[0][$CamCfg[0][emailc]]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$RegData[0][$CamCfg[0][movilc]]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$RegData[0][$CamCfg[0][movil2c]]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$AgData[$i][clavef]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$AgData[$i][claved]?></td>
  </tr>
<?  } ?>
</table>
  <? } ?>
