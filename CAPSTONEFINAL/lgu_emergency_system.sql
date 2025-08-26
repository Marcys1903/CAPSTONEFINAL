-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2025 at 04:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lgu_emergency_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `alert_id` int(11) NOT NULL,
  `alert_type` enum('Weather','Earthquake','Flood','Fire','Bomb Threat','Health Alert','Other') NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `severity` enum('Low','Medium','High','Critical') DEFAULT 'Low',
  `priority_level` int(11) DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`alert_id`, `alert_type`, `title`, `message`, `location`, `severity`, `priority_level`, `created_by`, `created_at`) VALUES
(1, 'Other', 'Flood Warning', 'Heavy rainfall has caused flooding in low-lying areas. Please evacuate to higher ground and follow local advisories.', NULL, 'Low', 1, 2, '2025-08-22 11:33:27'),
(2, 'Other', 'Fire Incident', 'A fire has been reported in the area. Stay clear of danger zones and follow evacuation orders if necessary.', NULL, 'Low', 1, 2, '2025-08-22 11:33:49'),
(3, 'Other', 'Earthquake Alert', 'An earthquake has been recorded. Expect aftershocks. Stay safe and follow official advisories.', NULL, 'Low', 1, 2, '2025-08-22 11:33:53'),
(4, 'Other', 'Power Interruption', 'There is an ongoing power outage. Restoration efforts are underway. Please remain patient and stay safe.', NULL, 'Low', 1, 2, '2025-08-22 11:33:57'),
(5, 'Other', 'Flood Warning', 'Heavy rainfall has caused flooding in low-lying areas. Please evacuate to higher ground and follow local advisories.', NULL, 'Low', 1, 2, '2025-08-23 15:23:20'),
(6, 'Other', 'Flood Warning', 'Heavy rainfall has caused flooding in low-lying areas. Please evacuate to higher ground and follow local advisories.', NULL, '', 3, 2, '2025-08-23 15:33:59'),
(7, 'Other', 'Earthquake Alert', 'An earthquake has been recorded. Expect aftershocks. Stay safe and follow official advisories.', NULL, '', 5, 2, '2025-08-23 15:40:03'),
(8, 'Other', 'Fire Incident', 'A fire has been reported in the area. Stay clear of danger zones and follow evacuation orders if necessary.', NULL, '', 3, 2, '2025-08-25 05:10:50'),
(9, 'Other', 'Flood Warning', 'Heavy rainfall has caused flooding in low-lying areas. Please evacuate to higher ground and follow local advisories.', NULL, '', 3, 2, '2025-08-25 06:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `alert_delivery`
--

CREATE TABLE `alert_delivery` (
  `delivery_id` int(11) NOT NULL,
  `alert_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `delivery_channel` enum('SMS','Email','PA System') DEFAULT NULL,
  `delivery_status` enum('Sent','Failed','Pending') DEFAULT 'Pending',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `audit_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`audit_id`, `user_id`, `activity`, `ip_address`, `timestamp`) VALUES
(1, 1, 'Logout', '::1', '2025-08-22 09:09:41'),
(2, 1, 'Login', '::1', '2025-08-22 09:09:46'),
(3, 1, 'Logout', '::1', '2025-08-22 09:10:29'),
(4, 1, 'Login', '::1', '2025-08-22 09:32:48'),
(5, 1, 'Logout', '::1', '2025-08-22 09:33:00'),
(6, 1, 'Login', '::1', '2025-08-22 09:33:17'),
(7, 3, 'Login', '192.168.100.28', '2025-08-22 09:51:14'),
(8, 1, 'Logout', '127.0.0.1', '2025-08-22 09:51:26'),
(9, 2, 'Login', '127.0.0.1', '2025-08-22 09:51:31'),
(10, 2, 'Staff sent mass notification: Flood Warning', '127.0.0.1', '2025-08-22 11:28:23'),
(11, 3, 'Login', '192.168.100.28', '2025-08-22 11:32:58'),
(12, 2, 'Staff sent mass notification: Flood Warning', '127.0.0.1', '2025-08-22 11:33:27'),
(13, 2, 'Staff sent mass notification: Fire Incident', '127.0.0.1', '2025-08-22 11:33:49'),
(14, 2, 'Staff sent mass notification: Earthquake Alert', '127.0.0.1', '2025-08-22 11:33:53'),
(15, 2, 'Staff sent mass notification: Power Interruption', '127.0.0.1', '2025-08-22 11:33:57'),
(16, 2, 'Logout', '127.0.0.1', '2025-08-22 11:34:01'),
(17, 3, 'Logout', '192.168.100.28', '2025-08-22 11:34:05'),
(18, 1, 'Login', '127.0.0.1', '2025-08-22 11:34:09'),
(19, 1, 'Logout', '127.0.0.1', '2025-08-22 13:25:34'),
(20, 3, 'Login', '127.0.0.1', '2025-08-22 13:25:40'),
(21, 3, 'Logout', '127.0.0.1', '2025-08-22 13:26:04'),
(22, 2, 'Login', '127.0.0.1', '2025-08-22 13:26:24'),
(23, 2, 'Logout', '127.0.0.1', '2025-08-22 13:28:12'),
(24, 1, 'Login', '127.0.0.1', '2025-08-22 13:28:17'),
(25, 1, 'Admin sent mass SMS notification: PLEASE EVACUATE NOW!', '127.0.0.1', '2025-08-22 14:21:34'),
(26, 1, 'Admin sent mass SMS notification (Flood): FLOOD ALERT: Citizens are advised to evacuate to higher ground immediately. Bring essentials and proceed to the nearest evacuation center. Stay safe. - LGU', '127.0.0.1', '2025-08-22 14:34:10'),
(27, 1, 'Logout', '127.0.0.1', '2025-08-22 14:34:49'),
(28, 3, 'Login', '127.0.0.1', '2025-08-22 14:35:12'),
(29, 3, 'Logout', '127.0.0.1', '2025-08-22 14:56:08'),
(30, 1, 'Login', '127.0.0.1', '2025-08-22 14:56:14'),
(31, 2, 'Login', '127.0.0.1', '2025-08-23 14:27:28'),
(32, 2, 'Login', '127.0.0.1', '2025-08-23 14:42:04'),
(33, 2, 'Staff sent mass notification: Flood Warning', '127.0.0.1', '2025-08-23 15:23:20'),
(34, 2, 'Staff sent mass notification: Flood Warning', '127.0.0.1', '2025-08-23 15:33:59'),
(35, 2, 'Staff sent mass notification: Earthquake Alert', '127.0.0.1', '2025-08-23 15:40:03'),
(36, NULL, 'Login', '127.0.0.1', '2025-08-24 12:19:31'),
(37, NULL, 'Logout', '127.0.0.1', '2025-08-24 12:36:18'),
(38, 5, 'Login', '127.0.0.1', '2025-08-24 13:11:19'),
(39, 5, 'Logout', '127.0.0.1', '2025-08-24 13:45:16'),
(40, 1, 'Login', '127.0.0.1', '2025-08-24 13:45:23'),
(41, 1, 'Added hotline: 111 (Tester)', '127.0.0.1', '2025-08-24 14:21:16'),
(42, 1, 'Removed hotline: 111 (Tester)', '127.0.0.1', '2025-08-24 14:24:22'),
(43, 1, 'Logout', '127.0.0.1', '2025-08-24 14:44:25'),
(44, 5, 'Login', '127.0.0.1', '2025-08-24 14:44:32'),
(45, 5, 'Logout', '127.0.0.1', '2025-08-24 14:53:08'),
(46, 1, 'Login', '127.0.0.1', '2025-08-24 14:53:24'),
(47, 1, 'Login', '192.168.254.121', '2025-08-25 05:06:14'),
(48, 5, 'Login', '192.168.254.145', '2025-08-25 05:06:25'),
(49, 1, 'Added hotline: 111 (tester)', '192.168.254.121', '2025-08-25 05:07:02'),
(50, 1, 'Admin sent mass SMS notification (Typhoon): TYPHOON ALERT: Due to strong winds and heavy rain, all residents are ordered to evacuate to designated centers. Secure important belongings and follow LGU officials\' guidance. - LGU', '192.168.254.121', '2025-08-25 05:07:38'),
(51, 1, 'Logout', '192.168.254.121', '2025-08-25 05:09:53'),
(52, 2, 'Login', '192.168.254.121', '2025-08-25 05:10:10'),
(53, 2, 'Staff sent mass notification: Fire Incident', '192.168.254.121', '2025-08-25 05:10:50'),
(54, 2, 'Logout', '192.168.254.121', '2025-08-25 05:23:26'),
(55, 5, 'Login', '192.168.254.121', '2025-08-25 05:23:49'),
(56, 5, 'Logout', '192.168.254.145', '2025-08-25 05:24:15'),
(57, 2, 'Login', '192.168.254.145', '2025-08-25 05:24:27'),
(58, 1, 'Login', '192.168.254.145', '2025-08-25 05:39:02'),
(59, 1, 'Admin sent Mass Notification (Typhoon): TYPHOON ALERT: Strong winds and heavy rain expected. Evacuate to designated centers. - LGU', '192.168.254.145', '2025-08-25 05:44:09'),
(60, 1, 'Admin sent Mass Notification (Typhoon): TYPHOON ALERT: Strong winds and heavy rain expected. Evacuate to designated centers. - LGU', '192.168.254.145', '2025-08-25 05:44:15'),
(61, 1, 'Admin sent Mass Notification (Flood): FLOOD ALERT: Citizens are advised to evacuate to higher ground immediately. Bring essentials and proceed to the nearest evacuation center. Stay safe. - LGU', '192.168.254.145', '2025-08-25 05:48:10'),
(62, 5, 'Login', '127.0.0.1', '2025-08-25 05:49:31'),
(63, 2, 'Staff sent mass notification: Flood Warning', '192.168.254.145', '2025-08-25 06:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `citizen_alerts`
--

CREATE TABLE `citizen_alerts` (
  `citizen_alert_id` int(11) NOT NULL,
  `citizen_id` int(11) DEFAULT NULL,
  `alert_id` int(11) DEFAULT NULL,
  `is_read` enum('Yes','No') DEFAULT 'No',
  `received_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `citizen_alerts`
--

INSERT INTO `citizen_alerts` (`citizen_alert_id`, `citizen_id`, `alert_id`, `is_read`, `received_at`) VALUES
(1, 3, 1, 'No', '2025-08-22 11:33:27'),
(2, 3, 2, 'No', '2025-08-22 11:33:49'),
(3, 3, 3, 'No', '2025-08-22 11:33:53'),
(4, 3, 4, 'No', '2025-08-22 11:33:57'),
(5, 3, 5, 'No', '2025-08-23 15:23:20'),
(6, 3, 6, 'No', '2025-08-23 15:33:59'),
(7, 3, 7, 'No', '2025-08-23 15:40:03'),
(8, 3, 8, 'No', '2025-08-25 05:10:50'),
(9, 5, 8, 'No', '2025-08-25 05:10:50'),
(10, 3, 9, 'No', '2025-08-25 06:03:56'),
(11, 5, 9, 'No', '2025-08-25 06:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `citizen_messages`
--

CREATE TABLE `citizen_messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `citizen_queries`
--

CREATE TABLE `citizen_queries` (
  `query_id` int(11) NOT NULL,
  `citizen_id` int(11) DEFAULT NULL,
  `query_text` text DEFAULT NULL,
  `summarized_query` text DEFAULT NULL,
  `response_text` text DEFAULT NULL,
  `responded_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `citizen_services`
--

CREATE TABLE `citizen_services` (
  `service_id` int(11) NOT NULL,
  `citizen_id` int(11) DEFAULT NULL,
  `subscribed_services` text DEFAULT NULL,
  `notification_channel` enum('SMS','Email','Both') DEFAULT 'Both'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evacuation_templates`
--

CREATE TABLE `evacuation_templates` (
  `template_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evacuation_templates`
--

INSERT INTO `evacuation_templates` (`template_id`, `category`, `message`, `created_at`) VALUES
(1, 'Flood', ' EVACUATION ORDER  Residents in low-lying and riverside areas are advised to evacuate immediately to designated evacuation centers. Bring only essential items and secure your safety.', '2025-08-22 14:26:15'),
(2, 'Typhoon', ' TYPHOON EVACUATION  Due to strong winds and heavy rainfall, residents in coastal and landslide-prone areas must proceed to evacuation centers. Follow LGU personnel for guidance.', '2025-08-22 14:26:15'),
(3, 'Fire', ' FIRE EVACUATION  Please leave the area immediately. Do not attempt to retrieve belongings. Proceed calmly to the nearest evacuation site.', '2025-08-22 14:26:15'),
(4, 'Earthquake', ' EARTHQUAKE RESPONSE  If safe, evacuate buildings and proceed to open spaces or evacuation centers. Watch out for aftershocks.', '2025-08-22 14:26:15'),
(5, 'Bomb Threat', ' SECURITY ALERT  Please evacuate the premises immediately in an orderly manner. Do not use mobile phones near the area. Follow authorities’ instructions.', '2025-08-22 14:26:15');

-- --------------------------------------------------------

--
-- Table structure for table `external_warnings`
--

CREATE TABLE `external_warnings` (
  `warning_id` int(11) NOT NULL,
  `source` enum('PAGASA','PHIVOLCS','Other') DEFAULT NULL,
  `warning_text` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `received_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `processed` enum('Yes','No') DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotlines`
--

CREATE TABLE `hotlines` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `hotline_number` varchar(50) NOT NULL,
  `agency` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotlines`
--

INSERT INTO `hotlines` (`id`, `name`, `phone_number`, `hotline_number`, `agency`) VALUES
(1, '', '', '911', 'National Office'),
(2, '', '', '122', 'Quezon City Emergency Hotline'),
(4, '', '', '111', 'tester');

-- --------------------------------------------------------

--
-- Table structure for table `incident_templates`
--

CREATE TABLE `incident_templates` (
  `template_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incident_templates`
--

INSERT INTO `incident_templates` (`template_id`, `category`, `title`, `message`) VALUES
(1, 'Flood', ' Flood Warning', 'Heavy rainfall has caused flooding in low-lying areas. Please evacuate to higher ground and follow local advisories.'),
(2, 'Fire', ' Fire Incident', 'A fire has been reported in the area. Stay clear of danger zones and follow evacuation orders if necessary.'),
(3, 'Earthquake', ' Earthquake Alert', 'An earthquake has been recorded. Expect aftershocks. Stay safe and follow official advisories.'),
(4, 'Power Outage', ' Power Interruption', 'There is an ongoing power outage. Restoration efforts are underway. Please remain patient and stay safe.');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `message`, `sent_at`, `created_at`) VALUES
(1, 2, 3, 'Hello', '2025-08-22 06:19:42', '2025-08-22 06:19:42'),
(2, 2, 3, 'Hi', '2025-08-22 06:36:01', '2025-08-22 06:36:01'),
(3, 3, 2, 'HI', '2025-08-22 06:37:08', '2025-08-22 06:37:08'),
(4, 3, 2, 'ghfjfj', '2025-08-22 09:51:31', '2025-08-22 09:51:31'),
(6, 2, 3, 'hello po ', '2025-08-22 09:51:48', '2025-08-22 09:51:48'),
(7, 2, 3, 'putragis', '2025-08-22 09:51:49', '2025-08-22 09:51:49'),
(8, 2, 3, 'paconnect', '2025-08-22 09:51:52', '2025-08-22 09:51:52'),
(9, 2, 3, 'ping', '2025-08-22 11:33:10', '2025-08-22 11:33:10'),
(10, 3, 2, 'Weh??', '2025-08-22 11:33:22', '2025-08-22 11:33:22'),
(11, 2, 3, '[ALERT] Flood Warning - Heavy rainfall has caused flooding in low-lying areas. Please evacuate to higher ground and follow local advisories.', '2025-08-22 11:33:27', '2025-08-22 11:33:27'),
(12, 3, 2, 'Tapos!/', '2025-08-22 11:33:40', '2025-08-22 11:33:40'),
(13, 2, 3, '[ALERT] Fire Incident - A fire has been reported in the area. Stay clear of danger zones and follow evacuation orders if necessary.', '2025-08-22 11:33:49', '2025-08-22 11:33:49'),
(14, 2, 3, '[ALERT] Earthquake Alert - An earthquake has been recorded. Expect aftershocks. Stay safe and follow official advisories.', '2025-08-22 11:33:53', '2025-08-22 11:33:53'),
(15, 2, 3, '[ALERT] Power Interruption - There is an ongoing power outage. Restoration efforts are underway. Please remain patient and stay safe.', '2025-08-22 11:33:57', '2025-08-22 11:33:57'),
(16, 2, 3, 'hii', '2025-08-22 13:27:26', '2025-08-22 13:27:26'),
(17, 2, 3, '[ALERT] Flood Warning - Heavy rainfall has caused flooding in low-lying areas. Please evacuate to higher ground and follow local advisories.', '2025-08-23 15:23:20', '2025-08-23 15:23:20'),
(18, 2, 3, '[ALERT][High] Flood Warning - Heavy rainfall has caused flooding in low-lying areas. Please evacuate to higher ground and follow local advisories.', '2025-08-23 15:33:59', '2025-08-23 15:33:59'),
(19, 2, 3, '[ALERT][Critical] Earthquake Alert - An earthquake has been recorded. Expect aftershocks. Stay safe and follow official advisories.', '2025-08-23 15:40:03', '2025-08-23 15:40:03'),
(20, 5, 2, 'Hello test', '2025-08-25 05:10:31', '2025-08-25 05:10:31'),
(21, 2, 5, 'hi', '2025-08-25 05:10:38', '2025-08-25 05:10:38'),
(22, 2, 3, '[ALERT][High] Fire Incident - A fire has been reported in the area. Stay clear of danger zones and follow evacuation orders if necessary.', '2025-08-25 05:10:50', '2025-08-25 05:10:50'),
(23, 2, 5, '[ALERT][High] Fire Incident - A fire has been reported in the area. Stay clear of danger zones and follow evacuation orders if necessary.', '2025-08-25 05:10:50', '2025-08-25 05:10:50'),
(24, 1, 3, 'TYPHOON ALERT: Strong winds and heavy rain expected. Evacuate to designated centers. - LGU', '2025-08-25 05:44:06', '2025-08-25 05:44:06'),
(25, 1, 5, 'TYPHOON ALERT: Strong winds and heavy rain expected. Evacuate to designated centers. - LGU', '2025-08-25 05:44:09', '2025-08-25 05:44:09'),
(26, 1, 3, 'TYPHOON ALERT: Strong winds and heavy rain expected. Evacuate to designated centers. - LGU', '2025-08-25 05:44:12', '2025-08-25 05:44:12'),
(27, 1, 5, 'TYPHOON ALERT: Strong winds and heavy rain expected. Evacuate to designated centers. - LGU', '2025-08-25 05:44:15', '2025-08-25 05:44:15'),
(28, 1, 3, 'FLOOD ALERT: Citizens are advised to evacuate to higher ground immediately. Bring essentials and proceed to the nearest evacuation center. Stay safe. - LGU', '2025-08-25 05:48:08', '2025-08-25 05:48:08'),
(29, 1, 5, 'FLOOD ALERT: Citizens are advised to evacuate to higher ground immediately. Bring essentials and proceed to the nearest evacuation center. Stay safe. - LGU', '2025-08-25 05:48:10', '2025-08-25 05:48:10'),
(30, 2, 3, '[ALERT][High] Flood Warning - Heavy rainfall has caused flooding in low-lying areas. Please evacuate to higher ground and follow local advisories.', '2025-08-25 06:03:56', '2025-08-25 06:03:56'),
(31, 2, 5, '[ALERT][High] Flood Warning - Heavy rainfall has caused flooding in low-lying areas. Please evacuate to higher ground and follow local advisories.', '2025-08-25 06:03:56', '2025-08-25 06:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `message`, `created_at`, `created_by`) VALUES
(3, 'SMS', 'EVACUATE NOW!', '2025-08-22 14:16:43', 1),
(4, 'SMS', 'PLEASE EVACUATE NOW!', '2025-08-22 14:21:34', 1),
(5, 'SMS', 'FLOOD ALERT: Citizens are advised to evacuate to higher ground immediately. Bring essentials and proceed to the nearest evacuation center. Stay safe. - LGU', '2025-08-22 14:34:10', 1),
(6, 'SMS', 'TYPHOON ALERT: Due to strong winds and heavy rain, all residents are ordered to evacuate to designated centers. Secure important belongings and follow LGU officials\' guidance. - LGU', '2025-08-25 05:07:38', 1),
(7, 'SMS', 'TYPHOON ALERT: Due to strong winds and heavy rain, all residents are ordered to evacuate to designated centers. Secure important belongings and follow LGU officials\' guidance. - LGU', '2025-08-25 05:07:38', 1),
(8, 'Mass Alert', 'TYPHOON ALERT: Strong winds and heavy rain expected. Evacuate to designated centers. - LGU', '2025-08-25 05:44:06', 1),
(9, 'Mass Alert', 'TYPHOON ALERT: Strong winds and heavy rain expected. Evacuate to designated centers. - LGU', '2025-08-25 05:44:09', 1),
(10, 'Mass Alert', 'TYPHOON ALERT: Strong winds and heavy rain expected. Evacuate to designated centers. - LGU', '2025-08-25 05:44:12', 1),
(11, 'Mass Alert', 'TYPHOON ALERT: Strong winds and heavy rain expected. Evacuate to designated centers. - LGU', '2025-08-25 05:44:15', 1),
(12, 'Mass Alert', 'FLOOD ALERT: Citizens are advised to evacuate to higher ground immediately. Bring essentials and proceed to the nearest evacuation center. Stay safe. - LGU', '2025-08-25 05:48:08', 1),
(13, 'Mass Alert', 'FLOOD ALERT: Citizens are advised to evacuate to higher ground immediately. Bring essentials and proceed to the nearest evacuation center. Stay safe. - LGU', '2025-08-25 05:48:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `log_id` int(11) NOT NULL,
  `alert_id` int(11) DEFAULT NULL,
  `sent_by` int(11) DEFAULT NULL,
  `total_recipients` int(11) DEFAULT NULL,
  `success_count` int(11) DEFAULT NULL,
  `failure_count` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_logs`
--

INSERT INTO `notification_logs` (`log_id`, `alert_id`, `sent_by`, `total_recipients`, `success_count`, `failure_count`, `timestamp`) VALUES
(1, 1, 2, 1, 1, 0, '2025-08-22 11:33:27'),
(2, 2, 2, 1, 1, 0, '2025-08-22 11:33:49'),
(3, 3, 2, 1, 1, 0, '2025-08-22 11:33:53'),
(4, 4, 2, 1, 1, 0, '2025-08-22 11:33:57'),
(5, 5, 2, 1, 1, 0, '2025-08-23 15:23:20'),
(6, 6, 2, 1, 1, 0, '2025-08-23 15:33:59'),
(7, 7, 2, 1, 1, 0, '2025-08-23 15:40:03'),
(8, 8, 2, 2, 2, 0, '2025-08-25 05:10:50'),
(9, 9, 2, 2, 2, 0, '2025-08-25 06:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `qc_id_verifications`
--

CREATE TABLE `qc_id_verifications` (
  `verification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `qc_id_path` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `remarks` text DEFAULT NULL,
  `verified_by` int(11) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_attendance`
--

CREATE TABLE `staff_attendance` (
  `attendance_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` enum('Present','Absent','On Leave') DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_performance`
--

CREATE TABLE `staff_performance` (
  `performance_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `evaluation` text DEFAULT NULL,
  `training_record` text DEFAULT NULL,
  `date_evaluated` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_profiles`
--

CREATE TABLE `staff_profiles` (
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_profiles`
--

INSERT INTO `staff_profiles` (`staff_id`, `user_id`, `job_title`, `department`, `salary`) VALUES
(1, 2, 'Emergency Staff', 'Disaster Response', 25000.00);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_id` int(11) NOT NULL,
  `setting_name` varchar(100) DEFAULT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `role` enum('admin','staff','citizen') NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `language_preference` varchar(50) DEFAULT 'English',
  `qc_id_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role`, `username`, `password`, `full_name`, `email`, `phone`, `address`, `language_preference`, `qc_id_path`, `created_at`) VALUES
(1, 'admin', 'admin01', 'admin123', 'Marcus Geremie D.R. Pelaez', 'admin@example.com', '09171234567', 'Quezon City', 'English', NULL, '2025-08-21 08:47:40'),
(2, 'staff', 'staff01', 'staff123', 'Juan Dela Cruz', 'staff@example.com', '09181234567', 'Caloocan City', 'English', NULL, '2025-08-21 08:47:40'),
(3, 'citizen', 'citizen01', 'citizen123', 'Maria Santos', 'citizen@example.com', '09221234567', 'Pasig City', 'Filipino', NULL, '2025-08-21 08:47:40'),
(5, 'citizen', 'Willbert', 'user123', 'John Willbert T. Tasara', 'tasaraj80@gmail.com', '09674613269', '39 MACAPAGAL STREET AREA 1B PASONG TAMO, QUEZON CITY', 'English', '../uploads/qc_ids/1756040793_QCIDSAMPLE.jpg', '2025-08-24 13:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_management_logs`
--

CREATE TABLE `user_management_logs` (
  `log_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `target_user_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`alert_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `alert_delivery`
--
ALTER TABLE `alert_delivery`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `alert_id` (`alert_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`audit_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `citizen_alerts`
--
ALTER TABLE `citizen_alerts`
  ADD PRIMARY KEY (`citizen_alert_id`),
  ADD KEY `citizen_id` (`citizen_id`),
  ADD KEY `alert_id` (`alert_id`);

--
-- Indexes for table `citizen_messages`
--
ALTER TABLE `citizen_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `citizen_queries`
--
ALTER TABLE `citizen_queries`
  ADD PRIMARY KEY (`query_id`),
  ADD KEY `citizen_id` (`citizen_id`),
  ADD KEY `responded_by` (`responded_by`);

--
-- Indexes for table `citizen_services`
--
ALTER TABLE `citizen_services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `citizen_id` (`citizen_id`);

--
-- Indexes for table `evacuation_templates`
--
ALTER TABLE `evacuation_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `external_warnings`
--
ALTER TABLE `external_warnings`
  ADD PRIMARY KEY (`warning_id`);

--
-- Indexes for table `hotlines`
--
ALTER TABLE `hotlines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incident_templates`
--
ALTER TABLE `incident_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `alert_id` (`alert_id`),
  ADD KEY `sent_by` (`sent_by`);

--
-- Indexes for table `qc_id_verifications`
--
ALTER TABLE `qc_id_verifications`
  ADD PRIMARY KEY (`verification_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `verified_by` (`verified_by`);

--
-- Indexes for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff_performance`
--
ALTER TABLE `staff_performance`
  ADD PRIMARY KEY (`performance_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff_profiles`
--
ALTER TABLE `staff_profiles`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_management_logs`
--
ALTER TABLE `user_management_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `target_user_id` (`target_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `alert_delivery`
--
ALTER TABLE `alert_delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `citizen_alerts`
--
ALTER TABLE `citizen_alerts`
  MODIFY `citizen_alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `citizen_messages`
--
ALTER TABLE `citizen_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `citizen_queries`
--
ALTER TABLE `citizen_queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `citizen_services`
--
ALTER TABLE `citizen_services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evacuation_templates`
--
ALTER TABLE `evacuation_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `external_warnings`
--
ALTER TABLE `external_warnings`
  MODIFY `warning_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotlines`
--
ALTER TABLE `hotlines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incident_templates`
--
ALTER TABLE `incident_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `qc_id_verifications`
--
ALTER TABLE `qc_id_verifications`
  MODIFY `verification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_performance`
--
ALTER TABLE `staff_performance`
  MODIFY `performance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_profiles`
--
ALTER TABLE `staff_profiles`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_management_logs`
--
ALTER TABLE `user_management_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `fk_alerts_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `alert_delivery`
--
ALTER TABLE `alert_delivery`
  ADD CONSTRAINT `alert_delivery_ibfk_1` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`alert_id`),
  ADD CONSTRAINT `alert_delivery_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `citizen_alerts`
--
ALTER TABLE `citizen_alerts`
  ADD CONSTRAINT `citizen_alerts_ibfk_1` FOREIGN KEY (`citizen_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `citizen_alerts_ibfk_2` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`alert_id`);

--
-- Constraints for table `citizen_messages`
--
ALTER TABLE `citizen_messages`
  ADD CONSTRAINT `citizen_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `citizen_messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `citizen_queries`
--
ALTER TABLE `citizen_queries`
  ADD CONSTRAINT `citizen_queries_ibfk_1` FOREIGN KEY (`citizen_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `citizen_queries_ibfk_2` FOREIGN KEY (`responded_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `citizen_services`
--
ALTER TABLE `citizen_services`
  ADD CONSTRAINT `citizen_services_ibfk_1` FOREIGN KEY (`citizen_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD CONSTRAINT `notification_logs_ibfk_1` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`alert_id`),
  ADD CONSTRAINT `notification_logs_ibfk_2` FOREIGN KEY (`sent_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `qc_id_verifications`
--
ALTER TABLE `qc_id_verifications`
  ADD CONSTRAINT `qc_id_verifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `qc_id_verifications_ibfk_2` FOREIGN KEY (`verified_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `staff_attendance`
--
ALTER TABLE `staff_attendance`
  ADD CONSTRAINT `staff_attendance_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff_profiles` (`staff_id`);

--
-- Constraints for table `staff_performance`
--
ALTER TABLE `staff_performance`
  ADD CONSTRAINT `staff_performance_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff_profiles` (`staff_id`);

--
-- Constraints for table `staff_profiles`
--
ALTER TABLE `staff_profiles`
  ADD CONSTRAINT `staff_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD CONSTRAINT `system_settings_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_management_logs`
--
ALTER TABLE `user_management_logs`
  ADD CONSTRAINT `user_management_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_management_logs_ibfk_2` FOREIGN KEY (`target_user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
