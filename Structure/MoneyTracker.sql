SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `account_list` (
  `account_id` int NOT NULL,
  `account_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `create_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;

CREATE TABLE `category_list` (
  `category_id` int NOT NULL,
  `category_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;

CREATE TABLE `subcategory_list` (
  `subcategory_id` int NOT NULL,
  `category_id` int NOT NULL,
  `subcategory_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `create_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;

CREATE TABLE `trans_list` (
  `trans_no` int NOT NULL,
  `account_id` int NOT NULL DEFAULT '0',
  `spend_at` datetime DEFAULT NULL,
  `vendor_id` int DEFAULT NULL,
  `subcategory_id` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `description` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `hash_key` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;

CREATE TABLE `vendor_list` (
  `vendor_id` int NOT NULL,
  `vendor_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;


ALTER TABLE `account_list`
  ADD PRIMARY KEY (`account_id`);

ALTER TABLE `category_list`
  ADD PRIMARY KEY (`category_id`);

ALTER TABLE `subcategory_list`
  ADD PRIMARY KEY (`subcategory_id`);

ALTER TABLE `trans_list`
  ADD PRIMARY KEY (`trans_no`),
  ADD UNIQUE KEY `hashkey` (`hash_key`);

ALTER TABLE `vendor_list`
  ADD PRIMARY KEY (`vendor_id`);


ALTER TABLE `account_list`
  MODIFY `account_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `category_list`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `subcategory_list`
  MODIFY `subcategory_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `trans_list`
  MODIFY `trans_no` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `vendor_list`
  MODIFY `vendor_id` int NOT NULL AUTO_INCREMENT;
COMMIT;
