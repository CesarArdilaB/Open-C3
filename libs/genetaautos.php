<?php
@session_start();

include "../appcfg/cc.php";

if($_SESSION[user_ID] == "" and $nombreP != "index.php"){

/*echo ("<script language='JavaScript'>document.location.href='/openc3/index.php';</script>");*/
header ("Location: /openc3/index.php");	
	
    	}
//Verificamos la seguridad.

$query = "SELECT $_GET[campoid],$_GET[campo1],$_GET[campo2] FROM $_GET[tabla] WHERE ($_GET[campo2] REGEXP '$_GET[q]' OR $_GET[campo1] REGEXP '$_GET[q]') AND $_GET[condiorden]";

//echo $query."<br>";

$req = mysql_query($query);
if (!$req)
{
	//echo $query."<br>"; 

	//echo "<B>Error ".mysql_errno()." :</B> ***".mysql_error().""; 
	
	}
$res = mysql_num_rows($req);
if ($res == 0)
   { echo "Sin Datos";
   }
 else{  
while($row = mysql_fetch_array($req))
            {	extract($row);
		   
		   $$_GET[campo2] = str_replace("|","&#124;",$$_GET[campo2]);
		   $$_GET[campo1] = str_replace("|","&#124;",$$_GET[campo1]);
		   $$_GET[campoid] = str_replace("|","&#124;",$$_GET[campoid]);
		   
		   echo utf8_encode($$_GET[campo2])."|".$$_GET[campo1]."|".$$_GET[campoid]."\n";
		   
		
		    }
mysql_free_result($req); }


?>