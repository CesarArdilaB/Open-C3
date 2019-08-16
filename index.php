<? 
session_start("octresSess");



// estas son las variables de session 

/*
$_SESSION["user_ID"]
$_SESSION["group_ID"]
$_SESSION["loged"]
$_SESSION["language"]
*/

// estas son las variables de session 

/*
aqui el comentario de introduccion a openc3 un sistema de informacion disenado para suplir las nesesidades de su call y contact center.
*/ 
require("appcfg/cc.php");
include("appcfg/func_mis.php");
include("appcfg/js_scripts.php");
include("appcfg/class_sqlman.php");
include("appcfg/class_forms.php");
include("appcfg/class_autoforms.php");

//cierra session

if($_GET[logout]==1){ 

session_destroy();

$mensaje	= strip_tags($_GET[mensaje]);
$CaracTeres = array("=","'","\"","\x00","\n","\r","\x1a","<",">","<script>","</script>",";",":","A-Z","0","2","3","4","5","6","7","8","(",")");
$mensaje 	= str_ireplace($CaracTeres,"",$mensaje);

redirect("index.php?mensaje=$mensaje"); }

//activamos los objetos
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

if(isset($_POST[in]))	{//----

if(isset($_POST[DB_name])){ $_SESSION[DBnamE] = $_POST[DB_name]; mysql_select_db($_POST[DB_name]);}else{$_SESSION[DBnamE]="octres";}

if( isset($_POST[codigo]) ){//aqui comprobamos el capcha------------------
	
require_once './libs/capcha/securimage/securimage.php';

		$image = new Securimage();

    if ($image->check($_POST[codigo]) == false) {

	$failcode = 1;

    /*<!--Aqui esta el comprobador del codigo-->*/}

							}//aqui comprobamos el capcha------------------


$uSuario 	= strip_tags($_POST[user]);
$cLave 		= strip_tags($_POST[password]);
$mensaje	= strip_tags($_GET[mensaje]);

$CaracTeres = array("=","'","\"","\x00","\n","\r","\x1a","<",">","<script>","</script>");
$uSuario 	= str_ireplace($CaracTeres,"",$uSuario);
$cLave 		= str_ireplace($CaracTeres,"",$cLave);
$mensaje 	= str_ireplace($CaracTeres,"",$mensaje);


$agent_validation=$sqlm->sql_select("agents","*","user = '".mysql_real_escape_string($uSuario)."' AND password = '".mysql_real_escape_string($cLave)."' AND inactivo = 0",0);

//$agent_validation=$sqlm->sql_select("agents","*","user = '".$_POST[user]."' AND password = '".$_POST[password]."'",0);


if($agent_validation != "No hay resultados"){ 

if($agent_validation[0][idgroup] == 0){ $grupo = 3;}
else{ $grupo =  $agent_validation[0][idgroup];}

	$iduser = $agent_validation[0][id_agents];
	$idgroup = $grupo;
	$idgroupag = $agent_validation[0][idagents_group];
	$logueado = md5($agent_validation[0][id_agents]);
	$lenguaje = "es";
	$username = $agent_validation[0][name];
	$extension = $agent_validation[0][extension];
	$numeroa = $agent_validation[0][number];


	}


if($agent_validation == "No hay resultados" or $failcode == 1){

session_destroy()
?>
<!--<script language="javascript">
    $(document).ready(function() {  
        $.fn.colorbox({html:"<div class='mensajes' align='center'></div>", open:true,width:"550", height:"100",top:"30%"});
    });  
</script>-->

<script language='JavaScript'>document.location.href='/openc3/index.php?logout=1&mensaje=1';</script>


<?
	
}else{

$_SESSION["user_ID"] = $iduser;
$_SESSION["group_ID"] = $idgroup;
$_SESSION["groupag_ID"] = $idgroupag;
$_SESSION["user_tipe"] = $tipouser;
$_SESSION["loged"] = $logueado;
$_SESSION["language"] = $lenguaje;
$_SESSION["user_NAME"] = $username;
$_SESSION["ext_NUMBER"] = $extension;
$_SESSION["agent_NUMBER"] = $numeroa;
		
}

				}//----

//terminamos de validar el logueo de los usuarios

// seccion para la seleccion del idioma de la aplicacion  que funciona con gettext.
//putenv("LC_ALL=$lan");
//setlocale(LC_ALL, $lan);
//bindtextdomain("apptext", "./translations");
//textdomain("apptext");
// seccion para la seleccion del idioma de la aplicacion  que funciona con gettext.

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Gestion - Open C3</title>
<link rel="shortcut icon" href="<?=$RAIZHTTP?>/favicon.ico" type="image/x-icon" />
</head>
<body>
<? 
// verifica si la session esta iniciada para mostrar la aplicacion o el login de usuario
if ( 

		$_SESSION["loged"] != md5($_SESSION["user_ID"])){ include 'apploginblock.php';}

else{
		
		include 'appmenu.php';
		include 'appblock.php';

}

?>
</body>
</html>
