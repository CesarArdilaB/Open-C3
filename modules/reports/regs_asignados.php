<? 
session_start();

if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1){ 

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<meta charset="utf-8">
	
<table border="0" cellspacing="2" cellpadding="0" align="center">
  <tr>
    <td align="center" valign="top"><table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-gray">
      <tr>
        <td class="textos_titulos">Seleccione Una Campaña</td>
        <td class="textos_titulos"><? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"1",
	"direccion"=>"modules/reports/regs_asignados.php?op=1");
	echo $formulario->select_envia_link("","id_campaign","","","",$parametrosGrupoHerr,0,"","MuestraForms"); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><div id="MuestraForms"></div></td>
  </tr>
</table>
<? }//para cuando no ahy opciones 
if( $_GET[op] == 1 ){ //llama los tabs 

include '../../appcfg/general_config.php';
$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->ReporteScripts();

//echo $varid."***************************".$varidU;

if($_GET[delReg] == 1){
mysql_query("DELETE FROM asigned_regs WHERE idreg = '$_GET[IdReg]' AND idagent = '$_GET[IdOper]'");
	}

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------	
if($varid == "" or $varid == "undefined"){$idcam = $_GET[varidU];}else{$idcam = $varid;}

$seleccRegsAsigned = $sqlm->sql_select("asigned_regs","*","idcam = '$idcam'",0);

?>
<script>

$(document).ready(function(){

$('#RegResults').dataTable();

});

</script>
    
<br />

<? if(is_array($seleccRegsAsigned)){ ?>
<table border="0" id="RegResults" align="center" cellpadding="0" cellspacing="0" class="display">
  <thead>
    <tr>
    <th class="textos_titulos">Id Registro</th>
    <th class="textos_titulos">Agente</th>
    <th class="textos_titulos">Fecha</th>
    <th class="textos_titulos">Acciones</th>
    <th class="textos_titulos">Listo</th>
  </thead>
<? for($i = 0 ;$i < count($seleccRegsAsigned) ; $i++) { ?>
  <tr>
    <td><?=$seleccRegsAsigned[$i][idreg]?></td>
    <td><?=$formulario_auto->armar_campo("autocom","agente","",$seleccRegsAsigned[$i][idagent],0,1,0,"agents,id_agents,name,id_agents,1");?></td>
    <td><?=$seleccRegsAsigned[$i][afechahora]?></td>
    <td align="center" valign="middle">
      <? echo "<a href='$RAIZHTTP/?sec=gestion&mod=agent_console&regediting=".$seleccRegsAsigned[$i][idreg]."&camediting=$idcam'>Editar</a>"; ?>
    </td>
    <td align="center" valign="middle"><a href="javascript:EnviarLinkJ('MuestraForms','modules/reports/regs_asignados.php?varidU=<?=$idcam?>&op=1&delReg=1&IdReg=<?=$seleccRegsAsigned[$i][idreg]?>&IdOper=<?=$seleccRegsAsigned[$i][idagent]?>')"><img src="<?=$RAIZHTTP?>/imgs/check.gif" width="20" height="20" border="0" /></a></td>
  </tr>
<? } ?> 
  <tfoot>
    <tr>
    <th class="textos_titulos">Id Registro</th>
    <th class="textos_titulos">Agente</th>
    <th class="textos_titulos">Fecha</th>
    <th class="textos_titulos">Acciones</th>
    <th class="textos_titulos">Listo</th>
  </tfoot>
</table>
<? } //esto es el iff del array?>

<? } //llama los tabs ?>