-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 12, 2018 at 02:43 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `postissue`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `adminity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`uid`, `username`, `password`, `adminity`) VALUES
(1, 'Rajesh', 'Passw0rd', 0),
(2, 'Sheldon', 'w0rdPass', 0);

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
CREATE TABLE IF NOT EXISTS `people` (
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `adminity` int(11) NOT NULL DEFAULT '0',
  `locked` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid` (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`uid`, `username`, `password`, `adminity`, `locked`) VALUES
(1, 'Piyush', '135,60.195,90.210,90.', 0, 0),
(2, 'Akash', '60,0.240,90.195,60.', 0, 0),
(3, 'Qureshi', '75,15.240,135.225,15.', 0, 0),
(4, 'Rajesh', '60,15.120,15.225,15.', 0, 0),
(5, 'Kamal', '120,45.135,45.180,75.', 0, 0),
(6, 'Seno', '90,30.180,135.105,135.', 0, 0),
(7, 'Kartik', '90,30.150,30.285,30.', 0, 0),
(8, 'POL', '90,30.90,30.90,30.', 0, 0),
(9, 'lomba', '105,30.105,45.255,105.', 0, 0),
(10, 'shapiro', '90,30.90,30.90,30.', 0, 0),
(11, 'pico', '$2y$11$fqM9o19.fg9oOk5Ymyusq.bIlOaTADQvxzvfQASbPyPHbXRm3XTRq', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `pid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `priority` varchar(10) NOT NULL DEFAULT '"LOW"',
  `poster` varchar(50) NOT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`pid`, `title`, `body`, `date`, `priority`, `poster`) VALUES
(1, 'Network security review', 'complete project', '2018-10-11', 'HIGH', 'Rajesh'),
(2, 'Web security review', 'Complete the atsk', '2018-10-12', 'MED', 'Qureshi'),
(3, 'task_5556', 'Have', '2018-10-24', 'LOW', 'Seno'),
(10, 'pop', 'non', '2022-09-24', 'MED', 'pico'),
(7, 'pillo&lt;&gt;', 'koppa', '2018-12-03', 'LOW', 'Rajesh'),
(8, 'Attempt after securing', '&lt;script&gt;alert(\\&quot;xss hack. site defaced\\&quot;);&lt;/script&gt;', '2018-11-03', 'LOW', 'Rajesh'),
(9, 'ok', 'bbaa', '2022-09-24', 'LOW', 'shapiro');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
