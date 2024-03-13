-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2024 at 09:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billfrozen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_status` varchar(255) NOT NULL,
  `expiry_date` date NOT NULL,
  `product_picture` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_code`, `product_name`, `price`, `category`, `quantity`, `product_status`, `expiry_date`, `product_picture`, `date_created`) VALUES
(1, 'PROD346792', 'Magnolia Whole Chicken', 230.00, 'Dressed Chicken', 10, 'Expiring Soon', '2024-03-29', 'uploads/SM3012-4.jpg', '2024-03-12 08:17:59'),
(2, 'PROD291373', 'CDO - Funtastyk Young Pork', 92.25, 'Frozen Foods', 50, 'Good', '2025-03-07', 'uploads/funtastyk-young-pork-tocino-flatpack-225g_1.jpg', '2024-03-12 08:18:28'),
(3, 'PROD283520', 'Mekeni - Kikiam', 110.00, 'Street Foods', 0, 'Expired', '2024-03-12', 'uploads/MekeniKikiam-AsianFlavoredFishRolls-250g.jpg', '2024-03-12 08:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `product_name`, `category`, `price`, `product_picture`) VALUES
(1, 'Magnolia Whole Chicken', 'Dressed Chicken', 230.00, 'uploads/SM3012-4.jpg'),
(2, 'CDO - Funtastyk Young Pork', 'Frozen Foods', 92.25, 'uploads/funtastyk-young-pork-tocino-flatpack-225g_1.jpg'),
(3, 'Tender Juicy - 1kg', 'Frozen Foods', 243.00, 'uploads/Purefoods-Tender-Juicy.jpg'),
(4, 'Mekeni - Kikiam', 'Street Foods', 110.00, 'uploads/MekeniKikiam-AsianFlavoredFishRolls-250g.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email_or_phone_number` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email_or_phone_number`, `full_name`, `username`, `password`, `profile_picture`, `date_created`) VALUES
(1, '09651168472', 'Hya Cynth Dojillo', 'hyacynth', '$2y$10$1ZyN9FbpJg0kWNA2bAfQWOfF/bvEM/Apd2GJitLTBF6iPmoK0BupS', NULL, '2024-03-13 08:17:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
