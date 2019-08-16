<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2){


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
  <form name="form1" onsubmit="foco();return false;" id="formaPisto">
    <table width="0" border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
      <tr>
        <td colspan="4" align="center" class="textos_titulos">Pistolear Nuevo Lote Para Ingreso</td>
      </tr>
      <tr>
        <td colspan="2" align="right" class="textos_negros">Campaña:        </td>
        <td colspan="2" align="left" class="textos_negros"><? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"id_campaign IN (SELECT idcampana FROM inv_camconfig) ");
	echo $formulario->c_select("","idcampana","","",":required",$parametrosGrupoHerr,0,"","MuestraCampos"); ?></td>
      </tr>
      <tr>
        <td class="textos_negros">Bodega</td>
        <td><?
	$parametrosGrupo=array(
	"tabla"=>"inv_bodegas",
	"campo1"=>"id_bodegas ",
	"campo2"=>"nombre",
	"campoid"=>"id_bodegas",
	"condiorden"=>"1");		 
	echo Generar_Formulario::c_select("","idbodega","","",":required",$parametrosGrupo,0,0);?>
        &nbsp;</td>
        <td class="textos_negros">Estado</td>
        <td><?
	$parametrosGrupo=array(
	"tabla"=>"inv_estado",
	"campo1"=>"id_estado",
	"campo2"=>"estado",
	"campoid"=>"id_estado",
	"condiorden"=>"1");		 
	echo Generar_Formulario::c_select("","idestado","","",":required",$parametrosGrupo,0,0);?>
        &nbsp;</td>
      </tr>
      <tr>
        <td class="textos_negros">Lote</td>
        <td align="left">
        <input name="lote" type="text" id="lote" class=":required" size="5">&nbsp;</td>
        <td class="textos_negros">Numero De Guia</td>
        <td><input name="guia" type="text" id="guia" class=":required" size="5"></td>
      </tr>
      <tr>
        <td align="left" class="textos_negros"><script>
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
		EnviarLinkForm('InsertaCuenta','<?=$RAIZHTTP?>/modules/inventarios/pistolear_in.php?op=2',Formulario);
		$('#pseudocodigo').attr('value','');

		 								}

		
		if	(bolsaso.value == "2")	{
		
        $('#bolsaout').attr('readonly', true);
		$('#pseudocodigo').focus();
		EnviarLinkForm('InsertaCuenta','<?=$RAIZHTTP?>/modules/inventarios/pistolear_in.php?op=2',Formulario);
		$('#pseudocodigo').attr('value','');

					
									}

		if	(bolsaso.value == "0" && bolsasoV.value == "")	{
		
		$('#bolsaout').focus();
			
									}


		if	(bolsaso.value == "0" && bolsasoV.value != "")	{
		
		$('#pseudocodigo').focus();
					
									}

		if	(bolsaso.value == "0" && bolsasoV.value != "" && Scode.value != ""){
			
		EnviarLinkForm('InsertaCuenta','<?=$RAIZHTTP?>/modules/inventarios/pistolear_in.php?op=2',Formulario);
		$('#pseudocodigo').attr('value','');
		$('#bolsaout').attr('value','');
		$('#bolsaout').focus();
		
			
			}
		

			}
			
		//esta funcion desactiva la bolsa de seguridad	
		function DesactivaBolsa(){
		
        $('#bolsaout').attr('readonly', true);
		$('#bolsaout').attr('value','');
		$('#ControlBolsa').attr('value','1');
			
			}

		//esta funcion activa la bolsa de seguridad	
		function ActivaBolsa(){
		
        $('#bolsaout').attr('readonly', false);
		$('#ControlBolsa').attr('value','2');
			
			}

		//en esta funcion mandamos uno a uno la bolsa
		
		function unoAuno(){

        $('#bolsaout').attr('readonly', false);
		$('#ControlBolsa').attr('value','0');
			
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
Bolsa de Seguridad</td>
        <td align="left"><input name="bolsa" type="text" id="bolsa" class=":required" size="5" /></td>
        <td align="left" class="textos_negros">Dias de entrega</td>
        <td align="left" class="textos_negros"><input name="tiempomax" class=":required" type="text" id="tiempomax" size="5" /></td>
      </tr>
      <tr>
        <td colspan="4" align="center" class="textos_negros"><input type="button" name="button" id="button" onmouseup="MostrarOcultar('GuardarPseudo',1);SoloLectura()" value="Comenzar Pistoleo" /></td>
      </tr>
      <tr>
        <td colspan="4" align="center" valign="middle">
        <div align="center" class="textos_negros" id="GuardarPseudo" <? echo "style='display:none'"; ?>>
          <table width="0" border="0" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
              <tr>
                <td rowspan="2" bgcolor="#FFFFFF"> CODIGO SOBRE: 
                <input name="bolsaout" type="text" id="bolsaout" size="10" /></td>
                  <td bgcolor="#FFFFFF">Uno a uno</td>
                  <td bgcolor="#FFFFFF"><input name="bolsaProp" type="radio" id="radio3" onclick="unoAuno()" value="1" checked="checked" /></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF">Omitir campo
                <input name="ControlBolsa" type="hidden" id="ControlBolsa" value="0" /></td>
                <td bgcolor="#FFFFFF"><input type="radio" name="bolsaProp" onclick="DesactivaBolsa()" id="radio2" value="2" /></td>
              </tr>
            <tr>
              <td colspan="3"><p> CODIGO TARJETA
                :
                <input type="text" name="pseudocodigo" id="pseudocodigo" />
                <input type="submit" name="Guardar" id="Guardar" value="Guardar" />
              </p></td>
            </tr>
            <tr>
              <td colspan="3" align="center"><input type="button" onclick="MostrarOcultar('GuardarPseudo',0);NormalLectura();focolote()" name="otro" id="otro" value="Terminar Pistoleo" /></td>
            </tr>
        </table>
        </div></td>
      </tr>
    </table>
  </form>
</div>


<hr>

<div id="InsertaCuenta">
<? }//---------------------------

if($_GET[op] == 2){ //-------------------------

if($inc != 1){ include("../../appcfg/general_config.php"); }

if($_GET[pseudocodigo] == ""){ ?>
	
  <div align="center" class="rounded-corners-ALERTA"><span class="textosbigBlanco">Escriba Un <strong>CODIGO TARJETA</strong></span></div>  
	
<?	exit; }

//este es el que derifica que existe el Pseudocudigo

$ConfigInventory = $sqlm->sql_select("inv_camconfig","*","idcampana = '$_GET[idcampana]'",0);


$varcam = $_GET[idcampana];

//------------------------- vemos la config de la tabla y de los parametros

$camAtrib=$sqlm->sql_select("autoform_tablas","*","tipotabla = 1 AND campaignid = $varcam",0);

$tablaINS = $camAtrib[0][nombretabla];

$PseudoVerif=$sqlm->sql_select($tablaINS,"*",$ConfigInventory[0][cpseudocodigo]." = '$_GET[pseudocodigo]'",0);

//------------------------- vemos la config de la tabla y de los parametros


//------------------------- vemos la config de la tabla y de los parametros

if(is_array($PseudoVerif)){ //aqui sin existe lo actualiza y lo visa como en invitario y con match
	

$camposARR[$ConfigInventory[0][cpseudocodigo]] = "$_GET[pseudocodigo]";

//------------ aqui verificamos si el pseudocodigo ya esta en el inventario

$PseudoExiste=$sqlm->sql_select("inv_inventario","*","scodigo = '$_GET[pseudocodigo]' AND idcampana = '$_GET[idcampana]'",0);
if(is_array($PseudoExiste)){ 
?>

<div align="center" class="textosbig">Este <strong>CODIGO TARJETA</strong> ya existe en el inventario</div>


<?
exit; }

//------------ aqui verificamos si el pseudocodigo ya esta en el inventario
$IdentUlt 						= $PseudoVerif[0][$camAtrib[0][campoid]];
$camposARR[$tablaINS."_id"] 	.= $PseudoVerif[0][$camAtrib[0][campoid]];
$historialARR[id_reg] 			= $PseudoVerif[0][$camAtrib[0][campoid]];
$historialARR[id_usuario]		= $_SESSION["user_ID"];
$historialARR[fechahora] 		= "$fecha_act $hora_act";
$historialARR[accion] 			= "Registro Creado por Pistoleo";

$guardarhostorial 	 	= $sqlm->insert_recs_auto("history_".$varcam,$historialARR,"",0);	

		
$guardaGiaBolsa 		= $sqlm->update_regs($tablaINS,"".$ConfigInventory[0][clote]." = '$_GET[lote]' ,".$ConfigInventory[0][cguiain]." = '$_GET[guia]' ,".$ConfigInventory[0][cguiain]." = '$_GET[bolsa]' ,".$ConfigInventory[0][cbolsaout]." = '$_GET[bolsaout]'","".$tablaINS."_id = '".$PseudoVerif[0][$camAtrib[0][campoid]]."'",0);


$guardaInventario 	 	= $sqlm->inser_data("inv_inventario","idregistro,idbodega,idagente,idestado,lote,matchf,scodigo,bolsa,guia,tiempomax,idcampana,bolsaout","$IdentUlt,$_GET[idbodega],".$_SESSION["user_ID"].",$_GET[idestado],'$_GET[lote]',1,'$_GET[pseudocodigo]','$_GET[bolsa]','$_GET[guia]','$_GET[tiempomax]','$_GET[idcampana]','$_GET[bolsaout]'",0);


$guardaInventarioHis 	= $sqlm->inser_data("inv_historial","idregistro,idbodega_his,idagente_his,idestado_his,idcampana","$IdentUlt,$_GET[idbodega],".$_SESSION["user_ID"].",$_GET[idestado],'$_GET[idcampana]'",0);



	
	}else{ //este es si el PseudoCodigo No esta En La Base De datos
		

/*$IdentUlt = $sqlm->ultimoid($varcam);

$camAtrib=$sqlm->sql_select("autoform_tablas","*","tipotabla = 1 AND campaignid = $varcam",0);

$tablaINS = $camAtrib[0][nombretabla];

//----------------llenamos los campos de la tabla matriz pendiente numero de guia

$camposARR[af13_41] 	= 	"$pseudocodigo";
$camposARR[af13_117] 	= 	"$guia";
$camposARR[af13_135] 	= 	"$bolsa";

//--------------------------------------

$camposARR[$tablaINS."_id"] .= $IdentUlt;
$historialARR[id_reg] 		= $IdentUlt;
$historialARR[id_usuario] 	= $_SESSION["user_ID"];
$historialARR[fechahora] 	= "$fecha_act $hora_act";
$historialARR[accion] 		= "Registro Creado por Pistoleo";


esto se comento porque ahora inserta el pseudocodigo en la base de datos.


$guardarhostorial 	 = 	$sqlm->insert_recs_auto("history_".$varcam,$historialARR,"",0);			
$guardar 			 =	$sqlm->insert_recs_auto($tablaINS,$camposARR,"",0);
$actualizaIdent		 =	$sqlm->update_regs("ident_".$varcam,"estado = 1, agente='".$_SESSION["user_ID"]."',fechahorac = '$fecha_act $hora_act'","id_ident_".$varcam." = ".$IdentUlt,0);
*/
$PseudoExiste=$sqlm->sql_select("inv_inventario","*","scodigo = '$_GET[pseudocodigo]'",0);
if(is_array($PseudoExiste)){ 

?>
<div align="center" class="textosbig">Este <strong>CODIGO TARJETA</strong> ya existe en el inventario</div>

<?

exit; }



$guardaInventario 	 = 	$sqlm->inser_data("inv_inventario","idbodega,idagente,idestado,lote,guia,bolsa,scodigo,tiempomax,idcampana,bolsaout","$_GET[idbodega],".$_SESSION["user_ID"].",$_GET[idestado],'$_GET[lote]','$_GET[guia]','$_GET[bolsa]','$_GET[pseudocodigo]','$_GET[tiempomax]','$_GET[idcampana]','$_GET[bolsaout]'",0);

//$guardaInventarioHis = 	$sqlm->inser_data("inv_historial","idregistro,idbodega_his,idagente_his,fechah_his,idestado_his","$IdentUlt,$idbodega,".$_SESSION["user_ID"].",'$fecha_act $hora_act',$idestado",0);

}//--------------------------------------------------------

$CuentaInvLote 		 = 	$sqlm->sql_select("inv_inventario","COUNT(id_inventario)as cuenta","lote = '$_GET[lote]' AND idcampana = '$_GET[idcampana]'",0);

?>
<br><br>
<div align="center" class="textosbig">Numero de plasticos pistoleados en el lote <?=$_GET[lote]?>: <?=$CuentaInvLote[0][cuenta]?> </div>

<? } ?>
</div>
</div>