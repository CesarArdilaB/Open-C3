-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 15-03-2012 a las 17:20:34
-- Versión del servidor: 5.0.95
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
-- Estructura de tabla para la tabla `agenda`
--

CREATE TABLE IF NOT EXISTS `agenda` (
  `id_agenda` int(11) NOT NULL auto_increment,
  `idmensajero` int(11) NOT NULL,
  `idmensajero_entrego` int(11) NOT NULL,
  `idregistro` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(8) NOT NULL,
  `comentarios` tinytext NOT NULL,
  `feedback` int(11) NOT NULL,
  `feddbackcoments` tinytext NOT NULL,
  PRIMARY KEY  (`id_agenda`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `agenda`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda_estados`
--

CREATE TABLE IF NOT EXISTS `agenda_estados` (
  `estado` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `id_estado` int(11) NOT NULL auto_increment,
  `inactivo` int(11) NOT NULL,
  PRIMARY KEY  (`id_estado`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `agenda_estados`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda_tmp`
--

CREATE TABLE IF NOT EXISTS `agenda_tmp` (
  `id_agendatmp` int(11) NOT NULL auto_increment,
  `idregistro` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(8) NOT NULL,
  `comentarios` tinytext NOT NULL,
  PRIMARY KEY  (`id_agendatmp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `agenda_tmp`
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
  `inactivo` int(11) NOT NULL,
  `id_agents` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_agents`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `agents`
--

INSERT INTO `agents` (`name`, `reportsid`, `number`, `user`, `password`, `extension`, `idagents_group`, `idgroup`, `tipo`, `inactivo`, `id_agents`) VALUES
('Administrador', NULL, NULL, 'admin', 'admusr520a', NULL, NULL, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agents_group`
--

CREATE TABLE IF NOT EXISTS `agents_group` (
  `name` varchar(255) default NULL,
  `description` tinytext,
  `campana` int(11) NOT NULL,
  `id_agents_group` int(11) NOT NULL auto_increment,
  `inactivo` int(11) NOT NULL,
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
  `afechahora` datetime NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=155 ;

--
-- Volcar la base de datos para la tabla `autoform_config`
--

INSERT INTO `autoform_config` (`id_autoform_config`, `labelcampo`, `nombrecampo`, `poscampo`, `tipocampo`, `requerido`, `historial`, `paramcampo`, `largo`, `eliminado`, `unico`, `telefono`, `generado`, `idgrupo`, `idtabla_rel`) VALUES
(1, 'Nombre', 'client_name', 0, 'text', '0', 0, '', 0, 0, 0, 0, 0, '1', 1),
(2, 'Descripcion', 'client_description', 1, 'text', '0', 0, '', 0, 0, 0, 0, 0, '1', 1),
(3, 'Nombre', 'project_name', 0, 'text', '0', 0, '', 0, 0, 0, 0, 0, '2', 2),
(4, 'Descripcion', 'project_description', 2, 'textarea', '0', 0, '', 0, 0, 0, 0, 0, '2', 2),
(5, 'Cliente', 'idclient', 1, 'select', '0', 0, 'clients,id_client,client_name,id_client,1', 0, 0, 0, 0, 0, '2', 2),
(6, 'Nombre de la Campaña', 'campaign_name', 1, 'text', ':required', 0, '', 0, 0, 0, 0, 0, '3', 3),
(7, 'Descripcion', 'campaign_description', 0, 'textarea', '0', 0, '', 0, 0, 0, 0, 0, '3', 3),
(8, 'Proyecto', 'idproject', 2, 'select', ':required', 0, 'projects,id_project,project_name,id_project,1', 0, 0, 0, 0, 0, '3', 3),
(9, 'Nombre', 'name', 0, 'text', '0', 0, '', 0, 0, 0, 0, 0, '4', 9),
(10, 'Id del Sistema', 'reportsid', 1, 'text', '0', 0, '', 0, 0, 0, 0, 0, '4', 9),
(11, 'Numero De Agente', 'number', 2, 'text', '1', 0, '', 0, 0, 0, 0, 0, '4', 9),
(12, 'Clave', 'password', 3, 'text', '0', 0, '', 0, 0, 0, 0, 0, '4', 9),
(13, 'Extension', 'extension', 4, 'text', '0', 0, '', 0, 0, 0, 0, 0, '4', 9),
(14, 'Nombre', 'name', 0, 'text', '0', 0, '', 0, 0, 0, 0, 0, '5', 10),
(15, 'Descripcion', 'description', 1, 'textarea', '0', 0, '', 0, 0, 0, 0, 0, '5', 10),
(16, 'Grupo', 'idagents_group', 6, 'select', '0', 0, 'agents_group,id_agents_group,name,id_agents_group,1', 0, 0, 0, 0, 0, '4', 9),
(30, 'Campaña', 'campana', 2, 'select', '0', 0, 'campaigns,id_campaign,campaign_name,id_campaign,1', 0, 0, 0, 0, 0, '5', 10),
(82, 'Nombre', 'name', 0, 'text', '0', 0, '', 15, 0, 0, 0, 0, '13', 12),
(83, 'Identificador', 'reportsid', 1, 'text', '0', 0, '', 15, 0, 0, 0, 0, '13', 12),
(84, 'Numero De Citas', 'maxcitas', 2, 'text', '0', 0, '', 15, 0, 0, 0, 0, '13', 12),
(85, 'Inactivo', 'inactivo', 6, 'text', '0', 0, '', 15, 0, 0, 0, 0, '13', 12),
(86, 'Nombre Bodega', 'nombre', 0, 'text', '0', 0, '', 15, 0, 0, 0, 0, '50', 17),
(87, 'Descripcion', 'descripcion', 2, 'textarea', '0', 0, '', 15, 0, 0, 0, 0, '50', 17),
(88, 'Estado', 'estado', 1, 'text', '0', 0, '', 15, 0, 0, 0, 0, '51', 18),
(89, 'Descripcion', 'descripcion', 2, 'textarea', '0', 0, '', 0, 0, 0, 0, 0, '51', 18),
(132, 'Inactivo', 'inactivo', 2, 'textarea', '0', 0, '', 0, 0, 0, 0, 0, '51', 18),
(133, 'Inactiva', 'inactivo', 2, 'text', '0', 0, '', 15, 0, 0, 0, 0, '50', 17),
(134, 'Ya No Labora', 'nolabora', 7, 'text', '0', 0, '', 15, 0, 0, 0, 0, '13', 12),
(146, 'Usuario', 'user', 3, 'text', '0', 0, '', 0, 0, 0, 0, 0, '4', 9),
(154, 'Placa', 'placa', 4, 'text', '0', 0, '', 6, 0, 0, 0, 0, '13', 12);

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
  `usrpermisos` varchar(255) character set latin1 collate latin1_spanish_ci NOT NULL,
  `usrver` varchar(255) NOT NULL,
  `usredit` varchar(255) NOT NULL,
  `idtabla_rel` int(11) NOT NULL,
  PRIMARY KEY  (`id_autoformgrupos`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Volcar la base de datos para la tabla `autoform_grupos`
--

INSERT INTO `autoform_grupos` (`id_autoformgrupos`, `labelgrupo`, `posiciongrupo`, `visiblegrupo`, `columnas`, `usrpermisos`, `usrver`, `usredit`, `idtabla_rel`) VALUES
(1, 'General', 0, 1, 1, '', '', '', 1),
(2, 'General', 0, 1, 1, '', '', '', 2),
(3, 'General', 0, 1, 1, '', '', '', 3),
(4, 'General', 1, 1, 1, '', '', '', 9),
(5, 'General', 0, 1, 1, '', '', '', 10),
(13, 'General', 0, 1, 1, '', '', '', 12),
(51, 'General Estados', 1, 1, 1, '', '', '', 18),
(50, 'General Bodegas', 1, 1, 1, '', '', '', 17);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Volcar la base de datos para la tabla `autoform_tablas`
--

INSERT INTO `autoform_tablas` (`id_autoformtablas`, `labeltabla`, `nombretabla`, `campoid`, `tipotabla`, `campaignid`, `descripcion`) VALUES
(1, 'Clientes', 'clients', 'id_client', 0, 0, 'Tabla para el majo de clientes.'),
(2, 'Proyectos', 'projects', 'id_project', 0, 0, 'Manejo de Proyectos por cliente.'),
(3, 'Campañas', 'campaigns', 'id_campaign', 0, 0, 'Tabla que contiene la informacion de las campañas.'),
(9, 'Agentes', 'agents', 'id_agents', 0, 0, 'Tabla para administrar agentes.'),
(10, 'Grupos de Agentes', 'agents_group', 'id_agents_group', 0, 0, 'Tabla de agentes.'),
(12, 'Mensajeros', 'mensajeros', 'id_mensajero', 0, 0, 'Tabla para el manejo de mensajeros. estos a futuro se podran enlazar con telefonia.'),
(17, 'Bodegas', 'inv_bodegas', 'id_bodegas', 0, 0, 'Tabla Para El Manejo de las Bodegas.'),
(18, 'Estados de Inventarios', 'inv_estado', 'id_estado', 0, 0, 'Esta Tabla Maneja los estados.');

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
  `inactivo` int(11) NOT NULL,
  PRIMARY KEY  (`id_campaign`),
  UNIQUE KEY `campaign_name` (`campaign_name`),
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
  `inactivo` int(11) NOT NULL,
  PRIMARY KEY  (`id_client`),
  UNIQUE KEY `client_name` (`client_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `clients`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comp_form_rel`
--

CREATE TABLE IF NOT EXISTS `comp_form_rel` (
  `idform` int(11) NOT NULL,
  `idcompmod` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_modformrel` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_modformrel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `comp_form_rel`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comp_modules`
--

CREATE TABLE IF NOT EXISTS `comp_modules` (
  `textlink` varchar(255) NOT NULL,
  `rutamod` varchar(255) NOT NULL,
  `tipod` int(11) NOT NULL,
  `altoiframe` int(11) NOT NULL,
  `id_compmod` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_compmod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `comp_modules`
--

INSERT INTO `comp_modules` (`textlink`, `rutamod`, `tipod`, `altoiframe`, `id_compmod`) VALUES
('Agendar Cita', 'modules/agenda/addcita.php', 0, 0, 1),
('Inventariar', 'modules/inventarios/inventario_add.php', 1, 200, 2),
('Historial Inventario', 'modules/inventarios/inventario_historia.php', 1, 200, 3);

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
  `idtemplate` int(11) NOT NULL,
  PRIMARY KEY  (`id_filter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `filter_config`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filter_tamplate`
--

CREATE TABLE IF NOT EXISTS `filter_tamplate` (
  `nombre` varchar(44) NOT NULL,
  `clausulas` varchar(255) NOT NULL,
  `id_filtertemplate` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_filtertemplate`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `filter_tamplate`
--

INSERT INTO `filter_tamplate` (`nombre`, `clausulas`, `id_filtertemplate`) VALUES
('Sin Datos', '1', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `groups`
--

INSERT INTO `groups` (`id_group`, `group_name`, `description`, `idclient`) VALUES
(1, 'SuperAdmin', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `his_baseup`
--

CREATE TABLE IF NOT EXISTS `his_baseup` (
  `fechahora` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombrearchivo` varchar(255) NOT NULL,
  `numeroregsok` int(11) NOT NULL,
  `numeroregsfail` int(11) NOT NULL,
  `idform` int(11) NOT NULL,
  `idhisbaseup` int(11) NOT NULL auto_increment,
  KEY `idhisbaseup` (`idhisbaseup`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `his_baseup`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `importdata`
--

CREATE TABLE IF NOT EXISTS `importdata` (
  `idform` int(11) NOT NULL,
  `campos` text NOT NULL,
  `regn` int(11) NOT NULL,
  `id_importdata` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_importdata`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `importdata`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_bodegas`
--

CREATE TABLE IF NOT EXISTS `inv_bodegas` (
  `idcampana` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` tinytext NOT NULL,
  `inactivo` int(11) NOT NULL,
  `id_bodegas` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_bodegas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `inv_bodegas`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_estado`
--

CREATE TABLE IF NOT EXISTS `inv_estado` (
  `estado` varchar(255) NOT NULL,
  `descripcion` tinytext NOT NULL,
  `inactivo` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_estado`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `inv_estado`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_historial`
--

CREATE TABLE IF NOT EXISTS `inv_historial` (
  `idregistro` int(11) NOT NULL,
  `idbodega_his` int(11) NOT NULL,
  `idagente_his` int(11) NOT NULL,
  `fechah_his` datetime NOT NULL,
  `idestado_his` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_inventario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `inv_historial`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_inventario`
--

CREATE TABLE IF NOT EXISTS `inv_inventario` (
  `idregistro` int(11) NOT NULL,
  `idbodega` int(11) NOT NULL,
  `idagente` int(11) NOT NULL,
  `fechah` datetime NOT NULL,
  `idestado` int(11) NOT NULL,
  `lote` varchar(255) NOT NULL,
  `matchf` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_inventario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `inv_inventario`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_match`
--

CREATE TABLE IF NOT EXISTS `inv_match` (
  `mbase` int(11) NOT NULL,
  `mfile` int(11) NOT NULL,
  `lote` varchar(255) NOT NULL,
  `id_match` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_match`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `inv_match`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_mefile`
--

CREATE TABLE IF NOT EXISTS `inv_mefile` (
  `pseudo` int(11) NOT NULL,
  `lotem` int(11) NOT NULL,
  `id_error` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_error`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `inv_mefile`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajeros`
--

CREATE TABLE IF NOT EXISTS `mensajeros` (
  `name` varchar(255) default NULL,
  `reportsid` varchar(255) default NULL,
  `number` int(11) default NULL,
  `user` varchar(44) NOT NULL,
  `password` varchar(255) default NULL,
  `extension` int(11) default NULL,
  `idagents_group` int(11) default NULL,
  `idgroup` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `placa` varchar(7) NOT NULL,
  `inactivo` int(11) NOT NULL,
  `maxcitas` int(11) NOT NULL,
  `nolabora` int(11) NOT NULL,
  `id_mensajero` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_mensajero`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `mensajeros`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=154 ;

--
-- Volcar la base de datos para la tabla `module_permissions`
--

INSERT INTO `module_permissions` (`id_permission`, `idgroup`, `id_page`, `id_campaign`, `page_permissions`) VALUES
(9, 1, 6, NULL, NULL),
(2, 1, 2, NULL, NULL),
(4, 1, 5, NULL, NULL),
(7, 1, 3, NULL, NULL),
(8, 1, 4, NULL, NULL),
(10, 1, 8, NULL, NULL),
(12, 1, 7, NULL, NULL),
(13, 1, 10, NULL, NULL),
(14, 1, 11, NULL, NULL),
(45, 1, 28, NULL, NULL),
(32, 1, 13, NULL, NULL),
(31, 1, 12, NULL, NULL),
(36, 1, 22, NULL, NULL),
(37, 1, 23, NULL, NULL),
(51, 1, 30, NULL, NULL),
(52, 1, 31, NULL, NULL),
(54, 1, 33, NULL, NULL),
(55, 1, 34, NULL, NULL),
(56, 1, 35, NULL, NULL),
(58, 1, 38, NULL, NULL),
(59, 1, 39, NULL, NULL),
(60, 1, 40, NULL, NULL),
(62, 1, 42, NULL, NULL),
(63, 1, 43, NULL, NULL),
(136, 1, 50, NULL, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Volcar la base de datos para la tabla `page_modules`
--

INSERT INTO `page_modules` (`id_page_module`, `page_title`, `modulegroup`, `module_folder`, `module_file`, `module_permission`) VALUES
(3, 'Perfiles', 'Administracion', 'admin', 'admin_grupos', ''),
(2, 'Usuarios', 'Administracion', 'admin', 'admin_usuarios', ''),
(6, 'Clientes y Campañas', 'Campañas', 'campaigns', 'admin_cpc', ''),
(4, 'Permisos', 'Administracion', 'admin', 'admin_permisos', ''),
(5, 'Modulos', 'Administracion', 'admin', 'admin_paginas', ''),
(7, 'Formularios', 'Campañas', 'campaigns', 'form_manager', ''),
(8, 'Grupos y Agentes', 'Personal', 'staff', 'agents_groups', ''),
(12, 'Consola de Agente', 'Gestion', 'gestion', 'agent_console', ''),
(10, 'Grabaciones', 'Monitoreo', 'monitoring', 'recordings', ''),
(11, 'Panel De Agentes', 'Monitoreo', 'monitoring', 'realtimepanel', ''),
(13, 'Generador de Reportes', 'Reportes', 'reports', 'rep_config', ''),
(23, 'Asignar Filtros', 'Campañas', 'campaigns', 'filter_config', ''),
(22, 'Marcacion Predictiva', 'Campañas', 'campaigns', 'dialer_campaigns', ''),
(28, 'Registros Consultados', 'Consultar', 'reports', 'regs_asignados', ''),
(30, 'Mensajeros', 'Personal', 'staff', 'mensajeros', ''),
(31, 'Agenda', 'Agenda', 'agenda', 'agenda', ''),
(33, 'Manifiesto', 'Agenda', 'agenda', 'manifiesto', ''),
(34, 'Bodegas', 'Inventarios', 'inventarios', 'bodegas', ''),
(35, 'Estados Inventarios', 'Inventarios', 'inventarios', 'estados', ''),
(38, 'Estados Agenda', 'Agenda', 'agenda', 'estados', ''),
(39, 'Alertas Agendamientos', 'Inventarios', 'inventarios', 'alertadias', ''),
(40, 'Match', 'Inventarios', 'inventarios', 'match', ''),
(42, 'Pistolear Entrada', 'Inventarios', 'inventarios', 'pistolear_in', ''),
(43, 'Pistolear Salida', 'Inventarios', 'inventarios', 'pistolear_out', ''),
(50, 'Courrier', 'Agenda', 'agenda', 'courrier', '');

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
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id_project` int(11) NOT NULL auto_increment,
  `project_name` varchar(45) default NULL,
  `project_description` varchar(45) default NULL,
  `idclient` int(11) default NULL,
  `inactivo` int(11) NOT NULL,
  PRIMARY KEY  (`id_project`),
  UNIQUE KEY `project_name` (`project_name`),
  KEY `fk_proyectos_clientes1` (`idclient`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `projects`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rep_asign`
--

CREATE TABLE IF NOT EXISTS `rep_asign` (
  `idagente` int(11) NOT NULL,
  `idgrupo` int(11) NOT NULL,
  `idfiltro` int(11) NOT NULL,
  `id_filterasign` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_filterasign`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `rep_asign`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rep_camposm`
--

CREATE TABLE IF NOT EXISTS `rep_camposm` (
  `campom` varchar(255) NOT NULL,
  `idfiltro` int(11) NOT NULL,
  `id_camposm` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_camposm`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `rep_camposm`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rep_conditions`
--

CREATE TABLE IF NOT EXISTS `rep_conditions` (
  `campo` varchar(255) NOT NULL,
  `condicion` varchar(2) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `idrelconfig` int(11) NOT NULL,
  `id_condition` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_condition`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `rep_conditions`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rep_config`
--

CREATE TABLE IF NOT EXISTS `rep_config` (
  `nombre` varchar(255) NOT NULL,
  `consulta` tinytext NOT NULL,
  `aagentid` int(11) NOT NULL,
  `agrouid` int(11) NOT NULL,
  `dialer` int(11) NOT NULL,
  `idform` int(11) NOT NULL,
  `idcam` int(11) NOT NULL,
  `idtemplate` int(11) NOT NULL,
  `id_filter` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_filter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `rep_config`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `name`, `reportsid`, `number`, `extension`, `idagents_group`, `user`, `password`, `lang`, `idgroup`) VALUES
(1, 'Administrador', '', '', '', 0, 'admin', 'admusr520a', 'es_CO', 1);
