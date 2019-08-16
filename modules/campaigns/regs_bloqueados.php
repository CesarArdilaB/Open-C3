<?
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3){

@include("../../appcfg/general_config.php");

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
  <form name="form1" onsubmit="EnviarLinkForm('MuestraCampos','<?=$RAIZHTTP?>/modules/campaigns/regs_bloqueados.php?op=2',this);return false;">
  <table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
    <tr>
      <td colspan="4" align="center" class="textos_negros">Desbloquear Registros</td>
    </tr>
    <tr>
      <td class="textos_negros">Seleccione una Campaña</td>
      <td><span class="textos_negros">
        <? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"1");
	echo $formulario->c_select("","idcampana","","",":required",$parametrosGrupoHerr,0,"","MuestraCampos"); ?>
      </span></td>
      <td class="textos_titulos">Escriba el ID</td>
      <td><input type="text" name="regid" id="regid"></td>
    </tr>
    <tr>
      <td colspan="4" align="center" class="textos_negros"><input type="submit" name="ok" id="ok" value="Buscar"></td>
    </tr>
  </table>
</form>
<br />
<br />
<div id="MuestraCampos"></div>

<?
} if($_GET[op] == 2){

@include("../../appcfg/general_config.php");

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------

$RegBloqueado = $sqlm->sql_select("ident_".$_GET[idcampana],"id_ident_".$_GET[idcampana],"id_ident_".$_GET[idcampana]." LIKE '$_GET[regid]' AND estado = 4",0);

if(is_array($RegBloqueado)){
?>

<table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
  <tr>
    <td class="textos_titulos">Id Registro</td>
    <td class="textos_titulos">Acciones</td>
  </tr>
  <tr>
    <td>
    <a href="?sec=gestion&mod=agent_console&regediting=<?=$_GET[regid]?>&camediting=<?=$_GET[idcampana]?>" target="_blank">
	<?=$RegBloqueado[0]["id_ident_".$_GET[idcampana]]?>
    </a>
    </td>
    <td align="center"><a href="javascript:EnviarLinkJ('desbloqueo','modules/campaigns/regs_bloqueados.php?op=3&regid=<?=$_GET[regid]?>&idcampana=<?=$_GET[idcampana]?>');">Desbloquear</a></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><div class="textos_titulos" id="desbloqueo"></div></td>
  </tr>
</table>


<? 

}//aqui si el registro existe

else{ echo "El Registro no existe o no esta bloqueado"; }


} if($_GET[op] == 3){ 
@include("../../appcfg/general_config.php");

$sqlm->update_regs("ident_".$_GET[idcampana],"estado = 1","id_ident_".$_GET[idcampana]." = $_GET[regid]",0);
echo "Registro Desbloqueado"; 

}

?>