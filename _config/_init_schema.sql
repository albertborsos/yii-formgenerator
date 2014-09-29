



-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'tbl_form_forms'
-- 
-- ---

DROP TABLE IF EXISTS `tbl_form_forms`;
		
CREATE TABLE `tbl_form_forms` (
  `id` INT NULL AUTO_INCREMENT DEFAULT NULL,
  `title` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Megnevezés',
  `name` VARCHAR(160) NULL DEFAULT NULL COMMENT 'name mező',
  `name_replace` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Csere kód',
  `method` VARCHAR(10) NULL DEFAULT NULL COMMENT 'method',
  `action` VARCHAR(160) NULL DEFAULT NULL,
  `class` VARCHAR(100) NULL DEFAULT NULL COMMENT 'class',
  `style` VARCHAR(100) NULL DEFAULT NULL COMMENT 'style',
  `bizlogic` MEDIUMTEXT NULL DEFAULT NULL,
  `message_success` VARCHAR(100) NULL DEFAULT NULL,
  `user_create` INT NULL DEFAULT NULL COMMENT 'Létrehozta',
  `date_create` DATETIME NULL DEFAULT NULL COMMENT 'Létrehozás ideje',
  `user_update` INT NULL DEFAULT NULL COMMENT 'Módosította',
  `date_update` DATETIME NULL DEFAULT NULL COMMENT 'Módosítás ideje',
  `status` VARCHAR(1) NULL DEFAULT NULL COMMENT 'Státusz',
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'tbl_form_inputs'
-- 
-- ---

DROP TABLE IF EXISTS `tbl_form_inputs`;
		
CREATE TABLE `tbl_form_inputs` (
  `id` INT NULL AUTO_INCREMENT DEFAULT NULL,
  `form_id` INT NULL DEFAULT NULL COMMENT 'Form',
  `type` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Típus',
  `model_class` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Model Osztály',
  `model_attribute` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Model mező',
  `name` VARCHAR(100) NULL DEFAULT NULL COMMENT 'name',
  `value` VARCHAR(100) NULL DEFAULT NULL COMMENT 'value',
  `placeholder` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Placeholder',
  `class` VARCHAR(100) NULL DEFAULT NULL,
  `style` VARCHAR(100) NULL DEFAULT NULL,
  `order_num` INT NULL DEFAULT NULL,
  `user_create` INT NULL DEFAULT NULL COMMENT 'Létrehozta',
  `date_create` DATETIME NULL DEFAULT NULL COMMENT 'Létrehozás ideje',
  `user_update` INT NULL DEFAULT NULL COMMENT 'Módosította',
  `date_update` DATETIME NULL DEFAULT NULL COMMENT 'Módosítás ideje',
  `status` VARCHAR(1) NULL DEFAULT NULL COMMENT 'Státusz',
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'tbl_form_datas'
-- 
-- ---

DROP TABLE IF EXISTS `tbl_form_datas`;
		
CREATE TABLE `tbl_form_datas` (
  `id` INT NULL AUTO_INCREMENT DEFAULT NULL,
  `input_id` INT NULL DEFAULT NULL COMMENT 'Beviteli mező',
  `key` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Kulcs',
  `value` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Érték',
  `order_num` INT NULL DEFAULT NULL,
  `user_create` INT NULL DEFAULT NULL COMMENT 'Létrehozta',
  `date_create` DATETIME NULL DEFAULT NULL COMMENT 'Létrehozás ideje',
  `user_update` INT NULL DEFAULT NULL COMMENT 'Módosította',
  `date_update` DATETIME NULL DEFAULT NULL COMMENT 'Módosítás ideje',
  `status` VARCHAR(1) NULL DEFAULT NULL COMMENT 'Státusz',
  PRIMARY KEY (`id`)
);

-- ---
-- Foreign Keys 
-- ---

ALTER TABLE `tbl_form_inputs` ADD FOREIGN KEY (form_id) REFERENCES `tbl_form_forms` (`id`);
ALTER TABLE `tbl_form_datas` ADD FOREIGN KEY (input_id) REFERENCES `tbl_form_inputs` (`id`);

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `tbl_form_forms` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `tbl_form_inputs` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `tbl_form_datas` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `tbl_form_forms` (`id`,`title`,`name`,`name_replace`,`method`,`action`,`class`,`style`,`status`) VALUES
-- ('','','','','','','','','');
-- INSERT INTO `tbl_form_inputs` (`id`,`form_id`,`type`,`model_class`,`model_attribute`,`name`,`value`,`placeholder`,`class`,`style`,`status`) VALUES
-- ('','','','','','','','','','','');
-- INSERT INTO `tbl_form_datas` (`id`,`input_id`,`key`,`value`,`status`) VALUES
-- ('','','','','');

