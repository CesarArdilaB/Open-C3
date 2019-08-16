<?
if( $_GET[op] != 1 ){ // verifica que aun no se mande 
	
include("../../appcfg/cc.php");
include("../../appcfg/func_mis.php");
include("../../appcfg/js_scripts.php");
include("../../appcfg/class_sqlman.php");
include("../../appcfg/class_forms.php");
include("../../appcfg/class_autoforms.php");

$sqlm= new Man_Mysql();

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaiz="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";
//validamos el logueo de los usuarios

$CamposGrupos = $sqlm->sql_select("autoform_grupos","*","idtabla_rel = '$_GET[idForm]' ORDER BY posiciongrupo",0);

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<center><h3>Organizar Campos</h3></center><br><br>

<style>
	#lista { list-style-type: none; margin: 0; padding: 0; width: 60%; }
	#lista li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 12px; height: 18px; }
	#lista li span { position: absolute; margin-left: -1.3em; }
	</style>
	<script>
            $(function(){
               $('#lista').sortable({
                   placeholder: 'placeholder',
                   update: function() {
                       $.get('form_group_order.php?op=1', $(this).sortable('serialize'));
					 //alert($(this).sortable('serialize'));
                   }
               }); 
            });
    </script>


<div class="demo" align="center">

<ul id="lista">

<? for($i=0 ; $i < count($CamposGrupos) ; $i++){ ?>

	<li id="item_<?=$CamposGrupos[$i]["id_autoformgrupos"]?>" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?=$CamposGrupos[$i]["labelgrupo"]?></li>

<? } // termina el for de sacar cada campo?>

</ul>

</div><!-- End demo -->
 
<? }//este es el que comprueba que no este en la op 1
if ( $_GET[op] == 1){
include '../../appcfg/general_config.php';

for($i=0 ; $i < count($_GET["item"]) ; $i++){
	
	$sqlm->update_regs("autoform_grupos","posiciongrupo = '$i'","id_autoformgrupos = '".$_GET["item"][$i]."'",0);
	
											}

}
?>