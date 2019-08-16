<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<div>Estos Son los archivos para el registro: <?=$_GET[IdIdent]?></div><br />

<table border="0" cellspacing="2" cellpadding="2">

<?
//cam_".$_GET[Idcamania]."/".$_GET[IdIdent]."/
$varDir = "../../files/cam_".$_GET[Idcamania]."/".$_GET[IdIdent]."/";
$ListaFilesARR = scandir ($varDir);


for($i=2 ; $i < count($ListaFilesARR) ; $i++){//este es el final del for

?>
<tr>
    <td align="center"><img src="/openc3/files/thumbnails/cam_<?=$_GET[Idcamania]?>/<?=$_GET[IdIdent]?>/<?=$ListaFilesARR[$i]?>" border="1" /></td>
    <td><a target="_blank" href='/openc3/files/cam_<?=$_GET[Idcamania]?>/<?=$_GET[IdIdent]?>/<?=$ListaFilesARR[$i]?>' class="textosbigRes"><?=$ListaFilesARR[$i]?></a></td>
</tr>
<?
} //este es el final del for

?>  

</table>