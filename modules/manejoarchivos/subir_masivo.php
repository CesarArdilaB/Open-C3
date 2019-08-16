<?

//phpinfo();

		
if($_POST[oksubir]){
	
	
	if(!copy($_FILES[archivosub][tmp_name],$RAIZ."/tmp/".$_FILES[archivosub][name])){
	
	$errores = error_get_last();
	print_r($errores);
	echo "<br><br>";
		
	}


	
$zip = new ZipArchive;

$res = $zip->open("$RAIZ/tmp/".$_FILES[archivosub][name]);

if ($res === TRUE) {
	
exec("rm -Rf $RAIZ/tmp/extract_path/*");
	
  $zip->extractTo("$RAIZ/tmp/extract_path/");
  $zip->close();
  $DecomMensaje =  'Descomprimido';
  
} else {
	
  $DecomMensaje =   'Arror Descomprimiento!';
  
}

$Ndirfile = substr($_FILES[archivosub][name],0,-4);

echo $Ndirfile." <br>";

$ListaFilesARR = scandir ("$RAIZ/tmp/extract_path");

//print_r($ListaFilesARR);

$mal = 0;
$ok = 0;

for($i=0; $i <count($ListaFilesARR) ; $i++){
	
	$ListaFilesARR[$i] = str_ireplace("'","",$ListaFilesARR[$i]);
	
	$bolsabuscar = substr($ListaFilesARR[$i],0,-4);
	$extension = substr($ListaFilesARR[$i],-4);
	
	//echo "$extension *** <br>";
	
	$SelBolsa = $sqlm->sql_select("inv_inventario","idregistro","bolsaout = '$bolsabuscar' AND idcampana = $_POST[idcampana]",0);

	if(is_array($SelBolsa) and $bolsabuscar != "")	{


 for( $z = 0 ; $z < count($SelBolsa) ; $z++ ){ 

mkdir("$RAIZ/files/cam_$_POST[idcampana]/".$SelBolsa[$z][idregistro],0777);		

exec("cp $RAIZ/tmp/extract_path/".$ListaFilesARR[$i]." $RAIZ/files/cam_$_POST[idcampana]/".$SelBolsa[$z][idregistro]."/$bolsabuscar"."_".date("s")."$extension");


//echo "cp $RAIZ/tmp/extract_path/".$ListaFilesARR[$i]." $RAIZ/files/cam_$_POST[idcampana]/".$SelBolsa[$z][idregistro]."/$bolsabuscar"."_".date("s")."$extension"."   <br> ";

  } 

	
	$ok++;
		
	}else{
	
	if($bolsabuscar != "")		{
	$mal++;	
	$bolsasmal .= "$bolsabuscar <br>";
				}
	
	}

	
	}

exec("rm -Rf $RAIZ/tmp/extract_path/*");
exec("rm -f $RAIZ/tmp/*");


$listo = "Archivos importados: $ok - archivos con error: $mal son los siguientes numeros de bolsa: <br> $bolsasmal ";
	
}//----------------------------

?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
<div align="center"><form action="" method="post" enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
    <tr>
      <td class="textos_titulos">Seleccione una Campaña</td>
      <td><span class="textos_negros">
        <? $parametrosGrupoHerr=array(
	"tabla"=>"campaigns",
	"campo1"=>"campaign_name",
	"campo2"=>"campaign_name",
	"campoid"=>"id_campaign",
	"condiorden"=>"1");
	echo $formulario->c_select("","idcampana","","",":required",$parametrosGrupoHerr,0,"","MuestraCampos"); ?>
      </span></td>
    </tr>
    <tr>
      <td class="textos_titulos">Seleccione un Archivo</td>
      <td><input name="archivosub" type="file" id="archivosub" size="10" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="oksubir" id="oksubir" value="Subir Archivos"></td>
      </tr>
  </table>
</form></div>

<br><br><br>

<div align="center" class="rounded-corners-gray">
  <p>
    <?=$listo?>
    <br />
<br />
  </p>
</div>