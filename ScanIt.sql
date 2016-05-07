-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 04, 2016 at 08:05 PM
-- Server version: 5.7.11-log
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scanit`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `ItemID` bigint(11) UNSIGNED ZEROFILL NOT NULL,
  `Name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Available` tinyint(1) NOT NULL,
  `Restricted` tinyint(1) NOT NULL DEFAULT '0'COMMENT 'Age restricted'
) ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` bigint(11) UNSIGNED ZEROFILL NOT NULL COMMENT 'A_I = ON',
  `UserID` smallint(5) UNSIGNED ZEROFILL NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TotPrice` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchitem`
--

CREATE TABLE `purchitem` (
  `ItemNum` bigint(11) UNSIGNED ZEROFILL NOT NULL,
  `OrderID` bigint(11) UNSIGNED ZEROFILL NOT NULL,
  `PurchPrice` decimal(5,2) NOT NULL,
  `Quantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` smallint(5) UNSIGNED ZEROFILL NOT NULL,
  `FName` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LName` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Addr1` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Addr2` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `City` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `State` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `ZIP` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `EmailAddr` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Username',
  `PhoneNum` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `CCNum` bigint(16) DEFAULT NULL,
  `UserLevel` tinyint(3) UNSIGNED ZEROFILL NOT NULL DEFAULT '000',
  `Password` char(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FName`, `LName`, `Addr1`, `Addr2`, `City`, `State`, `ZIP`, `EmailAddr`, `PhoneNum`, `CCNum`, `UserLevel`, `Password`) VALUES
(00001, 'system', 'administrator', '1220 Coffeen Street', NULL, 'Watertown', 'NY', '13601', 'admin@scan-it.com', '3157862200', NULL, 255, '200ceb26807d6bf99fd6f4f0d1ca54d4');
INSERT INTO `users` (`UserID`, `FName`, `LName`, `Addr1`, `Addr2`, `City`, `State`, `ZIP`, `EmailAddr`, `PhoneNum`, `CCNum`, `UserLevel`, `Password`) VALUES
(00002, 'inital', 'user', 'Company Address 1', 'Company Address 2', 'City', 'NY', '00000', 'default@scan-it.com', '5555555555', NULL, 20, '5f4dcc3b5aa765d61d8327deb882cf99');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD UNIQUE KEY `OrderID` (`OrderID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `purchitem`
--
ALTER TABLE `purchitem`
  ADD PRIMARY KEY (`ItemNum`,`OrderID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `EmailAddr` (`EmailAddr`),
  ADD KEY `LName` (`LName`,`EmailAddr`,`PhoneNum`),
  ADD KEY `LName_2` (`LName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `ItemID` bigint(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` bigint(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'A_I = ON';
--
-- AUTO_INCREMENT for table `purchitem`
--
ALTER TABLE `purchitem`
  MODIFY `ItemNum` bigint(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` smallint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `purchitem`
--
ALTER TABLE `purchitem`
  ADD CONSTRAINT `PurchItem_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `PurchItem_ibfk_2` FOREIGN KEY (`ItemNum`) REFERENCES `item` (`ItemID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
