<?php
/* vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4:
  Codificación: UTF-8
  +----------------------------------------------------------------------+
  | Elastix version 0.5                                                  |
  | http://www.elastix.org                                               |
  +----------------------------------------------------------------------+
  | Copyright (c) 2006 Palosanto Solutions S. A.                         |
  +----------------------------------------------------------------------+
  | Cdla. Nueva Kennedy Calle E 222 y 9na. Este                          |
  | Telfs. 2283-268, 2294-440, 2284-356                                  |
  | Guayaquil - Ecuador                                                  |
  | http://www.palosanto.com                                             |
  +----------------------------------------------------------------------+
  | The contents of this file are subject to the General Public License  |
  | (GPL) Version 2 (the "License"); you may not use this file except in |
  | compliance with the License. You may obtain a copy of the License at |
  | http://www.opensource.org/licenses/gpl-license.php                   |
  |                                                                      |
  | Software distributed under the License is distributed on an "AS IS"  |
  | basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See  |
  | the License for the specific language governing rights and           |
  | limitations under the License.                                       |
  +----------------------------------------------------------------------+
  | The Original Code is: Elastix Open Source.                           |
  | The Initial Developer of the Original Code is PaloSanto Solutions    |
  +----------------------------------------------------------------------+
  $Id: new_campaign.php $ */

// Included from configs/default.conf.php
global $arrConfig;

include_once("libs/paloSantoDB.class.php");
require_once("libs/smarty/libs/Smarty.class.php");
require_once "$arrConfig[astman_dir]/phpagi-asmanager.php";
require_once("libs/js/jscalendar/calendar.php"); 
require_once("modules/break_administrator/libs/PaloSantoBreaks.class.php");

/*  FUNCION XAJAX:
    funcion que se llama cada 4 segundos para:
    - verificar que el usuario aun está conectado a una cola
    - verificar si hay una llamada conectada y si es asi traer los datos de la llamada.
      Se muestran diferentes datos dependiendo de la pestaña en que se encuentra.
*/
function notificaLlamada($pestania, $prefijo_objeto, $nueva_llamada, $id_formulario=NULL) {
    global $arrLan; 
    $msj="";
    $respuesta = new xajaxResponse();
    $agentnum = $_SESSION['elastix_agent_user'];
    $extn     = $_SESSION['elastix_extension'];
    $no_queue = false;
    $actualizar_pagina = false;

    // si el agente no esta conectado en el asterisk se llama a la funcion disconnet_agent,
    // se anulan las variables de sesión y
    // se hace submit de la pagina para regresar a la pantalla del login del agente
    if (!estaAgenteConectado($agentnum,$extn,$msj,$no_queue)) {
        disconnet_agent();
        $_SESSION['elastix_agent_user'] = null;
        $_SESSION['elastix_extension']  = null;
        $_SESSION['channel_active'] = null;
        $respuesta->addAlert($arrLan["Agent disconnected"]." - $msj");
        // se hace submit de la pagina para regresar a la pantalla del login del agente
        $respuesta->addScript("document.getElementById('frm_agent_console').submit();");

    } else {
        // Conexión a la base de datos
        global $arrLang;
        $pDB = getDB();

        // se comprueba la conexión a la base de datos
        if (!is_object($pDB) || $pDB->errMsg!="") {
            $respuesta->addAssign("mensajes_informacion","innerHTML",$pDB->errMsg);
            return $respuesta;
        }

        $smarty = getSmarty(); // Load smarty 
        $colgar_disable = "true";
        $style= 'boton_desactivo';

        // estas variables boleanas sirven para controlar los addAssign de los formularios, llamadas y scripts
        $actualizar_llamada = $actualizar_script = $actualizar_form = false; 

        // la variable tipo de llamada nos ayudará a saber si hay o no llamadas y de que tipo son
        $tipo_llamada="";
        $texto_llamada = $texto_script = $texto_formulario = "";

        // SE CONSULTAN LAS LLAMADAS ENTRANTES
        $arr_ingoing_calls = getDataIngoingCall($pDB,$agentnum,$msj);

        // si devuelve el array con datos, entonces la llamada es entrante
        if (is_array($arr_ingoing_calls) && count($arr_ingoing_calls)>0) {
            $tipo_llamada = "ENTRANTE";
        } else {
            // si la llamada no es entrante se consultan las llamadas salientes
            $arr_campania = getDataCampania($pDB,$agentnum,$msj);
            if (is_array($arr_campania) && count($arr_campania)>0) {
                $tipo_llamada = "SALIENTE";
            }
        }

        // si tipo de llamada es diferente de nulo entonces SI HAY UNA LLAMADA_ACTIVA (entrante o saliente)
        if ($tipo_llamada != "") {
            $respuesta->addScript("cancelarMarcado(); document.getElementById('marcar2').className='boton_marcar_inactivo';\n");
            $style= 'boton_activo';    // se asigna estilo del boton colgar llamada, como hay llamada esta activo
            $colgar_disable = "false"; // se las usa para habilitar el boton de colgar llamada

            // template que se uso para tener la pantalla sin ningún dato
            $template = "vacio.tpl";

            // variables que se usan para manejar el texto que va a ir en la pestaña de llamada y de script
            $texto_llamada = $texto_script = "";

            switch ($tipo_llamada) {
                /*-------------------------------------------------------------------------*/
                /*LLAMADAS ENTRANTES-------------------------------------------------------*/
                /*-------------------------------------------------------------------------*/
                case "ENTRANTE":

                    $id_call = $arr_ingoing_calls["id_call_entry"]; // id de la llamada
                    $phone = $arr_ingoing_calls["callerid"]; // caller id de la persona que esta llamando
                    $texto_script = $arr_ingoing_calls["script"]; // script especificado en la cola 
                    $actualizar_script=true;
                    $_SESSION['channel_active'] = $arr_ingoing_calls["ChannelClient"];

                    $tiempo_transcurso_llamada = explode(":",$arr_ingoing_calls["duracion_llamada"]);

                    // este if pregunta si la llamada ha cambiado, esto es importante para evitar
                    // que la barra de estado de llamadas se quede con información de una llamada anterior
                    if ($nueva_llamada["llamada"] == "" || $nueva_llamada["llamada"]!=$id_call) {

                        // defino el tipo de llamada, para luego poder saber como hacer la finalización de la llamada
                        $respuesta->addScript("document.getElementById('tipo_llamada').value= 'ENTRANTE';");

                        $respuesta->addScript("document.getElementById('nueva_llamada').value = '$id_call';");
                        $respuesta->addScript("document.getElementById('transfer').className = 'boton_tranfer_activo';");
                        $respuesta->addScript("document.getElementById('transfer').disabled=false; \n");
                        $actualizar_pagina=true;

                        // se prosigue a buscar si existe uno o varios contactos con ese número telefónico
                        $arr_contactos = getContactos($pDB,$phone);

                        $combo_cedula_ruc = "";
                        $id_contact = "";
                        // si existe el contacto en la tabla contacto se muestran sus datos,
                        // caso contrario un mensaje de que no existen datos
                        if (is_array($arr_contactos) && count($arr_contactos)>0) {
                            // en el foreach se crea el array para poder enviarlo a la funcion que crea el combo
                            $primer_contacto = 1; 
                            foreach($arr_contactos as $key=>$contact) {
                                // se pregunta por el primer numero de cedula ruc para luego hacer la consulta consultar_registro_contacto, puesto que si no se ejecuta el onChange del combo no se muestran los datos del contacto
                                if ($primer_contacto == 1) {
                                    $id_contact = $contact["id"];
                                }
                                $cedula_ruc_contactos[$contact["id"]] = $contact["cedula_ruc"];
                                $primer_contacto++;
                            }
                            // si hay mas de un contacto con el mismo numero de teléfono se muestra un combo, caso contrario solo se muestran los datos y se guarda en call_entry el id del contacto que llamó
                            if (count($cedula_ruc_contactos)>1) {
                                $combo_cedula_ruc = "<select name='cedula_ruc' id='cedula_ruc' onChange='xajax_getDataContacto(this.value)'>".crea_combo($cedula_ruc_contactos, "")."</select>";
                            } else {
                                $msj="";
                                if (!confirmar_contacto($id_call, $id_contact, $msj)) {
                                    $smarty->assign("mb_message", $msj);
                                }
                            }
        
                            // se consultan los datos del contacto porque que si no se ejecuta el onChange del combo no se muestran los datos del contacto
                            $row_contacto = array();
                            $data_contact = consultar_registro_contacto($id_contact, $row_contacto);
                            $texto_llamada = $data_contact;

                            $link_crm = crea_link_vtiger($id_contact, $row_contacto["origen"]);
                            $respuesta->addAssign("link_crm","innerHTML",$link_crm);

                        } else {
                            $combo_cedula_ruc .= $arrLan["Number Phone not Registered"];
                        }

                        // se muestra el número telefónico de la llamada entrante
                        $telefono_cedula =  "<b>".$arrLan["Phone"].":</b> ".$phone."<br>";
                        // si hay mas de un contacto con el número telefonico, entonces se muestra una lista con
                        // los contactos que tienen ese número de telefono y un boton para confirmar cual es el contacto 
                        if ($combo_cedula_ruc!="") {
                            $telefono_cedula .= "<b>".$arrLan["Contacts"].":</b> ".$combo_cedula_ruc;
                            if ($combo_cedula_ruc!=$arrLan["Number Phone not Registered"]) {
                                $telefono_cedula .= " <input type='button' name='confirmar' id='confirmar' value='".$arrLan["Confirm"]."' onClick='xajax_confirmar_cedula_contacto($id_call, document.getElementById(\"cedula_ruc\").value)'>";
                            }
                        }
                        $respuesta->addAssign("numero_telefono","innerHTML",$telefono_cedula);
                    }

                break;
                /*-------------------------------------------------------------------------*/
                /*LLAMADAS SALIENTES-------------------------------------------------------*/
                /*-------------------------------------------------------------------------*/
                case "SALIENTE":

                    // defino el tipo de llamada, para luego poder saber como hacer la finalización de la llamada
                    $respuesta->addScript("document.getElementById('tipo_llamada').value= 'SALIENTE';");

                    $id_call = $arr_campania["id_calls"];


                    //ECUASISTENCIA 2do Punto : Estamos seteando a una variable de sesion el id de la llamada
                    $_SESSION["id_last_call"] = $id_call; 
                    //ECUASISTENCIA 2do Punto fin


                    $texto = $arr_campania["script"];
                    $colgar_disable = "false";
                    $llamada = $arr_campania["phone"];
                    $cliente = $arr_campania["nombre_cliente"];
                    $_SESSION['channel_active'] = $arr_ingoing_calls["ChannelClient"];

                    $tiempo_transcurso_llamada = explode(":",$arr_campania["duracion_llamada"]);

//intregracion para CRM hecha por Andres Ardila y generada desde el administrador de CCM.

/*$sQueryCrmL = "SELECT link_ulr,variable,titulo FROM crm_link WHERE id_campana = '".$arr_campania["id_campaign"]."'";        
$arr_CrmLink = $pDB->fetchTable($sQueryCrmL, true);


if ($arr_CrmLink != FALSE or $arr_CrmLink != ""){ 

$costom_CRM="<b>ID CRM:</b> <a href='javascript:popup_CRM(".$arr_CrmLink["link_ulr"]."?".$arr_CrmLink["variable"]."=".$cliente.")'> ".$cliente ." - ".$arr_CrmLink["titulo"]." </a></span>"; 

}

else{

$costom_CRM="$cliente </span>";

	}*/

//intregracion para CRM hecha por Andres Ardila y generada desde el administrador de CCM.

                    $numero_telefono  = "<span class='celda_callcenter_grande'><b>".$arrLan['Call Number'].":</b> ".$llamada."<br>";
		
		$client=explode("|",$cliente);
					
//	$numero_telefono  .= "<a href='/vtigercrm/index.php?module=Contacts&action=EditView&record=".$cliente."&return_module=Contacts&return_action=index&parenttab=Sales&return_viewname=7' target='_blank'>Clik para CRM - ".$cliente." </a>";
	//$numero_telefono  .= "<a href='https://192.168.0.241/openc3/?sec=gestion&mod=agent_console&regediting=".$cliente."&camediting=".$arr_atributos[2]."' target='_blank'>Clik para CRM - ".$cliente." </a>";



					//$numero_telefono  .= $costom_CRM;

                    $respuesta->addAssign("numero_telefono","innerHTML",$numero_telefono);
                    $respuesta->addScript("document.getElementById('marcar').className = 'boton_marcar_activo';");
                    $respuesta->addScript("document.getElementById('transfer').className = 'boton_tranfer_activo';");
                    $respuesta->addScript("document.getElementById('marcar').disabled=false; \n");
                    $respuesta->addScript("document.getElementById('transfer').disabled=false; \n");

                    $codigo_js="";

                    switch ($pestania) {
                        case 'LLAMADA':
                            if ($nueva_llamada["llamada"] == "" || $nueva_llamada["llamada"]!=$id_call) {
                                $respuesta->addScript("document.getElementById('nueva_llamada').value = '$id_call';");
                                $actualizar_pagina=true;
                                $arr_atributos = getAttributesCall($pDB, $id_call);
                                if (is_array($arr_atributos)) {
                                 
								    $texto_llamada = "<br><table border='0'>";
                                 
								    foreach ($arr_atributos as $id=>$atributo) {
                                        $sTextoValor = $atributo["value"];
                         
						                if (strpos($sTextoValor, 'https://') === 0) {
                         
						 $sTextoValor = "<a target=\"_blank\" href=\"".$atributo["value"]."\"> Clik para CRM  </a>";
                         
						                }
                                        
                                        $texto_llamada .= "<tr>";
                         $texto_llamada .= "<td with='350' class='celda_callcenter'><b>".$atributo["columna"].":</b></td>";
                         $texto_llamada .= "<td class='celda_callcenter'>".utf8_encode($sTextoValor)."</td>";
                         $texto_llamada .= "</tr>";
										
                                    }
									
                                    $texto_llamada .= "</table>";
									
                                }
//ECUASISTENCIA: PONEMOS EL LINK DE PROGRAMAR LLAMADAS PARA GENERAR EL POPUP
            $id_campana = $arr_campania["id_campaign"];
            $respuesta->addAssign("link_programar_llamada","innerHTML","<a href='javascript: popup_llamada(\"modules/agent_console/libs/programar_llamadas.php?num_telefono=$llamada&id_call=$id_call&id_campana=$id_campana&cliente=$cliente\");' class='normal'>".$arrLan["ProgramCalls"]."</a>");

//ECUASISTENCIA FIN 
                            } // fin del if q controla si hay nueva llamada
                        break;
                        case 'SCRIPT':
                            if ($nueva_llamada["script"] == "" || !(isset($nueva_llamada["nuevo_script"]) && $nueva_llamada["nuevo_script"] == $id_call)) {
                                $respuesta->addScript("document.getElementById('nuevo_script').value = '$id_call';");
                                $actualizar_script=true;
                                $arr_atributos = getAttributesCall($pDB, $id_call);
                                if (is_array($arr_atributos)) {
                                    foreach ($arr_atributos as $id=>$atributo) {
                                        $texto = str_replace("{".$atributo['columna']."}", $atributo["value"], $texto);
                                    }
                                    $texto_script = $texto;
                                    $texto_script = "<span class='celda_callcenter'>".$texto_script."</span>";
                                }
                            } // fin del if q controla si hay nueva llamada
                        break;
                        case 'FORMULARIO':
                            if ($nueva_llamada["form"] == "" || $nueva_llamada["form"]!=$id_call) {
                                $respuesta->addScript("document.getElementById('nuevo_form').value = '$id_call';");
                                $actualizar_form=true;
                                $mostrar_template=false;
                                $arr_form = obtener_formularios($pDB,$arr_campania['id_campaign']); 

                                if(is_array($arr_form) && count($arr_form)>0){

                                    if($id_formulario==NULL)
                                        $id_formulario = obtener_primer_formulario($arr_form);

                                    $list_id_form = "";
                                    foreach ($arr_form as $key=>$form) {
                                        if ($list_id_form!="") $list_id_form .= ",";
                                        $list_id_form .= $form["id"];
                                    }

                                    $smarty_option = smarty_option($arr_form,$id_formulario);
                                    $smarty->assign("option_form", $smarty_option);
                                    $id_form = $id_formulario;
                                    if (strlen(trim($list_id_form))>0) {
                                        $sQuery = "
                                        SELECT
                                            field.id id_field,
                                            field.id_form,
                                            field.etiqueta,
                                            field.tipo,
                                            field.value value_field,
                                            field.orden,
                                            data.id id_data,
                                            data.id_calls,
                                            data.id_form_field,
                                            data.value value_data
                                        FROM form_field field LEFT JOIN form_data_recolected data
                                            ON field.id = data.id_form_field and data.id_calls=$id_call
                                        WHERE field.id_form in ($list_id_form)
                                        ORDER BY field.id_form, field.orden";
            
                                        $arr_fields = $pDB->fetchTable($sQuery, true);
                                        if (is_array($arr_fields) && count($arr_fields)>0) {
                                            $break_id = $id = $arr_fields[0]["id_form"];
                                            $ids_formularios=$id;
                                            foreach($arr_fields as $key=>$field) {
                                                $funcion_js = "";
                                                $input = crea_objeto($smarty, $field, $prefijo_objeto, $funcion_js);
                                                $etiqueta = $field["etiqueta"];
                                                $tipo = $field["tipo"];
                                                if ($break_id != $field["id_form"]) {
                                                    $break_id = $field["id_form"];
                                                    $id = $break_id;
                                                    $ids_formularios.="-".$id;
                                                }
            
                                                $data_field[] = array("TYPE" => $tipo, "TAG" => $etiqueta, "INPUT" => $input, "ID_FORM" => $id);
                                                $id = "";
                                                $codigo_js .= $funcion_js;
                                            }
                                            foreach ($data_field as $key=>$data) {
                                                $smarty->assign("FORMULARIO", $data);
                                            }
            
                                            $smarty->assign("FORMULARIO", $data_field);
                                            $smarty->assign("id_formularios", $ids_formularios);
                                            $smarty->assign("formularios", $arrLan["Form"]);
                                            $smarty->assign("fill_fields", $arrLan["Fill the fields"]);
                                            $smarty->assign("SAVE", $arrLang["Save"]);
                                            $mostrar_template=true;
                                        }
                                    }
                                    if ($mostrar_template) $template = "consola_formulario.tpl";
                                    else $template = "vacio.tpl";
                                }
                                else{
                                    global $arrLang;
                                    $smarty->assign("no_definidos_formularios",$arrLan['Forms Nondefined']);
                                    $template = "vacio.tpl";
                                }
                                $texto_formulario=$smarty->fetch("file:/var/www/html/modules/agent_console/themes/default/$template");
                            } // fin del if q controla si hay nueva llamada
                        break;
                    } // fin del switch de las pestañas en llamadas salientes
                break;

            } // FIN DEL SWICTH


            //INICIO: DEL CODIGO QUE DEBE IR PARA LLAMADAS SALIENTES Y ENTRANTES

            // INICIO: SETEANDO MENSAJE DEL ESTATUS ACTUAL DE LA LLAMADA
            $respuesta->addAssign("estatus_actual","innerHTML",$arrLan["Calling"]);
            $respuesta->addScript("document.getElementById('celda_estatus_actual').className = 'fondo_estatus_llamada'; ");
            //PARA EL CRONOMETRO 
            if($tiempo_transcurso_llamada) {
                $hora    = (int)$tiempo_transcurso_llamada[0];
                $minuto  = (int)$tiempo_transcurso_llamada[1];
                $segundo = (int)$tiempo_transcurso_llamada[2];
            }
            else{
                $hora    = 0;
                $minuto  = 0;
                $segundo = 0;
            }
            $respuesta->addScript(" var fecha_aux2 = breakCronometroSet(0,0,0,$hora,$minuto,$segundo);
                                                    estado_cronometro('llamada',fecha_aux2);");
            // FIN: SETEANDO MENSAJE DEL ESTATUS ACTUAL DE LA LLAMADA

            //FIN: DEL CODIGO QUE DEBE IR PARA LLAMADAS SALIENTES Y ENTRANTES

        } else { // CASO CONTRARIO: NO HAY LLAMADAS ACTIVAS
            $respuesta->addScript("document.getElementById('marcar2').className='boton_marcar_activo';\n");

            $_SESSION['channel_active'] = null;
            // se limpia el link de crm
            $respuesta->addAssign("link_crm","innerHTML","");

            $respuesta->addAssign("numero_telefono","innerHTML","");
            // se activa las banderas que permiten luego actualizar la ventana con el nuevo texto

            //ECUASISTENCIA 2do Punto : Hemos dejado que el formulario se mantenga activo
            $actualizar_pagina=$actualizar_script=true;
            //ECUASISTENCIA 2do Punto fin
            
            // se limpia la pantalla tanto para la pestaña llamada, script y form
            $respuesta->addScript("document.getElementById('nueva_llamada').value = '';
                                   document.getElementById('nuevo_script').value = '';
                                   document.getElementById('nuevo_form').value = '';");
            // si el agente $agentnum no esta en pausa entra por el if
            if (!estaAgenteEnPausa(null,$agentnum)) {
                $estatus = $arrLan["Call no active"];
                $respuesta->addScript("document.getElementById('celda_estatus_actual').className = 'fondo_estatus_no_llamada';");
                //$respuesta->addScript("document.getElementById('marcar').className = 'boton_marcar_inactivo';");
                $respuesta->addScript("document.getElementById('transfer').className = 'boton_tranfer_inactivo';");
                //$respuesta->addScript("document.getElementById('marcar').disabled=true; \n");
                $respuesta->addScript("document.getElementById('transfer').disabled=true; \n");

                //PARA EL CRONOMETRO
                $respuesta->addScript("estado_cronometro('noLlamada',null);\n");

            } else {
                if(!isset($_SESSION['elastix_agent_audit']) || is_null($_SESSION['elastix_agent_audit'])){
                    $id_audit = auditoria_break_insert($_SESSION['elastix_agent_break'],$agentnum);
                    if($id_audit!=null) {
                        $_SESSION['elastix_agent_audit']=$id_audit;
                    }
                } 
                $estatus = $arrLan["In Break"].": ".obtener_break_audit($pDB,$_SESSION['elastix_agent_audit']);

                $respuesta->addScript("document.getElementById('celda_estatus_actual').className = 'fondo_estatus_break';");

                //PARA EL CRONOMETRO //HAY QUE VER COMO SOLUCIONAR PORQUE ESTA FUNCION SE LLAMA CADA 4 SEGUNDOS (SOLUCIONADO CON $soloUnaVez)
                //VARIABLE GLOBLA PARA CONTROLAR EL LAMADO INNECESARIO DE LA FUNCION obtener_tiempo_acumulado_break
                //AL REFRESCAR DE NUEVO CONSULTA Y ESO TRAIA PROBLEMAS DE MULTIPLES LLAMADO A LAFUNCION POR MOTIVOS DE
                //LA PERSISTENCIA DEL CRONOMETRO  
                if(!isset($_SESSION['elastix_agent_soloUnaVez'])){

                    $_SESSION['elastix_agent_soloUnaVez']=true;
                    $tiempo_acumulado = obtener_tiempo_acumulado_break(date('Y-m-d'),$agentnum,$_SESSION['elastix_agent_break']);

                    if($tiempo_acumulado) {
                        $hora    = (int)$tiempo_acumulado[0];
                        $minuto  = (int)$tiempo_acumulado[1];
                        $segundo = (int)$tiempo_acumulado[2];
                    }
                    else{
                        $hora    = 0;
                        $minuto  = 0;
                        $segundo = 0;
                    }
                   $respuesta->addScript(" var fecha_aux = breakCronometroSet(0,0,0,$hora,$minuto,$segundo);
                                            estado_cronometro('enBreak',fecha_aux);");
                }
            }

            $texto_script = getScriptCampaniaActiva($pDB);
    
            if ($texto_script) {
                $texto_script = "<span class='celda_callcenter'>".$texto_script."</span>";
            } else {
                $texto_script="";
            }

            $respuesta->addAssign("estatus_actual","innerHTML",$estatus);
            $texto = "<span style='color:#000000; FONT-SIZE: 13px;'><b>Agente $agentnum</b><br>En este momento no se ha comunicado con ningún número telefónico.</span>";
        } // FIN DEL ELSE QUE CONTROLA QUE NO HAY LLAMADAS ACTIVAS

        // SIN IMPORTAR QUE HAYA O NO UNA LLAMADA ACTIVA
        $pDB->disconnect();
        if ($actualizar_pagina) {
            $respuesta->addAssign("contenedor_llamada","innerHTML",$texto_llamada);
        }
        if ($actualizar_script) {
            $respuesta->addAssign("contenedor_script","innerHTML",$texto_script);
        }
        if ($actualizar_form) {
            $respuesta->addAssign("contenedor_formulario","innerHTML",$texto_formulario);
            if ($texto_formulario != "") {
                $respuesta->addScript("mostrarFormularioSeleccionado('$id_formulario');");
            }
        }
        $respuesta->addScript("document.getElementById('hangup').disabled=$colgar_disable; \n");
        $respuesta->addScript("document.getElementById('hangup').className='$style'; \n");

        if (isset($codigo_js) && trim($codigo_js)!="") {
           $respuesta->addScript($codigo_js);
        }
        $respuesta->addAssign("control","value","1");

    } // FIN DEL ELSE: ESTA LOGONEADO EL AGENTE

    //tenemos que devolver la instanciación del objeto xajaxResponse
    return $respuesta;
}

/*  FUNCION XAJAX:
    funcion que cuelga una llamada saliente conectada
*/
function colgarLlamada() {

    //if (!$agentnum)
    $agentnum = $_SESSION['elastix_agent_user'];

    global $arrLang;
    global $arrLan;
    $pDB = getDB();
    $smarty = getSmarty(); // Load smarty 

    $sQuery = "
        SELECT
          current_calls.id,
          current_calls.Channel channel,
          current_calls.fecha_inicio,
          calls.phone
        FROM
          current_calls,
          calls
        WHERE
          current_calls.agentnum='$agentnum'
          and current_calls.event='Link'
          and current_calls.id_call = calls.id";
    $arr_llamada = $pDB->getFirstRowQuery($sQuery, true);

    $resultado="";
    if (is_array($arr_llamada) && count($arr_llamada)>0) {
        if (isset($arr_llamada["channel"])) {
            finalizar_llamada_asterisk($arr_llamada["channel"], $resultado);
        } else {
            $resultado = $arrLan["Call no active"];
        }
    } else {
        $resultado = $arrLan["Call no active"];
    }
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    // si hay texto en resultado se lo muestra porque de seguro es la descripción de algun error
    if ($resultado!="") {
        $respuesta->addAssign("mensajes_informacion","innerHTML",$resultado);
    }
    $respuesta->addAssign("control","value","1");

    //tenemos que devolver la instanciación del objeto xajaxResponse
    return $respuesta;
}


/*  FUNCION XAJAX:
    funcion que cuelga una llamada entrante conectada
*/
function colgarLlamadaEntrante() {
    $pDB = getDB();
    $agentnum = $_SESSION['elastix_agent_user'];

    global $arrLang;
    global $arrLan;

    $sQuery = "
        SELECT
          current_call_entry.id
        FROM
          current_call_entry,
          agent
        WHERE
          current_call_entry.id_agent=agent.id
          and agent.number = '$agentnum'
          and agent.estatus ='A'";
    $arr_llamada = $pDB->getFirstRowQuery($sQuery, true);
    $resultado="";
    if (is_array($arr_llamada) && count($arr_llamada)>0) {
        $channel = "Agent/$agentnum";
        finalizar_llamada_asterisk($channel, $resultado);
    } else {
        $resultado = $sQuery;
    }

    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    // si hay texto en resultado se lo muestra porque de seguro es la descripción de algun error
    if ($resultado!="") {
        $respuesta->addAssign("mensajes_informacion","innerHTML",$resultado);
    }
    $respuesta->addAssign("control","value","1");

    //tenemos que devolver la instanciación del objeto xajaxResponse
    return $respuesta;
}

/*
    funcion que se conecta al asterisk y hace que finalice la llamada enviandole como parametro el canal.
*/
function finalizar_llamada_asterisk($channel, &$resultado) {
    global $arrLan;
    if ($channel!="") {
        $ip_asterisk = $_SESSION["ip_asterisk"];
        $user_asterisk = $_SESSION["user_asterisk"];
        $pass_asterisk = $_SESSION["pass_asterisk"];

        // Conexión con el Asterisk 
        $astman = new AGI_AsteriskManager();
        save_log_prueba("Conectando en finalizar_llamada_asterisk");
        if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
            $resultado = $arrLan["Error when connecting to database Call Center"];
        save_log_prueba("Error al conectar en finalizar_llamada_asterisk");
        } else {
            $arr_resultado = $astman->Hangup($channel);
            if ($arr_resultado["Response"] != "Success") {
                $resultado = $arr_resultado["Response"]." - ".$arr_resultado["Message"];
            }
            save_log_prueba("Desconecta en finalizar_llamada_asterisk\n");
            $astman->disconnect();
        }
    } else {
        $resultado = $arrLan["Call can't be closed, channel is empty"]; 
    }
}

/*  FUNCION XAJAX:
    funcion que hace que una llamada se ponga en hold 
*/
function hold() {
    global $arrLang;
    global $arrLan;
    $respuesta = new xajaxResponse();
    $pDB = getDB();

    $agentnum = $_SESSION['elastix_agent_user'];
    $member = "Agent/$agentnum";

    $aa="";
    $arr_ingoing_calls = getDataIngoingCall($pDB,$agentnum,$aa);
    if (is_array($arr_ingoing_calls) && count($arr_ingoing_calls)>0) {
        $tipo_llamada = "ENTRANTE";
    } else {
        // SE CONSULTAN LAS LLAMADAS SALIENTES
        $msg = NULL;
        $arr_campania = getDataCampania($pDB, $agentnum, $msg);
        if (is_array($arr_campania) && count($arr_campania)>0) {
            $tipo_llamada = "SALIENTE";
        }
    }
//$respuesta->addAlert("Tipo llamada = ".$tipo_llamada);
    if ($tipo_llamada != "") {

        //se obtiene el id del break que es para hold
        $break = get_break_hold($pDB);
        if (is_array($break)) {
	    $id_break = $break['id'];
            // según el tipo de llamada se actualiza la tabla current_calls o current_call_entry
            switch ($tipo_llamada) {
                case "ENTRANTE":
                    $tabla = "current_call_entry";
                    $id_tabla = $arr_ingoing_calls["id_current_call_entry"];
                    $channel = $arr_ingoing_calls["ChannelClient"];
                break;
                case "SALIENTE":
                    $tabla = "current_calls";
                    $id_tabla = $arr_campania["id_current_calls"];
                    $channel = $arr_campania["ChannelClient"];
//$respuesta->addAlert("Si entro a saliente y encontro el id del break para hold");
                break;
            }

            // funcion que retorna la extensión de parqueo si esta estubiera parqueada, caso contrario retorna falso. En esta función se hace un show parkedcalls.
            $ext_parqueo = get_extension_parqueo(null,$channel);
            // si la llamada no está en hold, hay que ponerla en hold
            if (!$ext_parqueo) {
//$respuesta->addAlert("Entro al if que indica que no está parkeada");
                // se actualiza el campo hold en la tabla current_calls o current_call_entry con el valor "S", esto indica que la llamada está el hold y no hay borrarla
                $sPeticionSQL = "update $tabla set hold='S' where id=$id_tabla ";
                $result = $pDB->genQuery($sPeticionSQL);
//$respuesta->addAlert("Se ejecuta update: ".$sPeticionSQL);
                if ($result) {
//$respuesta->addAlert("Se ejecuta exitosamente el update");
                    // se toma el id del break para pner al agente en ese break
                    $respuesta->addScript(agente_break($id_break));
                    // redireccionar la llamada a la cola de parqueo y devuelve la extensión de parqueo a la que se direccionó la llamada 
                    $ext_parqueo = enviar_cola_parqueo($channel);
//$respuesta->addAlert("La ext de parqueo que se obtiene es ".$ext_parqueo);
                 }
            // caso contrario, la llamada está el hold, hay que ponerla quitarle el hold 
            } else {
//$respuesta->addAlert("Entro al else que indica que SI está parkeada");
                if ($ext_parqueo) {
                    // origino la llamada para que el agente tome la llamada que puso en hold
//$respuesta->addAlert("Toma la llamada parkeada en la ext_parque = $ext_parqueo");
                    tomar_llamada_parqueo($ext_parqueo);
                }
                // quitar la pausa al agente y grabar hora fin del break en audit
                $respuesta->addScript(agente_break($id_break));
                // se actualiza el campo hold en la tabla current_calls o current_call_entry con el valor "N", esto indica que la llamada está el hold ya puede ser borrada
                $sPeticionSQL = "update $tabla set hold='N' where id=$id_tabla ";
//$respuesta->addAlert("Actualiza otra vez la tabla ".$sPeticionSQL);
                $result = $pDB->genQuery($sPeticionSQL);
            } // fin del else del if que pregunta si no hay llamada en hold 
        } // fin del if que pregunta si encontro el break tipo hold 
    } // fin del if que pregunta si hay llamada activa (entrante o saliente)
//$respuesta->addAlert("Saliendo de función hold");
    return $respuesta;
}

/*  FUNCION XAJAX:
    funcion que pone en break a un agente
*/
function agente_break($id_break) {
    global $arrLang;
    global $arrLan;

    // datos para la conexión al asterisk
    $ip_asterisk = $_SESSION["ip_asterisk"];
    $user_asterisk = $_SESSION["user_asterisk"];
    $pass_asterisk = $_SESSION["pass_asterisk"];

    $agentnum = $_SESSION['elastix_agent_user'];
    $member = "Agent/$agentnum";
    $respuesta = "";
    $astman = new AGI_AsteriskManager( );
    save_log_prueba("Conectando en agente_break");
    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
        $resultado = $arrLan["Error when connecting to Asterisk Manager"];
        save_log_prueba("Error al conectar en agente_break");
    } 
    else{ 
        // si no está en pausa, quiere decir que se lo va a poner en pausa
        if (!estaAgenteEnPausa($astman, $agentnum)) {
            //$salida = $astman->QueuePause(null,$member,"true");
            $salida = QueuePause($astman, null,$member,"true");
            save_log_prueba("Desconecta en agente_break\n");
            $astman->disconnect();
            $resultado = $salida['Message'];
            $_SESSION['elastix_agent_break']=$id_break;
            $_SESSION['elastix_agent_soloUnaVez']=null;
            $id_audit = auditoria_break_insert($_SESSION['elastix_agent_break'],$agentnum);
            $_SESSION['elastix_agent_audit'] = $id_audit;
            $name_pausa = $arrLan["UnHold"];
            $style = 'boton_unbreak';
            $respuesta .= "document.getElementById('div_list').style.display ='none';";
        // caso contrario, está en pausa, quiere decir que hay q quitar la pausa
        } else {
            //$salida = $astman->QueuePause(null,$member,"false");
            $salida = QueuePause($astman, null,$member,"false");
            save_log_prueba("Desconecta en agente_break\n");
        $astman->disconnect();
            $resultado = $salida['Message'];
            if(!auditoria_break_update($_SESSION['elastix_agent_audit'])){
                $smarty->assign("mb_title", $arrLan["Audit Error"]);
                $smarty->assign("mb_message", $arrLan['Audit of break could not be inserted']);
            }
            $_SESSION['elastix_agent_audit'] = null;
            $_SESSION['elastix_agent_break'] = null;
            $_SESSION['elastix_agent_soloUnaVez']=null;
            $name_pausa = $arrLan["Hold"];
            $respuesta .= "estado_cronometro('unBreak',null);";
            $style = 'boton_break';
         }
        $respuesta .= "document.getElementById('hold').value='".$name_pausa."';";
        $respuesta .= "document.getElementById('hold').className='".$style."';";
    }
    return $respuesta;
}

function enviar_cola_parqueo($channel) {

    // datos para la conexión al asterisk
    $ip_asterisk = $_SESSION["ip_asterisk"];
    $user_asterisk = $_SESSION["user_asterisk"];
    $pass_asterisk = $_SESSION["pass_asterisk"];
    $ext_parqueo_asterisk = $_SESSION["ext_parqueo"];

    $ext_parqueo = false;
    $astman = new AGI_AsteriskManager( );
    save_log_prueba("Conectando en enviar_cola_parqueo");
    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
        $resultado = $arrLan["Error when connecting to Asterisk Manager"];
        save_log_prueba("Error al conectar en enviar_cola_parqueo");
    } 
    else{
        $salida = $astman->Redirect($channel,"",$ext_parqueo_asterisk,"from-internal","1");
        if ($salida["Response"] != strtoupper("ERROR")) {
            sleep(3);
            $ext_parqueo = get_extension_parqueo($astman, $channel);
        }
        save_log_prueba("Desconecta en enviar_cola_parqueo\n");
        $astman->disconnect();
    }
    return $ext_parqueo;
}

function tomar_llamada_parqueo($ext_parqueo) {
    // datos para la conexión al asterisk
    $ip_asterisk = $_SESSION["ip_asterisk"];
    $user_asterisk = $_SESSION["user_asterisk"];
    $pass_asterisk = $_SESSION["pass_asterisk"];

    $astman = new AGI_AsteriskManager( );
    save_log_prueba("Conectando en tomar_llamada_parqueo");
    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
        save_log_prueba("Error al conectar en tomar_llamada_parqueo");
        $resultado = $arrLan["Error when connecting to Asterisk Manager"];
    } else{

        $agentnum = $_SESSION['elastix_agent_user'];
        $channel_agente = "Agent/$agentnum";


        $salida = $astman->Originate($channel_agente,$ext_parqueo,"from-internal","1",NULL, NULL, NULL, NULL, NULL, NULL, TRUE, NULL);
        save_log_prueba("Desconecta en tomar_llamada_parqueo\n");
        $astman->disconnect();
        if ($salida["Response"] != strtoupper("ERROR")) {
            $resultado .= "ingreso $agentnum $channel_agente";
            return $resultado;
        }


    }
    return false;
}

function get_extension_parqueo($astman, $channel) {
    $ext_parqueada = false;
    $desconectar = false;
    if (!is_object($astman)) {
        // datos para la conexión al asterisk
        $ip_asterisk = $_SESSION["ip_asterisk"];
        $user_asterisk = $_SESSION["user_asterisk"];
        $pass_asterisk = $_SESSION["pass_asterisk"];

        $desconectar = true;
        save_log_prueba("Conectando en get_extension_parqueo");
        $astman = new AGI_AsteriskManager( );	
        if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
            save_log_prueba("Error al conectar en get_extension_parqueo");
            $resultado = $arrLan["Error when connecting to Asterisk Manager"];
            return false;
        }
    }
    $hardware = $_SESSION["hardware"];
    //$hardware = "SIP|IAX|ZAP|H323|OH323";
    $salida = $astman->Command("show parkedcalls");
    $arrParkedCall = split("\n", $salida['data']);

//$ext_parqueada = "no entro al foreach";
    foreach($arrParkedCall as $linea){
        if(eregi("^[[:space:]]*([[:digit:]]{2,})[[:space:]]*$channel", $linea, $arrReg1)) {
            $ext_parqueada = $arrReg1[1];
            break;
        }
    }

    if ($desconectar) {
        $astman->disconnect();
        save_log_prueba("Desconecta en get_extension_parqueo\n");
    }
    return $ext_parqueada;
}

// funcion que trae cual es el break tipo hold
function get_break_hold($pDB) {
    $sQuery = "SELECT id, name FROM break WHERE tipo='H'";
    return $pDB->getFirstRowQuery($sQuery, true);
}

/*  FUNCION XAJAX:
    funcion que quita y añade a un agente de la cola, con el objetivo de evitar que por
    cierto tiempo el agente no reciba llamadas.
*/
function pausar_llamadas($id_break)
{
    global $arrLang;
    global $arrLan;
    $respuesta = new xajaxResponse();
    $agentnum = $_SESSION['elastix_agent_user'];

    $member = "Agent/$agentnum";
    $smarty = getSmarty(); // Load smarty 

    save_log_prueba("Conectando en pausar_llamadas");

    // datos para la conexión al asterisk
    $ip_asterisk = $_SESSION["ip_asterisk"];
    $user_asterisk = $_SESSION["user_asterisk"];
    $pass_asterisk = $_SESSION["pass_asterisk"];

    $astman = new AGI_AsteriskManager( );	
    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
        save_log_prueba("Error al conectar en pausar_llamadas");
        $resultado = $arrLan["Error when connecting to Asterisk Manager"];
    } 
    else{ 
        if (!estaAgenteEnPausa($astman, $agentnum)) {
            //$salida = $astman->QueuePause(null,$member,"true");
            $salida = QueuePause($astman, null,$member,"true");
            $resultado = $salida['Message'];
            $_SESSION['elastix_agent_break']=$id_break;
            $_SESSION['elastix_agent_soloUnaVez']=null;
            /*$id_audit = auditoria_break_insert($id_break,$agentnum); SE CAMBIO LA IMPLEMENTACION AL INSERTAR  A NOTIFICA LLAMADA POR RAZONES DE EXACTITUD EN EL TIEMPO DE INICIO DE BREAK
            if($id_audit!=null)
                $_SESSION['elastix_agent_audit']=$id_audit;*/
            $name_pausa = $arrLan["UnBreak"];
            $style = 'boton_unbreak';
            $respuesta->addScript("document.getElementById('div_list').style.display ='none'; \n");
        } else {
            //$salida = $astman->QueuePause(null,$member,"false");
            $salida = QueuePause($astman, null,$member,"false");
            $resultado = $salida['Message'];
            if(!auditoria_break_update($_SESSION['elastix_agent_audit'])){
                $smarty->assign("mb_title", $arrLan["Audit Error"]);
                $smarty->assign("mb_message", $arrLan['Audit of break could not be inserted']);
            }    
            $_SESSION['elastix_agent_audit'] = null;
            $_SESSION['elastix_agent_break'] = null;
            $_SESSION['elastix_agent_soloUnaVez']=null;
            $name_pausa = $arrLan["Break"];
            $respuesta->addScript("estado_cronometro('unBreak',null);\n");
            $style = 'boton_break';
        }
        $respuesta->addScript("document.getElementById('pause').value='".$name_pausa."'; \n");
        $respuesta->addScript("document.getElementById('pause').className='".$style."'; \n");
        save_log_prueba("Desconecta en pausar_llamadas\n");
        $astman->disconnect();
    }
    return $respuesta;
}


/* Funcion que por seguridad cuando ingrese un agente ingrese como estado sin pausa*/
function entrar_agente_sin_pausa($agente)
{
    $member = "Agent/$agente";
    global $arrLang;
    global $arrLan;

    // datos para la conexión al asterisk
    $ip_asterisk = $_SESSION["ip_asterisk"];
    $user_asterisk = $_SESSION["user_asterisk"];
    $pass_asterisk = $_SESSION["pass_asterisk"];

    $astman = new AGI_AsteriskManager( );	
    save_log_prueba("Conectando en entrar_agente_sin_pausa");
    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
        save_log_prueba("Error al conectar en entrar_agente_sin_pausa");
        $resultado = $arrLan["Error when connecting to Asterisk Manager"];
    } else { 
        if(estaAgenteEnPausa($astman, $agente)) {
            //$salida = $astman->QueuePause(null,$member,"false");
            $salida = QueuePause($astman, null,$member,"false");
            if($salida['Response']=='Error') {
                $mensaje_return = $arrLan['Unable to pause Agent to queue: No such queue']; 
            } else {
                $mensaje_return = 'se_quito_pause';
            }
        } else {
            $mensaje_return = 'sin_pause';
        }
        save_log_prueba("Desconecta en entrar_agente_sin_pausa\n");
        $astman->disconnect();
        return $mensaje_return;
    }
}
/*  FUNCION XAJAX:
    funcion hace que la extension que llega por parametro se logonee con el numero de agente
    que tambien llega por parámetro. Esto se lo hace originado una llamada desde la extension
    hacia el numero *8888 que es desde donde se conecta a la cola.
*/
function loginAgente($extn,$numAgente) {

    global $arrLang;
    global $arrLan;

    $ip_asterisk = $_SESSION["ip_asterisk"];
    $user_asterisk = $_SESSION["user_asterisk"];
    $pass_asterisk = $_SESSION["pass_asterisk"];

    $result = 1;
    $respuesta = new xajaxResponse();
    save_log_prueba("Conectando en loginAgente");
    // Conexión con el Asterisk
    $astman = new AGI_AsteriskManager();
    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
        save_log_prueba("Error al conectar en loginAgente");
        $respuesta->addScript("alert('".$arrLan["Error when connecting to Asterisk Manager"]."')");
    } else {
        if ($extn!="0" && $numAgente!="") {
            $arr_resultado = $astman->Originate($extn, "*8888".$numAgente, 'from-internal',1,NULL,NULL, NULL, NULL, NULL, NULL,'yes', 'id_nada');
            $respuesta->addAssign("pregunta_logoneo", "value", "1");
        } else {
            $respuesta->addAssign("mensaje","innerHTML",$arrLan["Please enter your number agent"]);
            $respuesta->addAssign("pregunta_logoneo", "value", "0");
        }
        $astman->disconnect();
        save_log_prueba("Desconecta en loginAgente\n");
    }
    return $respuesta;
 
}

/*  FUNCION XAJAX:
    funcion que pregunta cada segundo y medio si el agente que llega por parametro esta logoneado en la extension que tambien llega por parametro.
*/
function wait_login($extn, $num_agent) {
    global $arrLang;
    global $arrLan;
    $pDB = getDB();
    $datetime_init = date("Y-m-d H:i:s");
    $msj="";
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();

    $no_queue= false;
    if (estaAgenteConectado($num_agent,$extn,$msj,$no_queue)) {
        $respuesta->addAssign("status_login", "value","1");
        $encolado = entrar_agente_sin_pausa($num_agent);
        if($encolado=='se_quito_pause' || $encolado=='sin_pause'){
            $_SESSION['elastix_agent_user'] = $num_agent;
            $_SESSION['elastix_extension'] = $extn;

            if(!yaEstaRegistrado($num_agent,$datetime_init,$msj)) {
                if($msj=="") {
                    if( !registrarLogin($num_agent,$datetime_init,$msj) ) {
                        $respuesta->addAssign("mensaje","innerHTML","$msj");
                    } else {
                        //$respuesta->addAlert("registrado");
                    }
                } else {
                    //$respuesta->addAlert("este es el mensaje ".$msj);
                }
            } else {
                //$respuesta->addAlert("ya esta registrado ".$msj); 
            }
        }
        else{
            $respuesta->addAssign("mensaje","innerHTML","$encolado");
            $respuesta->addAssign("error_igual_numero_agente","value",1);
            $respuesta->addScript("document.getElementById('input_agent_user').value=''");
        }
    } else {
        if ($msj!="" && !$no_queue) {
            $respuesta->addAssign("mensaje","innerHTML","$mensaje");
            $respuesta->addAssign("error_igual_numero_agente","value",1);
            $respuesta->addScript("document.getElementById('input_agent_user').value=''");
        }
        $respuesta->addAssign("status_login", "value","0");
    }
    return $respuesta;
}

/*  FUNCION XAJAX:
    Que guarda la informacion del cliente que es ingresada desde el formulario del callcenter.
*/
function guardar_informacion_cliente($data_cliente) {
    global $arrLang;
    global $arrLan;
    //instanciamos el objeto para generar la respuesta con ajax
    $respuesta = new xajaxResponse();
    $pDB = getDB();
    $agentnum = $_SESSION['elastix_agent_user'];

    $msg = NULL;
    $arr_campania = getDataCampania($pDB, $agentnum, $msg);
    $valido=false;

    //ECUASISTENCIA 2do Punto : Hemos hecho varipos cambios a las condiciones para manejar el formulario mientras el agente lo llena cuando cuelga la llamada
    $id_calls="";
    if (is_array($arr_campania) && count($arr_campania)>0) {
            $id_calls = $arr_campania["id_calls"];
            //$respuesta->addAlert("encontr�data en current_calls");
    } else {
        if (isset($_SESSION["id_last_call"]) && $_SESSION["id_last_call"]!="") {
            //$respuesta->addAlert("obtuvo data de la session");
            $id_calls = $_SESSION["id_last_call"];
        }
    }
    if (is_array($data_cliente) && $id_calls!="") {
            foreach($data_cliente as $indice=>$objeto) {
                $id_form_field = $objeto[0];
                $value = trim($objeto[1]);

                $existe = existe_registro($pDB, $id_calls, $id_form_field);

                if ($existe) {
                    $sPeticionSQL = paloDB::construirUpdate(
                        "form_data_recolected",
                        array(
                            "value"          =>  paloDB::DBCAMPO($value)
                        ),
                        " id_calls=$id_calls and id_form_field=$id_form_field "
                        );
                         $result = $pDB->genQuery($sPeticionSQL);
                } else {
                    if (isset($value) && trim($value)!="") { 
                        $sPeticionSQL = paloDB::construirInsert(
                        "form_data_recolected",
                        array(
                            "id_calls"       =>  paloDB::DBCAMPO($id_calls),
                            "id_form_field"  =>  paloDB::DBCAMPO($id_form_field),
                            "value"          =>  paloDB::DBCAMPO($value)
                        ));
                        $result = $pDB->genQuery($sPeticionSQL);
                    } else {
                        $result=true;
                    }
                }

                if (!$result) {
                    $valido=false;
                    break;
                } else {
                    $valido=true;
                }
            }
    }
    if ($valido) {
        $respuesta->addScript("alert('".$arrLan["Information was saved"]."')");
    } else {
        $respuesta->addScript("alert('".$arrLan["Error saving client information"]."')");
    }
    //$pDB->disconnect();
    return $respuesta;
}


/* Funcion que se encarga de resolver acciones cuando se cierra el navegador incorecctamente
   como: No cerro un Break y no se hizo logoff del agente
 */
function evento_cerrar_navegador()
{
    $respuesta = new xajaxResponse(); 
    $resultado = disconnet_agent();
    if($resultado=='ok')
        $respuesta->addAlert("Agent logoff was make correct and audit break was save");
    else
        $respuesta->addAlert($resultado);
    return $respuesta;
}


/* FUNCION AJAX:
   Funcion que es llamada desde el evento onChange del combo que tiene como opciones los contactos
   que tiene un mismo numero telefonico (Cedulas). Esto se muestra en las llamadas entrantes.
   Esta funcion retorna la informacion del contacto seleccionado.
*/
function getDataContacto($id_contact) {
    $respuesta = new xajaxResponse();
    $row_contacto = array();
    $result = consultar_registro_contacto($id_contact, $row_contacto);
    $respuesta->addAssign("contenedor_llamada","innerHTML",$result);
    $link_crm = crea_link_vtiger($id_contact, $row_contacto["origen"]);
    $respuesta->addAssign("link_crm","innerHTML",$link_crm);
    return $respuesta;
}

/* Funcion que es llamada desde el evento onChange del combo que tiene como opciones los contactos
   que tiene un mismo numero telefonico (Cedulas). Esto se muestra en las llamadas entrantes.
*/
function consultar_registro_contacto($id_contact, &$contacto) {
    global $arrLan;
    $pDB = getDB();
    $sQuery = "
      SELECT cedula_ruc, name, apellido, origen FROM contact where id='$id_contact'";
    $contacto = $pDB->getFirstRowQuery($sQuery, true);

    $data_contact = $arrLan["Error when consulting contact information"];
    if (is_array($contacto) && count($contacto)>0) {
        $smarty = getSmarty(); // Load smarty

        $cedula["label"] = $arrLan["Number Identification"];
        $cedula["value"] = $contacto["cedula_ruc"];

        $name["label"] = $arrLan["Name"];
        $name["value"] = $contacto["name"];

        $apellido["label"] = $arrLan["Last Name"];
        $apellido["value"] = $contacto["apellido"];

        $smarty->assign("INFORMATION_CONTACT",$arrLan["Contact Basic Information"]);
        $smarty->assign("CEDULA",$cedula);
        $smarty->assign("NAME",$name);
        $smarty->assign("APELLIDO",$apellido);
        $data_contact = $smarty->fetch("file:/var/www/html/modules/agent_console/themes/default/data_contact.tpl");
    }
    return ($data_contact);
}

/* FUNCIONES QUE NO SON EJECUTADAS DESDE AJAX */
/* ------------------------------------------ */


/* Funcion que retorna todos los breaks que puede tomar un agente
   Esta funcion se basa en la funcion getBreaks del modulo Breaks.class.php
*/
function obtener_break()
{
    $pDB = getDB();
    $oBreak = new PaloSantoBreaks($pDB);
    $arrBreaks = $oBreak->getBreaks(null,'A');
    if (is_array($arrBreaks) && count($arrBreaks)>0){
        foreach($arrBreaks as $id => $break){
            $allBreak[$break['id']] = $break['name'];  
        }
        return $allBreak;
    }
    else 
        return array();
}

/*
    Funcion que retorna el nombre del break que tiene una auditoria dada
    Es usada al momento de actualizar la fecha y hora fin de la auditoria
*/
function obtener_break_audit($pDB,$id_audit){
    $sQuery = " SELECT be.name 
                FROM 
                    audit au
                        inner join 
                    break be on au.id_break = be.id
                WHERE 
                    au.id = $id_audit;";

    $result = $pDB->getFirstRowQuery($sQuery, true);
    if (is_array($result) && count($result)>0){
        return $result['name']; 
    } else {
        return "";
    }
}

/* Funcion que inserta una nueva auditoria del break que tomo el agente
   se guarda la fecha actual y la hora exacta con segundos que ela gente tomo el break 
   Retorna el id de la auditoria recien ingresada y la funxion pausar_llamadas la guarda en la session 
   en la variable de session elastix_agent_audit*/
function auditoria_break_insert($id_break,$num_agent,$ext_parqueo=NULL)
{ 
    global $arrLang;
    global $arrLan;
    $pDB = getDB();
    $smarty = getSmarty(); // Load smarty 
    $informacion_agent = obtener_informacion_agente($pDB,$num_agent);
    if($informacion_agent != null && is_array($informacion_agent) && count($informacion_agent) >0){
        if (is_null($ext_parqueo)) {
            $sPeticionSQL = "INSERT INTO audit (id_agent,id_break,datetime_init,datetime_end,duration,ext_parked) VALUES(".$informacion_agent['id'].",".$id_break.",\"".date("Y-m-d H:i:s")."\","."null,null,null)";
        } else {
            $fecha_actual = date("Y-m-d G:i:s");
            $sPeticionSQL = "INSERT INTO audit (id_agent,id_break,datetime_init,datetime_end,duration,ext_parked) VALUES(".$informacion_agent['id'].",".$id_break.",\"".$fecha_actual."\","."null,null,".$ext_parqueo.")";
        }
        $result = $pDB->genQuery($sPeticionSQL);
        if($result){
            $id_audit = $pDB->getFirstRowQuery("select last_insert_id() id_audit", true); //retorn el id recien insertado de la auditoria para actualizar las fechas de fin despues
            if($id_audit){
                //return $id_audit;
                return $id_audit['id_audit']; 
            }
            else {
                $smarty->assign("mb_title", $arrLan["Audit Error"]);
                $smarty->assign("mb_message", $arrLan['Number of audit nonassigned']);
                return null;
            }
        }
        else{
            $smarty->assign("mb_title", $arrLan["Audit Error"]);
            $smarty->assign("mb_message", $arrLan['Audit of break could not be inserted']);
            return null; 
        }
    }
    else{
        $smarty->assign("mb_title", $arrLan["Agent Error"]);
        $smarty->assign("mb_message", $arrLan['Id of the agent could not be obtained']);
        return null;
    }
}

/* Funcion que actualiza la auditoria que se pasa para poner la 
   fecha y hora del break que termino de tomar el agente
   El id de la auditoria esta guardada en al session con elastix_agent_audit 
   si todo esta bien se le asigna nulo aesta variable 
   Esto lo realiza la funcion pausar_llamadas */
function auditoria_break_update($id_audit)
{
    $pDB = getDB();
    $now = date("Y-m-d G:i:s");
    $sPeticionSQL = "UPDATE audit SET datetime_end='".$now."', duration=timediff('".$now."',datetime_init) WHERE id = $id_audit";
    $result = $pDB->genQuery($sPeticionSQL);
    if($result)
        return true;
    else
        return false; 
}
/* Funcion que se encarga de obtener el tiempo consumido de un break dado
   en la tabla auditoria */
function obtener_tiempo_acumulado_break($fecha,$agentenum,$id_break)
{
    global $arrLang;
    $pDB = getDB();
    $smarty = getSmarty(); // Load smarty 

    //PASO 1 OBTENGO INFORMACION DEL AGENTE ESPECIALMENTE SU ID
    $informacion_agent = obtener_informacion_agente($pDB,$agentenum); 
    if($informacion_agent != null && is_array($informacion_agent) && count($informacion_agent) >0){

        $sQuery = " /*OBTENEMOS EL TIEMPO TOTAL DEL BREAL SUMANDO EL TIEMPO ACUMULADO DEL MISMO 
                      BREAK EN SUCESOS ANTERIORES DEL MISMO DIA + EL TIEMPO QUE TRANSCURRE DEL 
                      BREAK QUE TOMO RECIEN*/
                    select 
                        SEC_TO_TIME(ifnull(t.acumulado,0) + t.transcurso) tiempoBreak
                    from
                        /*PASO 2 OBTENGO LA SUMA ACUMULADA DE UN BREAK ESPECIFICO DE UN DIA*/
                        (select 
                            sum(TIME_TO_SEC(a.duration)) acumulado, 
                            /*PASO 3 OBTENGO LA AUDIT RECIEN REGISTRADA ESTO SE USA CUANDO REFRESCA EL AGENTE EL
                            NAVEGADOR ENTONCES SE TIENE QUE AÑADIR EL TIEMPO TRANSCURRIDO YA QUE AL REFRESCAR SE 
                            PIERDE EL TIEMPO TRANSCURRIDO DESDE QUE TOMO EL BREAK*/
                            (select
                                TIME_TO_SEC(timediff(now(),au.datetime_init)) 
                            from 
                                audit au
                            where 
                                au.id = ".$_SESSION['elastix_agent_audit'].") transcurso
                        from 
                            audit a 
                        where 
                            a.id_agent = ".$informacion_agent['id']." and 
                            a.id_break= ".$id_break." and 
                            a.datetime_init like concat('%','".$fecha."','%') /*and
                            a.duration is not null */
                        group by 
                            a.id_break,
                            a.id_agent
                        ) t";

        $result = $pDB->getFirstRowQuery($sQuery, true);
        //$result = $pDB->fetchTable($sQuery,true);
        if ($result!=null && is_array($result) && count($result)>0){
                $time  = explode(":",$result['tiempoBreak']);
                return $time;
        }
        else 
            return false;
    }
}

/* Funcion que obtiene el id del agente que se pasa, se pasa el numero del agente
   y retorna el id del agente */
function obtener_informacion_agente($pDB,$num_agente)
{
    global $arrLang;
    $sql = "SELECT id, number, name, password FROM agent WHERE number = '$num_agente' AND estatus = 'A'";
    //$smarty = getSmarty(); // Load smarty 

    $result = $pDB->getFirstRowQuery($sql, true); 
    if(is_array($result) && count($result)>0)
        return $result; 
    else {
        return null;
    }
}
function existe_registro($pDB, $id_calls, $id_form_field) {
    $sQuery = "SELECT id FROM form_data_recolected WHERE id_calls=$id_calls AND id_form_field=$id_form_field";
    $result = $pDB->getFirstRowQuery($sQuery, true);
    //$pDB->disconnect(); 
    if (is_array($result) && count($result)>0)
        return true;
    else 
        return false;
}

/*funcion que trae datos de la campaña que tiene asignada un agente, el cual llega por parametro*/
function getDataCampania($pDB, $agentnum,&$msj) {
    $sQuery = "
    SELECT
      current_calls.id id_current_calls,
      current_calls.ChannelClient,
      campaign.id id_campaign,
      campaign.script script,
      calls.id id_calls,
      calls.phone phone,
      call_attribute.value nombre_cliente,
      timediff(now(),current_calls.fecha_inicio) duracion_llamada
    FROM
      (current_calls,
      calls,
      campaign)
    LEFT JOIN call_attribute
    ON 
      calls.id = call_attribute.id_call
      and call_attribute.column_number = '1'
    WHERE
      current_calls.agentnum='$agentnum'
      and current_calls.event='Link'
      and current_calls.id_call = calls.id
      and calls.id_campaign = campaign.id";
    $result = @$pDB->getFirstRowQuery($sQuery, true);
    if( is_array($result) && count($result)>0 ) {
        return $result;
    }else {
        return false;
    }

}

/* funcion que devuelve datos de una llamada entrante activa en caso de existir,
para esto necesita el objeto de la base y el número del agente */
function getDataIngoingCall($pDB,$agentnum,&$msj) {
    $sQuery = "
    SELECT
      current_call_entry.id id_current_call_entry,
      current_call_entry.id_call_entry,
      current_call_entry.callerid callerid,
      current_call_entry.ChannelClient ChannelClient,
      queue_call_entry.id id_queue_call_entry,
      queue_call_entry.queue,
      queue_call_entry.script,
      call_entry.id_contact,
      call_entry.datetime_init,
      timediff(now(),current_call_entry.datetime_init) duracion_llamada
    FROM
      current_call_entry,
      queue_call_entry,
      call_entry,
      agent
    WHERE
      agent.number = '$agentnum'
      and agent.estatus = 'A'
      and current_call_entry.id_agent=agent.id
      and current_call_entry.id_queue_call_entry = queue_call_entry.id
      and current_call_entry.id_call_entry = call_entry.id";
    $result = @$pDB->getFirstRowQuery($sQuery, true);

    if( is_array($result) && count($result)>0 ) {
        return $result;
    }else {
        return false;
    }
}

/*
  Funcion que es invocada al momento de que entra una nueva llamada y que el callerid existe
  en la base de datos con un solo contacto. También es invocada cuando se presiona el boton confirmar,
  al momento que hay una llamada y se encuentran varios contactos.
  El objetivo de esta funcion es grabar en la tabla call_entry el id del contacto que realmente llamó. 
*/
function confirmar_contacto($id_call, $id_contact, & $msj) {
    global $arrLan;
    $pDB = getDB();
    if (is_numeric($id_call) && is_numeric($id_contact)) {
        $sPeticionSQL = "update call_entry set id_contact=$id_contact where id=$id_call";
        $result = $pDB->genQuery($sPeticionSQL);
        if($result) 
            return true;
        else {
            $msj = $arrLan["Error when updating call information"]."<br>".$pDB->errMsg;
        }
    } else {
        $msj = $arrLan["Error when updating call information"]."<br>Error: ".$arrLan["Id call or Id contact have format invalid"];
    }
    return false;
}

/* FUNCION AJAX
   funcion que es llamada para grabar en la tabla call_entry el id del contacto que realmente llamó.
*/
function confirmar_cedula_contacto($id_call, $id_contact) {
    $respuesta = new xajaxResponse();
    $msj="";
    confirmar_contacto($id_call, $id_contact, $msj);
    $respuesta->addAssign("mensajes_informacion","innerHTML",$msj);
    return $respuesta;
}

function getContactos($pDB,$phone) {
    $sQuery = "
      SELECT id, cedula_ruc, name, apellido, origen FROM contact WHERE telefono='$phone'";
    $result = $pDB->fetchTable($sQuery, true);
    return ($result);
}

function getAttributesCall($pDB, $id_call) {
    $sQuery = "SELECT columna, value FROM call_attribute where id_call=$id_call";
    $arr_atributos = $pDB->fetchTable($sQuery, true);
    //$pDB->disconnect();
    return $arr_atributos;
}

/* Funcion que trae el script de una campaña activa */
function getScriptCampaniaActiva($pDB) {
    $sQuery = "SELECT script FROM campaign where estatus='A'";
    $result = $pDB->getFirstRowQuery($sQuery, true);
    if (is_array($result) && count($result)>0) {
        return $result["script"];
    }
    return false;
}


/* Funcion que hace que el agente se deslogonee */
function disconnet_agent() {
    global $arrLang;
    global $arrLan;

    // datos para la conexión al asterisk
    $ip_asterisk = $_SESSION["ip_asterisk"];
    $user_asterisk = $_SESSION["user_asterisk"];
    $pass_asterisk = $_SESSION["pass_asterisk"];

    $agentnum = $_SESSION['elastix_agent_user'];
    $datetime_end = date("Y-m-d H:i:s");
    $msj = "";
    $resultado = 'ok';
    save_log_prueba("Conectando en disconnet_agent");
    // Conexión con el Asterisk
    $astman = new AGI_AsteriskManager();
    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
        save_log_prueba("Error al conectar en disconnet_agent");
        $resultado = $arrLan["Error when connecting to Asterisk Manager"];
    } else { 
        if(estaAgenteEnPausa($astman, $agentnum)){
            //$salida = $astman->QueuePause(null,"Agent/$agentnum","false");
            $salida = QueuePause($astman, null,"Agent/$agentnum","false");
            if($salida['Response']=='Error')
                $resultado = $arrLan['Unable to pause Agent to queue: No such queue'];
            if(!auditoria_break_update($_SESSION['elastix_agent_audit']))
                $resultado = $arrLan["Audit Error"].": ".$arrLan['Audit of break could not be inserted'];
            $_SESSION['elastix_agent_audit'] = null;
            $_SESSION['elastix_agent_break'] = null;
        }
        //$arr_resultado = $astman->Agentlogoff($agentnum);
        $arr_resultado = Agentlogoff($astman, $agentnum);
        if( !registrarLogout($agentnum,$datetime_end,$msj) ) {;
            $respuesta = $msj;
        }
        $resultado = $arr_resultado["Response"]." - ".$arr_resultado["Message"];
        save_log_prueba("Desconecta en disconnet_agent\n");
        $astman->disconnect();
    }
    return $resultado;
}

/* Funcion que retorna un array con las extensiones creadas en el asterisk */
function getExtensions($arrConf) {
    $pDBa = getDBAsterisk($arrConf);

    $sQuery="select extension,
            (select count(*) from iax where iax.id=users.extension) as iax,
            (select count(*) from sip where sip.id=users.extension) as sip
            from users order by extension"; 
    $arrData = array();
    if (!$arrayResult = $pDBa->fetchTable($sQuery,true)){
        $error = $pDBa->errMsg; 
    }else{
	if (is_array($arrayResult) && count($arrayResult)>0) {
	    $arrData["No extension"] = "No extension";
            foreach($arrayResult as $item) {
                //si tiene iax mayor a 0 es IAX
                if ($item["iax"]>0) $device="IAX/";
                if ($item["sip"]>0) $device="SIP/";
                //$arrData[$device.$item["extension"]] = $device.$item["extension"];	
                $arrData[$item["extension"]] = $device.$item["extension"];	
            }
	}
    }
    $pDBa->disconnect();
    return $arrData;
}

// SE LO USABA PARA OBTENER LA EXTENSIÓN SEGÚN LA QUE LE PERTENECE AL USUARIO DEL ELASTIX, PERO ESTÁ DANDO PROBLEMAS

/* Funcion que retorna la extension asignada al usuario que ingreso a al aplicacion elastix */
// function getExtensionActual($username) {
//     $pDB = getDB();
//     $sQuery = "SELECT extension FROM acl_user WHERE name='$username'";
//     $extension = $pDB->getFirstRowQuery($sQuery, true);
//     if (is_array($extension) && count($extension)>0) {
//         return $extension["extension"];
//     }
//     //$pDB->disconnect();
//     return false;
// }

/* funcion que recive el canal (Ej: SIP/405) y devuelve la extensión (Ej: 405) */
function getExtensionChannel($extensions, $id_extension) {
    if (is_array($extensions)) {
        foreach($extensions as $key=>$extension) {
            if (ereg("^[[:alnum:]]*/([[:digit:]]+)$",$extension,$regs)) {
                $ext = $regs[1];
                if ($ext == $id_extension)
                    return $extension;
            }
        }
    }
    return false;
}

/* funcion que retorna true si un agente esta conectado en una extension (estos datos llegan por parametro) */
function estaAgenteConectado($numAgente,$extn, & $mensaje, &$no_queue, $cont_veces=0)
{
    global $arrLang;
    global $arrLan;

    // datos para la conexión al asterisk
    $ip_asterisk = $_SESSION["ip_asterisk"];
    $user_asterisk = $_SESSION["user_asterisk"];
    $pass_asterisk = $_SESSION["pass_asterisk"];
    $hardware = $_SESSION["hardware"];

    $mensaje = "";
    //$hardware = "SIP|IAX|ZAP|H323|OH323";
    //global $tipo_equipos; echo $tipo_equipos;
    $astman = new AGI_AsteriskManager();
    save_log_prueba("Conectando en estaAgenteConectado");
    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
        save_log_prueba("Error al conectar en estaAgenteConectado");
        $mensaje = $arrLan["Error when connecting to Asterisk Manager"];
    } else {
        $strAgentShow = $astman->Command("agent show online");
        save_log_prueba("Desconecta en estaAgenteConectado\n");
        $astman->disconnect();
        if ($strAgentShow["Response"] != "Error") {
            $arrAgentShow = split("\n", $strAgentShow['data']);
            if (is_array($arrAgentShow) && count($arrAgentShow)>0) {
                foreach($arrAgentShow as $line) {
                    if(ereg("^[[:space:]]*([[:digit:]]{2,})", $line, $arrReg1)) {
                        // si la condicion es verdadera, quiere decir que el agente que llego como parametro ya esta conectado
                        if($numAgente == $arrReg1[1]) {
                            ereg("(($hardware)/([[:digit:]]{2,}))", $line, $arrReg2);
                            // si la condicion es verdadera quiere decir que el agente con la extension seleccionada ya esta conectado
                            if($extn == $arrReg2[1]) {
                                return true;
                            } else {
                                $mensaje = $arrLan["Number Agent already connected with extension"]." $extn";
                                return false;
                            }
                        }
                    }
                }
                $no_queue = true;
                //$mensaje = $arrLan["Agent isn't in Queue Asterisk"]."\n".$strAgentShow['data'];
                $mensaje = "";
            } else {
                $mensaje = $arrLan["Error when consulting Agent in Asterisk Manager"];
            }
        } else {
            $mensaje = $strAgentShow["Message"];
        }
    }
    return false;
}


/* funcion que retorna true si un agente esta en pause en la cola */
function estaAgenteEnPausa($astman, $numAgente) {
    global $arrLang;
    global $arrLan;

    $desconectar = false;
    if (!is_object($astman)) {
        // datos para la conexión al asterisk
        $ip_asterisk = $_SESSION["ip_asterisk"];
        $user_asterisk = $_SESSION["user_asterisk"];
        $pass_asterisk = $_SESSION["pass_asterisk"];

        save_log_prueba("Conectando en estaAgenteEnPausa");
        $desconectar = true;
        $astman = new AGI_AsteriskManager();	
        if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
            save_log_prueba("Error al conectar en estaAgenteEnPausa");
            $resultado = $arrLan["Error when connecting to Asterisk Manager"];
            return false;
        }
    } 

    $strAgentShow = $astman->Command("queue show");
    if ($desconectar) {
        save_log_prueba("Desconecta en estaAgenteEnPausa\n");
        $astman->disconnect();
    }
    $arrAgentShow=array();
    if (is_array($strAgentShow))
        $arrAgentShow = split("\n", $strAgentShow['data']);

    foreach($arrAgentShow as $line) {
        if(ereg("[[:alnum:]]*/([[:digit:]]{2,})", $line, $arrReg1)) {
            // is la condicion es verdadera, quiere decir que el agente que llego como parametro ya esta conectado
            if($numAgente == $arrReg1[1]) {
                if(strpos($line,"(paused)") === false)//busco si tiene estado de pausa
                    return false;
                else return true;
            }
        }
    }

    return false;
}


function crea_objeto(&$smarty, $field, $prefijo_objeto, &$funcion_js) {
    $tipo_objeto = $field["tipo"];
    $input="";
    switch ($tipo_objeto) {
        case "LIST":
            $listado = explode(",",$field["value_field"]);
            $input = "";
            $selected="";
            foreach($listado as $key=>$item) {
                if ($field["value_data"] == $item) $selected = "selected";
                else $selected="";
                $input .= "<option $selected value='$item'>$item</option>";
            }
            if ($input!="") {
                $input = "<select name='$prefijo_objeto"."$field[id_field]' id='$prefijo_objeto"."$field[id_field]' class='SELECT'>$input</select>";
            }
        break;
        case "DATE":
            $input = '<input style="width: 10em; color: #840; background-color: #fafafa; border: 1px solid #999999; text-align: center" name="'.$prefijo_objeto.$field["id_field"].'" value="" id="'.$prefijo_objeto.$field["id_field"].'" type="text" />
            <a href="#" id="calendar_'.$prefijo_objeto.$field["id_field"].'">
            <img align="middle" border="0" src="/libs/js/jscalendar/img.gif" alt="" />
            </a>';

            $funcion_js = 'Calendar.setup({"ifFormat":"%d %b %Y","daFormat":"%Y/%m/%d","firstDay":1,"showsTime":true,"showOthers":true,"timeFormat":12,"inputField":"'.$prefijo_objeto.$field['id_field'].'","button":"calendar_'.$prefijo_objeto.$field['id_field'].'"});';

        break;
        case "TEXTAREA":
            $input = "<textarea name='$prefijo_objeto"."$field[id_field]' id='$prefijo_objeto"."$field[id_field]' rows='3' cols='50'>$field[value_data]</textarea>";
        break;
        case "LABEL":
            $input = "<label class='style_label'>$field[etiqueta]</label>";
        break;
        default:
            $input = "<input type='text' name='$prefijo_objeto"."$field[id_field]' id='$prefijo_objeto"."$field[id_field]' value='$field[value_data]' class='INPUT'>";
    }
    return $input;
}


function obtener_formularios($pDB,$id_campania)
{
    $sQuery = " SELECT f.id, f.nombre 
                FROM 
                    campaign_form cf 
                        inner join 
                    form f on cf.id_form = f.id
                WHERE cf.id_campaign=$id_campania";
    $result = $pDB->fetchTable($sQuery, true);
    //$pDB->disconnect();
    if (is_array($result) && count($result)>0)
        return $result;
    else 
        return false;
}


function obtener_primer_formulario($arr_values)
{
    if(is_array($arr_values) && count($arr_values)>0){
        foreach($arr_values as $key => $value){
            return $value['id'];
        }
    }
    return 0;
}

function smarty_option($arr_values,$selected)
{
    $options = array();
    if(is_array($arr_values) && count($arr_values)>0){
        foreach($arr_values as $key => $value){
            $options['VALUE'][] =  $value['id'];
            $options['NAME'][] = $value['nombre'];
            if($selected == $value['id'])
                $options['SELECTED'] = $value['id'];
        }
    }
    return $options;
}


/* Otras funciones */

function getSmarty() {
    global $arrConf;
    $smarty = new Smarty();
    $smarty->template_dir = "themes/default/";
    $smarty->compile_dir =  "var/templates_c/";
    $smarty->config_dir =   "configs/";
    $smarty->cache_dir =    "var/cache/";
    return $smarty;
}
function getDB() {
    global $arrConf;
    $pDB = new paloDB($arrConf["cadena_dsn"]);
    return $pDB;
}
function getDB1() {
    global $arrConf;
    $pDB = new paloDB($arrConf["cadena_dsn"]."d");
    return $pDB;
}
function getDBAsterisk($arrConfig) {
    $dsn = $arrConfig['AMPDBENGINE']['valor'] . "://" . $arrConfig['AMPDBUSER']['valor'] . ":" . $arrConfig['AMPDBPASS']['valor'] . "@" . $arrConfig['AMPDBHOST']['valor'] . "/asterisk";
    $pDBa     = new paloDB($dsn);
    return $pDBa;
}


/* ----------------------------------------- */
/*                                           */
/* FIN FUNCIONES DE TRANFERENCIA DE LLAMADAS */
/*                                           */
/* ----------------------------------------- */

/*
    Esta funcion devuelve el canal por el cual se esta recibiendo la llamada.
*/
function getChannelClient($agentNum,$tipo,&$msj) {
    global $arrConf;

    $pDB = new paloDB($arrConf['cadena_dsn']);

    $arrValor = array();
    if (!is_object($pDB->conn) || $pDB->errMsg!="") {
        $msj = $arrLan["Error when connecting to Call Center"];
        return false;
    }

    if($tipo=="ENTRANTE") {
        $SQLConsultaChannelClient = "
        select
            a.id,
            cce.ChannelClient as channel
        from
            agent as a,
            current_call_entry as cce
        where
            cce.id_agent=a.id
            and a.estatus='A'
            and a.number=".$agentNum;

        //$resConsulta = $pDB->getFirstRowQuery($SQLConsultaChannelClient,true);
        $resConsulta = $pDB->fetchTable($SQLConsultaChannelClient,true);

        // si no hubo error en la consulta del queue
        if(!$resConsulta) {
            $msj = $arrLan["Error query"]." ".$pDB->errMsg;
        } elseif( is_array($resConsulta[0]) && count($resConsulta[0]) > 0 ) {
            return $resConsulta[0]['channel'];
        }
    } elseif ($tipo=="SALIENTE") {

        $SQLConsultaChannelClient = "select ChannelClient as channel from current_calls where agentnum='$agentNum'";

        //$resConsulta = $pDB->getFirstRowQuery($SQLConsultaChannelClient,true);
        $resConsulta = $pDB->fetchtable($SQLConsultaChannelClient,true);

        // si no hubo error en la consulta del queue
        if( !$resConsulta ) {
            $msj = $arrLan["Error query"]." ".$pDB->errMsg;
        } elseif( is_array($resConsulta[0]) && count($resConsulta[0]) > 0 ) {
            return $resConsulta[0]['channel'];
        }
    }

    $msj = $arrLan["No call"]." ".$pDB->errMsg;
    return false;
}

/*
    Esta funcion devuelve una tupla que contiene el tipo de llamada y el id respectivo del
    tipo de llamada
*/
function getTipoLlamada($pDB,&$msj) {

    global $arrLan;
    $agentNum = $_SESSION['elastix_agent_user'];

    // se hace consulta para saber si hay llamadas entrantes para el agente que esta en $agentNum
    $SQLConsultaEntrante = "select cce.id_call_entry as id from agent as a,current_call_entry as cce where cce.id_agent=a.id and a.estatus='A' and a.number='$agentNum'";

    //$resConsultaEntrante = $pDB->getFirstRowQuery($SQLConsultaEntrante,true); //revisar esta funcion
    $resConsultaEntrante = $pDB->fetchTable($SQLConsultaEntrante,true);
    // si hay llamadas entrantes ingresa al if

    if(is_array( $resConsultaEntrante ) && count( $resConsultaEntrante )>0) {
        $tipo = "ENTRANTE";
        $id = $resConsultaEntrante[0]['id'];
        $arrValor = array( "tipo"=>$tipo ,"id"=>$id );
        return $arrValor;
    }

    // se hace consulta para saber si hay llamadas salientes para el agente que esta en $agentNum
    $SQLConsultaSaliente = "select id_call as id from current_calls  where agentnum='$agentNum'";
    //$resConsultaSaliente = $pDB->getFirstRowQuery($SQLConsultaSaliente,true); //revisar esta funcion
    $resConsultaSaliente = $pDB->fetchTable($SQLConsultaSaliente,true);
    // si hay llamadas salientes ingresa al if
    if(is_array($resConsultaSaliente) && count($resConsultaSaliente)>0)  {
        $tipo = "SALIENTE";
        $id = $resConsultaSaliente[0]['id'];
        $arrValor = array( "tipo"=>$tipo ,"id"=>$id );
        return $arrValor;
    }

    $msj = $arrLan["No call"];
    return false;
}


/*
    Esta funcion se encarga de actualizar as tablas calls, y call_entry dependiendo si la llamada es
    entrante o saliente.
*/

function actualizarTablasLlamada($pDB,$extension,$tipo,$id,&$msj) {
    global $arrConf;

    if($tipo=="ENTRANTE") {

        $SQLUpdate = paloDB::construirUpdate(
            "call_entry", array(
                    "transfer"  => paloDB::DBCAMPO($extension),
                ),"id=$id"
            );

        $resSQLUpdate = $pDB->genQuery($SQLUpdate);
        if(!$resSQLUpdate) {
            $msj = $pDB->errMsg;
        }else {
            return true;
        }
    }

    if($tipo=="SALIENTE") {

        $SQLUpdate = paloDB::construirUpdate(
            "calls", array(
                "transfer"  => paloDB::DBCAMPO($extension),
                ),"id=$id"
            );

        $resSQLUpdate = $pDB->genQuery($SQLUpdate);
        if(!$resSQLUpdate) {
            $msj = $pDB->errMsg;
        }else {
            return true;
        }
    }
    $msj = $arrLan["No call"];
    return false;

}

/*
    Esta funcion se encarga de transferir una llamada a una extension determinada
    por el parametro $id_extension.
*/

function transferirLlamadaCiega($id_extension) {
    global $arrLan;
    global $arrConf;
    $respuesta = new xajaxResponse();
    $agentNum = $_SESSION['elastix_agent_user'];

    $resultado= "";
    $pDB = new paloDB($arrConf['cadena_dsn']);
    if (!is_object($pDB->conn) || $pDB->errMsg!="") {
        $resultado = $arrLan["Error when connecting to Call Center"];
    }else {
        // la funcion devuelve en el arreglo el tipo de la llamada (ENTRANTE/SALIENTE) y el id de la llamada
        $arrValor = getTipoLlamada($pDB,$resultado);

        if($arrValor) {
            // obtengo el tipo de llamada y el id de lallamada
            $tipo = $arrValor['tipo'];
            $id_call = $arrValor['id'];
            // obtengo la extension de la llamada, sino hay una extension seleccionada se alamcena el valor 
            $cadenaExt = explode('/',$id_extension);
            if(count($cadenaExt)>1){
                $extension = $cadenaExt[1];
            }else{
                $extension=$id_extension;
            }

            $channel = getChannelClient($agentNum,$tipo,$resultado);
            if ($channel) {
                if($id_extension=="No extension"){
                    $resultado = $arrLan["select extension"];
                } else {
                    // datos para la conexión al asterisk
                    $ip_asterisk = $_SESSION["ip_asterisk"];
                    $user_asterisk = $_SESSION["user_asterisk"];
                    $pass_asterisk = $_SESSION["pass_asterisk"];

                    $astman = new AGI_AsteriskManager();
                    save_log_prueba("Conectando en transferirLlamadaCiega");
                    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
                        save_log_prueba("Error al conectar en transferirLlamadaCiega");
                        $resultado = $arrLan["Error when connecting to Asterisk Manager"];
                    }else {
                        $res = $astman->Redirect($channel, "", $extension, "from-internal", "1");
                        if ($res['Response']=='Error') {
                            $resultado = $arrLan["transfer_error"]." ".$res['Message'];
                        }else {
                            $resUpdate = actualizarTablasLlamada($pDB,$extension,$tipo,$id_call,$msj);
                            if(!$resUpdate){
                                $resultado = $msj;
                            }else{
                                $resultado = $arrLan["Success"];
                            }
                        }
                        save_log_prueba("Desconecta en transferirLlamadaCiega\n");
                        $astman->disconnect();
                    }
                }
            }
        }
    }
    if ($resultado!="") {
        $respuesta->addAssign("mensajes_informacion","innerHTML",$resultado);
    }
    return $respuesta;
}


/*
    Esta funcion recibe un arreglo que contiene las los valores a ser mostrados en una etiqueta
    html select y devuelve una cadena que debera ser insertada entre los tag <select> y </select>
    para asi formar un control SELECT.
*/

function crearSelect($arrOp) {
    $cadenaOp = "";

    global $arrLan;
    if(!is_array($arrOp)) {
        return false;
    }elseif( count($arrOp)==0 ) {
        $cadenaOp .= "<option value='-1'>No hay extensiones disponibles</option>";
    }else {
        foreach($arrOp as $key=>$value) {
             if ($key=="No extension") {
                $cadenaOp .= "\n<option value='$value' >{$arrLan["select extension"]}</option>";
            }else {
                $cadenaOp .= "\n<option value='$value' >$key</option>";
            }
        }
//         $cadenaOp .= "\n<option value='70/70' >70</option>";
//         $cadenaOp .= "\n<option value='71/71' >71</option>";
    }
     return $cadenaOp;
}

// Funcion que convierte las extensiones en extensiones válidadas para hacer el marcado.
// Un ejmplo de esto es las extenciones que tienen un formato IAX/502 se la convierte a IAX2/502 
function convertir_extensiones_validas($extensions) {
    if (is_array($extensions)) {
        $reemplazos= array(
                            "IAX"=>"IAX2",
                         );
        foreach($extensions as $key=>$extension) {
            if (!is_null($key) && !is_null($extension)) {
                foreach($reemplazos as $original=>$reemplazo) {
                    if (ereg("^$original/([[:digit:]]+)$",$extension,$regs)) {
                        $extensions[$key] = $reemplazo."/".$regs[1];
                    }
                }
            }
        }
    }
    return $extensions;
}


/*
    Esta funcion implementa la funcion DTFM del Asterisk
*/
function marcarLlamada($number) {
    global $arrLan;
    global $arrConf;
    $msj = "";
    $resultado = "";
    $respuesta = new xajaxResponse();
    $pDB = new paloDB($arrConf['cadena_dsn']);

    if (!is_object($pDB->conn) || $pDB->errMsg!="") {
        $resultado = $arrLan["Error when connecting to Call Center"];
    } else {
        // datos para la conexión al asterisk
        $ip_asterisk = $_SESSION["ip_asterisk"];
        $user_asterisk = $_SESSION["user_asterisk"];
        $pass_asterisk = $_SESSION["pass_asterisk"];
 
        if( !empty($number) && $number!="" && !is_null($number)  ) {// && is_numeric($number) ) {
            $agentNum = $_SESSION['elastix_agent_user'];
            $arrValor = getTipoLlamada($pDB,$msj);

            if( is_array($arrValor) && count($arrValor)>0 ) {

                $tipo = $arrValor['tipo'];
                $channel = getChannelClient($agentNum,$tipo,$msj);
                if($channel) {
                    $astman = new AGI_AsteriskManager();
                    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
                        $resultado .= $arrLan["Error when connecting to Asterisk Manager"];
                    }else {
                        $res = $astman->PlayDTMF($channel,$number);
                        if ($res['Response']=='Error') {
                            $resultado .= $arrLan["Marked Error"]." ".$res['Message'];
                        }else {
                            $resultado .= $arrLan["Success Marked"];
                        }
                        $astman->disconnect();
                    }
                } else {
                    $resultado .= $msj;
                }
            } else {
                $astman = new AGI_AsteriskManager();
		if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
		    $resultado .= $arrLan["Error when connecting to Asterisk Manager"];
		}else {
/**************************Originar Llamadas******************************************************/
		    $res = $astman->Originate("ZAP/1/$number","8000","from-internal","1",NULL, NULL, NULL, NULL, NULL, NULL, TRUE, NULL);

                    if ($res['Response']=='Error') {
			$resultado .= $arrLan["Marked Error"]." ".$res['Message'];
		    }else {
			$resultado .= $arrLan["Success Marked"];
		    }
		    $astman->disconnect();
                }
/************************************************************************************************/
                $resultado .= $msj;
            }
        } else {
            $resultado .= $arrLan["Please enter a number to mark"];
        }

    }
    if ($resultado!="") {
        $respuesta->addAssign("mensajes_informacion","innerHTML",$resultado);//."-->".$channel.$number);
    }
    return $respuesta;
}

function sacar_hold(){
        //global $arrLang;
        //global $arrLan;

        $respuesta = new xajaxResponse();

        $pDB = getDB();

        $agentnum = $_SESSION['elastix_agent_user'];
        $member = "Agent/$agentnum";

        $aa="";

        $ext_parqueo = get_extension_parqueo(null,$channel);

        if ($ext_parqueo) {

            $msj = tomar_llamada_parqueo($ext_parqueo);

        }
	$respuesta->addAlert("en hold");
        return $respuesta;
    }

/* ----------------------------------------- */
/*                                           */
/* FIN FUNCIONES DE TRANFERENCIA DE LLAMADAS */
/*                                           */
/* ----------------------------------------- */


/* FUNCIONES DEL AGI*/
    /**
    * Agent Logoff
    *
    * @link http://www.voip-info.org/wiki/index.php?page=Asterisk+Manager+API+AgentLogoff
    * @param Agent: Agent ID of the agent to login 
    */
    function Agentlogoff($obj_phpAgi, $agent)
    {
      return $obj_phpAgi->send_request('Agentlogoff', array('Agent'=>$agent));
    }

   /**
    * Queue Pause
    *
    * @link http://www.voip-info.org/wiki/index.php?page=Asterisk+Manager+API+Action+QueuePause
    * @param string $queue
    * @param string $interface
    * @param bool   $paused
    */
    function QueuePause($obj_phpAgi, $queue, $interface, $paused=false)
    {
      $parameters = array('Queue'=>$queue, 'Interface'=>$interface);
      if($paused) $parameters['Paused'] = $paused;
      return $obj_phpAgi->send_request('QueuePause', $parameters);
    } 


/* ---------------------------------------- */
/* FUNCIONES QUE ACTUALMENTE NO SE UTILIZAN */
/* ---------------------------------------- */

/*  FUNCION XAJAX:
    funcion que encola al agente a una cola en donde este no se encuentre 
*/
function encolar_agente($agente,$cola)
{
    // datos para la conexión al asterisk
    $ip_asterisk = $_SESSION["ip_asterisk"];
    $user_asterisk = $_SESSION["user_asterisk"];
    $pass_asterisk = $_SESSION["pass_asterisk"];

    $member = "Agent/$agente";
    global $arrLang;
    global $arrLan;
    save_log_prueba("Conectando en encolar_agente");
    $astman = new AGI_AsteriskManager( );	

    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
    save_log_prueba("Error al conectar en encolar_agente");
        $resultado = $arrLan["Error when connecting to Asterisk Manager"];
    } else { 
        if(!estaAgenteEnCola($agente,$cola))
        {
            $salida = $astman->QueueAdd($cola,$member);
            if($salida['Response']=='Error')
                return $arrLan['Unable to add Agent to queue: No such queue'];
            else return 'se_encolo';
        }
        else{
            return 'ya_encolado';
        }
        $astman->disconnect();
        save_log_prueba("Desconecta en encolar_agente\n");
    }
    return false;
}


/* funcion que retorna true si un agente esta agregado a la cola */
function estaAgenteEnCola($numAgente,$cola) {
    global $arrLang;
    global $arrLan;

    // datos para la conexión al asterisk
    $ip_asterisk = $_SESSION["ip_asterisk"];
    $user_asterisk = $_SESSION["user_asterisk"];
    $pass_asterisk = $_SESSION["pass_asterisk"];

    save_log_prueba("Conectando en estaAgenteEnCola");
    $astman = new AGI_AsteriskManager();	
    if (!$astman->connect($ip_asterisk, $user_asterisk, $pass_asterisk)) {
    save_log_prueba("Error al conectar en estaAgenteEnCola");
        $resultado = $arrLan["Error when connecting to Asterisk Manager"];
    } else {
        $strAgentShow = $astman->Command(" queue show $cola");
        save_log_prueba("Desconecta en estaAgenteEnCola\n");
        $astman->disconnect();
        $arrAgentShow=array();
        if (is_array($strAgentShow))
            $arrAgentShow = split("\n", $strAgentShow['data']);

        foreach($arrAgentShow as $line) {
            if(ereg("[[:alnum:]]*/([[:digit:]]{2,})", $line, $arrReg1)) {
                // is la condicion es verdadera, quiere decir que el agente que llego como parametro ya esta conectado
                if($numAgente == $arrReg1[1]) {
                    return true;
                }
            }
        }
    }
    return false;
}

function crea_combo($arreglo_valores, $selected) {
    $cadena = '';
    if(!is_array($arreglo_valores) or empty($arreglo_valores)) return '';

    foreach($arreglo_valores as $key => $value) if ($selected == $key)
        $cadena .= "<option value='$key' selected>$value</option>\n"; else $cadena .= "<option value='$key'>$value</option>\n";
    return $cadena;
}

// crea un link a partir de la url y el label que se le envia por parametro
function crea_link_vtiger($id_contact,$origen) {
    global $arrLan;
    if($id_contact != "" && strtoupper($origen)=="CRM") {
        $crm_label = $arrLan["View Client"];
        $crm_url = "/vtigercrm/index.php?action=DetailView&module=Leads&record=$id_contact&parenttab=Sales";
    } else {
        $crm_label = $arrLan["Add Client"];
        $crm_url = "/vtigercrm/index.php?module=Leads&action=EditView&return_action=DetailView&parenttab=Sales";
    }
    $link_crm = "<a href='javascript:window_open($crm_url,\"vtiger\");' class='normal'>$crm_label</a>";
    return $link_crm;
}


function save_log_prueba($texto){
    $LOG=false;
    if ($LOG) {
        $archivo = "/var/www/html/prueba_anita/prueba_conexionAsterisk.log";
        $fp = fopen($archivo, "a");
        if ($fp) {
            $string = "[".date("Y-m-d G:i:s")."] [".$_SESSION['elastix_agent_user']."] ".$texto."\n";
            $write = fputs($fp, $string);
            fclose($fp);
        }
    }
}


function registrarLogin($agentNum,$datetime_init,&$msj) {
    global $arrConf;
    $pDB = new paloDB($arrConf['cadena_dsn']);

    if (!is_object($pDB->conn) || $pDB->errMsg!="") {
        $resultado = $arrLan["Error when connecting to Call Center"];
    } else { 
        $id_agent = getIdAgent($pDB,$agentNum,$msj);
        if(!$id_agent) {
            return false;
        } else {
            $SQLInsertAudit = paloDB::construirInsert(
                "audit",
                array(
                        "id_agent"      =>  paloDB::DBCAMPO($id_agent),
                        "datetime_init" =>  paloDB::DBCAMPO($datetime_init),
                    )
            );

            $resSQLInsertAudit = $pDB->genQuery($SQLInsertAudit);
            if(!$resSQLInsertAudit) {
                $msj .= $pDB->errMsg." ".$resSQLInsertAudit;
                return  false;
            }else {
                return true;
            }
        }
    }
}


function registrarLogout($agentNum,$datetime_end,&$msj) {
    global $arrConf;
    $pDB = new paloDB($arrConf['cadena_dsn']);
    if (!is_object($pDB->conn) || $pDB->errMsg!="") {
        $resultado = $arrLan["Error when connecting to Call Center"];
    } else { 
        $id_audit = getLastIdLoginAgent($pDB,$agentNum,$msj);
        if(!$id_audit) {
            return false;
        } else {
            $SQLUpdateAudit = 
            "
                update audit
                set
                    datetime_end='{$datetime_end}' ,
                    duration=timediff('{$datetime_end}',datetime_init) 
                where id ={$id_audit} 
            ";
            $resQLUpdateAudit = $pDB->genQuery($SQLUpdateAudit);
            if(!$resQLUpdateAudit) {
                $msj .= $pDB->errMsg;
                return false;
            }else {
                return true;
            }
        }
    }
}

function getIdAgent($pDB,$agentNum,&$msj) {

    $SQLConsultaIdAgent = "select id from agent where number='{$agentNum}'";

    $resConsultaIdAgent = $pDB->getFirstRowQuery($SQLConsultaIdAgent,true);
    if(is_array($resConsultaIdAgent) && count($resConsultaIdAgent)>0)  {
        $id = $resConsultaIdAgent['id'];
        return $id;
    } elseif(is_array($resConsultaIdAgent)) {
        $msj .= "No hay informacion disponible";
    }else{
        $msj .= $pDB->errMsg; 
    }
    return false;
}


function getLastIdLoginAgent($pDB,$agentNum,&$msj) {

    $SQLConsultaIdAudit = 
    "
        select au.id as id
        from audit au , agent ag  
        where 
                ag.id=au.id_agent 
                    and 
                id_break is null 
                    and 
                datetime_end is null 
                    and 
                ag.number='{$agentNum}'
    ";

    $resConsultaIdAudit = $pDB->getFirstRowQuery($SQLConsultaIdAudit,true);
    if(is_array($resConsultaIdAudit) && count($resConsultaIdAudit)>0)  {
        $id = $resConsultaIdAudit['id'];
        return $id;
    } elseif(is_array($resConsultaIdAudit)) {
        $msj .= "Agente no ha iniciado sesion";
    }else{
        $msj .= $pDB->errMsg; 
    }
    return false;
}

function yaEstaRegistrado($num_agent,$datetime_init,&$msj) {
    global $arrConf;
    $pDB = new paloDB($arrConf['cadena_dsn']);
    if (!is_object($pDB->conn) || $pDB->errMsg!="") {
        $msj = $arrLan["Error when connecting to Call Center"];
        return false;
    } else { 
        $SQLConsulta = 
        "
            select au.id 
            from audit au, agent ag 
            where 
                    au.id_agent=ag.id and 
                    ag.number = '{$num_agent}' and 
                    datetime_end is null and
                    duration is null and
                    au.id_break is null;
        ";

        $resConsulta = $pDB->fetchTable($SQLConsulta,true);

        if(is_array($resConsulta) && count($resConsulta)>0)  {
            $msj = "devolvio true";
            return true;
        } elseif(!is_array($resConsulta)) {
            $msj = "";
        }else{
            $msj = $pDB->errMsg; 
        }
        return false;
    }
}



?>
