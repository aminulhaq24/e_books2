-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2025 at 05:14 AM
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
-- Database: `ebook_system_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `soft_copy_file` varchar(255) DEFAULT NULL,
  `cd_available` enum('Yes','No') DEFAULT 'No',
  `price` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `format_type` enum('PDF','HARDCOPY','CD') DEFAULT 'HARDCOPY',
  `subscription_duration` int(11) DEFAULT 0,
  `cd_price` decimal(10,2) DEFAULT 0.00,
  `weight` decimal(5,2) DEFAULT 0.00,
  `delivery_charges` decimal(10,2) DEFAULT 0.00,
  `is_free_for_members` tinyint(1) DEFAULT 0,
  `is_competition_winner` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `category_id`, `subcategory_id`, `description`, `cover_image`, `pdf_file`, `soft_copy_file`, `cd_available`, `price`, `created_at`, `format_type`, `subscription_duration`, `cd_price`, `weight`, `delivery_charges`, `is_free_for_members`, `is_competition_winner`) VALUES
(4, 'Bang e dara', 'Allama Iqbal', 22, 18, 'This is one of the most popular poetry book in South Asia and the entire world as well.', '1765009231_metal wall13.webp', '1765009231_pq2.docx', '', 'Yes', 600, '2025-12-06 08:20:31', 'HARDCOPY', 0, 0.00, 0.00, 0.00, 0, 0),
(9, 'Our Fae Queen ', 'Traci Lovelot', 22, 21, 'When my magic suddenly  awakens and uninvited guests crash my birthday party, Fae warriors save me... and kidnap me. These irresistible Fae plan to whisk me away to their enchanted realm, a world that\'s fading without its queen — me. \"I almost got fired for reading this book... worth it!\" Meet all 5 of her fae consorts in this FREE reverse harem box set.', '1765822094_book1.jpg', '1765822094_book1.pdf', '', 'Yes', 1500, '2025-12-15 18:08:14', 'PDF', 0, 0.00, 0.40, 200.00, 1, 0),
(11, 'A Spy Inside the Castle', 'M.B. Courtenay', 22, 21, 'Intelligent, and haunt prescient, A Spy Inside the Castle explores the intersection of techno and truth in an age where perception is weaponized—and no one is beyond suspicion.\r\n', '1765823018_book2.jpg', '1765823018_book2_compressed.pdf', '', 'Yes', 2000, '2025-12-15 18:23:38', 'PDF', 1, 0.00, 0.60, 250.00, 1, 0),
(12, 'Trouble in Mudbug', 'Jana DeLeon', 22, 21, 'Scientist Maryse Robicheaux thought a lot of her problems had gone away with her mother-in-law’s death. The woman was rude, pushy and used her considerable wealth to run herd over the entire town of Mudbug, Louisiana. Unfortunately, death doesn’t slow down Helena one bit, and Agent Luc LeJeune’s arrival in town is yet another complication for Maryse.\r\n', '1765823395_boo3.jpg', '1765823395_book3_compressed.pdf', '', 'Yes', 0, '2025-12-15 18:29:55', 'PDF', 1, 200.00, 0.00, 200.00, 0, 0),
(13, 'The First Ride: The Real Story of Santa Claus', 'Gary Paul Bryant', 22, 21, 'Forget Kris Kringle,  Sinterklaas, and St. Nick—you’re  about to learn the real story. In the 1870s, on a quiet farm in rural Hopeville, Connecticut, the Clauses arrived to work for Max Pepin. Christmas has never been the  same since. Walk the trails, and wander the same woods where Santa Claus once lived.” Step into the past, join the adventure, and discover the true beginnings of Santa Claus.', '1765823779_book4.jpg', '1765823779_book2_compressed.pdf', '', 'No', 0, '2025-12-15 18:36:19', 'PDF', 3, 0.00, 0.00, 0.00, 1, 0),
(14, 'The in treasure Conspiracy', 'Bruce Hutchison', 22, 21, 'Did Heinrich Schliemann actually discover Helen of Troy’s famous golden necklace and the ancient Trojan treasure near the Dardanelles in Turkey in 1872? And, if he did, what did he do with it? Where is it now? When a friend of Clayton Lovell Stone is brutally murdered following the Trojan treasures’ trail, others after that treasure set a trap to stop Stone dead in his tracks.\r\n', '1765824356_book5.jpg', '1765824356_book3_compressed.pdf', '', 'No', 0, '2025-12-15 18:45:56', 'PDF', 1, 0.00, 0.00, 0.00, 1, 1),
(15, 'Not Forgiven', 'Shawn Raiford', 22, 21, 'Chloe, one of North America’s deadliest contract killers, can’t stop the massacre that erupts at a Houston café. Innocent people die—and now she wants blood for blood. As Inspectors Creed and Mason hunt what looks like a serial killer, Chloe tears through corrupt cops, gangs, and the hit squad that targeted her. Not Forgiven is a ruthless thriller of vengeance and chaos.\r\n', '1765824616_book6.jpg', '1765824616_book1.pdf', '', 'Yes', 890, '2025-12-15 18:50:16', 'PDF', 0, 250.00, 0.50, 240.00, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `book_id`, `quantity`, `added_at`) VALUES
(1, 4, 4, 10, '2025-12-14 12:44:27'),
(2, 4, 15, 8, '2025-12-16 08:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(22, 'E-books'),
(23, 'Competitions');

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE `competitions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `first_prize` varchar(255) DEFAULT NULL,
  `second_prize` varchar(100) DEFAULT NULL,
  `third_prize` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `max_participants` int(11) DEFAULT 100,
  `timer_duration` int(11) DEFAULT 0 COMMENT 'For essay: 3 hours in minutes (180)',
  `winner_user_id` int(11) DEFAULT NULL,
  `winner_announced_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competitions`
--

INSERT INTO `competitions` (`id`, `title`, `type`, `start_datetime`, `end_datetime`, `description`, `image`, `first_prize`, `second_prize`, `third_prize`, `created_at`, `max_participants`, `timer_duration`, `winner_user_id`, `winner_announced_date`) VALUES
(1, 'annual comp', 'Essay', '2025-12-10 12:30:00', '2025-12-22 12:30:00', 'sc fgfd ggf hjghj jy', NULL, '5000', '0', '0', '2025-12-02 07:09:41', 100, 0, NULL, NULL),
(3, 'ewre', 'Quiz', '2025-12-05 12:35:00', '2025-12-25 12:35:00', 'ghhg bhjb wdw pip xz lkl', NULL, '', '5000', '3000', '2025-12-02 07:36:29', 100, 0, NULL, NULL),
(4, 'weregtrt', 'Story Writing', '2025-12-05 12:38:00', '2025-12-28 12:38:00', 'dwad nh cxx uju ikol', NULL, '6000', '5000', '3000', '2025-12-02 07:38:45', 100, 0, NULL, NULL),
(13, 'jghj', 'Story Writing', '2025-01-06 18:34:00', '2025-02-27 18:34:00', 'gfdg hkhu cxf iu iohjo bbhj', NULL, '7888', '5666', '2334', '2025-12-02 13:35:24', 100, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `competition_rules`
--

CREATE TABLE `competition_rules` (
  `id` int(11) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `rule_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competition_rules`
--

INSERT INTO `competition_rules` (`id`, `competition_id`, `rule_text`, `created_at`) VALUES
(2, 13, '  mbkm jb jhbhjb vjv', '2025-12-07 18:36:56');

-- --------------------------------------------------------

--
-- Table structure for table `competition_submissions`
--

CREATE TABLE `competition_submissions` (
  `id` int(11) NOT NULL,
  `competition_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('received','shortlisted','winner','rejected') DEFAULT 'received',
  `start_time` datetime DEFAULT NULL COMMENT 'For essay: when user started',
  `end_time` datetime DEFAULT NULL COMMENT 'For essay: when user must submit by',
  `word_count` int(11) DEFAULT 0,
  `score` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `competition_winners`
--

CREATE TABLE `competition_winners` (
  `id` int(11) NOT NULL,
  `competition_id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `position` enum('1st','2nd','3rd') NOT NULL,
  `awarded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dealers`
--

CREATE TABLE `dealers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `order_type` enum('PDF','HARDCOPY','CD') DEFAULT 'HARDCOPY',
  `subscription_months` int(11) DEFAULT 0,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(10,2) DEFAULT NULL,
  `shipping_charges` decimal(10,2) DEFAULT 0.00,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('PENDING','PAID','FAILED','REFUNDED') DEFAULT 'PENDING',
  `status` enum('PENDING','CONFIRMED','PROCESSING','SHIPPED','DELIVERED','CANCELLED','REFUNDED') DEFAULT 'PENDING',
  `delivery_date` date NOT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `placed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `book_id`, `order_type`, `subscription_months`, `quantity`, `price`, `shipping_charges`, `total_amount`, `payment_method`, `payment_status`, `status`, `delivery_date`, `tracking_number`, `shipping_address`, `placed_at`) VALUES
(1, 4, NULL, 'HARDCOPY', 0, 3, 1800.00, 0.00, 1800.00, 'credit_card', 'PENDING', 'PENDING', '2025-12-21', NULL, 'fzf bhb kjnk, Faisalabad, Punjab, 75800, Pakistan', '2025-12-14 13:32:05'),
(2, 4, NULL, 'HARDCOPY', 0, 1, 600.00, 0.00, 600.00, 'credit_card', 'PENDING', 'PENDING', '2025-12-21', NULL, 'fzf bhb kjnk, Faisalabad, Punjab, 75800, Pakistan', '2025-12-14 13:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `format` enum('PDF','HARDCOPY','CD') DEFAULT 'HARDCOPY',
  `quantity` int(11) DEFAULT 1,
  `price` decimal(10,2) DEFAULT NULL,
  `subscription_months` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `book_id`, `format`, `quantity`, `price`, `subscription_months`) VALUES
(1, 1, 4, 'HARDCOPY', 3, 600.00, 0),
(2, 2, 4, 'HARDCOPY', 1, 600.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `method` varchar(100) DEFAULT NULL,
  `transaction_ref` varchar(255) DEFAULT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `user_id`, `paid_amount`, `method`, `transaction_ref`, `paid_at`) VALUES
(1, 1, 4, 1800.00, 'credit_card', NULL, '2025-12-14 13:32:05'),
(2, 2, 4, 600.00, 'credit_card', NULL, '2025-12-14 13:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `subcategory_name`) VALUES
(8, 22, 'Islamic'),
(9, 23, 'Upcoming'),
(11, 22, 'Novels & literature'),
(12, 22, 'Technology'),
(13, 22, 'Kids Learning'),
(14, 22, 'Business '),
(16, 22, 'Fiction'),
(17, 22, 'History'),
(18, 22, 'Poetry'),
(19, 22, 'Essay'),
(20, 22, 'Science'),
(21, 22, 'Biography'),
(22, 22, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin','dealer') DEFAULT 'user',
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `status`, `address`, `city`, `country`, `postal_code`, `profile_image`, `created_at`, `updated_at`) VALUES
(1, 'Amin ul haq', 'amin@gmail.com', NULL, '$2y$10$.JhboR52TZYViJdhrgAMFOtz7Ae3sROyJS3bnxXg.8P0teZVtMH0C', 'admin', 'active', 'metroville site karachi', NULL, NULL, NULL, NULL, '2025-11-29 08:08:04', '2025-12-13 19:00:02'),
(2, 'Affan Khan', 'affan@gmail.com', NULL, '$2y$10$19WIesJAt.ic8.Cpolvq/upobCX3RsOYw9iAvTdFl3AQ8dGkeoGGi', 'dealer', 'active', 'metroville site karachi', NULL, NULL, NULL, NULL, '2025-11-29 10:05:02', '2025-12-13 19:00:02'),
(3, 'Amin ul haq 45', 'amin45@gmail.com', '03216790876', '$2y$10$AuzIVAnXgE6itNy2fktBS.wVRoWYMrX40sHZk4VoYZojOHHFY.Aze', 'user', 'active', NULL, NULL, NULL, NULL, NULL, '2025-12-13 19:09:40', '2025-12-13 19:09:40'),
(4, 'Amin ullah', 'amin47@gmail.com', '03216790098', '$2y$10$6Rn8QCFZbbdmbVh7y2z4g.ISMAQaTVmUkttghYII1CbkbwK3y.3Pa', 'user', 'active', 'fzf bhb kjnk', NULL, NULL, NULL, NULL, '2025-12-13 19:24:39', '2025-12-16 17:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE `winners` (
  `id` int(11) NOT NULL,
  `competition_id` int(11) DEFAULT NULL,
  `submission_id` int(11) DEFAULT NULL,
  `prize` varchar(255) DEFAULT NULL,
  `announced_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart_item` (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competitions`
--
ALTER TABLE `competitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competition_rules`
--
ALTER TABLE `competition_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `competition_id` (`competition_id`);

--
-- Indexes for table `competition_submissions`
--
ALTER TABLE `competition_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `competition_id` (`competition_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `competition_winners`
--
ALTER TABLE `competition_winners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `competition_id` (`competition_id`),
  ADD KEY `submission_id` (`submission_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dealers`
--
ALTER TABLE `dealers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `fk_order_items_orders` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payments_ibfk_1` (`order_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `competition_id` (`competition_id`),
  ADD KEY `submission_id` (`submission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `competition_rules`
--
ALTER TABLE `competition_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `competition_submissions`
--
ALTER TABLE `competition_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `competition_winners`
--
ALTER TABLE `competition_winners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dealers`
--
ALTER TABLE `dealers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `winners`
--
ALTER TABLE `winners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `competition_rules`
--
ALTER TABLE `competition_rules`
  ADD CONSTRAINT `competition_rules_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competitions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `competition_submissions`
--
ALTER TABLE `competition_submissions`
  ADD CONSTRAINT `competition_submissions_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competitions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `competition_submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `competition_winners`
--
ALTER TABLE `competition_winners`
  ADD CONSTRAINT `competition_winners_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competitions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `competition_winners_ibfk_2` FOREIGN KEY (`submission_id`) REFERENCES `competition_submissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `competition_winners_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `winners`
--
ALTER TABLE `winners`
  ADD CONSTRAINT `winners_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competitions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `winners_ibfk_2` FOREIGN KEY (`submission_id`) REFERENCES `competition_submissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
