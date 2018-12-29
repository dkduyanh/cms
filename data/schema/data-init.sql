--
-- Data for table `tbl_roles`
--

INSERT IGNORE INTO `tbl_roles` (`id`, `code`, `name`, `description`, `is_admin`, `is_default`) VALUES
(1, 'administrators', 'administrators', 'Administrators have complete and unrestricted access to the system (built-in role)', 1, 0),
(2, 'moderators', 'moderators', 'Moderators are granted access to the content management module for the purpose of writing, moderating posts, discussions... Some moderators can have some administrative privileges to manage others system''s features (built-in role)', 0, 0),
(3, 'members', 'members', 'Members are group of registered users of the site (built-in role)', 0, 0);

--
-- Data for table `tbl_users`
--

INSERT IGNORE INTO `tbl_users` (`id`, `username`, `email`, `firstname`, `lastname`, `displayname`, `password`,  `description`, `created_date`, `last_modified_date`, `last_access_date`, `last_login_date`, `verified`, `status`) VALUES
(1, 'admin', 'admin@localhost.loc', 'Super', 'Admin', 'Administrator', MD5('123456'), NULL, NOW(), NULL, NULL, NULL, 0, 1);

--
-- Data for table `tbl_users_roles`
--

INSERT IGNORE INTO `tbl_user_role` (`user_id`, `role_id`) VALUES
(1, 1);

--
-- Data for table `tbl_cms_taxonomies`
--

INSERT IGNORE INTO `tbl_cms_types` (`id`, `code`, `name`, `description`) VALUES
(1, 'page', 'Page', 'In general, Pages are very similar to Posts in that they both have Titles and Content. You can use Pages to present timeless information about yourself or your site, organize and manage any content such as "About," "Contact," etc'),
(2, 'article', 'Article', 'Articles are the entries that display in reverse chronological order on your home page. In contrast to pages, posts usually have comments fields beneath them and are included in your site''s RSS feed. ');

--
-- Dumping data for table `tbl_cms_media_folders`
--

INSERT IGNORE INTO `tbl_cms_media` (`id`, `name`, `mime`, `created_date`, `last_modified_date`, `is_visible`, `is_locked`, `position`, `parent_id`) VALUES(1, 'DATABASE', 'directory', NULL, NULL, 1, 0, 1, NULL);


--
-- Dumping data for table `tbl_languages`
--

INSERT INTO `tbl_languages` (`code`, `name`, `nativename`, `image`, `direction`, `is_default`, `position`) VALUES
('en_US', 'English (US)', 'English (US)', '', '', 1, NULL),
('vi_VN', 'Vietnamese', 'Tiếng Việt', NULL, NULL, 0, NULL);