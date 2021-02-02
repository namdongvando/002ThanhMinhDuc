-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2020 at 03:19 PM
-- Server version: 5.7.30-log-cll-lve
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hcdcvna2_hcdc`
--

-- --------------------------------------------------------

--
-- Table structure for table `e368b9938746fa090d6afd3628355133_admin_groups`
--

CREATE TABLE `e368b9938746fa090d6afd3628355133_admin_groups` (
  `Id` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Note` text,
  `Role` json DEFAULT NULL,
  `GroupsId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `e368b9938746fa090d6afd3628355133_admin_groups`
--

INSERT INTO `e368b9938746fa090d6afd3628355133_admin_groups` (`Id`, `Name`, `Note`, `Role`, `GroupsId`) VALUES
(1, 'Biên tập viên', '', '{\"Controller_madv\": false, \"Controller_mmenu\": false, \"Controller_mnews\": true, \"Controller_mpage\": false, \"Controller_muser\": false, \"Controller_minfor\": false, \"Controller_mtheme\": false, \"Controller_backend\": true, \"Controller_duyettin\": true, \"Controller_editnews\": true, \"Controller_mcategory\": false}', 1),
(2, 'Admin', '', '{\"Controller_madv\": true, \"Controller_mmenu\": true, \"Controller_mnews\": true, \"Controller_mpage\": true, \"Controller_muser\": true, \"Controller_minfor\": true, \"Controller_mtheme\": true, \"Controller_backend\": true, \"Controller_duyettin\": true, \"Controller_editnews\": true, \"Controller_mcategory\": true}', 0),
(3, 'modification', '', '{\"Controller_madv\": true, \"Controller_mmenu\": false, \"Controller_mnews\": false, \"Controller_mpage\": false, \"Controller_muser\": false, \"Controller_minfor\": false, \"Controller_mtheme\": false, \"Controller_backend\": true, \"Controller_duyettin\": true, \"Controller_editnews\": true, \"Controller_mcategory\": false}', 2),
(4, 'Đăng Tin', '', '{\"Controller_madv\": false, \"Controller_mmenu\": false, \"Controller_mnews\": false, \"Controller_mpage\": false, \"Controller_muser\": false, \"Controller_minfor\": false, \"Controller_mtheme\": false, \"Controller_backend\": false, \"Controller_duyettin\": true, \"Controller_editnews\": false, \"Controller_mcategory\": false}', 4),
(5, 'Duyệt Tin', '', '{\"Controller_madv\": false, \"Controller_mmenu\": false, \"Controller_mnews\": false, \"Controller_mpage\": false, \"Controller_muser\": false, \"Controller_minfor\": false, \"Controller_mtheme\": false, \"Controller_backend\": false, \"Controller_duyettin\": true, \"Controller_editnews\": false, \"Controller_mcategory\": false}', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `e368b9938746fa090d6afd3628355133_admin_groups`
--
ALTER TABLE `e368b9938746fa090d6afd3628355133_admin_groups`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `e368b9938746fa090d6afd3628355133_admin_groups`
--
ALTER TABLE `e368b9938746fa090d6afd3628355133_admin_groups`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
