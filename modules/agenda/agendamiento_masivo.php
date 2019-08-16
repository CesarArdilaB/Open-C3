<?
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4){

@include("../../appcfg/general_config.php");

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
  <tr>
    <td colspan="2" align="center" class="textos_negros">Agendamiento Masivo</td>
  </tr>
  <tr>
    <td class="textos_negros">Seleccione una Campaña</td>
    <td><? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"1",
	"direccion"=>"modules/agenda/agendamiento_masivo.php?op=1");
	echo $formulario->select_envia_link("","id_campaign","","","",$parametrosGrupoHerr,0,"","MuestraCampos"); ?></td>
  </tr>
</table>
<br />
<br />
<div id="MuestraCampos"></div>

<?
} if($_GET[op] == 1){

@include("../../appcfg/general_config.php");

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------

$FiltrosLista = $sqlm->sql_select("filter_config","nombre,id_filter","idcam = $varid AND agendamientos = 1",0);


?>

<table border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
      <tr>
        <td align="center" class="textos_titulos">Filtros Disponibles</td>
      </tr>
<? for( $i = 0 ; $i < count($FiltrosLista) ; $i++ ){ ?>
      <tr>
        <td class="textospadding"><?=$FiltrosLista[$i][nombre]?> - 
        <a href="javascript:EnviarLinkJ('lista_registros','modules/agenda/agendamiento_masivo.php?op=2&idfilter=<?=$FiltrosLista[$i][id_filter]?>&idcam=<?=$varid?>')" class="textos_negros">Ver Registros</a></td>
      </tr>
<?  } ?>
    </table></td>
    <td align="center" valign="top">
    <form id="form1" name="form1" method="post" action="<?=$RAIZHTTP?>/modules/agenda/agendamiento_masivo.php?op=3" onsubmit="MandarAgendamiento();return false;">
      <table border="0" cellpadding="0" cellspacing="2" class="rounded-corners-blue">
        <tr>
          <td><div id="lista_registros"> Sin Registros </div></td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
</table>


<? 

}if($_GET[op] == 2){ 

@include("../../appcfg/general_config.php");

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTPCONF";
$JsScripts->ValFormScripts();


$filtrArrai = $camposman->Consulta_Filtro($_GET[idfilter]);


$AgCamConfig = $sqlm->sql_select("agenda_camconfig","*","idcampana = '$_GET[idcam]'",0);

//print_r($AgCamConfig);

?>

<script>

EnviarLinkJ('MostrarCal','<?=$RAIZHTTP?>/modules/agenda/agendamiento_masivo.php?op=4&fecham=<?=$fecha_act?>');



function checkAll() {
        var nodoCheck = document.getElementsByTagName("input");
        var varCheck = document.getElementById("all").checked;
        for (i=0; i<nodoCheck.length; i++){
            if (nodoCheck[i].type == "checkbox" && nodoCheck[i].name != "all" && nodoCheck[i].disabled == false) {
                nodoCheck[i].checked = varCheck;
            }
        }
    }


</script>

<table border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td align="right" class="textos_titulos">Campo Gestion Call: </td>
    <td align="left"><?=$camposman->campoFdata($AgCamConfig[0][gestioncallc],0,0,":required");?></td>
  </tr>
  <tr>
    <td align="right" class="textos_titulos">Fecha de agendamiento</td>
    <td align="left">
    <script>
	$(function() {
	$( "#datepicker" ).datepicker(
	{onSelect: function(value, date) {
		
EnviarLinkJ('MostrarCal','<?=$RAIZHTTP?>/modules/agenda/agendamiento_masivo.php?op=4&fecham='+value);
		
		}
		
	,dateFormat: 'yy-mm-dd',minDate: -0}
		);
	});
	</script>
    
    <div id="datepicker"></div></td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="textos_titulos"><div id="MostrarCal" class="textos_titulos"></div></td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="textos_titulos"><input type="submit" name="button" id="button" value="Guardar" /></td>
  </tr>
  <tr>
    <td colspan="2" align="right" class="textos_titulos">Seleccionar todos <input type="checkbox" name="all" id="all"
     onclick="checkAll();" />
  &nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><?=$camposman->genera_tabla($filtrArrai,1,100);?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="button2" id="button2" value="Guardar" />    </td>
  </tr>
</table>


<? }if($_GET[op] == 3){ 

@include("../../appcfg/general_config.php");
require("../../appcfg/class_agenda.php");
$agendac = new Agenda();

//print_r($_POST);

for( $i=0 ; $i < count($_POST[idRegCamSel]) ; $i++ )	{
		
		$DatosSeleccionados = explode("-",$_POST[idRegCamSel][$i]);
		$idregistro = $DatosSeleccionados[0];
		$idcampana = $DatosSeleccionados[1];

$AgCamConfig = $sqlm->sql_select("agenda_camconfig","gestioncallc","idcampana = '$idcampana'",0);


$agendac->agendarTMP($idregistro,$idcampana,$_SESSION[user_ID],$_POST[fecha_ini],$_POST[$AgCamConfig[0][gestioncallc]],0);

			
														}

?>

<div align="center" class="rounded-corners-orange textosbig">Agendamiento Finalizado</div>

<? }
if($_GET[op] == 4){ 

@include("../../appcfg/general_config.php");
require("../../appcfg/class_agenda.php");
$agendac = new Agenda(); 


$agendaDISP = $agendac->agenda_disp(0,$_GET[fecham])


?>
    <script>
    
	function MandarAgendamiento()	{
			
	var Formulario = document.getElementById('form1');
	var checkboxes = document.getElementById("form1").checkbox;
	var fecha = document.getElementById('fecha_ini');
	var tope = document.getElementById('topeag');
	
	var cont = 1;
     
    for (var x=0; x < checkboxes.length; x++) {
    
	if (checkboxes[x].checked) 	{	
    
	cont = cont + 1;
    
	}
    							}
	
	//verificamos que seleccione un registro al menos							
	
	if(cont == 0){alert('Debe seleccionar al menos un registro para agendar'); return false;}

	if(eval(cont) > eval(tope.value)){alert("Los registros a agendar ("+cont+") sobrepasan la capacidad disponible ("+tope.value+") para la fecha: "+ fecha.value); return false;}
	
	//--------------
	
	if (confirm("Confirma el agendamiento masivo de " + cont + " registros seleccionados para la fecha " + fecha.value + " ?")) {
	
	EnviaFormPost('lista_registros','<?=$RAIZHTTP?>/modules/agenda/agendamiento_masivo.php?op=3',Formulario);
	
	}
	else	{
	
	return false;
	
			}
	

									}
    </script>

<div class="rounded-corners-orange textosbigBlanco">
Citas Disponobles para la fecha <?=$_GET[fecham]?>: <?=$agendaDISP?>
<input name="fecha_ini" id="fecha_ini" type="hidden" value="<?=$_GET[fecham]?>" />
<input name="topeag" id="topeag" type="hidden" value="<?=$agendaDISP?>" />
</div>

<? } ?>
