-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2023 at 02:07 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `projectmembers`
--

CREATE TABLE `projectmembers` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `role` text NOT NULL,
  `email` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projectmembers`
--

INSERT INTO `projectmembers` (`user_id`, `project_id`, `role`, `email`) VALUES
(0, 5, 'manager', 'javeriabutt6208@gmail.com'),
(0, 6, 'manager', 'javeriabutt6208@gmail.com'),
(0, 7, 'manager', 'javeriabutt6208@gmail.com'),
(1, 2, 'manager', 'javeriabutt6208@gmail.com'),
(2, 2, 'employee', 'user1@gmail.com'),
(2, 6, 'employee', 'user1@gmail.com'),
(2, 7, 'employee', 'user1@gmail.com'),
(3, 6, 'employee', 'user2@gmail.com'),
(3, 7, 'employee', 'user2@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `team` varchar(255) NOT NULL,
  `access` tinyint(1) NOT NULL,
  `deadline` date NOT NULL,
  `Status` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `percentage` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `team`, `access`, `deadline`, `Status`, `created_by`, `percentage`) VALUES
(2, 'Test2', '1', 0, '2023-07-20', 'To Do', 1, '0'),
(7, 'Test 4', '2', 0, '2023-07-21', 'Doing', 0, '46');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `user_id` int(10) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`user_id`, `firstname`, `lastname`, `username`, `email`, `password`) VALUES
(1, 'javeria', 'butt', 'javeria', 'javeriabutt6208@gmail.com', 'Javeria'),
(2, 'user', '1', 'user1', 'user1@gmail.com', 'user1'),
(3, 'user', '2', 'user2', 'user2@gmail.com', 'user2');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) NOT NULL,
  `file` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` text NOT NULL,
  `due_date` date DEFAULT NULL,
  `time_required` int(11) NOT NULL,
  `time_spent` text NOT NULL,
  `user_email` text NOT NULL,
  `timer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `project_id`, `assigned_to`, `file`, `description`, `status`, `due_date`, `time_required`, `time_spent`, `user_email`, `timer`) VALUES
(6, 'Task1', 2, 2, NULL, NULL, 'To Do', '2023-07-13', 20, '00', 'user1@gmail.com', '00:00:00'),
(7, 'task 3', 7, 2, NULL, NULL, 'To Do', '2023-07-20', 50, '0', 'user1@gmail.com', '00:00:00'),
(8, 'test task', 7, 0, NULL, NULL, 'Doing', '2023-07-19', 108, '92.59', 'javeriabutt6208@gmail.com', '00:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL,
  `Team_Name` text NOT NULL,
  `description` text NOT NULL,
  `created_on` date NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projectmembers`
--
ALTER TABLE `projectmembers`
  ADD PRIMARY KEY (`user_id`,`project_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD UNIQUE KEY `task_name` (`task_name`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
