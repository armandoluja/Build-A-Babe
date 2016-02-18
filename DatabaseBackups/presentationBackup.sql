-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2016 at 06:31 AM
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

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `addPicture`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addPicture` (IN `userId` INT(11))  NO SQL
Insert into image (userId) values (userId)$$

DROP PROCEDURE IF EXISTS `addSavedUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addSavedUser` (IN `userId` INT(11), IN `savedId` INT(11))  NO SQL
insert into saved_user (saved_user.id, saved_user.savedId) VALUES (userId, savedId)$$

DROP PROCEDURE IF EXISTS `addUserViewed`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addUserViewed` (IN `userId` INT(11), IN `vieweeId` INT(11))  NO SQL
insert into viewed(viewed.viewerId, viewed.vieweeId) values(userId, vieweeId)$$

DROP PROCEDURE IF EXISTS `countUsername`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `countUsername` (IN `userN` VARCHAR(20) CHARSET utf8)  NO SQL
    DETERMINISTIC
Select count(username) as numFound from login where username = userN$$

DROP PROCEDURE IF EXISTS `createChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `createChat` (IN `userId1` INT(11), IN `userId2` INT(11))  NO SQL
INSERT INTO chat (userId1, userId2, status) VALUES (userId1, userId2, null)$$

DROP PROCEDURE IF EXISTS `getAllMessages`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllMessages` (IN `userId` INT(11))  NO SQL
SELECT chat.chatId, message.senderId, message.receiverId, message.timeStamp, message.content FROM chat, message WHERE (chat.chatId = message.chatId) AND (message.senderId = userId OR message.receiverId = userId) AND chat.status IS NULL ORDER by message.timeStamp DESC$$

DROP PROCEDURE IF EXISTS `getAttributes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAttributes` (IN `userId` INT(11))  NO SQL
SELECT * From profile Where id = userId$$

DROP PROCEDURE IF EXISTS `getChat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getChat` (IN `userId1` INT(11), IN `userId2` INT(11))  NO SQL
SELECT * from chat where chat.userId1 = userId1 AND chat.userId2 = userId2$$

DROP PROCEDURE IF EXISTS `getName`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getName` (IN `userId` INT)  NO SQL
SELECT fName, lName FROM profile where userId = id$$

DROP PROCEDURE IF EXISTS `getNewestPic`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getNewestPic` (IN `userId` INT)  NO SQL
select imageId from image where userId = userId order by imageId DESC Limit 1$$

DROP PROCEDURE IF EXISTS `getPreferences`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getPreferences` (IN `userId` INT(11))  NO SQL
SELECT * FROM preference WHERE id = userId$$

DROP PROCEDURE IF EXISTS `getProfilesOfGender`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getProfilesOfGender` (IN `genderType` VARCHAR(1) CHARSET utf8)  READS SQL DATA
Select * from profile where gender = genderType$$

DROP PROCEDURE IF EXISTS `getSalt`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getSalt` (IN `userN` VARCHAR(20) CHARSET utf8)  READS SQL DATA
Select salt from login where username = userN$$

DROP PROCEDURE IF EXISTS `getSavedUsersIds`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getSavedUsersIds` (IN `userId` INT(11))  NO SQL
select saved_user.savedId as id from saved_user where saved_user.id = userId$$

DROP PROCEDURE IF EXISTS `getUserId`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserId` (IN `userN` VARCHAR(20) CHARSET utf8, IN `passW` VARCHAR(40) CHARSET utf8)  NO SQL
    DETERMINISTIC
Select id from login where username = userN and password = passW$$

DROP PROCEDURE IF EXISTS `getViewedUsersIds`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getViewedUsersIds` (IN `userId` INT(11))  NO SQL
select distinct viewed.vieweeId as id from viewed where viewed.viewerId = userId order by viewed.timeStamp desc$$

DROP PROCEDURE IF EXISTS `get_cookie`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_cookie` (IN `userId` INT)  NO SQL
SELECT session_cookie FROM login WHERE id = userId$$

DROP PROCEDURE IF EXISTS `isUserAttrSet`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `isUserAttrSet` (IN `userId` INT(11))  NO SQL
    COMMENT 'User has set his attributes? returns a row if true'
Select id From profile where id = userId$$

DROP PROCEDURE IF EXISTS `isUserPrefSet`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `isUserPrefSet` (IN `userId` INT(11))  NO SQL
    COMMENT 'User has set his preferences? returns a row if true'
SELECT id from preference where id = userId$$

DROP PROCEDURE IF EXISTS `isUserSaved`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `isUserSaved` (IN `userId` INT(11), IN `savedId` INT(11))  NO SQL
Select * from saved_user where userId = saved_user.id AND savedId = saved_user.savedId$$

DROP PROCEDURE IF EXISTS `loginCheck`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `loginCheck` (IN `cookie` VARCHAR(40) CHARSET utf8, IN `userId` INT)  NO SQL
    COMMENT 'returns a row if userId and cookie match'
SELECT id From login WHERE id=userId and session_cookie=cookie and session_cookie is Not Null$$

DROP PROCEDURE IF EXISTS `loginUpdate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `loginUpdate` (IN `cookie` VARCHAR(40) CHARSET utf8, IN `userN` VARCHAR(20) CHARSET utf8)  MODIFIES SQL DATA
    DETERMINISTIC
Update login set session_cookie = cookie Where username = userN$$

DROP PROCEDURE IF EXISTS `logout`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `logout` (IN `userId` INT, IN `cookie` VARCHAR(40) CHARSET utf8)  NO SQL
    COMMENT 'sets the user''s cookie to null when they logout'
UPDATE login set session_cookie = NULL WHERE (id = userId and session_cookie = cookie)$$

DROP PROCEDURE IF EXISTS `register`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `register` (IN `username` VARCHAR(20) CHARSET utf8, IN `password` VARCHAR(40) CHARSET utf8, IN `salt` VARCHAR(20) CHARSET utf8)  MODIFIES SQL DATA
Insert into login (username, password,salt) values (username,password,salt)$$

DROP PROCEDURE IF EXISTS `registerUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `registerUser` (IN `userN` VARCHAR(20) CHARSET utf8, IN `passW` VARCHAR(40) CHARSET utf8, IN `salt` VARCHAR(20) CHARSET utf8)  MODIFIES SQL DATA
INSERT into login (username, password, salt) values (userN, passW, salt)$$

DROP PROCEDURE IF EXISTS `removeSavedUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `removeSavedUser` (IN `userId` INT(11), IN `savedId` INT(11))  NO SQL
delete from saved_user where userId = saved_user.id AND savedId = saved_user.savedId$$

DROP PROCEDURE IF EXISTS `sendMessage`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sendMessage` (IN `chatId` INT, IN `senderId` INT, IN `receiverId` INT, IN `content` VARCHAR(256))  NO SQL
INSERT INTO message (message.senderId, message.receiverId, message.content, message.chatId) VALUES (senderId, receiverId, content, chatId)$$

DROP PROCEDURE IF EXISTS `setAttributes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setAttributes` (IN `userId` INT(11), IN `fName` VARCHAR(16) CHARSET utf8, IN `lName` VARCHAR(30) CHARSET utf8, IN `gender` VARCHAR(1) CHARSET utf8, IN `hairColor` INT(11), IN `eyeColor` INT(11), IN `bodyType` INT(11), IN `skinTone` INT(11), IN `bio` VARCHAR(240) CHARSET utf8, IN `birthdate` DATE, IN `maxSearchDist` INT(11), IN `height` INT(11))  MODIFIES SQL DATA
INSERT into profile (id,fName,lName,gender,hairColor,eyeColor,bodyType,skinTone,bio,birthdate,maxSearchDist,height) VALUES
	(userId,fName,lName,gender,hairColor,eyeColor,bodyType,skinTone,bio,birthdate,maxSearchDist,height)$$

DROP PROCEDURE IF EXISTS `setDefaultAttributes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setDefaultAttributes` (IN `userId` INT(11), IN `fName` VARCHAR(16) CHARSET utf8, IN `lName` VARCHAR(30) CHARSET utf8, IN `gender` VARCHAR(1) CHARSET utf8, IN `birthdate` DATE)  MODIFIES SQL DATA
INSERT into profile (id,fName,lName,gender,birthdate) VALUES
	(userId,fName,lName,gender,birthdate)$$

DROP PROCEDURE IF EXISTS `setPreferences`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setPreferences` (IN `userId` INT(11), IN `minAge` INT(11), IN `maxAge` INT(11), IN `gender` VARCHAR(1) CHARSET utf8, IN `minHeight` INT(11), IN `maxHeight` INT(11), IN `oneHair` INT(11), IN `twoHair` INT(11), IN `leastHair` INT(11), IN `oneEye` INT(11), IN `twoEye` INT(11), IN `bodyType` INT(11), IN `skinTone` INT)  MODIFIES SQL DATA
begin
INSERT INTO preference (id,minAge,maxAge,gender,minHeight,maxHeight,oneHair,twoHair,leastHair,oneEye,twoEye,bodyType,skinTone)
				VALUES (userId,minAge,maxAge,gender,minHeight,maxHeight,oneHair,twoHair,leastHair,oneEye,twoEye,bodyType,skinTone);
end$$

DROP PROCEDURE IF EXISTS `setProfilePictureId`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `setProfilePictureId` (IN `userId` INT(11), IN `picId` INT(11))  MODIFIES SQL DATA
UPDATE profile set profilePicId = picId Where id = userId$$

DROP PROCEDURE IF EXISTS `updateAttributes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAttributes` (IN `userId` INT(11), IN `fName` VARCHAR(16) CHARSET utf8, IN `lName` VARCHAR(30) CHARSET utf8, IN `gender` VARCHAR(1), IN `hairColor` INT(11), IN `eyeColor` INT(11), IN `bodyType` INT(11), IN `skinTone` INT(11), IN `bio` VARCHAR(240) CHARSET utf8, IN `birthdate` DATE, IN `maxSearchDist` INT(11), IN `height` INT(11))  MODIFIES SQL DATA
begin
UPDATE profile set fName=fName,lName=lName,gender=gender,hairColor=hairColor,eyeColor=eyeColor,bodyType=bodyType,skinTone=skinTone,bio=bio,birthdate=birthdate,maxSearchDist=maxSearchDist,height=height Where id = userId;
end$$

DROP PROCEDURE IF EXISTS `updatePreferences`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePreferences` (IN `userId` INT(11), IN `minAge` INT(11), IN `maxAge` INT(11), IN `gender` VARCHAR(1) CHARSET utf8, IN `minHeight` INT(11), IN `maxHeight` INT(11), IN `oneHair` INT(11), IN `twoHair` INT(11), IN `leastHair` INT(11), IN `oneEye` INT(11), IN `twoEye` INT(11), IN `bodyType` INT(11), IN `skinTone` INT)  NO SQL
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
CREATE TABLE `body_type_map` (
  `val` int(11) NOT NULL,
  `bodyType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `chatId` int(11) NOT NULL,
  `userId1` int(11) NOT NULL,
  `userId2` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT 'null = neither blocked; 0 = both users blocked; 1 = user 1 blocked; 2 = user 2 blocked'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `eye_color_map`
--

DROP TABLE IF EXISTS `eye_color_map`;
CREATE TABLE `eye_color_map` (
  `val` int(11) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hair_color_map`
--

DROP TABLE IF EXISTS `hair_color_map`;
CREATE TABLE `hair_color_map` (
  `val` int(11) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE `image` (
  `userId` int(11) NOT NULL,
  `imageId` int(11) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`userId`, `imageId`, `uploadDate`) VALUES
(15, 10, '2016-02-18 04:50:05'),
(15, 11, '2016-02-18 04:58:48'),
(15, 12, '2016-02-18 04:59:19'),
(16, 13, '2016-02-18 05:00:46'),
(17, 14, '2016-02-18 05:01:53'),
(18, 15, '2016-02-18 05:03:16'),
(19, 16, '2016-02-18 05:08:55'),
(20, 17, '2016-02-18 05:11:18'),
(21, 18, '2016-02-18 05:13:46'),
(22, 19, '2016-02-18 05:15:34'),
(16, 20, '2016-02-18 05:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(20) NOT NULL,
  `session_cookie` varchar(40) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `salt`, `session_cookie`, `status`) VALUES
(15, 'onegirl', '76341aee2f4080116f0ed2074ab22810fbcc1b0b', 'wfj9dOSE3dmc5Xq3HOX4', NULL, 0),
(16, 'twogirl', 'f876561d0dd836f16b4f5d32dfec8b0ae063cacb', 'aJMrrGaeO9oFhqy9EHRg', NULL, 0),
(17, 'threegirl', '34e34e2f0179329e907b3b0dfcf8c64af38118ff', 'HeCDeEDKLs3pBNPgPpvH', NULL, 0),
(18, 'fourgirl', '96a746680fd921883840e2b52c547d4570bc46c7', 'PyovYshbB8ZL8HRaFaJl', NULL, 0),
(19, 'fivegirl', '7c3f8c85b6e1cbeff477a915f41d19dde7dd023b', 'lyTAxEeNS0wUV7IZybqF', NULL, 0),
(20, 'sixgirl', '513f4ff969451f01daf37a697d5394cd928b6782', 'LbzigaEGEgNzSWZp1uGX', NULL, 0),
(21, 'sevengirl', '28d828b15c97d0d41080d29a4eae6bc91e033e50', 'VUW1cNdvrFfNBOkDC9mW', NULL, 0),
(22, 'eightgirl', 'c87c46828b57a738b99d67c4ecad96e23b581701', 'NaXNkQImVx2VoHrGxESQ', NULL, 0),
(23, 'fakeguyfive', 'd82c073268294ab4078ae22c5cfc49d996073257', 'biSf4TZP5nGcUpStt9NQ', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `messageId` int(11) NOT NULL,
  `senderId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` varchar(256) NOT NULL,
  `chatId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `messageview`
--
DROP VIEW IF EXISTS `messageview`;
CREATE TABLE `messageview` (
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
CREATE TABLE `preference` (
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
(15, 18, 65, 'M', 36, 96, 1, 0, 3, 3, 0, 1, 1),
(16, 18, 44, 'M', 36, 96, 0, 2, 3, 2, 2, 0, 0),
(23, 18, 56, 'F', 43, 68, 2, 1, 4, 1, 3, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
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
(15, 'Ally', 'Rosen', 'F', 2, 2, 2, 3, 2, 'Hey%20I%27m%20Ally%20and%20I%20like%20to%20climb%20mountains%20and%20go%20to%20the%20beach.', '1996-04-16', 28, 74),
(16, 'Kim', 'Weinberg', 'F', 2, 1, 1, 2, 20, 'I%20love%20singing%20and%20playing%20guitar.%20I%20enjoy%20someone%20who%20can%20hold%20a%20conversation%20and%20is%20up%20for%20fun%20and%20exciting%20things%21', '1996-03-16', 40, 66),
(17, 'Claire', 'Raffin', 'F', 2, 1, 1, 2, 4, 'I%20love%20getting%20to%20know%20people%20and%20going%20out%20with%20friends.%20I%27m%20so%20excited%20to%20get%20to%20know%20you%21', '1996-03-15', 40, 66),
(18, 'Madeline', 'Romeo', 'F', 2, 1, 1, 2, 5, 'Hey%20guys%21%20I%20really%20like%20going%20on%20adventures%20and%20having%20fun.%20I%20enjoy%20surfing%20and%20fishing%20and%20I%27m%20always%20down%20to%20do%20something.%20Save%20me%20%3A%29', '1996-04-14', 40, 66),
(19, 'Stef', 'Panzenhagen', 'F', 3, 1, 1, 2, 16, 'I%27m%20a%20student%20at%20Rose-Hulman%20Institute%20of%20Technology.%20I%27m%20passionate%20about%20my%20studies%20and%20want%20to%20be%20a%20doctor%20when%20I%20grow%20up.%20I%20also%20like%20playing%20soccer%20and%20going%20shopping.', '1994-05-17', 40, 66),
(20, 'Abby', 'Marco', 'F', 2, 1, 1, 2, 17, 'I%20am%20a%20city%20girl%21%20I%20love%20to%20run%20and%20my%20favorite%20activities%20involve%20hanging%20out%20with%20friends%20and%20eating%20ice%20cream.%20You%20should%20save%20me%20and%20send%20me%20a%20chat%21', '1994-08-14', 40, 66),
(21, 'Nikki', 'Lavgina', 'F', 3, 1, 1, 2, 18, 'Basically%20I%20love%20life%20and%20I%20love%20living%20life.%20I%20enjoy%20the%20outdoors%2C%20traveling%2C%20restaurants%2C%20laughing%2C%20going%20to%20cultural%20events%2C%20and%20socializing%20with%20quality%20people.', '1995-02-13', 40, 66),
(22, 'Katie', 'Becker', 'F', 3, 1, 1, 2, 19, 'I%20love%20sports%21%20I%20play%20lacrosse%20and%20I%27m%20studying%20law%20at%20Harvard.%20I%27m%20a%20huge%20patriots%20fan%20though%21%20Chat%20me%20%3B%29', '1994-02-17', 40, 66),
(23, 'Bobby', 'Jones', 'M', NULL, NULL, NULL, NULL, NULL, '', '1995-02-15', 40, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saved_user`
--

DROP TABLE IF EXISTS `saved_user`;
CREATE TABLE `saved_user` (
  `id` int(11) NOT NULL,
  `savedId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `viewed`
--

DROP TABLE IF EXISTS `viewed`;
CREATE TABLE `viewed` (
  `viewerId` int(11) NOT NULL,
  `vieweeId` int(11) NOT NULL,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `messageview`
--
DROP TABLE IF EXISTS `messageview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `messageview`  AS  select `message`.`chatId` AS `chatId`,`message`.`messageId` AS `messageId`,`message`.`senderId` AS `senderId`,`message`.`receiverId` AS `receiverId`,`message`.`timeStamp` AS `timeStamp`,`message`.`content` AS `content` from `message` ;

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
  ADD PRIMARY KEY (`chatId`),
  ADD UNIQUE KEY `userId1` (`userId1`,`userId2`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chatId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `messageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
