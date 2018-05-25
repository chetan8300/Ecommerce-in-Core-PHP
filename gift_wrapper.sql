-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2017 at 07:57 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gift_wrapper`
--
CREATE DATABASE IF NOT EXISTS `gift_wrapper` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `gift_wrapper`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `lastname`, `email`, `password`, `join_date`, `last_login`) VALUES
(3, 'Chetan', 'Godhani', 'chetangodhani9@gmail.com', '$2y$10$dLZKf88ch9Nxj9pqPHckpeNEgPr0ek8e.54.3aMkeuOs9cpBqcHQu', '2016-09-23 23:56:02', '2017-02-03 08:00:34');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(1, 'Levis'),
(2, 'Nike'),
(3, 'Polo'),
(4, 'Calvin Klein'),
(6, 'Indian Terrain'),
(7, 'United Colors Of Benetton'),
(8, 'Adidas');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `shipped` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`, `shipped`) VALUES
(1, '[{"id":"1","size":"28","quantity":"2"}]', '2016-11-14 13:12:26', 0, 0),
(3, '[{"id":"3","size":"S","quantity":1},{"id":"2","size":"small","quantity":1}]', '2016-11-16 18:57:07', 1, 1),
(4, '[{"id":"3","size":"S","quantity":"1"}]', '2016-11-17 08:07:20', 1, 1),
(5, '[{"id":"4","size":"M","quantity":"3"}]', '2016-11-17 09:07:26', 1, 0),
(6, '[{"id":"3","size":"XS","quantity":"3"}]', '2016-11-17 18:31:26', 1, 0),
(7, '[{"id":"3","size":"S","quantity":"2"}]', '2016-11-17 18:34:38', 1, 0),
(8, '[{"id":"1","size":"36","quantity":"1"}]', '2016-11-17 18:41:26', 1, 0),
(9, '[{"id":"1","size":"36","quantity":"1"}]', '2016-11-17 18:48:21', 1, 0),
(10, '[{"id":"2","size":"large","quantity":"1"}]', '2016-11-18 06:52:49', 1, 0),
(11, '[{"id":"4","size":"M","quantity":2},{"id":"1","size":"28","quantity":"3"},{"id":"3","size":"XS","quantity":6}]', '2016-11-18 10:41:14', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Men', 0),
(2, 'Women', 0),
(3, 'Boys', 0),
(4, 'Girls', 0),
(5, 'Gifts', 0),
(6, 'Shirts', 1),
(7, 'Pants', 1),
(8, 'Shoes', 1),
(9, 'Accessories', 1),
(10, 'Shirts', 2),
(11, 'Pants', 2),
(12, 'Shoes', 2),
(13, 'Dresses', 2),
(14, 'Accessories', 2),
(15, 'Shirts', 3),
(16, 'Pants', 3),
(17, 'Dresses', 4),
(18, 'Shoes', 4),
(19, 'Home Decor', 5);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `sizes` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `category`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES
(1, 'Levi&#039;s Jeans', '29.99', '39.99', 1, '7', '/ecommerce/assets/images/products/db779b194d998e4ed3929671e4cf61ed.png', 'These Jeans are Amazing. They are super comfortable.', 1, '28:3,32:5,36:1', 0),
(2, 'Levis Denim Shirt', '99.99', '69.99', 1, '6', '/ecommerce/assets/images/products/men3.png', 'These Denims are Amazing. They are super comfortable also Looks cool.', 0, 'small:6,medium:7,large:4', 0),
(3, 'Nike Tshirt - Just Do It', '10.99', '20.99', 2, '15', '/ecommerce/assets/images/products/bc18337125e31e3156ff6ff266e43399.jpg', 'Complete the sporty look of your little son with this black T-shirt by Nike. While the chic graphic print amplifies the fashion appeal of this regular-fit T-shirt, the breathable cotton fabric promises utmost comfort and a soft feel.', 1, 'XS:6,S:5,M:4,L:3', 0),
(4, 'Adidas White T-Shirt', '9.99', '19.99', 8, '15', '/ecommerce/assets/images/products/cd62a03a9039d6b15c10edd54b219590.jpg', 'Give a sporty and comfortable look to your girl by buying her this ?J P Trefoil T G off White Casual Top? from adidas Originals. Made from cotton, this printed top has a round neck and half sleeves. You can team this top with matching track pants to complete your girl&#039;s casual look.  ', 1, 'S:10,M:8', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `charge_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `txn_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `charge_id`, `cart_id`, `full_name`, `email`, `street`, `street2`, `city`, `state`, `zip_code`, `country`, `sub_total`, `tax`, `grand_total`, `description`, `txn_type`, `txn_date`) VALUES
(1, 'ch_195jKgLDd0UoI5Ur4N4vniHd', 3, 'Chetan Godhani', 'chetangodhani9@gmail.com', '42/1, Suryanarayan Society', 'Sector 25', 'Gandhinagar', 'Gujarat', '382025', 'India', '110.98', '9.66', '120.64', '2items from Gift Wrapper.', 'charge', '2016-10-18 03:41:47'),
(2, 'ch_195qmVLDd0UoI5UrujBZiDnu', 4, 'Chetan Godhani', 'chetangodhani92@GMAI.COM', 'dfgsdshfgj', 'gjhgjhgj', 'hjgjhgjh', 'hjgjhgjhg', '5343', 'ngfngf', '10.99', '0.96', '11.95', '1item from Gift Wrapper.', 'charge', '2016-10-18 11:39:01'),
(3, 'ch_195qmWLDd0UoI5Ur3KPILG8P', 4, 'Chetan Godhani', 'chetangodhani92@GMAI.COM', 'dfgsdshfgj', 'gjhgjhgj', 'hjgjhgjh', 'hjgjhgjhg', '5343', 'ngfngf', '10.99', '0.96', '11.95', '1item from Gift Wrapper.', 'charge', '2016-10-18 11:39:01'),
(4, 'ch_195ri0LDd0UoI5UrLVNfA6R0', 5, 'Chetan Godhani', 'chetangodhani9@gmail.com', 'dsfdslkfn', 'ldfsnlsdfn', 'ldl', 'kfgl', '546', 'fssdfsfgds', '29.97', '2.61', '32.58', '3items from Gift Wrapper.', 'charge', '2016-10-18 12:38:25'),
(5, 'ch_195ri1LDd0UoI5UraqRWL3n9', 5, 'Chetan Godhani', 'chetangodhani9@gmail.com', 'dsfdslkfn', 'ldfsnlsdfn', 'ldl', 'kfgl', '546', 'fssdfsfgds', '29.97', '2.61', '32.58', '3items from Gift Wrapper.', 'charge', '2016-10-18 12:38:26'),
(6, 'ch_1960XKLDd0UoI5Ur9aECsjuz', 6, 'Chetan Godhani', 'chetngod@gmail.com', 'asdgalksnk', 'kasjagknljsn', 'lksdmgnooegjfn', 'kjenrfjn', '261216516', 'sfokgdslg', '32.97', '2.87', '35.84', '3items from Gift Wrapper.', 'charge', '2016-10-18 22:03:58'),
(7, 'ch_1960XKLDd0UoI5Urjm6j4b9u', 6, 'Chetan Godhani', 'chetngod@gmail.com', 'asdgalksnk', 'kasjagknljsn', 'lksdmgnooegjfn', 'kjenrfjn', '261216516', 'sfokgdslg', '32.97', '2.87', '35.84', '3items from Gift Wrapper.', 'charge', '2016-10-18 22:03:58'),
(8, 'ch_1960a5LDd0UoI5UreUK2ta3N', 7, 'Chetan Godhani', 'chetangodhani9@gmail.co', 'fjonsdfk', 'okmdsookdmk', 'mlkffml ewl', 'lfdkb vkl ', '394107', 'szdfht', '21.98', '1.91', '23.89', '2items from Gift Wrapper.', 'charge', '2016-10-18 22:06:49'),
(9, 'ch_1960fCLDd0UoI5UrHbfd7PA7', 8, 'Chetan godhani', 'vhrgjn@kldsg.com', 'ksfjbg', 'kjgn', 'qskj', 'nfk', '153', 'dfg', '29.99', '2.61', '32.60', '1item from Gift Wrapper.', 'charge', '2016-10-18 22:12:06'),
(10, 'ch_1960uBLDd0UoI5UrkNzSGYNv', 9, 'sgss', 'sdfsf@sd.vom', 'serye', 'gtsetgfh', 'awer', 'sdgn', '45442', 'esrfh', '29.99', '2.61', '32.60', '1item from Gift Wrapper.', 'charge', '2016-10-18 22:27:35'),
(11, 'ch_1960uBLDd0UoI5UrnQqLenyn', 9, 'sgss', 'sdfsf@sd.vom', 'serye', 'gtsetgfh', 'awer', 'sdgn', '45442', 'esrfh', '29.99', '2.61', '32.60', '1item from Gift Wrapper.', 'charge', '2016-10-18 22:27:35'),
(12, 'ch_196C85LDd0UoI5Urpd5d3wQI', 10, 'drhhddrh', 'fgvjghjhhjasfj@gmail.com', 'bdsfbdsnmb', 'sdnmdsn', 'fbdsvbdsnm', 'qbmfbsdnfb', '364001', 'djfkjsddfdskj', '99.99', '8.70', '108.69', '1item from Gift Wrapper.', 'charge', '2016-10-19 10:26:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `join_date`, `last_login`) VALUES
(1, 'Abcd', 'Efgh', 'a@a.com', '$2y$10$9cWHrGsLIx9yEDVlv5YePuuDbb/C9PrqVCmrR7sYt4KSMBrasKDni', '2016-09-23 23:20:20', '2016-09-23 19:50:20'),
(2, 'Abcd', 'Efgh', 'tatti@tatti.com', '$2y$10$Pi6Kij6LdfiAzWzC8IlAI.4teW9E8CAJVGDJph7Av3YR5VycVzuBS', '2016-09-24 13:50:46', '2016-09-24 10:20:46'),
(3, 'Abcdsdfsdfs', 'Efghsdfsdfsf', 'tsdsdffsfatti@tafgfghtti.com', '$2y$10$Vy8vGNYk.U/nJmRkV3FE.uXS4fQwH4GTJpSr39hS17QTN0n6RP8mO', '2016-09-24 13:55:10', '2016-09-24 10:58:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
