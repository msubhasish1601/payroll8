-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 08, 2023 at 07:56 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qolaris_payroll_structure`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `emid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poc_phone_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poc_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poc_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Public','Private') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 = pending\r\n1 = active\r\n2 = inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `emid`, `name`, `poc_phone_no`, `poc_name`, `poc_email`, `type`, `status`, `created_at`, `updated_at`) VALUES
(9, NULL, 'sanjoy', '07001892317', '', 'mujuri@qolarisdata.com', 'Private', 1, '2023-10-18 22:55:22', '2023-11-06 13:03:13'),
(13, NULL, 'sanju m', '9775037905', '', 'admin@qolarisdata.com', 'Public', 1, '2023-10-19 06:01:04', '2023-10-29 02:14:46');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
