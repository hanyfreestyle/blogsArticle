-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2024 at 12:15 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_article`
--

--
-- Dumping data for table `page_photos`
--

INSERT INTO `page_photos` (`id`, `page_id`, `photo`, `photo_thum_1`, `photo_thum_2`, `position`, `print_photo`, `is_default`) VALUES
(2, 1, 'images/pages/1/فثسف-pAya3BO5aO.webp', 'images/pages/1/فثسف-SrNdaVObyf.webp', NULL, 0, 2, 0),
(3, 1, 'images/pages/1/فثسف-c1WrP2o48J.webp', 'images/pages/1/فثسف-R3uf427l49.webp', NULL, 0, 2, 0),
(4, 1, 'images/pages/1/فثسف-JncK829P6J.webp', 'images/pages/1/فثسف-ZJzEXVLxHV.webp', NULL, 0, 2, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
