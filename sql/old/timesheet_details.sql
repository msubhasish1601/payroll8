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
-- Table structure for table `timesheet_details`
--

DROP TABLE IF EXISTS `timesheet_details`;
CREATE TABLE IF NOT EXISTS `timesheet_details` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `timesheet_id` bigint(20) NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `task` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_status` enum('Pending','In Progress','Complete') COLLATE utf8mb4_unicode_ci NOT NULL,
  `hours` int(11) NOT NULL DEFAULT '0',
  `minutes` int(11) NOT NULL DEFAULT '0' COMMENT 'as picked from droplist having interval of 10mins like 0,10,20,30,40,50',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timesheet_details`
--

INSERT INTO `timesheet_details` (`id`, `timesheet_id`, `project_id`, `task`, `description`, `task_status`, `hours`, `minutes`, `created_at`, `updated_at`) VALUES
(82, 54, 19, '\"none\"', 'ass', 'In Progress', 4, 30, '2023-11-21 12:49:08', '2023-11-21 12:49:08'),
(81, 54, 19, '\"dgd\"', 'ss', 'Pending', 3, 20, '2023-11-21 12:49:08', '2023-11-21 12:49:08');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
