-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2016 at 06:02 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `buildababe`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `getAllMessages`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllMessages`(IN `userId` INT(11))
    NO SQL
SELECT chat.chatId, message.senderId, message.receiverId, message.timeStamp, message.content FROM chat JOIN message on chat.chatId = message.chatId WHERE (chat.userId1 = userId OR chat.userId2 = userId) AND chat.status IS NULL$$


DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `body_type_map`
--

DROP TABLE IF EXISTS `body_type_map`;
CREATE TABLE IF NOT EXISTS `body_type_map` (
  `val` int(11) NOT NULL,
  `bodyType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
`chatId` int(11) NOT NULL,
  `userId1` int(11) NOT NULL,
  `userId2` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT 'null = neither blocked; 0 = both users blocked; 1 = user 1 blocked; 2 = user 2 blocked'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`chatId`, `userId1`, `userId2`, `status`) VALUES
(1, 1, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eye_color_map`
--

DROP TABLE IF EXISTS `eye_color_map`;
CREATE TABLE IF NOT EXISTS `eye_color_map` (
  `val` int(11) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hair_color_map`
--

DROP TABLE IF EXISTS `hair_color_map`;
CREATE TABLE IF NOT EXISTS `hair_color_map` (
  `val` int(11) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `userId` int(11) NOT NULL,
`imageId` int(11) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
`id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(20) NOT NULL,
  `session_cookie` varchar(40) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `salt`, `session_cookie`, `status`) VALUES
(1, 'tempuser', '99df00dac4e7820a4df1f49b3148b845513565e8', '00000000000000000000', 'z6Hvjjm14w1mktBIOjTjyJ3pBhRwtJ5Ul80RMTSv', 0),
(3, 'tempuser3', '3d62803337dfb60cbc438cf47803de588b14e0ed', '3LeDVgvSD12mwUcRfIhv', NULL, 0),
(4, 'tempuser4', '1342bd71c0af757e4a0f3ddb41859b5227a43167', '55ijoT3hpQu6z37Tcc1l', 'lwZfQ2SEGvoG0OOKYud2tGe0qZ2TxQLCJTEtcQau', 0),
(5, 'tempuser5', 'e6cc086b281f584a6dfa11fb3a248c5d201f2590', 'wkrxGL833eRw6FrHG5NY', 'foYVDNCraR3Os8AXGZwdlJ6GvyVTKVGp7oMbKJxr', 0),
(6, 'tempuser7', 'ab39b3d1794cc421f48b19e2fec5aec120b09853', 'JipucIjtr5ReDKn0ETv8', 'ekAjUaHKbMiWBCepqfmcIw2vIpTmOoG85MHma8nu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
`messageId` int(11) NOT NULL,
  `senderId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` varchar(256) NOT NULL,
  `chatId` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageId`, `senderId`, `receiverId`, `timeStamp`, `content`, `chatId`) VALUES
(1, 1, 3, '2016-02-04 04:40:01', 'This is the content of the first message ever sent', 1),
(2, 3, 1, '2016-02-04 04:40:50', 'This is the content for the second message ever sent', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `messageview`
--
DROP VIEW IF EXISTS `messageview`;
CREATE TABLE IF NOT EXISTS `messageview` (
`chatId` int(11)
,`messageId` int(11)
,`senderId` int(11)
,`receiverId` int(11)
,`timeStamp` timestamp
,`content` varchar(256)
);
-- --------------------------------------------------------

--
-- Table structure for table `preference`
--

DROP TABLE IF EXISTS `preference`;
CREATE TABLE IF NOT EXISTS `preference` (
  `id` int(11) NOT NULL COMMENT 'this needs to be 1 to 1 with the login table and profile table',
  `minAge` int(11) NOT NULL DEFAULT '18',
  `maxAge` int(11) NOT NULL DEFAULT '100',
  `gender` varchar(1) CHARACTER SET utf8 NOT NULL,
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

--
-- Dumping data for table `preference`
--

INSERT INTO `preference` (`id`, `minAge`, `maxAge`, `gender`, `minHeight`, `maxHeight`, `oneHair`, `twoHair`, `leastHair`, `oneEye`, `twoEye`, `bodyType`, `skinTone`) VALUES
(0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(1, 18, 20, 'M', 48, 72, 0, 1, 2, 1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(11) NOT NULL,
  `fName` varchar(16) CHARACTER SET utf8 NOT NULL,
  `lName` varchar(30) CHARACTER SET utf8 NOT NULL,
  `gender` varchar(1) CHARACTER SET utf8 NOT NULL,
  `hairColor` int(11) DEFAULT NULL,
  `eyeColor` int(11) DEFAULT NULL,
  `bodyType` int(11) DEFAULT NULL,
  `skinTone` int(11) DEFAULT NULL,
  `profilePicId` int(11) DEFAULT NULL,
  `bio` varchar(240) CHARACTER SET utf8 DEFAULT NULL,
  `birthdate` date NOT NULL,
  `maxSearchDist` int(11) NOT NULL DEFAULT '40',
  `height` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `fName`, `lName`, `gender`, `hairColor`, `eyeColor`, `bodyType`, `skinTone`, `profilePicId`, `bio`, `birthdate`, `maxSearchDist`, `height`) VALUES
(1, 'Armando', 'Luja', 'M', 0, 0, 2, 1, NULL, 'If you are reading this, WE EATIN&#39;', '1995-11-04', 29, NULL),
(3, 'arm', 'ando', 'M', 0, 1, 2, 3, NULL, 'arm bio', '1960-01-01', 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saved_user`
--

DROP TABLE IF EXISTS `saved_user`;
CREATE TABLE IF NOT EXISTS `saved_user` (
  `id` int(11) NOT NULL,
  `savedId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `viewed`
--

DROP TABLE IF EXISTS `viewed`;
CREATE TABLE IF NOT EXISTS `viewed` (
  `viewerId` int(11) NOT NULL,
  `vieweeId` int(11) NOT NULL,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `messageview`
--
DROP TABLE IF EXISTS `messageview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `messageview` AS select `message`.`chatId` AS `chatId`,`message`.`messageId` AS `messageId`,`message`.`senderId` AS `senderId`,`message`.`receiverId` AS `receiverId`,`message`.`timeStamp` AS `timeStamp`,`message`.`content` AS `content` from `message`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `body_type_map`
--
ALTER TABLE `body_type_map`
 ADD PRIMARY KEY (`val`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
 ADD PRIMARY KEY (`chatId`);

--
-- Indexes for table `eye_color_map`
--
ALTER TABLE `eye_color_map`
 ADD PRIMARY KEY (`val`), ADD UNIQUE KEY `val` (`val`);

--
-- Indexes for table `hair_color_map`
--
ALTER TABLE `hair_color_map`
 ADD PRIMARY KEY (`val`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
 ADD PRIMARY KEY (`imageId`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
 ADD PRIMARY KEY (`messageId`);

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
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
MODIFY `chatId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
MODIFY `messageId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
