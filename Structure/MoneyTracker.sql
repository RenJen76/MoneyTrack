-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2022-06-17 15:37:16
-- 伺服器版本: 10.7.3-MariaDB-1:10.7.3+maria~focal
-- PHP 版本： 5.6.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `MoneyTracker`
--

-- --------------------------------------------------------

--
-- 資料表結構 `category_list`
--

CREATE TABLE `category_list` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 資料表結構 `subcategory_list`
--

CREATE TABLE `subcategory_list` (
  `subcategory_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `create_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 資料表結構 `trans_list`
--

CREATE TABLE `trans_list` (
  `trans_no` int(11) NOT NULL,
  `spend_at` datetime DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `description` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 資料表結構 `vendor_list`
--

CREATE TABLE `vendor_list` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`category_id`);

--
-- 資料表索引 `subcategory_list`
--
ALTER TABLE `subcategory_list`
  ADD PRIMARY KEY (`subcategory_id`);

--
-- 資料表索引 `trans_list`
--
ALTER TABLE `trans_list`
  ADD PRIMARY KEY (`trans_no`);

--
-- 資料表索引 `vendor_list`
--
ALTER TABLE `vendor_list`
  ADD PRIMARY KEY (`vendor_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `category_list`
--
ALTER TABLE `category_list`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `subcategory_list`
--
ALTER TABLE `subcategory_list`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用資料表 AUTO_INCREMENT `trans_list`
--
ALTER TABLE `trans_list`
  MODIFY `trans_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用資料表 AUTO_INCREMENT `vendor_list`
--
ALTER TABLE `vendor_list`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
