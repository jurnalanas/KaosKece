-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2013 at 08:53 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kaoskece`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `adminId` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(200) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `fakultas` varchar(200) NOT NULL,
  PRIMARY KEY (`adminId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminId`, `nama`, `userName`, `email`, `password`, `fakultas`) VALUES
(2, 'Anas', 'anasajadah', 'anas.bladz@gmail.com', 'balonku', 'FMIPA'),
(11, 'baru', 'baruaja', 'baru1@baru.com', 'baruaja', 'FAPERTA'),
(12, 'Tujuh Orang', 'tujuh', 'tujuh@tujuh.com', 'tujuh', 'FAPERTA'),
(13, 'YAYIYALAH', 'yaiyalah', 'yaiyalah@yaiyadong.com', 'yaiyadong', 'FMIPA');

-- --------------------------------------------------------

--
-- Table structure for table `daftartagihan`
--

CREATE TABLE IF NOT EXISTS `daftartagihan` (
  `no_tagihan` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `size` varchar(11) NOT NULL,
  `price` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `fakultas` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`no_tagihan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `daftartagihan`
--

INSERT INTO `daftartagihan` (`no_tagihan`, `username`, `id`, `name`, `size`, `price`, `img`, `fakultas`) VALUES
(6, 'anasajadah', '105', 'Kaos enam', 'Large', 25, 'img/shirts/shirt-105.png', 'FMIPA'),
(7, 'anasajadah', '105', 'Kaos enam', 'Small', 25, 'img/shirts/shirt-105.png', 'FMIPA'),
(8, 'anasajadah', '105', 'Kaos enam', 'Large', 25, 'img/shirts/shirt-105.png', 'FMIPA'),
(9, 'anasajadah', '105', 'Kaos enam', 'Large', 25, 'img/shirts/shirt-105.png', 'FMIPA'),
(10, 'anasajadah', '104', 'kaos lima', 'Large', 18, 'img/shirts/shirt-104.png', 'FMIPA'),
(11, 'tujuh', '108', 'Kaos sembilan', 'Small', 25, 'img/shirts/shirt-108.jpg', NULL),
(12, 'yaiyalah', '105', 'Kaos enam', 'Large', 25, 'img/shirts/shirt-105.png', 'FMIPA'),
(13, 'yaiyalah', '106', 'Kaos tujuh', 'Medium', 20, 'img/shirts/shirt-106.png', 'FMIPA');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE IF NOT EXISTS `fakultas` (
  `id_fakultas` int(11) NOT NULL AUTO_INCREMENT,
  `fakultas` varchar(200) NOT NULL,
  PRIMARY KEY (`id_fakultas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id_fakultas`, `fakultas`) VALUES
(1, 'FAPERTA'),
(2, 'FKH'),
(4, 'FPIK'),
(5, 'FAPET'),
(6, 'FAHUTAN'),
(7, 'FATETA'),
(8, 'FMIPA'),
(9, 'FEM'),
(10, 'FEMA');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE IF NOT EXISTS `produk` (
  `uploader` varchar(100) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `fakultas` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`uploader`, `id`, `name`, `img`, `price`, `fakultas`) VALUES
('anasajadah', 101, 'Kaos Satu', 'img/shirts/shirt-101.png', 18, 'FMIPA'),
('anasajadah', 102, 'Kaos Dua', 'img/shirts/shirt-102.png', 20, 'FMIPA'),
('anasajadah', 103, 'Kaos Tiga', 'img/shirts/shirt-103.png', 20, 'FMIPA'),
('anasajadah', 104, 'Kaos Empat', 'img/shirts/shirt-104.png', 18, 'FMIPA'),
('anasajadah', 105, 'Kaos Lima', 'img/shirts/shirt-105.png', 25, 'FMIPA'),
('anasajadah', 106, 'Kaos Enam', 'img/shirts/shirt-106.png', 20, 'FMIPA'),
('anasajadah', 107, 'Kaos Tujuh', 'img/shirts/shirt-107.jpg', 20, 'FMIPA'),
('Kaos Sembilan', 108, 'Kaos Delapan', 'img/shirts/shirt-108.jpg', 25, 'FMIPA');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(200) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id_status`, `status`) VALUES
(1, 'Puas'),
(2, 'Kecewa'),
(4, 'Galau'),
(5, 'Ga Peduli');

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
--

CREATE TABLE IF NOT EXISTS `testimoni` (
  `id_testi` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(50) DEFAULT NULL,
  `nama_baju` varchar(50) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `komentator` varchar(50) DEFAULT NULL,
  `komentar` varchar(200) NOT NULL,
  `id_baju` int(10) NOT NULL,
  PRIMARY KEY (`id_testi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `testimoni`
--

INSERT INTO `testimoni` (`id_testi`, `owner`, `nama_baju`, `status`, `komentator`, `komentar`, `id_baju`) VALUES
(11, 'anasajadah', NULL, 'Puas', NULL, 'tes aja dehaa', 105),
(12, 'anasajadah', 'Kaos Lima', 'Puas', 'anasdua', 'tes lagimama', 105),
(13, 'anasajadah', NULL, 'Puas', NULL, 'nggak tau lahsss', 106),
(14, 'anasajadah', 'Kaos Enam', 'Ga Peduli', 'anasdua', 'gue juga udah punya', 106),
(15, 'anasajadah', 'Kaos Lima', 'Puas', 'anasajadah', 'makan', 105),
(16, 'anasajadah', 'Kaos Tujuh', 'Puas', 'anasajadah', 'ahmmm', 107),
(17, 'anasajadah', 'Kaos Lima', 'Puas', 'yaiyalah', 'eh nggak bajunya belum punya', 105);

-- --------------------------------------------------------

--
-- Table structure for table `ukuran`
--

CREATE TABLE IF NOT EXISTS `ukuran` (
  `Id_ukuran` int(11) NOT NULL AUTO_INCREMENT,
  `Ukuran` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_ukuran`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ukuran`
--

INSERT INTO `ukuran` (`Id_ukuran`, `Ukuran`) VALUES
(1, 'Small'),
(2, 'Medium'),
(4, 'Large'),
(5, 'X-Large');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
