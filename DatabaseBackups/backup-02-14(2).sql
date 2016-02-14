-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2016 at 12:16 AM
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
DROP PROCEDURE IF EXISTS `addPicture`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addPicture`(IN `userId` INT(11))
    NO SQL
Insert into image (userId) values (userId)$$

DROP PROCEDURE IF EXISTS `countUsername`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `countUsername`(IN `userN` VARCHAR(20) CHARSET utf8)
    NO SQL
    DETERMINISTIC
Select count(username) as numFound from login where username = userN$$

DROP PROCEDURE IF EXISTS `createChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `createChat`(IN `userId1` INT(11), IN `userId2` INT(11))
    NO SQL
INSERT INTO chat (userId1, userId2, status) VALUES (userId1, userId2, null)$$

DROP PROCEDURE IF EXISTS `getAllMessages`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllMessages`(IN `userId` INT(11))
    NO SQL
SELECT chat.chatId, message.senderId, message.receiverId, message.timeStamp, message.content FROM chat, message WHERE (chat.chatId = message.chatId) AND (message.senderId = userId OR message.receiverId = userId) AND chat.status IS NULL ORDER by message.timeStamp DESC$$

DROP PROCEDURE IF EXISTS `getAttributes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAttributes`(IN `userId` INT(11))
    NO SQL
SELECT * From profile Where id = userId$$

DROP PROCEDURE IF EXISTS `getChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getChat`(IN `userId1` INT(11), IN `userId2` INT(11))
    NO SQL
SELECT * from chat where chat.userId1 = userId1 AND chat.userId2 = userId2$$

DROP PROCEDURE IF EXISTS `getName`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getName`(IN `userId` INT)
    NO SQL
SELECT fName, lName FROM profile where userId = id$$

DROP PROCEDURE IF EXISTS `getNewestPic`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getNewestPic`(IN `userId` INT)
    NO SQL
select imageId from image where userId = userId order by imageId DESC Limit 1$$

DROP PROCEDURE IF EXISTS `getPreferences`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getPreferences`(IN `userId` INT(11))
    NO SQL
SELECT * FROM preference WHERE id = userId$$

DROP PROCEDURE IF EXISTS `getProfilesOfGender`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getProfilesOfGender`(IN `genderType` VARCHAR(1) CHARSET utf8)
    READS SQL DATA
Select * from profile where gender = genderType$$

DROP PROCEDURE IF EXISTS `getSalt`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getSalt`(IN `userN` VARCHAR(20) CHARSET utf8)
    READS SQL DATA
Select salt from login where username = userN$$

DROP PROCEDURE IF EXISTS `getUserId`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserId`(IN `userN` VARCHAR(20) CHARSET utf8, IN `passW` VARCHAR(40) CHARSET utf8)
    NO SQL
    DETERMINISTIC
Select id from login where username = userN and password = passW$$

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

DROP PROCEDURE IF EXISTS `isUserSaved`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `isUserSaved`(IN `userId` INT(11), IN `savedId` INT(11))
    NO SQL
Select * from saved_user where userId = saved_user.id AND savedId = saved_user.savedId$$

DROP PROCEDURE IF EXISTS `loginCheck`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `loginCheck`(IN `cookie` VARCHAR(40) CHARSET utf8, IN `userId` INT)
    NO SQL
    COMMENT 'returns a row if userId and cookie match'
SELECT id From login WHERE id=userId and session_cookie=cookie and session_cookie is Not Null$$

DROP PROCEDURE IF EXISTS `loginUpdate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `loginUpdate`(IN `cookie` VARCHAR(40) CHARSET utf8, IN `userN` VARCHAR(20) CHARSET utf8)
    MODIFIES SQL DATA
    DETERMINISTIC
Update login set session_cookie = cookie Where username = userN$$

DROP PROCEDURE IF EXISTS `logout`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `logout`(IN `userId` INT, IN `cookie` VARCHAR(40) CHARSET utf8)
    NO SQL
    COMMENT 'sets the user''s cookie to null when they logout'
UPDATE login set session_cookie = NULL WHERE (id = userId and session_cookie = cookie)$$

DROP PROCEDURE IF EXISTS `register`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `register`(IN `username` VARCHAR(20) CHARSET utf8, IN `password` VARCHAR(40) CHARSET utf8, IN `salt` VARCHAR(20) CHARSET utf8)
    MODIFIES SQL DATA
Insert into login (username, password,salt) values (username,password,salt)$$

DROP PROCEDURE IF EXISTS `registerUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `registerUser`(IN `userN` VARCHAR(20) CHARSET utf8, IN `passW` VARCHAR(40) CHARSET utf8, IN `salt` VARCHAR(20) CHARSET utf8)
    MODIFIES SQL DATA
INSERT into login (username, password, salt) values (userN, passW, salt)$$

DROP PROCEDURE IF EXISTS `sendMessage`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sendMessage`(IN `chatId` INT, IN `senderId` INT, IN `receiverId` INT, IN `content` VARCHAR(256))
    NO SQL
INSERT INTO message (message.senderId, message.receiverId, message.content, message.chatId) VALUES (senderId, receiverId, content, chatId)$$

DROP PROCEDURE IF EXISTS `setAttributes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setAttributes`(IN `userId` INT(11), IN `fName` VARCHAR(16) CHARSET utf8, IN `lName` VARCHAR(30) CHARSET utf8, IN `gender` VARCHAR(1) CHARSET utf8, IN `hairColor` INT(11), IN `eyeColor` INT(11), IN `bodyType` INT(11), IN `skinTone` INT(11), IN `bio` VARCHAR(240) CHARSET utf8, IN `birthdate` DATE, IN `maxSearchDist` INT(11), IN `height` INT(11))
    MODIFIES SQL DATA
INSERT into profile (id,fName,lName,gender,hairColor,eyeColor,bodyType,skinTone,bio,birthdate,maxSearchDist,height) VALUES
	(userId,fName,lName,gender,hairColor,eyeColor,bodyType,skinTone,bio,birthdate,maxSearchDist,height)$$

DROP PROCEDURE IF EXISTS `setDefaultAttributes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setDefaultAttributes`(IN `userId` INT(11), IN `fName` VARCHAR(16) CHARSET utf8, IN `lName` VARCHAR(30) CHARSET utf8, IN `gender` VARCHAR(1) CHARSET utf8, IN `birthdate` DATE)
    MODIFIES SQL DATA
INSERT into profile (id,fName,lName,gender,birthdate) VALUES
	(userId,fName,lName,gender,birthdate)$$

DROP PROCEDURE IF EXISTS `setPreferences`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setPreferences`(IN `userId` INT(11), IN `minAge` INT(11), IN `maxAge` INT(11), IN `gender` VARCHAR(1) CHARSET utf8, IN `minHeight` INT(11), IN `maxHeight` INT(11), IN `oneHair` INT(11), IN `twoHair` INT(11), IN `leastHair` INT(11), IN `oneEye` INT(11), IN `twoEye` INT(11), IN `bodyType` INT(11), IN `skinTone` INT)
    MODIFIES SQL DATA
begin
INSERT INTO preference (id,minAge,maxAge,gender,minHeight,maxHeight,oneHair,twoHair,leastHair,oneEye,twoEye,bodyType,skinTone)
				VALUES (userId,minAge,maxAge,gender,minHeight,maxHeight,oneHair,twoHair,leastHair,oneEye,twoEye,bodyType,skinTone);
end$$

DROP PROCEDURE IF EXISTS `setProfilePictureId`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setProfilePictureId`(IN `userId` INT(11), IN `picId` INT(11))
    MODIFIES SQL DATA
UPDATE profile set profilePicId = picId Where id = userId$$

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`chatId`, `userId1`, `userId2`, `status`) VALUES
(1, 1, 3, NULL),
(2, 1, 6, NULL),
(3, 1, 7, NULL),
(4, 1, 4, NULL),
(5, 1, 5, NULL),
(6, 1, 8, NULL),
(7, 1, 9, NULL),
(8, 1, 2, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`userId`, `imageId`, `uploadDate`) VALUES
(13, 4, '2016-02-10 07:33:31'),
(3, 5, '2016-02-10 07:35:41'),
(4, 6, '2016-02-10 07:42:46'),
(7, 7, '2016-02-10 07:43:08'),
(5, 8, '2016-02-10 07:43:54'),
(1, 9, '2016-02-10 08:06:10');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `salt`, `session_cookie`, `status`) VALUES
(1, 'tempuser', '99df00dac4e7820a4df1f49b3148b845513565e8', '00000000000000000000', NULL, 0),
(3, 'tempuser3', '3d62803337dfb60cbc438cf47803de588b14e0ed', '3LeDVgvSD12mwUcRfIhv', NULL, 0),
(4, 'tempuser4', '1342bd71c0af757e4a0f3ddb41859b5227a43167', '55ijoT3hpQu6z37Tcc1l', NULL, 0),
(5, 'tempuser5', 'e6cc086b281f584a6dfa11fb3a248c5d201f2590', 'wkrxGL833eRw6FrHG5NY', NULL, 0),
(6, 'tempuser7', 'ab39b3d1794cc421f48b19e2fec5aec120b09853', 'JipucIjtr5ReDKn0ETv8', NULL, 0),
(7, 'tempuser2', '35c39d7d343b9b2eafcdd8f4d2cda1c8050a68a4', '8fMN7zTKxfT2JHGoYorq', NULL, 0),
(8, 'carliweinberg', '998cf3aeb488e09e23ad8147657062f00051f413', '73dtwRQZAM7nD6Vz5bTZ', 'qn7KwpsmAnJLldNmKMstKwijn221LJwFVn6PI8km', 0),
(9, 'tempuser8', '9d4bb82117686e8b03c4389419b892fc001f2a4c', 'kJp3tjFIrGWUS4fXWliw', NULL, 0),
(10, 'tempuser6', 'f302adad2e0a5fdd73afc5919e9f5ac0b7ff9517', '0hRbQHuHXxRhlWuouCT7', NULL, 0),
(11, 'tempuser9', '366ab09a7fbff75a6e2cc71a1ad978b9efdf39ec', 'FK49LEaZNpj45RHCe2nq', NULL, 0),
(12, 'tempuser10', '78ac31be72a48917330766c9c14ec67c2bcf88ce', 'RoWT4lV9b9gATEb9Fj4d', NULL, 0),
(13, 'josh', 'd0c0e26918275e47933cf0d73054599a59de3546', 'GMNPEQUTt7WdZt05k82h', NULL, 0),
(14, 'tempuser12', 'a07691c57decfce249f6ca1a48c3218cc56655f0', 'PtiMlDJM5031tLvpk00Z', NULL, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageId`, `senderId`, `receiverId`, `timeStamp`, `content`, `chatId`) VALUES
(1, 1, 3, '2016-02-04 04:40:01', 'This is the content of the first message ever sent', 1),
(2, 3, 1, '2016-02-04 04:40:50', 'This is the content for the second message ever sent', 1),
(3, 1, 3, '2016-02-04 06:28:37', 'Cool!', 0),
(4, 1, 3, '2016-02-04 06:28:59', 'Cool!', 1),
(5, 1, 6, '2016-02-04 08:39:37', 'hello', 2),
(10, 1, 5, '2016-02-04 08:50:55', 'hey', 5),
(11, 3, 1, '2016-02-04 08:55:54', 'i like pizza', 1),
(12, 1, 3, '2016-02-04 08:56:10', 'i like pasta more', 1),
(15, 5, 1, '2016-02-04 08:59:00', 'hi', 5),
(16, 1, 5, '2016-02-04 09:02:50', 'What is 9 + 10?', 5),
(17, 5, 1, '2016-02-04 09:03:23', '21', 5),
(18, 1, 5, '2016-02-04 09:03:45', 'You stupid.', 5),
(19, 6, 1, '2016-02-04 09:04:38', 'whatup', 2),
(20, 8, 1, '2016-02-06 04:38:05', 'Hi. What''s up?', 6),
(21, 1, 8, '2016-02-06 04:38:29', 'The sky.', 6),
(24, 8, 1, '2016-02-07 04:28:03', 'Cool', 6),
(25, 1, 8, '2016-02-07 04:31:02', 'yeah cool', 6),
(26, 1, 3, '2016-02-09 03:04:26', 'content of message', 1),
(27, 1, 3, '2016-02-09 03:04:45', 'This is cool', 1),
(28, 1, 3, '2016-02-09 03:05:13', 'hello', 1),
(30, 1, 3, '2016-02-09 03:33:33', 'hello', 1),
(31, 1, 3, '2016-02-09 03:34:02', 'this works', 1),
(32, 1, 3, '2016-02-09 03:38:25', 'see%3F', 1),
(33, 1, 3, '2016-02-09 17:42:27', 'hey', 1),
(34, 1, 3, '2016-02-09 17:42:28', 'hey', 1),
(35, 1, 5, '2016-02-09 23:40:31', 'very%20stupid', 1),
(36, 1, 5, '2016-02-10 06:22:42', 'hi', 1),
(37, 1, 5, '2016-02-10 06:23:06', 'hi', 1),
(38, 1, 5, '2016-02-10 06:24:08', 'a', 1),
(39, 1, 5, '2016-02-10 06:24:21', 'hi%20armado', 1),
(40, 1, 6, '2016-02-10 06:24:57', 'yeah%3F', 1),
(41, 1, 6, '2016-02-10 06:25:24', 'no%3F', 1),
(42, 1, 6, '2016-02-10 06:55:02', 'fgdfs', 1),
(43, 1, 3, '2016-02-10 06:56:05', 'hi', 1),
(44, 3, 1, '2016-02-10 07:01:41', 'yo', 3),
(45, 3, 1, '2016-02-10 07:01:55', 'whats%20up', 3),
(46, 1, 3, '2016-02-10 07:02:01', 'not%20much', 1),
(47, 3, 1, '2016-02-10 07:02:16', 'hi', 3),
(48, 1, 3, '2016-02-10 07:02:24', 'yo', 1),
(49, 1, 3, '2016-02-11 05:43:06', 'this%20works', 1);

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
(1, 18, 21, 'M', 36, 96, 2, 2, 1, 2, 0, 1, 0),
(3, 34, 50, 'F', 50, 78, 3, 0, 2, 3, 1, 2, 2),
(4, 37, 55, 'M', 55, 77, 0, 0, 0, 0, 0, 0, 1),
(5, 18, 22, 'F', 36, 96, 0, 0, 0, 0, 0, 0, 0),
(7, 18, 22, 'M', 36, 96, 0, 0, 0, 0, 0, 0, 0),
(13, 18, 22, 'F', 36, 96, 0, 0, 0, 0, 0, 0, 0);

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
  `bio` varchar(240) CHARACTER SET utf8 DEFAULT '',
  `birthdate` date NOT NULL,
  `maxSearchDist` int(11) NOT NULL DEFAULT '40',
  `height` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `fName`, `lName`, `gender`, `hairColor`, `eyeColor`, `bodyType`, `skinTone`, `profilePicId`, `bio`, `birthdate`, `maxSearchDist`, `height`) VALUES
(1, 'Jack', 'Hallam', 'M', 1, 3, 1, 1, 9, 'This%20is%20the%20bio', '1985-05-26', 69, 69),
(3, 'Armando', 'Luja', 'M', 0, 1, 2, 3, 5, 'arm%20bio', '1960-01-01', 10, 70),
(4, 'Joy', 'Gleeful', 'F', 2, 2, 3, 3, 6, 'Hey%20im%20gleejohy', '1994-07-07', 22, 64),
(5, 'Jacktapus', 'Dragonman', 'M', 0, 0, 0, 0, 8, 'Aye%20ladies%2C%20come%20get%20this%20jacktapusdragon', '1960-01-01', 10, 66),
(6, 'Coolio', 'Cools', 'M', 0, 0, 0, 0, NULL, '', '1960-01-01', 10, 66),
(7, 'Billy', 'Boy', 'M', 1, 1, 2, 2, 7, 'uh%2C%20im%20billy%20boy%20yo', '1994-05-07', 30, 72),
(8, 'Carli', 'Weinberg', 'F', 3, 2, 2, 0, NULL, 'I%20am%20the%20coolest%20person%20you%20will%20ever%20meet.%20I%20am%20your%20idea%20babe.%20Build%20me%20%3A%29', '1996-08-06', 1, 67),
(12, 'temp', 'user', 'F', NULL, NULL, NULL, NULL, NULL, '', '1998-02-01', 40, NULL),
(13, 'Josh', 'Laesch', 'M', 1, 4, 2, 0, 4, 'Hey%20I%27m%20Josh%2C%20but%20you%20can%20call%20me%20Jersh.', '1995-11-10', 40, 66),
(14, 'TempMan', 'TempMan', 'M', NULL, NULL, NULL, NULL, NULL, '', '1992-07-09', 40, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saved_user`
--

DROP TABLE IF EXISTS `saved_user`;
CREATE TABLE IF NOT EXISTS `saved_user` (
  `id` int(11) NOT NULL,
  `savedId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saved_user`
--

INSERT INTO `saved_user` (`id`, `savedId`) VALUES
(1, 3);

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
MODIFY `chatId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
MODIFY `messageId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
