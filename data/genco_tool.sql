-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th1 07, 2021 lúc 11:13 PM
-- Phiên bản máy phục vụ: 10.3.22-MariaDB
-- Phiên bản PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `genco_tool`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genco_admin`
--

CREATE TABLE `genco_admin` (
  `Id` int(11) NOT NULL,
  `Username` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Random` varchar(40) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Address` text NOT NULL,
  `Note` text NOT NULL,
  `Groups` int(11) NOT NULL,
  `Image` text NOT NULL,
  `Active` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `genco_admin`
--

INSERT INTO `genco_admin` (`Id`, `Username`, `Password`, `Random`, `Name`, `Email`, `Phone`, `Address`, `Note`, `Groups`, `Image`, `Active`) VALUES
(1, 'admin', 'aeff687ce115f337bf0e4d3d279cb8127391417f', '92c10a8b94da8ef879402a03581a15dc440b5a56', 'Nguyễn Văn Độ', 'namdong92@gmail.com', '0366997840', '115/21 phạm đình hổ phường 6 quận 6', '{\"Active\":1}', 1, '', 1),
(20, 'admin1', '8cf46dc6968bcc7813abd017b12d1c6e2758d95a', '6f8a1bea-7709-4ae7-a07d-d49228c42c57', 'admin1', 'namdong921@gmail.com', '123456', 'as das', '', 2, '', 1),
(2, 'admin3', 'a949680701d6476e5294c94e47946955eca32e26', 'obqe{a%)h$dsbo*$n!!b', 'Admin3', 'dung.huynh@genco.vn', '0123456789', '', '{\"Active\":1}', 1, '', 1),
(18, 'adminginky', '8dff762997be585a2c9ab718478c66ee61692a5c', 'f534d6df-7975-4800-b9ec-e91476bcb17f', 'Nguyen Van A', 'namdon12@gmail.com', '123456', 'as das', '', 2, '', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genco_admin_groups`
--

CREATE TABLE `genco_admin_groups` (
  `Id` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Note` text DEFAULT NULL,
  `Role` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`Role`)),
  `GroupsId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `genco_admin_groups`
--

INSERT INTO `genco_admin_groups` (`Id`, `Name`, `Note`, `Role`, `GroupsId`) VALUES
(1, 'Đối Tác', '', '{\"Controller_madv\": false, \"Controller_mmenu\": false, \"Controller_mnews\": true, \"Controller_mpage\": false, \"Controller_muser\": false, \"Controller_minfor\": false, \"Controller_mtheme\": false, \"Controller_backend\": true, \"Controller_duyettin\": true, \"Controller_editnews\": true, \"Controller_mcategory\": false}', 2),
(2, 'Admin', '', '{\"Controller_madv\": true, \"Controller_mmenu\": true, \"Controller_mnews\": true, \"Controller_mpage\": true, \"Controller_muser\": true, \"Controller_minfor\": true, \"Controller_mtheme\": true, \"Controller_backend\": true, \"Controller_duyettin\": true, \"Controller_editnews\": true, \"Controller_mcategory\": true}', 1),
(6, 'Supper Admin', '', '{\"Controller_madv\": false, \"Controller_mmenu\": false, \"Controller_mnews\": true, \"Controller_mpage\": false, \"Controller_muser\": false, \"Controller_minfor\": false, \"Controller_mtheme\": false, \"Controller_backend\": true, \"Controller_duyettin\": true, \"Controller_editnews\": true, \"Controller_mcategory\": false}', -1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genco_options`
--

CREATE TABLE `genco_options` (
  `Id` int(11) NOT NULL,
  `Name` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `Code` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Groups` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `OrderBy` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `genco_options`
--

INSERT INTO `genco_options` (`Id`, `Name`, `Code`, `Groups`, `OrderBy`) VALUES
(1, 'option 1', '1', 'goals', 0),
(2, 'option 2', '2', 'goals', 1),
(3, 'option 3', '3', 'goals', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genco_project`
--

CREATE TABLE `genco_project` (
  `Id` int(11) NOT NULL,
  `Name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Phone` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `MaxNumberController` int(11) NOT NULL DEFAULT 5,
  `Active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `genco_project`
--

INSERT INTO `genco_project` (`Id`, `Name`, `Address`, `Phone`, `Email`, `MaxNumberController`, `Active`) VALUES
(1, 'Dìn Ký Group', '137c Đ. Nguyễn Trãi, Phường Bến Thành, Quận 1, Thành phố Hồ Chí Minh', '0901866698', 'namdong92@gmail.com', 5, 1),
(2, 'SDASDASDA', 'asdA as', '121231212', 'namdong92@gmail.com', 5, -1),
(3, 'GenCo', 'a', '1234567890', 'namdong92@gmail.com', 5, -1),
(4, 'as as', 'sdas', 'asda', 'sdasdas@gmail.com', 5, -1),
(5, 'Dìn Ký Nguyễn Trãi', '137c Đ. Nguyễn Trãi, Phường Bến Thành, Quận 1, Thành phố Hồ Chí Minh', '0901866689', 'dung.huynh@genco.vn', 5, -1),
(6, 'Rum Cafe', '1. Rum Cafe GV: số 111 Lê Lợi, Phường 4, Gò Vấp, Thành phố Hồ Chí Minh\r\n2. Rum Cafe TĐ: số 20 Khổng Tử, Phường Bình Thọ, Thủ Đức, Thành phố Hồ Chí Minh', '0901866689', 'dung.huynh@genco.vn', 5, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genco_project_controller`
--

CREATE TABLE `genco_project_controller` (
  `Id` int(11) NOT NULL,
  `Name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PId` int(11) NOT NULL,
  `Lat` varchar(20) DEFAULT NULL,
  `Lon` varchar(20) DEFAULT NULL,
  `Ip` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UUID` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `genco_project_controller`
--

INSERT INTO `genco_project_controller` (`Id`, `Name`, `PId`, `Lat`, `Lon`, `Ip`, `Username`, `Password`, `UUID`) VALUES
(22, 'WHG201-TRỆT-NGUYENTRAI', 1, '', '', '118.69.65.193:8669', 'admin', 'admin1234', NULL),
(7, '14.241.224.232:8282', 3, '', '', '14.241.224.232:8282', 'admin', 'abcd1234', NULL),
(24, 'WHG201-RUMCAFE111LELOI', 6, '', '', '113.161.58.41:8282', 'admin', 'abcd1234', NULL),
(23, 'WHG201-CULAOXANH', 1, '', '', '113.161.69.30:8080', 'admin', 'abcd1234', NULL),
(21, 'WHG321-LAU4-NGUYENTRAI', 1, '', '', '118.69.65.193:8668', 'admin', 'admin1234', NULL),
(25, 'WHG201-RUMCAFE20KHONGTU', 6, '', '', '113.176.64.193:82', 'admin', 'admin1234', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genco_project_controller_data`
--

CREATE TABLE `genco_project_controller_data` (
  `Id` int(11) NOT NULL,
  `ControllerId` int(11) NOT NULL,
  `Col0` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Col1` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Col2` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Col3` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Col4` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Col5` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `genco_project_controller_data`
--

INSERT INTO `genco_project_controller_data` (`Id`, `ControllerId`, `Col0`, `Col1`, `Col2`, `Col3`, `Col4`, `Col5`) VALUES
(13, 1, 'hmrdung@gmail.com', 'dzung', '0901866698', '', '2019-11-30', '10 tỷ'),
(12, 1, '0901866698', '', '', '', '', ''),
(11, 1, 'dung.huynh@genco.vn', 'mr', 'dzung', '', '', ''),
(10, 1, 'wingsnoimibongtoi', '', '', '', '', ''),
(9, 1, 'soaivong01@gmail.com', 'soái vong', 'facebook ', '2019-11-08 13:50:25', '3', ''),
(14, 7, 'soaivong01@gmail.com', 'soái vong', 'facebook ', '2019-11-08 13:50:25', '3', ''),
(15, 7, 'wingsnoimibongtoi', '', '', '', '', ''),
(16, 7, 'dung.huynh@genco.vn', 'mr', 'dzung', '', '', ''),
(17, 7, '0901866698', '', '', '', '', ''),
(18, 7, 'hmrdung@gmail.com', 'dzung', '0901866698', '', '2019-11-30', '10 tỷ'),
(48, 21, 'truongngocvanquynh@yahoo.com.vn', 'quynh truong', 'facebook ', '2020-11-22 12:58:44', '1', ''),
(47, 21, 'steven_nguyen9999@yahoo.com', 'nguyen tien dung', 'facebook ', '2020-11-21 19:50:56', '1', ''),
(46, 21, 'nogias.man@gmail.com', 'pham phuong nam', 'facebook ', '2020-11-21 19:19:05', '1', ''),
(45, 21, 'lephungtam1905@gmail.com', 'lê p tâm', 'facebook ', '2020-11-21 19:00:51', '1', ''),
(44, 21, 'meo.beo94@yahoo.com.vn', 'phụng nguyễn', 'facebook ', '2020-11-20 20:43:00', '1', ''),
(43, 21, 'nhoxsockkut3n@yahoo.com', 'nguyễn văn Đại', 'facebook ', '2020-11-20 18:20:23', '1', ''),
(42, 21, 'loananhluu1998@gmail.com', 'loan anh luu', 'facebook ', '2020-11-20 08:57:21', '2', ''),
(41, 21, 'son465269@gmail.com', 'trần sơn', 'facebook ', '2020-11-19 21:55:21', '3', ''),
(40, 21, 'nghiphuong264@gmail.com', 'nghi nguyễn', 'facebook ', '2020-11-19 19:22:59', '1', ''),
(39, 21, 'minhtaibui789@gmail.com', 'minh tai', 'facebook ', '2020-11-19 19:03:06', '1', ''),
(34, 21, 'duyquang0705@gmail.com', 'tú huỳnh', 'facebook ', '2020-11-18 16:32:10', '1', ''),
(35, 21, 'huynhkimthao72@gmail.com', 'thao huynh', 'facebook ', '2020-11-18 18:04:19', '1', ''),
(36, 21, 'katekimngan@gmail.com', 'kimngan nguyen', 'facebook ', '2020-11-18 18:43:31', '1', ''),
(37, 21, 'trandinhthuy94@gmail.com', 'trần Đình thụy', 'facebook ', '2020-11-18 19:46:01', '1', ''),
(38, 21, 'nguyenthihuyentranglqdc3@gmail.com', 'huyền trang', 'facebook ', '2020-11-19 11:52:34', '1', ''),
(49, 21, 'devil_maycry_maylove97@yahoo.com', 'minh quang', 'facebook ', '2020-11-22 17:19:46', '1', ''),
(50, 21, 'ngocnhi1112003@gmail.com', 'võ long mẫn tiệp', 'facebook ', '2020-11-22 17:37:58', '1', ''),
(51, 21, 'levinh291199@gmail.com', 'lê phú vĩnh', 'facebook ', '2020-11-22 17:52:35', '1', ''),
(52, 21, 'bone27012000@gmail.com', 'dương quang thiên Ân', 'facebook ', '2020-11-22 18:05:28', '2', ''),
(53, 21, 'nlmphuong1305@gmail.com', 'mỹ phượng', 'facebook ', '2020-11-22 19:15:32', '1', ''),
(54, 21, 'anhkhoa.dienthoaivui@gmail.com', 'khoa hoàng', 'facebook ', '2020-11-22 20:05:53', '1', ''),
(55, 21, 'hoaiphongnttu@gmail.com', 'phong lê', 'facebook ', '2020-11-23 10:00:36', '4', ''),
(56, 21, 'minhkhoi1999@yahoo.com.vn', 'lê minh khôi', 'facebook ', '2020-11-23 11:46:02', '1', ''),
(57, 21, 'nhox_giahuy_2001@zing.vn', 'gia huy', 'facebook ', '2020-11-23 14:13:58', '1', ''),
(58, 21, 'nieptbn@gmail.com', 'pham bao ngoc', 'facebook ', '2020-11-23 20:37:26', '1', ''),
(59, 22, 'doremon_meou224@yahoo.com.vn', 'quang nhựt', 'facebook ', '2020-11-25 17:58:59', '1', ''),
(60, 22, 'phamngan5329@gmail.com', 'phạm ngânn', 'facebook ', '2020-11-27 19:30:30', '1', ''),
(61, 22, 'minhtaibui789@gmail.com', 'minh tai', 'facebook ', '2020-11-28 19:12:45', '3', ''),
(62, 22, 'aritahuang99@gmail.com', 'hoàng trâm', 'facebook ', '2020-11-29 16:34:47', '1', ''),
(63, 22, 'ducsang060597@gmail.com', 'pi phố núi', 'facebook ', '2020-11-29 19:41:57', '1', ''),
(64, 21, 'khianchuoi1412@yahoo.com', 'thiên vũ', 'facebook ', '2020-11-24 14:02:38', '1', ''),
(65, 21, 'vuongtrang2884@yahoo.com.vn', 'chau lu hong trang', 'facebook ', '2020-11-24 19:10:48', '1', ''),
(66, 21, 'hvminhphat57200@gmail.com', 'hứa vũ minh phát', 'facebook ', '2020-11-26 18:31:04', '1', ''),
(67, 21, 'junekdao2306@gmail.com', 'qui Đào', 'facebook ', '2020-11-26 18:51:34', '1', ''),
(68, 21, 'legiatam41@yahoo.com.vn', 'thái cực', 'facebook ', '2020-11-27 16:06:47', '1', ''),
(69, 21, 'thienthangiabang_mailaem@yahoo.com', 'bích ly', 'facebook ', '2020-11-27 18:06:14', '1', ''),
(70, 21, 'nlquanghan@yahoo.com.vn', 'quang hân', 'facebook ', '2020-11-27 18:56:30', '1', ''),
(71, 21, 'phamngan5329@gmail.com', 'phạm ngânn', 'facebook ', '2020-11-27 19:25:16', '1', ''),
(72, 21, 'hieunhocon@gmail.com', 'hiếu nhỏ', 'facebook ', '2020-11-27 23:06:32', '1', ''),
(73, 21, 'banhbo_tt@yahoo.com', 'chau hoan dong', 'facebook ', '2020-11-28 11:23:24', '1', ''),
(74, 21, 'hungdk71@gmail.com', 'hung nguyenmanh', 'facebook ', '2020-11-28 12:25:10', '1', ''),
(75, 21, 'brucetuyen3@gmail.com', 'phan thượng tuyên', 'facebook ', '2020-11-28 17:39:57', '1', ''),
(76, 21, 'khoinhi57@yahoo.com.vn', 'mỹ trang trịnh', 'facebook ', '2020-11-28 19:32:37', '1', ''),
(77, 21, 'nqat.ji@gmail.com', 'nguyễn thư', 'facebook ', '2020-11-28 20:56:20', '1', ''),
(78, 21, 'quangnhan1411@gmail.com', 'quang nhan', 'facebook ', '2020-11-29 10:27:11', '1', ''),
(79, 21, 'caolinh19755@gmail.com', 'cao nam', 'facebook ', '2020-11-29 13:58:37', '2', ''),
(80, 21, 'maiphong796@yahoo.com.vn', 'hoa lam', 'facebook ', '2020-11-29 17:19:27', '2', ''),
(81, 21, 'zave.xenon69@gmail.com', 'chu tiến Đạt', 'facebook ', '2020-11-29 19:48:55', '1', ''),
(82, 21, 'nmgiang284@gmail.com', 'giang nguyễn', 'facebook ', '2020-11-29 20:44:35', '1', ''),
(83, 21, 'hohoangduchuy2k7@gmail.com', 'hồ hoàng Đức huy', 'facebook ', '2020-11-29 21:35:47', '1', ''),
(84, 21, 'thuchauh@yahoo.com', 'anh thư', 'facebook ', '2020-12-01 08:03:12', '1', ''),
(85, 21, 'nghoanglong110@gmail.com', 'long hoang', 'facebook ', '2020-12-01 18:18:46', '1', ''),
(86, 21, 'tanvannhutien@yahoo.com', 'van dao', 'facebook ', '2020-12-01 18:45:12', '1', ''),
(87, 21, 'nguyenkhanhhao69@gmail.com', 'nguyen khánh hao', 'facebook ', '2020-12-02 13:55:28', '2', ''),
(88, 22, 'andithecrizzle01@icloud.com', 'barry barnes', 'facebook ', '2020-12-01 02:33:54', '1', ''),
(89, 22, 'menquehuong@yahoo.com.vn', 'lãng phong', 'facebook ', '2020-12-02 18:39:42', '1', ''),
(90, 21, 'ducthiennguyen789@gmail.com', 'nguyễn Đức thiện', 'facebook ', '2020-12-02 23:17:31', '1', ''),
(91, 22, 'doanhtv158@gmail.com', 'doanh trần', 'facebook ', '2020-12-03 07:36:45', '1', ''),
(92, 22, 'danglaanhhoa3@gmail.com', 'nguyễn hóa', 'facebook ', '2020-12-03 16:48:49', '1', ''),
(93, 22, 'we00048735@yahoo.com', 'hải dương', 'facebook ', '2020-12-03 20:41:39', '1', ''),
(94, 22, 'phpt_0504@yahoo.com.vn', 'trinh phan', 'facebook ', '2020-12-04 06:45:27', '1', ''),
(95, 22, 'keohongmcc@gmail.com', 'julie truong', 'facebook ', '2020-12-04 22:11:20', '1', ''),
(96, 22, 'trinhlinhk@gmail.com', 'linh linh', 'facebook ', '2020-12-05 15:07:23', '1', ''),
(97, 22, 'ducthiennguyen789@gmail.com', 'nguyễn Đức thiện', 'facebook ', '2020-12-06 19:09:49', '3', ''),
(98, 22, 'huynhkhanh9696@gmail.com', 'huỳnh khánh', 'facebook ', '2020-12-07 22:32:11', '1', ''),
(99, 22, '0948231915', '2020-12-07 15:47:07', '8a:6f:78:3f:78:40', '', '', ''),
(100, 22, '0963833958', '2020-12-08 10:43:31', 'd6:bb:54:b4:ec:28', '', '', ''),
(101, 22, '0945327161', '2020-12-08 21:32:41', 'e2:51:46:28:29:78', '', '', ''),
(102, 22, '0586340738', '2020-12-08 21:42:44', '96:de:85:4d:3e:34', '', '', ''),
(103, 21, 'lamvugemini@gmail.com', 'vũ lâm', 'facebook ', '2020-12-04 18:49:55', '1', ''),
(104, 21, 'haonguyengl123@gmail.com', 'hảo nguyễn', 'facebook ', '2020-12-04 19:09:51', '1', ''),
(105, 21, 'vuongelnino@gmail.com', 'vương gờ', 'facebook ', '2020-12-05 16:54:46', '1', ''),
(106, 21, 'ngochanh_tp@yahoo.com.vn', 'ngọc hạnh', 'facebook ', '2020-12-05 20:06:29', '1', ''),
(107, 21, 'daovugiahoa0966@gmail.com', 'Đào vũ gia hòa', 'facebook ', '2020-12-06 19:31:27', '1', ''),
(108, 21, '09018666890', '2020-12-07 12:28:54', 'c4:ad:34:30:a1:e4', '', '', ''),
(109, 21, '0983393879', '2020-12-07 17:47:14', '00:cd:fe:14:17:19', '', '', ''),
(110, 21, '0703283049', '2020-12-07 18:39:08', 'c4:ab:b2:58:ac:c6', '', '', ''),
(111, 21, '0366402044', '2020-12-07 19:01:46', '32:49:15:57:f7:b2', '', '', ''),
(112, 21, '0944683939', '2020-12-07 19:03:14', '96:e7:f7:a2:5a:99', '', '', ''),
(113, 21, '0902123125', '2020-12-07 22:12:26', 'a2:02:55:1a:ba:92', '', '', ''),
(114, 21, '0382859945', '2020-12-08 09:26:58', 'd0:28:ba:f5:68:61', '', '', ''),
(115, 21, '0901866689', '2020-12-08 09:42:35', 'ae:3a:ad:8d:4d:4b', '', '', ''),
(116, 21, '0901866698', '2020-12-08 10:22:07', '90:78:41:ef:4d:cc', '', '', ''),
(117, 21, '0939534788', '2020-12-08 10:30:04', '5e:f3:71:ff:bc:e7', '', '', ''),
(118, 22, 'kimngoc.210109@gmail.com', 'kim ngân', 'facebook ', '2020-12-09 22:55:07', '1', ''),
(119, 22, '0906085915', '2020-12-09 13:08:58', '1c:cc:d6:14:a6:b5', '', '', ''),
(120, 22, '0378518808', '2020-12-11 18:00:41', '8c:f5:a3:37:40:07', '', '', ''),
(121, 22, '0909038428', '2020-12-12 21:41:14', '78:4b:87:cf:74:32', '', '', ''),
(122, 22, '0903747966', '2020-12-12 23:05:50', '40:9c:28:9c:bc:57', '', '', ''),
(123, 22, '0918882759', '2020-12-13 10:45:55', 'd4:61:9d:a1:40:a3', '', '', ''),
(124, 22, '0908969282', '2020-12-14 15:45:46', '9e:7c:b7:57:7d:ed', '', '', ''),
(125, 22, '0948231916', '2020-12-16 15:48:53', '8a:6f:78:3f:78:40', '', '', ''),
(126, 22, '0933747966', '2020-12-17 01:53:13', '66:77:0e:eb:fa:6a', '', '', ''),
(127, 22, 'hiennhi971@gmail.com', 'linh hiền', 'facebook ', '2020-12-18 07:51:38', '1', ''),
(128, 22, 'khanhnhuhale@gmail.com', 'hà khánh như', 'facebook ', '2020-12-18 23:02:55', '1', ''),
(129, 22, 'ancoi.b2f@gmail.com', 'cao thanh an', 'facebook ', '2020-12-19 00:17:34', '1', ''),
(130, 21, '0969272727', '2020-12-08 11:53:55', 'a8:db:03:30:0f:63', '', '', ''),
(131, 21, '0913855734', '2020-12-08 15:28:53', '26:d8:27:b5:92:4c', '', '', ''),
(132, 21, '0898992905', '2020-12-08 15:48:41', 'ea:e0:7b:9a:ae:27', '', '', ''),
(133, 21, '0915525530', '2020-12-08 18:13:01', 'f8:38:80:ea:b6:20', '', '', ''),
(134, 21, '0986423113', '2020-12-08 18:55:49', '46:d2:5d:38:1f:ee', '', '', ''),
(135, 21, '0943793565', '2020-12-09 08:26:18', 'ca:d3:e8:3a:b3:0d', '', '', ''),
(136, 21, '0764989277', '2020-12-09 10:17:28', '20:31:1c:fe:c4:81', '', '', ''),
(137, 21, '0909025559', '2020-12-09 18:13:04', 'de:d9:86:e6:41:a8', '', '', ''),
(138, 21, '0395000161', '2020-12-09 20:30:08', '72:8d:c4:58:c2:ab', '', '', ''),
(139, 21, '0933649464', '2020-12-10 17:32:10', '26:59:d1:58:bd:60', '', '', ''),
(140, 21, '0923016359', '2020-12-10 17:55:02', '30:07:4d:15:f8:51', '', '', ''),
(141, 21, '0334205628', '2020-12-10 20:39:22', '04:db:56:2a:4e:8c', '', '', ''),
(142, 21, '0923309502', '2020-12-11 12:17:25', 'ec:51:bc:c6:f1:93', '', '', ''),
(143, 21, '0937414625', '2020-12-11 18:14:26', 'f8:e9:4e:0a:9e:46', '', '', ''),
(144, 21, '0978440910', '2020-12-11 19:45:48', '9c:64:8b:2a:19:70', '', '', ''),
(145, 21, '0789402625', '2020-12-12 04:10:06', '9c:5f:5a:f0:3f:41', '', '', ''),
(146, 21, '0931851958', '2020-12-12 09:28:41', '24:92:0e:c5:61:3c', '', '', ''),
(147, 21, '09678976541', '2020-12-12 10:01:59', 'ca:6c:bf:cd:07:b0', '', '', ''),
(148, 21, '0789560082', '2020-12-12 14:44:48', '68:db:ca:38:82:5f', '', '', ''),
(149, 21, '0909212272', '2020-12-12 17:57:31', '42:68:71:b4:17:54', '', '', ''),
(150, 21, '0399988763', '2020-12-12 18:07:59', 'ea:fa:42:60:92:11', '', '', ''),
(151, 21, '0903444406', '2020-12-12 18:25:26', 'd6:35:79:22:ce:84', '', '', ''),
(152, 21, '0903879799', '2020-12-12 18:26:19', '8c:f5:a3:fe:89:09', '', '', ''),
(153, 21, '0925418689', '2020-12-12 18:32:59', '72:68:f7:10:86:ea', '', '', ''),
(154, 21, '0937373945', '2020-12-13 16:37:43', '64:a5:c3:d4:05:71', '', '', ''),
(155, 21, '0909308906', '2020-12-13 17:50:35', 'bc:9f:ef:52:4c:7f', '', '', ''),
(156, 21, '0963833958', '2020-12-13 17:58:50', '86:f2:cd:13:60:ee', '', '', ''),
(157, 21, '0918409183', '2020-12-13 19:31:14', 'da:ba:99:6a:42:81', '', '', ''),
(158, 21, '0965927240', '2020-12-15 07:15:36', 'd8:5b:2a:ab:64:41', '', '', ''),
(159, 21, '0938280943', '2020-12-15 08:17:10', '08:78:08:be:0e:b0', '', '', ''),
(160, 21, '0972621185', '2020-12-15 12:25:22', '7a:c4:4c:80:e7:bb', '', '', ''),
(161, 21, '0917844760', '2020-12-15 15:44:55', '12:1c:58:5c:fa:58', '', '', ''),
(162, 21, '0908406086', '2020-12-16 19:11:28', 'ea:fa:4f:57:17:eb', '', '', ''),
(163, 21, '0976288007', '2020-12-17 11:43:10', '2e:c3:2d:04:75:89', '', '', ''),
(164, 21, '0708231405', '2020-12-17 13:02:41', '5e:3c:97:39:d7:d5', '', '', ''),
(165, 21, '0932204560', '2020-12-17 13:14:07', '96:2c:ad:ec:aa:e4', '', '', ''),
(166, 21, '0911755268', '2020-12-17 17:27:42', '5e:07:3b:8d:ec:90', '', '', ''),
(167, 21, '0946353226', '2020-12-17 17:31:37', 'aa:7b:f7:15:e6:12', '', '', ''),
(168, 21, '0963858817', '2020-12-17 17:56:56', '88:b2:91:a2:1b:7f', '', '', ''),
(169, 21, '0769256247', '2020-12-17 19:04:43', '7e:19:15:d9:30:b6', '', '', ''),
(170, 21, '0373279339', '2020-12-18 12:14:26', '2a:b3:8d:7a:44:cb', '', '', ''),
(171, 21, '0907440964', '2020-12-18 18:05:54', '0e:bc:d7:9e:e4:81', '', '', ''),
(172, 21, '0908691662', '2020-12-18 18:48:04', '6e:c4:37:03:b4:80', '', '', ''),
(173, 21, '0384166492', '2020-12-18 18:52:45', '76:88:72:7a:f7:4a', '', '', ''),
(174, 21, '0377431095', '2020-12-19 06:53:57', '02:d0:66:95:c6:0a', '', '', ''),
(175, 21, '0962475790', '2020-12-19 10:36:21', 'b2:e0:c3:4f:5e:35', '', '', ''),
(176, 21, '0901806604', '2020-12-19 15:44:36', '00:b5:d0:d9:98:8d', '', '', ''),
(177, 21, '0938588368', '2020-12-19 19:04:24', '60:f4:45:60:c0:95', '', '', ''),
(178, 21, '0906845178', '2020-12-19 19:31:06', '96:0f:aa:0a:83:ef', '', '', ''),
(179, 21, '0376336691', '2020-12-19 20:25:55', '36:64:bf:2b:64:0b', '', '', ''),
(180, 21, '0977727255', '2020-12-19 20:37:40', '2c:33:61:90:82:2e', '', '', ''),
(181, 21, '0913747747', '2020-12-19 22:22:25', '58:85:e9:2e:e6:d5', '', '', ''),
(182, 21, '0902911879', '2020-12-20 06:05:25', 'f0:76:6f:8e:86:c1', '', '', ''),
(183, 21, '0783830129', '2020-12-20 06:39:13', '04:f1:28:30:30:16', '', '', ''),
(184, 21, '0397342499', '2020-12-20 10:15:04', '8a:3c:1a:9a:3a:8b', '', '', ''),
(185, 21, '0903900104', '2020-12-20 10:16:08', '3e:67:35:65:12:60', '', '', ''),
(186, 21, '0778982181', '2020-12-20 14:14:43', '62:c6:bc:bc:f5:7b', '', '', ''),
(187, 21, '0941010301', '2020-12-20 16:07:04', 'b6:18:28:04:ed:96', '', '', ''),
(188, 21, '0982736152', '2020-12-20 16:59:31', 'c2:81:0c:7f:24:c5', '', '', ''),
(189, 21, '0938347321', '2020-12-20 17:24:15', '62:8f:9f:cf:3d:7a', '', '', ''),
(190, 21, '0898349705', '2020-12-20 17:43:38', '32:de:c3:a1:e8:7d', '', '', ''),
(191, 21, '0909491288', '2020-12-20 17:46:12', 'd8:1d:72:89:b2:7c', '', '', ''),
(192, 21, '0913855634', '2020-12-20 17:47:50', '26:d8:27:b5:92:4c', '', '', ''),
(193, 21, '0777766882', '2020-12-20 17:55:56', '7a:be:06:92:6d:5f', '', '', ''),
(194, 21, '0834450609', '2020-12-20 18:58:10', '0a:84:36:f4:ce:ba', '', '', ''),
(195, 21, '0379465746', '2020-12-20 20:04:40', 'f6:4b:56:71:e8:3f', '', '', ''),
(196, 21, '0912033093', '2020-12-20 20:25:38', 'ce:b8:4f:aa:ba:08', '', '', ''),
(197, 21, '0763265189', '2020-12-20 20:31:43', '9e:19:1b:0a:a2:83', '', '', ''),
(198, 21, '0985943979', '2020-12-20 20:34:05', '16:af:f6:b4:87:3e', '', '', ''),
(199, 21, '0902420326', '2020-12-20 20:59:21', '6a:f3:73:06:6d:fd', '', '', ''),
(200, 21, 'buithithaophuong9799@gmail.com', 'bui thao phuong', 'facebook ', '2020-12-10 20:23:12', '1', ''),
(201, 21, 'nghi.s097171@ilamail.edu.vn', 'pạnchi trongsoángg', 'facebook ', '2020-12-11 18:35:54', '1', ''),
(202, 21, 'congtran459@gmail.com', 'công trần', 'facebook ', '2020-12-12 13:56:38', '1', ''),
(203, 21, 'pucca281@yahoo.com.vn', 'ngoc to', 'facebook ', '2020-12-13 14:40:05', '1', ''),
(204, 21, 'louisduy9999@gmail.com', 'duy trần', 'facebook ', '2020-12-14 23:30:12', '1', ''),
(205, 21, 'datcho0905@gmail.com', 'phuc dat', 'facebook ', '2020-12-17 09:47:32', '1', ''),
(206, 21, 'xiunho23052002@gmail.com', 'quynh trang', 'facebook ', '2020-12-17 15:30:54', '1', ''),
(207, 21, 'pengokpengo_iuchiminhanh@yahoo.com.vn', 'lưu nguyệt', 'facebook ', '2020-12-17 22:06:14', '1', ''),
(208, 21, 'lyhoanganhthu3006@gmail.com', 'lý hoàng anh thư', 'facebook ', '2020-12-17 23:33:02', '1', ''),
(209, 21, 'fuxennomy99@gmail.com', 'sin sin', 'facebook ', '2020-12-19 20:13:38', '1', ''),
(210, 21, 'dsword1708@gmail.com', 'tommy tom', 'facebook ', '2020-12-19 22:22:58', '1', ''),
(211, 21, 'congminh284@yahoo.com.vn', 'tạ công minh', 'facebook ', '2020-12-20 08:17:43', '1', ''),
(212, 21, 'longrylai@gmail.com', 'nguyễn long', 'facebook ', '2020-12-20 10:46:33', '1', ''),
(213, 21, 'drdaoduytuong@gmail.com', 'duy tường', 'facebook ', '2020-12-20 17:27:48', '1', ''),
(214, 21, 'nhanzzzxxx@gmail.com', 'nguyễn trọng nhân', 'facebook ', '2020-12-20 18:55:08', '1', ''),
(215, 22, '0379110835', '2020-12-17 22:10:13', '4e:3a:3f:e4:74:63', '', '', ''),
(216, 22, '0398343845', '2020-12-18 09:44:36', '86:6e:3f:1b:a7:94', '', '', ''),
(217, 22, '0378730705', '2020-12-18 17:09:19', '7c:6b:9c:40:ae:a3', '', '', ''),
(218, 22, '0708690906', '2020-12-19 08:17:39', '9c:f4:8e:f0:44:39', '', '', ''),
(219, 22, '0902711132', '2020-12-19 16:00:06', '40:98:ad:8b:eb:98', '', '', ''),
(220, 22, '0907417747', '2020-12-19 18:11:42', 'da:66:4e:73:f7:a8', '', '', ''),
(221, 22, '0961623769', '2020-12-19 21:05:50', 'ee:d1:f7:53:88:c4', '', '', ''),
(222, 22, '0961344766', '2020-12-19 23:14:18', 'ce:35:6e:db:23:dc', '', '', ''),
(223, 22, '0907112266', '2020-12-19 23:52:17', '7c:a1:ae:4a:72:7c', '', '', ''),
(224, 22, '0902532783', '2020-12-20 07:43:42', '66:0a:0a:55:b2:76', '', '', ''),
(225, 22, '0866424024', '2020-12-20 07:52:24', '7c:a1:ae:7b:e2:fa', '', '', ''),
(226, 22, '0983995986', '2020-12-20 18:53:08', '0e:0b:ad:74:fb:50', '', '', ''),
(227, 22, '0938860116', '2020-12-20 19:46:48', 'c6:99:0d:b9:9e:0b', '', '', ''),
(228, 22, '0962970010', '2020-12-20 21:33:34', '1a:54:5c:c4:5f:0d', '', '', ''),
(229, 21, 'pepun_pekhok_khinhoxradyk@yahoo.com.vn', 'hồng nhungg', 'facebook ', '2020-12-21 19:21:17', '1', ''),
(230, 21, 'nkhoang90@gmail.com', 'may man nguyen', 'facebook ', '2020-12-21 23:24:44', '1', ''),
(231, 21, 'ly.2610@yahoo.com.vn', 'ly Đặng', 'facebook ', '2020-12-23 19:04:38', '1', ''),
(232, 21, 'tminh79678@gmail.com', 'tuyết minh', 'facebook ', '2020-12-24 18:19:46', '1', ''),
(233, 21, 'k6wdeanna@hotmail.com', 'hoàng khải', 'facebook ', '2020-12-24 19:48:40', '1', ''),
(234, 21, 'eglantine3103@yahoo.com', 'trí bùi', 'facebook ', '2020-12-25 09:22:03', '3', ''),
(235, 21, 'nhungocnk20@yahoo.com.vn', 'như ngọc', 'facebook ', '2020-12-25 18:21:03', '1', ''),
(236, 21, 'taihuaixiang@gmail.com', 'jasmine hht', 'facebook ', '2020-12-26 11:56:18', '1', ''),
(237, 21, 'phamvongochuyen13@gmail.com', 'ngọc huyền', 'facebook ', '2020-12-27 17:52:45', '1', ''),
(238, 21, 'luongnguyen7587@yahoo.com', 'mark luong', 'facebook ', '2020-12-27 19:08:52', '1', ''),
(239, 21, 'love_love_love104916@yahoo.com', 'thùy duyên', 'facebook ', '2020-12-27 19:51:19', '1', ''),
(240, 21, 'ngoctuyet_clud@yahoo.com', 'hương nguyễn', 'facebook ', '2020-12-29 17:40:30', '4', ''),
(241, 21, 'lilypham51@yahoo.com', 'mỹ phụng', 'facebook ', '2020-12-29 20:14:33', '2', ''),
(242, 21, 'thtam_lth@yahoo.com.vn', 'tâm lê', 'facebook ', '2020-12-30 21:19:03', '1', ''),
(243, 21, 'pvh19041981@gmail.com', 'nhật trường', 'facebook ', '2020-12-31 22:42:15', '1', ''),
(244, 21, 'boo_0903@yahoo.com.vn', 'trương nguyễn', 'facebook ', '2021-01-01 09:09:27', '1', ''),
(245, 21, 'meobonmat92@yahoo.com', 'võ ngọc loan', 'facebook ', '2021-01-01 09:17:45', '1', ''),
(246, 21, 'lnam61886@gmail.com', 'lê nam', 'facebook ', '2021-01-01 11:23:58', '1', ''),
(247, 21, 'tanhien1357@gmail.com', 'nguyen tan hien', 'facebook ', '2021-01-01 13:59:18', '1', ''),
(248, 21, 'anger_june@yahoo.com.vn', 'hoàng trinh', 'facebook ', '2021-01-01 18:00:53', '2', ''),
(249, 21, 'nnxtam@outlook.com', 'tam nguyen nx', 'facebook ', '2021-01-01 19:06:20', '1', ''),
(250, 21, 'jinjuly528@gmail.com', 'bảo huỳnh', 'facebook ', '2021-01-01 21:02:29', '1', ''),
(251, 21, 'ky_duyensaigon@yahoo.com', 'duyen ky', 'facebook ', '2021-01-03 12:11:37', '2', ''),
(252, 21, 'nguyenquanghuy121297@gmail.com', 'nguyễn quang huy', 'facebook ', '2021-01-04 00:17:19', '1', ''),
(253, 21, 'nguyenthanhthyyy@gmail.com', 'nguyễn thanh thy', 'facebook ', '2021-01-04 11:18:49', '2', ''),
(254, 21, 'vulaivlog@gmail.com', 'vũ lai', 'facebook ', '2021-01-04 20:11:57', '1', ''),
(255, 21, 'thuanaccclone@gmail.com', 'nguyễn thuận', 'facebook ', '2021-01-05 15:49:10', '1', ''),
(256, 21, 'thaovylenguyen88@gmail.com', 'thao vy le nguyen', 'facebook ', '2021-01-05 17:37:23', '1', ''),
(257, 21, 'toan240772@yahoo.com', 'võ minh toàn', 'facebook ', '2021-01-05 19:46:21', '1', ''),
(258, 21, '0934128242', '2020-12-21 09:48:35', '76:82:04:d8:7c:cd', '', '', ''),
(259, 21, '0938589257', '2020-12-21 15:17:10', 'ba:03:dd:c5:56:52', '', '', ''),
(260, 21, '0903093423', '2020-12-21 19:07:05', '06:6a:fe:05:77:3c', '', '', ''),
(261, 21, '0901841207', '2020-12-21 19:18:07', '5a:30:b2:e3:2f:a9', '', '', ''),
(262, 21, '0907412422', '2020-12-21 21:13:00', '22:32:af:a9:87:25', '', '', ''),
(263, 21, '0946993979', '2020-12-22 01:49:25', '9e:4d:08:86:94:4e', '', '', ''),
(264, 21, '0932699177', '2020-12-22 02:04:25', '2a:1a:91:b8:10:c4', '', '', ''),
(265, 21, '0908537557', '2020-12-22 10:23:09', '44:00:10:4d:9a:ac', '', '', ''),
(266, 21, '0903789576', '2020-12-22 12:57:44', '0e:35:87:6c:5f:5f', '', '', ''),
(267, 21, '0899331310', '2020-12-22 15:34:48', '56:cb:b4:c5:33:33', '', '', ''),
(268, 21, '0909757385', '2020-12-22 18:08:42', 'b8:d7:af:a1:3a:7d', '', '', ''),
(269, 21, '0397888739', '2020-12-22 18:09:11', 'aa:1a:9d:5a:9f:96', '', '', ''),
(270, 21, '0966437028', '2020-12-22 18:15:11', '3e:17:8d:b4:7d:58', '', '', ''),
(271, 21, '0904513834', '2020-12-22 18:26:48', 'b2:04:a5:b7:0c:10', '', '', ''),
(272, 21, '0903387666', '2020-12-22 18:28:56', 'ea:3d:0a:b0:96:b0', '', '', ''),
(273, 21, '0989661609', '2020-12-22 18:40:10', '2e:d2:6b:7c:e3:be', '', '', ''),
(274, 21, '0979150673', '2020-12-22 18:58:52', '52:5c:3c:e6:f2:2b', '', '', ''),
(275, 21, '0937654191', '2020-12-22 20:11:19', '84:ad:8d:9a:28:e7', '', '', ''),
(276, 21, '0908021377', '2020-12-22 20:29:31', '88:b2:91:93:22:94', '', '', ''),
(277, 21, '0903657966', '2020-12-22 20:30:54', 'b0:19:c6:23:8b:2f', '', '', ''),
(278, 21, '0942630333', '2020-12-22 20:40:17', 'f8:62:14:59:f1:1d', '', '', ''),
(279, 21, '0903740997', '2020-12-23 09:12:14', '0a:43:3d:6f:fd:02', '', '', ''),
(280, 21, '0931291812', '2020-12-23 09:41:01', '98:f6:21:c4:12:ef', '', '', ''),
(281, 21, '0903679937', '2020-12-23 11:45:33', 'ac:5f:3e:52:30:9b', '', '', ''),
(282, 21, '0968851505', '2020-12-23 17:29:54', '22:16:da:55:e6:a8', '', '', ''),
(283, 21, '0903125530', '2020-12-23 18:17:28', '54:33:cb:9d:92:71', '', '', ''),
(284, 21, '0767307932', '2020-12-23 18:36:17', 'd8:bb:2c:27:01:09', '', '', ''),
(285, 21, '0989040603', '2020-12-23 18:51:20', 'd6:fb:dc:aa:1c:0f', '', '', ''),
(286, 22, 'im.mrduy@gmail.com', 'tran quang duy', 'facebook ', '2020-12-21 07:58:36', '2', ''),
(287, 22, 'truc.saigontoday@gmail.com', 'truc le', 'facebook ', '2020-12-25 00:29:42', '1', ''),
(288, 22, 'ngoctuyet_clud@yahoo.com', 'hương nguyễn', 'facebook ', '2020-12-26 19:48:06', '2', ''),
(289, 22, 'dior.babie6789@gmail.com', 'dong nghi truong', 'facebook ', '2020-12-30 17:01:40', '1', ''),
(290, 22, '3qvui12h@gmail.com', 'mai thành Đạt', 'facebook ', '2020-12-31 16:38:15', '1', ''),
(291, 22, 'baotram090@gmail.com', 'bảo trâm', 'facebook ', '2021-01-01 08:57:03', '1', ''),
(292, 22, 'langdu1805@yahoo.com', 'duy tran', 'facebook ', '2021-01-01 10:00:27', '1', ''),
(293, 22, 'nct230193@gmail.com', 'công thành nguyễn', 'facebook ', '2021-01-01 23:39:00', '1', ''),
(294, 22, '0933625068', '2020-12-21 01:16:10', 'c2:db:90:5c:37:c2', '', '', ''),
(295, 22, '0947953615', '2020-12-21 19:47:33', 'ae:c2:d3:13:65:90', '', '', ''),
(296, 22, '0393564015', '2020-12-22 18:38:40', 'de:f5:0c:de:38:17', '', '', ''),
(297, 22, '0918424446', '2020-12-23 07:36:46', 'fe:71:49:4c:5b:50', '', '', ''),
(298, 22, '0393314241', '2020-12-23 15:19:32', 'fa:81:cf:a6:0a:be', '', '', ''),
(299, 22, '0393324241', '2020-12-23 19:31:32', '30:07:4d:58:1a:72', '', '', ''),
(300, 22, '0326212039', '2020-12-23 19:48:40', '86:f9:9e:7a:6f:b3', '', '', ''),
(301, 22, '0902791507', '2020-12-24 02:49:58', 'ca:15:ef:48:d1:83', '', '', ''),
(302, 22, '0901380927', '2020-12-24 20:45:24', 'e2:1c:a7:12:f1:57', '', '', ''),
(303, 22, '0937531361', '2020-12-26 15:06:30', '4c:74:bf:75:7a:a2', '', '', ''),
(304, 22, '0916979763', '2020-12-26 19:45:45', 'cc:25:ef:91:66:78', '', '', ''),
(305, 22, '0974039999', '2020-12-27 06:38:14', '36:8a:60:8c:b7:f8', '', '', ''),
(306, 22, '0931815559', '2020-12-27 07:48:41', 'da:ee:ad:37:e5:b6', '', '', ''),
(307, 22, '0396569699', '2020-12-27 08:44:10', 'd8:1d:72:82:b1:3a', '', '', ''),
(308, 22, '0972435801', '2020-12-27 09:55:17', '80:ed:2c:91:13:70', '', '', ''),
(309, 22, '0924260326', '2020-12-27 21:25:10', 'de:22:66:09:2b:e2', '', '', ''),
(310, 22, '0342676386', '2020-12-27 23:56:52', '76:ea:6f:74:5a:df', '', '', ''),
(311, 22, '0902914359', '2020-12-28 00:14:08', 'ea:d1:eb:1e:49:cb', '', '', ''),
(312, 22, '0913626569', '2020-12-29 06:45:26', 'da:26:e5:70:2f:aa', '', '', ''),
(313, 22, '0796838365', '2020-12-29 07:42:35', '26:f7:80:c2:92:06', '', '', ''),
(314, 22, '01289834179', '2020-12-29 20:02:21', 'ea:be:c4:3e:24:66', '', '', ''),
(315, 22, '0777618404', '2020-12-29 20:48:27', 'a6:6f:36:b7:bd:fe', '', '', ''),
(316, 22, '0909065589', '2020-12-30 06:28:03', '1e:db:b1:de:f8:4a', '', '', ''),
(317, 22, '0332763273', '2020-12-30 07:38:16', '82:56:da:1a:57:b5', '', '', ''),
(318, 22, '0349956016', '2020-12-30 18:22:21', '42:05:cd:ea:76:18', '', '', ''),
(319, 22, '0939810636', '2020-12-31 10:57:33', '42:b3:07:04:37:cc', '', '', ''),
(320, 22, '0793742845', '2020-12-31 22:55:22', '20:3c:ae:05:55:fd', '', '', ''),
(321, 22, '0582900358', '2021-01-01 01:41:32', '38:53:9c:a6:17:0c', '', '', ''),
(322, 22, '0913112426', '2021-01-01 12:07:09', '24:18:1d:b8:a2:75', '', '', ''),
(323, 22, '0776687692', '2021-01-01 12:46:54', 'b6:18:2c:72:03:3e', '', '', ''),
(324, 22, '0968983979', '2021-01-01 21:32:02', '04:d6:aa:55:1d:73', '', '', ''),
(325, 22, '0903735457', '2021-01-01 22:42:54', '62:cf:55:e2:f6:c2', '', '', ''),
(326, 22, '0978154168', '2021-01-02 01:23:53', 'fa:42:07:6e:d3:d0', '', '', ''),
(327, 22, '0925787899', '2021-01-02 01:46:17', 'f2:17:43:dc:23:84', '', '', ''),
(328, 22, '0905083456', '2021-01-02 07:58:02', '06:cf:fa:f4:36:fb', '', '', ''),
(329, 22, '0938500585', '2021-01-02 19:50:02', 'ce:15:ca:ad:7b:dd', '', '', ''),
(330, 22, '0979819968', '2021-01-02 22:37:37', '88:ae:07:b9:42:89', '', '', ''),
(331, 22, '0356627651', '2021-01-03 20:55:29', 'de:22:66:09:2b:e2', '', '', ''),
(332, 22, '0366402044', '2021-01-05 00:51:01', '02:1d:87:a4:88:76', '', '', ''),
(333, 22, '0696838365', '2021-01-05 07:52:59', '26:f7:80:c2:92:06', '', '', ''),
(334, 22, '0907268111', '2021-01-06 00:31:46', '0a:6c:0b:43:e4:4a', '', '', ''),
(335, 22, '0786842082', '2021-01-06 07:42:31', '00:d2:79:37:67:ee', '', '', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genco_project_setting`
--

CREATE TABLE `genco_project_setting` (
  `Id` int(11) NOT NULL,
  `Name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PId` int(11) NOT NULL,
  `Keyword` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `TextValues` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `UUID` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `genco_project_setting`
--

INSERT INTO `genco_project_setting` (`Id`, `Name`, `PId`, `Keyword`, `TextValues`, `UUID`) VALUES
(8, 'Pixel Facebook Code', 2, 'pixelfacebook', 'adasa', 'ef9202d4-821d-4e28-b1cd-3826d6722035'),
(7, 'Pixel Facebook Code', 1, 'pixelfacebook', ' <!-- Facebook Pixel Code -->\r\n<script>\r\n!function(f,b,e,v,n,t,s)\r\n{if(f.fbq)return;n=f.fbq=function(){n.callMethod?\r\nn.callMethod.apply(n,arguments):n.queue.push(arguments)};\r\nif(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version=\'2.0\';\r\nn.queue=[];t=b.createElement(e);t.async=!0;\r\nt.src=v;s=b.getElementsByTagName(e)[0];\r\ns.parentNode.insertBefore(t,s)}(window, document,\'script\',\r\n\'https://connect.facebook.net/en_US/fbevents.js\');\r\nfbq(\'init\', \'306128253841517\');\r\nfbq(\'track\', \'PageView\');\r\n</script>\r\n<noscript><img height=\"1\" width=\"1\" style=\"display:none\"\r\nsrc=\"https://www.facebook.com/tr?id=306128253841517&ev=PageView&noscript=1\"\r\n/></noscript>\r\n<!-- End Facebook Pixel Code -->', 'd722f269-b3fd-4852-9d97-9fce67baa3ca'),
(9, 'Pixel Facebook Code', 3, 'pixelfacebook', '', 'c0289a45-f652-4541-978a-98132589377e');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genco_project_users`
--

CREATE TABLE `genco_project_users` (
  `Id` int(11) NOT NULL,
  `PId` int(11) NOT NULL,
  `AdminId` int(11) DEFAULT NULL,
  `Active` tinyint(4) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `Note` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `genco_project_users`
--

INSERT INTO `genco_project_users` (`Id`, `PId`, `AdminId`, `Active`, `DateCreate`, `Note`) VALUES
(16, 1, 2, 1, '2020-08-08 13:19:19', '[]'),
(15, 1, 18, 1, '2020-08-08 13:19:00', '[]'),
(25, 1, 20, 1, '2020-11-19 11:23:01', '[]'),
(20, 1, 1, 1, '2020-08-09 10:07:50', '[]');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `genco_admin`
--
ALTER TABLE `genco_admin`
  ADD PRIMARY KEY (`Username`),
  ADD UNIQUE KEY `Id` (`Id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `genco_admin_groups`
--
ALTER TABLE `genco_admin_groups`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `genco_options`
--
ALTER TABLE `genco_options`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `genco_project`
--
ALTER TABLE `genco_project`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `genco_project_controller`
--
ALTER TABLE `genco_project_controller`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `UUID` (`UUID`);

--
-- Chỉ mục cho bảng `genco_project_controller_data`
--
ALTER TABLE `genco_project_controller_data`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `ControllerId` (`ControllerId`,`Col0`);

--
-- Chỉ mục cho bảng `genco_project_setting`
--
ALTER TABLE `genco_project_setting`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `UUID` (`UUID`),
  ADD UNIQUE KEY `PId` (`PId`,`Keyword`);

--
-- Chỉ mục cho bảng `genco_project_users`
--
ALTER TABLE `genco_project_users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `PIdAdminId` (`PId`,`AdminId`) USING BTREE;

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `genco_admin`
--
ALTER TABLE `genco_admin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `genco_admin_groups`
--
ALTER TABLE `genco_admin_groups`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `genco_options`
--
ALTER TABLE `genco_options`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `genco_project`
--
ALTER TABLE `genco_project`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `genco_project_controller`
--
ALTER TABLE `genco_project_controller`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `genco_project_controller_data`
--
ALTER TABLE `genco_project_controller_data`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=336;

--
-- AUTO_INCREMENT cho bảng `genco_project_setting`
--
ALTER TABLE `genco_project_setting`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `genco_project_users`
--
ALTER TABLE `genco_project_users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
