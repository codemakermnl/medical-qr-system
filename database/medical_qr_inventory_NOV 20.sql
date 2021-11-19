-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2021 at 06:35 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medical_qr_inventory`
--
CREATE DATABASE IF NOT EXISTS `medical_qr_inventory` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `medical_qr_inventory`;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `designation_id` int(10) NOT NULL,
  `designation_name` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`designation_id`, `designation_name`) VALUES
(2, 'Emergency Room');

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `equipment_id` int(10) NOT NULL,
  `equipment_type_id` int(10) NOT NULL,
  `designation_id` int(10) NOT NULL,
  `model_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`equipment_id`, `equipment_type_id`, `designation_id`, `model_number`) VALUES
(8, 1, 2, 'asdfasdf'),
(9, 1, 2, 'sdfsa'),
(10, 1, 2, 'h');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_borrow_logs`
--

CREATE TABLE `equipment_borrow_logs` (
  `equipment_borrow_log_id` int(10) NOT NULL,
  `equipment_id` int(10) NOT NULL,
  `date_borrowed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_returned` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `equipment_type`
--

CREATE TABLE `equipment_type` (
  `equipment_type_id` int(10) NOT NULL,
  `equipment_type` varchar(1000) NOT NULL,
  `description` longtext,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipment_type`
--

INSERT INTO `equipment_type` (`equipment_type_id`, `equipment_type`, `description`, `quantity`) VALUES
(1, 'X-Ray', 'x-ray', 1),
(2, 'Sphygmomanometer ', 'Blood Meter up to 300 mmg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `qr_codes`
--

CREATE TABLE `qr_codes` (
  `qr_codes_id` int(10) NOT NULL,
  `equipment_id` int(10) NOT NULL,
  `qr_code_path` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qr_codes`
--

INSERT INTO `qr_codes` (`qr_codes_id`, `equipment_id`, `qr_code_path`) VALUES
(5, 8, 'rODZ3VAu2-Qrcode10.png'),
(6, 9, '5TzZxXNGAI-Qrcode210.png'),
(7, 10, '^1RurQmtAhv-Qrcode244.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `first_name` varchar(1000) NOT NULL,
  `last_name` varchar(1000) NOT NULL,
  `position_id` int(10) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `address` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `position_id`, `employee_id`, `password`, `address`) VALUES
(2, 'asdf', 'asdfasdf', 1, '123', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'asdfasdfasd'),
(6, 'first', 'last', 3, '456', '9adcb29710e807607b683f62e555c22dc5659713', ''),
(7, 'test 7', 'lasty6', 3, '789', '9adcb29710e807607b683f62e555c22dc5659713', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_position`
--

CREATE TABLE `user_position` (
  `position_id` int(10) NOT NULL,
  `name` varchar(266) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_position`
--

INSERT INTO `user_position` (`position_id`, `name`) VALUES
(1, 'Admin'),
(2, 'Staff'),
(3, 'Employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`designation_id`);

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`equipment_id`),
  ADD KEY `equipment_type_id` (`equipment_type_id`),
  ADD KEY `designation_id` (`designation_id`);

--
-- Indexes for table `equipment_borrow_logs`
--
ALTER TABLE `equipment_borrow_logs`
  ADD PRIMARY KEY (`equipment_borrow_log_id`),
  ADD KEY `equipment_id` (`equipment_id`);

--
-- Indexes for table `equipment_type`
--
ALTER TABLE `equipment_type`
  ADD PRIMARY KEY (`equipment_type_id`);

--
-- Indexes for table `qr_codes`
--
ALTER TABLE `qr_codes`
  ADD PRIMARY KEY (`qr_codes_id`),
  ADD KEY `equipment_id` (`equipment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `user_position`
--
ALTER TABLE `user_position`
  ADD PRIMARY KEY (`position_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `designation_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `equipment_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `equipment_borrow_logs`
--
ALTER TABLE `equipment_borrow_logs`
  MODIFY `equipment_borrow_log_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipment_type`
--
ALTER TABLE `equipment_type`
  MODIFY `equipment_type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `qr_codes`
--
ALTER TABLE `qr_codes`
  MODIFY `qr_codes_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_position`
--
ALTER TABLE `user_position`
  MODIFY `position_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
