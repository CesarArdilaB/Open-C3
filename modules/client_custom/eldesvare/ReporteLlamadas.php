<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[op] != 7){

?>
<link rel="stylesheet" type="text/css" href="../../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../../css/estilos.css"/>

<div align="center">
  <h3>Buscar Llamadas</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/client_custom/eldesvare/ReporteLlamadas.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Inicial: <br></td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_ini","","")?>&nbsp;</td>
        <td class="textos_titulos">Fecha Final: </td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_fin","","")?>
        &nbsp;</td>
        <td rowspan="2" class="textos_titulos"><span class="textosbig">
          <input type="submit" name="button" id="button" value="Generar">
        </span></td>
      </tr>
      <tr class="textos_titulos">
        <td class="textos_titulos">Varado</td>
        <td class="textos_titulos">
<? 
$parametrosGrupoHerr=array(
	"tabla"=>"users",
	"campo1"=>"uid",
	"campo2"=>"name",
	"campoid"=>"uid",
	"condiorden"=>"name != \"admin\"");	
	
	echo $formulario->c_Auto_select("","varado","","","",$parametrosGrupoHerr,1," ","",0,10);

?>&nbsp;</td>
        <td class="textos_titulos">Cliente</td>
        <td class="textos_titulos"><? 
$parametrosGrupoHerr=array(
	"tabla"=>"node",
	"campo1"=>"nid",
	"campo2"=>"title",
	"campoid"=>"nid",
	"condiorden"=>"type = \"empresa\"");	
	
	echo $formulario->c_Auto_select("","cliente","","","",$parametrosGrupoHerr,1," ","",0,10);

?>&nbsp;</td>
      </tr>
    </table>
  </form>
</div>
<br />
<div id="PersInf"></div>
<? 
}//este es el que saca si no ahy ninguna opcion
if($_GET[op] == 1){ // aqui termina la opcion 1

if($_GET[varado_hidden] != ""){$ClausulaAdd .= "AND idvarado = $_GET[varado_hidden]";}
if($_GET[cliente_hidden] != ""){$ClausulaAdd .= " AND idcliente = $_GET[cliente_hidden]";}

include "../../../appcfg/cc.php";
include "../../../appcfg/class_sqlman.php";
$sqlm = new Man_Mysql();

$CallsConsulta = $sqlm->sql_select("webtransferrep","*","DATE(fechahora) BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]' $ClausulaAdd",0);
?>


<div align="center">

<? 
if(is_array($CallsConsulta)){ //termina el if del array 
?>

<iframe name="RecPlayer" width="500" height="30" frameborder="0"></iframe>
<table border="0" cellpadding="2" cellspacing="2" class="rounded-corners-blue">
    <tr>
      <td rowspan="2" align="center" bgcolor="#FFFFFF" class="textos_titulos">Cliente</td>
      <td rowspan="2" align="center" bgcolor="#FFFFFF" class="textos_titulos">Telefono</td>
      <td rowspan="2" align="center" bgcolor="#FFFFFF" class="textos_titulos"> Varado</td>
      <td rowspan="2" align="center" bgcolor="#FFFFFF" class="textos_titulos">Telefono</td>
      <td colspan="2" align="center" bgcolor="#FFFFFF" class="textos_titulos">Duracion </td>
      <td rowspan="2" align="center" bgcolor="#FFFFFF" class="textos_titulos">Medio</td>
      <td rowspan="2" align="center" bgcolor="#FFFFFF" class="textos_titulos">Grabacion</td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Min</td>
      <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Seg</td>
    </tr>
<? 
for($i=0 ; $i < count($CallsConsulta) ; $i++){//este es el final del for 
include "../../../appcfg/cc.php";
mysql_select_db("asteriskcdrdb");
$CallsTiempo = $sqlm->sql_select("cdr","billsec","uniqueid = '".$CallsConsulta[$i][unicoidC]."'",0);
if(is_array($CallsTiempo)){ $Minutos = number_format($CallsTiempo[0][billsec]/60,1); $Segundos = $CallsTiempo[0][billsec]; }
else{ $Minutos=""; $Segundos=""; }
// conexion con el desvare
$dbh=mysql_connect ("www.eldesvare.com", "integracion", "1nt3gr4d3sv4r3") or die ('No se ha realizado conexión a la database: ' . mysql_error());
mysql_select_db ("desvare"); 

$ClienteN = $sqlm->sql_select("node","title","nid = '".$CallsConsulta[$i][idcliente]."'",0); 
$VaradoN = $sqlm->sql_select("users","name","uid = '".$CallsConsulta[$i][idvarado]."'",0); 
if(is_array($VaradoN)){ 
$NomVarado = $VaradoN[0][name];
$NVarado = $CallsConsulta[$i][nvarado];
}
else {
$NomVarado = "Sin Varado"; $NVarado ="Sin Numero";}
?>
    <tr>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$ClienteN[0][title]?>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$CallsConsulta[$i][ncliente]?>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$NomVarado?>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$NVarado?>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$Minutos?>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$Segundos?>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="textos"><?=$CallsConsulta[$i][medio]?>&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF"><a href="/rc/<?=$CallsConsulta[$i][medio]?>t-<?=$CallsConsulta[$i][unicoidR]?>.WAV" class="textos" target="RecPlayer">Grabacion</a></td>
    </tr>
<? } //este es el final del for ?>
  </table>
<? }else{//termina el if del array ?>
<span class="textosbig">Sin Resultados</span>
<? } ?>
</div>
<?

} 	//aqui termina la opcion 1
					
					
	
?>