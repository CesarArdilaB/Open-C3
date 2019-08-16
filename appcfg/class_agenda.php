<?
/*esta clase sera utilizada para generar trar e insertar datos en la agenda del sistema.

Aqui los cambios que tiene en cada actualizacion:

*/

class Agenda extends Man_Mysql{
	
	var $RutaRaizINC;
	var $RutaHTTP;
	var $RutaRaiz;

	//genera la agenda segun la fecha seleccionada y opcional el mensagero.
	function show_agenda($fecha,$vewtipe=0,$idmensajero=0,$idregistro,$idcampana=0){

		date_default_timezone_set('America/Bogota');

		$fechaselunix 		= 	$this->tiempounix($fecha);
		$fechahoy			=	date("Y-n-j");
		$fechahoyunix 		=	$this->tiempounix($fechahoy);
		
		if($fechaselunix < $fechahoyunix){
		
		$mensajeNO="No se agendaron citas para: ";
		$mensajeSI="Se agendaron para: ";
		$vewtipe = 0;
			//aqui traemos que agenda ahy para hoy en caso de estar loqueado un mensajero el traera la agenda para dicho mensajero.
		$MensajerosLista 	= 	parent::sql_select("agenda","*","fecha = '$fecha' GROUP BY idmensajero",0);

		}else 	{//aqui ponemos los mensajes para las fechas anteriores.
		
		$mensajeNO="No hay citas para: ";
		$mensajeSI="Se agendaron para: ";

		$MensajerosLista =	parent::sql_select("mensajeros","id_mensajero as idmensajero","inactivo = 0 AND nolabora = 0",0);

				}//si la fecha es actual

	if(is_array($MensajerosLista)){ 	
	?>
<?=$mensajeSI?> <?=$fecha?>
<table width="0" border="0" align="center" cellspacing="4" class="rounded-corners-blanco">
  <tr>
    <td colspan="3" class="textos_titulos">Mensajeros Disponibles</td>
  </tr>
<? 	for($i = 0 ;$i < count($MensajerosLista) ; $i++) { 

	$DataMensajero 	= parent::sql_select("mensajeros","*","id_mensajero = '".$MensajerosLista[$i][idmensajero]."'",0);
	$CitasMensajero = parent::sql_select("agenda","*","idmensajero = '".$MensajerosLista[$i][idmensajero]."' AND fecha = '$fecha'",0);
	$numeroCitas = $this->numerocitas($fecha,$MensajerosLista[$i][idmensajero]);
	$NcitasDisp = $this->agenda_disp($MensajerosLista[$i][idmensajero],$fecha);
?>
  <tr>
    <td bgcolor="#EEEEEE" class="textos">
	<div class="textos_negros"><?=$DataMensajero[0][name]?></div>
    <? if(is_array($CitasMensajero)){ ?>
	
    <table width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="textos_negros">Id Registro&nbsp;</td>
    <td class="textos_negros">Comentario&nbsp;</td>
  </tr>
<? for($u = 0 ;$u < count($CitasMensajero) ; $u++) { ?>
  <tr>
    <td class="textos" align="center"><?=$CitasMensajero[$u][idregistro]?>&nbsp;</td>
    <td class="textos" align="center"><?=$CitasMensajero[$u][comentarios]?>&nbsp;</td>
  </tr>
<? } ?> 
</table>

	
	<? } ?>
    </td>
    <td bgcolor="#EEEEEE" class="textos">
	<? if($vewtipe == 1 and $NcitasDisp > 0){ ?>
    <a href="/openc3/modules/agenda/addcita_final.php?idmensajero=<?=$MensajerosLista[$i][idmensajero]?>&idregistro=<?=$idregistro?>&fecha=<?=$fecha?>&idcampana=<?=$idcampana?>" class="textos_negros">Agregar Cita</a>
	<? }else{ ?>
    <div class="textos">Agregar Cita</div>
	<? } ?>
    </td>
    <td bgcolor="#EEEEEE" class="textos">Disp: <?=$NcitasDisp?></td>
  </tr>
<? } ?> 
</table>

	
	<? 
	}else{
	?>

	<?=$mensajeNO?><br><?=$fecha?>

	<? } 	
		
		
	}//aqui temina la funcon que mustra la agenda regin fecha
	


//Agendar cita para los agentes


	//genera la agenda segun la fecha seleccionada y opcional el mensagero.
	function show_agenda_agent($fecha,$vewtipe=0,$idmensajero=0,$idregistro,$idcampana=0){
		date_default_timezone_set('America/Bogota');

		$verificaAG = $this->verifica_agenda($idregistro,$idcampana,$fecha);

		if($verificaAG == 0){ //verificamos que no este agendado

		$fechaselunix 	= 	$this->tiempounix($fecha);
		$fechahoy		=	date("Y-n-j");
		$fechahoyunix 		=	$this->tiempounix($fechahoy);
		
		if($fechaselunix < $fechahoyunix){
		
		$mensajeNO="No se agendaron citas para: ";
		$mensajeSI="Se agendaron para: ";
		$vewtipe = 0;
			//aqui traemos que agenda ahy para hoy en caso de estar loqueado un mensajero el traera la agenda para dicho mensajero.
		$MensajerosLista 	= 	parent::sql_select("agenda","*","fecha = '$fecha' GROUP BY idmensajero",0);

		}else 	{//aqui ponemos los mensajes para las fechas anteriores.
		
		$mensajeNO="No hay citas para: ";
		$mensajeSI="Se agendaron para: ";

		$MensajerosLista 	= 	parent::sql_select("mensajeros","id_mensajero as idmensajero","inactivo = 0 AND nolabora = 0",0);

				}//si la fecha es actual

	if(is_array($MensajerosLista)){ 	
	?>
<?=$mensajeSI?> <?=$fecha?>
<table width="0" border="0" align="center" cellspacing="4" class="rounded-corners-blanco">
  <tr>
    <td colspan="3" class="textos_titulos">Agendar cita para este dia</td>
  </tr>
<? 	for($i = 0 ;$i < count($MensajerosLista) ; $i++) { 

	$DataMensajero 	= parent::sql_select("mensajeros","*","id_mensajero = '".$MensajerosLista[$i][idmensajero]."'",0);
	$CitasMensajero = parent::sql_select("agenda","*","idmensajero = '".$MensajerosLista[$i][idmensajero]."' AND fecha = '$fecha'",0);
	$numeroCitas = $this->numerocitas($fecha,$MensajerosLista[$i][idmensajero]);
	@$NcitasDisp = $DataMensajero[0][maxcitas] - $numeroCitas;
	
	$CitasDispARR[]=$NcitasDisp;
	
 } ?> 
<tr>
    <td bgcolor="#EEEEEE" class="textos">
	<div class="textos_negros">Nuevas Citas</div>
    </td>
    <td bgcolor="#EEEEEE" class="textos">
	<? 
	
	$CitasTemps = parent::sql_select("agenda_tmp","count(idregistro) as cuenta","fecha = '$fecha'",0);
	$CitasTotalDisp = $this->agenda_disp(0,$fecha);
	
	
	if($vewtipe == 1 and $CitasTotalDisp > 0){ ?>
    <a href="/openc3/modules/agenda/addcita_temp.php?idregistro=<?=$idregistro?>&fecha=<?=$fecha?>&idcam=<?=$idcampana?>" class="textos_negros">Agregar Cita</a>
	<? }else{ ?>
    <div class="textos">Agregar Cita</div>
	<? } ?>
    </td>
    <td bgcolor="#EEEEEE" class="textos">Disp: <?=$CitasTotalDisp?></td>
</tr> 
</table>

	
	<? 
	}else{
	?>

	<?=$mensajeNO?><br><?=$fecha?>

	<? } 	
		
		}else{ echo"El Registro ya esta agendado para esta fecha: $fecha"; }//verificamos que no este agendado
		
	}//aqui temina la funcon que mustra la agenda regin fecha


//Agendar cita para los agentes


function regdates($idregistro,$fecha,$mayormenor,$idcampana){// esta funcion trae los historiales de las citas de un id.
	$TraerCitasReg = parent::sql_select("agenda","*","fecha $mayormenor '$fecha' AND idregistro = $idregistro AND idcampana = '$idcampana' GROUP BY numeroref,fecha",0);
	$TraerCitasTmp = parent::sql_select("agenda_tmp","*","fecha $mayormenor '$fecha' AND idregistro = $idregistro AND idcampana = '$idcampana' GROUP BY numeroref,fecha",0);

if(is_array($TraerCitasReg)){
	?>
<table width="0" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="textos_titulos">Fecha</td>
    <td class="textos_titulos">Mensajero</td>
    <td class="textos_titulos">Feedback</td>
    <td class="textos_titulos">Comentario Final</td>
    <td class="textos_titulos">Entrego</td>
    <td class="textos_titulos">Agente que agendo</td>
    <td class="textos_titulos">#De Visita</td>
  </tr>
<? for($i = 0 ;$i < count($TraerCitasReg) ; $i++) { 
	
	$DataAgente = parent::sql_select("agents","name","id_agents = '".$TraerCitasReg[$i][idagente]."'",0);
	if(is_array($DataAgente)){ $AgenteText = $DataAgente[0][name]; } else { $AgenteText = ""; }

	
	$MensajeroData = parent::sql_select("mensajeros","*","id_mensajero = ".$TraerCitasReg[$i][idmensajero]."",0);
	if(is_array($MensajeroData)){ $MensajeroText = $MensajeroData[0][name]; } else { $MensajeroText = ""; }

	$MensajeroEntregoData = parent::sql_select("mensajeros","*","id_mensajero = '".$TraerCitasReg[$i][idmensajero_entrego]."'",0);
	
		
	
?>
  <tr>
    <td class="textos"><?=$TraerCitasReg[$i][fecha]?>&nbsp;</td>
    <td class="textos"><?=$MensajeroText?>&nbsp;</td>
    <td class="textos">
	<? $FeedBackData = parent::sql_select("agenda_estados","estado","id_estado = '".$TraerCitasReg[$i][feedback]."'",0); ?>
      <? if(is_array($FeedBackData)){echo $FeedBackData[0][estado];}?> <br> <?=$TraerCitasReg[$i][feddbackcoments]?>&nbsp;</td>
    <td class="textos"><?=$TraerCitasReg[$i][feddbackcoments]?></td>
    <td class="textos"><? if(is_array($MensajeroEntregoData)){echo $MensajeroEntregoData[0][name];}?>&nbsp;</td>
    <td class="textos"><?=$AgenteText?>&nbsp;</td>
    <td align="center" class="textos"><?=$i+1?></td>
  </tr>
<? } ?> 
</table>

<?	
}//verificamos si ahy resultados
else{ echo "No hay citas."; }

if(is_array($TraerCitasTmp)){
	?>
<table width="0" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="textos_titulos">Fecha</td>
    <td class="textos_titulos">Mensajero</td>
    <td class="textos_titulos">Cometarios</td>
    <td class="textos_titulos">Agente que agendo</td>
  </tr>
<? for($i = 0 ;$i < count($TraerCitasTmp) ; $i++) { 

	$DataAgente = parent::sql_select("agents","name","id_agents = '".$TraerCitasTmp[$i][idagente]."'",0);
	if(is_array($DataAgente)){ $AgenteText = $DataAgente[0][name]; } else { $AgenteText = ""; }


?>
  <tr>
    <td class="textos"><?=$TraerCitasTmp[$i][fecha]?>&nbsp;</td>
    <td class="textos">Sin Asignar</td>
    <td class="textos"><?=$TraerCitasTmp[$i][comentarios]?>&nbsp;</td>
    <td class="textos"><?=$AgenteText?>&nbsp;</td>
  </tr>
<? } ?> 
</table>

<?	
}//verificamos si ahy resultados
else{ echo "No hay pre agendas."; }




	} //termina funcion que saca citas de un registro.	
	
	
function tiempounix($fecha)	{//esta funcion manda una fecha a unixtime para hacer la comparacion.
	
	$fechaARR=explode("-",$fecha);
	$fechaunix=@mktime(0,0,0,$fechaARR[1],$fechaARR[2],$fechaARR[0]);
	return $fechaunix;
	
						}//esta funcion manda una fecha a unixtime

function numerocitas($fecha,$idmensajero)	{//esta funcion trae el numero de citas de un mensajero para un dia.
	
	$TraerNumeroCitas = parent::sql_select("agenda","count(idmensajero) as ncitas","fecha = '$fecha' AND idmensajero = $idmensajero",0);
	if(!is_array($TraerNumeroCitas))	{	
		return 0;		
					}
		else		{
	return $TraerNumeroCitas[0][ncitas];
					}
						}//esta funcion trae el numero de citas de un mensajero para un dia.


//con esta funcion traemos los parametros de la agenda para un registro con su respectivo unique id

	function agenda_datos($idregistro,$idcampana,$campo){
		
	$AgendaData = parent::sql_select("agenda_tmp","$campo","idregistro = '$idregistro' AND idcampana = $idcampana",0);
		
		if(is_array($AgendaData))
		return $AgendaData[0][$campo];	
		else
		return "";	

		
		}

//-----------------------------------------------------------------------------------------------
	
	//esta funcion nos regreza la capasidad que tiene aun la agenda o un mensajero espesifico.

	function agenda_disp($idmensajero=0,$fecha){
	
	if($idmensajero != 0){
		$clausulaM = "id_mensajero = $idmensajero";
		$clausulaAG = "idmensajero = $idmensajero";
		$SelCuentaM = "maxcitas as cuenta";
		}
		else {
		$clausulaAG = 1;
		$clausulaM = 1;
		$SelCuentaM = "sum(maxcitas) as cuenta";
		}
		
		
	$DispMensajero 	= parent::sql_select("mensajeros",$SelCuentaM,"$clausulaM AND inactivo = 0 AND nolabora=0",0);
	$CitasMensajero = parent::sql_select("agenda","*","$clausulaAG AND fecha = '$fecha' GROUP BY numeroref",0);

	if($idmensajero == 0){
	$CitasTemporales = parent::sql_select("agenda_tmp","*","fecha = '$fecha' GROUP BY numeroref",0);

	if(is_array($CitasTemporales))
	{	$TotalAgendasTMP = count($CitasTemporales);	}

	}else { $TotalAgendasTMP = 0; }



	if(is_array($DispMensajero))
	{	$TotalDisp = $DispMensajero[0][cuenta];	}
	
	if(is_array($CitasMensajero))
	{	$TotalAgendas = count($CitasMensajero);	}
	else{ $TotalAgendas = 0; }

	
	return $TotalDisp - ($TotalAgendas + $TotalAgendasTMP);
		
		}


//-----------------------------------------------------------------------------------------------
//esta funcion agenda las temporales. busca el id segun la campana y manda la orden si es bolsa o pseudo
function agendarTMP($idregistro,$idcam,$idagente,$fecha,$ValorCallg="F",$recoleccion=0,$hora="",$comentarios=""){


//aqui controlamos si es recoleccion o es con inventario

if($recoleccion == 0){
	
	$TopeAG = $this->agenda_disp(0,$fecha);	
		
	if($TopeAG > 0){ // aqui verificamos el nombre de la agenda
	
	$VarfAgenda  = $this->verifica_agenda($idregistro,$idcam,$fecha);
	
	if ($VarfAgenda == 0){//verificamos que no este agendado
		
$InventarioData	= parent::sql_select("inv_inventario","bolsaout,scodigo","idcampana = $idcam AND idregistro = $idregistro",0);

$AgCamConfig = parent::sql_select("agenda_camconfig","gestioncallc","idcampana = '$idcam'",0);


if(is_array($InventarioData)){ 


if($InventarioData[0][bolsaout] != "")
{ 

$InventarioDataBolsa = parent::sql_select("inv_inventario","idregistro,bolsaout","idcampana = $idcam AND bolsaout = '".$InventarioData[0][bolsaout]."'  AND idregistro != 0",0);

//echo "**** ::".$ValorCallg;


for($i=0;$i<count($InventarioDataBolsa);$i++){


	if($ValorCallg != "F")	{
		
	//echo "*** Si Se Esta Metiendo ****";
	$camposARR[$AgCamConfig[0][gestioncallc]] = $ValorCallg;
	CamposManage::UpdateDataAF($camposARR,$InventarioDataBolsa[$i][idregistro],$idagente,"Agendamiento Masivo");
		
							}
	parent::inser_data("agenda_tmp","numeroref,idregistro,idcampana,idagente,fecha,tipoag,hora,comentarios","'".$InventarioData[0][bolsaout]."','".$InventarioDataBolsa[$i][idregistro]."','$idcam','$idagente','$fecha',2,'$hora','$comentarios'",0);

	
							


	}



}//aqui verificamos si hay bolsa y cuadra todos los pseudos con esa bolsa en el formulario

//aqui vamos andres terminanr si es por pseudocodigo
if($InventarioData[0][bolsaout] == "")
{ 

$InventarioDataBolsa = parent::sql_select("inv_inventario","idregistro,scodigo","idcampana = $idcam AND scodigo = '".$InventarioData[0][scodigo]."'  AND idregistro != 0",0);


	if($ValorCallg != "F")	{
	$camposARR[$AgCamConfig[0][gestioncallc]] = $ValorCallg;
	CamposManage::UpdateDataAF($camposARR,$InventarioDataBolsa[0][idregistro],$idagente,"Agendamiento Masivo");
							}

	
	parent::inser_data("agenda_tmp","numeroref,idregistro,idcampana,idagente,fecha,tipoag,hora,comentarios","'".$InventarioData[0][scodigo]."','$idregistro','$idcam','$idagente','$fecha',1,'$hora','$comentarios'",0);



}	//aqui vamos andres terminanr si es por pseudocodigo


 			}//si no tiene inventario les cuenta que la cagaron.
			else{ 
			
			//echo "El Registro $idregistro no tiene un inventario asociado y no se agendo!! <br>"; 
			
			parent::inser_data("agenda_tmp","numeroref,idregistro,idcampana,idagente,fecha,tipoag,hora,comentarios",
"'$idregistro','$idregistro','$idcam','$idagente','$fecha',3,'$hora','$comentarios'",0);

			
			
			}
			

				}//verifica que no este agendado 
				else{ 

	$AgCamConfig = parent::sql_select("agenda_camconfig","gestioncallc","idcampana = '$idcam'",0);
	if($ValorCallg != "F")	{
	$camposARR[$AgCamConfig[0][gestioncallc]] = $ValorCallg;
	CamposManage::UpdateDataAF($camposARR,$idregistro,$idagente,"Agendamiento Masivo");
							}
				

				echo "El Registro $idregistro ya esta agendado <br>"; 
				
				}

				}//este es el cierre que verifica el tope de la agenda
		else{
			
			
		echo "No se pudo agendar el registro: $idregistro, la agenda para esta fecha ya copo la capacidad. <br>";
			
			
			}

} //aqui termina el agendamiento con inventario y empiesa el de recoleccion de documentos		
elseif ($recoleccion != 0){
	
	

	$TopeAG = $this->agenda_disp(0,$fecha);	
		
	if($TopeAG > 0){ // aqui verificamos el nombre de la agenda
	
	$VarfAgenda  = $this->verifica_agenda($idregistro,$idcam,$fecha);
	
	if ($VarfAgenda == 0){//verificamos que no este agendado
		

parent::inser_data("agenda_tmp","numeroref,idregistro,idcampana,idagente,fecha,tipoag,hora,comentarios",
"'$idregistro','$idregistro','$idcam','$idagente','$fecha',3,'$hora','$comentarios'",0);


				}//verifica que no este agendado 

				}//este es el cierre que verifica el tope de la agenda

	
	}
//aqui termina el agendamiento con recoleccion de documentos			
		
		
		
		}



//esta funcion hace el agendamiento ya definitivo.

function agendar($IdAgenda,$mensajero,$idestado,$bodega=0,$FechaRuta,$IdAgente){

date_default_timezone_set('America/Bogota');
$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");

if($bodega != 0){$ClaBodega = ", idbodega = '$bodega'";}
else{ $ClaBodega = ""; }

$TopeAG = $this->agenda_disp($mensajero,$fecha);	

	if($TopeAG > 0){//aqui esta el verificador de capasidad


$SelTmpAG = parent::sql_select("agenda_tmp","*","id_agendatmp = '$IdAgenda'",0);
	
	//aqui empesamos a actualizar todo dependiendo de si es bolsa o pseudo
	
	
if($SelTmpAG[0][tipoag] == 1)		{//aqui es por pseudocodigo
		
//parent::update_regs("inv_inventario","fechasalida = '$FechaRuta' , fechah = '$fecha_act $hora_act', $ClaBodega , idestado = '$idestado'","scodigo = '".$SelTmpAG[0][numeroref]."'",0);


parent::update_regs("inv_inventario","idagente = '$IdAgente', fechasalida = '$FechaRuta' , $ClaBodega , idestado = '$idestado'","scodigo = '".$SelTmpAG[0][numeroref]."'",0);


$SelInv = parent::sql_select("inv_inventario","*","scodigo = '".$SelTmpAG[0][numeroref]."' AND idregistro != 0",0);


parent::inser_data("inv_historial","idregistro,idcampana,idbodega_his,idagente_his,fechasalida_his,idestado_his","'".$SelInv[0][idregistro]."','".$SelInv[0][idcampana]."','$bodega','$IdAgente','".$SelInv[0][fechasalida]."','".$SelInv[0][idestado]."'",0);


$Claves = $this->Genera_Claves($SelInv[0][idregistro],$SelInv[0][idcampana]);


parent::inser_data("agenda","idmensajero,idagente,idregistro,idcampana,fecha,hora,comentarios,tipoag,numeroref,claved,clavef","'$_GET[idmensajero_hidden]','".$SelTmpAG[0][idagente]."','".$SelInv[0][idregistro]."','".$SelInv[0][idcampana]."','$FechaRuta','".$SelTmpAG[0][hora]."','".$SelTmpAG[0][comentarios]."','".$SelTmpAG[0][tipoag]."','".$SelTmpAG[0][numeroref]."','$Claves[claved]','$Claves[clavef]'",0);

$Borrar = mysql_query("DELETE FROM agenda_tmp WHERE id_agendatmp = '$IdAgenda'");


										}//aqui termina por pseudo codigo


if($SelTmpAG[0][tipoag] == 2)			{//aqui es por bolsa
		
//parent::update_regs("inv_inventario","fechasalida = '$FechaRuta' $ClaBodega , fechah = '$fecha_act $hora_act', idestado = '$idestado'","bolsaout = '".$SelTmpAG[0][numeroref]."' AND bolsaout != '' AND idregistro != 0",0);	


parent::update_regs("inv_inventario","idagente = '$IdAgente', fechasalida = '$FechaRuta' $ClaBodega , idestado = '$idestado'","bolsaout = '".$SelTmpAG[0][numeroref]."' AND bolsaout != '' AND idregistro != 0",0);	


$SelInv = parent::sql_select("inv_inventario","*","bolsaout = '".$SelTmpAG[0][numeroref]."' AND idregistro != 0",0);
	

 for( $i = 0 ; $i < count($SelInv) ; $i++ ){ //aqui arranca el for

$SelAgenda = parent::sql_select("agenda_tmp","*","idregistro = '".$SelInv[$i][idregistro]."' AND idcampana = '".$SelInv[$i][idcampana]."'",0);

if(is_array($SelAgenda)){//aqui esta el verificador de agenda temporal

parent::inser_data("inv_historial","idregistro,idcampana,idbodega_his,idagente_his,fechasalida_his,idestado_his","'".$SelInv[$i][idregistro]."','".$SelInv[$i][idcampana]."','".$SelInv[$i][idbodega]."','$IdAgente','".$SelInv[$i][fechasalida]."','".$SelInv[$i][idestado]."'",0);

$Claves = $this->Genera_Claves($SelInv[$i][idregistro],$SelInv[$i][idcampana]);


parent::inser_data("agenda","idmensajero,idagente,idregistro,idcampana,fecha,hora,comentarios,tipoag,numeroref,claved,clavef","'$_GET[idmensajero_hidden]','".$SelAgenda[0][idagente]."','".$SelInv[$i][idregistro]."','".$SelInv[$i][idcampana]."','$_GET[fecha_ruta]','".$SelAgenda[0][hora]."','".$SelAgenda[0][comentarios]."','".$SelAgenda[0][tipoag]."','".$SelAgenda[0][numeroref]."','$Claves[claved]','$Claves[clavef]'",0);

$Borrar = mysql_query("DELETE FROM agenda_tmp WHERE idregistro = '".$SelInv[$i][idregistro]."' AND idcampana = '".$SelInv[$i][idcampana]."'");


			}//aqui esta el verificador de agenda temporal

  				} //aqui termina el for


										}//aqui termina por pseudo codigo


	
	}//aqui esta el verificador de capasidad
	else{ echo "Limite de capacidad alcanzado para este mensajero"; }
	
		}

//aqui cuadramos la funcion para el feed back

function feedback($nomeroRef,$tipoAg,$mesajeroent,$fechaentrega,$idbodega,$idestado,$idusuario,$tipog="",$tipoe="",$mesg="",$codigoof="",$idcam=0){

date_default_timezone_set('America/Bogota');
$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");
	
		
if($tipoAg == 1)		{

//parent::update_regs("inv_inventario","fechah = '$fecha_act $hora_act' , idagente = '$idusuario' , fechasalida = '$fechaentrega' , idbodega = '$idbodega', idestado = '$idestado'","scodigo = '$nomeroRef'",0);


parent::update_regs("inv_inventario","idagente = '$idusuario' , fechaentrega = '$fechaentrega' , idbodega = '$idbodega', idestado = '$idestado'","scodigo = '$nomeroRef' AND idcampana = '$idcam'",0);


$SelInv = parent::sql_select("inv_inventario","*","scodigo = '$nomeroRef'",0);



if(is_array($SelInv)){


//guardamos hostorial de inventarios

parent::inser_data("inv_historial","idregistro,idcampana,idbodega_his,idagente_his,fechasalida_his,idestado_his","'".$SelInv[0][idregistro]."','".$SelInv[0][idcampana]."','".$SelInv[0][idbodega]."','".$idusuario."','".$SelInv[0][fechasalida]."','".$SelInv[0][idestado]."'",0);




//traemos la data de la agenda
$SelAge = parent::sql_select("agenda","id_agenda","idregistro = '".$SelInv[0][idregistro]."' AND idcampana = '".$SelInv[0][idcampana]."' ORDER BY id_agenda DESC LIMIT 1",0);

//Actualizamos la agenda
parent::update_regs("agenda","idmensajero_entrego = '$mesajeroent'","id_agenda = '".$SelAge[0][id_agenda]."'",0);


//contador
	Campana::contador_update($SelInv[0][idcampana],$SelInv[0][idregistro]);

//bloqueo

$EstadoTipoEnd = parent::sql_select("inv_estado","tipo","id_estado = '$idestado' AND tipo = 'end'",0);
if(is_array($EstadoTipoEnd)){ Campana::desactiva_reg($SelInv[0][idcampana],$SelInv[0][idregistro]); }



//guardamos los campos de la campana que son obligratorios

$CamData = Campana::campana_config($SelInv[0][idcampana]);
$CfgAg = parent::sql_select("agenda_camconfig","*","idcampana = '".$SelInv[0][idcampana]."'",0);

$tipogC = $CfgAg[0][tipogestionc];
$tipoeC = $CfgAg[0][tipoentregac];
$mesgC  = $CfgAg[0][mesgestionc];
$codigoofC = $CfgAg[0][codigooficinac];



parent::update_regs($CamData[tablaP],"$tipogC = '$tipog' , $tipoeC = '$tipoe' , $mesgC = '$mesg' , $codigoofC = '$codigoof'","$CamData[campoID] = '".$SelInv[0][idregistro]."'",0);

 echo "Listo el Peseudocodigo: $nomeroRef";
}else {echo "El Peseudocodigo: $nomeroRef no existe";}

	
									}
									
									
									
if($tipoAg == 2)		{


//parent::update_regs("inv_inventario","fechah = '$fecha_act $hora_act' , idagente = '$idusuario' , fechasalida = '$fechaentrega' , idbodega = '$idbodega', idestado = '$idestado'","bolsaout = '$nomeroRef'  AND bolsaout != ''",0);	

parent::update_regs("inv_inventario","idagente = '$idusuario' , fechaentrega = '$fechaentrega' , idbodega = '$idbodega', idestado = '$idestado'","bolsaout = '$nomeroRef'  AND bolsaout != '' AND idcampana = '$idcam'",0);	



$SelInv = parent::sql_select("inv_inventario","*","bolsaout = '$nomeroRef' AND idcampana = '$idcam'",0);

if(is_array($SelInv)){
	

 for( $i = 0 ; $i < count($SelInv) ; $i++ ){ 

//guardamos hostorial de inventarios
parent::inser_data("inv_historial","idregistro,idcampana,idbodega_his,idagente_his,fechasalida_his,idestado_his","'".$SelInv[$i][idregistro]."','".$SelInv[$i][idcampana]."','".$SelInv[$i][idbodega]."','".$idusuario."','".$SelInv[$i][fechasalida]."','".$SelInv[$i][idestado]."'",0);

//traemos datos de la agenda
$SelAge = parent::sql_select("agenda","id_agenda","idregistro = '".$SelInv[$i][idregistro]."' AND idcampana = '".$SelInv[$i][idcampana]."' ORDER BY id_agenda DESC LIMIT 1",0);


if(is_array($SelAge)) 		{
//actualizamos la agenda
parent::update_regs("agenda","idmensajero_entrego = '$mesajeroent'","id_agenda = '".$SelAge[0][id_agenda]."'",0);
     						}

//contador
Campana::contador_update($SelInv[$i][idcampana],$SelInv[$i][idregistro]);

//bloqueo

$EstadoTipoEnd = parent::sql_select("inv_estado","tipo","id_estado = '$idestado' AND tipo = 'end'",0);
if(is_array($EstadoTipoEnd)){ Campana::desactiva_reg($SelInv[$i][idcampana],$SelInv[$i][idregistro]); }


//guardamos los campos de la campana que son obligratorios

$CamData = Campana::campana_config($SelInv[$i][idcampana]);
$CfgAg = parent::sql_select("agenda_camconfig","*","idcampana = '".$SelInv[$i][idcampana]."'",0);

$tipogC = $CfgAg[0][tipogestionc];
$tipoeC = $CfgAg[0][tipoentregac];
$mesgC  = $CfgAg[0][mesgestionc];
$codigoofC = $CfgAg[0][codigooficinac];



parent::update_regs($CamData[tablaP],"$tipogC = '$tipog' , $tipoeC = '$tipoe' , $mesgC = '$mesg' , $codigoofC = '$codigoof'","$CamData[campoID] = '".$SelInv[$i][idregistro]."'",0);



  } 
  

 echo "Lista la bosa de salida: $nomeroRef";
}else {echo "La bosa de salida: $nomeroRef no existe";}

	
}//--------------------------------
	
		
			}

	function verifica_agenda($idregistro,$idcampana,$fecha){//aqui verificamos la agensda para un dia para un registro.
		
$VerAg = parent::sql_select("agenda","numeroref","idregistro = '$idregistro' AND idcampana = '$idcampana' AND fecha = '$fecha'",0);

$VerAgTMP = parent::sql_select("agenda_tmp","numeroref","idregistro = '$idregistro' AND idcampana = '$idcampana' AND fecha = '$fecha'",0);

		
if(is_array($VerAg) or is_array($VerAgTMP)){ return array("Agendado para esta fecha","$idregistro"); }		
else { return 0; }		
		
		
		}	//aqui verificamos la agensda para un dia para un registro.	



	//esta clase nos la clave D y F del registro para se guardada en la agenda final
	function Genera_Claves($idregistro,$idcampana){
		
	$SelInv = parent::sql_select("inv_inventario","*","idregistro = '$idregistro' AND idcampana = '$idcampana'",0);
	$SelCfg = parent::sql_select("agenda_camconfig","emailc","idcampana = '$idcampana'",0);
			
	if($SelInv[0][bolsaout] != ""){
		
	$SelInvT = parent::sql_select("inv_inventario","*","bolsaout = '".$SelInv[0][bolsaout]."'",0);
	
	for( $i=0 ; $i < count($SelInvT) ; $i++){
		
		$PrimerEnc = md5($SelInvT[$i][scodigo]);
		$SegundoEnc = substr($PrimerEnc,0,5);
		
		$CadenaClaves .= $SegundoEnc."|";
		
		
											}
	
/*	
	$email = CamposManage::campoFdata($SelCfg[0][emailc],$idregistro);
	if($email != ""){ mail($email,"Sujeto","Mensaje sus claves de entrega son $email"); }
*/	
	
	return array("clavef" => $SelInv[0][bolsaout],"claved" => $CadenaClaves );
	
	}//si es con bolson
	else{//si es con seudocode
	
	$PrimerEnc = md5($SelInv[0][scodigo]);
	$SegundoEnc = substr($PrimerEnc,0,5);

	return array("clavef" => 0 ,"claved" => $CadenaClaves );
		
	}//si es con seudocode
	
	
		
		}
	//esta clase nos la clave D y F del registro para se guardada en la agenda final



}//termina la classe
?>