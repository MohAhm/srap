-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 01, 2016 at 12:08 AM
-- Server version: 5.7.11
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reserve`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(20) NOT NULL,
  `room_name` varchar(20) NOT NULL,
  `id_user` int(20) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `seats` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `room_name`, `id_user`, `name`, `date_from`, `date_to`, `seats`) VALUES
(1, 'U1-048', NULL, 'sussanne', '2016-12-24', '2016-12-24', 4),
(2, 'U1-048', NULL, 'sussanne', '2016-12-24', '2016-12-24', 2),
(3, 'U1-049', NULL, 'sussanne', '2016-12-24', '2016-12-27', 2),
(4, 'U1-062', NULL, 'sussanne', '2016-12-24', '2016-12-27', 1),
(5, 'U1-049', NULL, 'sussanne', '2016-11-27', '2016-11-27', 2),
(6, 'U1-049', NULL, 'sussanne', '2016-12-27', '2016-12-28', 2);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `seats` int(20) NOT NULL,
  `available` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `mapCord` (
  `name` varchar(20) NOT NULL,
  `north` float(16,2) NOT NULL,
  `west` float(16,2) NOT NULL,
  `south` float(16,2) NOT NULL,
  `east` float(16,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `name`, `seats`, `available`) VALUES
(1, 'U1-048', 8, 1),
(2, 'U1-049', 6, 1),
(3, 'U1-062', 6, 1),
(4, 'U1-050A', 5, 0),
(5, 'U1-050B', 5, 0),
(6, 'U1-063', 5, 0),
(7, 'U1-066C', 2, 0),
(8, 'U1-066B', 2, 0),
(9, 'U1-066A', 2, 0),
(10, 'U1-064', 1, 0),
(11, 'U1-070', 1, 0),
(12, 'U1-071', 1, 0),
(13, 'U1-072', 0, 0),
(14, 'U1-067', 3, 0),
(15, 'U1-068', 2, 0),
(16, 'U1-069', 3, 0),
(17, 'U1-069B', 2, 0),
(18, 'U1-073', 5, 0),
(19, 'U1-077', 5, 0),
(20, 'U1-079', 3, 0),
(21, 'U1-081', 7, 0),
(22, 'U1-084A', 5, 0),
(23, 'U1-084B', 5, 0),
(24, 'U1-089', 2, 0),
(25, 'U1-090', 2, 0),
(26, 'U1-091', 2, 0),
(27, 'U1-092', 1, 0),
(28, 'U1-093', 1, 0),
(29, 'U1-094', 1, 0),
(30, 'U1-095', 1, 0),
(31, 'U1-096', 1, 0),
(32, 'U1-106', 1, 0),
(33, 'U1-107', 1, 0),
(34, 'U1-123', 4, 0),
(35, 'U1-129', 1, 0),
(36, 'U1-130', 1, 0),
(37, 'U1-131', 1, 0),
(38, 'U1-132', 1, 0),
(39, 'U1-169', 1, 0),
(40, 'U1-170', 1, 0),
(41, 'U1-171', 1, 0),
(42, 'U1-172', 1, 0),
(43, 'U1-173', 1, 0),
(44, 'U1-174', 3, 0),
(45, 'U1-146', 2, 0),
(46, 'U1-145', 2, 0),
(47, 'U1-144', 2, 0),
(48, 'U1-143', 2, 0),
(49, 'U1-142', 2, 0),
(50, 'U1-141', 2, 0),
(51, 'U1-138', 2, 0),
(52, 'U1-139', 1, 0),
(53, 'U1-191', 3, 0),
(54, 'U1-193', 1, 0),
(55, 'U1-194', 1, 0),
(56, 'U1-195', 1, 0),
(57, 'U1-197', 1, 0),
(58, 'U1-198A', 3, 0),
(59, 'U1-198B', 3, 0),
(60, 'U1-187', 6, 0),
(61, 'U1-201', 6, 0),
(62, 'U1-204A', 2, 0),
(63, 'U1-125', 2, 0),
(64, 'U1-126', 3, 0),
(65, 'U1-133', 2, 0),
(66, 'U1-134', 1, 0),
(67, 'U1-135', 3, 0);

INSERT INTO `mapCord` VALUES
('U1-048', -30.45, -44.21, -47.28, -63.72),
('U1-049', -30.45, -64.60, -47.28, -77.26),
('U1-062', -30.33, -111.84, -47.07, -124.76),
('U1-050A', -30.33, -78, -37.75, -97.60),
('U1-050B', -40.95, -78, -47.3686, -97.5146),
('U1-063', -24.41, -111.93, -29.73, -124.58),
('U1-066C', -18.15, -111.84,   -23.73, -124.67),
('U1-066B', -11.52, -111.93, -17.39, -124.67),
('U1-066A', -4.83, -111.84, -10.75, -124.67),
('U1-064', -24.41, -98.35, -29.76, -106.52),
('U1-070', 1.93, -98.44, -7.28, -106.61),
('U1-071', 8.75, -98.44, 2.72, -106.61),
('U1-072', 15.41, -98.44, 9.40, -106.61),
('U1-067', 5.35, -111.84, -3.95, -124.67),
('U1-068', 12.04,-111.84, 5.97, -124.67),
('U1-069', 21.78, -111.84, 12.73, -124.67),
('U1-069B', 27.84, -115.31, 22.43, -124.63),
('U1-073', 44.34, -115.31, 28.69, -124.63),
('U1-077', 44.25, -88.24, 28.57, -97.47),
('U1-079', 44.25, -81.30, 28.57, -87.45),
('U1-081', 44.25, -67.76, 28.57, -80.6),
('U1-084A', 44.25, -57.65, 28.57, -67.06),
('U1-084B', 44.25, -44.03, 28.57, -56.87),
('U1-089', 21.78, -30.5, 16.05, -43.33),
('U1-090', 15.33, -30.5, 9.406, -43.33),
('U1-091', 8.75, -30.5, 2.64, -43.33),
('U1-092', 1.89, -35.07, -4.08, -43.33),
('U1-093', -4.78, -35.07, -10.79, -43.33),
('U1-094', -11.48, -35.07, -17.35, -43.33),
('U1-095', -18.06, -35.07, -23.73, -43.33),
('U1-096', -24.37, -35.07, -29.61, -43.33),
('U1-106', 15.41, -16.88, 9.41, -25.14),
('U1-107', 8.71, -16.96, 2.68, -25.31),
('U1-123', 44.28, -3.34, 34.38, -16.17),
('U1-129', 44.31, 3.6, 37.34, -2.55),
('U1-130', 44.31, 10.37, 37.34, 4.39),
('U1-131', 44.31, 17.23, 37.34, 11.16),
('U1-132', 44.31, 24, 37.34, 18.02),
('U1-169', -24.33, 64.69, -29.65, 55.50),
('U1-170', -17.98, 64.69, -23.56, 55.50),
('U1-171', -11.52, 64.69, -17.30, 55.50),
('U1-172', -4.74, 64.69, -10.66, 55.50),
('U1-173', 1.93, 64.69, -3.78, 55.50),
('U1-174', 15.41, 64.69, 2.64, 55.50),
('U1-146', -24.33, 50.19, -29.65, 38.32),
('U1-145', -17.98, 50.19, -23.56, 38.32),
('U1-144', -11.52, 50.19, -17.48, 38.32),
('U1-143', -4.74, 50.19, -10.75, 38.32),
('U1-142', 1.93, 50.19, -4.04, 38.32),
('U1-141', 8.71, 50.19, 2.68, 38.32),
('U1-138', 15.28, 50.19, 9.45, 38.32),
('U1-139', 21.78, 47.59, 16.13, 38.32),
('U1-191', 44.34, 71.46, 37.44, 59.50),
('U1-193', 44.34, 78.27, 37.44, 72.25),
('U1-194', 44.34, 85.08, 37.44, 79.01),
('U1-195', 44.34, 91.76, 37.44, 85.83),
('U1-197', 44.34, 98.57, 37.44, 92.42),
('U1-198A', 44.34, 112.06, 37.44, 99.32),
('U1-198B', 44.34, 124.80, 37.44, 112.85),
('U1-187', 33.06, 91.54, 16.13, 78.88),
('U1-201', 24.93, 105.54, 9.54, 92.55),
('U1-204A', 8.49, 105.54, 2.55, 92.55),
('U1-125', 30.56, 3.60, 16.17, -2.50),
('U1-126', 30.56, 10.24, 16.17, 4.44),
('U1-133', 44.34, 30.71, 36.10, 24.65),
('U1-134', 44.34, 37.35, 36.10, 31.51),
('U1-135', 44.34, 47.42, 36.10, 38.23);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
(1, 'sussanne', 'admin', 'admin'),
(2, 'Jan', 'user', 'user'),
(3, 'Juraj', 'user', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);
  
--
-- Indexes for table `mapCord`
--
ALTER TABLE `mapCord`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
