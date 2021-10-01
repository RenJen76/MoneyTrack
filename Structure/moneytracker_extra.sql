

ALTER TABLE `category_list`
  ADD PRIMARY KEY (`category_id`);

ALTER TABLE `subcategory_list`
  ADD PRIMARY KEY (`subcategory_id`);

ALTER TABLE `trans_list`
  ADD PRIMARY KEY (`trans_no`);

ALTER TABLE `vendor_list`
  ADD PRIMARY KEY (`vendor_id`);


ALTER TABLE `category_list`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `subcategory_list`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `trans_list`
  MODIFY `trans_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `vendor_list`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;