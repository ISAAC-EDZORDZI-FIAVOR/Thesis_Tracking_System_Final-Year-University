-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2024 at 03:35 PM
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
  `lecturer_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `assigned_at` timestamp(2) NOT NULL DEFAULT current_timestamp(2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(8, 'Appendices', '2024-07-03 22:48:02'),
(17, 'fjfjfhfjgfjgggj', '2024-07-03 23:10:35');

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
(11, 'Political Science11', '2024-07-03 18:42:03.06');

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
  `dateRegistered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `role`, `department_id`, `dateRegistered`) VALUES
(2, '202124977', 'ISAAC EDZORDZI FIAVOR', '$2y$10$xeF.UQEKDmRDEgk6SgzJseBzH1lN8Bkiyfy4b6qYv1Tr42.hRpfLa', 'student', 1, '2024-07-03 18:04:23'),
(4, '202125988', 'SULEMANA ADUL SALINA', '$2y$10$q0I/XFwH/OWxaeF/S8oew.7I2E/.mHCDdfz.RJzqHujkybcuYUCnC', 'student', 1, '2024-07-03 18:06:17'),
(6, 'Admin1', 'DANIEL DANSO ESSEL', '$2y$10$2Hqi4UfThs5r9JmvXfNW8uHrQIB4lJHJRrB3fssoAEyV0adfoSp7.', 'admin', 1, '2024-07-03 18:13:40'),
(7, 'L500', 'ENERST YAO TREKPA', '$2y$10$WO2vZAgESPN5SmjicUOtxuV4wLX/XdCd0Bpmnjsi3A6oJ0oIr/4.u', 'student', 1, '2024-07-03 18:36:32'),
(8, 'L5001', 'KOFI AMA FRIMPONG', '$2y$10$uG2lmcSDB0JJ2eptKp5tkeK9qQJLsBziYCxI/mt4cOoe5.Xks14xi', 'lecturer', 1, '2024-07-04 01:17:11'),
(9, 'L5002', 'DELA SOWA DRAVI', '$2y$10$oTUdNVA3HbMzjWHYSa/crOSR.bPMIuA7.mIzY.ziFU59hyD4zmA12', 'lecturer', 1, '2024-07-04 01:17:57'),
(12, '202124886', 'SELORM ENOVI KOFI', '$2y$10$tpEv/EzbngTr1aDEe0l3AuiFu7V0fHPP0HfBCpb6NvsC3noKXSARe', 'student', 3, '2024-07-09 17:05:47'),
(13, '202137744', 'MAMA KOFI DELAOR', '$2y$10$KwelSXVJZdobLTq6IivxM.oIIdOMNV9/Oq8oB3PTkLVkNUtYtVOVa', 'student', 5, '2024-07-11 16:21:21'),
(15, '204323484', 'KESSIE KORANTENG FIFI', '$2y$10$h8WS7Yczg4Et64kPROGSwO5BUBzS9J3.KHmcnt3rwGC9Bv76gkx.S', 'student', 8, '2024-07-11 16:52:54'),
(16, '202188774', 'AGYEMANAG REUBEN YORVI', '$2y$10$QOkRWOx9lu4sW0jY14VpK.kyT45cKoJH8U2QX3jMbvoKOJI79q5.W', 'student', 8, '2024-07-11 16:58:05'),
(17, '202222122', 'SELORM JUNIOR DZIKUNU', '$2y$10$hd8NQCumXjinlVgb6HkQOuLkEO/7D9uFiHwGe2sj/8oMWx9iDLyim', 'student', 1, '2024-07-11 20:35:16');

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `lecturer_id` (`lecturer_id`),
  ADD KEY `fk_department_id` (`department_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chapter_type`
--
ALTER TABLE `chapter_type`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_department_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

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
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
