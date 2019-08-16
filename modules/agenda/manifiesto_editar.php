<? 
include("../../appcfg/general_config.php");
include("../../appcfg/class_agenda.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();
$agendac = new Agenda();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

if(isset($_POST[act])){
	
	
		//$camposman->UpdateDataAF($_POST,$_GET[idreg],$_SESSION[user_ID],"Actualizado desde modulo Feedback");
		
		//print_r($_POST);

		$sqlm->update_regs("agenda","hora = '$_POST[horario]' , comentarios = '$_POST[feddbackcoments]', idmensajero = '$_POST[mensajero_hidden]'","id_agenda = '$_GET[idag]'",0);
		
		echo "<div align='center'> <br><br><br><br><br><br><br><br><br><br><br><br><br> Registro Actualizado </div>";
	
	exit;
	
	}

$AgnCfg = $sqlm->sql_select("agenda_camconfig","*","idcampana = '".$_GET[idcam]."'",0);
$InvCfg = $sqlm->sql_select("inv_camconfig","cbolsaout","idcampana = '".$_GET[idcam]."'",0);

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<form action="" method="post">
  <div align="center">
    <table width="0" border="0" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td colspan="2" align="center" class="textosbig">Editar Manifiesto - Registro: <?=$_GET[idreg]?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="textos_titulos">Mensajero</td>
        <td><? 
	$parametrosGrupoHerr=array(
	"tabla"=>"mensajeros",
	"campo1"=>"id_mensajero",
	"campo2"=>"name",
	"campoid"=>"id_mensajero",
	"condiorden"=>"nolabora = 0");
		
		echo $formulario->c_Auto_select("","mensajero","","","",$parametrosGrupoHerr,1,": ",$_GET[idmensajero],0,15); ?>        </td>
      </tr>
<!--      <tr>
        <td align="left" valign="top" class="textos_titulos">Label</td>
        <td><?=$camposman->campoFdata($AgnCfg[0][labelc],$_GET[idreg],0)?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="textos_titulos">Campaña</td>
        <td><?=$camposman->campoFdata($AgnCfg[0][campanac],$_GET[idreg],0);?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="textos_titulos"># Bolsa de seguridad</td>
        <td><?=$camposman->campoFdata($InvCfg[0][cbolsaout],$_GET[idreg],0);?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="textos_titulos">Cedula</td>
        <td><?=$camposman->campoFdata($AgnCfg[0][cedulac],$_GET[idreg],0);?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="textos_titulos">Nombre del Cliente</td>
        <td><?=$camposman->campoFdata($AgnCfg[0][nombrec],$_GET[idreg],0);?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="textos_titulos">Datos tercero autorizado</td>
        <td><?=$camposman->campoFdata($AgnCfg[0][datosterc],$_GET[idreg],0);?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="textos_titulos">Direccion entrega</td>
        <td><?=$camposman->campoFdata($AgnCfg[0][direccionenc],$_GET[idreg],0);?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="textos_titulos">Tipo entrega</td>
        <td><?=$camposman->campoFdata($AgnCfg[0][tipoentregac],$_GET[idreg],0);?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="textos_titulos">Hora cita</td>
        <td><input type="text" name="horario" id="horario" value="<?=$_GET[aghora]?>" /></td>
      </tr>-->
      <tr>
        <td align="left" valign="top" class="textos_titulos">Observaciones Agenda</td>
        <td><textarea name="feddbackcoments" cols="20" rows="3" id="feddbackcoments"><?=$_GET[agcom]?></textarea></td>
      </tr>
<!--      <tr>
        <td align="left" valign="top" class="textos_titulos">Observaciones Call</td>
        <td><?=$camposman->campoFdata($AgnCfg[0][obsevacionesc],$_GET[idreg],0);?></td>
      </tr>-->
      <tr>
        <td colspan="2" align="center"><input type="submit" name="act" id="act" value="Guardar"></td>
      </tr>
    </table>
  </div>
</form>