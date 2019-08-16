-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-10-2014 a las 18:35:35
-- Versión del servidor: 5.1.61
-- Versión de PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `octres`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acampos_esp`
--

CREATE TABLE IF NOT EXISTS `acampos_esp` (
  `campon` varchar(50) NOT NULL,
  `labelcampo` varchar(255) NOT NULL,
  `mudulon` varchar(255) NOT NULL,
  `tipocampo` varchar(10) NOT NULL,
  `paramcampo` varchar(255) NOT NULL,
  `tabla` varchar(50) NOT NULL,
  `campoid` varchar(55) NOT NULL,
  `id_camposesp` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_camposesp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `acampos_esp`
--

INSERT INTO `acampos_esp` (`campon`, `labelcampo`, `mudulon`, `tipocampo`, `paramcampo`, `tabla`, `campoid`, `id_camposesp`) VALUES
('idmensajero', 'Mensajero', 'Agenda', 'autocom', 'mensajeros,id_mensajero,name,id_mensajero,inactivo = 0', 'agenda', 'id_agenda', 1),
('idagente', 'Agente que agendo', 'Agenda', 'autocom', 'agents,id_agents,name,id_agents,inactivo = 0', 'agenda', 'id_agenda', 2),
('fecha', 'Fecha Agendamiento', 'Agenda', 'fecha', '', 'agenda', 'id_agenda', 3),
('feedback', 'Feed Back', 'Agenda', 'select', 'agenda_estados,id_estado,estado,id_estado,inactivo = 0', 'agenda', 'id_agenda', 4),
('idbodega', 'Bodega', 'Inventario', 'select', 'inv_bodegas,id_bodegas,nombre,id_bodegas,inactivo = 0', 'inv_inventario', 'id_inventario', 5),
('idestado', 'Estado Inventario', 'Inventario', 'select', 'inv_estado,id_estado,estado,id_estado,inactivo = 0', 'inv_inventario', 'id_inventario', 6),
('lote', 'Lote', 'Inventario', 'text', '', 'inv_inventario', 'id_inventario', 7),
('idagente', 'Usuario', 'Inventario', 'autocom', 'agents,id_agents,name,id_agents,inactivo = 0', 'inv_inventario', 'id_inventario', 8),
('fechasalida', 'Fecha de salida', 'Inventario', 'fecha', '', 'inv_inventario', 'id_inventario', 9),
('fechah', 'Fecha de Inventario', 'Inventario', 'fecha', '', 'inv_inventario', 'id_inventario', 11),
('fechaentrega', 'Fecha de Entrega', 'Inventario', 'fecha', '', 'inv_inventario', 'id_inventario', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda`
--

CREATE TABLE IF NOT EXISTS `agenda` (
  `id_agenda` int(11) NOT NULL AUTO_INCREMENT,
  `numeroref` varchar(255) NOT NULL,
  `claved` varchar(50) NOT NULL,
  `clavef` varchar(5) NOT NULL,
  `tipoag` int(11) NOT NULL,
  `idmensajero` int(11) NOT NULL,
  `idmensajero_entrego` int(11) NOT NULL,
  `idagente` int(11) NOT NULL,
  `idregistro` int(11) NOT NULL,
  `idcampana` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `fechahoraag` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `horaup` time NOT NULL,
  `hora` varchar(8) NOT NULL,
  `comentarios` tinytext NOT NULL,
  `feedback` int(11) NOT NULL,
  `feddbackcoments` tinytext NOT NULL,
  `geotag` varchar(255) NOT NULL,
  `aut` int(11) NOT NULL,
  PRIMARY KEY (`id_agenda`),
  KEY `idregistro` (`idregistro`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda_camconfig`
--

CREATE TABLE IF NOT EXISTS `agenda_camconfig` (
  `idcampana` int(11) NOT NULL,
  `labelc` varchar(20) NOT NULL,
  `cedulac` varchar(20) NOT NULL,
  `nombrec` varchar(20) NOT NULL,
  `datosterc` varchar(20) NOT NULL,
  `direccionenc` varchar(20) NOT NULL,
  `tipoentregac` varchar(20) NOT NULL,
  `tipoentregainic` varchar(20) NOT NULL,
  `obsevacionesc` varchar(20) NOT NULL,
  `barrioc` varchar(20) NOT NULL,
  `refmensajeroc` varchar(20) NOT NULL,
  `campanac` varchar(20) NOT NULL,
  `tipogestionc` varchar(20) NOT NULL,
  `mesgestionc` varchar(20) NOT NULL,
  `codigooficinac` varchar(20) NOT NULL,
  `gestioncallc` varchar(25) NOT NULL,
  `documentossolc` varchar(20) NOT NULL,
  `ciudadc` varchar(20) NOT NULL,
  `codigosoc` varchar(20) NOT NULL,
  `documentosc` varchar(20) NOT NULL,
  `emailc` varchar(20) NOT NULL,
  `movilc` varchar(20) NOT NULL,
  `movil2c` varchar(20) NOT NULL,
  `id_agcamconfig` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_agcamconfig`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda_estados`
--

CREATE TABLE IF NOT EXISTS `agenda_estados` (
  `estado` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `inactivo` int(11) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda_manifiestos`
--

CREATE TABLE IF NOT EXISTS `agenda_manifiestos` (
  `fecha` date NOT NULL,
  `idmensajero` int(11) NOT NULL,
  `id_manifiesto` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_manifiesto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda_tmp`
--

CREATE TABLE IF NOT EXISTS `agenda_tmp` (
  `id_agendatmp` int(11) NOT NULL AUTO_INCREMENT,
  `numeroref` varchar(255) NOT NULL,
  `tipoag` int(11) NOT NULL,
  `idregistro` int(11) NOT NULL,
  `idcampana` int(11) NOT NULL,
  `idagente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `fechahoraag` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hora` varchar(8) NOT NULL,
  `comentarios` tinytext NOT NULL,
  PRIMARY KEY (`id_agendatmp`),
  KEY `idregistro` (`idregistro`),
  KEY `idcampana` (`idcampana`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agents`
--

CREATE TABLE IF NOT EXISTS `agents` (
  `name` varchar(255) DEFAULT NULL,
  `reportsid` varchar(255) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `user` varchar(44) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `extension` int(11) DEFAULT NULL,
  `idagents_group` int(11) DEFAULT NULL,
  `idgroup` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `inactivo` int(11) NOT NULL,
  `id_agents` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_agents`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `agents`
--

INSERT INTO `agents` (`name`, `reportsid`, `number`, `user`, `password`, `extension`, `idagents_group`, `idgroup`, `tipo`, `inactivo`, `id_agents`) VALUES
('Administrador', NULL, NULL, 'admin', 'admin', NULL, NULL, 1, 1, 0, 1),
('supervisor', NULL, NULL, 'supervisor', 'supervisor', NULL, NULL, 2, 1, 0, 2),
('Agente1', '80120476', 101, 'agente1', 'agente1', 101, 1, 0, 0, 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agents_group`
--

CREATE TABLE IF NOT EXISTS `agents_group` (
  `name` varchar(255) DEFAULT NULL,
  `description` tinytext,
  `campana` int(11) NOT NULL,
  `id_agents_group` int(11) NOT NULL AUTO_INCREMENT,
  `inactivo` int(11) NOT NULL,
  PRIMARY KEY (`id_agents_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `agents_group`
--

INSERT INTO `agents_group` (`name`, `description`, `campana`, `id_agents_group`, `inactivo`) VALUES
('Grupo 1', '', 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asigned_regs`
--

CREATE TABLE IF NOT EXISTS `asigned_regs` (
  `idreg` int(11) NOT NULL,
  `idcam` int(11) NOT NULL,
  `idagent` int(11) NOT NULL,
  `afechahora` datetime NOT NULL,
  `id_asigned` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_asigned`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoform_config`
--

CREATE TABLE IF NOT EXISTS `autoform_config` (
  `id_autoform_config` int(11) NOT NULL AUTO_INCREMENT,
  `labelcampo` varchar(45) DEFAULT NULL,
  `nombrecampo` varchar(45) DEFAULT NULL,
  `poscampo` tinyint(4) DEFAULT NULL,
  `tipocampo` varchar(10) NOT NULL,
  `requerido` varchar(255) NOT NULL DEFAULT '0',
  `historial` int(11) NOT NULL,
  `paramcampo` tinytext NOT NULL,
  `mascara` int(11) NOT NULL,
  `valorc` varchar(255) NOT NULL,
  `largo` int(11) NOT NULL,
  `eliminado` int(11) NOT NULL DEFAULT '0',
  `unico` int(11) NOT NULL,
  `telefono` int(11) NOT NULL,
  `generado` int(11) NOT NULL,
  `idgrupo` varchar(255) NOT NULL,
  `idtabla_rel` int(11) NOT NULL,
  PRIMARY KEY (`id_autoform_config`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=164 ;

--
-- Volcado de datos para la tabla `autoform_config`
--

INSERT INTO `autoform_config` (`id_autoform_config`, `labelcampo`, `nombrecampo`, `poscampo`, `tipocampo`, `requerido`, `historial`, `paramcampo`, `mascara`, `valorc`, `largo`, `eliminado`, `unico`, `telefono`, `generado`, `idgrupo`, `idtabla_rel`) VALUES
(1, 'Nombre', 'client_name', 0, 'text', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '1', 1),
(2, 'Descripcion', 'client_description', 1, 'text', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '1', 1),
(3, 'Nombre', 'project_name', 0, 'text', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '2', 2),
(4, 'Descripcion', 'project_description', 2, 'textarea', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '2', 2),
(5, 'Cliente', 'idclient', 1, 'select', '0', 0, 'clients,id_client,client_name,id_client,1', 0, '', 0, 0, 0, 0, 0, '2', 2),
(6, 'Nombre de la Campaña', 'campaign_name', 1, 'text', ':required', 0, '', 0, '', 0, 0, 0, 0, 0, '3', 3),
(7, 'Descripcion', 'campaign_description', 0, 'textarea', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '3', 3),
(8, 'Proyecto', 'idproject', 2, 'select', ':required', 0, 'projects,id_project,project_name,id_project,1', 0, '', 0, 0, 0, 0, 0, '3', 3),
(9, 'Nombre', 'name', 0, 'text', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '4', 9),
(10, 'Id del Sistema', 'reportsid', 1, 'text', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '4', 9),
(11, 'Numero De Agente', 'number', 2, 'text', '1', 0, '', 0, '', 0, 0, 0, 0, 0, '4', 9),
(12, 'Clave', 'password', 3, 'text', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '4', 9),
(13, 'Extension', 'extension', 4, 'text', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '4', 9),
(14, 'Nombre', 'name', 0, 'text', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '5', 10),
(15, 'Descripcion', 'description', 1, 'textarea', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '5', 10),
(16, 'Grupo', 'idagents_group', 6, 'select', '0', 0, 'agents_group,id_agents_group,name,id_agents_group,1', 0, '', 0, 0, 0, 0, 0, '4', 9),
(30, 'Campaña', 'campana', 2, 'select', '0', 0, 'campaigns,id_campaign,campaign_name,id_campaign,1', 0, '', 0, 0, 0, 0, 0, '5', 10),
(82, 'Nombre', 'name', 0, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '13', 12),
(83, 'Identificador', 'reportsid', 1, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '13', 12),
(84, 'Numero De Citas', 'maxcitas', 2, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '13', 12),
(85, 'Inactivo', 'inactivo', 6, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '13', 12),
(86, 'Nombre Bodega', 'nombre', 0, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '50', 17),
(87, 'Descripcion', 'descripcion', 2, 'textarea', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '50', 17),
(88, 'Estado', 'estado', 1, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '51', 18),
(89, 'Descripcion', 'descripcion', 2, 'textarea', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '51', 18),
(132, 'Inactivo', 'inactivo', 2, 'textarea', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '51', 18),
(133, 'Inactiva', 'inactivo', 2, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '50', 17),
(134, 'Ya No Labora', 'nolabora', 7, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '13', 12),
(146, 'Usuario', 'user', 3, 'text', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '4', 9),
(147, 'Contexto', 'contexto', 4, 'text', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '3', 3),
(148, 'Numero de Cola', 'cola', 5, 'text', '0', 0, '', 0, '', 0, 0, 0, 0, 0, '3', 3),
(154, 'Placa', 'placa', 4, 'text', '0', 0, '', 0, '', 6, 0, 0, 0, 0, '13', 12),
(155, 'Nombres', 'af19_155', 1, 'text', '', 0, '', 0, '', 15, 0, 0, 0, 1, '52', 19),
(156, 'Apellidos', 'af19_156', 2, 'text', '', 0, '', 0, '', 15, 0, 0, 0, 1, '52', 19),
(157, 'Cedula', 'af19_157', 3, 'text', '', 0, '', 0, '', 15, 0, 0, 0, 1, '52', 19),
(158, 'Telefono', 'af19_158', 4, 'text', ' ', 1, '', 0, '', 15, 0, 0, 1, 1, '52', 19),
(159, 'Resultado', 'af19_159', 5, 'select', ' ', 0, 'autof_af19_159,id_af19_159,field1,id_af19_159,inactivo = 0', 0, '', 15, 0, 0, 0, 1, '52', 19),
(160, 'Campo 1', 'field1', 0, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '53', 20),
(161, 'Campo 2', 'field2', 1, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '53', 20),
(162, 'Campo 1', 'field1', 0, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '54', 21),
(163, 'Campo 2', 'field2', 1, 'text', '0', 0, '', 0, '', 15, 0, 0, 0, 0, '54', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoform_grupos`
--

CREATE TABLE IF NOT EXISTS `autoform_grupos` (
  `id_autoformgrupos` int(11) NOT NULL AUTO_INCREMENT,
  `labelgrupo` varchar(255) NOT NULL,
  `posiciongrupo` int(11) NOT NULL,
  `visiblegrupo` int(11) NOT NULL,
  `columnas` int(11) NOT NULL,
  `usrpermisos` varchar(255) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `usrver` varchar(255) NOT NULL,
  `usredit` varchar(255) NOT NULL,
  `nota` varchar(255) NOT NULL,
  `idtabla_rel` int(11) NOT NULL,
  PRIMARY KEY (`id_autoformgrupos`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Volcado de datos para la tabla `autoform_grupos`
--

INSERT INTO `autoform_grupos` (`id_autoformgrupos`, `labelgrupo`, `posiciongrupo`, `visiblegrupo`, `columnas`, `usrpermisos`, `usrver`, `usredit`, `nota`, `idtabla_rel`) VALUES
(1, 'General', 0, 1, 1, '', '', '', '', 1),
(2, 'General', 0, 1, 1, '', '', '', '', 2),
(3, 'General', 0, 1, 1, '', '', '', '', 3),
(4, 'General', 1, 1, 1, '', '', '', '', 9),
(5, 'General', 0, 1, 1, '', '', '', '', 10),
(13, 'General', 0, 1, 1, '', '', '', '', 12),
(51, 'General Estados', 1, 1, 1, '', '', '', '', 18),
(50, 'General Bodegas', 1, 1, 1, '', '', '', '', 17),
(52, 'General', 0, 1, 2, '', '', '', '', 19),
(53, 'General', 0, 1, 1, '', '', '', '', 20),
(54, 'General', 0, 1, 1, '', '', '', '', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoform_tablas`
--

CREATE TABLE IF NOT EXISTS `autoform_tablas` (
  `id_autoformtablas` int(11) NOT NULL AUTO_INCREMENT,
  `labeltabla` varchar(45) NOT NULL,
  `nombretabla` varchar(45) DEFAULT NULL,
  `campoid` varchar(40) NOT NULL,
  `tipotabla` int(11) NOT NULL,
  `campaignid` int(11) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id_autoformtablas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `autoform_tablas`
--

INSERT INTO `autoform_tablas` (`id_autoformtablas`, `labeltabla`, `nombretabla`, `campoid`, `tipotabla`, `campaignid`, `descripcion`) VALUES
(1, 'Clientes', 'clients', 'id_client', 0, 0, 'Tabla para el majo de clientes.'),
(2, 'Proyectos', 'projects', 'id_project', 0, 0, 'Manejo de Proyectos por cliente.'),
(3, 'Campañas', 'campaigns', 'id_campaign', 0, 0, 'Tabla que contiene la informacion de las campañas.'),
(9, 'Agentes', 'agents', 'id_agents', 0, 0, 'Tabla para administrar agentes.'),
(10, 'Grupos de Agentes', 'agents_group', 'id_agents_group', 0, 0, 'Tabla de agentes.'),
(12, 'Mensajeros', 'mensajeros', 'id_mensajero', 0, 0, 'Tabla para el manejo de mensajeros. estos a futuro se podran enlazar con telefonia.'),
(17, 'Bodegas', 'inv_bodegas', 'id_bodegas', 0, 0, 'Tabla Para El Manejo de las Bodegas.'),
(18, 'Estados de Inventarios', 'inv_estado', 'id_estado', 0, 0, 'Esta Tabla Maneja los estados.'),
(19, 'Formulario 1', 'autof_formulario1_1', 'autof_formulario1_1_id', 1, 1, 'Generado automaticamente por el manejador de formularios de OpenC3'),
(20, ' base', 'autof_af19_159', 'id_af19_159', 2, 0, 'Tabla de campo generada automaticamente.'),
(21, ' base', 'autof_af19_159', 'id_af19_159', 2, 0, 'Tabla de campo generada automaticamente.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autof_af19_159`
--

CREATE TABLE IF NOT EXISTS `autof_af19_159` (
  `field1` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `field2` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_af19_159` int(11) NOT NULL AUTO_INCREMENT,
  `inactivo` int(11) NOT NULL,
  PRIMARY KEY (`id_af19_159`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `autof_af19_159`
--

INSERT INTO `autof_af19_159` (`field1`, `field2`, `id_af19_159`, `inactivo`) VALUES
('Venta', '', 1, 0),
('LLamar de Nuevo', '', 2, 0),
('Telefono Danado', '', 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autof_formulario1_1`
--

CREATE TABLE IF NOT EXISTS `autof_formulario1_1` (
  `autof_formulario1_1_id` int(11) NOT NULL AUTO_INCREMENT,
  `af19_155` varchar(125) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `af19_156` varchar(125) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `af19_157` varchar(125) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `af19_158` varchar(125) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `af19_159` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`autof_formulario1_1_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `autof_formulario1_1`
--

INSERT INTO `autof_formulario1_1` (`autof_formulario1_1_id`, `af19_155`, `af19_156`, `af19_157`, `af19_158`, `af19_159`) VALUES
(3, 'Andres ', 'Ardila', '80120476', '3044138634', '3'),
(2, 'Alejandro ', 'Orrego', '223366', '252336', '1'),
(4, 'Pedro', 'Peres', '33652', '3652', '2'),
(5, 'Fernando ', 'Fernandez', '694563', '36213', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campaigns`
--

CREATE TABLE IF NOT EXISTS `campaigns` (
  `id_campaign` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `campaign_description` text CHARACTER SET utf8,
  `campaign_type` int(11) DEFAULT NULL,
  `contexto` varchar(255) CHARACTER SET utf8 NOT NULL,
  `cola` varchar(50) CHARACTER SET utf8 NOT NULL,
  `idproject` int(11) DEFAULT NULL,
  `inactivo` int(11) NOT NULL,
  PRIMARY KEY (`id_campaign`),
  UNIQUE KEY `campaign_name` (`campaign_name`),
  KEY `fk_campanas_proyectos1` (`idproject`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `campaigns`
--

INSERT INTO `campaigns` (`id_campaign`, `campaign_name`, `campaign_description`, `campaign_type`, `contexto`, `cola`, `idproject`, `inactivo`) VALUES
(1, 'Campaña 1', '', NULL, 'from-internal', '1000', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campaign_type`
--

CREATE TABLE IF NOT EXISTS `campaign_type` (
  `id_campaign_type` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_type_name` varchar(45) DEFAULT NULL,
  `campaign_type_description` text,
  PRIMARY KEY (`id_campaign_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(45) DEFAULT NULL,
  `client_description` text,
  `inactivo` int(11) NOT NULL,
  PRIMARY KEY (`id_client`),
  UNIQUE KEY `client_name` (`client_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id_client`, `client_name`, `client_description`, `inactivo`) VALUES
(1, 'Cliente SA', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comp_form_rel`
--

CREATE TABLE IF NOT EXISTS `comp_form_rel` (
  `idform` int(11) NOT NULL,
  `idcompmod` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_modformrel` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_modformrel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comp_modules`
--

CREATE TABLE IF NOT EXISTS `comp_modules` (
  `textlink` varchar(255) NOT NULL,
  `rutamod` varchar(255) NOT NULL,
  `tipod` int(11) NOT NULL,
  `altoiframe` int(11) NOT NULL,
  `id_compmod` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_compmod`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `comp_modules`
--

INSERT INTO `comp_modules` (`textlink`, `rutamod`, `tipod`, `altoiframe`, `id_compmod`) VALUES
('Agendar Cita', 'modules/agenda/addcita.php', 0, 0, 1),
('Inventariar', 'modules/inventarios/inventario_add.php', 1, 200, 2),
('Historial Inventario', 'modules/inventarios/inventario_historia.php', 1, 200, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador_config`
--

CREATE TABLE IF NOT EXISTS `contador_config` (
  `idcampana` int(11) NOT NULL,
  `numero_tipicaciones` int(11) NOT NULL,
  `numero_estados` int(11) NOT NULL,
  `id_contadorcfg` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_contadorcfg`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files_relacces`
--

CREATE TABLE IF NOT EXISTS `files_relacces` (
  `id_filesacces` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) NOT NULL,
  `ver` int(11) NOT NULL,
  `adm` int(11) NOT NULL,
  PRIMARY KEY (`id_filesacces`),
  KEY `id_filesacces` (`id_filesacces`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filter_camposm`
--

CREATE TABLE IF NOT EXISTS `filter_camposm` (
  `campom` varchar(255) NOT NULL,
  `idfiltro` int(11) NOT NULL,
  `id_camposm` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_camposm`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `id_filter` int(11) NOT NULL AUTO_INCREMENT,
  `idtemplate` int(11) NOT NULL,
  PRIMARY KEY (`id_filter`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `filter_config`
--

INSERT INTO `filter_config` (`nombre`, `consulta`, `aagentid`, `agrouid`, `dialer`, `idform`, `idcam`, `id_filter`, `idtemplate`) VALUES
('Filtro 1', '', 0, 0, 0, 19, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filter_tamplate`
--

CREATE TABLE IF NOT EXISTS `filter_tamplate` (
  `nombre` varchar(44) NOT NULL,
  `clausulas` varchar(255) NOT NULL,
  `id_filtertemplate` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_filtertemplate`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `filter_tamplate`
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
  `id_filterasign` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_filterasign`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `firter_conditions`
--

CREATE TABLE IF NOT EXISTS `firter_conditions` (
  `campo` varchar(255) NOT NULL,
  `condicion` varchar(2) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `idrelconfig` int(11) NOT NULL,
  `id_condition` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_condition`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id_group` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(45) DEFAULT NULL,
  `description` text,
  `idclient` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_group`),
  KEY `fk_grupos_clientes1` (`idclient`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id_group`, `group_name`, `description`, `idclient`) VALUES
(1, 'SuperAdmin', '', NULL),
(2, 'Supervisor', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `history_1`
--

CREATE TABLE IF NOT EXISTS `history_1` (
  `id_reg` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fechahora` datetime NOT NULL,
  `accion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `his_af19_158` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_history_1` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_history_1`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `history_1`
--

INSERT INTO `history_1` (`id_reg`, `id_usuario`, `fechahora`, `accion`, `his_af19_158`, `id_history_1`) VALUES
(1, 1, '2014-10-08 13:24:02', 'Registro Creado', '101010', 1),
(3, 1, '2014-10-10 13:48:50', 'Registro Creado', '3044138634', 2),
(2, 1, '2014-10-10 13:58:39', 'Registro Creado', '252336', 3),
(2, 1, '2014-10-10 13:58:59', 'Registro Creado', '32598', 4),
(2, 1, '2014-10-10 13:59:40', 'Registro Modificado', '252336', 5),
(2, 1, '2014-10-10 14:00:46', 'Registro Modificado', '252336', 6),
(2, 1, '2014-10-10 14:01:19', 'Registro Modificado', '252336', 7),
(4, 1, '2014-10-10 14:01:40', 'Registro Creado', '3652', 8),
(5, 1, '2014-10-10 14:01:54', 'Registro Creado', '36213', 9),
(3, 1, '2014-10-10 14:02:05', 'Registro Modificado', '3044138634', 10);

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
  `idhisbaseup` int(11) NOT NULL AUTO_INCREMENT,
  KEY `idhisbaseup` (`idhisbaseup`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ident_1`
--

CREATE TABLE IF NOT EXISTS `ident_1` (
  `id_ident_1` int(11) NOT NULL AUTO_INCREMENT,
  `estado` int(11) NOT NULL,
  `agente` int(11) NOT NULL,
  `fechahorac` datetime NOT NULL,
  PRIMARY KEY (`id_ident_1`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `ident_1`
--

INSERT INTO `ident_1` (`id_ident_1`, `estado`, `agente`, `fechahorac`) VALUES
(1, 1, 1, '2014-10-08 13:24:02'),
(2, 1, 1, '2014-10-10 13:58:59'),
(3, 1, 1, '2014-10-10 13:48:50'),
(4, 1, 1, '2014-10-10 14:01:40'),
(5, 1, 1, '2014-10-10 14:01:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `importdata`
--

CREATE TABLE IF NOT EXISTS `importdata` (
  `idform` int(11) NOT NULL,
  `campos` text NOT NULL,
  `regn` int(11) NOT NULL,
  `id_importdata` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_importdata`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_bodegas`
--

CREATE TABLE IF NOT EXISTS `inv_bodegas` (
  `idcampana` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` tinytext NOT NULL,
  `inactivo` int(11) NOT NULL,
  `id_bodegas` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_bodegas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_camconfig`
--

CREATE TABLE IF NOT EXISTS `inv_camconfig` (
  `idcampana` int(11) NOT NULL,
  `clote` varchar(20) NOT NULL,
  `cguiain` varchar(20) NOT NULL,
  `cdiasmaxentrega` varchar(20) NOT NULL,
  `cbolsain` varchar(20) NOT NULL,
  `cpseudocodigo` varchar(20) NOT NULL,
  `cbolsaout` varchar(20) NOT NULL,
  `cguiaout` varchar(20) NOT NULL,
  `gestioncallc` varchar(20) NOT NULL,
  `id_camconfig` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_camconfig`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_estado`
--

CREATE TABLE IF NOT EXISTS `inv_estado` (
  `estado` varchar(255) NOT NULL,
  `descripcion` tinytext NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `inactivo` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_estado`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_historial`
--

CREATE TABLE IF NOT EXISTS `inv_historial` (
  `idregistro` int(11) NOT NULL,
  `idcampana` int(11) NOT NULL,
  `idbodega_his` int(11) NOT NULL,
  `idagente_his` int(11) NOT NULL,
  `fechah_his` datetime NOT NULL,
  `fechasalida_his` date NOT NULL,
  `idestado_his` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_inventario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_inventario`
--

CREATE TABLE IF NOT EXISTS `inv_inventario` (
  `idregistro` int(11) NOT NULL,
  `idcampana` int(11) NOT NULL,
  `idbodega` int(11) NOT NULL,
  `idagente` int(11) NOT NULL,
  `fechah` datetime NOT NULL,
  `fechasalida` date NOT NULL,
  `fechaentrega` date NOT NULL,
  `idestado` int(11) NOT NULL,
  `scodigo` varchar(255) NOT NULL,
  `lote` int(11) NOT NULL,
  `guia` varchar(255) NOT NULL,
  `bolsa` varchar(255) NOT NULL,
  `guiaout` varchar(255) NOT NULL,
  `bolsaout` varchar(255) NOT NULL,
  `matchf` int(11) NOT NULL,
  `tiempomax` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_inventario`),
  KEY `idregistro` (`idregistro`),
  KEY `idcampana` (`idcampana`),
  KEY `bolsaout` (`bolsaout`),
  KEY `scodigo` (`scodigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_match`
--

CREATE TABLE IF NOT EXISTS `inv_match` (
  `mbase` int(11) NOT NULL,
  `mfile` int(11) NOT NULL,
  `lote` varchar(255) NOT NULL,
  `id_match` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_match`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_mefile`
--

CREATE TABLE IF NOT EXISTS `inv_mefile` (
  `pseudo` int(11) NOT NULL,
  `lotem` int(11) NOT NULL,
  `id_error` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_error`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajeros`
--

CREATE TABLE IF NOT EXISTS `mensajeros` (
  `name` varchar(255) DEFAULT NULL,
  `reportsid` varchar(255) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `user` varchar(44) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `extension` int(11) DEFAULT NULL,
  `idagents_group` int(11) DEFAULT NULL,
  `idgroup` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `placa` varchar(7) NOT NULL,
  `inactivo` int(11) NOT NULL,
  `maxcitas` int(11) NOT NULL,
  `nolabora` int(11) NOT NULL,
  `id_mensajero` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_mensajero`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `module_permissions`
--

CREATE TABLE IF NOT EXISTS `module_permissions` (
  `id_permission` int(11) NOT NULL AUTO_INCREMENT,
  `idgroup` int(11) DEFAULT NULL,
  `id_page` int(11) DEFAULT NULL,
  `id_campaign` int(11) DEFAULT NULL,
  `page_permissions` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_permission`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=171 ;

--
-- Volcado de datos para la tabla `module_permissions`
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
(136, 1, 50, NULL, NULL),
(154, 1, 114, NULL, NULL),
(155, 1, 143, NULL, NULL),
(156, 1, 139, NULL, NULL),
(157, 1, 149, NULL, NULL),
(158, 1, 172, NULL, NULL),
(159, 1, 142, NULL, NULL),
(160, 1, 141, NULL, NULL),
(161, 1, 84, NULL, NULL),
(162, 1, 189, NULL, NULL),
(163, 1, 148, NULL, NULL),
(164, 1, 147, NULL, NULL),
(165, 1, 138, NULL, NULL),
(166, 1, 140, NULL, NULL),
(167, 1, 125, NULL, NULL),
(168, 1, 144, NULL, NULL),
(169, 1, 53, NULL, NULL),
(170, 1, 190, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page_modules`
--

CREATE TABLE IF NOT EXISTS `page_modules` (
  `id_page_module` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(45) DEFAULT NULL,
  `modulegroup` varchar(255) DEFAULT NULL,
  `module_folder` varchar(45) DEFAULT NULL,
  `module_file` varchar(45) DEFAULT NULL,
  `module_permission` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_page_module`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=191 ;

--
-- Volcado de datos para la tabla `page_modules`
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
(13, 'Generador de Reportes', 'Reportes e Informes', 'reports', 'rep_config', ''),
(23, 'Asignar Filtros', 'Campañas', 'campaigns', 'filter_config', ''),
(22, 'Marcacion Predictiva', 'Campañas', 'campaigns', 'dialer_campaigns', ''),
(143, 'Agendamiento Masivo', 'Agenda', 'agenda', 'agendamiento_masivo', ''),
(30, 'Mensajeros', 'Personal', 'staff', 'mensajeros', ''),
(31, 'Agenda', 'Agenda', 'agenda', 'agenda', ''),
(34, 'Bodegas', 'Inventarios', 'inventarios', 'bodegas', ''),
(35, 'Estados Inventarios', 'Inventarios', 'inventarios', 'estados', ''),
(38, 'Estados Agenda', 'Agenda', 'agenda', 'estados', ''),
(39, 'Alertas Agendamientos', 'Inventarios', 'inventarios', 'alertadias', ''),
(40, 'Match', 'Inventarios', 'inventarios', 'match', ''),
(42, 'Pistolear Entrada', 'Inventarios', 'inventarios', 'pistolear_in', ''),
(43, 'Pistolear Salida', 'Inventarios', 'inventarios', 'pistolear_out', ''),
(50, 'Courrier', 'Agenda', 'agenda', 'courrier', ''),
(53, 'Reporte 1', 'Reportes e Informes', 'reports', 'rep_vewer&repid=1', NULL),
(114, 'Cambiar Password', 'Administracion', 'admin', 'cambiar_clave', ''),
(189, 'Carga de Archivos', 'Documentacion', 'manejoarchivos', 'subir_masivo', ''),
(139, 'Configurar Con Campañas', 'Agenda', 'agenda', 'config_campos', ''),
(138, 'Configurar con Campañas', 'Inventarios', 'inventarios', 'config_campos', ''),
(149, 'Contador', 'Agenda', 'agenda', 'contador', ''),
(148, 'Descarga de Reportes', 'Garga y Descarga', 'cronjobs', 'descarga_reportes', ''),
(172, 'Entregas Autenticadas', 'Agenda', 'agenda', 'registros_aut', ''),
(140, 'Feed Back', 'Inventarios', 'agenda', 'feedback_multiple', ''),
(147, 'Garga de Bases', 'Garga y Descarga', 'cronjobs', 'carga_bases', ''),
(144, 'Generador de Informes', 'Reportes e Informes', 'reports', 'rep_resumengraficos', ''),
(142, 'Manifiesto Nuevo', 'Agenda', 'agenda', 'manifiesto_nuevo', ''),
(84, 'Metas y comisiones', 'Campañas', 'campaigns', 'metas_config', ''),
(125, 'Panel de Mensajeros', 'Monitoreo', 'monitoring', 'courier_realtimepanel', ''),
(141, 'Reporte FeedBack', 'Agenda', 'agenda', 'feedback_reporte', ''),
(190, 'Dinamico 1', 'Reportes e Informes', 'reports', 'rep_resumvewer&repid=1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `id_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `idgrupo` int(11) DEFAULT NULL,
  `id_pagina` int(11) DEFAULT NULL,
  `id_campana` int(11) DEFAULT NULL,
  `permisos_paginas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_permiso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id_project` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(45) DEFAULT NULL,
  `project_description` varchar(45) DEFAULT NULL,
  `idclient` int(11) DEFAULT NULL,
  `inactivo` int(11) NOT NULL,
  PRIMARY KEY (`id_project`),
  UNIQUE KEY `project_name` (`project_name`),
  KEY `fk_proyectos_clientes1` (`idclient`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `projects`
--

INSERT INTO `projects` (`id_project`, `project_name`, `project_description`, `idclient`, `inactivo`) VALUES
(1, 'Proyecto 1', 'Este es el primer Proyecto de este cliente', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repdina_camposm`
--

CREATE TABLE IF NOT EXISTS `repdina_camposm` (
  `campom` varchar(255) NOT NULL,
  `idfiltro` int(11) NOT NULL,
  `id_camposm` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_camposm`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `repdina_camposm`
--

INSERT INTO `repdina_camposm` (`campom`, `idfiltro`, `id_camposm`) VALUES
('af19_156', 1, 6),
('af19_155', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repdina_compare`
--

CREATE TABLE IF NOT EXISTS `repdina_compare` (
  `campo` varchar(20) NOT NULL,
  `condicion` varchar(5) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `idrelconfig` int(11) NOT NULL,
  `id_compare` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_compare`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `repdina_compare`
--

INSERT INTO `repdina_compare` (`campo`, `condicion`, `valor`, `idrelconfig`, `id_compare`) VALUES
('af19_155', '!=', '', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repdina_config`
--

CREATE TABLE IF NOT EXISTS `repdina_config` (
  `nombre` varchar(255) NOT NULL,
  `id_cam` int(11) NOT NULL,
  `id_form` int(11) NOT NULL,
  `id_rep` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_rep`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `repdina_config`
--

INSERT INTO `repdina_config` (`nombre`, `id_cam`, `id_form`, `id_rep`) VALUES
('Dinamico 1', 1, 19, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repdina_datashow`
--

CREATE TABLE IF NOT EXISTS `repdina_datashow` (
  `valor` varchar(255) NOT NULL,
  `identificador` varchar(255) NOT NULL,
  `ncampo` varchar(25) NOT NULL,
  `id_rep` int(11) NOT NULL,
  `id_datashow` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_datashow`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `repdina_datashow`
--

INSERT INTO `repdina_datashow` (`valor`, `identificador`, `ncampo`, `id_rep`, `id_datashow`) VALUES
('Venta', '1', 'af19_159', 1, 1),
('LLamar de Nuevo', '2', 'af19_159', 1, 2),
('Telefono Danado', '3', 'af19_159', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rep_asign`
--

CREATE TABLE IF NOT EXISTS `rep_asign` (
  `idagente` int(11) NOT NULL,
  `idgrupo` int(11) NOT NULL,
  `idfiltro` int(11) NOT NULL,
  `id_filterasign` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_filterasign`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rep_camposm`
--

CREATE TABLE IF NOT EXISTS `rep_camposm` (
  `campom` varchar(255) NOT NULL,
  `idfiltro` int(11) NOT NULL,
  `id_camposm` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_camposm`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `rep_camposm`
--

INSERT INTO `rep_camposm` (`campom`, `idfiltro`, `id_camposm`) VALUES
('af19_155', 1, 1),
('af19_156', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rep_conditions`
--

CREATE TABLE IF NOT EXISTS `rep_conditions` (
  `campo` varchar(255) NOT NULL,
  `condicion` varchar(2) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `idrelconfig` int(11) NOT NULL,
  `id_condition` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_condition`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `rep_conditions`
--

INSERT INTO `rep_conditions` (`campo`, `condicion`, `valor`, `idrelconfig`, `id_condition`) VALUES
('af19_155', '!=', '', 1, 1);

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
  `id_filter` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_filter`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `rep_config`
--

INSERT INTO `rep_config` (`nombre`, `consulta`, `aagentid`, `agrouid`, `dialer`, `idform`, `idcam`, `idtemplate`, `id_filter`) VALUES
('Reporte 1', '', 0, 0, 0, 19, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `reportsid` varchar(50) NOT NULL,
  `number` varchar(5) NOT NULL,
  `extension` varchar(5) NOT NULL,
  `idagents_group` int(11) NOT NULL,
  `user` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `lang` varchar(5) NOT NULL,
  `idgroup` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `id_usuario_UNIQUE` (`id_user`),
  KEY `fk_usuarios_grupos` (`idgroup`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `name`, `reportsid`, `number`, `extension`, `idagents_group`, `user`, `password`, `lang`, `idgroup`) VALUES
(1, 'Administrador', '', '', '', 0, 'admin', 'admusr520a', 'es_CO', 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_rep_1`
--
CREATE TABLE IF NOT EXISTS `vista_rep_1` (
`id_ident_1` int(11)
,`fechahorac` datetime
,`af19_155` varchar(125)
,`af19_156` varchar(125)
,`agente` int(11)
);
-- --------------------------------------------------------

--
-- Estructura para la vista `vista_rep_1`
--
DROP TABLE IF EXISTS `vista_rep_1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_rep_1` AS select `ident_1`.`id_ident_1` AS `id_ident_1`,`ident_1`.`fechahorac` AS `fechahorac`,`autof_formulario1_1`.`af19_155` AS `af19_155`,`autof_formulario1_1`.`af19_156` AS `af19_156`,`ident_1`.`agente` AS `agente` from (`autof_formulario1_1` join `ident_1`) where ((`autof_formulario1_1`.`autof_formulario1_1_id` = `ident_1`.`id_ident_1`) and (`autof_formulario1_1`.`af19_155` <> ''));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
