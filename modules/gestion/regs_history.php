<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<? 
include '../../appcfg/general_config.php';

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->ValFormScripts();

$HistorialLlamadas = $sqlm->sql_select("history_".$_GET[Idcamania],"*","id_reg = '$_GET[IdIdent]'",0);

$TablaPro = $sqlm->sql_select("autoform_tablas","*","campaignid = '$_GET[Idcamania]'",0);

for($i=0 ; $i < count($TablaPro) ; $i++ ){
	
$CamposHistori = $sqlm->sql_select("autoform_config","*","idtabla_rel = '".$TablaPro[$i][id_autoformtablas]."' AND historial = '1' AND eliminado = 0",0);	

	if(is_array($CamposHistori)){for($o=0 ; $o < count($CamposHistori) ; $o++ ){//-----------------
	
	$cHp[]=array("nombre" => $CamposHistori[$o][nombrecampo],"tipo" => $CamposHistori[$o][tipocampo], "label" => $CamposHistori[$o][labelcampo], "parametros" => $CamposHistori[$o][paramcampo]);
	
	} //--------------------------------------------------------------
	}//el iff que verifica arreglo.
	} 

//terminamos de llamar el historial de modificaciones de el registro.
for($i=0 ; $i < count($TablaPro) ; $i++ ){
	
$CamposTelefono = $sqlm->sql_select("autoform_config","*","idtabla_rel = '".$TablaPro[$i][id_autoformtablas]."' AND telefono = '1'",0);	

if(is_array($CamposTelefono)){
	
	for($o=0 ; $o < count($CamposTelefono) ; $o++ ){//-----------------
	
	$cTp[]=array("nombre" => $CamposTelefono[$o][nombrecampo], "label" => $CamposTelefono[$o][labelcampo], "tabla" => $TablaPro[$i][nombretabla]);
	
	} //--------------------------------------------------------------

}
	} 
	
?> 

<table border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blanco">
  <tr>
    <td class="rounded-corners-blue"><div align="left" class="textos_titulos">Historial de Edicion</div></td>
  </tr>
  <tr>
    <td><table border="0" cellspacing="5" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha y Hora</td>
        <td class="textos_titulos">Usuario</td>
        <td class="textos_titulos">Accion</td>
        
        <? for($i=0; $i < count($cHp) ; $i++){ ?>
        
        <td class="textos_titulos"><?=$cHp[$i][label]?></td>
        
        <? } ?>
        
        </tr>
      <? if(is_array($HistorialLlamadas)){ for($i=0 ; $i < count($HistorialLlamadas) ;$i++){ 
@$User=$formulario->traer_datos_select("agents","name","name","id_agents",0,"id_agents = '".$HistorialLlamadas[$i][id_usuario]."'");
?>
      <tr>
        <td bgcolor="#F2F2F2" class="textos" style="width:130px"><?=$HistorialLlamadas[$i][fechahora]?></td>
        <td bgcolor="#F2F2F2" class="textos"><div align="center" class="textos"><?=$User[texto]?></div></td>
        <td bgcolor="#F2F2F2" class="textos"><?=$HistorialLlamadas[$i][accion]?></td>
        <? for($o=0; $o < count($cHp) ; $o++){//-----------?>
        
        <td bgcolor="#F2F2F2" class="textos">
          
		  <?=$formulario_auto->armar_campo($cHp[$o][tipo],$cHp[$o][nombre],"",$HistorialLlamadas[$i]["his_".$cHp[$o][nombre]],0,1,0,$cHp[$o][parametros])?> 
         
          <? 
		  if($_SESSION["group_ID"] == 100 ){ //seccion de edicion de historiales harcodeado nesesario ponerle un administrador.		  
		  genera_modalF("EditHisto".$i,900,600); ?> 
          <a class="EditHisto<?=$i?>" href="/openc3/modules/gestion/edithostori.php?idreg=<?=$HistorialLlamadas[$i][id_reg]?>&valor=<?=$HistorialLlamadas[$i]["his_".$cHp[$o][nombre]]?>&fechahora=<?=$HistorialLlamadas[$i][fechahora]?>&ncampo=<?=$cHp[$o][nombre]?>">
          <img src='<?=$RAIZHTTP?>/imgs/editimg.png' width='12' height='12'></img>
          </a> 
          <? } //sierra el if para los permisos de este modulo de edicion de historiales.?>         
          
          </td>
        
        <? } //--------------------------------------------?>
        </tr>
      <? }} ?> 
    </table></td>
  </tr>
  <tr>
    <td class="rounded-corners-blue"><div class="textos_titulos" align="left"> ---- </div></td>
  </tr>
  <tr>
    <td> ---- </td>
  </tr>
</table>
