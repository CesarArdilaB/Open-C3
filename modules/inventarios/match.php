<?
if($_GET[op] != 1 and $_GET[op] != 2){

@include("../../appcfg/general_config.php");
@include("appcfg/class_agenda.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();
$agendac = new Agenda();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center">
  <h3>Hacer Match de Inventarios</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" onsubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/inventarios/match.php?op=2',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Seleccione una Campaña</td>
        <td class="textos_titulos"><span class="textos_negros">
          <? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"id_campaign IN (SELECT idcampana FROM inv_camconfig) ");
	echo $formulario->c_select("","idcampana","","",":required",$parametrosGrupoHerr,0,"","MuestraCampos"); ?>
        </span></td>
        <td class="textos_titulos">Escriba Un Lote</td>
        <td class="textos_titulos">
		<? 
	$parametrosGrupoHerr=array(
	"tabla"=>"inv_inventario",
	"campo1"=>"lote",
	"campo2"=>"lote",
	"campoid"=>"lote",
	"condiorden"=>"1 GROUP BY lote");
		
		echo $formulario->c_Auto_select("","lote","","","",$parametrosGrupoHerr,1,"Lote: ","",0,15); ?>&nbsp;</td>
        <td class="textos_titulos"><span class="textosbig">
          <input type="submit" name="subir" id="subir" value="Verificar" />
        </span></td>
      </tr>
      <tr class="textos_titulos">
        <td colspan="5" align="center" class="textos_titulos"><span class="textos">Escriba un lote para verificar si esta completo.</span></td>
      </tr>
    </table>
  </form>
</div>
<br />
<div id="PersInf"></div>

<? } if($_GET[op] == 1){ 

include("../../appcfg/general_config.php");

if($_GET[lote_hidden] == ""){
	
	echo "SELECCIONE UN LOTE!!!!!";
	exit;
	
	}



$varcam = $_GET[idcampana];
$ConfigInventory = $sqlm->sql_select("inv_camconfig","*","idcampana = '$_GET[idcampana]'",0);
$ConfigIAgenda = $sqlm->sql_select("agenda_camconfig","*","idcampana = '$_GET[idcampana]'",0);

$camAtrib=$sqlm->sql_select("autoform_tablas","*","tipotabla = 1 AND campaignid = $varcam",0);
$TablaCam = $camAtrib[0][nombretabla];
$CampoId= $camAtrib[0][campoid];



$PseudosNoInv = $sqlm->sql_select("$TablaCam","".$ConfigInventory[0][cpseudocodigo].",".$ConfigIAgenda[0][cedulac].",".$ConfigIAgenda[0][nombrec].",$CampoId","$CampoId NOT IN (SELECT idregistro FROM inv_inventario WHERE idcampana = $_GET[idcampana])",0);

if(is_array($PseudosNoInv)){
excelexp("TablaPseudos");
?>

<div align="center">
  <table width="0" border="0" cellpadding="0" id="TablaPseudos" cellspacing="0" class="rounded-corners-blue">
    <tr>
      <td colspan="3" align="center" class="textos_titulos"> Total:
<?=count($PseudosNoInv)?>
      &nbsp;</td>
    </tr>    
    <tr>
      <td align="center"><p><strong> CODIGO TARJETA </strong></p></td>
      <td align="center" class="textos_titulos">Cedula</td>
      <td align="center" class="textos_titulos">Nombre</td>
    </tr>
  <? for($i = 0 ;$i < count($PseudosNoInv) ; $i++) { ?>

    <tr>
      <td align="center" class="textos"><a href="/openc3/?sec=gestion&mod=agent_console&regediting=<?=$PseudosNoInv[$i][$CampoId]?>&camediting=<?=$varcam?>">
	  							<?=$PseudosNoInv[$i][$ConfigInventory[0][cpseudocodigo]]?>
      </a></td>
      <td align="center" class="textos"><?=$PseudosNoInv[$i][$ConfigIAgenda[0][cedulac]]?></td>
      <td align="center" class="textos"><?=$PseudosNoInv[$i][$ConfigIAgenda[0][nombrec]]?></td>
    </tr>

  <? } ?>    
  </table>
</div>

<? } /*aqui verificamos que sea un array el resultado*/	} //termina la opcion uno que es la que muestra los inventarios disponibles 
	elseif($_GET[op] == 2){ 
include("../../appcfg/general_config.php");

if($_GET[lote_hidden] == ""){
	
	echo "SELECCIONE UN LOTE!!!!!";
	exit;
	
	}



$ConfigInventory = $sqlm->sql_select("inv_camconfig","*","idcampana = '$_GET[idcampana]'",0);
$ConfigIAgenda = $sqlm->sql_select("agenda_camconfig","*","idcampana = '$_GET[idcampana]'",0);

$varcam = $_GET[idcampana];
$camAtrib=$sqlm->sql_select("autoform_tablas","*","tipotabla = 1 AND campaignid = $varcam ",0);
$TablaCam = $camAtrib[0][nombretabla];
$CampoId = $camAtrib[0][campoid];


//------------------------------------------
//aqui hacemos match para los que pistolean antes de tener la base.
$PseudosNoBasee = $sqlm->sql_select("inv_inventario","*","lote = '$_GET[lote_hidden]' AND matchf = 0 AND idregistro = 0 AND idcampana = $varcam",0);

if(is_array($PseudosNoBasee)){
	
for($i=0 ; $i < count($PseudosNoBasee) ; $i++ ){

$PseudosBasee = $sqlm->sql_select($TablaCam,"*","".$ConfigInventory[0][cpseudocodigo]." = '".$PseudosNoBasee[$i][scodigo]."'",0);	

if(is_array($PseudosBasee)){

$SelectInvACT =	$sqlm->sql_select("inv_inventario","*","scodigo = '".$PseudosBasee[0][$ConfigInventory[0][cpseudocodigo]]."'",0);

$guardaInventarioHis 	= $sqlm->inser_data("inv_historial","idregistro,idbodega_his,idagente_his,idestado_his,idcampana","'".$PseudosBasee[0][autof_matrizprincipal_1_id]."',".$SelectInvACT[0][idbodega].",".$SelectInvACT[0][idagente].",".$SelectInvACT[0][idestado].",".$SelectInvACT[0][idcampana]."",0);

$actualizaInv 		=	$sqlm->update_regs("inv_inventario","matchf = 1, idregistro = '".$PseudosBasee[0][$CampoId]."'","scodigo = '".$PseudosBasee[0][$ConfigInventory[0][cpseudocodigo]]."'",0);



$actualizaMatriz 	=	$sqlm->update_regs($TablaCam,"".$ConfigInventory[0][cbolsain]." = '".$SelectInvACT[0][bolsa]."', ".$ConfigInventory[0][cguiain]." = '".$SelectInvACT[0][guia]."', ".$ConfigInventory[0][cbolsaout]." = '".$SelectInvACT[0][bolsaout]."' , ".$ConfigInventory[0][clote]." = '".$_GET[lote_hidden]."' ","$CampoId = '".$PseudosBasee[0][$CampoId]."'",0);


}

	
	} 
}

//aqui hacemos match para los que pistolean antes de tener la base.
//------------------------------------------



$PseudosNoMatchBase = $sqlm->sql_select("inv_inventario","scodigo","matchf = 0 AND lote = '$_GET[lote_hidden]' AND idcampana = $varcam ORDER BY id_inventario ASC",0);


$PseudosNoMatchInv = $sqlm->sql_select("$TablaCam","".$ConfigInventory[0][cpseudocodigo].",".$ConfigIAgenda[0][cedulac].",".$ConfigIAgenda[0][nombrec].",$CampoId","".$ConfigInventory[0][clote]." = '$_GET[lote_hidden]' AND $CampoId NOT IN (SELECT idregistro FROM inv_inventario WHERE idcampana = $varcam)",0);

$PseudosSiMatch = $sqlm->sql_select("inv_inventario,$TablaCam","".$ConfigInventory[0][cpseudocodigo].",".$ConfigIAgenda[0][cedulac].",".$ConfigIAgenda[0][nombrec].",idregistro","idregistro = $CampoId AND matchf = 1 AND lote = '$_GET[lote_hidden]' AND lote = ".$ConfigInventory[0][clote]." ORDER BY id_inventario ASC",0);

excelexp("TablaPseudos");
?>

<div align="center">
  <table id="TablaPseudos" width="0" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="3" align="center" class="textos_titulos">Resultados para el lote: <?=$_GET[lote_hidden]?></td>
    </tr>
    <tr>
      <td align="left" valign="top">
      <? if(is_array($PseudosNoMatchBase)){ ?>
      <table width="0" border="0" cellpadding="0" id="TablaPseudos2" cellspacing="2" class="rounded-corners-blue">
        <tr>
          <td class="textos_titulos"><strong> CODIGOS TARJETA </strong> que no esta en la base Total:
            <?=count($PseudosNoMatchBase)?>
            &nbsp;</td>
        </tr>        
        <tr>
          <td align="center" class="textos_negros"><strong>CODIGOS TARJETA</strong></td>
          </tr>

        <? for($i = 0 ;$i < count($PseudosNoMatchBase) ; $i++) { ?>
        <tr>
          <td align="center" bgcolor="#FFFFFF"><?=$PseudosNoMatchBase[$i][scodigo]?></td>
          </tr>
        <? } ?>
      </table><? } ?>
      
      </td>
      <td align="left" valign="top"><? if(is_array($PseudosNoMatchInv)){ ?>
        <table width="0" border="0" cellpadding="0" id="TablaPseudos4" cellspacing="2" class="rounded-corners-blue">
          <tr>
            <td colspan="3" class="textos_titulos"><strong>CODIGOS TARJETA</strong> que no esta en Inventario:
              <?=count($PseudosNoMatchInv)?>
              &nbsp;</td>
          </tr>
          <tr>
            <td align="center" class="textos_negros"><strong>CODIGOS TARJETA</strong></td>
            <td align="center" class="textos_negros">Cedula</td>
            <td align="center" class="textos_negros">Nombre</td>
          </tr>
          <? for($i = 0 ;$i < count($PseudosNoMatchInv) ; $i++) { ?>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><a class="Links<?=$i?>" href="/openc3/?sec=gestion&amp;mod=agent_console&amp;regediting=<?=$PseudosNoMatchInv[$i][autof_matrizprincipal_1_id]?>&amp;camediting=<?=$varcam?>">
              <?=$PseudosNoMatchInv[$i][$ConfigInventory[0][cpseudocodigo]]?>
            </a></td>
            <td align="center" bgcolor="#FFFFFF"><span class="textos">
              <?=$PseudosNoMatchInv[$i][$ConfigIAgenda[0][cedulac]]?>
            </span></td>
            <td align="center" bgcolor="#FFFFFF"><span class="textos">
              <?=$PseudosNoMatchInv[$i][$ConfigIAgenda[0][nombrec]]?>
            </span></td>
          </tr>
          <? } ?>
        </table>
      <? } ?></td>
      <td align="left" valign="top"><? if(is_array($PseudosSiMatch)){ ?>
        <table width="0" border="0" cellpadding="0" id="TablaPseudos3" cellspacing="2" class="rounded-corners-blue">
          <tr>
            <td colspan="3" class="textos_titulos"><strong>CODIGOS TARJETA</strong> en match Total:
              <?=count($PseudosSiMatch)?>
              &nbsp;</td>
          </tr>
          <tr>
            <td align="center" class="textos_negros"><strong>CODIGOS TARJETA</strong></td>
            <td align="center" class="textos_negros">Cedula</td>
            <td align="center" class="textos_negros">Nombre</td>
          </tr>
          <? for($i = 0 ;$i < count($PseudosSiMatch) ; $i++) { ?>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><a href="/openc3/?sec=gestion&mod=agent_console&regediting=<?=$PseudosSiMatch[$i][idregistro]?>&camediting=<?=$varcam?>" class="textos">
              <?=$PseudosSiMatch[$i][$ConfigInventory[0][cpseudocodigo]]?>
            </a></td>
            <td align="center" bgcolor="#FFFFFF"><span class="textos">
              <?=$PseudosSiMatch[$i][$ConfigIAgenda[0][cedulac]]?>
            </span></td>
            <td align="center" bgcolor="#FFFFFF"><span class="textos">
              <?=$PseudosSiMatch[$i][$ConfigIAgenda[0][nombrec]]?>
            </span></td>
          </tr>
          <? } ?>
        </table>
      <? } ?></td>
    </tr>
  </table>
</div>

<? }//Aqui termina la opcion 2 que es la que saca los que estan inventariados pero no tienen match
?>
