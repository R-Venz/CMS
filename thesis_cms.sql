-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2024 at 05:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thesis_cms`
--
CREATE DATABASE IF NOT EXISTS `thesis_cms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `thesis_cms`;

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `getAdmin`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getAdmin` (`r` VARCHAR(60)) RETURNS INT(11)  BEGIN
	Declare uid int;
	select id into uid from tbl_user where role=r;
	return uid;
    END$$

DROP FUNCTION IF EXISTS `getBalance`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getBalance` () RETURNS DOUBLE  BEGIN
	DECLARE contribution DOUBLE;
	DECLARE released DOUBLE;
	DECLARE balance DOUBLE;
	
	SELECT CASE WHEN SUM(amount) IS NULL THEN 0 ELSE SUM(amount) END INTO contribution FROM tbl_contribution;
	
	SELECT CASE WHEN SUM(amt) IS NULL THEN 0 ELSE SUM(amt) END INTO released FROM tbl_release;
	
	return (contribution - released);
    END$$

DROP FUNCTION IF EXISTS `getCollectedByDeath`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getCollectedByDeath` (`did` BIGINT) RETURNS VARCHAR(20) CHARSET utf8 COLLATE utf8_general_ci  BEGIN
	declare amt varchar(20);
	
	SELECT CASE WHEN SUM(amount) IS NULL THEN 0 ELSE SUM(amount) END INTO amt
	FROM tbl_contribution c
	INNER JOIN tbl_bill b ON c.bill_id=b.id
	WHERE death_id=did;
	return amt;
    END$$

DROP FUNCTION IF EXISTS `getCollectibleByDeath`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getCollectibleByDeath` (`did` BIGINT) RETURNS VARCHAR(20) CHARSET utf8 COLLATE utf8_general_ci  BEGIN
	DECLARE amt2 VARCHAR(20);
	
	SELECT CASE WHEN SUM(amt) IS NULL THEN 0 ELSE SUM(amt) END INTO amt2
	FROM tbl_bill b
	WHERE death_id=did AND NOT id IN (SELECT bill_id FROM tbl_contribution);
	RETURN amt2;
    END$$

DROP FUNCTION IF EXISTS `getContribution`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getContribution` () RETURNS VARCHAR(20) CHARSET utf8 COLLATE utf8_general_ci  BEGIN
	declare amt varchar(20);
	select contribution into amt FROM tbl_settings;
	
	return amt;
    END$$

DROP FUNCTION IF EXISTS `getNumMember`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getNumMember` (`mpid` INT) RETURNS INT(11)  BEGIN
	DECLARE n INT;
	
	SELECT COUNT(*) INTO n FROM tbl_member m
	INNER JOIN tbl_mm mm ON  m.id=mm.member_id
	WHERE mm.membership_id=mpid;
	
	RETURN n;
    END$$

DROP FUNCTION IF EXISTS `getReleasedByDeath`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getReleasedByDeath` (`did` BIGINT, `tp` VARCHAR(20)) RETURNS VARCHAR(20) CHARSET utf8 COLLATE utf8_general_ci  BEGIN
	DECLARE am VARCHAR(20);
	if tp = '' then
		SELECT CASE WHEN SUM(amt) IS NULL THEN 0 ELSE SUM(amt) END INTO am
		FROM tbl_release
		WHERE death_id=did;
	else 
		SELECT CASE WHEN SUM(amt) IS NULL THEN 0 ELSE SUM(amt) END INTO am
		FROM tbl_release
		WHERE death_id=did and type=tp;
	end if;
	RETURN am;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bill`
--

DROP TABLE IF EXISTS `tbl_bill`;
CREATE TABLE `tbl_bill` (
  `id` int(11) NOT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `death_id` int(11) DEFAULT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp(),
  `amt` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_bill`
--

INSERT INTO `tbl_bill` (`id`, `membership_id`, `death_id`, `dt`, `amt`) VALUES
(200, 1, 20, '2024-12-18 00:38:38', '100'),
(201, 19, 20, '2024-12-18 00:38:38', '100'),
(202, 20, 20, '2024-12-18 00:38:38', '100'),
(203, 24, 20, '2024-12-18 00:38:38', '100'),
(204, 25, 20, '2024-12-18 00:38:38', '100'),
(205, 26, 20, '2024-12-18 00:38:38', '100'),
(206, 27, 20, '2024-12-18 00:38:38', '100'),
(207, 28, 20, '2024-12-18 00:38:38', '100'),
(208, 29, 20, '2024-12-18 00:38:38', '100'),
(209, 30, 20, '2024-12-18 00:38:38', '100'),
(210, 31, 20, '2024-12-18 00:38:38', '100'),
(211, 33, 20, '2024-12-18 00:38:38', '100'),
(215, 1, 21, '2024-12-18 01:11:49', '100'),
(216, 19, 21, '2024-12-18 01:11:49', '100'),
(217, 20, 21, '2024-12-18 01:11:49', '100'),
(218, 24, 21, '2024-12-18 01:11:49', '100'),
(219, 25, 21, '2024-12-18 01:11:49', '100'),
(220, 26, 21, '2024-12-18 01:11:49', '100'),
(221, 27, 21, '2024-12-18 01:11:49', '100'),
(222, 28, 21, '2024-12-18 01:11:49', '100'),
(223, 29, 21, '2024-12-18 01:11:49', '100'),
(224, 30, 21, '2024-12-18 01:11:49', '100'),
(225, 31, 21, '2024-12-18 01:11:49', '100'),
(226, 33, 21, '2024-12-18 01:11:49', '100'),
(230, 19, 22, '2024-12-18 01:22:37', '100'),
(231, 20, 22, '2024-12-18 01:22:37', '100'),
(232, 24, 22, '2024-12-18 01:22:37', '100'),
(233, 25, 22, '2024-12-18 01:22:37', '100'),
(234, 26, 22, '2024-12-18 01:22:37', '100'),
(235, 27, 22, '2024-12-18 01:22:37', '100'),
(236, 28, 22, '2024-12-18 01:22:37', '100'),
(237, 29, 22, '2024-12-18 01:22:37', '100'),
(238, 30, 22, '2024-12-18 01:22:37', '100'),
(239, 31, 22, '2024-12-18 01:22:37', '100'),
(240, 33, 22, '2024-12-18 01:22:37', '100'),
(245, 19, 23, '2024-12-18 02:20:48', '100'),
(246, 20, 23, '2024-12-18 02:20:48', '100'),
(247, 24, 23, '2024-12-18 02:20:48', '100'),
(248, 25, 23, '2024-12-18 02:20:48', '100'),
(249, 26, 23, '2024-12-18 02:20:48', '100'),
(250, 27, 23, '2024-12-18 02:20:48', '100'),
(251, 28, 23, '2024-12-18 02:20:48', '100'),
(252, 29, 23, '2024-12-18 02:20:48', '100'),
(253, 30, 23, '2024-12-18 02:20:48', '100'),
(254, 31, 23, '2024-12-18 02:20:48', '100'),
(255, 33, 23, '2024-12-18 02:20:48', '100'),
(256, 37, 23, '2024-12-18 02:20:48', '100'),
(260, 19, 23, '2024-12-18 02:21:31', '100'),
(261, 20, 23, '2024-12-18 02:21:31', '100'),
(262, 24, 23, '2024-12-18 02:21:31', '100'),
(263, 25, 23, '2024-12-18 02:21:31', '100'),
(264, 26, 23, '2024-12-18 02:21:31', '100'),
(265, 27, 23, '2024-12-18 02:21:31', '100'),
(266, 28, 23, '2024-12-18 02:21:31', '100'),
(267, 29, 23, '2024-12-18 02:21:31', '100'),
(268, 30, 23, '2024-12-18 02:21:31', '100'),
(269, 31, 23, '2024-12-18 02:21:31', '100'),
(270, 33, 23, '2024-12-18 02:21:31', '100'),
(271, 37, 23, '2024-12-18 02:21:31', '100'),
(275, 19, 20, '2024-12-18 11:04:26', '100'),
(276, 20, 20, '2024-12-18 11:04:26', '100'),
(277, 24, 20, '2024-12-18 11:04:26', '100'),
(278, 25, 20, '2024-12-18 11:04:26', '100'),
(279, 26, 20, '2024-12-18 11:04:26', '100'),
(280, 27, 20, '2024-12-18 11:04:26', '100'),
(281, 28, 20, '2024-12-18 11:04:26', '100'),
(282, 29, 20, '2024-12-18 11:04:26', '100'),
(283, 30, 20, '2024-12-18 11:04:26', '100'),
(284, 31, 20, '2024-12-18 11:04:26', '100'),
(285, 33, 20, '2024-12-18 11:04:26', '100'),
(286, 37, 20, '2024-12-18 11:04:26', '100');

--
-- Triggers `tbl_bill`
--
DROP TRIGGER IF EXISTS `onadd_bill`;
DELIMITER $$
CREATE TRIGGER `onadd_bill` AFTER INSERT ON `tbl_bill` FOR EACH ROW BEGIN
		
	INSERT INTO tbl_contribution (amount,user_id,bill_id)
		SELECT NEW.amt,getAdmin('Admin'),NEW.id FROM tbl_deposit d
		INNER JOIN tbl_membership mp ON d.membership_id=mp.id 
		WHERE d.balance>=NEW.amt AND mp.mstatus='Active' AND membership_id=NEW.membership_id;
	update tbl_deposit d
	INNER JOIN tbl_membership mp ON d.membership_id=mp.id
	SET balance=(balance-NEW.amt) WHERE balance>=NEW.amt AND mp.mstatus='Active' AND membership_id=NEW.membership_id;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contribution`
--

DROP TABLE IF EXISTS `tbl_contribution`;
CREATE TABLE `tbl_contribution` (
  `id` int(11) NOT NULL,
  `amount` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `dt_paid` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_contribution`
--

INSERT INTO `tbl_contribution` (`id`, `amount`, `user_id`, `bill_id`, `dt_paid`) VALUES
(64, '100', 1, 203, '2024-12-18 00:38:38'),
(65, '100', 1, 204, '2024-12-18 00:38:38'),
(66, '100', 3, 209, '2024-12-18 00:56:01'),
(67, '100', 3, 210, '2024-12-18 01:00:35'),
(68, '100', 4, 211, '2024-12-18 01:04:52'),
(70, '100', 4, 201, '2024-12-18 01:06:48'),
(71, '100', 4, 205, '2024-12-18 01:06:54'),
(72, '100', 1, 218, '2024-12-18 01:11:49'),
(73, '100', 1, 219, '2024-12-18 01:11:49'),
(74, '100', 1, 232, '2024-12-18 01:22:37'),
(75, '100', 1, 233, '2024-12-18 01:22:37'),
(76, '100', 1, 247, '2024-12-18 02:20:48'),
(77, '100', 1, 248, '2024-12-18 02:20:48'),
(78, '100', 1, 262, '2024-12-18 02:21:31'),
(79, '100', 1, 263, '2024-12-18 02:21:31'),
(80, '100', 3, 230, '2024-12-18 02:29:09'),
(81, '100', 3, 260, '2024-12-18 02:29:09'),
(82, '100', 3, 216, '2024-12-18 02:29:09'),
(83, '100', 3, 245, '2024-12-18 02:29:09'),
(84, '100', 1, 277, '2024-12-18 11:04:26'),
(85, '100', 1, 278, '2024-12-18 11:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deactivation_account`
--

DROP TABLE IF EXISTS `tbl_deactivation_account`;
CREATE TABLE `tbl_deactivation_account` (
  `id` int(11) NOT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reason` varchar(150) DEFAULT 'Unable to pay the bill(s)',
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `dt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_deactivation_account`
--

INSERT INTO `tbl_deactivation_account` (`id`, `membership_id`, `user_id`, `reason`, `status`, `dt`) VALUES
(1, 1, 3, 'Unable to pay the bill(s)', 'Approved', '2024-12-18 01:21:13');

--
-- Triggers `tbl_deactivation_account`
--
DROP TRIGGER IF EXISTS `onupdate_deactivation_account`;
DELIMITER $$
CREATE TRIGGER `onupdate_deactivation_account` AFTER UPDATE ON `tbl_deactivation_account` FOR EACH ROW BEGIN
	
	if NEW.status = 'Approved' then
		update tbl_membership SET mstatus = 'Inactive' WHERE id=OLD.membership_id;
	end if;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_declared_death`
--

DROP TABLE IF EXISTS `tbl_declared_death`;
CREATE TABLE `tbl_declared_death` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `declarant_id` int(11) DEFAULT NULL,
  `dod` date DEFAULT NULL,
  `cod` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `dstatus` enum('Pending','Rejected','Posted','Closed') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_declared_death`
--

INSERT INTO `tbl_declared_death` (`id`, `member_id`, `declarant_id`, `dod`, `cod`, `user_id`, `date_added`, `dstatus`) VALUES
(20, 30, 31, '2024-12-18', '     ', 2, '2024-12-18 00:31:41', 'Posted'),
(21, 12, 11, '2024-12-18', 'CAR ACCIDENT', 2, '2024-12-18 01:11:43', 'Posted'),
(22, 27, 26, '2024-12-18', 'CAR ACCIDENT', 2, '2024-12-18 01:22:31', 'Posted'),
(23, 24, 25, '2024-12-18', 'CAR ACCIDENT', 2, '2024-12-18 02:19:29', 'Posted');

--
-- Triggers `tbl_declared_death`
--
DROP TRIGGER IF EXISTS `declareDeath`;
DELIMITER $$
CREATE TRIGGER `declareDeath` AFTER UPDATE ON `tbl_declared_death` FOR EACH ROW BEGIN
	if new.dstatus='Posted' then
		UPDATE tbl_mm SET STATUS='Inactive' WHERE member_id=NEW.member_id;
		insert into tbl_bill (membership_id,death_id,amt)
		SElect id,NEW.id,getContribution() FROM tbl_membership WHERE mstatus='Active';
	end if;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deposit`
--

DROP TABLE IF EXISTS `tbl_deposit`;
CREATE TABLE `tbl_deposit` (
  `id` int(11) NOT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `balance` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_deposit`
--

INSERT INTO `tbl_deposit` (`id`, `membership_id`, `balance`) VALUES
(19, 1, '0'),
(20, 19, '0'),
(21, 20, '0'),
(22, 24, '400'),
(23, 25, '400'),
(24, 26, '0'),
(25, 27, '0'),
(26, 28, '0'),
(27, 29, '0'),
(28, 30, '0'),
(29, 31, '0'),
(30, 33, '0'),
(34, 37, '0');

--
-- Triggers `tbl_deposit`
--
DROP TRIGGER IF EXISTS `onupdate_deposit`;
DELIMITER $$
CREATE TRIGGER `onupdate_deposit` AFTER UPDATE ON `tbl_deposit` FOR EACH ROW BEGIN
	declare newb decimal;
	declare oldb DECIMAL;
	SET newb = NEW.balance;
	SET oldb = old.balance;
	if newb > oldb then
		insert into tbl_msg (user_id,msg,deposit_id,balance_amount)
		values(getAdmin('Treasurer'),CONCAT('Added ',(NEW.balance - OLD.balance)),NEW.id,NEW.balance);
	elseif newb < oldb THEN
		INSERT INTO tbl_msg (user_id,msg,deposit_id,balance_amount)
		VALUES(getAdmin('Treasurer'),CONCAT('Deducted ',(OLD.balance - NEW.balance)),NEW.id,NEW.balance);
	end if;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

DROP TABLE IF EXISTS `tbl_member`;
CREATE TABLE `tbl_member` (
  `id` int(11) NOT NULL,
  `fname` varchar(60) DEFAULT NULL,
  `lname` varchar(60) DEFAULT NULL,
  `mname` varchar(60) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `cnum` varchar(20) DEFAULT NULL,
  `dt_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_member`
--

INSERT INTO `tbl_member` (`id`, `fname`, `lname`, `mname`, `dob`, `email`, `cnum`, `dt_added`) VALUES
(1, 'ARA', 'VILLAMOR', 'LODI', '2000-01-01', 'ara.villamor@gmail.com', '09466565656', '2024-08-23 21:46:04'),
(2, 'SHELLA MAE', 'CUSTODIO', 'LODI', '2000-01-01', 'shellamae.custodio@gmail.com', '09898989999', '2024-08-23 21:47:41'),
(3, 'LENDSEY MAE', 'LODI', 'LODI', '2000-01-01', 'ledset@gmail.com', '09786545682', '2024-08-23 21:48:19'),
(4, 'CARLOS', 'YOLO', 'LODI', '2000-01-01', 'carlos.yolo@gmail.com', '09782545682', '2024-08-23 21:50:41'),
(11, 'MADELA', 'Cruz', 'DELA', '1999-08-06', 'arashe@gmail.com', '09461111111', '2024-08-31 12:11:29'),
(12, 'JUAN', 'Cruz', 'DELA', '2001-09-12', 'juandelacruz@gmail.com', '09461111111', '2024-09-06 23:07:59'),
(21, 'PEDRO', 'Cruz', 'DELA', '2001-09-07', 'pedz@gmail.com', '09461111111', '2024-09-07 02:02:59'),
(22, 'MARIA', 'Malpor', 'GUAIN', '1990-09-06', 'juandelacruz@gmail.com', '09465598785', '2024-09-11 02:11:27'),
(23, 'JHON', 'Malpor', 'GUAIN', '2000-09-11', 'mal@gmail.com', '09466598752', '2024-09-11 02:13:16'),
(24, 'MELVIN', 'aristotle', 'A', '1999-10-24', 'mel@gmail.com', '09461111111', '2024-10-29 05:52:38'),
(25, 'ANNA EN', 'aristotle', 'S', '1998-10-30', 'ann@gmail.com', '09466598789', '2024-10-29 05:54:08'),
(26, 'STEVIN', ' Fuentes', 'ALBARA', '1995-10-12', 'steven@gmail.com', '09123452389', '2024-11-13 08:51:09'),
(27, 'STELLA', ' Fuentes', 'ALBARA', '1996-12-12', 'stella1@gmail.com', '09123452389', '2024-11-13 09:01:15'),
(28, 'ANYA', 'Sharma', 'ROSE', '1989-03-15', 'anya.r.sharma@gmail.com', '09123456789', '2024-11-21 00:23:12'),
(29, 'RAJ SHARMA', 'Sharma', 'ROSE', '1996-10-23', 'raj@gmail.com', '09123452389', '2024-11-21 00:24:51'),
(30, 'MAE', 'Dagooc', 'ROSALES', '2002-01-15', 'maedagooc@gmail.com', '09097789345', '2024-11-21 01:25:20'),
(31, 'JOAN', 'Dagooc', 'ROSALES', '1980-11-27', 'joandagooc@gmail.com', '09096438942', '2024-11-21 01:29:53'),
(32, 'YOYOY', 'Dagooc', 'POHANES', '1978-11-11', 'yoyoydagooc@gmail.com', '09658783245', '2024-11-21 01:32:11'),
(33, 'IRENE', 'Pohanes', 'HATAGI', '1995-05-04', 'irenepohanes@gmail.com', '09456723542', '2024-11-21 01:52:49'),
(34, 'YVET', 'Pohanes', 'HATAGI', '2011-03-28', 'yvetpohanes@gmail.com', '09784292704', '2024-11-21 01:56:34'),
(35, 'JERIC', 'Pohanes', 'HATAGI', '2014-09-22', 'jericpohanes@gmail.com', '09783920409', '2024-11-21 02:00:18'),
(36, 'REGINE', 'Pohanes', 'HATAGI', '2016-05-19', 'reginepohanes@gmail.com', '09093849202', '2024-11-21 02:02:00'),
(37, 'JUANCHO', 'Torilio', 'PILAPIL', '1965-06-23', 'juanchotorilio@gmail.com', '09387096097', '2024-11-21 02:45:20'),
(38, 'LISBETH', 'Torilio', 'SANGA', '1967-02-04', 'lisbethtorilio@gmail.com', '09008907685', '2024-11-21 02:48:33'),
(39, 'DONNA MARIE', 'Udtohan', 'CASTILLO', '2000-03-08', 'donnamarieudtohan@gmail.com', '09994685634', '2024-11-21 02:51:58'),
(40, 'DULFO', 'Baria', 'CALUPITAN', '1979-05-05', 'dulfobaria@gmail.com', '09564790365', '2024-11-21 02:54:32'),
(41, 'LOLITA', 'Calupitan', 'FERNANDEZ', '2001-02-07', 'lolitacalupitan@gmail.com', '09141213211', '2024-11-21 02:57:39'),
(42, 'RAJ ', 'Sharma', 'KATALOG', '1996-10-12', '', '09123456789', '2024-12-15 22:23:16'),
(43, 'SANTO', 'Vegas', 'YOU', '1996-12-24', '', '09765634563', '2024-12-15 22:25:20'),
(44, 'SANTA', 'Vegas', 'YOU', '1990-03-30', '', '0985264526', '2024-12-15 22:27:14'),
(45, 'YEDDAH MARIE', 'babol', 'ROBLE', '1990-02-10', '', '09876562345', '2024-12-18 02:15:24'),
(46, 'ARA ', 'babol', 'ROBLE', '2003-12-06', '', '09876562345', '2024-12-18 02:17:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_membership`
--

DROP TABLE IF EXISTS `tbl_membership`;
CREATE TABLE `tbl_membership` (
  `id` int(11) NOT NULL,
  `uname` varchar(60) DEFAULT NULL,
  `pass` varchar(60) DEFAULT NULL,
  `addr` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `mstatus` enum('Active','Inactive','Pending') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_membership`
--

INSERT INTO `tbl_membership` (`id`, `uname`, `pass`, `addr`, `date_added`, `mstatus`) VALUES
(1, 'ara.villamor@gmail.com', '202cb962ac59075b964b07152d234b70', 'San Jose, Aurora, ZDS', '2024-08-27 12:33:46', 'Inactive'),
(19, 'arashe1@gmail.com', '202cb962ac59075b964b07152d234b70', 'Poblacion, Aurora,ZDS', '2024-08-31 12:11:29', 'Active'),
(20, NULL, NULL, 'SAN JUAN, AURORA, ZDS', '2024-09-11 02:11:27', 'Active'),
(24, NULL, NULL, 'SAN JUAN, AURORA, ZDS', '2024-10-29 05:52:38', 'Active'),
(25, NULL, NULL, 'Inasagan, Aurora Zamboanga del sur', '2024-11-13 08:51:09', 'Active'),
(26, NULL, NULL, 'aurora zamboanga del sur', '2024-11-21 00:23:12', 'Active'),
(27, NULL, NULL, 'Lubid, Aurora ZDS', '2024-11-21 01:25:20', 'Active'),
(28, NULL, NULL, 'Libertad, Aurora ZDS', '2024-11-21 01:52:49', 'Active'),
(29, NULL, NULL, 'Campo Uno, Aurora ZDS', '2024-11-21 02:45:20', 'Active'),
(30, 'dulfobaria@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Inasagan, Aurora ZDS', '2024-11-21 02:54:32', 'Active'),
(31, NULL, NULL, 'aurora zamboanga del sur', '2024-12-15 22:23:16', 'Active'),
(33, NULL, NULL, 'Poblacion Aurora Zamboanga del sur', '2024-12-15 22:25:20', 'Active'),
(37, NULL, NULL, 'AZDS', '2024-12-18 02:15:24', 'Active');

--
-- Triggers `tbl_membership`
--
DROP TRIGGER IF EXISTS `onadd_membership`;
DELIMITER $$
CREATE TRIGGER `onadd_membership` AFTER INSERT ON `tbl_membership` FOR EACH ROW BEGIN
	INSERT INTO tbl_deposit (membership_id,balance)
	VALUES (NEW.id,0);
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mm`
--

DROP TABLE IF EXISTS `tbl_mm`;
CREATE TABLE `tbl_mm` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `role` enum('Head','Member') DEFAULT 'Head',
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `relationship` enum('Grandfather','Grandmother','Father','Mother','Son','Daughter','Grandson','Granddaughter','Others','Spouse') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_mm`
--

INSERT INTO `tbl_mm` (`id`, `member_id`, `membership_id`, `role`, `status`, `relationship`) VALUES
(1, 1, 1, 'Head', 'Active', ''),
(2, 2, 1, 'Member', 'Active', 'Daughter'),
(3, 3, 1, 'Member', 'Active', 'Granddaughter'),
(4, 4, 1, 'Member', 'Inactive', 'Mother'),
(5, 11, 19, 'Head', 'Inactive', ''),
(6, 12, 19, 'Member', 'Inactive', 'Daughter'),
(15, 21, 19, 'Member', 'Inactive', 'Father'),
(16, 22, 20, 'Member', 'Active', 'Daughter'),
(17, 23, 20, 'Head', 'Active', ''),
(19, 24, 24, 'Head', 'Inactive', ''),
(20, 25, 24, 'Member', 'Active', 'Daughter'),
(21, 26, 25, 'Head', 'Inactive', ''),
(22, 27, 25, 'Member', 'Inactive', 'Spouse'),
(23, 28, 26, 'Head', 'Active', ''),
(24, 29, 26, 'Member', 'Active', 'Son'),
(25, 30, 27, 'Member', 'Inactive', ''),
(26, 31, 27, 'Head', 'Active', 'Mother'),
(27, 32, 27, 'Member', 'Active', 'Father'),
(28, 33, 28, 'Head', 'Active', ''),
(29, 34, 28, 'Member', 'Active', 'Daughter'),
(30, 35, 28, 'Member', 'Active', 'Son'),
(31, 36, 28, 'Member', 'Active', 'Son'),
(32, 37, 29, 'Head', 'Active', ''),
(33, 38, 29, 'Member', 'Active', 'Spouse'),
(34, 39, 29, 'Member', 'Active', 'Granddaughter'),
(35, 40, 30, 'Head', 'Active', ''),
(36, 41, 30, 'Member', 'Active', 'Daughter'),
(37, 42, 31, 'Head', 'Active', ''),
(38, 43, 33, 'Head', 'Active', ''),
(39, 44, 33, 'Member', 'Inactive', 'Spouse'),
(40, 45, 37, 'Head', 'Active', ''),
(41, 46, 37, 'Member', 'Active', 'Daughter');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_msg`
--

DROP TABLE IF EXISTS `tbl_msg`;
CREATE TABLE `tbl_msg` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `msg` varchar(200) DEFAULT NULL,
  `deposit_id` int(11) DEFAULT NULL,
  `m_dt` timestamp NULL DEFAULT current_timestamp(),
  `balance_amount` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_msg`
--

INSERT INTO `tbl_msg` (`id`, `user_id`, `msg`, `deposit_id`, `m_dt`, `balance_amount`) VALUES
(1, 3, 'Added 1000', 23, '2024-12-18 00:37:57', '1000'),
(2, 3, 'Added 1000', 22, '2024-12-18 00:38:05', '1000'),
(3, 3, 'Deducted 100', 22, '2024-12-18 00:38:38', '900'),
(4, 3, 'Deducted 100', 23, '2024-12-18 00:38:38', '900'),
(5, 3, 'Deducted 100', 22, '2024-12-18 01:11:49', '800'),
(6, 3, 'Deducted 100', 23, '2024-12-18 01:11:49', '800'),
(7, 3, 'Deducted 100', 22, '2024-12-18 01:22:37', '700'),
(8, 3, 'Deducted 100', 23, '2024-12-18 01:22:37', '700'),
(9, 3, 'Deducted 100', 22, '2024-12-18 02:20:48', '600'),
(10, 3, 'Deducted 100', 23, '2024-12-18 02:20:48', '600'),
(11, 3, 'Deducted 100', 22, '2024-12-18 02:21:31', '500'),
(12, 3, 'Deducted 100', 23, '2024-12-18 02:21:31', '500'),
(13, 3, 'Deducted 100', 22, '2024-12-18 11:04:26', '400'),
(14, 3, 'Deducted 100', 23, '2024-12-18 11:04:26', '400');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_release`
--

DROP TABLE IF EXISTS `tbl_release`;
CREATE TABLE `tbl_release` (
  `id` int(11) NOT NULL,
  `death_id` int(11) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `receiver` varchar(180) DEFAULT NULL,
  `amt` varchar(20) DEFAULT NULL,
  `dt` timestamp NULL DEFAULT current_timestamp(),
  `type` enum('Expenses','Released') DEFAULT 'Expenses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_release`
--

INSERT INTO `tbl_release` (`id`, `death_id`, `purpose`, `user_id`, `receiver`, `amt`, `dt`, `type`) VALUES
(1, 20, 'RELEASED', 3, 'Cruz, Madela', '50', '2024-12-18 00:40:45', 'Released'),
(2, 20, 'RELEASED', 3, 'Cruz, Madela', '25', '2024-12-18 00:44:52', 'Released');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

DROP TABLE IF EXISTS `tbl_settings`;
CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `contribution` varchar(20) DEFAULT NULL,
  `date_altered` timestamp NULL DEFAULT current_timestamp(),
  `membership_fee` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `contribution`, `date_altered`, `membership_fee`) VALUES
(1, '100', '2024-09-11 02:09:58', '50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `fname` varchar(60) DEFAULT NULL,
  `lname` varchar(60) DEFAULT NULL,
  `uname` varchar(60) DEFAULT NULL,
  `pass` varchar(60) DEFAULT NULL,
  `role` enum('Admin','Treasurer','Secretary','Collector') DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `fname`, `lname`, `uname`, `pass`, `role`, `status`) VALUES
(1, 'ARA', 'VILLAMOR', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'Active'),
(2, 'SHELLA MAE', 'CUSTODIO', 'secretary', '889b2b111b4bc3adb722f0fcff480901', 'Secretary', 'Active'),
(3, 'LENDSEY', 'MAE', 'treasurer', '242fb277e2e5ebd600540af0c99edfb6', 'Treasurer', 'Active'),
(4, 'CAPLOS', 'BARBIE', 'collector1', '9ae8148974c9ca01ec9271753426d214', 'Collector', 'Active'),
(6, 'RYAN', 'BANG', 'bang', '7b750d8eacfee224ab8f1a92759b4094', 'Collector', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_bill`
--
ALTER TABLE `tbl_bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_bill1` (`membership_id`),
  ADD KEY `FK_tbl_bill2` (`death_id`);

--
-- Indexes for table `tbl_contribution`
--
ALTER TABLE `tbl_contribution`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_contribution` (`user_id`),
  ADD KEY `FK_tbl_contribution2` (`bill_id`);

--
-- Indexes for table `tbl_deactivation_account`
--
ALTER TABLE `tbl_deactivation_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_deactivation_account1` (`membership_id`),
  ADD KEY `FK_tbl_deactivation_account2` (`user_id`);

--
-- Indexes for table `tbl_declared_death`
--
ALTER TABLE `tbl_declared_death`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_declared_death` (`member_id`);

--
-- Indexes for table `tbl_deposit`
--
ALTER TABLE `tbl_deposit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_deposit` (`membership_id`);

--
-- Indexes for table `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_membership`
--
ALTER TABLE `tbl_membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_mm`
--
ALTER TABLE `tbl_mm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_mm1` (`member_id`),
  ADD KEY `FK_tbl_mm2` (`membership_id`);

--
-- Indexes for table `tbl_msg`
--
ALTER TABLE `tbl_msg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_msg` (`deposit_id`);

--
-- Indexes for table `tbl_release`
--
ALTER TABLE `tbl_release`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_expenses` (`death_id`),
  ADD KEY `FK_tbl_expenses1` (`user_id`),
  ADD KEY `FK_tbl_expenses2` (`receiver`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_bill`
--
ALTER TABLE `tbl_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT for table `tbl_contribution`
--
ALTER TABLE `tbl_contribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `tbl_deactivation_account`
--
ALTER TABLE `tbl_deactivation_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_declared_death`
--
ALTER TABLE `tbl_declared_death`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_deposit`
--
ALTER TABLE `tbl_deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_member`
--
ALTER TABLE `tbl_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_membership`
--
ALTER TABLE `tbl_membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_mm`
--
ALTER TABLE `tbl_mm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_msg`
--
ALTER TABLE `tbl_msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_release`
--
ALTER TABLE `tbl_release`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_bill`
--
ALTER TABLE `tbl_bill`
  ADD CONSTRAINT `FK_tbl_bill1` FOREIGN KEY (`membership_id`) REFERENCES `tbl_membership` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_bill2` FOREIGN KEY (`death_id`) REFERENCES `tbl_declared_death` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_contribution`
--
ALTER TABLE `tbl_contribution`
  ADD CONSTRAINT `FK_tbl_contribution` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_contribution2` FOREIGN KEY (`bill_id`) REFERENCES `tbl_bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_deactivation_account`
--
ALTER TABLE `tbl_deactivation_account`
  ADD CONSTRAINT `FK_tbl_deactivation_account1` FOREIGN KEY (`membership_id`) REFERENCES `tbl_membership` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_deactivation_account2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_declared_death`
--
ALTER TABLE `tbl_declared_death`
  ADD CONSTRAINT `FK_tbl_declared_death` FOREIGN KEY (`member_id`) REFERENCES `tbl_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_deposit`
--
ALTER TABLE `tbl_deposit`
  ADD CONSTRAINT `FK_tbl_deposit` FOREIGN KEY (`membership_id`) REFERENCES `tbl_membership` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_mm`
--
ALTER TABLE `tbl_mm`
  ADD CONSTRAINT `FK_tbl_mm1` FOREIGN KEY (`member_id`) REFERENCES `tbl_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_mm2` FOREIGN KEY (`membership_id`) REFERENCES `tbl_membership` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_msg`
--
ALTER TABLE `tbl_msg`
  ADD CONSTRAINT `FK_tbl_msg` FOREIGN KEY (`deposit_id`) REFERENCES `tbl_deposit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_release`
--
ALTER TABLE `tbl_release`
  ADD CONSTRAINT `FK_tbl_expenses` FOREIGN KEY (`death_id`) REFERENCES `tbl_declared_death` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_expenses1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
