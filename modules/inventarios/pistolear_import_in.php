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
  <form action="" method="post" enctype="multipart/form-data" name="form1" id="formaPisto" onsubmit="foco();return false;">
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
        <td colspan="4" align="center" class="textos_negros"><label for="fileField">Buscar Archivo:</label>
        <input type="file" name="fileField" id="fileField"></td>
      </tr>
      <tr>
        <td colspan="4" align="center" class="textos_negros"><p>El Archivo debe ser delimitado por comas y llevar los campos en este orde:<br>
          Codigo Sobre (si esta vacio enviar en 0), Codigo Tarjeta
        </p></td>
      </tr>
      <tr>
        <td colspan="4" align="center" class="textos_negros"><input name="ok" type="submit" id="ok" form="formaPisto" value="Importar" /></td>
      </tr>
    </table>
  </form>
</div>


<hr>

<div id="InsertaCuenta">
<? }//---------------------------

if($_POST[ok]){ //-------------------------

//if($inc != 1){ include("appcfg/general_config.php"); }

//print_r($_POST);
//print_r($_FILES);

$copiar=copy($_FILES[fileField][tmp_name],"tmp/files/".$_FILES[fileField][name])or die("No esta copiando verifique permisos"); //copiamos el archivo csv y lo dejamos pendiente para eliminarlo despues de subir la data
				
				$filedb = fopen("tmp/files/".$_FILES[fileField][name],"r");
	

//**************************************

		while ($data = fgetcsv ($filedb,10000,";")) { //while que reviza el archivo
    		$num = count ($data);
			
			$i++;

			//echo "<br> $data[0] - $data[1]";

//Array ( [idcampana] => 1 [idbodega] => 1 [idestado] => 1 [lote] => 1 [guia] => 1 [bolsa] => 1 [tiempomax] => 1 [ok] => Importar ) Array ( [fileField] => Array ( [name] => CODIGO.csv [type] => text/comma-separated-values [tmp_name] => /tmp/phpiSXqfy [error] => 0 [size] => 2195 ) ) 

if(is_numeric($data[0]) and is_numeric($data[1])){

$sqlm->ins_regs("inv_inventario","ok","idcampana,idbodega,idestado,scodigo,bolsa,lote","'$_POST[idcampana]','$_POST[idbodega]','$_POST[idestado]','$data[1]','$data[0]','$_POST[lote]'",0);

}

				
				}//while que reviza el archivo

	echo "$i Registros importados";

//**************************************

	
				unlink("/tmp/files/".$_FILES[fileField][name]);

 } ?>
</div>
</div>