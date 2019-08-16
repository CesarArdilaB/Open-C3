<?
session_start();

//print_r($_SESSION);

if($op != 100 and $_GET[sec] != "monitoring"){	
?>


<script>
setInterval( "EnviarLinkJ('incomingC','modules/asterisk/incomingcallchek.php?op=100','',1)", 2000 );
</script>

<div id="incomingC"></div>
<?
}
if($op==100){
if (!isset($_GET[camediting])) {include $_SERVER['DOCUMENT_ROOT'].'/openc3/appcfg/general_config.php'; }
include $_SERVER['DOCUMENT_ROOT'].'/openc3/appcfg/class_asterisk.php';
$astm = new ast_man();

if( !isset($_SESSION[camp_context]) and !isset($_SESSION[camp_cola]) and !isset($_SESSION[noin])){//verificamos las variables de sesion para el contexto y la cola
	
$ConsultaCamp = $sqlm->sql_select("agents_group,campaigns","cola,contexto,id_campaign","id_agents_group = '$_SESSION[groupag_ID]' AND id_campaign = campana",0);

if(is_array($ConsultaCamp) and $ConsultaCamp[0][cola] == "" and $ConsultaCamp[0][contexto] == ""){ $_SESSION[noin] = 0; }
 if(is_array($ConsultaCamp) and $ConsultaCamp[0][contexto] != ""){
	  
 $_SESSION[camp_context] = $ConsultaCamp[0][contexto]; 
 $_SESSION[camp_id] = $ConsultaCamp[0][id_campaign];
 
 }
 if(is_array($ConsultaCamp) and $ConsultaCamp[0][cola] != ""){ 
 
 $_SESSION[camp_cola] = $ConsultaCamp[0][cola]; 
 $_SESSION[camp_id] = $ConsultaCamp[0][id_campaign];
 
 }
//print_r($ConsultaCamp);
	
	}//verificamos las variables de sesion 

if(isset($_SESSION[camp_context])){ 

$entrando = $astm->in_exten($_SESSION[ext_NUMBER],$_SESSION[camp_context]);

if(is_array($entrando)){

	$TraeCamposTelefono = $sqlm->sql_select("autoform_tablas,autoform_config","nombrecampo,nombretabla","campaignid = '$_SESSION[camp_id]' AND idtabla_rel = id_autoformtablas AND telefono = 1",0);
	
	for($i=0 ; $i < count($TraeCamposTelefono) ; $i++){//este es el final del for
	
	$ConsultaRegs = $sqlm->sql_select($TraeCamposTelefono[0][nombretabla],$TraeCamposTelefono[0][nombretabla]."_id as idregistro","$entrando[callerid] REGEXP ".$TraeCamposTelefono[$i][nombrecampo],0);
	if(is_array($ConsultaRegs)){ $ARRid[] = $ConsultaRegs[0][idregistro]; }
		
	} //este es el final del for
	
	//print_r($ARRid);
	
?>

<div class="cuadrocall">
    <table width="200" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td colspan="2" align="center" class="textosbig"><div align="center">!Llamada Entrante!<br>
        Registros Encontrados: <?=count($ARRid)?></div></td>
      </tr>
<? for($i=0 ; $i < count($ARRid) ; $i++){//este es el final del for ?>
      <tr>
        <td class="textos_negros">Id: 
        <?=$ARRid[$i]?> <br> Telefono: <?=$entrando[callerid]?>         &nbsp;</td>
        <td align="center"><a href="/openc3/?sec=gestion&mod=agent_console&uniqid=<?=$entrando[unicoid]?>&calerid=<?=$entrando[callerid]?>&regediting=<?=$ARRid[$i]?>&camediting=<?=$_SESSION[camp_id]?>">Editar</a> <br> 
        <a href="/openc3/?sec=gestion&mod=agent_console&uniqid=<?=$entrando[unicoid]?>&calerid=<?=$entrando[callerid]?>&regediting=<?=$ARRid[$i]?>&camediting=<?=$_SESSION[camp_id]?>" target="_blank">Nueva Ventana</a> 
        &nbsp;</td>
      </tr>
<? } //este es el final del for ?>
      <tr>
        <td colspan="2" align="center"><a href="/openc3/?sec=gestion&mod=agent_console&uniqid=<?=$entrando[unicoid]?>&calerid=<?=$entrando[callerid]?>&camediting=<?=$_SESSION[camp_id]?>">Nuevo Registro</a>
        <br ><a href="/openc3/?sec=gestion&mod=agent_console&uniqid=<?=$entrando[unicoid]?>&calerid=<?=$entrando[callerid]?>&camediting=<?=$_SESSION[camp_id]?>" target="_blank">Nueva Ventana</a></td>
      </tr>
    </table>
</div>
    
<?
	
	}
	//si es real la llamada de entrada muestra el poup y la magia
	

}
if(isset($_SESSION[camp_cola])){ 

//echo $_SESSION[ext_NUMBER]." *** ";

$entrando_ag = $astm->in_agent($_SESSION[ext_NUMBER],$_SESSION[camp_cola]);

if(is_array($entrando_ag)){

	$TraeCamposTelefono = $sqlm->sql_select("autoform_tablas,autoform_config","nombrecampo,nombretabla","campaignid = '$_SESSION[camp_id]' AND idtabla_rel = id_autoformtablas AND telefono = 1",0);
	
	for($i=0 ; $i < count($TraeCamposTelefono) ; $i++){//este es el final del for
	
	$ConsultaRegs = $sqlm->sql_select($TraeCamposTelefono[0][nombretabla],$TraeCamposTelefono[0][nombretabla]."_id as idregistro","$entrando_ag[callerid] REGEXP ".$TraeCamposTelefono[$i][nombrecampo],0);
	if(is_array($ConsultaRegs)){ $ARRid[] = $ConsultaRegs[0][idregistro]; }
		
	} //este es el final del for
	
	//print_r($ARRid);
	
?>

<div class="cuadrocall">
    <table width="200" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td colspan="2" align="center" class="textosbig"><div align="center">!Llamada Entrante! <br> para el agente. <?=$_SESSION["agent_NUMBER"]?><br>
        Registros Encontrados: <?=count($ARRid)?></div></td>
      </tr>
<? for($i=0 ; $i < count($ARRid) ; $i++){//este es el final del for ?>
      <tr>
        <td class="textos_negros">Id: 
        <?=$ARRid[$i]?> <br> Telefono: <?=$entrando_ag[callerid]?>         &nbsp;</td>
        <td align="center"><a href="/openc3/?sec=gestion&mod=agent_console&uniqid=<?=$entrando_ag[unicoid]?>&calerid=<?=$entrando_ag[callerid]?>&regediting=<?=$ARRid[$i]?>&camediting=<?=$_SESSION[camp_id]?>">Editar</a> <br> 
        <a href="/openc3/?sec=gestion&mod=agent_console&uniqid=<?=$entrando_ag[unicoid]?>&calerid=<?=$entrando_ag[callerid]?>&regediting=<?=$ARRid[$i]?>&camediting=<?=$_SESSION[camp_id]?>" target="_blank">Nueva Ventana</a> 
        &nbsp;</td>
      </tr>
<? } //este es el final del for ?>
      <tr>
        <td colspan="2" align="center"><a href="/openc3/?sec=gestion&mod=agent_console&uniqid=<?=$entrando_ag[unicoid]?>&calerid=<?=$entrando_ag[callerid]?>&camediting=<?=$_SESSION[camp_id]?>">Nuevo Registro</a>
        <br ><a href="/openc3/?sec=gestion&mod=agent_console&uniqid=<?=$entrando_ag[unicoid]?>&calerid=<?=$entrando_ag[callerid]?>&camediting=<?=$_SESSION[camp_id]?>" target="_blank">Nueva Ventana</a></td>
      </tr>
    </table>
</div>
    
<?
	
	}
	//si es real la llamada de entrada muestra el poup y la magia
	




//echo "Configuracionin por cola ..."; 

}

//-------------------------------------------------------------
	
}
?>