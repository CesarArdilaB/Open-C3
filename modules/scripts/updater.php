<? 
session_start();

include("../../appcfg/general_config.php");


$sqlm= new Man_Mysql();

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaiz="$RAIZHTTP";
$formulario_auto->RutaHTTP="$RAIZHTTP";

//------------------------------------------------------------- 

$TraeCamposSelect=$sqlm->sql_select("autoform_config","nombrecampo","eliminado != 1 AND (tipocampo = 'autocom' OR tipocampo = 'select') AND idtabla_rel = '$formid'",1);
$TeblaData=$sqlm->sql_select("autoform_tablas","*","id_autoformtablas = '$formid'",0);


if(is_array($TraeCamposSelect)){
	for($i=0 ; $i < count($TraeCamposSelect) ; $i++ ){

		$ntabla = "autof_".$TraeCamposSelect[$i][nombrecampo];
		$ncampoid = "id_".$TraeCamposSelect[$i][nombrecampo];
		$ncampo = $TraeCamposSelect[$i][nombrecampo];
		$UpdateCamposSelect=$sqlm->update_regs($TeblaData[0][nombretabla].",".$ntabla,"$ncampo = $ncampoid","$ncampo = field1",1);
	
	} 
}


//aqui hacemos la tabla de los registros duplicados
?>