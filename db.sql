-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2025 at 03:37 AM
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
-- Database: `recapdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `recap`
--

CREATE TABLE `recap` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `notes` text DEFAULT NULL,
  `movie` text DEFAULT NULL,
  `sports` text DEFAULT NULL,
  `new_program` text DEFAULT NULL,
  `program_special` text DEFAULT NULL,
  `series` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `typing_user` varchar(100) DEFAULT NULL,
  `typing_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recap`
--

INSERT INTO `recap` (`id`, `tanggal`, `notes`, `movie`, `sports`, `new_program`, `program_special`, `series`, `created_at`, `typing_user`, `typing_time`) VALUES
(9, '2025-11-24', '(IVM) D\'Academy 7 Top 6 Show Malam Pertama | Pk. 19:00 Live ', 'Sinema ANTV:\r\n   1. Sinema Spesial\r\n       - True Justice : Dark Vengeance | Pk. 01:15 \r\n       - Intan Berduri | Pk. 06:00\r\n       - Mandala Penakluk Satria Tartar | Pk. 18:00\r\n       - Titisan Dewi Ular | Pk. 20:00\r\n       - Saur Sepuh : Satria Madangkara | Pk. 21:30\r\n   2. Mega Bollywood\r\n       - Break ke Baad | Pk. 03:00\r\n       - Sultan | Pk. 10:00\r\n   3. Bioskop Asia\r\n       - Swordsman | Pk. 23:30\r\n\r\nBig Movies GTV:\r\n   1. The Mechanic | Pk. 19:30\r\n   2. Desert Dragon | Pk. 21:15\r\n\r\nMega Film Asia IVM:\r\n   1. Blind War | Pk. 00:30\r\n   2. Rise of the Legend | Pk. 02:30\r\n   3. Blind War | Pk. 23:00\r\n\r\nBioskop TRANSTV\r\n   1. Salt | Pk. 21:00\r\n   2. Kidnap | Pk. 23:00\r\n\r\nTheater Malam TRANS7\r\n   1. Ayat-Ayat Cinta 2 | Pk. 00.00\r\n\r\nMega FilmTV Malam RCTI\r\n   1. Alergi Jodoh | Pk. 01:15', '1) INEWS\r\n    1. AFC Champions League Elite 2025/2026 (LIVE)\r\n        - Al Duhail vs Al Ittihad | Pk. 23:00\r\n\r\n2) SCTV\r\n   1. Premier League 2025/2026 (LIVE)\r\n        - Arsenal vs Totteham | Pk. 00:00\r\n\r\n3) MOJI\r\n   1. Kejurnas Bola Voli U-19 2025 (LIVE) | Pk. 08:45 - 19:00\r\n   2. Kejurnas Bola Voli U-19 2025 (Delay) | Pk. 23:45', '', '', '', '2025-11-24 11:45:42', 'Fatih', '2025-11-25 10:41:59'),
(17, '2025-11-25', '(IVM) D\'Academy 7 Top 6 Show Malam Kedua | Pk. 19:00 (Live)', '[MOVIE]\r\nSinema ANTV:\r\n   1. Sinema Spesial\r\n       - True Justice : Street Wars | Pk. 01:15 \r\n       - Hippies Spesial | Pk. 06:00\r\n       - Pendekar Mata Satu | Pk. 18:00\r\n       - Malam Satu Suro | Pk. 20:00\r\n       - Saur Sepuh 2: Pesanggarahan | Pk. 21:30\r\n   2. Mega Bollywood\r\n       - Ram Jaane | Pk. 03:00\r\n       - Bade Miyan Chote Miyan | Pk. 10:00\r\n   3. Bioskop Asia\r\n       - Millionaires Express | Pk. 23:30\r\n\r\nBig Movies GTV:\r\n   1. Replicant | Pk. 19:30\r\n   2. Fighter | Pk. 21:15\r\n\r\nMega Film Asia IVM:\r\n   1. Once Upon a Time in China 2 | Pk. 01:15\r\n   2. Tiger Cage II | Pk. 03.00\r\n   3. Fury 12 Hours | Pk. 23:00\r\n\r\nBioskop TRANSTV\r\n   1. 21 Bridges | Pk. 21:00\r\n   2. From Paris With Love | Pk. 23:00', '1) RCTI\r\n   1. AFC Champions League Elite 2025/2026\r\n       - Al-Ahli vs Al-Sharjah (LIVE) | 01.00 \r\n\r\n2) INEWS \r\n   1. AFC Champions League Elite 2025/2026\r\n       - Al-Duhail vs Al-Ittihad (LIVE) | 00.00\r\n\r\n3) MOJI\r\n   1. Kejurnas Bola Voli U-19 2025 (LIVE) | Pk. 08:45 - 19:00', '', '', '', '2025-11-25 02:33:33', '', '2025-11-25 17:18:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recap`
--
ALTER TABLE `recap`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_tanggal` (`tanggal`),
  ADD UNIQUE KEY `tanggal` (`tanggal`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recap`
--
ALTER TABLE `recap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
