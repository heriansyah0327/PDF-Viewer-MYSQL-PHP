-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 10, 2025 at 05:29 PM
-- Server version: 5.7.44-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pdfviewer`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--
CREATE DATABASE pdfviewer2;
USE pdfviewer2;

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `file_name`, `file_url`, `uploaded_at`) VALUES
(1, 'PETUNJUK PENULISAN ILMIAH INFORMATIKA 2022_REV.pdf', 'PETUNJUK PENULISAN ILMIAH INFORMATIKA 2022_REV.pdf', '2025-05-19 13:19:24'),
(3, 'Buku Panduan PPPL 2022 - edisi revisi.pdf', 'Buku Panduan PPPL 2022 - edisi revisi.pdf', '2025-10-21 12:32:22'),
(4, 'Business English_Group 1.pdf', 'Business English_Group 1.pdf', '2025-10-21 12:32:27'),
(5, '1 PPT UK 01 Kebutuhan Teknis.pdf', '1 PPT UK 01 Kebutuhan Teknis.pdf', '2025-10-21 12:32:59'),
(6, '1 PPT UK 02 Data Peralatan.pdf', '1 PPT UK 02 Data Peralatan.pdf', '2025-10-21 12:33:06'),
(7, '1 PPT UK 03 Merancang Topologi.pdf', '1 PPT UK 03 Merancang Topologi.pdf', '2025-10-21 12:33:09'),
(8, 'Topik 3_UK 4.pdf', 'Topik 3_UK 4.pdf', '2025-10-21 12:33:14'),
(9, '1 PPT UK 09 Mamasang Kabel.pdf', '1 PPT UK 09 Mamasang Kabel.pdf', '2025-10-21 12:33:19'),
(10, 'Topik 2_UK5.pdf', 'Topik 2_UK5.pdf', '2025-10-21 12:33:22'),
(11, 'Topik 4_UK12_1.pdf', 'Topik 4_UK12_1.pdf', '2025-10-21 12:33:26'),
(12, 'Topik 4_UK12_2.pdf', 'Topik 4_UK12_2.pdf', '2025-10-21 12:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
