-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2024 at 11:19 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flight_hours`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ahlam', 'ahlam.tabole@gmail.com', NULL, '$2y$12$Hpgzj9CvEUjs9M.Rqc.kUOOD1C.7tYDvqTcLoEqJQrS7GZS3uEofy', NULL, '2024-02-23 13:28:24', '2024-02-23 13:28:24'),
(2, 'admin', 'admin88@gmail.com', NULL, '$2y$12$Via2yG4f1KkFVxrtsswT3.CLzOd6vfU8dM5584mKCd7nYwmF.zgpW', NULL, '2024-02-23 14:08:25', '2024-02-23 14:08:25');

-- --------------------------------------------------------

--
-- Table structure for table `aircrafts`
--

CREATE TABLE `aircrafts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `aircraft_name` varchar(255) NOT NULL,
  `aircraft_code` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `status` enum('active','inactive','maintenance') NOT NULL,
  `registration_number` varchar(20) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aircrafts`
--

INSERT INTO `aircrafts` (`id`, `aircraft_name`, `aircraft_code`, `manufacturer`, `status`, `registration_number`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Boeing 747', 'B747', 'عزبة نجيب', 'active', '1231231', 6, '2024-06-06 08:32:18', '2024-06-16 13:11:46'),
(3, 'Aircraft 656', 'A656', 'France', 'inactive', '22458', 6, '2024-06-08 18:53:42', '2024-06-08 18:53:42'),
(10, 'Aircraft 656', 'A658', 'France', 'inactive', '11458', 6, '2024-06-08 18:52:13', '2024-06-08 18:52:13'),
(11, 'Aircraft XYZ', 'XYZ11', 'USA', 'active', '12345', 10, '2024-06-08 18:52:13', '2024-06-09 09:06:09'),
(12, 'Dawn Herring', 'Voluptates impedit', 'Rerum obcaecati recu', 'maintenance', '178', 6, '2024-06-14 13:34:48', '2024-06-14 13:34:48'),
(13, 'Carissa Harrison', 'Minus ut hic accusam', 'Ad dolores beatae a', 'active', '753', 6, '2024-06-14 13:34:53', '2024-06-14 13:34:53'),
(14, 'Charity Blair', 'Sunt proident simi', 'Recusandae Ad qui a', 'maintenance', '483', 6, '2024-06-14 13:36:00', '2024-06-14 13:36:00'),
(15, 'Samson', 'Pariatur Odio molli', 'Facere similique exc', 'active', '880', 6, '2024-06-14 13:36:22', '2024-06-14 13:36:48'),
(16, 'Jordan Tillman', 'Fugiat consectetur', 'Nesciunt voluptas e', 'active', '240', 6, '2024-06-14 13:37:25', '2024-06-14 13:37:25'),
(17, 'Geoffrey Houston', 'Ut ex recusandae Ut', 'Hic doloribus culpa', 'maintenance', '474', 6, '2024-06-14 13:38:25', '2024-06-14 13:38:25');

-- --------------------------------------------------------

--
-- Table structure for table `airports`
--

CREATE TABLE `airports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `airport_name` varchar(255) NOT NULL,
  `airport_code` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `airports`
--

INSERT INTO `airports` (`id`, `airport_name`, `airport_code`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Cairo Airport', 'CA11', 6, '2024-06-06 08:37:01', '2024-06-16 13:12:47'),
(3, 'Sohag AirPort After Edir', 'SH33', 6, '2024-06-06 08:37:37', '2024-06-08 18:17:31'),
(5, 'John F. Kennedy International Airport', 'JFK', 6, '2024-06-08 22:17:38', '2024-06-08 22:17:38'),
(6, 'Los Angeles International Airport', 'LAX', 6, '2024-06-08 22:17:38', '2024-06-08 22:17:38'),
(7, 'London Airport', 'LHR', 6, '2024-06-08 22:17:38', '2024-06-09 09:07:39'),
(8, 'Tokyo Haneda Airport', 'HND', 6, '2024-06-08 22:17:38', '2024-06-08 22:17:38'),
(9, 'Beijing Capital International Airport', 'PEK', 6, '2024-06-08 22:17:38', '2024-06-08 22:17:38'),
(10, 'Dubai International Airport', 'DXB', 10, '2024-06-08 22:17:38', '2024-06-08 22:17:38'),
(11, 'Paris Charles de Gaulle Airport', 'CDG', 10, '2024-06-08 22:17:38', '2024-06-08 22:17:38'),
(12, 'Singapore Changi Airport', 'SIN', 10, '2024-06-08 22:17:38', '2024-06-08 22:17:38'),
(13, 'Sydney Kingsford Smith Airport', 'SYD', 10, '2024-06-08 22:17:38', '2024-06-08 22:17:38'),
(14, 'Frankfurt Airport', 'FRA', 10, '2024-06-08 22:17:38', '2024-06-08 22:17:38'),
(15, 'Dara Gentry', 'AAA11', 6, '2024-06-14 13:31:27', '2024-06-14 13:31:27');

-- --------------------------------------------------------

--
-- Table structure for table `captins`
--

CREATE TABLE `captins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crews`
--

CREATE TABLE `crews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `financial_number` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `license_number` varchar(255) DEFAULT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `job_type` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `crews`
--

INSERT INTO `crews` (`id`, `financial_number`, `first_name`, `last_name`, `nickname`, `date_of_birth`, `license_number`, `job_id`, `job_type`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(24, '1000011', 'أحمد', 'الطرابلسي', 'أحمد الطرابلسي', '1980-01-01', 'LN0000', 17, 2, 'active', 10, '2024-06-15 15:13:38', '2024-06-16 13:53:18'),
(26, '100003', 'علي', 'المصراتي', 'علي', '1984-03-03', 'LN00003', 28, 1, 'active', 10, '2024-06-15 15:13:38', '2024-06-15 15:13:38'),
(27, '100004', 'خالد', 'سبهاوي', 'خالد', '1986-04-04', 'LN00004', 29, 2, 'active', 10, '2024-06-15 15:13:38', '2024-06-15 15:13:38'),
(28, '100005', 'عمر', 'البيضاوي', 'عمر', '1988-05-05', 'LN00005', 30, 1, 'inactive', 10, '2024-06-15 15:13:38', '2024-06-15 15:13:38'),
(29, '100006', 'يوسف', 'الزاوي', 'يوسف', '1990-06-06', 'LN00006', 31, 2, 'active', 10, '2024-06-15 15:13:38', '2024-06-15 15:13:38'),
(30, '100007', 'إبراهيم', 'الخمس', 'إبراهيم', '1992-07-07', 'LN00007', 32, 1, 'inactive', 10, '2024-06-15 15:13:38', '2024-06-15 15:13:38'),
(31, '100008', 'سعيد', 'المرج', 'سعيد', '1994-08-08', 'LN00008', 34, 2, 'active', 10, '2024-06-15 15:13:38', '2024-06-15 15:13:38'),
(32, '100009', 'عبدالله', 'غات', 'عبدالله', '1996-09-09', 'LN00009', 35, 1, 'inactive', 10, '2024-06-15 15:13:38', '2024-06-15 15:13:38'),
(33, '100010', 'عبدالرحمن', 'الزنتان', 'عبدالرحمن', '1998-10-10', 'LN00010', 36, 2, 'active', 10, '2024-06-15 15:13:38', '2024-06-15 15:13:38'),
(44, '300001', 'أحمد', 'السيد', 'أبو أحمد', '1980-01-01', 'LN20001', 1, 1, 'active', 6, '2024-06-15 15:15:26', '2024-06-15 15:15:26'),
(45, '300002', 'محمد', 'عبدالرحمن', 'أبو محمد', '1982-02-02', 'LN20002', 17, 2, 'inactive', 6, '2024-06-15 15:15:26', '2024-06-15 15:15:26'),
(46, '300003', 'علي', 'حسن', 'أبو علي', '1984-03-03', 'LN20003', 28, 1, 'active', 6, '2024-06-15 15:15:26', '2024-06-15 15:15:26'),
(47, '300004', 'خالد', 'عبدالله', 'أبو خالد', '1986-04-04', 'LN20004', 29, 2, 'active', 6, '2024-06-15 15:15:26', '2024-06-15 15:15:26'),
(48, '300005', 'عمر', 'مصطفى', 'أبو عمر', '1988-05-05', 'LN20005', 30, 1, 'inactive', 6, '2024-06-15 15:15:26', '2024-06-15 15:15:26'),
(49, '300006', 'يوسف', 'المنسي', 'أبو يوسف', '1990-06-06', 'LN20006', 31, 2, 'active', 6, '2024-06-15 15:15:26', '2024-06-15 15:15:26'),
(50, '300007', 'إبراهيم', 'الزهار', 'أبو إبراهيم', '1992-07-07', 'LN20007', 32, 1, 'inactive', 6, '2024-06-15 15:15:26', '2024-06-15 15:15:26'),
(51, '300008', 'سعيد', 'المصري', 'أبو سعيد', '1994-08-08', 'LN20008', 34, 2, 'active', 6, '2024-06-15 15:15:26', '2024-06-15 15:15:26'),
(52, '300009', 'عبدالله', 'سلامة', 'أبو عبدالله', '1996-09-09', 'LN20009', 35, 1, 'inactive', 6, '2024-06-15 15:15:26', '2024-06-15 15:15:26'),
(53, '300010', 'عبدالرحمن', 'مرسي', 'أبو عبدالرحمن', '1998-10-10', 'LN20010', 36, 2, 'active', 6, '2024-06-15 15:15:26', '2024-06-15 15:15:26'),
(54, '747', 'Zenia', 'Reeves', 'Nigel Guthrie', '1986-08-15', '790', 35, 2, 'inactive', 6, '2024-06-16 13:26:02', '2024-06-16 13:26:02');

-- --------------------------------------------------------

--
-- Table structure for table `crews_flights`
--

CREATE TABLE `crews_flights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `crew_id` bigint(20) UNSIGNED NOT NULL,
  `training_start_at` time DEFAULT NULL,
  `training_end_at` time DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `crews_flights`
--

INSERT INTO `crews_flights` (`id`, `flight_id`, `crew_id`, `training_start_at`, `training_end_at`, `user_id`, `created_at`, `updated_at`) VALUES
(83, 5, 26, '10:54:00', '11:54:00', 6, '2024-07-07 20:05:11', '2024-07-07 20:05:11'),
(84, 5, 27, '13:54:00', '15:54:00', 6, '2024-07-07 20:05:11', '2024-07-07 20:05:11'),
(86, 6, 27, '05:18:00', '06:18:00', 6, '2024-07-07 20:18:22', '2024-07-07 20:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `crew_normal_flights`
--

CREATE TABLE `crew_normal_flights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `crew_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `crew_normal_flights`
--

INSERT INTO `crew_normal_flights` (`id`, `flight_id`, `crew_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 77, 27, 6, '2024-07-07 20:16:05', '2024-07-07 20:16:05'),
(2, 78, 27, 6, '2024-07-07 20:16:05', '2024-07-07 20:16:05'),
(3, 77, 26, 6, '2024-07-07 20:16:05', '2024-07-07 20:16:05'),
(4, 78, 26, 6, '2024-07-07 20:16:05', '2024-07-07 20:16:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flight_number` varchar(200) NOT NULL,
  `flight_date` date NOT NULL,
  `aircraft_id` bigint(20) UNSIGNED NOT NULL,
  `origin_airport_id` bigint(20) UNSIGNED NOT NULL,
  `destination_airport_id` bigint(20) UNSIGNED NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `aircraft_number` varchar(255) NOT NULL,
  `flight_type` enum('normal_flight','simulated_flight','unloaded_flight','airplane_test') NOT NULL DEFAULT 'normal_flight'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `flight_number`, `flight_date`, `aircraft_id`, `origin_airport_id`, `destination_airport_id`, `departure_time`, `arrival_time`, `user_id`, `created_at`, `updated_at`, `aircraft_number`, `flight_type`) VALUES
(59, '533', '1969-06-21', 2, 11, 7, '13:35:00', '16:47:00', 6, '2024-07-03 06:21:59', '2024-07-03 06:21:59', '860', 'normal_flight'),
(60, '414', '1970-02-06', 10, 8, 6, '20:00:00', '21:00:00', 6, '2024-07-03 06:21:59', '2024-07-03 06:21:59', '350', 'unloaded_flight'),
(61, '976', '1996-03-06', 11, 6, 9, '10:00:00', '11:00:00', 6, '2024-07-03 06:28:18', '2024-07-03 06:28:18', '25', 'normal_flight'),
(62, '553', '2003-04-26', 15, 7, 6, '08:30:00', '10:00:00', 6, '2024-07-03 06:28:18', '2024-07-03 06:28:18', '19', 'normal_flight'),
(63, '371', '1979-12-27', 3, 8, 14, '10:01:00', '11:35:00', 6, '2024-07-03 14:42:07', '2024-07-03 14:42:07', '475', 'normal_flight'),
(64, '35', '1983-11-09', 10, 14, 10, '16:17:00', '03:59:00', 6, '2024-07-03 14:42:07', '2024-07-03 14:42:07', '389', 'normal_flight'),
(65, '21', '1986-11-22', 16, 15, 11, '15:01:00', '19:29:00', 6, '2024-07-03 14:46:52', '2024-07-03 14:46:52', '978', 'normal_flight'),
(66, '837', '1996-10-14', 11, 11, 8, '19:42:00', '23:25:00', 6, '2024-07-03 14:46:52', '2024-07-03 14:46:52', '833', 'normal_flight'),
(67, '683', '1995-06-13', 15, 3, 15, '05:41:00', '06:58:00', 6, '2024-07-03 14:57:46', '2024-07-03 14:57:46', '36', 'normal_flight'),
(68, '91', '1997-05-17', 10, 15, 3, '18:08:00', '20:37:00', 6, '2024-07-03 14:57:46', '2024-07-03 14:57:46', '83', 'normal_flight'),
(69, '784', '1973-03-31', 2, 11, 3, '22:26:00', '23:12:00', 6, '2024-07-03 14:59:17', '2024-07-03 14:59:17', '17', 'normal_flight'),
(70, '775', '2015-10-23', 13, 3, 7, '17:28:00', '23:00:00', 6, '2024-07-03 14:59:17', '2024-07-03 14:59:17', '718', 'normal_flight'),
(71, '862', '2002-08-28', 13, 10, 8, '10:28:00', '11:53:00', 6, '2024-07-03 15:09:08', '2024-07-03 15:09:08', '132', 'normal_flight'),
(72, '88', '2016-08-31', 3, 11, 13, '03:02:00', '04:23:00', 6, '2024-07-03 15:09:08', '2024-07-03 15:09:08', '564', 'normal_flight'),
(73, '236', '2004-01-18', 16, 2, 3, '18:10:00', '21:57:00', 6, '2024-07-03 15:11:04', '2024-07-03 15:11:04', '953', 'normal_flight'),
(74, '636', '2022-09-03', 11, 12, 7, '10:00:00', '11:00:00', 6, '2024-07-03 15:11:04', '2024-07-03 15:11:04', '569', 'normal_flight'),
(75, '301', '2017-08-28', 2, 14, 3, '16:42:00', '18:46:00', 6, '2024-07-07 20:07:32', '2024-07-07 20:07:32', '697', 'normal_flight'),
(76, '991', '2020-06-26', 11, 3, 15, '19:39:00', '21:33:00', 6, '2024-07-07 20:07:32', '2024-07-07 20:07:32', '328', 'normal_flight'),
(77, '271', '2001-07-07', 12, 15, 3, '03:58:00', '07:34:00', 6, '2024-07-07 20:16:05', '2024-07-07 20:16:05', '678', 'normal_flight'),
(78, '663', '2002-05-19', 14, 3, 15, '12:02:00', '13:43:00', 6, '2024-07-07 20:16:05', '2024-07-07 20:16:05', '257', 'normal_flight');

-- --------------------------------------------------------

--
-- Table structure for table `flight_hours`
--

CREATE TABLE `flight_hours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `aircraft_id` bigint(20) UNSIGNED NOT NULL,
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `hours` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flight_hours`
--

INSERT INTO `flight_hours` (`id`, `aircraft_id`, `flight_id`, `hours`, `created_at`, `updated_at`) VALUES
(50, 2, 59, 3.20, '2024-07-03 06:21:59', '2024-07-03 06:21:59'),
(51, 10, 60, 1.00, '2024-07-03 06:21:59', '2024-07-03 06:21:59'),
(52, 11, 61, 1.00, '2024-07-03 06:28:18', '2024-07-03 06:28:18'),
(53, 15, 62, 1.50, '2024-07-03 06:28:18', '2024-07-03 06:28:18'),
(54, 3, 63, 1.57, '2024-07-03 14:42:07', '2024-07-03 14:42:07'),
(55, 10, 64, 6.70, '2024-07-03 14:42:07', '2024-07-03 14:42:07'),
(56, 16, 65, 4.47, '2024-07-03 14:46:52', '2024-07-03 14:46:52'),
(57, 11, 66, 3.72, '2024-07-03 14:46:52', '2024-07-03 14:46:52'),
(58, 15, 67, 1.28, '2024-07-03 14:57:46', '2024-07-03 14:57:46'),
(59, 10, 68, 2.48, '2024-07-03 14:57:46', '2024-07-03 14:57:46'),
(60, 2, 69, 0.77, '2024-07-03 14:59:17', '2024-07-03 14:59:17'),
(61, 13, 70, 5.53, '2024-07-03 14:59:17', '2024-07-03 14:59:17'),
(62, 13, 71, 1.42, '2024-07-03 15:09:08', '2024-07-03 15:09:08'),
(63, 3, 72, 1.35, '2024-07-03 15:09:09', '2024-07-03 15:09:09'),
(64, 16, 73, 3.78, '2024-07-03 15:11:04', '2024-07-03 15:11:04'),
(65, 11, 74, 1.00, '2024-07-03 15:11:04', '2024-07-03 15:11:04'),
(66, 2, 75, 2.07, '2024-07-07 20:07:32', '2024-07-07 20:07:32'),
(67, 11, 76, 1.90, '2024-07-07 20:07:32', '2024-07-07 20:07:32'),
(68, 12, 77, 3.60, '2024-07-07 20:16:05', '2024-07-07 20:16:05'),
(69, 14, 78, 1.68, '2024-07-07 20:16:05', '2024-07-07 20:16:05');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_name` varchar(255) NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_name`, `type_id`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Captain After', 2, 'inactive', 6, '2024-06-07 08:07:50', '2024-06-16 13:13:10'),
(17, 'Captain', 2, 'inactive', 6, '2024-06-07 13:34:47', '2024-06-07 13:34:47'),
(28, 'Pilot', 1, 'active', 6, '2024-06-08 22:19:09', '2024-06-08 22:19:09'),
(29, 'Flight Attendant', 2, 'active', 6, '2024-06-08 22:19:09', '2024-06-08 22:19:09'),
(30, 'Aircraft Mechanic', 1, 'inactive', 6, '2024-06-08 22:19:09', '2024-06-09 09:09:14'),
(31, 'Ground Crew', 2, 'inactive', 6, '2024-06-08 22:19:09', '2024-06-08 22:19:09'),
(32, 'Dispatch Coordinator', 1, 'active', 6, '2024-06-08 22:19:09', '2024-06-08 22:19:09'),
(33, 'Air Traffic Controller', 2, 'active', 10, '2024-06-08 22:19:09', '2024-06-08 22:19:09'),
(34, 'Airport Operations Manager', 1, 'inactive', 10, '2024-06-08 22:19:09', '2024-06-08 22:19:09'),
(35, 'Cargo Handler', 2, 'active', 10, '2024-06-08 22:19:09', '2024-06-08 22:19:09'),
(36, 'Security Officer', 1, 'inactive', 10, '2024-06-08 22:19:09', '2024-06-08 22:19:09'),
(37, 'Customer Service Agent', 2, 'active', 10, '2024-06-08 22:19:09', '2024-06-08 22:19:09'),
(38, 'Zelda Day', 2, 'inactive', 6, '2024-06-16 14:57:05', '2024-06-16 14:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `job_types`
--

CREATE TABLE `job_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_types`
--

INSERT INTO `job_types` (`id`, `job_type`) VALUES
(1, 'الطاقم الفني'),
(2, 'طاقم الضيافة');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_01_000000_create_admins_table ', 2),
(6, '2024_02_02_000000_create_captins_table', 2),
(7, '2024_02_26_141352_create_jobs_categories_table', 3),
(8, '2024_06_03_200954_create_jobs_table', 3),
(9, '2024_06_03_201008_create_aircrafts_table', 3),
(10, '2024_06_03_201022_create_airports_table', 3),
(11, '2024_06_03_201040_create_flights_table', 3),
(12, '2024_06_03_201059_create_crews_table', 4),
(13, '2024_06_03_203226_create_crews_flights_table', 5),
(14, '2024_06_03_203743_create_flight_hours_table', 6),
(15, '2024_06_05_130019_add_table_job_types', 7),
(16, '2024_06_05_130313_add_column_to_job_table', 7),
(19, '2024_06_06_130024_add_columns_to_aircraft_table', 8),
(20, '2024_06_07_200706_add_role_to_users_table', 9),
(21, '2024_06_10_115236_make_columns_nullable_on_crew_table', 10),
(22, '2024_06_10_125439_drop_column_from_crew_table', 11),
(23, '2024_06_11_133510_add_column_to_flights_table', 12),
(24, '2024_06_11_134300_drop_column_from_flights_table', 13),
(25, '2024_06_14_154904_add_columns_to_flights_table', 14),
(26, '2024_06_15_160956_add_landing_time_to_flights_table', 15),
(27, '2024_06_27_030101_delete_columns_from_flights_table', 16),
(28, '2024_06_27_033739_add_default_value_to_column_in_flights_table', 17),
(29, '2024_07_04_125020_create_other_flights_table', 18),
(30, '2024_07_04_130552_add_columns_to_crews_flights_table', 19),
(31, '2024_07_06_181217_add_flight_type_to_other_flights_table', 20),
(32, '2024_07_07_230057_update_crews_flights_table', 21),
(33, '2024_07_07_231052_add_crew_normal_flights_table', 22);

-- --------------------------------------------------------

--
-- Table structure for table `other_flights`
--

CREATE TABLE `other_flights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `airport_id` bigint(20) UNSIGNED NOT NULL,
  `aircraft_id` bigint(20) UNSIGNED NOT NULL,
  `flight_number` varchar(200) NOT NULL,
  `flight_date` date NOT NULL,
  `flight_type` enum('simulated_flight','unloaded_flight','airplane_test') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_flights`
--

INSERT INTO `other_flights` (`id`, `airport_id`, `aircraft_id`, `flight_number`, `flight_date`, `flight_type`, `created_at`, `updated_at`) VALUES
(5, 7, 13, '111', '2024-07-17', 'simulated_flight', '2024-07-07 20:05:11', '2024-07-07 20:05:11'),
(6, 2, 11, '910', '2024-07-23', 'airplane_test', '2024-07-07 20:18:22', '2024-07-07 20:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('admin@gmail.com', '$2y$12$0sse0pqSe2bkUIZ/ugqMiOz8dMXdaNdPugZ9jMKAhMS1LV8C5IL6y', '2024-02-12 13:55:50'),
('admin88@gmail.com', '$2y$12$2ipjpPqHNm29tXEQxM7FxeutbsdVl/J5k3FzL8IH0Wyu50nkk.jge', '2024-02-26 08:29:32'),
('ahlam.tabole@gmail.com', '$2y$12$Z3QtMKt3JY7gtyCzX8cyquVzb1iOzRJrJbFGr84zjkuyVfiewo1G6', '2024-02-26 09:52:48'),
('ali@gmail.com', '$2y$12$FLcvP71962R.nUBlSRDgdu6LHIExM5NC7ljXtwZyy4uY/ZbXC0Y3O', '2024-02-26 12:03:30'),
('user@gmail.com', '$2y$12$0kz.LfQTbaC2DPx4Q7hTAu.wikWF2BimazCLpyoT6cUDLhtkyG5SS', '2024-02-20 11:59:42');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('captain','employee','admin') NOT NULL DEFAULT 'employee',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(6, 'Mohamed Saad', 'saad@gmail.com', 'employee', NULL, '$2y$12$Us43fyFNjmvRVDwXEkjwlO8XH/7UEqoDQ/w47qz.X0vScDFPE1r6G', NULL, '2024-06-03 17:07:21', '2024-06-03 17:07:21'),
(9, 'Mohamed Adel', 'admin@gmail.com', 'admin', NULL, '$2y$10$vGbeK98zc4V50WDutCHUme7cYVRAT6m4W0zatD7PB6MhcMY/pgUmq', NULL, '2024-06-07 22:39:28', '2024-06-07 22:39:28'),
(10, 'Ahlam Taboli', 'ahlam@gmail.com', 'employee', NULL, '$2y$10$rKnHI9TDxu.4VgMSeK4gE.fRnw32Pg5LXEuVKviZDpe3Dmckq0wMG', NULL, '2024-06-07 22:39:29', '2024-06-07 22:39:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `aircrafts`
--
ALTER TABLE `aircrafts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aircrafts_aircraft_code_unique` (`aircraft_code`),
  ADD UNIQUE KEY `aircrafts_registration_number_unique` (`registration_number`),
  ADD KEY `aircrafts_user_id_foreign` (`user_id`);

--
-- Indexes for table `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `airports_airport_code_unique` (`airport_code`),
  ADD KEY `airports_user_id_foreign` (`user_id`);

--
-- Indexes for table `captins`
--
ALTER TABLE `captins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `captins_email_unique` (`email`);

--
-- Indexes for table `crews`
--
ALTER TABLE `crews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crews_user_id_foreign` (`user_id`),
  ADD KEY `crews_job_id_foreign` (`job_id`),
  ADD KEY `job_type` (`job_type`);

--
-- Indexes for table `crews_flights`
--
ALTER TABLE `crews_flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crews_flights_user_id_foreign` (`user_id`),
  ADD KEY `crews_flights_crew_id_foreign` (`crew_id`),
  ADD KEY `crews_flights_flight_id_foreign` (`flight_id`);

--
-- Indexes for table `crew_normal_flights`
--
ALTER TABLE `crew_normal_flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crew_normal_flights_user_id_foreign` (`user_id`),
  ADD KEY `crew_normal_flights_flight_id_foreign` (`flight_id`),
  ADD KEY `crew_normal_flights_crew_id_foreign` (`crew_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flights_user_id_foreign` (`user_id`),
  ADD KEY `flights_aircraft_id_foreign` (`aircraft_id`),
  ADD KEY `flights_origin_airport_id_foreign` (`origin_airport_id`),
  ADD KEY `flights_destination_airport_id_foreign` (`destination_airport_id`);

--
-- Indexes for table `flight_hours`
--
ALTER TABLE `flight_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flight_hours_aircraft_id_foreign` (`aircraft_id`),
  ADD KEY `flight_hours_flight_id_foreign` (`flight_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_user_id_foreign` (`user_id`),
  ADD KEY `jobs_type_id_foreign` (`type_id`);

--
-- Indexes for table `job_types`
--
ALTER TABLE `job_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_flights`
--
ALTER TABLE `other_flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `other_flights_airport_id_foreign` (`airport_id`),
  ADD KEY `other_flights_aircraft_id_foreign` (`aircraft_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `aircrafts`
--
ALTER TABLE `aircrafts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `airports`
--
ALTER TABLE `airports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `captins`
--
ALTER TABLE `captins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crews`
--
ALTER TABLE `crews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `crews_flights`
--
ALTER TABLE `crews_flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `crew_normal_flights`
--
ALTER TABLE `crew_normal_flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `flight_hours`
--
ALTER TABLE `flight_hours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `job_types`
--
ALTER TABLE `job_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `other_flights`
--
ALTER TABLE `other_flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aircrafts`
--
ALTER TABLE `aircrafts`
  ADD CONSTRAINT `aircrafts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `airports`
--
ALTER TABLE `airports`
  ADD CONSTRAINT `airports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `crews`
--
ALTER TABLE `crews`
  ADD CONSTRAINT `crews_ibfk_1` FOREIGN KEY (`job_type`) REFERENCES `job_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crews_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `crews_flights`
--
ALTER TABLE `crews_flights`
  ADD CONSTRAINT `crews_flights_crew_id_foreign` FOREIGN KEY (`crew_id`) REFERENCES `crews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crews_flights_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `other_flights` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crews_flights_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `crew_normal_flights`
--
ALTER TABLE `crew_normal_flights`
  ADD CONSTRAINT `crew_normal_flights_crew_id_foreign` FOREIGN KEY (`crew_id`) REFERENCES `crews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crew_normal_flights_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crew_normal_flights_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `flights_aircraft_id_foreign` FOREIGN KEY (`aircraft_id`) REFERENCES `aircrafts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flights_destination_airport_id_foreign` FOREIGN KEY (`destination_airport_id`) REFERENCES `airports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flights_origin_airport_id_foreign` FOREIGN KEY (`origin_airport_id`) REFERENCES `airports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flights_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `flight_hours`
--
ALTER TABLE `flight_hours`
  ADD CONSTRAINT `flight_hours_aircraft_id_foreign` FOREIGN KEY (`aircraft_id`) REFERENCES `aircrafts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flight_hours_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `job_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `other_flights`
--
ALTER TABLE `other_flights`
  ADD CONSTRAINT `other_flights_aircraft_id_foreign` FOREIGN KEY (`aircraft_id`) REFERENCES `aircrafts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `other_flights_airport_id_foreign` FOREIGN KEY (`airport_id`) REFERENCES `airports` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
