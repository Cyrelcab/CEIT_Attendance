-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 04:29 AM
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
-- Database: `event_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `event_audience`
--

CREATE TABLE `event_audience` (
  `id` int(30) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `schoolid` varchar(250) NOT NULL,
  `school_year` varchar(250) NOT NULL,
  `department` varchar(250) NOT NULL,
  `course` varchar(250) NOT NULL,
  `year_level` varchar(250) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_audience`
--

INSERT INTO `event_audience` (`id`, `event_id`, `name`, `schoolid`, `school_year`, `department`, `course`, `year_level`, `contact`, `email`, `status`, `date_created`, `date_updated`) VALUES
(32, 16, 'Juomell Cenabre', '2023-1233', '2023-2024', 'IT', 'BSIT', '4th', '09876543212', 'juomell.cenabre@gmail.com', 0, '2024-05-28 08:58:46', NULL),
(33, 16, 'Erika Abellar', '2021-0204', '2023-2024', 'IT', 'DCT', '2nd', '09121864079', 'jessel.cagmat@csucc.edu.ph', 0, '2024-05-28 09:08:15', NULL),
(34, 16, 'Jessel Cagmat', '2021-0909', '2023-2024', 'Engineering', 'BSEE', '2nd', '97686678677', 'jessel.cagmat@csucc.edu.ph', 0, '2024-05-28 09:09:24', NULL),
(35, 18, 'Jance Wesley Cenabre', '2021-0867', '2022-2023', 'IT', 'BSCpE', '3rd', '0912186423', 'jancewesle.ceanbre@csucc.edu.ph', 0, '2024-05-28 09:13:02', '2024-05-28 09:26:59'),
(36, 20, 'Romelyn V. Abastas', '2021-0634', '2023-2024', 'Engineering', 'BSEE', '2nd', '0923232333', 'romelyn.abastas@csucc.edu.ph', 0, '2024-05-28 09:13:40', '2023-05-28 09:57:24'),
(37, 20, 'Rey Jhon Manili', '2021-0453', '2023-2024', 'Engineering', 'EET', '1st', '09121864079', 'reyjhon.manili@csucc.edu.ph', 0, '2024-05-28 09:14:32', '2023-05-28 09:56:09'),
(38, 20, 'Nikoo Landonga', '2020-0384', '2022-2023', 'IT', 'BSIT', '2nd', '09876543210', 'nikoo.landonga@csucc.edu.ph', 0, '2024-05-28 09:15:36', '2023-05-28 09:47:02'),
(39, 17, 'Saranade Mongie', '2021-0657', '2022-2023', 'IT', 'BSIT', '4th', '0912186429', 'saranade.mongie@csucc.edu.ph', 0, '2024-05-28 09:16:41', '2024-05-28 09:26:35'),
(40, 20, 'Jose Manalo', '2019-0563', '2022-2023', 'IT', 'BSEE', '', '0912175234', 'jose.manalo@csucc.edu.ph', 0, '2024-05-28 09:17:37', '2023-05-28 10:04:55'),
(41, 20, 'Jhon Mark Guzon', '2021-0534', '2022-2023', 'IT', 'BSIT', '3rd', '0912834234', 'jhonmark.guzon@csucc.edu.ph', 0, '2024-05-28 09:18:21', '2023-05-28 09:46:36'),
(42, 19, 'Eunis Ballaran', '2021-0534', '2024-2025', 'IT', 'BSIT', '4th', '0923232333', 'eunis.ballaran@csucc.edu.ph', 0, '2024-05-28 09:36:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_list`
--

CREATE TABLE `event_list` (
  `id` int(30) NOT NULL,
  `title` varchar(250) NOT NULL,
  `venue` varchar(250) NOT NULL,
  `school_year` int(11) NOT NULL,
  `semester` varchar(250) NOT NULL,
  `department` varchar(250) NOT NULL,
  `course` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `year_level` varchar(250) NOT NULL,
  `limit_registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Don''t Close, 1= entry has timeout',
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime NOT NULL,
  `limit_time` float DEFAULT NULL,
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `total_attending` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_list`
--

INSERT INTO `event_list` (`id`, `title`, `venue`, `school_year`, `semester`, `department`, `course`, `description`, `year_level`, `limit_registration`, `datetime_start`, `datetime_end`, `limit_time`, `user_id`, `date_created`, `date_update`, `total_attending`) VALUES
(17, 'IT Days', 'Himalayan', 2022, '1st', 'IT', 'BSIT & DCT', 'Attend!', 'All', 1, '2023-02-28 09:10:00', '2023-03-28 10:10:00', 1, 0, '2024-05-28 09:10:30', '2024-05-28 09:39:50', 0),
(18, 'General Assembly', 'AVR', 2023, '2nd', 'All', 'All', 'Attend!', '4th', 1, '2024-05-28 09:11:00', '2024-05-28 10:11:00', 2, 0, '2024-05-28 09:12:23', '2024-05-28 09:33:41', 0),
(19, 'LCO', 'Gym', 2024, '1st', 'All', 'All', 'attend', 'All', 1, '2025-03-28 09:35:00', '2025-03-28 09:35:00', 20, 0, '2024-05-28 09:35:31', NULL, 0),
(20, 'Awarding', 'Gym', 2022, '2nd', 'All', 'All', 'Attend!', 'All', 1, '2023-05-28 09:44:00', '2023-05-28 10:44:00', 1, 0, '2023-05-28 09:44:35', '2023-05-28 09:48:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `registration_history`
--

CREATE TABLE `registration_history` (
  `id` int(30) NOT NULL,
  `event_id` int(30) NOT NULL,
  `audience_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration_history`
--

INSERT INTO `registration_history` (`id`, `event_id`, `audience_id`, `user_id`, `date_created`) VALUES
(1, 1, 3, 3, '2021-07-26 15:35:33'),
(2, 1, 1, 3, '2021-07-26 15:40:04'),
(3, 4, 10, 3, '2024-02-28 18:04:43'),
(4, 5, 12, 1, '2024-03-01 21:51:33'),
(5, 3, 12, 1, '2024-03-01 22:02:50'),
(6, 3, 1, 1, '2024-03-01 23:15:56'),
(7, 3, 3, 1, '2024-03-01 23:17:44'),
(8, 1, 12, 1, '2024-03-01 23:24:37'),
(9, 6, 3, 1, '2024-03-01 23:33:47'),
(10, 6, 1, 1, '2024-03-01 23:34:03'),
(11, 6, 12, 1, '2024-03-01 23:34:11'),
(12, 15, 31, 1, '2024-05-28 04:46:02'),
(13, 16, 32, 1, '2024-05-28 09:00:09'),
(14, 16, 33, 1, '2024-05-28 09:20:20'),
(15, 18, 37, 1, '2024-05-28 09:21:24'),
(16, 18, 36, 1, '2024-05-28 09:21:36'),
(17, 18, 35, 1, '2024-05-28 09:21:54'),
(18, 17, 41, 1, '2024-05-28 09:22:51'),
(19, 17, 40, 1, '2024-05-28 09:23:00'),
(20, 17, 38, 1, '2024-05-28 09:23:08'),
(21, 17, 39, 1, '2024-05-28 09:23:17'),
(22, 19, 42, 1, '2024-05-28 09:37:29'),
(23, 20, 38, 1, '2023-05-28 09:48:54'),
(24, 20, 40, 1, '2023-05-28 09:49:02'),
(25, 20, 41, 1, '2023-05-28 09:50:24'),
(26, 20, 37, 1, '2023-05-28 09:56:46'),
(27, 20, 36, 1, '2023-05-28 09:57:57');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Information Technology Event Attendance System'),
(2, 'address', 'Philippines'),
(3, 'contact', '+1234567890'),
(4, 'email', 'info@sample.com'),
(5, 'fb_page', 'https://www.facebook.com/myPageName'),
(6, 'short_name', 'IT EAS'),
(9, 'logo', 'uploads/1709299980_download.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=Admin,2=Registrar',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1709301360_399972430_274011178973309_6897524317576608863_n.jpg', NULL, 1, '2021-01-20 14:02:37', '2024-03-01 21:56:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_audience`
--
ALTER TABLE `event_audience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_list`
--
ALTER TABLE `event_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration_history`
--
ALTER TABLE `registration_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_audience`
--
ALTER TABLE `event_audience`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `event_list`
--
ALTER TABLE `event_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `registration_history`
--
ALTER TABLE `registration_history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
