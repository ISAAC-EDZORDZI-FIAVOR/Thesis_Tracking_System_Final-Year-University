-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2024 at 03:37 AM
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
  `assigned_at` timestamp(2) NOT NULL DEFAULT current_timestamp(2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `student_id`, `primary_supervisor_id`, `secondary_supervisor_id1`, `secondary_supervisor_id2`, `department_id`, `assigned_at`) VALUES
(33, 7, 8, 9, 34, 1, '2024-08-01 14:48:35.60'),
(34, 26, 8, 9, 34, 1, '2024-08-01 14:48:35.61'),
(35, 44, 8, 9, 34, 1, '2024-08-01 14:48:35.62'),
(38, 4, 34, 34, 34, 1, '2024-08-01 20:12:35.47'),
(42, 2, 8, 9, 34, 1, '2024-08-06 12:21:40.21'),
(43, 56, 34, 33, 9, 1, '2024-08-06 12:28:13.24'),
(44, 17, 57, 8, 33, 1, '2024-08-06 18:20:57.37'),
(45, 54, 57, 9, 34, 1, '2024-08-06 18:35:29.37'),
(46, 45, 57, 9, 34, 1, '2024-08-07 10:52:44.06'),
(47, 32, 57, 33, 9, 1, '2024-08-07 18:00:22.01');

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
  `dateRegistered` timestamp(2) NOT NULL DEFAULT current_timestamp(2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `dateRegistered`) VALUES
(1, 'Computer Science', '2024-07-03 18:02:23.14'),
(2, 'Information Technology', '2024-07-03 18:02:23.14'),
(3, 'Electrical Engineering', '2024-07-03 18:02:23.14'),
(4, 'Mechanical Engineering', '2024-07-03 18:02:23.14'),
(5, 'Civil Engineering', '2024-07-03 18:02:23.14'),
(6, 'Mathematics', '2024-07-03 18:02:23.14'),
(7, 'Physics', '2024-07-03 18:02:23.14'),
(8, 'Chemistry', '2024-07-03 18:02:23.14'),
(9, 'Biology', '2024-07-03 18:02:23.14'),
(11, 'Political Science', '2024-07-03 18:42:03.06');

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
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thesis_proposals`
--

INSERT INTO `thesis_proposals` (`id`, `student_id`, `primary_supervisor_id`, `secondary_supervisor_id1`, `secondary_supervisor_id2`, `title`, `description`, `status`, `submission_date`, `comment`) VALUES
(31, 56, 34, 33, 9, 'sdfghjkl;\';lkjhgfdsdfghjkl;;lkjhgfdfghjk', 'dfghjkl;\';lkjhgfdsdfghjkl;\'lk', 'pending', '2024-08-06 16:14:04', NULL),
(33, 54, 57, 9, 34, 'ghjkl;\'uioptrytyrutyi', 'wesrdfghjlk;\';lkjhgfghl', 'pending', '2024-08-06 19:05:40', NULL),
(34, 45, 57, 9, 34, 'God is Good', 'Aliquam luctus nunc id sagittis scelerisque. Suspendisse egestas eu tellus sit amet dapibus. Morbi lacinia erat et maximus dignissim. Nullam eu gravida purus. Aenean mollis non urna vitae consequat. Nulla interdum aliquet congue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit, nulla et accumsan vestibulum, eros libero interdum lacus, id congue ante leo et dolor. Morbi orci augue, sagittis at ultricies faucibus, faucibus eget est. Nullam viverra eu felis quis mattis. Fusce iaculis est sapien, quis tempus elit tempus non. Curabitur a urna non ante tempor viverra. Curabitur posuere arcu ac accumsan ornare. Nulla a egestas purus.', 'approved', '2024-08-08 01:08:23', 'great '),
(35, 32, 57, 33, 9, 'fygkghfgdfg', 'ertjyu6iotuuterywertyreyeryryryr', 'rejected', '2024-08-07 18:01:49', 'Your Proposal is not good');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','lecturer','hod','dean','admin') NOT NULL,
  `department_id` int(11) NOT NULL,
  `email` varchar(100) GENERATED ALWAYS AS (concat(`username`,substr(`role`,1,2),'@uew.edu.gh')) VIRTUAL,
  `dateRegistered` timestamp NOT NULL DEFAULT current_timestamp(),
  `student_level` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `role`, `department_id`, `dateRegistered`, `student_level`) VALUES
(2, '202124977', 'ISAAC EDZORDZI FIAVOR', '$2y$10$xeF.UQEKDmRDEgk6SgzJseBzH1lN8Bkiyfy4b6qYv1Tr42.hRpfLa', 'student', 1, '2024-07-03 18:04:23', ''),
(4, '202125988', 'SULEMANA ADUL SALINA', '$2y$10$q0I/XFwH/OWxaeF/S8oew.7I2E/.mHCDdfz.RJzqHujkybcuYUCnC', 'student', 1, '2024-07-03 18:06:17', ''),
(6, 'Admin1', 'DANIEL DANSO ESSEL', '$2y$10$2Hqi4UfThs5r9JmvXfNW8uHrQIB4lJHJRrB3fssoAEyV0adfoSp7.', 'admin', 1, '2024-07-03 18:13:40', ''),
(7, 'L500', 'ENERST YAO TREKPA', '$2y$10$WO2vZAgESPN5SmjicUOtxuV4wLX/XdCd0Bpmnjsi3A6oJ0oIr/4.u', 'student', 1, '2024-07-03 18:36:32', ''),
(8, 'L5001', 'KOFI AMA FRIMPONG', '$2y$10$uG2lmcSDB0JJ2eptKp5tkeK9qQJLsBziYCxI/mt4cOoe5.Xks14xi', 'lecturer', 1, '2024-07-04 01:17:11', ''),
(9, 'L5002', 'DELA SOWA DRAVI', '$2y$10$oTUdNVA3HbMzjWHYSa/crOSR.bPMIuA7.mIzY.ziFU59hyD4zmA12', 'lecturer', 1, '2024-07-04 01:17:57', ''),
(15, '204323484', 'KESSIE KORANTENG FIFI', '$2y$10$h8WS7Yczg4Et64kPROGSwO5BUBzS9J3.KHmcnt3rwGC9Bv76gkx.S', 'student', 8, '2024-07-11 16:52:54', ''),
(16, '202188774', 'AGYEMANAG REUBEN YORVI', '$2y$10$QOkRWOx9lu4sW0jY14VpK.kyT45cKoJH8U2QX3jMbvoKOJI79q5.W', 'student', 8, '2024-07-11 16:58:05', ''),
(17, '202222122', 'SELORM JUNIOR DZIKUNU', '$2y$10$hd8NQCumXjinlVgb6HkQOuLkEO/7D9uFiHwGe2sj/8oMWx9iDLyim', 'student', 1, '2024-07-11 20:35:16', ''),
(19, '2067227485', 'SAVIOUR CYNTHIA MASSU', '$2y$10$wVmATDMO0AT.5.f/WnPLDOFRvcxm8mtVT.BWhz2uWhfcTpetvJNnW', 'student', 1, '2024-07-14 13:12:50', ''),
(21, '2042347543', 'TESY FORSON AKUA', '$2y$10$HQgEKwNcCB8dLSp6A/vgROiGKmvG6mJ9uqeyNcUcCA3tDFFIbWFd2', 'lecturer', 3, '2024-07-14 13:12:50', ''),
(26, '454354', 'GLORIA WORNYO DOAGBEDA', '$2y$10$osjMqTbP5hkvwIALyutsHOuVpeSnDysWCnTIV1pI8Dy//lh.rdcHO', 'student', 1, '2024-07-14 13:42:13', ''),
(28, '23456', 'SELORM ENOVI KOFIAAAA', '$2y$10$viEHkT45COLY3ufny9Yfy.soD2yVcldA68nnZCoYcy2NrpKtbOyre', 'student', 3, '2024-07-14 13:46:15', ''),
(30, '97854655', 'ISAAC EDZORDZI FIAVOR', '$2y$10$/hPSmk7uNiGQuPcc/H6nC.jEMolU4tDCKH0fvGKRSW4VToP38Z4rG', 'hod', 7, '2024-07-14 15:26:31', ''),
(31, '687463', 'KOFI DADY SEYRAM', '$2y$10$L8MxkF9LZ7BzAEJx6.g7UOtDZjkfoyYnpNO4W18MXkstMbmqmQ4Sy', 'lecturer', 2, '2024-07-15 15:42:01', ''),
(32, '234567', 'DEMO NAME FOR', '$2y$10$/qj6Rp5g9cKkz6UNXZuah.AORu/Z8sTpCqPmVqJhVU8FmnBUOvf3K', 'student', 1, '2024-07-16 18:21:07', ''),
(33, '590804EE', 'EKOW MANGO TOOFE', '$2y$10$qQ8MXL4d9X/tnX4deBb9Me2.hBmxiVUWiQWqpvHPO/tNwn.oRWsda', 'lecturer', 1, '2024-07-16 18:22:05', ''),
(34, '54687545', 'JOLIW KOFI MAMZ', '$2y$10$vo94E/s1KgQ82/v2MPcDA.5Jaj3e8ejcQpOlvvBXSnJxd6DqaIa.m', 'lecturer', 1, '2024-07-17 12:28:48', ''),
(35, '545464', 'SAMUEL KOFI DORDOE', '$2y$10$NRp2Ib846Pz0i1yONKd1juYbgc8st.9vNwSd1COXKoHOIMMHNt73O', 'student', 6, '2024-07-17 16:39:27', ''),
(36, 'L45435', 'LOVELACE AMA GHANA', '$2y$10$5trTrFZ.XXJWyCWAWBfDcuNh/JRm.MFVo6EESkEPwjoNxANR8T1BO', 'lecturer', 6, '2024-07-17 16:40:07', ''),
(37, 'Admin2', 'EKOW NANIA KOJO', '$2y$10$KkGq48LSoymGfOP5jj.CVuvA/e65GqBZ724Ox2hDERDbw5om13u3i', 'admin', 1, '2024-07-18 01:53:45', ''),
(39, '2021788384', 'KENNEDY YAO TETTEY', '$2y$10$GjoJ14sSK1N6DGVQXEg2ZesujzPqoTLheg5ugd77FUGhKbD/QO/1i', 'admin', 2, '2024-07-18 11:56:15', ''),
(44, '20213377', 'DESMOND ATIASIA BREMPONG', '$2y$10$88xWmwjQ1UueIxX87hPjYemW.krmcxQ8fv3rVAylamtp85pHnv.j2', 'student', 1, '2024-07-19 13:21:33', ''),
(45, '20219966', 'JERRY KING ETORNAM', '$2y$10$ZFODZAGUXiNTJ8Z/Nldbiu98OGJMiw89jk7xSlsm2BkpkwPJH7gRi', 'student', 1, '2024-07-20 16:50:55', ''),
(46, 'Admin3', 'JOHN KUMA AGYEMANG', '$2y$10$lZf4Bb9TQEB8VTHMSTc55eTFPm3U7Vb52rBgVxlxO678LT7VW2Xb.', 'admin', 1, '2024-07-27 16:51:09', ''),
(47, '206799775', 'SAVIOUR AGLIGO SELORM', '$2y$10$oiNpbx9/XvIocK6HENLNQeTp5PkvHEm0tP17qbP2hyQ/2ZU.98erK', 'student', 1, '2024-07-27 16:54:19', ''),
(48, '240208482', 'KENNETH GEORGE FIFI', '$2y$10$HmICnth0PJzPaE/nxYEhqO0AadUyVO603Uoa94onjnct/54zKlhBe', 'admin', 2, '2024-07-27 16:54:19', ''),
(49, '2040083543', 'TESY GORSON DAVI', '$2y$10$uAsuZJuECEdimam08ITXGO.NK5jyvEJKcWk8BXxFykw/BDiTisyLC', 'lecturer', 3, '2024-07-27 16:54:20', ''),
(54, '202178843', 'EMILE JOHN DOE', '$2y$10$UZPwLsemdQOHwgSfpN4fQOpbRq0P2bVv7THKofnkR6Xz0zRf4sm2m', 'student', 1, '2024-08-01 15:36:32', '5th Years'),
(55, '2021235', 'LOFI AMA AAAA', '$2y$10$g2OSwpAI0jDdlT56sYrNheMhs345lNHZ7Yr6kZMEsUg3RF8krA2Hy', 'student', 1, '2024-08-02 12:12:26', '5th Years'),
(56, '202133998', 'OKENNETH YOVI AMA', '$2y$10$xOW2zKYv.eVysS3kBJPz.eNLqT0hUbVFEjr6ESnTZPvnfH97HlkoO', 'student', 1, '2024-08-06 12:26:08', '5th Years'),
(57, '987776467', 'ISAAC EDZORDZI FIAVOR1', '$2y$10$zGDZWtrVAUPSN7a7koHqOuw8xPNhFygK8GA3lUc3uMpa2PjxBeKmO', 'lecturer', 1, '2024-08-06 18:20:03', NULL);

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
  ADD KEY `fk_secondary_supervisor2` (`secondary_supervisor_id2`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chapters_student_id` (`student_id`),
  ADD KEY `idx_chapters_chapter_name` (`chapter_name`);

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
  ADD UNIQUE KEY `name` (`name`);

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
-- Indexes for table `thesis_proposals`
--
ALTER TABLE `thesis_proposals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `fk_primary_supervisor_id` (`primary_supervisor_id`),
  ADD KEY `fk_secondary_supervisor_id1` (`secondary_supervisor_id1`),
  ADD KEY `fk_secondary_supervisor_id2` (`secondary_supervisor_id2`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `department_id` (`department_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chapter_type`
--
ALTER TABLE `chapter_type`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- AUTO_INCREMENT for table `thesis_proposals`
--
ALTER TABLE `thesis_proposals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

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
-- Constraints for table `thesis_proposals`
--
ALTER TABLE `thesis_proposals`
  ADD CONSTRAINT `fk_primary_supervisor_id` FOREIGN KEY (`primary_supervisor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_secondary_supervisor_id1` FOREIGN KEY (`secondary_supervisor_id1`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_secondary_supervisor_id2` FOREIGN KEY (`secondary_supervisor_id2`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `thesis_proposals_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
