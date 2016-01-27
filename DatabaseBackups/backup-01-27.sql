-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2016 at 09:50 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BuildABabe`
--

-- --------------------------------------------------------

--
-- Table structure for table `LOGIN`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(20) NOT NULL,
  `session_cookie` varchar(40) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LOGIN`
--

INSERT INTO `LOGIN` (`id`, `username`, `password`, `salt`, `session_cookie`) VALUES
(1, 'tempuser', '99df00dac4e7820a4df1f49b3148b845513565e8', '00000000000000000000', '7d6yMKQAaGgpijPNUk5GZ70ZVcrkHw0mYCS8TmxL'),
(2, 'tempuser2', 'tempuser2', 'tyHZ3xiAv22onV3aDQat', NULL),
(3, 'tempuser3', '3d62803337dfb60cbc438cf47803de588b14e0ed', '3LeDVgvSD12mwUcRfIhv', 'WD5rAsqfMNxL6tJUQJEjL7aT2f7cypa349hxm1GW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `LOGIN`
--
ALTER TABLE `LOGIN`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `LOGIN`
--
ALTER TABLE `LOGIN`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
