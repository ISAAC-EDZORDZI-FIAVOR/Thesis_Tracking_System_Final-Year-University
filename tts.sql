-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2024 at 03:15 PM
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
-- Database: `tts`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `primary_supervisor_id` int(11) DEFAULT NULL,
  `secondary_supervisor_id1` int(11) DEFAULT NULL,
  `secondary_supervisor_id2` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `assigned_at` timestamp(2) NOT NULL DEFAULT current_timestamp(2),
  `faculty_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `student_id`, `primary_supervisor_id`, `secondary_supervisor_id1`, `secondary_supervisor_id2`, `department_id`, `assigned_at`, `faculty_id`) VALUES
(35, 44, 57, 9, 34, 1, '2024-08-01 14:48:35.62', 1),
(42, 2, 8, 9, 34, 1, '2024-08-06 12:21:40.21', 1),
(45, 54, 57, 9, 34, 1, '2024-08-06 18:35:29.37', 1),
(46, 45, 57, 9, 34, 1, '2024-08-07 10:52:44.06', 1),
(47, 32, 57, 33, 9, 1, '2024-08-07 18:00:22.01', 1),
(48, 7, 8, 9, 33, 1, '2024-08-15 12:16:40.73', 1),
(50, 68, 9, 34, 8, 1, '2024-08-16 18:41:31.73', NULL),
(51, 74, 9, 34, 8, 1, '2024-08-16 18:41:31.74', NULL),
(52, 4, 57, 8, 34, 1, '2024-08-16 18:42:05.79', NULL),
(53, 75, 8, 9, 33, 1, '2024-08-16 19:36:55.83', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `assignments_list`
-- (See below for the actual view)
--
CREATE TABLE `assignments_list` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `assignment_details`
-- (See below for the actual view)
--
CREATE TABLE `assignment_details` (
`assignment_id` int(11)
,`student_name` varchar(100)
,`primary_supervisor_name` varchar(100)
,`secondary_supervisor1_name` varchar(100)
,`secondary_supervisor2_name` varchar(100)
,`department_name` varchar(100)
,`department_id` int(11)
,`assigned_at` timestamp(2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `assignment_details1`
-- (See below for the actual view)
--
CREATE TABLE `assignment_details1` (
`assignment_id` int(11)
,`department_id` int(11)
,`department_name` varchar(100)
,`student_name` varchar(100)
,`primary_supervisor_name` varchar(100)
,`secondary_supervisor1_name` varchar(100)
,`secondary_supervisor2_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `assignment_details2`
-- (See below for the actual view)
--
CREATE TABLE `assignment_details2` (
`assignment_id` int(11)
,`student_name` varchar(100)
,`primary_supervisor_name` varchar(100)
,`secondary_supervisor1_name` varchar(100)
,`secondary_supervisor2_name` varchar(100)
,`department_name` varchar(100)
,`faculty_name` varchar(100)
,`assigned_at` timestamp(2)
);

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `chapter_name` varchar(100) NOT NULL,
  `chapter_text` text NOT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('submitted','approved','rejected') DEFAULT 'submitted',
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chapter_progress`
--

CREATE TABLE `chapter_progress` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `lecturer_id` int(11) DEFAULT NULL,
  `chapter_number` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sender_role` enum('student','lecturer') DEFAULT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_progress`
--

INSERT INTO `chapter_progress` (`id`, `student_id`, `lecturer_id`, `chapter_number`, `message`, `sender_role`, `status`, `submission_date`, `reply_to`) VALUES
(1, 45, NULL, 1, 'Chapter one Submitted', 'student', 'pending', '2024-08-08 22:46:35', NULL),
(2, NULL, 9, 1, 'sfgsgsdgsd', 'lecturer', 'accepted', '2024-08-08 22:48:06', NULL),
(3, 45, NULL, 1, 'sdgfdsgdfgs', 'student', 'pending', '2024-08-08 22:48:25', NULL),
(4, 45, NULL, 1, 'hgsdgg', 'student', 'pending', '2024-08-08 22:48:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chapter_type`
--

CREATE TABLE `chapter_type` (
  `id` int(100) NOT NULL,
  `chapter_name` varchar(100) NOT NULL,
  `dateRegistered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_type`
--

INSERT INTO `chapter_type` (`id`, `chapter_name`, `dateRegistered`) VALUES
(1, 'Proposal', '2024-07-03 22:48:02'),
(2, 'Chapter 1: Introduction', '2024-07-03 22:48:02'),
(3, 'Chapter 2: Literature Review', '2024-07-03 22:48:02'),
(4, 'Chapter 3: Methodology', '2024-07-03 22:48:02'),
(5, 'Chapter 4: Results and Discussion', '2024-07-03 22:48:02'),
(6, 'Chapter 5: Conclusion and Recommendations', '2024-07-03 22:48:02'),
(7, 'References', '2024-07-03 22:48:02'),
(8, 'Appendicesaa', '2024-07-03 22:48:02');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dateRegistered` timestamp(2) NOT NULL DEFAULT current_timestamp(2),
  `faculty_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `dateRegistered`, `faculty_id`) VALUES
(1, 'Computer Science', '2024-07-03 18:02:23.14', 1),
(2, 'Information Technology', '2024-07-03 18:02:23.14', 1),
(3, 'Electrical Engineering', '2024-07-03 18:02:23.14', 3),
(4, 'Mechanical Engineering', '2024-07-03 18:02:23.14', 3),
(5, 'Civil Engineering', '2024-07-03 18:02:23.14', 3),
(6, 'Mathematics', '2024-07-03 18:02:23.14', 1),
(7, 'Physics', '2024-07-03 18:02:23.14', 1),
(8, 'Chemistry', '2024-07-03 18:02:23.14', 1),
(9, 'Biology', '2024-07-03 18:02:23.14', 1),
(11, 'Political Science', '2024-07-03 18:42:03.06', 8),
(18, 'Super Admin', '2024-08-13 17:22:26.40', NULL),
(20, 'Integrated Science', '2024-08-15 22:19:11.10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dateRegistered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `dateRegistered`) VALUES
(1, 'Faculty of Science', '2024-08-13 16:28:06'),
(2, 'Faculty of Arts and Humanities', '2024-08-13 16:28:06'),
(3, 'Faculty of Engineering', '2024-08-13 16:28:06'),
(4, 'Faculty of Medicine', '2024-08-13 16:28:06'),
(5, 'Faculty of Business and Economics', '2024-08-13 16:28:06'),
(6, 'Faculty of Education', '2024-08-13 16:28:06'),
(7, 'Faculty of Law', '2024-08-13 16:28:06'),
(8, 'Faculty of Social Sciences', '2024-08-13 16:28:06'),
(9, 'Faculty of Agriculture', '2024-08-13 16:28:06'),
(10, 'Faculty of Information Technology', '2024-08-13 16:28:06'),
(12, 'dgdgfdgdg', '2024-08-14 15:18:27'),
(13, 'fsfsfsf', '2024-08-14 15:19:01'),
(14, 'sfsdfafda', '2024-08-14 15:19:18'),
(15, 'fsfsfs7564', '2024-08-14 15:19:42'),
(16, 'lkjhgfdertyuil;', '2024-08-14 15:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thesis`
--

CREATE TABLE `thesis` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `status` enum('pending','in_progress','completed','rejected') NOT NULL DEFAULT 'pending',
  `submission_date` date DEFAULT NULL,
  `approval_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thesischapters`
--

CREATE TABLE `thesischapters` (
  `id` int(11) NOT NULL,
  `thesis_id` int(11) NOT NULL,
  `chapter_name` varchar(100) NOT NULL,
  `chapter_text` text DEFAULT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thesiscomments`
--

CREATE TABLE `thesiscomments` (
  `id` int(11) NOT NULL,
  `thesis_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thesis_interactions`
--

CREATE TABLE `thesis_interactions` (
  `id` int(11) NOT NULL,
  `thesis_proposal_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thesis_interactions`
--

INSERT INTO `thesis_interactions` (`id`, `thesis_proposal_id`, `user_id`, `title`, `description`, `message`, `created_at`) VALUES
(1, 39, 75, 'Causes of rain fall in  Ghana and It Effect on the Climate Change', 'Aliquam luctus nunc id sagittis scelerisque. Suspendisse egestas eu tellus sit amet dapibus. Morbi lacinia erat et maximus dignissim. Nullam eu gravida purus. Aenean mollis non urna vitae consequat. Nulla interdum aliquet congue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit, nulla et accumsan vestibulum, eros libero interdum lacus, id congue ante leo et dolor. Morbi orci augue, sagittis at ultricies faucibus, faucibus eget est. Nullam viverra eu felis quis mattis. Fusce iaculis est sapien, quis tempus elit tempus non. Curabitur a urna non ante tempor viverra. Curabitur posuere arcu ac accumsan ornare. Nulla a egestas purus.', 'Proposal submitted', '2024-08-17 14:18:47'),
(2, 39, 9, 'Proposal Review', 'Status: rejected', 'text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in', '2024-08-17 15:29:26'),
(3, 39, 9, 'Proposal Review', 'Status: approved', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in ', '2024-08-17 16:45:12'),
(4, 39, 9, 'Proposal Review', 'Status: rejected', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in ', '2024-08-17 16:48:13'),
(5, 39, 75, 'The Use of Educational App to improve on the learning of Mathematics in Basic School Level in Ghana', 'humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the', 'Proposal submitted', '2024-08-17 17:31:19'),
(6, 39, 9, 'Proposal Review', 'Status: rejected', 'the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum', '2024-08-17 17:37:17'),
(7, 39, 75, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'omes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32', 'Proposal submitted', '2024-08-17 17:45:39'),
(8, 39, 9, 'Proposal Review', 'Status: approved', 'omes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32', '2024-08-17 17:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `thesis_proposals`
--

CREATE TABLE `thesis_proposals` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `primary_supervisor_id` int(11) NOT NULL,
  `secondary_supervisor_id1` int(11) DEFAULT NULL,
  `secondary_supervisor_id2` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment` text DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `lecturer_comment_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thesis_proposals`
--

INSERT INTO `thesis_proposals` (`id`, `student_id`, `primary_supervisor_id`, `secondary_supervisor_id1`, `secondary_supervisor_id2`, `title`, `description`, `status`, `submission_date`, `comment`, `faculty_id`, `department_id`, `file_path`, `lecturer_comment_time`) VALUES
(31, 56, 34, 33, 9, 'sdfghjkl;\';lkjhgfdsdfghjkl;;lkjhgfdfghjk', 'dfghjkl;\';lkjhgfdsdfghjkl;\'lk', 'pending', '2024-08-06 16:14:04', NULL, NULL, NULL, NULL, NULL),
(33, 54, 57, 9, 34, 'ghjkl;\'uioptrytyrutyi', 'wesrdfghjlk;\';lkjhgfghl', 'approved', '2024-08-06 19:05:40', 'xxx', NULL, NULL, NULL, NULL),
(34, 45, 57, 9, 34, 'God is Good', 'Aliquam luctus nunc id sagittis scelerisque. Suspendisse egestas eu tellus sit amet dapibus. Morbi lacinia erat et maximus dignissim. Nullam eu gravida purus. Aenean mollis non urna vitae consequat. Nulla interdum aliquet congue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit, nulla et accumsan vestibulum, eros libero interdum lacus, id congue ante leo et dolor. Morbi orci augue, sagittis at ultricies faucibus, faucibus eget est. Nullam viverra eu felis quis mattis. Fusce iaculis est sapien, quis tempus elit tempus non. Curabitur a urna non ante tempor viverra. Curabitur posuere arcu ac accumsan ornare. Nulla a egestas purus.', 'approved', '2024-08-08 01:08:23', 'I love this Proposal Topic', NULL, NULL, NULL, NULL),
(35, 32, 57, 33, 9, 'fygkghfgdfg', 'ertjyu6iotuuterywertyreyeryryryr', 'rejected', '2024-08-07 18:01:49', 'asdfgjkl;;p[poiuytfdrseawSADFKJL;', NULL, NULL, NULL, NULL),
(39, 75, 8, 9, 33, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'omes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32', 'approved', '2024-08-17 17:45:39', 'omes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32', 1, 1, '../uploads/proposals/984567748_CYNTHIA_NYOVI_MACHOKA_proposal.pdf', '2024-08-17 17:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','lecturer','hod','dean','department_admin','super_admin','faculty_admin') DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `email` varchar(100) GENERATED ALWAYS AS (concat(`username`,'@',substr(`role`,1,2),'.uew.edu.gh')) VIRTUAL,
  `dateRegistered` timestamp NOT NULL DEFAULT current_timestamp(),
  `student_level` varchar(20) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `role`, `department_id`, `dateRegistered`, `student_level`, `faculty_id`) VALUES
(2, '202124977', 'ISAAC EDZORDZI FIAVOR', '$2y$10$xeF.UQEKDmRDEgk6SgzJseBzH1lN8Bkiyfy4b6qYv1Tr42.hRpfLa', 'student', 1, '2024-07-03 18:04:23', '', 1),
(4, '202125988', 'SULEMANA ADUL SALINA', '$2y$10$q0I/XFwH/OWxaeF/S8oew.7I2E/.mHCDdfz.RJzqHujkybcuYUCnC', 'student', 1, '2024-07-03 18:06:17', '', 1),
(7, 'L500', 'ENERST YAO TREKPA', '$2y$10$WO2vZAgESPN5SmjicUOtxuV4wLX/XdCd0Bpmnjsi3A6oJ0oIr/4.u', 'student', 1, '2024-07-03 18:36:32', '', 1),
(8, 'L5001', 'KOFI AMA FRIMPONG', '$2y$10$uG2lmcSDB0JJ2eptKp5tkeK9qQJLsBziYCxI/mt4cOoe5.Xks14xi', 'lecturer', 1, '2024-07-04 01:17:11', '', 1),
(9, 'L5002', 'DELA SOWA DRAVI', '$2y$10$oTUdNVA3HbMzjWHYSa/crOSR.bPMIuA7.mIzY.ziFU59hyD4zmA12', 'lecturer', 1, '2024-07-04 01:17:57', '', 1),
(15, '204323484', 'KESSIE KORANTENG FIFI', '$2y$10$h8WS7Yczg4Et64kPROGSwO5BUBzS9J3.KHmcnt3rwGC9Bv76gkx.S', 'student', 8, '2024-07-11 16:52:54', '', 1),
(16, '202188774', 'AGYEMANAG REUBEN YORVIVOR', '$2y$10$r3LRt7GzDxcdabkOKR1GCOvQHAiHroUhnLqh1TezGQQ9gT42s5CD6', 'lecturer', 3, '2024-07-11 16:58:05', '', 3),
(19, '2067227485', 'SAVIOUR CYNTHIA MASSU', '$2y$10$wVmATDMO0AT.5.f/WnPLDOFRvcxm8mtVT.BWhz2uWhfcTpetvJNnW', 'student', 1, '2024-07-14 13:12:50', '', 1),
(21, '2042347543', 'TESY FORSON AKUA', '$2y$10$HQgEKwNcCB8dLSp6A/vgROiGKmvG6mJ9uqeyNcUcCA3tDFFIbWFd2', 'lecturer', 3, '2024-07-14 13:12:50', '', 3),
(26, '454354', 'GLORIA WORNYO DOAGBEDA', '$2y$10$OIzn1mTcSwAO5yjcpd16hulZ5G2ncrlTLLNByIca4zepA1PAMnwXu', 'lecturer', 5, '2024-07-14 13:42:13', '', 3),
(28, '23456', 'SELORM ENOVI KOFIAAAA', '$2y$10$viEHkT45COLY3ufny9Yfy.soD2yVcldA68nnZCoYcy2NrpKtbOyre', 'student', 3, '2024-07-14 13:46:15', '', 3),
(30, '97854655', 'ISAAC EDZORDZI FIAVOR', '$2y$10$/hPSmk7uNiGQuPcc/H6nC.jEMolU4tDCKH0fvGKRSW4VToP38Z4rG', 'hod', 7, '2024-07-14 15:26:31', '', 1),
(31, '687463', 'KOFI DADY SEYRAM', '$2y$10$L8MxkF9LZ7BzAEJx6.g7UOtDZjkfoyYnpNO4W18MXkstMbmqmQ4Sy', 'lecturer', 2, '2024-07-15 15:42:01', '', 10),
(32, '234567', 'DEMO NAME FOR', '$2y$10$0SNDMxWZxtSVYC9D4TEwde6QagXzS.Pww6rOgOCmwzq8zUMNXcJzm', 'student', 1, '2024-07-16 18:21:07', '5th Years', 1),
(33, '590804EE', 'EKOW MANGO TOOFE', '$2y$10$qQ8MXL4d9X/tnX4deBb9Me2.hBmxiVUWiQWqpvHPO/tNwn.oRWsda', 'lecturer', 1, '2024-07-16 18:22:05', '', 1),
(34, '54687545', 'JOLIW KOFI MAMZ', '$2y$10$vo94E/s1KgQ82/v2MPcDA.5Jaj3e8ejcQpOlvvBXSnJxd6DqaIa.m', 'lecturer', 1, '0000-00-00 00:00:00', '', NULL),
(35, '545464', 'SAMUEL KOFI DORDOE', '$2y$10$NRp2Ib846Pz0i1yONKd1juYbgc8st.9vNwSd1COXKoHOIMMHNt73O', 'student', 6, '2024-07-17 16:39:27', '', NULL),
(36, 'L45435', 'LOVELACE AMA GHANA', '$2y$10$5trTrFZ.XXJWyCWAWBfDcuNh/JRm.MFVo6EESkEPwjoNxANR8T1BO', 'lecturer', 6, '2024-07-17 16:40:07', '', NULL),
(44, '20213377', 'DESMOND ATIASIA BREMPONG', '$2y$10$88xWmwjQ1UueIxX87hPjYemW.krmcxQ8fv3rVAylamtp85pHnv.j2', 'student', 1, '2024-07-19 13:21:33', '', NULL),
(45, '20219966', 'JERRY KING ETORNAM', '$2y$10$ZFODZAGUXiNTJ8Z/Nldbiu98OGJMiw89jk7xSlsm2BkpkwPJH7gRi', 'student', 1, '2024-07-20 16:50:55', '', NULL),
(47, '206799775', 'SAVIOUR AGLIGO SELORM', '$2y$10$BrGLOn7P5ueKzkpeuhminOPN8oXVAgzlhU3LmimYJDV7nv0KTjRF.', 'student', 1, '2024-07-27 16:54:19', '6th Years', NULL),
(48, '240208482', 'KENNETH GEORGE FIFI', '$2y$10$HmICnth0PJzPaE/nxYEhqO0AadUyVO603Uoa94onjnct/54zKlhBe', '', 2, '2024-07-27 16:54:19', '', NULL),
(49, '2040083543', 'TESY GORSON DAVI', '$2y$10$uAsuZJuECEdimam08ITXGO.NK5jyvEJKcWk8BXxFykw/BDiTisyLC', 'lecturer', 3, '2024-07-27 16:54:20', '', NULL),
(54, '202178843', 'EMILE JOHN DOE', '$2y$10$UZPwLsemdQOHwgSfpN4fQOpbRq0P2bVv7THKofnkR6Xz0zRf4sm2m', 'student', 1, '2024-08-01 15:36:32', '5th Years', NULL),
(56, '202133998', 'OKENNETH YOVI AMAQ', '$2y$10$FCinSX/Z.eYUuxk9kgV04OwHJxGHuIgEXWSySJRBrovi.eGYXCQBK', 'student', 1, '2024-08-06 12:26:08', '5th Years', NULL),
(57, '987776467', 'ISAAC EDZORDZI FIAVOR1', '$2y$10$zGDZWtrVAUPSN7a7koHqOuw8xPNhFygK8GA3lUc3uMpa2PjxBeKmO', 'lecturer', 1, '2024-08-06 18:20:03', NULL, NULL),
(63, 'SupAdmin', 'ISAAC EDZORDZI FIAVOR', '$2y$10$YTgHH.CQ6343/QgTyM4HHug/OxznKkpE/ohFcN2r2WkWRnSYGFfY6', 'super_admin', 18, '2024-08-13 17:25:38', NULL, NULL),
(64, '202533454', 'DELADEM KOFI TETTEY', '$2y$10$XRHQIucy0O97GWV9pXwWS.QePKkyzM0g8Rf2hDUsCUeZNHDs0uda6', 'student', 1, '2024-08-14 16:45:18', '5th Years', 1),
(67, '1206790005', 'JANE AGLIGO ABASH', '$2y$10$CDbmC9NlPIhQeyrYpSu0m.xoeNvJaXmlqulZ3ybysY3u/UjpjfjhC', 'student', 2, '2024-08-14 19:52:20', '5th Year', 1),
(68, '1240778482', 'JAMES GEORGE FIFIAVOR', '$2y$10$U8ovwLBOXK.9kDDiVjBX.uM2MrqvjR.4DoRKj711hEckKRWmYI5Rm', 'student', 1, '2024-08-14 19:52:20', '4th Year', 1),
(69, '1204008333', 'TESYIVOR GODSWAY DAVIDSON', '$2y$10$mXRs14SDTAYMOi1xHQcA1edolM7hUVrojxpCjHYLbE9NQkddFjICu', 'student', 5, '2024-08-14 19:52:20', '6th Year', 3),
(70, 'FacultyAdmin', 'SAMUEL DORDOE KOFI', '$2y$10$9D.xYMDgl0O1JeJY7kl8P.H3Vp/9ipE69xiQYrUpTEo1LBqQZm0Di', 'faculty_admin', 1, '2024-08-15 21:11:42', NULL, 1),
(71, 'DepAdmin', 'SAMPSON JIDI AYONIA', '$2y$10$k6MloAcRUevyfpIUdpJgQ.t1Zef9MiAN/Sx0jBhKffyXaxSycNzgO', 'department_admin', 1, '2024-08-16 00:15:25', NULL, 1),
(72, '74555', 'OKAKAI ALFRED AMAQ', '$2y$10$WrkBg9hoEl1g/De1M0fUx.CmY.EC.gyd5Mv9QGz8Wpjv5bTMPcFFO', 'student', 8, '2024-08-16 10:42:48', '5th Years', 1),
(74, '2035767485', 'YADIA BAABA YAO', '$2y$10$OqBClnfVOBLN5RhjEyfLTul9AfpT6rQ6hLOSNIPjErJN7FG8lZDvi', 'student', 1, '2024-08-16 15:47:20', '5th Years', 1),
(75, '984567748', 'CYNTHIA NYOVI MACHOKA', '$2y$10$ASMQflDqU707AZFcXp9WWepE2ZG4SQ0a3lWHrJvBBQ8Wh.JtdkLhK', 'student', 1, '2024-08-16 19:11:35', '5th Year', 1);

-- --------------------------------------------------------

--
-- Table structure for table `uuu`
--

CREATE TABLE `uuu` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `department_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure for view `assignments_list`
--
DROP TABLE IF EXISTS `assignments_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `assignments_list`  AS SELECT `a`.`id` AS `id`, `u`.`fullname` AS `student_name`, `l`.`fullname` AS `lecturer_name`, `d`.`name` AS `department_name` FROM (((`assignments` `a` join `users` `u` on(`a`.`student_id` = `u`.`id`)) join `users` `l` on(`a`.`lecturer_id` = `l`.`id`)) join `departments` `d` on(`a`.`department_id` = `d`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `assignment_details`
--
DROP TABLE IF EXISTS `assignment_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `assignment_details`  AS SELECT `a`.`id` AS `assignment_id`, `s`.`fullname` AS `student_name`, `ps`.`fullname` AS `primary_supervisor_name`, `ss1`.`fullname` AS `secondary_supervisor1_name`, `ss2`.`fullname` AS `secondary_supervisor2_name`, `d`.`name` AS `department_name`, `d`.`id` AS `department_id`, `a`.`assigned_at` AS `assigned_at` FROM (((((`assignments` `a` join `users` `s` on(`a`.`student_id` = `s`.`id`)) join `users` `ps` on(`a`.`primary_supervisor_id` = `ps`.`id`)) join `users` `ss1` on(`a`.`secondary_supervisor_id1` = `ss1`.`id`)) join `users` `ss2` on(`a`.`secondary_supervisor_id2` = `ss2`.`id`)) join `departments` `d` on(`a`.`department_id` = `d`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `assignment_details1`
--
DROP TABLE IF EXISTS `assignment_details1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `assignment_details1`  AS SELECT `a`.`id` AS `assignment_id`, `departments`.`id` AS `department_id`, `departments`.`name` AS `department_name`, `s`.`fullname` AS `student_name`, `p`.`fullname` AS `primary_supervisor_name`, `s1`.`fullname` AS `secondary_supervisor1_name`, `s2`.`fullname` AS `secondary_supervisor2_name` FROM (((((`assignments` `a` join `users` `s` on(`a`.`student_id` = `s`.`id`)) join `users` `p` on(`a`.`primary_supervisor_id` = `p`.`id`)) left join `users` `s1` on(`a`.`secondary_supervisor_id1` = `s1`.`id`)) left join `users` `s2` on(`a`.`secondary_supervisor_id2` = `s2`.`id`)) join `departments`) ;

-- --------------------------------------------------------

--
-- Structure for view `assignment_details2`
--
DROP TABLE IF EXISTS `assignment_details2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `assignment_details2`  AS SELECT `a`.`id` AS `assignment_id`, `s`.`fullname` AS `student_name`, `p`.`fullname` AS `primary_supervisor_name`, `s1`.`fullname` AS `secondary_supervisor1_name`, `s2`.`fullname` AS `secondary_supervisor2_name`, `d`.`name` AS `department_name`, `f`.`name` AS `faculty_name`, `a`.`assigned_at` AS `assigned_at` FROM ((((((`assignments` `a` join `users` `s` on(`a`.`student_id` = `s`.`id`)) join `users` `p` on(`a`.`primary_supervisor_id` = `p`.`id`)) left join `users` `s1` on(`a`.`secondary_supervisor_id1` = `s1`.`id`)) left join `users` `s2` on(`a`.`secondary_supervisor_id2` = `s2`.`id`)) join `departments` `d` on(`a`.`department_id` = `d`.`id`)) join `faculties` `f` on(`a`.`faculty_id` = `f`.`id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fk_department_id` (`department_id`),
  ADD KEY `fk_primary_supervisor` (`primary_supervisor_id`),
  ADD KEY `fk_secondary_supervisor1` (`secondary_supervisor_id1`),
  ADD KEY `fk_secondary_supervisor2` (`secondary_supervisor_id2`),
  ADD KEY `fk_assignments_faculty` (`faculty_id`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chapters_student_id` (`student_id`),
  ADD KEY `idx_chapters_chapter_name` (`chapter_name`);

--
-- Indexes for table `chapter_progress`
--
ALTER TABLE `chapter_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Indexes for table `chapter_type`
--
ALTER TABLE `chapter_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chapter_name` (`chapter_name`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `thesis`
--
ALTER TABLE `thesis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `supervisor_id` (`supervisor_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `thesischapters`
--
ALTER TABLE `thesischapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thesis_id` (`thesis_id`);

--
-- Indexes for table `thesiscomments`
--
ALTER TABLE `thesiscomments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thesis_id` (`thesis_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `thesis_interactions`
--
ALTER TABLE `thesis_interactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thesis_proposal_id` (`thesis_proposal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `thesis_proposals`
--
ALTER TABLE `thesis_proposals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `fk_primary_supervisor_id` (`primary_supervisor_id`),
  ADD KEY `fk_secondary_supervisor_id1` (`secondary_supervisor_id1`),
  ADD KEY `fk_secondary_supervisor_id2` (`secondary_supervisor_id2`),
  ADD KEY `fk_thesis_proposals_faculty` (`faculty_id`),
  ADD KEY `fk_thesis_proposals_department` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `fk_user_faculty` (`faculty_id`);

--
-- Indexes for table `uuu`
--
ALTER TABLE `uuu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chapter_progress`
--
ALTER TABLE `chapter_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chapter_type`
--
ALTER TABLE `chapter_type`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thesis`
--
ALTER TABLE `thesis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thesischapters`
--
ALTER TABLE `thesischapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thesiscomments`
--
ALTER TABLE `thesiscomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thesis_interactions`
--
ALTER TABLE `thesis_interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `thesis_proposals`
--
ALTER TABLE `thesis_proposals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `uuu`
--
ALTER TABLE `uuu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_assignments_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `fk_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `fk_primary_supervisor` FOREIGN KEY (`primary_supervisor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_secondary_supervisor1` FOREIGN KEY (`secondary_supervisor_id1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_secondary_supervisor2` FOREIGN KEY (`secondary_supervisor_id2`) REFERENCES `users` (`id`);

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chapters_ibfk_2` FOREIGN KEY (`chapter_name`) REFERENCES `chapter_type` (`chapter_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chapter_progress`
--
ALTER TABLE `chapter_progress`
  ADD CONSTRAINT `chapter_progress_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_progress_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `thesis`
--
ALTER TABLE `thesis`
  ADD CONSTRAINT `thesis_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `thesis_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `thesis_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `thesischapters`
--
ALTER TABLE `thesischapters`
  ADD CONSTRAINT `thesischapters_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `thesis` (`id`);

--
-- Constraints for table `thesiscomments`
--
ALTER TABLE `thesiscomments`
  ADD CONSTRAINT `thesiscomments_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `thesis` (`id`),
  ADD CONSTRAINT `thesiscomments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `thesis_interactions`
--
ALTER TABLE `thesis_interactions`
  ADD CONSTRAINT `thesis_interactions_ibfk_1` FOREIGN KEY (`thesis_proposal_id`) REFERENCES `thesis_proposals` (`id`),
  ADD CONSTRAINT `thesis_interactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `thesis_proposals`
--
ALTER TABLE `thesis_proposals`
  ADD CONSTRAINT `fk_primary_supervisor_id` FOREIGN KEY (`primary_supervisor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_secondary_supervisor_id1` FOREIGN KEY (`secondary_supervisor_id1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_secondary_supervisor_id2` FOREIGN KEY (`secondary_supervisor_id2`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_thesis_proposals_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `fk_thesis_proposals_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `thesis_proposals_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_faculty` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
