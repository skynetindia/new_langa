-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2017 at 08:14 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `easylanga_backup`
--

-- --------------------------------------------------------

--
-- Table structure for table `costi`
--

CREATE TABLE `costi` (
  `id` mediumint(9) NOT NULL,
  `oggetto` char(100) NOT NULL COMMENT 'object',
  `costo` varchar(9) NOT NULL COMMENT 'cost',
  `datainserimento` varchar(30) NOT NULL COMMENT 'insertion date',
  `id_ente` mediumint(9) NOT NULL COMMENT 'id_body'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `costi`
--

INSERT INTO `costi` (`id`, `oggetto`, `costo`, `datainserimento`, `id_ente`) VALUES
(1752, 'DOMINIO + HOST', '-15', '01/07/2016', 1402),
(1342, 'DOMINIO + HOST', '-15', '01/07/2016', 1398),
(1319, 'DOMINIO + HOSTING CONDIVISO', '-15', '08/09/2015', 621),
(1868, 'test', '10', '02/04/2017', 1245),
(1784, 'DOMINIO + HOSTING', '-36', '24/10/2016', 1560),
(1328, 'DOMINIO + HOSTING CONDIVISO', '-15', '26/04/2016', 444),
(1352, 'TEMA - PRO Business - Responsive Multi-Purpose Theme', '-53', '25/06/2015', 290),
(1354, 'DOMINIO + HOSTING CONDIVISO', '-15', '29/10/2015', 290),
(1353, 'DOMINIO + HOSTING CONDIVISO', '-15', '27/11/2015', 290),
(1867, 'PLUGIN - SEO Icons - Animated SVG''s for WordPress', '9', '29/10/2015', 1245),
(1743, 'Swift Security Bundle - Hide WordPress, Firewall, Code Scanner', '-32', '31/08/2016', 1267),
(1737, 'PHP SCRIPTS - Project Box - Team Management Tool', '-40', '09/10/2015', 1267),
(1742, 'Row Scroll Animations for Visual Composer', '-12', '29/08/2016', 1267),
(1741, 'Creative Google Maps for Visual Composer', '-10', '29/08/2016', 1267),
(1740, 'TEMA - Adventure - Responsive Photography Theme', '-44', '19/07/2016', 1267),
(1739, 'TEMA - Salient - Responsive Multi-Purpose Theme', '-53', '16/04/2016', 1267),
(1738, 'Master - Onepage Portfolio Theme', '-40', '13/07/2015', 1267),
(1736, 'AFFITTO', '-500', '05/12/2015', 1267),
(1735, 'AFFITTO', '-500', '05/11/2015', 1267),
(1734, 'AFFITTO', '-500', '05/10/2016', 1267),
(1733, 'AFFITTO', '-500', '05/10/2015', 1267),
(1732, 'AFFITTO', '-500', '05/09/2016', 1267),
(1731, 'AFFITTO', '-500', '05/08/2016', 1267),
(1730, 'AFFITTO', '-500', '05/07/2016', 1267),
(1729, 'AFFITTO', '-500', '05/06/2016', 1267),
(1728, 'AFFITTO', '-500', '05/05/2016', 1267),
(1727, 'AFFITTO', '-500', '05/04/2016', 1267),
(1726, 'AFFITTO', '-500', '05/03/2016', 1267),
(1724, 'AFFITTO', '-500', '05/01/2016', 1267),
(1725, 'AFFITTO', '-500', '05/02/2016', 1267),
(1723, 'VARIO UFFICIO', '-5927', '01/12/2015', 1267),
(1722, 'VARIO UFFICIO', '-3092', '01/11/2015', 1267),
(1765, 'DOMINIO + HOST', '-15', '01/07/2016', 1397),
(1320, 'DOMINIO + HOSTING CONDIVISO', '-15', '11/11/2015', 621),
(1321, 'TEMA - Ronneby - High-Performance WordPress Theme', '-53', '14/09/2015', 621),
(1866, 'PLUGIN - Animatrix Icons - SVG Animated WordPress Plugin', '-16', '29/10/2015', 1245),
(1720, 'LUCE + TELEFONO', '-150', '01/09/2016', 1267),
(1314, 'VIDEO - Light Bulb Explosion Logo Reveal', '-15', '15/10/2015', 1246),
(1315, 'MUSIC - Violin Pack', '-20', '24/03/2016', 1246),
(1865, 'PLUGIN -  Isometric Image Tiles Shortcode for VC', '-10', '29/10/2015', 1245),
(1864, 'PLUGIN - Animatic - Advanced WordPress Frontend Animator', '-19', '29/10/2015', 1245),
(1862, 'PLUGIN - VC Coming Soon Pages', '-14', '23/11/2015', 1245),
(1863, 'PLUGIN - Wordpress Meta Data & Taxonomies Filter', '-25', '25/06/2015', 1245),
(1327, 'TEMA - Blessing | Funeral Home WordPress Theme', '-53', '25/11/2015', 444),
(1326, 'DOMINIO + HOSTING CONDIVISO', '-15', '24/11/2015', 444),
(1325, 'DOMINIO + HOSTING CONDIVISO', '-15', '11/12/2015', 444),
(1343, 'PLUGIN - Online Hotel Booking System Pro (WordPress Plugin)', '-35', '01/01/2016', 1265),
(1335, 'TEMA - Salon | Barbershop & Tatoo WordPress Theme', '-53', '21/01/2016', 622),
(1332, 'TEMA - Point Finder - Directory WordPress Theme', '-53', '25/01/2016', 1268),
(1331, 'DOMINIO + HOSTING PROFESSIONALE', '-150', '23/01/2016', 1268),
(1334, 'DOMINIO + HOSTING CONDIVISO', '-15', '18/01/2016', 622),
(1859, 'HTML5 - Dot Hunter', '-13', '18/02/2016', 1245),
(1338, 'DOMINIO + HOSTING CONDIVISO', '-15', '12/02/2016', 1254),
(1339, 'TEMA - Restaurant WordPress Theme | NEM', '-53', '15/02/2016', 1254),
(1861, 'PLUGIN - Bookly Booking Plugin – Responsive Appointment Booking and Scheduling', '-41', '20/02/2016', 1245),
(1860, 'EMAIL - Moka - Responsive Email and Newsletter Template', '-16', '19/02/2016', 1245),
(1858, 'PLUGIN - Go Pricing - WordPress Responsive Pricing Tables', '-22', '17/05/2016', 1245),
(1312, 'VIDEO - Licking Lips', '-12', '11/03/2016', 1246),
(1313, 'MUSIC - Deep Bass Logo', '-6', '15/10/2015', 1246),
(1311, 'EFFECT - TypoKing | Title Animation & Kinetic Typography Text', '-48', '11/03/2016', 1246),
(1721, 'VARIO UFFICIO', '-1086', '01/10/2015', 1267),
(1719, 'COSTO MATERIE PER CUCININO INTERNO', '-400', '01/09/2016', 1267),
(1856, 'PLUGIN - Visual Composer Extensions Addon All in One', '-16', '14/05/2016', 1245),
(1857, 'PLUGIN - Hero Menu - Responsive WordPress Mega Menu Plugin', '-17', '16/05/2016', 1245),
(1855, 'PLUGIN - Image & Video Device Mockups Shortcode', '-9', '14/05/2016', 1245),
(1854, 'PLUGIN -  360 Product & Panorama Rotation - Visual Composer Addon', '-11', '14/05/2016', 1245),
(1852, 'PLUGIN - Snap Social Network Auto-poster', '-150', '10/06/2015', 1245),
(1310, 'VIDEO - Safe Sex', '-12', '11/03/2016', 1246),
(1309, 'VIDEO - Around the World', '-25', '03/06/2016', 1246),
(1718, 'PASTI', '-450', '01/09/2016', 1267),
(1717, 'VARIO UFFICIO', '-6843', '01/09/2015', 1267),
(1716, 'LUCE + TELEFONO', '-150', '01/08/2016', 1267),
(1349, 'gasolio per 1° appuntamento', '-10', '26/08/2016', 1525),
(933, 'COSTO MATERIALE PORTACHIAVI IN METALLO', '-135', '30/08/2016', 1531),
(934, 'PROVVIGIONE PAOLO ROBINO', '-50', '30/08/2016', 1531),
(1715, 'VACANZA', '-2000', '01/08/2016', 1267),
(1714, 'PASTI', '-220', '01/08/2016', 1267),
(1713, 'GASOLIO', '-50', '01/07/2016', 1267),
(1712, 'PASTI', '-500', '01/07/2016', 1267),
(1711, 'PASTI', '-500', '01/07/2016', 1267),
(1048, 'RINNOVO ANNUALE', '-15', '05/09/2016', 1403),
(1710, 'LUCE + TELEFONO', '-150', '01/07/2016', 1267),
(1709, 'PASTI', '-500', '01/06/2016', 1267),
(1708, 'LUCE + TELEFONO', '-150', '01/06/2016', 1267),
(1707, 'GASOLIO', '-100', '01/06/2016', 1267),
(1706, 'LUCE + TELEFONO', '-150', '01/05/2016', 1267),
(1705, 'GASOLIO', '-150', '01/05/2016', 1267),
(1704, 'PASTI', '-400', '01/05/2016', 1267),
(1703, 'PASTI', '-400', '01/04/2016', 1267),
(1702, 'GASOLIO', '-150', '01/04/2016', 1267),
(1701, 'LUCE + TELEFONO', '-150', '01/04/2016', 1267),
(1700, 'LUCE + TELEFONO', '-150', '01/03/2016', 1267),
(1699, 'PASTI', '-500', '01/03/2016', 1267),
(1698, 'GASOLIO', '-150', '01/03/2016', 1267),
(1697, 'GASOLIO', '-150', '01/02/2016', 1267),
(1851, 'PLUGIN - Wapppress - Builds Android Mobile App for Any Wordpress Website', '-17', '09702/2016', 1245),
(1771, '% PORTACHIAVI LEVA', '-50', '09/09/2016', 1239),
(1348, 'GASOLIO', '-20', '23/09/2016', 1562),
(1347, 'GASOLIO', '-20', '23/09/2016', 1522),
(1350, 'DOMINIO + HOSTING', '-30', '04/10/2016', 1575),
(1351, 'TEMA SHOPPY', '-52', '04/10/2016', 1575),
(1355, 'RINNOVO DOMINIO + HOSTING', '-15', '04/10/2016', 290),
(1853, 'PLUGIN - wpDataTables - Tables and Charts Manager for WordPress', '-31', '13/07/2015', 1245),
(1378, 'RINNOVO DOMINIO + HOSTING', '-15', '04/10/2016', 1404),
(1379, 'RINNOVO DOMINIO + HOSTING', '-15', '04/10/2016', 1551),
(1483, 'RINNOVO DOMINIO + HOSTING', '-30', '04/10/2016', 500),
(1696, 'PASTI', '-500', '01/02/2016', 1267),
(1695, 'LUCE + TELEFONO', '-150', '01/02/2016', 1267),
(1694, 'LUCE + TELEFONO', '-150', '01/01/2016', 1267),
(1692, 'GASOLIO', '-150', '01/01/2016', 1267),
(1693, 'PASTI', '-500', '01/01/2016', 1267),
(1785, 'TEMA JUSTER', '-54', '25/10/2016', 1560),
(1773, '', '', '', 12),
(1774, '', '', '', 11),
(1781, '', '', '', 15),
(1800, 'Super Store Finder for Wordpress', '21', '15/01/2017', 1623),
(1799, 'WOOF - WooCommerce Products Filter', '30', '15/01/2017', 1623),
(1798, 'eForm - WordPress Form Builder', '29', '15/01/2017', 1623),
(1797, 'Use-your-Drive | Google Drive plugin for WordPress', '29', '15/01/2017', 1623),
(1796, 'Notification Users Plugins Wordpress', '6', '15/01/2017', 1623),
(1795, 'Responsive FlipBook Plugin', '35', '15/01/2017', 1623),
(1794, 'PDF To FlipBook Extension', '15', '15/01/2017', 1623),
(1801, 'KALLYAS - Creative eCommerce Multi-Purpose WordPress Theme', '69', '15/01/2017', 1623),
(1850, 'APP - 360 - HD Addictive Game Template', '-14', '07/10/2015', 1245),
(1848, 'RINNOVO DOMINIO + HOSTING', '-15', '04/10/2016', 1245),
(1849, 'PLUGIN - Yellow Pencil: Visual CSS Style Editor', '-20', '07/10/2015', 1245),
(1847, 'PLUGIN - iWappPress Builds iOS App for any wordpress website - CodeCanyon Item for Sale iWappPress B', '-17', '04/05/2016', 1245),
(1846, 'PLUGIN -  Panoramic - Google Street View Rotator for WP', '-16', '02/12/2015', 1245);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `costi`
--
ALTER TABLE `costi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `costi`
--
ALTER TABLE `costi`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1869;