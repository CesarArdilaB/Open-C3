<div style="padding-top:25px; padding-left:20px; padding-right:20px; overflow:auto; height:100%" align="center">
<? 
		if ( $_GET[sec] == "" or $_GET[mod] == ""){ 
		
		include $RAIZ.'/appdashboard.php'; } 
		
		else { 
		
		$rutainclude = $RAIZ."/modules/".$_GET[sec]."/".$_GET[mod].".php";
		
		include "$rutainclude"; 
		
		}
?>
</div>
            
</div>
 
 <div class="reference_div">
       <span class="reference">
                <a href="">&copy; parasuempresa.com | Open C3 - GNU Project</a>
       </span>
 </div>
