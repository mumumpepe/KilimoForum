-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2024 at 11:28 AM
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
-- Database: `webforum`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment_content` text DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `seller_farmer_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment_content`, `post_id`, `user_id`, `seller_farmer_id`, `timestamp`) VALUES
(1, 'mchele wako ni mzuri sana nimeupenda', 3, 58, NULL, '2024-08-06 12:16:25'),
(2, 'nikitaka kuupata naupataje', 3, 58, NULL, '2024-08-06 12:16:36'),
(3, 'habari nauliza naweza pata punguzo mpaka la asilimia ngapi', 3, 58, 62, '2024-08-06 12:00:26'),
(4, 'majembe yako ni mazuri sana na imara', 5, 58, 62, '2024-08-06 12:00:26'),
(5, 'hongera mchele wako nimeupenda', 3, 58, 60, '2024-08-06 12:00:26'),
(6, 'how much does it cost', 4, 58, 62, '2024-08-06 12:03:07'),
(7, 'jembe moja bei gani tajiri', 5, 58, 62, '2024-08-06 12:22:34'),
(8, 'hi', 3, 58, 60, '2024-08-06 12:56:15'),
(9, 'i really like your mchele', 3, 58, 60, '2024-08-06 12:59:18'),
(10, 'trekta zako kweli ziko imara mkuu nawashauri watu wanunue', 4, 58, 60, '2024-08-06 12:59:53'),
(11, 'je pawatila hii inadumu kwa muda gani (makadirio mafupi)', 6, 58, 60, '2024-08-06 13:08:12'),
(12, 'sawa mkuu nimependa majembe yako, punguzo ni asilimia ngapi kama nataka matano', 5, 58, 60, '2024-08-06 13:26:32'),
(13, 'matumazi yake yakoje', 7, 58, 60, '2024-08-06 13:29:19'),
(14, 'mchele wako ni mzuri kweli au blah blah!', 3, 58, 60, '2024-08-06 13:32:26'),
(15, 'HI', 9, 58, 60, '2024-08-08 05:51:39'),
(16, 'maharage yako mazuri sana hongera', 10, 58, 60, '2024-08-08 10:26:50'),
(17, 'nikitaka gunia 50 naweza pata punguzo hadi la asilimia ngapi?', 10, 58, 60, '2024-08-08 10:27:21'),
(18, 'habari', 3, 58, 60, '2024-08-08 11:21:50'),
(19, 'hi', 3, 58, 60, '2024-08-08 11:51:14'),
(20, 'hi', 3, 58, 60, '2024-08-08 12:17:56'),
(21, 'habari', 9, 58, 60, '2024-08-12 07:28:03'),
(22, 'Mchele wa wapi??', 3, 58, 60, '2024-08-13 07:08:05'),
(23, 'habari', 3, 58, 60, '2024-08-14 09:52:57'),
(24, 'hi ', 3, 58, 60, '2024-08-15 14:12:34'),
(25, 'hi', 3, 58, 60, '2024-08-15 14:30:05'),
(26, 'hi', 3, 58, 60, '2024-08-15 14:49:21'),
(27, 'hi', 3, 58, 60, '2024-08-15 15:38:32'),
(28, 'hi', 3, 58, 60, '2024-08-15 15:53:34'),
(29, 'hi', 3, 58, 60, '2024-08-19 12:03:29'),
(30, 'vitunguu vya nimevipenda ngoja nizingatie maokoto apa', 11, 58, 60, '2024-08-19 13:09:27'),
(31, 'hi', 3, 58, 60, '2024-08-19 13:39:36'),
(32, 'hi', 3, 58, 60, '2024-08-19 14:17:56'),
(33, 'hi there', 3, 58, 60, '2024-08-19 14:27:50'),
(34, 'hi there there', 3, 58, 60, '2024-08-19 14:41:15'),
(35, 'hi', 4, 58, 60, '2024-08-20 09:33:39'),
(36, 'hi', 3, 58, 60, '2024-08-20 09:36:53'),
(37, 'hi', 4, 58, 60, '2024-08-20 09:37:27'),
(38, 'mchele wako ni mzuri nimeupenda je hakuna punguzo', 3, 58, 60, '2024-08-21 07:47:49');

-- --------------------------------------------------------

--
-- Table structure for table `comment_replies`
--

CREATE TABLE `comment_replies` (
  `reply_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_comment_id` int(11) DEFAULT NULL,
  `child_commnet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_post`
--

CREATE TABLE `forum_post` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `message_content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `seller_farmer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('customer','seller','farmer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `message_content`, `user_id`, `seller_farmer_id`, `product_id`, `timestamp`, `role`) VALUES
(17, 'hi', 58, 60, 8, '2024-08-09 08:17:19', 'customer'),
(18, 'hi customer hi can i serve you', 58, 60, 8, '2024-08-09 08:33:06', 'farmer'),
(19, 'hi', 58, 60, 8, '2024-08-09 08:39:58', 'customer'),
(20, 'hi there', 58, 60, 8, '2024-08-09 08:41:06', 'customer'),
(21, 'how can i get your products', 58, 60, 8, '2024-08-09 08:43:23', 'customer'),
(22, 'how can i get your products', 58, 60, 8, '2024-08-09 08:44:09', 'customer'),
(41, 'habari buana ', 58, 62, 4, '2024-08-09 14:02:23', 'customer'),
(42, 'hi there', 58, 60, 3, '2024-08-10 04:32:44', 'customer'),
(43, 'hi', 58, 62, 5, '2024-08-10 04:36:15', 'customer'),
(44, 'hi', 58, 62, 5, '2024-08-10 04:36:18', 'customer'),
(45, 'i am little bit attracted to your product can you show me the whole store of yours', 58, 62, 5, '2024-08-10 04:36:37', 'customer'),
(46, 'i am little bit attracted to your product can you show me the whole store', 58, 60, 3, '2024-08-10 04:36:50', 'customer'),
(47, 'i really am attracted', 58, 60, 3, '2024-08-10 04:36:59', 'customer'),
(48, 'trekta yako ni imara kweli au ni swags tu mzee baba', 58, 62, 4, '2024-08-10 04:42:24', 'customer'),
(49, 'customer thanks for your comment', 58, 60, 8, '2024-08-10 05:39:14', 'farmer'),
(50, 'really as a farmer i am motivated ', 58, 60, 8, '2024-08-10 05:40:10', 'farmer'),
(52, 'i am very happy to hear that thanks mr/mrs', 58, 62, 5, '2024-08-10 05:49:55', 'seller'),
(53, 'trekta hizi ni kweli ni imara kwani pia zinakuja na warranty ya miaka mitano kwa hiyo ushindwe wewe tu', 58, 62, 4, '2024-08-10 05:50:48', 'seller'),
(54, 'okay mr tell me what product do you want', 58, 62, 5, '2024-08-10 05:55:22', 'seller'),
(55, 'just wanted to see what you have got so that i plan well my budget', 58, 62, 5, '2024-08-10 05:57:35', 'customer'),
(56, 'habari', 58, 60, 3, '2024-08-13 07:09:53', 'customer'),
(57, 'nzuri', 58, 60, 3, '2024-08-13 07:11:37', 'farmer'),
(58, 'habari', 58, 60, 3, '2024-08-13 07:13:15', 'customer'),
(59, 'hi there', 58, 60, 3, '2024-08-14 09:53:18', 'customer'),
(60, 'HI', 58, 60, 11, '2024-08-19 09:37:27', 'customer'),
(61, 'hi', 58, 60, 3, '2024-08-19 14:45:41', 'customer'),
(62, 'hi', 58, 60, 3, '2024-08-19 15:10:44', 'customer'),
(63, 'hi', 58, 60, 3, '2024-08-19 15:13:33', 'customer'),
(64, 'HI', 58, 60, 3, '2024-08-19 15:26:24', 'farmer'),
(65, 'hi', 58, 60, 3, '2024-08-19 15:31:14', 'farmer'),
(66, 'hi seller', 58, 62, 4, '2024-08-20 17:56:45', 'customer'),
(67, 'hi there', 58, 60, 3, '2024-08-21 07:48:59', 'customer'),
(68, 'yes how are you doin\r\n', 58, 60, 3, '2024-08-21 07:50:47', 'farmer');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_amount` float(4,2) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` float(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `description`, `price`, `category`, `user_id`) VALUES
(3, 'MCHELE', 'mchele super wa kyela na madibira', 21.00, 'product', 60),
(4, 'TRACTOR', 'best tractor in the world (John Deer)', 12500.00, 'tool', 62),
(5, 'MAJEMBE YA TREKTA', 'majembe bora kutoka ujerumani ', 7000.00, 'tool', 62),
(7, 'DRIED TOMATO', 'best dried tomato in the whole east and central africa', 1.00, 'product', 60),
(8, 'MAHINDI', 'mahindi mbegu ya chotara', 10.00, 'product', 60),
(9, 'VITUNGUU MAJI', 'vitunguu vya kienyeji', 17.00, 'product', 60),
(11, 'GARLIC', 'best garlic low price', 1.00, 'product', 60),
(12, 'MAEMBE', 'maembe ya tanga', 1.00, 'product', 60);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('customer','farmer','seller','administrator') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `registration_date`, `role`) VALUES
(23, 'secretadminmumumpepe', '', '$2y$10$DKB8S3prdCve518LgQ3PXulUJYMZ2IM0ThtndI32J2DrG/K8e9DTW', '2023-09-05 08:21:17', 'administrator'),
(58, 'mumumpepe', 'abinerykinwiko@gmail.com', '$2y$10$IIJJ91ha1EuQEE95CYia0ewbvC2N8D6OtsaNnAppCTbs3zFYI2QX2', '2024-07-29 07:39:16', 'customer'),
(60, 'farmer', 'farmer@gmail.com', '$2y$10$sJLpi9hF27qmWnfCvXFN/eEUsmvUXxsRhm3zlCy1jKQFnilT5Ze9q', '2024-07-29 09:29:08', 'farmer'),
(62, 'seller', 'kammbinginja@proton.me', '$2y$10$FUc0kdvC/EVqqk2V0KD5eOUrTqAkYP/GoXHZ1b.6Gp6c2eD2cBLpe', '2024-07-29 09:34:48', 'seller'),
(64, 'nobody', 'nobody@example.com', '$2y$10$rgn8zRa.1Krk4Ssk5Parh.OwpQNdzBmCDQBqwscgUxSMkEhhPp6Du', '2024-08-29 06:52:16', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD PRIMARY KEY (`reply_id`);

--
-- Indexes for table `forum_post`
--
ALTER TABLE `forum_post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `comment_replies`
--
ALTER TABLE `comment_replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_post`
--
ALTER TABLE `forum_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forum_post`
--
ALTER TABLE `forum_post`
  ADD CONSTRAINT `forum_post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
