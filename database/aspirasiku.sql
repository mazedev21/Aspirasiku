-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Okt 2024 pada 16.45
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aspirasiku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` int(5) NOT NULL,
  `tgl_aspirasi` varchar(20) NOT NULL,
  `nis` varchar(16) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `isi_laporan` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` enum('proses','selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `tgl_aspirasi`, `nis`, `kategori`, `isi_laporan`, `foto`, `status`) VALUES
(35, '2024-06-05', '9986', 'Kurikulum', 'test', '', 'proses'),
(40, '2024-06-06', '0000', 'Kurikulum', 'test2kurikulum', '', 'selesai'),
(41, '2024-06-06', '0000', 'Kesiswaan', 'test2kesiswaan', '', 'selesai'),
(43, '2024-06-13', '0000', 'Kurikulum', 'testfoto', '', 'proses'),
(44, '2024-06-13', '0000', 'Kurikulum', 'test', '', 'proses'),
(45, '2024-06-13', '0000', 'Kurikulum', 'test', '', 'proses'),
(46, '2024-06-13', '0000', 'Kurikulum', 'test foto', 'noImage.jpg', 'proses'),
(47, '2024-06-13', '0000', 'Kurikulum', 'test foto', '130620242555130220204341itiak.png', 'proses'),
(48, '2024-10-29', '0000', 'Kesiswaan', 'test', 'noImage.jpg', 'selesai'),
(49, '2024-10-29', '', 'Kesiswaan', 'test', 'noImage.jpg', 'proses'),
(50, '2024-10-29', '0000', 'Kesiswaan', 'test', 'noImage.jpg', 'selesai'),
(51, '2024-10-29', '0000', 'Kurikulum', 'test', 'noImage.jpg', 'proses'),
(52, '2024-10-29', '0002', 'Kurikulum', 'test', 'noImage.jpg', 'proses');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(5) NOT NULL,
  `nama_petugas` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','petugas','kurikulum','kesiswaan','sarpra','humas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `username`, `password`, `level`) VALUES
(3, 'Emannuel Henji Pratama Putra', 'henji', '1fdf0b48801318b218208849e390963e', 'admin'),
(4, 'Rahma Syifa Aulia', 'rahma', '2ddbf96e67b1c7d400979c9670d63421', 'admin'),
(6, 'beta.guru', 'beta.guru', '8832a1dc0e0ae8f0d0d83afc8f7c857e', 'petugas'),
(7, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(8, 'Ida Nurkhayati', 'kurikulumsmada', '3a908f550a4561e4e1ae2402052c28a0', 'kurikulum'),
(9, 'Dwi Hendro Noveantoro', 'kesiswaansmada', '3a908f550a4561e4e1ae2402052c28a0', 'kesiswaan'),
(10, 'Triyono', 'sarprasmada', '3a908f550a4561e4e1ae2402052c28a0', 'sarpra'),
(11, 'Gandhy Rudi Mardiwijuni', 'humassmada', '3a908f550a4561e4e1ae2402052c28a0', 'humas'),
(12, 'Pisang', 'pisang', '4dc2a159b17b4725943816b8ba6d7ff5', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(16) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `username`, `password`, `telp`) VALUES
('0000', 'beta.siswa', 'beta.siswa', '20a8f71f06b87054279f09c92ee1cade', '00000000000'),
('10101', 'Muhammad Fachry Juliansyah Yacob ', 'Fachry Juliansyah', '755af6f697f7aeb9a42fdb112c039b9a', 'fachryianspenada@gmail,com'),
('2222', 'Uji Coba', 'ujicoba2', '2a83beb12126c6498998890a31c63e66', 'ujicoba2@gmail.com'),
('22222', 'Baru 2', 'baru2', '72159d2453e4500489ec2943b0d06b3a', 'baru2@gmail.com'),
('222222', 'Baru 2', 'baru2', '72159d2453e4500489ec2943b0d06b3a', 'baru2@gmail.com'),
('2222222', 'Akun Baru 1', 'akunbaru1', 'ce6b2b9cdb448b7878f1be10ac4ffc8e', 'akunbaru1@gmail.com'),
('3333', 'ujicoba1', 'ujicoba1', '4825e93382057b7bf63a0c784308a21c', 'ujicoba1@gmail.com'),
('9986', 'Emannuel Henji Pratama Putra', '9986', '9f5506939986201d55a4353ff8b4028e', '088221281349');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tanggapan`
--

CREATE TABLE `tanggapan` (
  `id_tanggapan` int(5) NOT NULL,
  `id_aspirasi` int(5) NOT NULL,
  `tgl_tanggapan` varchar(20) NOT NULL,
  `tanggapan` text NOT NULL,
  `id_petugas` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tanggapan`
--

INSERT INTO `tanggapan` (`id_tanggapan`, `id_aspirasi`, `tgl_tanggapan`, `tanggapan`, `id_petugas`) VALUES
(1, 1, '2020-02-13', 'berarti awak nan punyo tu mah', 2),
(3, 4, '2023-12-21', 'ya', 3),
(5, 3, '2023-12-26', 'test', 6),
(6, 9, '2023-12-26', 'ya', 3),
(9, 13, '2024-03-08', 'y', 3),
(10, 14, '2024-03-08', 'ya\r\n', 6),
(12, 41, '2024-06-06', 'test', 6),
(13, 40, '2024-06-09', 'oke', 8),
(14, 48, '2024-10-29', 'test', 9),
(15, 50, '2024-10-29', 'test', 9),
(16, 50, '2024-10-29', 'test2', 0),
(17, 50, '2024-10-29', 'test2', 9),
(18, 50, '2024-10-29', 'test', 9);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indeks untuk tabel `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD PRIMARY KEY (`id_tanggapan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `id_tanggapan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
