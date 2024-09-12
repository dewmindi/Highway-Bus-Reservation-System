-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2024 at 10:04 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `obrsphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked`
--

CREATE TABLE `booked` (
  `id` int(30) NOT NULL,
  `schedule_id` int(30) NOT NULL,
  `ref_no` text NOT NULL,
  `name` varchar(250) NOT NULL,
  `qty` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '1=Paid, 0- Unpaid',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` varchar(255) NOT NULL,
  `nic` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booked`
--

INSERT INTO `booked` (`id`, `schedule_id`, `ref_no`, `name`, `qty`, `status`, `date_updated`, `email`, `nic`) VALUES
(1, 1, '202206248407', 'Leala', 2, 1, '2022-06-25 21:43:13', '', 0),
(2, 4, '202206252673', 'James Waldron', 2, 0, '2022-06-25 17:10:27', '', 0),
(3, 2, '202206251496', 'Christine Moore', 3, 1, '2022-06-25 23:21:55', '', 0),
(4, 4, '202206254769', 'Hughie', 1, 1, '2022-06-25 20:02:23', '', 0),
(5, 7, '202206257753', 'Chris', 34, 0, '2022-06-25 20:04:20', '', 0),
(6, 5, '20220625746', 'Will Williams', 3, 1, '2022-06-25 23:19:45', '', 0),
(7, 9, '202206252201', 'Test Name', 1, 0, '2022-06-25 23:23:51', '', 0),
(20, 1, '202406019749', 'Umeshika Dewmindi', 2, 0, '2024-06-01 20:40:31', 'udewmindi.ud@gmail.com', 9960),
(21, 1, '202406013362', 'Shalini', 2, 0, '2024-06-01 20:45:32', 'udewmindi.ud@gmail.com', 1212),
(22, 1, '202406014456', 'su', 6, 0, '2024-06-01 20:56:08', 'udewmindi.ud@gmail.com', 1222),
(24, 1, '202406019428', 'Zonu Suuu', 9, 0, '2024-06-01 21:58:24', 'udewmindi.ud@gmail.com', 3412),
(30, 2, '20240607841', 'Dewmindi P L U', 2, 0, '2024-06-07 19:54:39', 'udewmindi.ud@gmail.com', 9960);

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `bus_number` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = inactive, 1 = active',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`id`, `name`, `bus_number`, `status`, `date_updated`) VALUES
(1, 'Greyhound', 'ADG4455', 1, '2022-06-24 18:59:55'),
(2, 'Greyhound', 'ADG7782', 1, '2022-06-24 19:00:21'),
(3, 'Greyhound', 'ADG6657', 1, '2022-06-24 19:00:37'),
(4, 'Greyhound', 'ADG1769', 1, '2022-06-24 19:00:51'),
(5, 'BoltBus', 'SFH2587', 1, '2022-06-24 19:01:13'),
(6, 'BoltBus', 'SFH7777', 1, '2022-06-24 19:01:18'),
(7, 'RedCoach', 'QWE8787', 1, '2022-06-24 19:01:38'),
(8, 'Jefferson', 'ERE2585', 1, '2022-06-24 19:01:54'),
(9, 'Vamoze', 'TWE8969', 1, '2022-06-24 19:02:14'),
(10, 'FlixB', 'TTY5874', 1, '2022-06-24 19:02:38'),
(11, 'Vamoze', 'TWE1258', 1, '2022-06-24 19:02:54');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(30) NOT NULL,
  `terminal_name` text NOT NULL,
  `city` varchar(250) NOT NULL,
  `state` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0= inactive , 1= active',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `terminal_name`, `city`, `state`, `status`, `date_updated`) VALUES
(1, 'Mathara', '', '', 1, '2024-06-02 16:50:14'),
(2, 'Makumbura', '', '', 1, '2024-06-02 16:50:30'),
(3, 'Kaduwela', '', '', 1, '2024-06-02 16:50:43'),
(4, 'Kadawatha', '', '', 1, '2024-06-02 16:50:54'),
(5, 'Pettah', '', '', 1, '2024-06-02 16:51:07'),
(6, 'Panadura', '', '', 1, '2024-06-02 16:47:07'),
(7, 'Kandy', '', '', 1, '2024-06-02 16:47:31'),
(8, 'Monaragala', '', '', 1, '2024-06-24 19:13:18'),
(9, 'Negombo', '', '', 1, '2024-06-24 19:09:37'),
(10, 'Trinco', '', '', 1, '2024-06-02 16:49:07'),
(11, 'Kurunagala', '', '', 1, '2024-06-02 16:49:35'),
(12, 'Piliyanadala', '', '', 1, '2024-06-02 16:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Vithanage', 'pl.umeshika99@gmail.com', '$2y$10$IG3myJ.Lo7FcscMKZ5zjReLEnQyLbBXhdUNOfGQ1GrE6k.GZq47dK', '2024-06-02 09:00:46'),
(11, 'Umindu', 'umindu@gmail.com', '$2y$10$rpkDcK0ut62Xauvfn8bC8O7arJZhHYPc6RflQeu/WVgj9Fn2NlDHS', '2024-06-02 14:20:18'),
(20, 'Sonu', 'sonu@gmail.com', '$2y$10$5NQqUOB62DTvksboz4gqye/MpX3iOkbMCYTlXF8oEi8fhvBHkvr2q', '2024-06-07 04:41:12'),
(26, 'broon', 'broon@gmail.com', '$2y$10$TkNc8k8wNFXovUkWlYs8/.g3y2H0AIsQY9knVUSZTad3HP4.zEeL6', '2024-06-07 06:19:21'),
(27, 'suu', 'suu@gmail.com', '$2y$10$s.G//EswUwNn8jfR4qGWtOj3bqIcvWQGLkZ5cCvZNW5ZOgYardjpe', '2024-06-07 11:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int(30) NOT NULL,
  `bus_id` int(30) NOT NULL,
  `from_location` int(30) NOT NULL,
  `to_location` int(30) NOT NULL,
  `departure_time` datetime NOT NULL,
  `eta` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `availability` int(11) NOT NULL,
  `price` text NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_list`
--

INSERT INTO `schedule_list` (`id`, `bus_id`, `from_location`, `to_location`, `departure_time`, `eta`, `status`, `availability`, `price`, `date_updated`) VALUES
(1, 11, 1, 5, '2022-06-25 15:00:00', '2022-06-25 20:00:00', 1, 25, '50', '2022-06-25 17:27:08'),
(2, 6, 1, 4, '2022-06-25 20:00:00', '2022-06-25 01:00:00', 1, 30, '26', '2022-06-25 09:09:20'),
(3, 1, 3, 9, '2022-06-26 10:00:00', '2022-06-26 16:00:00', 1, 32, '33', '2022-06-25 09:10:46'),
(4, 9, 4, 1, '2022-06-26 08:00:00', '2022-06-26 19:00:00', 1, 30, '65', '2022-06-25 09:11:55'),
(5, 7, 8, 10, '2022-06-27 10:00:00', '2022-06-27 19:00:00', 1, 33, '80', '2022-06-25 09:13:02'),
(6, 4, 7, 6, '2022-06-26 11:00:00', '2022-06-25 13:00:00', 1, 35, '43', '2022-06-25 09:17:10'),
(7, 8, 9, 4, '2022-06-27 15:00:00', '2022-06-27 23:00:00', 1, 34, '75', '2022-06-25 09:18:08'),
(8, 3, 6, 2, '2022-06-27 12:00:00', '2022-06-25 17:00:00', 1, 31, '68', '2022-06-25 09:20:35'),
(9, 10, 11, 12, '2022-06-26 10:00:00', '2022-06-26 13:00:00', 1, 38, '65', '2022-06-25 17:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(150) NOT NULL,
  `user_type` tinyint(1) NOT NULL DEFAULT 1,
  `username` varchar(25) NOT NULL,
  `password` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT ' 0 = incative , 1 = active',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_type`, `username`, `password`, `status`, `date_updated`) VALUES
(1, 'Administrator', 1, 'admin', 'f2d0ff370380124029c2b807a924156c', 1, '2022-06-25 20:13:42'),
(3, 'AdminWilly', 2, 'willy', 'f2d0ff370380124029c2b807a924156c', 1, '2022-06-25 20:14:01'),
(4, 'AdminLea', 1, 'leadmin', 'f2d0ff370380124029c2b807a924156c', 1, '2022-06-25 20:14:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked`
--
ALTER TABLE `booked`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `schedule_list`
--
ALTER TABLE `schedule_list`
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
-- AUTO_INCREMENT for table `booked`
--
ALTER TABLE `booked`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `bus`
--
ALTER TABLE `bus`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
