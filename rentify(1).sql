-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 11, 2026 at 02:49 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentify`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `car_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `booking_status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `pickup_location` varchar(50) DEFAULT NULL,
  `has_chauffeur` tinyint(1) NOT NULL DEFAULT '0',
  `has_gps` tinyint(1) NOT NULL DEFAULT '0',
  `has_full_insurance` tinyint(1) NOT NULL DEFAULT '0',
  `security_deposit_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `car_id`, `start_date`, `end_date`, `total_price`, `booking_status`, `pickup_location`, `has_chauffeur`, `has_gps`, `has_full_insurance`, `security_deposit_amount`, `created`, `modified`) VALUES
(3, 3, 2, '2025-12-24', '2025-12-26', '180.00', 'confirmed', NULL, 0, 0, 0, '0.00', '2025-12-21 06:33:39', '2025-12-21 06:34:24'),
(8, 4, 1, '2026-01-13', '2026-01-14', '200.00', 'cancelled', NULL, 0, 0, 0, '0.00', '2025-12-22 14:26:42', '2025-12-23 07:15:40'),
(9, 4, 2, '2025-12-29', '2025-12-30', '90.00', 'completed', 'city', 0, 0, 0, '0.00', '2025-12-23 07:13:28', '2026-01-01 04:04:06'),
(10, 4, 2, '2025-12-31', '2025-12-31', '90.00', 'completed', NULL, 0, 0, 0, '0.00', '2025-12-23 10:39:25', '2026-01-01 04:04:06'),
(12, 4, 1, '2025-12-30', '2025-12-30', '200.00', 'completed', NULL, 0, 0, 0, '0.00', '2025-12-23 12:53:56', '2026-01-01 04:04:06'),
(13, 4, 1, '2026-01-01', '2026-01-01', '200.00', 'completed', NULL, 0, 0, 0, '0.00', '2025-12-23 14:06:57', '2026-01-02 12:26:32'),
(14, 4, 2, '2025-12-28', '2025-12-28', '90.00', 'completed', NULL, 0, 0, 0, '0.00', '2025-12-23 14:08:41', '2026-01-01 04:04:06'),
(21, 4, 6, '2025-12-28', '2025-12-28', '120.00', 'completed', NULL, 0, 0, 0, '0.00', '2025-12-27 04:43:39', '2026-01-01 04:04:06'),
(23, 4, 2, '2026-01-01', '2026-01-02', '190.80', 'completed', 'city', 0, 0, 0, '0.00', '2025-12-27 13:43:22', '2026-01-03 03:00:12'),
(24, 4, 3, '2025-12-29', '2025-12-29', '137.80', 'cancelled', 'south', 0, 0, 0, '0.00', '2025-12-28 20:57:54', '2025-12-28 22:37:39'),
(27, 4, 3, '2025-12-30', '2025-12-30', '137.80', 'cancelled', 'city', 0, 0, 0, '0.00', '2025-12-29 02:18:16', '2025-12-29 02:19:46'),
(31, 4, 5, '2025-12-31', '2025-12-31', '2120.00', 'cancelled', 'city', 0, 0, 0, '0.00', '2025-12-30 04:07:51', '2025-12-30 04:22:00'),
(32, 4, 3, '2025-12-31', '2025-12-31', '137.80', 'cancelled', 'city', 0, 0, 1, '0.00', '2025-12-30 04:21:29', '2025-12-30 04:21:55'),
(34, 4, 5, '2026-01-01', '2026-01-02', '5316.96', 'cancelled', 'airport', 1, 0, 1, '500.00', '2025-12-30 04:24:09', '2025-12-31 04:17:50'),
(35, 11, 5, '2026-01-03', '2026-01-04', '5528.96', 'confirmed', 'airport', 1, 1, 1, '500.00', '2025-12-30 04:31:27', '2025-12-30 04:31:49'),
(36, 4, 7, '2025-12-31', '2026-01-02', '622.23', 'completed', 'city', 1, 0, 1, '50.90', '2025-12-30 22:06:31', '2026-01-03 03:00:12'),
(38, 4, 5, '2026-01-01', '2026-01-01', '2385.00', 'cancelled', 'city', 1, 0, 0, '500.00', '2025-12-31 04:59:59', '2025-12-31 05:00:48'),
(39, 11, 3, '2026-01-02', '2026-01-02', '137.80', 'completed', 'city', 0, 0, 0, '0.00', '2026-01-01 17:59:10', '2026-01-03 13:27:33'),
(40, 11, 5, '2026-01-01', '2026-01-01', '2393.48', 'completed', 'airport', 0, 0, 1, '500.00', '2026-01-01 21:46:18', '2026-01-02 09:40:24'),
(41, 11, 4, '2026-01-02', '2026-01-02', '106.00', 'completed', 'airport', 0, 0, 0, '0.00', '2026-01-01 21:54:48', '2026-01-03 13:27:33'),
(42, 11, 2, '2026-01-03', '2026-01-03', '143.81', 'confirmed', 'city', 1, 0, 0, '50.90', '2026-01-01 22:00:41', '2026-01-01 22:01:19'),
(43, 11, 1, '2026-01-02', '2026-01-06', '1060.00', 'confirmed', 'airport', 0, 0, 0, '0.00', '2026-01-01 22:07:04', '2026-01-01 22:07:33'),
(44, 11, 4, '2026-01-03', '2026-01-03', '106.00', 'confirmed', 'airport', 0, 0, 0, '0.00', '2026-01-02 09:40:55', '2026-01-02 09:41:10'),
(45, 4, 1, '2026-01-07', '2026-01-08', '636.00', 'cancelled', 'city', 1, 0, 0, '150.00', '2026-01-02 19:49:44', '2026-01-04 00:28:57'),
(46, 13, 7, '2026-01-04', '2026-01-06', '477.00', 'completed', 'north', 0, 0, 1, '50.90', '2026-01-03 03:04:42', '2026-01-10 01:08:22'),
(47, 13, 5, '2026-01-06', '2026-01-06', '2393.48', 'cancelled', 'city', 0, 0, 1, '500.00', '2026-01-03 03:10:16', '2026-01-03 03:24:03'),
(48, 13, 3, '2026-01-03', '2026-01-03', '137.80', 'completed', 'airport', 0, 0, 0, '0.00', '2026-01-03 03:27:01', '2026-01-05 09:14:05'),
(49, 13, 3, '2026-01-06', '2026-01-06', '161.80', 'completed', 'city', 0, 0, 1, '40.00', '2026-01-04 02:31:29', '2026-01-10 01:08:22'),
(50, 11, 5, '2026-01-05', '2026-01-05', '2658.48', 'confirmed', 'city', 1, 0, 1, '500.00', '2026-01-04 22:26:01', '2026-01-04 22:26:24'),
(51, 11, 7, '2026-01-07', '2026-01-07', '207.41', 'confirmed', 'airport', 1, 0, 1, '50.90', '2026-01-04 22:51:07', '2026-01-04 22:51:39'),
(52, 13, 5, '2026-01-06', '2026-01-06', '2393.48', 'completed', 'city', 0, 0, 1, '500.00', '2026-01-05 09:13:00', '2026-01-10 01:08:22'),
(53, 4, 5, '2026-01-07', '2026-01-07', '2658.48', 'confirmed', 'airport', 1, 0, 1, '500.00', '2026-01-05 15:26:10', '2026-01-05 15:26:24'),
(54, 16, 5, '2026-01-09', '2026-01-14', '12720.00', 'cancelled', 'airport', 0, 0, 0, '500.00', '2026-01-06 18:27:52', '2026-01-06 18:29:05'),
(55, 16, 5, '2026-01-08', '2026-01-08', '2120.00', 'confirmed', 'airport', 0, 0, 0, '500.00', '2026-01-06 18:28:16', '2026-01-06 18:29:18'),
(56, 13, 5, '2026-01-10', '2026-01-10', '2120.00', 'cancelled', 'airport', 0, 0, 0, '500.00', '2026-01-10 16:32:42', '2026-01-11 10:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `car_model` varchar(100) NOT NULL,
  `plate_number` varchar(50) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `year` int DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `status` enum('available','maintenance') DEFAULT 'available',
  `image` varchar(255) DEFAULT NULL,
  `transmission` enum('automatic','manual') NOT NULL,
  `seats` int NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `engine` varchar(100) DEFAULT NULL,
  `zero_to_sixty` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `category_id`, `car_model`, `plate_number`, `brand`, `year`, `price_per_day`, `status`, `image`, `transmission`, `seats`, `created`, `modified`, `engine`, `zero_to_sixty`) VALUES
(1, 5, 'Trump The Beast', 'VGJ 2233', 'Alfa Romeo', 2025, '200.00', 'available', 'beast.jpg', 'automatic', 4, '2025-12-20 11:54:56', '2026-01-10 00:52:05', '', ''),
(2, 2, 'Hilux', 'JGV 2323', 'Mitsubishi', 2023, '90.00', 'available', 'hilux.jpg', 'automatic', 4, '2025-12-21 06:32:41', '2025-12-27 05:58:51', '5.2L v10', '2.9s'),
(3, 1, 'Model 3', 'FCK 2032', 'Tesla', 2022, '130.00', 'available', 'tesla_model3.png', 'automatic', 4, '2025-12-23 22:01:37', '2025-12-23 22:01:37', 'electric', '1.0s'),
(4, 3, 'Civic', 'PLO 2939', 'Honda', 2020, '100.00', 'available', 'honda_civic.jpg', 'automatic', 4, '2025-12-23 22:05:14', '2025-12-29 17:37:04', '3.0L', '0.5s'),
(5, 7, 'F8', 'MNS 8080', 'Ferrari', 2019, '2000.00', 'available', 'ferrari-f8-1766566471.jpg', 'automatic', 2, '2025-12-24 08:50:06', '2026-01-11 10:35:44', '5.2L v10', '5.8s'),
(6, 2, 'CR-V', 'GAY 3232', 'Honda', 2025, '120.00', 'available', 'honda-cr-v-1766775252.png', 'automatic', 6, '2025-12-27 00:22:56', '2026-01-04 01:23:38', '1.5L', '9.0s'),
(7, 2, 'X50', 'NAF 2729', 'Proton', 2020, '130.00', 'available', 'proton-x50-1767103451.jpeg', 'automatic', 5, '2025-12-30 22:04:11', '2025-12-30 22:04:11', '', ''),
(8, 2, 'GT12', 'PLO 2323', 'Range Rover', 2026, '190.00', 'available', NULL, 'automatic', 6, '2026-01-04 01:25:31', '2026-01-04 01:25:31', '2.5L', '3.2s'),
(9, 3, 'Myvi', 'PLO 2930', 'Perodua', 2026, '100.00', 'available', 'cars\\perodua-myvi_1767537476.jpg', 'automatic', 4, '2026-01-04 22:37:56', '2026-01-05 23:02:12', '1.5L', '1.0s'),
(10, 3, 'Axia Rahmah', 'ZHD 2920', 'Perodua', 2025, '80.00', 'available', 'cars\\perodua-axia-rahmah_1767540914.jpeg', 'manual', 5, '2026-01-04 23:35:14', '2026-01-04 23:35:14', '1.2L', '2.9s');

-- --------------------------------------------------------

--
-- Table structure for table `car_categories`
--

CREATE TABLE `car_categories` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `security_deposit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `insurance_tier` varchar(50) NOT NULL DEFAULT 'basic',
  `insurance_daily_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `chauffeur_available` tinyint(1) NOT NULL DEFAULT '0',
  `chauffeur_daily_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gps_available` tinyint(1) NOT NULL DEFAULT '0',
  `gps_daily_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `badge_color` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `car_categories`
--

INSERT INTO `car_categories` (`id`, `name`, `description`, `security_deposit`, `insurance_tier`, `insurance_daily_rate`, `chauffeur_available`, `chauffeur_daily_rate`, `gps_available`, `gps_daily_rate`, `created`, `modified`, `badge_color`) VALUES
(1, 'Sedan', 'A car body style defined by its \"three-box\" design: a separate engine compartment, a passenger cabin, and a distinct, enclosed trunk for cargo, typically with four doors and seating for four to five people, offering comfort, practicality, and good fuel economy for everyday use.', '40.00', 'basic', '22.64', 0, '0.00', 1, '7.20', '2025-12-20 05:38:19', '2026-01-04 01:59:31', '#07edc7'),
(2, 'SUV', 'Big Cars', '50.90', 'standard', '20.00', 1, '45.67', 1, '15.00', '2025-12-20 20:13:07', '2026-01-04 01:26:05', '#bc10bc'),
(3, 'Economy', 'Budget-friendly compact cars', '35.00', 'standard', '20.00', 1, '20.00', 0, '0.00', '2025-12-21 16:24:17', '2026-01-04 22:38:53', '#2b0fff'),
(4, 'Compact', 'Slightly larger than economy,but still efficient', '50.00', 'standard', '45.00', 1, '32.80', 1, '20.00', '2025-12-21 16:24:17', '2025-12-30 03:46:25', ''),
(5, 'Luxury', 'Premium vehicles', '150.00', 'premium', '90.00', 1, '100.00', 1, '10.00', '2025-12-21 16:24:17', '2026-01-04 01:19:08', '#0000ff'),
(7, 'Sports', 'High-performance vehicles', '500.00', 'premium', '258.00', 1, '250.00', 1, '100.00', '2025-12-21 16:24:17', '2026-01-04 01:43:28', '#ff0000'),
(8, 'Electric/Hybrid', 'Eco-friendly vehicles', '50.20', 'standard', '40.00', 1, '30.00', 1, '0.00', '2025-12-21 16:24:17', '2025-12-31 20:05:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('unpaid','paid','cancelled') DEFAULT 'unpaid',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `booking_id`, `invoice_number`, `amount`, `status`, `created`, `modified`) VALUES
(3, 3, 'INV-694794C39CE0C', '180.00', 'paid', '2025-12-21 06:33:39', '2025-12-21 06:34:24'),
(8, 8, 'INV-69495522BA03D', '200.00', 'cancelled', '2025-12-22 14:26:42', '2025-12-23 07:15:40'),
(9, 9, 'INV-694A41185C330', '90.00', 'paid', '2025-12-23 07:13:28', '2025-12-23 07:13:47'),
(10, 10, 'INV-694A715D179F0', '90.00', 'paid', '2025-12-23 10:39:25', '2025-12-23 10:39:46'),
(12, 12, 'INV-694A90E47F17C', '200.00', 'paid', '2025-12-23 12:53:56', '2025-12-23 12:54:09'),
(13, 13, 'INV-694AA2018567F', '200.00', 'paid', '2025-12-23 14:06:57', '2025-12-23 14:07:20'),
(14, 14, 'INV-694AA2695CB84', '90.00', 'paid', '2025-12-23 14:08:41', '2025-12-23 14:08:58'),
(21, 21, 'INV-694EF37B9F4B9', '120.00', 'paid', '2025-12-27 04:43:39', '2025-12-28 22:44:40'),
(23, 23, 'INV-694F71FA74BA8', '190.80', 'paid', '2025-12-27 13:43:22', '2025-12-27 15:46:51'),
(24, 24, 'INV-69512953064D8', '137.80', 'cancelled', '2025-12-28 20:57:55', '2025-12-28 22:37:39'),
(27, 27, 'INV-6951746888432', '137.80', 'cancelled', '2025-12-29 02:18:16', '2025-12-29 02:19:46'),
(31, 31, 'INV-6952DF97047ED', '2120.00', 'cancelled', '2025-12-30 04:07:51', '2025-12-30 04:22:00'),
(32, 32, 'INV-6952E2C938143', '137.80', 'cancelled', '2025-12-30 04:21:29', '2025-12-30 04:21:55'),
(34, 34, 'INV-6952E36951FE1', '5316.96', 'cancelled', '2025-12-30 04:24:09', '2025-12-31 04:17:50'),
(35, 35, 'INV-6952E51F37870', '5528.96', 'paid', '2025-12-30 04:31:27', '2025-12-30 04:31:49'),
(36, 36, 'INV-6953DC67415EF', '622.23', 'paid', '2025-12-30 22:06:31', '2025-12-30 22:06:51'),
(38, 38, 'INV-69543D4F75652', '2385.00', 'cancelled', '2025-12-31 04:59:59', '2025-12-31 05:00:48'),
(39, 39, 'INV-6956456E33E47', '137.80', 'paid', '2026-01-01 17:59:10', '2026-01-01 17:59:26'),
(40, 40, 'INV-69567AAADD8A4', '2393.48', 'unpaid', '2026-01-01 21:46:18', '2026-01-01 21:46:18'),
(41, 41, 'INV-69567CA885F10', '106.00', 'paid', '2026-01-01 21:54:48', '2026-01-01 22:13:55'),
(42, 42, 'INV-69567E099C1F9', '143.81', 'paid', '2026-01-01 22:00:41', '2026-01-01 22:21:14'),
(43, 43, 'INV-69567F88797BD', '1060.00', 'unpaid', '2026-01-01 22:07:04', '2026-01-01 22:07:04'),
(44, 44, 'INV-69572227366BB', '106.00', 'paid', '2026-01-02 09:40:55', '2026-01-02 09:41:10'),
(45, 45, 'INV-6957B0D841F4A', '636.00', 'cancelled', '2026-01-02 19:49:44', '2026-01-04 00:28:57'),
(46, 46, 'INV-695816CB01F00', '477.00', 'paid', '2026-01-03 03:04:43', '2026-01-03 03:04:59'),
(47, 47, 'INV-695818184B6F3', '2393.48', 'cancelled', '2026-01-03 03:10:16', '2026-01-03 03:24:03'),
(48, 48, 'INV-69581C051E4FA', '137.80', 'paid', '2026-01-03 03:27:01', '2026-01-03 03:28:07'),
(49, 49, 'INV-6959608140FF5', '161.80', 'paid', '2026-01-04 02:31:29', '2026-01-04 02:32:19'),
(50, 50, 'INV-695A7879AB9B4', '2658.48', 'paid', '2026-01-04 22:26:01', '2026-01-04 22:26:23'),
(51, 51, 'INV-695A7E5B433B8', '207.41', 'paid', '2026-01-04 22:51:07', '2026-01-04 22:51:39'),
(52, 52, 'INV-695B101C2832D', '2393.48', 'paid', '2026-01-05 09:13:00', '2026-01-05 09:13:13'),
(53, 53, 'INV-695B679276454', '2658.48', 'paid', '2026-01-05 15:26:10', '2026-01-05 15:26:24'),
(54, 54, 'INV-695CE3A80448F', '12720.00', 'cancelled', '2026-01-06 18:27:52', '2026-01-06 18:29:04'),
(55, 55, 'INV-695CE3C02C277', '2120.00', 'paid', '2026-01-06 18:28:16', '2026-01-06 18:29:18'),
(56, 56, 'INV-69620EAA68C9E', '2120.00', 'unpaid', '2026-01-10 16:32:42', '2026-01-10 16:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` int NOT NULL,
  `car_id` int NOT NULL,
  `description` text,
  `cost` decimal(10,2) DEFAULT NULL,
  `maintenance_date` date DEFAULT NULL,
  `status` enum('scheduled','completed') DEFAULT 'scheduled',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `maintenances`
--

INSERT INTO `maintenances` (`id`, `car_id`, `description`, `cost`, `maintenance_date`, `status`, `created`, `modified`) VALUES
(1, 5, '', '300.00', '2025-12-30', 'completed', '2025-12-29 17:47:24', '2025-12-30 03:28:02'),
(2, 1, 'brake not function', '500.00', '2025-12-29', 'completed', '2025-12-29 17:51:03', '2025-12-30 16:23:49'),
(3, 1, 'brake rosak', '500.00', '2026-01-06', 'completed', '2026-01-02 15:37:49', '2026-01-02 15:38:08'),
(4, 1, '', NULL, '2026-01-02', 'completed', '2026-01-02 15:39:21', '2026-01-02 15:39:21'),
(5, 1, '', NULL, '2026-01-02', 'completed', '2026-01-02 15:56:16', '2026-01-02 15:56:35'),
(6, 9, 'rim tercabut', '450.00', '2026-01-05', 'completed', '2026-01-05 13:34:13', '2026-01-05 23:02:11'),
(7, 1, '', '150.00', '2026-01-16', 'completed', '2026-01-10 00:48:34', '2026-01-10 00:52:05'),
(8, 5, 'the user said the car is broken. so maybe need to check engine and exhaust', '1600.00', '2026-01-13', 'completed', '2026-01-10 01:11:41', '2026-01-10 01:11:57'),
(9, 5, 'repair engine', '12000.00', '2026-01-11', 'completed', '2026-01-11 10:35:26', '2026-01-11 10:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_status` enum('paid','unpaid','refunded') DEFAULT 'unpaid',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `amount`, `payment_method`, `payment_date`, `payment_status`, `created`, `modified`) VALUES
(11, 12, '200.00', 'cash', '2025-12-23 12:54:09', 'paid', '2025-12-23 12:54:09', '2025-12-23 12:54:09'),
(12, 13, '200.00', 'card', '2025-12-23 14:07:20', 'paid', '2025-12-23 14:07:20', '2025-12-23 14:07:20'),
(19, 23, '190.80', 'online_transfer_cimbclicks', '2025-12-27 15:46:51', 'paid', '2025-12-27 15:46:51', '2025-12-27 15:46:51'),
(21, 21, '120.00', 'online_transfer_maybank2u', '2025-12-28 22:44:40', 'paid', '2025-12-28 22:44:40', '2025-12-28 22:44:40'),
(24, 27, '137.80', 'online_transfer_hongleong', '2025-12-29 02:18:36', 'refunded', '2025-12-29 02:18:36', '2025-12-29 02:19:46'),
(27, 34, '5316.96', 'card', '2025-12-30 04:24:34', 'refunded', '2025-12-30 04:24:34', '2025-12-31 04:17:50'),
(28, 35, '5528.96', 'cash', '2025-12-30 04:31:49', 'paid', '2025-12-30 04:31:49', '2025-12-30 04:31:49'),
(29, 36, '622.23', 'card', '2025-12-30 22:06:51', 'paid', '2025-12-30 22:06:51', '2025-12-30 22:06:51'),
(32, 39, '137.80', 'card', '2026-01-01 17:59:25', 'paid', '2026-01-01 17:59:25', '2026-01-01 17:59:25'),
(33, 40, '2393.48', 'cash', '2026-01-01 21:47:27', '', '2026-01-01 21:47:27', '2026-01-01 21:47:27'),
(34, 40, '2393.48', 'cash', '2026-01-01 21:47:45', '', '2026-01-01 21:47:45', '2026-01-01 21:47:45'),
(35, 40, '2393.48', 'cash', '2026-01-01 21:47:57', '', '2026-01-01 21:47:57', '2026-01-01 21:47:57'),
(36, 41, '106.00', 'cash', '2026-01-01 22:13:55', 'paid', '2026-01-01 21:55:03', '2026-01-01 22:13:55'),
(37, 42, '143.81', 'cash', '2026-01-01 22:00:47', 'paid', '2026-01-01 22:00:47', '2026-01-01 22:10:00'),
(38, 42, '143.81', 'cash', '2026-01-01 22:21:14', 'paid', '2026-01-01 22:05:56', '2026-01-01 22:21:14'),
(39, 43, '1060.00', 'cash', '2026-01-01 22:07:10', '', '2026-01-01 22:07:10', '2026-01-01 22:07:10'),
(40, 44, '106.00', 'online_transfer_cimbclicks', '2026-01-02 09:41:10', 'paid', '2026-01-02 09:41:10', '2026-01-02 09:41:10'),
(41, 45, '636.00', 'cash', '2026-01-02 19:55:42', 'refunded', '2026-01-02 19:51:21', '2026-01-04 00:28:57'),
(42, 45, '636.00', 'cash', '2026-01-02 19:55:39', 'refunded', '2026-01-02 19:51:34', '2026-01-04 00:28:57'),
(43, 45, '636.00', 'cash', '2026-01-02 19:55:35', 'refunded', '2026-01-02 19:53:49', '2026-01-04 00:28:57'),
(44, 46, '477.00', 'card', '2026-01-03 03:04:59', 'paid', '2026-01-03 03:04:59', '2026-01-03 03:04:59'),
(45, 47, '2393.48', 'online_transfer_cimbclicks', '2026-01-03 03:10:24', 'refunded', '2026-01-03 03:10:24', '2026-01-03 03:24:03'),
(46, 48, '137.80', 'cash', '2026-01-03 03:28:07', 'paid', '2026-01-03 03:27:10', '2026-01-03 03:28:07'),
(47, 49, '161.80', 'cash', '2026-01-04 02:32:19', 'paid', '2026-01-04 02:31:37', '2026-01-04 02:32:19'),
(48, 50, '2658.48', 'card', '2026-01-04 22:26:23', 'paid', '2026-01-04 22:26:23', '2026-01-04 22:26:23'),
(49, 51, '207.41', 'online_transfer_maybank2u', '2026-01-04 22:51:39', 'paid', '2026-01-04 22:51:39', '2026-01-04 22:51:39'),
(50, 52, '2393.48', 'online_transfer_maybank2u', '2026-01-05 09:13:13', 'paid', '2026-01-05 09:13:13', '2026-01-05 09:13:13'),
(51, 53, '2658.48', 'card', '2026-01-05 15:26:24', 'paid', '2026-01-05 15:26:24', '2026-01-05 15:26:24'),
(52, 55, '2120.00', 'online_transfer_maybank2u', '2026-01-06 18:29:18', 'paid', '2026-01-06 18:29:18', '2026-01-06 18:29:18');

-- --------------------------------------------------------

--
-- Table structure for table `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20251219172412, 'AddRoleToUsers', '2025-12-23 10:18:56', '2025-12-23 10:18:56', 0),
(20251223100526, 'AddBookingIdToReviews', '2025-12-23 10:21:47', '2025-12-23 10:21:47', 0),
(20251223151232, 'AddSpecsToCars', '2025-12-23 15:25:02', '2025-12-23 15:25:02', 0),
(20251224163000, 'RemoveDefaultImageFromCars', '2025-12-24 08:53:09', '2025-12-24 08:53:10', 0),
(20251224175900, 'RemoveBookedStatusFromCars', '2025-12-24 10:01:58', '2025-12-24 10:01:58', 0),
(20251225172659, 'AddPricePerDayToBookings', '2025-12-26 01:29:30', '2025-12-26 01:29:31', 0),
(20251225173210, 'RemovePricePerDayFromBookings', '2025-12-26 01:33:45', '2025-12-26 01:33:46', 0),
(20251227045900, 'AddPickupLocationToBookings', '2025-12-27 05:04:36', '2025-12-27 05:04:37', 0),
(20251230021300, 'AddPolicyFieldsToCarCategories', '2025-12-30 02:16:15', '2025-12-30 02:16:16', 0),
(20251230021400, 'AddServiceSelectionsToBookings', '2025-12-30 02:16:16', '2025-12-30 02:16:16', 0),
(20260103165136, 'AddBadgeColorToCarCategories', '2026-01-04 00:51:53', '2026-01-04 00:51:54', 0),
(20260103173526, 'DropBadgeColorFromCars', '2026-01-04 01:35:55', '2026-01-04 01:35:55', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `car_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `booking_id` int DEFAULT NULL
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `car_id`, `rating`, `comment`, `created`, `modified`, `booking_id`) VALUES
(2, 4, 1, 3, 'service is not good\r\n', '2025-12-23 12:54:24', '2025-12-23 12:54:24', NULL),
(3, 4, 1, 5, 'boleh aaa kereta ni okay sikit ah trump the beast kot', '2025-12-23 14:08:07', '2025-12-23 14:08:07', NULL),
(4, 4, 2, 5, 'BEST GILAAAAAA', '2025-12-23 14:09:09', '2025-12-23 14:09:09', NULL),
(5, 4, 5, 5, 'BAPAK LAJU SIA KERETA NI', '2025-12-24 09:46:11', '2025-12-24 09:46:11', NULL),
(8, 4, 1, 2, 'the brake are not function', '2025-12-29 17:50:24', '2025-12-29 17:50:24', NULL),
(9, 4, 6, 3, 'Good but need to have android player', '2026-01-01 21:25:51', '2026-01-01 21:25:51', NULL),
(10, 13, 5, 2, 'the car is so broken', '2026-01-10 01:08:46', '2026-01-10 01:08:46', NULL),
(11, 13, 5, 2, 'engine not fast as described', '2026-01-11 10:32:36', '2026-01-11 10:32:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `ic_number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT 'default_user.png',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `ic_number`, `email`, `phone`, `address`, `password`, `avatar`, `created`, `modified`, `role`) VALUES
(3, 'Super Admin', '999999-99-99', 'admin@rentify.com', '', '', '$2y$10$SAMV3gZm/X1lIADW80NkX.P372nCziNJzpPUju48KbmQsDVzV0AJS', 'avatars\\avatar_3_1767322835.jpg', '2025-12-19 17:24:50', '2026-01-02 11:00:35', 'admin'),
(4, 'safa23', '901211098822', 'safa@email.com', '01229199222', 'no.10 Kuala Selangor Jalan Kebun, UiTM Puncak Perdana 68200 Selangor Malaysia', '$2y$10$BmmkJTL8L12pAd/NJDu3hu7KbKysySjp6vnpYM1cLIPWjIKZ4ZslC', 'safa.png', '2025-12-19 18:07:05', '2026-01-05 15:56:32', 'customer'),
(11, 'pali93', '832938928392', 'pali@email.com', '01124623278', '', '$2y$10$rEL1StyMP8RqgEVqDT9.zuZ5bExZIYHZOyKao/s6lis6ircdxawuO', 'default_user.png', '2025-12-30 04:30:19', '2026-01-02 09:56:18', 'customer'),
(13, 'megat', '292029302932', 'megat@example.com', '0192191210', NULL, '$2y$10$A3rk2ilSwYa4Y23UvAcyIuqSI8utQf5O4yepBnckS7zYLlhrO1R/a', 'default_user.png', '2026-01-03 03:03:54', '2026-01-03 03:03:54', 'customer'),
(14, 'zahid', '920390293029', 'zahid@email.com', '0192313221', NULL, '$2y$10$EtdjMDC5KxO5APOK.cpmd.j15fboEoul6r/sa5euIq5U3WdPgyXOG', 'default_user.png', '2026-01-04 22:59:43', '2026-01-04 22:59:43', 'customer'),
(15, 'megat naufal', '040231142389', 'naufal@email.com', '0192345628', NULL, '$2y$10$hwhozKsou8kk1U27J6Uw/umezBLE9fHVpevX7UtgrYRaTEo9qwIuS', 'default_user.png', '2026-01-05 13:55:46', '2026-01-05 13:55:46', 'customer'),
(16, 'Maira', '040923140260', 'humairafatin31@gmail.com', '0183920742', NULL, '$2y$10$m1CAMDrVF7gLPI.LRclqyeM0F761AaHlx3drbj.jBYWs4EZO4P5Zi', 'default_user.png', '2026-01-06 18:25:26', '2026-01-06 18:25:26', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plate_number` (`plate_number`),
  ADD KEY `car_id` (`category_id`);

--
-- Indexes for table `car_categories`
--
ALTER TABLE `car_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `BY_BADGE_COLOR` (`badge_color`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `booking_id_idx` (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `ic_number` (`ic_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `car_categories`
--
ALTER TABLE `car_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `car_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD CONSTRAINT `maintenances_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
