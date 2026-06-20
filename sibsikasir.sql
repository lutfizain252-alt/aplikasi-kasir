-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2026 at 09:17 AM
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
-- Database: `sibsikasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `id_kategori`, `harga`, `stok`, `username`) VALUES
(3, 'Chitato', 3, 12000, 40, NULL),
(4, 'Beras 5 Kg', 1, 70000, 20, NULL),
(5, 'Kopi Kapal Api', 2, 2000, 100, NULL),
(40, '1', 29, 1, 1, 'ambol'),
(41, 'w', 30, 1, 1, 'ambol'),
(42, 'w', 36, 1, 1, 'ambol'),
(43, '11', 31, 1, 2, 'ambol'),
(44, 'wqe', 29, 12, 2, 'ambol'),
(45, '213', 37, 1231, 12, 'ambol'),
(48, 'ciki2', 41, 1, 1, 'iam'),
(49, 'cola', 42, 5, 1, 'iam');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `no_nota` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `no_nota`, `id_barang`, `qty`, `subtotal`) VALUES
(11, 17, 48, 1, 1000),
(12, 17, 49, 1, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `username`) VALUES
(1, 'Sembako', NULL),
(2, 'Minuman', NULL),
(3, 'Snack', NULL),
(4, 'Sembako', NULL),
(5, 'Minuman', NULL),
(6, 'Snack', NULL),
(7, 'ATK', NULL),
(8, 'Elektronik', NULL),
(9, 'mie instan', NULL),
(11, 'makanan', NULL),
(12, 'makanan', NULL),
(29, 'makanan', 'ambol'),
(30, 'minum', 'ambol'),
(31, 'www', 'ambol'),
(32, 'www', 'ambol'),
(33, 'www', 'ambol'),
(34, 'www', 'ambol'),
(35, 'ww', 'ambol'),
(36, 'wwww', 'ambol'),
(37, 'www', 'ambol'),
(38, 'ww', 'ambol'),
(41, 'makanan', 'iam'),
(42, 'minuman', 'iam');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `kasir` varchar(100) DEFAULT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal`, `kasir`, `total`) VALUES
(17, '2026-06-20 14:17:00', 'Muhammad Ilham Ramadhan', 6000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('pemilik','kasir') NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `email`, `role`, `reset_token`, `token_expire`) VALUES
(1, 'LUTFI123', 'LUTFI123', 'Lutfi Zain', NULL, 'pemilik', NULL, NULL),
(2, 'kasir', '12345', 'Kasir SIBSIKASIR', NULL, 'kasir', NULL, NULL),
(3, 'LUTFI123', 'LUTFI123', 'Lutfi Zain', NULL, 'pemilik', NULL, NULL),
(4, 'kasir', '12345', 'Kasir SIBSIKASIR', NULL, 'kasir', NULL, NULL),
(7, 'iam', 'iam321', 'Muhammad Ilham Ramadhan', 'milhamramadhan309@gamil.com', 'kasir', 'f24e0fc5488b89d1fcf7fa868e077ce11628ece7914998f41ddb098a83b7ec0c', '2026-06-18 15:59:11'),
(8, 'ambol', 'ambol123', 'ilham', 'ilhamramadhanm18@gmail.com', 'kasir', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
