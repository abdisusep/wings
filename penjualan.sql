-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 09:46 AM
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
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `user`, `password`) VALUES
(1, 'smit', 'e69a59fc3b9cf146b0080afaebce07aa'),
(2, 'susep', 'eabf460d61c787f50a641778fdf19aca');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_code` varchar(18) DEFAULT NULL,
  `product_name` varchar(30) DEFAULT NULL,
  `price` int(6) DEFAULT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `discount` int(6) DEFAULT NULL,
  `dimension` varchar(50) DEFAULT NULL,
  `unit` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_code`, `product_name`, `price`, `currency`, `discount`, `dimension`, `unit`) VALUES
(1, 'SKU001', 'So Klin Pewangi', 15000, 'IDR', 10, '13cm x 10cm', 'PCS'),
(2, 'SKU002', 'So Klin Pemutih', 10000, 'IDR', 0, '10cm x 10cm', 'PCS'),
(3, 'SKU003', 'Sampo Pantene', 2000, 'IDR', 0, '4 x 2', 'PCS'),
(4, 'SKU004', 'Sabun Mandi', 5000, 'IDR', 0, '5 x 5', 'PCS'),
(5, 'SKU005', 'Tisu', 20000, 'IDR', 0, '20 x 20', 'BOX'),
(6, 'SKU006', 'Sikat Gigi', 8000, 'IDR', 5, '4 x 5', 'PCS');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_detail`
--

CREATE TABLE `transaction_detail` (
  `id` int(11) NOT NULL,
  `transaction_header_id` int(11) NOT NULL,
  `document_code` varchar(3) DEFAULT NULL,
  `document_number` varchar(10) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `unit` varchar(5) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `currency` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_detail`
--

INSERT INTO `transaction_detail` (`id`, `transaction_header_id`, `document_code`, `document_number`, `product_id`, `price`, `quantity`, `unit`, `subtotal`, `currency`) VALUES
(1, 1, 'TRX', '1', 2, 10000, 1, 'PCS', 10000, 'IDR'),
(2, 1, 'TRX', '1', 1, 13500, 2, 'PCS', 27000, 'IDR'),
(3, 2, 'TRX', '2', 4, 5000, 1, 'PCS', 5000, 'IDR'),
(4, 2, 'TRX', '2', 5, 20000, 1, 'BOX', 20000, 'IDR'),
(5, 2, 'TRX', '2', 6, 7600, 2, 'PCS', 15200, 'IDR');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_header`
--

CREATE TABLE `transaction_header` (
  `id` int(11) NOT NULL,
  `document_code` varchar(3) DEFAULT NULL,
  `document_number` varchar(10) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_header`
--

INSERT INTO `transaction_header` (`id`, `document_code`, `document_number`, `user_id`, `total`, `date`) VALUES
(1, 'TRX', '1', 2, 37000, '2024-06-07'),
(2, 'TRX', '2', 1, 40200, '2024-06-07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_header`
--
ALTER TABLE `transaction_header`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction_header`
--
ALTER TABLE `transaction_header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
