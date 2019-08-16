<? 
session_start();

include("../../appcfg/general_config.php");

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $addcampo != 1){ 

if(isset($_POST[ok_guardar])){
	
	$Guardar = $sqlm->ins_from($_POST,"metas_interval","ok_guardar",0);
	
	}
	
if(isset($_POST[idinterval_nodb])){
	
	$Guardar = $sqlm->update_recs_auto("metas_interval",$_POST,0,"id_metainterval = '$_POST[idinterval_nodb]'",0);
	
	}
	
if(isset($_POST[Borrar])){
	
	$Guardar = mysql_query("DELETE FROM metas_interval WHERE id_metainterval = '$_POST[idinterval_nodb]'");
	
	}


$DataIntervalos = $sqlm->sql_select("metas_interval","*","id_meta = '$_GET[idmetas]'",0);

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<meta charset="utf-8">
	
<div class="textosbig" align="center">
  <h3>Asignar Intervalos</h3>
</div>
<div align="center">
  <form id="form1" name="form1" method="post" action="">
    <table border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td class="textospadding">Desde</td>
        <td><input name="desde" type="text" id="desde" size="3" /></td>
        <td class="textospadding">Hasta</td>
        <td><input name="hasta" type="text" id="hasta" size="3" /></td>
        <td class="textospadding">Valor</td>
        <td><input name="valor" type="text" id="valor" size="7" /></td>
      </tr>
      <tr>
        <td colspan="6" align="center"><input name="id_meta" type="hidden" id="id_meta" value="<?=$_GET[idmetas]?>" />          <input type="submit" name="ok_guardar" id="ok_guardar" value="Guardar" /></td>
      </tr>
    </table>
  </form>
<hr>
<? if(is_array($DataIntervalos)){ ?>
  <table border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td align="center" class="textos_titulos">Desde</td>
      <td align="center" class="textos_titulos">Hasta</td>
      <td align="center" class="textos_titulos">Valor</td>
      <td align="center" class="textos_titulos">Acciones</td>
    </tr>
<? for($i=0 ; $i < count($DataIntervalos) ; $i++){//este es el final del for ?>
  <form method="post">
    <tr>
      <td><input name="desde" type="text" value="<?=$DataIntervalos[$i][desde]?>" id="desde" size="3" /></td>
      <td><input name="hasta" type="text" value="<?=$DataIntervalos[$i][hasta]?>" id="hasta" size="3" /></td>
      <td><input name="valor" type="text" value="<?=$DataIntervalos[$i][valor]?>" id="valor" size="7" /></td>
      <td><input name="idinterval_nodb" type="hidden" id="idinterval_nodb" value="<?=$DataIntervalos[$i][id_metainterval]?>" />        <input type="submit" name="act_ok_nodb" id="act_ok_nodb" value="Actualizar" />
        | 
        <input type="submit" name="Borrar" id="Borrar" value="Borrar" /></td>
    </tr>
   </form>
<? } //este es el final del for ?>
  </table>

<? }else{echo "Sin Intervalos";} ?>
  
</div>
<p>&nbsp;</p>
<p>
  <? }//para cuando no ahy opciones ?>
</p>
<p>&nbsp;</p>
