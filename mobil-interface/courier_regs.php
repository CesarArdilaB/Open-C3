<?
include '../appcfg/cc.php';
include '../appcfg/class_sqlman.php';
include '../appcfg/class_forms.php';
include '../appcfg/class_autoforms.php';

$RAIZCONF = $_SERVER['DOCUMENT_ROOT']."/openc3";
$RAIZHTTPCONF = "https://$ipruta/";

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTPCONF";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZCONF";
$formulario_auto->RutaHTTP="$RAIZHTTPCONF";
$formulario_auto->RutaRaiz="$RAIZHTTPCONF";

date_default_timezone_set('America/Bogota');
$fecha_act=date("Y-n-j");

$sqlm = new Man_Mysql;

	$IsLoged = $sqlm->sql_select("mensajeros","name,id_mensajero as idm","mobilin = '".$_GET[uuid]."'",0);
	if(is_array($IsLoged)){
		
		//aqui si esta logueado le muestra los registros
		
	$AgendaData = $sqlm->sql_select(
	"agenda,autof_matrizprincipal_1",
	"af13_40 as nombre, 
	af13_71,af13_145,af13_72,af13_81,af13_149,af13_67,af13_68,af13_69,af13_150,
	autof_matrizprincipal_1_id as idreg,id_agenda as idag,claved,clavef",
	"idmensajero = '".$IsLoged[0][idm]."' AND idregistro = autof_matrizprincipal_1_id 
	AND fecha = '$fecha_act' AND feedback = 0 GROUP BY numeroref",0);


	if(is_array($AgendaData)){//si ahy resultados

	for($i=0 ; $i < count($AgendaData) ; $i++){//este es el final del for
	
	$callecra 	= 	$formulario_auto->armar_campo("select","nom","",$AgendaData[$i][af13_71],0,1,0,"autof_af13_71,field2,field1,id_af13_71,1");
	$puntos 	= 	": ".$AgendaData[$i][af13_145];
	$numero 	= 	"# ".$AgendaData[$i][af13_72];
	$casa 		= 	"Conjunto/Casa/Apto/Bloque: ".$AgendaData[$i][af13_81];
	$barrio 	= 	"Barrio: ".$AgendaData[$i][af13_149];
	$ciudad 	= 	$formulario_auto->armar_campo("select","nom","",$AgendaData[$i][af13_67],0,1,0,"autof_af13_67,id_af13_67,field1,id_af13_67,1");
	$zona	 	= 	$formulario_auto->armar_campo("select","nom","",$AgendaData[$i][af13_68],0,1,0,"autof_af13_68,id_af13_68,field1,id_af13_68,1");
	$localidad 	= 	$formulario_auto->armar_campo("select","nom","",$AgendaData[$i][af13_69],0,1,0,"autof_af13_69,id_af13_69,field1,id_af13_69,1");
	$refmensaj 	= 	"Referencia: ".$AgendaData[$i][af13_150];
	
	$DireccionComp = "$callecra $puntos $numero $casa $barrio $refmensaj";		
	
	
	
$ArrResult[] = array	(
				"idreg" => $AgendaData[$i][idreg],
				"cliente" => $AgendaData[$i][nombre],
				"direccion" => $DireccionComp,
				"idmensajero" => $IsLoged[0][idm],
				"idagenda" => $AgendaData[$i][idag],
				"claved" => $AgendaData[$i][claved],
				"clavef" => $AgendaData[$i][clavef]
						);	

	
	} //este es el final del for
	
	
	echo json_encode($ArrResult);
	
	}//si ahy resultados
	else {
		
	echo "11";	
		
		}
	
			
	}else{
		
		//si no esta logueado le muestra el form

		echo "11";
			
		}

?>