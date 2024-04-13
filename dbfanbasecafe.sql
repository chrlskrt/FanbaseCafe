-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2024 at 11:13 AM
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
-- Database: `dbfanbasecafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblevent`
--

CREATE TABLE `tblevent` (
  `event_id` int(6) NOT NULL,
  `account_id` int(6) NOT NULL,
  `fanbase_id` int(6) NOT NULL,
  `event_name` varchar(48) NOT NULL,
  `event_type` varchar(30) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time(6) NOT NULL,
  `event_location` varchar(100) NOT NULL,
  `event_description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblevent`
--

INSERT INTO `tblevent` (`event_id`, `account_id`, `fanbase_id`, `event_name`, `event_type`, `event_date`, `event_time`, `event_location`, `event_description`) VALUES
(1, 1, 1, 'SVT CEBU MEET & GREET', 'Meet & Greet', '2024-05-15', '15:00:00.000000', 'SM Seaside, SRP', 'K-POP Boy Group SEVENTEEN will hold an offsite MEET & GREET with CARATs in CEBU to celebrate the success of their latest album.'),
(2, 1, 2, 'BLINK CUP-SLEEVEE EXTRAVAGANZA!', 'Cupsleeve', '2024-06-05', '10:00:00.000000', 'SM Seaside, SRP', 'Design your own BLACKPINK cup sleeve & win merch!  #BLINKCupSleeveEvent'),
(3, 1, 3, 'TXT \"Dream Chapter: MOA Playground\"', 'DREAM', '2024-08-14', '10:00:00.000000', 'ANJO World, CEBU', 'Live music, games, fansign & exclusive merch! Don\'t miss the MOA party with TXT! #TXTMoaPlayground'),
(4, 1, 4, 'BTS Muster: Light the Night (CEBU)', 'Concert', '2024-04-25', '18:00:00.000000', 'Ayala Malls, Lahug', 'This event is primarily a concert, focusing on a live performance by BTS where fans can sing along, dance, and celebrate their love for the group. The additional elements like special surprises and ARMY-focused activities enhance the concert experience but don\'t overshadow the core focus on live music.'),
(5, 1, 5, 'iKONIC Night: Dive into the KINGDOM', 'Fan Festival', '2024-05-30', '16:00:00.000000', 'Cebu Institute of Technology-University', 'iKONICS, relive KINGDOM & celebrate iKON!\r\n\r\nEnjoy video screening, games, exclusive content & merch. Mingle with fellow fans & create lasting memories!  #iKONICNight');

-- --------------------------------------------------------

--
-- Table structure for table `tblfanbase`
--

CREATE TABLE `tblfanbase` (
  `fanbase_id` int(11) NOT NULL,
  `fanbase_name` varchar(30) NOT NULL,
  `fanbase_artist` varchar(30) NOT NULL,
  `date_created` date NOT NULL,
  `fanbase_description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfanbase`
--

INSERT INTO `tblfanbase` (`fanbase_id`, `fanbase_name`, `fanbase_artist`, `date_created`, `fanbase_description`) VALUES
(1, 'CARAT', 'SEVENTEEN', '2015-02-14', 'A safe place for CARATS!!'),
(2, 'BLINK', 'BLACKPINK', '2016-04-06', 'A safe place for BLINKs'),
(3, 'MOA', 'Tomorrow X Together', '2024-04-04', 'A safe place for MOAs'),
(4, 'ARMY', 'BTS', '2024-04-03', 'A safe place for ARMYs'),
(5, 'iKONIC', 'iKON', '2024-04-07', 'A safe space for iKONICs');

-- --------------------------------------------------------

--
-- Table structure for table `tblfanbase_admin`
--

CREATE TABLE `tblfanbase_admin` (
  `fanbase_admin_id` int(6) NOT NULL,
  `acc_fanbase_id` int(6) NOT NULL,
  `date_appointed` date NOT NULL,
  `isActive` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblfanbase_member`
--

CREATE TABLE `tblfanbase_member` (
  `fanbase_member_id` int(6) NOT NULL,
  `acc_fanbase_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfanbase_member`
--

INSERT INTO `tblfanbase_member` (`fanbase_member_id`, `acc_fanbase_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tblpost`
--

CREATE TABLE `tblpost` (
  `post_id` int(6) NOT NULL,
  `account_id` int(6) NOT NULL,
  `fanbase_id` int(6) NOT NULL,
  `post_created` date NOT NULL,
  `post_text` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblreply`
--

CREATE TABLE `tblreply` (
  `reply_id` int(6) NOT NULL,
  `post_id` int(6) NOT NULL,
  `fanbase_id` int(6) NOT NULL,
  `account_id` int(6) NOT NULL,
  `reply_text` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbluseraccount`
--

CREATE TABLE `tbluseraccount` (
  `account_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `email_add` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(72) NOT NULL,
  `isMember` tinyint(1) NOT NULL DEFAULT 1,
  `isSysAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluseraccount`
--

INSERT INTO `tbluseraccount` (`account_id`, `user_id`, `email_add`, `username`, `password`, `isMember`, `isSysAdmin`) VALUES
(1, 1, 'admin101@gmail.com', 'admin101', '$2y$10$TM8wTyla68b9H3JKS/wIxu95lh4RyGCuSKqdrR8Klml9sU57fMCMC', 1, 1),
(2, 2, 'pop@gmail.com', 'pop', '$2y$10$QUL4DkkPR3yVaTYNEkJewuR.L16XCPIvaYJzQ2JkL8MEkcBkVVln2', 1, 0),
(3, 3, 'ice@gmail.com', 'ice', '$2y$10$wlu4WdFyy0KRdbhLgX55ZuP6wocbpM0h3Mfc4qEuMIQmL4tADleFm', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbluseraccount_fanbase`
--

CREATE TABLE `tbluseraccount_fanbase` (
  `acc_fanbase_id` int(6) NOT NULL,
  `account_id` int(6) NOT NULL,
  `fanbase_id` int(6) NOT NULL,
  `date_joined` date NOT NULL,
  `isMember` int(1) NOT NULL DEFAULT 1,
  `isAdmin` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluseraccount_fanbase`
--

INSERT INTO `tbluseraccount_fanbase` (`acc_fanbase_id`, `account_id`, `fanbase_id`, `date_joined`, `isMember`, `isAdmin`) VALUES
(1, 1, 1, '2024-04-13', 1, 0),
(2, 1, 2, '2024-04-13', 1, 0),
(3, 1, 3, '2024-04-13', 1, 0),
(4, 1, 4, '2024-04-13', 1, 0),
(5, 1, 5, '2024-04-13', 1, 0),
(6, 2, 1, '2024-04-13', 1, 0),
(7, 2, 3, '2024-04-13', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbluserprofile`
--

CREATE TABLE `tbluserprofile` (
  `user_id` int(6) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `birthdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluserprofile`
--

INSERT INTO `tbluserprofile` (`user_id`, `firstname`, `lastname`, `birthdate`) VALUES
(1, 'admin101', 'admin101', '2001-01-01'),
(2, 'pop', 'pop', '2001-01-02'),
(3, 'ice', 'ice', '2001-01-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblevent`
--
ALTER TABLE `tblevent`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `fanbase_id` (`fanbase_id`);

--
-- Indexes for table `tblfanbase`
--
ALTER TABLE `tblfanbase`
  ADD PRIMARY KEY (`fanbase_id`);

--
-- Indexes for table `tblfanbase_admin`
--
ALTER TABLE `tblfanbase_admin`
  ADD PRIMARY KEY (`fanbase_admin_id`),
  ADD KEY `acc_fanbase_id` (`acc_fanbase_id`);

--
-- Indexes for table `tblfanbase_member`
--
ALTER TABLE `tblfanbase_member`
  ADD PRIMARY KEY (`fanbase_member_id`),
  ADD KEY `tblfanbase_member_ibfk_1` (`acc_fanbase_id`);

--
-- Indexes for table `tblpost`
--
ALTER TABLE `tblpost`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `fanbase_id` (`fanbase_id`);

--
-- Indexes for table `tblreply`
--
ALTER TABLE `tblreply`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `fanbase_id` (`fanbase_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `user_id_fk` (`user_id`);

--
-- Indexes for table `tbluseraccount_fanbase`
--
ALTER TABLE `tbluseraccount_fanbase`
  ADD PRIMARY KEY (`acc_fanbase_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `fanbase_id` (`fanbase_id`);

--
-- Indexes for table `tbluserprofile`
--
ALTER TABLE `tbluserprofile`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblevent`
--
ALTER TABLE `tblevent`
  MODIFY `event_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblfanbase`
--
ALTER TABLE `tblfanbase`
  MODIFY `fanbase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblfanbase_admin`
--
ALTER TABLE `tblfanbase_admin`
  MODIFY `fanbase_admin_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblfanbase_member`
--
ALTER TABLE `tblfanbase_member`
  MODIFY `fanbase_member_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblpost`
--
ALTER TABLE `tblpost`
  MODIFY `post_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblreply`
--
ALTER TABLE `tblreply`
  MODIFY `reply_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  MODIFY `account_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbluseraccount_fanbase`
--
ALTER TABLE `tbluseraccount_fanbase`
  MODIFY `acc_fanbase_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbluserprofile`
--
ALTER TABLE `tbluserprofile`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblevent`
--
ALTER TABLE `tblevent`
  ADD CONSTRAINT `tblevent_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `tbluseraccount` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblevent_ibfk_2` FOREIGN KEY (`fanbase_id`) REFERENCES `tblfanbase` (`fanbase_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblfanbase_admin`
--
ALTER TABLE `tblfanbase_admin`
  ADD CONSTRAINT `tblfanbase_admin_ibfk_1` FOREIGN KEY (`acc_fanbase_id`) REFERENCES `tbluseraccount_fanbase` (`acc_fanbase_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblfanbase_member`
--
ALTER TABLE `tblfanbase_member`
  ADD CONSTRAINT `tblfanbase_member_ibfk_1` FOREIGN KEY (`acc_fanbase_id`) REFERENCES `tbluseraccount_fanbase` (`acc_fanbase_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblpost`
--
ALTER TABLE `tblpost`
  ADD CONSTRAINT `tblpost_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `tbluseraccount` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblpost_ibfk_2` FOREIGN KEY (`fanbase_id`) REFERENCES `tblfanbase` (`fanbase_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblreply`
--
ALTER TABLE `tblreply`
  ADD CONSTRAINT `tblreply_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `tblpost` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblreply_ibfk_2` FOREIGN KEY (`fanbase_id`) REFERENCES `tblfanbase` (`fanbase_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblreply_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `tbluseraccount` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `tbluserprofile` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbluseraccount_fanbase`
--
ALTER TABLE `tbluseraccount_fanbase`
  ADD CONSTRAINT `tbluseraccount_fanbase_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `tbluseraccount` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbluseraccount_fanbase_ibfk_2` FOREIGN KEY (`fanbase_id`) REFERENCES `tblfanbase` (`fanbase_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
