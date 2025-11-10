-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jun 2024 pada 09.21
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
-- Database: `shopping`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'ammar', '123'),
(2, 'admin', 'admin'),
(3, 'admin', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,0) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `product_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `pmode` varchar(50) NOT NULL,
  `products` text NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `phone`, `address`, `pmode`, `products`, `amount_paid`) VALUES
(1, 'amar', 'ammar@gmailcom', '00000', '12345', 'cards', 'alat Campur Cat Pallet(5), Canvas 50X60(4), pallet(4), cover foto A4(4), cat akrilik(4), Kertas Craft coklat(4), A4 Warna Multicolor(4)', 977400.00),
(2, 'wert', 'ammar@gmailcom', 'werty', 'qwerty', 'netbanking', 'alat Campur Cat Pallet(1)', 83000.00),
(3, '111111111111', 'ammar@gmailcom123', '122222222222', '111111111111111111', 'cod', '', 0.00),
(4, '23', 'ammar@gmailcom', '11111111111111', 'qqqqqqqqqqqqqqqqqq', 'cod', '', 0.00),
(5, 'eawrsetdfghj', 'ammar@gmailcom', '123456', 'rsgarga1121', 'netbanking', '', 0.00),
(6, 'sdfghjk', 'ammar@gmailcom', '`1234567', 'asdfghjk', 'cod', '', 0.00),
(7, 'amar', 'ammar@gmailcom', '12345678', '234567uio', 'cod', '', 0.00),
(8, 'amar', 'ammar@gmailcom', '00000', '123', 'cod', '', 0.00),
(9, 'pklm', 'ammar@gmailcom', '00000', 'qwe', 'netbanking', '', 0.00),
(10, 'amar', 'ammar@gmailcom', 'werty', 'qw', 'cod', '', 0.00),
(11, 'qqqqqqqqqqqqqq', 'ammar@gmailcom', '1111111111', '1111111111111111', 'cod', '', 0.00),
(12, 'amar', 'ammar@gmailcom', '122222222222', 'aceh', 'cod', 'alat Campur Cat Pallet(8), canva(5), 7Pcs Kuas(8), cat air 20ml(1), pallet(6)', 1460000.00),
(13, 'amar', 'ammar@gmailcom', '122222222222', 'aceh', 'cod', 'alat Campur Cat Pallet(8), canva(5), 7Pcs Kuas(8), cat air 20ml(1), pallet(6)', 1460000.00),
(14, 'amar', 'ammar@gmailcom', '123456789', '12345678', 'cod', 'canva(4), 7Pcs Kuas(4)', 348000.00),
(15, 'amar', 'ammar@gmailcom', '123456789', '12345678', 'cod', 'canva(4), 7Pcs Kuas(4)', 348000.00),
(16, 'amar', 'amarraffa939@gmail.com', '00000', 'fdsa', 'cod', 'canva(3), 7Pcs Kuas(5)', 395000.00),
(17, '111111111111', 'amarraffa939@gmail.com', '00000', '123e', 'cod', '', 0.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_qty` int(11) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`id`, `product_name`, `product_price`, `product_qty`, `product_image`, `product_code`) VALUES
(1, 'alat Campur Cat Pallet', 83000.00, 1, 'propalette.png', 'pt1000'),
(2, 'canva', 20000.00, 1, 'procanvsa.png', 'pt1001'),
(3, '7Pcs Kuas', 67000.00, 1, 'prokertas.png', 'pt1002'),
(4, 'cat air 20ml', 40000.00, 1, 'procatair.png', 'pt1003'),
(5, 'cover foto A4', 30000.00, 1, 'procover.png', 'pt1004'),
(6, 'pallet', 20000.00, 1, 'propalet.png', 'pt1005'),
(7, 'cat akrilik', 10000.00, 1, 'procat.png', 'pt1006'),
(9, 'A4 Warna Multicolor', 5000.00, 1, 'proMulti.png', 'pt1008'),
(16, '12234', 20000.00, 1, '123', '10001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'ammar', '12345ammar54321raffa'),
(2, 'ammarraffa', '12345'),
(3, 'nur', '567'),
(4, 'nur', '123'),
(5, 'ammarr', '12345ammar54321raffa'),
(6, 'rr', '123'),
(7, '12345', '12345'),
(8, 'raqi', '123');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
