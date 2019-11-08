-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2019 at 03:34 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surat`
--

-- --------------------------------------------------------

--
-- Table structure for table `file_upload`
--

CREATE TABLE `file_upload` (
  `id` int(11) NOT NULL,
  `nama_surat` varchar(255) NOT NULL,
  `jenis_surat` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `kode_surat` varchar(50) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file_upload`
--

INSERT INTO `file_upload` (`id`, `nama_surat`, `jenis_surat`, `filename`, `kode_surat`, `tanggal`) VALUES
(2, 'Surat Perjalanan Dinas', 'Surat Keluar Dekan Teknologi Industri', '001DTISKL-UIBX2019.pdf', '001/DTI/SKL-UIB/X/2019', '2019-10-31');

-- --------------------------------------------------------

--
-- Table structure for table `file_upload_surat_kep`
--

CREATE TABLE `file_upload_surat_kep` (
  `id` int(11) NOT NULL,
  `nama_surat` varchar(255) NOT NULL,
  `jenis_surat` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `kode_surat` varchar(50) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `file_upload_surat_user`
--

CREATE TABLE `file_upload_surat_user` (
  `id` int(11) NOT NULL,
  `nama_surat` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `file_upload_surat_user`
--

INSERT INTO `file_upload_surat_user` (`id`, `nama_surat`, `filename`, `keterangan`) VALUES
(19, 'asdasd', 'Surat19.pdf', 'asdad');

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id` int(11) NOT NULL,
  `nama_surat` varchar(150) NOT NULL,
  `kode_unik_surat` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat_keluar`
--

INSERT INTO `surat_keluar` (`id`, `nama_surat`, `kode_unik_surat`) VALUES
(1, 'Surat Keluar Rektor', 'REK/SKL-UIB'),
(2, 'Surat Keluar Dekan Fakultas Ekonomi', 'DFE/SKL-UIB'),
(3, 'Surat Keluar Dekan Fakultas Hukum', 'DFH/SKL-UIB'),
(4, 'Surat Keluar Dekan Ilmu Komputer', 'DIK/SKL-UIB'),
(5, 'Surat Keluar Dekan Teknologi Industri', 'DTI/SKL-UIB'),
(6, 'Surat Keluar Dekan Teknik Sipil & Perencanaan', 'DTS/SKL-UIB'),
(7, 'Surat Keluar Dekan Pendidikan Bahasa Inggris', 'DFP/SKL-UIB'),
(8, 'Surat Keluar LPPM', 'LPPM/SKL-UIB'),
(9, 'Surat Keluar BAUK', 'BAUK/SKL-UIB'),
(10, 'Surat Keluar ADC', 'ADC/SKL-UIB');

-- --------------------------------------------------------

--
-- Table structure for table `surat_keputusan`
--

CREATE TABLE `surat_keputusan` (
  `id` int(11) NOT NULL,
  `nama_surat` varchar(150) NOT NULL,
  `kode_unik_surat` varchar(150) NOT NULL,
  `tipe` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat_keputusan`
--

INSERT INTO `surat_keputusan` (`id`, `nama_surat`, `kode_unik_surat`, `tipe`) VALUES
(1, 'Surat Keputusan Rektor', 'REK/KEP-UIB', 'Rektor'),
(2, 'Surat Keputusan Dekan Fakultas Ekonomi', 'DFE/KEP-UIB', 'Dekan Fakultas Ekonomi'),
(3, 'Surat Keputusan Dekan Fakultas Hukum', 'DFH/KEP-UIB', 'Dekan Fakultas Hukum'),
(4, 'Surat Keputusan Dekan Ilmu Komputer', 'DIK/KEP-UIB', 'Dekan Ilmu Komputer'),
(5, 'Surat Keputusan Dekan Teknologi Industri', 'DTI/KEP-UIB', 'Dekan Teknologi Industri'),
(6, 'Surat Keputusan Dekan Teknik Sipil & Perencanaan', 'DTS/KEP-UIB', 'Dekan Teknik Sipil & Perencanaan'),
(7, 'Surat Keputusan Dekan Pendidikan Bahasa Inggris', 'DFP/KEP-UIB', 'Dekan Pendidikan Bahasa Inggris');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `level` enum('Admin','User') NOT NULL DEFAULT 'User',
  `blokir` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `nama`, `level`, `blokir`) VALUES
(11, 'jodi@uib.ac.id', 'Jodi', 'Admin', 'N'),
(12, 'denny@uib.ac.id', 'Denny', 'User', 'N'),
(15, 'theodora@uib.ac.id', 'Theodora', 'User', 'Y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file_upload`
--
ALTER TABLE `file_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_upload_surat_kep`
--
ALTER TABLE `file_upload_surat_kep`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_upload_surat_user`
--
ALTER TABLE `file_upload_surat_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_keputusan`
--
ALTER TABLE `surat_keputusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file_upload`
--
ALTER TABLE `file_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `file_upload_surat_kep`
--
ALTER TABLE `file_upload_surat_kep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_upload_surat_user`
--
ALTER TABLE `file_upload_surat_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `surat_keputusan`
--
ALTER TABLE `surat_keputusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
