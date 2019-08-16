<? 
session_start();

if($op != 1 and $op != 2 and $op != 3and $op != 4 and $op != 5 and $op != 6 and $addcampo != 1){ 

include("../../appcfg/general_config.php");


$sqlm= new Man_Mysql();

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaiz="$RAIZHTTP";
$formulario_auto->RutaHTTP="$RAIZHTTP";

//------------------------------------------------------------- 

$ImpCampos = $sqlm->sql_select("importdata","*","idform  = '$_GET[formid]'",0);

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<div class="textos_titulos">Seleccione un modulo para este formulario.</div>
<script>
EnviarLinkJ('FormAdminB','modules/campaigns/complementari_modules.php?op=1&formid=<?=$idform?>');
</script>


<?  }// termina la prime opcion
if($op==1){ ?>

<div align="left">Esta es la lista</div>


<? } ?>