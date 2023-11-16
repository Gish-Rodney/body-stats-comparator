-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 07:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `b_s_comparator`
--

-- --------------------------------------------------------

--
-- Table structure for table `athlete_stats`
--

CREATE TABLE `athlete_stats` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture_url` varchar(255) DEFAULT NULL,
  `weight` float NOT NULL,
  `height` int(11) NOT NULL,
  `strength` float NOT NULL,
  `agility` float NOT NULL,
  `endurance` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `athlete_stats`
--

INSERT INTO `athlete_stats` (`id`, `name`, `picture_url`, `weight`, `height`, `strength`, `agility`, `endurance`) VALUES
(2, 'Rodney', NULL, 83.2, 176, 50, 5.1, 120);

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE `workouts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `targeted_stat` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workouts`
--

INSERT INTO `workouts` (`id`, `name`, `targeted_stat`, `description`, `created_at`) VALUES
(1, 'Strength Training', 'strength', 'Weightlifting and resistance exercises for strength improvement', '2023-11-16 17:34:52'),
(2, 'Agility Drill', 'agility', 'Speed and agility exercises to enhance quickness and coordination', '2023-11-16 17:34:52'),
(3, 'Endurance Workout', 'endurance', 'Cardio and stamina-focused exercises for endurance improvement', '2023-11-16 17:34:52'),
(4, 'Strength Training', 'strength', 'Weightlifting and resistance exercises for strength improvement', '2023-11-16 17:35:06'),
(5, 'Agility Drill', 'agility', 'Speed and agility exercises to enhance quickness and coordination', '2023-11-16 17:35:06'),
(6, 'Endurance Workout', 'endurance', 'Cardio and stamina-focused exercises for endurance improvement', '2023-11-16 17:35:06');

-- --------------------------------------------------------

--
-- Table structure for table `workout_stats`
--

CREATE TABLE `workout_stats` (
  `id` int(11) NOT NULL,
  `workout_id` int(11) DEFAULT NULL,
  `stat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `athlete_stats`
--
ALTER TABLE `athlete_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workout_stats`
--
ALTER TABLE `workout_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workout_id` (`workout_id`),
  ADD KEY `stat_id` (`stat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `athlete_stats`
--
ALTER TABLE `athlete_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `workout_stats`
--
ALTER TABLE `workout_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `workout_stats`
--
ALTER TABLE `workout_stats`
  ADD CONSTRAINT `workout_stats_ibfk_1` FOREIGN KEY (`workout_id`) REFERENCES `workouts` (`id`),
  ADD CONSTRAINT `workout_stats_ibfk_2` FOREIGN KEY (`stat_id`) REFERENCES `athlete_stats` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
