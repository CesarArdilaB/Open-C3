-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-10-2011 a las 19:30:42
-- Versión del servidor: 5.0.77
-- Versión de PHP: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `octres`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agents`
--

CREATE TABLE IF NOT EXISTS `agents` (
  `name` varchar(255) NOT NULL,
  `reportsid` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `password` int(11) NOT NULL,
  `extension` int(11) NOT NULL,
  `idagents_group` int(11) NOT NULL,
  `id_agents` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_agents`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `agents`
--

INSERT INTO `agents` (`name`, `reportsid`, `number`, `password`, `extension`, `idagents_group`, `id_agents`) VALUES
('Agente1', '80132456', 100, 100, 100, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agents_group`
--

CREATE TABLE IF NOT EXISTS `agents_group` (
  `name` varchar(255) NOT NULL,
  `description` tinytext NOT NULL,
  `campana` int(11) NOT NULL,
  `id_agent_group` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_agent_group`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `agents_group`
--

INSERT INTO `agents_group` (`name`, `description`, `campana`, `id_agent_group`) VALUES
('General', 'este es un grupo de pruebas.', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoform_config`
--

CREATE TABLE IF NOT EXISTS `autoform_config` (
  `id_autoform_config` int(11) NOT NULL auto_increment,
  `labelcampo` varchar(45) default NULL,
  `nombrecampo` varchar(45) default NULL,
  `poscampo` varchar(45) default NULL,
  `tipocampo` varchar(10) NOT NULL,
  `requerido` varchar(45) NOT NULL default '0',
  `historial` int(11) NOT NULL,
  `paramcampo` tinytext NOT NULL,
  `eliminado` int(11) NOT NULL default '0',
  `generado` int(11) NOT NULL,
  `idgrupo` varchar(255) NOT NULL,
  `idtabla_rel` int(11) NOT NULL,
  PRIMARY KEY  (`id_autoform_config`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Volcar la base de datos para la tabla `autoform_config`
--

INSERT INTO `autoform_config` (`id_autoform_config`, `labelcampo`, `nombrecampo`, `poscampo`, `tipocampo`, `requerido`, `historial`, `paramcampo`, `eliminado`, `generado`, `idgrupo`, `idtabla_rel`) VALUES
(1, 'Nombre', 'client_name', '0', 'text', '0', 0, '', 0, 0, '1', 1),
(2, 'Descripcion', 'client_description', '1', 'text', '0', 0, '', 0, 0, '1', 1),
(3, 'Nombre', 'project_name', '0', 'text', '0', 0, '', 0, 0, '2', 2),
(4, 'Descripcion', 'project_description', '2', 'textarea', '0', 0, '', 0, 0, '2', 2),
(5, 'Cliente', 'idclient', '1', 'autocom', '0', 0, 'clients,id_client,client_name,id_client,1', 0, 0, '2', 2),
(6, 'Nombre de la Campaña', 'campaign_name', '1', 'text', ':required', 0, '', 0, 0, '3', 3),
(7, 'Descripcion', 'campaign_description', '0', 'textarea', '0', 0, '', 0, 0, '3', 3),
(8, 'Proyecto', 'idproject', '2', 'autocom', ':required', 0, 'projects,id_project,project_name,id_project,1', 0, 0, '3', 3),
(9, 'Nombre', 'name', '0', 'text', '0', 0, '', 0, 0, '4', 9),
(10, 'Id del Sistema', 'reportsid', '1', 'text', '0', 0, '', 0, 0, '4', 9),
(11, 'Numero', 'number', '2', 'text', '1', 0, '', 0, 0, '4', 9),
(12, 'Clave', 'password', '3', 'text', '0', 0, '', 0, 0, '4', 9),
(13, 'Extension', 'extension', '4', 'text', '0', 0, '', 0, 0, '4', 9),
(14, 'Nombre', 'name', '0', 'text', '0', 0, '', 0, 0, '5', 10),
(15, 'Descripcion', 'description', '1', 'textarea', '0', 0, '', 0, 0, '5', 10),
(16, 'Grupo', 'idagents_group', '6', 'select', '0', 0, 'agents_group,id_agent_group,name,id_agent_group,1', 0, 0, '4', 9),
(59, 'Pago2', 'af12_59', '1', 'text', '', 0, '', 0, 1, '14', 12),
(58, 'pg P1', 'af12_58', '6', 'text', '', 0, '', 0, 1, '13', 12),
(57, 'qc P1', 'af12_57', '5', 'text', '', 0, '', 0, 1, '13', 12),
(56, 'Aprobacion P1', 'af12_56', '4', 'text', ' ', 0, '', 0, 1, '13', 12),
(55, 'Fecha P1', 'af12_55', '3', 'fecha', '', 0, '', 0, 1, '13', 12),
(54, 'Digitado P1', 'af12_54', '2', 'text', '', 0, '', 0, 1, '13', 12),
(53, 'Pago1', 'af12_53', '0', 'text', '', 0, '', 0, 1, '13', 12),
(52, 'Banco T2', 'af12_52', '9', 'text', '', 0, '', 0, 1, '12', 12),
(51, 'Fecha Ven T2', 'af12_51', '8', 'fecha', '', 0, '', 0, 1, '12', 12),
(50, 'Codigo de Verificacion T2', 'af12_50', '7', 'text', '', 0, '', 0, 1, '12', 12),
(49, 'Tarjeta de Credito 2', 'af12_49', '6', 'text', '', 0, '', 0, 1, '12', 12),
(48, 'Banco T1', 'af12_48', '5', 'text', '', 0, '', 0, 1, '12', 12),
(47, 'Fecha Ven T1', 'af12_47', '4', 'fecha', '', 0, '', 0, 1, '12', 12),
(30, 'Campaña', 'campana', '2', 'select', '0', 0, 'campaigns,id_campaign,campaign_name,id_campaign,1', 0, 0, '5', 10),
(45, 'Tarjeta de Credito 1', 'af12_45', '2', 'text', ':float :length;16 :required', 0, '', 0, 1, '12', 12),
(46, 'Codigo de Verificacion T1', 'af12_46', '3', 'text', '', 0, '', 0, 1, '12', 12),
(44, 'Fecha de Nacimiento', 'af12_44', '1', 'fecha', '', 0, '', 0, 1, '12', 12),
(43, 'Nombre', 'af12_43', '0', 'text', '', 0, '', 0, 1, '12', 12),
(42, 'Hora-Venta', 'af12_42', '3', 'text', '', 0, '', 0, 1, '11', 12),
(41, 'Control', 'af12_41', '2', 'text', '', 0, '', 0, 1, '11', 12),
(39, 'Fecha-Venta', 'af12_39', '0', 'fecha', '', 0, '', 0, 1, '11', 12),
(40, 'Asesor', 'af12_40', '1', 'text', '', 0, '', 0, 1, '11', 12),
(60, 'Digitado P2', 'af12_60', '2', 'text', '', 0, '', 0, 1, '14', 12),
(61, 'Fecha P2', 'af12_61', '3', 'text', '', 0, '', 0, 1, '14', 12),
(62, 'Aprobacion P2', 'af12_62', '4', 'text', '', 0, '', 0, 1, '14', 12),
(63, 'qc P2', 'af12_63', '5', 'text', '', 0, '', 0, 1, '14', 12),
(64, 'pg P2', 'af12_64', '6', 'text', '', 0, '', 0, 1, '14', 12),
(65, 'Pago3', 'af12_65', '1', 'text', '', 0, '', 0, 1, '15', 12),
(66, 'Digitado P3', 'af12_66', '2', 'text', '', 0, '', 0, 1, '15', 12),
(67, 'Fecha P3', 'af12_67', '3', 'text', '', 0, '', 0, 1, '15', 12),
(68, 'Aprobacion P3', 'af12_68', '4', 'text', '', 0, '', 0, 1, '15', 12),
(69, 'qc P3', 'af12_69', '5', 'text', '', 0, '', 0, 1, '15', 12),
(70, 'pg P3', 'af12_70', '6', 'text', '', 0, '', 0, 1, '15', 12),
(71, 'Ups Tracking', 'af12_71', '1', 'text', '', 0, '', 0, 1, '16', 12),
(72, 'Ups Fecha', 'af12_72', '2', 'fecha', '', 0, '', 0, 1, '16', 12),
(73, 'Fedex Number', 'af12_73', '3', 'text', '', 0, '', 0, 1, '16', 12),
(74, 'Fedex Fecha', 'af12_74', '3', 'fecha', '', 0, '', 0, 1, '16', 12),
(75, 'Otros Number', 'af12_75', '5', 'text', '', 0, '', 0, 1, '16', 12),
(76, 'Otros Fecha', 'af12_76', '6', 'fecha', '', 0, '', 0, 1, '16', 12),
(77, 'Observaciones', 'af12_77', '7', 'textarea', '', 0, '', 0, 1, '16', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoform_grupos`
--

CREATE TABLE IF NOT EXISTS `autoform_grupos` (
  `id_autoformgrupos` int(11) NOT NULL auto_increment,
  `labelgrupo` varchar(255) NOT NULL,
  `posiciongrupo` int(11) NOT NULL,
  `visiblegrupo` int(11) NOT NULL,
  `usrpermisos` varchar(255) NOT NULL,
  `idtabla_rel` int(11) NOT NULL,
  PRIMARY KEY  (`id_autoformgrupos`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcar la base de datos para la tabla `autoform_grupos`
--

INSERT INTO `autoform_grupos` (`id_autoformgrupos`, `labelgrupo`, `posiciongrupo`, `visiblegrupo`, `usrpermisos`, `idtabla_rel`) VALUES
(1, 'General', 0, 1, '', 1),
(2, 'General', 0, 1, '', 2),
(3, 'General', 0, 1, '', 3),
(4, 'General', 1, 1, '', 9),
(5, 'General', 0, 1, '1', 10),
(16, 'Envio', 6, 1, '', 12),
(15, 'Pago 3', 4, 1, '', 12),
(14, 'Pago 2', 3, 1, '', 12),
(13, 'Pago 1', 2, 1, '', 12),
(12, 'Datos del Tarjetahabiente', 1, 1, '', 12),
(11, 'Datos de Asesor', 0, 1, '', 12);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcar la base de datos para la tabla `autoform_tablas`
--

INSERT INTO `autoform_tablas` (`id_autoformtablas`, `labeltabla`, `nombretabla`, `campoid`, `tipotabla`, `campaignid`, `descripcion`) VALUES
(1, 'Clientes', 'clients', 'id_client', 0, 0, 'Tabla para el majo de clientes.'),
(2, 'Proyectos', 'projects', 'id_project', 0, 0, 'Manejo de Proyectos por cliente.'),
(3, 'Campañas', 'campaigns', 'id_campaign', 0, 0, 'Tabla que contiene la informacion de las campañas.'),
(9, 'Agentes', 'agents', 'id_agents', 0, 0, 'Tabla para administrar agentes.'),
(10, 'Grupos de Agentes', 'agents_group', 'id_agent_group', 0, 0, 'Tabla de agentes.'),
(12, 'Ingles Hoy', 'autof_ingleshoy_1', 'Ingles Hoy_id', 1, 1, 'Generado automaticamente por el manejador de formularios de OpenC3');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `campaigns`
--

INSERT INTO `campaigns` (`id_campaign`, `campaign_name`, `campaign_description`, `campaign_type`, `idproject`) VALUES
(1, 'Ingles Hoy', 'Ingles Hoy', NULL, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `clients`
--

INSERT INTO `clients` (`id_client`, `client_name`, `client_description`) VALUES
(1, 'Pas Program', '');

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
(1, 'SuperAdmin', 'Es el Perfil de super administrador, no se puede eliminar.', NULL),
(2, 'AdminCallCenter', 'administradores del call center', NULL),
(3, 'Agentes', 'este es un grupo de agentes al cual no se le deben agregar usuarios', NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

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
(20, 2, 10, NULL, NULL),
(21, 2, 10, NULL, NULL),
(22, 2, 8, NULL, NULL),
(32, 1, 13, NULL, NULL),
(24, 3, 0, NULL, NULL),
(25, 3, 12, NULL, NULL),
(26, 3, 0, NULL, NULL),
(27, 3, 0, NULL, NULL),
(33, 1, 14, NULL, NULL),
(31, 1, 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page_modules`
--

CREATE TABLE IF NOT EXISTS `page_modules` (
  `id_page_module` int(11) NOT NULL auto_increment,
  `page_title` varchar(45) collate utf8_spanish_ci default NULL,
  `modulegroup` varchar(255) character set latin1 collate latin1_spanish_ci default NULL,
  `module_folder` varchar(45) collate utf8_spanish_ci default NULL,
  `module_file` varchar(255) collate utf8_spanish_ci default NULL,
  `module_permission` varchar(255) collate utf8_spanish_ci default NULL,
  PRIMARY KEY  (`id_page_module`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=15 ;

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
(14, 'Ventas', 'Reportes', 'reports', 'rep_vewer&repid=1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id_project` int(11) NOT NULL auto_increment,
  `project_name` varchar(45) default NULL,
  `project_description` varchar(45) default NULL,
  `idclient` int(11) default NULL,
  PRIMARY KEY  (`id_project`),
  KEY `fk_proyectos_clientes1` (`idclient`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `projects`
--

INSERT INTO `projects` (`id_project`, `project_name`, `project_description`, `idclient`) VALUES
(1, 'Ingles', 'campanas referentes al proyecto ingles hoy', 1);

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
  `tablas` varchar(255) NOT NULL,
  `camposmos` varchar(255) NOT NULL,
  `camposcom` varchar(255) NOT NULL,
  `nombre_reporte` varchar(45) default NULL,
  `id_cam` int(11) default NULL,
  `condiciones` text,
  PRIMARY KEY  (`idrep_reportes`),
  KEY `id_cam` (`id_cam`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `rep_reportes`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `texto` varchar(255) character set utf8 collate utf8_spanish_ci NOT NULL,
  `dsfsfsd` varchar(22) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `test`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL auto_increment,
  `names` varchar(45) default NULL,
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

INSERT INTO `users` (`id_user`, `names`, `user`, `password`, `lang`, `idgroup`) VALUES
(1, 'Administrador', 'admin', '4ffc430a5b13bfba71aefbdf9016360f', 'es_CO', 1),
(2, 'Adnistrador del Call Center', 'admincall', 'admincall', '', 2);
