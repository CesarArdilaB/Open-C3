<? 
// funcion que llena los selects para alimentar: ayudante, quien, tanquea, cema etc....

function traer_combos($tabla,$campo1,$campo2,$campoid,$conlosdos="0",$condicion="1",$ordenar=""){
	
	$query = "SELECT $campoid,$campo1,$campo2 FROM $tabla WHERE $condicion $ordenar";
$req = mysql_query($query);

//echo "$query";

if (!$req)
{ echo "<B>Error ".mysql_errno()." :</B> ***************************".mysql_error()."";
exit; }
$res = mysql_num_rows($req);

if ($res == 0)
   { //echo "''";
   }
else 
   { while($row = mysql_fetch_array($req))
            {
               extract($row);
			   
			   echo "<option value='".$$campoid."' id='".$$campo1."'>".utf8_encode($$campo2)."</option>";
			   
			    }
mysql_free_result($req);
} 
	
	}
	
	//------------------------------------------

function traer_datos_seleccionados($tabla,$campo1,$campo2,$campoid,$conlosdos="0",$condicion="1",$ordenar=""){
	
	$query = "SELECT $campoid,$campo1,$campo2 FROM $tabla WHERE $condicion $ordenar";
$req = mysql_query($query);

//echo "$query";

if (!$req)
{ echo "<B>Error ".mysql_errno()." :</B> ***************************".mysql_error()."";
exit; }
$res = mysql_num_rows($req);

if ($res == 0)
   { //echo "'PAILA' $query";
   }
else 
   { while($row = mysql_fetch_array($req))
            {
               extract($row);
			   
			   return array("valor" => $$campoid,"idsel" => $$campo1,"texto" => utf8_encode($$campo2));
			   
			    }
mysql_free_result($req);
} 
	
	}
	
	//------------------------------------------
	
function traer_maxid($tabla,$campoid){
	
	$query = "SELECT MAX($campoid) as idmaximo FROM $tabla";
$req = mysql_query($query);

//echo "$query";

if (!$req)
{ echo "<B>Error ".mysql_errno()." :</B> ***************************".mysql_error()."";
exit; }
$res = mysql_num_rows($req);

if ($res == 0)
   { //echo "''";
   }
else 
   { while($row = mysql_fetch_array($req))
            {
               extract($row);
			   
			   $idainsertar=$idmaximo;
			   
			   return $idainsertar;
			   
			    }
mysql_free_result($req);
} 
	
	}
?>