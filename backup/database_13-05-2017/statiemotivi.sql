-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2017 at 08:12 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `easylanga_backup`
--

-- --------------------------------------------------------

--
-- Table structure for table `statiemotivi`
--

CREATE TABLE `statiemotivi` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_tipo` int(11) NOT NULL COMMENT 'id_type',
  `id_ente` int(11) NOT NULL COMMENT 'id_entity',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `statiemotivi`
--

INSERT INTO `statiemotivi` (`id`, `id_tipo`, `id_ente`, `created_at`, `updated_at`) VALUES
(59, 1, 1242, NULL, NULL),
(89, 7, 1238, NULL, NULL),
(100, 7, 682, NULL, NULL),
(213, 1, 1519, NULL, NULL),
(214, 8, 1256, NULL, NULL),
(216, 3, 1508, NULL, NULL),
(252, 6, 1258, NULL, NULL),
(261, 1, 1416, NULL, NULL),
(280, 6, 1403, NULL, NULL),
(292, 6, 307, NULL, NULL),
(295, 6, 444, NULL, NULL),
(296, 6, 1257, NULL, NULL),
(297, 6, 1260, NULL, NULL),
(299, 6, 1400, NULL, NULL),
(302, 6, 1255, NULL, NULL),
(305, 6, 1254, NULL, NULL),
(307, 6, 47, NULL, NULL),
(308, 6, 1398, NULL, NULL),
(309, 6, 1265, NULL, NULL),
(313, 1, 1522, NULL, NULL),
(314, 4, 1515, NULL, NULL),
(315, 4, 1525, NULL, NULL),
(317, 6, 1404, NULL, NULL),
(322, 6, 500, NULL, NULL),
(329, 6, 1241, NULL, NULL),
(331, 8, 1507, NULL, NULL),
(333, 6, 225, NULL, NULL),
(334, 6, 1267, NULL, NULL),
(335, 7, 1456, NULL, NULL),
(336, 4, 1574, NULL, NULL),
(337, 8, 1578, NULL, NULL),
(338, 6, 1402, NULL, NULL),
(342, 4, 1604, NULL, NULL),
(344, 4, 1599, NULL, NULL),
(346, 6, 1397, NULL, NULL),
(354, 4, 1613, NULL, NULL),
(358, 6, 253, NULL, NULL),
(359, 7, 104, NULL, NULL),
(361, 1, 0, NULL, NULL),
(363, 7, 11, NULL, NULL),
(367, 5, 1690, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `statiemotivi`
--
ALTER TABLE `statiemotivi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `statiemotivi`
--
ALTER TABLE `statiemotivi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=368;