-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2017 at 08:26 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `easylanga_backup`
--

-- --------------------------------------------------------

--
-- Table structure for table `clienti`
--

CREATE TABLE `clienti` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_ente` int(11) NOT NULL COMMENT 'id_body',
  `color` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#f37f0d',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cellulare` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clienti`
--

INSERT INTO `clienti` (`id`, `id_ente`, `color`, `name`, `cellulare`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(17, 1250, '#f37f0d', 'Tarasco Pier Paolo', '', 'tarasco1250@langa.tv', '$2y$10$W8GZKe.G8uUUJ0LasovGPuk4Bf/psrnfU70ptvMU/UA2DlyeMmm3.', 'zwoegHSXrzItNKfI80fMJfFzw5uE5pqUJZ7Yu8xWIc71KjUWN17yRveYmdmn', NULL, '2016-11-03 19:59:16'),
(18, 1267, '#f37f0d', 'Luca PRATA', '', 'info@langa.tv', '$2y$10$bDeguuRA4X.vMTXxEfQ6we5OnbzM99FobOV.vxwdL6gOrxwoOnoxm', 'BbYxhL1KPAHpYu7gbShzGxWEKQ5JPvxbXlYS2tL8T5nWFqRMx7zjNkdoTSdx', NULL, '2016-12-28 18:15:10'),
(23, 1560, '#f37f0d', 'Gerbaldo', '', 'g.gerbaldo@cedisingrosso.it', '$2y$10$W8GZKe.G8uUUJ0LasovGPuk4Bf/psrnfU70ptvMU/UA2DlyeMmm3.', 'rLBpOjDtCiFPHrXEyn4kwNOdb1ZodqgElYaeGyV8JdIXDXFkJyR0LxpAHutU', NULL, '2017-04-05 05:50:07'),
(24, 1571, '#f37f0d', 'Vaclav Hejda', '', 'contract@thermaeurope.com', '$2y$10$kE0C3hZqjU6coR.95x/H4eUsAd.Gm8lnyaEjMm587WUJ7Gip24IMO', 'EFyORWXtdYAqDK859R4XtQfU8ZwUxzxghY8wanwANy5T5WmmlO5bnViI3UzB', NULL, '2017-01-31 12:37:17'),
(25, 0, '#f37f0d', '', '', '', '', 'qMKxqeVRpPbUHriKPFRk2EhLzptT9wR1sFMfLv86FWzdfV4vP3efubJIAPPg', '2017-04-13 06:47:39', '2017-04-13 06:47:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_name_unique` (`name`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clienti`
--
ALTER TABLE `clienti`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;