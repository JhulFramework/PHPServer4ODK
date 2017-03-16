-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2017 at 09:04 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odk_aggregate`
--

-- --------------------------------------------------------

--
-- Table structure for table `odk_user`
--

CREATE TABLE `odk_user` (
  `user_key` int(11) NOT NULL,
  `access` varchar(12) NOT NULL,
  `iname` varchar(15) NOT NULL,
  `password` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `odk_user`
--

INSERT INTO `odk_user` (`user_key`, `access`, `iname`, `password`) VALUES
(1, 'DUF', 'odkadmin', 'odkadmin');

-- --------------------------------------------------------

--
-- Table structure for table `submitted_data`
--

CREATE TABLE `submitted_data` (
  `identity_key` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `year` varchar(6) NOT NULL,
  `month` int(2) NOT NULL,
  `day` int(2) NOT NULL,
  `created` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `submitted_data_content`
--

CREATE TABLE `submitted_data_content` (
  `data_key` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `xforms`
--

CREATE TABLE `xforms` (
  `xml_form_key` int(11) NOT NULL,
  `name` varchar(99) NOT NULL,
  `md5` varchar(32) NOT NULL,
  `r_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `odk_user`
--
ALTER TABLE `odk_user`
  ADD PRIMARY KEY (`user_key`);

--
-- Indexes for table `submitted_data`
--
ALTER TABLE `submitted_data`
  ADD PRIMARY KEY (`identity_key`);

--
-- Indexes for table `submitted_data_content`
--
ALTER TABLE `submitted_data_content`
  ADD PRIMARY KEY (`data_key`);

--
-- Indexes for table `xforms`
--
ALTER TABLE `xforms`
  ADD PRIMARY KEY (`xml_form_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `odk_user`
--
ALTER TABLE `odk_user`
  MODIFY `user_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `submitted_data`
--
ALTER TABLE `submitted_data`
  MODIFY `identity_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `xforms`
--
ALTER TABLE `xforms`
  MODIFY `xml_form_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
