<?
/*esta clase sera utilizada para generar los reportes 1.0

Aqui los cambios que tiene en cada actualizacion:

*/

class reportes extends Man_Mysql{

	var $RutaRaizINC;
	var $RutaHTTP;
	var $RutaRaiz;

	function GeneraRep($idreporte,$confurando=0){//genera un reporte de la tabla de reportes

	$ParametrosRep		= parent::sql_select("rep_config","*","id_filter = '$idreporte'",0);
	$ParametrosTabla 	= parent::sql_select("autoform_tablas","*","id_autoformtablas = '".$ParametrosRep[0][idform]."'",0);
	$CamposMostrar		= parent::sql_select("rep_camposm","*","idfiltro = '".$idreporte."'",0);
	$CamposCom			= parent::sql_select("rep_conditions","*","idrelconfig = '".$idreporte."'",0);

	$TraeFillTemplate = parent::sql_select("filter_tamplate,rep_config","clausulas,filter_tamplate.nombre as nombreT,idtemplate","id_filter = '$idreporte' and id_filtertemplate = idtemplate",0);

	if(is_array($TraeFillTemplate)){ $FiltroTemplate = " AND (".$TraeFillTemplate[0][clausulas].")"; }
	else{ $FiltroTemplate = ""; }



	//preparamos las tablas que se van a consultar

	$Camposid = $ParametrosTabla[0][campoid]." = id_ident_".$ParametrosTabla[0][campaignid];

	$tablas .= $ParametrosTabla[0][nombretabla].",ident_".$ParametrosTabla[0][campaignid];
	//,history_".$ParametrosTabla[0][campaignid]

	//preparamos las tablas que se van a consultar
	//aqui cuadramos los campos que vamos a mostrar
	for($i=0 ; $i < count($CamposMostrar) ; $i++ ){

	@$camposmos .= ",".$CamposMostrar[$i][campom];
	@$ArrCamposMos[]=$CamposMostrar[$i][campom];

	}
	//aqui cuadramos los campos que vamos a comparar
	for($i=0 ; $i < count($CamposCom) ; $i++ ){

	@$CadenaCom .= "AND ".$CamposCom[$i][campo]." ".$CamposCom[$i][condicion]." '".$CamposCom[$i][valor]."'";

	}
	//-----------------------------------------

$camposmos = "id_ident_".$ParametrosTabla[0][campaignid].",fechahorac".$camposmos.",agente";
//,fechahora



//, (SELECT fechahora FROM history_".$ParametrosTabla[0][campaignid]." WHERE id_reg = id_ident_".$ParametrosTabla[0][campaignid]." ORDER BY fechahora DESC LIMIT 0,1 )as fechaact
//$camposmos = "id_ident_".$parametrosConsult[0][id_cam].",".substr($parametrosConsult[0][camposmos],1);// para tse

$condiciones = $Camposid." ".$CadenaCom." ".$FiltroTemplate;
//AND id_reg = ".$ParametrosTabla[0][campoid]."


//traemos los campos a mostrar y comparar de la tabla

//$ArrCamposMos=explode(",",$parametrosConsult[0][camposmos]);
$ArrCamposCom=explode(",",$parametrosConsult[0][camposcom]);



//hacemos el select de los datos.

$SelectedData=parent::sql_select($tablas,$camposmos,$condiciones."LIMIT 0,1",0);

		if($confurando == 1){

	$queryDEL = "DROP VIEW vista_rep_"."$idreporte";
	@mysql_query($queryDEL);

							}

$CrearVista = "CREATE VIEW vista_rep_"."$idreporte AS SELECT $camposmos FROM $tablas WHERE $condiciones";
//GROUP BY id_reg ORDER BY fechahora DESC

//echo "<br>".$CrearVista;

@mysql_query($CrearVista);

if($SelectedData != "No hay resultados"){

$this->genera_modalF("descargar",400,300);

?>
<link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
<div id="Results<?=$idreporte?>" align="left">

<div align="center" class="rounded-corners-orange" style="width:300px">
<a href="<?=$this->RutaHTTP?>/libs/csv_informes.php?tabla=vista_rep_<?=$idreporte?>&camposm=<?=$camposmos?>&campoid=id_ident_<?=$ParametrosTabla[0][campaignid]?>" class="textos_titulos descargar">Descargar todos los Registros de este Informe</a>
</div>


<script>

$(document).ready(function(){
$('#tablaResults<?=$idreporte?>').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "<?=$this->RutaHTTP?>/libs/rep_processing.php?agm=<?=$parametrosConsult[0][agente]?>&idcam=<?=$ParametrosTabla[0][campaignid]?>&tabla=vista_rep_<?=$idreporte?>&camposm=<?=$camposmos?>&campoid=id_ident_<?=$ParametrosTabla[0][campaignid]?>",
		"sDom": 'T<"clear">lfrtip',
        "oTableTools": {
            "sSwfPath": "<?=$this->RutaHTTP?>/libs/DataTables/media/swf/copy_cvs_xls_pdf.swf"
        }
    });

});

</script>


<table border="0" align="center" cellpadding="0" cellspacing="5" id="tablaResults<?=$idreporte?>" class="display">
	<thead>
		<tr>

        <th>Id Registro</th>
		<th>Fecha de Creacion</th>

<? for($o=0 ; $o < count($ArrCamposMos) ; $o++){

$selectcamposMOS=parent::sql_select("autoform_config","labelcampo","nombrecampo = '$ArrCamposMos[$o]'");

	if($selectcamposMOS != "No hay resultados"){ ?>

			<th><?=$selectcamposMOS[0][labelcampo]?></th>

<? }/*termina el if*/  } ?>

 <th>Agente / Usuario</th>
<!-- <th>Fecha de Actualizacion</th>-->
        <th>Acciones</th>
        </tr>
	</thead>
    <tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Cargando Datos</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>

        <th>Id Registro</th>
      <th>Fecha de Creacion</th>

<? for($o=0 ; $o < count($ArrCamposMos) ; $o++){

$selectcamposMOS=parent::sql_select("autoform_config","labelcampo","nombrecampo = '$ArrCamposMos[$o]'");

	if($selectcamposMOS != "No hay resultados"){?>
			<th><?=$selectcamposMOS[0][labelcampo]?></th>
<? }/*termina el if*/  } ?>

		<th>Agente / Usuario</th>
      <!--  <th>Fecha de Actualizacion</th>-->
		<th>Acciones</th>
        </tr>
	</tfoot>
</table>
</div>
<?	}//el if que comprueba los registros

else { echo "<center><b>No Hay Resultados</b></center>";}


	}//genera un reporte de la tabla de reportes

//-------------------------------------------


	function GeneraRepFijo($idreporte,$confurando=0,$buscando=""){//genera un reporte de la tabla de reportes fija

	$ParametrosRep		= parent::sql_select("rep_config","*","id_filter = '$idreporte'",0);
	$ParametrosTabla 	= parent::sql_select("autoform_tablas","*","id_autoformtablas = '".$ParametrosRep[0][idform]."'",0);
	$CamposMostrar		= parent::sql_select("rep_camposm","*","idfiltro = '".$idreporte."'",0);
	$CamposCom			= parent::sql_select("rep_conditions","*","idrelconfig = '".$idreporte."'",0);

	$TraeFillTemplate = parent::sql_select("filter_tamplate,rep_config","clausulas,filter_tamplate.nombre as nombreT,idtemplate","id_filter = '$idreporte' and id_filtertemplate = idtemplate",0);

	if(is_array($TraeFillTemplate)){ $FiltroTemplate = " AND (".$TraeFillTemplate[0][clausulas].")"; }
	else{ $FiltroTemplate = ""; }



	//preparamos las tablas que se van a consultar

	$Camposid = $ParametrosTabla[0][campoid]." = id_ident_".$ParametrosTabla[0][campaignid];

	$tablas .= $ParametrosTabla[0][nombretabla].",ident_".$ParametrosTabla[0][campaignid];
	//,history_".$ParametrosTabla[0][campaignid]

	//preparamos las tablas que se van a consultar
	//aqui cuadramos los campos que vamos a mostrar
	for($i=0 ; $i < count($CamposMostrar) ; $i++ ){

	@$camposmos .= ",".$CamposMostrar[$i][campom];
	@$ArrCamposMos[]=$CamposMostrar[$i][campom];

	}
	//aqui cuadramos los campos que vamos a comparar
	for($i=0 ; $i < count($CamposCom) ; $i++ ){

	@$CadenaCom .= "AND ".$CamposCom[$i][campo]." ".$CamposCom[$i][condicion]." '".$CamposCom[$i][valor]."'";

	}
	//-----------------------------------------

$camposmos = "id_ident_".$ParametrosTabla[0][campaignid].",fechahorac".$camposmos.",agente";
//,fechahora



//, (SELECT fechahora FROM history_".$ParametrosTabla[0][campaignid]." WHERE id_reg = id_ident_".$ParametrosTabla[0][campaignid]." ORDER BY fechahora DESC LIMIT 0,1 )as fechaact
//$camposmos = "id_ident_".$parametrosConsult[0][id_cam].",".substr($parametrosConsult[0][camposmos],1);// para tse

$condiciones = $Camposid." ".$CadenaCom." ".$FiltroTemplate;
//AND id_reg = ".$ParametrosTabla[0][campoid]."


//traemos los campos a mostrar y comparar de la tabla

//$ArrCamposMos=explode(",",$parametrosConsult[0][camposmos]);
$ArrCamposCom=explode(",",$parametrosConsult[0][camposcom]);

$campoid = "id_ident_".$ParametrosTabla[0][campaignid];

//hacemos el select de los datos.

$SelectedData=parent::sql_select($tablas,$camposmos,$condiciones."LIMIT 0,1",0);

		if($confurando == 1){

	$queryDEL = "DROP VIEW vista_rep_"."$idreporte";
	@mysql_query($queryDEL);

							}

$CrearVista = "CREATE VIEW vista_rep_"."$idreporte AS SELECT $camposmos FROM $tablas WHERE $condiciones";
//GROUP BY id_reg ORDER BY fechahora DESC

//echo "<br>".$CrearVista."<br><br><br>";

@mysql_query($CrearVista);


if($buscando != ""){ //aqui buscamos lo del bucador

		$sWhere = "(";
		$sWhere .= " $campoid  LIKE '%".mysql_real_escape_string( $buscando )."%' OR ";
		for ( $i=0 ; $i<count($ArrCamposMos) ; $i++ )
		{

	$sWhere .= $ArrCamposMos[$i]." LIKE '%".mysql_real_escape_string( $buscando )."%' OR ";

		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';


}else{ $sWhere = 1; } //aqui buscamos lo del bucador

$SelectedDataM=parent::sql_select("vista_rep_"."$idreporte","*","$sWhere LIMIT 0,50",0);


if($SelectedDataM != "No hay resultados"){

$this->genera_modalF("descargar",400,300);

?>
<link rel="stylesheet" type="text/css" href="../css/estilos.css"/>



<div id="Results<?=$idreporte?>" align="left">

<div align="center">
<form method="post" enctype="application/x-www-form-urlencoded" action="">
<table width="200" border="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td bgcolor="#FFFFFF">Buscar </td>
    <td bgcolor="#FFFFFF"><input type="text" name="buscar" value="<?=$buscando?>"></td>
    <td bgcolor="#FFFFFF"><input type="submit" value="Buscar" name="ok"></td>
  </tr>
</table>

</form>
</div>

<div align="center" class="rounded-corners-orange" style="width:300px">
<a href="<?=$this->RutaHTTP?>/libs/csv_informes.php?tabla=vista_rep_<?=$idreporte?>&camposm=<?=$camposmos?>&campoid=id_ident_<?=$ParametrosTabla[0][campaignid]?>" class="textos_titulos descargar">Descargar todos los Registros de este Informe</a>
</div>

<table border="0" align="center" cellpadding="0" cellspacing="5" id="tablaResults<?=$idreporte?>" class="display">
	<thead>
		<tr>

        <th>Id Registro</th>
		<th>Fecha de Creacion</th>

<? for($o=0 ; $o < count($ArrCamposMos) ; $o++){

$selectcamposMOS=parent::sql_select("autoform_config","labelcampo,tipocampo,paramcampo","nombrecampo = '$ArrCamposMos[$o]'",0);

	if($selectcamposMOS != "No hay resultados"){ ?>

			<th><?=$selectcamposMOS[0][labelcampo]?></th>

<? }/*termina el if*/  } ?>

 		<th>Agente / Usuario</th>
<!-- <th>Fecha de Actualizacion</th>-->
        <th>Acciones</th>
        </tr>
	</thead>
    <tbody>
<? for($z=0 ; $z < count($SelectedDataM) ; $z++){ ?>
		<tr>
			<td>

			<?=$SelectedDataM[$z][$campoid]?>

            </td>
			<td><?=$SelectedDataM[$z][fechahorac]?></td>

<?

for($o=0 ; $o < count($ArrCamposMos) ; $o++){ $ncampo = $ArrCamposMos[$o];

$selectcamposMOS=parent::sql_select("autoform_config","labelcampo,tipocampo,paramcampo","nombrecampo = '$ArrCamposMos[$o]'",0);


?>

			<td><?=Auto_Forms::armar_campo($selectcamposMOS[0][tipocampo],$SelectedDataM[$z][$ncampo],"",$SelectedDataM[$z][$ncampo],0,1,0,$selectcamposMOS[0][paramcampo])?></td>

<? } ?>

			<td>
<?=Auto_Forms::armar_campo("autocom","agente","",$SelectedDataM[$z][agente],0,1,0,"agents,id_agents,name,id_agents,1");?>
			</td>

            <td>

            <a href='<?="/openc3/?sec=gestion&mod=agent_console&regediting=".$SelectedDataM[$z][$campoid]."&camediting=".$ParametrosTabla[0][campaignid]?>'>Ver Registro</a>

            </td>

		</tr>
<? } ?>
	</tbody>
	<tfoot>
		<tr>

        <th>Id Registro</th>
      <th>Fecha de Creacion</th>

<? for($o=0 ; $o < count($ArrCamposMos) ; $o++){

$selectcamposMOS=parent::sql_select("autoform_config","labelcampo","nombrecampo = '$ArrCamposMos[$o]'");

	if($selectcamposMOS != "No hay resultados"){?>
			<th><?=$selectcamposMOS[0][labelcampo]?></th>
<? }/*termina el if*/  } ?>

		<th>Agente / Usuario</th>
      <!--  <th>Fecha de Actualizacion</th>-->
		<th>Acciones</th>
        </tr>
	</tfoot>
</table>
</div>
<?	}//el if que comprueba los registros

else { echo "<center><b>No Hay Resultados</b></center>";}


	}//genera un reporte de la tabla de reportes fija


//-------------------------------------------

//Aqui hacemos la seccion del reporte grafico

function Genera_Reporte_Graf($idreporte,$fechaini=0,$fechafin=0,$campofecha="",$TipoGraf="line",$Muestratabla=0){

$CausulaRep 	=	parent::sql_select("repdina_config","nombre,id_cam,id_form","id_rep = '$idreporte'",0);
$CausulaComp 	= 	parent::sql_select("repdina_compare","campo,condicion,valor","idrelconfig = '$idreporte'");
$FormData 		= 	parent::sql_select("autoform_tablas","labeltabla,nombretabla,campoid,campaignid","id_autoformtablas = '".$CausulaRep[0][id_form]."'",0);



//aqui complementamos con las tablas de datos de los modulos esopesiales
for($i=0 ; $i<count($CausulaComp);$i++){


	if(substr($CausulaComp[$i][campo],0,4) == "cme_")		{

	@$CampoData = parent::sql_select("acampos_esp","*","campon = '".substr($CausulaComp[$i][campo],4,20)."'",0);
	$ARRtablas[] = $CampoData[0][tabla];
	$ArrCondiciones[] = $CampoData[0][tabla].".idregistro = ".$FormData[0][campoid]." AND ".$CampoData[0][tabla].".idcampana = ".$FormData[0][campaignid];
	$CausulaComp[$i][campo] = substr($CausulaComp[$i][campo],4,20);


$condiciones .= " AND ".$CausulaComp[$i][campo]." ".$CausulaComp[$i][condicion]." '".$CausulaComp[$i][valor]."'";

																}else{

$condiciones .= " AND ".$CausulaComp[$i][campo]." ".$CausulaComp[$i][condicion]." '".$CausulaComp[$i][valor]."'";

																}
}

//aqui complementamos con las tablas de datos de los modulos esopesiales




	$CausulaData 	=	parent::sql_select("repdina_datashow","valor,identificador,ncampo","id_rep = '$idreporte'",0);


//aqui complementamos con las tablas de datos de los modulos esopesiales
for($i=0 ; $i<count($CausulaData);$i++){


	if(substr($CausulaData[$i][ncampo],0,4) == "cme_")		{

@$CampoData = parent::sql_select("acampos_esp","*","campon = '".substr($CausulaData[$i][ncampo],4,20)."'",0);
	$ARRtablas[] = $CampoData[0][tabla];
	$ArrCondiciones[] = $CampoData[0][tabla].".idregistro = ".$FormData[0][campoid]." AND ".$CampoData[0][tabla].".idcampana = ".$FormData[0][campaignid];
	$TraeCondiciones[$i][campo] = substr($CausulaData[$i][ncampo],4,20);

															}
}


//clausulas adicionales
$CamposShow = parent::sql_select("repdina_camposm","campom","idfiltro = '$idreporte'",0);

for($i=0 ; $i<count($CamposShow);$i++){


	if(substr($CamposShow[$i][campom],0,4) == "cme_")		{

@$CampoData = parent::sql_select("acampos_esp","*","campon = '".substr($CamposShow[$i][campom],4,20)."'",0);
	$ARRtablas[] = $CampoData[0][tabla];
	$ArrCondiciones[] = $CampoData[0][tabla].".idregistro = ".$FormData[0][campoid]." AND ".$CampoData[0][tabla].".idcampana = ".$FormData[0][campaignid];
	$TraeCondiciones[$i][campo] = substr($CamposShow[$i][campom],4,20);

			$CademasMostrar .= $CampoData[0][tabla].".".substr($CamposShow[$i][campom],4,20).",";

			}else { $CademasMostrar .= $CamposShow[$i][campom].","; }

			$ARRcamposM[]=$CamposShow[$i][campom];


}
//clausulas adicionales



if(is_array($ARRtablas))	{

		$NuevoARRtablas = array_unique($ARRtablas);
		$TablasNuevas = implode(",",$NuevoARRtablas);
		$TablasNuevas = ",".$TablasNuevas;

		$NuevoArrCondiciones = array_unique($ArrCondiciones);
		$CondicionesNuevas = implode(" AND ",$NuevoArrCondiciones);
		$CondicionesNuevas = " AND ".$CondicionesNuevas;

							 }


//aqui complementamos con las tablas de datos de los modulos esopesiales




	$SelFecha		=	parent::sql_select("history_".$FormData[0][campaignid],"CONCAT(MONTH(fechahora),'/',DAY(fechahora))as fechaM , DATE(fechahora) as fechaTabla, DATE(fechahora) AS fechaC","DATE(fechahora) BETWEEN '$fechaini' AND '$fechafin' GROUP BY DATE(fechahora)",0);


//generamos con las fechas el div.
for($i=0 ; $i < count($SelFecha) ; $i++ ){
	$Xvalues .="'".$SelFecha[$i][fechaM]."',";
	$Xtvalues.=$SelFecha[$i][fechaTabla].",";
}

	$Xvalues .=substr($Xvalues,0,-1);
	$Xtvalues .=substr($Xtvalues,0,-1);


//aqui armamos la matriz para la grafica.

		for($z=0 ; $z < count($CausulaData) ; $z++ ){//----------------------


		if(substr($CausulaData[$z][ncampo],0,4) == "cme_"){ $CausulaData[$z][ncampo] = substr($CausulaData[$z][ncampo],4,40); }

	$ValoresSerie .= "{name: '".$CausulaData[$z][valor]."',";
	$valorTData[] = $CausulaData[$z][identificador]; // aqui le mandamos los ids a la tabla de datos para el detalle


		for($o=0 ; $o < count($SelFecha) ; $o++){

		//aqui agregamos lo de la fecha

		if($campofecha != "" )	{

		$ClausulaFecha = " AND ".$campofecha." = '".$SelFecha[$o][fechaC]."'";

		$campoidIDENT = "";
		$tablaIDENT = "";
		$ClausulaIdent = "";
						}
		else {

		$ClausulaFecha = " AND DATE(fechahora) = '".$SelFecha[$o][fechaC]."'";
		$campoidIDENT = "id_reg";
		$tablaIDENT = ",history_".$FormData[0][campaignid];
		$ClausulaIdent = " AND ".$FormData[0][campoid]." = $campoidIDENT ";

			}

		//aqui termina lo de la fecha



$DataReport = parent::sql_select($FormData[0][nombretabla].$tablaIDENT.$TablasNuevas,"count(".$CausulaData[$z][ncampo].")as cuenta",$CausulaData[$z][ncampo]." = '".$CausulaData[$z][identificador]."'".$condiciones.$CondicionesNuevas.$ClausulaIdent.$ClausulaFecha." GROUP BY ".$FormData[0][campoid],0);


		if(is_array($DataReport)){

		$Vals .= count($DataReport).",";
		$Arrtabledata[$CausulaData[$z][valor]][] = count($DataReport);

		}
		else {

		$Vals .= "0,";
		$Arrtabledata[$CausulaData[$z][valor]][] = 0;

		}

			$valoresD=substr($Vals,0,-1);

			}

			$ValoresSerie .= "data: [$valoresD]},";

			$Vals = "";

		}//------------------------------------------------------------------

	$ValoresSerie = substr($ValoresSerie,0,-1);

	//print_r($valorTData);

	$series = "

						series: [$ValoresSerie]

	";

	//aqui creamos la tabla de datos
	if($Muestratabla != 0){

	$ValoresArriba = explode(",",$Xtvalues);
	$ValoresArriba = array_unique($ValoresArriba);


	$this->excelexpR("DataRep");

	$topeID = 0;
	$topeDA = 0;

	?>

<table border="0" align="center" cellpadding="0" id="DataRep" cellspacing="2" class="rounded-corners-gray">
  <tr>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Campo</td>
<?

for( $i = 0 ; $i < count($ValoresArriba) ; $i++ ){

?>
<td align="center" bgcolor="#FFFFFF" class="textos_titulos"><?=$ValoresArriba[$i]?></td>
<?  } ?>
  </tr>
<? 	foreach ($Arrtabledata as $llave => $value){ $topeDA = 0; ?>

  <tr>
    <td bgcolor="#FFFFFF" class="textos_titulos"><?=$llave?></td>

	<? foreach ($value as $llave2 => $value2){ ?>
	<td align="center" bgcolor="#FFFFFF" class="textospadding">

    <? if($value2 != 0){ ?>

    <? $this->genera_modalF("mod$topeDA$topeID",1000,650); ?>
    <a class="mod<?=$topeDA.$topeID?> textospadding" href="modules/reports/rep_detailvewr.php?valorc=<?=$valorTData[$topeID]?>&fecha=<?=$ValoresArriba[$topeDA]?>&repid=<?=$idreporte?>&campoc=<?=$campofecha?>"><?=$value2?></a>

    <? }else { echo $value2; }

	$ARRTotal[$llave2][] = $value2;

	?>

    </td>
	<? $topeDA++; } ?>

  </tr>


<?  $topeID++; } ?>

<tr>
    <td bgcolor="#FFFFFF" class="textos_titulos" align="right">Total:</td>

   	<? foreach ($value as $llave2 => $value2){ ?>

    <td align="center" bgcolor="#FFFFFF" class="textospadding"><?=array_sum($ARRTotal[$llave2])?></td>

    <? } ?>

  </tr>

  </table>



    <? } ?>
		<script type="text/javascript">

			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container',
						defaultSeriesType: '<?=$TipoGraf?>',
						marginRight: 130,
						marginBottom: 25
					},
					title: {
						text: '<?=$CausulaRep[0][nombre]?>',
						x: -20 //center
					},
					subtitle: {
						text: '<?=$FormData[0][labeltabla]?>',
						x: -20
					},
					xAxis: {
						categories: [<?=$Xvalues?>]
					},
					yAxis: {
						title: {
							text: 'Valores'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					tooltip: {
						formatter: function() {
				                return '<b>'+ this.series.name +'</b><br/>'+
								'Dia:' + this.x +':'+ this.y;
						}
					},
					legend: {
						layout: 'horizontal',
						align: 'right',
						verticalAlign: 'top',
						x: -10,
						y: 0,
						borderWidth: 0,
						width:180
					},
						<?=$series?>
				});


			});

		</script>

  		<div id="container" style="width: 1100px; height: 550px; margin: 0 auto"></div>
	<?

	}

//Aqui terminamos la seccion del reporte grafico
//----------------------------------------------------------------------------------------------------------


// en esta funcion  lanzamos el detalle del reporte dinamico

function Genera_grid_repdina($idreporte,$fecha=0,$campofecha="",$valor){


$CausulaRep 	=	parent::sql_select("repdina_config","nombre,id_cam,id_form","id_rep = '$idreporte'",0);
$CausulaComp 	= 	parent::sql_select("repdina_compare","campo,condicion,valor","idrelconfig = '$idreporte'");
$FormData 		= 	parent::sql_select("autoform_tablas","labeltabla,nombretabla,campoid,campaignid","id_autoformtablas = '".$CausulaRep[0][id_form]."'",0);



//aqui complementamos con las tablas de datos de los modulos esopesiales
for($i=0 ; $i<count($CausulaComp);$i++){


	if(substr($CausulaComp[$i][campo],0,4) == "cme_")		{

	@$CampoData = parent::sql_select("acampos_esp","*","campon = '".substr($CausulaComp[$i][campo],4,20)."'",0);
	$ARRtablas[] = $CampoData[0][tabla];
	$ArrCondiciones[] = $CampoData[0][tabla].".idregistro = ".$FormData[0][campoid]." AND ".$CampoData[0][tabla].".idcampana = ".$FormData[0][campaignid];
	$CausulaComp[$i][campo] = substr($CausulaComp[$i][campo],4,20);


$condiciones .= " AND ".$CausulaComp[$i][campo]." ".$CausulaComp[$i][condicion]." '".$CausulaComp[$i][valor]."'";


																}else{

$condiciones .= " AND ".$CausulaComp[$i][campo]." ".$CausulaComp[$i][condicion]." '".$CausulaComp[$i][valor]."'";

																}
}

//aqui complementamos con las tablas de datos de los modulos esopesiales

	$CausulaData 	=	parent::sql_select("repdina_datashow","valor,identificador,ncampo","id_rep = '$idreporte'",0);


//aqui complementamos con las tablas de datos de los modulos esopesiales
for($i=0 ; $i<count($CausulaData);$i++){


	if(substr($CausulaData[$i][ncampo],0,4) == "cme_")		{

@$CampoData = parent::sql_select("acampos_esp","*","campon = '".substr($CausulaData[$i][ncampo],4,20)."'",0);
	$ARRtablas[] = $CampoData[0][tabla];
	$ArrCondiciones[] = $CampoData[0][tabla].".idregistro = ".$FormData[0][campoid]." AND ".$CampoData[0][tabla].".idcampana = ".$FormData[0][campaignid];
	$TraeCondiciones[$i][campo] = substr($CausulaData[$i][ncampo],4,20);
	$CampoCom = substr($CausulaData[$i][ncampo],4,20);

															}
	else{ 	$CampoCom = $CausulaData[$i][ncampo]; }
}


$CamposShow = parent::sql_select("repdina_camposm","campom","idfiltro = '$idreporte'",0);

for($i=0 ; $i<count($CamposShow);$i++){


	if(substr($CamposShow[$i][campom],0,4) == "cme_")		{

@$CampoData = parent::sql_select("acampos_esp","*","campon = '".substr($CamposShow[$i][campom],4,20)."'",0);
	$ARRtablas[] = $CampoData[0][tabla];
	$ArrCondiciones[] = $CampoData[0][tabla].".idregistro = ".$FormData[0][campoid]." AND ".$CampoData[0][tabla].".idcampana = ".$FormData[0][campaignid];
	$TraeCondiciones[$i][campo] = substr($CamposShow[$i][campom],4,20);

			$CademasMostrar .= $CampoData[0][tabla].".".substr($CamposShow[$i][campom],4,20).",";

			}else { $CademasMostrar .= $CamposShow[$i][campom].","; }

			$ARRcamposM[]=$CamposShow[$i][campom];


}

			$CademasMostrar = substr($CademasMostrar,0,-1);


if(is_array($ARRtablas))	{

		$NuevoARRtablas = array_unique($ARRtablas);
		$TablasNuevas = implode(",",$NuevoARRtablas);
		$TablasNuevas = ",".$TablasNuevas;

		$NuevoArrCondiciones = array_unique($ArrCondiciones);
		$CondicionesNuevas = implode(" AND ",$NuevoArrCondiciones);
		$CondicionesNuevas = " AND ".$CondicionesNuevas;

							 }

		//echo $CondicionesNuevas." **** <br>";

		$campoidIDENT = "id_reg";
		$tablaIDENT = ",history_".$FormData[0][campaignid];


//	echo "SELECT $CademasMostrar FROM ".$FormData[0][nombretabla].$TablasNuevas.$tablaIDENT." WHERE $campoidIDENT = ".$FormData[0][nombretabla]."_id $condiciones $CondicionesNuevas  AND $campofecha = '$fecha' AND DATE(fechahora) = '$fecha' AND ".$TraeCondiciones[0][campo]." = $valor GROUP BY ".$FormData[0][nombretabla]."_id";


/*

echo "<br><br><br> ********************** <br> ";

	print_r($TraeCondiciones);
echo "<br><br><br> ********************** <br><br><br> ";

*/


		if($campofecha != "" )	{


		$ClausulaFecha = " AND ".$campofecha." = '".$fecha."'";

		$campoidIDENT = "";
		$tablaIDENT = "";
		$ClausulaIdent = "1";
						}
		else {

		$ClausulaFecha = " AND DATE(fechahora) = '".$fecha."'";
		$campoidIDENT = "id_reg";
		$tablaIDENT = ",history_".$FormData[0][campaignid];
		$ClausulaIdent = "$campoidIDENT = ".$FormData[0][nombretabla]."_id";
			}


$DataReport = parent::sql_select(
$FormData[0][nombretabla].$TablasNuevas.$tablaIDENT,
$CademasMostrar.",".$FormData[0][nombretabla]."_id",
"$ClausulaIdent  $condiciones $CondicionesNuevas  $ClausulaFecha AND $CampoCom = $valor GROUP BY ".$FormData[0][nombretabla]."_id",0);



?>
<div align="center">

<? $this->excelexpR("DataRep"); ?>

<table border="0" align="center"  id="DataRep" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
  <tr>
<?
for( $i = 0 ; $i < count($ARRcamposM) ; $i++ ){

//empesamos a armar la tabla con los labesls de los campos

if(substr($ARRcamposM[$i],0,4) == "cme_")		{
$LabelC = parent::sql_select("acampos_esp","labelcampo","campon = '".substr($ARRcamposM[$i],4,40)."'");
}else{
$LabelC = parent::sql_select("autoform_config","labelcampo","nombrecampo = '$ARRcamposM[$i]'");
}

?>

  <td bgcolor="#FFFFFF" class="textos_titulos"><?=$LabelC[0][labelcampo]?></td>

<?  } ?>
    <td align="center" bgcolor="#FFFFFF" class="textos_titulos">Id Registro</td>
  </tr>
<? for( $i = 0 ; $i < count($DataReport) ; $i++ ){ ?>

  <tr>
<?
for( $o = 0 ; $o < count($ARRcamposM) ; $o++ ){

if(substr($ARRcamposM[$o],0,4) == "cme_"){


$CampoParam = parent::sql_select("acampos_esp","tipocampo,paramcampo,tabla,campoid","campon = '".substr($ARRcamposM[$o],4,40)."'");
$campoN = substr($ARRcamposM[$o],4,40);

//traemos los valores de las tablas especiales.

$dataespecial = parent::sql_select($CampoParam[0][tabla],$campoN,"idregistro = ".$DataReport[$i][$FormData[0][nombretabla]."_id"]." AND idcampana = ".$FormData[0][campaignid]." ORDER BY ".$CampoParam[0][campoid]." DESC LIMIT 1",0);
$DataReport[$i][$campoN] = $dataespecial[0][$campoN];

//terminamos los valores de tablas especiales

}else{
$CampoParam = parent::sql_select("autoform_config","tipocampo,paramcampo","nombrecampo = '$ARRcamposM[$o]'");
$campoN = $ARRcamposM[$o];
}

?>

    <td bgcolor="#FFFFFF" class="textospadding">

<?=Auto_Forms::armar_campo($CampoParam[0][tipocampo],"prevew","",$DataReport[$i][$campoN],0,1,0,$CampoParam[0][paramcampo]);?>

    </td>

<?  } ?>
    <td align="center" bgcolor="#FFFFFF" class="textospadding">


    <a href="/openc3/?sec=gestion&amp;mod=agent_console&amp;regediting=<?=$DataReport[$i][$FormData[0][nombretabla]."_id"]?>&amp;camediting=<?=$FormData[0][campaignid]?>" target="_blank">
	<?=$DataReport[$i][$FormData[0][nombretabla]."_id"]?>
    </a>


    </td>
  </tr>

<?  } ?>
</table>
</div>

<?



	}

//terminamos la funcion del detalle del reporte dinamico

//------------------------------------------------------------------------------------------------------


// en esta funcion  lanzamos el detalle del reporte dinamico

function Genera_csv_repdina($idreporte,$fechaini=0,$fechafin=0,$campofecha="",$idexp=0){


$CausulaRep 	=	parent::sql_select("repdina_config","nombre,id_cam,id_form","id_rep = '$idreporte'",0);
$CausulaComp 	= 	parent::sql_select("repdina_compare","campo,condicion,valor","idrelconfig = '$idreporte'",0);
$FormData 		= 	parent::sql_select("autoform_tablas","labeltabla,nombretabla,campoid,campaignid","id_autoformtablas = '".$CausulaRep[0][id_form]."'",0);



//aqui complementamos con las tablas de datos de los modulos esopesiales
for($i=0 ; $i<count($CausulaComp);$i++){


	if(substr($CausulaComp[$i][campo],0,4) == "cme_")		{

	@$CampoData = parent::sql_select("acampos_esp","*","campon = '".substr($CausulaComp[$i][campo],4,20)."'",0);
	$ARRtablas[] = $CampoData[0][tabla];
	$ArrCondiciones[] = $CampoData[0][tabla].".idregistro = ".$FormData[0][campoid]." AND ".$CampoData[0][tabla].".idcampana = ".$FormData[0][campaignid];
	$TraeCondiciones[$i][campo] = substr($CausulaComp[$i][campo],4,20);

$condiciones .= " AND ".$CampoData[0][tabla].".".substr($CausulaComp[$i][campo],4,20)." ".$CausulaComp[$i][condicion]." '".$CausulaComp[$i][valor]."'";

																}else{

$condiciones .= " AND ".$CausulaComp[$i][campo]." ".$CausulaComp[$i][condicion]." '".$CausulaComp[$i][valor]."'";

																}
}

//aqui complementamos con las tablas de datos de los modulos esopesiales

	$CausulaData 	=	parent::sql_select("repdina_datashow","valor,identificador,ncampo","id_rep = '$idreporte'",0);


//aqui complementamos con las tablas de datos de los modulos esopesiales
for($i=0 ; $i<count($CausulaData);$i++){


	if(substr($CausulaData[$i][ncampo],0,4) == "cme_")		{

@$CampoData = parent::sql_select("acampos_esp","*","campon = '".substr($CausulaData[$i][ncampo],4,20)."'",0);
	$ARRtablas[] = $CampoData[0][tabla];
	$ArrCondiciones[] = $CampoData[0][tabla].".idregistro = ".$FormData[0][campoid]." AND ".$CampoData[0][tabla].".idcampana = ".$FormData[0][campaignid];
	$TraeCondiciones[$i][campo] = substr($CausulaData[$i][ncampo],4,20);

															}
}


$CamposShow = parent::sql_select("repdina_camposm","campom","idfiltro = '$idreporte'",0);

for($i=0 ; $i<count($CamposShow);$i++){


	if(substr($CamposShow[$i][campom],0,4) == "cme_")		{

@$CampoData = parent::sql_select("acampos_esp","*","campon = '".substr($CamposShow[$i][campom],4,20)."'",0);
	$ARRtablas[] = $CampoData[0][tabla];
	$ArrCondiciones[] = $CampoData[0][tabla].".idregistro = ".$FormData[0][campoid]." AND ".$CampoData[0][tabla].".idcampana = ".$FormData[0][campaignid];
	$TraeCondiciones[$i][campo] = substr($CamposShow[$i][campom],4,20);

	$CamposOrden .= $FormData[0][campoid].",";

			$CademasMostrar .= $CampoData[0][tabla].".".substr($CamposShow[$i][campom],4,20).",";

			}else { $CademasMostrar .= $CamposShow[$i][campom].","; }

			$ARRcamposM[]=$CamposShow[$i][campom];


}

			$CademasMostrar = substr($CademasMostrar,0,-1);
			$CamposOrden = substr($CamposOrden,0,-1);


if(is_array($ARRtablas))	{

		$NuevoARRtablas = array_unique($ARRtablas);
		$TablasNuevas = implode(",",$NuevoARRtablas);
		$TablasNuevas = ",".$TablasNuevas;

		$NuevoArrCondiciones = array_unique($ArrCondiciones);
		$CondicionesNuevas = implode(" AND ",$NuevoArrCondiciones);
		$CondicionesNuevas = " AND ".$CondicionesNuevas;

							 }

		$campoidIDENT = "id_reg";
		$tablaIDENT = ",history_".$FormData[0][campaignid];


//	echo "SELECT $CademasMostrar FROM ".$FormData[0][nombretabla].$TablasNuevas.$tablaIDENT." WHERE $campoidIDENT = ".$FormData[0][nombretabla]."_id $condiciones $CondicionesNuevas  AND $campofecha = '$fecha' AND DATE(fechahora) = '$fecha' AND ".$TraeCondiciones[0][campo]." = $valor GROUP BY ".$FormData[0][nombretabla]."_id";

for($y=0 ; $y < count($CausulaData);$y++){ //Empiesa el for que saca todos los valores
}//termina el for que saca todos los valores


		if($campofecha != "" )	{


		$ClausulaFecha = "AND DATE($campofecha) BETWEEN '$fechaini' AND '$fechafin'";

		$campoidIDENT = "";
		$tablaIDENT = "";
		$ClausulaIdent = "1";
						}
		else {

		$ClausulaFecha = " AND DATE(fechahora) BETWEEN '$fechaini' AND '$fechafin' ";
		$campoidIDENT = "id_reg";
		$tablaIDENT = ",history_".$FormData[0][campaignid];
		$ClausulaIdent = " $campoidIDENT = ".$FormData[0][nombretabla]."_id";
			}


$DataReport = parent::sql_select(
$FormData[0][nombretabla].$TablasNuevas.$tablaIDENT,
$CademasMostrar.",".$FormData[0][nombretabla]."_id",
"$ClausulaIdent  $condiciones $CondicionesNuevas $ClausulaFecha GROUP BY ".$FormData[0][nombretabla]."_id ORDER BY $CamposOrden DESC",0);



//---------------------------------------------------------------

for( $i = 0 ; $i < count($ARRcamposM) ; $i++ ){

//empesamos a armar la tabla con los labesls de los campos

if(substr($ARRcamposM[$i],0,4) == "cme_")		{
$LabelC = parent::sql_select("acampos_esp","labelcampo","campon = '".substr($ARRcamposM[$i],4,40)."'");
}else{
$LabelC = parent::sql_select("autoform_config","labelcampo","nombrecampo = '$ARRcamposM[$i]'");
}

$htm .= $LabelC[0][labelcampo]."|";

}
$htm .= "Id Registro \r";

for( $i = 0 ; $i < count($DataReport) ; $i++ ){

for( $o = 0 ; $o < count($ARRcamposM) ; $o++ ){

if(substr($ARRcamposM[$o],0,4) == "cme_")		{
$CampoParam = parent::sql_select("acampos_esp","tipocampo,paramcampo,campoid,tabla","campon = '".substr($ARRcamposM[$o],4,40)."'",0);
$campoN = substr($ARRcamposM[$o],4,40);


//traemos los valores de las tablas especiales.

$dataespecial = parent::sql_select($CampoParam[0][tabla],$campoN,"idregistro = ".$DataReport[$i][$FormData[0][nombretabla]."_id"]." AND idcampana = ".$FormData[0][campaignid]." ORDER BY ".$CampoParam[0][campoid]." DESC LIMIT 1",0);
$DataReport[$i][$campoN] = $dataespecial[0][$campoN];

//terminamos los valores de tablas especiales


}else{
$CampoParam = parent::sql_select("autoform_config","tipocampo,paramcampo","nombrecampo = '$ARRcamposM[$o]'",0);
$campoN = $ARRcamposM[$o];
}

//echo $campoN."***".$DataReport[$i][$campoN]."<br><br>";

$htm .= Auto_Forms::armar_campo($CampoParam[0][tipocampo],"prevew","",$DataReport[$i][$campoN],0,1,0,$CampoParam[0][paramcampo])."|";


}

$htm .= $DataReport[$i][$FormData[0][nombretabla]."_id"]." \r";


  }




$unirfecha= str_ireplace("-","",date('Y-m-d'));

$new_report=fopen("../../tmp/autogenerado".$unirfecha.".csv","w");

fwrite($new_report, $htm);

fclose($new_report);

//actiualizamos el archivo en la tabla de reportes

if($idexp != 0){

parent::update_regs("cron_export","autogenerado = 'autogenerado".$unirfecha.".csv'","id_cronexport = '$idexp'",0);

	}

}

//terminamos la funcion del detalle CSV del reporte dinamico

//------------------------------------------------------------------------------------------------------


function trae_dato_agente($campo,$numerag){ //con esta funcion se traen los datos del agente dependiendo de el campoi solicitado

	mysql_select_db("octres");

	$agentedato=parent::sql_select("agents",$campo,"number = '$numerag'");

	return $agentedato[0][$campo];

	}//con esta funcion se traen los datos del agente dependiendo de el campoi solicitado


function tiempo_corrido($HoraIni,$HoraFin){//esta funcion regresa el tiempo quye lleva desde un momneot a otro en segundos.

	$h1d=explode(":",$HoraIni);
	$h2d=explode(":",$HoraFin);

	$hora1=mktime($h1d[0],$h1d[1],$h1d[2],0,0,0);
	$hora2=mktime($h2d[0],$h2d[1],$h2d[2],0,0,0);

	$tiempo = $hora2 - $hora1;
	$tiempoM = number_format($tiempo / 60,2);

	if($tiempo > 60 and $tiempoM < 60){ $tiempo = number_format($tiempo / 60,2); $pos="Min";}
	elseif($tiempoM > 60 ){ $tiempo = number_format($tiempo / 60 / 60,2); $pos="Hor"; }
	else{$pos="Seg";}

	return $tiempo." ".$pos;

	}//esta funcion regresa el tiempo quye lleva desde un momneot a otro en segundos.


//////----- Aqui empieza la seccion de reportes de gestion del open C3 apoyado en Callcenter de Elastix-------//////

function traer_datos_asesor_callmodule($idasesor,$campo){

		mysql_select_db("call_center");

$datoa=parent::sql_select("agent",$campo,"id = '$idasesor' LIMIT 0,1");

	return $datoa[0][$campo];

	}//................................................................................

function traer_nombre_asesor_callmodule($idasesor){

		mysql_select_db("call_center");

$datoa=parent::sql_select("agent","number","id = '$idasesor' LIMIT 0,1");

		mysql_select_db("octres");

$datoN=parent::sql_select("agents","name","number = '".$datoa[0][number]."' LIMIT 0,1");

		return $datoN[0][name];

	}//................................................................................


function traer_exten_asesor_callmodule($idasesor){

		mysql_select_db("call_center");

$datoa=parent::sql_select("agent","number","id = '$idasesor' LIMIT 0,1");

		mysql_select_db("octres");

$datoN=parent::sql_select("agents","extension","number = '".$datoa[0][number]."' LIMIT 0,1");

		return $datoN[0][extension];

	}//................................................................................

function traer_finconexion_callmodule($idasesor,$fecha){

	mysql_select_db("call_center");

	$datoa=parent::sql_select("audit","(datetime_end) AS HoraFinal","id_agent = '$idasesor' AND DATE(datetime_end) = '$fecha' ORDER BY datetime_end DESC");

	if(is_array($datoa)){
	return $datoa[0][HoraFinal];
	}else{
	return "<font color='#FF0000'>No registra salida - Error de agente</font>";
	}

}//................................................................................

function calcular_segundos_conexion_callmodule($idAgente,$inicio,$final){

		mysql_select_db("call_center");

$Hora1unix1=array();
$Hora2unix1=array();

if($final == "<font color='#FF0000'>No registra salida - Error de agente</font>"){ $comParaFecha = "AND DATE(datetime_init) = '$inicio'";}
else {$comParaFecha = "AND DATE(datetime_init) BETWEEN DATE('$inicio') AND DATE('$final')";}


$datoa=parent::sql_select("audit","MIN(datetime_init) AS HoraInicial,MAX(datetime_end) AS HoraFinal","id_agent = '$idAgente' $comParaFecha GROUP BY DATE(datetime_init) ORDER BY datetime_end ASC",0);

if(is_array($datoa)){

	for($i=0 ; $i < count($datoa) ; $i++ ){

$secciones1=explode(" ",$datoa[$i][HoraInicial]);
$Hora1=explode(":",$secciones1[1]);
$fecha1=explode("-",$secciones1[0]);

$Hora1unix1[]=@mktime($Hora1[0],$Hora1[1],$Hora1[2],$fecha1[1],$fecha1[2],$fecha1[0]);

////---------------------------------------

$secciones2=explode(" ",$datoa[$i][HoraFinal]);
$Hora2=explode(":",$secciones2[1]);
$fecha2=explode("-",$secciones2[0]);
$Hora2unix1[]=@mktime($Hora2[0],$Hora2[1],$Hora2[2],$fecha2[1],$fecha2[2],$fecha2[0]);

	}

}//--

 	$segundos=array_sum($Hora2unix1) - array_sum($Hora1unix1);

	return $segundos;

}//................................................................................

function traer_acd_hold_segundos_callmodule($idasesor,$fecha,$fecha1,$campo,$ext){

mysql_select_db("call_center");
$datoa=parent::sql_select("calls","SUM($campo) AS Segundos","id_agent = '$idasesor' AND DATE(fecha_llamada) BETWEEN '$fecha' AND '$fecha1' AND status = 'Success'");

 	if(is_array($datoa)){ $tiempo1 = $datoa[0][Segundos]; }


/*mysql_select_db("asteriskcdrdb");
$datoaCDR=parent::sql_select("cdr","SUM(billsec) AS Segundos","src = '$ext' AND DATE(calldate) BETWEEN '$fecha' AND '$fecha1' AND disposition = 'ANSWERED' AND dst NOT REGEXP '8888'");
if(is_array($datoaCDR)){ $tiempo2 = $datoaCDR[0][Segundos]; }*/

	if($tiempo1 == "" and $tiempo2 == ""){

		return "<font color='#FF0000'> No registra gestion </font>";

	}else{ return $tiempo1 + $tiempo2; }


}//................................................................................


function traer_breaks_callmodule($idasesor,$fecha,$fecha2){

		mysql_select_db("call_center");

$datoa=parent::sql_select("audit","SUM( TIMESTAMPDIFF(MINUTE , datetime_init, datetime_end ) ) *60 AS tiempo","id_agent = '$idasesor' AND DATE(datetime_end) BETWEEN '$fecha' AND '$fecha2' AND id_break != 0 AND id_break != 3");

 if(is_array($datoa)){ return $datoa[0][tiempo]; }
 else{return "<font color='#FF0000'> No registra gestion </font>";}

}//................................................................................


function traer_acd_llamadas_callmodule($idasesor,$fecha,$fecha2,$ext){

	mysql_select_db("call_center");

if($fecha2 == "<font color='#FF0000'>No registra salida - Error de agente</font>"){
$comParaFecha = "AND DATE(fecha_llamada) = DATE('$fecha')";
$comParaFechaCDR = "AND DATE(calldate) = DATE('$fecha')";}
else {
$comParaFecha = "AND DATE(fecha_llamada) BETWEEN DATE('$fecha') AND DATE('$fecha2')";
$comParaFechaCDR = "AND DATE(calldate) BETWEEN DATE('$fecha') AND DATE('$fecha2')";}

$datoa=parent::sql_select("calls","duration","id_agent = '$idasesor' $comParaFecha AND duration > 0");

$numerollamadas=0;

	if(is_array($datoa)){

			for($i=0 ; $i < count($datoa) ; $i++ ){

			$numerollamadas++;

			}

		}

//------

	mysql_select_db("asteriskcdrdb");

$datoaCDR=parent::sql_select("cdr","billsec","src = '$ext' $comParaFechaCDR AND duration > 0");


	if(is_array($datoaCDR)){

			for($i=0 ; $i < count($datoaCDR) ; $i++ ){

			$numerollamadas++;

			}

		}

	if($numerollamadas == 0){return "<font color='#FF0000'> No registra gestion</font>";}
	else{ return $numerollamadas; }

}//................................................................................

function ultimo_break_nombre_callmodule($idasesor){

		mysql_select_db("call_center");


$datoa=parent::sql_select("audit,agent","id_break,TIME(datetime_init) as hora","number = '$idasesor' AND agent.id = id_agent AND estatus = 'A' ORDER BY datetime_init DESC LIMIT 0,1");

 if(is_array($datoa)){

$datob=parent::sql_select("break","name","id = '".$datoa[0][id_break]."'");
 if(is_array($datob)){
return $datob[0][name]."|".$datoa[0][hora];
 }

 }else{ return ""; }


}//................................................................................

function traer_asistencia($agenten,$fecha){

	mysql_select_db("call_center");

	$datoa=parent::sql_select("agent,audit","duration","DATE(datetime_init) = '$fecha' AND number = '$agenten' AND agent.id = id_agent");

	if(is_array($datoa)){
	return "<img width='25' height='25' src='".$this->RutaHTTP."/imgs/verde.gif'";
	}else{
	return "<img width='25' height='25' src='".$this->RutaHTTP."/imgs/rojo.gif'";
	}

}//................................................................................

//-----------------------------------------------------------

function traer_id_registro($telefononumero){ //------------------------------------------------

mysql_select_db("octres");

	$dataid = parent::sql_select("autof_formulario_1","autof_formulario_1_id","af11_34 = '$telefononumero' OR '$telefononumero' REGEXP af11_33 LIMIT 0,1");
	if(is_array($dataid)){
	return $dataid[0][autof_formulario_1_id];
	}else{
	return "Numero Sin Registro";
	}


} //-----------------------------------------------------------------------------------------------


function traer_id_asesor_cid($idasesor,$campo){

		mysql_select_db("call_center");

		$queryNumC = parent::sql_select("agent","number","id = '$idasesor' LIMIT 0,1",0);

		mysql_select_db("octres");
		$queryNumO = parent::sql_select("agents",$campo,"number = '".$queryNumC[0][number]."' LIMIT 0,1");

		if(is_array($queryNumO)){
		return $queryNumO[0][$campo];
		}else{
		return "Sin Agente.";
		}

}//................................................................................

function traer_id_asesor_cext($ext,$campo){


		mysql_select_db("octres");
		$queryNumO = parent::sql_select("agents",$campo,"extension = '".$ext."' LIMIT 0,1");

		if(is_array($queryNumO)){
		return $queryNumO[0][$campo];
		}else{
		return "Sin Agente.";
		}

}//................................................................................



function report_metas($ext,$campo){


		mysql_select_db("octres");
		$queryNumO = parent::sql_select("agents",$campo,"extension = '".$ext."' LIMIT 0,1");

		if(is_array($queryNumO)){
		return $queryNumO[0][$campo];
		}else{
		return "Sin Agente.";
		}

}//................................................................................




///-------------------

function tiempo_segundos($segundos){
$minutos=$segundos/60;
$horas=floor($minutos/60);
$minutos2=$minutos%60;
$segundos_2=$segundos%60%60%60;
if($minutos2<10)$minutos2='0'.$minutos2;
if($segundos_2<10)$segundos_2='0'.$segundos_2;

if($segundos<60){ /* segundos */
$resultado= "00:00:".round($segundos).'';
}elseif($segundos>60 && $segundos<3600){/* minutos */
$resultado= "00:".$minutos2.':'.$segundos_2.'';
}else{/* horas */
$resultado= $horas.':'.$minutos2.':'.$segundos_2.'';
}
return $resultado;
}

	function genera_modalF($linkclase="",$ancho="",$alto="",$urlform="",$div=""){

			?>
	<script>
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$(".<?=$linkclase?>").colorbox({
			width:"<?=$ancho?>", height:"<?=$alto?>",top:"2%",iframe:true<? if($urlform != "" ){  ?>,
			onClosed:function(){ EnviarLinkJ('<?=$div?>','<?=$urlform?>');}
			<? } ?>});
			//Example of preserving a JavaScript event for inline calls.
			$("#click").click(function(){
				$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});
		});
	</script>
			<?

		}



function excelexpR($idtabla){

?>
<script language="javascript">
$(document).ready(function() {
     $(".botonExcel").click(function(event) {
     $("#datos_a_enviar").val( $("<div>").append( $("#<?=$idtabla?>").eq(0).clone()).html());
     $("#FormularioExportacion").submit();
});
});
</script>

<form action="/openc3/libs/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
<p>Exportar a Excel  <img src="/openc3/imgs/export_to_excel.gif" class="botonExcel" /></p>
<div style="display:none"><textarea id="datos_a_enviar" name="datos_a_enviar" cols="" rows=""></textarea></div>
</form>

<?

	}


}
?>
