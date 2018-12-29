
CREATE TABLE IF NOT EXISTS `tbl_cms_type_field` (
  `type_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `default_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `tbl_cms_type_field` ADD PRIMARY KEY (`type_id`,`field_id`);
ALTER TABLE `tbl_cms_type_field` ADD FOREIGN KEY (`type_id`) REFERENCES `tbl_cms_types`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_cms_type_field` ADD FOREIGN KEY (`field_id`) REFERENCES `tbl_cms_fields`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO tbl_cms_type_field(field_id, type_id) SELECT id AS field_id, type_id FROM tbl_cms_fields;

ALTER TABLE `tbl_cms_fields` CHANGE `type_id` `type_id` INT(11) NULL;
UPDATE tbl_cms_fields SET type_id = NULL;

ALTER TABLE `tbl_cms_fields` DROP FOREIGN KEY tbl_cms_fields_ibfk_1;
ALTER TABLE tbl_cms_fields DROP INDEX `code`;
-- ALTER TABLE tbl_cms_fields DROP INDEX `type_id`;
ALTER TABLE `tbl_cms_fields` DROP `type_id`;



ALTER TABLE `tbl_cms_posts` CHANGE `settings` `extras` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `tbl_cms_categories` CHANGE `settings` `extras` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;


ALTER TABLE `tbl_cms_types` 
	ADD `show_title` BOOLEAN DEFAULT TRUE , 
	ADD `show_intro` BOOLEAN DEFAULT TRUE , 
	ADD `show_image` BOOLEAN DEFAULT TRUE , 
	ADD `show_image_alt` BOOLEAN DEFAULT TRUE , 
	ADD `show_body` BOOLEAN DEFAULT TRUE , 
	ADD `show_categories` BOOLEAN DEFAULT TRUE ,
	ADD `show_tags` BOOLEAN DEFAULT TRUE ;
	

ALTER TABLE `tbl_menu` CHANGE `settings` `extras` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `tbl_menu_items` ADD `type` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL AFTER `id`;
ALTER TABLE `tbl_menu_items` ADD `ref_type` VARCHAR(50) NULL AFTER `image`, ADD `ref_id` BIGINT NULL AFTER `ref_type`;
ALTER TABLE `tbl_menu_items` CHANGE `settings` `extras` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;


ALTER TABLE `tbl_languages` ADD `image` VARCHAR(255) NULL DEFAULT NULL AFTER `direction`;
ALTER TABLE `tbl_languages` ADD `position` INT NULL DEFAULT '0' AFTER `is_default`;
ALTER TABLE `tbl_cms_posts` ADD `language` VARCHAR(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `tbl_users` DROP `type_id`;