<? 
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3){

if($inc != 1){ include("../../appcfg/general_config.php"); }


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


if($_POST[ok]){ 

//print_r($_POST); 

for($i=0 ; $i < count($_POST[regedit]) ; $i++){ //aqui guardamos esa vuelta
	
$sqlm->update_regs("agenda","feedback = '$_POST[feedback]'","id_agenda = '".$_POST[regedit][$i]."'",0);
	
	}//aqui guardamos esa vuelta

echo "<br><br><br><br><br><br><div align='center'>Registros Actualizados</div>";

}

 switch($_GET[tfeed]){
	 
	 case"all";
	 $FeddClausula = "AND 1";
	 break;
	 
	 case"ok";
	 $FeddClausula = "AND feedback = 3";
	 break;

	 case"nook";
	 $FeddClausula = "AND feedback != 3 AND feedback != 0";
	 break;

	 case"none";
	 $FeddClausula = "AND feedback = 0";
	 break;
	 
	 }


$DataFeed = $sqlm->sql_select("agenda","feedback,idmensajero,idmensajero_entrego,idregistro,idcampana,id_agenda","fecha BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' AND idmensajero = $_GET[idmen] $FeddClausula",0);

if(is_array($DataFeed)){
?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<div align="center"><? excelexp("detailtable"); ?></div>
<form id="form1" name="form1" method="post" action="">
  <table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-gray" id="detailtable">
    <tr>
      <td class="textos_titulos">Nombre Cliente</td>
      <td class="textos_titulos">Cedula</td>
      <td class="textos_titulos">Label</td>
      <td class="textos_titulos">Bolsa de seguridad de Salida</td>
      <td class="textos_titulos">Direccion de entrega</td>
      <td class="textos_titulos">Tipo entrega</td>
      <td class="textos_titulos">Campaña</td>
      <td class="textos_titulos">Codigo Oficina</td>
      <td class="textos_titulos">Cliente Bancario</td>
      <td class="textos_titulos">Feedback</td>
      <td class="textos_titulos">Id Registro</td>
      <td class="textos_titulos">Editar</td>
    </tr>
    <?

if(is_array($DataFeed)){
for( $i = 0 ; $i < count($DataFeed) ; $i++ ){ 

$AgeCampos 	= $sqlm->sql_select("agenda_camconfig","*","idcampana = '".$DataFeed[$i][idcampana]."'",0);
$InvCampos 	= $sqlm->sql_select("inv_camconfig","cbolsaout","idcampana = '".$DataFeed[$i][idcampana]."'",0);

//echo $DataFeed[$i][idregistro]." ------ ";

$CamCliente = $campanaC->campana_parents($DataFeed[$i][idcampana]);
$Ncliente = $camposman->campoFdata($AgeCampos[0][nombrec],$DataFeed[$i][idregistro]);
$Cedula = $camposman->campoFdata($AgeCampos[0][cedulac],$DataFeed[$i][idregistro]);
$label = $camposman->campoFdata($AgeCampos[0][labelc],$DataFeed[$i][idregistro]);
$direccionent = $camposman->campoFdata($AgeCampos[0][direccionenc],$DataFeed[$i][idregistro]);
$Tipoent = $camposman->campoFdata($AgeCampos[0][tipoentregac],$DataFeed[$i][idregistro]);
$campana = $camposman->campoFdata($AgeCampos[0][campanac],$DataFeed[$i][idregistro]);
$cofofice = $camposman->campoFdata($AgeCampos[0][codigooficinac],$DataFeed[$i][idregistro]);
$bolsasalida = $camposman->campoFdata($InvCampos[0][cbolsaout],$DataFeed[$i][idregistro]);

$SelFeed = $sqlm->sql_select("agenda_estados","estado","id_estado = '".$DataFeed[$i][feedback]."'",0);
if(is_array($SelFeed)){ $FeedText = $SelFeed[0][estado]; }else{ $FeedText = ""; }

?>
    <tr>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$Ncliente?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$Cedula?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$label?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$bolsasalida?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$direccionent?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$Tipoent?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$Ncliente?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$campana?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$CamCliente[clienteN]?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$FeedText?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><a href="/openc3/?sec=gestion&amp;mod=agent_console&amp;regediting=<?=$DataFeed[$i][idregistro]?>&amp;camediting=<?=$DataFeed[$i][idcampana]?>" target="_parent">
        <?=$DataFeed[$i][idregistro]?>
      </a></td>
      <td align="center" bgcolor="#FFFFFF" class="textospadding">
      <input type="checkbox" value="<?=$DataFeed[$i][id_agenda]?>" name="regedit[]" id="regedit" />
      </td>
    </tr>

    <?  }} ?>
    <tr>
      <td colspan="12" align="center" valign="top" bgcolor="#FFFFFF" class="textospadding"><div align="center">
        <?
	$parametrosGrupo=array(
	"tabla"=>"agenda_estados",
	"campo1"=>"id_estado ",
	"campo2"=>"estado",
	"campoid"=>"id_estado",
	"condiorden"=>"inactivo = 0");		 
	echo $formulario->c_select("","feedback","","","",$parametrosGrupo,0,0);?>        
        <input type="submit" name="ok" id="ok" value="Guardar" />
      </div></td>
    </tr>
  </table>
</form>


<? }/*si es arreglo*/	} ?>