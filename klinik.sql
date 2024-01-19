-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2024 at 02:21 PM
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
-- Database: `klinik`
--

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `pasien_id` bigint(20) UNSIGNED NOT NULL,
  `pasien_nik` varchar(16) DEFAULT NULL,
  `pasien_nama` varchar(65) DEFAULT NULL,
  `pasien_alamat` text NOT NULL,
  `pasien_kontak` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`pasien_id`, `pasien_nik`, `pasien_nama`, `pasien_alamat`, `pasien_kontak`) VALUES
(1, '320724098781', 'Dani Nugraha', 'Cijulang', '081323456765'),
(2, '320724098782', 'Shinta Maharani', 'Jakarta Barat', '081323456766'),
(3, '320724098783', 'Rizki Nurwahid', 'Depok', '081323456769'),
(4, '3494220979597636', 'Rizki Baikuni', 'Bandung', '081323456732'),
(5, '3730513849827818', 'Rinda Dwi Hanisa', 'Jakarat Utara', '087870693211'),
(6, '3542111067594474', 'Vani Rizka', 'Cilincing', '087870693217'),
(8, '3424221124303861', 'Farid Hamdani', 'Jakarta Selatan', '087870693201'),
(9, '3182934848145463', 'Fitri Silalahi', 'Lampung', '087870693898'),
(10, '3335001633692917', 'Asep Rohman', 'Pangandaran', '087870693999'),
(11, '3533410234057044', 'Sati Gunaardi', 'Bandung Barat', '087870692655'),
(12, '3714454220677315', 'Gunardi Wahyudi', 'Bogor', '081323456777'),
(13, '3387392341749949', 'Rizaldi Faradi', 'Manokwari', '087870697600'),
(14, '3143146419918270', 'Faisal Hamdani', 'Tangerang Selatan', '081323456734'),
(16, '3030141661855534', 'Adi Muhtarom', 'Tangerang Cimone', '081323456809');

-- --------------------------------------------------------

--
-- Table structure for table `pasien_antrian`
--

CREATE TABLE `pasien_antrian` (
  `antrian_id` int(11) UNSIGNED NOT NULL,
  `antrian_nomor` varchar(25) NOT NULL,
  `pasien_id` bigint(20) UNSIGNED NOT NULL,
  `antrian_status` enum('Menunggu','Selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien_antrian`
--

INSERT INTO `pasien_antrian` (`antrian_id`, `antrian_nomor`, `pasien_id`, `antrian_status`) VALUES
(1, 'A-001', 16, 'Menunggu'),
(2, 'A-002', 15, 'Menunggu'),
(3, 'A-003', 14, 'Menunggu'),
(4, 'A-004', 13, 'Menunggu'),
(5, 'A-005', 12, 'Menunggu'),
(6, 'A-006', 11, 'Selesai'),
(7, 'A-007', 10, 'Selesai'),
(8, 'A-008', 9, 'Selesai'),
(9, 'A-009', 8, 'Selesai'),
(10, 'A-010', 6, 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `pasien_riwayat`
--

CREATE TABLE `pasien_riwayat` (
  `riwayat_id` bigint(20) UNSIGNED NOT NULL,
  `pasien_id` bigint(20) UNSIGNED NOT NULL,
  `keterangan_keluhan` text DEFAULT NULL,
  `catatan_dokter` text DEFAULT NULL,
  `catatan_resep` text DEFAULT NULL,
  `tanggal_berobat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien_riwayat`
--

INSERT INTO `pasien_riwayat` (`riwayat_id`, `pasien_id`, `keterangan_keluhan`, `catatan_dokter`, `catatan_resep`, `tanggal_berobat`) VALUES
(11, 16, '&lt;p&gt;Sakit jantung sebelah kiri&lt;/p&gt;', '', '', '2023-12-07'),
(12, 6, '&lt;p&gt;Sakit dada bagian kiri&lt;/p&gt;', 'jangan banyak tidur', '- Baigon', '2024-01-01'),
(13, 10, '&lt;p&gt;Sakit jantung&lt;/p&gt;', '-', '-', '2024-01-01'),
(14, 11, '&lt;p&gt;Sakit lambung&lt;/p&gt;', '-', '-', '2024-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `profile_klinik`
--

CREATE TABLE `profile_klinik` (
  `klinik_id` tinyint(1) UNSIGNED NOT NULL,
  `klinik_name` varchar(65) DEFAULT NULL,
  `klinik_description` text NOT NULL,
  `klinik_contact` text DEFAULT NULL,
  `klinik_logo` varchar(45) DEFAULT NULL,
  `klinik_icon` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_klinik`
--

INSERT INTO `profile_klinik` (`klinik_id`, `klinik_name`, `klinik_description`, `klinik_contact`, `klinik_logo`, `klinik_icon`) VALUES
(1, 'Klinik Ansena', 'Klinik pengotabatan masyarakat', '087654321', 'logo.png', 'favicon.ico');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `sid` varbinary(192) NOT NULL,
  `created` datetime DEFAULT NULL,
  `session_data` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`sid`, `created`, `session_data`) VALUES
(0x396e713776746b696d743068753565626d763034383570386763, '2024-01-19 21:02:52', 0x757365725f69647c733a313a2231223b637265617465647c693a313730353636393337323b);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` smallint(6) NOT NULL,
  `nama_lengkap` varchar(65) DEFAULT NULL,
  `photo` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `role_id`, `nama_lengkap`, `photo`) VALUES
(1, 'myroot593@gmail.com', '$2y$10$c3FHGly3yeU1yhARb/Fe0euWfteioUOQyuGCd1kH6sDR8vQQpJcj6', 5, 'Dadang', 0x3736353132372e6a7067),
(3, 'dokter@gmail.com', '$2y$10$c9SzS0gWU1/Q71UHqXJhNuvMdqiwt1qlwQs8mnfdICHPD6CQ9eXJ6', 6, 'Dr Suhanda', 0x3738393235342e6a7067),
(4, 'administrasi@gmail.com', '$2y$10$zEfXkqXy13TaXPK.EUOBVuLmgqsd2yYf1bH5j.QZKR1hG1jez9HZi', 8, 'Hendara Mahesa', 0x3236383936352e6a7067),
(5, 'penggunalain@gmail.com', '$2y$10$hQj3QX.5pc38UqD53HE1R.LNzEhyiiYhEhbx2bCUECsvcLi8UkdLq', 8, 'Hari Tanue', 0x3731363134322e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `users_role`
--

CREATE TABLE `users_role` (
  `role_id` smallint(5) UNSIGNED NOT NULL,
  `role_name` varchar(65) DEFAULT NULL,
  `role_alias` varchar(65) DEFAULT NULL,
  `role_module` enum('admin','dokter','administrasi') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_role`
--

INSERT INTO `users_role` (`role_id`, `role_name`, `role_alias`, `role_module`) VALUES
(5, 'administrator', 'Admin', 'admin'),
(6, 'dokter', 'Dokter Umum', 'dokter'),
(8, 'administrasi', 'Admin Pendaftaran', 'administrasi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`pasien_id`),
  ADD UNIQUE KEY `pasien_nik` (`pasien_nik`);

--
-- Indexes for table `pasien_antrian`
--
ALTER TABLE `pasien_antrian`
  ADD PRIMARY KEY (`antrian_id`),
  ADD KEY `riwayat_id` (`pasien_id`);

--
-- Indexes for table `pasien_riwayat`
--
ALTER TABLE `pasien_riwayat`
  ADD PRIMARY KEY (`riwayat_id`);

--
-- Indexes for table `profile_klinik`
--
ALTER TABLE `profile_klinik`
  ADD PRIMARY KEY (`klinik_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `pasien_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pasien_antrian`
--
ALTER TABLE `pasien_antrian`
  MODIFY `antrian_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pasien_riwayat`
--
ALTER TABLE `pasien_riwayat`
  MODIFY `riwayat_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_role`
--
ALTER TABLE `users_role`
  MODIFY `role_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
