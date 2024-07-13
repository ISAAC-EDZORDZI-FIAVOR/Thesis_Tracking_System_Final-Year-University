-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2024 at 12:15 PM
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
-- Database: `thesistrackingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `lecturer_id` int(11) DEFAULT NULL
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
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(6, 'Biotechnology'),
(5, 'Chemical Engineering'),
(9, 'Chemistry'),
(4, 'Civil Engineering'),
(1, 'Computer Science'),
(3, 'Electrical Engineering'),
(10, 'Environmental Science'),
(7, 'Mathematics'),
(2, 'Mechanical Engineering'),
(8, 'Physics');

-- --------------------------------------------------------

--
-- Table structure for table `progresstracking`
--

CREATE TABLE `progresstracking` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `submission_id` int(11) DEFAULT NULL,
  `submission_type` enum('proposal','chapter') NOT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment` text DEFAULT NULL,
  `status` enum('submitted','approved','rejected') DEFAULT 'submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thesisproposals`
--

CREATE TABLE `thesisproposals` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `proposal_text` text NOT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('submitted','approved','rejected') DEFAULT 'submitted',
  `comment` text DEFAULT NULL
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
  `department_id` int(11) DEFAULT NULL,
  `dateRegistered` timestamp(2) NOT NULL DEFAULT current_timestamp(2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `role`, `department_id`, `dateRegistered`) VALUES
(64, 'L2248', 'ISAAC EDZORDZI FIAVOR', '$2y$10$FKQdWYZuKRpVBL88DobY4.Fge89ntFSpGnXwLiBg9YpldSyrW3qg.', 'admin', 1, '2024-06-20 19:54:03.42'),
(67, 'L44434', 'DANIEL DANSO ESSEL', '$2y$10$Or71NbAx7108tDZ/FrN/KugviwPg47DOPnwQwTF6SKkBj8x0L6Q0.', 'admin', 1, '2024-06-20 19:54:03.42'),
(69, 'L3333', 'SAMUEL DORDOE KOFI', '$2y$10$JVI5HHj5cA9LqAaKyxi1H.V1yFwP2MfbxtZ.ZFYcM5EEMoQlPbIgm', 'admin', 7, '2024-06-20 19:54:03.42'),
(70, 'L444', 'DELA STEPHEN DUMEVOR', '$2y$10$dwt1wBxU4cf1AkjfNYWwauYpnqT2frzU/WPe/HFbi4s9L5u4woIPO', 'student', 1, '2024-06-20 19:55:56.99'),
(71, '50224577', 'CYNTHIA ESI BADU', '$2y$10$MnNAxbnL5nVw50B5SZstd.CW7cS8v1KNMuZZmK5tk9iX4C.u6SFvO', 'student', 9, '2024-06-20 19:59:36.91'),
(72, '50224578', 'SEDEM PROSPER OCLOO', '$2y$10$h.7sSUu0fS/0TsI02eS9HOhgBDbwVoqQeL1oSetpyKAD2Q2yFULSC', 'student', 1, '2024-06-20 20:00:39.79'),
(73, 'AD0001', 'EKOW PAUL AGYEMANG', '$2y$10$A5cNuHmtSulR9gitxivya.cIJl16a.Bh28/igkoF3XBuvbzlnuB0q', 'admin', 9, '2024-06-20 20:02:15.45'),
(74, 'DE001', 'LUCKY WODOTO JERRY', '$2y$10$WmKm0QGtjgdMNYVT1OK7OOA3HvX1WryIneLatX2j0xpz0COkV2vCS', 'dean', 1, '2024-06-20 20:03:52.97'),
(75, 'HO001', 'GHANSAH SAVIOUR TETTEY', '$2y$10$M6J9tNRETl6NXz3/LIOU7O4J9C3VW7ngQdiG7lvOQRPbNkXOfQGue', 'hod', 1, '2024-06-20 20:05:17.15'),
(76, 'L001', 'MARY MENSAH ADJOA', '$2y$10$s2zISfJqkDbBQz.i6Jsf2OMXYCm5lv7CoD1IIFrqJ8dSqn27b4VSa', 'lecturer', 1, '2024-06-20 20:07:30.03'),
(86, 'S777', 'MARY MENSAH ADJOAafsfs', '$2y$10$W2oSk/izHwHkVDJXetoUxO5wX3XRGDIR5c1wbMauREabxmyorhmYa', 'student', 3, '2024-06-20 22:04:54.61'),
(88, 'L666', 'bbdsasf', '$2y$10$WAgPnhPAh4qzPdKyX4ha3eBO/sKs52D32Bpbskbgs1NDagRForhD2', 'lecturer', 8, '2024-06-20 22:58:19.54'),
(91, 'y666', 'afafdsaf', '$2y$10$8Dt8rxmXqfbW.cxav4xgw.FB98GH2t8rZF5hxdd7ER/BOD.sjFTN.', 'lecturer', 6, '2024-06-20 23:08:14.40'),
(93, '75345464', 'ISAAC EDZORDZI FIAVOR', '$2y$10$mZmoaappd40VurLwfJzeNO4kdrKemH02cHBKRHDhoV3J3o2R52ngi', 'lecturer', 2, '2024-06-20 23:17:24.45'),
(96, '533', 'SAMUEL DORDOE KOFI', '$2y$10$BL2UygQzx0E/1.yNDwu4Mer2aI4RmqOUsl0gdKX2z5tgUb1gMA9/u', 'lecturer', 2, '2024-06-20 23:19:09.97'),
(99, 'L224877', 'fafsaf', '$2y$10$rTF9hJwtQiuH8QcI09loUe2cxG.VPAi/DzmSfzXqgOtxzM/OhusrW', 'dean', 2, '2024-06-20 23:25:23.32'),
(102, '7897777', 'DELA STEPHEN DUMEVOR', '$2y$10$b/nOJfLMnbfhIrcKavuTlOFWnIdpsd4gGaQzVIOLGfqaOgb9kJvCm', 'dean', 10, '2024-06-20 23:38:27.48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chapters_student_id` (`student_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `progresstracking`
--
ALTER TABLE `progresstracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_progress_tracking_student_id` (`student_id`);

--
-- Indexes for table `thesisproposals`
--
ALTER TABLE `thesisproposals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_thesis_proposals_student_id` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `idx_users_role` (`role`);

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
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `progresstracking`
--
ALTER TABLE `progresstracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thesisproposals`
--
ALTER TABLE `thesisproposals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `progresstracking`
--
ALTER TABLE `progresstracking`
  ADD CONSTRAINT `progresstracking_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `thesisproposals`
--
ALTER TABLE `thesisproposals`
  ADD CONSTRAINT `thesisproposals_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
