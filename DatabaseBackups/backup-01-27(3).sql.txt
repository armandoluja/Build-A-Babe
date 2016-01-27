-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2016 at 11:18 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buildababe`
--

-- --------------------------------------------------------

--
-- Table structure for table `body_type_map`
--

CREATE TABLE `body_type_map` (
  `val` int(11) NOT NULL,
  `bodyType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `eye_color_map`
--

CREATE TABLE `eye_color_map` (
  `val` int(11) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hair_color_map`
--

CREATE TABLE `hair_color_map` (
  `val` int(11) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(20) NOT NULL,
  `session_cookie` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `salt`, `session_cookie`) VALUES
(1, 'tempuser', '99df00dac4e7820a4df1f49b3148b845513565e8', '00000000000000000000', 'LIHoN4Z6TWnWb3M58lkmWv7L23irdbRYjE7yBbj8'),
(2, 'tempuser2', 'tempuser2', 'tyHZ3xiAv22onV3aDQat', NULL),
(3, 'tempuser3', '3d62803337dfb60cbc438cf47803de588b14e0ed', '3LeDVgvSD12mwUcRfIhv', 'WD5rAsqfMNxL6tJUQJEjL7aT2f7cypa349hxm1GW');

-- --------------------------------------------------------

--
-- Table structure for table `preference`
--

CREATE TABLE `preference` (
  `id` int(11) NOT NULL,
  `minAge` int(11) NOT NULL DEFAULT '18',
  `maxAge` int(11) NOT NULL DEFAULT '110',
  `gender` int(11) NOT NULL,
  `minHeight` int(11) NOT NULL DEFAULT '36',
  `maxHeight` int(11) NOT NULL DEFAULT '96',
  `oneHair` int(11) DEFAULT NULL,
  `twoHair` int(11) DEFAULT NULL,
  `leastHair` int(11) DEFAULT NULL,
  `oneEye` int(11) DEFAULT NULL,
  `twoEye` int(11) DEFAULT NULL,
  `bodyType` int(11) DEFAULT NULL,
  `skinTone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `fName` varchar(16) NOT NULL,
  `lName` varchar(30) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` int(11) NOT NULL,
  `hairColor` int(11) DEFAULT NULL,
  `eyeColor` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `bodyType` int(11) DEFAULT NULL,
  `skinTone` int(11) DEFAULT NULL,
  `profilePicId` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `saved_user`
--

CREATE TABLE `saved_user` (
  `id` int(11) NOT NULL,
  `savedId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `body_type_map`
--
ALTER TABLE `body_type_map`
  ADD PRIMARY KEY (`val`);

--
-- Indexes for table `eye_color_map`
--
ALTER TABLE `eye_color_map`
  ADD PRIMARY KEY (`val`),
  ADD UNIQUE KEY `val` (`val`);

--
-- Indexes for table `hair_color_map`
--
ALTER TABLE `hair_color_map`
  ADD PRIMARY KEY (`val`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preference`
--
ALTER TABLE `preference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saved_user`
--
ALTER TABLE `saved_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `preference`
--
ALTER TABLE `preference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
