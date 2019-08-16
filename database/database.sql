SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `octres` DEFAULT CHARACTER SET latin1 ;
USE `octres` ;

-- -----------------------------------------------------
-- Table `octres`.`clients`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`clients` (
  `id_client` INT NOT NULL AUTO_INCREMENT ,
  `client_name` VARCHAR(45) NULL ,
  `client_description` TEXT NULL ,
  PRIMARY KEY (`id_client`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `octres`.`module_permissions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`module_permissions` (
  `id_permission` INT NOT NULL AUTO_INCREMENT ,
  `idgroup` INT NULL ,
  `id_page` INT NULL ,
  `id_campaign` INT NULL ,
  `page_permissions` VARCHAR(255) NULL ,
  PRIMARY KEY (`id_permission`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `octres`.`groups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`groups` (
  `id_group` INT NOT NULL AUTO_INCREMENT ,
  `group_name` VARCHAR(45) NULL ,
  `description` TEXT NULL ,
  `idclient` VARCHAR(45) NULL ,
  PRIMARY KEY (`id_group`) ,
  INDEX `fk_grupos_clientes1` (`idclient` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `octres`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`users` (
  `id_user` INT NOT NULL AUTO_INCREMENT ,
  `names` VARCHAR(45) NULL ,
  `user` VARCHAR(45) NULL ,
  `password` VARCHAR(45) NULL ,
  `lang` VARCHAR(5) NULL ,
  `idgroup` INT NULL ,
  PRIMARY KEY (`id_user`) ,
  UNIQUE INDEX `id_usuario_UNIQUE` (`id_user` ASC) ,
  INDEX `fk_usuarios_grupos` (`idgroup` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `octres`.`projects`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`projects` (
  `id_project` INT NOT NULL AUTO_INCREMENT ,
  `project_name` VARCHAR(45) NULL ,
  `project_description` VARCHAR(45) NULL ,
  `idclient` INT NULL ,
  PRIMARY KEY (`id_project`) ,
  INDEX `fk_proyectos_clientes1` (`idclient` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `octres`.`autoform_config`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`autoform_config` (
  `id_autoform_config` INT(11) NOT NULL AUTO_INCREMENT ,
  `labelcampo` VARCHAR(45) NULL DEFAULT NULL ,
  `nombrecampo` VARCHAR(45) NULL DEFAULT NULL ,
  `poscampo` VARCHAR(45) NULL DEFAULT NULL ,
  `tipocampo` VARCHAR(10) NOT NULL ,
  `requerido` VARCHAR(45) NOT NULL DEFAULT 0 ,
  `historial` INT NULL DEFAULT 0 ,
  `paramcampo` TINYTEXT NOT NULL ,
  `generado` INT NULL ,
  `eliminado` INT NULL DEFAULT 0 ,
  `idgrupo` VARCHAR(255) NOT NULL ,
  `idtabla_rel` INT(11) NOT NULL ,
  PRIMARY KEY (`id_autoform_config`) )
ENGINE = MyISAM
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `octres`.`autoform_grupos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`autoform_grupos` (
  `id_autoformgrupos` INT(11) NOT NULL AUTO_INCREMENT ,
  `labelgrupo` VARCHAR(255) NOT NULL ,
  `posiciongrupo` INT(11) NOT NULL ,
  `visiblegrupo` INT(11) NOT NULL ,
  `usrpermisos` VARCHAR(255) NOT NULL ,
  `idtabla_rel` INT(11) NOT NULL ,
  PRIMARY KEY (`id_autoformgrupos`) )
ENGINE = MyISAM
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `octres`.`autoform_tablas`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`autoform_tablas` (
  `id_autoformtablas` INT(11) NOT NULL AUTO_INCREMENT ,
  `labeltabla` VARCHAR(45) NOT NULL ,
  `nombretabla` VARCHAR(45) NULL DEFAULT NULL ,
  `campoid` VARCHAR(40) NOT NULL ,
  `tipotabla` INT NULL COMMENT 'este campo define si es para administrar varias tablas o si es un formulario de una campana.' ,
  `campaignid` INT NULL COMMENT 'este table es la relacion con una campana' ,
  `descripcion` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id_autoformtablas`) )
ENGINE = MyISAM
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `octres`.`campaigns`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`campaigns` (
  `id_campaign` INT NOT NULL AUTO_INCREMENT ,
  `campaign_name` VARCHAR(45) NULL ,
  `campaign_description` TEXT NULL ,
  `campaign_type` INT NULL ,
  `idproject` INT NULL ,
  PRIMARY KEY (`id_campaign`) ,
  INDEX `fk_campanas_proyectos1` (`idproject` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `octres`.`campaign_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`campaign_type` (
  `id_campaign_type` INT NOT NULL AUTO_INCREMENT ,
  `campaign_type_name` VARCHAR(45) NULL ,
  `campaign_type_description` TEXT NULL ,
  PRIMARY KEY (`id_campaign_type`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `octres`.`page_modules`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`page_modules` (
  `id_page_module` INT NOT NULL AUTO_INCREMENT ,
  `page_title` VARCHAR(45) NULL ,
  `modulegroup` VARCHAR(255) NULL ,
  `module_folder` VARCHAR(45) NULL ,
  `module_file` VARCHAR(45) NULL ,
  `module_permission` VARCHAR(255) NULL ,
  PRIMARY KEY (`id_page_module`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `octres`.`permisos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`permisos` (
  `id_permiso` INT NOT NULL AUTO_INCREMENT ,
  `idgrupo` INT NULL DEFAULT NULL ,
  `id_pagina` INT NULL DEFAULT NULL ,
  `id_campana` INT NULL DEFAULT NULL ,
  `permisos_paginas` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id_permiso`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `octres`.`agents`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`agents` (
  `name` VARCHAR(255) NULL ,
  `reportsid` VARCHAR(255) NULL ,
  `number` INT NULL ,
  `password` INT NULL ,
  `extension` INT NULL ,
  `idagents_group` INT NULL ,
  `id_agents` INT NOT NULL ,
  PRIMARY KEY (`id_agents`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `octres`.`agents_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`agents_group` (
  `name` VARCHAR(255) NULL ,
  `description` TINYTEXT NULL ,
  `id_agents_group` INT NOT NULL ,
  PRIMARY KEY (`id_agents_group`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `octres`.`rep_campos_cfg`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`rep_campos_cfg` (
  `idrep_campos_cfg` INT NOT NULL ,
  `tabla` VARCHAR(45) NULL ,
  `nombre_campo` VARCHAR(45) NULL ,
  `mostrar` INT NULL ,
  `valor_comparar` VARCHAR(255) NULL ,
  `id_reporte` INT NULL ,
  PRIMARY KEY (`idrep_campos_cfg`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `octres`.`rep_reportes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `octres`.`rep_reportes` (
  `idrep_reportes` INT NOT NULL AUTO_INCREMENT ,
  `nombre_reporte` VARCHAR(45) NULL ,
  `id_cam` INT NULL ,
  `condiciones` TEXT NULL ,
  PRIMARY KEY (`idrep_reportes`) )
ENGINE = MyISAM;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
