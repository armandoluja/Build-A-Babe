-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2016 at 09:21 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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

DROP PROCEDURE IF EXISTS `getAttributes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAttributes`(IN `userId` INT(11))
    NO SQL
SELECT * From profile Where id = userId$$

DROP PROCEDURE IF EXISTS `getName`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getName`(IN `userId` INT)
    NO SQL
SELECT fName, lName FROM profile where userId = id$$

DROP PROCEDURE IF EXISTS `getPreferences`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getPreferences`(IN `userId` INT(11))
    NO SQL
SELECT * FROM preference WHERE id = userId$$

DROP PROCEDURE IF EXISTS `get_cookie`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_cookie`(IN `userId` INT)
    NO SQL
SELECT session_cookie FROM login WHERE id = userId$$

DROP PROCEDURE IF EXISTS `isUserAttrSet`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `isUserAttrSet`(IN `userId` INT(11))
    NO SQL
    COMMENT 'User has set his attributes? returns a row if true'
Select id From profile where id = userId$$

DROP PROCEDURE IF EXISTS `isUserPrefSet`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `isUserPrefSet`(IN `userId` INT(11))
    NO SQL
    COMMENT 'User has set his preferences? returns a row if true'
SELECT id from preference where id = userId$$

DROP PROCEDURE IF EXISTS `loginCheck`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `loginCheck`(IN `cookie` VARCHAR(40) CHARSET utf8, IN `userId` INT)
    NO SQL
    COMMENT 'returns a row if userId and cookie match'
SELECT id From login WHERE id=userId and session_cookie=cookie and session_cookie is Not Null$$

DROP PROCEDURE IF EXISTS `logout`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `logout`(IN `userId` INT, IN `cookie` VARCHAR(40) CHARSET utf8)
    NO SQL
    COMMENT 'sets the user''s cookie to null when they logout'
UPDATE login set session_cookie = NULL WHERE (id = userId and session_cookie = cookie)$$

DROP PROCEDURE IF EXISTS `setAttributes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setAttributes`(IN `userId` INT(11), IN `fName` VARCHAR(16) CHARSET utf8, IN `lName` VARCHAR(30) CHARSET utf8, IN `gender` VARCHAR(1) CHARSET utf8, IN `hairColor` INT(11), IN `eyeColor` INT(11), IN `bodyType` INT(11), IN `skinTone` INT(11), IN `bio` VARCHAR(240) CHARSET utf8, IN `birthdate` DATE, IN `maxSearchDist` INT(11), IN `height` INT(11))
    MODIFIES SQL DATA
INSERT into profile (id,fName,lName,gender,hairColor,eyeColor,bodyType,skinTone,bio,birthdate,maxSearchDist,height) VALUES
	(userId,fName,lName,gender,hairColor,eyeColor,bodyType,skinTone,bio,birthdate,maxSearchDist,height)$$

DROP PROCEDURE IF EXISTS `setPreferences`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setPreferences`(IN `userId` INT(11), IN `minAge` INT(11), IN `maxAge` INT(11), IN `gender` VARCHAR(1) CHARSET utf8, IN `minHeight` INT(11), IN `maxHeight` INT(11), IN `oneHair` INT(11), IN `twoHair` INT(11), IN `leastHair` INT(11), IN `oneEye` INT(11), IN `twoEye` INT(11), IN `bodyType` INT(11), IN `skinTone` INT)
    MODIFIES SQL DATA
begin
INSERT INTO preference (id,minAge,maxAge,gender,minHeight,maxHeight,oneHair,twoHair,leastHair,oneEye,twoEye,bodyType,skinTone)
				VALUES (userId,minAge,maxAge,gender,minHeight,maxHeight,oneHair,twoHair,leastHair,oneEye,twoEye,bodyType,skinTone);
end$$

DROP PROCEDURE IF EXISTS `updateAttributes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAttributes`(IN `userId` INT(11), IN `fName` VARCHAR(16) CHARSET utf8, IN `lName` VARCHAR(30) CHARSET utf8, IN `gender` VARCHAR(1), IN `hairColor` INT(11), IN `eyeColor` INT(11), IN `bodyType` INT(11), IN `skinTone` INT(11), IN `bio` VARCHAR(240) CHARSET utf8, IN `birthdate` DATE, IN `maxSearchDist` INT(11), IN `height` INT(11))
    MODIFIES SQL DATA
begin
UPDATE profile set fName=fName,lName=lName,gender=gender,hairColor=hairColor,eyeColor=eyeColor,bodyType=bodyType,skinTone=skinTone,bio=bio,birthdate=birthdate,maxSearchDist=maxSearchDist,height=height Where id = userId;
end$$

DROP PROCEDURE IF EXISTS `updatePreferences`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePreferences`(IN `userId` INT(11), IN `minAge` INT(11), IN `maxAge` INT(11), IN `gender` VARCHAR(1) CHARSET utf8, IN `minHeight` INT(11), IN `maxHeight` INT(11), IN `oneHair` INT(11), IN `twoHair` INT(11), IN `leastHair` INT(11), IN `oneEye` INT(11), IN `twoEye` INT(11), IN `bodyType` INT(11), IN `skinTone` INT)
    NO SQL
    DETERMINISTIC
UPDATE preference SET minAge=minAge, maxAge=maxAge,
gender=gender,minHeight=minHeight,maxHeight=maxHeight,
oneHair=oneHair,twoHair=twoHair,leastHair=leastHair,
oneEye=oneEye,twoEye=twoEye,bodyType=bodyType,skinTone=skinTone WHERE id=userId$$

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `salt`, `session_cookie`, `status`) VALUES
(1, 'tempuser', '99df00dac4e7820a4df1f49b3148b845513565e8', '00000000000000000000', '8TNVmmYMtyzLovkuzAaOOqePyReAfWQIu3lRaijr', 0),
(3, 'tempuser3', '3d62803337dfb60cbc438cf47803de588b14e0ed', '3LeDVgvSD12mwUcRfIhv', NULL, 0),
(4, 'tempuser4', '1342bd71c0af757e4a0f3ddb41859b5227a43167', '55ijoT3hpQu6z37Tcc1l', 'lwZfQ2SEGvoG0OOKYud2tGe0qZ2TxQLCJTEtcQau', 0),
(5, 'tempuser5', 'e6cc086b281f584a6dfa11fb3a248c5d201f2590', 'wkrxGL833eRw6FrHG5NY', 'foYVDNCraR3Os8AXGZwdlJ6GvyVTKVGp7oMbKJxr', 0),
(6, 'tempuser7', 'ab39b3d1794cc421f48b19e2fec5aec120b09853', 'JipucIjtr5ReDKn0ETv8', 'ekAjUaHKbMiWBCepqfmcIw2vIpTmOoG85MHma8nu', 0),
(7, 'tempuser2', '35c39d7d343b9b2eafcdd8f4d2cda1c8050a68a4', '8fMN7zTKxfT2JHGoYorq', NULL, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageId`, `senderId`, `receiverId`, `timeStamp`, `content`, `chatId`) VALUES
(1, 1, 3, '2016-02-04 04:40:01', 'This is the content of the first message ever sent', 1),
(2, 3, 1, '2016-02-04 04:40:50', 'This is the content for the second message ever sent', 1),
(3, 1, 3, '2016-02-04 06:28:37', 'Cool!', 0),
(4, 1, 3, '2016-02-04 06:28:59', 'Cool!', 1);

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
(1, 'Armando', 'Luja', 'M', 0, 0, 2, 1, NULL, 'If%20you%20are%20reading%20this%2C%20WE%20EATIN%26%2339%3B', '1995-11-04', 29, 71),
(3, 'arm', 'ando', 'M', 0, 1, 2, 3, NULL, 'arm bio', '1960-01-01', 10, NULL),
(7, 'Billy', 'Boy', 'M', 1, 1, 2, 2, NULL, 'uh%2C%20im%20billy%20boy%20yo', '1994-05-07', 30, 72);

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
  ADD PRIMARY KEY (`val`),
  ADD UNIQUE KEY `val` (`val`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `messageId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
