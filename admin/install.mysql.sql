CREATE TABLE IF NOT EXISTS `#__pmenu_menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `begin_publish` datetime DEFAULT NULL,
  `end_publish` datetime DEFAULT NULL,
  `published` tinyint(2) DEFAULT 0,
  PRIMARY KEY (`menu_id`)
);

CREATE TABLE IF NOT EXISTS `#__pmenu_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL, 
  `parent_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `price` varchar(55) DEFAULT NULL,
  `info_object` text DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `begin_publish` datetime DEFAULT NULL,
  `end_publish` datetime DEFAULT NULL,
  `published` tinyint(2) DEFAULT 0,
  PRIMARY KEY (`item_id`)
);

CREATE TABLE IF NOT EXISTS `#__pmenu_restaurants` (
  `restaurant_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info_object` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `begin_publish` datetime DEFAULT NULL,
  `end_publish` datetime DEFAULT NULL,
  `published` tinyint(2) DEFAULT 1,
  PRIMARY KEY (`restaurant_id`)
);

-- 
-- CREATE TABLE IF NOT EXISTS `#__pmenu_favorites` (
--   `review_id` int(11) NOT NULL AUTO_INCREMENT,
--   `book_id` int(11) DEFAULT NULL,
--   `user_id` int(11) DEFAULT NULL,
--   `title` varchar(255) DEFAULT NULL,
--   `review` text DEFAULT NULL,
--   `rating` varchar(55) DEFAULT NULL,
--   `created` datetime DEFAULT NULL,
--   `modified` datetime DEFAULT NULL,
--   `published` tinyint(2) DEFAULT 1,
--   PRIMARY KEY (`review_id`)
-- );