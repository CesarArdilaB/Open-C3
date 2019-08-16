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
  <form name="form1" onsubmit="EnviarLinkForm('ListaRegs','<?=$RAIZHTTP?>/modules/inventarios/pistolear_out.php?op=2',this);return false;">
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

$randcode = rand(10,100);

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTPCONF";
//$JsScripts->AllScripts();
$JsScripts->ValFormScripts();


include("../../appcfg/class_agenda.php");
$agendac = new Agenda();

$AgendaData = $sqlm->sql_select("agenda_tmp,inv_inventario","inv_inventario.idregistro,agenda_tmp.idcampana,fecha","fecha BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' AND  agenda_tmp.idregistro = inv_inventario.idregistro AND inv_inventario.idregistro != 0",0);

$AgendaDataAgrupada = $sqlm->sql_select("agenda_tmp,inv_inventario","inv_inventario.idregistro,agenda_tmp.idcampana,fecha","fecha BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' AND  agenda_tmp.idregistro = inv_inventario.idregistro  AND inv_inventario.idregistro != 0 GROUP BY numeroref",0);


?>
<br />
<? if(is_array($AgendaData)){ ?>

<script>
		function SoloLectura(){
        $('#lote').attr('readonly', true);
		$('#guia').attr('readonly', true);
		$('#bolsa').attr('readonly', true);
		$('#idcampana').attr('readonly', true);
		$('#tiempomax').attr('readonly', true);

		}
		function NormalLectura(){
        $('#lote').attr('readonly', false);
		$('#guia').attr('readonly', false);
		$('#bolsa').attr('readonly', false);
		$('#idcampana').attr('readonly', false);
		$('#tiempomax').attr('readonly', false);


		}
		
		
		function foco(){
			
		var bolsaso = document.getElementById('ControlBolsa');
		var bolsasoV = document.getElementById('bolsaout');
		var Scode = document.getElementById('pseudocodigo');
		var Formulario = document.getElementById('formaPisto');
			
		if	(bolsaso.value == "1")	{ 
		
		$('#pseudocodigo').focus();
		EnviarLinkForm('PistolResult','<?=$RAIZHTTP?>/modules/inventarios/pistolear_out.php?op=3',Formulario);
		$('#pseudocodigo').attr('value','');

		 								}

		
		if	(bolsaso.value == "2")	{
		
		$('#bolsaout').focus();
		EnviarLinkForm('PistolResult','<?=$RAIZHTTP?>/modules/inventarios/pistolear_out.php?op=3',Formulario);
		$('#bolsaout').attr('value','');

					
									}

			}
			
		//esta funcion desactiva la bolsa de seguridad	
		function DesactivaBolsa(){
		
        $('#bolsaout').attr('readonly', true);
		$('#pseudocodigo').attr('readonly', false);
		$('#bolsaout').attr('value','');
		$('#ControlBolsa').attr('value','1');
			
			}

		//esta funcion activa la bolsa de seguridad	
		function ActivaBolsa(){
		
		$('#pseudocodigo').attr('value','');
        $('#pseudocodigo').attr('readonly', true);
        $('#bolsaout').attr('readonly', false);
		$('#ControlBolsa').attr('value','2');
			
			}

		//esta funcion es cuando se termina el pistoleo	
		function focolote(){
		$('#lote').focus();
		$('#lote').attr('value','');
		$('#guia').attr('value','');
		$('#bolsa').attr('value','');
		$('#pseudocodigo').attr('value','');
		$('#idcampana').attr('value','');
		$('#tiempomax').attr('value','');
			}
</script>

<form name="form3" method="post" onsubmit="foco();return false;" action="" id="formaPisto">
  <table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
    <tr>
      <td class="textos_titulos">Mensajero</td>
      <td><? 
	$parametrosGrupoHerr=array(
	"tabla"=>"mensajeros",
	"campo1"=>"id_mensajero",
	"campo2"=>"name",
	"campoid"=>"id_mensajero",
	"condiorden"=>"nolabora = 0 AND inactivo = 0 AND maxcitas > 0");
	echo $formulario->c_Auto_select("","idmensajero","","",":required",$parametrosGrupoHerr,1,"-","",0,15); ?></td>
      <td class="textos_titulos">Fecha de ruta</td>
      <td><span class="textos_titulos">
        <?=$formulario->c_fecha_input("","fecha_ruta","","","",":required",0,"-0")?>
      </span></td>
    </tr>
    <tr>
      <td class="textos_titulos">Estado Custodia</td>
      <td><?
	$parametrosGrupo=array(
	"tabla"=>"inv_estado",
	"campo1"=>"id_estado",
	"campo2"=>"estado",
	"campoid"=>"id_estado",
	"condiorden"=>"1");		 
	echo Generar_Formulario::c_select("","idestado","","",":required",$parametrosGrupo,0,0);?></td>
      <td class="textos_titulos">Bodega</td>
      <td><?
	$parametrosGrupo=array(
	"tabla"=>"inv_bodegas",
	"campo1"=>"id_bodegas ",
	"campo2"=>"nombre",
	"campoid"=>"id_bodegas",
	"condiorden"=>"1");		 
	echo Generar_Formulario::c_select("","idbodega","","",":required",$parametrosGrupo,0,0);?></td>
    </tr>
    <tr>
      <td colspan="4" align="center" class="textos_titulos"><table border="0" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
        <tr>
          <td class="textos_titulos"> CODIGO SOBRE</td>
          <td><input name="bolsaout" type="text" id="bolsaout" size="10" readonly /></td>
          <td><input type="radio" name="ControlBolsa" id="radio" value="2" onclick="ActivaBolsa()" /></td>
        </tr>
        <tr>
          <td class="textos_titulos"><strong>CODIGO TARJETA</strong></td>
        <td>
   <input type="text" name="pseudocodigo" id="pseudocodigo" />
   		</td>
        <td>
   <input name="ControlBolsa" type="radio" id="radio2" value="1" checked="checked" onclick="DesactivaBolsa()" />
   		</td>
        </tr>
      </table>
      <input name="ControlBolsa" type="hidden" id="ControlBolsa" value="1" /></td>
    </tr>
    <tr>
      <td colspan="4" align="center" class="textos_titulos"><input type="submit" name="ok_pistolo" id="ok_pistolo" value="Guardar" /> 
      - 
      <input type="submit" name="ok_pistolo2" id="ok_pistolo2" onclick="EnviarLinkJ('ListaRegs','<?=$RAIZHTTP?>/modules/inventarios/pistolear_out.php?op=2&fecha_ini=<?=$_GET[fecha_ini]?>&fecha_fin=<?=$_GET[fecha_fin]?>')" value="Finalizar Lote" /></td>
    </tr>
  </table>
</form>
<div id="PistolResult" align="center"></div>
<br />
<br />

<!--<script>

$(document).ready(function(){
$('#tabladatos').dataTable();

});

</script>  -->


<a href="javascript:imprimir('TabladatosPrint')">Imprimir</a> 

<form id="form2" name="form2" method="post" action="">
<div id="TabladatosPrint">
  <table border="0" align="center" cellpadding="2" bgcolor="#EFEFEF" cellspacing="2" class="rounded-corners-gray" id="tabladatos">
   <thead>
    <tr>
      <th colspan="16" class="textos_titulos">Numero de Entregas: <?=count($AgendaData)?> - Numero de entregas agupadas por bolsa <?=count($AgendaDataAgrupada)?></th>
      </tr>
    <tr>
      <th class="textos_titulos">Fecha AG</th>
      <th class="textos_titulos"><strong>CODIGO TARJETA</strong></th>
      <th class="textos_titulos">Bolsa de seguridad de salida</th>
      <th class="textos_titulos">Guia de salida</th>
      <th class="textos_titulos">Campaña</th>
      <th class="textos_titulos">Cliente Bancario</th>
      <th class="textos_titulos">Tipo Entrega</th>
      <th class="textos_titulos">Direccion de agendamiento</th>
      <th class="textos_titulos">documentos a solicitar</th>
      <th class="textos_titulos">Observaciones Call </th>
      <th class="textos_titulos">Comentarios agenda</th>
      <th class="textos_titulos">Horario Agendamiento</th>
      <th class="textos_titulos">Label</th>
      <th class="textos_titulos">Barrio</th>
      <th class="textos_titulos">Ref Mensajero</th>
      <th class="textos_titulos">Id Registro</th>
      </tr>
   </thead>
   <tbody>
    <? 

for( $i = 0 ; $i < count($AgendaData) ; $i++ ){ 

$AgeCampos 	= $sqlm->sql_select("agenda_camconfig","*","idcampana = '".$AgendaData[$i][idcampana]."'",0);
$InvCampos 	= $sqlm->sql_select("inv_camconfig","*","idcampana = '".$AgendaData[$i][idcampana]."'",0);
$CamCliente = $campanaC->campana_parents($AgendaData[$i][idcampana]);

$Pseudo = $camposman->campoFdata($InvCampos[0][cpseudocodigo],$AgendaData[$i][idregistro]);
$Bolsa = $camposman->campoFdata($InvCampos[0][cbolsaout],$AgendaData[$i][idregistro]);

//$guardar = $sqlm->inser_data("inv_pistoltmp","pseudocode,bolsa,random","'$Pseudo','$Bolsa','$randcode'",0);

?>
    <tr>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$AgendaData[$i][fecha];?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$Pseudo;?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$Bolsa?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$camposman->campoFdata($InvCampos[0][cguiaout],$AgendaData[$i][idregistro]);?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$camposman->campoFdata($AgeCampos[0][campanac],$AgendaData[$i][idregistro]);?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$CamCliente[clienteN]?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$camposman->campoFdata($AgeCampos[0][tipoentregac],$AgendaData[$i][idregistro]);?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$camposman->campoFdata($AgeCampos[0][direccionenc],$AgendaData[$i][idregistro]);?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$camposman->campoFdata($AgeCampos[0][documentossolc],$AgendaData[$i][idregistro]);?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$camposman->campoFdata($AgeCampos[0][obsevacionesc],$AgendaData[$i][idregistro]);?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$AgendaData[$i][comentarios]?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$AgendaData[$i][hora]?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$camposman->campoFdata($AgeCampos[0][labelc],$AgendaData[$i][idregistro]);?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$camposman->campoFdata($AgeCampos[0][barrioc],$AgendaData[$i][idregistro]);?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$camposman->campoFdata($AgeCampos[0][refmensajeroc],$AgendaData[$i][idregistro]);?></td>
      <td bgcolor="#FFFFFF" class="textospadding"><?=$AgendaData[$i][idregistro]?></td>
      </tr>
    <?  } ?>
   </tbody>
   <tfoot>
   </tfoot>
  </table>
</div>
</form>


<? }else{ echo "No hay agenda para estas fechas"; } /*aqui es si hay registros*/ }

if($_GET[op] == 3){ //-------------------------

if($inc != 1){ include("../../appcfg/general_config.php"); }
require("../../appcfg/class_agenda.php");
$agendac = new Agenda();


//aqui pistoleamos lo de pseudocodigo
if($_GET[ControlBolsa] == 1 and $_GET[pseudocodigo] != "")		{

$SelAgData = $sqlm->sql_select("agenda_tmp","id_agendatmp","numeroref = '$_GET[pseudocodigo]'",0);

if(is_array($SelAgData)) {
$agendac->agendar($SelAgData[0][id_agendatmp],$_GET[idmensajero_hidden],$_GET[idestado],$_GET[idbodega],$_GET[fecha_ruta]);
echo "Listo";
			}{ echo "Este pseudocodigo ya esta agendado o no esta inventareado";}

									}
									
									
									
if($_GET[ControlBolsa] == 2 and $_GET[bolsaout] != "")		{

$SelAgData = $sqlm->sql_select("agenda_tmp","id_agendatmp","numeroref = '$_GET[bolsaout]'",0);

if(is_array($SelAgData)) {

$agendac->agendar($SelAgData[0][id_agendatmp],$_GET[idmensajero_hidden],$_GET[idestado],$_GET[idbodega],$_GET[fecha_ruta],$_SESSION["user_ID"]);
echo "Listo";				

			}else { echo "Esta bolsa ya esta agendada o no esta inventareada";}


									}

?>



<? } ?>