-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2024 at 05:15 PM
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
-- Database: `noteshive`
--

-- --------------------------------------------------------

--
-- Table structure for table `msg`
--

CREATE TABLE `msg` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `number` int(20) NOT NULL,
  `msg` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `msg`
--

INSERT INTO `msg` (`id`, `user_id`, `name`, `email`, `number`, `msg`, `date`) VALUES
(6, 51, 'pawan ', 'pawan@gmail.com', 2147483647, 'MOST DANGEROUS GAME AND OTHER STORIES OF ADVENTURE, THE \r\n\r\nis there availability', '2023-02-23 13:41:50'),
(7, 51, 'dfbgf', 'hdgfh@vszv', 0, 'dh', '2023-02-23 13:47:26'),
(8, 51, 'sv', 'jisaxih205@minterp.c', 0, 'xhf', '2023-02-23 13:49:56'),
(10, 51, 'tabbjncj ', 'njkchasncj@123c', 2147483647, 'f,mmnfkjhvd inwjcwonfdiuwmh', '2024-03-04 17:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `my_downloads`
--

CREATE TABLE `my_downloads` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `title` varchar(50) NOT NULL,
  `d_date` text NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `my_downloads`
--

INSERT INTO `my_downloads` (`id`, `user_id`, `title`, `d_date`) VALUES
(163, 57, 'Project-Documentation.pdf', '1709566771'),
(164, 57, 'E-Notes-Taker-Application (2).pdf', '1709566863'),
(165, 57, 'A.A.A. PRICE LIST 15-04-2022 (1) (1).pdf', '1709568306'),
(166, 57, 'sample_pdf (1) (2).pdf', '1709568332'),
(167, 57, 'sample_pdf (1) (2).pdf', '1709568375'),
(168, 57, 'A.A.A. PRICE LIST 15-04-2022 (1) (1).pdf', '1709568871');

-- --------------------------------------------------------

--
-- Table structure for table `notes_info`
--

CREATE TABLE `notes_info` (
  `bid` int(100) NOT NULL,
  `title` varchar(20) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `file_name` text NOT NULL,
  `date` text NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes_info`
--

INSERT INTO `notes_info` (`bid`, `title`, `category`, `description`, `image`, `file_name`, `date`) VALUES
(2, 'Tanmay', 'Notes', 'Tannu bhau ki jay', 'noteshive (1).jpeg', 'sample_pdf (1) (2).pdf', '2024-03-04 19:03:41'),
(3, 'Sarthak', 'CheatSheet', 'Sarthak ka book', '28480371_7402282.jpg', 'E-Notes-Taker-Application (2).pdf', '2024-03-04 19:24:21'),
(4, 'Omi', 'Books', 'Omkar', 'team.jpg', 'A.A.A. PRICE LIST 15-04-2022 (1) (1).pdf', '2024-03-04 19:42:32'),
(5, 'Hanuman', 'Books', 'Hanuma is Genius', 'team.jpg', 'Project-Documentation.pdf', '2024-03-04 19:48:32');

-- --------------------------------------------------------

--
-- Table structure for table `users_info`
--

CREATE TABLE `users_info` (
  `Id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_info`
--

INSERT INTO `users_info` (`Id`, `name`, `surname`, `email`, `password`, `user_type`) VALUES
(57, 'saurabh', 'patole', 'saurabh@gmail.com', '2021', 'User'),
(58, 'raj', 'dev', 'raj@123', '2023', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `my_downloads`
--
ALTER TABLE `my_downloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes_info`
--
ALTER TABLE `notes_info`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `users_info`
--
ALTER TABLE `users_info`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `msg`
--
ALTER TABLE `msg`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `my_downloads`
--
ALTER TABLE `my_downloads`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `notes_info`
--
ALTER TABLE `notes_info`
  MODIFY `bid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_info`
--
ALTER TABLE `users_info`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
