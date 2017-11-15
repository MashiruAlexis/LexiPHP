-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2017 at 11:18 AM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eval`
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
  `password` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `status` varchar(11) NOT NULL,
  `updated_at` varchar(10) DEFAULT NULL,
  `created_at` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `account_type_id`, `fname`, `lname`, `username`, `password`, `email`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 'Alexis', 'Celis', 'alexis', '$2y$10$bII82dEH1evCqo9tS7CnLOzwJtUIqiLSZnrUiYMJrEJzDsZQK.dCq', 'alexis@alexis.com', 'active', NULL, NULL),
(2, 2, 'Alexis', 'Celis', 'alexis1', '$2y$10$hkdZ6LOcQVo3ervGZnjGMOwykU98nqdwr79nCfXV6I2FAOkJyrMLi', 'alexis1@alexis.com', 'active', NULL, NULL),
(3, 3, 'Alexis', 'Celis', 'alexis2', '$2y$10$F.et6GT05kaKgC4XttqSoOe4Hg4Xnxk7TCMR2fXWikEzt8XyOKRfS', 'alexis2@alexis.com', 'active', NULL, NULL),
(4, 3, 'Jared', 'Celis', 'jared', '$2y$10$BFnDl1tKeFzvAoS2d3PR5OQXIF724VEnsjTIlBWqT9kaFcCyWndSe', 'jared@admin.com', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_data`
--

CREATE TABLE `account_data` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `teacher_id` int(5) NOT NULL,
  `college_dept` varchar(30) DEFAULT NULL,
  `academic_rank` varchar(30) DEFAULT NULL,
  `subject_id` varchar(11) NOT NULL,
  `scyear` varchar(11) DEFAULT NULL,
  `sem` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_data`
--

INSERT INTO `account_data` (`id`, `account_id`, `teacher_id`, `college_dept`, `academic_rank`, `subject_id`, `scyear`, `sem`) VALUES
(1, NULL, 1, 'College of Education', 'Instructor I', '1', NULL, NULL),
(2, NULL, 2, 'College of ICT', 'Instuctor II', '2', NULL, NULL),
(3, NULL, 1, 'College of Education', 'Instructor I', '1', NULL, NULL),
(4, NULL, 2, 'College of ICT', 'Instuctor II', '2', NULL, NULL),
(6, 4, 0, NULL, NULL, '1', '2017-2018', '2nd'),
(7, 3, 0, NULL, NULL, '2', '2018-2019', '2nd'),
(8, 3, 3, NULL, NULL, '2', '2018-2019', '2nd');

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
(1, NULL, 4, 'xcnu', NULL, NULL, 'on-going'),
(2, NULL, 3, 'axur', NULL, NULL, 'on-going');

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
  `evaluator_id` int(11) NOT NULL,
  `evaluation_sub_criteria_id` int(11) NOT NULL,
  `scale` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_details`
--

CREATE TABLE `evaluation_details` (
  `id` int(11) NOT NULL,
  `evaluation_id` int(10) NOT NULL,
  `evaluator_id` int(10) NOT NULL,
  `rating_id` int(10) NOT NULL,
  `school_year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `deptartment` varchar(50) DEFAULT NULL,
  `comments` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation_details`
--

INSERT INTO `evaluation_details` (`id`, `evaluation_id`, `evaluator_id`, `rating_id`, `school_year`, `semester`, `deptartment`, `comments`) VALUES
(1, 1, 5, 4, '2017-2018', '2nd', NULL, 'He is really good at teaching.'),
(2, 1, 6, 5, '2017-2018', '2nd', NULL, 'I did learn a lot of things because of him.'),
(3, 2, 7, 6, '2018-2019', '2nd', NULL, 'Wooooa i love this teacher');

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
  `account_id` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `year` varchar(20) DEFAULT NULL,
  `course` varchar(20) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluator`
--

INSERT INTO `evaluator` (`id`, `account_id`, `type`, `name`, `year`, `course`, `date`) VALUES
(1, 0, 'Student', 'Ramon Alexis Celis', '2nd', 'BSIT', NULL),
(2, 0, 'Student', 'Ramon Alexis Celis', '2nd', 'BSIT', NULL),
(3, 0, 'Student', 'Ramon Alexis Celis', '2nd', 'BSIT', NULL),
(4, 0, 'Student', 'James Reid', '4th', 'BSHRM', NULL),
(5, 0, 'Student', 'Ramon Alexis Celis', '2nd', 'BSIT', NULL),
(6, 0, 'Student', 'James Reid', '4th', 'BSHRM', NULL),
(7, 0, 'Student', 'Nick', '3rd', 'HRM', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `evaluation_id` int(10) DEFAULT NULL,
  `crit_A1` int(5) NOT NULL,
  `crit_A2` int(5) NOT NULL,
  `crit_A3` int(5) NOT NULL,
  `crit_A4` int(5) NOT NULL,
  `crit_A5` int(5) NOT NULL,
  `ave_crit1` int(11) DEFAULT NULL,
  `crit_B1` int(5) NOT NULL,
  `crit_B2` int(5) NOT NULL,
  `crit_B3` int(5) NOT NULL,
  `crit_B4` int(5) NOT NULL,
  `crit_B5` int(5) NOT NULL,
  `ave_crit2` int(10) NOT NULL,
  `crit_C1` int(5) NOT NULL,
  `crit_C2` int(5) NOT NULL,
  `crit_C3` int(5) NOT NULL,
  `crit_C4` int(5) NOT NULL,
  `crit_C5` int(5) NOT NULL,
  `ave_crit3` int(5) NOT NULL,
  `crit_D1` int(5) NOT NULL,
  `crit_D2` int(5) NOT NULL,
  `crit_D3` int(5) NOT NULL,
  `crit_D4` int(5) NOT NULL,
  `crit_D5` int(5) NOT NULL,
  `ave_crit4` int(10) NOT NULL,
  `ave_total` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `teacher_id`, `evaluation_id`, `crit_A1`, `crit_A2`, `crit_A3`, `crit_A4`, `crit_A5`, `ave_crit1`, `crit_B1`, `crit_B2`, `crit_B3`, `crit_B4`, `crit_B5`, `ave_crit2`, `crit_C1`, `crit_C2`, `crit_C3`, `crit_C4`, `crit_C5`, `ave_crit3`, `crit_D1`, `crit_D2`, `crit_D3`, `crit_D4`, `crit_D5`, `ave_crit4`, `ave_total`) VALUES
(1, NULL, NULL, 5, 5, 4, 3, 4, 4, 4, 4, 5, 4, 5, 4, 5, 4, 3, 4, 4, 4, 4, 5, 1, 1, 2, 3, 3),
(2, NULL, NULL, 5, 5, 4, 3, 4, 4, 4, 4, 5, 4, 5, 4, 5, 4, 3, 4, 4, 4, 4, 5, 1, 1, 2, 3, 3),
(3, NULL, NULL, 5, 4, 3, 2, 1, 3, 1, 1, 1, 1, 1, 1, 1, 2, 3, 4, 5, 3, 5, 5, 5, 5, 5, 5, 2),
(4, NULL, NULL, 5, 5, 4, 3, 3, 4, 5, 4, 5, 1, 1, 3, 1, 1, 1, 2, 1, 1, 3, 2, 3, 4, 4, 3, 3),
(5, NULL, NULL, 5, 5, 5, 4, 4, 5, 4, 5, 5, 5, 4, 5, 5, 5, 5, 5, 5, 5, 5, 4, 3, 4, 3, 4, 5),
(6, NULL, NULL, 5, 5, 4, 4, 5, 5, 5, 4, 3, 3, 3, 4, 3, 3, 3, 4, 4, 3, 4, 3, 3, 4, 3, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  `subbject_code` varchar(15) NOT NULL,
  `subject_title` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `subject_id`, `subbject_code`, `subject_title`) VALUES
(1, '1', 'Comp Prog 1', 'Computer Programming 1'),
(2, '2', 'DBMS 1', 'Database Management 1'),
(3, '3', 'Web Dev 101', 'Website Development'),
(4, '4', 'Engl101', 'English 101');

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
-- Indexes for table `evaluation_details`
--
ALTER TABLE `evaluation_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation_sub_criteria`
--
ALTER TABLE `evaluation_sub_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluator`
--
ALTER TABLE `evaluator`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `account_data`
--
ALTER TABLE `account_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
-- AUTO_INCREMENT for table `evaluation_details`
--
ALTER TABLE `evaluation_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `evaluation_sub_criteria`
--
ALTER TABLE `evaluation_sub_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `evaluator`
--
ALTER TABLE `evaluator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
