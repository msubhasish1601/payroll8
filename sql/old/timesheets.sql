-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 22, 2023 at 05:14 AM
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
-- Table structure for table `timesheets`
--

DROP TABLE IF EXISTS `timesheets`;
CREATE TABLE IF NOT EXISTS `timesheets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `employee_id` bigint(20) NOT NULL,
  `sheet_date` date NOT NULL,
  `total_hours_locked` decimal(5,2) NOT NULL,
  `is_draft` int(11) NOT NULL DEFAULT '0',
  `is_submit` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timesheets`
--

INSERT INTO `timesheets` (`id`, `employee_id`, `sheet_date`, `total_hours_locked`, `is_draft`, `is_submit`, `created_at`, `updated_at`) VALUES
(54, 1526, '2023-11-21', '7.83', 1, 0, '2023-11-21 12:49:08', '2023-11-21 12:49:08');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
