-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2024 at 06:08 PM
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
(52, 4, 57, 8, 34, 1, '2024-08-16 18:42:05.79', NULL),
(54, 76, 9, 8, 33, 1, '2024-08-18 13:43:11.36', 1),
(56, 79, 78, 78, 78, 2, '2024-08-26 10:21:23.48', 1),
(57, 84, 78, 80, 83, 2, '2024-08-26 11:48:58.35', 1),
(58, 28, 16, 21, 49, 3, '2024-08-27 14:50:57.46', NULL),
(59, 90, 16, 21, 49, 3, '2024-08-27 14:50:57.46', NULL),
(60, 15, 103, 103, 103, 8, '2024-09-06 18:06:54.68', 1);

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
-- Table structure for table `chapter_five`
--

CREATE TABLE `chapter_five` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `primary_supervisor_id` int(11) NOT NULL,
  `secondary_supervisor_id1` int(11) DEFAULT NULL,
  `secondary_supervisor_id2` int(11) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `comment` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','revise') DEFAULT 'pending',
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `lecturer_comment_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_five`
--

INSERT INTO `chapter_five` (`id`, `student_id`, `primary_supervisor_id`, `secondary_supervisor_id1`, `secondary_supervisor_id2`, `faculty_id`, `department_id`, `title`, `description`, `comment`, `file_path`, `status`, `submission_date`, `lecturer_comment_time`) VALUES
(1, 76, 9, 8, 33, 1, 1, 'lkjhgfoiuytrewq87uy6trew', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', NULL, 'approved', '2024-08-25 01:21:40', '2024-08-25 01:22:17'),
(2, 15, 103, 103, 103, 1, 8, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'jected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making', 'jected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making', NULL, 'approved', '2024-09-07 15:57:24', '2024-09-07 15:57:53');

-- --------------------------------------------------------

--
-- Table structure for table `chapter_five_interactions`
--

CREATE TABLE `chapter_five_interactions` (
  `id` int(11) NOT NULL,
  `chapter_five_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_five_interactions`
--

INSERT INTO `chapter_five_interactions` (`id`, `chapter_five_id`, `user_id`, `title`, `description`, `message`, `created_at`) VALUES
(1, 1, 76, 'lkjhgfoiuytrewq87uy6trew', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', 'Sir Please I have Submitted Chapter Five', '2024-08-25 01:21:40'),
(2, 1, 9, 'Chapter Five  Review', 'Status: approved', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', '2024-08-25 01:22:17'),
(3, 2, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'Sir Please I have Submitted Chapter Five', '2024-09-07 15:05:35'),
(4, 2, 103, 'Chapter Five  Review', 'Status: revise', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2024-09-07 15:18:17'),
(5, 2, 103, 'Chapter Five  Review', 'Status: rejected', 'jected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making', '2024-09-07 15:50:33'),
(6, 2, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'jected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making', 'Sir Please I have Submitted Chapter Five', '2024-09-07 15:51:08'),
(7, 2, 103, 'Chapter Five  Review', 'Status: revise', 'jected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making', '2024-09-07 15:53:22'),
(8, 2, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'jected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making', 'Sir Please I have Submitted Chapter Five', '2024-09-07 15:57:24'),
(9, 2, 103, 'Chapter Five  Review', 'Status: approved', 'jected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making', '2024-09-07 15:57:53');

-- --------------------------------------------------------

--
-- Table structure for table `chapter_four`
--

CREATE TABLE `chapter_four` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `primary_supervisor_id` int(11) NOT NULL,
  `secondary_supervisor_id1` int(11) DEFAULT NULL,
  `secondary_supervisor_id2` int(11) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `comment` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','revise') DEFAULT 'pending',
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `lecturer_comment_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_four`
--

INSERT INTO `chapter_four` (`id`, `student_id`, `primary_supervisor_id`, `secondary_supervisor_id1`, `secondary_supervisor_id2`, `faculty_id`, `department_id`, `title`, `description`, `comment`, `file_path`, `status`, `submission_date`, `lecturer_comment_time`) VALUES
(1, 76, 9, 8, 33, 1, 1, 'asdfghjkl;\'lkjhgfdsdfghjkl;\';lkjhgfdbhdhjkhlfdg', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', '../uploads/Chapter_Four/20784838_RITA_ALOMOTEY_EMEFA_chapter_four.pdf', 'approved', '2024-08-25 01:16:28', '2024-08-25 01:16:58'),
(3, 15, 103, 103, 103, 1, 8, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'jected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making', '../uploads/Chapter_Four/204323484_KESSIE_KORANTENG_FIFI_chapter_four.pdf', 'approved', '2024-09-07 14:35:35', '2024-09-07 15:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `chapter_four_interactions`
--

CREATE TABLE `chapter_four_interactions` (
  `id` int(11) NOT NULL,
  `chapter_four_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_four_interactions`
--

INSERT INTO `chapter_four_interactions` (`id`, `chapter_four_id`, `user_id`, `title`, `description`, `message`, `created_at`) VALUES
(1, 1, 76, 'wasdfghjkl,;lkjhgfdsdfghjkl;\'lkjhugtfdghjkl;lkjhgfdfghujikopl;\'lkjihuygt', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', 'Sir Please I have Submitted Chapter Four', '2024-08-25 01:15:08'),
(2, 1, 9, 'Chapter Four  Review', 'Status: rejected', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', '2024-08-25 01:15:51'),
(3, 1, 76, 'asdfghjkl;\'lkjhgfdsdfghjkl;\';lkjhgfdbhdhjkhlfdg', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', 'Sir Please I have Submitted Chapter Four', '2024-08-25 01:16:28'),
(4, 1, 9, 'Chapter Four  Review', 'Status: approved', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', '2024-08-25 01:16:58'),
(5, 3, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'Sir Please I have Submitted Chapter Four', '2024-09-07 14:05:36'),
(6, 3, 103, 'Chapter Four  Review', 'Status: revise', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2024-09-07 14:29:40'),
(7, 3, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 'Sir Please I have Submitted Chapter Four', '2024-09-07 14:35:35'),
(8, 3, 103, 'Chapter Four  Review', 'Status: approved', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2024-09-07 14:38:19'),
(9, 3, 103, 'Chapter Four  Review', 'Status: revise', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2024-09-07 15:18:42'),
(10, 3, 103, 'Chapter Four  Review', 'Status: approved', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2024-09-07 15:19:32'),
(11, 3, 103, 'Chapter Four  Review', 'Status: revise', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2024-09-07 15:20:26'),
(12, 3, 103, 'Chapter Four  Review', 'Status: approved', 'jected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making', '2024-09-07 15:34:11'),
(13, 3, 103, 'Chapter Four  Review', 'Status: rejected', 'jected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making', '2024-09-07 15:52:11'),
(14, 3, 103, 'Chapter Four  Review', 'Status: approved', 'jected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making', '2024-09-07 15:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `chapter_one`
--

CREATE TABLE `chapter_one` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `primary_supervisor_id` int(11) NOT NULL,
  `secondary_supervisor_id1` int(11) DEFAULT NULL,
  `secondary_supervisor_id2` int(11) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `comment` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','revise') DEFAULT 'pending',
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `lecturer_comment_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_one`
--

INSERT INTO `chapter_one` (`id`, `student_id`, `primary_supervisor_id`, `secondary_supervisor_id1`, `secondary_supervisor_id2`, `faculty_id`, `department_id`, `title`, `description`, `comment`, `file_path`, `status`, `submission_date`, `lecturer_comment_time`) VALUES
(1, 54, 57, 9, 34, 1, 1, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, ', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through t', '../uploads/Chapter_One/202178843_EMILE_JOHN_DOE_chapter_One.pdf', 'rejected', '2024-08-18 23:50:36', '2024-08-20 16:00:58'),
(5, 76, 9, 8, 33, 1, 1, 'The use of Smart shirt to improve upon the security of the visually impaired', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through t', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through t', '../uploads/Chapter_One/20784838_RITA_ALOMOTEY_EMEFA_chapter_One.pdf', 'approved', '2024-08-20 18:32:44', '2024-08-20 18:34:31'),
(7, 79, 78, 78, 78, 1, 2, 'Uses of AI in Education', 'type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchang', 'Bad Bad Bad', '../uploads/Chapter_One/8231570001_Prince_Essel_chapter_One.pdf', 'rejected', '2024-08-26 10:42:31', '2024-08-26 10:47:11'),
(8, 45, 57, 9, 34, 1, 1, 'rtukl\';\';lkjhgfdghjkl;\'lkj', 'fghjko[p[;lkjfhgfghjklhgghfjgkhljk', 'sdsftyuiop[lkjhgfdsdftyuiopdflkjlkjs\r\njflkjsalfjslajflsjflsajfljsf\r\nslhfskjhfkshfshfkshfks\r\nshfkshfkshkfsdhkhsdfhskhfs\r\nhskhfkshkshfkjsjfshkfhs', '../uploads/Chapter_One/20219966_JERRY_KING_ETORNAM_chapter_One.pdf', 'pending', '2024-09-05 11:38:39', '2024-09-01 10:57:50'),
(12, 15, 103, 103, 103, 1, 8, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', NULL, 'approved', '2024-09-07 12:56:32', '2024-09-07 12:57:54');

-- --------------------------------------------------------

--
-- Table structure for table `chapter_one_interactions`
--

CREATE TABLE `chapter_one_interactions` (
  `id` int(11) NOT NULL,
  `chapter_one_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_one_interactions`
--

INSERT INTO `chapter_one_interactions` (`id`, `chapter_one_id`, `user_id`, `title`, `description`, `message`, `created_at`) VALUES
(1, 1, 54, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'urvived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publ', 'Sir Please I have Submitted Chapter One', '2024-08-18 21:27:59'),
(2, 1, 9, 'Chapter One  Review', 'Status: rejected', 'urvived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publ', '2024-08-18 23:14:44'),
(5, 1, 54, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, ', 'Sir Please I have Submitted Chapter One', '2024-08-18 23:50:36'),
(6, 1, 9, 'Chapter One  Review', 'Status: approved', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, ', '2024-08-18 23:51:30'),
(7, 1, 9, 'Chapter One  Review', 'Status: rejected', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through t', '2024-08-20 16:00:58'),
(8, 5, 76, 'The use of Smart shirt to improve upon the security of the visually impaired', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through t', 'Sir Please I have Submitted Chapter One', '2024-08-20 18:32:32'),
(9, 5, 76, 'The use of Smart shirt to improve upon the security of the visually impaired', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through t', 'Sir Please I have Submitted Chapter One', '2024-08-20 18:32:44'),
(10, 5, 9, 'Chapter One  Review', 'Status: approved', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through t', '2024-08-20 18:34:31'),
(11, 7, 79, 'Uses of AI in Education', 'type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchang', 'Sir Please I have Submitted Chapter One', '2024-08-26 10:42:31'),
(12, 7, 78, 'Chapter One  Review', 'Status: rejected', 'Bad Bad Bad', '2024-08-26 10:47:11'),
(13, 8, 45, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'wetyuiop\'l;\r\n\';lkjhgfdsadfgrthyjukio;p\'[\';lkjhgtrf', 'Sir Please I have Submitted Chapter One', '2024-09-01 10:03:55'),
(14, 8, 9, 'Chapter One  Review', 'Status: rejected', 'sdsftyuiop[lkjhgfdsdftyuiopdflkjlkjs\r\njflkjsalfjslajflsjflsajfljsf\r\nslhfskjhfkshfshfkshfks\r\nshfkshfkshkfsdhkhsdfhskhfs\r\nhskhfkshkshfkjsjfshkfhs', '2024-09-01 10:57:50'),
(15, 8, 45, 'rtukl\';\';lkjhgfdghjkl;\'lkj', 'fghjko[p[;lkjfhgfghjklhgghfjgkhljk', 'Sir Please I have Submitted Chapter One', '2024-09-05 11:38:20'),
(16, 8, 45, 'rtukl\';\';lkjhgfdghjkl;\'lkj', 'fghjko[p[;lkjfhgfghjklhgghfjgkhljk', 'Sir Please I have Submitted Chapter One', '2024-09-05 11:38:28'),
(17, 8, 45, 'rtukl\';\';lkjhgfdghjkl;\'lkj', 'fghjko[p[;lkjfhgfghjklhgghfjgkhljk', 'Sir Please I have Submitted Chapter One', '2024-09-05 11:38:39'),
(18, 12, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 't is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'Sir Please I have Submitted Chapter One', '2024-09-06 20:01:29'),
(19, 12, 103, 'Chapter One  Review', 'Status: revise', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', '2024-09-07 12:45:31'),
(20, 12, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', 'Sir Please I have Submitted Chapter One', '2024-09-07 12:56:32'),
(21, 12, 103, 'Chapter One  Review', 'Status: approved', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', '2024-09-07 12:57:55');

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
-- Table structure for table `chapter_three`
--

CREATE TABLE `chapter_three` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `primary_supervisor_id` int(11) NOT NULL,
  `secondary_supervisor_id1` int(11) DEFAULT NULL,
  `secondary_supervisor_id2` int(11) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `comment` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','revise') DEFAULT 'pending',
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `lecturer_comment_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_three`
--

INSERT INTO `chapter_three` (`id`, `student_id`, `primary_supervisor_id`, `secondary_supervisor_id1`, `secondary_supervisor_id2`, `faculty_id`, `department_id`, `title`, `description`, `comment`, `file_path`, `status`, `submission_date`, `lecturer_comment_time`) VALUES
(1, 76, 9, 8, 33, 1, 1, 'asdfghjnkm,l.;\';lkjhgfdsadfghjkl;kjuyhtrfedsfhgjkljhgfdfghj', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', NULL, 'approved', '2024-08-25 01:12:10', '2024-08-25 01:12:49'),
(2, 15, 103, 103, 103, 1, 8, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', '../uploads/Chapter_Three/204323484_KESSIE_KORANTENG_FIFI_chapter_three.pdf', 'approved', '2024-09-07 13:38:12', '2024-09-07 13:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `chapter_three_interactions`
--

CREATE TABLE `chapter_three_interactions` (
  `id` int(11) NOT NULL,
  `chapter_three_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_three_interactions`
--

INSERT INTO `chapter_three_interactions` (`id`, `chapter_three_id`, `user_id`, `title`, `description`, `message`, `created_at`) VALUES
(1, 1, 76, 'asdfghjnkm,l.;\';lkjhgfdsadfghjkl;kjuyhtrfedsfhgjkljhgfdfghj', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', 'Sir Please I have Submitted Chapter Three', '2024-08-25 01:12:10'),
(2, 1, 9, 'Chapter Three  Review', 'Status: approved', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', '2024-08-25 01:12:49'),
(3, 2, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', 'Sir Please I have Submitted Chapter Three', '2024-09-07 13:27:32'),
(4, 2, 103, 'Chapter Three  Review', 'Status: revise', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', '2024-09-07 13:32:37'),
(5, 2, 103, 'Chapter Three  Review', 'Status: revise', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', '2024-09-07 13:36:19'),
(6, 2, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', 'Sir Please I have Submitted Chapter Three', '2024-09-07 13:38:12'),
(7, 2, 103, 'Chapter Three  Review', 'Status: approved', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', '2024-09-07 13:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `chapter_two`
--

CREATE TABLE `chapter_two` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `primary_supervisor_id` int(11) NOT NULL,
  `secondary_supervisor_id1` int(11) DEFAULT NULL,
  `secondary_supervisor_id2` int(11) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `comment` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','revise') DEFAULT 'pending',
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `lecturer_comment_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_two`
--

INSERT INTO `chapter_two` (`id`, `student_id`, `primary_supervisor_id`, `secondary_supervisor_id1`, `secondary_supervisor_id2`, `faculty_id`, `department_id`, `title`, `description`, `comment`, `file_path`, `status`, `submission_date`, `lecturer_comment_time`) VALUES
(1, 76, 9, 8, 33, 1, 1, 'The use of Smart shirt to improve upon the security of the visually impaired', 'ext ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop p', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', '../uploads/Chapter_Two/20784838_RITA_ALOMOTEY_EMEFA_chapter_two.pdf', 'approved', '2024-08-20 19:25:22', '2024-08-25 01:10:34'),
(2, 15, 103, 103, 103, 1, 8, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', '../uploads/Chapter_Two/204323484_KESSIE_KORANTENG_FIFI_chapter_two.pdf', 'approved', '2024-09-07 13:18:27', '2024-09-07 13:19:08');

-- --------------------------------------------------------

--
-- Table structure for table `chapter_two_interactions`
--

CREATE TABLE `chapter_two_interactions` (
  `id` int(11) NOT NULL,
  `chapter_two_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter_two_interactions`
--

INSERT INTO `chapter_two_interactions` (`id`, `chapter_two_id`, `user_id`, `title`, `description`, `message`, `created_at`) VALUES
(1, 1, 76, 'The use of Smart shirt to improve upon the security of the visually impaired', 'ext ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop p', 'Sir Please I have Submitted Chapter Two', '2024-08-20 19:25:22'),
(2, 1, 9, 'Chapter Two  Review', 'Status: approved', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, a', '2024-08-25 01:10:34'),
(3, 2, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', 'Sir Please I have Submitted Chapter Two', '2024-09-07 13:03:57'),
(4, 2, 103, 'Chapter Two  Review', 'Status: revise', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', '2024-09-07 13:16:12'),
(5, 2, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', 'Sir Please I have Submitted Chapter Two', '2024-09-07 13:18:27'),
(6, 2, 103, 'Chapter Two  Review', 'Status: approved', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus', '2024-09-07 13:19:08');

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
-- Table structure for table `compiled_thesis`
--

CREATE TABLE `compiled_thesis` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `primary_supervisor_id` int(11) NOT NULL,
  `secondary_supervisor_id1` int(11) DEFAULT NULL,
  `secondary_supervisor_id2` int(11) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Submitted','Approved','Rejected') NOT NULL DEFAULT 'Submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compiled_thesis`
--

INSERT INTO `compiled_thesis` (`id`, `student_id`, `primary_supervisor_id`, `secondary_supervisor_id1`, `secondary_supervisor_id2`, `file_path`, `faculty_id`, `department_id`, `submission_date`, `status`) VALUES
(1, 76, 9, 8, 33, '../uploads/Compiled_thesis/RITA_ALOMOTEY_EMEFA_20784838_20240825.pdf', 1, 1, '2024-08-25 16:48:56', 'Submitted'),
(2, 15, 103, 103, 103, '../uploads/Compiled_thesis/KESSIE_KORANTENG_FIFI_204323484_20240907.pdf', 1, 8, '2024-09-07 16:01:22', 'Submitted');

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
(19, 'Super Admin', '2024-08-30 12:23:02');

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
(8, 39, 9, 'Proposal Review', 'Status: approved', 'omes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32', '2024-08-17 17:51:41'),
(9, 44, 76, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks ', 'Proposal submitted', '2024-08-18 13:48:05'),
(10, 44, 9, 'Proposal Review', 'Status: rejected', 'professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum', '2024-08-18 14:04:01'),
(11, 39, 9, 'Proposal Review', 'Status: rejected', 'urvived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publ', '2024-08-18 19:05:17'),
(12, 44, 76, 'The use of Smart shirt to improve upon the security of the visually impaired', 'f type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishi', 'Sir Please I have Submitted the Thesis Proposal ', '2024-08-20 15:54:12'),
(13, 33, 9, 'Proposal Review', 'Status: rejected', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through t', '2024-08-20 16:05:44'),
(14, 44, 9, 'Proposal Review', 'Status: approved', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through t', '2024-08-20 18:32:00'),
(15, 46, 79, 'Uses of AI in Education', 'type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchang', 'Sir Please I have Submitted the Thesis Proposal ', '2024-08-26 10:26:42'),
(16, 46, 78, 'Proposal Review', 'Status: approved', 'type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchang', '2024-08-26 10:37:18'),
(17, 47, 90, 'qwertyuiop[]lkjhgfdfgjhkl;\'\';lkjhrdtfghjkl', 'awdsdfghjkl;kjgfdasfdghjkl;\'lkjhgfdsdfghjkl;kjhgfdsfgjhkl;kjhgfdsadfhgyjkul;jhgfdsfghjdxgfghjklkjhgfddasfghjkl;kjhgfdfghj', 'Sir Please I have Submitted the Thesis Proposal ', '2024-08-27 15:05:45'),
(18, 47, 16, 'Proposal Review', 'Status: rejected', 'ewrtyui;l\'\r\n;lkjhgfdsfghjkl;\';lkjhgfdsfghjkl', '2024-08-27 15:07:05'),
(19, 47, 90, '67890--098765432345678o9p0[poikuyjhtgrfddrtyjkhul;\'', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum', 'Sir Please I have Submitted the Thesis Proposal ', '2024-08-27 15:08:38'),
(20, 47, 16, 'Proposal Review', 'Status: approved', 'kudos!!!!!!', '2024-08-27 15:10:06'),
(21, 35, 9, 'Proposal Review', 'Status: approved', 'sdfghjkjhgfdsdfghjklkjhgf\r\ngfsjljldjjd\r\nsddsjljflsdlfjslfjl \r\ngdj klgjld jgld j gldjgd \r\ndjsljlgd', '2024-09-01 11:00:54'),
(22, 49, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset', 'Sir Please I have Submitted the Thesis Proposal ', '2024-09-06 18:28:18'),
(23, 49, 103, 'Proposal Review', 'Status: revise', 'of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem', '2024-09-06 19:35:22'),
(24, 49, 15, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 't is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'Sir Please I have Submitted the Thesis Proposal ', '2024-09-06 19:53:11'),
(25, 49, 103, 'Proposal Review', 'Status: approved', 'of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem', '2024-09-06 19:55:06');

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
  `status` enum('pending','approved','rejected','revise') DEFAULT 'pending',
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
(33, 54, 57, 9, 34, 'ghjkl;\'uioptrytyrutyi', 'wesrdfghjlk;\';lkjhgfghl', 'rejected', '2024-08-06 19:05:40', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through t', NULL, NULL, NULL, '2024-08-20 16:05:44'),
(34, 45, 57, 9, 34, 'God is Good', 'Aliquam luctus nunc id sagittis scelerisque. Suspendisse egestas eu tellus sit amet dapibus. Morbi lacinia erat et maximus dignissim. Nullam eu gravida purus. Aenean mollis non urna vitae consequat. Nulla interdum aliquet congue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit, nulla et accumsan vestibulum, eros libero interdum lacus, id congue ante leo et dolor. Morbi orci augue, sagittis at ultricies faucibus, faucibus eget est. Nullam viverra eu felis quis mattis. Fusce iaculis est sapien, quis tempus elit tempus non. Curabitur a urna non ante tempor viverra. Curabitur posuere arcu ac accumsan ornare. Nulla a egestas purus.', 'approved', '2024-08-08 01:08:23', 'I love this Proposal Topic', NULL, NULL, NULL, NULL),
(35, 32, 57, 33, 9, 'fygkghfgdfg', 'ertjyu6iotuuterywertyreyeryryryr', 'approved', '2024-08-07 18:01:49', 'sdfghjkjhgfdsdfghjklkjhgf\r\ngfsjljldjjd\r\nsddsjljflsdlfjslfjl \r\ngdj klgjld jgld j gldjgd \r\ndjsljlgd', NULL, NULL, NULL, '2024-09-01 11:00:54'),
(39, 75, 8, 9, 33, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 'omes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32', 'rejected', '2024-08-17 17:45:39', 'urvived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publ', 1, 1, '../uploads/proposals/984567748_CYNTHIA_NYOVI_MACHOKA_proposal.pdf', '2024-08-18 19:05:17'),
(44, 76, 9, 8, 33, 'The use of Smart shirt to improve upon the security of the visually impaired', 'f type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishi', 'approved', '2024-08-20 15:54:12', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through t', 1, 1, '../uploads/proposals/20784838_RITA_ALOMOTEY_EMEFA_proposal.pdf', '2024-08-20 18:32:00'),
(46, 79, 78, 78, 78, 'Uses of AI in Education', 'type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchang', 'approved', '2024-08-26 10:26:42', 'type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchang', 1, 2, '../uploads/proposals/8231570001_Prince_Essel_proposal.pdf', '2024-08-26 10:37:18'),
(47, 90, 16, 21, 49, '67890--098765432345678o9p0[poikuyjhtgrfddrtyjkhul;\'', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum', 'approved', '2024-08-27 15:08:38', 'kudos!!!!!!', 3, 3, '../uploads/proposals/2000774483_GODWIN_KOFI_AMENUVOR_proposal.pdf', '2024-08-27 15:10:06'),
(49, 15, 103, 103, 103, 'The Use of Artificial Intelligence to improve on the learning of Mathematics in Basic School Level in Ghana', 't is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'approved', '2024-09-06 19:53:11', 'of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem', 1, 8, '../uploads/proposals/204323484_KESSIE_KORANTENG_FIFI_proposal.pdf', '2024-09-06 19:55:06');

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
(15, '204323484', 'KESSIE KORANTENG FIFI', '$2y$10$NE9xiOtPf4vPqaKXVF7/7.o3Vnpta5dBW/nJrRWrOyql6tWlg81Bq', 'student', 8, '2024-07-11 16:52:54', '', 1),
(16, '202188774', 'AGYEMANAG REUBEN YORVIVOR', '$2y$10$r3LRt7GzDxcdabkOKR1GCOvQHAiHroUhnLqh1TezGQQ9gT42s5CD6', 'lecturer', 3, '2024-07-11 16:58:05', '', 3),
(19, '2067227485', 'SAVIOUR CYNTHIA MASSU', '$2y$10$wVmATDMO0AT.5.f/WnPLDOFRvcxm8mtVT.BWhz2uWhfcTpetvJNnW', 'student', 1, '2024-07-14 13:12:50', '', 1),
(21, '2042347543', 'TESY FORSON AKUA', '$2y$10$HQgEKwNcCB8dLSp6A/vgROiGKmvG6mJ9uqeyNcUcCA3tDFFIbWFd2', 'lecturer', 3, '2024-07-14 13:12:50', '', 3),
(26, '454354', 'GLORIA WORNYO DOAGBEDA', '$2y$10$OIzn1mTcSwAO5yjcpd16hulZ5G2ncrlTLLNByIca4zepA1PAMnwXu', 'lecturer', 5, '2024-07-14 13:42:13', '', 3),
(28, '23456', 'SELORM ENOVI KOFIAAAA', '$2y$10$viEHkT45COLY3ufny9Yfy.soD2yVcldA68nnZCoYcy2NrpKtbOyre', 'student', 3, '2024-07-14 13:46:15', '', 3),
(30, '97854655', 'ISAAC EDZORDZI FIAVOR', '$2y$10$/hPSmk7uNiGQuPcc/H6nC.jEMolU4tDCKH0fvGKRSW4VToP38Z4rG', 'hod', 7, '2024-07-14 15:26:31', '', 1),
(32, '234567', 'DEMO NAME FOR', '$2y$10$0SNDMxWZxtSVYC9D4TEwde6QagXzS.Pww6rOgOCmwzq8zUMNXcJzm', 'student', 1, '2024-07-16 18:21:07', '5th Years', 1),
(33, '590804EE', 'EKOW MANGO TOOFE', '$2y$10$qQ8MXL4d9X/tnX4deBb9Me2.hBmxiVUWiQWqpvHPO/tNwn.oRWsda', 'lecturer', 1, '2024-07-16 18:22:05', '', 1),
(34, '54687545', 'JOLIW KOFI MAMZ', '$2y$10$vo94E/s1KgQ82/v2MPcDA.5Jaj3e8ejcQpOlvvBXSnJxd6DqaIa.m', 'lecturer', 1, '0000-00-00 00:00:00', '', NULL),
(35, '545464', 'SAMUEL KOFI DORDOE', '$2y$10$NRp2Ib846Pz0i1yONKd1juYbgc8st.9vNwSd1COXKoHOIMMHNt73O', 'student', 6, '2024-07-17 16:39:27', '', NULL),
(36, 'L45435', 'LOVELACE AMA GHANA', '$2y$10$5trTrFZ.XXJWyCWAWBfDcuNh/JRm.MFVo6EESkEPwjoNxANR8T1BO', 'lecturer', 6, '2024-07-17 16:40:07', '', NULL),
(44, '20213377', 'DESMOND ATIASIA BREMPONG', '$2y$10$88xWmwjQ1UueIxX87hPjYemW.krmcxQ8fv3rVAylamtp85pHnv.j2', 'student', 1, '2024-07-19 13:21:33', '', NULL),
(45, '20219966', 'JERRY KING ETORNAM', '$2y$10$cKRnuX99eHKaMeIRoLZkBeIg6B2ef7thhrTgyLcWN5PazKSwhrm4G', 'student', 1, '2024-07-20 16:50:55', '5th Year', 1),
(47, '206799775', 'SAVIOUR AGLIGO SELORM', '$2y$10$BrGLOn7P5ueKzkpeuhminOPN8oXVAgzlhU3LmimYJDV7nv0KTjRF.', 'student', 1, '2024-07-27 16:54:19', '6th Years', NULL),
(48, '240208482', 'KENNETH GEORGE FIFI', '$2y$10$HmICnth0PJzPaE/nxYEhqO0AadUyVO603Uoa94onjnct/54zKlhBe', '', 2, '2024-07-27 16:54:19', '', NULL),
(49, '2040083543', 'TESY GORSON DAVI', '$2y$10$uAsuZJuECEdimam08ITXGO.NK5jyvEJKcWk8BXxFykw/BDiTisyLC', 'lecturer', 3, '2024-07-27 16:54:20', '', NULL),
(54, '202178843', 'EMILE JOHN DOE', '$2y$10$sh/bEWA7shNGm5LjFp8SnejulDnL8EgcJtrGoTdDiyDfJxf5FZKPO', 'student', 1, '2024-08-01 15:36:32', '5th Years', 1),
(56, '202133998', 'OKENNETH YOVI AMAQ', '$2y$10$FCinSX/Z.eYUuxk9kgV04OwHJxGHuIgEXWSySJRBrovi.eGYXCQBK', 'student', 1, '2024-08-06 12:26:08', '5th Years', NULL),
(57, '987776467', 'ISAAC EDZORDZI FIAVOR', '$2y$10$flLV/ZD7GeSOSsVBpLXrVOuTK0m9w59EBlIKL54jOWExyxp0eLwXS', 'lecturer', 1, '2024-08-06 18:20:03', NULL, 1),
(63, 'SupAdmin', 'ISAAC EDZORDZI FIAVOR', '$2y$10$YTgHH.CQ6343/QgTyM4HHug/OxznKkpE/ohFcN2r2WkWRnSYGFfY6', 'super_admin', 18, '2024-08-13 17:25:38', NULL, NULL),
(64, '202533454', 'DELADEM KOFI TETTEY', '$2y$10$XRHQIucy0O97GWV9pXwWS.QePKkyzM0g8Rf2hDUsCUeZNHDs0uda6', 'student', 1, '2024-08-14 16:45:18', '5th Years', 1),
(67, '1206790005', 'JANE AGLIGO ABASH', '$2y$10$CDbmC9NlPIhQeyrYpSu0m.xoeNvJaXmlqulZ3ybysY3u/UjpjfjhC', 'student', 2, '2024-08-14 19:52:20', '5th Year', 1),
(68, '1240778482', 'JAMES GEORGE FIFIAVOR', '$2y$10$U8ovwLBOXK.9kDDiVjBX.uM2MrqvjR.4DoRKj711hEckKRWmYI5Rm', 'student', 1, '2024-08-14 19:52:20', '4th Year', 1),
(69, '1204008333', 'TESYIVOR GODSWAY DAVIDSON', '$2y$10$mXRs14SDTAYMOi1xHQcA1edolM7hUVrojxpCjHYLbE9NQkddFjICu', 'student', 5, '2024-08-14 19:52:20', '6th Year', 3),
(70, 'FacultyAdmin', 'SAMUEL DORDOE KOFI', '$2y$10$9D.xYMDgl0O1JeJY7kl8P.H3Vp/9ipE69xiQYrUpTEo1LBqQZm0Di', 'faculty_admin', 1, '2024-08-15 21:11:42', NULL, 1),
(71, 'DepAdmin', 'SAMPSON JIDI AYONIA', '$2y$10$k6MloAcRUevyfpIUdpJgQ.t1Zef9MiAN/Sx0jBhKffyXaxSycNzgO', 'department_admin', 1, '2024-08-16 00:15:25', NULL, 1),
(72, '74555', 'OKAKAI ALFRED AMAQ', '$2y$10$WrkBg9hoEl1g/De1M0fUx.CmY.EC.gyd5Mv9QGz8Wpjv5bTMPcFFO', 'student', 8, '2024-08-16 10:42:48', '5th Years', 1),
(74, '2035767485', 'YADIA BAABA YAO', '$2y$10$OqBClnfVOBLN5RhjEyfLTul9AfpT6rQ6hLOSNIPjErJN7FG8lZDvi', 'student', 1, '2024-08-16 15:47:20', '5th Years', 1),
(75, '984567748', 'CYNTHIA NYOVI MACHOKA', '$2y$10$ASMQflDqU707AZFcXp9WWepE2ZG4SQ0a3lWHrJvBBQ8Wh.JtdkLhK', 'student', 1, '2024-08-16 19:11:35', '5th Year', 1),
(76, '20784838', 'RITA ALOMOTEY EMEFA', '$2y$10$sCHOMyfTw5DXiiamXZ9/bu.zlEd2jCP5EHVg0nn6MGZqvhtyvhw.C', 'student', 1, '2024-08-18 13:33:47', '5th Year', 1),
(77, '202188734', 'CAROLINE PAKADY AMU', '$2y$10$Ga.JMYeeDbn49Oh8GoNFtuQExv15Ab0ucMznjvY8eXN4/DgQYPWtm', 'student', 2, '2024-08-23 13:55:31', '5th Year', 1),
(78, 'YAAYAA', 'Yaa Mensah', '$2y$10$uuJ9WWXE8fyuVfBhE8MuOOHC.ue13HxjxBmtwdhf3J2BnUI6gZmDK', 'lecturer', 2, '2024-08-26 10:16:20', NULL, 1),
(79, '8231570001', 'Prince Essel', '$2y$10$gWc1BewEHV8m2on4x4U.puJ4OX.nqPSlxPDaWG/abR6Be7ZGcsgPi', 'student', 2, '2024-08-26 10:17:51', '1st Year', 1),
(80, 'Naana', 'Gloria Ama', '$2y$10$saX.0HSDzmb0.cCO/DsQm.z.XgXkSUCUIF76Ry67PbrGg6hgZKwP6', 'lecturer', 2, '2024-08-26 11:42:35', NULL, 1),
(83, 'Gaga', 'Gabor Portia Ama', '$2y$10$vu9dqTqUKjcM3ir2Jr13pOfLZzVpVDztbSycqFexMm9BC91L37M/a', 'lecturer', 2, '2024-08-26 11:45:25', NULL, 1),
(84, '2021244997', 'ATIVOR MOSES KOFI', '$2y$10$XHrXYzNgCl7Bgy.Vcf24suzJxkrBAkLYySQScu84saJ5k62uhsR1m', 'student', 2, '2024-08-26 11:47:16', '4th Year', 1),
(88, 'DepAdmin3', 'SULEMANA ADUL SALINA', '$2y$10$7CZXCsb4xid4dPzqoFFAdupn3smrPO/JBAYyRNDUCMCQBk80umgke', 'faculty_admin', 5, '2024-08-27 14:24:04', NULL, 3),
(89, 'DepAdmin30', 'RITA ALOMOTEY EMAFA', '$2y$10$V.8gZ5iaDlWx2beTjyWkJem27gY7Q7ORuwwq4o7I6s9WdHQwVsKVy', 'department_admin', 3, '2024-08-27 14:32:53', NULL, 3),
(90, '2000774483', 'GODWIN KOFI AMENUVOR', '$2y$10$CfASpfKMidsX89gyrlBOduACwWnYd9jmwH.HVprQDe/kcbQtAC1yK', 'student', 3, '2024-08-27 14:49:14', '5th Years', 3),
(91, 'GodWin', 'GODWIN KOFI ALORMENU', '$2y$10$doj0bqtrXVxqLSat3SiN.eD9nXpwvukIjAd8fylvScGuxlTPRyQ8e', 'faculty_admin', 1, '2024-08-30 11:47:32', NULL, 1),
(92, 'KRAKWESI', 'KORANTENG KWESI KESSIE', '$2y$10$4UBqBVYUNFa6smftsMljnutguGXNV6nKxIphpPWsHoGsSKj97vRLG', 'lecturer', 1, '2024-08-30 12:00:43', NULL, 1),
(94, 'come', 'Kwame shatat', '$2y$10$d7fHFxmzsc/AdNa9aqdosezqIiSTE1NElmuLHKmM40EGmGPDZydd.', 'student', 1, '2024-08-30 16:47:37', '', 1),
(95, 'tsw', 'AGOGO AMANI', '$2y$10$0dmx7u8.CwsYasbY90jNs.KfaNwuN65HHWmHzgFooe/7rDwitJDpO', 'department_admin', 1, '2024-08-30 16:49:51', NULL, 1),
(96, 'Dean', 'SELORM DZIKUNU KWAME', '$2y$10$wgeQ.pvd2JUxC6MZDy7tzezpqxGy/hNPgv1XQM688gY0xhKWxgOcK', 'dean', 1, '2024-09-01 08:33:21', NULL, 1),
(97, 'l2021', 'ENERST YAO TREKPA', '$2y$10$2B/KvvaQtEpX52XGGSmAuuOXkRHOqmb/fpxgxED8wJiVHH7E59R46', 'lecturer', 7, '2024-09-01 08:45:39', NULL, 1),
(98, '22222333', 'SULEMANA ADUL SALINA', '$2y$10$aYxMX7dQD4TunYQVWkka5uKfSTxLv.7sqPMx9Uw2iM4Ev5gWx8PJq', 'student', 6, '2024-09-01 09:52:20', '2nd Year', 1),
(99, 'Dean2', 'GLORIA WORNYO DOAGBEDA', '$2y$10$6i2bjnsShsq13sShhaAYgOb5lBB8xJN1hYyhG.CBoCnkEhaMPPrEe', 'dean', 3, '2024-09-01 12:58:23', NULL, 3),
(102, '498749274', 'DESOMOND', '$2y$10$zlGu9Pe6R79q6vUk9yFfiu87EbHnRA/h1gmGqocnKlawJTDmo3X0u', 'student', 1, '2024-09-05 13:08:49', '3rd Year', 1),
(103, 'L89765', 'SELORM ENOVI KOFIA', '$2y$10$tkBlNDNWxsvDJhjD60auZ.Ld8q33fdwpH0EeX1xYYpfZ0Pt0fuYDC', 'lecturer', 8, '2024-09-06 18:05:57', NULL, 1),
(104, 'l47087', 'SULEMANA ADUL SALINA', '$2y$10$LuYruR3tpFYZTPitNbf4NOJRltpQBZo5btcfES./pL6wl0dOb.czW', 'lecturer', 8, '2024-09-06 18:12:19', NULL, 1);

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
-- Indexes for table `chapter_five`
--
ALTER TABLE `chapter_five`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `primary_supervisor_id` (`primary_supervisor_id`),
  ADD KEY `secondary_supervisor_id1` (`secondary_supervisor_id1`),
  ADD KEY `secondary_supervisor_id2` (`secondary_supervisor_id2`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `chapter_five_interactions`
--
ALTER TABLE `chapter_five_interactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_five_id` (`chapter_five_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chapter_four`
--
ALTER TABLE `chapter_four`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `primary_supervisor_id` (`primary_supervisor_id`),
  ADD KEY `secondary_supervisor_id1` (`secondary_supervisor_id1`),
  ADD KEY `secondary_supervisor_id2` (`secondary_supervisor_id2`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `chapter_four_interactions`
--
ALTER TABLE `chapter_four_interactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_four_id` (`chapter_four_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chapter_one`
--
ALTER TABLE `chapter_one`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `primary_supervisor_id` (`primary_supervisor_id`),
  ADD KEY `secondary_supervisor_id1` (`secondary_supervisor_id1`),
  ADD KEY `secondary_supervisor_id2` (`secondary_supervisor_id2`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `chapter_one_interactions`
--
ALTER TABLE `chapter_one_interactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_one_id` (`chapter_one_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chapter_progress`
--
ALTER TABLE `chapter_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Indexes for table `chapter_three`
--
ALTER TABLE `chapter_three`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `student_id_2` (`student_id`),
  ADD KEY `primary_supervisor_id` (`primary_supervisor_id`),
  ADD KEY `secondary_supervisor_id1` (`secondary_supervisor_id1`),
  ADD KEY `secondary_supervisor_id2` (`secondary_supervisor_id2`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `chapter_three_interactions`
--
ALTER TABLE `chapter_three_interactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_three_id` (`chapter_three_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chapter_two`
--
ALTER TABLE `chapter_two`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `student_id_2` (`student_id`),
  ADD UNIQUE KEY `student_id_3` (`student_id`),
  ADD KEY `primary_supervisor_id` (`primary_supervisor_id`),
  ADD KEY `secondary_supervisor_id1` (`secondary_supervisor_id1`),
  ADD KEY `secondary_supervisor_id2` (`secondary_supervisor_id2`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `chapter_two_interactions`
--
ALTER TABLE `chapter_two_interactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_two_id` (`chapter_two_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chapter_type`
--
ALTER TABLE `chapter_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chapter_name` (`chapter_name`);

--
-- Indexes for table `compiled_thesis`
--
ALTER TABLE `compiled_thesis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student` (`student_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `primary_supervisor_id` (`primary_supervisor_id`),
  ADD KEY `secondary_supervisor_id1` (`secondary_supervisor_id1`),
  ADD KEY `secondary_supervisor_id2` (`secondary_supervisor_id2`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `department_id` (`department_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chapter_five`
--
ALTER TABLE `chapter_five`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chapter_five_interactions`
--
ALTER TABLE `chapter_five_interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `chapter_four`
--
ALTER TABLE `chapter_four`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chapter_four_interactions`
--
ALTER TABLE `chapter_four_interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `chapter_one`
--
ALTER TABLE `chapter_one`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `chapter_one_interactions`
--
ALTER TABLE `chapter_one_interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `chapter_progress`
--
ALTER TABLE `chapter_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chapter_three`
--
ALTER TABLE `chapter_three`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chapter_three_interactions`
--
ALTER TABLE `chapter_three_interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `chapter_two`
--
ALTER TABLE `chapter_two`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chapter_two_interactions`
--
ALTER TABLE `chapter_two_interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chapter_type`
--
ALTER TABLE `chapter_type`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `compiled_thesis`
--
ALTER TABLE `compiled_thesis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `thesis_proposals`
--
ALTER TABLE `thesis_proposals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

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
-- Constraints for table `chapter_five`
--
ALTER TABLE `chapter_five`
  ADD CONSTRAINT `chapter_five_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_five_ibfk_2` FOREIGN KEY (`primary_supervisor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_five_ibfk_3` FOREIGN KEY (`secondary_supervisor_id1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_five_ibfk_4` FOREIGN KEY (`secondary_supervisor_id2`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_five_ibfk_5` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `chapter_five_ibfk_6` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `chapter_five_interactions`
--
ALTER TABLE `chapter_five_interactions`
  ADD CONSTRAINT `chapter_five_interactions_ibfk_1` FOREIGN KEY (`chapter_five_id`) REFERENCES `chapter_five` (`id`),
  ADD CONSTRAINT `chapter_five_interactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chapter_four`
--
ALTER TABLE `chapter_four`
  ADD CONSTRAINT `chapter_four_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_four_ibfk_2` FOREIGN KEY (`primary_supervisor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_four_ibfk_3` FOREIGN KEY (`secondary_supervisor_id1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_four_ibfk_4` FOREIGN KEY (`secondary_supervisor_id2`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_four_ibfk_5` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `chapter_four_ibfk_6` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `chapter_four_interactions`
--
ALTER TABLE `chapter_four_interactions`
  ADD CONSTRAINT `chapter_four_interactions_ibfk_1` FOREIGN KEY (`chapter_four_id`) REFERENCES `chapter_four` (`id`),
  ADD CONSTRAINT `chapter_four_interactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chapter_one`
--
ALTER TABLE `chapter_one`
  ADD CONSTRAINT `chapter_one_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_one_ibfk_2` FOREIGN KEY (`primary_supervisor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_one_ibfk_3` FOREIGN KEY (`secondary_supervisor_id1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_one_ibfk_4` FOREIGN KEY (`secondary_supervisor_id2`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_one_ibfk_5` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `chapter_one_ibfk_6` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `chapter_one_interactions`
--
ALTER TABLE `chapter_one_interactions`
  ADD CONSTRAINT `chapter_one_interactions_ibfk_1` FOREIGN KEY (`chapter_one_id`) REFERENCES `chapter_one` (`id`),
  ADD CONSTRAINT `chapter_one_interactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chapter_progress`
--
ALTER TABLE `chapter_progress`
  ADD CONSTRAINT `chapter_progress_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_progress_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chapter_three`
--
ALTER TABLE `chapter_three`
  ADD CONSTRAINT `chapter_three_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_three_ibfk_2` FOREIGN KEY (`primary_supervisor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_three_ibfk_3` FOREIGN KEY (`secondary_supervisor_id1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_three_ibfk_4` FOREIGN KEY (`secondary_supervisor_id2`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_three_ibfk_5` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `chapter_three_ibfk_6` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `chapter_three_interactions`
--
ALTER TABLE `chapter_three_interactions`
  ADD CONSTRAINT `chapter_three_interactions_ibfk_1` FOREIGN KEY (`chapter_three_id`) REFERENCES `chapter_three` (`id`),
  ADD CONSTRAINT `chapter_three_interactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chapter_two`
--
ALTER TABLE `chapter_two`
  ADD CONSTRAINT `chapter_two_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_two_ibfk_2` FOREIGN KEY (`primary_supervisor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_two_ibfk_3` FOREIGN KEY (`secondary_supervisor_id1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_two_ibfk_4` FOREIGN KEY (`secondary_supervisor_id2`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapter_two_ibfk_5` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `chapter_two_ibfk_6` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `chapter_two_interactions`
--
ALTER TABLE `chapter_two_interactions`
  ADD CONSTRAINT `chapter_two_interactions_ibfk_1` FOREIGN KEY (`chapter_two_id`) REFERENCES `chapter_two` (`id`),
  ADD CONSTRAINT `chapter_two_interactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `compiled_thesis`
--
ALTER TABLE `compiled_thesis`
  ADD CONSTRAINT `compiled_thesis_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `compiled_thesis_ibfk_2` FOREIGN KEY (`primary_supervisor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `compiled_thesis_ibfk_3` FOREIGN KEY (`secondary_supervisor_id1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `compiled_thesis_ibfk_4` FOREIGN KEY (`secondary_supervisor_id2`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `compiled_thesis_ibfk_5` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  ADD CONSTRAINT `compiled_thesis_ibfk_6` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

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
