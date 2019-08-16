--
-- Table structure for table `repgraf_campos_cfg`
--

CREATE TABLE IF NOT EXISTS `repgraf_campos_cfg` (
  `idrepgraf_campos_cfg` int(11) NOT NULL,
  `tabla` varchar(45) default NULL,
  `nombre_campo` varchar(45) default NULL,
  `mostrar` int(11) default NULL,
  `valor_comparar` varchar(255) default NULL,
  `id_reporte` int(11) default NULL,
  PRIMARY KEY  (`idrepgraf_campos_cfg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `repgraf_compare`
--

CREATE TABLE IF NOT EXISTS `repgraf_compare` (
  `campo` varchar(255) NOT NULL,
  `condicion` varchar(2) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `idrelconfig` int(11) NOT NULL,
  `id_compare` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_compare`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `repgraf_config`
--

CREATE TABLE IF NOT EXISTS `repgraf_config` (
  `nombre` varchar(255) NOT NULL,
  `id_cam` int(11) NOT NULL,
  `id_form` int(11) NOT NULL,
  `id_rep` int(11) NOT NULL auto_increment,
  KEY `id_rep` (`id_rep`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `repgraf_datashow`
--

CREATE TABLE IF NOT EXISTS `repgraf_datashow` (
  `valor` varchar(255) NOT NULL,
  `identificador` varchar(255) NOT NULL,
  `ncampo` varchar(10) NOT NULL,
  `id_rep` int(11) NOT NULL,
  `id_datashow` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id_datashow`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `repgraf_reportes`
--

CREATE TABLE IF NOT EXISTS `repgraf_reportes` (
  `idrepgraf_reportes` int(11) NOT NULL auto_increment,
  `nombre_reporte` varchar(45) default NULL,
  `tablas` varchar(255) NOT NULL,
  `camposcom` tinytext NOT NULL,
  `camposmos` tinytext NOT NULL,
  `agente` int(11) NOT NULL,
  `id_cam` int(11) default NULL,
  `condiciones` text,
  PRIMARY KEY  (`idrepgraf_reportes`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
