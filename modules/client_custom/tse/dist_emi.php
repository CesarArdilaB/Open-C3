<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[op] != 7){

?>
<link rel="stylesheet" type="text/css" href="../../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../../css/estilos.css"/>

<div align="center">
  <h3>Informes Emision y Distribucion</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/client_custom/tse/dist_emi.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Inicial: <br></td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_ini","","")?>
          &nbsp;</td>
        <td class="textos_titulos">Fecha Final: </td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_fin","","")?>
        &nbsp;</td>
        <td class="textos_titulos"><span class="textosbig">
          <input type="submit" name="button" id="button" value="Generar">
        </span></td>
      </tr>
    </table>
  </form>
</div>
<br />
<div id="PersInf"></div>
<? 
}//este es el que saca si no ahy ninguna opcion
if($_GET[op] == 1){ // aqui termina la opcion 1
include '../../../appcfg/general_config.php';

$SelectDATA=$sqlm->sql_select("autof_matrizprincipal_1","*","DATE(af13_34) BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]'",0);

//echo $fecha_act." ***";

if(is_array($SelectDATA)){

excelexp("informe");

genera_modalF("DescarInf".$i,400,400); 

?>


<table id="informe" width="100%" border="0" cellpadding="3" cellspacing="1" class="rounded-corners-blue">
  <tr>
    <td colspan="30" align="left" class="textos_titulos"><a href="modules/client_custom/tse/dist_emi_csv.php?fechai=<?=$_GET[fecha_ini]?>&fechaf=<?=$_GET[fecha_fin]?>" class="textos_titulos DescarInf">Descargar CSV</a></td>
  </tr>
  <tr>
    <td align="center" class="textos_titulos">Mes Fisico</td>
    <td align="center" class="textos_titulos">Fecha Fisico TSE</td>
    <td align="center" class="textos_titulos">Campaña</td>
    <td align="center" class="textos_titulos">Estado Custodia</td>
    <td align="center" class="textos_titulos">Identificacion Cliente</td>
    <td align="center" class="textos_titulos">SEUDOCODIGO</td>
    <td align="center" class="textos_titulos">Nombre Cliente</td>
    <td align="center" class="textos_titulos">Activacion</td>
    <td align="center" class="textos_titulos">Fecha de Activacion</td>
    <td align="center" class="textos_titulos">Fecha de Entrega / Envio</td>
    <td align="center" class="textos_titulos">DATOS TERCERO AUTORIZADO</td>
    <td align="center" class="textos_titulos">Tipo de Entrega</td>
    <td align="center" class="textos_titulos">Nombre Asesor Call Center</td>
    <td align="center" class="textos_titulos">Gestion Realizada Call</td>
    <td align="center" class="textos_titulos">Fecha de Gestion Call Center</td>
    <td align="center" class="textos_titulos">Ciudad Base</td>
    <td align="center" class="textos_titulos">Direccion Cita</td>
    <td align="center" class="textos_titulos">Cupo</td>
    <td align="center" class="textos_titulos">Nombre Base</td>
    <td align="center" class="textos_titulos">Bodega</td>
    <td align="center" class="textos_titulos">Gestion Mesa</td>
    <td align="center" class="textos_titulos">Punto de Venta</td>
    <td align="center" class="textos_titulos">Fecha Entrega Cliente</td>
    <td align="center" class="textos_titulos">Feedback manifiesto</td>
    <td align="center" class="textos_titulos">FECHA BANCO BASE AGENDAMIENTO</td>
    <td align="center" class="textos_titulos">FECHA RECEPCION BASE TSE</td>
    <td align="center" class="textos_titulos">Tipo de entrega inicial</td>
    <td align="center" class="textos_titulos"># Bolsa seguridad de salida</td>
    <td align="center" class="textos_titulos">Código de dirección</td>
    <td align="center" class="textos_titulos">Id Registro</td>
  </tr>
<? for($i=0;$i < count($SelectDATA);$i++){ 

$CustodiuaDATA = $sqlm->sql_select("inv_inventario,inv_estado","estado,fechasalida,idbodega","idregistro ='".$SelectDATA[$i][autof_matrizprincipal_1_id]."' AND idestado = id_estado",0);

if(is_array($CustodiuaDATA)){
$BodegaNombre = $sqlm->sql_select("inv_bodegas","nombre","id_bodegas ='".$CustodiuaDATA[0][idbodega]."'",0);
}
if(is_array($BodegaNombre)){$BodegaTxt = $BodegaNombre[0][nombre];}else{$BodegaTxt = "";}

$campanaDATA= $sqlm->sql_select("autof_af13_38","field1","id_af13_38 ='".$SelectDATA[$i][af13_38]."'",0);
if(is_array($campanaDATA)){	$campanaTEXT = $campanaDATA[0][field1];	}else{ $campanaTEXT = ""; }

$activacionDATA = $sqlm->sql_select("autof_af13_126","field1","id_af13_126 ='".$SelectDATA[$i][af13_126]."'",0);
if(is_array($activacionDATA)){$actData = $activacionDATA[0][field1];	}else{ $actData = ""; }

$tipoentDATA = $sqlm->sql_select("autof_af13_155","field1","id_af13_155 ='".$SelectDATA[$i][af13_155]."'",0);
if(is_array($tipoentDATA)){$entData = $tipoentDATA[0][field1];	}else{ $entData = ""; }

$gescallDATA = $sqlm->sql_select("autof_af13_109","field1","id_af13_109 ='".$SelectDATA[$i][af13_109]."'",0);
if(is_array($gescallDATA)){$gescallText = $gescallDATA[0][field1];	}else{ $gescallText = ""; }


$gmesaDATA = $sqlm->sql_select("autof_af13_100","field1","id_af13_100 ='".$SelectDATA[$i][af13_100]."'",0);
if(is_array($gmesaDATA)){$gmesaText = $gmesaDATA[0][field1];	}else{ $gmesaText = ""; }


$pventaDATA = $sqlm->sql_select("autof_af13_92","field1","id_af13_92 ='".$SelectDATA[$i][af13_92]."'",0);
if(is_array($pventaDATA)){$pventaText = $pventaDATA[0][field1];	}else{ $pventaText = ""; }

$CiudadData = $sqlm->sql_select("autof_af13_37","field1","id_af13_37 ='".$SelectDATA[$i][af13_37]."'",0);
if(is_array($CiudadData)){$CiudadBText = $CiudadData[0][field1];	}else{ $CiudadBText = ""; }


if(is_array($CustodiuaDATA)){
	
	$estadoINV = $CustodiuaDATA[0][estado]; 
	$fechaSalidaINV = $CustodiuaDATA[0][fechasalida]; 
	
	}else {
		
	$estadoINV = "";
	$fechaSalidaINV = ""; 
	
	} 

$OperadorDATA = $sqlm->sql_select("agents,history_1","name","id_reg = '".$SelectDATA[$i][autof_matrizprincipal_1_id]."' AND id_agents = id_usuario AND tipo = 0 ORDER BY id_history_1 DESC LIMIT 0,1",0);


if(is_array($OperadorDATA)){$operadorText = $OperadorDATA[0][name];}else{ $operadorText = ""; }


//nuevos campos de soporte adicionados el 13 de diciembre

$AgendaFeed = $sqlm->sql_select("agenda","feedback","idregistro = '".$SelectDATA[$i][autof_matrizprincipal_1_id]."' ORDER BY id_agenda DESC",0);

if(is_array($AgendaFeed)){

$AgendaFeedDATA = $sqlm->sql_select("agenda_estados","estado","id_estado = '".$AgendaFeed[0][feedback]."'",0);
if(is_array($AgendaFeedDATA)){ $FeedBACKT = $AgendaFeedDATA[0][estado]; }else{ $FeedBACKT = ""; }


}else{ $FeedBACKT = ""; }



//*****

$tentregadataDATA = $sqlm->sql_select("autof_af13_795","field1","id_af13_795 ='".$SelectDATA[$i][af13_795]."'",0);
if(is_array($tentregadataDATA)){$tentregaText = $tentregadataDATA[0][field1];	}else{ $tentregaText = ""; }



$dircodDATA = $sqlm->sql_select("autof_af13_796","field1","id_af13_796 ='".$SelectDATA[$i][af13_796]."'",0);
if(is_array($dircodDATA)){$coddirText = $dircodDATA[0][field1];	}else{ $coddirText = ""; }




?>
  <tr>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_33]?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_34]?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$campanaTEXT?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$estadoINV?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_39]?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_41]?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_40]?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$actData?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_128]?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$fechaSalidaINV?>&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_794]?></td>
    <td bgcolor="#FFFFFF"><?=$entData?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$operadorText?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$gescallText?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=substr($SelectDATA[$i][af13_34],0,10)?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$CiudadBText?></td>
    <td bgcolor="#FFFFFF"><?=utf8_encode($SelectDATA[$i][af13_145])?></td>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_42]?></td>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_171]?></td>
    <td bgcolor="#FFFFFF"><?=$BodegaTxt?></td>
    <td bgcolor="#FFFFFF"><?=$gmesaText?></td>
    <td bgcolor="#FFFFFF"><?=$pventaText?></td>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_93]?></td>
    <td bgcolor="#FFFFFF"><?=$FeedBACKT?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_35]?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_36]?></td>
    <td bgcolor="#FFFFFF"><?=$tentregaText?>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?=$SelectDATA[$i][af13_152]?></td>
    <td bgcolor="#FFFFFF"><?=$coddirText?>&nbsp;</td>
    <td bgcolor="#FFFFFF">
    <a href="/openc3/?sec=gestion&mod=agent_console&regediting=<?=$SelectDATA[$i][id_reg]?>&camediting=1"><?=$SelectDATA[$i][autof_matrizprincipal_1_id]?></a>&nbsp;
    </td>
  </tr>
<? } ?> 
</table>



<? }//aqui si hay resultados

else{ ?>

<div align="center" class="textosbig">No Hay Resultados.</div>	
	
<?	}

} // aqui termina la opcion 1?>