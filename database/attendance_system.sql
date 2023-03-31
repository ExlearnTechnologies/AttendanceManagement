-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2013 at 08:39 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `attendance_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `AttID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(10) NOT NULL,
  `Prensent` int(1) NOT NULL,
  `AttDate` date NOT NULL,
  PRIMARY KEY (`AttID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1496 ;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`AttID`, `EmpID`, `Prensent`, `AttDate`) VALUES
(1495, 23, 1, '2013-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `employee_detail`
--

DROP TABLE IF EXISTS `employee_detail`;
CREATE TABLE IF NOT EXISTS `employee_detail` (
  `EmpID` int(10) NOT NULL AUTO_INCREMENT,
  `EmpName` varchar(255) NOT NULL,
  `EmpAddress` text NOT NULL,
  `EmpMobile` varchar(15) NOT NULL,
  `EmpEmail` varchar(50) NOT NULL,
  `EmpBirthdate` date NOT NULL,
  `EmpBloodGroup` varchar(5) NOT NULL,
  `EmpTechnology` varchar(20) NOT NULL,
  PRIMARY KEY (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `employee_detail`
--

INSERT INTO `employee_detail` (`EmpID`, `EmpName`, `EmpAddress`, `EmpMobile`, `EmpEmail`, `EmpBirthdate`, `EmpBloodGroup`, `EmpTechnology`) VALUES
(23, 'jayvik kashipara', 'rajkot', '9426666226', 'info@kashipara.in', '2013-05-23', 'A+', 'php');

-- --------------------------------------------------------

--
-- Table structure for table `increment_detail`
--

DROP TABLE IF EXISTS `increment_detail`;
CREATE TABLE IF NOT EXISTS `increment_detail` (
  `IncID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(20) NOT NULL,
  `Salary` int(20) NOT NULL,
  `IncrementDate` date NOT NULL,
  PRIMARY KEY (`IncID`),
  KEY `EmpID` (`EmpID`),
  KEY `EmpID_2` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `salary_detail`
--

DROP TABLE IF EXISTS `salary_detail`;
CREATE TABLE IF NOT EXISTS `salary_detail` (
  `SalaryID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(20) NOT NULL,
  `JoinDate` date NOT NULL,
  `EmpType` varchar(20) NOT NULL,
  `CurrentSalary` int(10) NOT NULL,
  `IncrementAmount` int(10) NOT NULL,
  `IncrementAfter` int(5) NOT NULL,
  `IncrementDate` date NOT NULL,
  `LastSalary` int(10) NOT NULL,
  `LastIncrement` date NOT NULL,
  PRIMARY KEY (`SalaryID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UserID` int(10) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  PRIMARY KEY (`UserID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `UserName`, `Password`) VALUES
(2, 'admin', 'admin');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`EmpID`) REFERENCES `employee_detail` (`EmpID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `increment_detail`
--
ALTER TABLE `increment_detail`
  ADD CONSTRAINT `increment_detail_ibfk_1` FOREIGN KEY (`EmpID`) REFERENCES `employee_detail` (`EmpID`) ON DELETE CASCADE;

--
-- Constraints for table `salary_detail`
--
ALTER TABLE `salary_detail`
  ADD CONSTRAINT `salary_detail_ibfk_1` FOREIGN KEY (`EmpID`) REFERENCES `employee_detail` (`EmpID`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
