-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2026 at 08:54 AM
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
-- Database: `wardrova_v1`
--
CREATE DATABASE IF NOT EXISTS `wardrova_v1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `wardrova_v1`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@test.com', '$2y$10$2xha7MIjzdaT.g.tycRIou8g.X1RZ8S9FSqqIRx/uRNYrHEIitPC6');

-- --------------------------------------------------------

--
-- Table structure for table `billing_details`
--

CREATE TABLE `billing_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `card_last4` varchar(4) NOT NULL,
  `expiry_month` varchar(2) NOT NULL,
  `expiry_year` varchar(4) NOT NULL,
  `billing_address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing_details`
--

INSERT INTO `billing_details` (`id`, `order_id`, `full_name`, `card_last4`, `expiry_month`, `expiry_year`, `billing_address`, `created_at`) VALUES
(1, 2, 'John Doe', '9012', '13', '2035', 'some random address', '2025-12-27 05:03:04');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `size`, `quantity`) VALUES
(11, 1, 2, 'XL', 3),
(13, 1, 4, 'L', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'men'),
(2, 'women'),
(3, 'boys'),
(4, 'girls');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `gst_amount` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'placed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `gst_amount`, `grand_total`, `status`, `created_at`) VALUES
(1, 2, 800.00, 0.00, 0.00, 'delivered', '2025-12-26 13:50:02'),
(2, 1, 600.00, 30.00, 630.00, 'shipped', '2025-12-27 05:03:04');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `size`, `quantity`, `price`) VALUES
(1, 1, 2, 'L', 1, 200.00),
(2, 1, 2, 'XL', 3, 200.00),
(3, 2, 2, 'XL', 3, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `created_at`) VALUES
(2, 1, 'Urban Edge Sweatshirt', 'Designed for modern streetwear lovers, the Urban Edge Sweatshirt features a bold yet minimal look. Soft fabric, ribbed cuffs, and a sleek silhouette make it ideal for casual outings.', 1200.00, '2025-12-22 18:00:10'),
(4, 1, 'Linen Comfort Kurta', 'Crafted from premium linen, this kurta delivers a lightweight feel with a classy silhouette. Perfect for summer festivities and elegant daytime events.', 1500.00, '2025-12-25 16:41:58'),
(5, 1, 'Classic Slim-Fit Shirt', 'Upgrade your everyday style with the Classic Slim-Fit Shirt, crafted for a sharp, modern look with all-day comfort. Made from premium breathable fabric, this shirt offers a smooth finish, excellent durability, and a tailored silhouette that complements both casual and semi-formal outfits.', 1500.00, '2025-12-28 17:59:39'),
(6, 1, 'Urban Flight Bomber Jacket – Olive Green', 'Upgrade your everyday style with the Urban Flight Bomber Jacket, designed for modern men who value comfort and clean aesthetics. Crafted from a premium polyester blend, this jacket offers a lightweight yet durable feel, making it perfect for all-day wear.', 2500.00, '2025-12-31 15:14:54'),
(7, 2, 'Women Casual Top', 'A lightweight cotton-blend top with a relaxed fit for everyday styling ease.', 2500.00, '2026-01-02 15:00:07'),
(8, 1, 'Men Sleeveless Jacket', 'A quilted sleeveless jacket designed for warmth without bulk, ideal for layering.', 1700.00, '2026-01-02 15:04:07'),
(9, 2, 'Women Skirt', 'A graceful chiffon skirt featuring elegant pleats and a flowing silhouette.', 1200.00, '2026-01-02 15:10:55'),
(10, 1, 'Men Trousers', 'Tailored trousers designed for a sharp fit and smooth finish, suitable for formal occasions.', 1600.00, '2026-01-02 15:22:30'),
(11, 3, 'Boys T-Shirt', 'A fun and comfortable cotton t-shirt designed for everyday play and activities.', 800.00, '2026-01-02 15:30:32'),
(12, 3, 'Boys Hoodie', 'A warm fleece hoodie that keeps kids cozy while staying stylish.', 900.00, '2026-01-02 15:41:04'),
(14, 3, 'Boys Denim Jeans', 'Durable stretch denim jeans designed for comfort and active lifestyles.', 900.00, '2026-01-04 01:35:39'),
(15, 3, 'Boys SweatShirt', 'A cozy fleece sweatshirt with playful prints for everyday wear.', 900.00, '2026-01-04 01:37:08'),
(16, 3, 'Boys Cargo Pants', 'Stylish cargo pants with utility pockets, perfect for casual and outdoor use.', 1500.00, '2026-01-04 01:37:54'),
(17, 3, 'Boys Sleeveless Tee', 'A breathable sleeveless tee designed for summer comfort and playtime.', 800.00, '2026-01-04 01:39:58'),
(18, 4, 'Girls Party Frock', 'A charming fit-and-flare frock with elegant fabric detailing for special occasions.', 1500.00, '2026-01-04 01:52:00'),
(19, 2, 'Women Shrug', 'A lightweight knit shrug ideal for layering over ethnic or western outfits.', 1200.00, '2026-01-04 01:59:00'),
(20, 2, 'Women Palazzo Pants', 'Breezy palazzo pants offering a loose fit and superior comfort for all-day wear.', 1500.00, '2026-01-04 02:13:48'),
(21, 2, 'Women Jump Suit', 'A one-piece cotton-blend jumpsuit that combines style, ease, and versatility.', 2100.00, '2026-01-04 06:22:56'),
(22, 2, 'Women Kurta', 'A minimalist linen kurta designed for comfort, breathability, and graceful ethnic wear.', 1800.00, '2026-01-04 06:30:43'),
(23, 4, 'Girls Top', 'A soft cotton top designed for daily comfort and easy styling.', 800.00, '2026-01-04 07:03:49'),
(24, 4, 'Girls Gown', 'A beautifully flared gown crafted for celebrations and festive moments.', 1000.00, '2026-01-04 12:24:38'),
(25, 4, 'Girls Jacket', 'A padded jacket designed to keep girls warm during chilly days.', 800.00, '2026-01-04 12:34:36'),
(26, 4, 'Girls Denim Jeggings', 'Stretchable denim jeggings offering the look of jeans with extra comfort.', 1500.00, '2026-01-04 12:47:56'),
(27, 4, 'Girls Casual Shorts', 'Lightweight cotton shorts designed for comfort, play, and summer outings.', 700.00, '2026-01-07 13:51:21'),
(28, 1, 'Men Jeans', 'Modern slim-fit jeans made from stretch denim for effortless movement and timeless style.', 1800.00, '2026-01-07 14:10:07'),
(29, 1, 'Men T-Shirt', 'A versatile navy t-shirt made from combed cotton, ideal for relaxed daily wear.', 2000.00, '2026-01-07 14:17:43'),
(30, 1, 'Men Hoodie', 'A cozy everyday hoodie crafted from soft cotton fleece, offering warmth, comfort, and a clean casual look.', 1500.00, '2026-01-07 14:30:56'),
(31, 1, 'Men Blazer', 'A lightweight linen-blend blazer that elevates everyday outfits with effortless sophistication.', 2800.00, '2026-01-07 14:49:47'),
(32, 2, 'Women Midi Dress', 'A flowy fit-and-flare midi dress that delivers elegance, comfort, and feminine charm.', 2000.00, '2026-01-07 15:12:49'),
(33, 2, 'Women T-Shirt', 'A soft oversized t-shirt with bold graphics for effortless street-style looks.', 1500.00, '2026-01-07 15:38:57'),
(34, 2, 'Women Sweatshirt', 'A cozy fleece sweatshirt with a relaxed oversized fit for laid-back days.', 1800.00, '2026-01-15 07:43:13'),
(35, 2, 'Women Blouse', 'A fitted silk-blend blouse designed to complement sarees and festive attire.', 2000.00, '2026-01-15 07:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`) VALUES
(28, 5, 'images/products/1767115257_shirt_front.png'),
(29, 5, 'images/products/1767115272_shirt_side.png'),
(30, 5, 'images/products/1767115281_shirt_back.png'),
(31, 4, 'images/products/1767193042_kurta_front.png'),
(32, 4, 'images/products/1767193063_kurta_side.png'),
(33, 4, 'images/products/1767193074_kurta_back.png'),
(34, 2, 'images/products/1767193102_sweatshirt_front.png'),
(35, 2, 'images/products/1767193121_sweatshirt_side.png'),
(36, 2, 'images/products/1767193139_sweatshirt_back.png'),
(37, 6, 'images/products/PROD_1767194094_bomber_front.png'),
(38, 6, 'images/products/1767194113_bomber_side.png'),
(39, 6, 'images/products/1767194125_bomber_back.png'),
(41, 7, 'images/products/PROD_1767366007_women_top_front.png'),
(42, 7, 'images/products/PROD_1767366007_women_top_side.png'),
(43, 7, 'images/products/1767366036_women_top_back.png'),
(45, 8, 'images/products/PROD_1767366247_sleeveless_jacket_front.png'),
(46, 8, 'images/products/PROD_1767366247_sleeveless_jacket_side.png'),
(47, 8, 'images/products/1767366274_sleeveless_jacket_back.png'),
(48, 9, 'images/products/PROD_1767366655_women_skirt.png'),
(49, 9, 'images/products/PROD_1767366655_women_skirt_b.png'),
(50, 9, 'images/products/PROD_1767366655_women_skirt_s.png'),
(52, 10, 'images/products/PROD_1767367350_trousers_front.png'),
(53, 10, 'images/products/PROD_1767367350_trousers_side.png'),
(54, 10, 'images/products/1767367371_trousers_back.png'),
(56, 11, 'images/products/PROD_1767367832_boy_tshirt_front.png'),
(57, 11, 'images/products/PROD_1767367832_boy_tshirt_side.png'),
(58, 11, 'images/products/1767367852_boy_tshirt_back.png'),
(60, 12, 'images/products/PROD_1767368464_boys_hoodie_front.png'),
(61, 12, 'images/products/PROD_1767368464_boys_hoodie_side.png'),
(62, 12, 'images/products/1767368486_boys_hoodie_back.png'),
(66, 14, 'images/products/PROD_1767490539_boys_denim_jeans.png'),
(67, 14, 'images/products/PROD_1767490539_boys_denim_jeans_b.png'),
(68, 14, 'images/products/PROD_1767490539_boys_denim_jeans_c.png'),
(69, 15, 'images/products/PROD_1767490628_boys_sweatshirt.png'),
(70, 15, 'images/products/PROD_1767490628_boys_sweatshirt_b.png'),
(71, 15, 'images/products/PROD_1767490628_boys_sweatshirt_c.png'),
(72, 16, 'images/products/PROD_1767490674_boys_cargo.png'),
(73, 16, 'images/products/PROD_1767490674_boys_cargo_b.png'),
(74, 16, 'images/products/PROD_1767490674_boys_cargo_c.png'),
(75, 17, 'images/products/PROD_1767490798_boys_sleeveless.png'),
(76, 17, 'images/products/PROD_1767490798_boys_sleeveless_b.png'),
(77, 17, 'images/products/PROD_1767490798_boys_sleeveless_c.png'),
(78, 18, 'images/products/PROD_1767491520_girls_party_frock.png'),
(79, 18, 'images/products/PROD_1767491520_girls_party_frock_b.png'),
(80, 18, 'images/products/PROD_1767491520_girls_party_frock_s.png'),
(81, 19, 'images/products/PROD_1767491940_women_shrug.png'),
(82, 19, 'images/products/PROD_1767491940_women_shrug_b.png'),
(83, 19, 'images/products/PROD_1767491940_women_shrug_c.png'),
(84, 20, 'images/products/PROD_1767492828_women_palazzo.png'),
(85, 20, 'images/products/PROD_1767492828_women_palazzo_b.png'),
(86, 20, 'images/products/PROD_1767492828_women_palazzo_c.png'),
(87, 21, 'images/products/PROD_1767507776_women_jumpsuit.png'),
(88, 21, 'images/products/PROD_1767507776_women_jumpsuit_b.png'),
(89, 21, 'images/products/PROD_1767507776_women_jumpsuit_c.png'),
(90, 22, 'images/products/PROD_1767508243_women_kurta.png'),
(91, 22, 'images/products/PROD_1767508243_women_kurta_b.png'),
(92, 22, 'images/products/PROD_1767508243_women_kurta_c.png'),
(93, 23, 'images/products/PROD_1767510229_girls_tshirt.png'),
(94, 23, 'images/products/PROD_1767510229_girls_tshirt_b.png'),
(95, 23, 'images/products/PROD_1767510229_girls_tshirt_c.png'),
(96, 24, 'images/products/PROD_1767529478_girls_gown.png'),
(97, 24, 'images/products/PROD_1767529478_girls_gown_b.png'),
(98, 24, 'images/products/PROD_1767529478_girls_gown_c.png'),
(99, 25, 'images/products/PROD_1767530076_girls_jacket.png'),
(100, 25, 'images/products/PROD_1767530076_girls_jacket_b.png'),
(101, 25, 'images/products/PROD_1767530076_girls_jacket_c.png'),
(102, 26, 'images/products/PROD_1767530876_girls_jeggings.png'),
(103, 26, 'images/products/PROD_1767530876_girls_jeggings_b.png'),
(104, 26, 'images/products/PROD_1767530876_girls_jeggings_c.png'),
(105, 27, 'images/products/PROD_1767793881_girls_shorts.png'),
(106, 27, 'images/products/PROD_1767793881_girls_shorts_b.png'),
(107, 27, 'images/products/PROD_1767793881_girls_shorts_c.png'),
(110, 28, 'images/products/PROD_1767795007_men_denim_jeans.png'),
(111, 28, 'images/products/1767795096_men_denim_jeans_b.png'),
(112, 28, 'images/products/1767795124_men_denim_jeans_c.png'),
(113, 29, 'images/products/PROD_1767795463_t_shirt.png'),
(114, 29, 'images/products/PROD_1767795463_t_shirt_b.png'),
(115, 29, 'images/products/PROD_1767795463_t_shirt_c.png'),
(116, 30, 'images/products/PROD_1767796256_hoodie.png'),
(117, 30, 'images/products/PROD_1767796256_hoodie_b.png'),
(118, 30, 'images/products/PROD_1767796256_hoodie_c.png'),
(119, 31, 'images/products/PROD_1767797387_blazer.png'),
(120, 31, 'images/products/PROD_1767797387_blazer_b.png'),
(121, 31, 'images/products/PROD_1767797387_blazer_c.png'),
(122, 32, 'images/products/PROD_1767798769_women_midi_dress.png'),
(123, 32, 'images/products/PROD_1767798769_women_midi_dress_b.png'),
(124, 32, 'images/products/PROD_1767798769_women_midi_dress_c.png'),
(125, 33, 'images/products/PROD_1767800337_women_t_shirt.png'),
(126, 33, 'images/products/PROD_1767800337_women_t_shirt_b.png'),
(127, 33, 'images/products/PROD_1767800337_women_t_shirt_c.png'),
(128, 34, 'images/products/PROD_1768462993_women_sweatshirt.png'),
(129, 34, 'images/products/PROD_1768462993_women_sweatshirt_b.png'),
(130, 34, 'images/products/PROD_1768462993_women_sweatshirt_c.png'),
(131, 35, 'images/products/PROD_1768463176_women_blouse.png'),
(132, 35, 'images/products/PROD_1768463176_women_blouse_b.png'),
(133, 35, 'images/products/PROD_1768463176_women_blouse_c.png');

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `size`, `stock`) VALUES
(97, 2, 'L', 14),
(98, 2, 'XL', 14),
(99, 2, 'XXL', 12),
(100, 6, 'L', 20),
(101, 6, 'XL', 20),
(102, 6, 'XXL', 20),
(103, 5, 'L', 10),
(104, 5, 'XL', 20),
(105, 5, 'XXL', 10),
(106, 4, 'L', 20),
(107, 4, 'XL', 20),
(108, 4, 'XXL', 20),
(171, 8, 'L', 20),
(172, 8, 'XL', 20),
(173, 8, 'XXL', 20),
(178, 19, 'M', 20),
(179, 19, 'L', 20),
(180, 19, 'XL', 20),
(181, 19, 'XXL', 20),
(182, 20, 'L', 20),
(183, 20, 'XL', 20),
(184, 20, 'XXL', 20),
(199, 28, 'L', 20),
(200, 28, 'XL', 20),
(201, 28, 'XXL', 20),
(202, 29, 'L', 20),
(203, 29, 'XL', 20),
(204, 29, 'XXL', 20),
(205, 10, 'L', 20),
(206, 10, 'XL', 20),
(207, 10, 'XXL', 20),
(211, 7, 'L', 20),
(212, 7, 'XL', 20),
(213, 7, 'XXL', 20),
(214, 9, 'L', 20),
(215, 9, 'XL', 20),
(216, 9, 'XXL', 20),
(217, 21, 'L', 20),
(218, 21, 'XL', 20),
(219, 21, 'XXL', 20),
(223, 30, 'L', 20),
(224, 30, 'XL', 20),
(225, 30, 'XXL', 20),
(226, 22, 'L', 20),
(227, 22, 'XL', 20),
(228, 22, 'XXL', 20),
(229, 11, 'S', 20),
(230, 11, 'M', 20),
(231, 11, 'L', 20),
(232, 12, 'S', 20),
(233, 12, 'M', 20),
(234, 12, 'L', 20),
(235, 14, 'S', 20),
(236, 14, 'M', 20),
(237, 15, 'S', 20),
(238, 15, 'M', 20),
(239, 16, 'S', 20),
(240, 16, 'M', 20),
(241, 17, 'S', 20),
(242, 17, 'M', 20),
(243, 31, 'L', 20),
(244, 31, 'XL', 20),
(245, 31, 'XXL', 20),
(246, 18, 'S', 20),
(247, 18, 'M', 20),
(248, 24, 'S', 20),
(249, 24, 'M', 20),
(250, 25, 'S', 20),
(251, 25, 'M', 20),
(252, 27, 'S', 20),
(253, 27, 'M', 20),
(254, 26, 'S', 20),
(255, 26, 'M', 20),
(256, 23, 'S', 20),
(257, 23, 'M', 20),
(258, 32, 'L', 20),
(259, 32, 'XL', 20),
(260, 32, 'XXL', 20),
(261, 33, 'L', 20),
(262, 33, 'XL', 20),
(263, 33, 'XXL', 20),
(264, 34, 'L', 20),
(265, 34, 'XL', 20),
(266, 34, 'XXL', 20),
(267, 35, 'L', 20),
(268, 35, 'XL', 20),
(269, 35, 'XXL', 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `password`) VALUES
(1, 'user123', 'One', 'userone@demo.com', '$2y$10$2xha7MIjzdaT.g.tycRIou8g.X1RZ8S9FSqqIRx/uRNYrHEIitPC6'),
(2, 'user', 'two', 'usertwo@demo.com', '$2y$10$.zAoKvVbi9/RE78S/NZ.A.3o2riQp53I6a25FX8/moz3Jg0euv3zK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_details`
--
ALTER TABLE `billing_details`
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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `billing_details`
--
ALTER TABLE `billing_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
