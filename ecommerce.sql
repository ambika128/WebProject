-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 05:06 AM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `session_id`, `product_id`, `quantity`, `added_on`, `username`) VALUES
(2, 'rju8notr8olatsuns9tfn44rcl', 0, 1, '2025-04-20 17:36:44', 'pushkar');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Mobile` varchar(30) NOT NULL,
  `Message` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`Name`, `Email`, `Mobile`, `Message`) VALUES
('Pushkar Sunil Shete', 'pushkarshete3495@gamil.com', '8669963495', 'Hello');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(10) UNSIGNED NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_price` decimal(10,2) NOT NULL,
  `p_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `p_name`, `p_price`, `p_image`) VALUES
(0, 'Cricket Jerseys', 200.00, 'images\\img-1.jpg'),
(1, 'Football Jerseys', 300.00, 'images\\img-2.jpg'),
(2, 'Kabaddi Jersey', 200.00, 'images\\img-3.jpg'),
(3, 'Premium Jerseys', 200.00, 'images\\img-4.jpg'),
(4, 'Comfortable Jerseys', 200.00, 'images\\img-5.jpg'),
(5, 'Ganpati Jerseys', 500.00, 'images\\img-6.jpg'),
(6, 'Navratri Jerseys', 350.00, 'images\\img-7.jpg'),
(7, 'Shimga Jerseys', 400.00, 'images\\img-8.jpg'),
(8, 'Shivjayanti Jerseys', 300.00, 'images/img-9.jpg'),
(9, 'Dahi Handi Jerseys', 250.00, 'images\\img-10.jpg'),
(10, 'Red Sando', 250.00, 'images\\img-11.jpg'),
(11, 'Sando', 350.00, 'images\\img-12.jpg'),
(12, 'Coloured Sando', 350.00, 'images\\img-13.jpg'),
(13, 'Music Design Jerseys', 250.00, 'images\\img-14.jpg'),
(14, 'Music Design Jerseys', 350.00, 'images\\img-15.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phonenumber` varchar(60) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`firstName`, `lastName`, `email`, `password`, `username`, `phonenumber`, `address`) VALUES
('Pushkar', 'Shete', 'pushkarshete3495@gamil.com', '12', 'pushkar', '8669963495', 'delhi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`p_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
