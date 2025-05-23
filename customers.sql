-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 09:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lwb_accounts`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `account_number` varchar(50) NOT NULL,
  `area` varchar(100) NOT NULL,
  `category` enum('Residential','Commercial','Institutional','LWB Staff') NOT NULL,
  `water_sources` varchar(255) DEFAULT NULL,
  `connection_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `address`, `phone_number`, `account_number`, `area`, `category`, `water_sources`, `connection_date`, `created_at`) VALUES
(1, 'Test Customer', '123 Main St', NULL, '10001', 'Downtown', 'Residential', NULL, NULL, '2025-05-21 06:36:58'),
(2, 'Ivy', ' Kawale P.O BOX 96 ,lilongwe', NULL, '1000113', 'Kawale 1', 'Residential', NULL, NULL, '2025-05-21 06:41:28'),
(3, 'Wezzie Kamphere', 'Area 44, Chiuzira', '0887833721', '00111', '44', 'LWB Staff', 'Overhead Tank', '2025-05-04', '2025-05-21 09:21:01'),
(4, 'Bashir Kangomba', 'Lilongwe Waterboard P.O Box 96, Lilongwe.', '+265992604833', '00112', '24 katondo', 'Residential', NULL, '2025-05-04', '2025-05-21 09:27:47'),
(5, 'Chigo Nyirenda', 'Lilongwe Waterboard P.O Box 96, Lilongwe.', '0992604833', '00113', '51', 'Residential', 'Taps', '2025-05-12', '2025-05-21 12:22:16'),
(6, 'Joshua Chinoko', 'Lilongwe Waterboard P.O Box 96, Lilongwe.', '0992604833', '00116', '14', 'Institutional', 'Taps', '2025-05-11', '2025-05-21 13:24:46'),
(7, 'eliza Mhango', 'Lilongwe Waterboard P.O Box 96, Lilongwe.', '+265992604833', '1234', '47', 'Commercial', 'Taps', '2025-05-18', '2025-05-22 08:33:57'),
(8, 'victoria', 'mount pleasant P.O Box 96, Lilongwe.', '0992604833', '00117', '22', 'Institutional', 'Taps', '2025-05-12', '2025-05-22 12:09:41'),
(9, 'clara gondwe', 'Lilongwe Waterboard P.O Box 96, Lilongwe.', '+265992604833', '00115', '12', 'Residential', 'Kiosk', '2025-05-30', '2025-05-22 13:15:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_number` (`account_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
