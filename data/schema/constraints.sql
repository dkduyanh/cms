--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_acl_role_permission`
--
ALTER TABLE `tbl_acl_role_permission`
  ADD CONSTRAINT `tbl_acl_role_permission_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`),
  ADD CONSTRAINT `tbl_acl_role_permission_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `tbl_acl_permissions` (`id`);

--
-- Constraints for table `tbl_acl_user_permission`
--
ALTER TABLE `tbl_acl_user_permission`
  ADD CONSTRAINT `tbl_acl_user_permission_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`),
  ADD CONSTRAINT `tbl_acl_user_permission_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `tbl_acl_permissions` (`id`);

--
-- Constraints for table `tbl_cms_categories`
--
ALTER TABLE `tbl_cms_categories`
  ADD CONSTRAINT `tbl_cms_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `tbl_cms_categories` (`id`);

--
-- Constraints for table `tbl_cms_comments`
--
ALTER TABLE `tbl_cms_comments`
  ADD CONSTRAINT `tbl_cms_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `tbl_cms_posts` (`id`),
  ADD CONSTRAINT `tbl_cms_comments_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `tbl_cms_comments` (`id`);

--
-- Constraints for table `tbl_cms_posts`
--
ALTER TABLE `tbl_cms_posts`
  ADD CONSTRAINT `tbl_cms_posts_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `tbl_cms_types` (`id`),
  ADD CONSTRAINT `tbl_cms_posts_ibfk_2` FOREIGN KEY (`creator_id`) REFERENCES `tbl_users` (`id`),
  ADD CONSTRAINT `tbl_cms_posts_ibfk_3` FOREIGN KEY (`last_modifier_id`) REFERENCES `tbl_users` (`id`),
  ADD CONSTRAINT `tbl_cms_posts_ibfk_4` FOREIGN KEY (`parent_id`) REFERENCES `tbl_cms_posts` (`id`);

--
-- Constraints for table `tbl_cms_post_category`
--
ALTER TABLE `tbl_cms_post_category`
  ADD CONSTRAINT `tbl_cms_post_category_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `tbl_cms_posts` (`id`),
  ADD CONSTRAINT `tbl_cms_post_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `tbl_cms_categories` (`id`);

--
-- Constraints for table `tbl_cms_post_field`
--
ALTER TABLE `tbl_cms_post_field`
  ADD CONSTRAINT `tbl_cms_post_field_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `tbl_cms_posts` (`id`),
  ADD CONSTRAINT `tbl_cms_post_field_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `tbl_cms_fields` (`id`);

--
-- Constraints for table `tbl_cms_post_tag`
--
ALTER TABLE `tbl_cms_post_tag`
  ADD CONSTRAINT `tbl_cms_post_tag_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `tbl_cms_posts` (`id`),
  ADD CONSTRAINT `tbl_cms_post_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tbl_cms_tags` (`id`);

--
-- Constraints for table `tbl_cms_type_field`
--
ALTER TABLE `tbl_cms_type_field`
  ADD CONSTRAINT `tbl_cms_type_field_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `tbl_cms_types` (`id`),
  ADD CONSTRAINT `tbl_cms_type_field_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `tbl_cms_fields` (`id`);

--
-- Constraints for table `tbl_menu_items`
--
ALTER TABLE `tbl_menu_items`
  ADD CONSTRAINT `tbl_menu_items_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `tbl_menu` (`id`),
  ADD CONSTRAINT `tbl_menu_items_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `tbl_menu_items` (`id`);

--
-- Constraints for table `tbl_oauth_users`
--
ALTER TABLE `tbl_oauth_users`
  ADD CONSTRAINT `tbl_oauth_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`);

--
-- Constraints for table `tbl_text_translation`
--
ALTER TABLE `tbl_text_translation`
  ADD CONSTRAINT `tbl_text_translation_ibfk_1` FOREIGN KEY (`source_id`) REFERENCES `tbl_text_source` (`id`),
  ADD CONSTRAINT `tbl_text_translation_ibfk_2` FOREIGN KEY (`language`) REFERENCES `tbl_languages` (`code`);

--
-- Constraints for table `tbl_user_data`
--
ALTER TABLE `tbl_user_data`
  ADD CONSTRAINT `tbl_user_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`);

--
-- Constraints for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  ADD CONSTRAINT `tbl_user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`),
  ADD CONSTRAINT `tbl_user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`);

--
-- Constraints for table `tbl_user_sentiments`
--
ALTER TABLE `tbl_user_sentiments`
  ADD CONSTRAINT `tbl_user_sentiments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`);

--
-- Constraints for table `tbl_user_tokens`
--
ALTER TABLE `tbl_user_tokens`
  ADD CONSTRAINT `tbl_user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`);