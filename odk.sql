-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2016 at 01:33 PM
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
-- Table structure for table `submitted_data`
--

CREATE TABLE IF NOT EXISTS `submitted_data` (
  `ik` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `year` varchar(6) NOT NULL,
  `month` int(2) NOT NULL,
  `day` int(2) NOT NULL,
  `created` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `submitted_data_content`
--

CREATE TABLE IF NOT EXISTS `submitted_data_content` (
  `ik` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `md5` varchar(32) NOT NULL,
  `r_url` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `submitted_data`
--
ALTER TABLE `submitted_data`
  ADD PRIMARY KEY (`ik`);

--
-- Indexes for table `submitted_data_content`
--
ALTER TABLE `submitted_data_content`
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
-- AUTO_INCREMENT for table `submitted_data`
--
ALTER TABLE `submitted_data`
  MODIFY `ik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `xforms`
--
ALTER TABLE `xforms`
  MODIFY `ik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
