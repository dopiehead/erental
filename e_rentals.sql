-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 02, 2025 at 01:49 PM
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
-- Database: `e_rentals`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer_receipt`
--

CREATE TABLE `buyer_receipt` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date_added` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `seller_type` varchar(255) NOT NULL,
  `noofItem` int(11) NOT NULL,
  `buyer` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `date_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `category_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_image`, `category_type`) VALUES
(1, 'cars', 'assets/images/categories/tesla.png', ''),
(2, 'fashion', 'assets/images/categories/cloth.png', ''),
(3, 'conveyance', 'assets/images/categories/bicycle.jpeg', ''),
(4, 'cosmetics', 'assets/images/categories/lipgloss.png', ''),
(5, 'logistics', 'assets/images/categories/truck.png', ''),
(6, 'building_materials', 'assets/images/categories/building_materials.png', ''),
(7, 'kitchen_equipments', 'assets/images/categories/dish.png', ''),
(8, 'shoes_sneakers', 'assets/images/categories/sneakers.png', ''),
(9, 'hotel_products', 'assets/images/categories/hotel.png', ''),
(10, 'jewelleries', 'assets/images/categories/jewels.png', ''),
(11, 'apartments', 'assets/images/categories/plantation.png', ''),
(12, 'music_equipments', 'assets/images/categories/microphone.jpg', ''),
(13, 'airbnb', 'assets/images/categories/hotel.jpeg', ''),
(14, 'electronics', 'assets/images/categories/refrigerator.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` int(11) NOT NULL,
  `tracking_no` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` int(11) NOT NULL,
  `noofitem` int(11) NOT NULL,
  `buyer` int(11) NOT NULL,
  `seller` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `shipping_address` text NOT NULL,
  `lga` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pin_code` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `terms` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `id` int(11) NOT NULL,
  `mykey` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`id`, `mykey`) VALUES
(1, 'pk_test_7580449c6abedcd79dae9c1c08ff9058c6618351');

-- --------------------------------------------------------

--
-- Table structure for table `member_message`
--

CREATE TABLE `member_message` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `compose` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `compose` text NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `has_read` tinyint(11) NOT NULL,
  `is_sender_deleted` tinyint(11) NOT NULL,
  `is_receiver_deleted` tinyint(11) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `picx`
--

CREATE TABLE `picx` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `pictures` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `picx`
--

INSERT INTO `picx` (`id`, `sid`, `pictures`) VALUES
(1, 1, 'uploads/more/showroom1.png,uploads/more/showroom2.png,uploads/more/showroom3.png,uploads/more/showroom4.png');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `poster_id` int(11) NOT NULL,
  `poster_type` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_details` text NOT NULL,
  `product_category` varchar(255) NOT NULL,
  `product_condition` varchar(255) NOT NULL,
  `product_location` varchar(11) NOT NULL,
  `product_address` varchar(255) NOT NULL,
  `product_color` varchar(255) NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `gift_picks` tinyint(11) NOT NULL,
  `sold` tinyint(11) NOT NULL,
  `product_views` int(11) NOT NULL,
  `product_likes` int(11) NOT NULL,
  `product_rating` int(11) NOT NULL,
  `product_discount` int(11) NOT NULL,
  `featured_product` tinyint(11) NOT NULL,
  `date_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `poster_id`, `poster_type`, `product_name`, `product_price`, `product_image`, `product_details`, `product_category`, `product_condition`, `product_location`, `product_address`, `product_color`, `quantity_sold`, `product_quantity`, `gift_picks`, `sold`, `product_views`, `product_likes`, `product_rating`, `product_discount`, `featured_product`, `date_added`) VALUES
(1, 1, 'vendor', 'tesla', 150000, 'uploads/products/tesla.png', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'cars', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 42, 0, 0, 10, 0, 'jan 5, 2025'),
(2, 1, 'vendor', 'h/m', 15000, 'uploads/products/cloth.png', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'fashion', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 42, 0, 0, 10, 0, 'jan 5, 2025'),
(3, 1, 'vendor', 'yamaha', 50000, 'uploads/products/bicycle.jpeg', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'conveyance', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 54, 0, 0, 10, 0, 'jan 5, 2025'),
(4, 1, 'vendor', 'kylie_cosmetics', 150000, 'uploads/products/lipgloss.png', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'cosmetics', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 40, 0, 0, 10, 0, 'jan 5, 2025'),
(5, 1, 'vendor', 'benz', 15000, 'uploads/products/truck.png', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'logistics', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 40, 0, 0, 10, 0, 'jan 5, 2025'),
(6, 1, 'vendor', 'chixel', 50000, 'uploads/products/building_materials.png', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'building_materials', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 41, 0, 0, 10, 0, 'jan 5, 2025'),
(7, 1, 'vendor', 'refrigerator', 18000, 'uploads/products/dish.png', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'electronics', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 40, 0, 0, 10, 0, 'jan 5, 2025'),
(8, 1, 'vendor', 'sneakers', 120000, 'uploads/products/sneakers.png', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'shoes_sneakers', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 40, 0, 0, 10, 0, 'jan 5, 2025'),
(9, 1, 'vendor', 'airbnb', 15000, 'uploads/products/hotel.jpeg', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'apartments', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 40, 0, 0, 10, 0, 'jan 5, 2025'),
(10, 1, 'vendor', 'jewels', 25000, 'uploads/products/jewels.png', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'jewelleries', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 40, 0, 0, 10, 0, 'jan 5, 2025'),
(11, 1, 'vendor', 'tractor', 150000, 'uploads/products/kitchen.png', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'kitchen_equipments', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 42, 0, 0, 10, 0, 'jan 5, 2025'),
(12, 1, 'vendor', 'microphone', 1500, 'uploads/products/microphone.jpg', 'A product is any item or service offered for sale, typically to meet customer needs or solve a problem. It can be tangible, like electronics or clothing, or intangible, like software or consulting services. Products often have key attributes such as price, quality, category, and features that influence customer purchasing decisions. In e-commerce, product details like images, descriptions, ratings, and discounts help attract buyers and drive sales.', 'music_equipments', 'new', 'lagos', '24 iya street ikeja', '', 0, 20, 0, 0, 61, 0, 0, 10, 0, 'jan 5, 2025');

-- --------------------------------------------------------

--
-- Table structure for table `proof_of_identity`
--

CREATE TABLE `proof_of_identity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `passport` text NOT NULL,
  `valid_id` text NOT NULL,
  `date_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_comment`
--

CREATE TABLE `seller_comment` (
  `id` int(11) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_comment`
--

INSERT INTO `seller_comment` (`id`, `sender_email`, `sender_name`, `comment`, `product_name`, `date`) VALUES
(1, 'ngnimitech@gmail.com', 'neeyo', 'nice', 'charger', 'jan 5, 2025');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `pending` tinyint(11) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `sender_id`, `message`, `recipient_id`, `pending`, `date`) VALUES
(1, 1, 'hello', 1, 1, '11-3-2025 12:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_location` varchar(255) NOT NULL,
  `lga` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_rating` varchar(255) NOT NULL,
  `verified` tinyint(11) NOT NULL,
  `vkey` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `reset_token_expiry` varchar(255) NOT NULL,
  `date_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_name`, `user_email`, `user_password`, `user_type`, `user_image`, `user_phone`, `user_location`, `lga`, `user_address`, `user_rating`, `verified`, `vkey`, `reset_token`, `reset_token_expiry`, `date_added`) VALUES
(1, 'Neeyo', 'ngnimitech@gmail.com', '$2y$10$HGiVDPgxxDNG.l49vYKXBe8ZLHEbVC.lk0VTmsn3ey9DQt42JMfcW', 'Vendor', 'uploads/neeyo.png', '09074456453', 'Lagos', '', 'iyalla street, Ikeja Alausa', '0', 1, 'a5ec3ee7fd2cab423930471f709ed1a5', '9489a247b2fff01dde8dd4e915d4f5397ac9d1ec8ebd76aa98daad04da658242', '2025-01-31 20:30:44', '2025-01-31 16:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `verify_seller`
--

CREATE TABLE `verify_seller` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `valid_id` int(11) NOT NULL,
  `verified` tinyint(11) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer_receipt`
--
ALTER TABLE `buyer_receipt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_message`
--
ALTER TABLE `member_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picx`
--
ALTER TABLE `picx`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `proof_of_identity`
--
ALTER TABLE `proof_of_identity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_comment`
--
ALTER TABLE `seller_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verify_seller`
--
ALTER TABLE `verify_seller`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer_receipt`
--
ALTER TABLE `buyer_receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_message`
--
ALTER TABLE `member_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `picx`
--
ALTER TABLE `picx`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `proof_of_identity`
--
ALTER TABLE `proof_of_identity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_comment`
--
ALTER TABLE `seller_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `verify_seller`
--
ALTER TABLE `verify_seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
