-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2017 at 01:11 PM
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
-- Table structure for table `tbl_image`
--

CREATE TABLE `tbl_image` (
  `Id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `userName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(4, 'shimba-hills.jpg', 'Shimba Hills Hotel');

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
  `booked` varchar(100) DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_rooms`
--

INSERT INTO `tbl_rooms` (`id`, `companyName`, `roomType`, `capacity`, `price`, `booked`) VALUES
(2, 'Shimba Hills Hotel', 'Lounge', '4', '15,000', 'Yes'),
(3, 'Shimba Hills Hotel', 'Beach side room', '4', '20000', 'Yes');

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
  `website` varchar(200) DEFAULT NULL,
  `means` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `loginType` varchar(100) DEFAULT 'user',
  `subscription` varchar(100) NOT NULL DEFAULT 'N',
  `userStatus` enum('Y','N') NOT NULL DEFAULT 'N',
  `tokenCode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `userName`, `userEmail`, `userPass`, `userPhone`, `about`, `website`, `means`, `category`, `loginType`, `subscription`, `userStatus`, `tokenCode`) VALUES
(1, 'admin', 'admin95@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '712991415', NULL, NULL, NULL, NULL, 'admin', 'N', 'Y', 'fe79c8ee7fdc36c308a4891b8aa20eb1'),
(3, 'Grand Regency', 'Grandregency@yahoo.com', '81dc9bdb52d04dc20036dbd8313ed055', '712991415', NULL, NULL, NULL, NULL, 'company', 'N', 'Y', '7cae4474bf2b66561815e9c59c0e2b71'),
(5, 'Hilton', 'Hilton@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0712991415', NULL, NULL, NULL, NULL, 'company', 'N', 'Y', '8afdc42751ca264cce7fe7f0ead79464'),
(6, 'Serena', 'serena@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0712991415', 'We pride ourself with the best chefs in the world and a diverse work force. Making most out of our diversity to make our customers happy and feeling at home.', '', NULL, NULL, 'company', 'N', 'Y', '705b67157e085b74db3fe3f7fba7d9db'),
(2, 'Shimba Hills Hotel', 'shimbahillshotel@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0712991415', NULL, NULL, NULL, NULL, 'company', 'N', 'Y', '6f078b11506105489c988422d50fb79c'),
(4, 'Sun n Sands', 'emmcodes@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '+254712991415', 'hn', 'www.sun', NULL, NULL, 'company', 'N', 'Y', '57722b2b6fc1118b760f1e075209e92d');

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
-- Indexes for table `tbl_image`
--
ALTER TABLE `tbl_image`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id` (`Id`),
  ADD KEY `userName` (`userName`);

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
-- AUTO_INCREMENT for table `tbl_image`
--
ALTER TABLE `tbl_image`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_prof`
--
ALTER TABLE `tbl_prof`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_base`
--
ALTER TABLE `tbl_base`
  ADD CONSTRAINT `fkuserbase` FOREIGN KEY (`companyName`) REFERENCES `tbl_users` (`userName`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_image`
--
ALTER TABLE `tbl_image`
  ADD CONSTRAINT `fkuserimage` FOREIGN KEY (`userName`) REFERENCES `tbl_users` (`userName`) ON DELETE CASCADE ON UPDATE CASCADE;

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
