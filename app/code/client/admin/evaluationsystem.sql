-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2018 at 01:42 PM
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
-- Table structure for table `academic_rank`
--

CREATE TABLE `academic_rank` (
  `id` int(11) NOT NULL,
  `rank` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `academic_rank`
--

INSERT INTO `academic_rank` (`id`, `rank`) VALUES
(1, 'Instructor I'),
(2, 'Instructor II'),
(3, 'Instructor III'),
(4, 'Asst. Prof. I'),
(5, 'Asst. Prof. II'),
(6, 'Asst. Prof. III'),
(7, 'Asst. Prof. IV'),
(8, 'Assoc. Prof. I'),
(9, 'Assoc. Prof. II'),
(10, 'Assoc. Prof. III'),
(11, 'Assoc. Prof. IV'),
(12, 'Assoc. Prof. V'),
(13, 'Prof. I'),
(14, 'Prof. II'),
(15, 'Prof. III'),
(16, 'Prof. IV'),
(17, 'Prof. V');

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
(3, 3, 'Alexis', 'Celis', 'alexis2', '$2y$10$fkObKuPg/92spH8tOBRnxeGJxwwA06aJdFx7F9e/TcgcHst6JA/2q', 'alexis2@alexis.com', 'active', NULL, NULL),
(4, 3, 'Jared', 'Celis', 'jared', '$2y$10$BFnDl1tKeFzvAoS2d3PR5OQXIF724VEnsjTIlBWqT9kaFcCyWndSe', 'jared@admin.com', 'active', NULL, NULL),
(5, 3, 'James', 'Jones', 'james', '$2y$10$.AiWnDypBBxlSevqxHafkeTZPKA5EBLh12u/n52p8XjvivIzDsIfC', 'james@admin.com', 'active', NULL, NULL),
(7, 2, 'dean', 'dean', 'dean1', '$2y$10$LzF.axypsbFSaBASK6Svj.4JqOa9NhIhfZh4dCgu23Qe0QlO9OtdS', 'dean@dean.com', 'active', NULL, NULL),
(17, 3, 'test1', 'test1', 'test1', '$2y$10$oF7BhHSRkxLg98rvS.RZZuua0MBUbCsCr6lsauSPp5Um2dTv0.7ti', 'test1@admin', 'active', NULL, NULL),
(18, 3, 'test2', 'test2', 'test2', '$2y$10$jbmhxVX3S09mpAv47GWFNea.CBGzYJQvBy1BatJxQhi9MQSoqrSJC', 'test2@admin.com', 'active', NULL, NULL),
(19, 3, 'Alexis3', 'Alexis3', 'alexis3', '$2y$10$z8/scNUFaC2BWtjYIcU.GeekQ8AJbXwTJhLgOliSPe2ccTYEBNoRS', 'alexis3@admin.com', 'active', NULL, NULL),
(20, 3, 'Alexis4', 'Alexis4', 'alexis4', '$2y$10$NTZAnR3p0XQSrV2WtQXM7eA3to263SsZyi1bZGZ/hAS9PEg8KeTEu', 'alexis4@admin.com', 'active', NULL, NULL),
(21, 3, 'Roger', 'Abulencia', 'roger', '$2y$10$TZjZxEeF3q.2KC3E00FrPuSt0P5tA0r1.aMmOsCU7/r5wMcSi6NK6', 'roger@yahoo.com', 'active', NULL, NULL),
(22, 3, 'test4', 'test4', 'test4', '$2y$10$kAwmTygp6VhNWxqXWw0oUe7AxY26hv0lCD7HhbYAb01XAvYIPP7qm', 'test4@admin.com', 'active', NULL, NULL),
(23, 2, 'dean2', 'dean2', 'dean2', '$2y$10$dN6EJ2pAhTN.bjlDwPEpOuLuUa8AAd8.1gNlWa/mNFbkbH0C1Lyh6', 'dean2@admin.com', 'active', NULL, NULL),
(24, 3, 'test5', 'test5', 'test5', '$2y$10$TTy.3Ntjxt5TClfr/GCJ8.4F/xHQP3fAoiWbPOFatlDmCN89rGeNW', 'test5@admin.com', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_data`
--

CREATE TABLE `account_data` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `teacher_id` int(5) DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `college_dept_id` varchar(30) DEFAULT NULL,
  `academic_rank_id` varchar(30) DEFAULT NULL,
  `subject_id` varchar(30) DEFAULT NULL,
  `scyear` varchar(11) DEFAULT NULL,
  `sem` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_data`
--

INSERT INTO `account_data` (`id`, `account_id`, `teacher_id`, `supervisor_id`, `college_dept_id`, `academic_rank_id`, `subject_id`, `scyear`, `sem`) VALUES
(6, 4, 0, NULL, '1', NULL, '1', '2017-2018', '1st'),
(7, 3, 0, 2, '2', NULL, '2', '2017-2018', '1st'),
(9, 5, 0, NULL, '4', NULL, '3', '2017-2018', '1st'),
(11, 7, 0, NULL, '2', NULL, '', NULL, NULL),
(12, 2, 2, NULL, '1', NULL, '1', '2017-2018', '1st'),
(13, 17, NULL, 2, '1', NULL, '1', '2017-2018', '1st'),
(14, 18, NULL, 2, '1', NULL, '2', '2017-2018', '1st'),
(15, 19, NULL, 2, '1', NULL, '3', '2017-2018', '1st'),
(16, 20, NULL, 2, '1', NULL, '3', '2017-2018', '1st'),
(17, 21, NULL, 2, '1', NULL, '2', '2017-2018', '2nd'),
(18, 22, NULL, 2, '1', NULL, '1', '2017-2018', '1st'),
(19, 23, NULL, 0, '2', NULL, NULL, NULL, NULL),
(20, 24, NULL, 23, '2', NULL, '1', '2017-2018', '1st');

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
-- Table structure for table `college_dept`
--

CREATE TABLE `college_dept` (
  `id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `college_dept`
--

INSERT INTO `college_dept` (`id`, `label`) VALUES
(1, 'College of Education'),
(2, 'College of Engineering & Technology'),
(3, 'College of Business Management '),
(4, 'College of Arts & Sciences');

-- --------------------------------------------------------

--
-- Table structure for table `decision`
--

CREATE TABLE `decision` (
  `id` int(11) NOT NULL,
  `ranged` varchar(11) DEFAULT NULL,
  `interpretation` varchar(50) DEFAULT NULL,
  `recommendation` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `decision`
--

INSERT INTO `decision` (`id`, `ranged`, `interpretation`, `recommendation`) VALUES
(1, '91-100', 'Excellent', NULL),
(2, '86-90', 'Very Good', NULL),
(3, '80-85', 'Good', NULL),
(4, '71-79', 'Fair', NULL),
(5, '65-70', 'Poor', NULL),
(6, '0-64', 'Very Poor', NULL);

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
(1, NULL, 3, 'l0nzsf', NULL, NULL, 'on-going'),
(2, NULL, 21, 'o2bymq', NULL, NULL, 'stopped'),
(3, NULL, 24, 'mivnaw', NULL, NULL, 'stopped'),
(4, NULL, 19, 'ib1d7v', NULL, NULL, 'on-going'),
(5, NULL, 20, 'etonfv', NULL, NULL, 'stopped');

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
(1, 1, 1, 1, '2017-2018', '1st', NULL, 'He\'s so kind that i want him out in this school.'),
(2, 1, 2, 2, '2017-2018', '1st', NULL, 'Wow i love the he teach'),
(3, 1, 3, 3, '2017-2018', '1st', NULL, 'He\'s really kind to us period.'),
(4, 1, 4, 4, '2017-2018', '1st', NULL, 'Hi please give higher grade thanks'),
(5, 2, 5, 5, '2017-2018', '2nd', NULL, 'Keep up the good work sir'),
(6, 2, 6, 6, '2017-2018', '2nd', NULL, 'continue your punctuality and work ethics'),
(7, 2, 7, 7, '2017-2018', '2nd', NULL, 'Thank you for imparting your knowledge sir..God Bless'),
(8, 2, 8, 8, '2017-2018', '2nd', NULL, 'The best faculty member i ever have'),
(9, 3, 9, 9, '2017-2018', '1st', NULL, 'This guys is really something else.'),
(10, 3, 10, 10, '2017-2018', '1st', NULL, 'lol this guy is really funny'),
(11, 3, 11, 11, '2017-2018', '1st', NULL, 'I am very good at this'),
(12, 1, 12, 12, '2017-2018', '1st', NULL, 'Nice, good job my friend.'),
(13, 2, 13, 13, '2017-2018', '2nd', NULL, 'What a let down!'),
(14, 2, 2, 14, '2017-2018', '2nd', NULL, 'The future is near.'),
(15, 2, 14, 15, '2017-2018', '2nd', NULL, 'Good Luck to you my trusted friend.'),
(16, 1, 15, 16, '2017-2018', '1st', NULL, 'This guy is just so amazing.'),
(17, 1, 16, 17, '2017-2018', '1st', NULL, 'Wow just wow!'),
(18, 1, 2, 18, '2017-2018', '1st', NULL, 'this so amazing'),
(19, 5, 17, 24, '2017-2018', '1st', NULL, 'Nice');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_self`
--

CREATE TABLE `evaluation_self` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `rating_id` int(11) DEFAULT NULL,
  `scyear` varchar(10) DEFAULT NULL,
  `sem` varchar(10) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation_self`
--

INSERT INTO `evaluation_self` (`id`, `account_id`, `rating_id`, `scyear`, `sem`, `status`) VALUES
(3, 3, 22, '2017-2018', '1st', 'approved'),
(4, 19, 23, '2017-2018', '1st', 'approved'),
(5, 20, 25, '2017-2018', '1st', 'approved');

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
(1, 1, '1. Demonstrates sensitivity to students\' ability to attend and absorb content information.'),
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
  `account_id` varchar(11) DEFAULT '0',
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
(1, '2', 'Dean', 'Alexis Celis', NULL, NULL, NULL),
(2, '3', 'Teacher', 'Alexis Celis', NULL, NULL, NULL),
(3, '0', 'Student', 'Darby Doll', '2nd', 'BSIT', NULL),
(4, '0', 'Student', 'Katty', '2nd', 'BEED', NULL),
(5, '3', 'Teacher', 'Alexis Celis', NULL, NULL, NULL),
(6, '2', 'Dean', 'Alexis Celis', NULL, NULL, NULL),
(7, '0', 'Student', 'Carl Camenforte', '2nd', 'BSCE', NULL),
(8, '2', 'Dean', 'Alexis Celis', NULL, NULL, NULL),
(9, '23', '', 'dean2 dean2', NULL, NULL, NULL),
(10, '0', 'Student', 'Maricar', '2nd', 'BA Com', NULL),
(11, '24', '', 'test5 test5', NULL, NULL, NULL),
(12, '0', 'Student', 'katty1', '2nd', 'BSCE', NULL),
(13, '3', 'Teacher', 'Alexis Celis', NULL, NULL, NULL),
(14, '20', '', 'Alexis4 Alexis4', NULL, NULL, NULL),
(15, '0', 'Student', 'Alexis Celis the second', '1st', 'BSIT', NULL),
(16, '0', 'Student', 'Ramon Alexis Celis The First', '1st', 'BSIT', NULL),
(17, '0', 'Student', 'Mashiro', '1st', 'BSIT', NULL);

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
(1, NULL, NULL, 5, 5, 5, 4, 5, '96', 5, 5, 5, 4, 4, '92', 5, 5, 5, 5, 5, '100', 1, 1, 1, 1, 1, '20', 77),
(2, NULL, NULL, 5, 5, 5, 5, 4, '96', 5, 5, 5, 5, 5, '100', 5, 4, 3, 3, 5, '80', 5, 5, 5, 5, 5, '100', 94),
(3, NULL, NULL, 5, 5, 5, 5, 5, '100', 4, 4, 5, 4, 4, '84', 4, 3, 5, 5, 5, '88', 4, 4, 5, 1, 5, '76', 87),
(4, NULL, NULL, 5, 4, 5, 5, 5, '96', 5, 5, 4, 5, 5, '96', 4, 3, 4, 4, 5, '80', 5, 5, 5, 5, 5, '100', 93),
(5, NULL, NULL, 4, 4, 4, 5, 4, '84', 4, 4, 4, 4, 4, '80', 4, 5, 4, 5, 4, '88', 4, 4, 4, 5, 4, '84', 84),
(6, NULL, NULL, 4, 4, 5, 4, 4, '84', 4, 4, 5, 4, 4, '84', 4, 4, 5, 4, 5, '88', 4, 4, 5, 4, 4, '84', 85),
(7, NULL, NULL, 4, 4, 5, 3, 5, '84', 4, 3, 4, 5, 5, '84', 5, 4, 4, 4, 5, '88', 4, 4, 5, 4, 5, '88', 86),
(8, NULL, NULL, 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 100),
(9, NULL, NULL, 5, 4, 5, 5, 5, '96', 1, 1, 2, 2, 3, '36', 3, 3, 4, 5, 5, '80', 5, 5, 5, 5, 5, '100', 78),
(10, NULL, NULL, 5, 5, 4, 5, 4, '92', 2, 5, 5, 5, 5, '88', 5, 1, 1, 5, 4, '64', 5, 5, 5, 5, 5, '100', 86),
(11, NULL, NULL, 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 100),
(12, NULL, NULL, 5, 5, 4, 4, 5, '92', 5, 5, 5, 5, 5, '100', 5, 4, 4, 3, 5, '84', 5, 5, 5, 4, 5, '96', 93),
(13, NULL, NULL, 5, 5, 5, 4, 5, '96', 5, 4, 3, 1, 1, '56', 1, 1, 1, 2, 2, '28', 2, 3, 2, 3, 3, '52', 58),
(14, NULL, NULL, 4, 4, 4, 4, 4, '80', 4, 4, 4, 4, 4, '80', 4, 4, 4, 4, 4, '80', 4, 4, 4, 4, 4, '80', 80),
(15, NULL, NULL, 5, 5, 5, 4, 3, '88', 3, 4, 4, 5, 5, '84', 2, 2, 5, 1, 2, '48', 4, 5, 5, 5, 5, '96', 79),
(16, NULL, NULL, 5, 4, 4, 4, 5, '88', 5, 4, 4, 4, 3, '80', 3, 3, 4, 4, 3, '68', 2, 2, 2, 2, 2, '40', 69),
(17, NULL, NULL, 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 100),
(18, NULL, NULL, 5, 4, 5, 5, 5, '96', 4, 3, 3, 4, 3, '68', 3, 4, 5, 5, 5, '88', 5, 5, 5, 5, 5, '100', 88),
(22, NULL, NULL, 5, 5, 5, 4, 4, '92', 4, 3, 2, 3, 4, '64', 5, 5, 5, 5, 5, '100', 5, 5, 3, 5, 5, '92', 87),
(23, NULL, NULL, 5, 4, 4, 4, 5, '88', 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 97),
(24, NULL, NULL, 5, 4, 4, 5, 1, '76', 1, 1, 1, 1, 1, '20', 1, 1, 1, 1, 1, '20', 1, 1, 5, 5, 5, '68', 46),
(25, NULL, NULL, 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 5, 5, 5, 5, 5, '100', 100);

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
-- Indexes for table `academic_rank`
--
ALTER TABLE `academic_rank`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `college_dept`
--
ALTER TABLE `college_dept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `decision`
--
ALTER TABLE `decision`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluation_id` (`evaluation_id`);

--
-- Indexes for table `evaluation_self`
--
ALTER TABLE `evaluation_self`
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
-- AUTO_INCREMENT for table `academic_rank`
--
ALTER TABLE `academic_rank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `account_data`
--
ALTER TABLE `account_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `college_dept`
--
ALTER TABLE `college_dept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `decision`
--
ALTER TABLE `decision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `evaluation_self`
--
ALTER TABLE `evaluation_self`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `evaluation_sub_criteria`
--
ALTER TABLE `evaluation_sub_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `evaluator`
--
ALTER TABLE `evaluator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `evaluation_details`
--
ALTER TABLE `evaluation_details`
  ADD CONSTRAINT `evaluation_details_ibfk_1` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
