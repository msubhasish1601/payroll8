-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 08, 2023 at 07:55 AM
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
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `emid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `owner_id` bigint(20) NOT NULL,
  `project_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `actual_start_date` date DEFAULT NULL,
  `actual_end_date` date DEFAULT NULL,
  `contract_cost` decimal(20,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 = pending\r\n1 = active\r\n2 = inactive\r\n3 = closed\r\n4 = cancelled\r\n5 = hold',
  `closure_certificate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `closure_date` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `emid`, `name`, `client_id`, `owner_id`, `project_code`, `start_date`, `end_date`, `actual_start_date`, `actual_end_date`, `contract_cost`, `status`, `closure_certificate`, `closure_date`, `description`, `created_at`, `updated_at`) VALUES
(19, NULL, 'laravel', 9, 3306, 'P/9/2023/3306', '2023-11-10', '2023-11-12', '2023-11-15', '2023-11-18', '3456.00', 3, 'certificate/hQgQyutQoU3JMDPTUtABovGJWROJvHOacHdQEiNe.xls', '2023-11-22', 'text text', '2023-11-07 13:41:56', '2023-11-07 13:41:56'),
(18, NULL, 'Qolaris', 9, 3362, 'P/9/2023/3362', '2023-11-09', '2023-11-10', '2023-11-15', '2023-11-17', '3456.00', 1, 'certificate/PA25vdq3J6zIQUVynZ1ObpHzCR5t6vUnM8D2dj2p.xls', '2023-11-23', 'text', '2023-11-07 13:39:12', '2023-11-07 13:39:12');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
