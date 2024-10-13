-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 08:36 PM
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
-- Database: `rent_n_repeat2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `revenue` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`, `revenue`) VALUES
(90000000, 'Fatin Israq Talha', 'israq@gmail.com', 'talha', 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(8) NOT NULL,
  `product_id` int(8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `product_id`, `created_at`, `user_id`) VALUES
(7, 124, '2024-10-09 16:00:46', 11000011);

-- --------------------------------------------------------

--
-- Table structure for table `lessee`
--

CREATE TABLE `lessee` (
  `user_id` int(8) NOT NULL,
  `nid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `password` varchar(300) NOT NULL,
  `profile_image` varchar(255) DEFAULT './uploads/default-pfp.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessee`
--

INSERT INTO `lessee` (`user_id`, `nid`, `name`, `email`, `contact_no`, `address`, `password`, `profile_image`) VALUES
(11000008, 1232352345, 'AAAA', 'a@gmail.com', '12342153245', 'asdfasdf', '$2y$10$veqZUc8JevrDJIMntBKjb.NaEcNp0F1.zsLAJclm68ATxWbOsgW8u', './uploads/default-pfp.jpg'),
(11000009, 1232354234, 'Sadekin Borno', 'borno@gmail.com', '0173452323', 'Noakhali', '$2y$10$H25prSLeJQUo//pWukWJiu4/9S6RT1tW3Wu6/AU6FjElR19Qi.ebi', 'uploads/3b6f51f02385de8d2fd7b5f14ac14f8d.jpg'),
(11000010, 2147483647, 'Fatin Israq Talha', 'talha@gmail.com', '0172341232', 'Sayednagar, Vatara, Dhaka', '$2y$10$XXL5EwAQPXkqGem83BhWJe158QQh.DYcVrEJkGrJHUBmiVBr6mL.i', './uploads/default-pfp.jpg'),
(11000011, 984932746, 'Muntasin  Hossain', 'shawtccho@gmail.com', '01987654321', 'Khanpur, Narayanganj', '$2y$10$42GtZi3q.N3A4C4IGUrt2O3Zuj1acdQJBU0PWRZBJhyqQ7m0GJ4sy', 'uploads/Screenshot (219).png');

-- --------------------------------------------------------

--
-- Table structure for table `lessor`
--

CREATE TABLE `lessor` (
  `user_id` int(8) NOT NULL,
  `nid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `password` varchar(300) NOT NULL,
  `profile_image` varchar(255) DEFAULT './uploads/default-pfp.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessor`
--

INSERT INTO `lessor` (`user_id`, `nid`, `name`, `email`, `contact_no`, `address`, `password`, `profile_image`) VALUES
(12000003, 1234567890, 'Ashraful Islam Asif', 'asif@gmail.com', '01656789957', '32, Kishoreganj', '$2y$10$AhXxg8YfN4Bct6ArLa2zGOnnxcV2xBSQEVFw.OgUhIvu7us4/D7FW', 'uploads/IMG_20240415_015356_728.jpg'),
(12000004, 2147483647, 'M Jahan Ena', 'ena@gmail.com', '01823925352', 'Narayanganj', '$2y$10$T5PoufMRO73/dVQnTPZH0.on7Drzh7kFNtx95gL5RKI1PGo2f6b6q', 'uploads/1726298917011.jpg'),
(12000005, 2147483647, 'Arwah Islam Unaisa', 'eusha@gmail.com', '01834523452', 'Alormela, Kishoreganj', '$2y$10$.ajWMjQd64VaAeZRd6n24e6H2BDwLUNPBU6ATr/1ai0edXc7unFCi', 'uploads/unnamed.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `transaction_id` int(8) NOT NULL,
  `lessee_id` int(8) NOT NULL,
  `lessor_id` int(8) NOT NULL,
  `admin_id` int(8) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `lessor_portion` decimal(10,2) DEFAULT NULL,
  `admin_portion` decimal(10,2) DEFAULT NULL,
  `is_damaged` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`transaction_id`, `lessee_id`, `lessor_id`, `admin_id`, `start_date`, `end_date`, `total_price`, `lessor_portion`, `admin_portion`, `is_damaged`) VALUES
(16, 11000010, 12000004, 90000000, '2024-10-07', '2024-10-07', 3.50, 2.80, 0.70, NULL),
(17, 11000009, 12000004, 90000000, '2024-10-07', '2024-10-07', 1.50, 1.20, 0.30, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(8) NOT NULL,
  `product_id` int(8) NOT NULL,
  `transaction_id` int(8) NOT NULL,
  `rental_days` int(11) NOT NULL,
  `price_per_item` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`detail_id`, `product_id`, `transaction_id`, `rental_days`, `price_per_item`) VALUES
(1, 121, 16, 1, 3.50),
(2, 119, 17, 1, 1.50);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(8) NOT NULL,
  `transaction_id` int(8) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `transaction_id`, `payment_date`, `amount`) VALUES
(1, 16, '2024-10-07 05:30:17', 3.50),
(2, 17, '2024-10-07 05:34:28', 1.50);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `user_id` int(8) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `size` varchar(2) NOT NULL,
  `fit` varchar(255) NOT NULL,
  `is_damaged` tinyint(1) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `product_description` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `user_id`, `product_name`, `product_type`, `size`, `fit`, `is_damaged`, `is_available`, `price_per_day`, `image_path`, `product_description`) VALUES
(118, 12000003, 'Mens Fusion Panjabi', 'Panjabi', 'L', '', 0, 1, 2.00, 'uploads/panjabi.jpg', ''),
(119, 12000004, 'Dress shoes', 'Formal shoes', '39', '', 0, 0, 1.50, 'uploads/LadiesShoe.png', ''),
(120, 12000004, 'Women\'s Cargo Pants - Cream color', 'Pants', '33', '', 0, 1, 2.50, 'uploads/0461_4911_676_of.png', ''),
(121, 12000004, 'Brown Classy Top', 'Top', 'M', '', 0, 0, 3.50, 'uploads/d08d2327978b4c5a41fa4281703e6d0d.png', ''),
(122, 12000005, 'Korean Dress', 'Dress', 'M', '', 0, 1, 1.50, 'uploads/9e8f1960bf721d0f5908c41a42a6bfd9.jpg', 'White classy Korean dress '),
(123, 12000005, 'High Heels', 'Shoes', '39', '', 0, 1, 1.00, 'uploads/b8c02de24848e9a708e2b4f321a451c0.jpg', 'Classy grey high heel shoes for parties'),
(124, 12000003, 'Black Shirt', 'shirt', 'M', '', 0, 1, 0.75, 'uploads/5b1fe7dbd57dfeaf7d26eaa0bff68221.jpg', 'Black formal shirt for men'),
(125, 12000003, 'Formal Shoes', 'shoes', '42', '', 0, 1, 1.00, 'uploads/05cff055131cc9cb354a232cf531c24b.jpg', 'Classy black formal shoes '),
(126, 12000003, 'Formal Pants', 'pants', '32', '', 0, 1, 1.20, 'uploads/bb3a70148a2ea32e3ead826cce81ac80.jpg', 'Black Formal Pants For men'),
(127, 12000003, 'Black Shirt', 'Shirt', 'L', '', 0, 1, 1.25, 'uploads/527e659ee34f87b923d279c46e987491.jpg_720x720q80.jpg', 'Semi-formal black shirt for men'),
(128, 12000003, 'Wedding guest panjabi', 'panjabi', '42', '', 0, 1, 0.75, 'uploads/a900d044-ccf1-451c-989d-f57887e88caa.jpg', 'Cream colored panjabi for weddings, and other occasions. ');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(8) NOT NULL,
  `product_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `review_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `product_id`, `user_id`, `rating`, `comment`, `review_date`) VALUES
(2, 120, 12000004, 5.0, '', '2024-10-07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `lessor_id` (`user_id`);

--
-- Indexes for table `lessee`
--
ALTER TABLE `lessee`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `lessor`
--
ALTER TABLE `lessor`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `lessor_id` (`lessee_id`),
  ADD KEY `lessee_id` (`lessor_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90000001;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lessee`
--
ALTER TABLE `lessee`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11000012;

--
-- AUTO_INCREMENT for table `lessor`
--
ALTER TABLE `lessor`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12000006;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `transaction_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `lessee` (`user_id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`lessee_id`) REFERENCES `lessee` (`user_id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`lessor_id`) REFERENCES `lessor` (`user_id`),
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `order` (`transaction_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `order` (`transaction_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `lessor` (`user_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `lessor` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
