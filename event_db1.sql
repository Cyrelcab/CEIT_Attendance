-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2024 at 11:14 AM
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
-- Database: `event_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `event_audience`
--

CREATE TABLE `event_audience` (
  `id` int(30) NOT NULL,
  `event_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_audience`
--

INSERT INTO `event_audience` (`id`, `event_id`, `name`, `contact`, `email`, `remarks`, `status`, `date_created`, `date_updated`) VALUES
(1, 6, 'Claire Blake', '09123456789', 'cblake@sample.com', '09123456789', 0, '2021-07-26 11:59:02', '2024-03-01 23:33:03'),
(3, 1, 'Mike Williams', '09123456789', 'mwilliams@sample.com', 'Sample', 0, '2021-07-26 15:33:32', '2024-03-01 23:42:54'),
(9, 4, 'Eden Aika Casleb Baguhin', '0912345678', 'HelloWorld1@gmail.com', '45tyfy', 0, '2024-02-28 17:48:21', '2024-02-28 17:55:54'),
(10, 4, 'erika abellar', '0912345678', 'admin@gmail.com', 'sdjadio', 0, '2024-02-28 18:01:17', NULL),
(11, 4, 'erika abellar', '0912345678', 'HelloWorld1@gmail.com', 'try', 0, '2024-02-28 18:03:32', NULL),
(12, 6, 'Jhoejeth Mondejar', '09090909', 'admin@gmail.com', 'mo adto ko!', 0, '2024-03-01 21:48:28', '2024-03-01 23:33:08');

-- --------------------------------------------------------

--
-- Table structure for table `event_list`
--

CREATE TABLE `event_list` (
  `id` int(30) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `venue` text NOT NULL,
  `limit_registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Don''t Close, 1= entry has timeout',
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime NOT NULL,
  `limit_time` float DEFAULT NULL,
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_update` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_list`
--

INSERT INTO `event_list` (`id`, `title`, `description`, `venue`, `limit_registration`, `datetime_start`, `datetime_end`, `limit_time`, `user_id`, `date_created`, `date_update`) VALUES
(1, 'Sample 101', 'Sample Event Only', 'Venue 101', 0, '2024-03-01 11:23:00', '2024-04-01 05:00:00', 0, 3, '2021-07-26 11:10:12', '2024-03-01 23:23:31'),
(3, 'Sample 102', 'Sample only', 'Venue 102', 1, '2024-03-01 15:00:00', '2024-03-02 05:30:00', 30, 3, '2021-07-26 13:36:43', '2024-03-01 22:02:09'),
(5, 'Birthday ni Erika', 'happy na bday mo pa!', 'cabaYawa', 1, '2024-03-01 21:45:00', '2024-03-01 22:10:00', 0, 0, '2024-03-01 21:46:27', '2024-03-01 21:47:07'),
(6, '123', 'first day', 'csucc', 0, '2024-03-01 23:29:00', '2024-03-02 23:29:00', 0, 0, '2024-03-01 23:29:37', NULL);

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
(11, 6, 12, 1, '2024-03-01 23:34:11');

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
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `event_list`
--
ALTER TABLE `event_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `registration_history`
--
ALTER TABLE `registration_history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
