<?
/*esta clase sera utilizada para generar manipular los inventarios en OPEC c3 esta hace parte de los modulos complemetarios.

Aqui los cambios que tiene en cada actualizacion:

*/

class Inventario extends Man_Mysql{
	
	var $RutaRaizINC;
	var $RutaHTTP;
	var $RutaRaiz;


	function inventario_4id($idRegistro,$idcampana){ // esta funcion nos muestra el estado de un id en el inventario con su historial

	
$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");

		$RegStatus 	= 	parent::sql_select("ident_".$idcampana,"estado","id_ident_$idcampana = '$idRegistro'",0);
		

		$ActualStatus 	= 	parent::sql_select("inv_inventario","*","idregistro = '$idRegistro' AND idcampana = '$idcampana'",0);

		if(is_array($ActualStatus)){

		$RegHistorial 		= 	parent::sql_select("inv_historial","*","idregistro = '$idRegistro'  AND idcampana = '$idcampana' ORDER BY fechah_his DESC",0);
		$RegEstadoActual	=	parent::sql_select("inv_inventario","*","idregistro = '$idRegistro' AND idcampana = '$idcampana' ORDER BY fechah DESC",0);

		?>
<link rel="stylesheet" type="text/css" href="../css/estilos.css"/> 
<link rel="stylesheet" type="text/css" href="../css/style.css"/>		
		<div align="center">
		  
          <table width="0" border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
		    <tr>
		      <td align="center" class="textos_titulos">Seguimiento del Registro</td>
		     
             
           	 <td rowspan="2" align="center" class="textos_titulos">
		        
                <? if($RegStatus[0][estado] !=4 ){ ?>
                
    <form id="form2" name="form2" method="post" action="<?=$this->RutaHTTP?>/modules/inventarios/inventario_update.php">

                <table width="0" border="0" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
		          <tr>
		            <td colspan="2" align="center" class="textos_negros">Actualizar Estado</td>
	              </tr>
		          <tr>
		            <td class="textos_negros">Bodega</td>
		            <td><?
	$parametrosGrupo=array(
	"tabla"=>"inv_bodegas",
	"campo1"=>"id_bodegas ",
	"campo2"=>"nombre",
	"campoid"=>"id_bodegas",
	"condiorden"=>"1");		 
	echo Generar_Formulario::c_select("","idbodega","","",":required",$parametrosGrupo,0,0);?>
		              &nbsp;</td>
	              </tr>
		          <tr>
		            <td class="textos_negros">Estado</td>
		            <td><?
	$parametrosGrupo=array(
	"tabla"=>"inv_estado",
	"campo1"=>"id_estado",
	"campo2"=>"estado",
	"campoid"=>"id_estado",
	"condiorden"=>"1");		 
	echo Generar_Formulario::c_select("","idestado","","",":required",$parametrosGrupo,0,0);?></td>
	              </tr>
		          <tr>
		            <td class="textos_negros">Fecha Entrega</td>
		            <td><?=Generar_Formulario::c_fecha_input("","fechasalida","","")?></td>
	              </tr>
		          <tr>
		            <td colspan="2" align="center" class="textos_negros"><input name="idregINV" type="hidden" id="idregINV" value="<?=$ActualStatus[0][id_inventario]?>" />
		              <input name="fechah" type="hidden" id="fechah" value="<?=$fecha_act." ".$hora_act?>" />
		              <input type="hidden" name="idregistro" id="idregistro2" value="<?=$idRegistro?>"/>
		              <input type="hidden" name="idcampana" id="idregistro2" value="<?=$idcampana?>"/>
		              <input type="submit" name="ok" id="ok" value="Actualizar" /></td>
	              </tr>
	            </table>
	          </form>
              
              <? } ?>
              
              </td>
	        </tr>
		    <tr>
		      <td align="left" valign="top">
               <table width="0" border="0" cellspacing="4" cellpadding="0">
		        <tr>
		          <td align="center" class="textos_negros">Usuario</td>
		          <td align="center" class="textos_negros">Fecha y Hora</td>
		          <td align="center" class="textos_negros">Fecha Salida</td>
		          <td align="center" class="textos_negros">Fecha Entrega</td>
		          <td align="center" class="textos_negros">Estado</td>
		          <td align="center" class="textos_negros">Bodega</td>
		          <td align="center" class="textos_negros">Lote</td>
		          <td align="center" class="textos_negros">Match</td>
	            </tr>
<? if(is_array($RegEstadoActual)){ for($i = 0 ;$i < count($RegEstadoActual) ; $i++) { 

	$Bodega 	= 	parent::sql_select("inv_bodegas","*","id_bodegas = '".$RegEstadoActual[$i][idbodega]."'",0);
	$Estado 	= 	parent::sql_select("inv_estado","*","id_estado = '".$RegEstadoActual[$i][idestado]."'",0);
	$Agente 	= 	parent::sql_select("agents","*","id_agents = '".$RegEstadoActual[$i][idagente]."'",0);
	if($ActualStatus[0][matchf] == 0){ $mtch = "No"; }else{ $mtch = "Si"; }
?>

		        <tr>
		          <td bgcolor="#CCCCCC" class="textos"><?=$Agente[0][name]?>&nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos">Fecha de Inventario
	                <br />
                  <?=$RegEstadoActual[$i][fechah]?>		            &nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$RegEstadoActual[$i][fechasalida]?></td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$RegEstadoActual[$i][fechaentrega]?>&nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$Estado[0][estado]?>&nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$Bodega[0][nombre]?>&nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$ActualStatus[0][lote]?>&nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$mtch?>&nbsp;</td>
	            </tr>
<? } } //si $RegHistorial es array?> 
<? if(is_array($RegHistorial)){ for($i = 0 ;$i < count($RegHistorial) ; $i++) { 

	$Bodega 	= 	parent::sql_select("inv_bodegas","*","id_bodegas = '".$RegHistorial[$i][idbodega_his]."'",0);
	$Estado 	= 	parent::sql_select("inv_estado","*","id_estado = '".$RegHistorial[$i][idestado_his]."'",0);
	$Agente 	= 	parent::sql_select("agents","*","id_agents = '".$RegHistorial[$i][idagente_his]."'",0);
	
	if(is_array($Agente )){ $EGname = $Agente[0][name];  }
	else{ $EGname = ""; }
	
	if($ActualStatus[0][matchf] == 0){ $mtch = "No"; }else{ $mtch = "Si"; }
?>

		        <tr>
		          <td bgcolor="#FFFFFF" class="textos"><?=$EGname?>&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$RegHistorial[$i][fechah_his]?>&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$RegHistorial[$i][fechasalida_his]?></td>
		          <td bgcolor="#FFFFFF" class="textos">&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$Estado[0][estado]?>&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$Bodega[0][nombre]?>&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$ActualStatus[0][lote]?>&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$mtch?>&nbsp;</td>
	            </tr>
<? } } //si $RegHistorial es array?> 
	          </table>
              
              
              </td>
	        </tr>
  </table>
  
	    </div>

		
		<?
			
		}else{
/*//aqui va el html para agregar un id al inventario			
?>
 <form id="form1" name="form1" method="post" action="<?=$this->RutaHTTP?>/modules/inventarios/inventario_save.php">
   <div align="center">
     <table width="0" border="0" align="center" cellpadding="2" cellspacing="0" class="rounded-corners-blue">
       <tr>
         <td colspan="2" class="textos_titulos">Guardar En Inventario el Registro: <?=$idRegistro?></td>
       </tr>
       <tr>
         <td class="textos_negros">Bodega</td>
         <td><?
	$parametrosGrupo=array(
	"tabla"=>"inv_bodegas",
	"campo1"=>"id_bodegas ",
	"campo2"=>"nombre",
	"campoid"=>"id_bodegas",
	"condiorden"=>"inactivo = 0");		 
	echo Generar_Formulario::c_select("","idbodega","","",":required",$parametrosGrupo,0,0);?>&nbsp;</td>
       </tr>
       <tr>
         <td class="textos_negros">Lote</td>
         <td>
	<?=Generar_Formulario::c_text("","lote","","","",0,0,0);?>&nbsp;</td>
       </tr>
       <tr>
         <td class="textos_negros">Estado</td>
         <td><?
	$parametrosGrupo=array(
	"tabla"=>"inv_estado",
	"campo1"=>"id_estado",
	"campo2"=>"estado",
	"campoid"=>"id_estado",
	"condiorden"=>"1");		 
	echo Generar_Formulario::c_select("","idestado","","",":required",$parametrosGrupo,0,0);?>&nbsp;</td>
       </tr>
       <tr>
         <td colspan="2" align="center">
      <input name="fechah" type="hidden" id="fechah" value="<?=$fecha_act." ".$hora_act?>" />  
      <input type="hidden" name="idagente" id="idagente" value="<?=$_SESSION[user_ID]?>" />          
      <input type="hidden" name="idregistro" id="idregistro" value="<?=$idRegistro?>"/>           
      <input type="submit" name="button" id="button" value="Guardar" /></td>
       </tr>
     </table>
   </div>
 </form>

 
<?
	*/			
		echo "<div align='center'> Se debe inventariar por pistoleo </div>";	}
		
		
		} // esta funcion nos muestra el estado de un id en el inventario con su historial



function historial_4id($idRegistro,$idcampana){ // funcion mustra el historial de un id
	
$fecha_act=date("Y-n-j");
$hora_act=date("H:i:s");
		
		$ActualStatus 	= 	parent::sql_select("inv_inventario","*","idregistro = '$idRegistro' AND idcampana = '$idcampana'",0);

		if(is_array($ActualStatus)){

		$RegHistorial 		= 	parent::sql_select("inv_historial","*","idregistro = '$idRegistro' AND idcampana = '$idcampana' ORDER BY fechah_his DESC",0);
		$RegEstadoActual	=	parent::sql_select("inv_inventario","*","idregistro = '$idRegistro' AND idcampana = '$idcampana' ORDER BY fechah DESC",0);
	
		?>
<link rel="stylesheet" type="text/css" href="../css/estilos.css"/> 
<link rel="stylesheet" type="text/css" href="../css/style.css"/>		
		<div align="center">
		  
                         <table width="0" border="0" cellpadding="0" cellspacing="4" class="rounded-corners-blue">
		        <tr>
		          <td colspan="8" align="center" class="textos_negros">Seguimiento del Segistro</td>
		          </tr>
		        <tr>
		          <td align="center" class="textos_negros">Usuario</td>
		          <td align="center" class="textos_negros">Fecha y Hora</td>
		          <td align="center" class="textos_negros">Fecha Salida</td>
		          <td align="center" class="textos_negros">Fecha Entrega</td>
		          <td align="center" class="textos_negros">Estado</td>
		          <td align="center" class="textos_negros">Bodega</td>
		          <td align="center" class="textos_negros">Lote</td>
		          <td align="center" class="textos_negros">Match</td>
	            </tr>
<? if(is_array($RegEstadoActual)){ for($i = 0 ;$i < count($RegEstadoActual) ; $i++) { 

	$Bodega 	= 	parent::sql_select("inv_bodegas","*","id_bodegas = '".$RegEstadoActual[$i][idbodega]."'",0);
	$Estado 	= 	parent::sql_select("inv_estado","*","id_estado = '".$RegEstadoActual[$i][idestado]."'",0);
	$Agente 	= 	parent::sql_select("agents","*","id_agents = '".$RegEstadoActual[$i][idagente]."'",0);
	
	if(is_array($Agente)){ $agenteN = $Agente[0][name]; }else{ $agenteN = "Sin Agente"; }
	
	if($ActualStatus[0][matchf] == 0){ $mtch = "No"; }else{ $mtch = "Si"; }
?>

		        <tr>
		          <td bgcolor="#CCCCCC" class="textos"><?=$agenteN?>&nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos">Fecha de Inventario
                    <br />
                  <?=$RegEstadoActual[$i][fechah]?>&nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$RegEstadoActual[$i][fechasalida]?></td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$RegEstadoActual[$i][fechaentrega]?>&nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$Estado[0][estado]?>&nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$Bodega[0][nombre]?>&nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$ActualStatus[0][lote]?>&nbsp;</td>
		          <td bgcolor="#CCCCCC" class="textos"><?=$mtch?>&nbsp;</td>
	            </tr>
<? } } //si $RegHistorial es array?> 
<? if(is_array($RegHistorial)){ for($i = 0 ;$i < count($RegHistorial) ; $i++) { 

	$Bodega 	= 	parent::sql_select("inv_bodegas","*","id_bodegas = '".$RegHistorial[$i][idbodega_his]."'",0);
	$Estado 	= 	parent::sql_select("inv_estado","*","id_estado = '".$RegHistorial[$i][idestado_his]."'",0);
	$Agente 	= 	parent::sql_select("agents","*","id_agents = '".$RegHistorial[$i][idagente_his]."'",0);

	if(is_array($Agente )){ $EGname = $Agente[0][name];  }
	else{ $EGname = ""; }

	
	
	if($ActualStatus[0][matchf] == 0){ $mtch = "No"; }else{ $mtch = "Si"; }
?>

		        <tr>
		          <td bgcolor="#FFFFFF" class="textos"><?=$EGname?>&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$RegHistorial[$i][fechah_his]?>&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$RegHistorial[$i][fechasalida_his]?></td>
		          <td bgcolor="#FFFFFF" class="textos">&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$Estado[0][estado]?>&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$Bodega[0][nombre]?>&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$ActualStatus[0][lote]?>&nbsp;</td>
		          <td bgcolor="#FFFFFF" class="textos"><?=$mtch?>&nbsp;</td>
	            </tr>
<? } } //si $RegHistorial es array?> 
	          </table>
  
	    </div>

		
		<?
			
		}else{
//aqui va el html para agregar un id al inventario			
?>
 
        <div class="textosbig" align="center">Este Registro No Tiene Historial de Inventarios </div>
<?
				
			}
		
		
		} // funcion mustra el historial de un id


}//termina la classe
?>