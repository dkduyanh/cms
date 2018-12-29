-- ALTER TABLE `tbl_users` DROP `user_password_expiry`;
-- ALTER TABLE `tbl_users` ADD `firstname` VARCHAR(255) DEFAULT NULL , ADD `lastname` VARCHAR(255) DEFAULT NULL , ADD `gender` INT DEFAULT NULL;
-- ALTER TABLE `tbl_users` ADD `birthdate` INT DEFAULT NULL , add `phone` varchar(20) default null;
UPDATE `tbl_users` SET `phone` = NULL;
-- ALTER TABLE `tbl_users` ADD `birthplace` varchar(255) DEFAULT NULL;
-- ALTER TABLE `tbl_users` ADD `last_password_changed_date` datetime DEFAULT NULL;
-- ALTER TABLE `tbl_users` ADD `displayname` varchar(255) DEFAULT NULL;
-- ALTER TABLE `tbl_users` ADD `about_me` varchar(255) DEFAULT NULL;
-- ALTER TABLE `tbl_users` ADD `image` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL ;
ALTER TABLE `tbl_users` CHANGE `user_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `user_username` `username` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `user_email` `email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique email of user', CHANGE `user_fullname` `fullname` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Stores full name of user', CHANGE `user_password` `password` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `user_description` `description` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `user_created_date` `created_date` DATETIME NULL DEFAULT NULL, CHANGE `user_last_modified_date` `last_modified_date` DATETIME NULL DEFAULT NULL, CHANGE `user_last_login` `last_login_date` DATETIME NULL DEFAULT NULL, CHANGE `user_last_access` `last_access_date` DATETIME NULL DEFAULT NULL, CHANGE `user_salt` `salt` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '', CHANGE `user_secret_key` `secret_key` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `user_timezone` `timezone` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `user_language` `language` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `user_verified` `verified` TINYINT(1) NULL DEFAULT '0', CHANGE `user_status` `status` TINYINT(4) NOT NULL DEFAULT '-1';
ALTER TABLE `tbl_users` DROP `secret_key`;
ALTER TABLE `tbl_roles` CHANGE `role_id` `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique role ID (Primary Key)', CHANGE `role_code` `code` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Display unique role code', CHANGE `role_name` `name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Display role name', CHANGE `role_description` `description` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Short description of role', CHANGE `role_is_admin` `is_admin` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Administrative role can log in admin panel', CHANGE `role_is_default` `is_default` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Default role for user''s registration';
ALTER TABLE `tbl_user_tokens` CHANGE `token_created_date` `created_date` DATETIME NOT NULL, CHANGE `token_expiry_date` `expiry_date` DATETIME NOT NULL;
UPDATE tbl_users u INNER JOIN tbl_user_profiles p ON u.id = p.user_id
SET
  u.firstname = p.profile_firstname,
  u.lastname = p.profile_lastname,
  u.displayname = p.profile_displayname,
  u.phone = p.profile_phone,
  u.birthdate = p.profile_birthdate,
  u.birthplace = p.profile_birthplace,
  u.gender = p.profile_gender;
DROP TABLE tbl_user_profiles;

UPDATE tbl_users SET password = concat(salt, password), salt = null;
ALTER TABLE `tbl_users` DROP `salt`;



ALTER TABLE `tbl_cms_posts` CHANGE `post_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `post_code` `code` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'This field is used to identify a post (such as URL for the permalinked post page)', CHANGE `post_title` `title` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Title/Headline', CHANGE `post_intro` `intro` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'A short Excerpt, Introduction or Description of post (max 64KB)', CHANGE `post_body` `body` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'The main textual content of this post (max 4GB)', CHANGE `post_filtered_body` `filtered_body` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'The main textual content of this post which is stripped all the html tags, it''s use for search or index content (max 4GB)', CHANGE `post_image` `image` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Display the ID (managed by media library) or URL/Path of other single image that associates with post', CHANGE `post_image_alt` `image_alt` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `post_created_date` `created_date` DATETIME NULL DEFAULT NULL COMMENT 'The creation date and time', CHANGE `post_creator_id` `creator_id` INT(11) NULL DEFAULT NULL, CHANGE `post_last_modified_date` `last_modified_date` DATETIME NULL DEFAULT NULL, CHANGE `post_last_modifier_id` `last_modifier_id` INT(11) NULL DEFAULT NULL, CHANGE `post_published_date` `published_date` DATETIME NULL DEFAULT NULL, CHANGE `post_expiry_date` `expiry_date` DATETIME NULL DEFAULT NULL, CHANGE `post_average_rating` `average_rating` DECIMAL(10,0) NULL DEFAULT '0', CHANGE `post_view_count` `view_count` INT(11) NULL DEFAULT '0', CHANGE `post_like_count` `like_count` INT(11) NULL DEFAULT '0', CHANGE `post_dislike_count` `dislike_count` INT(11) NULL DEFAULT '0', CHANGE `post_comment_count` `comment_count` INT(11) NULL DEFAULT '0', CHANGE `post_allow_comment` `allow_comment` TINYINT(1) NULL DEFAULT '0', CHANGE `post_allow_search` `allow_search` TINYINT(1) NULL DEFAULT '1', CHANGE `post_privacy` `privacy` INT(1) NULL DEFAULT NULL, CHANGE `post_is_sticky` `is_sticky` TINYINT(1) NULL DEFAULT '0', CHANGE `post_parent` `parent_id` INT(11) NULL DEFAULT NULL, CHANGE `post_position` `position` INT(11) NULL DEFAULT NULL, CHANGE `post_status` `status` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `post_data` `data` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `tbl_cms_posts` CHANGE `data` `settings` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Stores data that related with post such as display format(image, color, html class...), configurations, meta data... and should be stored in json or serialized format';
ALTER TABLE `tbl_cms_post_field` CHANGE `field_value` `value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_cms_comments` CHANGE `comment_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `comment_title` `title` VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Title of comment', CHANGE `comment_body` `body` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'The textual content of this comment', CHANGE `comment_created_date` `created_date` DATETIME NULL DEFAULT NULL COMMENT 'The creation date and time', CHANGE `comment_creator_id` `creator_id` INT(11) NULL DEFAULT NULL COMMENT 'User who creates this comment', CHANGE `comment_creator_name` `creator_name` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Name of user who creates this comment but has not been a member (when comment_creator_id is null)', CHANGE `comment_creator_email` `creator_email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Email of user who who creates this comment but has not been a member', CHANGE `comment_creator_ip` `creator_ip` VARCHAR(39) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'IP address of user who who creates this comment but has not been a member', CHANGE `comment_last_modified_date` `last_modified_date` DATETIME NULL DEFAULT NULL COMMENT 'Last modification date and time', CHANGE `comment_last_modifier_id` `last_modifier_id` INT(11) NULL DEFAULT NULL COMMENT 'Last user who modify this comment', CHANGE `comment_like_count` `like_count` INT(11) NOT NULL DEFAULT '0', CHANGE `comment_dislike_count` `dislike_count` INT(11) NOT NULL DEFAULT '0', CHANGE `comment_parent` `parent_id` INT(11) NULL DEFAULT NULL COMMENT 'Parent comment ID. Determines the place of this comment in hierarchical tree', CHANGE `comment_status` `status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '[-3]: trash/deleted, [-2]: draft, [-1]: pending for approval, [0]: inactived, [1]: published';
ALTER TABLE `tbl_cms_categories` CHANGE `category_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `category_code` `code` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'An unique code of category, used in URLs or used for identifying category', CHANGE `category_name` `name` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Title of cateogry', CHANGE `category_description` `description` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'A short description of category', CHANGE `category_created_date` `created_date` DATETIME NULL DEFAULT NULL COMMENT 'The creation date and time', CHANGE `category_creator_id` `creator_id` INT(11) NULL DEFAULT NULL COMMENT 'User who create this category', CHANGE `category_last_modified_date` `last_modified_date` DATETIME NULL DEFAULT NULL COMMENT 'Last modification date and time', CHANGE `category_last_modifier_id` `last_modifier_id` INT(11) NULL DEFAULT NULL COMMENT 'Last user who modify this category', CHANGE `category_position` `position` INT(11) NULL DEFAULT NULL COMMENT 'Display position of this category among others within the same level in  hierarchical tree', CHANGE `category_is_sticky` `is_sticky` TINYINT(1) NULL DEFAULT '0' COMMENT 'Allow to pin this category to top/homepage', CHANGE `category_parent` `parent_id` INT(11) NULL DEFAULT NULL COMMENT 'Parent category ID. Determines the place of this category in hierarchical tree', CHANGE `category_status` `status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '[0]: disabled, [1]: enabled', CHANGE `category_data` `data` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Stores data (in json or serialized format) that related with category such as display format(image, color, html class...), configurations...';
ALTER TABLE `tbl_cms_categories` CHANGE `data` `settings` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Stores data (in json or serialized format) that related with category such as display format(image, color, html class...), configurations...';
ALTER TABLE `tbl_cms_categories` ADD `image` VARCHAR(256) NOT NULL , ADD `image_alt` VARCHAR(256) NOT NULL ;
ALTER TABLE `tbl_cms_fields` CHANGE `field_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `field_code` `code` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Stores the unique code which is used to identify a field', CHANGE `field_name` `name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Display the field name', CHANGE `field_description` `description` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Display the short description or caption of field', CHANGE `field_attributes` `attributes` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Stores attributes (also called properties) which provide additional information about field, it may be input type, data type, max-length, default value... and should be store in json format', CHANGE `field_group` `group` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Group related fields in a form', CHANGE `field_position` `position` INT(11) NULL DEFAULT NULL COMMENT 'Display position of this field among others within the same type';
ALTER TABLE `tbl_cms_fields` CHANGE `attributes` `settings` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Stores attributes (also called properties) which provide additional information about field, it may be input type, data type, max-length, default value... and should be store in json format';
ALTER TABLE `tbl_cms_tags` CHANGE `tag_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `tag_name` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique tag name', CHANGE `tag_weight` `weight` INT(11) NOT NULL DEFAULT '0' COMMENT 'Display the significance of this tag or the number of posts concerned with it';
ALTER TABLE `tbl_cms_types` CHANGE `type_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `type_code` `code` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique code of type', CHANGE `type_name` `name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Display the name of type', CHANGE `type_description` `description` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'A short description of type';


ALTER TABLE `tbl_cms_media_files` CHANGE `file_id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT, CHANGE `folder_id` `folder_id` INT(11) NULL DEFAULT NULL, CHANGE `file_name` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Display name of file', CHANGE `file_description` `description` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'A short description of media file', CHANGE `file_path` `path` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Remote URL or path of file', CHANGE `file_content` `content` LONGBLOB NULL DEFAULT NULL COMMENT 'File content in binary code', CHANGE `file_size` `size` DOUBLE NULL DEFAULT NULL COMMENT 'Size of file in Kilobyte', CHANGE `file_extension` `extension` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'File extension', CHANGE `file_mime` `mime` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'MIME type', CHANGE `file_hash` `hash` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Store hash value of file with algorithms such as SHA512 (128 chars), SHA256(64 chars), SHA1(40 chars) MD5 (32 chars). In case of using many hash methods: SHA1_xxx, MD5_xxx', CHANGE `file_metadata` `metadata` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Store file metadata (attributes) such as EXIF, ID3-TAG...', CHANGE `file_created_date` `created_date` DATETIME NULL DEFAULT NULL COMMENT 'The creation date and time', CHANGE `file_creator_id` `creator_id` INT(11) NULL DEFAULT NULL COMMENT 'User who uploaded this file', CHANGE `file_last_modified_date` `last_modified_date` DATETIME NULL DEFAULT NULL COMMENT 'Last modification date and time', CHANGE `file_last_modifier_id` `last_modifier_id` INT(11) NULL DEFAULT NULL COMMENT 'Last user who modify information of this file', CHANGE `file_is_visible` `is_visible` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Mark if this is hidden or visible file', CHANGE `file_is_locked` `is_locked` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Mark if file is writable or not? If true, this file can not be modified, deleted, or moved to another folder', CHANGE `file_position` `position` INT(11) NULL DEFAULT NULL COMMENT 'Display position of this FILE among others within the same folder', CHANGE `file_src` `is_remote` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Specify the source of media, [0]: extenal media [1]: interal media';
ALTER TABLE `tbl_cms_media_folders` CHANGE `folder_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `folder_name` `name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `folder_created_date` `created_date` DATETIME NULL DEFAULT NULL, CHANGE `folder_last_modified_date` `last_modified_date` DATETIME NULL DEFAULT NULL, CHANGE `folder_is_visible` `is_visible` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Mark if this is hidden or visible folder', CHANGE `file_is_locked` `is_locked` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Mark if folder is writable or not? If true, this folder can not be modified, deleted, or moved to another folder', CHANGE `folder_position` `position` INT(11) NULL DEFAULT NULL COMMENT 'Display position of this folder among others within the same level in  hierarchical tree', CHANGE `folder_parent` `parent_id` INT(11) NULL DEFAULT NULL;
CREATE TABLE `tbl_cms_media` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` double DEFAULT NULL,
  `extension` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hash` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `metadata` text COLLATE utf8_unicode_ci,
  `creator_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_modifier_id` int(11) DEFAULT NULL,
  `last_modified_date` datetime DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL,
  `is_locked` tinyint(1) NOT NULL,
  `position` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`parent_id`,`name`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO tbl_cms_media (id, parent_id, `name`, `mime`, created_date, last_modified_date, is_visible, is_locked) SELECT id, parent_id, `name`, 'directory', created_date, last_modified_date, is_visible, is_locked FROM tbl_cms_media_folders;
INSERT INTO tbl_cms_media (parent_id, `name`, `content_path`, `size`, extension, hash, created_date, creator_id, is_visible, is_locked) SELECT folder_id as parent_id, `name`, path, `size`, extension, hash, created_date, creator_id, is_visible, is_locked  FROM tbl_cms_media_files;
DROP TABLE `tbl_cms_media_files`;
DROP TABLE `tbl_cms_media_folders`;


ALTER TABLE `tbl_menu` CHANGE `menu_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `menu_code` `code` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique code of menu', CHANGE `menu_name` `name` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'The text displayed for menu', CHANGE `menu_description` `description` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'A short description of menu', CHANGE `menu_status` `status` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '[0: Inactive], [1: Active]', CHANGE `menu_data` `data` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Stores data that related with menu such as display format(image, color, html class...), configurations..., and should be stored in json or serialized format';
ALTER TABLE `tbl_menu_items` CHANGE `item_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `item_title` `title` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'The text displayed for the link', CHANGE `item_image` `image` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'The icon displayed for the link', CHANGE `item_link` `link` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'The external path this link points to.', CHANGE `item_description` `description` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'A short description of the link', CHANGE `item_linktarget` `target` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Specifies where to open the linked document', CHANGE `item_position` `position` INT(11) NULL DEFAULT NULL COMMENT 'The ordinal position of items within the same level in  hierarchical tree', CHANGE `item_parent` `parent_id` INT(11) NULL DEFAULT NULL COMMENT 'Parent item ID. Determines the place of this item in hierarchical tree', CHANGE `item_status` `status` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '[0: Inactive], [1: Active]', CHANGE `item_data` `data` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Stores data that related with link such as display format(image, color, html class...), configurations..., and should be stored in json or serialized format';
ALTER TABLE `tbl_menu` CHANGE `data` `settings` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Stores data that related with menu such as display format(image, color, html class...), configurations..., and should be stored in json or serialized format';
ALTER TABLE `tbl_menu_items` CHANGE `data` `settings` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Stores data that related with link such as display format(image, color, html class...), configurations..., and should be stored in json or serialized format';
ALTER TABLE `tbl_menu_items` CHANGE `title` `name` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'The text displayed for the link';
ALTER TABLE `tbl_cache` CHANGE `cache_id` `key` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `cache_data` `data` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `cache_created_time` `created_date` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, CHANGE `cache_expiry_time` `expiry_date` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `tbl_languages` DROP `language_description`;
ALTER TABLE `tbl_languages` CHANGE `language_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `language_code` `code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique code of language', CHANGE `language_name` `name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Display the name of language', CHANGE `language_nativename` `nativename` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'Display the native name of language such as English, Ti?ng Vi?t', CHANGE `language_direction` `direction` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Specifies direction of language (Left-to-Right = 0, Right-to-Left = 1)', CHANGE `language_default` `is_default` TINYINT(1) NULL DEFAULT '0' COMMENT 'Specifies which language is loaded when the system started';
ALTER TABLE `tbl_email_templates` CHANGE `template_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `template_code` `code` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique code of template', CHANGE `template_name` `name` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Display name of template', CHANGE `template_description` `description` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'A short description of template', CHANGE `template_subject` `subject` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Specifies email`s subject', CHANGE `template_body` `body` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Specifies textual content of email', CHANGE `template_sender_email` `sender_email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Specifies sender`s email', CHANGE `template_sender_name` `sender_name` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Specifies sender`s name', CHANGE `template_allow_delete` `allow_delete` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Indicates that this is a template which is used by system and can not be deleted';


RENAME TABLE `tbl_logs` TO `tbl_activity_log`;
ALTER TABLE `tbl_activity_log` DROP `log_data`, DROP `log_group`;
ALTER TABLE `tbl_activity_log` ADD `type` VARCHAR(50) NOT NULL ;
ALTER TABLE `tbl_activity_log` ADD `user_name` VARCHAR(256) NOT NULL , ADD `ref_name` VARCHAR(256) NOT NULL ;
ALTER TABLE `tbl_activity_log` CHANGE `log_id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT, CHANGE `user_id` `user_id` INT(11) NULL DEFAULT NULL, CHANGE `user_ip` `ip` VARCHAR(39) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `user_agent` `user_agent` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `ref_id` `ref_id` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `log_time` `created_date` DATETIME NULL DEFAULT NULL, CHANGE `log_action` `action` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `log_message` `message` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_activity_log` CHANGE `ref_name` `ref_type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;


RENAME TABLE `tbl_cms_sentiments` TO `tbl_user_sentiments`;
ALTER TABLE `tbl_user_sentiments` CHANGE `like` `value` TINYINT(1) NULL DEFAULT NULL COMMENT '[0] Unlike [1] Like [-1] Dislike';
ALTER TABLE `tbl_user_sentiments` CHANGE `ref_type` `ref_type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_user_sentiments` COMMENT = 'Store user''s sentiments';
ALTER TABLE `tbl_user_sentiments` CHANGE `like_date` `last_modified_date` DATETIME NULL DEFAULT NULL;


RENAME TABLE `tbl_settings` TO `tbl_configuration`;
ALTER TABLE `tbl_configuration` CHANGE `setting_code` `code` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `setting_value` `value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_configuration` DROP `setting_description`, DROP `setting_maxlength`, DROP `setting_data_type`, DROP `setting_input_type`, DROP `setting_meta_data`, DROP `setting_position`, DROP `setting_group`;
ALTER TABLE `tbl_configuration` ADD `autoload` INT NOT NULL DEFAULT '0' AFTER `value`;


DROP TABLE IF EXISTS `tbl_privilege_actions`;
CREATE TABLE `tbl_privilege_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Defines the actions a user or role can perform on a resource';

DROP TABLE IF EXISTS `tbl_privileges`;
CREATE TABLE `tbl_privileges` (
  `actor_ref_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `actor_ref_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `object_ref_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `object_ref_id` int(11) NOT NULL,
  `allow` tinyint(1) NOT NULL,
  PRIMARY KEY (`actor_ref_type`,`actor_ref_id`,`action_id`,`object_ref_type`,`object_ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO tbl_privilege_actions SELECT permission_id, permission_code, permission_name, permission_description, module as group_name FROM tbl_auth_permissions;


INSERT INTO tbl_privileges
SELECT 'user', user_id, permission_id, r.ref_type, r.ref_id, rule
FROM tbl_auth_user_assignment ua
	INNER JOIN tbl_auth_resources r ON r.resource_id = ua.resource_id;

INSERT INTO tbl_privileges
SELECT 'role', role_id, permission_id, r.ref_type, r.ref_id, rule
FROM tbl_auth_role_assignment ra
	INNER JOIN tbl_auth_resources r ON r.resource_id = ra.resource_id;


CREATE TABLE `tbl_privileges_copy` (
  `actor_ref_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `actor_ref_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `object_ref_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `object_ref_id` int(11) NOT NULL,
  `allow` tinyint(1) NOT NULL,
  PRIMARY KEY (`actor_ref_type`,`actor_ref_id`,`action_id`,`object_ref_type`,`object_ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert tbl_privileges_copy 
select DISTINCT A.actor_ref_type, A.actor_ref_id, A.action_id, 'cms_category', B.category_id, allow  from tbl_privileges A 
JOIN tbl_cms_post_category B on post_id = object_ref_id
where object_ref_type = 'post' and actor_ref_type = 'user';


insert tbl_privileges_copy 
select DISTINCT A.actor_ref_type, A.actor_ref_id, A.action_id, 'cms_category', B.category_id, allow  from tbl_privileges A 
JOIN tbl_cms_post_category B on post_id = object_ref_id
where object_ref_type = 'post' and actor_ref_type = 'role';

ALTER TABLE tbl_auth_role_assignment DROP FOREIGN KEY tbl_auth_role_assignment_ibfk_1;
ALTER TABLE tbl_auth_role_assignment DROP FOREIGN KEY tbl_auth_role_assignment_ibfk_2;
ALTER TABLE tbl_auth_role_assignment DROP FOREIGN KEY tbl_auth_role_assignment_ibfk_3;
ALTER TABLE tbl_auth_user_assignment DROP FOREIGN KEY tbl_auth_user_assignment_ibfk_1;
ALTER TABLE tbl_auth_user_assignment DROP FOREIGN KEY tbl_auth_user_assignment_ibfk_2;
ALTER TABLE tbl_auth_user_assignment DROP FOREIGN KEY tbl_auth_user_assignment_ibfk_3;

DROP TABLE IF EXISTS `tbl_auth_role_assignment`;
DROP TABLE IF EXISTS `tbl_auth_user_assignment`;
DROP TABLE IF EXISTS `tbl_auth_permissions`;
DROP TABLE IF EXISTS `tbl_auth_resources`;


/*
(
	SELECT `tbl_privileges`.* 
	FROM `tbl_privileges` INNER JOIN `tbl_privilege_actions` ON `tbl_privileges`.`action_id` = `tbl_privilege_actions`.`id` 
	WHERE (`code`='read') AND (`object_ref_type`='post') AND (`object_ref_id`='170') AND ((`actor_ref_type`='user') AND (`actor_ref_id`=1))
) UNION ( 
	SELECT `tbl_privileges`.* 
	FROM `tbl_privileges` INNER JOIN `tbl_privilege_actions` ON `tbl_privileges`.`action_id` = `tbl_privilege_actions`.`id` 
	WHERE (`code`='read') AND (`object_ref_type`='post') AND (`object_ref_id`='170') AND ((`actor_ref_type`='role') AND (`actor_ref_id`=2)) 
)



select if(sum(allow) > 0, 1, 0) as allow
from (
 (
  SELECT `tbl_privileges`.* 
  FROM `tbl_privileges` INNER JOIN `tbl_privilege_actions` ON `tbl_privileges`.`action_id` = `tbl_privilege_actions`.`id` 
  WHERE (`code`='read') AND (`object_ref_type`='post') AND (`object_ref_id`='170') AND ((`actor_ref_type`='user') AND (`actor_ref_id`=1))
 ) UNION ( 
  SELECT `tbl_privileges`.* 
  FROM `tbl_privileges` INNER JOIN `tbl_privilege_actions` ON `tbl_privileges`.`action_id` = `tbl_privilege_actions`.`id` 
  WHERE (`code`='read') AND (`object_ref_type`='post') AND (`object_ref_id`='170') AND ((`actor_ref_type`='role') AND (FIND_IN_SET(`actor_ref_id`, '1,2,3'))) 
 )   
) as t
group by actor_ref_type
order by actor_ref_type DESC 
limit 1
*/




