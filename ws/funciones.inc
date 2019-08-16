<?php
#Funciones relacionados con la base de datos
function conectar()
{
	$db = "octres";
	$link = @mysql_pconnect ("localhost","root","admusr");
	if (!$link)
	{
		return (FALSE);
	}
	else
	{
		return($link);
	}
}
?>
