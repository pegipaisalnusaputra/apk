-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Okt 2024 pada 13.59
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_client`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_clientblmapprove`
--

CREATE TABLE `tb_clientblmapprove` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `tanggal_input` date NOT NULL,
  `total_kredit` decimal(10,2) NOT NULL,
  `biaya_admin` decimal(10,2) NOT NULL,
  `ktp` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_clientblmapprove`
--

INSERT INTO `tb_clientblmapprove` (`id`, `nama`, `alamat`, `nohp`, `tanggal_input`, `total_kredit`, `biaya_admin`, `ktp`, `created_at`) VALUES
(1, 'dian', 'sukabumi', '087677889988', '2024-10-04', 8000000.00, 1600000.00, 'uploads/1728024417_mahasiswa.jpg', '2024-10-04 06:46:57'),
(2, 'mega', 'parungkuda', '087677889989', '2024-10-04', 7000000.00, 1400000.00, '', '2024-10-04 07:08:38'),
(3, 'udin', 'cicurug', '08767787777', '2024-10-04', 18000000.00, 3600000.00, '', '2024-10-04 07:10:15'),
(4, 'udin', 'cicurug', '08767787777', '2024-10-04', 18000000.00, 3600000.00, '', '2024-10-04 07:12:07'),
(5, 'alwi', 'sukabumi', '087655676655', '2024-10-04', 45000000.00, 9000000.00, '66ff9a0a2f9e43.40621634.jpg', '2024-10-04 07:32:26'),
(6, 'alwi', 'sukabumi', '087655676655', '2024-10-04', 45000000.00, 9000000.00, '66ff9a87a04cd0.32030029.jpg', '2024-10-04 07:34:31'),
(7, 'alwi', 'sukabumi', '087655676655', '2024-10-04', 45000000.00, 9000000.00, '66ff9dc383b8e2.28744754.jpg', '2024-10-04 07:48:19'),
(8, 'tes', 'cicurug', '086544556676', '2024-10-04', 17000000.00, 3400000.00, '66ff9e0f350d95.97660364.PNG', '2024-10-04 07:49:35'),
(9, 'marketing', 'sukabumi', '087666778877', '2024-10-04', 5000000.00, 1000000.00, '66ffade755c901.93488976.PNG', '2024-10-04 08:57:11'),
(10, 'marketing', 'sukabumi', '087666778877', '2024-10-04', 5000000.00, 1000000.00, '66ffae47657de4.74837079.PNG', '2024-10-04 08:58:47'),
(11, 'www', 'www', '0873653536', '2024-10-04', 15000000.00, 3000000.00, '66ffae93260ea0.20534346.PNG', '2024-10-04 09:00:03'),
(12, 'www', 'www', '0873653536', '2024-10-04', 15000000.00, 3000000.00, '66ffb315a9a158.26184904.PNG', '2024-10-04 09:19:17'),
(13, 'www', 'www', '0873653536', '2024-10-04', 15000000.00, 3000000.00, '66ffb4509be3c2.42942347.PNG', '2024-10-04 09:24:32'),
(14, 'www', 'www', '0873653536', '2024-10-04', 15000000.00, 3000000.00, '66ffb4987f5098.23125558.PNG', '2024-10-04 09:25:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kredit`
--

CREATE TABLE `tb_kredit` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `aplikasi` varchar(100) NOT NULL,
  `nominal_aplikasi` decimal(15,2) NOT NULL,
  `total_kredit` decimal(15,2) NOT NULL,
  `nama_marketing` varchar(100) NOT NULL,
  `persentase` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kredit`
--

INSERT INTO `tb_kredit` (`id`, `nama`, `alamat`, `nohp`, `aplikasi`, `nominal_aplikasi`, `total_kredit`, `nama_marketing`, `persentase`, `created_at`) VALUES
(1, 'marketing', 'sukabumi', '087666778877', 'kredito', 5000000.00, 5000000.00, 'Egi', 0.20, '2024-10-04 08:58:47'),
(2, 'www', 'www', '0873653536', 'easy cash', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:00:03'),
(3, 'www', 'www', '0873653536', 'adakami', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:00:03'),
(4, 'www', 'www', '0873653536', 'akulaku', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:00:03'),
(5, 'www', 'www', '0873653536', 'easy cash', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:19:17'),
(6, 'www', 'www', '0873653536', 'adakami', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:19:17'),
(7, 'www', 'www', '0873653536', 'akulaku', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:19:17'),
(8, 'www', 'www', '0873653536', 'easy cash', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:24:34'),
(9, 'www', 'www', '0873653536', 'adakami', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:24:34'),
(10, 'www', 'www', '0873653536', 'akulaku', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:24:34'),
(11, 'www', 'www', '0873653536', 'easy cash', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:25:46'),
(12, 'www', 'www', '0873653536', 'adakami', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:25:46'),
(13, 'www', 'www', '0873653536', 'akulaku', 5000000.00, 15000000.00, 'wwwdotcom', 0.20, '2024-10-04 09:25:46');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_clientblmapprove`
--
ALTER TABLE `tb_clientblmapprove`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_kredit`
--
ALTER TABLE `tb_kredit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_clientblmapprove`
--
ALTER TABLE `tb_clientblmapprove`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tb_kredit`
--
ALTER TABLE `tb_kredit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
