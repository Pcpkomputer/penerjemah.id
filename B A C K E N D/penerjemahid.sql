-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Agu 2020 pada 18.12
-- Versi server: 10.1.30-MariaDB
-- Versi PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penerjemahid`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id_aktivitas` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `aktivitas`
--

INSERT INTO `aktivitas` (`id_aktivitas`, `id_user`, `deskripsi`) VALUES
(1, 1, 'Baru saja membuka sebuah permintaan di tautan berikut ini %3Cnuxt-link%20to=%22/detail/permintaan/1%22%3E%3C/nuxt-link%3E'),
(2, 2, 'Baru saja membuka sebuah permintaan di tautan berikut ini %3Cnuxt-link%20to=%22/detail/permintaan/1%22%3E%3C/nuxt-link%3E'),
(3, 3, 'Baru saja membuka sebuah permintaan di tautan berikut ini %3Cnuxt-link%20to=%22/detail/permintaan/1%22%3E%3C/nuxt-link%3E'),
(4, 2, 'Baru saja memilih kandidat permintaannya di Ini adalah judul permintaan kedua'),
(5, 2, 'Baru saja memilih kandidat permintaannya di Ini adlaah judul permintaan'),
(6, 2, 'Baru saja memilih kandidat permintaannya di Ini adalah judul permintaan kedua'),
(7, 2, 'Baru saja memilih kandidat permintaannya di Ini adlaah judul permintaan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `captcha`
--

CREATE TABLE `captcha` (
  `id_captcha` int(11) NOT NULL,
  `gambar` char(20) NOT NULL,
  `kunci` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `captcha`
--

INSERT INTO `captcha` (`id_captcha`, `gambar`, `kunci`) VALUES
(1, 'c1.jpg', 'AN1tA'),
(2, 'c2.jpg', 'NvRm4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `emoney`
--

CREATE TABLE `emoney` (
  `id_user` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `prefix` char(1) NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `emoney`
--

INSERT INTO `emoney` (`id_user`, `jumlah`, `prefix`, `tanggal`, `keterangan`) VALUES
(8, 500, '+', '2019-06-27 00:00:00', 'topup'),
(8, 200, '-', '2019-06-28 00:00:00', 'transaksi'),
(8, 100, '+', '2019-06-28 00:00:00', 'topup'),
(2, 500, '+', '2019-06-13 00:00:00', 'topup'),
(7, 100, '+', '2019-06-30 04:06:45', 'penerimaan pembayaran'),
(2, 100, '-', '2019-06-30 04:06:45', 'pembayaran permintaan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jasa`
--

CREATE TABLE `jasa` (
  `id_jasa` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int(11) NOT NULL,
  `waktupengerjaan` int(11) NOT NULL,
  `background` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `tanggaldibuat` date NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jasa`
--

INSERT INTO `jasa` (`id_jasa`, `judul`, `deskripsi`, `harga`, `waktupengerjaan`, `background`, `label`, `tanggaldibuat`, `id_user`) VALUES
(1, 'Ini adalah judul jasa pertama', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet, libero vel dictum maximus, libero nulla vehicula felis, vitae mollis arcu ante sed magna. Proin molestie et quam ut sollicitudin. Duis ut tellus ut mi iaculis dignissim. Curabitur sit amet ultrices arcu. Morbi pharetra, sem vel sagittis lacinia, libero leo semper orci, quis porttitor arcu metus imperdiet ex. Etiam sem est, cursus vel vulputate sed, consectetur eu tortor. Donec condimentum ante at mauris porta sodales.\r\n\r\nMaecenas aliquet et lacus a faucibus. Curabitur malesuada elit sed massa bibendum, ac tempus ligula fringilla. Vivamus pulvinar eu neque a varius. Fusce hendrerit, justo et congue porta, ex felis dictum mi, vel dictum lorem odio a arcu. Ut tincidunt elementum rhoncus. Praesent congue aliquam enim, et eleifend lectus. Aliquam erat volutpat. Integer pharetra erat non aliquam vehicula. Sed vitae augue at dolor semper ultrices eget vel dui. Phasellus sit amet laoreet nulla, ac suscipit nisl. Nulla placerat vel lorem at rhoncus. Fusce vulputate laoreet ipsum sit amet maximus. Praesent turpis elit, egestas id elit vitae, egestas mollis ante. Donec viverra fringilla sollicitudin. Nulla tempor quam vitae vulputate suscipit.', 500000, 3, 'https://cdn.projects.co.id/upload/usre70413/201901145c3be815692d4.jpg', 'Penerjemah,Label2,Label3', '0000-00-00', 1),
(2, 'Ini adalah judul jasa ketiga', '<p style=\"margin-bottom:0px;\">sadasdsad</p><br><p style=\"margin-bottom:0px;\">asdsadsadsadasd</p>', 1000000, 2, 'https://cdn.projects.co.id/upload/usre70413/201901145c3be815692d4.jpg', 'Label,Penerjemah', '0000-00-00', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentarjasa`
--

CREATE TABLE `komentarjasa` (
  `id_user` int(11) NOT NULL,
  `id_jasa` int(11) NOT NULL,
  `komentar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `komentarjasa`
--

INSERT INTO `komentarjasa` (`id_user`, `id_jasa`, `komentar`) VALUES
(2, 1, 'memek kalian'),
(1, 1, 'hahaha kintil'),
(2, 2, 'asdsad'),
(2, 2, 'lele banget');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lockedfile`
--

CREATE TABLE `lockedfile` (
  `id_permintaan` int(11) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `file` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `lockedfile`
--

INSERT INTO `lockedfile` (`id_permintaan`, `locked`, `file`) VALUES
(6, 1, 'g3mz5sqaCURmuLF2R7ER7HNb8.ass');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_permintaan` int(11) DEFAULT NULL,
  `id_jasa` int(11) DEFAULT NULL,
  `dibaca` tinyint(1) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `id_user`, `id_permintaan`, `id_jasa`, `dibaca`, `keterangan`) VALUES
(1, 2, 6, NULL, 1, 'Permintaan Anda yang berjudul Ini adlaah judul per'),
(2, 2, 6, NULL, 1, 'Permintaan Anda yang berjudul Ini adlaah judul permintaan baru saja diselesaikan oleh kandidat pilihan Anda'),
(3, 2, 6, NULL, 1, 'Permintaan Anda yang berjudul Ini adlaah judul permintaan baru saja diselesaikan oleh kandidat pilihan Anda'),
(4, 2, 1, NULL, 1, 'Anda diundang untuk mengikuti suatu permintaan oleh pemiliknya.'),
(5, 2, 1, NULL, 1, 'Anda diundang untuk mengikuti suatu permintaan oleh pemiliknya.'),
(6, 2, 1, NULL, 1, 'Anda diundang untuk mengikuti suatu permintaan oleh pemiliknya.'),
(7, 1, 2, NULL, 1, 'Anda diundang untuk mengikuti suatu permintaan oleh pemiliknya.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerjaterpilihpermintaan`
--

CREATE TABLE `pekerjaterpilihpermintaan` (
  `id_permintaan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pekerjaterpilihpermintaan`
--

INSERT INTO `pekerjaterpilihpermintaan` (`id_permintaan`, `id_user`, `file`, `deskripsi`, `deadline`) VALUES
(6, 7, '5d178a39e565e.pdf', 'xzcxzcxzczxc', '2019-07-04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penaruh`
--

CREATE TABLE `penaruh` (
  `id_user` int(11) NOT NULL,
  `id_permintaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penaruh`
--

INSERT INTO `penaruh` (`id_user`, `id_permintaan`) VALUES
(2, 1),
(7, 2),
(1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan`
--

CREATE TABLE `permintaan` (
  `id_permintaan` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `tanggaldibuat` date NOT NULL,
  `harga` int(11) NOT NULL,
  `jangkawaktu` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `permintaan`
--

INSERT INTO `permintaan` (`id_permintaan`, `judul`, `deskripsi`, `kategori`, `label`, `tanggaldibuat`, `harga`, `jangkawaktu`, `status`, `id_user`) VALUES
(1, 'Ini adalah judul permintaan pertama', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sit amet libero massa. Sed in tellus leo. Curabitur maximus a felis vitae porta. Sed vel metus in lorem ullamcorper dapibus. Pellentesque diam lectus, sodales sit amet erat eget, ultricies rhoncus lectus. Donec dui nunc, eleifend vitae ex eu, dictum ornare ipsum. Suspendisse venenatis nulla sit amet dolor ultrices aliquam. Mauris bibendum dolor sagittis, sollicitudin nunc non, elementum lorem. Cras sit amet blandit quam, vel ullamcorper ipsum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.\r\n\r\nFusce ornare a lorem vitae ornare. Proin enim neque, tristique in porttitor eget, placerat et leo. Aliquam gravida bibendum orci, id dapibus elit lobortis sed. Ut pharetra semper quam at aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi ex eros, ultricies at felis sit amet, auctor pharetra justo. Curabitur at fringilla mauris, ut tincidunt justo. Donec cursus erat a mauris fringilla consequat. Nullam vitae tortor nisl. Cras egestas metus vitae purus tempus, quis pulvinar est blandit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam vel maximus metus. Phasellus rutrum tristique nunc, ac placerat lacus maximus ac. Cras vel odio eget massa pretium condimentum eget a nisl. Proin finibus suscipit est. Nam vel neque at risus efficitur condimentum vel et orci.', 'Penerjemah', '', '2019-06-18', 150000, 3, 'published', 1),
(2, 'Ini adalah judul permintaan kedua', '<p style=\"margin-bottom:0px;\">sadasdsad</p><p style=\"margin-bottom:0px;\">asdasdasdsadsad</p><br><p style=\"margin-bottom:0px;\">asdsadsadsa</p>', 'Penerjemah', 'Meme,Review,Dank', '2019-06-18', 300000, 2, 'published', 2),
(6, 'Ini adlaah judul permintaan', '<p style=\"margin-bottom:0px;\">testing1234</p>', 'Interpreter', 'asd', '2019-06-29', 50000, 5, 'finished', 2),
(7, 'testing123', '<p style=\"margin-bottom:0px;\">asdsadsadsad</p>', 'Penerjemah', 'asdasd', '2019-07-04', 500000, 1, 'published', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `portofolio`
--

CREATE TABLE `portofolio` (
  `id_user` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `isi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `portofolio`
--

INSERT INTO `portofolio` (`id_user`, `gambar`, `isi`) VALUES
(2, '5d1727606f845.png', 'tes sadassa'),
(2, '5d1727f9be125.png', 'tai kuda'),
(2, '5d1728ca54c05.png', 'tescoba 123'),
(7, '5d17e5b0d92fa.png', 'dfgdfg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `id_pemberirating` int(11) NOT NULL,
  `id_penerimarating` int(11) NOT NULL,
  `nilai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rating`
--

INSERT INTO `rating` (`id_pemberirating`, `id_penerimarating`, `nilai`) VALUES
(2, 1, 80),
(3, 1, 60),
(1, 2, 20),
(3, 2, 80);

-- --------------------------------------------------------

--
-- Struktur dari tabel `undangan`
--

CREATE TABLE `undangan` (
  `id_user` int(11) NOT NULL,
  `id_permintaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `undangan`
--

INSERT INTO `undangan` (`id_user`, `id_permintaan`) VALUES
(2, 1),
(2, 1),
(2, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `namalengkap` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggaldibuat` date NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  `kabupaten` varchar(50) NOT NULL,
  `terakhirlogin` datetime DEFAULT NULL,
  `avatar` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `email`, `username`, `password`, `namalengkap`, `deskripsi`, `tanggaldibuat`, `provinsi`, `kabupaten`, `terakhirlogin`, `avatar`, `token`) VALUES
(1, '', 'terrificsubs', 'p3rw1rapc', 'Padang Perwira Yudha', '', '2019-06-18', 'Jawa Timur', 'Pacitan', '2019-06-18 06:18:24', '5d14a50222693.jpg', '18XoczxxQWGQcMN'),
(2, '', 'ellysazh', 'p3rw1rapc', 'Ellysa R Azhaari', '<p style=\"margin-bottom:0px;\">Halo namaku anita!</p>', '2019-06-18', 'Jawa Tengah', 'Cilacap', '2019-06-17 06:12:00', '5d14a70dc08e6.jpg', 'OzhTSVe5aaM3Hq8'),
(3, '', 'taufiqnurmaulana', 'taufiqnurmaulana', 'Taufiq Nur Maulana', '', '2019-06-20', 'Jawa Tengah', 'Karanganyar', '2019-06-19 05:24:08', 'taufiq.jpg', 'sadas213j.knasoasion'),
(7, 'asdsadsa@gmail.com', 'terrific', 'tete123', 'tete 123', '<p style=\"margin-bottom:0px;\">asdsadsadsadsa</p><br><p style=\"margin-bottom:0px;\">asdsads</p><br><p style=\"margin-bottom:0px;\">asdsadsasadsad</p><br><p style=\"margin-bottom:0px;\">asdsad</p><br><p style=\"margin-bottom:0px;\">asdsadsadsadsad  asdsadsa</p><br><p style=\"margin-bottom:0px;\">asdsadsa</p>', '2019-06-27', 'sadasd', 'zzzz', '0000-00-00 00:00:00', '5d14a50222693.jpg', 'c13mEiZ2SWmWmUr'),
(8, 'tempik@gmail.com', 'tempik', 'p3rrrww11', 'sadsadsadsad', '<p style=\"margin-bottom:0px;\">sadasdsa    anana</p><br><p style=\"margin-bottom:0px;\">sadasdsadsad</p><br><p style=\"margin-bottom:0px;\">asdkjlasdjlsakjklda</p><br><p style=\"margin-bottom:0px;\">amama amama mantap cokkkk</p>', '2019-06-27', 'aaa', 'xxxxx', '0000-00-00 00:00:00', '5d14a70dc08e6.jpg', 'YXHiRwejugPKI8Z');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`id_aktivitas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `captcha`
--
ALTER TABLE `captcha`
  ADD PRIMARY KEY (`id_captcha`);

--
-- Indeks untuk tabel `emoney`
--
ALTER TABLE `emoney`
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `jasa`
--
ALTER TABLE `jasa`
  ADD PRIMARY KEY (`id_jasa`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `komentarjasa`
--
ALTER TABLE `komentarjasa`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_jasa` (`id_jasa`);

--
-- Indeks untuk tabel `lockedfile`
--
ALTER TABLE `lockedfile`
  ADD KEY `id_permintaan` (`id_permintaan`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_permintaan` (`id_permintaan`),
  ADD KEY `id_jasa` (`id_jasa`);

--
-- Indeks untuk tabel `pekerjaterpilihpermintaan`
--
ALTER TABLE `pekerjaterpilihpermintaan`
  ADD KEY `pekerjaterpilihpermintaan_ibfk_1` (`id_permintaan`),
  ADD KEY `pekerjaterpilihpermintaan_ibfk_2` (`id_user`);

--
-- Indeks untuk tabel `penaruh`
--
ALTER TABLE `penaruh`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_permintaan` (`id_permintaan`);

--
-- Indeks untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id_permintaan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `portofolio`
--
ALTER TABLE `portofolio`
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD KEY `id_pemberirating` (`id_pemberirating`),
  ADD KEY `id_penerimarating` (`id_penerimarating`);

--
-- Indeks untuk tabel `undangan`
--
ALTER TABLE `undangan`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_permintaan` (`id_permintaan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`,`email`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id_aktivitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `captcha`
--
ALTER TABLE `captcha`
  MODIFY `id_captcha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jasa`
--
ALTER TABLE `jasa`
  MODIFY `id_jasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id_permintaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD CONSTRAINT `aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `emoney`
--
ALTER TABLE `emoney`
  ADD CONSTRAINT `emoney_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jasa`
--
ALTER TABLE `jasa`
  ADD CONSTRAINT `jasa_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komentarjasa`
--
ALTER TABLE `komentarjasa`
  ADD CONSTRAINT `komentarjasa_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `komentarjasa_ibfk_2` FOREIGN KEY (`id_jasa`) REFERENCES `jasa` (`id_jasa`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lockedfile`
--
ALTER TABLE `lockedfile`
  ADD CONSTRAINT `lockedfile_ibfk_1` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan` (`id_permintaan`);

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasi_ibfk_2` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan` (`id_permintaan`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasi_ibfk_3` FOREIGN KEY (`id_jasa`) REFERENCES `jasa` (`id_jasa`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pekerjaterpilihpermintaan`
--
ALTER TABLE `pekerjaterpilihpermintaan`
  ADD CONSTRAINT `pekerjaterpilihpermintaan_ibfk_1` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan` (`id_permintaan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pekerjaterpilihpermintaan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penaruh`
--
ALTER TABLE `penaruh`
  ADD CONSTRAINT `penaruh_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `penaruh_ibfk_2` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan` (`id_permintaan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  ADD CONSTRAINT `permintaan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `portofolio`
--
ALTER TABLE `portofolio`
  ADD CONSTRAINT `portofolio_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`id_pemberirating`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`id_penerimarating`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `undangan`
--
ALTER TABLE `undangan`
  ADD CONSTRAINT `undangan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `undangan_ibfk_2` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan` (`id_permintaan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
