-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2019 at 09:31 PM
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
-- Database: `_dk`
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

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `id_parent`, `name`, `description`) VALUES
(1, NULL, 'Category 1', NULL),
(2, 1, 'Category 2', NULL),
(3, 1, 'Category 3', NULL),
(4, NULL, 'Category 4', NULL),
(5, 4, 'Category 5', NULL),
(6, 1, 'Category 6', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(4) NOT NULL,
  `f_name` varchar(30) COLLATE utf16_czech_ci NOT NULL,
  `l_name` varchar(30) COLLATE utf16_czech_ci NOT NULL,
  `email` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `phone` varchar(20) COLLATE utf16_czech_ci NOT NULL,
  `address` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `city` varchar(30) COLLATE utf16_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `f_name`, `l_name`, `email`, `phone`, `address`, `city`) VALUES
(1, 'John', 'Doe', 'john.doe@gmail.com', '123456789', 'Pici co ja vim 3', 'NY, 1000'),
(2, 'Jane', 'Doe', 'jane.doe@gmail.com', '987654321', 'Pici co ja vim 31', 'LA, 100');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(6) NOT NULL,
  `id_customer` int(4) NOT NULL,
  `one_time_customer` tinyint(1) NOT NULL,
  `serial_number` varchar(12) COLLATE utf16_czech_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` int(5) NOT NULL,
  `type_of_delivery` varchar(20) COLLATE utf16_czech_ci NOT NULL DEFAULT 'Česká pošta',
  `payed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `id_customer`, `one_time_customer`, `serial_number`, `date`, `price`, `type_of_delivery`, `payed`) VALUES
(18, 1, 0, '20190520-1', '2019-05-20 18:26:36', 50, 'Česká pošta', 0),
(19, 2, 1, '20190520-2', '2019-05-20 18:39:57', 500, 'Česká pošta', 0),
(20, 1, 0, '20190520-3', '2019-05-20 18:50:33', 50, 'Česká pošta', 0),
(21, 1, 0, '20190520-4', '2019-05-20 18:53:30', 100, 'Česká pošta', 0),
(22, 1, 0, '20190520-5', '2019-05-20 18:56:32', 50, 'Česká pošta', 0);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `id` int(6) NOT NULL,
  `name` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `description` varchar(300) COLLATE utf16_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`, `description`) VALUES
(1, 'Manufacturer 1', NULL),
(2, 'Manufacturer 2', NULL),
(3, 'Manufacturer 3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(6) NOT NULL,
  `email` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `token` varchar(64) COLLATE utf16_czech_ci NOT NULL,
  `expiration` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
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

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`id`, `id_product`, `url`) VALUES
(1, 1, 'PEN GRIP NAVI BLUE.jpg'),
(2, 1, 'PEN GRIP NAVI GREEN.jpg'),
(3, 2, 'PEN GRIP NAVI GREEN.jpg'),
(4, 3, 'PEN GRIP NAVI RED.jpg'),
(5, 4, 'PEN GRIP NAVI RED.jpg'),
(6, 5, 'PEN GRIP NAVI RED.jpg'),
(8, 6, 'PEN GRIP NAVI RED.jpg');

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
  `stock` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `id_category`, `id_manufacturer`, `name`, `description`, `color`, `toughness`, `price`, `stock`) VALUES
(1, 1, 1, 'Foo', 'Some description', NULL, NULL, 50, 10),
(2, 1, 1, 'Foo', 'Some description', 'Red', 'Soft', 50, 10),
(3, 2, 1, 'Foo', 'Some description', 'Blue', 'Tough', 70, 10),
(4, 1, 2, 'Foo', 'Some description', NULL, NULL, 80, 0),
(5, 3, 2, 'Foo', 'Some description', 'Aquamarine', 'Soft', 90, 10),
(6, 3, 3, 'Foo', 'Some description', NULL, NULL, 100, 0);

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

--
-- Dumping data for table `products_in_invoice`
--

INSERT INTO `products_in_invoice` (`id`, `id_invoice`, `id_product`, `count`) VALUES
(1, 1, 1, 3),
(8, 13, 1, 1),
(9, 13, 2, 1),
(10, 14, 1, 1),
(11, 14, 2, 1),
(12, 15, 1, 1),
(13, 15, 2, 1),
(14, 16, 1, 1),
(15, 16, 2, 1),
(16, 17, 1, 1),
(17, 18, 1, 1),
(18, 20, 2, 1),
(19, 21, 1, 1),
(20, 21, 1, 1),
(21, 22, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `q&a`
--

CREATE TABLE `q&a` (
  `id` int(6) NOT NULL,
  `id_answer` int(6) DEFAULT NULL,
  `email` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `description` varchar(5000) COLLATE utf16_czech_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(4) NOT NULL,
  `login` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `password` varchar(300) COLLATE utf16_czech_ci NOT NULL,
  `f_name` varchar(30) COLLATE utf16_czech_ci NOT NULL,
  `l_name` varchar(30) COLLATE utf16_czech_ci NOT NULL,
  `phone` varchar(20) COLLATE utf16_czech_ci NOT NULL,
  `address` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `city` varchar(50) COLLATE utf16_czech_ci NOT NULL,
  `registered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `f_name`, `l_name`, `phone`, `address`, `city`, `registered`, `active`) VALUES
(1, 'root', '$2y$10$HCvA.ftrLeGwFv7aAwOyEOFHSM.YHY6GFSQwYvkmH2d1KdjrTlzJG', '', '', '', '', '', '2019-04-04 20:45:43', 1),
(5, 'eyy@picovina.com', '$2y$10$vDx0svhLzSyacmTFKQW/T.i7u3KaYWW6ts0NdidefH1aEZ.BHJrAu', 'John', 'Doe', '666 666 666', 'V prdeli 666', 'Suchdol, 275 00', '2019-04-24 19:13:50', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

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
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `products_in_invoice`
--
ALTER TABLE `products_in_invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `q&a`
--
ALTER TABLE `q&a`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products_in_invoice`
--
ALTER TABLE `products_in_invoice`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `q&a`
--
ALTER TABLE `q&a`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
