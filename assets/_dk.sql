-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2019 at 11:29 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `_dk2`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(6) NOT NULL,
  `id_parent` int(6) DEFAULT NULL,
  `name` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `description` varchar(300) COLLATE utf16_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(4) NOT NULL,
  `f_name` varchar(1000) COLLATE utf16_czech_ci NOT NULL,
  `l_name` varchar(1000) COLLATE utf16_czech_ci NOT NULL,
  `email` varchar(1000) COLLATE utf16_czech_ci NOT NULL,
  `phone` varchar(1000) COLLATE utf16_czech_ci NOT NULL,
  `address` varchar(1000) COLLATE utf16_czech_ci NOT NULL,
  `city` varchar(1000) COLLATE utf16_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `f_name`, `l_name`, `email`, `phone`, `address`, `city`) VALUES
(1, 'def5020098d49acfe4d0a72fb658362ac6c75086f15c0da1c8302bde76cc23d955fe287112b23ea5d25415ca28676d18f8a63135d449eb315a402bb558d96940dc8340569da7b3ecba12c0b9ae7527a9e1168c157804d11b', 'def50200b1a58e3d4979cebce1dd2b756cb6a387a9cb37d1734e58250e7964f45d436e71f73c65510783b81f17cf6b8da0146f24a3315e0a678d481413d3b66481aca938c0e6e8a03fa0986db52743b373b4d8d82eebf27f', 'def5020098d49acfe4d0a72fb658362ac6c75086f15c0da1c8302bde76cc23d955fe287112b23ea5d25415ca28676d18f8a63135d449eb315a402bb558d96940dc8340569da7b3ecba12c0b9ae7527a9e1168c157804d11b', 'def50200b1a58e3d4979cebce1dd2b756cb6a387a9cb37d1734e58250e7964f45d436e71f73c65510783b81f17cf6b8da0146f24a3315e0a678d481413d3b66481aca938c0e6e8a03fa0986db52743b373b4d8d82eebf27f', 'def5020098d49acfe4d0a72fb658362ac6c75086f15c0da1c8302bde76cc23d955fe287112b23ea5d25415ca28676d18f8a63135d449eb315a402bb558d96940dc8340569da7b3ecba12c0b9ae7527a9e1168c157804d11b', 'def50200dbad89561ddfaa24ba75eb14c51dcd4d547ea5a0f8dc4515ef2ae6879d000d10896c83d7c7c92f9aac5f2c870b8f865eb4ef055556d927946820b43e47139cdeec942182f59019201f37f965845c30de8c8d816c');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(6) NOT NULL,
  `id_customer` int(4) NOT NULL,
  `serial_number` varchar(12) COLLATE utf16_czech_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` int(5) NOT NULL,
  `type_of_delivery` varchar(20) COLLATE utf16_czech_ci NOT NULL DEFAULT 'Česká pošta',
  `payed` tinyint(1) NOT NULL DEFAULT '0',
  `finished` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(10) NOT NULL,
  `log` varchar(10000) COLLATE utf16_czech_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `id` int(6) NOT NULL,
  `name` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `description` varchar(300) COLLATE utf16_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(6) NOT NULL,
  `login` varchar(1000) COLLATE utf16_czech_ci NOT NULL,
  `token` varchar(64) COLLATE utf16_czech_ci NOT NULL,
  `expiration` varchar(1000) COLLATE utf16_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
  `id` int(6) NOT NULL,
  `id_product` int(6) NOT NULL,
  `url` varchar(100) COLLATE utf16_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(6) NOT NULL,
  `id_category` int(6) NOT NULL,
  `id_manufacturer` int(6) NOT NULL,
  `name` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `description` varchar(300) COLLATE utf16_czech_ci DEFAULT NULL,
  `color` varchar(30) COLLATE utf16_czech_ci DEFAULT NULL,
  `toughness` varchar(30) COLLATE utf16_czech_ci DEFAULT NULL,
  `price` int(5) NOT NULL,
  `stock` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_in_invoice`
--

CREATE TABLE `products_in_invoice` (
  `id` int(6) NOT NULL,
  `id_invoice` int(6) NOT NULL,
  `id_product` int(6) NOT NULL,
  `count` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_backup`
--

CREATE TABLE `product_backup` (
  `id` int(6) NOT NULL,
  `category` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `manufacturer` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `name` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `description` varchar(300) COLLATE utf16_czech_ci DEFAULT NULL,
  `color` varchar(30) COLLATE utf16_czech_ci DEFAULT NULL,
  `toughness` varchar(30) COLLATE utf16_czech_ci DEFAULT NULL,
  `price` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qna`
--

CREATE TABLE `qna` (
  `id` int(6) NOT NULL,
  `id_question` int(6) DEFAULT NULL,
  `email` varchar(1000) COLLATE utf16_czech_ci NOT NULL,
  `description` varchar(5000) COLLATE utf16_czech_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(4) NOT NULL,
  `id_customer` int(4) NOT NULL,
  `login` varchar(1000) COLLATE utf16_czech_ci NOT NULL,
  `password` varchar(1000) COLLATE utf16_czech_ci NOT NULL,
  `registration_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_customer`, `login`, `password`, `registration_time`, `active`, `admin`) VALUES
(1, 1, 'def5020098d49acfe4d0a72fb658362ac6c75086f15c0da1c8302bde76cc23d955fe287112b23ea5d25415ca28676d18f8a63135d449eb315a402bb558d96940dc8340569da7b3ecba12c0b9ae7527a9e1168c157804d11b', '$2y$10$ogWq8IRWiOSF0oR7yTkmJe.eL5nMSpMI0RGbz0nsGIKLrclesMLmy', '2019-05-24 23:38:01', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `subcategory` (`id_parent`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `url` (`url`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_manufacturer` (`id_manufacturer`);

--
-- Indexes for table `products_in_invoice`
--
ALTER TABLE `products_in_invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_invoice` (`id_invoice`),
  ADD KEY `id_product_1` (`id_product`);

--
-- Indexes for table `product_backup`
--
ALTER TABLE `product_backup`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `qna`
--
ALTER TABLE `qna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_question` (`id_question`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `id_customer` (`id_customer`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_in_invoice`
--
ALTER TABLE `products_in_invoice`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_backup`
--
ALTER TABLE `product_backup`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qna`
--
ALTER TABLE `qna`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `subcategory` FOREIGN KEY (`id_parent`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `id_customer` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `id_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `id_category` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `id_manufacturer` FOREIGN KEY (`id_manufacturer`) REFERENCES `manufacturer` (`id`);

--
-- Constraints for table `products_in_invoice`
--
ALTER TABLE `products_in_invoice`
  ADD CONSTRAINT `id_invoice` FOREIGN KEY (`id_invoice`) REFERENCES `invoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_product_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qna`
--
ALTER TABLE `qna`
  ADD CONSTRAINT `id_question` FOREIGN KEY (`id_question`) REFERENCES `qna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `id_customer_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
