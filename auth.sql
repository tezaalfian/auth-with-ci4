-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Nov 2020 pada 06.38
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_spu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` varchar(128) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `jk`, `email`, `no_hp`, `foto`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('1605656263', 'admin', '$2y$10$zUWXutLl2C.xbDD9KGtyYups3Y6ZHhjLzPq.cyGG.nmQ8yWwTKxsO', 'Tahfizh Dulido', NULL, '', '', 'v1605616492/spu-app/users/1605616208', 1, '2020-11-17 06:30:11', '2020-11-17 06:30:11', NULL),
('1605661219', 'alfian', '$2y$10$zxyIFac8AHalf9AVJi1biePuv.jAm1OIUDdWoQq.syL3AOJUwbjJm', 'Teza Alfian', NULL, 'teza@tahfizhdulido.com', '085719994048', 'v1605661503/spu-app/users/1605661219', 1, '2020-11-17 19:00:21', '2020-11-17 19:00:21', NULL),
('1605728016', 'ahmad', '$2y$10$5wOl8KZHGlI52Ng8mTJabuvf8aPms8KmAHTgkzaCM99V/.gTtb4Mi', 'ahmad juna', NULL, '', '', 'v1605594452/spu-app/users/default.png', 1, '2020-11-18 13:33:36', '2020-11-18 13:40:55', '2020-11-18 13:40:55'),
('1605738092', 'tes', '$2y$10$3lphXkNhxQX3pMF.IA.fPO/mW/GL1l1nCpj.Ew1974wrvff6sDaE.', 'tes nama', NULL, '', '', 'v1605594452/spu-app/users/default.png', 1, '2020-11-18 16:21:32', '2020-11-18 16:21:54', '2020-11-18 16:21:54'),
('1605799668', 'rahmat', '$2y$10$dNKlHeHaJTwZtaGRnPcMxOIobzwcxhAJ08Bz1ReO1.xZmyWLNFXs2', 'Rahmat Akbar', NULL, 'rahmat@tahfizhdulido.com', '', 'v1605594452/spu-app/users/default.png', 1, '2020-11-19 09:27:48', '2020-11-19 09:27:48', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_access_menu`
--

CREATE TABLE `users_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users_access_menu`
--

INSERT INTO `users_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(7, 1, 1),
(8, 1, 4),
(9, 1, 5),
(10, 2, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_menu`
--

CREATE TABLE `users_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(125) DEFAULT NULL,
  `icon` varchar(125) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users_menu`
--

INSERT INTO `users_menu` (`id`, `menu`, `icon`) VALUES
(1, 'Users', 'fa fa-users'),
(4, 'Menu', 'fa fa-folder'),
(5, 'Dashboard', 'fas fa-laptop');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_role`
--

CREATE TABLE `users_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users_role`
--

INSERT INTO `users_role` (`id`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', '2020-11-18 00:00:00', '2020-11-18 00:00:00', NULL),
(2, 'lembaga', '2020-11-18 00:00:00', '2020-11-18 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_role_access`
--

CREATE TABLE `users_role_access` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `user_id` char(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users_role_access`
--

INSERT INTO `users_role_access` (`id`, `role_id`, `user_id`) VALUES
(1, 1, '1605656263'),
(2, 2, '1605656263'),
(3, 1, '1605661219'),
(4, 2, '1605661219'),
(13, 2, '1605799668');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_sub_menu`
--

CREATE TABLE `users_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `title` varchar(125) DEFAULT NULL,
  `url` varchar(125) DEFAULT NULL,
  `icon` varchar(125) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users_sub_menu`
--

INSERT INTO `users_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(3, 4, 'Menu Management', 'menu', 'fa fa-circle-o', 1),
(4, 4, 'Sub Menu Management', 'menu/submenu', 'fa fa-circle-o', 1),
(5, 1, 'Data Users', 'users', 'fa fa-circle-o', 1),
(6, 1, 'User Role', 'users/role', 'fa fa-circle-o', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users_access_menu`
--
ALTER TABLE `users_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users_menu`
--
ALTER TABLE `users_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users_role_access`
--
ALTER TABLE `users_role_access`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users_sub_menu`
--
ALTER TABLE `users_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users_access_menu`
--
ALTER TABLE `users_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users_menu`
--
ALTER TABLE `users_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users_role`
--
ALTER TABLE `users_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users_role_access`
--
ALTER TABLE `users_role_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `users_sub_menu`
--
ALTER TABLE `users_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
