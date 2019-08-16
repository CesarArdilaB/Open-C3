<?
if($_GET[op] != 1 and $_GET[op] != 2){

/*include("../../appcfg/general_config.php");
include("appcfg/class_agenda.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();
$agendac = new Agenda();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";*/


?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>

<div align="center">
  <h3>Ver Manifiesto</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/agenda/manifiesto_nuevo.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Inicial: <br></td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_ini","","")?>
          &nbsp;</td>
        <td class="textos_titulos">Mensajero</td>
        <td class="textos_titulos"><? 
	$parametrosGrupoHerr=array(
	"tabla"=>"mensajeros",
	"campo1"=>"id_mensajero",
	"campo2"=>"name",
	"campoid"=>"id_mensajero",
	"condiorden"=>"nolabora = 0");
		
		echo $formulario->c_Auto_select("","mensajero","","","",$parametrosGrupoHerr,1,": ","",0,15); ?>
        &nbsp;</td>
        <td class="textos_titulos">&nbsp;<span class="textos_titulos">
          <input type="submit" name="button" id="button" value="Buscar" />
        </span></td>
      </tr>
    </table>
  </form>
</div>
<br />
<div id="PersInf" style="height:100%"></div>


<?	
}if($_GET[op] == 1)	{//------------

require("../../appcfg/general_config.php");
require("../../appcfg/class_agenda.php");


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$sqlm = new Man_Mysql();
$agendac = new Agenda();

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZ";
$formulario_auto->RutaHTTP="$RAIZHTTP";	
$formulario_auto->RutaRaiz="$RAIZHTTP";

if($_GET[mensajero_hidden] != "" ){ 
$consulta .= "AND idmensajero = '$_GET[mensajero_hidden]' LIMIT 1";
$Valriablemen = "&mensajero_hidden=$_GET[mensajero_hidden]";
}
else{ 
$consulta .= "GROUP BY idmensajero"; 
$Valriablemen = "";
}


$CitasDia = $sqlm->sql_select("agenda","*","fecha = '$_GET[fecha_ini]' AND idmensajero != 0 $consulta",0);

if(is_array($CitasDia)){//verificamos si es arreglo
?>		

<div align="center">
<? excelexp(tabladata); ?>
<a href="javascript:imprimir('tabladata')">Imprimir</a> 

<div id="tabladata">
  <table border="0" align="center" cellpadding="5" bgcolor="#CCCCCC" cellspacing="2" class="rounded-corners-gray">
<?
for( $i = 0 ; $i < count($CitasDia) ; $i++ ){ 


//aqui verifiacmos el id del manifiesto

$IdManifiesto = $sqlm->sql_select("agenda_manifiestos","id_manifiesto","fecha = '$_GET[fecha_ini]' AND idmensajero ='".$CitasDia[$i][idmensajero]."' ",0);

if(is_array($IdManifiesto)){
	
	$idman = $IdManifiesto[0][id_manifiesto];
	//echo "Aqui estamos";
	
	} else{
	
$sqlm->inser_data("agenda_manifiestos","fecha,idmensajero","'$_GET[fecha_ini]','".$CitasDia[$i][idmensajero]."'",0);	

$MaxidManifiesto = $sqlm->sql_select("agenda_manifiestos","MAX(id_manifiesto) as maximo",1,0);

	$idman = $MaxidManifiesto[0][maximo];
		
	}

//aqui verifiacmos el id del manifiesto


//$CitasDetalle = $sqlm->sql_select("agenda,inv_inventario","*","fecha = '$_GET[fecha_ini]' AND idmensajero = '".$CitasDia[$i][idmensajero]."' AND agenda.idregistro = inv_inventario.idregistro AND  agenda.idcampana = inv_inventario.idcampana  ORDER BY id_inventario GROUP BY numeroref",0);

$CitasDetalle = $sqlm->sql_select("agenda","*","fecha = '$_GET[fecha_ini]' AND idmensajero = '".$CitasDia[$i][idmensajero]."' GROUP BY numeroref ORDER BY id_agenda ASC ",0);


$Mensajero = $sqlm->sql_select("mensajeros","name","id_mensajero = '".$CitasDia[$i][idmensajero]."'",0);


if(is_array($Mensajero)){ $Mname = $Mensajero[0][name]; }else{ $Mname = ""; }

?>

    <tr>
      <td colspan="7" rowspan="2" align="center" bgcolor="#EFEFEF" class="textosbig"><?=$Mname?><br />
Numero de entregas: <?=count($CitasDetalle)?></td>
      <td colspan="8" rowspan="2" align="center" bgcolor="#EFEFEF" class="textosbig">MANIFIESTO DE RUTA</td>
      <td align="center" bgcolor="#EFEFEF" class="textosbig">No. <?=$idman?></td>
      <td colspan="3" rowspan="2" align="center" bgcolor="#EFEFEF">
      <img src="imgs/logocliente.png" width="163" height="50" style="margin-top:10px;margin-bottom:10px;"/>
      </td>
    </tr>
    <tr>
      <td align="center" bgcolor="#EFEFEF" class="textosbig"><?=$_GET[fecha_ini]?></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">N</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">LABEL</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">CLIENTE</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">AGENTE QUE AGENDO</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">CAMPAÑA</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos"># BOLSA DE SEGURIDAD</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">CEDULA</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">NOMBRE DEL CLIENTE</td>
      <td align="center" class="textos_titulos">DATOS TERCERO AUTORIZADO</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">DIRECCION ENTREGA</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">REF MENSAJERO</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">BARRIO</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">CIUDAD</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">CODIGOS OFICINAS</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">DOCUMENTACION A SOLICITAR</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">TIPO DE ENTREGA</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">HORA DE LA CITA</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">OBSERVACIONES CALL</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">OBSERVACIONES AGENDA</td>
    </tr>
<? 
if(is_array($CitasDetalle)){

for( $o = 0 ; $o < count($CitasDetalle) ; $o++ ){ 

$cco++; 
if(($cco%2)==0){ 
$Bgc = "#CCFFFF";
}else{ 
$Bgc = "#FFFFFF";} 


$AgnCfg = $sqlm->sql_select("agenda_camconfig","*","idcampana = '".$CitasDetalle[$o][idcampana]."'",0);
$InvCfg = $sqlm->sql_select("inv_camconfig","cbolsaout","idcampana = '".$CitasDetalle[$o][idcampana]."'",0);

//echo $CitasDetalle[$o][idregistro]."<---registro|".$CitasDetalle[$o][idcampana]."|<br>";
//echo "***".$AgnCfg[0][labelc]."***";

$Label = $camposman->campoFdata($AgnCfg[0][labelc],$CitasDetalle[$o][idregistro]);
$Campana = $camposman->campoFdata($AgnCfg[0][campanac],$CitasDetalle[$o][idregistro]);
$Bolsa = $camposman->campoFdata($InvCfg[0][cbolsaout],$CitasDetalle[$o][idregistro]);
$Cedula = $camposman->campoFdata($AgnCfg[0][cedulac],$CitasDetalle[$o][idregistro]);
$Nombre = $camposman->campoFdata($AgnCfg[0][nombrec],$CitasDetalle[$o][idregistro]);
$Tercero = $camposman->campoFdata($AgnCfg[0][datosterc],$CitasDetalle[$o][idregistro]);
$Direccion = $camposman->campoFdata($AgnCfg[0][direccionenc],$CitasDetalle[$o][idregistro]);
$Tipoe = $camposman->campoFdata($AgnCfg[0][tipoentregac],$CitasDetalle[$o][idregistro]);
$ref = $camposman->campoFdata($AgnCfg[0][refmensajeroc],$CitasDetalle[$o][idregistro]);
$Obsercacionescall = $camposman->campoFdata($AgnCfg[0][obsevacionesc],$CitasDetalle[$o][idregistro]);
$barrio = $camposman->campoFdata($AgnCfg[0][barrioc],$CitasDetalle[$o][idregistro]);
$ciudad = $camposman->campoFdata($AgnCfg[0][ciudadc],$CitasDetalle[$o][idregistro]);
$codigos = $camposman->campoFdata($AgnCfg[0][codigosoc],$CitasDetalle[$o][idregistro]);
$documentos = $camposman->campoFdata($AgnCfg[0][documentossolc],$CitasDetalle[$o][idregistro]);


$CamCliente = $campanaC->campana_parents($CitasDetalle[$o][idcampana]);

$DataAgente = $sqlm->sql_select("agents","name","id_agents = '".$CitasDetalle[$o][idagente]."'",0);
if(is_array($DataAgente)){ $AgenteText = $DataAgente[0][name]; } else { $AgenteText = ""; }

//traemos los datos de la agenda


genera_modalF("EditMan$i$o",500,660,"modules/agenda/manifiesto_nuevo.php?op=1&fecha_ini=$_GET[fecha_ini]$Valriablemen","PersInf"); 

?>

    <tr>
      <td bgcolor="<?=$Bgc?>"><a href="/openc3/?sec=gestion&amp;mod=agent_console&amp;regediting=<?=$CitasDetalle[$o][idregistro]?>&amp;camediting=<?=$CitasDetalle[$o][idcampana]?>">
        <?=$CitasDetalle[$o][idregistro]?></a> 
        
        <a class="EditMan<?=$i.$o?>" href="modules/agenda/manifiesto_editar.php?idreg=<?=$CitasDetalle[$o][idregistro]?>&idcam=<?=$CitasDetalle[$o][idcampana]?>&idag=<?=$CitasDetalle[$o][id_agenda]?>&agcom=<?=$CitasDetalle[$o][comentarios]?>&aghora=<?=$CitasDetalle[$o][hora]?>&idmensajero=<?=$CitasDia[$i][idmensajero]?>">
        <img src='imgs/editimg.png' width='12' height='12'></img>
        </a>
        
      </td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$Label?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$CamCliente[clienteN]?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$AgenteText?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$Campana?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$Bolsa?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$Cedula?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$Nombre?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$Tercero?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$Direccion?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$ref?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$barrio?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$ciudad?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$codigos?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$documentos?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$Tipoe?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$CitasDetalle[$o][hora]?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$Obsercacionescall?></td>
      <td bgcolor="<?=$Bgc?>" class="textospadding"><?=$CitasDetalle[$o][comentarios]?></td>
    </tr>
    
<? } /*Aqui cerramos el segundo for*/  ?><? }/*aqui el ifisarray*/  } ?>
  </table>
  </div>
  
  
  
  <?  } //Terminamos de Verificar si es arreglo
 else{ 
 ?>
 
 No Hay Resultados.
 
 <? } ?>
</div>


<?				}//------------

//---------------------------?> 