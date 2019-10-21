-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2019 at 09:26 PM
-- Server version: 10.2.27-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nst_sql`
--

-- --------------------------------------------------------

--
-- Table structure for table `devicedata`
--

CREATE TABLE `devicedata` (
  `id` int(11) NOT NULL,
  `data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `current_lat` double NOT NULL,
  `current_lng` double NOT NULL,
  `current_status` int(11) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `token`, `current_lat`, `current_lng`, `current_status`, `last_update`) VALUES
(1, 'NST-02-01', 39.908119, 32.7520028, 3, '2019-10-21 21:26:03'),
(2, 'NST-02-02', 41.152911, 28.985438, 1, '2019-10-21 21:26:03'),
(3, 'NST-02-03', 41.158911, 28.985438, 1, '2019-10-21 21:26:03'),
(4, 'NST-02-04', 41.154911, 28.985438, 1, '2019-10-21 21:26:03'),
(5, 'NST-02-05', 41.152911, 28.983338, 1, '2019-10-21 21:26:03'),
(6, 'NST-02-06', 41.192911, 28.983338, 1, '2019-10-21 21:26:03'),
(7, 'NST-02-07', 41.192911, 28.980338, 1, '2019-10-21 21:26:03'),
(8, 'NST-02-08', 41.192911, 28.975338, 1, '2019-10-21 21:26:03'),
(9, 'NST-02-09', 41.188911, 28.975338, 1, '2019-10-21 21:26:03');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `temperature` double NOT NULL,
  `date` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `seen` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `device_id`, `duration`, `temperature`, `date`, `start_date`, `end_date`, `seen`) VALUES
(6, 1, 25, 26.3, '2019-10-20 11:48:56', '2019-10-20 11:48:24', '2019-10-20 11:48:56', 1),
(5, 1, 19, 26.5, '2019-10-20 11:37:40', '2019-10-20 11:37:18', '2019-10-20 11:37:40', 1),
(7, 1, 15, 26.2, '2019-10-20 12:17:56', '2019-10-20 12:17:38', '2019-10-20 12:17:56', 1),
(8, 1, 18, 26.8, '2019-10-20 12:43:12', '2019-10-20 12:42:38', '2019-10-20 12:43:12', 1),
(9, 1, 28, 27.6, '2019-10-20 12:47:13', '2019-10-20 12:46:42', '2019-10-20 12:47:13', 1),
(14, 1, 24, 30.5, '2019-10-20 15:39:04', '2019-10-20 15:38:37', '2019-10-20 15:39:04', 1),
(13, 1, 32, 30.4, '2019-10-20 15:37:33', '2019-10-20 15:36:55', '2019-10-20 15:37:33', 1),
(15, 1, 18, 28.5, '2019-10-20 17:08:21', '2019-10-20 17:08:01', '2019-10-20 17:08:21', 1),
(16, 1, 34, 31, '2019-10-20 17:32:30', '2019-10-20 17:31:32', '2019-10-20 17:32:30', 1),
(17, 1, 19, 26.5, '2019-10-20 21:42:27', '2019-10-20 21:42:05', '2019-10-20 21:42:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessionRecords`
--

CREATE TABLE `sessionRecords` (
  `id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `os` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `browser` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `sessioncode` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`, `icon`) VALUES
(1, 'Stabil', 'https://nst.crmmi.com/assets/status/green.png'),
(2, 'Cihaz Çalışmıyor', 'https://nst.crmmi.com/assets/status/grey.png'),
(3, 'Alarm', 'https://nst.crmmi.com/assets/status/red.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `last_login`, `last_login_ip`, `auth`) VALUES
(1, 'nst@crmmi.com', 'nst', '123', '2019-10-20 08:34:00', '212.156.76.118', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `devicedata`
--
ALTER TABLE `devicedata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessionRecords`
--
ALTER TABLE `sessionRecords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
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
-- AUTO_INCREMENT for table `devicedata`
--
ALTER TABLE `devicedata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sessionRecords`
--
ALTER TABLE `sessionRecords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
