-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2020-11-29 10:23:12
-- 伺服器版本： 10.4.16-MariaDB
-- PHP 版本： 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `myxiaoyae`
--

-- --------------------------------------------------------

--
-- 資料表結構 `food`
--

CREATE TABLE `food` (
  `food_ID` smallint(6) NOT NULL,
  `food_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` smallint(6) NOT NULL,
  `store_ID` smallint(3) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `food`
--

INSERT INTO `food` (`food_ID`, `food_name`, `price`, `store_ID`) VALUES
(1, '蜜汁雞排', 45, 1),
(2, '無骨鹹酥雞', 50, 1),
(3, '百頁/雞蛋豆腐', 30, 1),
(4, '雞心/雞屁股', 25, 1),
(5, '雞皮', 30, 1),
(6, '雞翅', 20, 1),
(7, '糯米腸', 20, 1),
(8, '甜不辣', 30, 1),
(9, '滷香豆干', 15, 1),
(10, '四季豆', 30, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `order_list`
--

CREATE TABLE `order_list` (
  `cus_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `food_ID` smallint(6) NOT NULL,
  `number` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `store`
--

CREATE TABLE `store` (
  `store_ID` smallint(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_hour` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `URL` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `store`
--

INSERT INTO `store` (`store_ID`, `store_name`, `address`, `business_hour`, `phone`, `URL`) VALUES
(1, 'Boss-G炸物輕食', '基隆市信義區深溪路192號屈臣氏旁棚架第三攤', '16:00 - 24:00', '0918187899', 'https://imgur.com/pdYVPnv'),
(2, '珍好味永和豆漿', '基隆市中正區新豐街379號', '19:00 - 11:00', ' 02-24691999', NULL),
(3, '麥當勞-基隆新豐店', '基隆市新豐街249號', '24小時營業', '無', 'https://imgur.com/kxuvN0O');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`food_ID`),
  ADD KEY `store_ID` (`store_ID`);

--
-- 資料表索引 `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`cus_name`,`food_ID`),
  ADD KEY `food_ID` (`food_ID`);

--
-- 資料表索引 `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_ID`);

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `food_ibfk_1` FOREIGN KEY (`store_ID`) REFERENCES `store` (`store_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `order_list`
--
ALTER TABLE `order_list`
  ADD CONSTRAINT `order_list_ibfk_1` FOREIGN KEY (`food_ID`) REFERENCES `food` (`food_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
