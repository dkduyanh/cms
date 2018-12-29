/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : test2

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-05-09 09:41:28
*/

SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `tbl_cronjobs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `command` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `interval` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `next_run_date` datetime NOT NULL,  
  `last_run_date` datetime DEFAULT NULL,
  `last_run_result` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `creator_id` int(11) unsigned DEFAULT NULL,
  `last_modified_date` datetime DEFAULT NULL,
  `last_modifier_id` int(11) unsigned DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tbl_cronjob_log` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`cronjob_id` int(11) unsigned NOT NULL,
	`start_time` double NOT NULL,
	`end_time` double NOT NULL,
	`status` tinyint(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tbl_acl_permissions
-- ----------------------------
DROP TABLE IF EXISTS `tbl_acl_permissions`;
CREATE TABLE `tbl_acl_permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`,`category`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tbl_acl_role_permission
-- ----------------------------
DROP TABLE IF EXISTS `tbl_acl_role_permission`;
CREATE TABLE `tbl_acl_role_permission` (
  `role_id` int(11) unsigned NOT NULL,
  `permission_id` int(11) unsigned NOT NULL,
  `allow` tinyint(1) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tbl_acl_user_permission
-- ----------------------------
DROP TABLE IF EXISTS `tbl_acl_user_permission`;
CREATE TABLE `tbl_acl_user_permission` (
  `user_id` int(11) unsigned NOT NULL,
  `permission_id` int(11) unsigned NOT NULL,
  `allow` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tbl_cache
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cache`;
CREATE TABLE `tbl_cache` (
  `key` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` double NOT NULL,
  `data` blob,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores cache data';

-- ----------------------------
-- Table structure for tbl_cms_categories
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_categories`;
CREATE TABLE `tbl_cms_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'An unique code of category, used in URLs or used for identifying category',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Title of cateogry',
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'A short description of category',
  `created_date` datetime DEFAULT NULL COMMENT 'The creation date and time',
  `creator_id` int(11) unsigned DEFAULT NULL COMMENT 'User who create this category',
  `last_modified_date` datetime DEFAULT NULL COMMENT 'Last modification date and time',
  `last_modifier_id` int(11) unsigned DEFAULT NULL COMMENT 'Last user who modify this category',
  `image` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display the ID (managed by media library) or URL/Path of other single image that associates with category',
  `image_alt` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display alternative text (for ALT attribute in the HTML image tag) or the ID or URL/Path of alternative file/image',
  `position` int(11) DEFAULT NULL COMMENT 'Display position of this category among others within the same level in  hierarchical tree',
  `is_sticky` tinyint(1) DEFAULT '0' COMMENT 'Allow to pin this category to top/homepage',
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Parent category ID. Determines the place of this category in hierarchical tree',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '[0]: disabled, [1]: enabled',
  `extras` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Stores data (in json or serialized format) that related with category such as display format(image, color, html class...), configurations...',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`) USING BTREE,
  KEY `parent_id` (`parent_id`,`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores defined groups of related posts but broader than tags';

-- ----------------------------
-- Table structure for tbl_cms_comments
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_comments`;
CREATE TABLE `tbl_cms_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned NOT NULL,
  `title` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Title of comment',
  `body` text COLLATE utf8mb4_unicode_ci COMMENT 'The textual content of this comment',
  `created_date` datetime DEFAULT NULL COMMENT 'The creation date and time',
  `creator_id` int(11) unsigned DEFAULT NULL COMMENT 'User who creates this comment',
  `creator_name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Name of user who creates this comment but has not been a member (when comment_creator_id is null)',
  `creator_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Email of user who who creates this comment but has not been a member',
  `creator_ip` varchar(39) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'IP address of user who who creates this comment but has not been a member',
  `last_modified_date` datetime DEFAULT NULL COMMENT 'Last modification date and time',
  `last_modifier_id` int(11) unsigned DEFAULT NULL COMMENT 'Last user who modify this comment',
  `like_count` int(11) unsigned NOT NULL DEFAULT '0',
  `dislike_count` int(11) unsigned NOT NULL DEFAULT '0',
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Parent comment ID. Determines the place of this comment in hierarchical tree',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '[-3]: trash/deleted, [-2]: draft, [-1]: pending for approval, [0]: inactived, [1]: published',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `post_id` (`post_id`,`status`) USING BTREE,
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores the comments of posts';

-- ----------------------------
-- Table structure for tbl_cms_fields
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_fields`;
CREATE TABLE `tbl_cms_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Stores the unique code which is used to identify a field',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Display the field name',
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display the short description or caption of field',
  `field_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_required` tinyint(1) DEFAULT '0',
  `default_value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hint` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Group related fields in a form',
  `position` int(11) DEFAULT NULL COMMENT 'Display position of this field among others within the same group',
  `settings` text COLLATE utf8mb4_unicode_ci COMMENT 'Stores settings which provides additional information to display field, it may be type of input, max-length, default value... and should be store in json format',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores user defined post fields and their attributes';

-- ----------------------------
-- Table structure for tbl_cms_media
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_media`;
CREATE TABLE `tbl_cms_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longblob,
  `size` double unsigned DEFAULT NULL,
  `extension` varchar(10) CHARACTER SET ascii DEFAULT NULL,
  `mime` varchar(255) CHARACTER SET ascii DEFAULT NULL,
  `hash` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` text COLLATE utf8mb4_unicode_ci,
  `creator_id` int(11) unsigned DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_modifier_id` int(11) unsigned DEFAULT NULL,
  `last_modified_date` datetime DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL,
  `is_locked` tinyint(1) NOT NULL,
  `position` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`parent_id`,`name`) USING BTREE,
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tbl_cms_media_attachments
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_media_attachments`;
CREATE TABLE `tbl_cms_media_attachments` (
  `media_id` int(11) unsigned NOT NULL,
  `ref_type` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`media_id`,`ref_type`,`ref_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tbl_cms_posts
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_posts`;
CREATE TABLE `tbl_cms_posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(11) unsigned NOT NULL,
  `code` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'This field is used to identify a post (such as URL for the permalinked post page)',
  `title` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Title/Headline',
  `intro` text COLLATE utf8mb4_unicode_ci COMMENT 'A short Excerpt, Introduction or Description of post (max 64KB)',
  `body` longtext COLLATE utf8mb4_unicode_ci COMMENT 'The main textual content of this post (max 4GB)',
  `filtered_body` longtext COLLATE utf8mb4_unicode_ci COMMENT 'The main textual content of this post which is stripped all the html tags, it''s use for search or index content (max 4GB)',
  `image` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display the ID (managed by media library) or URL/Path of other single image that associates with post',
  `image_alt` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display alternative text (for ALT attribute in the HTML image tag) or the ID or URL/Path of alternative file/image',
  `created_date` datetime DEFAULT NULL COMMENT 'The creation date and time',
  `creator_id` int(11) unsigned DEFAULT NULL COMMENT 'User who create this post',
  `last_modified_date` datetime DEFAULT NULL COMMENT 'Last modification date and time',
  `last_modifier_id` int(11) unsigned DEFAULT NULL COMMENT 'Last user who modify this post',
  `published_date` datetime DEFAULT NULL COMMENT 'Publication date and time (defaults to 0000-00-00 00:00:00 or NULL, which indicates that the posted date and created date are same)',
  `expiry_date` datetime DEFAULT NULL COMMENT 'Expiry date and time (defaults to 0000-00-00 00:00:00 or NULL, which indicates that the post never expires)',
  `average_rating` decimal(10,0) DEFAULT '0' COMMENT 'Display an average of the post sentiment scores, based on a 1-5 or 1-10 scale',
  `view_count` int(11) unsigned DEFAULT '0' COMMENT 'Display total of views (or clicks) a post has',
  `like_count` int(11) unsigned DEFAULT '0' COMMENT 'Display total of likes a post has',
  `dislike_count` int(11) unsigned DEFAULT '0' COMMENT 'Display total of dislikes a post has',
  `comment_count` int(11) unsigned DEFAULT '0' COMMENT 'Display total of comments a post has',
  `allow_comment` tinyint(1) DEFAULT '0' COMMENT 'Allow user to post comments. [0]: disabled, [1]: enabled',
  `allow_search` tinyint(1) DEFAULT '1' COMMENT 'If enabled, post will not appear in search result. [0]: disabled, [1]: enabled',
  `privacy` int(1) DEFAULT NULL COMMENT 'The privacy level of post, 0: no access/locked (except administrator), 1: read only (for guests, friends), 2: read/edit/delete (moderator, creator)',
  `is_sticky` tinyint(1) DEFAULT '0' COMMENT 'Allow to pin this post to top/homepage',
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Stores post''s parent id which indicates that it relates to this post. Eg: chapters in novel, posts in same subject, photos in album, options/answwers in poll/survey',
  `position` int(11) DEFAULT NULL COMMENT 'Stores the position of this post between others which are same parent',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '[-3]: trash/deleted, [-2]: draft,  [-1]: pending for approval, [0]: inactived, [1]: published, [2]: sticky/top/hot',
  `extras` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Stores data that related with post such as display format(image, color, html class...), configurations, meta data... and should be stored in json or serialized format',
  `language` varchar(8) CHARACTER SET ascii DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`) USING BTREE,
  KEY `type_id` (`type_id`,`is_sticky`,`status`) USING BTREE,
  KEY `created_date` (`created_date`) USING BTREE,
  KEY `creator_id` (`creator_id`) USING BTREE,
  KEY `published_date` (`published_date`) USING BTREE,
  KEY `expiry_date` (`expiry_date`) USING BTREE,
  KEY `last_modifier_id` (`last_modifier_id`) USING BTREE,
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores information of posts';

-- ----------------------------
-- Table structure for tbl_cms_post_body
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_post_body`;
CREATE TABLE `tbl_cms_post_body` (
  `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci COMMENT 'The main textual content of this post (max 4GB)',
  PRIMARY KEY (`post_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores information of posts';

-- ----------------------------
-- Table structure for tbl_cms_post_category
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_post_category`;
CREATE TABLE `tbl_cms_post_category` (
  `post_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `position` int(11) DEFAULT NULL COMMENT 'The position of article among others within the same category',
  PRIMARY KEY (`post_id`,`category_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maps posts to categories';

-- ----------------------------
-- Table structure for tbl_cms_post_field
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_post_field`;
CREATE TABLE `tbl_cms_post_field` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maps fields to posts, and store field value of post';

-- ----------------------------
-- Table structure for tbl_cms_post_tag
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_post_tag`;
CREATE TABLE `tbl_cms_post_tag` (
  `post_id` int(11) unsigned NOT NULL,
  `tag_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`) USING BTREE,
  KEY `tag_id` (`tag_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maps posts to tags';

-- ----------------------------
-- Table structure for tbl_cms_tags
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_tags`;
CREATE TABLE `tbl_cms_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Unique tag name',
  `weight` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Display the significance of this tag or the number of posts concerned with it',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores defined groups of related posts but more specific than categories';

-- ----------------------------
-- Table structure for tbl_cms_types
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_types`;
CREATE TABLE `tbl_cms_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique code of type',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Display the name of type',
  `plural_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Display the name of type in plural context',
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'A short description of type',
  `is_visible` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Controls if the type is visible to users or not',
  `show_title` tinyint(1) DEFAULT '1',
  `show_intro` tinyint(1) DEFAULT '1',
  `show_body` tinyint(1) DEFAULT '1',
  `show_image` tinyint(1) DEFAULT '1',
  `show_image_alt` tinyint(1) DEFAULT '1',
  `show_tags` tinyint(1) DEFAULT '1',
  `show_categories` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='This table is used to define many different types of (post) content such as news, page, blog...';

-- ----------------------------
-- Table structure for tbl_cms_type_field
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cms_type_field`;
CREATE TABLE `tbl_cms_type_field` (
  `type_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `default_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_required` tinyint(1) DEFAULT '0',
  `multiple` tinyint(1) DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`type_id`,`field_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tbl_configuration
-- ----------------------------
DROP TABLE IF EXISTS `tbl_configuration`;
CREATE TABLE `tbl_configuration` (
  `code` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores custom configuration';

-- ----------------------------
-- Table structure for tbl_email_templates
-- ----------------------------
DROP TABLE IF EXISTS `tbl_email_templates`;
CREATE TABLE `tbl_email_templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Unique code of template',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Display name of template',
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'A short description of template',
  `subject` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Specifies email`s subject',
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Specifies textual content of email',
  `sender_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Specifies sender`s email',
  `sender_name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Specifies sender`s name',
  `created_date` datetime NOT NULL,
  `creator_id` int(11) unsigned NOT NULL,
  `last_modified_date` datetime DEFAULT NULL,
  `last_modifier_id` int(11) unsigned DEFAULT NULL,
  `allow_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Indicates that this is a template which is used by system and can not be deleted',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores customizable content of emails';

-- ----------------------------
-- Table structure for tbl_languages
-- ----------------------------
DROP TABLE IF EXISTS `tbl_languages`;
CREATE TABLE `tbl_languages` (
  `code` varchar(8) CHARACTER SET ascii NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nativename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direction` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'LTR = Left-to-Right, RTL = Right-to-Left',
  `is_default` tinyint(1) DEFAULT '0',
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tbl_menu
-- ----------------------------
DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE `tbl_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Unique code of menu',
  `name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The text displayed for menu',
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'A short description of menu',
  `show_items` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Collapse or expand all items',
  `show_selected_items` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Marks/highlight selected items',
  `show_selected_parents` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Marks/highlight selected parents',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '[0: Inactive], [1: Active]',
  `extras` text COLLATE utf8mb4_unicode_ci COMMENT 'Stores data that related with menu such as display format(image, color, html class...), configurations..., and should be stored in json or serialized format',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines custom menu';

-- ----------------------------
-- Table structure for tbl_menu_items
-- ----------------------------
DROP TABLE IF EXISTS `tbl_menu_items`;
CREATE TABLE `tbl_menu_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) unsigned NOT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `params` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `extras` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `menu_id` (`menu_id`,`status`) USING BTREE,
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tbl_oauth_users
-- ----------------------------
DROP TABLE IF EXISTS `tbl_oauth_users`;
CREATE TABLE `tbl_oauth_users` (
  `user_id` int(11) unsigned NOT NULL,
  `oauth_provider` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Oauth Provider such as Facebook, Google, Microsoft and Linkedin...',
  `oauth_uid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User Id who signed in with Oauth Provider',
  `oauth_data` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Stores user data which retuned from Oauth Provider, it should be stored in xml, serialized or json format',
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`oauth_provider`,`oauth_uid`) USING BTREE,
  UNIQUE KEY `oauth_uid_provider` (`oauth_provider`,`oauth_uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores oauth users from other networks, this allows the same user to login with both Twitter AND Facebook at some point';

-- ----------------------------
-- Table structure for tbl_roles
-- ----------------------------
DROP TABLE IF EXISTS `tbl_roles`;
CREATE TABLE `tbl_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique role ID (Primary Key)',
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Display unique role code',
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Display role name',
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Short description of role',
  `created_date` datetime DEFAULT NULL COMMENT 'The creation date and time',
  `last_modified_date` datetime DEFAULT NULL COMMENT 'Last modification date and time',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Administrative role can log in some administrative panels',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Default role for user''s registration',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `role_code` (`code`) USING BTREE,
  KEY `is_admin` (`is_admin`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Defines user roles';

-- ----------------------------
-- Table structure for tbl_system_log
-- ----------------------------
DROP TABLE IF EXISTS `tbl_system_log`;
CREATE TABLE `tbl_system_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `level` tinyint(1) NOT NULL COMMENT '[INFO, WARNING, ERROR]',
  `env` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` double unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `extras` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tbl_text_source
-- ----------------------------
DROP TABLE IF EXISTS `tbl_text_source`;
CREATE TABLE `tbl_text_source` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Specifies the name of translation sets',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The message that needs to be translated',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores common source phrase or text (multi-language)';

-- ----------------------------
-- Table structure for tbl_text_translation
-- ----------------------------
DROP TABLE IF EXISTS `tbl_text_translation`;
CREATE TABLE `tbl_text_translation` (
  `source_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language` varchar(8) CHARACTER SET ascii NOT NULL COMMENT 'Specifies the language for translation',
  `translation` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The phrase or text that is translated from source',
  PRIMARY KEY (`source_id`,`language`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores common translated phrase or text (multi-language)';

-- ----------------------------
-- Table structure for tbl_users
-- ----------------------------
DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique code of user',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Unique user name of user',
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Unique email of user',
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique phone of user',
  `password` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Stores user’s hashed password',
  `firstname` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `displayname` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nickname',
  `gender` tinyint(1) DEFAULT NULL COMMENT 'Male / Female / Unknown',
  `birthdate` date DEFAULT NULL,
  `birthplace` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_me` text COLLATE utf8mb4_unicode_ci COMMENT 'Introduction text',
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'A short description of user',
  `creator_id` int(11) unsigned DEFAULT NULL,
  `created_date` datetime DEFAULT NULL COMMENT 'The creation date and time (timestamp for when user was created, it’s also called registration date)',
  `last_modifier_id` int(11) unsigned DEFAULT NULL,
  `last_modified_date` datetime DEFAULT NULL COMMENT 'Last modification date and time (timestamp for when user changes information)',
  `last_password_changed_date` datetime DEFAULT NULL COMMENT 'Last time when user changes password successfully',
  `last_login_date` datetime DEFAULT NULL COMMENT 'Timestamp for user’s last successful login (the last time the user actually logged in by supplying username and password)',
  `last_access_date` datetime DEFAULT NULL COMMENT 'Timestamp for previous time user accessed the site (the last time the user was browsing the site while already logged in)',
  `last_verified_date` datetime DEFAULT NULL COMMENT 'Last time when user is verified successfully',
  `timezone` varchar(32) CHARACTER SET ascii DEFAULT NULL COMMENT 'User’s time zone',
  `language` varchar(8) CHARACTER SET ascii DEFAULT NULL COMMENT 'Display default language',
  `verified` tinyint(1) DEFAULT '0' COMMENT 'Specifies if this user is verified or not?',
  `status` tinyint(4) NOT NULL DEFAULT '-1' COMMENT '[-1: pending for approval], [0: disabled/blocked], [1: enabled]',
  `settings` text COLLATE utf8mb4_unicode_ci COMMENT 'Specifies additional settings related to user',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  UNIQUE KEY `code` (`code`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores user information';

-- ----------------------------
-- Table structure for tbl_user_data
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_data`;
CREATE TABLE `tbl_user_data` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tbl_user_role
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_role`;
CREATE TABLE `tbl_user_role` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`) USING BTREE,
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maps users to roles';

-- ----------------------------
-- Table structure for tbl_user_sentiments
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_sentiments`;
CREATE TABLE `tbl_user_sentiments` (
  `user_id` int(11) unsigned NOT NULL,
  `ref_id` int(11) unsigned NOT NULL,
  `ref_type` enum('post','comment') COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` tinyint(1) DEFAULT NULL COMMENT '[0] Unlike [1] Like [-1] Dislike',
  `last_modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`ref_id`,`ref_type`) USING BTREE,
  KEY `ref_id` (`ref_type`,`ref_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Store user''s sentiments';

-- ----------------------------
-- Table structure for tbl_user_sessions
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_sessions`;
CREATE TABLE `tbl_user_sessions` (
  `session` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A session ID. The value is generated by session handlers.',
  `user_id` int(11) unsigned NOT NULL COMMENT 'The user corresponding to a session',
  `timestamp` int(11) NOT NULL COMMENT 'The Unix timestamp when this session last requested a page',
  `data` text COLLATE utf8mb4_unicode_ci COMMENT 'Stores data of session, It may be the serialized contents of $_SESSION',
  PRIMARY KEY (`session`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `timestamp` (`timestamp`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores user''s sessions';

-- ----------------------------
-- Table structure for tbl_user_tokens
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_tokens`;
CREATE TABLE `tbl_user_tokens` (
  `token` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `last_checked_date` datetime NOT NULL,
  `expiry_date` datetime NOT NULL,
  PRIMARY KEY (`token`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SET FOREIGN_KEY_CHECKS=1;
