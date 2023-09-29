-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2023 at 11:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `babada-absen`
--

-- --------------------------------------------------------

--
-- Table structure for table `ba_absensi`
--

CREATE TABLE `ba_absensi` (
  `abs_id` bigint(20) NOT NULL,
  `abs_kry_id` bigint(20) DEFAULT NULL,
  `abs_cpy_id` bigint(20) DEFAULT NULL,
  `abs_shift_id` bigint(20) DEFAULT NULL,
  `abs_tanggal` date DEFAULT NULL,
  `abs_jam_masuk` time DEFAULT NULL,
  `abs_jam_pulang` time DEFAULT NULL,
  `abs_status` smallint(1) DEFAULT NULL,
  `abs_ket` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ba_company`
--

CREATE TABLE `ba_company` (
  `cpy_id` bigint(20) NOT NULL,
  `cpy_kode` varchar(50) DEFAULT NULL,
  `cpy_nama` varchar(255) DEFAULT NULL,
  `cpy_alamat` varchar(255) DEFAULT NULL,
  `cpy_lat` double DEFAULT NULL,
  `cpy_lang` double DEFAULT NULL,
  `cpy_qr_code` blob DEFAULT NULL,
  `cpy_jenis` smallint(1) DEFAULT NULL COMMENT '1=holding, 2=subholding'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ba_data_shift`
--

CREATE TABLE `ba_data_shift` (
  `sft_id` int(11) NOT NULL,
  `sft_nama` varchar(50) DEFAULT NULL,
  `sft_jam_masuk` time DEFAULT NULL,
  `sft_jam_pulang` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ba_data_shift`
--

INSERT INTO `ba_data_shift` (`sft_id`, `sft_nama`, `sft_jam_masuk`, `sft_jam_pulang`) VALUES
(1, 'Shift Siang', '13:00:00', '22:20:00'),
(2, 'Shift Pagi', '05:30:00', '14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ba_karyawan`
--

CREATE TABLE `ba_karyawan` (
  `kry_id` bigint(20) NOT NULL,
  `kry_kode` varchar(50) DEFAULT NULL,
  `kry_nama` varchar(100) DEFAULT NULL,
  `kry_jk` smallint(1) DEFAULT NULL COMMENT '1=pria, 2=wanita',
  `kry_notelp` varchar(20) DEFAULT NULL,
  `kry_alamat` varchar(200) DEFAULT NULL,
  `kry_tgl_masuk` date DEFAULT NULL,
  `kry_status` smallint(1) NOT NULL DEFAULT 1 COMMENT '0=nonaktif, 1=aktif',
  `kry_foto` blob DEFAULT NULL,
  `kry_cpy_id` bigint(20) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ba_user`
--

CREATE TABLE `ba_user` (
  `usr_id` bigint(20) NOT NULL,
  `usr_username` varchar(100) DEFAULT NULL,
  `usr_password` varchar(255) DEFAULT NULL,
  `usr_kry_id` bigint(20) DEFAULT NULL,
  `usr_cpy_id` bigint(20) DEFAULT NULL,
  `usr_role` smallint(1) DEFAULT NULL COMMENT '1=admin, 2=karyawan',
  `usr_status` smallint(1) NOT NULL DEFAULT 1 COMMENT '0=nonaktif, 1=aktif',
  `usr_shift` smallint(1) DEFAULT NULL COMMENT '0=nonaktif, 1=aktif',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ba_user`
--

INSERT INTO `ba_user` (`usr_id`, `usr_username`, `usr_password`, `usr_kry_id`, `usr_cpy_id`, `usr_role`, `usr_status`, `usr_shift`, `date_created`) VALUES
(1, 'administrator', 'b0fac120d0707b9c8470783a38e20e33', NULL, NULL, 1, 1, NULL, '2023-09-25 12:03:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ba_absensi`
--
ALTER TABLE `ba_absensi`
  ADD PRIMARY KEY (`abs_id`);

--
-- Indexes for table `ba_company`
--
ALTER TABLE `ba_company`
  ADD PRIMARY KEY (`cpy_id`);

--
-- Indexes for table `ba_data_shift`
--
ALTER TABLE `ba_data_shift`
  ADD PRIMARY KEY (`sft_id`);

--
-- Indexes for table `ba_user`
--
ALTER TABLE `ba_user`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ba_absensi`
--
ALTER TABLE `ba_absensi`
  MODIFY `abs_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ba_company`
--
ALTER TABLE `ba_company`
  MODIFY `cpy_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ba_data_shift`
--
ALTER TABLE `ba_data_shift`
  MODIFY `sft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ba_user`
--
ALTER TABLE `ba_user`
  MODIFY `usr_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
