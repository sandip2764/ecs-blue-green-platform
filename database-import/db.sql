-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2025 at 02:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `karfect`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `landmark` varchar(100) DEFAULT NULL,
  `type` enum('Home','Work','Other') DEFAULT 'Home',
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `name`, `phone`, `address`, `landmark`, `type`, `latitude`, `longitude`, `is_default`, `created_at`) VALUES
(8, 4, 'sandip', '8597402188', '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', 'barisha youth club', 'Home', 22.478864, 88.302725, 1, '2025-05-09 10:30:52'),
(9, 4, 'sandip 2', '8967568353', 'Kolkata, West Bengal, India', NULL, 'Work', 22.574355, 88.362873, 0, '2025-05-09 16:40:44'),
(10, 4, 'vivek', '8481087683', '1, Naktala Rd, Hati Bagan, Bansdroni, Kolkata, West Bengal 700047, India', NULL, 'Home', 22.472330, 88.365989, 0, '2025-05-10 05:54:44'),
(11, 6, 'Krishnendu barik', '8016449935', '1468, Ustad Amir Ali Khan Sarani, Arobindo Pally, Paschim Putiary, Kolkata, West Bengal 700041, India', 'dollyvilla', 'Home', 22.472131, 88.337500, 1, '2025-05-13 08:05:07'),
(12, 9, 'test', '1234567890', '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', 'barisha youth club', 'Work', 22.478864, 88.302725, 1, '2025-05-14 05:35:41'),
(13, 3, 'sandip', '87675436725', '2/1F, Tollygunge Rd, Chetla, Kolkata, West Bengal 700027, India', NULL, 'Home', 22.515589, 88.333892, 1, '2025-06-20 10:25:45');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `username` varchar(55) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`) VALUES
(1, '', 'karfect', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'admin@karfect.com', '$2y$10$lXviostzagMngefiGlmJlOSCZURG6odY4ftSA5x7vNdXdth6tYkne', '2025-06-16 14:37:04'),
(2, 'newadmin@karfect.com', '$2y$10$1z5Qz2Y2v3Qz3Qz4Qz5Qz6Qz7Qz8Qz9Qz0Qz1Qz2Qz3Qz4Qz5Qz6', '2025-06-16 14:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `image` varchar(255) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `service_id`, `quantity`, `image`, `added_at`) VALUES
(115, 4, 74, 1, 'uploads/684f11f9afb69-77.png', '2025-06-20 09:04:34');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Success','Failed') DEFAULT 'Pending',
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `status`, `latitude`, `longitude`, `address`, `created_at`) VALUES
('ORDER_1746719531', 4, NULL, 'Pending', 28.642227, 77.261872, 'J7R6+VP Delhi, India', '2025-05-08 15:52:11'),
('ORDER_1746719534', 4, NULL, 'Pending', 28.642227, 77.261872, 'J7R6+VP Delhi, India', '2025-05-08 15:52:14'),
('ORDER_1746719544', 4, NULL, 'Pending', 28.642227, 77.261872, 'J7R6+VP Delhi, India', '2025-05-08 15:52:24'),
('ORDER_1746725060', 4, NULL, 'Pending', 28.607754, 77.229734, 'Pandara Market, 11-12, Barda Ukil Marg, Pandara Flats, India Gate, New Delhi, Delhi 110003, India', '2025-05-08 17:24:20'),
('ORDER_1746725070', 4, NULL, 'Pending', 28.607754, 77.229734, 'Pandara Market, 11-12, Barda Ukil Marg, Pandara Flats, India Gate, New Delhi, Delhi 110003, India', '2025-05-08 17:24:30'),
('order_QdOyOHVzmVMIg1', 4, 1888.00, 'Success', 22.472330, 88.365989, '1, Naktala Rd, Hati Bagan, Bansdroni, Kolkata, West Bengal 700047, India', '2025-06-05 05:38:34'),
('order_QfZiWbwjEOAZBi', 4, 944.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-06-10 17:26:46'),
('order_QhkcVyXD4awoER', 4, 944.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-06-16 05:24:59'),
('order_Qhl2X6SVju1u4o', 4, 5891.74, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-06-16 05:49:20'),
('order_QiBBywEnJQaawU', 4, 14866.82, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-06-17 07:24:32'),
('order_QjO2NBFs1oZUcl', 4, 13920.46, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-06-20 08:37:21'),
('order_QjPtX1imSLQ92r', 3, 352.82, 'Success', 22.515589, 88.333892, '2/1F, Tollygunge Rd, Chetla, Kolkata, West Bengal 700027, India', '2025-06-20 10:26:35'),
('order_QSsvOMprJSWOxZ', 4, 29972.00, 'Pending', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-09 15:47:14'),
('order_QSt6rWMX4wA1Pj', 4, 2832.00, 'Pending', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-09 15:58:11'),
('order_QSthl81YDYqa84', 4, 6608.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-09 16:32:59'),
('order_QStQsEtSmfPZ5E', 4, 4720.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-09 16:16:54'),
('order_QT759w4WCH6XTm', 4, 2832.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-10 05:38:07'),
('order_QT7IVuSWjL23EM', 4, 3776.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-10 05:50:46'),
('order_QT7Nn6UKWjJ4SA', 4, 3776.00, 'Success', 22.472330, 88.365989, '1, Naktala Rd, Hati Bagan, Bansdroni, Kolkata, West Bengal 700047, India', '2025-05-10 05:55:50'),
('order_QT7oAn9hELh07E', 4, 2832.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-10 06:20:39'),
('order_QT9CRhTokyGIk3', 4, 1888.00, 'Success', 22.472330, 88.365989, '1, Naktala Rd, Hati Bagan, Bansdroni, Kolkata, West Bengal 700047, India', '2025-05-10 07:42:23'),
('order_QTG1NC9Ot51J54', 4, 2832.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-10 14:22:44'),
('order_QTGofBB4W1COsH', 4, 944.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-10 15:09:22'),
('order_QTHjExIBzvUwGO', 4, 1888.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-10 16:02:56'),
('order_QTHsmhaaWiWJpz', 4, 1888.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-10 16:12:00'),
('order_QTVgraBn3VlvnU', 4, 2832.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-11 05:42:25'),
('order_QTVmppUwLsJ8fc', 4, 2832.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-11 05:48:03'),
('order_QTVyDKLMkT0hEN', 4, 944.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-11 05:58:51'),
('order_QTW9aTSkNqgHUZ', 4, 944.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-11 06:09:49'),
('order_QTWqrWzGQAaKY5', 4, 1888.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-11 06:50:35'),
('order_QTX1qHYHm9ffjG', 4, 2832.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-11 07:01:04'),
('order_QUggKqrsFLOU4W', 6, 2832.00, 'Success', 22.472131, 88.337500, '1468, Ustad Amir Ali Khan Sarani, Arobindo Pally, Paschim Putiary, Kolkata, West Bengal 700041, India', '2025-05-14 05:06:39'),
('order_QUhBlk1rF4sUp1', 9, 944.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-14 05:36:17'),
('order_QUL5RpsSh2dBIw', 4, 944.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-13 07:59:07'),
('order_QULCmkrtxdz8B5', 6, 944.00, 'Success', 22.472131, 88.337500, '1468, Ustad Amir Ali Khan Sarani, Arobindo Pally, Paschim Putiary, Kolkata, West Bengal 700041, India', '2025-05-13 08:06:59'),
('order_QXTH7gzc0yU7H0', 9, 944.00, 'Success', 22.478864, 88.302725, '2/1F, Dakshin Behala Rd, Beside बारिशा यूथ क्लब, Srikrishna Pally, Behala, Kolkata, West Bengal 700061, India', '2025-05-21 05:58:06');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `service_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `service_id`, `title`, `quantity`, `price`, `image`) VALUES
(1, 'order_QSthl81YDYqa84', 1, 'Back pain relief massage', 7, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(2, 'order_QT759w4WCH6XTm', 1, 'Back pain relief massage', 3, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(3, 'order_QT7IVuSWjL23EM', 1, 'Back pain relief massage', 4, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(4, 'order_QT7Nn6UKWjJ4SA', 1, 'Back pain relief massage', 4, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(5, 'order_QT7oAn9hELh07E', 1, 'Back pain relief massage', 3, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(6, 'order_QT9CRhTokyGIk3', 1, 'Back pain relief massage', 2, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(7, 'order_QTG1NC9Ot51J54', 1, 'Back pain relief massage', 3, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(8, 'order_QTGofBB4W1COsH', 1, 'Back pain relief massage', 1, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(9, 'order_QTHjExIBzvUwGO', 1, 'Back pain relief massage', 2, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(10, 'order_QTHsmhaaWiWJpz', 1, 'Back pain relief massage', 2, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(11, 'order_QTVgraBn3VlvnU', 1, 'Back pain relief massage', 3, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(12, 'order_QTVmppUwLsJ8fc', 1, 'Back pain relief massage', 3, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(13, 'order_QTVyDKLMkT0hEN', 1, 'Back pain relief massage', 1, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(14, 'order_QTW9aTSkNqgHUZ', 1, 'Back pain relief massage', 1, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(15, 'order_QTWqrWzGQAaKY5', 1, 'Back pain relief massage', 2, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(16, 'order_QTX1qHYHm9ffjG', 1, 'Back pain relief massage', 3, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(17, 'order_QUL5RpsSh2dBIw', 1, 'Back pain relief massage', 1, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(18, 'order_QULCmkrtxdz8B5', 1, 'Back pain relief massage', 1, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(19, 'order_QUggKqrsFLOU4W', 1, 'Back pain relief massage', 3, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(20, 'order_QUhBlk1rF4sUp1', 1, 'Back pain relief massage', 1, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(21, 'order_QXTH7gzc0yU7H0', 1, 'Back pain relief massage', 1, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(22, 'order_QdOyOHVzmVMIg1', 1, 'Back pain relief massage', 2, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(23, 'order_QfZiWbwjEOAZBi', 1, 'Back pain relief massage', 1, 800.00, 'https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_1232,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1681981718912-7bde2d.jpeg'),
(24, 'order_QhkcVyXD4awoER', 1, 'Back pain relief massage', 1, 800.00, 'uploads/684d8da483220-back_pain_relief_men.png'),
(25, 'order_Qhl2X6SVju1u4o', 3, 'Neck pain relief massage', 1, 800.00, 'uploads/684c392cacddb-neck_pain_relief.png'),
(26, 'order_Qhl2X6SVju1u4o', 2, 'Deep tissue massage', 1, 1000.00, 'uploads/684c2964ea2a8-deep_tissue_massage.png'),
(27, 'order_Qhl2X6SVju1u4o', 50, 'Back & Shoulder Relief Massage', 1, 499.00, 'uploads/684ef2f6bb7d3-53.png'),
(28, 'order_Qhl2X6SVju1u4o', 51, 'Leg & Foot Pain Massage', 1, 499.00, 'uploads/684ef33b9f3b6-54.png'),
(29, 'order_Qhl2X6SVju1u4o', 52, 'Head & Neck Relief Massage', 1, 399.00, 'uploads/684ef376c8a7d-55.png'),
(30, 'order_Qhl2X6SVju1u4o', 53, 'Aromatherapy Relaxing Massage', 1, 399.00, 'uploads/684ef3cecf257-56.png'),
(31, 'order_Qhl2X6SVju1u4o', 56, 'Under Eye Treatment', 1, 499.00, 'uploads/684ef53f766e2-59.png'),
(32, 'order_Qhl2X6SVju1u4o', 57, 'Lip Lightening Mask', 1, 599.00, 'uploads/684ef5bf7f79c-61.png'),
(33, 'order_Qhl2X6SVju1u4o', 59, 'Brightening Coffee Scrub', 1, 299.00, 'uploads/684ef67c495db-62.png'),
(34, 'order_QiBBywEnJQaawU', 72, 'Party DJ & Sound Setup', 1, 12599.00, 'uploads/684f11048d7fa-75.png'),
(35, 'order_QjO2NBFs1oZUcl', 62, 'AC Repair & Servicing', 1, 1399.00, 'uploads/684f0d4c90c1c-65.png'),
(36, 'order_QjO2NBFs1oZUcl', 32, 'Face waxing', 1, 399.00, 'uploads/684e9d9f3e798-34.png'),
(37, 'order_QjO2NBFs1oZUcl', 74, 'All Types of Decorations', 1, 9999.00, 'uploads/684f11f9afb69-77.png'),
(38, 'order_QjPtX1imSLQ92r', 29, 'Back waxing', 1, 299.00, 'uploads/684e9bd4dc0ec-32.png');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `discounted_price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `duration` varchar(20) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT 0.00,
  `reviews` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `original_price`, `discounted_price`, `image`, `category`, `duration`, `rating`, `reviews`, `description`, `created_at`) VALUES
(1, 'Back pain relief massage', 1200.00, 800.00, 'uploads/684d8da483220-back_pain_relief_men.png', 'men_pain_relief', '40 mins', 4.80, 11000, 'High-pressure focused massage to address all the pain points/areas in the back. Eliminates pain, stiffness & inflammation.', '2025-04-28 14:55:05'),
(2, 'Deep tissue massage', 1500.00, 1000.00, 'uploads/684c2964ea2a8-deep_tissue_massage.png', 'men_pain_relief', '50 mins', 4.90, 8000, 'Deep tissue massage to relieve stress and muscle tension.', '2025-04-28 14:55:05'),
(3, 'Neck pain relief massage', 1200.00, 800.00, 'uploads/684c392cacddb-neck_pain_relief.png', 'men_pain_relief', '40 mins', 4.80, 1000, 'High-pressure focused massage to address all the pain points/areas in the neck. Eliminates pain, stiffness & inflammation.', '2025-04-28 14:55:05'),
(4, 'Leg pain relief massage', 1400.00, 499.00, 'uploads/684c390fbdbd2-leg_pain_men.png', 'men_pain_relief', '40 mins', 4.80, 11000, 'High-pressure focused massage to address all the pain points/areas in the leg. Eliminates pain, stiffness & inflammation', '2025-04-28 14:55:05'),
(5, 'Head & Scalp Massage', 1500.00, 1000.00, 'uploads/684c38f83af64-men_head_scalp.png', 'men_stress_relief', '50 mins', 4.90, 8000, 'Relieves mental tension, improves sleep,\r\nand promotes relaxation.', '2025-04-28 14:55:05'),
(6, 'Anti-dandruff hair treatment', 1500.00, 800.00, 'uploads/684c287d63c16-men_anti-dandruff_clean2.png', 'men_haircare', '30 mins', 4.90, 8000, 'Reduction in dandruff through exfoliation & cleansing. Includes active oil massage, tonic & mask treatment.', '2025-04-28 14:55:05'),
(7, 'Face & neck detan', 1400.00, 499.00, 'uploads/684c2b1dc1cba-men_face_detan.png', 'men_detan', '30 mins', 4.80, 11000, 'Removes sun tan, evens out skin tone, and brightens. the face and neck for a fresh, radiant look.', '2025-04-28 14:55:05'),
(8, 'Hand detan', 1500.00, 399.00, 'uploads/684c38dbe148d-men_hand_detan.png', 'men_detan', '30 mins', 4.90, 8000, 'Effectively removes sun tan from hands, restores natural skin tone. and leaves the skin smooth and glowing.', '2025-04-28 14:55:05'),
(9, 'Office-ready cleanup', 1200.00, 799.00, 'uploads/684c3948a6b04-men_office_ready_cleanup.png', 'men_facial_cleanup', '20 mins', 4.90, 1000, 'Quick grooming session that includes face cleansing, detanning, and basic. touch-ups to give you a fresh, professional look for work or meetings.', '2025-04-28 14:55:05'),
(10, 'Skin-brightening facial', 1500.00, 1299.00, 'uploads/684c3984f14ae-men_skin_brightening.png', 'men_facial_cleanup', '30 mins', 4.90, 8000, 'Revives dull skin, reduces pigmentation, and enhances your natural glow. for a brighter, more radiant complexion.', '2025-04-28 14:55:05'),
(11, 'Skin hydrating facial', 1400.00, 1299.00, 'uploads/684c39794d90e-men_skin_hydrating.png', 'men_facial_cleanup', '45 mins', 4.70, 11000, 'Deeply moisturizes dry and tired skin, restoring softness. and leaves your face feeling fresh, plump, and nourished.', '2025-04-28 14:55:05'),
(12, 'Oil-free vacation cleanup', 1500.00, 999.00, 'uploads/684c3960d1605-men_oilfree_vacation_cleanup.png', 'men_facial_cleanup', '50 mins', 4.90, 8000, 'Removes excess oil, dirt, and tan. to leave your skin fresh, matte, and ready for a flawless vacation look.', '2025-04-28 14:55:05'),
(13, 'Charcoal de-toxifying cleanup', 1200.00, 800.00, 'uploads/684c2936435da-men_de-toxifying_cleanup.png', 'men_facial_cleanup', '40 mins', 4.80, 1000, 'Draws out deep impurities, unclogs pores, and controls. excess oil for a clear, refreshed, and detoxified skin tone.', '2025-04-28 14:55:05'),
(14, 'Haircut for men', 1500.00, 249.00, 'uploads/684c38c349eb0-haircut_men2.png', 'haircut_beard_styling', '30 mins', 4.90, 8000, 'Precision haircut tailored to your style. and face shape, leaving you with a clean, sharp, and confident look.', '2025-04-28 14:55:05'),
(15, 'Haircut for kids', 1400.00, 199.00, 'uploads/684c38a95a340-haircut_kids.png', 'haircut_beard_styling', '30 mins', 4.80, 11000, 'Gentle and stylish haircut designed for kids. ensuring comfort, safety, and a fun grooming experience.', '2025-04-28 14:55:05'),
(16, 'Beard trimming & styling', 1500.00, 399.00, 'uploads/684c26f11597f-beard_trim.png', 'haircut_beard_styling', '30 mins', 4.90, 8000, 'Get your beard shaped, trimmed, and styled. to perfection for a neat, well-groomed, and modern look.', '2025-04-28 14:55:05'),
(17, 'Clean shave', 1200.00, 299.00, 'uploads/684c295314ab9-clean_shave.png', 'haircut_beard_styling', '20 mins', 4.80, 1000, 'Smooth and precise shave that. leaves your skin fresh, clean, and irritation-free with a polished finish.', '2025-04-28 14:55:05'),
(18, 'Beard color (with product)', 1500.00, 499.00, 'uploads/684c26e30025d-beard_color.png', 'haircut_beard_styling', '30 mins', 4.90, 8000, 'Enhances or covers grays with a natural-looking shade. giving your beard a fresh, youthful, and well-groomed appearance.', '2025-04-28 14:55:05'),
(19, 'Brightening lemon deep cleanser pedicure', 1400.00, 799.00, 'uploads/684c28b9610ca-men_pedicure14.png', 'men_pedicure_manicure', '45 mins', 4.80, 11000, 'Refreshes tired feet by deeply cleansing, exfoliating, and brightening. the skin with the power of lemon for soft, radiant feet.', '2025-04-28 14:55:05'),
(20, 'Brightening lemon express pedicure', 1500.00, 999.00, 'uploads/684c28d1a9e22-men_pedicure15.png', 'men_pedicure_manicure', '50 mins', 4.90, 8000, 'A quick and refreshing pedicure that cleanses and brightens. your feet using lemon extracts, leaving them fresh and energized in no time.', '2025-04-28 14:55:05'),
(21, 'Express manicure', 1200.00, 899.00, 'uploads/684c2ca82bb3d-manicure_men939.png', 'men_pedicure_manicure', '30 mins', 4.50, 12000, 'A quick grooming session for your hands that includes. nail shaping, cuticle care, and a clean hand polish.', '2025-06-13 13:49:21'),
(22, 'Hair color (only application)', 500.00, 199.00, 'uploads/684c38865587d-men_hair_colour.png', 'men_haircare', '30 mins', 4.90, 10000, 'Enhances or covers grays with a natural-looking shade. giving your beard a fresh, youthful, and well-groomed appearance.', '2025-06-13 14:41:10'),
(23, 'Beard color', 1500.00, 499.00, 'uploads/684db1f14edaf-clean_shave.png', 'men_pain_relief', '30 mins', 4.00, 12000, 'testing', '2025-06-14 17:31:29'),
(24, 'Full arms & underarms waxing', 1400.00, 299.00, 'uploads/684e99428ad28-27.png', 'women_waxing', '30 mins', 4.00, 12000, 'Removes unwanted hair smoothly from arms and underarms. leaving the skin clean, soft, and long-lastingly smooth.', '2025-06-15 09:58:26'),
(25, 'Leg waxing', 1299.00, 299.00, 'uploads/684e9ab956eab-28.png', 'women_waxing', '40 mins', 4.60, 9000, 'Removes hair from thighs to ankles . leaving your legs smooth and tan-free for weeks.', '2025-06-15 10:04:41'),
(26, 'Underarm waxing', 1399.00, 299.00, 'uploads/684e9b260e4e7-29.png', 'women_waxing', '50 mins', 5.00, 2000, 'Gently clears hair from underarms . giving you clean and fresh-looking skin.', '2025-06-15 10:06:30'),
(27, 'Full-Body Waxing', 1599.00, 799.00, 'uploads/684e9b6dbeed6-30.png', 'women_waxing', '50 mins', 4.70, 29000, 'Covers arms, legs, underarms, back, and more . for all-over smoothness and hygiene.', '2025-06-15 10:07:41'),
(28, 'Arms waxing', 799.00, 199.00, 'uploads/684e9ba1addda-31.png', 'women_waxing', '30 mins', 5.00, 2989, 'Removes hair from shoulders to fingertips . leaving your arms soft and silky.', '2025-06-15 10:08:33'),
(29, 'Back waxing', 999.00, 299.00, 'uploads/684e9bd4dc0ec-32.png', 'women_waxing', '30 mins', 4.80, 19872, 'Clears hair from upper and lower back . giving you a cleaner and confident look.', '2025-06-15 10:09:24'),
(30, 'Stomach waxing', 1299.00, 399.00, 'uploads/684e9c1774fe6-33.png', 'women_waxing', '30 mins', 4.60, 12000, 'Removes unwanted hair from the stomach area . for a neat and polished appearance.', '2025-06-15 10:10:31'),
(31, 'Threading', 1199.00, 599.00, 'uploads/684e9d0dbdef4-35.png', 'women_threading_and_face_waxing', '40 mins', 4.80, 10000, 'Precisely shapes eyebrows and removes facial hair . giving a clean and defined look.', '2025-06-15 10:14:37'),
(32, 'Face waxing', 999.00, 399.00, 'uploads/684e9d9f3e798-34.png', 'women_threading_and_face_waxing', '30 mins', 4.80, 12000, 'Removes fine facial hair from forehead to chin. for smooth, bright, and flawless skin.', '2025-06-15 10:17:03'),
(33, 'Oil-Free Vacation Cleanup', 1499.00, 899.00, 'uploads/684ea7e7e8c72-36.png', 'women_cleanup', '40 mins', 4.80, 15000, 'Removes excess oil, tan, and dirt . giving a matte and travel-ready glow.', '2025-06-15 11:00:55'),
(34, 'Charcoal Detox Cleanup', 1499.00, 899.00, 'uploads/684ea82d91d90-37.png', 'women_cleanup', '50 mins', 5.00, 18000, 'Draws out deep impurities and tightens pores. for clear, detoxified skin.', '2025-06-15 11:02:05'),
(35, 'Tan Removal Cleanup', 1499.00, 999.00, 'uploads/684ea86241e12-38.png', 'women_cleanup', '30 mins', 5.00, 19900, 'Gently exfoliates and removes sun tan. restoring your natural skin tone.', '2025-06-15 11:02:58'),
(36, 'Fruit Glow Cleanup', 1599.00, 1099.00, 'uploads/684ea8b17ca17-39.png', 'women_cleanup', '45 mins', 4.50, 12000, 'Enriched with fruit extracts. This cleanup gives an instant fresh and radiant look.', '2025-06-15 11:04:17'),
(37, 'Brightening Lemon Cleanup', 1299.00, 799.00, 'uploads/684ea8e4c7487-40.png', 'women_cleanup', '50 mins', 5.00, 12000, 'Infused with lemon extracts. brightens dull skin and reduces pigmentation.', '2025-06-15 11:05:08'),
(38, 'Gold Facial', 3499.00, 2999.00, 'uploads/684ea9b2e76e3-41.png', 'women_facial', '1 hour', 4.20, 1000, 'Nourishes skin deeply. boosts glow and gives a rich, radiant finish.', '2025-06-15 11:08:34'),
(39, ' Diamond Facial', 4999.00, 4699.00, 'Uploads/685524c287f5e-42.png', 'women_facial', '1 hour', 3.80, 299, 'Exfoliates and rejuvenates skin. leaving it polishe and glowing like a diamond.', '2025-06-15 11:09:28'),
(40, 'Skin-Brightening Facial', 1299.00, 699.00, 'uploads/684eaa78812b4-43.png', 'women_facial', '45 mins', 5.00, 30020, 'Reduces dullness and dark spots. revealing a visibly brighter complexion.\r\n\r\n', '2025-06-15 11:11:52'),
(41, 'Anti-Aging Facial', 1599.00, 1499.00, 'uploads/684eab78139ca-44.png', 'women_facial', '50 mins', 4.80, 16000, 'Tightens skin and reduces fine lines. for a youthful and firm look.', '2025-06-15 11:16:08'),
(42, 'Hydrating Facial', 1299.00, 1099.00, 'uploads/684eabc4678f8-45.png', 'women_facial', '45 mins', 4.80, 12000, 'Deeply moisturizes dry and tired skin. leaving it plump, soft, and refreshed.', '2025-06-15 11:17:24'),
(43, 'Bleach', 1299.00, 699.00, 'uploads/684ee6252cc8c-46.png', 'women_hair_bleach_detan', '40 mins', 4.60, 12000, 'Lightens facial hair and brightens skin. for an even-toned, glowing look.', '2025-06-15 15:26:29'),
(44, 'Detan', 1599.00, 999.00, 'uploads/684ee68abf5d5-47.png', 'women_hair_bleach_detan', '45 mins', 5.00, 12000, 'Removes suntan and pigmentation. restoring your natural glow.', '2025-06-15 15:28:10'),
(45, 'Hair color & mehendi (only application)', 699.00, 399.00, 'uploads/684ee717d7f89-48.png', 'women_hair_bleach_detan', '50 mins', 4.70, 1200, 'Nourishes hair from roots to tips. Repairs dryness and adds shine.', '2025-06-15 15:30:31'),
(46, 'Classic Pedicure', 999.00, 799.00, 'uploads/684ee7798b5a2-49.png', 'women_pedicure_manicure', '50 mins', 5.00, 12000, 'Soaks, scrubs, and smooths your feet. for soft, clean, and refreshed soles.', '2025-06-15 15:32:09'),
(47, 'Brightening Lemon Pedicure', 1299.00, 999.00, 'uploads/684ee7d6d9eb4-50.png', 'women_pedicure_manicure', '30 mins', 4.20, 10000, 'Lemon-infused cleanse and exfoliation. Removes tan and adds natural glow.', '2025-06-15 15:32:38'),
(48, 'Spa Pedicure', 1299.00, 599.00, 'uploads/684ee80ea7959-51.png', 'women_pedicure_manicure', '30 mins', 4.50, 11000, 'Deep foot care with massage and hydration. to relax and pamper your feet.', '2025-06-15 15:34:38'),
(49, 'Express Manicure', 899.00, 499.00, 'uploads/684ee84d81808-52.png', 'women_pedicure_manicure', '40 mins', 4.90, 19990, 'A quick hand cleanup with nail shaping. gives a neat and polished look.', '2025-06-15 15:35:41'),
(50, 'Back & Shoulder Relief Massage', 1299.00, 499.00, 'uploads/684ef2f6bb7d3-53.png', 'women_pain_relief', '30 mins', 4.20, 12000, 'Relieves muscle tension from long sitting or standing. easing stiffness and pain.', '2025-06-15 16:21:10'),
(51, 'Leg & Foot Pain Massage', 899.00, 499.00, 'uploads/684ef33b9f3b6-54.png', 'women_pain_relief', '30 mins', 4.50, 10000, 'Targets tired legs and heels. improves blood flow and reduces swelling.', '2025-06-15 16:22:19'),
(52, 'Head & Neck Relief Massage', 999.00, 399.00, 'uploads/684ef376c8a7d-55.png', 'women_pain_relief', '30 mins', 4.00, 5666, 'Eases headaches and neck stiffness. Perfect for work stress and fatigue.', '2025-06-15 16:23:18'),
(53, 'Aromatherapy Relaxing Massage', 999.00, 399.00, 'uploads/684ef3cecf257-56.png', 'women_stress_relief', '30 mins', 4.50, 9827, 'Uses calming essential oils. to reduce stress, anxiety, and uplift your mood.', '2025-06-15 16:24:46'),
(54, 'Swedish Relaxation Massage', 1299.00, 499.00, 'uploads/684ef40ac0439-57.png', 'women_stress_relief', '30 mins', 4.80, 1200, 'Gentle massage strokes. to soothe the body and calm the mind.', '2025-06-15 16:25:46'),
(55, 'Foot Reflexology', 899.00, 399.00, 'uploads/684ef463d0a3d-58.png', 'women_stress_relief', '30 mins', 4.50, 1281, 'Applies pressure to foot zones. relaxing the entire body and nervous system.', '2025-06-15 16:27:15'),
(56, 'Under Eye Treatment', 799.00, 499.00, 'uploads/684ef53f766e2-59.png', 'women_add-on', '30 mins', 4.80, 1200, 'Reduces dark circles and puffiness. for a fresh, well-rested look.', '2025-06-15 16:30:55'),
(57, 'Lip Lightening Mask', 899.00, 599.00, 'uploads/684ef5bf7f79c-61.png', 'women_add-on', '30 mins', 4.60, 1287, 'Softens and brightens dark lips. making them smooth and naturally pink.', '2025-06-15 16:33:03'),
(58, 'Neck Brightening Pack', 1299.00, 799.00, 'uploads/684ef5f284605-60.png', 'women_add-on', '30 mins', 4.90, 2439, 'Improves uneven skin tone on neck. for a cleaner and polished appearance.', '2025-06-15 16:33:54'),
(59, 'Brightening Coffee Scrub', 799.00, 299.00, 'uploads/684ef67c495db-62.png', 'women_skin-care_scrubs ', '30 mins', 5.00, 1298, 'Exfoliates dead skin and tan. revealing soft, glowing skin instantly.', '2025-06-15 16:36:12'),
(60, 'Ubtan Herbal Scrub', 499.00, 199.00, 'uploads/684ef6b5759ae-63.png', 'women_skin-care_scrubs ', '30 mins', 4.60, 8653, 'Traditional scrub with turmeric and herbs. brightens and evens out skin tone.', '2025-06-15 16:37:09'),
(61, 'Chocolate Nourishing Scrub', 599.00, 299.00, 'uploads/684ef795f24dc-64.png', 'women_skin-care_scrubs ', '30 mins', 4.20, 2341, 'Deeply moisturizes and softens dry skin. with a rich, relaxing aroma.', '2025-06-15 16:40:53'),
(62, 'AC Repair & Servicing', 2999.00, 1399.00, 'uploads/684f0d4c90c1c-65.png', 'home_appliance _repair_services', '1-2 hours', 4.60, 12000, 'Complete AC checkup, gas refill, and cooling issue fix. ensures smooth and efficient performance.', '2025-06-15 18:13:32'),
(63, 'Refrigerator Repair', 1999.00, 1299.00, 'uploads/684f0d8fef40f-66.png', 'home_appliance _repair_services', '1-2 hours', 4.70, 13000, 'Fixes cooling issues, compressor faults, and water leaks. restores optimal cooling quickly.', '2025-06-15 18:14:39'),
(64, 'Washing Machine, Geyser & Microwave Oven Repair', 1899.00, 1299.00, 'uploads/684f0e034dc09-67.png', 'home_appliance _repair_services', '1-2 hours', 4.20, 1235, 'Fixes heating issues, door problems, and electrical faults. making your cooking hassle-free again.', '2025-06-15 18:16:35'),
(65, 'TV Repair (LED/LCD/Smart TV)', 1299.00, 899.00, 'uploads/684f0e541b7d7-68.png', 'home_appliance _repair_services', 'upto 2 hours', 4.50, 1093, 'Handles screen issues, sound problems, and power faults. for smooth home entertainment.', '2025-06-15 18:17:56'),
(66, 'Computer & Laptop Repair', 3999.00, 2999.00, 'uploads/684f0eb08d158-69.png', 'home_appliance _repair_services', '2 hours', 4.80, 12000, 'Software fixes, hardware upgrades, virus removal. ensures smooth and fast performance.', '2025-06-15 18:19:28'),
(67, 'Full Home Deep Cleaning', 5999.00, 4999.00, 'uploads/684f0efe84983-70.png', 'home_cleaning_services', '2 hours', 4.60, 1298, 'Comprehensive cleaning of all rooms, floors, furniture, and windows . for a dust-free, fresh, and hygienic home.', '2025-06-15 18:20:46'),
(68, 'Toilet & Bathroom Cleaning', 3999.00, 2999.00, 'uploads/684f0f3da0cde-71.png', 'home_cleaning_services', '50 mins', 4.80, 12092, 'Removes stains, hard water marks, and germs from toilet and bathroom surfaces. leaving them sparkling and disinfected.', '2025-06-15 18:21:49'),
(69, 'Kitchen Deep Cleaning', 2999.00, 1999.00, 'uploads/684f0f849083a-72.png', 'home_cleaning_services', '30 mins', 4.30, 1313, 'Degreasing of chimney, tiles, shelves, and appliances. eliminates stains, bacteria, and cooking residue.\r\n\r\n', '2025-06-15 18:23:00'),
(70, 'All kinds of pest control', 1999.00, 1599.00, 'uploads/684f1032b9f48-74.png', 'pest_control', '40 mins', 5.00, 18821, 'Comprehensive treatment covering all common pests for a safe and pest-free living space.', '2025-06-15 18:25:54'),
(71, 'Cockroach Control', 899.00, 599.00, 'uploads/684f1097c7af1-73.png', 'pest_control', '45 mins', 5.00, 7621, 'Targets hidden cockroaches in kitchens and bathrooms. ensures long-lasting protection.', '2025-06-15 18:27:35'),
(72, 'Party DJ & Sound Setup', 12999.00, 12599.00, 'uploads/684f11048d7fa-75.png', 'event_management', 'upto 3 hours', 5.00, 12652, 'Professional DJ with full sound system. plays the latest hits and ensures non-stop entertainment for your events.', '2025-06-15 18:29:24'),
(73, 'Waiters & Catering Staff', 9999.00, 9899.00, 'uploads/684f1177866e0-76.png', 'event_management', 'upto 3 hours', 4.90, 12711, 'Well-trained, uniformed staff for food serving, table setup, and guest assistance. ensuring smooth and hygienic food service.', '2025-06-15 18:31:19'),
(74, 'All Types of Decorations', 14999.00, 9999.00, 'uploads/684f11f9afb69-77.png', 'event_management', '2 hour', 5.00, 129128, 'Custom theme-based decoration including balloons, flowers, lights, and backdrops. Perfect for birthdays, weddings, anniversaries, and corporate events.', '2025-06-15 18:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` varchar(50) NOT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `razorpay_order_id` varchar(50) DEFAULT NULL,
  `payment_id` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Initiated','Success','Failed') DEFAULT 'Initiated',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `order_id`, `razorpay_order_id`, `payment_id`, `amount`, `status`, `created_at`, `updated_at`) VALUES
('txn_1746805634', 'order_QSsvOMprJSWOxZ', 'order_QSsvOMprJSWOxZ', 'pay_QSsvgdl59RXulj', 29972.00, 'Success', '2025-05-09 15:47:14', '2025-05-09 15:47:14'),
('txn_1746806291', 'order_QSt6rWMX4wA1Pj', 'order_QSt6rWMX4wA1Pj', 'pay_QSt7GmVTopPQ1T', 2832.00, 'Success', '2025-05-09 15:58:11', '2025-05-09 15:58:11'),
('txn_1746807415', 'order_QStQsEtSmfPZ5E', 'order_QStQsEtSmfPZ5E', 'pay_QStR2t0GE9HzqH', 4720.00, 'Success', '2025-05-09 16:16:55', '2025-05-09 16:16:55'),
('txn_1746808379', 'order_QSthl81YDYqa84', 'order_QSthl81YDYqa84', 'pay_QSti1XpJJXLaAj', 6608.00, 'Success', '2025-05-09 16:32:59', '2025-05-09 16:32:59'),
('txn_1746855487', 'order_QT759w4WCH6XTm', 'order_QT759w4WCH6XTm', 'pay_QT75PfLXqoX1Gp', 2832.00, 'Success', '2025-05-10 05:38:07', '2025-05-10 05:38:07'),
('txn_1746856246', 'order_QT7IVuSWjL23EM', 'order_QT7IVuSWjL23EM', 'pay_QT7Imcxxb06TBS', 3776.00, 'Success', '2025-05-10 05:50:46', '2025-05-10 05:50:46'),
('txn_1746856551', 'order_QT7Nn6UKWjJ4SA', 'order_QT7Nn6UKWjJ4SA', 'pay_QT7O6tppgFIRV8', 3776.00, 'Success', '2025-05-10 05:55:51', '2025-05-10 05:55:51'),
('txn_1746858039', 'order_QT7oAn9hELh07E', 'order_QT7oAn9hELh07E', 'pay_QT7oKwgIEk2cyN', 2832.00, 'Success', '2025-05-10 06:20:39', '2025-05-10 06:20:39'),
('txn_1746862943', 'order_QT9CRhTokyGIk3', 'order_QT9CRhTokyGIk3', 'pay_QT9Cf4ihl8Tw4h', 1888.00, 'Success', '2025-05-10 07:42:23', '2025-05-10 07:42:23'),
('txn_1746886964', 'order_QTG1NC9Ot51J54', 'order_QTG1NC9Ot51J54', 'pay_QTG1Zq2THobQBb', 2832.00, 'Success', '2025-05-10 14:22:44', '2025-05-10 14:22:44'),
('txn_1746889762', 'order_QTGofBB4W1COsH', 'order_QTGofBB4W1COsH', 'pay_QTGoq4msksvJaw', 944.00, 'Success', '2025-05-10 15:09:22', '2025-05-10 15:09:22'),
('txn_1746892976', 'order_QTHjExIBzvUwGO', 'order_QTHjExIBzvUwGO', 'pay_QTHjPWO5ijlMDS', 1888.00, 'Success', '2025-05-10 16:02:56', '2025-05-10 16:02:56'),
('txn_1746893520', 'order_QTHsmhaaWiWJpz', 'order_QTHsmhaaWiWJpz', 'pay_QTHsz56G5uWlqg', 1888.00, 'Success', '2025-05-10 16:12:00', '2025-05-10 16:12:00'),
('txn_1746942145', 'order_QTVgraBn3VlvnU', 'order_QTVgraBn3VlvnU', 'pay_QTVh2kTTB9i9Pe', 2832.00, 'Success', '2025-05-11 05:42:25', '2025-05-11 05:42:25'),
('txn_1746942483', 'order_QTVmppUwLsJ8fc', 'order_QTVmppUwLsJ8fc', 'pay_QTVn0ZcrSqcU39', 2832.00, 'Success', '2025-05-11 05:48:03', '2025-05-11 05:48:03'),
('txn_1746943131', 'order_QTVyDKLMkT0hEN', 'order_QTVyDKLMkT0hEN', 'pay_QTVyPV2LqGlDy6', 944.00, 'Success', '2025-05-11 05:58:51', '2025-05-11 05:58:51'),
('txn_1746943789', 'order_QTW9aTSkNqgHUZ', 'order_QTW9aTSkNqgHUZ', 'pay_QTW9zEtr4Jx7NP', 944.00, 'Success', '2025-05-11 06:09:49', '2025-05-11 06:09:49'),
('txn_1746946235', 'order_QTWqrWzGQAaKY5', 'order_QTWqrWzGQAaKY5', 'pay_QTWr45MJv4wlj2', 1888.00, 'Success', '2025-05-11 06:50:35', '2025-05-11 06:50:35'),
('txn_1746946864', 'order_QTX1qHYHm9ffjG', 'order_QTX1qHYHm9ffjG', 'pay_QTX27vUDuT11sf', 2832.00, 'Success', '2025-05-11 07:01:04', '2025-05-11 07:01:04'),
('txn_1747123147', 'order_QUL5RpsSh2dBIw', 'order_QUL5RpsSh2dBIw', 'pay_QUL5gHeyXFBICK', 944.00, 'Success', '2025-05-13 07:59:07', '2025-05-13 07:59:07'),
('txn_1747123619', 'order_QULCmkrtxdz8B5', 'order_QULCmkrtxdz8B5', 'pay_QULE0TZRkeN7MN', 944.00, 'Success', '2025-05-13 08:06:59', '2025-05-13 08:06:59'),
('txn_1747199199', 'order_QUggKqrsFLOU4W', 'order_QUggKqrsFLOU4W', 'pay_QUggexPP6tqPTz', 2832.00, 'Success', '2025-05-14 05:06:39', '2025-05-14 05:06:39'),
('txn_1747200977', 'order_QUhBlk1rF4sUp1', 'order_QUhBlk1rF4sUp1', 'pay_QUhBxyDL3Rk8Q2', 944.00, 'Success', '2025-05-14 05:36:17', '2025-05-14 05:36:17'),
('txn_1747807086', 'order_QXTH7gzc0yU7H0', 'order_QXTH7gzc0yU7H0', 'pay_QXTIkg5zPh6x1A', 944.00, 'Success', '2025-05-21 05:58:06', '2025-05-21 05:58:06'),
('txn_1749101914', 'order_QdOyOHVzmVMIg1', 'order_QdOyOHVzmVMIg1', 'pay_QdOyu2sF2KM0ua', 1888.00, 'Success', '2025-06-05 05:38:34', '2025-06-05 05:38:34'),
('txn_1749576406', 'order_QfZiWbwjEOAZBi', 'order_QfZiWbwjEOAZBi', 'pay_QfZihlJOPjnXhu', 944.00, 'Success', '2025-06-10 17:26:46', '2025-06-10 17:26:46'),
('txn_1750051499', 'order_QhkcVyXD4awoER', 'order_QhkcVyXD4awoER', 'pay_Qhkcyofdxqh3AM', 944.00, 'Success', '2025-06-16 05:24:59', '2025-06-16 05:24:59'),
('txn_1750052960', 'order_Qhl2X6SVju1u4o', 'order_Qhl2X6SVju1u4o', 'pay_Qhl2ifU5UcAK3K', 5891.74, 'Success', '2025-06-16 05:49:20', '2025-06-16 05:49:20'),
('txn_1750145072', 'order_QiBBywEnJQaawU', 'order_QiBBywEnJQaawU', 'pay_QiBCP1HVyzNUOq', 14866.82, 'Success', '2025-06-17 07:24:32', '2025-06-17 07:24:32'),
('txn_1750408641', 'order_QjO2NBFs1oZUcl', 'order_QjO2NBFs1oZUcl', 'pay_QjO2cd7eeNITEB', 13920.46, 'Success', '2025-06-20 08:37:21', '2025-06-20 08:37:21'),
('txn_1750415195', 'order_QjPtX1imSLQ92r', 'order_QjPtX1imSLQ92r', 'pay_QjPu04HiKXgFFu', 352.82, 'Success', '2025-06-20 10:26:35', '2025-06-20 10:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `address`, `latitude`, `longitude`, `phone`) VALUES
(1, 'Donjkn10', 'donjkn10@gmail.com', '0', '2025-04-04 15:55:32', NULL, NULL, NULL, NULL),
(3, 'sandip', 'konjno29@gmail.com', '$2y$10$z1L7ALl5n/z2HZ411OXCCufSIdRyzRYD0sEgE5revPstWGvyXMfgm', '2025-04-04 16:05:34', '', NULL, NULL, NULL),
(4, 'Sandip', 'sandipparia27@gmail.com', '$2y$10$fvEVEj6n43crKMjBzu84Aul0Mi.XaXaCAtbAcKnS2FictAgFqW2dK', '2025-04-04 16:07:38', 'D-152, Block D, Defence Colony, New Delhi, Delhi 110024, India', 28.577124, 77.237152, NULL),
(5, 'Sandip', 'dnoob357@gmail.com', '$2y$10$oB.4MwFM/zu5FpovTw7gvu456O5LqgIK/hPQwOjM4seGM1xcKobm2', '2025-04-05 13:50:46', NULL, NULL, NULL, NULL),
(6, 'Sandip Paria', 'dkon8502@gmail.com', '', '2025-04-06 05:33:59', '', NULL, NULL, NULL),
(7, 'Md Ashraf Ali', 'mdashraf9135@gmail.com', '$2y$10$KiKDhCWriTbhZfV.h0UPh.bINugSx.n/aTlsEVwYWqJbJqf58wVNy', '2025-04-23 11:41:00', NULL, NULL, NULL, NULL),
(8, 'sandip', 'sandip.paria27@gmail.com', '$2y$10$yBph1hDGPGf8Mp/foLA8nOp3/dfLNMNxAqYFVTMFw98KL.5.ROeF2', '2025-04-28 08:22:30', NULL, NULL, NULL, NULL),
(9, 'sandip paria', 'sandipparia854@gmail.com', '', '2025-05-14 05:29:03', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `categories` text NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `profession` varchar(255) NOT NULL,
  `workzone` varchar(255) NOT NULL,
  `experience` int(11) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `status` enum('Active','Inactive','Suspended') NOT NULL,
  `rating` decimal(3,1) DEFAULT 0.0,
  `image` varchar(255) NOT NULL,
  `document` varchar(255) NOT NULL,
  `login_password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`id`, `unique_id`, `name`, `categories`, `dob`, `gender`, `profession`, `workzone`, `experience`, `salary`, `phone`, `email`, `address`, `status`, `rating`, `image`, `document`, `login_password`, `created_at`) VALUES
(1, 'karfecthero_123962', 'Sandip paria', 'men_pain_relief,men_stress_relief,men_haircare,men_detan,men_facial_cleanup', '2025-06-16', 'Male', 'Plumber', 'kolkata behala 14 no', 1, 12000.00, '8597402188', 'donjkn10@gmail.com', 'Paharpur to astichak road , monsha mondir, jagannath karbar', 'Active', 4.0, '0', 'admin/uploads/685047ec6cefb-invoice_order_order_Qhl2X6SVju1u4o.pdf', '$2y$10$SkOXUQ1LuLMBnYYzN0FKbOPPF5ohn/UahkaEG57P8l0mvKVsbsOyO', '2025-06-16 16:35:56'),
(2, 'karfecthero_184227', 'Rajesh Patel', 'men_detan', '2025-06-16', 'Male', 'Plumber', 'kolkata newtown', 2, 20000.00, '8753681272', 'konjno@gmail.com', 'Paharpur to astichak road , monsha mondir, jagannath karbar', 'Inactive', 3.0, '0', 'admin/uploads/68504a1c97c60-Sourav_Das_Resume.pdf', '$2y$10$IdbsVW9..gGAsw0Fpon4MutbxJrRIUmIHfkyXGgpKbL/7EbB4hHcq', '2025-06-16 16:45:16'),
(3, 'KARFECTWBSP390467', 'Abhishek Sharma', 'men_stress_relief,men_detan', '1997-10-14', 'Male', 'Painter', 'delhi new bazar', 4, 20000.00, '8729718281', 'example@gmail.com', 'Jagannath karbar ,pirijkhanbar,egra , PURBAMEDiNIPUR', 'Suspended', 0.0, 'admin/uploads/685400a99b65e-28.png', 'admin/uploads/685400a99bd72-invoice_order_order_Qhl2X6SVju1u4o.pdf', '$2y$10$AJCR89QAN5AR.7mqwV5l7eYuC0cZHeHeu9UNxJ17kSjOUEex6RqCC', '2025-06-19 12:20:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_default` (`user_id`,`is_default`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
