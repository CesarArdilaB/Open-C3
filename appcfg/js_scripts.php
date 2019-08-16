<? 

class ScriptsSitio{

	var $rutaserver; 

function AllScripts(){ //compruba si solo debe incluir el validador de formularios?>
<!--<script type="text/javascript" src="<?=$this->rutaserver?>/js/newcal/calendar.js"></script>
<script type="text/javascript" src="<?=$this->rutaserver?>/js/newcal/lang/language_spanish.php"></script>
<script type="text/javascript" src="<?=$this->rutaserver?>/js/newcal/calendar-setup.js"></script>
<script type="text/JavaScript" src="<?=$this->rutaserver?>/js/Funciones.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=$this->rutaserver?>/js/newcal/calendar-win2k-cold-1.css" title="win2k-cold-1" />-->


<!--<script language="javascript" src="<?=$this->rutaserver?>/js/prototype.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=$this->rutaserver?>/js/newcal/calendar-win2k-cold-1.css" title="win2k-cold-1" />
-->
<link rel="stylesheet" type="text/css" href="<?=$this->rutaserver?>/libs/DataTables/media/css/demo_page.css" />
<link rel="stylesheet" type="text/css" href="<?=$this->rutaserver?>/libs/DataTables/media/css/demo_table.css" />


<link rel="stylesheet" type="text/css" href="<?=$this->rutaserver?>/css/estilos.css"/>

<script type="text/javascript" src="<?=$this->rutaserver?>/libs/jquery/jqueri161.js"></script>
<!--<script type="text/javascript" src="<?=$this->rutaserver?>/libs/jquery-1.3.2.js"></script>-->

<script type='text/javascript' src='<?=$this->rutaserver?>/libs/autocomplete/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='<?=$this->rutaserver?>/libs/autocomplete/lib/jquery.ajaxQueue.js'></script>
<script type='text/javascript' src='<?=$this->rutaserver?>/libs/autocomplete/lib/thickbox-compressed.js'></script>
<script type='text/javascript' src='<?=$this->rutaserver?>/libs/autocomplete/jquery.autocomplete.js'></script>
<script type='text/javascript' src='<?=$this->rutaserver?>/libs/jqueryui/js/jquery-ui-1.8.13.custom.min.js'></script>
<script src="<?=$this->rutaserver?>/libs/colorbox/colorbox/jquery.colorbox.js"></script>

<link media="screen" rel="stylesheet" href="<?=$this->rutaserver?>/libs/colorbox/example1/colorbox.css" />
<link rel="stylesheet" type="text/css" href="<?=$this->rutaserver?>/libs/autocomplete/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="<?=$this->rutaserver?>/libs/autocomplete/lib/thickbox.css" />
<link type="text/css" href="<?=$this->rutaserver?>/libs/jqueryui/css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />	


<? } // termina la funcion que trae todos los scripts

function ValFormScripts(){ ?>
<script type='text/javascript' src='<?=$this->rutaserver?>/libs/vanadium-min.js'></script>
<? } //aqui termina de traer el script que valida el formulario

function ReporteScripts(){?>
<script type="text/javascript" language="javascript" src="<?=$this->rutaserver?>/libs/DataTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" src="<?=$this->rutaserver?>/libs/DataTables/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" charset="utf-8" src="<?=$this->rutaserver?>/libs/DataTables/media/js/TableTools.js"></script>


<? }

function CharScripts(){?>
		<script type="text/javascript" src="<?=$this->rutaserver?>/libs/charts/js/highcharts.js"></script>
		<script type="text/javascript" src="<?=$this->rutaserver?>/libs/charts/js/modules/exporting.js"></script>
<? }


}//termina la clase?>