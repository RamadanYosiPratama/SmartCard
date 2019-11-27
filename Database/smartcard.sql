-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2019 at 05:20 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartcard`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(15) NOT NULL,
  `niGn` varchar(100) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telp` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `niGn`, `nama_guru`, `alamat`, `jenis_kelamin`, `email`, `telp`, `photo`) VALUES
(6, '2019001S', 'Muhammad Ramadan', 'Bekasi', 'laki-laki', 'ramadanyosi30@gmail.com', '081292674005', '2019001S.jpg'),
(7, '2019001D', 'Debian', 'Jakarta', 'perempuan', 'syifa@gmail.com', '081298774005', '2019001D.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `kode_kelas` varchar(15) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `kode_kelas`, `nama_kelas`) VALUES
(1, '01GRUP1', 'Kelas 7 SMP'),
(2, '02GRUP2', 'Kelas 8 SMP'),
(3, '03GRUP3', 'Kelas 9 SMP');

-- --------------------------------------------------------

--
-- Table structure for table `krs`
--

CREATE TABLE `krs` (
  `id_krs` int(10) NOT NULL,
  `id_thn_akad` int(10) NOT NULL,
  `nis` char(15) NOT NULL,
  `kode_matapelajaran` varchar(10) NOT NULL,
  `nilai` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `krs`
--

INSERT INTO `krs` (`id_krs`, `id_thn_akad`, `nis`, `kode_matapelajaran`, `nilai`) VALUES
(25, 14, '2019001111', '01IPA1', ''),
(26, 14, '2019001111', '01MTKA', ''),
(32, 14, '2019001111', '01BING', ''),
(33, 14, '2019001111', '01BING', ''),
(34, 14, '2019001111', '01MTK7', 'A'),
(36, 14, '2019001111', '01BhsIng1', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `matapelajaran`
--

CREATE TABLE `matapelajaran` (
  `kode_matapelajaran` varchar(10) NOT NULL,
  `nama_matapelajaran` varchar(100) NOT NULL,
  `lama_belajar` int(5) NOT NULL,
  `id_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matapelajaran`
--

INSERT INTO `matapelajaran` (`kode_matapelajaran`, `nama_matapelajaran`, `lama_belajar`, `id_kelas`) VALUES
('01MTK7', 'Matematika Kelas 7', 2, 1),
('01MTK8', 'Matematika Kelas 8', 2, 2),
('01MTK9', 'Matematika Kelas 9', 3, 3),
('01IPA9', 'Ilmu Pengetahuan Alam Kelas 9', 3, 3),
('01IPA7', 'Ilmu Pengetahuan Alam Kelas 7', 2, 1),
('01IPA8', 'Ilmu Pengetahuan Alam Kelas 8', 2, 2),
('01BhsIng1', 'BahasaInggris Kelas 7', 2, 1),
('01BhsIng2', 'BahasaInggris Kelas 8', 2, 2),
('01BhsIng3', 'BahasaInggris Kelas 9', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `main_menu` varchar(11) NOT NULL,
  `level` enum('admin','user') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `link`, `icon`, `main_menu`, `level`) VALUES
(1, 'siswa', 'siswa', 'fa fa-user', '12', 'admin'),
(2, 'kelas', 'kelas', 'fa fa-graduation-cap', '12', 'admin'),
(3, 'Mata Pelajaran', 'matapelajaran', 'fa fa-bookmark-o', '12', 'user'),
(4, 'Guru', 'guru', 'fa fa-users', '12', 'user'),
(5, 'Tahun Akademik', 'Thn_akad_semester', 'fa fa-ellipsis-v', '12', 'admin'),
(6, 'KRS', 'krs', 'fa fa-edit', '12', 'user'),
(7, 'Input Nilai', 'nilai/inputNilai', 'fa fa-sort-numeric-asc', '12', 'admin'),
(8, 'KHS', 'nilai', 'fa fa-file-text-o', '12', 'user'),
(9, 'cetak nilai', 'nilai/buatTranskrip', 'fa fa-pencil-square-o', '12', 'user'),
(10, 'User', 'users', 'fa fa-user', '13', 'user'),
(11, 'Menu', 'menu', 'fa fa-eye', '13', 'admin'),
(12, 'SmartCard', '#', 'fa fa-graduation-cap', '0', 'admin'),
(13, 'SETING', '#', 'fa fa-gear', '0', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` char(15) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `nama_panggilan` varchar(15) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `agama` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `id_kelas` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama_lengkap`, `nama_panggilan`, `alamat`, `email`, `telp`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `agama`, `photo`, `id_kelas`) VALUES
('2019001111', 'Yanto', 'Yan', 'Bekasi', 'yanto@gmail.com', '081292674005', 'Meikarta', '2001-01-01', 'L', 'Islam', '2019001111.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `thn_akad_semester`
--

CREATE TABLE `thn_akad_semester` (
  `id_thn_akad` int(10) NOT NULL,
  `thn_akad` varchar(9) NOT NULL,
  `semester` varchar(5) NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thn_akad_semester`
--

INSERT INTO `thn_akad_semester` (`id_thn_akad`, `thn_akad`, `semester`, `aktif`) VALUES
(1, '2014/2015', '1', 'N'),
(2, '2014/2015', '2', 'N'),
(3, '2015/2016', '1', 'N'),
(4, '2015/2016', '2', 'N'),
(5, '2016/2017', '1', 'N'),
(7, '2016/2017', '2', 'N'),
(8, '2018/2019', '1', 'N'),
(9, '2018/2019', '2', 'N'),
(13, '2019/2020', '1', 'Y'),
(14, '2019/2020', '2', 'N'),
(0, '2020/2021', '1', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `transkrip`
--

CREATE TABLE `transkrip` (
  `id_transkrip` int(10) NOT NULL,
  `nis` varchar(15) NOT NULL,
  `kode_matapelajaran` varchar(10) NOT NULL,
  `nilai` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transkrip`
--

INSERT INTO `transkrip` (`id_transkrip`, `nis`, `kode_matapelajaran`, `nilai`) VALUES
(0, '2017010012', 'FKB3001', 'A'),
(0, '2017010012', 'FKB3003', 'B'),
(0, '2017010012', 'FKB4012', 'B'),
(0, '2017010012', 'UPK200X', 'B'),
(0, '2017010019', 'FKB1001', 'B'),
(0, '2017010019', 'FKB3002', 'A'),
(0, '2017010019', 'FKB3003', 'C'),
(0, '2019001111', '01IPA1', ''),
(0, '2019001111', '01MTKA', ''),
(0, '2019001111', '01BING', ''),
(0, '2019001111', '01BING', ''),
(0, '2019001111', '01MTK7', 'A'),
(0, '2019001111', '01BhsIng1', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `level` enum('admin','user') NOT NULL DEFAULT 'user',
  `blokir` enum('N','Y') NOT NULL DEFAULT 'N',
  `id_sessions` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `level`, `blokir`, `id_sessions`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'yosefmurya@gmail.com', 'admin', 'N', '21232f297a57a5a743894a0e4a801fc3'),
('Ramadan', '81dc9bdb52d04dc20036dbd8313ed055', 'ramadanyosi30@gmail.com', 'admin', 'N', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`id_krs`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `krs`
--
ALTER TABLE `krs`
  MODIFY `id_krs` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
