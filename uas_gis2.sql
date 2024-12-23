-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 04:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas_gis2`
--

-- --------------------------------------------------------

--
-- Table structure for table `apotik`
--

CREATE TABLE `apotik` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `pemilik` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apotik`
--

INSERT INTO `apotik` (`id`, `nama`, `pemilik`, `alamat`, `kecamatan`, `latitude`, `longitude`) VALUES
(5, 'fino', 'F55122036', 'Teknik', 'TEKNIK', '-0.841836', '119.8942905'),
(6, 'RIO', 'F55122006', 'FMIPA', 'FMIPA', '-0.838768', '119.8943335');

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `warna` varchar(100) NOT NULL,
  `poligon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `nama`, `warna`, `poligon`) VALUES
(5, 'TEKNIK', '#ff0000', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[119.892381,-0.840227],[119.89635,-0.840227],[119.895985,-0.841042],[119.896049,-0.843445],[119.892231,-0.843359],[119.892381,-0.840227]]]}}]}'),
(6, 'FMIPA', '#4dffdb', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[119.894527,-0.839175],[119.892339,-0.839133],[119.892274,-0.838789],[119.893754,-0.838167],[119.893647,-0.837223],[119.894956,-0.837266],[119.8959,-0.837266],[119.895942,-0.838897],[119.896307,-0.839025],[119.896393,-0.840313],[119.894527,-0.840227],[119.894527,-0.839175]]]}}]}'),
(7, 'PERTANIAN', '#00ffaa', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[119.896479,-0.840372],[119.898689,-0.840308],[119.898624,-0.839042],[119.89768,-0.838076],[119.89768,-0.837368],[119.895793,-0.837304],[119.8959,-0.838677],[119.896436,-0.839235],[119.896479,-0.840372]]]}}]}'),
(8, 'KEHUTANAN', '#ff0088', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[119.896479,-0.840372],[119.898689,-0.840308],[119.898624,-0.839042],[119.89768,-0.838076],[119.89768,-0.837368],[119.895793,-0.837304],[119.8959,-0.838677],[119.896436,-0.839235],[119.896479,-0.840372]]]}},{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[119.897744,-0.835485],[119.899525,-0.835528],[119.90019,-0.838875],[119.900554,-0.841707],[119.898559,-0.841686],[119.898559,-0.839068],[119.897637,-0.838146],[119.897744,-0.835485]]]}}]}'),
(9, 'FKIP', '#4746a0', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[119.896479,-0.840372],[119.898689,-0.840308],[119.898624,-0.839042],[119.89768,-0.838076],[119.89768,-0.837368],[119.895793,-0.837304],[119.8959,-0.838677],[119.896436,-0.839235],[119.896479,-0.840372]]]}},{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[119.897744,-0.835485],[119.899525,-0.835528],[119.90019,-0.838875],[119.900554,-0.841707],[119.898559,-0.841686],[119.898559,-0.839068],[119.897637,-0.838146],[119.897744,-0.835485]]]}},{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[119.892307,-0.830177],[119.895021,-0.830123],[119.895074,-0.831904],[119.894527,-0.832419],[119.894538,-0.833824],[119.89353,-0.833824],[119.89338,-0.834543],[119.892221,-0.833792],[119.892307,-0.830177]]]}}]}'),
(20, 'EKONOMI', '#c85656', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[119.8959,-0.830035],[119.895879,-0.831645],[119.896308,-0.832589],[119.896458,-0.83334],[119.897766,-0.833361],[119.89856,-0.833254],[119.898603,-0.832009],[119.89678,-0.830121],[119.8959,-0.830035]]]}}]}'),
(21, 'HUKUM', '#fed716', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[119.896499,-0.833297],[119.898537,-0.833297],[119.89858,-0.833661],[119.899481,-0.835464],[119.897679,-0.835292],[119.897571,-0.837137],[119.895834,-0.837094],[119.896156,-0.835592],[119.895877,-0.834262],[119.896499,-0.833297]]]}}]}'),
(22, 'FISIP', '#9e9e9e', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[119.894612,-0.833189],[119.896607,-0.833297],[119.895921,-0.834305],[119.896114,-0.835378],[119.895835,-0.837094],[119.893797,-0.837159],[119.893582,-0.836472],[119.893711,-0.835507],[119.893497,-0.834391],[119.893539,-0.833897],[119.894419,-0.833769],[119.894612,-0.833189]]]}}]}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apotik`
--
ALTER TABLE `apotik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apotik`
--
ALTER TABLE `apotik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
