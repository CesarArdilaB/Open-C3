 CREATE TABLE `asteriskcdrdb`.`openc3_calls` (
`id_ocalls` INT NOT NULL AUTO_INCREMENT ,
`uniqueid` VARCHAR( 32 ) NOT NULL ,
`id_registro` INT NOT NULL ,
`id_campana` INT NOT NULL ,
`nombrecampo` VARCHAR( 100 ) NOT NULL ,
PRIMARY KEY ( `id_ocalls` ) ,
INDEX ( `id_ocalls` )
) ENGINE = MYISAM 