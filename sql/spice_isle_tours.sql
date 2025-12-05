-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 04:00 PM
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
-- Database: `spice_isle_tours`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `image`, `content`, `created_at`) VALUES
(1, 'Top 5 Hidden Gems in Grenada', 'hidden_gems.jpg', 'Discover the secret spots in Grenada that most tourists miss. From pristine beaches to charming local cafes, we take you off the beaten path!', '2025-12-04 13:20:35'),
(2, 'A Foodie\'s Guide to Grenadian Cuisine', 'grenadian_food.jpg', 'Grenada is a culinary paradise. Explore local flavors from spicy oil down to sweet nutmeg desserts. Here are our top picks!', '2025-12-04 13:20:35'),
(3, 'Why You Should Visit Grand Etang National Park', 'grand_etang.jpg', 'Experience the lush rainforest, waterfalls, and volcanic crater lake at Grand Etang. Perfect for hikers, nature lovers, and photographers!', '2025-12-04 13:20:35'),
(4, 'Top Beaches for Families in Grenada', 'family_beaches.jpg', 'Planning a family vacation? We\'ve rounded up the best beaches in Grenada that are kid-friendly, safe, and perfect for building sandcastles!', '2025-12-04 13:20:35'),
(5, 'A Day in St. George\'s: Must-See Attractions', 'st_georges.jpg', 'St. George\'s is the heart of Grenada. Explore colorful markets, historic forts, and charming streets in a single day adventure.', '2025-12-04 13:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `client_id`, `tour_id`) VALUES
(1, 1, 1),
(3, 2, 1),
(4, 2, 3),
(5, 2, 2),
(7, 3, 1),
(8, 3, 2),
(9, 3, 3),
(10, 4, 2),
(11, 4, 3),
(12, 4, 3),
(13, 4, 2),
(14, 4, 2),
(15, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `certification`
--

CREATE TABLE `certification` (
  `guide_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `date_certified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `user_id`) VALUES
(1, 'Test User', 'testuser@example.com', NULL),
(2, 'teleca', 'Queenb70@outlook.com', 3),
(3, 'teleca', 'teleca', NULL),
(4, 'admin', 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guide`
--

CREATE TABLE `guide` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_hire` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guide`
--

INSERT INTO `guide` (`id`, `name`, `address`, `date_hire`, `phone`) VALUES
(2, 'John Smith', NULL, NULL, '555-1234'),
(3, 'Mary Johnson', NULL, NULL, '555-5678'),
(4, 'David Lee', NULL, NULL, '555-9012'),
(5, 'Sarah Brown', NULL, NULL, '555-3456');

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

CREATE TABLE `guides` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `type`, `address`, `description`) VALUES
(1, 'Grand Anse Beach', 'Beach', 'Grand Anse', 'Beautiful sandy beach.'),
(2, 'Seven Sisters Falls', 'Waterfall', 'Rainforest', 'Scenic waterfall trail.'),
(3, 'Fort George', 'Historic', 'St. George\'s', 'Historic fort with views.');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'Teleca St Louis', 'Queenb70@outlook.com', 'test', 'test', 'unread', '2025-12-04 12:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `outing`
--

CREATE TABLE `outing` (
  `id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `guide_id` int(11) NOT NULL,
  `outing_datetime` datetime NOT NULL,
  `booking_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outing`
--

INSERT INTO `outing` (`id`, `tour_id`, `guide_id`, `outing_datetime`, `booking_id`) VALUES
(1, 3, 3, '2025-12-17 08:09:00', 9),
(2, 2, 4, '2025-12-08 08:15:00', 8),
(3, 1, 4, '2025-12-09 20:16:00', 7),
(4, 2, 4, '2025-12-11 19:16:00', 5),
(5, 3, 5, '2025-12-10 04:13:00', 4),
(6, 1, 2, '2025-12-12 06:15:00', 3),
(7, 1, 3, '2025-12-16 17:15:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `duration` int(11) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `title`, `duration`, `fee`, `image`, `created_at`) VALUES
(1, 'Grand Anse Beach Tour', 4, 50.00, 'Grand Anse Beach Tour.jpg', '2025-12-03 20:49:27'),
(2, 'Seven Sisters Waterfall Hike', 6, 75.00, 'Seven Sisters Waterfall Hike.jpg', '2025-12-03 20:49:27'),
(3, 'Fort George Historical Tour', 2, 40.00, 'Fort George Historical Tour.jpg', '2025-12-03 20:49:27');

-- --------------------------------------------------------

--
-- Table structure for table `tour_location`
--

CREATE TABLE `tour_location` (
  `tour_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `visit_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_location`
--

INSERT INTO `tour_location` (`tour_id`, `location_id`, `visit_order`) VALUES
(1, 1, 1),
(1, 2, 3),
(1, 3, 2),
(2, 2, 1),
(2, 3, 2),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`) VALUES
(1, 'admin', 'test@example.com', '$2y$10$i/.SuB6gB3TX8u6LiEWblOTmPbarwrvpfnb/TTz7rVTZ3qM7eLDY6'),
(2, 'qwerty', 'qwerty@mail.com', '$2y$10$tCWXKJ.Y27mlXNmy8LdcFekZWD8UNPR9e9Qjz4y0TAX16TsoUfS8y'),
(3, 'teleca', 'Queenb70@outlook.com', '$2y$10$VN6cEKY3bY78clEVEhvuZOAGD50KEoLiRrz8hR.SK9CPUecgy5BnO'),
(4, 'name', 'name@name.com', '$2y$10$r/w5/0o3oX4U1qZnBz8s/u4KR2vfQgrZbBe8i2WE8bpO8IjntFrxe'),
(5, 'admin', 'admin@example.com', '$2y$10$VdTq5b7f3FZPx9J0cqk3ROFAHJe4VjG.5U3ShZrcJY.M/PQh2UEi6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Indexes for table `certification`
--
ALTER TABLE `certification`
  ADD PRIMARY KEY (`guide_id`,`location_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `guide`
--
ALTER TABLE `guide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outing`
--
ALTER TABLE `outing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `guide_id` (`guide_id`),
  ADD KEY `fk_booking` (`booking_id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tour_location`
--
ALTER TABLE `tour_location`
  ADD PRIMARY KEY (`tour_id`,`location_id`),
  ADD KEY `location_id` (`location_id`);

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
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guide`
--
ALTER TABLE `guide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `guides`
--
ALTER TABLE `guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `outing`
--
ALTER TABLE `outing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certification`
--
ALTER TABLE `certification`
  ADD CONSTRAINT `certification_ibfk_1` FOREIGN KEY (`guide_id`) REFERENCES `guide` (`id`),
  ADD CONSTRAINT `certification_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`);

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `outing`
--
ALTER TABLE `outing`
  ADD CONSTRAINT `fk_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `outing_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`),
  ADD CONSTRAINT `outing_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `guide` (`id`);

--
-- Constraints for table `tour_location`
--
ALTER TABLE `tour_location`
  ADD CONSTRAINT `tour_location_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`),
  ADD CONSTRAINT `tour_location_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
