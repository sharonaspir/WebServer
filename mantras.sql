-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2013 at 05:19 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webservice`
--

-- --------------------------------------------------------

--
-- Table structure for table `mantras`
--

CREATE TABLE IF NOT EXISTS `mantras` (
  `Id` varchar(12) NOT NULL,
  `Author` varchar(12) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `ReleventSport` int(2) NOT NULL,
  `ReleventEducation` int(2) NOT NULL,
  `ReleventNewAge` int(2) NOT NULL,
  `ReleventHealth` int(2) NOT NULL,
  `CreationDate` date NOT NULL,
  UNIQUE KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mantras`
--

INSERT INTO `mantras` (`Id`, `Author`, `Description`, `ReleventSport`, `ReleventEducation`, `ReleventNewAge`, `ReleventHealth`, `CreationDate`) VALUES
('1', 'Osho', 'Love is the only miracle there is', 20, 80, 100, 70, '2013-08-16'),
('2', 'Gandhi', 'Be the change you wish to see in the world', 60, 80, 90, 70, '2013-08-16'),
('3', 'Laura Silva', 'Every day in every way I’m getting better and better', 90, 90, 50, 80, '2013-08-16'),
('4', 'Norman Vince', 'I change my thoughts, I change my world', 70, 90, 90, 50, '2013-08-16'),
('5', 'Unknown', 'Eat Well Travel Often', 50, 50, 90, 80, '2013-08-16');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
