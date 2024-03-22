-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2024 at 08:58 AM
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `added_quantity` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `sold` int(11) NOT NULL,
  `product_status` varchar(255) NOT NULL,
  `expiry_date` date NOT NULL,
  `product_picture` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_code`, `product_name`, `price`, `category`, `quantity`, `sold`, `product_status`, `expiry_date`, `product_picture`, `date_created`) VALUES
(1, 'PROD346792', 'Magnolia Whole Chicken', 230.00, 'Dressed Chicken', 10, 0, 'Expiring Soon', '2024-03-29', 'uploads/SM3012-4.jpg', '2024-03-12 08:17:59'),
(2, 'PROD291373', 'CDO - Funtastyk Young Pork', 92.25, 'Frozen Foods', 50, 0, 'Good', '2025-03-07', 'uploads/funtastyk-young-pork-tocino-flatpack-225g_1.jpg', '2024-03-12 08:18:28'),
(3, 'PROD283520', 'Mekeni - Kikiam', 110.00, 'Street Foods', 0, 10, 'Expired', '2024-03-12', 'uploads/MekeniKikiam-AsianFlavoredFishRolls-250g.jpg', '2024-03-12 08:22:12'),
(4, 'PROD779539', 'Tender Juicy - 1kg', 243.00, 'Frozen Foods', 10, 0, 'Good', '2024-08-29', 'uploads/Purefoods-Tender-Juicy.jpg', '2024-03-22 01:36:05'),
(5, 'PROD863845', 'Pampanga`s Best - Sisig', 81.00, 'Frozen Foods', 15, 0, 'Good', '2024-06-22', 'uploads/5951-003-20-2023-140350-685.jpg', '2024-03-22 02:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_code` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(4, 'Mekeni - Kikiam', 'Street Foods', 110.00, 'uploads/MekeniKikiam-AsianFlavoredFishRolls-250g.jpg'),
(5, 'Pampanga`s Best - Sisig', 'Frozen Foods', 81.00, 'uploads/5951-003-20-2023-140350-685.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
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

INSERT INTO `users` (`id`, `user_id`, `email_or_phone_number`, `full_name`, `username`, `password`, `profile_picture`, `date_created`) VALUES
(1, 'BFU342966', '09651168472', 'Hya Cynth Dojillo', 'hyacynth', '$2y$10$LA8MNMshGEV/Pt2Iv5kexuNERQB/25yjoyb8cDlBdsvCHg9loq7XW', NULL, '2024-03-21 06:18:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_code`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
