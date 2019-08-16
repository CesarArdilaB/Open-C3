-- phpMyAdmin SQL Dump
-- version 2.11.11.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-11-2011 a las 10:40:57
-- Versión del servidor: 5.0.77
-- Versión de PHP: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `openc3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agents`
--

CREATE TABLE IF NOT EXISTS `agents` (
  `name` varchar(255) default NULL,
  `reportsid` varchar(255) default NULL,
  `number` int(11) default NULL,
  `user` varchar(44) NOT NULL,
  `password` varchar(255) default NULL,
  `extension` int(11) default NULL,
  `idagents_group` int(11) default NULL,
  `idgroup` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `id_agents` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_agents`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--


CREATE TABLE IF NOT EXISTS `projects` (
  `id_project` int(11) NOT NULL auto_increment,
  `project_name` varchar(45) default NULL,
  `project_description` varchar(45) default NULL,
  `idclient` int(11) default NULL,
  PRIMARY KEY  (`id_project`),
  KEY `fk_proyectos_clientes1` (`idclient`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- Volcar la base de datos para la tabla `agents`
--

INSERT INTO `agents` (`name`, `reportsid`, `number`, `user`, `password`, `extension`, `idagents_group`, `idgroup`, `tipo`, `id_agents`) VALUES
('Administrador', NULL, NULL, 'admin', 'admusr520a', NULL, NULL, 1, 1, 1),
('Adnistrador del Call Center', NULL, NULL, 'admincall', 'admincall', NULL, NULL, 2, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agents_group`
--

CREATE TABLE IF NOT EXISTS `agents_group` (
  `name` varchar(255) default NULL,
  `description` tinytext,
  `campana` int(11) NOT NULL,
  `id_agents_group` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_agents_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `agents_group`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asigned_regs`
--

CREATE TABLE IF NOT EXISTS `asigned_regs` (
  `idreg` int(11) NOT NULL,
  `idcam` int(11) NOT NULL,
  `idagent` int(11) NOT NULL,
  `id_asigned` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_asigned`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `asigned_regs`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoform_config`
--

CREATE TABLE IF NOT EXISTS `autoform_config` (
  `id_autoform_config` int(11) NOT NULL auto_increment,
  `labelcampo` varchar(45) default NULL,
  `nombrecampo` varchar(45) default NULL,
  `poscampo` tinyint(4) default NULL,
  `tipocampo` varchar(10) NOT NULL,
  `requerido` varchar(255) NOT NULL default '0',
  `historial` int(11) NOT NULL,
  `paramcampo` tinytext NOT NULL,
  `largo` int(11) NOT NULL,
  `eliminado` int(11) NOT NULL default '0',
  `unico` int(11) NOT NULL,
  `telefono` int(11) NOT NULL,
  `generado` int(11) NOT NULL,
  `idgrupo` varchar(255) NOT NULL,
  `idtabla_rel` int(11) NOT NULL,
  PRIMARY KEY  (`id_autoform_config`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Volcar la base de datos para la tabla `autoform_config`
--

INSERT INTO `autoform_config` (`id_autoform_config`, `labelcampo`, `nombrecampo`, `poscampo`, `tipocampo`, `requerido`, `historial`, `paramcampo`, `largo`, `eliminado`, `unico`, `telefono`, `generado`, `idgrupo`, `idtabla_rel`) VALUES
(1, 'Nombre', 'client_name', 0, 'text', '0', 0, '', 0, 0, 0, 0, 0, '1', 1),
(2, 'Descripcion', 'client_description', 1, 'text', '0', 0, '', 0, 0, 0, 0, 0, '1', 1),
(3, 'Nombre', 'project_name', 0, 'text', '0', 0, '', 0, 0, 0, 0, 0, '2', 2),
(4, 'Descripcion', 'project_description', 2, 'textarea', '0', 0, '', 0, 0, 0, 0, 0, '2', 2),
(5, 'Cliente', 'idclient', 1, 'autocom', '0', 0, 'clients,id_client,client_name,id_client,1', 0, 0, 0, 0, 0, '2', 2),
(6, 'Nombre de la Campaña', 'campaign_name', 1, 'text', ':required', 0, '', 0, 0, 0, 0, 0, '3', 3),
(7, 'Descripcion', 'campaign_description', 0, 'textarea', '0', 0, '', 0, 0, 0, 0, 0, '3', 3),
(8, 'Proyecto', 'idproject', 2, 'autocom', ':required', 0, 'projects,id_project,project_name,id_project,1', 0, 0, 0, 0, 0, '3', 3),
(9, 'Nombre', 'name', 0, 'text', '0', 0, '', 0, 0, 0, 0, 0, '4', 9),
(10, 'Id del Sistema', 'reportsid', 1, 'text', '0', 0, '', 0, 0, 0, 0, 0, '4', 9),
(11, 'Numero De Agente', 'number', 2, 'text', '1', 0, '', 0, 0, 0, 0, 0, '4', 9),
(12, 'Clave', 'password', 3, 'text', '0', 0, '', 0, 0, 0, 0, 0, '4', 9),
(13, 'Extension', 'extension', 4, 'text', '0', 0, '', 0, 0, 0, 0, 0, '4', 9),
(14, 'Nombre', 'name', 0, 'text', '0', 0, '', 0, 0, 0, 0, 0, '5', 10),
(15, 'Descripcion', 'description', 1, 'textarea', '0', 0, '', 0, 0, 0, 0, 0, '5', 10),
(16, 'Grupo', 'idagents_group', 6, 'select', '0', 0, 'agents_group,id_agents_group,name,id_agents_group,1', 0, 0, 0, 0, 0, '4', 9),
(30, 'Campaña', 'campana', 2, 'select', '0', 0, 'campaigns,id_campaign,campaign_name,id_campaign,1', 0, 0, 0, 0, 0, '5', 10),
(31, 'Usuario', 'user', 2, 'text', '1', 0, '', 15, 0, 0, 0, 0, '4', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoform_grupos`
--

CREATE TABLE IF NOT EXISTS `autoform_grupos` (
  `id_autoformgrupos` int(11) NOT NULL auto_increment,
  `labelgrupo` varchar(255) NOT NULL,
  `posiciongrupo` int(11) NOT NULL,
  `visiblegrupo` int(11) NOT NULL,
  `columnas` int(11) NOT NULL,
  `usrpermisos` varchar(255) NOT NULL,
  `idtabla_rel` int(11) NOT NULL,
  PRIMARY KEY  (`id_autoformgrupos`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `autoform_grupos`
--

INSERT INTO `autoform_grupos` (`id_autoformgrupos`, `labelgrupo`, `posiciongrupo`, `visiblegrupo`, `columnas`, `usrpermisos`, `idtabla_rel`) VALUES
(1, 'General', 0, 1, 1, '', 1),
(2, 'General', 0, 1, 1, '', 2),
(3, 'General', 0, 1, 1, '', 3),
(4, 'General', 1, 1, 1, '', 9),
(5, 'General', 0, 1, 1, '1', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoform_tablas`
--

CREATE TABLE IF NOT EXISTS `autoform_tablas` (
  `id_autoformtablas` int(11) NOT NULL auto_increment,
  `labeltabla` varchar(45) NOT NULL,
  `nombretabla` varchar(45) default NULL,
  `campoid` varchar(40) NOT NULL,
  `tipotabla` int(11) NOT NULL,
  `campaignid` int(11) NOT NULL,
  `descripcion` text,
  PRIMARY KEY  (`id_autoformtablas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Volcar la base de datos para la tabla `autoform_tablas`
--

INSERT INTO `autoform_tablas` (`id_autoformtablas`, `labeltabla`, `nombretabla`, `campoid`, `tipotabla`, `campaignid`, `descripcion`) VALUES
(1, 'Clientes', 'clients', 'id_client', 0, 0, 'Tabla para el majo de clientes.'),
(2, 'Proyectos', 'projects', 'id_project', 0, 0, 'Manejo de Proyectos por cliente.'),
(3, 'Campañas', 'campaigns', 'id_campaign', 0, 0, 'Tabla que contiene la informacion de las campañas.'),
(9, 'Agentes', 'agents', 'id_agents', 0, 0, 'Tabla para administrar agentes.'),
(10, 'Grupos de Agentes', 'agents_group', 'id_agents_group', 0, 0, 'Tabla de agentes.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campaigns`
--

CREATE TABLE IF NOT EXISTS `campaigns` (
  `id_campaign` int(11) NOT NULL auto_increment,
  `campaign_name` varchar(45) default NULL,
  `campaign_description` text,
  `campaign_type` int(11) default NULL,
  `idproject` int(11) default NULL,
  PRIMARY KEY  (`id_campaign`),
  KEY `fk_campanas_proyectos1` (`idproject`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `campaigns`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campaign_type`
--

CREATE TABLE IF NOT EXISTS `campaign_type` (
  `id_campaign_type` int(11) NOT NULL auto_increment,
  `campaign_type_name` varchar(45) default NULL,
  `campaign_type_description` text,
  PRIMARY KEY  (`id_campaign_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `campaign_type`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int(11) NOT NULL auto_increment,
  `client_name` varchar(45) default NULL,
  `client_description` text,
  PRIMARY KEY  (`id_client`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `clients`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filter_camposm`
--

CREATE TABLE IF NOT EXISTS `filter_camposm` (
  `campom` varchar(255) NOT NULL,
  `idfiltro` int(11) NOT NULL,
  `id_camposm` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_camposm`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `filter_camposm`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filter_config`
--

CREATE TABLE IF NOT EXISTS `filter_config` (
  `nombre` varchar(255) NOT NULL,
  `consulta` tinytext NOT NULL,
  `aagentid` int(11) NOT NULL,
  `agrouid` int(11) NOT NULL,
  `dialer` int(11) NOT NULL,
  `idform` int(11) NOT NULL,
  `idcam` int(11) NOT NULL,
  `id_filter` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_filter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `filter_config`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `firter_asign`
--

CREATE TABLE IF NOT EXISTS `firter_asign` (
  `idagente` int(11) NOT NULL,
  `idgrupo` int(11) NOT NULL,
  `idfiltro` int(11) NOT NULL,
  `id_filterasign` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_filterasign`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `firter_asign`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `firter_conditions`
--

CREATE TABLE IF NOT EXISTS `firter_conditions` (
  `campo` varchar(255) NOT NULL,
  `condicion` varchar(2) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `idrelconfig` int(11) NOT NULL,
  `id_condition` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_condition`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `firter_conditions`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id_group` int(11) NOT NULL auto_increment,
  `group_name` varchar(45) default NULL,
  `description` text,
  `idclient` varchar(45) default NULL,
  PRIMARY KEY  (`id_group`),
  KEY `fk_grupos_clientes1` (`idclient`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `groups`
--

INSERT INTO `groups` (`id_group`, `group_name`, `description`, `idclient`) VALUES
(1, 'SuperAdmin', '', NULL),
(2, 'AdminCallCenter', '', NULL),
(3, 'Agentes', 'Grupo administrativo para asignar permisos a los agentes.', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `importdata`
--

CREATE TABLE IF NOT EXISTS `importdata` (
  `idform` int(11) NOT NULL,
  `campos` tinytext NOT NULL,
  `regn` int(11) NOT NULL,
  `id_importdata` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_importdata`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `importdata`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `module_permissions`
--

CREATE TABLE IF NOT EXISTS `module_permissions` (
  `id_permission` int(11) NOT NULL auto_increment,
  `idgroup` int(11) default NULL,
  `id_page` int(11) default NULL,
  `id_campaign` int(11) default NULL,
  `page_permissions` varchar(255) default NULL,
  PRIMARY KEY  (`id_permission`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Volcar la base de datos para la tabla `module_permissions`
--

INSERT INTO `module_permissions` (`id_permission`, `idgroup`, `id_page`, `id_campaign`, `page_permissions`) VALUES
(9, 1, 6, NULL, NULL),
(2, 1, 2, NULL, NULL),
(6, 1, 0, NULL, NULL),
(4, 1, 5, NULL, NULL),
(7, 1, 3, NULL, NULL),
(8, 1, 4, NULL, NULL),
(10, 1, 8, NULL, NULL),
(15, 2, 3, NULL, NULL),
(12, 1, 7, NULL, NULL),
(13, 1, 10, NULL, NULL),
(14, 1, 11, NULL, NULL),
(16, 2, 2, NULL, NULL),
(17, 2, 4, NULL, NULL),
(18, 2, 6, NULL, NULL),
(19, 2, 7, NULL, NULL),
(21, 2, 10, NULL, NULL),
(22, 2, 8, NULL, NULL),
(32, 1, 13, NULL, NULL),
(25, 3, 12, NULL, NULL),
(40, 1, 25, NULL, NULL),
(39, 1, 24, NULL, NULL),
(35, 2, 13, NULL, NULL),
(34, 2, 12, NULL, NULL),
(31, 1, 12, NULL, NULL),
(36, 1, 22, NULL, NULL),
(37, 1, 23, NULL, NULL),
(38, 1, 21, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page_modules`
--

CREATE TABLE IF NOT EXISTS `page_modules` (
  `id_page_module` int(11) NOT NULL auto_increment,
  `page_title` varchar(45) default NULL,
  `modulegroup` varchar(255) default NULL,
  `module_folder` varchar(45) default NULL,
  `module_file` varchar(45) default NULL,
  `module_permission` varchar(255) default NULL,
  PRIMARY KEY  (`id_page_module`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Volcar la base de datos para la tabla `page_modules`
--

INSERT INTO `page_modules` (`id_page_module`, `page_title`, `modulegroup`, `module_folder`, `module_file`, `module_permission`) VALUES
(3, 'Grupos', 'Administracion', 'admin', 'admin_grupos', ''),
(2, 'Usuarios', 'Administracion', 'admin', 'admin_usuarios', ''),
(6, 'Clientes y Campañas', 'Campañas', 'campaigns', 'admin_cpc', ''),
(4, 'Permisos', 'Administracion', 'admin', 'admin_permisos', ''),
(5, 'Modulos', 'Administracion', 'admin', 'admin_paginas', ''),
(7, 'Formularios', 'Campañas', 'campaigns', 'form_manager', ''),
(8, 'Grupos y Agentes', 'Personal', 'staff', 'agents_groups', ''),
(12, 'Consola de Agente', 'Gestion', 'gestion', 'agent_console', ''),
(10, 'Grabaciones', 'Monitoreo', 'monitoring', 'recordings', ''),
(11, 'Panel De Agentes', 'Monitoreo', 'monitoring', 'realtimepanel', ''),
(13, 'Generador de Reportes', 'Reportes', 'reports', 'rep_generator', ''),
(25, 'Reportes de Telmex', 'Personalizado', 'client_custom', 'siverps', ''),
(23, 'Asignar Filtros', 'Campañas', 'campaigns', 'filter_config', ''),
(22, 'Marcacion Predictiva', 'Campañas', 'campaigns', 'dialer_campaigns', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `id_permiso` int(11) NOT NULL auto_increment,
  `idgrupo` int(11) default NULL,
  `id_pagina` int(11) default NULL,
  `id_campana` int(11) default NULL,
  `permisos_paginas` varchar(255) default NULL,
  PRIMARY KEY  (`id_permiso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `permisos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rep_campos_cfg`
--

CREATE TABLE IF NOT EXISTS `rep_campos_cfg` (
  `idrep_campos_cfg` int(11) NOT NULL,
  `tabla` varchar(45) default NULL,
  `nombre_campo` varchar(45) default NULL,
  `mostrar` int(11) default NULL,
  `valor_comparar` varchar(255) default NULL,
  `id_reporte` int(11) default NULL,
  PRIMARY KEY  (`idrep_campos_cfg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `rep_campos_cfg`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rep_reportes`
--

CREATE TABLE IF NOT EXISTS `rep_reportes` (
  `idrep_reportes` int(11) NOT NULL auto_increment,
  `nombre_reporte` varchar(45) default NULL,
  `tablas` varchar(255) NOT NULL,
  `camposcom` tinytext NOT NULL,
  `camposmos` tinytext NOT NULL,
  `vistan` varchar(255) NOT NULL,
  `id_cam` int(11) default NULL,
  `condiciones` text,
  PRIMARY KEY  (`idrep_reportes`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `rep_reportes`
--

INSERT INTO `rep_reportes` (`idrep_reportes`, `nombre_reporte`, `tablas`, `camposcom`, `camposmos`, `vistan`, `id_cam`, `condiciones`) VALUES
(1, 'General', ',autof_formulario_1,autof_formulario_1', ',af11_86', ',af11_31,af11_32,af11_92,af11_36,af11_86', '', 1, '1 AND  af11_86 != '''' '),
(2, 'Registros', ',autof_formulario_1,autof_formulario_1', ',af11_34', ',af11_31,af11_32,af11_34', '', 1, '1 AND  af11_34 != '''' ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL auto_increment,
  `name` varchar(45) default NULL,
  `reportsid` varchar(50) NOT NULL,
  `number` varchar(5) NOT NULL,
  `extension` varchar(5) NOT NULL,
  `idagents_group` int(11) NOT NULL,
  `user` varchar(45) default NULL,
  `password` varchar(45) default NULL,
  `lang` varchar(5) NOT NULL,
  `idgroup` int(11) default NULL,
  PRIMARY KEY  (`id_user`),
  UNIQUE KEY `id_usuario_UNIQUE` (`id_user`),
  KEY `fk_usuarios_grupos` (`idgroup`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `name`, `reportsid`, `number`, `extension`, `idagents_group`, `user`, `password`, `lang`, `idgroup`) VALUES
(1, 'Administrador', '', '', '', 0, 'admin', 'admusr520a', 'es_CO', 1),
(2, 'Adnistrador del Call Center', '', '', '', 0, 'admincall', 'admincall', '', 2);
