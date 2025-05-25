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
-- Table structure for table `project_documents`
--

DROP TABLE IF EXISTS `project_documents`;
CREATE TABLE IF NOT EXISTS `project_documents` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL,
  `document_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_documents`
--

INSERT INTO `project_documents` (`id`, `project_id`, `document_name`, `document_file`, `created_at`, `updated_at`) VALUES
(1, 16, 'sms', 'C:\\wamp64\\tmp\\php8F7C.tmp', '2023-10-28 14:28:11', '2023-10-29 02:36:19'),
(2, 16, 'sa', 'document/OR6H8uVwHBoxiSsyV82pszDD9Ygpc7iKcQExDUDo.xls', '2023-11-06 13:32:59', '2023-11-06 13:32:59'),
(3, 16, 'sd', 'document/FT1ybZxpAjDBBj6UVd0dX07MXthXkXPMLHyJtBwh.xls', '2023-11-06 13:32:59', '2023-11-06 13:32:59');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
