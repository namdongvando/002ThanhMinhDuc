-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 23, 2020 at 03:05 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gencotool`
--

-- --------------------------------------------------------

--
-- Table structure for table `genco_admin`
--

DROP TABLE IF EXISTS `genco_admin`;
CREATE TABLE IF NOT EXISTS `genco_admin` (
  `Username` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Random` varchar(40) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Address` text NOT NULL,
  `Note` text NOT NULL,
  `Groups` int(11) NOT NULL,
  `Urrlimages` text NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genco_admin`
--

INSERT INTO `genco_admin` (`Username`, `Password`, `Random`, `Name`, `Email`, `Phone`, `Address`, `Note`, `Groups`, `Urrlimages`) VALUES
('admin', 'aeff687ce115f337bf0e4d3d279cb8127391417f', '92c10a8b94da8ef879402a03581a15dc440b5a56', 'Nguyễn Văn D', 'namdong92@gmail.com', '0366997840', '115/21 phạm đình hổ phường 6 quận 6', '{\"Active\":1}', 0, ''),
('admin3', 'a8865647a72f42edb6372a057bf4b70ad9775933', 'obqe{a%)h$dsbo*$n!!b', 'Admin3', '14782369@gmail.com', '0123456789', '', '{\"Active\":1}', 0, ''),
('adminmaster', 'f0ad04ab1ef71438a8f9e6c271cadb59d213aae4', '123eds', 'Dai ta', 'namdong91@gmail.com', '0372779917', 'Nam dong, cu jut, dak nong\r\n', '{\"Active\":0}', 2, ''),
('dangbai1', '32b72f3d0dbc2c4af52c10b4f7a00d293e8568c1', 'glzy^*^8ao04hd(v}#sc', 'dangbai1', '', '', '', '{\"Active\":1}', 4, ''),
('dangbai2', 'f0c027680b6f2c125c7f489a43ccdfd5bcd052c2', 'qb^u0a&1]0zebajqqf0)', 'dangbai2', '', '', '', '{\"Active\":0}', 1, ''),
('duyetbai1', '015287ae4ecab0f5ae57f1a5febc774599041a0f', '8vg%pq$gmif0m%lnksus', 'duyetbai1', '', '', '', '{\"Active\":0}', 1, ''),
('duyetbai2', '1749030ee6389eb46273c59a0fe69c66acb7788b', '&ev1c^asfo2hngh(q8c*', 'duyetbai2', '', '', '', '{\"Active\":0}', 1, ''),
('minhle', 'a1cf777be1023a2f15ed1e15cca186af36e673c6', 'cs@bs%cbqra*^if*rd%6', 'Lê Trường Minh', 'letrminh@gmail.com', '090674866', '', '{\"Active\":1}', 0, ''),
('mod1', '2f61c73677d969bf7332c9d122b0998625bf71f5', '1%aggz70c)sqg}5m9i%4', 'mod1', '', '', '', '{\"Active\":1}', 2, ''),
('mod2', '5ffc4a3da2dd56debb4889b2703166c577dbe7ff', 'kgr&qlr^ldgb}ad$vga9', 'mod2', '', '', '', '{\"Active\":0}', 1, ''),
('mod3', 'a75dbda5ae6a979539a1d719e50f0bb0691d3f6e', '!0@d03xa[6auwkp&*c*4', 'mod3', 'namdong92@gmail.com', '0987654321', '', '{\"Active\":1}', 2, ''),
('mod4', 'ad239255c18f50b65c65e6a70f88b62216438450', 'cz6}fjgg5wsq@bbucdb*', 'mod4', '', '', '', '{\"Active\":0}', 1, ''),
('quanlybaihiv', 'ad14e0cdef9e220fe74574495a517cdb8497253d', '^#3ue1cde*2v2{&d[qb1', 'quanlybaihiv', 'namdong92@gmail.com', '0366997840', '', '{\"Active\":1}', 0, ''),
('thembai1', '0da627de2f00bc3999e55aeba950d5bcfa9702c4', '^a*hjadg*$#7r4xqrybq', 'thembai1', '', '', '', '{\"Active\":0}', 1, ''),
('thembai2', 'fa5007c1e4b719cca616c55a4b67f8a909caac65', '4d9hb8ce(wdrcfkdx8sv', 'thembai2', '', '', '', '{\"Active\":0}', 1, ''),
('truyenthong', 'ec44811827a3b91beb449c15f0d8402c32687c80', 'u3g851&m590fj$w^gbcc', 'truyenthong', '', '', '', '{\"Active\":0}', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `genco_admin_groups`
--

DROP TABLE IF EXISTS `genco_admin_groups`;
CREATE TABLE IF NOT EXISTS `genco_admin_groups` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Note` text DEFAULT NULL,
  `Role` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`Role`)),
  `GroupsId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genco_admin_groups`
--

INSERT INTO `genco_admin_groups` (`Id`, `Name`, `Note`, `Role`, `GroupsId`) VALUES
(1, 'Biên tập viên', '', '{\"Controller_madv\": false, \"Controller_mmenu\": false, \"Controller_mnews\": true, \"Controller_mpage\": false, \"Controller_muser\": false, \"Controller_minfor\": false, \"Controller_mtheme\": false, \"Controller_backend\": true, \"Controller_duyettin\": true, \"Controller_editnews\": true, \"Controller_mcategory\": false}', 1),
(2, 'Admin', '', '{\"Controller_madv\": true, \"Controller_mmenu\": true, \"Controller_mnews\": true, \"Controller_mpage\": true, \"Controller_muser\": true, \"Controller_minfor\": true, \"Controller_mtheme\": true, \"Controller_backend\": true, \"Controller_duyettin\": true, \"Controller_editnews\": true, \"Controller_mcategory\": true}', 0),
(3, 'modification', '', '{\"Controller_madv\": true, \"Controller_mmenu\": false, \"Controller_mnews\": false, \"Controller_mpage\": false, \"Controller_muser\": false, \"Controller_minfor\": false, \"Controller_mtheme\": false, \"Controller_backend\": true, \"Controller_duyettin\": true, \"Controller_editnews\": true, \"Controller_mcategory\": false}', 2),
(4, 'Đăng Tin', '', '{\"Controller_madv\": false, \"Controller_mmenu\": false, \"Controller_mnews\": false, \"Controller_mpage\": false, \"Controller_muser\": false, \"Controller_minfor\": false, \"Controller_mtheme\": false, \"Controller_backend\": false, \"Controller_duyettin\": true, \"Controller_editnews\": false, \"Controller_mcategory\": false}', 4),
(5, 'Duyệt Tin', '', '{\"Controller_madv\": false, \"Controller_mmenu\": false, \"Controller_mnews\": false, \"Controller_mpage\": false, \"Controller_muser\": false, \"Controller_minfor\": false, \"Controller_mtheme\": false, \"Controller_backend\": false, \"Controller_duyettin\": true, \"Controller_editnews\": false, \"Controller_mcategory\": false}', 3);

-- --------------------------------------------------------

--
-- Table structure for table `genco_options`
--

DROP TABLE IF EXISTS `genco_options`;
CREATE TABLE IF NOT EXISTS `genco_options` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `Code` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Groups` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `OrderBy` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genco_options`
--

INSERT INTO `genco_options` (`Id`, `Name`, `Code`, `Groups`, `OrderBy`) VALUES
(1, 'option 1', '1', 'goals', 0),
(2, 'option 2', '2', 'goals', 1),
(3, 'option 3', '3', 'goals', 3);

-- --------------------------------------------------------

--
-- Table structure for table `genco_project`
--

DROP TABLE IF EXISTS `genco_project`;
CREATE TABLE IF NOT EXISTS `genco_project` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Phone` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genco_project`
--

INSERT INTO `genco_project` (`Id`, `Name`, `Address`, `Phone`, `Email`) VALUES
(1, 'Dì Ký', 'sdaa sdasdas', '1231212', 'namdong92@gmail.com'),
(2, 'Dự Án 1', '', '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
