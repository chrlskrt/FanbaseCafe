-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 06:18 PM
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
  `event_description` varchar(750) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblevent`
--

INSERT INTO `tblevent` (`event_id`, `account_id`, `fanbase_id`, `event_name`, `event_type`, `event_date`, `event_time`, `event_location`, `event_description`) VALUES
(1, 1, 1, 'SVT CEBU MEET & GREET', 'Meet & Greet', '2024-05-08', '15:00:00.000000', 'SM Seaside, Cebu', 'K-POP Boy Group SEVENTEEN will hold an offsite MEETING with CARATs in CEBU!'),
(2, 1, 2, 'BLINK CUP-SLEEVE EXTRAVAGANZA!', 'Cupsleeve', '2024-05-31', '10:00:00.000000', 'SM Seaside, Cebu', 'Design you own BLACKPINK cup sleeve & win merch!'),
(3, 1, 3, 'TXT \"Dream Chapter: MOA Playground\"', 'Fan Festival', '2024-08-14', '18:00:00.000000', 'Anjo World Theme Park, Minglanilla, Cebu', 'Live music, games, fansign & exclusive merch! Don\'t miss out on the fun!'),
(4, 1, 4, 'BTS Muster: Light the Night ', 'Fan Concert', '2024-08-22', '18:00:00.000000', 'Ayala Malls, Lahug', 'Calling all ARMY!  ✨  Get ready to light up the night with BTS! The  BTS Muster: Light the Night fan concert is back, and it\'s going to be epic. Don\'t miss unforgettable performances, special stages, and the chance to connect with the amazing BTS fandom. Join us for an unforgettable night!'),
(5, 1, 5, 'iKONIC Night: Dive into the KINGDOM', 'Fan Festival', '2024-10-10', '18:00:00.000000', 'Cebu Institute of Technology-University', 'iKONICs, relive KINGDOM & celebrate iKON! ');

-- --------------------------------------------------------

--
-- Table structure for table `tblevent_participant`
--

CREATE TABLE `tblevent_participant` (
  `event_participant_id` int(6) NOT NULL,
  `event_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblfanbase`
--

CREATE TABLE `tblfanbase` (
  `fanbase_id` int(11) NOT NULL,
  `fanbase_name` varchar(30) NOT NULL,
  `fanbase_artist` varchar(30) NOT NULL,
  `date_created` date NOT NULL,
  `fanbase_description` varchar(500) NOT NULL,
  `fanbase_photo` varchar(150) NOT NULL,
  `fanbase_logo` varchar(150) NOT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfanbase`
--

INSERT INTO `tblfanbase` (`fanbase_id`, `fanbase_name`, `fanbase_artist`, `date_created`, `fanbase_description`, `fanbase_photo`, `fanbase_logo`, `isDeleted`) VALUES
(1, 'CARAT', 'SEVENTEEN', '2024-05-08', 'A safe place for CARATs and SEVENTEEN', 'grpcarat.jpg', 'grpcaratLogo.jpg', 0),
(2, 'BLINK', 'BLACKPINK', '2024-05-08', 'A safe place for BLINKs and BLACKPINK', 'grpblink.jpg', 'grpblinkLogo.jpg', 0),
(3, 'MOA', 'Tomorrow X Together', '2024-05-08', 'A safe place for MOAs', 'grpMOA.jpg', 'grpMOALogo.jpg', 0),
(4, 'ARMY', 'BTS', '2024-05-08', 'A safe place for ARMYs and BTS', 'grpARMY.jpg', 'grpARMYLogo.jpg', 0),
(5, 'iKONIC', 'iKON', '2024-05-08', 'A safe place for iKONICs and iKON', 'grpikonic.jpg', 'grpikonicLogo.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblfanbase_admin`
--

CREATE TABLE `tblfanbase_admin` (
  `fanbase_admin_id` int(6) NOT NULL,
  `acc_fanbase_id` int(6) NOT NULL,
  `date_appointed` date NOT NULL,
  `isDemoted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblfanbase_adminrequest`
--

CREATE TABLE `tblfanbase_adminrequest` (
  `adminrequest_id` int(6) NOT NULL,
  `account_id` int(6) NOT NULL,
  `fanbase_id` int(6) NOT NULL,
  `date_requested` date NOT NULL,
  `isRequested` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblpost`
--

CREATE TABLE `tblpost` (
  `post_id` int(6) NOT NULL,
  `account_id` int(6) NOT NULL,
  `fanbase_id` int(6) NOT NULL,
  `post_created` datetime NOT NULL,
  `post_text` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblreply`
--

CREATE TABLE `tblreply` (
  `reply_id` int(6) NOT NULL,
  `post_id` int(6) NOT NULL,
  `account_id` int(6) NOT NULL,
  `reply_created` datetime NOT NULL,
  `reply_text` varchar(500) NOT NULL
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
  `isSysAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `isDeleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluseraccount`
--

INSERT INTO `tbluseraccount` (`account_id`, `user_id`, `email_add`, `username`, `password`, `isSysAdmin`, `isDeleted`) VALUES
(1, 1, 'admin101@gmail.com', 'admin101', '$2y$10$xrlIhsfu/vbFINVIKFVLUeshT70j58Xr9LF2CLQeJ35lEnyatUAIa', 1, 0),
(2, 2, 'pop@gmail.com', 'pop', '$2y$10$RZ07r0zBo4NA0jIvEvEa1.WkPPCuIOYzXtc0jSm9ZQNy0xvhY2WRq', 0, 0),
(3, 3, 'ice@gmail.com', 'ice', '$2y$10$AZcGp4n3a/YrYisn8qjgTu8Buy3BLEN2PgbJ8bR2v7P4N.ievgmru', 0, 0);

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
(1, 1, 1, '2024-05-08', 1, 0),
(2, 1, 2, '2024-05-08', 1, 0),
(3, 1, 3, '2024-05-08', 1, 0),
(4, 1, 4, '2024-05-08', 1, 0),
(5, 1, 5, '2024-05-08', 1, 0),
(6, 2, 1, '2024-05-08', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbluseraccount_sysadmin`
--

CREATE TABLE `tbluseraccount_sysadmin` (
  `sysAdmin_id` int(6) NOT NULL,
  `account_id` int(6) NOT NULL,
  `date_appointed` date NOT NULL,
  `isDemoted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluseraccount_sysadmin`
--

INSERT INTO `tbluseraccount_sysadmin` (`sysAdmin_id`, `account_id`, `date_appointed`, `isDemoted`) VALUES
(1, 1, '2024-05-08', 0);

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
(1, 'admin101', 'admin101', '2000-01-01'),
(2, 'pop', 'pop', '2004-09-19'),
(3, 'ice', 'ice', '2009-05-08');

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
-- Indexes for table `tblevent_participant`
--
ALTER TABLE `tblevent_participant`
  ADD PRIMARY KEY (`event_participant_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `account_id` (`account_id`);

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
-- Indexes for table `tblfanbase_adminrequest`
--
ALTER TABLE `tblfanbase_adminrequest`
  ADD PRIMARY KEY (`adminrequest_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `fanbase_id` (`fanbase_id`);

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
-- Indexes for table `tbluseraccount_sysadmin`
--
ALTER TABLE `tbluseraccount_sysadmin`
  ADD PRIMARY KEY (`sysAdmin_id`),
  ADD KEY `account_id` (`account_id`);

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
-- AUTO_INCREMENT for table `tblevent_participant`
--
ALTER TABLE `tblevent_participant`
  MODIFY `event_participant_id` int(6) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `tblfanbase_adminrequest`
--
ALTER TABLE `tblfanbase_adminrequest`
  MODIFY `adminrequest_id` int(6) NOT NULL AUTO_INCREMENT;

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
  MODIFY `acc_fanbase_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbluseraccount_sysadmin`
--
ALTER TABLE `tbluseraccount_sysadmin`
  MODIFY `sysAdmin_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Constraints for table `tblevent_participant`
--
ALTER TABLE `tblevent_participant`
  ADD CONSTRAINT `tblevent_participant_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `tblevent` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblevent_participant_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `tbluseraccount` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblfanbase_admin`
--
ALTER TABLE `tblfanbase_admin`
  ADD CONSTRAINT `tblfanbase_admin_ibfk_1` FOREIGN KEY (`acc_fanbase_id`) REFERENCES `tbluseraccount_fanbase` (`acc_fanbase_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblfanbase_adminrequest`
--
ALTER TABLE `tblfanbase_adminrequest`
  ADD CONSTRAINT `tblfanbase_adminrequest_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `tbluseraccount` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblfanbase_adminrequest_ibfk_2` FOREIGN KEY (`fanbase_id`) REFERENCES `tblfanbase` (`fanbase_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Constraints for table `tbluseraccount_sysadmin`
--
ALTER TABLE `tbluseraccount_sysadmin`
  ADD CONSTRAINT `tbluseraccount_sysadmin_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `tbluseraccount` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
