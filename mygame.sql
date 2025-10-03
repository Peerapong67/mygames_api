-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2025 at 04:58 PM
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
-- Database: `mygame`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(10) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `publisher` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='gamedetail';

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `name`, `publisher`, `category`, `price`, `rating`) VALUES
(1, 'Pixel Quest', 'Indie Studio', 'single_player', 29.99, 7.85),
(2, 'Shadow Realm', 'Square Enix', 'single_player', 39.99, 8.95),
(3, 'Ancient Scrolls', 'Bethesda', 'single_player', 49.99, 9.10),
(4, 'Glory Arena', 'Riot Games', 'multiplayer', 59.99, 9.00),
(5, 'Galaxy Raiders', 'Bandai Namco', 'multiplayer', 44.99, 8.15),
(6, 'Zombie Survival', 'Valve', 'multiplayer', 34.99, 8.05),
(7, 'Street Football', 'EA Sports', 'sport', 24.99, 8.40),
(8, 'Tennis Pro Tour', 'Konami', 'sport', 19.99, 7.95),
(9, 'Battle Ops', 'Activision', 'shooting', 54.99, 8.20),
(10, 'Sniper Elite X', 'Rebellion', 'shooting', 64.99, 8.65),
(11, 'Combat Strike', 'Tencent', 'shooting', 74.99, 8.75),
(12, 'Farm Life', 'Zynga', 'casual', 14.99, 7.35),
(13, 'Casual Town', 'Supercell', 'casual', 9.99, 7.50),
(14, 'Puzzle Mania', 'King', 'puzzle', 12.99, 7.60),
(15, 'Mind Blocks', 'Mojang', 'puzzle', 22.99, 9.20),
(16, 'Speed Horizon', 'Ubisoft', 'racing', 49.99, 7.95),
(17, 'Pro Racing League', 'Codemasters', 'racing', 59.99, 8.55),
(18, 'Mystery Island', 'Nintendo', 'adventure', 69.99, 9.05),
(19, 'Dragon World', 'Capcom', 'adventure', 79.99, 9.25),
(20, 'Jungle Adventure', 'SEGA', 'adventure', 39.99, 8.40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
