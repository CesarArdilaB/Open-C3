<? 
session_start();

//error_reporting(E_ALL);

if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[addcampo] != 1){ 


//********************************


?>

<script type="text/javascript">
 
 $(window).bind('beforeunload', function(){
 return 'Guarden los datos antes de continuar, de lo contrario perderán los cambios';
 });
 
//-------------------------------------------



</script>
 
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<meta charset="utf-8">
<? if ($_GET[camediting]=="") {?>
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
	"direccion"=>"modules/gestion/agent_console.php?op=1");
	echo $formulario->select_envia_link("","id_campaign","","","",$parametrosGrupoHerr,0,"","MuestraForms"); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><div id="MuestraForms"></div></td>
  </tr>
</table>

<? } // en caso de no estar editando un registro muestra el seleccionador de campanas.
else{

$_GET[op] = 1;	
$_POST[varid]=$_GET[camediting];
	
	}
}//para cuando no ahy opciones 
if( $_GET[op] == 1 ){ //llama los tabs 

if($_GET[regediting] == ""){
@include '../../appcfg/general_config.php';
}

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------
if(isset($_POST[varid])){ $varcam=$_POST[varid];  }else {$varcam=$_GET[camediting]; }

//include '../../appcfg/general_config.php';


$seleccforms = $sqlm->sql_select("autoform_tablas","*","tipotabla = 1 AND campaignid = $varcam ORDER BY id_autoformtablas",0);

if($_GET[regediting] == ""){

$IdentID = $sqlm->ultimoid($varcam);
$FormMode=0;

}else{

$IdentID = $_GET[regediting];

$FormMode=1;

	}

?>
	
<table border="0" align="center" cellpadding="5" cellspacing="2">
  <tr>
    <td  valign="top">
    
   <div style="margin-right:5px; margin-top:-2px;"> 
   

<table border="0" cellspacing="2" cellpadding="2" class="rounded-corners-blue">
  <tr>
    <td class="textosbig">ID:
      <?=$IdentID?></td>
  </tr>
  <tr>

   <td>
    <? genera_modalF("modaluatoas",400,180,"",""); ?>
    <a href="<?=$RAIZHTTP?>/modules/gestion/regs_autoasign.php?regediting=<?=$IdentID?>&camediting=<?=$varcam?>" class="modaluatoas">Guardar Este Registro</a></td>
  </tr>

  <tr>
   
    
    <td class="textos">

    <a href="<?=$RAIZHTTP?>/?sec=gestion&amp;mod=agent_console&camediting=<?=$varid?>">Insertar Nuevo Registro</a>
    </td>
    
    
    </tr>

  <tr>
    <td class="textos"><div class="textos_titulos" align="center">Registros Asignados</div></td>
  </tr>
  <tr>
    <td class="textos">
<? //if($_SESSION["group_ID"] != 4) { //linea con hardcode para tse?>

<script>
setInterval( "EnviarLinkJ('RegistrosAsgnados','modules/gestion/regs_asigned.php','',1)", 5000 );
</script>


    <div id="RegistrosAsgnados">
    <? include("$RAIZ/modules/gestion/regs_asigned.php");?>
    </div>
<? //} //linea con hardcode para tse ?> 
    </td>
  </tr>
	</table>

    </div>
    
    </td>
    <td valign="top">

	<script>
	$(function() {
		$( "#tabs" ).tabs({
			ajaxOptions: {
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html("No ahy contenido para mostar");
				}
			}
		});
	});
	</script>

    
<div class="demo">
<div id="tabs">
	<ul>
 <? for ($i=0;$i<count($seleccforms);$i++){ //ESTE ES EL FORMQUE SACA LOS FORMULARIOS PARA EL TABUNTAB

	@$genFormC = mysql_query("SHOW COLUMNS FROM `".$seleccforms[$i]["nombretabla"]."`"); 
		
 	
		if($genFormC != ""){

 ?> 
 <li>
 <a href="modules/gestion/agent_console.php?op=2&Idcamania=<?=$varcam?>&IdIdent=<?=$IdentID?>&FormMode=<?=$FormMode?>&idforma=<?=$seleccforms[$i]["id_autoformtablas"]?>">
 <?=$seleccforms[$i]["labeltabla"]?>
 </a>
</li>		
        
 <? 						} 
 	} //ESTE ES EL FORMQUE SACA LOS FORMULARIOS PARA EL TABUNTAB
	
	//aqui le ponesmos la pestaña de los historiales.
	
$FilePermision = $sqlm->sql_select("files_relacces","*","id_grupo = '".$_SESSION["group_ID"]."' AND (ver = 1 OR adm = 1)",0);

if(is_array($FilePermision)){ //aqui verificamos permisos para lor archivos
	
	if($FilePermision[0][adm] == 1){
	
	 ?>

<li>
 <a href="modules/gestion/filemanager.php?Idcamania=<?=$varcam?>&IdIdent=<?=$IdentID?>">
 Administrar Documentacion Relacionada
 </a>
</li>
	
<? 
	} //verificamos permisos para administracion de archivos.
	
	if($FilePermision[0][ver] == 1){ ///aqui verificamos el permiso para solo ver los archivos.?>

<li>
 <a href="modules/gestion/filevewer.php?Idcamania=<?=$varcam?>&IdIdent=<?=$IdentID?>">
 Ver Documentacion Relacionada
 </a>
</li>

<? }//aqui verificamos el permiso para solo ver los archivos.

} //aqui verificamos permisos para lor archivos ?>

<li>
 <a href="modules/gestion/regs_history.php?Idcamania=<?=$varcam?>&IdIdent=<?=$IdentID?>&FormMode=<?=$FormMode?>&idforma=<?=$seleccforms[$i]["id_autoformtablas"]?>">
 Historiales
 </a>
</li>


	</ul>


</div>

</div><!-- End demo -->	</td>
  </tr>
</table>

<? } //llama los tabs 

if($_GET[op]==2){ //mostramos el formulario
include '../../appcfg/general_config.php';

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";

$JsScripts->ValFormScripts();

if($_GET[FormMode] == 1){ 

$TableProp = $sqlm->sql_select("autoform_tablas","*","id_autoformtablas = $_GET[idforma]",0);

$compruebaid = $sqlm->sql_select($TableProp[0][nombretabla],$TableProp[0][campoid],$TableProp[0][campoid]." = '$_GET[IdIdent]'",0);

	if(!is_array($compruebaid)){
		
	//echo "NO ESTA: IdReg $IdIdent aquio estamos: ".$TableProp[0][nombretabla];
	$guarda = $sqlm->inser_data($TableProp[0][nombretabla],$TableProp[0][campoid],"'$_GET[IdIdent]'",0);
	
	}else{
		
	//echo "SI ESTA: IdReg $IdIdent aquio estamos: ".$TableProp[0][nombretabla];

	}
	

 }

$argArray=array(
	"idUser"=>$_SESSION["user_ID"],
	"idReg"=>$_GET[IdIdent],
	"idCam"=>$_GET[Idcamania]);

?> 

<?=$formulario_auto->generar_form_ins($_GET[idforma],2,0,"",0,0,$_GET[FormMode],1,$argArray,$_SESSION["group_ID"]);?> 

<?

	$CompModList = $sqlm->sql_select("comp_form_rel,comp_modules","*","idform = $_GET[idforma] AND id_compmod = idcompmod AND id_grupo = '".$_SESSION["group_ID"]."'",0);

	if(is_array($CompModList)){//if que comprueba que existan medulos.
	for($i=0 ; $i < count($CompModList) ; $i++ ){
		
	
	if($CompModList[$i][tipod] == 1)	{//aqui verificamos como se va a mostar
	
	echo "<div class='rounded-corners-blanco'><div class='textosbigRes'>".$CompModList[$i][textlink]."</div><iframe width='100%' frameborder='0' scrolling='auto' height='".$CompModList[$i][altoiframe]."px' src='".$CompModList[$i][rutamod]."?idreg=$_GET[IdIdent]&idcam=$_GET[Idcamania]'></iframe></div>";
		
	}//aqui verificamos como se va a mostar
	else{
	genera_modalF("FormAgenda",1000,600);
	echo "<div class='rounded-corners-orange'><a class='textosbigRes FormAgenda' href='".$CompModList[$i][rutamod]."?idreg=$_GET[IdIdent]&idcam=$_GET[Idcamania]'>".$CompModList[$i][textlink]."</a></div>";
	
	}//aqui verificamos como se va a mostar
	
	
	} }//if que comprueba que existan medulos.

 } //mostramos el formulario ?>