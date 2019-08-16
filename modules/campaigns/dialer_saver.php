<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<? 
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5){
include '../../appcfg/general_config.php';
include '../../appcfg/cc_call.php';

mysql_select_db("call_center");

$CamPre = $sqlm->sql_select("campaign","*","idofill = '".$_GET[idfiltro]."'",0);

?>
<script>
	
	EnviarLinkJ('ListaDialer','modules/campaigns/dialer_saver.php?op=1&idfiltro=<?=$_GET[idfiltro]?>');
//	setInterval( "EnviarLinkJ('ListaDialer','modules/campaigns/dialer_saver.php?op=1&idfiltro=<?=$idfiltro?>','',1)", 10000 )
//este auto refresco queda comentado hasta identificar como hacer que no se duplique.


</script>
<? genera_modalF("NewPre",800,580,"$RAIZHTTP/modules/campaigns/dialer_saver.php?op=1&idfiltro=$_GET[idfiltro]","ListaDialer"); ?>
<div align="center">
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><div align="center">
      <table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>Filtre las marcaciones por estado: </td>
          <td>
            <select name="camposver" onchange="EnviarLinkJ('ListaDialer','modules/campaigns/dialer_saver.php?op=1&idfiltro=<?=$_GET[idfiltro]?>',this.options[this.selectedIndex].value);">
              <option value="-" selected="selected">Seleccione</option>
              <option value="A">Activas</option>
              <option value="T">Terminadas</option>
              <option value="I">Inactivas</option>
              </select>
            </td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td><div align="center">Para asignar los registros disponibles a una marcacion predictiva haga <a href="<?=$RAIZHTTP?>/modules/campaigns/dialer_newc.php?idfiltro=<?=$_GET[idfiltro]?>&amp;idform=<?=$_GET[idform]?>" class="NewPre">click aqui</a></div></td>
  </tr>
  </table>
</div>

<div id="ListaDialer">

</div>

<?
}//el primer if queda aqui. 
if($_GET[op] == 1){
	
include '../../appcfg/general_config.php';


//--------------------------------------------------************
mysql_select_db("octres",$dbh);

$TraeCondiciones = $sqlm->sql_select("firter_conditions","*","idrelconfig = '".$_GET[idfiltro]."'",0);

for($i=0 ; $i<count($TraeCondiciones);$i++){
	
	@$CampoData = $sqlm->sql_select("autoform_config","*","nombrecampo = '".$TraeCondiciones[$i][campo]."'",0);

$condiciones .= "AND ".$TraeCondiciones[$i][campo]." ".$TraeCondiciones[$i][condicion]." '".$TraeCondiciones[$i][valor]."'";

 } /*Aqui termino el for que muestra los filtro*/ 
$TablaData= $sqlm->sql_select("autoform_tablas","*","id_autoformtablas = '".$CampoData[0][idtabla_rel]."'",0);


//trae el filtro personalizado que se aplico

$TraeFillTemplate = $sqlm->sql_select("filter_tamplate,filter_config","clausulas,filter_tamplate.nombre as nombreT,idtemplate","id_filter = '$_GET[idfiltro]' and id_filtertemplate = idtemplate",0);
if(is_array($TraeFillTemplate)){
$condiciones .= " AND (".$TraeFillTemplate[0][clausulas].")";
}

//trae el filtro personalizado que se aplico


$Reduldado = $sqlm->sql_select($TablaData[0][nombretabla],"COUNT(".$TablaData[0][campoid].") as cuenta","1 $condiciones",0);

//--------------------------------------------------************
include '../../appcfg/cc_call.php';
mysql_select_db("call_center");

if($_POST[varid] != "undefined" ){ $varid = $_POST[varid]; }else{ $varid = $_GET[varid]; }//-----------------
if($varid == "undefined" or $varid == ""){ $estadoC = "AND estatus != ''"; }else{ $estadoC = "AND estatus = '$varid'"; }

@$CamsLista = $sqlm->sql_select("campaign","*","idofill = '".$_GET[idfiltro]."' $estadoC ORDER BY estatus",0);

?>
	
<div align="center">
  <table border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td colspan="9" class="textos_titulos">
      <div align="center">Registros Disponibles Para Este Filtro:<?=$Reduldado[0][cuenta]?></div>
      </td>
    </tr>
    <tr>
      <td class="textos_titulos">Nombre</td>
      <td class="textos_titulos">Creado</td>
      <td class="textos_titulos">Rango Fecha</td>
      <td class="textos_titulos">Rango Hora</td>
      <td class="textos_negros">Intentos</td>
      <td class="textos_titulos">Completadas</td>
      <td class="textos_titulos">Promedio</td>
      <td class="textos_titulos">Estado</td>
      <td class="textos_titulos">Acciones</td>
     </tr>
     
<? if(is_array($CamsLista)){for($i = 0 ;$i < count($CamsLista) ; $i++) { 

	switch($CamsLista[$i][estatus]){

		case "I": 
		$estadoT = "Inactiva";
		$linkedit="<a href='$RAIZHTTP/modules/campaigns/dialer_edit.php?idcam=".$CamsLista[$i][id]."&idfiltro=".$_GET[idfiltro]."' class='EditPre".$i."'>Modificar</a>";
		break;
		
		case "T":
		$estadoT = "Terminada"; 	
		$linkedit="No Permitido";
		break;
		
		case "A":
		$estadoT = "Activa";
		$linkedit="<a href='$RAIZHTTP/modules/campaigns/dialer_edit.php?idcam=".$CamsLista[$i][id]."&idfiltro=".$_GET[idfiltro]."' class='EditPre".$i."'>Modificar</a>";
		
	}

genera_modalF("EditPre".$i,800,580,"$RAIZHTTP/modules/campaigns/dialer_saver.php?op=1&idfiltro=".$_GET[idfiltro],"ListaDialer");

?>
    <tr class="rounded-corners-blanco">
      <td align="left" bgcolor="#FFFFFF" class="textos"><?=$CamsLista[$i][name]?></td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$CamsLista[$i][creado]?></td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$CamsLista[$i][datetime_init]." ".$CamsLista[$i][datetime_end]?></td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$CamsLista[$i][daytime_init]." ".$CamsLista[$i][daytime_end]?></td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$CamsLista[$i][retries]?></td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$CamsLista[$i][num_completadas]?></td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$CamsLista[$i][promedio]?></td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$estadoT?></td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$linkedit?></td>
    </tr>
<? } } //cierro el if y el for.?> 
  </table>
</div>
<? } //el fn de la opcion 1 ?>
