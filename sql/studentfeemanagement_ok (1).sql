-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 29, 2024 at 07:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentfeemanagement_ok`
--

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `month` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `student_id`, `amount`, `month`, `status`, `created_on`) VALUES
(40, 21, 1250.00, '2024-06', 'Unpaid', '2024-06-27 03:57:00'),

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `class` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `father_name` varchar(255) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `cnic` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `phone`, `address`, `class`, `section`, `created_on`, `father_name`, `contact`, `cnic`, `dob`, `gender`) VALUES
(20, 'Zain Malik', 'zain.malik@gmail.com', '03055678901', 'Pakistan', '6th', 'G', '2024-06-27 03:16:00', NULL, NULL, NULL, NULL, NULL),

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `subject_taught` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `teacher_name`, `subject_taught`, `date_of_birth`, `gender`, `address`, `phone`, `created_on`) VALUES
(1, 'Muhammad Ali', 'Mathematics', '1980-05-15', 'Male', 'House 123, Street ABC, Lahore', '+92 300 1234567', '2024-06-28 02:33:37'),
(2, 'Sara Khan', 'English Literature', '1985-09-20', 'Female', 'Apartment 456, Road XYZ, Karachi', '+92 321 9876543', '2024-06-28 02:33:37'),
(3, 'Ahmed Shah', 'Physics', '1982-03-10', 'Male', 'Village PQR, Islamabad', '+92 333 5556667', '2024-06-28 02:33:37'),
(4, 'Fatima Aslam', 'Chemistry', '1984-07-25', 'Female', 'Flat 789, Avenue DEF, Lahore', '+92 345 2223344', '2024-06-28 02:33:37'),
(5, 'Kamran Malik', 'Computer Science', '1981-01-08', 'Male', 'House 567, Block GHI, Karachi', '+92 311 7778899', '2024-06-28 02:33:37'),
(6, 'Ayesha Ahmed', 'Biology', '1983-11-12', 'Female', 'Street JKL, Rawalpindi', '+92 333 1234567', '2024-06-28 02:33:37'),
(7, 'Bilal Khan', 'History', '1980-06-30', 'Male', 'Apartment 789, Sector MNO, Lahore', '+92 322 4445566', '2024-06-28 02:33:37'),
(8, 'Zoya Malik', 'Urdu Literature', '1986-02-17', 'Female', 'House 234, Lane PQR, Karachi', '+92 333 8889990', '2024-06-28 02:33:37'),
(9, 'Usman Ali', 'Economics', '1978-09-05', 'Male', 'Flat 901, Crescent UVW, Islamabad', '+92 300 7778889', '2024-06-28 02:33:37'),
(10, 'Hina Khan', 'Political Science', '1987-04-22', 'Female', 'House 345, Road XYZ, Lahore', '+92 321 1112233', '2024-06-28 02:33:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_on`) VALUES
(1, 'tm', 'tm', '2024-06-26 10:21:13'),
(2, 'usman@gmail.com', 'usman', '2024-06-26 13:33:25'),
(5, 'bmw', 'bmw', '2024-06-26 13:35:07'),
(7, 'admin', 'admin', '2024-06-27 13:59:08'),
(8, 'Zain', '1234', '2024-06-27 14:35:42'),
(9, 'huda', '0075a4e7a2e71083262da135ecdbdd14', '2024-06-27 15:11:21'),
(10, 'admin7amp', '202cb962ac59075b964b07152d234b70', '2024-06-27 15:16:31'),
(12, 'admin486', '$2y$10$XPonnk63RLo/qBUoixz36OoQV', '2024-06-28 03:53:13'),
(13, 'admin489', '$2y$10$PKUugsQVwXvH2ZE6OhWOdutRI', '2024-06-28 04:09:21'),
(14, 'testuser', '$2y$10$Po/62dgnLoJtHg0iPQCfm.CAo', '2024-06-28 04:16:54'),
(19, 'Tamoor', '81dc9bdb52d04dc20036dbd8313ed055', '2024-06-28 06:25:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`session_id`, `user_id`, `last_activity`) VALUES
(11, 1, '2024-06-28 10:00:00'),
(12, 2, '2024-06-28 09:30:00'),
(13, 5, '2024-06-28 08:45:00'),
(14, 7, '2024-06-28 11:15:00'),
(15, 8, '2024-06-28 10:30:00'),
(16, 9, '2024-06-28 09:00:00'),
(17, 10, '2024-06-28 08:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fees_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `fk_user_sessions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
