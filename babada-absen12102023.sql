-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2023 at 06:15 AM
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
  `abs_cpy_kode` varchar(50) DEFAULT NULL,
  `abs_shift_id` bigint(20) DEFAULT NULL,
  `abs_tanggal` date DEFAULT NULL,
  `abs_jam_masuk` time DEFAULT NULL,
  `abs_jam_pulang` time DEFAULT NULL,
  `abs_terlambat` int(11) DEFAULT NULL,
  `abs_denda` int(11) DEFAULT NULL,
  `abs_status` smallint(1) DEFAULT NULL,
  `abs_ket` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ba_absensi`
--

INSERT INTO `ba_absensi` (`abs_id`, `abs_kry_id`, `abs_cpy_kode`, `abs_shift_id`, `abs_tanggal`, `abs_jam_masuk`, `abs_jam_pulang`, `abs_terlambat`, `abs_denda`, `abs_status`, `abs_ket`) VALUES
(4, 3, 'CPY103251', NULL, '2023-10-09', '11:55:31', NULL, 235, 235000, 2, 'motor rusak');

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

--
-- Dumping data for table `ba_company`
--

INSERT INTO `ba_company` (`cpy_id`, `cpy_kode`, `cpy_nama`, `cpy_alamat`, `cpy_lat`, `cpy_lang`, `cpy_qr_code`, `cpy_jenis`) VALUES
(1, 'CPY103251', 'Babada Management', 'Jl. Lintas Timur Km. 14, Kec. Tenayan Raya, Pekanbaru', 0.4661537, 101.5203302, 0x4350593130333235312e706e67, 1);

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
-- Table structure for table `ba_divisi`
--

CREATE TABLE `ba_divisi` (
  `dvi_id` bigint(20) NOT NULL,
  `dvi_nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ba_divisi`
--

INSERT INTO `ba_divisi` (`dvi_id`, `dvi_nama`) VALUES
(1, 'Direksi'),
(2, 'IT Programming'),
(3, 'HRD'),
(4, 'Operational'),
(5, 'Marketing');

-- --------------------------------------------------------

--
-- Table structure for table `ba_jabatan`
--

CREATE TABLE `ba_jabatan` (
  `jab_id` bigint(20) NOT NULL,
  `jab_nama` varchar(100) DEFAULT NULL,
  `jab_level` smallint(1) DEFAULT NULL COMMENT '1=dirut'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ba_jabatan`
--

INSERT INTO `ba_jabatan` (`jab_id`, `jab_nama`, `jab_level`) VALUES
(1, 'DIC', 2),
(2, 'Karyawan', 3);

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
  `kry_tpt_lahir` varchar(150) DEFAULT NULL,
  `kry_tgl_lahir` date DEFAULT NULL,
  `kry_penyakit` varchar(255) DEFAULT NULL,
  `kry_gol_darah` varchar(50) DEFAULT NULL,
  `kry_status_nikah` varchar(20) DEFAULT NULL,
  `kry_no_ktp` varchar(50) DEFAULT NULL,
  `kry_map_rumah` varchar(100) DEFAULT NULL,
  `kry_tgl_masuk` date DEFAULT NULL,
  `kry_foto` blob DEFAULT NULL,
  `kry_cpy_id` bigint(20) DEFAULT NULL,
  `kry_dvi_id` bigint(20) DEFAULT NULL,
  `kry_jab_id` bigint(20) DEFAULT NULL,
  `kry_status` smallint(1) NOT NULL DEFAULT 1 COMMENT '0=nonaktif, 1=aktif, 2=resign',
  `kry_resign` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ba_karyawan`
--

INSERT INTO `ba_karyawan` (`kry_id`, `kry_kode`, `kry_nama`, `kry_jk`, `kry_notelp`, `kry_alamat`, `kry_tpt_lahir`, `kry_tgl_lahir`, `kry_penyakit`, `kry_gol_darah`, `kry_status_nikah`, `kry_no_ktp`, `kry_map_rumah`, `kry_tgl_masuk`, `kry_foto`, `kry_cpy_id`, `kry_dvi_id`, `kry_jab_id`, `kry_status`, `kry_resign`, `date_created`) VALUES
(3, '04082554', 'Wegi Zulianda', 1, '082283922582', 'Jl. Bukit Indah, Sail, Kec. Tenayan Raya, Pekanbaru', 'Taluk Kuantan', '1998-08-04', '-', 'O', 'Belum Menikah', '1402100408980002', 'https://maps.app.goo.gl/yWBaZJuBhdMFw25X7', '2023-06-16', 0x666f746f5f576567695f5a756c69616e64612e4a5047, 1, 2, 2, 1, NULL, '2023-10-03 10:17:05');

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
(1, 'administrator', 'b0fac120d0707b9c8470783a38e20e33', NULL, NULL, 1, 1, NULL, '2023-09-25 12:03:48'),
(2, 'wegizul', '746a926d7a852eca82a7318ab7f0a223', 3, 1, 3, 1, 0, '2023-10-03 11:11:50');

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
-- Indexes for table `ba_divisi`
--
ALTER TABLE `ba_divisi`
  ADD PRIMARY KEY (`dvi_id`);

--
-- Indexes for table `ba_jabatan`
--
ALTER TABLE `ba_jabatan`
  ADD PRIMARY KEY (`jab_id`);

--
-- Indexes for table `ba_karyawan`
--
ALTER TABLE `ba_karyawan`
  ADD PRIMARY KEY (`kry_id`);

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
  MODIFY `abs_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ba_company`
--
ALTER TABLE `ba_company`
  MODIFY `cpy_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ba_data_shift`
--
ALTER TABLE `ba_data_shift`
  MODIFY `sft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ba_divisi`
--
ALTER TABLE `ba_divisi`
  MODIFY `dvi_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ba_jabatan`
--
ALTER TABLE `ba_jabatan`
  MODIFY `jab_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ba_karyawan`
--
ALTER TABLE `ba_karyawan`
  MODIFY `kry_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ba_user`
--
ALTER TABLE `ba_user`
  MODIFY `usr_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;