-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2024 at 03:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

---- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2025 at 12:20 AM
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
-- Database: `billfrozen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `added_quantity` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user_id`, `username`, `product_code`, `product_name`, `added_quantity`, `date_created`) VALUES
('BFU509265', 'yangyang', 'PROD863845', 'Pampanga`s Best - Sisig', 1, '2024-06-20 02:15:02'),
('BFU342966', 'hyacynth', 'PROD346792', 'Magnolia Whole Chicken', 1, '2025-02-06 23:18:25');

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
  `expiry_date` date NOT NULL,
  `product_picture` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_code`, `product_name`, `price`, `category`, `quantity`, `sold`, `expiry_date`, `product_picture`, `date_created`) VALUES
(1, 'PROD346792', 'Magnolia Whole Chicken', 230.00, 'Dressed Chicken', 6, 3, '2025-05-15', 'uploads/SM3012-4.jpg', '2024-03-12 08:17:59'),
(2, 'PROD291373', 'CDO - Funtastyk Young Pork', 92.25, 'Frozen Foods', 49, 1, '2025-03-07', 'uploads/funtastyk-young-pork-tocino-flatpack-225g_1.jpg', '2024-03-12 08:18:28'),
(3, 'PROD283520', 'Mekeni - Kikiam', 110.00, 'Street Foods', 0, 10, '2025-08-12', 'uploads/MekeniKikiam-AsianFlavoredFishRolls-250g.jpg', '2024-03-12 08:22:12'),
(4, 'PROD779539', 'Tender Juicy - 1kg', 243.00, 'Frozen Foods', 10, 0, '2024-08-29', 'uploads/Purefoods-Tender-Juicy.jpg', '2024-03-22 01:36:05'),
(5, 'PROD863845', 'Pampanga`s Best - Sisig', 81.00, 'Frozen Foods', 14, 1, '2024-06-22', 'uploads/5951-003-20-2023-140350-685.jpg', '2024-03-22 02:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `order_status` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `username`, `description`, `order_status`, `status`, `date_created`) VALUES
(1, 'BFU342966', 'Hya Cynth Dojillo', 'Your order with order code ORD04-05-20242627 has been declined due to insufficient stocks.', 'Order Declined', 'read', '2024-07-10 02:59:43'),
(2, 'BFU342966', 'Hya Cynth Dojillo', 'Your order with order code ORD04-05-20244958 has been confirmed and is now scheduled for delivery on 2024-07-26.', 'Order Confirmed', 'read', '2024-07-09 02:59:57'),
(3, 'BFU342966', 'Hya Cynth Dojillo', 'Your order with order code ORD04-08-20245184 has been confirmed and is now scheduled for delivery on 2025-02-14.', 'Order Confirmed', 'read', '2025-02-04 08:10:57'),
(4, 'BFU342966', 'Hya Cynth Dojillo', 'Your order with order code ORD04-08-20245184 has been rescheduled for delivery on 2025-02-14.', 'Order Rescheduled', 'read', '2025-02-05 11:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_code` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `delivery_date` date DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_code`, `user_id`, `name`, `contact`, `product_code`, `product_name`, `quantity`, `total_price`, `order_date`, `delivery_date`, `delivery_address`, `order_status`, `date_created`) VALUES
('ORD04-05-20242627', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD863845', 'Pampanga`s Best - Sisig', 3, 243.00, '2024-04-05', NULL, 'Villavert-Jimenez, Hamtic, 5715', 'Order Declined', '2024-04-05 05:21:37'),
('ORD04-05-20244958', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD863845', 'Pampanga`s Best - Sisig', 3, 243.00, '2024-04-05', '2024-07-26', 'h dfhjsd, hhasdh, 546', 'Order Received', '2024-04-05 07:56:26'),
('ORD04-08-20245184', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD346792', 'Magnolia Whole Chicken', 1, 230.00, '2024-04-08', '2025-02-14', 'Hello World, Hello, ', 'For Delivery', '2024-04-08 03:54:35'),
('ORD02-04-20252923', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD283520', 'Mekeni - Kikiam', 1, 110.00, '2025-02-04', NULL, 'Binirayan, San Jose, 5700', 'Pending', '2025-02-04 06:00:54'),
('ORD02-06-20256273', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD779539', 'Tender Juicy - 1kg', 1, 243.00, '2025-02-07', NULL, 'kkasdj, ksjdlk, 54465', 'Pending', '2025-02-06 16:57:42'),
('ORD02-06-20254904', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD346792', 'Magnolia Whole Chicken', 1, 230.00, '2025-02-07', NULL, 'adkkad, kakdsj, 2154', 'Pending', '2025-02-06 16:58:07'),
('ORD02-06-20254904', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD291373', 'CDO - Funtastyk Young Pork', 1, 92.25, '2025-02-07', NULL, 'adkkad, kakdsj, 2154', 'Pending', '2025-02-06 16:58:07'),
('ORD02-06-20259492', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD346792', 'Magnolia Whole Chicken', 2, 460.00, '2025-02-07', NULL, 'asd, dsad, 5686', 'Pending', '2025-02-06 16:59:12'),
('ORD02-06-20259914', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD863845', 'Pampanga`s Best - Sisig', 1, 81.00, '2025-02-07', NULL, 'dakjd, jdasd, 5456', 'Pending', '2025-02-06 17:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `product_name`, `description`, `category`, `price`, `product_picture`) VALUES
(1, 'Magnolia Whole Chicken', '', 'Dressed Chicken', 230.00, 'uploads/SM3012-4.jpg'),
(2, 'CDO - Funtastyk Young Pork', '', 'Frozen Foods', 92.25, 'uploads/funtastyk-young-pork-tocino-flatpack-225g_1.jpg'),
(3, 'Tender Juicy - 1kg', 'Ha? Hakdog', 'Frozen Foods', 243.00, 'uploads/Purefoods-Tender-Juicy.jpg'),
(4, 'Mekeni - Kikiam', '', 'Street Foods', 110.00, 'uploads/MekeniKikiam-AsianFlavoredFishRolls-250g.jpg'),
(5, 'Pampanga`s Best - Sisig', '', 'Frozen Foods', 81.00, 'uploads/5951-003-20-2023-140350-685.jpg');

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
(1, 'BFU342966', '09651168472', 'Hya Cynth Dojillo', 'hyacynth', '$2y$10$OVAMZrZ2acJ/Z6v9CUEaiuuSQgfHu/kjZlMRC30ABd8SMKgupHMcu', NULL, '2024-03-21 06:18:48'),
(2, 'BFU509265', '09610519898', 'Hya Cynth Dojillo', 'yangyang', '$2y$10$3O0tM.ugft11w2yTxu/1a.h5QwFB5wg3RGRjYZcCIT7U0bOqD84zC', NULL, '2024-06-18 02:22:22'),
(3, 'BFU669727', 'ghelobatas@gmail.com', 'Ghelo Batas', 'gheloB', '$2y$10$259IFp2aOI9v/IhNzV09fOYXCI.rV0S999DvrLHcRxP6Ynxrtg3vi', NULL, '2025-02-04 06:28:22');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Database: `billfrozen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `added_quantity` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user_id`, `username`, `product_code`, `product_name`, `added_quantity`, `date_created`) VALUES
('BFU342966', 'hyacynth', 'PROD291373', 'CDO - Funtastyk Young Pork', 1, '2024-05-15 05:52:37'),
('BFU342966', 'hyacynth', 'PROD346792', 'Magnolia Whole Chicken', 1, '2024-06-20 02:10:22'),
('BFU509265', 'yangyang', 'PROD863845', 'Pampanga`s Best - Sisig', 1, '2024-06-20 02:15:02');

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
  `expiry_date` date NOT NULL,
  `product_picture` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_code`, `product_name`, `price`, `category`, `quantity`, `sold`, `expiry_date`, `product_picture`, `date_created`) VALUES
(1, 'PROD346792', 'Magnolia Whole Chicken', 230.00, 'Dressed Chicken', 10, 0, '2024-11-29', 'uploads/SM3012-4.jpg', '2024-03-12 08:17:59'),
(2, 'PROD291373', 'CDO - Funtastyk Young Pork', 92.25, 'Frozen Foods', 50, 0, '2025-03-07', 'uploads/funtastyk-young-pork-tocino-flatpack-225g_1.jpg', '2024-03-12 08:18:28'),
(3, 'PROD283520', 'Mekeni - Kikiam', 110.00, 'Street Foods', 0, 10, '2024-03-12', 'uploads/MekeniKikiam-AsianFlavoredFishRolls-250g.jpg', '2024-03-12 08:22:12'),
(4, 'PROD779539', 'Tender Juicy - 1kg', 243.00, 'Frozen Foods', 10, 0, '2024-08-29', 'uploads/Purefoods-Tender-Juicy.jpg', '2024-03-22 01:36:05'),
(5, 'PROD863845', 'Pampanga`s Best - Sisig', 81.00, 'Frozen Foods', 15, 0, '2024-06-22', 'uploads/5951-003-20-2023-140350-685.jpg', '2024-03-22 02:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `order_status` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `username`, `description`, `order_status`, `status`, `date_created`) VALUES
(1, 'BFU342966', 'Hya Cynth Dojillo', 'Your order with order code ORD04-05-20242627 has been declined due to insufficient stocks.', 'Order Declined', 'read', '2024-07-10 02:59:43'),
(2, 'BFU342966', 'Hya Cynth Dojillo', 'Your order with order code ORD04-05-20244958 has been confirmed and is now scheduled for delivery on 2024-07-26.', 'Order Confirmed', 'read', '2024-07-09 02:59:57');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_code` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `delivery_date` date DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_code`, `user_id`, `name`, `contact`, `product_code`, `product_name`, `quantity`, `total_price`, `order_date`, `delivery_date`, `delivery_address`, `order_status`, `date_created`) VALUES
('ORD04-05-20242627', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD863845', 'Pampanga`s Best - Sisig', 3, 243.00, '2024-04-05', NULL, 'Villavert-Jimenez, Hamtic, 5715', 'Order Declined', '2024-04-05 05:21:37'),
('ORD04-05-20244958', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD863845', 'Pampanga`s Best - Sisig', 3, 243.00, '2024-04-05', '2024-07-26', 'h dfhjsd, hhasdh, 546', 'For Delivery', '2024-04-05 07:56:26'),
('ORD04-08-20245184', 'BFU342966', 'Hya Cynth Dojillo', '09651168472', 'PROD346792', 'Magnolia Whole Chicken', 1, 230.00, '2024-04-08', NULL, 'Hello World, Hello, ', 'Pending', '2024-04-08 03:54:35');

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
(1, 'BFU342966', '09651168472', 'Hya Cynth Dojillo', 'hyacynth', '$2y$10$OVAMZrZ2acJ/Z6v9CUEaiuuSQgfHu/kjZlMRC30ABd8SMKgupHMcu', NULL, '2024-03-21 06:18:48'),
(2, 'BFU509265', '09610519898', 'Hya Cynth Dojillo', 'yangyang', '$2y$10$3O0tM.ugft11w2yTxu/1a.h5QwFB5wg3RGRjYZcCIT7U0bOqD84zC', NULL, '2024-06-18 02:22:22');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
