        <script type="text/javascript">
            $(function() {
				/**
				 * the menu
				 */
				var $menu = $('#ldd_menu');
				
				/**
				 * for each list element,
				 * we show the submenu when hovering and
				 * expand the span element (title) to 510px
				 */
				$menu.children('li').each(function(){
					var $this = $(this);
					var $span = $this.children('span');
					$span.data('width',$span.width());
					
					$this.bind('mouseenter',function(){
						$menu.find('.ldd_submenu').stop(true,true).hide();
						$span.stop().animate({'width':'160px'},300,function(){
							$this.find('.ldd_submenu').slideDown(300);
						});
					}).bind('mouseleave',function(){
						$this.find('.ldd_submenu').stop(true,true).hide();
						$span.stop().animate({'width':$span.data('width')+'px'},300);
					});
				});
            });
        </script>	
<?

$menuPAG=$sqlm->sql_select("module_permissions","id_page","idgroup = '$_SESSION[group_ID]'",0);

if(is_array($menuPAG)){//cierra if no tiene modulos	

for( $g=0 ; $g < count($menuPAG) ; $g++ ){
	
$menuPAGINA=$sqlm->sql_select("page_modules","modulegroup,page_title,module_folder,module_file","id_page_module ='".$menuPAG[$g][id_page]."'",0);

//$h=$g-1;

if($menuPAGINA != "No hay resultados"){	

		$arrGRUPO[$g] = utf8_encode($menuPAGINA[0][modulegroup]);
		
		$arrNOMBREPAG[$arrGRUPO[$g]] .= utf8_encode($menuPAGINA[0][page_title])."|";
		
		$arrFOLDER[$arrGRUPO[$g]] .= $menuPAGINA[0][module_folder]."|";
		
		$arrFILE[$arrGRUPO[$g]] .= $menuPAGINA[0][module_file]."|";

		}
	
	}	//---------------------------------------------


}//cierra if no tiene modulos	
else{
	
	echo "<div align='center'>No Ahy Permisos Asignados.</div>";
	exit;
	}

$arrGRUPOdep=array_unique($arrGRUPO);
sort($arrGRUPOdep);
ksort($arrNOMBREPAG);
ksort($arrFOLDER);
ksort($arrFILE);

?>
		<div class="box_menu">
			<h2>
			  <div><a href="<?="$RAIZHTTP/index.php"?>"><img src="jpg/logoweb.png" width="163" height="50" /></a></div>
			  <div style="margin-top:-30px ; margin-left:170px;"> - by: <a href="http://www.parasuempresa.com" target="_blank">p a r a s u e m p r e s a</a></div> 
            <div style="width:450px; margin-top:-15px;" align="right"><a href="?logout=1"> <?="Cerrar session"?> </a></div>
            <div style="float:right; position:absolute; right:10px; top:15px"><img src="imgs/logocliente.png" width="163" height="50" /></div></h2>
		
        <!---------------------------------------------- aqui empieza el menu de la plataforma ---------------------------------------->
<ul id="ldd_menu" class="ldd_menu">
<? 

for( $i=0 ; $i < count($arrGRUPOdep) ; $i++ ){

if($arrGRUPOdep[$i] != ""){//que no queden en blanco los grupos
	
	echo "<li>
			<span>$arrGRUPOdep[$i]</span>
			<div class=\"ldd_submenu\">
				<ul>
			<li class=\"ldd_heading\">Seleccione</li>";

 $sacarMENU=explode("|",$arrNOMBREPAG[$arrGRUPOdep[$i]]);
 $sacarFOLDER=explode("|",$arrFOLDER[$arrGRUPOdep[$i]]);
 $sacarFILE=explode("|",$arrFILE[$arrGRUPOdep[$i]]);

for( $o=0 ; $o < count($sacarMENU) ; $o++ ){
	
	if($sacarMENU[$o] != ""){///-----------------------
		echo "<li><a href='$RAIZHTTP/?sec=".$sacarFOLDER[$o]."&mod=".$sacarFILE[$o]."'>".$sacarMENU[$o]."</a></li>";
		}///-----------------------
	
	}

	echo "	</ul>
			<a class=\"ldd_subfoot\" href=\"$RAIZHTTP/index.php\"> + Inicio</a>
			</div>
			</li>";

}//que no queden en blanco los grupos
	
	}

?>
</ul>     