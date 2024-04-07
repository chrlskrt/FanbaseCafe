-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2024 at 03:47 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbrepuestof1`
--

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
(4, 'ARMY', 'BTS', '2024-04-03', 'A safe place for ARMYs');

-- --------------------------------------------------------

--
-- Table structure for table `tbluseraccount`
--

CREATE TABLE `tbluseraccount` (
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email_add` text NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(72) NOT NULL,
  `isMember` tinyint(1) NOT NULL DEFAULT 1,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluseraccount`
--

INSERT INTO `tbluseraccount` (`account_id`, `user_id`, `email_add`, `username`, `password`, `isMember`, `isAdmin`) VALUES
(1, 1, 'admin101@gmail.com', 'admin101', '$2y$10$nW5XICRG2CZ1Zm70mRtVbOlhZSqg0DJZNEXE9fOiqVu3Qp5aLI6q2', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbluserprofile`
--

CREATE TABLE `tbluserprofile` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `birthdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluserprofile`
--

INSERT INTO `tbluserprofile` (`user_id`, `firstname`, `lastname`, `birthdate`) VALUES
(1, 'ADMIN101', 'ADMIN101', '2000-01-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblfanbase`
--
ALTER TABLE `tblfanbase`
  ADD PRIMARY KEY (`fanbase_id`);

--
-- Indexes for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `user_id_fk` (`user_id`);

--
-- Indexes for table `tbluserprofile`
--
ALTER TABLE `tbluserprofile`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblfanbase`
--
ALTER TABLE `tblfanbase`
  MODIFY `fanbase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbluserprofile`
--
ALTER TABLE `tbluserprofile`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `tbluserprofile` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
