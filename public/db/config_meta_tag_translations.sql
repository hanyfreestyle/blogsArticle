-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2024 at 01:42 AM
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
-- Dumping data for table `config_meta_tag_translations`
--

INSERT INTO `config_meta_tag_translations` (`id`, `meta_tag_id`, `locale`, `g_title`, `g_des`) VALUES
(1, 1, 'ar', 'مقالات', 'موقع مقالات'),
(2, 1, 'en', 'Real Estate Egypt | Egypt\'s #1 Real Estate Destination', 'Real Estate Egypt is the biggest real estate website in Egypt for compounds, resorts and commercial projects'),
(3, 2, 'ar', 'الاقسام', 'الاقسام'),
(4, 2, 'en', 'Developers | Real Estate Egypt', 'Developers Real Estate Egypt'),
(5, 3, 'ar', 'من نحن', 'من نحن'),
(6, 3, 'en', 'Blog | Real Estate Egypt', 'Blog Real Estate Egypt'),
(7, 4, 'ar', 'معايير تدقيق المحتوى', 'معايير تدقيق المحتوى'),
(8, 4, 'en', 'Contact Us | Real Estate Egypt | Egypt\'s #1 Real Estate Destination', 'Contact Us Real Estate Egypt is the biggest real estate website in Egypt for compounds, resorts and commercial projects'),
(9, 5, 'ar', 'كمبوندات مصر', 'كمبوندات مصر'),
(10, 5, 'en', 'Compounds', 'Compounds'),
(11, 6, 'ar', 'وحدات للبيع', 'وحدات للبيع'),
(12, 6, 'en', 'For Sale', 'For Sale'),
(13, 7, 'ar', 'عذرًا !! الصفحة التي تبحث عنها غير موجودة.', 'عذرًا !! الصفحة التي تبحث عنها غير موجودة.'),
(14, 7, 'en', 'Oops !! Page Not Found', 'Oops !! Page Not Found'),
(15, 8, 'ar', 'المشاريع والوحدات المفضلة', 'المشاريع والوحدات المفضلة'),
(16, 8, 'en', 'Favorite List', 'Favorite List');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
