<?php
  /* vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4:
  Codificación: UTF-8
  +----------------------------------------------------------------------+
  | Elastix version 1.2-2                                                |
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
  $Id: default.conf.php,v 1.1 2008-09-03 01:09:56 Alex Villacís Lasso Exp $ */

function _moduleContent(&$smarty, $module_name)
{
    global $arrConfig;

    //include elastix framework
    include_once "libs/paloSantoGrid.class.php";
    include_once "libs/paloSantoForm.class.php";

    //include module files
    include_once "modules/$module_name/libs/paloSantoConfiguration.class.php";
    include_once "modules/$module_name/configs/default.conf.php";

    // incluir el archivo de idioma de acuerdo al que este seleccionado
    // si el archivo de idioma no existe incluir el idioma por defecto
    $lang=get_language();
    $script_dir=dirname($_SERVER['SCRIPT_FILENAME']);
    $lang_file="modules/$module_name/lang/$lang.lang";

    if (file_exists("$script_dir/$lang_file"))
        include_once($lang_file);
    else
        include_once("modules/$module_name/lang/en.lang");

    global $arrConf;
    global $arrLang;
    global $arrLangModule;

    $oDB = new paloDB($arrConfig['cadena_dsn']);

    //folder path for custom templates
    $base_dir=dirname($_SERVER['SCRIPT_FILENAME']);
    $templates_dir=(isset($arrConfig['templates_dir']))?$arrConfig['templates_dir']:'themes';
    $local_templates_dir="$base_dir/modules/$module_name/".$templates_dir.'/'.$arrConf['theme'];

    $accion = getAction();

    $content = "";
    $content .= form_Service($oDB, $smarty, $module_name, $local_templates_dir, array_merge($arrLang, $arrLangModule),$arrConfig['pid_dialer']);
    $content .= form_Configuration($oDB, $smarty, $module_name, $local_templates_dir, array_merge($arrLang, $arrLangModule));

    return $content;
}

function form_Configuration(&$oDB, $smarty, $module_name, $local_templates_dir, $arrLang)
{
    global $arrConfig;

    $arrFormConference = createFieldForm($arrLang);
    $oForm = new paloForm($smarty,$arrFormConference);

    $smarty->assign("SAVE", $arrLang["Save"]);
    $smarty->assign("TITLE", $arrLang["Configuration"]);
    $smarty->assign("REQUIRED_FIELD", $arrLang["Required field"]);
    $smarty->assign("IMG", "images/list.png");

    $objConfig =& new PaloSantoConfiguration($oDB);
    $listaConf = $objConfig->ObtainConfiguration();
    
//    print_r($listaConf);
    $camposConocidos = array(
        'asterisk.asthost' => 'asterisk_asthost',
        'asterisk.astuser' => 'asterisk_astuser',
        'asterisk.astpass' => 'asterisk_astpass_1',
        'asterisk.duracion_sesion' => 'asterisk_duracion_sesion',
        'dialer.llamada_corta' => 'dialer_llamada_corta',
        'dialer.tiempo_contestar' => 'dialer_tiempo_contestar',
        'dialer.debug' => 'dialer_debug',
        'dialer.allevents' => 'dialer_allevents',
        'dialer.overcommit' => 'dialer_overcommit',
        'dialer.qos' => 'dialer_qos',
    );
    $valoresForm = array(
        'asterisk_asthost' => '127.0.0.1',
        'asterisk_astuser' => '',
        'asterisk_astpass_1' => '',
        'asterisk_astpass_2' => '',
        'asterisk_duracion_sesion' => '0',
        'dialer_llamada_corta' => '10',
        'dialer_tiempo_contestar' => '8',
        'dialer_debug' => 'off',
        'dialer_allevents' => 'off',
        'dialer_overcommit' => 'off',
        'dialer_qos' => '0.97',
    );
    foreach ($camposConocidos as $dbfield => $formfield) {
        if (isset($listaConf[$dbfield])) {
            if ($dbfield == 'dialer.debug' || $dbfield == 'dialer.allevents' || $dbfield == 'dialer.overcommit')
            {
                $valoresForm[$formfield] = $listaConf[$dbfield] ? 'on' : 'off';
            } else $valoresForm[$formfield] = $listaConf[$dbfield];
        } else {
        }
    }
    if (count($_POST) > 0) {
        if (!isset($_POST['asterisk_astuser']) || trim($_POST['asterisk_astuser']) == '') {
        	$_POST['asterisk_astuser'] = '';
            $_POST['asterisk_astpass_1'] = '';
            $_POST['asterisk_astpass_2'] = '';
        }
        foreach ($camposConocidos as $dbfield => $formfield) if (isset($_POST[$formfield])) {
            if ($dbfield == 'dialer.debug' || $dbfield == 'dialer.allevents' || $dbfield == 'dialer.overcommit')
            {
               $valoresForm[$formfield] = ($_POST[$formfield] == 'on') ? 'on' : 'off';
            } else $valoresForm[$formfield] = $_POST[$formfield];
        }

        $action = getAction();
        if ($action == 'save') {
            if (!$oForm->validateForm($_POST)) {
                $smarty->assign("mb_title", $arrLang["Validation Error"]);
                $arrErrores=$oForm->arrErroresValidacion;
                $strErrorMsg = "<b>{$arrLang['The following fields contain errors']}:</b><br/>";
                if(is_array($arrErrores) && count($arrErrores) > 0){
                    foreach($arrErrores as $k=>$v) {
                        $strErrorMsg .= "$k, ";
                    }
                }
                $smarty->assign("mb_message", $strErrorMsg);
            } elseif ($_POST['dialer_qos'] < 0 || $_POST['dialer_qos'] >= 100) {
                $smarty->assign("mb_title", $arrLang["Validation Error"]);
                $arrErrores=array('Service Percent' => 'Not in range 1..99');
                $strErrorMsg = "<b>{$arrLang['The following fields contain errors']}:</b><br/>";
                if(is_array($arrErrores) && count($arrErrores) > 0){
                    foreach($arrErrores as $k=>$v) {
                        $strErrorMsg .= "$k, ";
                    }
                }
                $smarty->assign("mb_message", $strErrorMsg);
            } elseif ($_POST['asterisk_astpass_1'] != $_POST['asterisk_astpass_2']) {
                $smarty->assign("mb_title", $arrLang["Validation Error"]);
                $strErrorMsg = $arrLang['Password and confirmation do not match.'];
                $smarty->assign("mb_message", $strErrorMsg);
            } else {
                // Esto asume implementación PDO
                $oDB->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $oDB->conn->beginTransaction();
                $bContinuar = TRUE;
                $strErrorMsg = '';
                $config = array();
                foreach ($camposConocidos as $dbfield => $formfield) {
                    if ($dbfield == 'asterisk.astpass' && $_POST[$formfield] == '') continue;
                    
                    if ($dbfield == 'dialer.debug' || $dbfield == 'dialer.allevents' || $dbfield == 'dialer.overcommit') {
                        $config[$dbfield] = ($_POST[$formfield] == 'on') ? 1 : 0;
                    } else {
                        $config[$dbfield] = $_POST[$formfield];
                    }
                }
                if (!isset($config['asterisk.astuser']) || $config['asterisk.astuser'] == '')
                    $config['asterisk.astpass'] = '';
                $bContinuar = $objConfig->SaveConfiguration($config);
                if (!$bContinuar) {
                    $strErrorMsg = $objConfig->errMsg;
                    $smarty->assign("mb_title", $arrLang['Internal DB error']);
                    $strErrorMsg = $arrLang['Could not save changes!'].' '.$strErrorMsg;
                    $smarty->assign("mb_message", $strErrorMsg);
                }
                if ($bContinuar) {
                    $bContinuar = $oDB->conn->commit();
                    if (!$bContinuar) {
                        $smarty->assign("mb_title", $arrLang['Internal DB error']);
                        $strErrorMsg = $arrLang['Could not commit changes!'];
                        $smarty->assign("mb_message", $strErrorMsg);
                    }
                }
                if (!$bContinuar) $oDB->conn->rollBack();
            }
        }
    }
    unset($valoresForm['asterisk_astpass_1']);
    unset($valoresForm['asterisk_astpass_2']);

    $htmlForm = $oForm->fetchForm("$local_templates_dir/form.tpl", "", $valoresForm);

    $contenidoModulo = "<form  method='POST' style='margin-bottom:0;' action='?menu=$module_name'>".$htmlForm."</form>";

    return $contenidoModulo;
}

function form_Service(&$oDB, $smarty, $module_name, $local_templates_dir, $arrLang, $pd)
{
    global $arrConfig;

    $objConfig = new paloSantoConfiguration($oDB);
    if (isset($_POST['dialer_action'])) {
        $objConfig->setStatusDialer(($_POST['dialer_action'] == $arrLang['Start']) ? 1 : 0);
    }
    $bDialerActivo = $objConfig->getStatusDialer($pd);

    $smarty->assign('DIALER_STATUS_MESG',$arrLang['Dialer Status']);
    $smarty->assign('CURRENT_STATUS',$arrLang['Current Status']);
    $smarty->assign('DIALER_STATUS', $bDialerActivo 
        ? $arrLang['Running'] 
        : $arrLang['Stopped']);
    $smarty->assign('DIALER_ACTION', $bDialerActivo 
        ? $arrLang['Stop'] 
        : $arrLang['Start']);
}

function createFieldForm($arrLang)
{
    return array(
        'asterisk_asthost'  =>      array(
            'LABEL'                     =>  $arrLang['Asterisk Server'],
            'REQUIRED'                  =>  'yes',
            'INPUT_TYPE'                =>  'TEXT',
            'VALIDATION_TYPE'           =>  'text',
            'INPUT_EXTRA_PARAM'         =>  '',
            'VALIDATION_EXTRA_PARAM'    =>  '',
        ),
        'asterisk_astuser'  =>      array(
            'LABEL'                     =>  $arrLang['Asterisk Login'],
            'REQUIRED'                  =>  'no',
            'INPUT_TYPE'                =>  'TEXT',
            'VALIDATION_TYPE'           =>  'text',
            'INPUT_EXTRA_PARAM'         =>  '',
            'VALIDATION_EXTRA_PARAM'    =>  '',
        ),
        'asterisk_astpass_1'  =>      array(
            'LABEL'                     =>  $arrLang['Asterisk Password'],
            'REQUIRED'                  =>  'no',
            'INPUT_TYPE'                =>  'PASSWORD',
            'VALIDATION_TYPE'           =>  'text',
            'INPUT_EXTRA_PARAM'         =>  '',
            'VALIDATION_EXTRA_PARAM'    =>  '',
        ),
        'asterisk_astpass_2'  =>      array(
            'LABEL'                     =>  $arrLang['Asterisk Password (confirm)'],
            'REQUIRED'                  =>  'no',
            'INPUT_TYPE'                =>  'PASSWORD',
            'VALIDATION_TYPE'           =>  'text',
            'INPUT_EXTRA_PARAM'         =>  '',
            'VALIDATION_EXTRA_PARAM'    =>  '',
        ),
        'asterisk_duracion_sesion'  =>  array(
            'LABEL'                     =>  $arrLang['AMI Session Duration'],
            'REQUIRED'                  =>  'yes',
            'INPUT_TYPE'                =>  'TEXT',
            'VALIDATION_TYPE'           =>  'numeric',
            'INPUT_EXTRA_PARAM'         =>  '',
            //'VALIDATION_EXTRA_PARAM'    =>  '^[[:digit:]]+$',
            'VALIDATION_EXTRA_PARAM'    =>  '',            
        ),
        'dialer_llamada_corta'  =>  array(
            'LABEL'                     =>  $arrLang['Short Call Threshold'],
            'REQUIRED'                  =>  'yes',
            'INPUT_TYPE'                =>  'TEXT',
            'VALIDATION_TYPE'           =>  'ereg',
            'INPUT_EXTRA_PARAM'         =>  '',
            'VALIDATION_EXTRA_PARAM'    =>  '^[[:digit:]]+$',
        ),
        'dialer_tiempo_contestar'=> array(
            'LABEL'                     =>  $arrLang['Answering delay'],
            'REQUIRED'                  =>  'yes',
            'INPUT_TYPE'                =>  'TEXT',
            'VALIDATION_TYPE'           =>  'ereg',
            'INPUT_EXTRA_PARAM'         =>  '',
            'VALIDATION_EXTRA_PARAM'    =>  '^[[:digit:]]+$',
        ),
        'dialer_debug'  =>          array(
            'LABEL'                     =>  $arrLang['Enable dialer debug'],
            'REQUIRED'                  =>  'yes',
            'INPUT_TYPE'                =>  'CHECKBOX',
            'VALIDATION_TYPE'           =>  'text',
            'INPUT_EXTRA_PARAM'         =>  '',
            'VALIDATION_EXTRA_PARAM'    =>  '',
        ),
        'dialer_allevents'  =>      array(
            'LABEL'                     =>  $arrLang['Dump all received Asterisk events'],
            'REQUIRED'                  =>  'yes',
            'INPUT_TYPE'                =>  'CHECKBOX',
            'VALIDATION_TYPE'           =>  'text',
            'INPUT_EXTRA_PARAM'         =>  '',
            'VALIDATION_EXTRA_PARAM'    =>  '',
        ),
        'dialer_overcommit'  =>      array(
            'LABEL'                     =>  $arrLang['Enable overcommit of outgoing calls'],
            'REQUIRED'                  =>  'yes',
            'INPUT_TYPE'                =>  'CHECKBOX',
            'VALIDATION_TYPE'           =>  'text',
            'INPUT_EXTRA_PARAM'         =>  '',
            'VALIDATION_EXTRA_PARAM'    =>  '',
        ),
        'dialer_qos'=> array(
            'LABEL'                     =>  $arrLang['Service percent'],
            'REQUIRED'                  =>  'yes',
            'INPUT_TYPE'                =>  'TEXT',
            'VALIDATION_TYPE'           =>  'float',
            'INPUT_EXTRA_PARAM'         =>  '',
            'VALIDATION_EXTRA_PARAM'    =>  '^[[:digit:]]+$',
        ),
    );
}


function getAction()
{
    if(getParameter("show")) //Get parameter by POST (submit)
        return "show";
    if(getParameter("save"))
        return "save";
    else if(getParameter("new"))
        return "new";
    else if(getParameter("action")=="show") //Get parameter by GET (command pattern, links)
        return "show";
    else
        return "report";
}?>
