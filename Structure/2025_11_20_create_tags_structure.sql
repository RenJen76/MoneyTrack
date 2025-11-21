CREATE TABLE `tags` (`tag_id` INT NOT NULL , `tag_name` VARCHAR(30) NOT NULL ) ENGINE = MyISAM;
CREATE TABLE `trans_tag` (`trans_id` int(11) NOT NULL, `tag_id` int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `trans_tag` ADD UNIQUE KEY `trans_id` (`trans_id`,`tag_id`);
ALTER TABLE `tags` ADD PRIMARY KEY (`tag_id`);
ALTER TABLE `tags` MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;