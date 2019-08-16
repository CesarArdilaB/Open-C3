<table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textos_negros"><div align="left" class="textos_titulos">LLamadas de Predictivo</div></td>
        <td><div align="center" class="textos_titulos"> LLamadas Manuales        </div></td>
      </tr>
      <tr>
        <td>
<? for($i=0; $i < count($cTp) ; $i++){ 
mysql_select_db("octres");
$Telefono=$formulario->traer_datos_select($cTp[$i][tabla],$cTp[$i][nombre],$cTp[$i][nombre],$cTp[$i][tabla]."_id",0,$cTp[$i][tabla]."_id = '$IdIdent'");

mysql_select_db("call_center");

if($Telefono[texto] == ""){$Telefono[texto] = "Vacio";}

@$TelLista = $sqlm->sql_select("calls","*","phone REGEXP '".$Telefono[texto]."' AND status = 'Success'",0);

?>

<div class="textos_titulos"><?=$cTp[$i][label]?> - <?=$Telefono[texto]?></div>


<table border="0" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
  <tr>
    <td class="textos_negros">Agente</td>
    <td class="textos_negros">Fecha</td>
    <td class="textos_negros">Grabacion</td>
    <td class="textos_negros">Duracion</td>
  </tr>
<? if(is_array($TelLista)){for($o=0 ; $o < count($TelLista) ; $o++){ 

mysql_select_db("call_center");
$AgenteNum=$formulario->traer_datos_select("agent","number","number","id",0,"id = '".$TelLista[$o][id_agent]."'");

mysql_select_db("octres");
$AgenteNombre=$formulario->traer_datos_select("agents","name","name","id_agents",0,"number = '".$AgenteNum[texto]."'");
?> 

 <tr>
    <td bgcolor="#FFFFFF" class="textos"><?=$AgenteNombre[texto]?> </td>
    <td bgcolor="#FFFFFF" class="textos"><?=$TelLista[$o][fecha_llamada]?></td>
    <td bgcolor="#FFFFFF">
    <div align="center" id="<?=$o?><?=$TelLista[$o][uniqueid]?>">
    <a href="javascript:EnviarLinkJ('<?=$o?><?=$TelLista[$o][uniqueid]?>','modules/monitoring/recfinder.php?unicoid=<?=$TelLista[$o][uniqueid]?>');">Buscar Archivo</a>
    </div>
    </td>
    <td bgcolor="#FFFFFF" align="center"><?=number_format($TelLista[$o][duration]/60,1)?> min&nbsp;</td>
  </tr>
  
 <? } /*este es el if del resiltado*/  } ?> 
</table>    
<? //aqui saco la lista de telefonos
 }//el que selecciona los campos de telefono es este ?>         
   
 </td>
        <td><? for($i=0; $i < count($cTp) ; $i++){ 
mysql_select_db("octres");
$Telefono=$formulario->traer_datos_select($cTp[$i][tabla],$cTp[$i][nombre],$cTp[$i][nombre],$cTp[$i][tabla]."_id",0,$cTp[$i][tabla]."_id = '$IdIdent'");

mysql_select_db("asteriskcdrdb");

if($Telefono[texto] == ""){$Telefono[texto] = "Vacio";}
@$TelListaM = $sqlm->sql_select("cdr","*","dst REGEXP '".$Telefono[texto]."' AND disposition = 'ANSWERED' AND src !='' AND billsec > 1",0);

?>
          <div class="textos_titulos">
            <?=$cTp[$i][label]?>
            -
  <?=$Telefono[texto]?>
          </div>
          <table border="0" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
            <tr>
              <td class="textos_negros">Agente</td>
              <td class="textos_negros">Fecha</td>
              <td class="textos_negros">Grabacion</td>
              <td class="textos_negros">Duracion</td>
            </tr>
            <? if(is_array($TelListaM)){for($o=0 ; $o < count($TelListaM) ; $o++){ 

mysql_select_db("octres");
$AgenteNombre=$formulario->traer_datos_select("agents","name","name","id_agents",0,"extension = '".$TelListaM[$o][src]."'");
?>
            <tr>
              <td bgcolor="#FFFFFF" class="textos"><?=$AgenteNombre[texto]?></td>
              <td bgcolor="#FFFFFF" class="textos"><?=$TelListaM[$o][calldate]?></td>
              <td bgcolor="#FFFFFF"><div align="center" id="<?=$o?><?=$TelListaM[$o][uniqueid]?>"><a href="javascript:EnviarLinkJ('<?=$o?><?=$TelListaM[$o][uniqueid]?>','modules/monitoring/recfinder.php?unicoid=<?=$TelListaM[$o][uniqueid]?>');">Buscar Archivo</a></div></td>
              <td align="center" bgcolor="#FFFFFF"><?=number_format($TelListaM[$o][billsec]/60,1)?> min&nbsp;</td>
            </tr>
            <? } /*este es el if del resiltado*/  } ?>
          </table>
          <? //aqui saco la lista de telefonos
 }//el que selecciona los campos de telefono es este ?></td>
      </tr>
      <tr>
        <td colspan="2"><iframe name="reproductor" width="100%" height="20px" scrolling="No" frameborder="0" id="reproductor"></iframe></td>
        </tr>
    </table>