-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 03, 2025 at 11:25 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int NOT NULL,
  `username` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `username`, `password`) VALUES
(123321, 'adm@gmail.com', '123'),
(123456, 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `tb_menu`
--

CREATE TABLE `tb_menu` (
  `id` int NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_makanan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_menu`
--

INSERT INTO `tb_menu` (`id`, `gambar`, `nama_makanan`, `harga`) VALUES
(22, '1756372764_ResepAyamGoreng-650x350-1.jpg', 'AYAM GORENG', 90000),
(23, '1756372924_resep-ayam-betutu-gilimanuk_43.jpeg', 'AYAM BETUTU', 15000000),
(24, '1756380262_bebek.jpg', 'BEBEK GORENG', 45000),
(25, '1756383751_43es teh.jpg', 'ES TEH', 5000),
(26, '1756547049_bebek.jpg', 'BEBEK JEMBUT', 100000),
(27, '1756547066_ResepAyamGoreng-650x350-1.jpg', 'AYAM TAJEN', 50000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_riwayat`
--

CREATE TABLE `tb_riwayat` (
  `id` int NOT NULL,
  `nama_makanan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `tanggal` date NOT NULL,
  `total` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_riwayat`
--

INSERT INTO `tb_riwayat` (`id`, `nama_makanan`, `quantity`, `tanggal`, `total`) VALUES
(1, 'AYAM GORENG (4), AYAM BETUTU (1), BEBEK GORENG (3), ES TEH (150), BEBEK JEMBUT (2), AYAM TAJEN (5)', 165, '2025-08-30', 16695000),
(2, 'ES TEH (5)', 5, '2025-08-30', 25000),
(3, 'AYAM GORENG (9)', 9, '2025-08-30', 810000),
(4, 'BEBEK JEMBUT (13)', 13, '2025-08-30', 1300000),
(5, 'BEBEK GORENG (18)', 18, '2025-08-30', 810000),
(6, 'AYAM GORENG (1)', 1, '2025-08-30', 90000),
(7, 'AYAM GORENG (1)', 1, '2025-09-01', 90000),
(8, 'BEBEK GORENG (5)', 5, '2025-09-01', 225000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_menu`
--
ALTER TABLE `tb_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
