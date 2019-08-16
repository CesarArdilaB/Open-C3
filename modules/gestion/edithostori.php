<? include '../../appcfg/general_config.php'; 

if(isset($ok)){
	
	$camparam=$sqlm->sql_select("autoform_tablas,autoform_config","campaignid","nombrecampo = '$ncampo' AND idtabla_rel = id_autoformtablas",0);
	
	$mensaje="Registro Actualizado <br>";
	
	$act = $sqlm->update_regs("history_".$camparam[0][campaignid],"his_".$ncampo." = '$valhis'","id_reg = '$idreg' AND fechahora = '$fechahora'");
	
	}

$CampoProp=$sqlm->sql_select("autoform_config","*","nombrecampo = '$ncampo'",0);
?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
  
<form name="form1" method="post" action="">
  <div align="center">
    <table width="0" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" class="textosbig"><?=$$mensaje?>Editando Historico Para:
          <?=$CampoProp[0][labelcampo]?>
          en la fecha:
          <?=$fechahora?>
          en el registro
          <?=$idreg?></td>
      </tr>
      <tr>
        <td align="center"><?=$formulario_auto->armar_campo($CampoProp[0][tipocampo],"valhis","",$valor,0,0,0,$CampoProp[0][paramcampo])?>
          &nbsp;
          <input name="idreg" type="hidden" id="idreg" value="<?=$idreg?>">
          <input name="fechahora" type="hidden" id="fechahora" value="<?=$fechahora?>">
          <input name="ncampo" type="hidden" id="ncampo" value="<?=$ncampo?>"></td>
      </tr>
      <tr>
        <td align="center"><input type="submit" name="ok" id="ok" value="Guardar"></td>
      </tr>
    </table>
  </div>
</form>
