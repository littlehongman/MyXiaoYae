-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 13, 2020 at 01:03 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myxiaoyae`
--

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `food_ID` smallint(6) NOT NULL,
  `food_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` smallint(6) NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`food_ID`, `food_name`, `price`, `store_name`) VALUES
(1, '蜜汁雞排', 45, 'Boss-G炸物輕食'),
(2, '無骨鹹酥雞', 50, 'Boss-G炸物輕食'),
(3, '百頁豆腐', 30, 'Boss-G炸物輕食'),
(4, '雞心', 25, 'Boss-G炸物輕食'),
(5, '雞皮', 30, 'Boss-G炸物輕食'),
(6, '雞翅', 20, 'Boss-G炸物輕食'),
(7, '糯米腸', 20, 'Boss-G炸物輕食'),
(8, '甜不辣', 30, 'Boss-G炸物輕食'),
(9, '滷香豆干', 15, 'Boss-G炸物輕食'),
(10, '四季豆', 30, 'Boss-G炸物輕食'),
(11, '大麥克', 72, '麥當勞-基隆新豐店'),
(12, '雙層牛肉吉事堡', 62, '麥當勞-基隆新豐店'),
(13, '嫩煎雞腿堡', 82, '麥當勞-基隆新豐店'),
(14, '麥香雞', 44, '麥當勞-基隆新豐店'),
(15, '麥克雞塊 (6塊)', 60, '麥當勞-基隆新豐店'),
(16, '麥克雞塊 (10塊)', 100, '麥當勞-基隆新豐店'),
(17, '勁辣雞腿堡', 72, '麥當勞-基隆新豐店'),
(18, '麥脆雞腿 (2塊)', 110, '麥當勞-基隆新豐店'),
(19, '麥脆雞翅 (2塊)', 90, '麥當勞-基隆新豐店'),
(20, '黃金起司豬排堡', 52, '麥當勞-基隆新豐店'),
(21, '麥香魚', 44, '麥當勞-基隆新豐店'),
(22, '煙燻雞肉長堡', 74, '麥當勞-基隆新豐店'),
(23, '薑燒豬肉長堡', 74, '麥當勞-基隆新豐店'),
(24, 'BLT 安格斯黑牛堡', 109, '麥當勞-基隆新豐店'),
(25, 'BLT 辣脆雞腿堡', 109, '麥當勞-基隆新豐店'),
(26, 'BLT 嫩煎雞腿堡', 109, '麥當勞-基隆新豐店'),
(27, '蕈菇安格斯黑牛堡', 119, '麥當勞-基隆新豐店'),
(28, '凱薩脆雞沙拉', 99, '麥當勞-基隆新豐店'),
(30, '小籠湯包', 60, '珍好味永和豆漿'),
(31, '蔥抓餅', 25, '珍好味永和豆漿'),
(32, '蘿蔔糕', 25, '珍好味永和豆漿'),
(33, '原味飯糰', 28, '珍好味永和豆漿'),
(34, '招牌乳酪蛋餅', 35, '珍好味永和豆漿'),
(35, '燒餅', 18, '珍好味永和豆漿'),
(36, '油條', 18, '珍好味永和豆漿'),
(37, '燒餅夾油條', 28, '珍好味永和豆漿'),
(38, '燒餅夾蛋', 23, '珍好味永和豆漿'),
(39, '豆漿', 15, '珍好味永和豆漿'),
(41, '雞蛋糕', 20, 'Boss-G炸物輕食');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `cus_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `food_ID` smallint(6) NOT NULL,
  `numbers` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`cus_name`, `food_ID`, `numbers`) VALUES
('hank', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `store_ID` int(3) NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_hour` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `URL` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_ID`, `store_name`, `address`, `business_hour`, `phone`, `URL`) VALUES
(1, 'Boss-G炸物輕食', '基隆市信義區深溪路192號屈臣氏旁棚架第三攤', '16:00 - 24:00', '0918187899', 'https://imgur.com/pdYVPnv.jpg'),
(2, '珍好味永和豆漿', '基隆市中正區新豐街379號', '19:00 - 11:00', ' 02-24691999', 'https://imgur.com/6owbBpq.png'),
(3, '麥當勞-基隆新豐店', '基隆市新豐街249號', '24小時營業', '無', 'https://imgur.com/kxuvN0O.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`food_ID`),
  ADD KEY `store_name` (`store_name`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`cus_name`,`food_ID`),
  ADD KEY `food_ID` (`food_ID`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_ID`),
  ADD UNIQUE KEY `store_name` (`store_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `food_ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `store_ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `food_ibfk_1` FOREIGN KEY (`store_name`) REFERENCES `store` (`store_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_list`
--
ALTER TABLE `order_list`
  ADD CONSTRAINT `order_list_ibfk_1` FOREIGN KEY (`food_ID`) REFERENCES `food` (`food_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
