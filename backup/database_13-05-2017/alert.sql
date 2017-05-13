-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2017 at 03:39 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newlanga`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert`
--

CREATE TABLE `alert` (
  `alert_id` int(11) NOT NULL,
  `nome_alert` varchar(255) NOT NULL COMMENT 'alert name',
  `tipo_alert` int(11) NOT NULL COMMENT 'alert type',
  `ente` varchar(255) NOT NULL COMMENT 'entity',
  `ruolo` varchar(30) NOT NULL COMMENT 'role',
  `messaggio` longtext NOT NULL COMMENT 'message',
  `is_sent` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alert`
--

INSERT INTO `alert` (`alert_id`, `nome_alert`, `tipo_alert`, `ente`, `ruolo`, `messaggio`, `is_sent`, `created_at`) VALUES
(1, 'new alert', 0, '0,12', '1,3', 'test\r\n', 1, '2017-05-01'),
(2, 'demo', 0, '0,12,14', '2,3', '', 0, '2017-05-05'),
(3, 'Today Alert', 1, '12,14', '2,3', 'Hi All.', 1, '2017-05-12'),
(4, 'Today Test', 5, '0,29', '1', 'Hello.', 1, '2017-05-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alert`
--
ALTER TABLE `alert`
  ADD PRIMARY KEY (`alert_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alert`
--
ALTER TABLE `alert`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
