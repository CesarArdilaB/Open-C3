<?
session_start();

include '../../../appcfg/general_config.php';


$sel = $sqlm->sql_select("autoform_config","nombrecampo","tipocampo IN ('autocom','select') AND idtabla_rel != 13 AND nombrecampo
REGEXP 'af'",1);


for($i=0 ; $i < count($sel) ; $i++){
	
echo "<br> ALTER TABLE `autof_".$sel[$i][nombrecampo]."` ADD INDEX ( `field1` );";
mysql_query("ALTER TABLE `autof_".$sel[$i][nombrecampo]."` ADD INDEX ( `field1` )");


}


?>