-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2017 at 03:42 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easylanga`
--

-- --------------------------------------------------------

--
-- Table structure for table `link_profilo`
--

CREATE TABLE `link_profilo` (
  `id` mediumint(9) NOT NULL,
  `name` char(30) NOT NULL,
  `id_user` mediumint(9) NOT NULL,
  `image` char(150) NOT NULL,
  `url` char(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `link_profilo`
--

INSERT INTO `link_profilo` (`id`, `name`, `id_user`, `image`, `url`) VALUES
(1, 'Elenco Miei Enti', 2, '147501021657eadea8e81a6--profilo', 'enti/miei'),
(2, 'Test', 2, '147501025657eaded08d5e2--profilo', 'calendario/0'),
(16, ' PREVENTIVI (TUTTI)', 1, '147611904657fbca06ae1fa--profilo', 'http://easy.langa.tv/preventivi'),
(18, 'PROGETTI (TUTTI)', 1, '147611923557fbcac30f14d--profilo', 'http://easy.langa.tv/progetti'),
(17, 'ENTI (TUTTI)', 1, '147611917257fbca84d4222--profilo', 'http://easy.langa.tv/enti'),
(19, 'CALENDARIO', 17, '147611925457fbcad67edfc--profilo', 'http://easy.langa.tv/calendario/1'),
(24, 'STATISTICHE', 1, '147611933857fbcb2ab6f10--profilo', 'http://easy.langa.tv/statistiche/economiche'),
(23, 'ENTI', 17, '147611933057fbcb22e56c4--profilo', 'http://easy.langa.tv/enti'),
(14, 'CALENDARIO (TUTTI)', 1, '147611898357fbc9c73aee3--profilo', 'http://easy.langa.tv/calendario/1'),
(20, 'FATTURE', 1, '147611925757fbcad9b7ab7--profilo', 'http://easy.langa.tv/pagamenti/tranche/elenco'),
(22, 'PROGETTI', 17, '147611930957fbcb0d4387a--profilo', 'http://easy.langa.tv/progetti'),
(25, 'PREVENTIVI (MIEI)', 56, '147619039057fce0b62b195--profilo', 'http://easy.langa.tv/preventivi/miei'),
(26, 'CALENDARIO (TUTTI)', 56, '147619041257fce0cc2953a--profilo', 'http://easy.langa.tv/calendario/1'),
(27, 'ENTI (TUTTI)', 56, '147619043657fce0e4401ac--profilo', 'http://easy.langa.tv/enti'),
(28, 'ENTI (TUTTI)', 54, '147619050057fce124e958a--profilo', 'http://easy.langa.tv/enti'),
(29, 'CALENDARIO (TUTTI)', 54, '147619052157fce13906930--profilo', 'http://easy.langa.tv/calendario/1'),
(30, 'PREVENTIVI (MIEI)', 54, '147619055757fce15d389fb--profilo', 'http://easy.langa.tv/preventivi/miei'),
(31, 'ENTI (TUTTI)', 53, '147619063157fce1a796a42--profilo', 'http://easy.langa.tv/enti'),
(32, 'CALENDARIO (TUTTI)', 53, '147619064957fce1b971a07--profilo', 'http://easy.langa.tv/calendario/1'),
(33, 'PREVENTIVI (MIEI)', 53, '147619067257fce1d06880d--profilo', 'http://easy.langa.tv/preventivi/miei'),
(34, 'CALENDARIO (TUTTI)', 16, '1477292707580db2a3a139b--profilo', 'http://easy.langa.tv/calendario/1'),
(35, 'PROGETTI (MIEI)', 16, '1477292742580db2c65ffe3--profilo', 'http://easy.langa.tv/progetti/miei'),
(36, 'ENTI (TUTTI)', 16, '1477292760580db2d8bfc2a--profilo', 'http://easy.langa.tv/enti'),
(37, 'ENTI (TUTTI)', 0, '1477383703580f1617a9404--profilo', 'http://easy.langa.tv/enti'),
(38, 'CALENDARIO (TUTTI)', 0, '1477383721580f1629ad4d2--profilo', 'http://easy.langa.tv/calendario/1'),
(39, 'PREVENTIVI (TUTTI)', 0, '1477383736580f1638ee5dd--profilo', 'http://easy.langa.tv/preventivi'),
(40, 'PROGETTI (TUTTI)', 0, '1477383750580f1646e17b1--profilo', 'http://easy.langa.tv/progetti'),
(46, 'FATTURE (TUTTE)', 0, '1477384090580f179a37426--profilo', 'http://easy.langa.tv/pagamenti/tranche/elenco'),
(47, 'NEWSLETTER', 0, '1477384251580f183b2a895--profilo', 'http://easy.langa.tv/newsletter'),
(48, 'STATISTICHE', 0, '1477384267580f184b5e03c--profilo', 'http://easy.langa.tv/statistiche/economiche'),
(51, 'NEWSLETTER (CREAZIONE)', 0, '1477384365580f18ad971c0--profilo', 'http://easy.langa.tv/newsletter/add'),
(50, 'UTENTI (CREAZIONE)', 0, '1477384317580f187dda62a--profilo', 'http://easy.langa.tv/admin/utenti'),
(52, 'PACCHETTI (CREAZIONE)', 0, '1477395506580f443232b39--profilo', 'http://easy.langa.tv/admin/tassonomie/pacchetti/add'),
(53, 'OPTIONAL (CREAZIONE)', 0, '1477395521580f4441da6e6--profilo', 'http://easy.langa.tv/admin/tassonomie/optional/add'),
(54, 'SCONTI (CREAZIONE)', 0, '1477395538580f4452f2d78--profilo', 'http://easy.langa.tv/admin/tassonomie/sconti/add');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `link_profilo`
--
ALTER TABLE `link_profilo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `link_profilo`
--
ALTER TABLE `link_profilo`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
