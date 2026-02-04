-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2026 at 07:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mypustaka`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  `level` enum('User','Admin') DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nama_lengkap`, `email`, `password`, `nomor_telepon`, `alamat`, `foto_ktp`, `level`) VALUES
(1, 'Mahasiswa Genap', 'admin@mypustaka.com', 'admin', '08123456789', NULL, NULL, 'Admin'),
(2, 'user', 'user@gmail.com', '$2y$10$5XcxYPLHaLvMlxt6Eek2JuoJChFyjUlExItXlTk56erwxdIJsRzMK', '08123654789', NULL, NULL, 'User'),
(3, 'admin', 'admin123@gmail.com', '$2y$10$4gLnjEwGz2FPSr9hKgF8IeIaKOFwanTyghQxVYcCXebrjJI0f05ci', '08123456789', NULL, NULL, 'Admin'),
(4, 'Reynaldi', 'rey@gmail.com', '$2y$10$BXkTSGqxkRl4469oIdHrYuBdVlrpLB9DfJscqXTdiX5faNI0bc8cu', NULL, NULL, NULL, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(100) DEFAULT NULL,
  `penerbit` varchar(150) DEFAULT NULL,
  `tahun_terbit` int(4) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `foto_cover` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `kategori`, `stok`, `foto_cover`) VALUES
(3, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, NULL, 10, '1770019269_Laskar_pelangi_sampul.jpg'),
(4, 'Filosofi Teras', 'Henry Manampiring', 'Kompas', 2018, NULL, 5, '1770019206_42861019.jpg'),
(5, 'Atomic Habits', 'James Clear', 'Gramedia', 2019, NULL, 7, '1770019006_9786020633176_.Atomic_Habit.jpg'),
(6, 'Bumi', 'Tere Liye', 'Gramedia Pustaka Utama', 2014, NULL, 12, '1770013642_9786020332956_Bumi-New-Cover.jpg'),
(7, 'Rich Dad Poor Dad', 'Robert Kiyosaki', 'Warner Books', 1997, NULL, 3, '1770013579_81bsw6fnUiL.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali_seharusnya` date NOT NULL,
  `tgl_dikembalikan` date DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan') DEFAULT 'Dipinjam',
  `denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_buku`, `id_anggota`, `tgl_pinjam`, `tgl_kembali_seharusnya`, `tgl_dikembalikan`, `status`, `denda`) VALUES
(1, 7, 2, '2026-02-03', '2026-02-10', '2026-02-03', 'Dikembalikan', 0),
(2, 7, 2, '2026-02-03', '2026-02-10', NULL, 'Dipinjam', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_anggota` (`id_anggota`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
