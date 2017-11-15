-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2017 at 05:59 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
(4, 3, 'Jared', 'Celis', 'jared', '$2y$10$BFnDl1tKeFzvAoS2d3PR5OQXIF724VEnsjTIlBWqT9kaFcCyWndSe', 'jared@admin.com', 'active', NULL, NULL),
(5, 3, 'James', 'Jones', 'james', '$2y$10$.AiWnDypBBxlSevqxHafkeTZPKA5EBLh12u/n52p8XjvivIzDsIfC', 'james@admin.com', 'active', NULL, NULL);

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
(8, 3, 3, NULL, NULL, '2', '2018-2019', '2nd'),
(9, 5, 0, NULL, NULL, '3', '2017-2018', '1st');

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
(2, NULL, 3, 'axur', NULL, NULL, 'on-going'),
(3, NULL, 5, 'rklabz', NULL, NULL, 'on-going');

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
(1, 'A. Commitment', NULL),
(2, 'B. Knowledge of Subject', NULL),
(3, 'C. Teaching for Independent Learning', NULL),
(4, 'D. Management of Learning', NULL);

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
(1, 2, 1, 1, '2018-2019', '2nd', NULL, 'this is a test'),
(2, 2, 2, 2, '2018-2019', '2nd', NULL, 'This teacher is really funny.'),
(3, 3, 3, 3, '2017-2018', '1st', NULL, 'he cant teach at all.'),
(4, 3, 4, 4, '2017-2018', '1st', NULL, 'Dean testing'),
(5, 2, 5, 5, '2018-2019', '2nd', NULL, 'Deans Testing part 2'),
(6, 2, 6, 6, '2018-2019', '2nd', NULL, 'this is great'),
(7, 2, 7, 7, '2018-2019', '2nd', NULL, 'Formula testing'),
(8, 1, 8, 8, '2017-2018', '2nd', NULL, 'formula testing'),
(9, 1, 9, 9, '2017-2018', '2nd', NULL, 'Formula test again'),
(10, 1, 10, 10, '2017-2018', '2nd', NULL, 'Formula test'),
(11, 3, 11, 11, '2017-2018', '1st', NULL, 'formula'),
(12, 3, 12, 12, '2017-2018', '1st', NULL, 'another one formula test');

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
(1, 1, 'Demonstrates sensitivity to students\' ability to attend and absorb content information.'),
(2, 2, '1. Demonstrate mastery of the subject matter (explain the subject matter without relying solely on the prescribed textbook).'),
(3, 1, '2. Integrates sensitively his/her learning objectives with those of the students in a collaborative process.'),
(4, 3, '1. Creates teaching strategies the allow students to practice using concepts they need to understand (interactive discussion).'),
(5, 4, '1. Creates opportunities for intensive and/or extensive contribution of students in the class activities (e.g breaks class into dyads, triads or buzz/task groups).'),
(6, 1, '3. Makes self available to students beyond official time'),
(7, 1, '4. Regularly comes to class on time, well-groomed and well-prepared to complete assigned responsibilities.'),
(8, 1, '5. Keeps accurate records of students\' performance and prompt submission of the same.'),
(9, 2, '2. Draws and share information on the state on the art of theory and practice in his/her discipline.'),
(10, 2, '3. Integrates subject to practical circumstances and learning intents/purposes of students.'),
(11, 2, '4. Explains the relevance of present topics to the previous lessons, and relates the subject matter to relevant current issues and/or daily life activities.'),
(12, 2, '5. Demonstrates up-to-date knowledge and/or awareness on current trends and issues of the subject.'),
(13, 3, '2. Enhances student self-esteem and/or gives due recognition to students\' performance/potentials.'),
(14, 3, '3. Allows students to create their own course with objectives and realistically defined student-professor rules and make them accountable for their performance.'),
(15, 3, '4. Allows students to think independently and make their own decisions and holding them accountable for their performance based largely on their success in executing decisions.'),
(16, 3, '5. Encourages students to learn beyond what is required and he/guide the students how to apply the concepts learned.'),
(17, 4, '2. Assumes roles as facilitator, resource person, coach, inquisitor, integrator, referee in drawing students to contribute to knowledge and understanding of concepts at hands.'),
(18, 4, '3. Designs and implements learning conditions and experience that promotes healthy exchange and/or confrontations.'),
(19, 4, '4. Structures.re-structures learning and teach-learning context to enhance attainment of collective learning objectives.'),
(20, 4, '5. Use of Instructional Materials (audio/video materials, fieldtrips, film showing, computer aided instruction and etc.) to reinforces learning processes.');

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
(1, 3, 'Teacher', 'Alexis Celis', NULL, NULL, NULL),
(2, 0, 'Student', 'Katrina', '1st', 'BSED', NULL),
(3, 3, 'Teacher', 'Alexis Celis', NULL, NULL, NULL),
(4, 2, 'Dean', 'Alexis Celis', NULL, NULL, NULL),
(5, 2, 'Dean', 'Alexis Celis', NULL, NULL, NULL),
(6, 3, 'Teacher', 'Alexis Celis', NULL, NULL, NULL),
(7, 2, 'Dean', 'Alexis Celis', NULL, NULL, NULL),
(8, 2, 'Dean', 'Alexis Celis', NULL, NULL, NULL),
(9, 2, 'Dean', 'Alexis Celis', NULL, NULL, NULL),
(10, 2, 'Dean', 'Alexis Celis', NULL, NULL, NULL),
(11, 3, 'Teacher', 'Alexis Celis', NULL, NULL, NULL),
(12, 3, 'Teacher', 'Alexis Celis', NULL, NULL, NULL);

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
  `ave_crit1` varchar(11) DEFAULT NULL,
  `crit_B1` int(5) NOT NULL,
  `crit_B2` int(5) NOT NULL,
  `crit_B3` int(5) NOT NULL,
  `crit_B4` int(5) NOT NULL,
  `crit_B5` int(5) NOT NULL,
  `ave_crit2` varchar(10) NOT NULL,
  `crit_C1` int(5) NOT NULL,
  `crit_C2` int(5) NOT NULL,
  `crit_C3` int(5) NOT NULL,
  `crit_C4` int(5) NOT NULL,
  `crit_C5` int(5) NOT NULL,
  `ave_crit3` varchar(5) NOT NULL,
  `crit_D1` int(5) NOT NULL,
  `crit_D2` int(5) NOT NULL,
  `crit_D3` int(5) NOT NULL,
  `crit_D4` int(5) NOT NULL,
  `crit_D5` int(5) NOT NULL,
  `ave_crit4` varchar(10) NOT NULL,
  `ave_total` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `teacher_id`, `evaluation_id`, `crit_A1`, `crit_A2`, `crit_A3`, `crit_A4`, `crit_A5`, `ave_crit1`, `crit_B1`, `crit_B2`, `crit_B3`, `crit_B4`, `crit_B5`, `ave_crit2`, `crit_C1`, `crit_C2`, `crit_C3`, `crit_C4`, `crit_C5`, `ave_crit3`, `crit_D1`, `crit_D2`, `crit_D3`, `crit_D4`, `crit_D5`, `ave_crit4`, `ave_total`) VALUES
(1, NULL, NULL, 5, 5, 5, 5, 5, '5', 5, 5, 5, 5, 5, '5', 5, 5, 5, 5, 5, '5', 5, 5, 5, 5, 5, '5', 5),
(2, NULL, NULL, 5, 5, 5, 5, 5, '5', 5, 4, 4, 4, 5, '4', 1, 1, 1, 1, 1, '1', 1, 2, 3, 4, 5, '3', 3),
(3, NULL, NULL, 5, 5, 4, 4, 4, '4', 3, 3, 3, 3, 2, '3', 3, 3, 4, 4, 5, '4', 5, 4, 4, 4, 5, '4', 4),
(4, NULL, NULL, 4, 4, 4, 4, 5, '4', 4, 4, 5, 4, 4, '4', 4, 5, 5, 4, 4, '4', 5, 5, 4, 4, 5, '5', 4),
(5, NULL, NULL, 5, 4, 3, 4, 4, '4', 4, 5, 4, 4, 2, '4', 4, 4, 5, 4, 4, '4', 4, 4, 4, 4, 5, '4', 4),
(6, NULL, NULL, 5, 4, 5, 5, 4, '0', 5, 5, 5, 5, 5, '0', 5, 4, 5, 5, 4, '0', 5, 5, 5, 5, 5, '0', 96),
(7, NULL, NULL, 5, 5, 5, 5, 5, '0', 5, 5, 5, 5, 5, '0', 5, 5, 5, 5, 5, '0', 5, 5, 5, 5, 5, '0', 100),
(8, NULL, NULL, 5, 4, 5, 5, 5, '0.208333333', 5, 5, 5, 5, 5, '0.2', 5, 5, 5, 5, 5, '0.3', 5, 5, 5, 5, 5, '0.3', 1),
(9, NULL, NULL, 5, 4, 5, 5, 5, '0.208333333', 5, 5, 5, 5, 5, '0.2', 5, 5, 5, 5, 5, '0.3', 5, 5, 5, 5, 5, '0.3', 21036363),
(10, NULL, NULL, 5, 4, 5, 5, 5, '0.208333333', 5, 5, 5, 5, 5, '0.2', 5, 5, 5, 5, 5, '0.3', 5, 5, 5, 5, 5, '0.3', 101),
(11, NULL, NULL, 5, 5, 4, 5, 5, '19.2', 5, 5, 4, 5, 5, '19.2', 5, 5, 5, 5, 5, '30', 5, 5, 5, 5, 5, '30', 9840),
(12, NULL, NULL, 5, 4, 5, 5, 5, '19.2', 5, 5, 5, 1, 5, '16.8', 5, 5, 5, 5, 5, '30', 5, 5, 5, 5, 5, '30', 96);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `account_data`
--
ALTER TABLE `account_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `evaluation_sub_criteria`
--
ALTER TABLE `evaluation_sub_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `evaluator`
--
ALTER TABLE `evaluator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
