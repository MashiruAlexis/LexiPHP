-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2017 at 06:23 PM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evaluationsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `account_type_id` int(11) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `status` varchar(11) NOT NULL,
  `updated_at` varchar(10) DEFAULT NULL,
  `created_at` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `account_type_id`, `fname`, `lname`, `username`, `password`, `email`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 'Alexis', 'Celis', 'alexis', '$2y$10$C2S.05tIOwIv3', 'alexis@alexis.com', 'active', NULL, NULL),
(2, 3, 'Alexis', 'Celis', 'alexis1', '$2y$10$u6wq/WpTbTZVw', 'alexis1@alexis.com', 'active', NULL, NULL),
(3, 3, 'Alexis', 'Celis', 'alexis2', '$2y$10$ACntf5BBpvUbj', 'alexis2@alexis.com', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_data`
--

CREATE TABLE `account_data` (
  `id` int(11) NOT NULL,
  `college_dept` varchar(30) DEFAULT NULL,
  `academic_rank` varchar(30) DEFAULT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE `account_type` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`id`, `type`) VALUES
(1, 'Admin'),
(2, 'Dean'),
(3, 'Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `id` int(11) NOT NULL,
  `evaluator_id` int(11) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL,
  `sem` varchar(1040) DEFAULT NULL,
  `school_year` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`id`, `evaluator_id`, `account_id`, `code`, `sem`, `school_year`, `status`) VALUES
(1, NULL, 3, 'COOLKID', NULL, NULL, 'on-going'),
(2, NULL, 2, 'Wazzup', NULL, NULL, 'on-going');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_criteria`
--

CREATE TABLE `evaluation_criteria` (
  `id` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation_criteria`
--

INSERT INTO `evaluation_criteria` (`id`, `label`, `sort`) VALUES
(1, 'This is criteria 1', NULL),
(2, 'This is criteria 2', NULL),
(3, 'This is criteria 3', NULL),
(4, 'This is criteria 4', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_data`
--

CREATE TABLE `evaluation_data` (
  `id` int(11) NOT NULL,
  `evaluation_id` int(11) NOT NULL,
  `evaluation_sub_criteria_id` int(11) NOT NULL,
  `scale` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_sub_criteria`
--

CREATE TABLE `evaluation_sub_criteria` (
  `id` int(11) NOT NULL,
  `evaluation_criteria_id` int(11) NOT NULL,
  `question` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation_sub_criteria`
--

INSERT INTO `evaluation_sub_criteria` (`id`, `evaluation_criteria_id`, `question`) VALUES
(1, 1, 'This is sub criteria 1'),
(2, 2, 'This is sub criteria 2'),
(3, 1, 'This is sub criteria 2'),
(4, 3, 'This is sub criteria 2'),
(5, 4, 'This is sub criteria 1'),
(6, 1, 'This is sub criteria 3'),
(7, 1, 'This is sub criteria 4'),
(8, 1, 'This is sub criteria 5'),
(9, 2, 'This is sub criteria 1'),
(10, 2, 'This is sub criteria 3'),
(11, 2, 'This is sub criteria 4'),
(12, 2, 'This is sub criteria 5'),
(13, 3, 'This is sub criteria 1'),
(14, 3, 'This is sub criteria 3'),
(15, 3, 'This is sub criteria 3'),
(16, 3, 'This is sub criteria 4'),
(17, 4, 'This is sub criteria 2'),
(18, 4, 'This is sub criteria 3'),
(19, 4, 'This is sub criteria 4'),
(20, 4, 'This is sub criteria 5');

-- --------------------------------------------------------

--
-- Table structure for table `evaluator`
--

CREATE TABLE `evaluator` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `position` varchar(20) NOT NULL,
  `date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `ratee` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_data`
--
ALTER TABLE `account_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation_criteria`
--
ALTER TABLE `evaluation_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation_data`
--
ALTER TABLE `evaluation_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation_sub_criteria`
--
ALTER TABLE `evaluation_sub_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `account_data`
--
ALTER TABLE `account_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `evaluation_criteria`
--
ALTER TABLE `evaluation_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `evaluation_data`
--
ALTER TABLE `evaluation_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `evaluation_sub_criteria`
--
ALTER TABLE `evaluation_sub_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
