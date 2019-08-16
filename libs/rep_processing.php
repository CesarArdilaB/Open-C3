<?php
session_start();
if($_SESSION[user_ID] == "" and $nombreP != "index.php"){

/*echo ("<script language='JavaScript'>document.location.href='/openc3/index.php';</script>");*/
header ("Location: /openc3/index.php");	
	
    	}

foreach ($_GET as $key=>$val) {
    ${$key}=$val;
}

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	 
	$_GET[campos]=explode(",",$_GET[camposm]);
	$aColumns = $_GET[campos];
	
	//print_r($aColumns);
	
	/* Indexed column (used for fast and accurate table cardinality) */
	
	$sIndexColumn = $_GET[campoid];
	
	/* DB table to use */
	$sTable = $_GET[tabla];
	
	//print_r($_GET);
	
	/* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
	include( "../appcfg/cc.php" );
	
	
/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM  $sTable
		$sWhere
		$sOrder
		$sLimit
	";
	
	//echo $sQuery."----------------  $sIndexColumn ************* <br>";
	
	$rResult = mysql_query( $sQuery ) or die("aqui esta el error: $sQuery ".mysql_error());
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
	"; 
	$rResultTotal = mysql_query( $sQuery) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	;

	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
//**********************************************************************	
	require_once("../appcfg/class_forms.php");
	require_once("../appcfg/class_autoforms.php");
	require_once("../appcfg/class_sqlman.php");

$RAIZCONF = $_SERVER['DOCUMENT_ROOT']."/openc3";
$RAIZHTTP = "/openc3";

$sqlm= new Man_Mysql();


$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaizINC="$RAIZCONF";
$formulario_auto->RutaHTTP="$RAIZHTTP";
$formulario_auto->RutaRaiz="$RAIZHTTP";

//---------------------------------------------------------
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		//echo"el man si esta haciendo el loop<br>";
		
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "fechahorac" )
			{
				/* Special output formatting for 'version' column */
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			elseif ( $aColumns[$i] == "fechahora" )
			{
				/* Special output formatting for 'version' column */
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' and  $aColumns[$i] != 'agente' and $aColumns[$i] != $campoid)
			{
				/* General output */
			//	$row[] = $aRow[ $aColumns[$i] ];
			$selectcamposMOSParam=$sqlm->sql_select("autoform_config","tipocampo,paramcampo","nombrecampo = '$aColumns[$i]'",0);
			
			$row[] = $formulario_auto->armar_campo($selectcamposMOSParam[0][tipocampo],$aRow[ $aColumns[$i] ],"",$aRow[ $aColumns[$i] ],0,1,0,$selectcamposMOSParam[0][paramcampo]);
			
			}			
			else if ( $aColumns[$i] == 'agente')		
			{
				/* General output */
			//	$row[] = $aRow[ $aColumns[$i] ];
			$row[] = $formulario_auto->armar_campo("autocom","agente","",$aRow[ $aColumns[$i] ],0,1,0,"agents,id_agents,name,id_agents,1");
			
			}
			else if ( $aColumns[$i] == $campoid)		
			{
				/* General output */
			//	$row[] = $aRow[ $aColumns[$i] ];
			$row[] = $aRow[ $aColumns[$i] ];
			$IdRegistro = $aRow[ $aColumns[$i] ];
			
			}
			
			
		}
		
		if($agm != 1){ $asig = "<a href='$RAIZHTTP/modules/reports/asignar_reg.php?regediting=".$aRow[$sIndexColumn]."&camediting=$idcam' class='FF".$aRow[$sIndexColumn]."'>Asignar</a>"; }//verificamos si el reporte es para agentes y quitar el boton asignar.
		$FechaHistorial=$sqlm->sql_select("history_".$idcam,"fechahora","id_reg = '".$IdRegistro."' ORDER BY fechahora DESC LIMIT 1",0);
		
		//if(is_array($FechaHistorial)){$FechaActualizacion = $FechaHistorial[0][fechahora];}else{$FechaActualizacion = "Sin Historico";}
		//$row[] =  "$FechaActualizacion";
		$row[] =  "<a href='$RAIZHTTP/?sec=gestion&mod=agent_console&regediting=".$aRow[$sIndexColumn]."&camediting=$idcam'>Ver Registro</a> $asig";
		
		$output['aaData'][] = $row;
	}
	
	require_once("../appcfg/class_json.php");
	$json = new Services_JSON;
	echo $json->encode($output);
	
	//echo json_encode( $output );
?>