
CREATE TABLE `trans_list` (
  `trans_no` int(11) NOT NULL,
  `spend_at` datetime DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
