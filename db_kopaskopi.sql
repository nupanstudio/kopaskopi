-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Feb 2026 pada 13.49
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kopaskopi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `no_meja` varchar(10) DEFAULT NULL,
  `items` text DEFAULT NULL,
  `jumlah_item` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('baru','proses','selesai') DEFAULT 'baru',
  `pembayaran` enum('pending','lunas') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `nama_pelanggan`, `no_meja`, `items`, `jumlah_item`, `total_harga`, `notes`, `status`, `pembayaran`, `created_at`) VALUES
(1, 'Ibnu', '01', 'Americano Ice x4, Americano Ice x1, Americano Ice x1', 6, 108000, 'Americano Ice: Less Sugar | Americano Ice: Less | Americano Ice: test', 'baru', 'pending', '2026-02-04 08:17:06'),
(2, 'Ibnu', '01', 'Americano Ice x2, KOPAS-UP x3', 5, 90000, 'Americano Ice: Less Sugar | KOPAS-UP: Tambah Gula Dikit', 'baru', 'pending', '2026-02-04 08:19:37'),
(3, 'Asep', '04', 'Americano Ice x3', 3, 54000, 'Americano Ice: Kurangi Gulanya', 'baru', 'pending', '2026-02-04 08:20:43'),
(4, 'ibnu', '01', 'Americano Ice x1', 1, 18000, '', 'baru', 'pending', '2026-02-04 09:27:30'),
(5, 'ibnu', '03', 'Americano Ice x4', 4, 72000, 'Americano Ice: test', 'baru', 'pending', '2026-02-04 09:35:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kategori`, `harga`, `gambar`) VALUES
(1, 'KOPAS-UP', 'signature', 18000, 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=600'),
(2, 'Americano Ice', 'based-coffee', 18000, 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=600');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
