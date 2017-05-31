-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 30, 2017 at 05:42 AM
-- Server version: 5.7.15
-- PHP Version: 7.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_base`
--

CREATE TABLE `tbl_base` (
  `id` int(11) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `companyBranch` varchar(100) NOT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_base`
--

INSERT INTO `tbl_base` (`id`, `companyName`, `companyBranch`, `category`) VALUES
(2, 'Sun n Sands', 'Mtwapa', 'beach hotel'),
(3, 'Serena', 'Nairobi', '5Star hotel'),
(4, 'Serena', 'Mombasa', '5Star hotel');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prof`
--

CREATE TABLE `tbl_prof` (
  `id` int(11) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `userName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_prof`
--

INSERT INTO `tbl_prof` (`id`, `image`, `userName`) VALUES
(2, 'bg2.jpeg', 'Sun n Sands'),
(3, 'bg2.jpg', 'Serena'),
(4, 'shimba-hills.jpg', 'Shimba Hills Hotel'),
(5, 'hotels.jpg', 'Hilton'),
(6, 'grandregency.jpg', 'Grand Regency'),
(7, 'sarova.jpg', 'Sarova Hotels');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rooms`
--

CREATE TABLE `tbl_rooms` (
  `id` int(11) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `roomType` varchar(100) NOT NULL,
  `capacity` varchar(100) DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `booked` varchar(100) DEFAULT 'No',
  `phoneNumber` int(100) DEFAULT NULL,
  `customerName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_rooms`
--

INSERT INTO `tbl_rooms` (`id`, `companyName`, `roomType`, `capacity`, `price`, `booked`, `phoneNumber`, `customerName`) VALUES
(1, 'Serena', '2bedroom', '4', '10000', 'Yes', 712345678, 'sdfghj'),
(2, 'Serena', 'asd', '5', '20000', 'No', 7345678, 'Emmanuel');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPass` varchar(100) NOT NULL,
  `userPhone` varchar(20) NOT NULL,
  `about` varchar(1000) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `loginType` varchar(100) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `userName`, `userEmail`, `userPass`, `userPhone`, `about`, `website`, `loginType`) VALUES
(1, 'admin', 'admin95@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '712991415', NULL, NULL, 'admin'),
(3, 'Grand Regency', 'Grandregency@yahoo.com', '81dc9bdb52d04dc20036dbd8313ed055', '712991415', NULL, NULL, 'company'),
(5, 'Hilton', 'Hilton@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0712991415', NULL, NULL, 'company'),
(10, 'Sarova Hotels', 'beja.emmanuel@gmail.com', '202cb962ac59075b964b07152d234b70', '0712121212', NULL, NULL, 'company'),
(6, 'Serena', 'serena@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0712991415', 'We pride ourself with the best chefs in the world and a diverse work force. Making most out of our diversity to make our customers happy and feeling at home.', NULL, 'company'),
(2, 'Shimba Hills Hotel', 'shimbahillshotel@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0712991415', NULL, NULL, 'company'),
(4, 'Sun n Sands', 'emmcodes@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '+254712991415', 'hn', NULL, 'company');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_base`
--
ALTER TABLE `tbl_base`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companyName` (`companyName`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tbl_prof`
--
ALTER TABLE `tbl_prof`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `userName` (`userName`);

--
-- Indexes for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `companyName` (`companyName`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userName`),
  ADD UNIQUE KEY `userEmail` (`userEmail`),
  ADD KEY `userName` (`userName`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_base`
--
ALTER TABLE `tbl_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_prof`
--
ALTER TABLE `tbl_prof`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_base`
--
ALTER TABLE `tbl_base`
  ADD CONSTRAINT `fkuserbase` FOREIGN KEY (`companyName`) REFERENCES `tbl_users` (`userName`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_prof`
--
ALTER TABLE `tbl_prof`
  ADD CONSTRAINT `fkuserppic` FOREIGN KEY (`userName`) REFERENCES `tbl_users` (`userName`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  ADD CONSTRAINT `fkroomcompany` FOREIGN KEY (`companyName`) REFERENCES `tbl_users` (`userName`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
