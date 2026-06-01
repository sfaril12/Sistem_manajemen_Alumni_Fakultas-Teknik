-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jan 2026 pada 01.12
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
-- Database: `si_alumni_kusioner`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `pasword` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id_admin`, `nama`, `pasword`, `email`) VALUES
(1, 'faryushin', 'faryushin123', 'faryu@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban`
--

CREATE TABLE `jawaban` (
  `id_jawaban` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pertanyaan` int(11) NOT NULL,
  `jawaban_pertanyaan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jawaban`
--

INSERT INTO `jawaban` (`id_jawaban`, `id_user`, `id_pertanyaan`, `jawaban_pertanyaan`) VALUES
(9, 3, 1, 'bekerja'),
(10, 3, 2, 'kurang dari satu hari'),
(11, 3, 3, 'desaigner'),
(12, 3, 4, 'cukup sesuai'),
(13, 3, 5, 'ngoding'),
(14, 3, 6, 'cukup'),
(15, 3, 7, 'soft skill bahasa inggris'),
(16, 3, 8, 'ya'),
(17, 4, 29, 'merah'),
(18, 4, 30, 'biru'),
(19, 4, 31, 'ya'),
(20, 4, 32, 'it server'),
(21, 4, 33, 'bahasa inggris'),
(22, 4, 1, 'santai'),
(23, 4, 2, 'kurang dari satu tahun'),
(24, 4, 3, 'programmer'),
(25, 4, 4, 'cukup sesuai saya tidak kehilangan jati diri jurusan'),
(26, 4, 5, 'bisa ngoding PHP'),
(27, 4, 6, 'belum cukup'),
(28, 4, 7, 'bahasa arab'),
(29, 4, 8, 'ya'),
(30, 7, 1, 'cari kerja'),
(31, 7, 2, 'kurang dari satu bulan'),
(32, 7, 3, 'sedang menjadi teknisi server di kantor telkom indonesia'),
(33, 7, 4, 'saya merasa tidak sesuai karena semasa kuliah saya mengambil jurusan desainer tetapi di dunia kerja saya menjadi teknisi server'),
(34, 7, 5, 'skill editing dan desain'),
(35, 7, 6, 'cukup'),
(36, 7, 7, 'cara problem solving'),
(37, 7, 8, 'ya'),
(38, 7, 29, 'menyanyi'),
(39, 7, 30, 'nila'),
(40, 7, 31, 'tidak'),
(41, 7, 32, 'teknisi dan monitoring server'),
(42, 7, 33, 'bahasa jepang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kusioner`
--

CREATE TABLE `kusioner` (
  `id_kusioner` int(11) NOT NULL,
  `judul_kusioner` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `terbit_kusioner` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kusioner`
--

INSERT INTO `kusioner` (`id_kusioner`, `judul_kusioner`, `deskripsi`, `terbit_kusioner`) VALUES
(1, 'Kuesioner Data Kondisi Alumni Setelah Lulus', 'Kuesioner ini bertujuan untuk mengumpulkan data mengenai kondisi alumni setelah lulus, meliputi aktivitas utama, bidang pekerjaan atau studi lanjut, serta kesesuaian pendidikan dengan kebutuhan setelah lulus.\r\nData yang diperoleh digunakan sebagai bahan evaluasi dan pengembangan institusi, khususnya dalam peningkatan kualitas lulusan.', '2026-01-14 03:21:46'),
(5, 'kusioner ke 2', 'ini kusioner', '2025-01-15 13:32:40'),
(6, 'kusioner ke 3', 'data alumni', '2024-01-15 13:34:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `opsi_radio`
--

CREATE TABLE `opsi_radio` (
  `id_opsi` int(11) NOT NULL,
  `id_pertanyaan` int(11) NOT NULL,
  `label_opsi` varchar(255) NOT NULL,
  `value_opsi` varchar(100) NOT NULL,
  `urutan` int(11) DEFAULT 1,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `opsi_radio`
--

INSERT INTO `opsi_radio` (`id_opsi`, `id_pertanyaan`, `label_opsi`, `value_opsi`, `urutan`, `is_active`) VALUES
(1, 1, 'Bekerja', 'bekerja', 1, 1),
(2, 1, 'Mencari Pekerjaan', 'cari kerja', 2, 1),
(3, 1, 'Santai', 'santai', 3, 1),
(4, 2, '< 1 hari', 'kurang dari satu hari', 1, 1),
(5, 2, '< 1 bulan', 'kurang dari satu bulan', 2, 1),
(6, 2, '< 1 tahun', 'kurang dari satu tahun', 3, 1),
(7, 2, '> 1 tahun', 'lebih dari satu tahun', 4, 1),
(8, 6, 'Cukup', 'cukup', 1, 1),
(9, 6, 'Belum Cukup', 'belum cukup', 2, 1),
(10, 8, 'Ya', 'ya', 1, 1),
(11, 8, 'Tidak', 'tidak', 2, 1),
(17, 30, 'merah ', 'merah ', 1, 1),
(18, 30, 'biru', 'biru', 2, 1),
(19, 30, 'nila', 'nila', 3, 1),
(20, 31, 'ya', 'ya', 1, 1),
(21, 31, 'tidak', 'tidak', 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id_pertanyaan` int(11) NOT NULL,
  `id_kusioner` int(11) NOT NULL,
  `text_pertanyaan` text NOT NULL,
  `tipe_pertanyaan` enum('text','radio') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pertanyaan`
--

INSERT INTO `pertanyaan` (`id_pertanyaan`, `id_kusioner`, `text_pertanyaan`, `tipe_pertanyaan`) VALUES
(1, 1, 'Apa aktivitas utama Anda saat ini setelah lulus?', 'radio'),
(2, 1, 'Berapa lama waktu yang Anda butuhkan untuk mendapatkan aktivitas utama setelah lulus?', 'radio'),
(3, 1, 'Bidang pekerjaan atau aktivitas yang sedang Anda jalani saat ini?', 'text'),
(4, 1, 'Seberapa sesuai bidang studi yang Anda tempuh dengan aktivitas Anda saat ini?', 'text'),
(5, 1, 'Kompetensi apa yang paling membantu Anda setelah lulus?', 'text'),
(6, 1, 'Apakah pendidikan yang Anda peroleh sudah cukup membekali Anda untuk dunia kerja atau studi lanjut?', 'radio'),
(7, 1, 'Kompetensi apa yang menurut Anda masih kurang dan perlu ditingkatkan pada mahasiswa?', 'text'),
(8, 1, 'Apakah Anda bersedia berkontribusi dalam kegiatan alumni atau kampus?', 'radio'),
(29, 5, 'apa kesukaanmu', 'text'),
(30, 5, 'apa warna kesukaanmu', 'radio'),
(31, 6, 'sekarang sedang melamar pekerjaan atau tidak', 'radio'),
(32, 6, 'apa pekerjaanmu sekarang', 'text'),
(33, 6, 'apa yang ingin kamu kembangkan sekarang\r\n', 'text');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_alumni`
--

CREATE TABLE `profil_alumni` (
  `id_alumni` int(50) NOT NULL,
  `id_user` int(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `tahun_lulus` year(4) NOT NULL,
  `program_studi` varchar(100) NOT NULL,
  `asal_universitas` varchar(100) NOT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `instansi` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profil_alumni`
--

INSERT INTO `profil_alumni` (`id_alumni`, `id_user`, `nama`, `nim`, `tahun_lulus`, `program_studi`, `asal_universitas`, `pekerjaan`, `instansi`, `tanggal_lahir`) VALUES
(1, 3, 'SULAIMAN', 'E1E121093', '2026', 'Teknik Informatika', 'Universitas Halu Oleo', 'Sudah bekerja sebagai IT Support di perusahaan tambang', 'PT Tambang Morowali Indonesia', '1999-04-12'),
(2, 4, 'RINA', 'E1E121089', '2026', 'Teknik Informatika', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Admin IT', 'CV Tech Solution Kendari', '2000-01-25'),
(3, 5, 'ARNITA', 'E1E120060', '2026', 'Teknik Informatika', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '2000-09-10'),
(4, 6, 'NAFARUDIN', 'E1E107034', '2013', 'Teknik Informatika', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '1999-02-28'),
(5, 7, 'HARJUNI', 'E1E107072', '2016', 'Teknik Informatika', 'Universitas Halu Oleo', 'Sudah bekerja sebagai IT Support di perusahaan tambang', 'PT Industri Nikel Morowali', '1998-10-14'),
(6, 8, 'SAFRILLAH', 'E1E107003', '2016', 'Teknik Informatika', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '1999-07-19'),
(7, 9, 'AKBAR', 'E1E114047', '2021', 'Teknik Informatika', 'Universitas Halu Oleo', 'Sudah bekerja sebagai IT Support di perusahaan tambang', 'PT Nikel Sulawesi Mining', '1998-06-30'),
(8, 10, 'FADLIN', 'E1E109072', '2016', 'Teknik Informatika', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Mobile App Developer', 'Startup Aplikasi Nusantara', '1999-12-02'),
(9, 11, 'MILAWATI', 'E1E117017', '2024', 'Teknik Informatika', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '2000-03-08'),
(10, 12, 'SARTINA', 'E1E109021', '2017', 'Teknik Informatika', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '2000-11-21'),
(11, 13, 'SABARULLAH HALI', 'E1D114033', '2019', 'Teknik Elektro', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Teknisi Listrik', 'PT Energi Listrik Sulawesi', '1998-03-12'),
(12, 14, 'BAKHTIAR', 'E1D214012', '2015', 'Teknik Elektro', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '2000-07-21'),
(13, 15, 'SABRI', 'E1D120105', '2026', 'Teknik Elektro', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Operator Panel Listrik', 'PLN UP3 Kendari', '1997-11-05'),
(14, 16, 'IDIL', 'E1D120046', '2026', 'Teknik Elektro', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '2001-01-30'),
(15, 17, 'ALYASIR', 'E1D120003', '2025', 'Teknik Elektro', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Teknisi Jaringan', 'PT Telekomunikasi Indonesia', '1996-06-18'),
(16, 18, 'RUSTAM', 'E1C119070', '2024', 'Teknik Mesin', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Mekanik Industri', 'PT Industri Baja Nasional', '1996-09-18'),
(17, 19, 'RAHMAN', 'E1C118019', '2025', 'Teknik Mesin', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Teknisi Mesin', 'PT Perkasa Manufaktur', '1997-12-05'),
(18, 20, 'LINTON', 'E1C118050', '2025', 'Teknik Mesin', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '2001-04-27'),
(19, 21, 'AZIT', 'P3C122016', '2026', 'Teknik Mesin', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '2000-01-11'),
(20, 22, 'SISIL AZIZAH AMELIA', 'E1A117092', '2021', 'Teknik Sipil', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '1999-05-12'),
(21, 23, 'JHOSIARDAN', 'P3A118012', '2022', 'Teknik Sipil', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '2000-08-21'),
(22, 24, 'SARIFUDIN', 'P3A114114', '2018', 'Teknik Sipil', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '1996-11-03'),
(23, 25, 'RIZKY', 'P3A123032', '2023', 'Teknik Sipil', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '2001-02-14'),
(24, 26, 'AMRAN', 'E1A125033', '2025', 'Teknik Sipil', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '2003-06-30'),
(25, 27, 'BUHARDIMAN', 'P3A122013', '2022', 'Teknik Sipil', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Pelaksana Lapangan', 'PT Nusantara Konstruksi', '2000-01-09'),
(26, 28, 'ARHAM', 'E1A121066', '2023', 'Teknik Sipil', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Surveyor', 'PT Bina Karya', '2001-12-19'),
(27, 29, 'SYARA', 'P3A121053', '2023', 'Teknik Sipil', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Staff Teknik', 'CV Konstruksi Mandiri', '2001-03-25'),
(28, 30, 'HASMAWATI', 'E1A121074', '2023', 'Teknik Sipil', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Drafter', 'CV Mitra Teknik', '2001-07-18'),
(29, 31, 'ARAHMAN', 'E1A120047', '2022', 'Teknik Sipil', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Site Engineer', 'PT Cipta Karya', '2000-09-05'),
(30, 32, 'IBNU HAJAR HABU', 'E3B100014', '2019', 'Teknik Arsitektur', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '1997-04-10'),
(31, 33, 'NILSAM', 'P3B123051', '2020', 'Teknik Arsitektur', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '1998-10-22'),
(32, 34, 'ELAVISTASARI', 'P3B122019', '2021', 'Teknik Arsitektur', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '1998-06-15'),
(33, 35, 'ADRIAN', 'P3B121002', '2022', 'Teknik Arsitektur', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '1997-01-27'),
(34, 36, 'ASRANDI', 'P3B122014', '2023', 'Teknik Arsitektur', 'Universitas Halu Oleo', 'Belum bekerja', 'Tidak ada', '1998-08-09'),
(35, 37, 'FITRIANI', 'P3B116082', '2019', 'Teknik Arsitektur', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Drafter', 'Studio Arsitek Nusantara', '1996-02-16'),
(36, 38, 'IRMAWAN', 'E3B113021', '2020', 'Teknik Arsitektur', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Visualisasi 3D', 'PT Arsitek Muda', '1996-11-04'),
(37, 39, 'JANUARI', 'P3B117040', '2021', 'Teknik Arsitektur', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Junior Architect', 'CV Desain Kreatif', '1997-09-13'),
(38, 40, 'RESKIYANI', 'P3B114045', '2022', 'Teknik Arsitektur', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Interior Designer', 'PT Cipta Ruang', '1996-05-28'),
(39, 41, 'KAISAR', 'P3B117042', '2023', 'Teknik Arsitektur', 'Universitas Halu Oleo', 'Sudah bekerja sebagai Site Architect', 'PT Tata Ruang Indonesia', '1997-12-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `waktu_buat_akun` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `waktu_buat_akun`) VALUES
(3, 'sulaiman', 'sulaiman123', 'sulaiman@gmail.com', '2026-01-13 01:33:27'),
(4, 'rina', 'rina123', 'rina@gmail.com', '2026-01-13 01:33:27'),
(5, 'arnita', 'arnita123', 'arnita@gmail.com', '2026-01-13 01:33:27'),
(6, 'nafarudin', 'nafarudin123', 'nafarudin@gmail.com', '2026-01-13 01:33:27'),
(7, 'harjuni', 'harjuni123', 'harjuni@gmail.com', '2026-01-13 01:33:27'),
(8, 'safrillah', 'safrillah123', 'safrillah@gmail.com', '2026-01-13 01:33:27'),
(9, 'akbar', 'akbar123', 'akbar@gmail.com', '2026-01-13 01:33:27'),
(10, 'fadlin', 'fadlin123', 'fadlin@gmail.com', '2026-01-13 01:33:27'),
(11, 'milawati', 'milawati123', 'milawati@gmail.com', '2026-01-13 01:33:27'),
(12, 'sartina', 'sartina123', 'sartina@gmail.com', '2026-01-13 01:33:27'),
(13, 'sabarullah', 'sabarullah123', 'sabarullah@gmail.com', '2026-01-13 01:36:16'),
(14, 'bakhtiar', 'bakhtiar123', 'bakhtiar@gmail.com', '2026-01-13 01:36:16'),
(15, 'sabri', 'sabri123', 'sabri@gmail.com', '2026-01-13 01:36:16'),
(16, 'idil', 'idil123', 'idil@gmail.com', '2026-01-13 01:36:16'),
(17, 'alyasir', 'alyasir123', 'alyasir@gmail.com', '2026-01-13 01:36:16'),
(18, 'rustam', 'rustam123', 'rustam@gmail.com', '2026-01-13 01:38:18'),
(19, 'rahman', 'rahman123', 'rahman@gmail.com', '2026-01-13 01:38:18'),
(20, 'linton', 'linton123', 'linton@gmail.com', '2026-01-13 01:38:18'),
(21, 'azit', 'azit123', 'azit@gmail.com', '2026-01-13 01:38:18'),
(22, 'sisilazizah', 'sisilazizah123', 'sisilazizah@gmail.com', '2026-01-14 04:30:54'),
(23, 'jhosiardan', 'jhosiardan123', 'jhosiardan@gmail.com', '2026-01-14 04:30:54'),
(24, 'sarifudin', 'sarifudin123', 'sarifudin@gmail.com', '2026-01-14 04:30:54'),
(25, 'rizky', 'rizky123', 'rizky@gmail.com', '2026-01-14 04:30:54'),
(26, 'amran', 'amran123', 'amran@gmail.com', '2026-01-14 04:30:54'),
(27, 'buhardiman', 'buhardiman123', 'buhardiman@gmail.com', '2026-01-14 04:30:54'),
(28, 'arham', 'arham123', 'arham@gmail.com', '2026-01-14 04:30:54'),
(29, 'syara', 'syara123', 'syara@gmail.com', '2026-01-14 04:30:54'),
(30, 'hasmawati', 'hasmawati123', 'hasmawati@gmail.com', '2026-01-14 04:30:54'),
(31, 'arahman', 'arahman123', 'arahman@gmail.com', '2026-01-14 04:30:54'),
(32, 'ibnuhajarhabu', 'ibnuhajarhabu123', 'ibnuhajarhabu@gmail.com', '2026-01-15 02:02:01'),
(33, 'nilsam', 'nilsam123', 'nilsam@gmail.com', '2026-01-15 02:03:15'),
(34, 'elavistasari', 'elavistasari123', 'elavistasari@gmail.com', '2026-01-15 02:03:15'),
(35, 'adrian', 'adrian123', 'adrian@gmail.com', '2026-01-15 02:03:15'),
(36, 'asrandi', 'asrandi123', 'asrandi@gmail.com', '2026-01-15 02:03:15'),
(37, 'fitriani', 'fitriani123', 'fitriani@gmail.com', '2026-01-15 02:03:15'),
(38, 'irmawan', 'irmawan123', 'irmawan@gmail.com', '2026-01-15 02:03:15'),
(39, 'januari', 'januari123', 'januari@gmail.com', '2026-01-15 02:03:15'),
(40, 'reskiyani', 'reskiyani123', 'reskiyani@gmail.com', '2026-01-15 02:03:15'),
(41, 'kaisar', 'kaisar123', 'kaisar@gmail.com', '2026-01-15 02:03:15');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD UNIQUE KEY `uq_user_pertanyaan` (`id_user`,`id_pertanyaan`),
  ADD KEY `fk_jawaban_pertanyaan` (`id_pertanyaan`);

--
-- Indeks untuk tabel `kusioner`
--
ALTER TABLE `kusioner`
  ADD PRIMARY KEY (`id_kusioner`);

--
-- Indeks untuk tabel `opsi_radio`
--
ALTER TABLE `opsi_radio`
  ADD PRIMARY KEY (`id_opsi`),
  ADD KEY `id_pertanyaan` (`id_pertanyaan`);

--
-- Indeks untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id_pertanyaan`),
  ADD KEY `fk_pertanyaan_kusioner` (`id_kusioner`);

--
-- Indeks untuk tabel `profil_alumni`
--
ALTER TABLE `profil_alumni`
  ADD PRIMARY KEY (`id_alumni`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `kusioner`
--
ALTER TABLE `kusioner`
  MODIFY `id_kusioner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `opsi_radio`
--
ALTER TABLE `opsi_radio`
  MODIFY `id_opsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id_pertanyaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `profil_alumni`
--
ALTER TABLE `profil_alumni`
  MODIFY `id_alumni` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `fk_jawaban_pertanyaan` FOREIGN KEY (`id_pertanyaan`) REFERENCES `pertanyaan` (`id_pertanyaan`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_jawaban_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `opsi_radio`
--
ALTER TABLE `opsi_radio`
  ADD CONSTRAINT `opsi_radio_ibfk_1` FOREIGN KEY (`id_pertanyaan`) REFERENCES `pertanyaan` (`id_pertanyaan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD CONSTRAINT `fk_pertanyaan_kusioner` FOREIGN KEY (`id_kusioner`) REFERENCES `kusioner` (`id_kusioner`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `profil_alumni`
--
ALTER TABLE `profil_alumni`
  ADD CONSTRAINT `profil_alumni_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
