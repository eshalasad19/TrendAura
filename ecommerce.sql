-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 24, 2026 at 03:08 PM
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
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `about_id` int(11) NOT NULL,
  `about_name` text NOT NULL,
  `about_desc` text NOT NULL,
  `about_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`about_id`, `about_name`, `about_desc`, `about_image`) VALUES
(1, 'Trendy fashion, premium quality, delivered with ease and care.', 'Trendy fashion, premium quality, delivered with ease and care.', '../image/about-us1.jpg'),
(2, 'We are TrendAura', 'Welcome to our classic women\'s clothing store, where we believe\r\nthat timeless  <br> style never goes out of fashion. Our collection features classic pieces that are both stylish and versatile.\r\n', '../image/about-us2.jfif'),
(3, 'Who we are.', 'We believe in a world where you have total freedom to be you, without judgement. To experiment. To express yourself. To be brave and grab life as the extraordinary adventure it is. So we make sure everyone has an equal chance to discover all the amazing things they’re capable of – no matter who they are, where they’re from or what looks they like to boss. We exist to give you the confidence to be whoever you want to be.', '../image/about-us3.jpg'),
(4, 'Our mission', 'Our mission is to empower people through sustainable fashion. We want everyone to look and feel good, while also doing our part to help the environment.We believe that fashion should be stylish, affordable and accessible to everyone. Body positivity and inclusivity are values that are at the heart of our brand.', '../image/about-us4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `user_id` int(100) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `product_name`, `product_price`, `product_img`, `product_quantity`, `total_price`, `user_id`, `product_id`) VALUES
(4, 'Green Graphic Tee ', 1290, '../image/t-shirt2.webp', 1, 1290, 32, 23),
(8, 'Mens Cannes Straight Fit Denim', 2499, '../image/jeans.webp', 1, 2499, 34, 24),
(14, 'Jupiter Luxury Self Weave Unisex Coo Ord Set', 4050, '../image/track.webp', 1, 4050, 38, 28);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_image`) VALUES
(2, 'Men', '../image/mens_clothing.jpg'),
(3, 'Women', '../image/womens_clothing.webp'),
(4, 'Accessories', '../image/womens_accesories.jpg'),
(5, 'Beauty', '../image/beauty.webp'),
(6, 'Kids', '../image/kids.jpg'),
(7, 'Shoes', '../image/shoes.jpg'),
(8, 'Bag', '../image/bag.jpg'),
(9, 'Fragrance', '../image/fragrances.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`id`, `heading`, `description`) VALUES
(1, 'Address:', 'Karachi, Pakistan'),
(2, 'Phone:', '+92 300 1234567'),
(3, 'Email:', 'trendaura@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderr`
--

CREATE TABLE `orderr` (
  `order_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `phone` int(11) NOT NULL,
  `orderdate` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `payment_method` varchar(30) NOT NULL DEFAULT 'COD',
  `payment_status` varchar(20) NOT NULL DEFAULT 'Unpaid',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderr`
--

INSERT INTO `orderr` (`order_id`, `username`, `address`, `city`, `email`, `phone`, `orderdate`, `status`, `payment_method`, `payment_status`, `updated_at`) VALUES
(30, 'Eshal Asad', 'H.No 494 Haji Fazal Town Naya Nazimabad Karachi', 'Karachi', 'eshalasad19@gmail.com', 2147483647, '2026-07-19', 'Delivered', 'COD', 'Unpaid', '2026-07-19 13:15:01'),
(31, 'Eshal Asad', 'H.No 494 Haji Fazal Town Naya Nazimabad Karachi', 'Karachi', 'eshalasad19@gmail.com', 2147483647, '2026-07-21', 'Cancelled', 'COD', 'Unpaid', '2026-07-21 05:22:27'),
(32, 'Eshal Asad', 'H.No 494 Haji Fazal Town Naya Nazimabad Karachi', 'Karachi', 'eshalasad19@gmail.com', 2147483647, '2026-07-21', 'Delivered', 'COD', 'Paid', '2026-07-21 05:37:28'),
(33, 'Eshal Asad', 'H.No 494 Haji Fazal Town Naya Nazimabad Karachi', 'Karachi', 'eshalasad19@gmail.com', 2147483647, '2026-07-21', 'Cancelled', 'COD', 'Unpaid', '2026-07-21 05:57:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`, `user_id`) VALUES
(16, 30, 22, 1, 990, 41),
(17, 31, 36, 1, 1990, 41),
(18, 32, 26, 1, 12700, 41),
(19, 33, 36, 1, 1990, 41);

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `history_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_status_history`
--

INSERT INTO `order_status_history` (`history_id`, `order_id`, `status`, `note`, `created_at`) VALUES
(1, 30, 'Pending', 'Order placed — payment method: COD', '2026-07-19 07:54:43'),
(2, 30, 'Processing', NULL, '2026-07-19 13:11:33'),
(3, 30, 'Delivered', NULL, '2026-07-19 13:15:01'),
(4, 31, 'Pending', 'Order placed — payment method: COD', '2026-07-21 05:22:03'),
(5, 31, 'Cancelled', 'Cancelled by customer', '2026-07-21 05:22:27'),
(6, 32, 'Pending', 'Order placed — payment method: COD', '2026-07-21 05:37:03'),
(7, 32, 'Delivered', NULL, '2026-07-21 05:37:28'),
(8, 33, 'Pending', 'Order placed — payment method: COD', '2026-07-21 05:56:59'),
(9, 33, 'Cancelled', 'Cancelled by customer', '2026-07-21 05:57:25');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` int(100) NOT NULL,
  `product_desc` varchar(255) NOT NULL,
  `stock` int(100) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_image`, `product_price`, `product_desc`, `stock`, `cat_id`, `sub_cat_id`) VALUES
(22, 'Egret White Pique Tee', '../image/t-shirt.webp', 990, 'T-shirt featuring crew neck with short sleeves, 100% Cotton Double Tuck Pique, the model height is 5ft 9in and wearing size is Medium.', 4, 2, 2),
(23, 'Green Graphic Tee ', '../image/t-shirt2.webp', 1290, 'T-shirt featuring crew neck with short sleeves, drop shoulder, 100% Cotton and the model height is 5’10 and wearing size is Medium.', 14, 2, 2),
(24, 'Mens Cannes Straight Fit Denim', '../image/jeans.webp', 2499, 'Crafted with a straight-leg cut, these jeans offer a balanced fit that sits comfortably at the waist and falls straight from hip to hem.', 0, 2, 3),
(25, 'GS Mens Distressed Straight Fit Denim', '../image/jeans2.webp', 2699, 'Crafted with a straight-leg cut, these jeans offer a balanced fit that sits comfortably at the waist and falls straight from hip to hem.', 10, 2, 3),
(26, ' Black Formal Moccassins Shoes', '../image/footwear.webp', 12700, 'Soft, supple, and undeniably stylish—our suede formal moccasins bring a touch of modern flair to classic refinement.', 8, 2, 4),
(27, 'Brown French Emporio Sandal', '../image/footwear2.webp', 7300, 'Mens footwear simple sandal easy to wear.', 9, 2, 4),
(28, 'Jupiter Luxury Self Weave Unisex Coo Ord Set', '../image/track.webp', 4050, 'Introducing the Jupiter Luxury Self Weave Unisex Co-Ord Set—a perfect blend of sophistication and comfort. Designed for those who appreciate premium quality and timeless style, this co-ord set is your go-to choice for any occasion.', 8, 2, 5),
(29, 'Jupiter Elite Unisex Hooded Black Coord Set', '../image/track2.webp', 3599, 'Stay stylish and comfortable with the Jupiter Elite Unisex Hooded Coord Set. Crafted from high-quality wooven fabric, this set offers durability and versatility. Perfect for both men and women, its the ideal choice for any casual occasion. Elevate your wa', 5, 2, 5),
(30, ' Black & Brown Mens Belt', '../image/belts.webp', 2990, 'Color: Black Brown', 8, 2, 6),
(31, '100% Original Leather Belt in Mahagony', '../image/belts1.webp', 2500, '100% Original Leather Belt in Mahagony is ideal for men who want something that works for both casual and office. ', 10, 2, 6),
(32, 'Brown Paisley Pattern Tie', '../image/tie.jpg', 1699, 'A sophisticated brown tie featuring an intricate paisley pattern in neutral tones, perfect for adding a refined touch to your formal or business attire.', 9, 2, 7),
(33, 'Red and Black Floral Pattern Tie', '../image/tie2.jpg', 1999, 'A bold red tie with a contemporary floral design, bringing an artistic touch to your professional or formal look.', 10, 2, 7),
(34, 'THE MAVERICK JACKET', '../image/jacket.webp', 11950, 'Jacket with sherpa collar, pockets that consist of a flap with snap button and zipper at the sides ,ribbed cuff and hem and zipper at front. This jacket has quilted lining.', 10, 2, 8),
(35, 'SEERSUCKER PUFFER JACKET', '../image/jacket2.webp', 13450, 'Puffer jacket with hood, elasticated cuffs, drawcord at hood and bottom hem and front zipper closure. Bone pockets at front.', 10, 2, 8),
(36, 'Textured Round Neck Blouse ', '../image/louse.webp', 1990, 'Textured round neck blouse with button fastening on front and cuff details on sleeves. Elastic trim detail at hem.', 9, 3, 9),
(37, 'Black And White Casual Shirt', '../image/louse2.webp', 1471, 'White Checkered Basic Yarn Dyed Top With Boat Neck, Elasticated Detail On Sleeves And Smocking Detail On Hem.', 10, 3, 9),
(38, 'Crew Neck Embroidered Tee', '../image/w-tshirt.webp', 999, 'Crew neck tee with short sleeves and embroidered artwork on front.', 9, 3, 10),
(39, 'Multi Knit T-Shirt', '../image/w-tshirt2.webp', 1050, 'Half Sleeves Crew Neck Printed T-Shirt ', 10, 3, 10),
(40, 'Black Pleated Skirt Crepe ', '../image/w-skirt.webp', 4510, 'Elevate your wardrobe with these versatile black pleated skirt, perfect for both casual and formal occasions. Designed with a modern fit.', 10, 3, 11),
(41, 'Jasper Charm - Silk Velvet Skirt ', '../image/w-skirt2.webp', 4400, 'This silk brown velvet skirt exudes effortless luxury and refined elegance. The rich, velvety texture creates a soft, sumptuous feel against the skin, while the deep brown hue adds warmth and sophistication to any ensemble.', 10, 3, 11),
(42, 'Wide Leg Pants', '../image/w-pat.jpg', 4990, 'Turn heads with these Wide Leg Trousers - perfect for any occasion! These Basic Wide Leg Pants offer a comfortable and stylish fit, made with high-quality cotton for a luxurious feel. Perfect for any fashion-forward individual looking to make a statement.', 10, 3, 12),
(43, 'Tailored Bell Bottom Pants', '../image/w-pat2.webp', 4549, ' regular fit and soft pleats for a refined touch, they deliver a modern fit that perfect for effortless, on trend dressing from day to night.', 10, 3, 12);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `name`, `email`, `password`, `profile_pic`, `phone`, `address`, `role_id`) VALUES
(16, 'Admin', 'admin@gmail.com', '$2y$10$O41/ec5E/9uRB/yiYBsvFut23Z4NCSZoEd6bSwY6Wx3zvYGsDjSBG', '../image/profile.svg', '030112345678', 'Naya Nazimabad', 1),
(41, 'Eshal Asad', 'eshalasad19@gmail.com', '$2y$10$U4JD5okkNni39wABQDwWcOqqvw7yKXHG5yHxQhELn.GZsqsk7FnzW', '../image/profile_photo_headshot.jpg', '03422829729', 'H.No 494 Haji Fazal Town Naya Nazimabad Karachi', 3);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(3, 'User'),
(5, 'Product Manager');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `title`, `description`, `image`) VALUES
(3, 'Glow Beauty', 'Unleash your true radiance with premium makeup essentials.', '../image/makeup-3081015_1920.jpg'),
(4, 'Timeless Style', 'Discover fashion that blends elegance, comfort, and confidence.', '../image/fashion-slideshow-11.jpg'),
(5, 'Step Ahead', 'Walk bold, stay stylish — comfort meets modern design.', '../image/blur-2178183_1920.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `sub_id` int(11) NOT NULL,
  `sub_name` varchar(100) NOT NULL,
  `sub_image` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`sub_id`, `sub_name`, `sub_image`, `category_id`) VALUES
(2, 'T-Shirts', '../image/mens-tshirts.jpg', 2),
(3, 'Jeans', '../image/mens_pants.webp', 2),
(4, 'Footwear', '../image/mens_shoes.jpg', 2),
(5, 'Tracksuit', '../image/track_suit.webp', 2),
(6, 'Belts', '../image/mens_belt.webp', 2),
(7, 'Ties', '../image/mens_tie.webp', 2),
(8, 'Jacket', '../image/mens_jackets.webp', 2),
(9, 'Blouse', '../image/women_blouse.webp', 3),
(10, 'T-Shirts', '../image/women_tshirt.webp', 3),
(11, 'Skirts', '../image/women_skirt.webp', 3),
(12, 'Pants', '../image/women_pant.webp', 3),
(13, 'Blazer', '../image/women_blazer.webp', 3),
(14, 'Shoes', '../image/women_shoes.webp', 3),
(15, 'Pajamas', '../image/women_pyjama.webp', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_message` (`user_id`);

--
-- Indexes for table `orderr`
--
ALTER TABLE `orderr`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `sub_cat_id` (`sub_cat_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `about_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orderr`
--
ALTER TABLE `orderr`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `fk_user_message` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orderr` (`order_id`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `order_item_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`sub_cat_id`) REFERENCES `sub_category` (`sub_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
