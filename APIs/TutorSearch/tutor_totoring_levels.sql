-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2022 at 09:34 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eastsons_studylab`
--

-- --------------------------------------------------------

--
-- Table structure for table `tutor_totoring_levels`
--

CREATE TABLE `tutor_totoring_levels` (
  `tutoring_level_id` int(11) NOT NULL,
  `Tutoring_Level` varchar(256) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tutor_totoring_levels`
--

INSERT INTO `tutor_totoring_levels` (`tutoring_level_id`, `Tutoring_Level`, `user_id`) VALUES
(3, 'Computer', 125),
(4, 'Pre-School', 125),
(5, 'AEIS (Secondary)', 126),
(6, 'Music', 126),
(7, 'Primary', 126),
(9, 'AEIS (Secondary)', 109);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tutor_totoring_levels`
--
ALTER TABLE `tutor_totoring_levels`
  ADD PRIMARY KEY (`tutoring_level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tutor_totoring_levels`
--
ALTER TABLE `tutor_totoring_levels`
  MODIFY `tutoring_level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
