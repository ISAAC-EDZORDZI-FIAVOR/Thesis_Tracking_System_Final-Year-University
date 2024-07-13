-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2024 at 06:50 PM
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
-- Database: `university`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `email` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `specialization` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `reviewer_email` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `review_timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sac`
--

CREATE TABLE `sac` (
  `sac_id` int(11) NOT NULL,
  `student_email` varchar(255) NOT NULL,
  `advisor_email` varchar(255) NOT NULL,
  `co_advisor_email` varchar(255) NOT NULL,
  `chairperson_email` varchar(255) NOT NULL,
  `member1_email` varchar(255) NOT NULL,
  `member2_email` varchar(255) NOT NULL,
  `requested_timestamp` datetime NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `email` varchar(255) NOT NULL,
  `pid` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `dept_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `file_id` int(11) NOT NULL,
  `student_email` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','faculty','deanpg') NOT NULL,
  `signup_timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `signup_timestamp`) VALUES
(2, 'furybimyse@mailinator.com', '$2y$10$FiroyzFLLpmVNsfMhU5Lvux8lLJpP2Xk4Q4o.1BdX8lHW6uK5Hn1S', 'faculty', '2024-06-08 18:16:44'),
(1, 'isaacfiavor0611@gmail.com', '$2y$10$wR0UW7PzD15Y/DsibRrKR.s8ME/FjPL07YSm6lTzWCMm4NRDMNPL.', 'student', '2024-06-08 18:15:05'),
(3, 'synys@mailinator.com', '$2y$10$9C3/fs72raFDh3f5Pd410unSU2rsvxDLZcBvyn4XPtQdY7AGan/BK', 'student', '2024-06-08 18:34:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `reviewer_email` (`reviewer_email`);

--
-- Indexes for table `sac`
--
ALTER TABLE `sac`
  ADD PRIMARY KEY (`sac_id`),
  ADD KEY `student_email` (`student_email`),
  ADD KEY `advisor_email` (`advisor_email`),
  ADD KEY `co_advisor_email` (`co_advisor_email`),
  ADD KEY `chairperson_email` (`chairperson_email`),
  ADD KEY `member1_email` (`member1_email`),
  ADD KEY `member2_email` (`member2_email`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `pid` (`pid`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `student_email` (`student_email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sac`
--
ALTER TABLE `sac`
  MODIFY `sac_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `uploads` (`file_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`reviewer_email`) REFERENCES `faculty` (`email`);

--
-- Constraints for table `sac`
--
ALTER TABLE `sac`
  ADD CONSTRAINT `sac_ibfk_1` FOREIGN KEY (`student_email`) REFERENCES `students` (`email`),
  ADD CONSTRAINT `sac_ibfk_2` FOREIGN KEY (`advisor_email`) REFERENCES `faculty` (`email`),
  ADD CONSTRAINT `sac_ibfk_3` FOREIGN KEY (`co_advisor_email`) REFERENCES `faculty` (`email`),
  ADD CONSTRAINT `sac_ibfk_4` FOREIGN KEY (`chairperson_email`) REFERENCES `faculty` (`email`),
  ADD CONSTRAINT `sac_ibfk_5` FOREIGN KEY (`member1_email`) REFERENCES `faculty` (`email`),
  ADD CONSTRAINT `sac_ibfk_6` FOREIGN KEY (`member2_email`) REFERENCES `faculty` (`email`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`);

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`student_email`) REFERENCES `students` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
