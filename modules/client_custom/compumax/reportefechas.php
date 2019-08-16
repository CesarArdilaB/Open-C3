<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[op] != 7){

?>
<link rel="stylesheet" type="text/css" href="../../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../../css/estilos.css"/>

<div align="center">
  <h3>Informes de Call Center</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/client_custom/compumax/reportefechas.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Inicial: <br></td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_ini","","")?></td>
        <td rowspan="2" class="textos_titulos">Tipo de llamada</td>
        <td rowspan="2" class="textos_titulos"><span class="textos">
          <input name="tipo" type="radio" id="radio" value="1" checked="checked">
          <label for="tipo">Entrante <br>
            <input type="radio" name="tipo" id="radio2" value="2">
            Saliente</label>
        </span></td>
        <td rowspan="2" class="textos_titulos"><span class="textosbig">
          <input type="submit" name="button" id="button" value="Generar">
        </span></td>
      </tr>
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Final: </td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_fin","","")?></td>
      </tr>
    </table>
  </form>
</div>
<br />
<div id="PersInf"></div>
<? 
}//este es el que saca si no ahy ninguna opcion
if($_GET[op] == 1){ // aqui termina la opcion 1
include '../../../appcfg/general_config.php';


//--- aqui seleccionamos la data
$SelectData = $sqlm->sql_select("history_1,autof_compumax_1","*","fechahora BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' AND autof_compumax_1_id	= id_reg AND af19_179 = '$_GET[tipo]'",0);


if(is_array($SelectData)){
	
	excelexp("reporto");
?>
<div>
<table border="0" cellpadding="2" cellspacing="2" bgcolor="#CCCCCC" id="reporto">
  <tr>
    <td bgcolor="#FFFFFF" class="textos_titulos">Id Registro</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Fecha de Gestión</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Nombre</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Identificación</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Ciudad</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Dirección</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Teléfono</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Correo</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Agente que gestiono</td>
  </tr>
<? 

for($i=0 ; $i < count($SelectData) ; $i++){

$SelAgente = $sqlm->sql_select("agents","name","id_agents = '".$SelectData[$i][id_usuario]."'",0);
	
?>
  <tr>
    <td bgcolor="#FFFFFF" class="textospadding"><a target="_blank" href="?sec=gestion&mod=agent_console&regediting=<?=$SelectData[$i][id_reg]?>&camediting=1"><?=$SelectData[$i][id_reg]?></a></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelectData[$i][fechahora]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelectData[$i][af19_166	]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelectData[$i][af19_155]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelectData[$i][af19_158]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelectData[$i][af19_157]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelectData[$i][af19_159]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelectData[$i][af19_161]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelAgente[0][name]?></td>
  </tr>
<? } ?>
</table>
</div>

<?
}


} // aqui termina la opcion 1?>