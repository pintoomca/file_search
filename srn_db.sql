-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2021 at 10:21 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srn_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_users`
--

CREATE TABLE `data_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT '0',
  `logged_in` varchar(50) DEFAULT '0',
  `is_confirmed` varchar(50) DEFAULT '0',
  `is_admin` varchar(50) DEFAULT '0',
  `email` varchar(50) DEFAULT '0',
  `password` varchar(255) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_users`
--

INSERT INTO `data_users` (`id`, `username`, `logged_in`, `is_confirmed`, `is_admin`, `email`, `password`, `created_at`) VALUES
(1, 'ashu', '0', '0', '0', 'ashu@gmai.com', '$2y$10$75rehbRX2wCoKDX5tHGEc.x/kSScPyLKTk0IdYbMDe3htmO2zLeBi', '2019-11-13 08:24:32'),
(2, 'test', '0', '0', '0', 'test@example.com', '$2y$10$shJU8CXHheEGqGP7m76Wf.yvNe2u9WALhyqUr7cS6iF0rpFMzLlU6', '2019-11-13 08:26:50'),
(3, 'ashutosh', '0', '0', '0', 'ashu@example.com', '$2y$10$DIS2M/pAWaOdW88dFxSOfODdAdOubdMpnltCtjozlHDTFp9xhJvp.', '2019-11-14 10:38:56'),
(4, 'pintoogautam', '0', '0', '0', 'psunandap@gmail.com', '$2y$10$Q/7kd5/Fyq/436/lcgzreumXABLtHOSZFHEY0EZDKfBsF.m5l9/f6', '2019-11-14 10:46:58'),
(5, 'NARENDRA', '0', '0', '0', 'narendra.patidar@nisg.org', '$2y$10$a8dyJ53BhGIDnxoC1sFWPuYALbeXYQ12y/SemVsc/Gr88sr4Cdpu6', '2019-11-14 11:00:49'),
(6, 'Admin', '0', '0', '0', 'admin@gmail.com', '$2y$10$OViO2EoFOdQvsSvWtAybZuHBkP5YqEpZ8xwu4KdSoMuqsUlG3zCf2', '2020-02-01 07:10:30'),
(7, 'ashu', '0', '0', '0', 'ashu@example.com', '$2y$10$K24YvEz7f5A09s.5tK1ajumXBNLNYRkwd.e5LUsUUNprh47rT/ktG', '2020-02-01 11:33:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT '0',
  `email` varchar(50) DEFAULT '0',
  `password` varchar(50) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_users`
--
ALTER TABLE `data_users`
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
-- AUTO_INCREMENT for table `data_users`
--
ALTER TABLE `data_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
