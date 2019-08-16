<?php
include "../appcfg/cc.php";

$query = "SELECT $_GET[campo] FROM $_GET[tabla] WHERE $_GET[campo] = '$_GET[value]' LIMIT 0,1";

//echo $query."<br>";

$req = mysql_query($query);
if (!$req)
{
	//echo $query."<br>"; 

	//echo "<B>Error ".mysql_errno()." :</B> ***".mysql_error().""; 
	
	}
$res = mysql_num_rows($req);
if ($res == 0)
   { echo "{ success: true }";
   }
 else{  
while($row = mysql_fetch_array($req))
            {	extract($row);
		   
		echo "{ success: false, message: \"Este Valor Ya Existe En La BBDD.\" }";
		
		    }
mysql_free_result($req); }


?>