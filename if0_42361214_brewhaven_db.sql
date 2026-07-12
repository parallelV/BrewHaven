-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql208.infinityfree.com
-- Generation Time: Jul 12, 2026 at 12:21 PM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42361214_brewhaven_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity` text NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `activity`, `log_time`) VALUES
(1, 1, 'Added Category: Premium Milk Tea', '2026-07-07 06:35:01'),
(2, 1, 'Added Category: Milk Tea', '2026-07-07 06:35:14'),
(3, 1, 'Added Category: Sundaes', '2026-07-07 06:45:10'),
(4, 1, 'Added Product: Caramel Matcha Latte', '2026-07-08 07:09:54'),
(5, 1, 'Added Product: French Toast', '2026-07-11 12:16:13'),
(6, 1, 'Updated Product: Caramel Matcha Latte', '2026-07-11 12:21:17'),
(7, 1, 'Added Product: Chocolate Hazelnut Iced Coffee', '2026-07-11 12:57:06'),
(8, 1, 'Updated Product: Chocolate Hazelnut Iced Coffee', '2026-07-11 13:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(9, 5, 1, 1),
(22, 7, 3, 1),
(23, 7, 8, 1),
(24, 7, 38, 1),
(25, 7, 13, 1),
(26, 7, 30, 2),
(27, 7, 35, 3);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`) VALUES
(1, 'Hot Coffee', '2026-07-06 11:29:10'),
(2, 'Iced Coffee', '2026-07-06 11:29:10'),
(3, 'Refreshers', '2026-07-06 11:29:10'),
(4, 'Bread & Pastries', '2026-07-06 11:29:10'),
(5, 'Cakes & Desserts', '2026-07-06 11:29:10');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` enum('Pending','Preparing','Completed','Cancelled') DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `payment_method`, `status`, `order_date`) VALUES
(2, 2, '240.00', 'Cash on Pickup', 'Completed', '2026-07-07 06:07:35'),
(3, 3, '185.00', 'GCash', 'Completed', '2026-07-07 08:55:13'),
(4, 4, '145.00', 'Cash on Pickup', 'Pending', '2026-07-07 09:53:15'),
(5, 6, '1305.00', 'GCash', 'Pending', '2026-07-11 11:28:51'),
(6, 7, '1559.00', 'Cash on Pickup', 'Pending', '2026-07-11 12:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(3, 2, 24, 2, '120.00', '240.00'),
(4, 3, 18, 1, '185.00', '185.00'),
(5, 4, 25, 1, '145.00', '145.00'),
(6, 5, 26, 1, '90.00', '90.00'),
(7, 5, 7, 1, '195.00', '195.00'),
(8, 5, 11, 1, '225.00', '225.00'),
(9, 5, 16, 1, '210.00', '210.00'),
(10, 5, 24, 1, '120.00', '120.00'),
(11, 5, 34, 1, '240.00', '240.00'),
(12, 5, 36, 1, '225.00', '225.00'),
(13, 6, 38, 1, '149.00', '149.00'),
(14, 6, 24, 2, '120.00', '240.00'),
(15, 6, 39, 2, '130.00', '260.00'),
(16, 6, 33, 2, '230.00', '460.00'),
(17, 6, 11, 2, '225.00', '450.00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `expires_at` datetime NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `otp`, `expires_at`, `is_used`, `created_at`) VALUES
(1, 'pacozyril@gmail.com', '633827', '2026-07-08 04:08:02', 1, '2026-07-08 07:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_type` enum('Drink','Food') NOT NULL DEFAULT 'Drink',
  `product_name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `size` enum('Regular','Medium','Large') DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'default.png',
  `status` enum('Available','Unavailable') DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `featured` enum('Yes','No') DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_type`, `product_name`, `description`, `size`, `price`, `stock`, `image`, `status`, `created_at`, `featured`) VALUES
(1, 1, 'Drink', 'Caffè Americano', 'Freshly brewed espresso with hot water.', 'Regular', '120.00', 50, 'americano.jpg', 'Available', '2026-07-06 14:17:09', 'No'),
(2, 1, 'Drink', 'Cappuccino', 'Espresso with steamed milk and foam.', 'Medium', '165.00', 45, 'cappuccino.jpg', 'Available', '2026-07-06 14:17:09', 'No'),
(3, 1, 'Drink', 'Caffè Latte', 'Rich espresso blended with steamed milk.', 'Medium', '175.00', 40, 'latte.jpg', 'Available', '2026-07-06 14:17:09', 'No'),
(4, 1, 'Drink', 'Caramel Macchiato', 'Espresso with vanilla syrup and caramel drizzle.', 'Large', '210.00', 35, 'macchiato.jpg', 'Available', '2026-07-06 14:17:09', 'No'),
(5, 1, 'Drink', 'Caffè Mocha', 'Chocolate-flavored espresso drink.', 'Large', '220.00', 30, 'mocha.jpg', 'Available', '2026-07-06 14:17:09', 'No'),
(6, 1, 'Drink', 'Flat White', 'Velvety steamed milk with espresso.', 'Medium', '185.00', 28, 'flatwhite.jpg', 'Available', '2026-07-06 14:17:09', 'No'),
(7, 1, 'Drink', 'Vanilla Latte', 'Classic latte with vanilla syrup.', 'Medium', '195.00', 26, 'vanillalatte.jpg', 'Available', '2026-07-06 14:17:09', 'No'),
(8, 1, 'Drink', 'Hazelnut Latte', 'Creamy latte infused with hazelnut flavor.', 'Large', '205.00', 25, 'hazelnutlatte.jpg', 'Available', '2026-07-06 14:17:09', 'No'),
(9, 2, 'Drink', 'Iced Americano', 'Espresso served over ice.', 'Medium', '135.00', 50, 'icedamericano.jpg', 'Available', '2026-07-06 15:06:27', 'No'),
(10, 2, 'Drink', 'Iced Latte', 'Cold milk blended with espresso.', 'Large', '190.00', 40, 'icedlatte.jpg', 'Available', '2026-07-06 15:06:27', 'No'),
(11, 2, 'Drink', 'Iced Caramel Macchiato', 'Cold espresso with caramel drizzle.', 'Large', '225.00', 35, 'icedmacchiato.jpg', 'Available', '2026-07-06 15:06:27', 'No'),
(12, 2, 'Drink', 'Vanilla Sweet Cream Cold Brew', 'Cold brew topped with vanilla sweet cream.', 'Large', '235.00', 25, 'coldbrew.jpg', 'Available', '2026-07-06 15:06:27', 'No'),
(13, 2, 'Drink', 'Hazelnut Iced Latte', 'Creamy iced latte infused with hazelnut.', 'Large', '220.00', 30, 'hazelnuticed.jpg', 'Available', '2026-07-06 15:06:27', 'No'),
(14, 2, 'Drink', 'Iced White Mocha', 'Espresso with white chocolate over ice.', 'Large', '235.00', 28, 'whitemocha.jpg', 'Available', '2026-07-06 15:06:27', 'No'),
(15, 2, 'Drink', 'Salted Caramel Cold Brew', 'Cold brew with salted caramel foam.', 'Large', '245.00', 20, 'saltedcaramel.jpg', 'Available', '2026-07-06 15:06:27', 'No'),
(16, 2, 'Drink', 'Spanish Latte', 'Espresso with creamy condensed milk served cold.', 'Large', '210.00', 30, 'spanishlatte.jpg', 'Available', '2026-07-06 15:06:27', 'No'),
(17, 3, 'Drink', 'Strawberry Lemonade', 'Refreshing strawberry citrus drink.', 'Large', '175.00', 50, 'strawberry.jpg', 'Available', '2026-07-06 15:09:03', 'No'),
(18, 3, 'Drink', 'Mango Passion', 'Sweet tropical mango refresher.', 'Large', '185.00', 40, 'mango.jpg', 'Available', '2026-07-06 15:09:03', 'No'),
(19, 3, 'Drink', 'Green Apple Refresher', 'Crisp green apple flavored drink.', 'Large', '180.00', 35, 'apple.jpg', 'Available', '2026-07-06 15:09:03', 'No'),
(20, 3, 'Drink', 'Berry Hibiscus', 'Mixed berry herbal refresher.', 'Large', '195.00', 30, 'berry.jpg', 'Available', '2026-07-06 15:09:03', 'No'),
(21, 3, 'Drink', 'Peach Citrus Tea', 'Refreshing peach tea with citrus.', 'Large', '190.00', 25, 'peach.jpg', 'Available', '2026-07-06 15:09:03', 'No'),
(22, 3, 'Drink', 'Tropical Sunset', 'Refreshing tropical fruit blend.', 'Large', '200.00', 20, 'tropical.jpg', 'Available', '2026-07-06 15:09:03', 'No'),
(23, 4, 'Food', 'Butter Croissant', 'Classic buttery croissant.', NULL, '95.00', 40, 'buttercroissant.jpg', 'Available', '2026-07-06 15:09:12', 'No'),
(24, 4, 'Food', 'Chocolate Croissant', 'Flaky croissant with chocolate filling.', NULL, '120.00', 30, 'chocolatecroissant.jpg', 'Available', '2026-07-06 15:09:12', 'No'),
(25, 4, 'Food', 'Ham & Cheese Croissant', 'Savory ham and cheese croissant.', NULL, '145.00', 25, 'hamcheese.jpg', 'Available', '2026-07-06 15:09:12', 'No'),
(26, 4, 'Food', 'Garlic Bread', 'Freshly baked garlic bread.', NULL, '90.00', 30, 'garlicbread.jpg', 'Available', '2026-07-06 15:09:12', 'No'),
(27, 4, 'Food', 'Cinnamon Roll', 'Soft cinnamon roll with icing.', NULL, '145.00', 20, 'cinnamon.jpg', 'Available', '2026-07-06 15:09:12', 'No'),
(28, 4, 'Food', 'Blueberry Muffin', 'Moist muffin with blueberries.', NULL, '135.00', 25, 'muffin.jpg', 'Available', '2026-07-06 15:09:12', 'No'),
(29, 5, 'Food', 'Blueberry Cheesecake', 'Creamy blueberry cheesecake.', NULL, '210.00', 20, 'cheesecake.jpg', 'Available', '2026-07-06 15:09:18', 'No'),
(30, 5, 'Food', 'Chocolate Cake', 'Rich chocolate layered cake.', NULL, '195.00', 25, 'chocolatecake.jpg', 'Available', '2026-07-06 15:09:18', 'No'),
(31, 5, 'Food', 'Red Velvet Cake', 'Classic red velvet cake.', NULL, '220.00', 18, 'redvelvet.jpg', 'Available', '2026-07-06 15:09:18', 'No'),
(32, 5, 'Food', 'Carrot Cake', 'Fresh carrot cake with cream cheese frosting.', NULL, '205.00', 15, 'carrotcake.jpg', 'Available', '2026-07-06 15:09:18', 'No'),
(33, 5, 'Food', 'New York Cheesecake', 'Creamy New York cheesecake.', NULL, '230.00', 20, 'nycheesecake.jpg', 'Available', '2026-07-06 15:09:18', 'No'),
(34, 5, 'Food', 'Tiramisu', 'Classic Italian tiramisu.', NULL, '240.00', 15, 'tiramisu.jpg', 'Available', '2026-07-06 15:09:18', 'No'),
(35, 5, 'Food', 'Chocolate Brownie', 'Fudgy chocolate brownie.', NULL, '120.00', 30, 'brownie.jpg', 'Available', '2026-07-06 15:09:18', 'No'),
(36, 5, 'Food', 'Oreo Cheesecake', 'Creamy cheesecake with Oreo cookies.', NULL, '225.00', 20, 'oreocheesecake.jpg', 'Available', '2026-07-06 15:09:18', 'No'),
(38, 2, 'Drink', 'Caramel Matcha Latte', '', 'Medium', '149.00', 20, '1783772478_caramelMatchaLatte.png', 'Available', '2026-07-08 07:09:54', 'No'),
(39, 4, 'Food', 'French Toast', 'French Toast with syrup of your choice and butter.', 'Regular', '130.00', 21, '1783772173_french_toast.jpg', 'Available', '2026-07-11 12:16:13', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(20) NOT NULL,
  `role` enum('admin','seller','buyer') DEFAULT 'buyer',
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `address`, `contact`, `role`, `status`, `created_at`) VALUES
(1, 'System Administrator', 'admin@brewhaven.com', '$2y$10$RT.Ssz7nGIh0XT7ybpRToeIQVR1N6oMOrP22dAito7LG3fI98U59u', 'Brew Haven Office', '09123456789', 'admin', 'Active', '2026-07-06 11:10:15'),
(2, 'Juan Dela Cruz', 'juan@gmail.com', '$2y$10$76gD9M7rvSh9viod5i6bL.FEa1J4AUXu/hXFxr1zEansEdw4KfK0C', '124 Kamias Road, Barangay PinyahanQuezon City, Metro Manila 1101', '09760613468', 'buyer', 'Active', '2026-07-06 16:55:55'),
(3, 'Keith Sarangay', 'momonchi47@gmail.com', '$2y$10$vxtrYSUl3s0OXaxIyvUDFuOlp7AHZFUmBsoPyVRcprnj5243gJg6.', 'Sunriser Square Caloocan City', '09770623274', 'buyer', 'Active', '2026-07-07 08:53:53'),
(4, 'john zyril paco', 'pacozyril@gmail.com', '$2y$10$uJbGG/pqWA01/JP4HAbKt.wFPZOKW7CPdpaSk2.8HCGVtC8HMWd2a', 'secret', '0123456789', 'buyer', 'Active', '2026-07-07 09:51:54'),
(5, 'Jed Bautista', 'bautistajed45@gmail.com', '$2y$10$apquCDkAut.fJIE2dexzUuGtHHL8Ud7Gfy6mw2W4VfyWsXYS25utC', 'none', '09932607492', 'buyer', 'Active', '2026-07-10 12:53:13'),
(6, 'Duwayne Jan Ruiz', 'ruizduwayne7@gmail.com', '$2y$10$Eh0oAh82kgyNkedX0OQg5u0RIY7fpXe/a2agbT04jgCrvj2pv20FO', '9 King John St. Del Rey VIlle 2 Subdivision Camarin, Caloocan City', '09497626174', 'buyer', 'Active', '2026-07-11 11:18:44'),
(7, 'Justin Mark', 'just@gmail.com', '$2y$10$.DYlQ61IykVDS3764B7BNOKRmI33iGdWuGpf8JBk9JycyBuiBMibG', 'Manila', '09457874565', 'buyer', 'Active', '2026-07-11 12:11:21'),
(8, 'Beng Beng Marcos', 'jaywoh479@gmail.com', '$2y$10$Q2uIRpCxRpMKgJKb1TZrHOddvgCtXX9a/fP3t3DIlsv2D8TIEzma.', 's', '09123456789', 'buyer', 'Active', '2026-07-12 16:11:17'),
(9, 'John Zyril Paco', 'zyrilpaco@gmail.com', '$2y$10$Zzur1w7NRLRWeIuzrrYZNeuh4fXsNV.rDe2K4/AA/yosEjdkU85CC', 'Commonwealth', '09472376124', 'buyer', 'Active', '2026-07-12 16:16:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
