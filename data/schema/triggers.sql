-- USE `hotshare`;

DELIMITER //

/* USERS */

-- DROP TRIGGER IF EXISTS `bi_tbl_users`//
-- CREATE DEFINER = CURRENT_USER TRIGGER `bi_tbl_users` BEFORE INSERT ON tbl_users FOR EACH ROW 
-- BEGIN
--  /*generate random string*/
--	DECLARE v_strRandCode VARCHAR(32) DEFAULT NULL;
--	SELECT MD5(UUID()) INTO v_strRandCode;
--	/*set value*/
--	SET NEW.user_secret_key = LEFT(v_strRandCode, 5);
--	SET NEW.user_salt = RIGHT(v_strRandCode, 5);
--	SET NEW.user_password = MD5(CONCAT(NEW.user_password, NEW.user_salt));
-- END //

-- DROP TRIGGER IF EXISTS `bu_tbl_users`//
-- CREATE DEFINER = CURRENT_USER TRIGGER `bu_tbl_users` BEFORE UPDATE ON tbl_users FOR EACH ROW 
-- BEGIN
--	/*generate random string*/
--	DECLARE v_strRandCode VARCHAR(32) DEFAULT NULL;
--	SELECT MD5(UUID()) INTO v_strRandCode;
--	/*set value*/
--	SET NEW.user_secret_key = LEFT(v_strRandCode, 5);
--	/*change salt and re-generate new password if password field was updated*/
--	IF (NEW.user_password != OLD.user_password) THEN
--		SET NEW.user_salt = RIGHT(v_strRandCode, 5);
--		SET NEW.user_password = MD5(CONCAT(NEW.user_password, NEW.user_salt));
--	END IF;
-- END //

/* CMS CATEGORIES */

DROP TRIGGER IF EXISTS `bi_tbl_cms_categories`//
CREATE DEFINER = CURRENT_USER TRIGGER `bi_tbl_cms_categories` BEFORE INSERT ON tbl_cms_categories FOR EACH ROW 
BEGIN
	/* update order of new category */
	IF NEW.category_position IS NULL THEN
		SET NEW.category_position = (SELECT IFNULL(MAX(category_id),0)+1 FROM tbl_cms_categories WHERE category_parent <=> NEW.category_parent);
	END IF;
END //

DROP TRIGGER IF EXISTS `bu_tbl_cms_categories`//
CREATE DEFINER = CURRENT_USER TRIGGER `bu_tbl_cms_categories` BEFORE UPDATE ON tbl_cms_categories FOR EACH ROW 
BEGIN
	/* if change parent of this category*/
	IF IFNULL(NEW.category_parent,0) <> IFNULL(OLD.category_parent,0) THEN
		/* prevent update new parent has same value with id */
		IF NEW.category_parent = NEW.category_id THEN
			SIGNAL SQLSTATE '45010' SET MESSAGE_TEXT = "Parent can not be same value with Primary key";	
		ELSE
			/* prevent update new parent has value of its children */
			BEGIN
				DECLARE v_intDone INT DEFAULT 0;
				DECLARE v_intParentCateId INT DEFAULT NEW.category_parent;
				WHILE v_intDone = 0 DO
					SELECT category_parent INTO v_intParentCateId FROM tbl_cms_categories WHERE category_id <=> v_intParentCateId;
					IF v_intParentCateId <=> NULL OR v_intParentCateId <=> NEW.category_parent THEN
						SET v_intDone = 1;
					ELSEIF v_intParentCateId = NEW.category_id THEN
						SIGNAL SQLSTATE '45011' SET MESSAGE_TEXT = "Parent can not be same value with any childrent's primary keys";
					END IF;
				END WHILE;
			END;
		END IF;
		/* update order */
		IF NEW.category_position IS NULL OR NEW.category_position <=> OLD.category_position THEN
			SET NEW.category_position = (SELECT IFNULL(MAX(category_id),0)+1 FROM tbl_cms_categories WHERE category_parent <=> NEW.category_parent);
		END IF;
	END IF;		
END //

/* MENU */

DROP TRIGGER IF EXISTS `bu_tbl_menu`//
CREATE DEFINER = CURRENT_USER TRIGGER `bu_tbl_menu` BEFORE UPDATE ON tbl_menu FOR EACH ROW 
BEGIN
	/* if change menu status*/
	IF NEW.menu_status <> OLD.menu_status THEN
		/* change status of all it's root menu items */
		UPDATE tbl_menu_items SET item_status = NEW.menu_status WHERE menu_id = OLD.menu_id AND item_parent <=> NULL;
	END IF;
END //

/* MENU ITEMS */

DROP TRIGGER IF EXISTS `bi_tbl_menu_items`//
CREATE DEFINER = CURRENT_USER TRIGGER `bi_tbl_menu_items` BEFORE INSERT ON tbl_menu_items FOR EACH ROW 
BEGIN
	/* update order of new category */
	IF NEW.item_position IS NULL THEN
		SET NEW.item_position = (SELECT IFNULL(MAX(item_id),0)+1 FROM tbl_menu_items WHERE item_parent <=> NEW.item_parent);
	END IF;
END //

DROP TRIGGER IF EXISTS `bu_tbl_menu_items`//
CREATE DEFINER = CURRENT_USER TRIGGER `bu_tbl_menu_items` BEFORE UPDATE ON tbl_menu_items FOR EACH ROW 
BEGIN
	/* if change parent of this item*/
	IF IFNULL(NEW.item_parent,0) <> IFNULL(OLD.item_parent,0) THEN
		/* prevent update new parent has same value with id */
		IF NEW.item_parent = NEW.item_id THEN
			SIGNAL SQLSTATE '45010' SET MESSAGE_TEXT = "Parent can not be same value with Primary key";	
		ELSE
			/* prevent update new parent has value of its children */
			BEGIN
				DECLARE v_intDone INT DEFAULT 0;
				DECLARE v_intParentItemId INT DEFAULT NEW.item_parent;
				WHILE v_intDone = 0 DO
					SELECT item_parent INTO v_intParentItemId FROM tbl_menu_items WHERE item_id <=> v_intParentItemId;
					IF v_intParentItemId <=> NULL OR v_intParentItemId <=> NEW.item_parent THEN
						SET v_intDone = 1;
					ELSEIF v_intParentItemId = NEW.item_id THEN
						SIGNAL SQLSTATE '45011' SET MESSAGE_TEXT = "Parent can not be same value with any childrent's primary keys";
					END IF;
				END WHILE;
			END;
		END IF;
		/* update order */
		IF NEW.item_position IS NULL OR NEW.item_position <=> OLD.item_position THEN
			SET NEW.item_position = (SELECT IFNULL(MAX(item_id),0)+1 FROM tbl_menu_items WHERE item_parent <=> NEW.item_parent);
		END IF;
	END IF;
END //
DELIMITER ;