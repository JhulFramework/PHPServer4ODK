-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 19, 2016 at 09:59 AM
-- Server version: 10.0.27-MariaDB
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odk`
--

-- --------------------------------------------------------

--
-- Table structure for table `submitted_forms`
--

CREATE TABLE IF NOT EXISTS `submitted_forms` (
  `ik` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `year` varchar(6) NOT NULL,
  `month` int(2) NOT NULL,
  `day` int(2) NOT NULL,
  `created` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `submitted_forms`
--

INSERT INTO `submitted_forms` (`ik`, `name`, `year`, `month`, `day`, `created`) VALUES
(4, 'Birds', '2016', 11, 11, '1478833387'),
(5, 'Birds', '2016', 11, 11, '1478836289');

-- --------------------------------------------------------

--
-- Table structure for table `submitted_forms_data`
--

CREATE TABLE IF NOT EXISTS `submitted_forms_data` (
  `ik` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `submitted_forms_data`
--

INSERT INTO `submitted_forms_data` (`ik`, `content`) VALUES
(4, 'a:6:{s:4:"name";s:6:"Pecock";s:11:"nationality";s:5:"Inidi";s:4:"temp";s:2:"56";s:8:"humidity";s:4:"high";s:4:"wind";s:4:"high";s:18:"repeat_observation";a:6:{s:7:"habitat";a:0:{}s:7:"observe";a:0:{}s:4:"bird";s:5:"eagle";s:8:"location";a:0:{}s:5:"image";a:0:{}s:5:"notes";a:0:{}}}'),
(5, 'a:6:{s:4:"name";s:6:"Fgfgfd";s:11:"nationality";s:5:"Fdgfd";s:4:"temp";a:0:{}s:8:"humidity";a:0:{}s:4:"wind";a:0:{}s:18:"repeat_observation";a:6:{s:7:"habitat";a:0:{}s:7:"observe";a:0:{}s:4:"bird";a:0:{}s:8:"location";a:0:{}s:5:"image";a:0:{}s:5:"notes";a:0:{}}}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ik` int(11) NOT NULL,
  `access` varchar(12) NOT NULL,
  `iname` varchar(15) NOT NULL,
  `password` varchar(99) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ik`, `access`, `iname`, `password`) VALUES
(1, 'DUF', 'odkadmin', 'Rk1MdWdzMjNlYzBlNmU3YTg4Y2ZlMzZiMjFkN2EzZDA3ZTUxNWExZmIxMTEyMTljMmU3Nzk2YTZlODE1YTk1NTNhZTcwOQ==');

-- --------------------------------------------------------

--
-- Table structure for table `xforms`
--

CREATE TABLE IF NOT EXISTS `xforms` (
  `ik` int(11) NOT NULL,
  `name` varchar(99) NOT NULL,
  `r_url` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `xforms`
--

INSERT INTO `xforms` (`ik`, `name`, `r_url`) VALUES
(7, 'Birds', 'uploads/xforms/Birds.xml'),
(13, 'Sample', 'uploads/xforms/Sample.xml');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `submitted_forms`
--
ALTER TABLE `submitted_forms`
  ADD PRIMARY KEY (`ik`);

--
-- Indexes for table `submitted_forms_data`
--
ALTER TABLE `submitted_forms_data`
  ADD PRIMARY KEY (`ik`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ik`);

--
-- Indexes for table `xforms`
--
ALTER TABLE `xforms`
  ADD PRIMARY KEY (`ik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `submitted_forms`
--
ALTER TABLE `submitted_forms`
  MODIFY `ik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `xforms`
--
ALTER TABLE `xforms`
  MODIFY `ik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
