-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 02, 2022 at 05:41 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_board_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `school_boards`
--

CREATE TABLE `school_boards` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_boards`
--

INSERT INTO `school_boards` (`id`, `name`, `created_at`) VALUES
(1, 'CSM', '2022-01-02 12:27:49'),
(2, 'CSMB', '2022-01-02 12:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `school_board` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `school_board`, `created_at`) VALUES
(2, 'Stanislav Despotovic', 1, '2022-01-02 14:46:30'),
(4, 'Titanik', 2, '2022-01-02 15:00:44'),
(5, 'Cheese Pizzaa', 2, '2022-01-02 15:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `student_grades`
--

CREATE TABLE `student_grades` (
  `student_id` int(11) NOT NULL,
  `grade` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_grades`
--

INSERT INTO `student_grades` (`student_id`, `grade`, `created_at`) VALUES
(2, 6, '2022-01-02 15:20:56'),
(2, 10, '2022-01-02 15:32:57'),
(2, 5, '2022-01-02 15:33:16'),
(4, 10, '2022-01-02 15:33:28'),
(5, 5, '2022-01-02 15:33:48'),
(2, 10, '2022-01-02 15:33:53'),
(5, 10, '2022-01-02 15:33:57'),
(2, 8, '2022-01-02 15:40:27'),
(4, 8, '2022-01-02 15:43:59'),
(4, 5, '2022-01-02 16:06:41'),
(5, 7, '2022-01-02 16:08:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `school_boards`
--
ALTER TABLE `school_boards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `school_boards`
--
ALTER TABLE `school_boards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
