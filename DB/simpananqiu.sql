-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Nov 2023 pada 04.55
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simpananqiu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`) VALUES
(1, 'Giofany Fauziano', 'admin', '$2y$10$opKzHlw4TznrmqkjHzAchecSbEheKngBEGJ81yzWUlcdUuWhepBM.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aset`
--

CREATE TABLE `aset` (
  `id_aset` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `transaksi` varchar(255) NOT NULL,
  `grup` varchar(255) NOT NULL,
  `nama_aset` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tgl_b` datetime NOT NULL,
  `tgl_e` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `aset`
--

INSERT INTO `aset` (`id_aset`, `id_user`, `transaksi`, `grup`, `nama_aset`, `total`, `deskripsi`, `tgl_b`, `tgl_e`) VALUES
(24, 15, 'Pengeluaran', 'Bank', 'Mandiri', '2343556', 'nnnn', '2023-11-05 12:18:24', '0000-00-00 00:00:00'),
(25, 15, 'Pemasukan', 'Tunai', 'Yaa', '23444', '7', '2023-11-06 12:24:08', '2023-11-06 13:52:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `catat_tabungan`
--

CREATE TABLE `catat_tabungan` (
  `id_catat` int(11) NOT NULL,
  `id_tabungan` int(11) NOT NULL,
  `nominal` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_b` datetime NOT NULL,
  `tgl_e` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `catat_tabungan`
--

INSERT INTO `catat_tabungan` (`id_catat`, `id_tabungan`, `nominal`, `keterangan`, `tgl_b`, `tgl_e`) VALUES
(17, 36, '+20000', NULL, '2023-11-13 09:28:03', NULL),
(18, 36, '-10000', NULL, '2023-11-13 09:28:10', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ganti_password`
--

CREATE TABLE `ganti_password` (
  `id_password` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `transaksi` varchar(50) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `tgl_b` datetime NOT NULL,
  `tgl_e` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `id_user`, `id_admin`, `transaksi`, `nama_kategori`, `tgl_b`, `tgl_e`) VALUES
(357, 15, 0, 'Pemasukan', '1234', '2023-11-07 14:36:03', '2023-11-07 14:36:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keuangan`
--

CREATE TABLE `keuangan` (
  `id_keuangan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_aset` int(11) NOT NULL,
  `nama_keuangan` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `catatan` text NOT NULL,
  `deskripsi` text NOT NULL,
  `tgl_b` datetime NOT NULL,
  `tgl_e` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tgl_b` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kontak`
--

INSERT INTO `kontak` (`id_kontak`, `id_user`, `nama`, `email`, `judul`, `pesan`, `tgl_b`) VALUES
(18, 0, 'Fajar', 'saputradzulkarnain@gmail.com', 'Tentang Pandawa Hotel', 'Halo saya punya problem nich', '2023-10-18 09:33:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `premium`
--

CREATE TABLE `premium` (
  `id_premium` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `tgl_b` datetime NOT NULL,
  `tgl_e` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabungan`
--

CREATE TABLE `tabungan` (
  `id_tabungan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_tabungan` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `rencana` varchar(25) NOT NULL,
  `nominal` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tgl_b` datetime NOT NULL,
  `tgl_e` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabungan`
--

INSERT INTO `tabungan` (`id_tabungan`, `id_user`, `nama_tabungan`, `target`, `rencana`, `nominal`, `gambar`, `tgl_b`, `tgl_e`) VALUES
(36, 15, 'Beli Sepeda', '1500000', 'Harian', '30000', '1699789701_KPK.png', '2023-11-12 18:48:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `username` varchar(25) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `tgl_b` datetime NOT NULL,
  `tgl_e` datetime NOT NULL,
  `status` varchar(25) NOT NULL,
  `vr` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `username`, `gender`, `no_hp`, `email`, `password`, `foto`, `tgl_b`, `tgl_e`, `status`, `vr`) VALUES
(15, 'Fajar Maulana Nugroho Sutardi', 'fajar', 'Laki-Laki', '081223952077', 'saputradzulkarnain@gmail.com', '$2y$10$1YscXfhrnzMlTHbl/eHPWOOu8VieQr82itntnt2uzmXriboOWrw22', '1699156460_1697438626_download.jpg', '2023-11-05 10:54:20', '2023-11-05 10:54:39', '2', '$2y$10$QUMJEuAC5UeubPVxkITfee0GET/lBDhYhWv37qf98Q8J.YynNSADq'),
(16, 'Ahmad Iksal', 'icang', 'Laki-Laki', '081233953958', 'ahmadiksal@gmail.com', '$2y$10$G0rlYrbA7D9qQvT8oSPCAOzetZ7swqlbOfO.wYHkwSCLiJ543Axy2', '1699258292_1697517184_2ee05578feb7ae722f47e5d9e4b8daf0.png', '2023-11-06 15:11:32', '2023-11-06 15:12:11', '2', '$2y$10$I/jvNGwv2PzOMv1evglJG.Aof3wlghbRsxlTlR67KIfprBxXWcNbq');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `aset`
--
ALTER TABLE `aset`
  ADD PRIMARY KEY (`id_aset`);

--
-- Indeks untuk tabel `catat_tabungan`
--
ALTER TABLE `catat_tabungan`
  ADD PRIMARY KEY (`id_catat`);

--
-- Indeks untuk tabel `ganti_password`
--
ALTER TABLE `ganti_password`
  ADD PRIMARY KEY (`id_password`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `keuangan`
--
ALTER TABLE `keuangan`
  ADD PRIMARY KEY (`id_keuangan`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indeks untuk tabel `premium`
--
ALTER TABLE `premium`
  ADD PRIMARY KEY (`id_premium`);

--
-- Indeks untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  ADD PRIMARY KEY (`id_tabungan`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `aset`
--
ALTER TABLE `aset`
  MODIFY `id_aset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `catat_tabungan`
--
ALTER TABLE `catat_tabungan`
  MODIFY `id_catat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `ganti_password`
--
ALTER TABLE `ganti_password`
  MODIFY `id_password` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=358;

--
-- AUTO_INCREMENT untuk tabel `keuangan`
--
ALTER TABLE `keuangan`
  MODIFY `id_keuangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `premium`
--
ALTER TABLE `premium`
  MODIFY `id_premium` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  MODIFY `id_tabungan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
