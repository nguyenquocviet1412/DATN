-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 09, 2025 at 04:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datn`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `id_variant` bigint UNSIGNED DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `id_user`, `id_variant`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 9, 40, 3, '1661170.00', '2024-09-05 10:57:15', NULL),
(2, 5, 7, 2, '1731366.00', '2024-12-01 10:57:15', NULL),
(3, 8, 17, 4, '1456932.00', '2024-05-31 10:57:15', NULL),
(4, 2, 9, 4, '1453644.00', '2024-12-17 10:57:15', NULL),
(5, 3, 34, 1, '973638.00', '2024-07-22 10:57:15', NULL),
(6, 9, 19, 4, '1261283.00', '2025-02-07 10:57:15', NULL),
(7, 8, 41, 4, '585114.00', '2024-06-30 10:57:15', NULL),
(8, 9, 9, 3, '592779.00', '2024-04-28 10:57:15', NULL),
(9, 1, 18, 3, '154189.00', '2024-07-26 10:57:15', NULL),
(10, 5, 21, 5, '1556461.00', '2024-12-08 10:57:15', NULL),
(11, 6, 34, 2, '464781.00', '2024-03-03 10:57:15', NULL),
(12, 10, 24, 5, '1807173.00', '2024-08-03 10:57:15', NULL),
(13, 4, 32, 3, '728451.00', '2024-07-12 10:57:15', NULL),
(14, 3, 27, 3, '105881.00', '2024-11-21 10:57:15', NULL),
(15, 6, 12, 5, '1694867.00', '2024-10-09 10:57:15', NULL),
(16, 10, 37, 3, '1128648.00', '2025-01-16 10:57:15', NULL),
(17, 4, 44, 3, '500049.00', '2024-09-22 10:57:15', NULL),
(18, 1, 48, 1, '1268334.00', '2024-09-16 10:57:15', NULL),
(19, 6, 5, 5, '932112.00', '2024-03-23 10:57:15', NULL),
(20, 9, 48, 3, '1273700.00', '2024-12-11 10:57:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Boots', '2024-10-04 10:48:27', NULL, NULL),
(3, 'Casual Shoes', '2024-02-28 10:48:27', NULL, NULL),
(4, 'Formal Shoes', '2024-06-02 10:48:27', NULL, NULL),
(5, 'Running Shoes', '2024-06-01 10:48:27', NULL, NULL),
(6, 'dép', '2025-02-19 10:41:31', '2025-02-19 10:41:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Red', '2024-04-26 10:48:38', NULL, NULL),
(2, 'Blue', '2024-06-18 10:48:38', NULL, NULL),
(3, 'Black', '2024-09-22 10:48:38', NULL, NULL),
(4, 'White', '2025-01-07 10:48:38', NULL, NULL),
(5, 'Green', '2024-12-18 10:48:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `id_product` bigint UNSIGNED DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_hidden` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `id_user`, `id_product`, `note`, `is_hidden`, `created_at`, `updated_at`) VALUES
(1, 14, 48, 'Distinctio nulla autem distinctio suscipit et ipsa.', '1', '2025-02-07 20:04:17', '2025-03-04 10:08:19'),
(2, 3, 57, 'Consequatur dolores omnis aut maxime et et aspernatur.', NULL, '2025-01-07 07:16:16', NULL),
(3, 19, 56, 'Voluptates vel neque est vel facilis voluptatum nihil.', NULL, '2025-01-07 18:32:45', NULL),
(4, 5, 58, 'Magnam est culpa expedita deserunt illo aut.', NULL, '2025-02-01 21:12:43', NULL),
(5, 3, 45, 'Fugit voluptas dolore veniam in sint.', NULL, '2025-01-01 02:55:05', NULL),
(6, 3, 41, 'Est et deserunt qui minus culpa.', NULL, '2025-02-01 21:26:38', NULL),
(7, 18, 59, 'Iste quas velit qui.', NULL, '2025-02-15 02:53:50', NULL),
(8, 19, 55, 'Dolorem aut non quas.', NULL, '2025-01-05 21:52:02', NULL),
(9, 7, 44, 'Tempora ut optio aliquid non.', NULL, '2025-02-04 12:09:51', NULL),
(10, 17, 56, 'Distinctio asperiores non dolore officiis.', NULL, '2025-01-30 18:57:50', NULL),
(11, 10, 41, 'Sapiente voluptatum repudiandae et itaque sed ducimus tempore voluptatem.', NULL, '2025-02-06 13:22:36', NULL),
(12, 18, 44, 'Dignissimos consequatur velit est tenetur.', NULL, '2025-02-01 11:11:08', NULL),
(13, 18, 60, 'Nisi numquam nemo illo necessitatibus dignissimos.', NULL, '2025-01-09 20:32:08', NULL),
(14, 19, 43, 'Dignissimos vel magnam quia non similique.', NULL, '2025-01-21 21:40:14', NULL),
(15, 5, 56, 'Deleniti sed cum id blanditiis reiciendis dolore.', NULL, '2025-02-01 04:49:21', NULL),
(16, 17, 49, 'Animi ab laborum libero.', NULL, '2025-02-06 03:49:44', NULL),
(17, 11, 55, 'Laboriosam repudiandae praesentium reprehenderit et.', NULL, '2025-01-09 23:59:05', NULL),
(18, 8, 58, 'Quidem sunt nam laborum dolores quia corporis.', NULL, '2024-12-31 17:35:19', NULL),
(19, 8, 50, 'Ipsum qui impedit et quos quia quibusdam.', NULL, '2025-02-04 06:19:25', NULL),
(20, 20, 53, 'Et praesentium fugit voluptas.', NULL, '2025-01-31 00:48:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `username`, `password`, `role`, `fullname`, `email`, `phone`, `gender`, `date_of_birth`, `address`, `position`, `salary`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'ydong', '$2y$12$pmPMbt0H/.lnHLrSjWYV4O0H/RpQiVrfa2UYVfRve6Zdiia9gC4iy', 'staff', 'Bác. Sử Lực', 'moc.thy@example.net', '(0510)620-9834', 'Female', '2009-07-19', '260, Ấp Vượng Hiếu, Phường Hứa Chiêu Nhàn, Quận Lạc\nThừa Thiên Huế', 'Maintenance and Repair Worker', '28755195.00', 'active', NULL, '2025-01-20 08:16:48', '2025-03-04 10:14:49', '2025-03-04 10:14:49'),
(3, 'tmach', '$2y$12$ApIeuYouokdzV3.257FFSOXSB6Q9yG0YbweuISQ.714XdiXt6Ox8m', 'staff', 'Khưu Hải Minh', 'toai25@example.com', '(84)(8)3101-3239', 'Male', '2001-11-26', '18 Phố Nhiệm Định Khánh, Phường 2, Quận Cần My\nKon Tum', 'Signal Repairer OR Track Switch Repairer', '12526812.00', 'active', NULL, '2025-01-05 23:31:03', NULL, NULL),
(4, 'ha78', '$2y$12$vuJ10IzogDhp6v2Jh5Lyl.M3jhnubDOiNrli2Iqbkne/XvY1g1Pca', 'staff', 'Ngô Hiệp Liêm', 'bach47@example.org', '(04)3160-2449', 'Male', '1972-05-10', '793 Phố Nhâm Hiệp Huấn, Phường Bảo, Quận Thịnh Ngọc\nĐà Nẵng', 'Portable Power Tool Repairer', '20103371.00', 'active', NULL, '2025-01-08 06:58:06', NULL, NULL),
(5, 'btrung', '$2y$12$ndikz.CaZ78WBg2z7jQfc.zKHJWzYeTj6CSACBJhRKC7JD0O3YKt.', 'admin', 'Em. Lô Vinh', 'nhien.cat@example.org', '+84-39-354-0384', 'Male', '1994-12-10', '819 Phố Lô Diễm Ngọc, Ấp Đổng Minh, Quận 66\nĐồng Tháp', 'Gaming Dealer', '13310191.00', 'active', NULL, '2025-02-08 05:09:48', NULL, NULL),
(6, 'pdam', '$2y$12$uV2Ub7zC.h1XlfhP.jbf2OuOb15QkudfllwkQnPOyDtaiU.ai29YG', 'staff', 'Em. Hàng Quyền', 'xuan.nham@example.org', '058 228 7561', 'Male', '1999-07-30', '28, Thôn Hậu, Xã 39, Quận Thơ\nNinh Bình', 'Patternmaker', '18014956.00', 'active', NULL, '2025-01-02 09:11:55', NULL, NULL),
(7, 'hien.banh', '$2y$12$GDlhlUFf61r4cCl2lnFbzuSzzdKS9ZafnVLYzxDPVMzNQGTaoIHj2', 'staff', 'Ca Đan Nhật', 'nguyet40@example.org', '0210-232-2855', 'Male', '1982-09-14', '65 Phố Ân Lộc Bình, Xã 9, Huyện Dao\nQuảng Trị', 'Slot Key Person', '19127500.00', 'active', NULL, '2025-01-23 05:24:16', '2025-03-02 06:17:58', NULL),
(8, 'tu46', '$2y$12$/5AepT1nfbbbWbyJxrqW6OCTJf8IzBZeoBfbqyqZLlgBou1tMg4mu', 'staff', 'Bành Lan Điệp', 'loc.cu@example.org', '0219-389-5612', 'Female', '2017-04-02', '85 Phố Tiếp Lý Hiếu, Phường Nghiêm, Quận Bùi Hậu\nHồ Chí Minh', 'Psychiatric Aide', '11053458.00', 'active', NULL, '2025-02-11 21:04:49', NULL, NULL),
(9, 'nhu.trac', '$2y$12$7J0MgtJ4SNZcLmYjJfAgou5.HJNJpM/33mSvlLh1AIntvsHCyR88y', 'admin', 'Tống Tuyền', 'wcao@example.com', '(84)(231)656-4563', 'Female', '1992-10-29', '62, Ấp Thảo, Thôn Ty Phong, Huyện 32\nGia Lai', 'Athletes and Sports Competitor', '6216781.00', 'active', NULL, '2025-01-17 11:46:07', NULL, NULL),
(10, 'bphan', '$2y$12$e1ybzSY2zoim87OsyUSI8u1T63vC1siVQgs4r4GyL8zRu0c4QarIW', 'admin', 'Vừ Hồ Yến', 'admin@gmail.com', '+84-95-153-7264', 'Male', '1980-04-19', '7, Ấp Hà Diệu, Xã 1, Quận Ân Hiên\nHòa Bình', 'Bicycle Repairer', '13498435.00', 'active', NULL, '2025-01-06 19:11:27', NULL, NULL),
(11, 'hong.trang', '$2y$12$F9z0TG8gJJjfFe5Fd9heBOKYGyZIzoj6EuoId/S/CXsxeGPpf.uL.', 'admin', 'Khổng Điền', 'nguy.ngon@example.com', '+84-163-851-2132', 'Male', '1973-02-26', '8034 Phố Thập, Phường Ý Đường, Quận Mỹ\nBà Rịa - Vũng Tàu', 'Chemist', '19459259.00', 'active', NULL, '2025-01-18 15:53:17', NULL, NULL),
(12, 'truc86', '$2y$12$Pt9jMZNrOlbn3yWHUvih4eIDQDVYkkeVy3ZNQEahz0NaLMuOzw346', 'staff', 'Cự Cúc', 'an.quynh@example.org', '072-443-7285', 'Male', '2008-11-12', '617 Phố Lương, Xã 6, Quận Ẩn Hoa\nLong An', 'Communications Equipment Operator', '9184143.00', 'active', NULL, '2025-02-04 21:36:20', NULL, NULL),
(13, 'xninh', '$2y$12$PBglM1udKYTN/.TDXBavT.49NxQc8RrrGzLD4MFxbqiwC5zqHo14a', 'admin', 'Chị. Bế Việt Ngọc', 'hao.phung@example.net', '+84-126-017-5806', 'Male', '1984-08-06', '67 Phố Thịnh, Phường Phi, Huyện 96\nHà Nội', 'Manager Tactical Operations', '7609147.00', 'active', NULL, '2025-01-10 09:11:59', NULL, NULL),
(14, 'tan32', '$2y$12$06zkmc9PgzE7rmZUIN.PwOJen0q36SsjF9ZLUxMaYGvF8tQ.NOcR2', 'admin', 'Triệu Trầm Nương', 'tong.viet@example.com', '090 794 2993', 'Female', '1997-06-17', '5 Phố Anh, Thôn Ngân Đoàn, Huyện 20\nQuảng Ngãi', 'Carpenter Assembler and Repairer', '27033566.00', 'active', NULL, '2025-01-16 09:19:14', NULL, NULL),
(15, 'lo.nha', '$2y$12$l4PRzOUfXr/qzAwwdzC3M../5ePoQ3Fh1sfvyk9h5rBp5k8lKZl8O', 'admin', 'Hứa Lập Quý', 'si59@example.org', '0124-779-7676', 'Male', '1984-10-02', '268 Phố Triết, Phường Thời Thập, Huyện Hương Bồ\nLong An', 'Biophysicist', '28712980.00', 'active', NULL, '2025-02-05 06:03:07', NULL, NULL),
(16, 'tbo', '$2y$12$CRh9U6O4FsDAsY84661A7.GYAWJ3xuNbxvilI1Na62rHeamdh.5j6', 'staff', 'Chú. Chương Bằng Hạnh', 'phung58@example.com', '(0231) 185 5289', 'Female', '1976-03-08', '499, Ấp Đới Định Nhung, Xã 3, Quận 81\nHậu Giang', 'Plumber', '22308300.00', 'active', NULL, '2025-01-16 19:40:13', NULL, NULL),
(17, 'uvo', '$2y$12$OGMKQCJd/3f1ItJ839Fso.C81Sl7lXSbPLrV1CJoaZQ94cF3KifW.', 'admin', 'Bác. Viên Khê', 'rkhau@example.net', '0511 713 6416', 'Male', '2022-01-06', '7 Phố Thi Hoa Mi, Xã Dung, Quận 62\nNinh Bình', 'Music Composer', '18049258.00', 'active', NULL, '2025-02-03 12:32:36', NULL, NULL),
(18, 'au.nghi', '$2y$12$Ke7Aq.YxCwira9JrJ2kfj.tlWjwbhde4XDaNDVl4M17sTFikQ3Ubq', 'staff', 'Phi Vĩ', 'thuc.lam@example.net', '+84-74-019-3906', 'Male', '2019-12-04', '9 Phố Giả Hội Liêm, Phường 62, Huyện Cái\nSóc Trăng', 'Budget Analyst', '10829003.00', 'active', NULL, '2025-01-03 17:54:18', NULL, NULL),
(19, 'buong', '$2y$12$6Y1KdnbfINA.NAOYcPoGyO.2ST5YOFdIdxhdIU2lKq32gkdIakG2.', 'staff', 'Đôn Nhã Ly', 'qhang@example.net', '84-169-629-7225', 'Female', '2014-07-27', '47, Thôn Nhung Duyên, Xã 79, Quận Bửu Phong Vy\nBình Phước', 'Computer', '17355373.00', 'active', NULL, '2025-01-04 11:37:04', NULL, NULL),
(20, 'ntong', '$2y$12$FNJd2O1qyOh.KKhRiERzpuTZ55gogJjsKTB8bK26dVSVQkJf9xZ26', 'admin', 'Cô. Đào Sông Hoan', 'hdao@example.com', '0219-565-4453', 'Female', '2011-05-14', '6959 Phố Biện Hỷ Nga, Phường Diệp, Quận Hình Lễ Trác\nHồ Chí Minh', 'Infantry', '24552836.00', 'active', NULL, '2025-01-28 19:56:14', NULL, NULL),
(21, 'giangntph32755@fpt.edu.vn', '$2y$12$JUcPSEkhwRgdiBA64buuLOz2sDXIs6oAQSXobEo0JAtegUrwgEYrG', 'admin', 'Nguyễn Trường Giang', 'giangsunshinee@gmail.com', '0869311893', 'Male', '2004-06-13', 'Ha Noi', 'Dương Liễu', '8347237.00', 'active', NULL, '2025-02-27 19:04:30', '2025-02-27 19:04:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `id_product` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `id_user`, `id_product`, `created_at`, `updated_at`) VALUES
(1, 19, 56, '2025-01-22 13:29:07', NULL),
(2, 14, 53, '2025-01-19 19:37:04', NULL),
(3, 12, 44, '2025-02-09 14:20:53', NULL),
(4, 13, 49, '2025-01-15 23:03:23', NULL),
(5, 5, 49, '2025-01-01 21:44:28', NULL),
(6, 4, 43, '2025-01-31 04:46:57', NULL),
(7, 9, 59, '2025-01-10 15:32:49', NULL),
(8, 11, 59, '2025-02-05 03:33:57', NULL),
(9, 11, 59, '2025-01-17 20:17:57', NULL),
(10, 17, 55, '2025-01-10 11:56:16', NULL),
(11, 4, 53, '2025-01-06 12:09:45', NULL),
(12, 19, 50, '2025-02-09 17:54:50', NULL),
(13, 10, 53, '2025-01-22 11:43:50', NULL),
(14, 16, 59, '2025-01-26 02:02:54', NULL),
(15, 5, 58, '2025-01-27 08:43:27', NULL),
(16, 13, 48, '2025-01-16 00:17:07', NULL),
(17, 8, 50, '2025-01-10 21:19:23', NULL),
(18, 2, 56, '2025-02-15 08:30:58', NULL),
(19, 18, 56, '2025-01-30 02:20:56', NULL),
(20, 1, 53, '2025-01-31 05:29:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int NOT NULL,
  `id_employee` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `details` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `id_employee`, `action`, `ip_address`, `details`, `created_at`, `updated_at`) VALUES
(1, 10, 'hiển thị trang dashboard', '127.0.0.1', NULL, '2025-03-04 10:07:41', '2025-03-04 10:07:41'),
(2, 10, 'Vào trang hiển thị danh sách bình luận', '127.0.0.1', NULL, '2025-03-04 10:08:15', '2025-03-04 10:08:15'),
(3, 10, 'Vào trang hiển thị danh sách bình luận', '127.0.0.1', NULL, '2025-03-04 10:08:19', '2025-03-04 10:08:19'),
(4, 10, 'Vào trang hiển thị danh sách nhân viên', '127.0.0.1', NULL, '2025-03-04 10:11:50', '2025-03-04 10:11:50'),
(5, 10, 'Xóa nhân viên có id: 2', '127.0.0.1', NULL, '2025-03-04 10:14:49', '2025-03-04 10:14:49'),
(6, 10, 'Vào trang hiển thị danh sách nhân viên', '127.0.0.1', NULL, '2025-03-04 10:14:49', '2025-03-04 10:14:49'),
(7, 10, 'Vào trang hiển thị danh sách nhân viên', '127.0.0.1', NULL, '2025-03-04 10:14:54', '2025-03-04 10:14:54'),
(8, 10, 'Vào trang hiển thị danh sách đánh giá', '127.0.0.1', NULL, '2025-03-04 10:19:26', '2025-03-04 10:19:26'),
(9, 10, 'Xem chi tiết đánh giá sản phẩm có id: 41', '127.0.0.1', NULL, '2025-03-04 10:19:28', '2025-03-04 10:19:28'),
(10, 10, 'Vào trang hiển thị danh sách đánh giá', '127.0.0.1', NULL, '2025-03-04 10:19:31', '2025-03-04 10:19:31'),
(11, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-04 10:20:19', '2025-03-04 10:20:19'),
(12, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-04 10:20:24', '2025-03-04 10:20:24'),
(13, 10, 'Vào trang hiển thị danh sách nhân viên', '127.0.0.1', NULL, '2025-03-04 10:20:25', '2025-03-04 10:20:25'),
(14, 10, 'Vào trang hiển thị danh sách nhân viên', '127.0.0.1', NULL, '2025-03-04 10:20:31', '2025-03-04 10:20:31'),
(15, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-04 10:22:44', '2025-03-04 10:22:44'),
(16, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-04 10:24:59', '2025-03-04 10:24:59'),
(17, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-04 10:25:01', '2025-03-04 10:25:01'),
(18, 10, 'Vào trang thêm biến thể cho sản phẩm có ID: 41', '127.0.0.1', NULL, '2025-03-04 10:25:39', '2025-03-04 10:25:39'),
(19, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-04 10:25:47', '2025-03-04 10:25:47'),
(20, 10, 'đăng nhập vào hệ thống', '127.0.0.1', NULL, '2025-03-06 09:44:46', '2025-03-06 09:44:46'),
(21, 10, 'hiển thị trang dashboard', '127.0.0.1', NULL, '2025-03-06 09:44:46', '2025-03-06 09:44:46'),
(22, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 09:44:51', '2025-03-06 09:44:51'),
(23, 10, 'Vào trang tạo mới tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 09:44:56', '2025-03-06 09:44:56'),
(24, 10, 'Tạo mới tài khoản người dùng có id: 22', '127.0.0.1', NULL, '2025-03-06 09:46:02', '2025-03-06 09:46:02'),
(25, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 09:46:02', '2025-03-06 09:46:02'),
(26, 10, 'Xem chi tiết tài khoản người dùng có id: 1', '127.0.0.1', NULL, '2025-03-06 09:47:18', '2025-03-06 09:47:18'),
(27, 10, 'Xem chi tiết tài khoản người dùng có id: 19', '127.0.0.1', NULL, '2025-03-06 09:47:45', '2025-03-06 09:47:45'),
(28, 10, 'Xem chi tiết tài khoản người dùng có id: 20', '127.0.0.1', NULL, '2025-03-06 09:47:48', '2025-03-06 09:47:48'),
(29, 10, 'Vào trang tạo mới tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 09:48:17', '2025-03-06 09:48:17'),
(30, 10, 'Tạo mới tài khoản người dùng có id: 23', '127.0.0.1', NULL, '2025-03-06 09:48:31', '2025-03-06 09:48:31'),
(31, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 09:48:32', '2025-03-06 09:48:32'),
(32, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 09:49:12', '2025-03-06 09:49:12'),
(33, 10, 'Xem chi tiết tài khoản người dùng có id: 20', '127.0.0.1', NULL, '2025-03-06 09:49:15', '2025-03-06 09:49:15'),
(34, 10, 'Xem chi tiết tài khoản người dùng có id: 20', '127.0.0.1', NULL, '2025-03-06 09:49:25', '2025-03-06 09:49:25'),
(35, 10, 'Xem chi tiết tài khoản người dùng có id: 19', '127.0.0.1', NULL, '2025-03-06 09:49:48', '2025-03-06 09:49:48'),
(36, 10, 'Xem chi tiết tài khoản người dùng có id: 16', '127.0.0.1', NULL, '2025-03-06 09:49:50', '2025-03-06 09:49:50'),
(37, 10, 'Vào trang tạo mới tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 09:54:26', '2025-03-06 09:54:26'),
(38, 10, 'Vào trang tạo mới tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 09:54:41', '2025-03-06 09:54:41'),
(39, 10, 'Tạo mới tài khoản người dùng có id: 24', '127.0.0.1', NULL, '2025-03-06 09:55:09', '2025-03-06 09:55:09'),
(40, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 09:55:10', '2025-03-06 09:55:10'),
(41, 10, 'Xem chi tiết tài khoản người dùng có id: 12', '127.0.0.1', NULL, '2025-03-06 09:55:25', '2025-03-06 09:55:25'),
(42, 10, 'Xem chi tiết tài khoản người dùng có id: 12', '127.0.0.1', NULL, '2025-03-06 09:55:38', '2025-03-06 09:55:38'),
(43, 10, 'Xem chi tiết tài khoản người dùng có id: 12', '127.0.0.1', NULL, '2025-03-06 09:59:15', '2025-03-06 09:59:15'),
(44, 10, 'Xem chi tiết tài khoản người dùng có id: 12', '127.0.0.1', NULL, '2025-03-06 10:00:28', '2025-03-06 10:00:28'),
(45, 10, 'Xem chi tiết tài khoản người dùng có id: 12', '127.0.0.1', NULL, '2025-03-06 10:02:25', '2025-03-06 10:02:25'),
(46, 10, 'Xem chi tiết tài khoản người dùng có id: 12', '127.0.0.1', NULL, '2025-03-06 10:02:40', '2025-03-06 10:02:40'),
(47, 10, 'Xem chi tiết tài khoản người dùng có id: 1', '127.0.0.1', NULL, '2025-03-06 10:03:19', '2025-03-06 10:03:19'),
(48, 10, 'Xem chi tiết tài khoản người dùng có id: 1', '127.0.0.1', NULL, '2025-03-06 10:03:58', '2025-03-06 10:03:58'),
(49, 10, 'Xem chi tiết tài khoản người dùng có id: 2', '127.0.0.1', NULL, '2025-03-06 10:04:01', '2025-03-06 10:04:01'),
(50, 10, 'Xem chi tiết tài khoản người dùng có id: 3', '127.0.0.1', NULL, '2025-03-06 10:04:03', '2025-03-06 10:04:03'),
(51, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:09:04', '2025-03-06 10:09:04'),
(52, 10, 'Xem chi tiết tài khoản người dùng có id: 1', '127.0.0.1', NULL, '2025-03-06 10:09:06', '2025-03-06 10:09:06'),
(53, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:09:25', '2025-03-06 10:09:25'),
(54, 10, 'Xem chi tiết tài khoản người dùng có id: 2', '127.0.0.1', NULL, '2025-03-06 10:09:26', '2025-03-06 10:09:26'),
(55, 10, 'Xem chi tiết tài khoản người dùng có id: 15', '127.0.0.1', NULL, '2025-03-06 10:09:30', '2025-03-06 10:09:30'),
(56, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:09:32', '2025-03-06 10:09:32'),
(57, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:09:34', '2025-03-06 10:09:34'),
(58, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:09:38', '2025-03-06 10:09:38'),
(59, 10, 'Xem chi tiết tài khoản người dùng có id: 10', '127.0.0.1', NULL, '2025-03-06 10:09:42', '2025-03-06 10:09:42'),
(60, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:09:45', '2025-03-06 10:09:45'),
(61, 10, 'Xem chi tiết tài khoản người dùng có id: 11', '127.0.0.1', NULL, '2025-03-06 10:09:47', '2025-03-06 10:09:47'),
(62, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:09:49', '2025-03-06 10:09:49'),
(63, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:11:18', '2025-03-06 10:11:18'),
(64, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:11:24', '2025-03-06 10:11:24'),
(65, 10, 'Xem chi tiết tài khoản người dùng có id: 16', '127.0.0.1', NULL, '2025-03-06 10:11:33', '2025-03-06 10:11:33'),
(66, 10, 'Xem chi tiết tài khoản người dùng có id: 24', '127.0.0.1', NULL, '2025-03-06 10:11:36', '2025-03-06 10:11:36'),
(67, NULL, 'đăng xuất khỏi hệ thống', '127.0.0.1', NULL, '2025-03-06 10:14:25', '2025-03-06 10:14:25'),
(68, 10, 'đăng nhập vào hệ thống', '127.0.0.1', NULL, '2025-03-06 10:16:13', '2025-03-06 10:16:13'),
(69, 10, 'hiển thị trang dashboard', '127.0.0.1', NULL, '2025-03-06 10:16:13', '2025-03-06 10:16:13'),
(70, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:16:18', '2025-03-06 10:16:18'),
(71, 10, 'Xem chi tiết tài khoản người dùng có id: 24', '127.0.0.1', NULL, '2025-03-06 10:16:20', '2025-03-06 10:16:20'),
(72, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:16:29', '2025-03-06 10:16:29'),
(73, 10, 'Xem chi tiết tài khoản người dùng có id: 15', '127.0.0.1', NULL, '2025-03-06 10:16:32', '2025-03-06 10:16:32'),
(74, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:16:35', '2025-03-06 10:16:35'),
(75, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:16:39', '2025-03-06 10:16:39'),
(76, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:16:45', '2025-03-06 10:16:45'),
(77, 10, 'Xem chi tiết tài khoản người dùng có id: 23', '127.0.0.1', NULL, '2025-03-06 10:17:11', '2025-03-06 10:17:11'),
(78, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-06 10:17:14', '2025-03-06 10:17:14'),
(79, 10, 'đăng nhập vào hệ thống', '127.0.0.1', NULL, '2025-03-08 07:05:25', '2025-03-08 07:05:25'),
(80, 10, 'hiển thị trang dashboard', '127.0.0.1', NULL, '2025-03-08 07:05:25', '2025-03-08 07:05:25'),
(81, 10, 'hiển thị trang dashboard', '127.0.0.1', NULL, '2025-03-08 07:05:41', '2025-03-08 07:05:41'),
(82, 10, 'Vào trang danh sách danh mục', '127.0.0.1', NULL, '2025-03-08 07:05:42', '2025-03-08 07:05:42'),
(83, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 08:32:05', '2025-03-08 08:32:05'),
(84, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 08:32:11', '2025-03-08 08:32:11'),
(85, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 08:32:14', '2025-03-08 08:32:14'),
(86, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 08:38:56', '2025-03-08 08:38:56'),
(87, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 08:39:07', '2025-03-08 08:39:07'),
(88, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 08:39:26', '2025-03-08 08:39:26'),
(89, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 08:40:30', '2025-03-08 08:40:30'),
(90, 10, 'Vào trang sửa sản phẩm: 42', '127.0.0.1', NULL, '2025-03-08 08:40:33', '2025-03-08 08:40:33'),
(91, 10, 'Vào trang sửa sản phẩm: 42', '127.0.0.1', NULL, '2025-03-08 08:49:09', '2025-03-08 08:49:09'),
(92, 10, 'Vào trang sửa sản phẩm: 42', '127.0.0.1', NULL, '2025-03-08 08:58:04', '2025-03-08 08:58:04'),
(93, 10, 'Vào trang sửa sản phẩm: 42', '127.0.0.1', NULL, '2025-03-08 09:06:19', '2025-03-08 09:06:19'),
(94, 10, 'Vào trang sửa sản phẩm: 42', '127.0.0.1', NULL, '2025-03-08 09:06:32', '2025-03-08 09:06:32'),
(95, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 09:06:42', '2025-03-08 09:06:42'),
(96, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 09:06:43', '2025-03-08 09:06:43'),
(97, 10, 'Vào trang sửa sản phẩm: 67', '127.0.0.1', NULL, '2025-03-08 09:06:50', '2025-03-08 09:06:50'),
(98, 10, 'Xóa biến thể có ID: 137 của sản phẩm có ID: 67', '127.0.0.1', NULL, '2025-03-08 09:06:53', '2025-03-08 09:06:53'),
(99, 10, 'Vào trang sửa sản phẩm: 67', '127.0.0.1', NULL, '2025-03-08 09:06:53', '2025-03-08 09:06:53'),
(100, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 09:06:55', '2025-03-08 09:06:55'),
(101, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 09:06:57', '2025-03-08 09:06:57'),
(102, 10, 'Xóa ảnh biến thể có ID: 1', '127.0.0.1', NULL, '2025-03-08 09:07:01', '2025-03-08 09:07:01'),
(103, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 09:07:01', '2025-03-08 09:07:01'),
(104, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 09:07:29', '2025-03-08 09:07:29'),
(105, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 09:08:09', '2025-03-08 09:08:09'),
(106, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 09:11:17', '2025-03-08 09:11:17'),
(107, 10, 'Xóa ảnh biến thể có ID: 1', '127.0.0.1', NULL, '2025-03-08 09:16:59', '2025-03-08 09:16:59'),
(108, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 09:17:00', '2025-03-08 09:17:00'),
(109, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:02:20', '2025-03-08 10:02:20'),
(110, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:02:50', '2025-03-08 10:02:50'),
(111, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 10:04:02', '2025-03-08 10:04:02'),
(112, 10, 'Vào trang sửa sản phẩm: 42', '127.0.0.1', NULL, '2025-03-08 10:04:05', '2025-03-08 10:04:05'),
(113, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 10:04:09', '2025-03-08 10:04:09'),
(114, 10, 'Vào trang sửa sản phẩm: 50', '127.0.0.1', NULL, '2025-03-08 10:04:11', '2025-03-08 10:04:11'),
(115, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 10:04:14', '2025-03-08 10:04:14'),
(116, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 10:04:23', '2025-03-08 10:04:23'),
(117, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:04:25', '2025-03-08 10:04:25'),
(118, 10, 'Vào trang chỉnh sửa biến thể có ID: 1', '127.0.0.1', NULL, '2025-03-08 10:06:47', '2025-03-08 10:06:47'),
(119, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:06:54', '2025-03-08 10:06:54'),
(120, 10, 'Vào trang chỉnh sửa biến thể có ID: 1', '127.0.0.1', NULL, '2025-03-08 10:07:01', '2025-03-08 10:07:01'),
(121, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:07:07', '2025-03-08 10:07:07'),
(122, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:09:01', '2025-03-08 10:09:01'),
(123, 10, 'Xóa ảnh biến thể có ID: 2', '127.0.0.1', NULL, '2025-03-08 10:10:20', '2025-03-08 10:10:20'),
(124, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:10:20', '2025-03-08 10:10:20'),
(125, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:13:34', '2025-03-08 10:13:34'),
(126, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:21:16', '2025-03-08 10:21:16'),
(127, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:23:15', '2025-03-08 10:23:15'),
(128, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:23:38', '2025-03-08 10:23:38'),
(129, 10, 'Vào trang sửa sản phẩm: 41', '127.0.0.1', NULL, '2025-03-08 10:23:55', '2025-03-08 10:23:55'),
(130, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 10:28:19', '2025-03-08 10:28:19'),
(131, 10, 'Vào trang thêm sản phẩm', '127.0.0.1', NULL, '2025-03-08 10:28:20', '2025-03-08 10:28:20'),
(132, 10, 'Vào trang thêm sản phẩm', '127.0.0.1', NULL, '2025-03-08 10:28:37', '2025-03-08 10:28:37'),
(133, 10, 'Vào trang thêm sản phẩm', '127.0.0.1', NULL, '2025-03-08 10:28:46', '2025-03-08 10:28:46'),
(134, 10, 'Vào trang thêm sản phẩm', '127.0.0.1', NULL, '2025-03-08 10:30:43', '2025-03-08 10:30:43'),
(135, 10, 'Vào trang danh sách danh mục', '127.0.0.1', NULL, '2025-03-08 10:32:37', '2025-03-08 10:32:37'),
(136, 10, 'Vào trang hiển thị danh sách tài khoản người dùng', '127.0.0.1', NULL, '2025-03-08 10:32:44', '2025-03-08 10:32:44'),
(137, 10, 'Xem chi tiết tài khoản người dùng có id: 1', '127.0.0.1', NULL, '2025-03-08 10:32:46', '2025-03-08 10:32:46'),
(138, 10, 'Xem chi tiết tài khoản người dùng có id: 24', '127.0.0.1', NULL, '2025-03-08 10:32:53', '2025-03-08 10:32:53'),
(139, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 10:33:01', '2025-03-08 10:33:01'),
(140, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 10:45:32', '2025-03-08 10:45:32'),
(141, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 10:46:52', '2025-03-08 10:46:52'),
(142, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 10:50:40', '2025-03-08 10:50:40'),
(143, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 10:56:43', '2025-03-08 10:56:43'),
(144, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 10:58:21', '2025-03-08 10:58:21'),
(145, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 10:59:20', '2025-03-08 10:59:20'),
(146, 10, 'đăng nhập vào hệ thống', '127.0.0.1', NULL, '2025-03-08 19:17:28', '2025-03-08 19:17:28'),
(147, 10, 'hiển thị trang dashboard', '127.0.0.1', NULL, '2025-03-08 19:17:28', '2025-03-08 19:17:28'),
(148, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 19:17:33', '2025-03-08 19:17:33'),
(149, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 19:17:42', '2025-03-08 19:17:42'),
(150, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 19:18:00', '2025-03-08 19:18:00'),
(151, 10, 'Vào trang hiển thị danh sách nhân viên', '127.0.0.1', NULL, '2025-03-08 19:18:03', '2025-03-08 19:18:03'),
(152, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 19:50:34', '2025-03-08 19:50:34'),
(153, 10, 'Vào trang hiển thị danh sách đánh giá', '127.0.0.1', NULL, '2025-03-08 19:50:40', '2025-03-08 19:50:40'),
(154, 10, 'Xem chi tiết đánh giá sản phẩm có id: 41', '127.0.0.1', NULL, '2025-03-08 19:50:42', '2025-03-08 19:50:42'),
(155, 10, 'Vào trang hiển thị danh sách đánh giá', '127.0.0.1', NULL, '2025-03-08 19:50:43', '2025-03-08 19:50:43'),
(156, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 19:50:47', '2025-03-08 19:50:47'),
(157, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 19:50:49', '2025-03-08 19:50:49'),
(158, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 19:50:52', '2025-03-08 19:50:52'),
(159, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 19:51:05', '2025-03-08 19:51:05'),
(160, 10, 'Vào trang hiển thị danh sách nhân viên', '127.0.0.1', NULL, '2025-03-08 19:51:19', '2025-03-08 19:51:19'),
(161, 10, 'Xem thông tin nhân viên có id: 3', '127.0.0.1', NULL, '2025-03-08 19:51:22', '2025-03-08 19:51:22'),
(162, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 19:51:28', '2025-03-08 19:51:28'),
(163, 10, 'Vào trang thêm voucher', '127.0.0.1', NULL, '2025-03-08 19:51:30', '2025-03-08 19:51:30'),
(164, 10, 'Tạo voucher mới có id: 19', '127.0.0.1', NULL, '2025-03-08 19:52:11', '2025-03-08 19:52:11'),
(165, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 19:52:11', '2025-03-08 19:52:11'),
(166, 10, 'Vào trang chỉnh sửa voucher có ID: 19', '127.0.0.1', NULL, '2025-03-08 19:52:24', '2025-03-08 19:52:24'),
(167, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 19:52:42', '2025-03-08 19:52:42'),
(168, 10, 'Vào trang hiển thị danh sách bình luận', '127.0.0.1', NULL, '2025-03-08 19:52:53', '2025-03-08 19:52:53'),
(169, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 19:52:54', '2025-03-08 19:52:54'),
(170, 10, 'Vào trang hiển thị danh sách bình luận', '127.0.0.1', NULL, '2025-03-08 19:52:57', '2025-03-08 19:52:57'),
(171, 10, 'Vào trang hiển thị danh sách nhân viên', '127.0.0.1', NULL, '2025-03-08 19:53:23', '2025-03-08 19:53:23'),
(172, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 19:53:24', '2025-03-08 19:53:24'),
(173, 10, 'Vào trang thêm sản phẩm', '127.0.0.1', NULL, '2025-03-08 19:53:25', '2025-03-08 19:53:25'),
(174, 10, 'Thêm sản phẩm mới có id: 69', '127.0.0.1', NULL, '2025-03-08 19:53:53', '2025-03-08 19:53:53'),
(175, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 19:53:53', '2025-03-08 19:53:53'),
(176, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 19:53:56', '2025-03-08 19:53:56'),
(177, 10, 'Vào trang sửa sản phẩm: 69', '127.0.0.1', NULL, '2025-03-08 19:54:00', '2025-03-08 19:54:00'),
(178, 10, 'Vào trang thêm biến thể cho sản phẩm có ID: 69', '127.0.0.1', NULL, '2025-03-08 19:54:05', '2025-03-08 19:54:05'),
(179, 10, 'Vào trang sửa sản phẩm: 69', '127.0.0.1', NULL, '2025-03-08 19:54:07', '2025-03-08 19:54:07'),
(180, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 19:54:35', '2025-03-08 19:54:35'),
(181, 10, 'Vào trang hiển thị danh sách voucher', '127.0.0.1', NULL, '2025-03-08 20:05:53', '2025-03-08 20:05:53'),
(182, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 20:05:57', '2025-03-08 20:05:57'),
(183, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 20:14:02', '2025-03-08 20:14:02'),
(184, 10, 'Vào trang thêm sản phẩm', '127.0.0.1', NULL, '2025-03-08 20:14:03', '2025-03-08 20:14:03'),
(185, 10, 'Thêm sản phẩm mới có id: 70', '127.0.0.1', NULL, '2025-03-08 20:14:22', '2025-03-08 20:14:22'),
(186, 10, 'Thêm biến thể mới có id: 142 cho sản phẩm có id: 70', '127.0.0.1', NULL, '2025-03-08 20:14:23', '2025-03-08 20:14:23'),
(187, 10, 'Vào trang thêm sản phẩm', '127.0.0.1', NULL, '2025-03-08 20:14:23', '2025-03-08 20:14:23'),
(188, 10, 'Thêm sản phẩm mới có id: 71', '127.0.0.1', NULL, '2025-03-08 20:16:09', '2025-03-08 20:16:09'),
(189, 10, 'Thêm biến thể mới có id: 143 cho sản phẩm có id: 71', '127.0.0.1', NULL, '2025-03-08 20:16:09', '2025-03-08 20:16:09'),
(190, 10, 'Vào trang thêm sản phẩm', '127.0.0.1', NULL, '2025-03-08 20:16:10', '2025-03-08 20:16:10'),
(191, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 20:16:17', '2025-03-08 20:16:17'),
(192, 10, 'Vào trang hiển thị danh sách đơn hàng', '127.0.0.1', NULL, '2025-03-08 20:16:25', '2025-03-08 20:16:25'),
(193, 10, 'Xem chi tiết đơn hàng: 20', '127.0.0.1', NULL, '2025-03-08 20:16:39', '2025-03-08 20:16:39'),
(194, 10, 'Xem chi tiết đơn hàng: 20', '127.0.0.1', NULL, '2025-03-08 20:22:31', '2025-03-08 20:22:31'),
(195, 10, 'Xem chi tiết đơn hàng: 20', '127.0.0.1', NULL, '2025-03-08 20:30:55', '2025-03-08 20:30:55'),
(196, 10, 'Xem chi tiết đơn hàng: 20', '127.0.0.1', NULL, '2025-03-08 20:31:17', '2025-03-08 20:31:17'),
(197, 10, 'Xem chi tiết đơn hàng: 20', '127.0.0.1', NULL, '2025-03-08 20:38:36', '2025-03-08 20:38:36'),
(198, 10, 'Xem chi tiết đơn hàng: 20', '127.0.0.1', NULL, '2025-03-08 20:38:49', '2025-03-08 20:38:49'),
(199, 10, 'Vào trang hiển thị danh sách sản phẩm', '127.0.0.1', NULL, '2025-03-08 21:03:32', '2025-03-08 21:03:32'),
(200, 10, 'Vào trang hiển thị danh sách đơn hàng', '127.0.0.1', NULL, '2025-03-08 21:10:17', '2025-03-08 21:10:17'),
(201, 10, 'Xem chi tiết đơn hàng: 19', '127.0.0.1', NULL, '2025-03-08 21:10:18', '2025-03-08 21:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2014_10_12_000000_create_users_table', 1),
(7, '2014_10_12_100000_create_password_reset_tokens_table', 2),
(8, '2019_08_19_000000_create_failed_jobs_table', 3),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 4),
(10, '2025_02_14_152325_create_employees_table', 5),
(11, '2025_02_14_155908_create_categories_table', 6),
(12, '2025_02_14_155934_create_colors_table', 7),
(14, '2025_02_14_160053_create_posts_table', 8),
(15, '2025_02_14_160109_create_products_table', 9),
(16, '2025_02_14_160126_create_sizes_table', 10),
(17, '2025_02_14_160222_create_vouchers_table', 11),
(19, '2025_02_14_160211_create_variants_table', 12),
(20, '2025_02_14_155834_create_carts_table', 13),
(21, '2025_02_14_155922_create_comments_table', 13),
(22, '2025_02_14_155957_create_favorites_table', 13),
(23, '2025_02_14_160044_create_orders_table', 14),
(24, '2025_02_14_160034_create_order_items_table', 15),
(25, '2025_02_14_160105_create_product_images_table', 15),
(26, '2025_02_14_160120_create_rates_table', 15),
(27, '2025_02_14_160145_create_user_rewards_table', 15),
(28, '2025_02_14_160154_create_user_vouvhers_table', 15),
(29, '2025_02_14_160245_create_wallets_table', 16),
(30, '2025_02_14_160240_create_wallet_transactions_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `id_voucher` bigint UNSIGNED DEFAULT NULL,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(15,2) NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'COD',
  `payment_status` enum('pending','shipping','completed','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `id_voucher`, `discount_amount`, `total_price`, `fullname`, `phone`, `shipping_address`, `payment_method`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 5, 2, '10000.00', '6000000.00', NULL, NULL, '983 Kenny Dale Suite 897\nHuelchester, MO 82274', '', 'completed', '2025-01-26 03:40:14', NULL),
(2, 15, 6, '0.00', '0.00', NULL, NULL, '4050 Johnson Bridge Suite 420\nPort Dedrick, CO 29651', '', 'pending', '2025-01-22 23:17:24', NULL),
(3, 14, 1, '0.00', '0.00', NULL, NULL, '633 Vandervort Pike Apt. 848\nRennerstad, WI 86658', '', 'completed', '2025-01-28 05:47:59', NULL),
(4, 11, 9, '0.00', '0.00', NULL, NULL, '96098 Jonatan Ranch\nNorth Destinimouth, NY 55275-9263', '', 'pending', '2025-01-25 09:12:52', NULL),
(5, 15, 9, '0.00', '0.00', NULL, NULL, '67935 Kerluke Keys\nSouth Jeremiestad, NC 02598-0019', '', 'failed', '2025-02-08 03:06:24', NULL),
(6, 7, 1, '0.00', '0.00', NULL, NULL, '684 Towne Fort\nNew Elliottown, DE 89279', '', 'completed', '2025-01-10 02:29:51', NULL),
(7, 20, 5, '0.00', '0.00', NULL, NULL, '6188 Ernser Village\nNew Valentinamouth, WY 34995-3220', '', 'failed', '2025-01-05 06:06:24', NULL),
(8, 20, 2, '0.00', '0.00', NULL, NULL, '937 Rowland Mills\nHermanville, AR 00474', '', 'completed', '2025-01-28 01:53:56', NULL),
(9, 7, 4, '0.00', '0.00', NULL, NULL, '6737 Medhurst Center Apt. 280\nHomenickbury, WI 59037', '', 'failed', '2025-02-03 19:44:03', NULL),
(10, 19, 7, '0.00', '0.00', NULL, NULL, '4015 Dicki Ville Apt. 234\nChristiansenmouth, VT 09312-4072', '', 'failed', '2025-01-30 13:03:22', NULL),
(11, 17, 2, '0.00', '0.00', NULL, NULL, '36095 Beer Gateway Suite 879\nMistytown, MO 91616-7112', '', 'pending', '2025-02-14 01:32:44', NULL),
(12, 12, 10, '0.00', '0.00', NULL, NULL, '7443 Russel Stravenue Suite 158\nNorth Sylvia, PA 36789', '', 'completed', '2025-01-02 12:04:32', NULL),
(13, 6, 1, '0.00', '6000000.00', NULL, NULL, '86697 Serena Tunnel Apt. 274\nTobyport, VT 42820', '', 'failed', '2025-02-09 06:51:20', NULL),
(14, 4, 5, '0.00', '0.00', NULL, NULL, '64586 Howe Fields\nMcCulloughmouth, AK 78495-7611', '', 'failed', '2025-01-11 00:44:16', NULL),
(15, 11, 10, '0.00', '0.00', NULL, NULL, '231 Turcotte Crossing\nGibsonland, OH 65115-5501', '', 'completed', '2025-01-16 01:48:40', NULL),
(16, 13, 5, '0.00', '0.00', NULL, NULL, '35810 Hank Circles Apt. 113\nIvybury, KY 84608-1923', '', 'pending', '2025-01-27 05:43:29', NULL),
(17, 8, 3, '0.00', '0.00', NULL, NULL, '8376 Gaetano River\nEast Arianeburgh, NC 64560', '', 'pending', '2025-01-06 05:51:54', NULL),
(18, 3, 10, '0.00', '0.00', NULL, NULL, '54984 Janick Islands\nPort Daijahaven, WA 16133-7337', '', 'completed', '2025-01-13 08:45:24', NULL),
(19, 4, 1, '0.00', '0.00', NULL, NULL, '306 Jamel Meadow Suite 939\nMaybellbury, MT 44517-6389', '', 'completed', '2025-02-03 06:55:28', NULL),
(20, 7, 3, '0.00', '0.00', NULL, NULL, '71970 Vicky Rest Suite 400\nWeissnatberg, VA 98782', '', 'failed', '2025-01-10 11:41:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `id_order` bigint UNSIGNED DEFAULT NULL,
  `id_variant` bigint UNSIGNED DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `id_order`, `id_variant`, `quantity`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 13, 96, 4, '665000.00', '1330000.00', '2025-01-12 03:00:40', '2025-02-15 11:03:44'),
(2, 15, 86, 3, '1564000.00', '3128000.00', '2025-02-07 22:37:45', '2025-02-15 11:03:44'),
(3, 3, 64, 1, '112000.00', '560000.00', '2025-01-19 11:26:21', '2025-02-15 11:03:44'),
(4, 2, 114, 1, '1357000.00', '4071000.00', '2025-01-01 23:53:22', '2025-02-15 11:03:44'),
(5, 8, 15, 4, '227000.00', '908000.00', '2025-01-14 23:10:21', '2025-02-15 11:03:44'),
(6, 4, 71, 4, '1745000.00', '3490000.00', '2025-01-09 10:37:35', '2025-02-15 11:03:44'),
(7, 9, 52, 1, '645000.00', '3225000.00', '2025-01-29 20:17:51', '2025-02-15 11:03:44'),
(8, 7, 41, 1, '311000.00', '1244000.00', '2025-02-02 06:07:13', '2025-02-15 11:03:44'),
(9, 1, 81, 5, '1521000.00', '7605000.00', '2025-01-01 04:28:12', '2025-02-15 11:03:44'),
(10, 7, 43, 2, '282000.00', '1410000.00', '2025-01-12 07:35:16', '2025-02-15 11:03:44'),
(11, 19, 35, 5, '127000.00', '508000.00', '2025-01-26 22:25:00', '2025-02-15 11:03:44'),
(12, 9, 63, 4, '262000.00', '1048000.00', '2025-01-22 00:40:46', '2025-02-15 11:03:44'),
(13, 8, 1, 5, '1616000.00', '4848000.00', '2025-01-09 11:45:23', '2025-02-15 11:03:44'),
(14, 9, 115, 3, '127000.00', '254000.00', '2025-01-24 20:35:31', '2025-02-15 11:03:44'),
(15, 17, 96, 2, '665000.00', '3325000.00', '2025-01-25 16:34:07', '2025-02-15 11:03:44'),
(16, 8, 8, 5, '1577000.00', '7885000.00', '2025-01-18 23:11:16', '2025-02-15 11:03:44'),
(17, 20, 115, 1, '127000.00', '635000.00', '2025-01-08 06:41:57', '2025-02-15 11:03:44'),
(18, 15, 14, 4, '279000.00', '558000.00', '2025-01-25 10:48:16', '2025-02-15 11:03:44'),
(19, 6, 13, 3, '1960000.00', '9800000.00', '2025-01-17 21:41:03', '2025-02-15 11:03:44'),
(20, 15, 5, 3, '1837000.00', '5511000.00', '2025-02-13 08:20:48', '2025-02-15 11:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_employee` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `image`, `status`, `created_at`, `updated_at`, `id_employee`) VALUES
(1, 'Unde et voluptates in amet quia ut eos.', 'Explicabo in qui aut minus dolor minima. Architecto ea consequatur illo sint sunt omnis magni et. Eum inventore repudiandae nemo incidunt in voluptatem ipsa. Fugiat numquam aut quae ab et magnam labore vitae.\n\nSunt deserunt non eveniet laudantium atque error aliquam. In eum asperiores rerum nam quia. Ducimus fuga dolor perferendis nihil non voluptas.\n\nItaque error blanditiis ad eos recusandae dolorem tempore. Distinctio recusandae non totam sit. Repudiandae fuga id natus consequuntur aut officiis nam. Necessitatibus nihil illum voluptatum.', 'https://via.placeholder.com/640x480.png/008866?text=business+Faker+ut', 'published', '2025-01-25 23:20:29', '2025-02-15 11:05:00', 10),
(2, 'Architecto asperiores occaecati quia ad quis neque.', 'Inventore repudiandae suscipit illo facilis laboriosam perferendis sit consectetur. Maxime culpa consequuntur quo et. Temporibus est ab at rem corporis sint commodi odit.\n\nOccaecati quia et eius dolorem deserunt et. Voluptatem necessitatibus aut tempore voluptatem commodi.\n\nDolorem sapiente veritatis commodi excepturi qui qui et. Officia omnis inventore maxime officia in distinctio autem. Aliquid ab nihil officiis deleniti nihil possimus. Dicta veniam molestiae voluptatem aut.', 'https://via.placeholder.com/640x480.png/004488?text=business+Faker+est', 'published', '2025-02-02 18:28:58', '2025-02-15 11:05:00', 17),
(3, 'Quae dicta autem ut itaque fuga error similique.', 'Rerum nesciunt ut et quis accusantium in cupiditate neque. Est asperiores nam soluta aliquid. Maiores quis nisi aut consequatur. Sapiente nihil omnis enim voluptates odit eveniet.\n\nIste a veniam odio earum sed dolor velit non. Odit eaque ullam ab quo labore maiores sunt. Maxime magnam molestiae quia deleniti magni vero soluta.\n\nExplicabo necessitatibus omnis aut iusto vitae quae. Delectus eius id quia. Et libero eum debitis.', 'https://via.placeholder.com/640x480.png/0011ee?text=business+Faker+eveniet', 'draft', '2025-01-09 12:54:23', '2025-02-15 11:05:00', 8),
(4, 'Commodi perferendis veritatis nulla temporibus.', 'Saepe reiciendis sed cupiditate ea. Nemo temporibus facere commodi dicta rerum. Dolores ut est et. Doloremque sequi quia illo.\n\nQuidem atque nulla expedita praesentium ipsa a. Voluptatum magni autem enim ad iure. Quia facere et qui atque qui dicta incidunt. Omnis voluptate architecto enim eveniet.\n\nConsequatur voluptatum aliquid nihil quaerat nobis blanditiis accusantium. Architecto cumque cum dolor rerum ea. Voluptatum animi voluptas aut accusantium et dolor iure et. Odit vel autem minima molestiae.', 'https://via.placeholder.com/640x480.png/00ff55?text=business+Faker+qui', 'published', '2025-01-03 00:36:16', '2025-02-15 11:05:00', 9),
(5, 'Quos omnis molestiae quaerat.', 'Fugiat aut eum temporibus optio cum nemo in qui. Suscipit consequatur reiciendis ea deserunt hic ducimus nostrum asperiores.\n\nSuscipit sint quia consectetur cupiditate. Nisi et cumque sunt dolor et tempora et. Suscipit voluptas voluptate possimus nobis provident perferendis totam dolores. Aliquam quia doloribus officia vel placeat.\n\nEarum eos ea aliquid neque fuga. Dolorem et voluptatum accusantium omnis molestiae. Inventore voluptas rerum praesentium. Dolorum reiciendis sequi rerum incidunt alias ipsam repudiandae.', 'https://via.placeholder.com/640x480.png/002233?text=business+Faker+illum', 'draft', '2025-01-02 21:38:49', '2025-02-15 11:05:00', 19),
(6, 'Omnis ratione consectetur non aut eius libero nemo qui.', 'Aliquam commodi laudantium suscipit animi ducimus est. Error culpa aut autem enim deleniti quibusdam. Blanditiis sint quas voluptas ex dicta eum.\n\nOccaecati necessitatibus non eos optio voluptas sint tempore. Explicabo amet nihil commodi amet esse rerum quas itaque. Sequi eum aut eius tempora earum laudantium. Impedit et repellendus possimus ea quis.\n\nEst voluptas eum ratione et qui voluptatem. Quam aut cupiditate officiis voluptatem consequatur veniam illum. Qui et perferendis repudiandae qui sint. Porro illo reiciendis cumque ullam rerum.', 'https://via.placeholder.com/640x480.png/0033cc?text=business+Faker+laudantium', 'published', '2025-01-12 00:51:23', '2025-02-15 11:05:00', 17),
(7, 'Quia enim in porro hic doloremque magnam.', 'Qui minima cum alias officia quibusdam necessitatibus animi. Exercitationem voluptates ad eum voluptatem fugit nihil quaerat. Adipisci cupiditate voluptas fugit suscipit eum eaque. Ullam molestiae unde iusto accusantium voluptas dolores consequatur.\n\nIpsum ullam cum id qui quasi et omnis. Minima inventore voluptatem et dolor quasi sunt.\n\nIllo qui sequi et dolor quia sit in. Vitae eius quo ea delectus quibusdam autem voluptatem. In expedita dolores nemo sit deleniti eaque culpa. Dolores quo quibusdam dolores libero similique eos non.', 'https://via.placeholder.com/640x480.png/002211?text=business+Faker+omnis', 'published', '2025-02-08 08:38:15', '2025-02-15 11:05:00', 17),
(8, 'Voluptatem iste exercitationem praesentium recusandae excepturi repudiandae.', 'Consequatur eum in et ratione animi repellendus. Aspernatur libero animi est vel provident in.\n\nIpsam odio in quis excepturi labore corporis fugit velit. Quibusdam magni consequatur at voluptas excepturi eius. Repellendus cumque quis velit est deserunt quia non.\n\nQui atque consectetur commodi mollitia modi eaque debitis totam. Alias voluptas consectetur quod voluptatem magni dignissimos. Unde doloribus sint magni modi quasi. Sit voluptatem beatae et harum nesciunt dolorum autem qui.', 'https://via.placeholder.com/640x480.png/007733?text=business+Faker+beatae', 'published', '2025-02-04 19:15:24', '2025-02-15 11:05:00', 17),
(9, 'Dicta molestias eveniet nisi perspiciatis.', 'Cupiditate consequatur sunt repudiandae quos cupiditate quaerat est. Cum ipsum id dicta voluptatem sunt. Aspernatur eligendi rerum libero fugiat aspernatur et itaque maiores. Sed quidem quod voluptatem ut cumque vel rem.\n\nEius non quae cupiditate modi nihil atque. A et delectus ut voluptas dolores iusto suscipit. Error laboriosam dolores vel ut voluptatum non. Magni dolores sapiente saepe dolor laborum.\n\nPorro consequuntur est et itaque modi repellat sunt. Quia delectus exercitationem asperiores ut debitis id. Et numquam et ex explicabo ea vel.', 'https://via.placeholder.com/640x480.png/00ff66?text=business+Faker+odio', 'draft', '2025-02-12 22:01:41', '2025-02-15 11:05:00', 18),
(10, 'Est placeat corporis non accusamus.', 'Repudiandae nihil mollitia ratione ut. Odit atque architecto repellat aut corrupti. Consequatur nam amet cum esse omnis sed. Sed voluptatibus est nihil dolorum illo.\n\nPlaceat necessitatibus vel nemo alias eius rerum. Ad qui ipsa et impedit consequatur. Quia quibusdam asperiores illum autem.\n\nEnim at magni totam et modi qui tempore. Natus error vel vel aut impedit. Est numquam nemo facilis molestias labore id quia pariatur.', 'https://via.placeholder.com/640x480.png/004477?text=business+Faker+voluptatem', 'published', '2025-02-04 12:28:56', '2025-02-15 11:05:00', 11),
(11, 'Soluta voluptatum architecto ullam magnam.', 'Reprehenderit et asperiores et nulla quisquam ut. Fuga et et qui placeat. Fugit sapiente non optio nisi. Ut libero eos omnis ut rerum qui minus. Aliquam praesentium quia voluptate laborum nam quibusdam.\n\nBlanditiis dolores sapiente libero dolor quasi reprehenderit laudantium aperiam. Exercitationem quasi eveniet consectetur rem incidunt mollitia. Id molestiae consequatur ea corrupti.\n\nSoluta voluptatem ut dolor soluta. Porro assumenda inventore ratione ut sed dicta. Ipsam dicta inventore dicta nulla nemo sit.', 'https://via.placeholder.com/640x480.png/00aaaa?text=business+Faker+fuga', 'published', '2025-01-15 01:51:16', '2025-02-15 11:05:00', 15),
(12, 'Est aspernatur et qui qui consequatur animi molestiae.', 'Sint numquam quia modi dolores quidem neque qui. Unde ratione temporibus nostrum nisi. Repudiandae eum officia quia aut excepturi ea cupiditate.\n\nOdio et voluptas voluptas eum in ut numquam eos. Et in qui adipisci quasi sequi. Minus repellat recusandae sapiente id voluptates quidem.\n\nQui dolores temporibus blanditiis ipsa nobis dolor praesentium praesentium. Minima dolorem laudantium officia omnis. Ea modi molestias mollitia est. Doloribus aut iusto quidem aliquid eveniet.', 'https://via.placeholder.com/640x480.png/00ee44?text=business+Faker+est', 'draft', '2025-02-14 01:39:39', '2025-02-15 11:05:00', 6),
(13, 'Ut ut saepe culpa odit consequuntur commodi itaque.', 'Nesciunt maiores blanditiis tenetur possimus error nostrum. Repudiandae dolorem eveniet quaerat quaerat fugiat adipisci non. Modi odio minima deserunt quos.\n\nConsequatur id vel earum unde nihil aut. Incidunt provident ipsam et et nostrum quia et. In laboriosam vero aut porro inventore distinctio nihil corporis.\n\nQui dolorem et quos facere quia. Non enim nam ex occaecati. Impedit aspernatur vero doloribus temporibus autem reiciendis nulla.', 'https://via.placeholder.com/640x480.png/0022dd?text=business+Faker+sint', 'draft', '2025-01-19 10:32:44', '2025-02-15 11:05:00', 2),
(14, 'Doloremque inventore autem fugiat maxime.', 'Animi officiis et repellat aut. Ut cumque velit placeat alias voluptates dolores accusamus. Asperiores aliquam repellendus blanditiis iusto. Rem eos magnam velit.\n\nExcepturi magnam est et error officia expedita nihil tempora. Tempore quis provident accusamus suscipit maxime quibusdam. Saepe est animi velit. Voluptatem non sunt et eum repellat veritatis. Voluptatem veritatis est et ab fugiat ut tempore et.\n\nNisi accusantium laboriosam labore ad. Architecto saepe necessitatibus id magni. Facere maxime est harum perferendis. Et amet id fugit et qui.', 'https://via.placeholder.com/640x480.png/006600?text=business+Faker+enim', 'draft', '2025-02-01 10:50:36', '2025-02-15 11:05:00', 12),
(15, 'Rerum eos nulla consequuntur similique qui ut.', 'Sit ut temporibus similique delectus labore qui. Maxime dignissimos autem sint praesentium consectetur et officiis aut. At expedita quos velit ea vitae recusandae. Itaque nisi consequatur dicta fugiat quia.\n\nFuga alias accusantium ducimus quia vel odio deserunt aut. Sint consequatur voluptatem et neque fugiat consequuntur iste. Qui ipsa delectus eveniet quam enim.\n\nOmnis aliquid veniam laboriosam. Laborum voluptatem voluptatem dicta voluptatem. Quis in nulla quis esse et. Et esse iste omnis autem dolor ea nemo. Officiis quod eum illum sunt aut.', 'https://via.placeholder.com/640x480.png/006611?text=business+Faker+delectus', 'draft', '2025-01-02 18:13:52', '2025-02-15 11:05:00', 14),
(16, 'Officiis possimus quasi mollitia culpa veritatis ab.', 'Et voluptates voluptatem temporibus doloribus. Voluptates reiciendis sunt dignissimos quasi minima iusto. Nobis ut distinctio et quidem et vitae pariatur.\n\nVoluptatem aliquam et qui nam neque sit. Rem fuga laborum quia. Omnis harum molestias optio est voluptatem quia cumque. Rerum aspernatur consequatur numquam et ut enim dolores ipsa.\n\nDolor qui ut consectetur ut eaque sed consequuntur vitae. Qui quas sunt nobis qui delectus esse mollitia. Assumenda maxime qui error et.', 'https://via.placeholder.com/640x480.png/00bb55?text=business+Faker+sunt', 'published', '2025-01-27 10:46:19', '2025-02-15 11:05:00', 2),
(17, 'Fuga blanditiis assumenda et.', 'Est autem quo exercitationem quia magnam voluptate pariatur. Quia ipsa hic eius maiores. Commodi sapiente aliquid quia architecto.\n\nAliquid qui et voluptas repellat. Consequuntur quod in possimus ipsa iure. Nam nisi tenetur facere blanditiis.\n\nReprehenderit odit assumenda facilis consequatur. Facere soluta labore harum impedit consequatur dolorum exercitationem. Animi nulla id sed hic.', 'https://via.placeholder.com/640x480.png/00bbdd?text=business+Faker+eius', 'published', '2025-01-01 20:50:18', '2025-02-15 11:05:00', 13),
(18, 'Cum qui eveniet dolorem rerum qui amet.', 'Est animi dolor aperiam et distinctio ut. Eligendi explicabo natus optio sint. Suscipit et distinctio nihil et iure odio. Vero velit repellendus voluptas itaque nihil quasi ut.\n\nRepudiandae sed repellat ex et saepe quae est temporibus. Ab quis dolores veritatis omnis. Illo et iusto culpa similique qui quos voluptatem. Sint repudiandae sequi et eveniet illum.\n\nEt quisquam alias nostrum aliquid nobis. Eligendi incidunt id officia atque reiciendis voluptas.', 'https://via.placeholder.com/640x480.png/003344?text=business+Faker+consequatur', 'draft', '2025-02-14 21:47:19', '2025-02-15 11:05:00', 6),
(19, 'Ea inventore consequuntur ullam exercitationem.', 'Corporis sint veniam ea et. Qui itaque perferendis sequi maxime doloremque. Corporis expedita quos libero ab suscipit laborum mollitia. Earum praesentium non aliquam ullam et. Officia explicabo ad ipsam ut pariatur ipsa architecto.\n\nDebitis omnis rerum non qui neque omnis debitis iure. Aliquid totam nulla vero harum illum optio non.\n\nDolor alias exercitationem illum molestiae similique harum. Et mollitia fuga nulla qui autem facere. Possimus voluptatum asperiores adipisci aut. Id voluptatem eum facilis repellendus.', 'https://via.placeholder.com/640x480.png/004411?text=business+Faker+esse', 'draft', '2025-01-18 02:15:08', '2025-02-15 11:05:00', 7),
(20, 'Sed quia laudantium voluptas quis veritatis ullam.', 'Vero aut quaerat repellat repellendus cum aut deleniti. Sit ad aperiam quia sapiente corporis nulla non. Aspernatur assumenda est velit voluptates perspiciatis nemo fugit. Omnis omnis possimus maiores quia est qui doloremque ad.\n\nDebitis minus dicta voluptatibus quo temporibus minus. Earum dolores itaque ut et. Assumenda totam error quidem officiis aut.\n\nReprehenderit autem consequatur praesentium eveniet. Ut explicabo fuga autem aliquam ea distinctio ut. Qui deserunt est nobis provident et.', 'https://via.placeholder.com/640x480.png/0055cc?text=business+Faker+aut', 'published', '2025-01-04 04:08:58', '2025-02-15 11:05:00', 15);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` bigint NOT NULL,
  `view` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_category` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `view`, `status`, `created_at`, `updated_at`, `id_category`) VALUES
(41, 'Giày nam', 'Blanditiis aspernatur ut et dolores quaerat aperiam. Dicta excepturi aliquid numquam minus itaque porro autem. Voluptatum et voluptatem vitae ut quo quae.', 463000, 673, 'active', '2025-01-06 16:52:35', '2025-02-22 09:02:49', 5),
(42, 'ut Shoes', 'Maiores delectus qui delectus laborum aut magni. Quasi ea tempore sit inventore corporis temporibus saepe accusantium. Dolorem soluta exercitationem tempore assumenda enim rerum quos. Nam libero tempora et iure.', 641000, 63, 'active', '2025-01-11 11:26:54', NULL, 3),
(43, 'at Shoes', 'Magnam numquam cumque sit dolores delectus quas aspernatur quibusdam. Id sit repudiandae deserunt cupiditate. Odit natus assumenda eum pariatur animi nulla mollitia.', 1045000, 175, 'active', '2025-01-29 14:27:26', '2025-03-01 21:28:47', 4),
(44, 'veritatis Shoes', 'Id fugiat magnam dicta officia. Modi ut omnis velit vel et facere autem dicta. Ducimus ut dolores harum. Et cum minus at error natus.', 1719000, 843, 'inactive', '2025-01-27 09:48:57', NULL, 4),
(45, 'sapiente Shoes', 'Doloremque et iste animi at. Est quia minus id ratione aspernatur. Et earum amet incidunt consequatur libero odit culpa.', 1916000, 972, 'inactive', '2025-01-24 05:12:43', NULL, 4),
(46, 'ut Shoes', 'Et accusantium ut ut quod facere quo. Pariatur qui dolor sed doloribus. Perspiciatis ad laudantium non facere. Sed aut ratione et quae et animi dolorum enim.', 1499000, 643, 'active', '2025-01-16 01:19:08', NULL, 3),
(47, 'exercitationem Shoes', 'Totam quaerat quas voluptatem velit est sit a. Reprehenderit aliquam voluptas dolores aut ut. Labore dolor voluptates voluptatem qui. Modi veritatis assumenda sunt omnis nemo.', 463000, 737, 'active', '2025-01-30 17:15:10', NULL, 4),
(48, 'vel Shoes', 'Dolorum perspiciatis animi officia nihil rem. Itaque iure consectetur id. Qui consequatur impedit aut ipsam eligendi. Sunt omnis officia vel quidem ut sit.', 684000, 618, 'active', '2025-02-04 04:56:59', NULL, NULL),
(49, 'ipsa Shoes', 'Aperiam qui neque illo. Unde delectus maxime sed molestiae ad non. Ab dicta aut est quae officiis veritatis. Minus eum voluptate quaerat nostrum ut odit quisquam.', 471000, 998, 'active', '2025-01-18 14:23:18', NULL, 3),
(50, 'corrupti Shoes', 'Tenetur corporis aspernatur vitae et. Ipsa consectetur qui temporibus quia occaecati voluptas numquam.', 1435000, 794, 'active', '2025-02-13 19:08:38', NULL, 3),
(51, 'fuga Shoes', 'Eius iste vitae non cumque ullam odit mollitia enim. Corrupti omnis debitis corporis laudantium sint doloremque non. Quam corporis consequuntur et fugiat tempora dolores ea. Et tempore illo dolorem esse rerum.', 1823000, 596, 'active', '2025-01-14 07:04:54', NULL, 5),
(52, 'sunt Shoes', 'Omnis placeat aut assumenda. Rerum corrupti doloribus harum quaerat. Tempore animi voluptas iure corrupti voluptatibus atque ut. Assumenda non aut autem est sed.', 1842000, 545, 'inactive', '2025-01-28 09:22:47', NULL, 4),
(53, 'dolores Shoes', 'Similique libero dolorem qui sit aut. Ad saepe itaque corrupti sit delectus harum aut. Qui aut nobis repudiandae assumenda quia inventore nihil. Nesciunt dignissimos ad quam omnis.', 330000, 807, 'active', '2025-02-04 03:42:39', NULL, 3),
(54, 'hic Shoes', 'Officia sit commodi at qui in sapiente. Velit consequatur est ullam vero debitis aspernatur earum. Ut quaerat incidunt sint qui quia.', 570000, 602, 'inactive', '2025-01-12 18:21:34', NULL, 5),
(55, 'dolorem Shoes', 'Accusamus et iste cum eos. Recusandae suscipit aut sit. Facilis quaerat ex nihil modi qui.', 1145000, 655, 'inactive', '2025-01-05 00:10:07', NULL, NULL),
(56, 'magni Shoes', 'Aut magnam autem harum accusamus velit rerum quas. Nulla consequatur tenetur iure sed aliquid officia eius.', 641000, 685, 'inactive', '2025-01-21 07:39:08', NULL, 3),
(57, 'dolorem Shoes', 'Qui rerum ipsam saepe repellendus eos magnam. Adipisci et aspernatur velit est harum quae velit. Voluptatibus autem sit temporibus magni aliquam commodi.', 1806000, 707, 'active', '2025-02-11 00:35:09', NULL, 3),
(58, 'quos Shoes', 'Reiciendis natus soluta rerum autem dolorem accusantium sequi. Qui molestias unde iusto molestiae voluptate accusantium sit. Quod fuga ut commodi consectetur amet.', 1955000, 996, 'active', '2025-02-15 05:59:23', NULL, NULL),
(59, 'sit Shoes', 'Molestiae placeat assumenda minus optio id. Maxime atque eveniet reprehenderit sint rerum itaque labore. Et id omnis aut iusto.', 1922000, 598, 'active', '2025-01-03 21:54:09', NULL, 4),
(60, 'quia Shoes', 'Commodi in libero qui ullam nihil cum reprehenderit. Et voluptatem consequatur voluptatibus voluptatum magnam magni. Facilis excepturi nam blanditiis dolores. Maiores qui deleniti quod voluptatum aut quibusdam.', 1833000, 146, 'inactive', '2025-02-09 01:59:32', NULL, 5),
(61, 'Jodan1', 'jsa ab ựabauwgwhes', 5000000, 0, 'active', '2025-02-22 19:48:11', '2025-02-22 19:48:11', 4),
(62, 'nike2', 'dsgh', 200000, 0, 'active', '2025-02-22 20:37:34', '2025-02-22 20:46:44', 4),
(63, 'adidas', 'dsdgfd', 300000, 0, 'active', '2025-02-23 02:17:57', '2025-02-23 02:17:57', 4),
(64, 'viet', 'ư rfe', 2000, 0, 'active', '2025-02-25 08:55:47', '2025-02-25 08:55:47', 2),
(65, 'Nike3', 'qrsaegfegfesg', 2000000, 0, 'active', '2025-03-01 09:58:37', '2025-03-01 09:58:37', 4),
(66, 'vietnqph45471', 'dgsvs', 1000, 0, 'active', '2025-03-01 19:54:21', '2025-03-01 19:54:21', 4),
(67, 'eafae', 'wefgwefw', 12345, 0, 'active', '2025-03-02 08:25:02', '2025-03-02 08:25:02', 2),
(68, 'sẻtg4w', 'ư4tgwtg', 1234, 0, 'active', '2025-03-02 08:49:54', '2025-03-02 08:49:54', 4),
(69, 'Giày nam 12', 'ègvsergsef', 1000000, 0, 'active', '2025-03-08 19:53:53', '2025-03-08 19:53:53', 2),
(70, 'vietseges', 'ưdf', 1312134, 0, 'active', '2025-03-08 20:14:22', '2025-03-08 20:14:22', 2),
(71, 'viet255', '3qwrtf3', 234, 0, 'active', '2025-03-08 20:16:09', '2025-03-08 20:16:09', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint UNSIGNED NOT NULL,
  `id_variant` bigint UNSIGNED DEFAULT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `id_variant`, `image_url`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 13, 'https://via.placeholder.com/400x400.png/000000?text=fashion+provident', 0, '2025-02-14 13:22:22', NULL),
(2, 14, 'https://via.placeholder.com/400x400.png/001100?text=fashion+quo', 0, '2025-01-31 00:30:07', NULL),
(3, 14, 'https://via.placeholder.com/400x400.png/0022dd?text=fashion+adipisci', 0, '2025-02-01 19:12:08', NULL),
(4, 14, 'https://via.placeholder.com/400x400.png/00dd99?text=fashion+libero', 0, '2025-02-02 07:17:18', NULL),
(5, 15, 'https://via.placeholder.com/400x400.png/002277?text=fashion+necessitatibus', 0, '2025-02-14 14:34:49', NULL),
(6, 15, 'https://via.placeholder.com/400x400.png/0066bb?text=fashion+voluptas', 0, '2025-01-25 20:32:06', NULL),
(7, 15, 'https://via.placeholder.com/400x400.png/0055ee?text=fashion+vero', 0, '2025-01-22 02:44:01', NULL),
(16, 6, 'https://1.kixify.com/sites/default/files/imagecache/product_list/product/2025/01/21/p_34859077_200409935_2661011.jpg', 0, '2025-02-11 15:29:00', NULL),
(18, 52, 'https://via.placeholder.com/400x400.png/00ee99?text=fashion+dolorem', 0, '2025-01-10 03:00:15', NULL),
(19, 52, 'https://via.placeholder.com/400x400.png/0033dd?text=fashion+doloribus', 0, '2025-02-05 21:31:06', NULL),
(20, 52, 'https://via.placeholder.com/400x400.png/00eebb?text=fashion+omnis', 0, '2025-02-06 23:22:23', NULL),
(21, 53, 'https://via.placeholder.com/400x400.png/00ee66?text=fashion+velit', 0, '2025-01-11 10:26:19', NULL),
(22, 53, 'https://via.placeholder.com/400x400.png/003333?text=fashion+maxime', 0, '2025-02-11 05:06:01', NULL),
(23, 53, 'https://via.placeholder.com/400x400.png/00dd11?text=fashion+sapiente', 0, '2025-01-26 09:22:50', NULL),
(24, 54, 'https://via.placeholder.com/400x400.png/006622?text=fashion+accusamus', 0, '2025-01-01 09:15:29', NULL),
(25, 16, 'https://via.placeholder.com/400x400.png/007744?text=fashion+enim', 0, '2025-01-19 23:05:37', NULL),
(26, 16, 'https://via.placeholder.com/400x400.png/008888?text=fashion+odio', 0, '2025-01-25 05:35:24', NULL),
(27, 17, 'https://via.placeholder.com/400x400.png/009922?text=fashion+necessitatibus', 0, '2025-02-01 01:49:02', NULL),
(28, 18, 'https://via.placeholder.com/400x400.png/0033bb?text=fashion+minima', 0, '2025-02-01 14:00:31', NULL),
(29, 18, 'https://via.placeholder.com/400x400.png/009955?text=fashion+enim', 0, '2025-01-25 04:09:33', NULL),
(30, 18, 'https://via.placeholder.com/400x400.png/006611?text=fashion+praesentium', 0, '2025-01-18 18:30:34', NULL),
(31, 19, 'https://via.placeholder.com/400x400.png/0055dd?text=fashion+modi', 0, '2025-01-04 07:21:25', NULL),
(32, 19, 'https://via.placeholder.com/400x400.png/00dd88?text=fashion+architecto', 0, '2025-01-08 23:01:38', NULL),
(33, 19, 'https://via.placeholder.com/400x400.png/0088dd?text=fashion+sunt', 0, '2025-01-13 05:54:08', NULL),
(34, 20, 'https://via.placeholder.com/400x400.png/00ee88?text=fashion+quia', 1, '2025-01-03 04:41:03', NULL),
(35, 20, 'https://via.placeholder.com/400x400.png/00bbaa?text=fashion+nulla', 0, '2025-01-31 07:23:12', NULL),
(36, 20, 'https://via.placeholder.com/400x400.png/00ee66?text=fashion+quo', 0, '2025-01-07 02:26:00', NULL),
(37, 21, 'https://via.placeholder.com/400x400.png/00cc88?text=fashion+ea', 1, '2025-01-18 03:51:56', NULL),
(38, 21, 'https://via.placeholder.com/400x400.png/0088dd?text=fashion+neque', 0, '2025-02-01 00:25:17', NULL),
(39, 21, 'https://via.placeholder.com/400x400.png/004488?text=fashion+est', 0, '2025-01-21 14:43:26', NULL),
(40, 55, 'https://via.placeholder.com/400x400.png/00aaee?text=fashion+magnam', 1, '2025-01-28 10:11:48', NULL),
(41, 55, 'https://via.placeholder.com/400x400.png/00bbff?text=fashion+maxime', 0, '2025-01-17 06:38:09', NULL),
(42, 55, 'https://via.placeholder.com/400x400.png/00cc22?text=fashion+itaque', 0, '2025-01-23 02:06:57', NULL),
(43, 56, 'https://via.placeholder.com/400x400.png/00dd33?text=fashion+blanditiis', 1, '2025-02-13 23:17:09', NULL),
(44, 56, 'https://via.placeholder.com/400x400.png/00bb44?text=fashion+vitae', 0, '2025-01-17 17:24:31', NULL),
(45, 56, 'https://via.placeholder.com/400x400.png/00cc88?text=fashion+perferendis', 0, '2025-01-28 03:21:39', NULL),
(46, 57, 'https://via.placeholder.com/400x400.png/001100?text=fashion+aut', 1, '2025-01-28 17:28:45', NULL),
(47, 57, 'https://via.placeholder.com/400x400.png/00cc77?text=fashion+et', 0, '2025-02-10 17:05:17', NULL),
(48, 37, 'https://via.placeholder.com/400x400.png/0000bb?text=fashion+dolorem', 1, '2025-02-01 04:19:28', NULL),
(49, 37, 'https://via.placeholder.com/400x400.png/00aaaa?text=fashion+odio', 0, '2025-02-02 05:34:36', NULL),
(50, 38, 'https://via.placeholder.com/400x400.png/0033ff?text=fashion+velit', 1, '2025-01-25 17:13:47', NULL),
(51, 38, 'https://via.placeholder.com/400x400.png/0000ff?text=fashion+odio', 0, '2025-01-24 02:57:27', NULL),
(52, 39, 'https://via.placeholder.com/400x400.png/0077bb?text=fashion+et', 1, '2025-01-09 06:58:31', NULL),
(53, 39, 'https://via.placeholder.com/400x400.png/0077dd?text=fashion+tempore', 0, '2025-01-29 20:43:18', NULL),
(54, 22, 'https://via.placeholder.com/400x400.png/005522?text=fashion+qui', 1, '2025-01-03 20:45:36', NULL),
(55, 22, 'https://via.placeholder.com/400x400.png/0044bb?text=fashion+et', 0, '2025-01-03 11:46:43', NULL),
(56, 22, 'https://via.placeholder.com/400x400.png/00bb77?text=fashion+culpa', 0, '2025-01-19 16:32:01', NULL),
(57, 23, 'https://via.placeholder.com/400x400.png/002266?text=fashion+magnam', 1, '2025-02-07 19:59:54', NULL),
(58, 24, 'https://via.placeholder.com/400x400.png/0066bb?text=fashion+qui', 1, '2025-01-18 06:38:29', NULL),
(59, 24, 'https://via.placeholder.com/400x400.png/00ee11?text=fashion+laboriosam', 0, '2025-01-24 01:28:05', NULL),
(60, 24, 'https://via.placeholder.com/400x400.png/006677?text=fashion+aut', 0, '2025-02-10 16:17:55', NULL),
(61, 58, 'https://via.placeholder.com/400x400.png/007711?text=fashion+animi', 1, '2025-02-10 07:59:35', NULL),
(62, 58, 'https://via.placeholder.com/400x400.png/005500?text=fashion+voluptatem', 0, '2025-01-28 02:16:38', NULL),
(63, 59, 'https://via.placeholder.com/400x400.png/009977?text=fashion+aspernatur', 1, '2025-02-04 02:09:17', NULL),
(64, 60, 'https://via.placeholder.com/400x400.png/00ee44?text=fashion+magnam', 1, '2025-01-11 11:51:55', NULL),
(65, 31, 'https://via.placeholder.com/400x400.png/0011cc?text=fashion+soluta', 1, '2025-01-24 06:23:42', NULL),
(66, 32, 'https://via.placeholder.com/400x400.png/0044aa?text=fashion+et', 1, '2025-01-23 10:38:47', NULL),
(67, 32, 'https://via.placeholder.com/400x400.png/00aadd?text=fashion+consectetur', 0, '2025-01-29 12:54:32', NULL),
(68, 32, 'https://via.placeholder.com/400x400.png/007722?text=fashion+ex', 0, '2025-02-11 23:52:34', NULL),
(69, 33, 'https://via.placeholder.com/400x400.png/0088ee?text=fashion+facere', 1, '2025-01-18 06:04:47', NULL),
(70, 40, 'https://via.placeholder.com/400x400.png/00ddaa?text=fashion+eveniet', 1, '2025-01-29 01:00:34', NULL),
(71, 40, 'https://via.placeholder.com/400x400.png/0088dd?text=fashion+minus', 0, '2025-01-15 18:50:30', NULL),
(72, 40, 'https://via.placeholder.com/400x400.png/003300?text=fashion+ea', 0, '2025-01-22 18:23:33', NULL),
(73, 41, 'https://via.placeholder.com/400x400.png/0088dd?text=fashion+perferendis', 0, '2025-01-28 22:32:41', NULL),
(74, 42, 'https://via.placeholder.com/400x400.png/00eecc?text=fashion+expedita', 0, '2025-01-27 05:16:52', NULL),
(75, 42, 'https://via.placeholder.com/400x400.png/001166?text=fashion+nemo', 0, '2025-01-22 12:37:33', NULL),
(76, 42, 'https://via.placeholder.com/400x400.png/008855?text=fashion+fugiat', 0, '2025-01-25 19:35:29', NULL),
(77, 25, 'https://via.placeholder.com/400x400.png/0000ff?text=fashion+dolor', 1, '2025-01-10 18:48:42', NULL),
(78, 26, 'https://via.placeholder.com/400x400.png/00eedd?text=fashion+praesentium', 1, '2025-01-03 03:59:47', NULL),
(79, 26, 'https://via.placeholder.com/400x400.png/0099ff?text=fashion+quibusdam', 0, '2025-02-12 18:26:44', NULL),
(80, 26, 'https://via.placeholder.com/400x400.png/00eeee?text=fashion+et', 0, '2025-02-08 21:20:03', NULL),
(81, 27, 'https://via.placeholder.com/400x400.png/0033dd?text=fashion+assumenda', 1, '2025-02-01 11:54:40', NULL),
(82, 7, 'https://via.placeholder.com/400x400.png/00dd33?text=fashion+nisi', 1, '2025-01-27 07:19:10', NULL),
(83, 8, 'https://via.placeholder.com/400x400.png/003377?text=fashion+minus', 1, '2025-01-30 11:58:59', NULL),
(84, 8, 'https://via.placeholder.com/400x400.png/00ff44?text=fashion+voluptas', 0, '2025-02-14 09:20:20', NULL),
(85, 9, 'https://via.placeholder.com/400x400.png/00ffdd?text=fashion+nulla', 1, '2025-01-23 08:57:59', NULL),
(86, 9, 'https://via.placeholder.com/400x400.png/00cc11?text=fashion+sint', 0, '2025-01-16 21:31:10', NULL),
(87, 43, 'https://via.placeholder.com/400x400.png/0099dd?text=fashion+perspiciatis', 1, '2025-02-03 05:08:48', NULL),
(88, 43, 'https://via.placeholder.com/400x400.png/000022?text=fashion+quam', 0, '2025-01-24 23:13:33', NULL),
(89, 43, 'https://via.placeholder.com/400x400.png/004455?text=fashion+blanditiis', 0, '2025-01-16 08:19:12', NULL),
(90, 44, 'https://via.placeholder.com/400x400.png/00aaaa?text=fashion+pariatur', 1, '2025-01-03 09:50:03', NULL),
(91, 44, 'https://via.placeholder.com/400x400.png/00ee33?text=fashion+accusantium', 0, '2025-01-05 04:38:04', NULL),
(92, 44, 'https://via.placeholder.com/400x400.png/00ff33?text=fashion+accusamus', 0, '2025-01-08 20:50:09', NULL),
(93, 45, 'https://via.placeholder.com/400x400.png/0000cc?text=fashion+quo', 1, '2025-01-31 21:33:27', NULL),
(94, 34, 'https://via.placeholder.com/400x400.png/004422?text=fashion+eos', 1, '2025-02-08 10:46:00', NULL),
(95, 34, 'https://via.placeholder.com/400x400.png/008888?text=fashion+molestiae', 0, '2025-02-02 18:25:15', NULL),
(96, 35, 'https://via.placeholder.com/400x400.png/002299?text=fashion+quas', 1, '2025-01-06 05:25:43', NULL),
(97, 36, 'https://via.placeholder.com/400x400.png/006655?text=fashion+blanditiis', 1, '2025-01-23 02:50:55', NULL),
(98, 36, 'https://via.placeholder.com/400x400.png/001177?text=fashion+voluptatem', 0, '2025-01-28 00:30:29', NULL),
(99, 36, 'https://via.placeholder.com/400x400.png/0000cc?text=fashion+molestias', 0, '2025-01-22 04:16:16', NULL),
(100, 46, 'https://via.placeholder.com/400x400.png/003377?text=fashion+eius', 1, '2025-01-18 13:49:31', NULL),
(101, 46, 'https://via.placeholder.com/400x400.png/009944?text=fashion+non', 0, '2025-01-15 01:23:02', NULL),
(102, 47, 'https://via.placeholder.com/400x400.png/000055?text=fashion+dolore', 1, '2025-01-29 09:14:38', NULL),
(103, 47, 'https://via.placeholder.com/400x400.png/002255?text=fashion+nemo', 0, '2025-01-01 08:55:29', NULL),
(104, 47, 'https://via.placeholder.com/400x400.png/0055ee?text=fashion+in', 0, '2025-02-06 01:55:24', NULL),
(105, 48, 'https://via.placeholder.com/400x400.png/00dd99?text=fashion+culpa', 1, '2025-01-04 08:12:38', NULL),
(106, 10, 'https://via.placeholder.com/400x400.png/000044?text=fashion+modi', 1, '2025-01-11 21:09:20', NULL),
(107, 10, 'https://via.placeholder.com/400x400.png/008811?text=fashion+voluptatem', 0, '2025-01-09 05:35:13', NULL),
(108, 11, 'https://via.placeholder.com/400x400.png/0088ee?text=fashion+minima', 1, '2025-01-16 06:32:46', NULL),
(109, 12, 'https://via.placeholder.com/400x400.png/00ffdd?text=fashion+aperiam', 1, '2025-01-19 14:02:31', NULL),
(110, 28, 'https://via.placeholder.com/400x400.png/0000cc?text=fashion+numquam', 1, '2025-02-01 22:10:48', NULL),
(111, 28, 'https://via.placeholder.com/400x400.png/007755?text=fashion+saepe', 0, '2025-01-15 23:34:41', NULL),
(112, 29, 'https://via.placeholder.com/400x400.png/007755?text=fashion+iste', 1, '2025-01-04 14:03:00', NULL),
(113, 29, 'https://via.placeholder.com/400x400.png/009900?text=fashion+facere', 0, '2025-01-25 15:22:10', NULL),
(114, 30, 'https://via.placeholder.com/400x400.png/00aa11?text=fashion+dicta', 1, '2025-01-31 00:07:14', NULL),
(115, 49, 'https://via.placeholder.com/400x400.png/00aabb?text=fashion+fugit', 1, '2025-01-27 19:57:24', NULL),
(116, 49, 'https://via.placeholder.com/400x400.png/00cccc?text=fashion+est', 0, '2025-01-25 11:38:48', NULL),
(117, 50, 'https://via.placeholder.com/400x400.png/003300?text=fashion+rem', 1, '2025-01-10 12:04:12', NULL),
(118, 50, 'https://via.placeholder.com/400x400.png/00ff77?text=fashion+veritatis', 0, '2025-01-11 13:37:51', NULL),
(119, 51, 'https://via.placeholder.com/400x400.png/00ee33?text=fashion+similique', 1, '2025-01-05 22:49:28', NULL),
(120, NULL, 'storage/productproduct/PWiIAhuNwViIbgbWXfv96ZagvibpFn70gAMlxqV6.png', 1, '2025-02-22 09:01:01', '2025-02-22 09:02:49'),
(121, 125, 'storage/product/1740285103_tải xuống.jpg', 1, '2025-02-22 21:31:43', '2025-02-22 21:31:43'),
(122, 126, 'storage/product/1740286661_tải xuống (2).jpg', 1, '2025-02-22 21:57:41', '2025-02-22 21:57:41'),
(124, 73, 'storage/product/1740300803_tải xuống.jpg', 1, '2025-02-23 01:53:23', '2025-02-23 01:53:23'),
(126, 5, 'storage/product/1740301378_tải xuống (2).jpg', 0, '2025-02-23 02:02:58', '2025-02-23 02:02:58'),
(127, 6, 'storage/product/1740301406_tải xuống.jpg', 0, '2025-02-23 02:03:26', '2025-02-23 02:03:26'),
(132, 128, 'storage/product/1740303074_tải xuống.jpg', 1, '2025-02-23 02:31:14', '2025-02-23 02:31:14'),
(133, 129, 'storage/product/1740303122_tải xuống (3).jpg', 1, '2025-02-23 02:32:02', '2025-02-23 02:32:02'),
(134, 129, 'storage/product/1740303122_tải xuống (2).jpg', 0, '2025-02-23 02:32:02', '2025-02-23 02:32:02'),
(135, 130, 'storage/product/1740303370_tải xuống (3).jpg', 1, '2025-02-23 02:36:10', '2025-02-23 02:36:10'),
(136, 130, 'storage/product/1740303370_tải xuống (2).jpg', 0, '2025-02-23 02:36:10', '2025-02-23 02:36:10'),
(137, 130, 'storage/product/1740303370_tải xuống (1).jpg', 0, '2025-02-23 02:36:10', '2025-02-23 02:36:10'),
(138, 131, 'storage/product/1740496735_tải xuống (1).jpg', 1, '2025-02-25 08:18:55', '2025-02-25 08:18:55'),
(139, 131, 'storage/product/1740496735_tải xuống.jpg', 0, '2025-02-25 08:18:55', '2025-02-25 08:18:55'),
(140, 132, 'storage/product/1740498967_tải xuống.jpg', 1, '2025-02-25 08:56:07', '2025-02-25 08:56:07'),
(141, 133, 'storage/product/1740848317_tải xuống (1).jpg', 1, '2025-03-01 09:58:37', '2025-03-01 09:58:37'),
(144, 136, 'storage/product/1740887593_tải xuống (3).jpg', 0, '2025-03-01 20:53:13', '2025-03-01 20:53:13'),
(145, 136, 'storage/product/1740887593_tải xuống (2).jpg', 0, '2025-03-01 20:53:13', '2025-03-01 20:53:13'),
(146, 136, 'storage/product/1740887593_tải xuống (1).jpg', 0, '2025-03-01 20:53:13', '2025-03-01 20:53:13'),
(147, 136, 'storage/product/1740887593_tải xuống.jpg', 0, '2025-03-01 20:53:13', '2025-03-01 20:53:13'),
(149, 1, 'storage/product/1740889270_tải xuống (2).jpg', 0, '2025-03-01 21:21:10', '2025-03-01 21:21:10'),
(152, 61, 'storage/product/1740889603_tải xuống (2).jpg', 0, '2025-03-01 21:26:43', '2025-03-01 21:26:43'),
(153, 61, 'storage/product/1740889603_tải xuống (1).jpg', 0, '2025-03-01 21:26:43', '2025-03-01 21:26:43'),
(154, 61, 'storage/product/1740889603_tải xuống.jpg', 0, '2025-03-01 21:26:43', '2025-03-01 21:26:43'),
(155, 96, 'storage/product/1740889741_tải xuống.jpg', 0, '2025-03-01 21:29:01', '2025-03-01 21:29:01'),
(158, 2, 'storage/product/1740929471_tải xuống (1).jpg', 0, '2025-03-02 08:31:11', '2025-03-02 08:31:11'),
(160, 139, 'storage/product/1740930594_tải xuống (3).jpg', 1, '2025-03-02 08:49:54', '2025-03-02 08:49:54'),
(161, 139, 'storage/product/1740930594_tải xuống (2).jpg', 0, '2025-03-02 08:49:54', '2025-03-02 08:49:54'),
(162, 139, 'storage/product/1740930594_tải xuống (1).jpg', 0, '2025-03-02 08:49:54', '2025-03-02 08:49:54'),
(163, 139, 'storage/product/1740930594_tải xuống.jpg', 0, '2025-03-02 08:49:54', '2025-03-02 08:49:54'),
(164, 140, 'storage/product/1740930594_tải xuống (3).jpg', 1, '2025-03-02 08:49:54', '2025-03-02 08:49:54'),
(165, 140, 'storage/product/1740930594_tải xuống (2).jpg', 0, '2025-03-02 08:49:54', '2025-03-02 08:49:54'),
(166, 141, 'storage/product/1741488833_tải xuống (2).jpg', 1, '2025-03-08 19:53:53', '2025-03-08 19:53:53');

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `id_product` bigint UNSIGNED DEFAULT NULL,
  `id_order_item` bigint UNSIGNED DEFAULT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `id_user`, `id_product`, `id_order_item`, `rating`, `review`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 50, 20, 1, 'Molestiae molestias quo consequuntur provident possimus omnis non suscipit.', 'pending', '2025-02-05 17:33:00', NULL),
(2, 4, 49, 9, 5, 'Atque perferendis tempora labore nobis praesentium ea et et.', 'approved', '2025-01-14 18:18:01', NULL),
(3, 12, 42, 9, 5, 'Suscipit dolorem saepe omnis error magnam vitae deleniti delectus ipsum.', 'approved', '2025-02-08 11:01:17', NULL),
(4, 16, 51, 3, 5, 'Quibusdam et sapiente dolorum non voluptatem maiores dolore et voluptas facilis occaecati.', 'pending', '2025-01-01 14:05:23', NULL),
(5, 2, 46, 4, 3, 'Eligendi expedita laborum incidunt saepe adipisci omnis rerum id rerum unde hic.', 'rejected', '2025-01-16 09:33:34', NULL),
(6, 7, 57, 4, 4, 'Aut maxime hic magni ducimus quos et aspernatur impedit quod.', 'approved', '2025-01-06 14:09:46', NULL),
(7, 12, 45, 9, 1, 'Temporibus ipsa soluta ut exercitationem illum quia et eos commodi ea in earum.', 'rejected', '2025-01-03 13:52:04', NULL),
(8, 15, 50, 6, 1, 'Dolorum rerum rem nam natus dicta quo et itaque ipsum aut.', 'approved', '2025-01-11 04:57:23', NULL),
(9, 2, 56, 15, 3, 'Praesentium laborum qui ut sequi eum est dolor voluptas non qui.', 'pending', '2025-01-20 05:16:55', NULL),
(10, 10, 50, 17, 3, 'Veniam et quae quod illum magnam molestiae iure libero eaque sapiente iure voluptatum.', 'pending', '2025-01-03 02:25:01', NULL),
(11, 17, 58, 1, 5, 'Tempore omnis ut dolor accusantium esse maxime excepturi voluptatem eos qui doloremque.', 'rejected', '2025-02-09 20:48:42', NULL),
(12, 19, 41, 9, 5, 'Nesciunt animi et consequatur recusandae non laboriosam repellat eum eos laboriosam voluptatem delectus vel.', 'pending', '2025-01-19 12:25:23', NULL),
(13, 2, 52, 18, 1, 'Voluptas et reprehenderit velit omnis quam velit omnis.', 'rejected', '2025-01-05 23:16:18', NULL),
(14, 16, 49, 8, 1, 'Magni perspiciatis adipisci iste ipsam incidunt distinctio.', 'approved', '2025-02-11 21:42:28', NULL),
(15, 5, 42, 2, 1, 'Aperiam quia et rem cumque consequatur odio consequatur voluptatibus esse sit magni.', 'approved', '2025-01-31 04:29:38', NULL),
(16, 8, 52, 20, 5, 'Dolore et qui perspiciatis aut molestias molestias porro quod aperiam qui.', 'pending', '2025-02-03 04:26:29', NULL),
(17, 4, 60, 1, 4, 'Voluptas beatae odit sequi temporibus aut ut et enim aut.', 'rejected', '2025-01-12 14:49:44', NULL),
(18, 16, 42, 1, 4, 'Quisquam quis odit et minus modi voluptatibus praesentium earum saepe.', 'approved', '2025-02-01 11:33:52', NULL),
(19, 13, 57, 3, 4, 'Rem perferendis ullam autem eveniet quo laudantium nobis ducimus cum iure ut eum quidem.', 'approved', '2025-02-14 19:18:45', NULL),
(20, 8, 49, 6, 4, 'Eum eaque vitae eveniet maiores magni non harum mollitia omnis harum sit ducimus consequatur.', 'approved', '2025-02-04 01:19:35', NULL),
(21, 4, 45, 13, 1, 'Autem cumque laborum reiciendis vitae quidem quae omnis.', 'pending', '2025-02-14 04:54:33', NULL),
(22, 2, 48, 18, 5, 'Non neque reiciendis excepturi vel architecto quia pariatur dolores ipsa ut distinctio consectetur harum.', 'rejected', '2025-01-08 13:21:45', NULL),
(23, 20, 48, 4, 5, 'Possimus ut repellat repellat similique nulla tenetur maxime error non modi aut.', 'approved', '2025-02-08 23:03:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint UNSIGNED NOT NULL,
  `size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '35', '2025-02-08 18:14:21', '2025-03-08 07:54:15', NULL),
(2, '36', '2025-01-14 16:45:54', NULL, NULL),
(3, '37', '2025-02-03 13:17:44', NULL, NULL),
(4, '38', '2025-01-03 00:39:27', NULL, NULL),
(5, '39', '2025-02-04 14:08:58', NULL, NULL),
(6, '40', '2025-01-08 00:41:02', NULL, NULL),
(7, '41', '2025-01-25 01:30:50', NULL, NULL),
(8, '42', '2025-01-24 10:50:19', NULL, NULL),
(9, '43', '2025-02-11 15:22:43', NULL, NULL),
(10, '44', '2025-01-30 14:29:38', NULL, NULL),
(11, '45', '2025-01-31 16:02:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Male','Female','Other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `phone`, `address`, `gender`, `role`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'cu dep trai', 'giangntph32755@fpt.edu.vn', '$2y$12$uBH/XW3UZRz3rXJWok3JjuC3qfHS2NmTd7dSQMcgFoEKfy9VEWCre', '0976965451', '315 Phố Cẩn, Phường Bích, Huyện Liên KhoátCà Mau', 'Male', 'employee', '', NULL, '2024-11-10 10:49:18', '2025-02-27 19:29:52', NULL),
(2, 'Bà. Ân Hải Mai', 'lam92@example.net', '$2y$12$GZI29B3AzrOi1veg0gvmheCx387bUuh.7CO9uNVoNOoHtjonlwNPe', '(84)(510)992-2158', '2836 Phố Danh Chung Hạ, Xã 03, Huyện Nhiên Giang\nNam Định', 'Male', 'user', 'active', NULL, '2024-12-22 10:49:19', NULL, NULL),
(3, 'Giáp Đoan Ngân', 'van.hoan@example.com', '$2y$12$PiIt5aoU/E9oMlEsMR0aN.V0KQSqPbwEOpcCp5YcvFujDS.aPUQfy', '+84-27-955-8261', '47 Phố Lỳ Long Bích, Phường Lễ Thành, Huyện 18\nCần Thơ', 'Male', 'user', 'active', NULL, '2024-06-18 10:49:19', NULL, NULL),
(4, 'Chị. Cái Mai', 'nghi.nghi@example.org', '$2y$12$tpNC46a1L00omzLsi52aBOAaBn8b26BlcxCx2CDpdWJlnk3EXXJDS', '+84-651-279-3281', '6, Thôn Vương Nghi, Xã Phong Tống, Quận 5\nQuảng Bình', 'Male', 'user', 'active', NULL, '2024-10-15 10:49:19', NULL, NULL),
(5, 'Hứa Sa', 'cam56@example.net', '$2y$12$0Mt02gmEjqZc3pZuHHHp1usr.9eDmOQXZGHaiYSzh4BbTjOB79TuS', '(84)(95)393-8245', '282 Phố Đoàn Liêm Khoa, Phường 96, Quận Triệu Bạch\nĐồng Tháp', 'Female', 'user', 'active', NULL, '2024-06-09 10:49:19', NULL, NULL),
(6, 'Chị. Từ Băng', 'diep.dau@example.net', '$2y$12$UM/P21C3r8XzxVtADqdsqetceJpEEFAnq8aTeHZpMnRasqD/hUEui', '(0321)815-2300', '52, Thôn Khiêm Tuyến, Xã Duệ Hạ, Quận Kính Hiền\nQuảng Nam', 'Female', 'user', 'active', NULL, '2024-03-30 10:49:20', NULL, NULL),
(7, 'Bà. Nông Thái Lâm', 'mkhuong@example.com', '$2y$12$hHcaFqDD.xFS2ZSG2cz/cuyfbFHXP2TtSpuZNYEE2I80sWwMxHMq6', '+84-58-998-8695', '81, Ấp Chiến, Thôn Lâm Chung, Huyện Chinh Lý\nLạng Sơn', 'Female', 'user', 'active', NULL, '2024-12-01 10:49:20', NULL, NULL),
(8, 'Bác. Trang Tuyết Khôi', 'khanh59@example.net', '$2y$12$FNNofdtLTnfbU0Tn89JzCOhIyGQPbYEg1txjUjtZ.FGnJw.XjGLli', '(0125)524-2420', '5241, Thôn Ty Doãn, Phường 2, Huyện Ty Hành Thông\nBắc Ninh', 'Female', 'user', 'active', NULL, '2024-04-13 10:49:20', NULL, NULL),
(9, 'Lô Việt', 'ong.quynh@example.org', '$2y$12$v4GZwtzbKdzGyJ0lfJinw.fsC/1EeqJBOSoOsp83sZfVUl/vS9OlG', '027 667 0896', '11, Thôn Đan Dã, Phường Kỷ Vinh, Quận Phụng Lộc\nLạng Sơn', 'Female', 'user', 'active', NULL, '2024-11-10 10:49:20', NULL, NULL),
(10, 'Bác. Khoa Kiều', 'quyen.doan@example.com', '$2y$12$vdZ8K1W8juiyhrec5HqGVuPhNHMjUaFyvfBg28ELeTy7lHh3njUSK', '(073)043-2497', '659 Phố Tòng Phi Cẩn, Phường Cung Mỹ Bằng, Quận Trinh Quế\nCao Bằng', 'Female', 'user', 'active', NULL, '2024-11-30 10:49:20', NULL, NULL),
(11, 'Giao Hoán', 'mkhong@example.net', '$2y$12$425w.LV7hyB5/6IysfovPupwBHETOZz2.g7Ikcr8tmIRKDCNz.q4K', '84-711-297-6694', '247, Ấp Thảo Đan, Xã Nữ Giang, Huyện Sơn Tín\nThừa Thiên Huế', 'Male', 'user', 'active', NULL, '2025-02-04 10:49:21', NULL, NULL),
(12, 'Ngô Phúc', 'loan.banh@example.com', '$2y$12$xTteDU8hLc6ng9wzHlY8ROMuLQwUwOPvDdyIKZjog4/J3ExXLzDP.', '+84-123-401-0360', '97 Phố Hứa Cơ Lệ, Thôn Lư Bảo, Huyện Thủy Thy\nPhú Thọ', 'Female', 'user', 'active', NULL, '2024-10-06 10:49:21', NULL, NULL),
(13, 'Ân Ngọc', 'man43@example.net', '$2y$12$bL/tDXJFRU/BcVYlL/JT6OHCcrLrKax9.v2VlIrPY.nT1rNj3pEvy', '(84)(651)145-9488', '857, Thôn Cự Nhung, Xã Long Lợi, Huyện Ngân Miên\nHậu Giang', 'Male', 'user', 'active', NULL, '2024-06-27 10:49:21', NULL, NULL),
(14, 'Ông. Lã Phong Án', 'dai.loc@example.net', '$2y$12$fsS1MwQVZxSOLMtbtZ1dAOIHj8r0TQFw3A9Nkkzbsv3qMKYFeaBgi', '(0510) 033 4626', '618, Ấp Nam Lý, Phường Thông Diệp, Quận 98\nHà Giang', 'Male', 'user', 'active', NULL, '2024-11-14 10:49:21', NULL, NULL),
(15, 'Lỳ Hiếu', 'zcan@example.net', '$2y$12$gUmJuLhd6FlGff02cY94TeaDZhpzrZLlI1Kfqi9h1zF8m/yezX.PS', '+84-70-550-9976', '78 Phố Toại, Phường Khuê Hồng, Quận Thịnh\nĐà Nẵng', 'Female', 'user', 'active', NULL, '2024-07-16 10:49:21', NULL, NULL),
(16, 'Tiêu Phượng Hiếu', 'nguyen.kha@example.net', '$2y$12$NssREbKL30MMT25x4.op4e8ntCrkLy2L6My1YE3BaKjUY76sNQxty', '(0126)847-6364', '4115 Phố Vi Duyên Như, Ấp Ngân Hà, Huyện 63\nBắc Kạn', 'Female', 'user', 'active', NULL, '2025-01-13 10:49:22', NULL, NULL),
(17, 'Khâu Hiểu Loan', 'nhan75@example.com', '$2y$12$xsmQbZn35CuzDnwP4Y5mWOJRVOS1vkpLqZHU.z/eBlNdAxCKJzJKe', '84-74-427-2423', '865 Phố Nhiệm Tân Tâm, Phường Cam Hà Lân, Huyện 2\nBạc Liêu', 'Male', 'user', 'active', NULL, '2024-08-07 10:49:22', NULL, NULL),
(18, 'Bạc Như Tuyến', 'lac46@example.com', '$2y$12$HuVg3DwQDB4uOXp.MRfsVOUnKkXO/uWrLyaxNDufM3vYcxRiXV7zO', '+84-780-794-9891', '939 Phố Đổng, Phường Thắm Giao, Quận 88\nCần Thơ', 'Male', 'user', 'active', NULL, '2025-02-04 10:49:22', NULL, NULL),
(19, 'Cát Đinh Phụng', 'phong85@example.net', '$2y$12$IcvkrPRk2fnXo4VXyHiLDuY1achu9xBB9h7ZPw7RAMKnmLwqluXqi', '090-791-7651', '46 Phố Hồng Trang Dũng, Xã Cự, Quận Vĩnh Lễ\nKon Tum', 'Male', 'user', 'active', NULL, '2025-02-01 10:49:22', NULL, NULL),
(20, 'Chị. Danh Cầm', 'moc.khoi@example.org', '$2y$12$cEWypLb4tNDLB1v/d6Psy.r3D.RGURFJV5V8dqOmaNDyp9B.ZCoOC', '(0128)673-6533', '5622, Ấp Võ, Xã Đào Bằng Thoại, Quận Thi Điệp\nLong An', 'Female', 'user', 'active', NULL, '2024-07-23 10:49:22', NULL, NULL),
(21, 'kenn', 'giangsunshinee@gmail.com', '$2y$12$Cb5THxWSZ1RN0AZDqGgXledbSHIfm8/MzL9vX/eS2Xkfjw3PRwxIq', '0869311893', 'Ha Noi', 'Male', 'user', 'active', NULL, '2025-02-27 19:17:42', '2025-02-27 19:20:00', NULL),
(22, 'Nguyễn Văn A', 'vietnqph45471@fpt.edu.vn', '$2y$12$aCBrbdGKTQ0DEs0Y6fAQzut.KsAelwsWySZXDnw20oAM9/GYdXvTC', '0987654321', 'Hà Nội', 'Male', 'user', 'active', NULL, '2025-03-06 09:46:02', '2025-03-06 09:46:02', NULL),
(23, 'Nguyễn Văn B', 'chu@gmail.com', '$2y$12$gee0n/c8RdLOzq9Qe/FU9ehzMLkpXXLkA.s5lkrJSUg4Fnh9ouPNW', '0334947408', 'Mỹ', 'Male', 'user', 'active', NULL, '2025-03-06 09:48:31', '2025-03-06 09:48:31', NULL),
(24, 'Trần Văn Chú', 'viet@gmail.com', '$2y$12$elNwHW/d.7DTBqepYWKH..hkB79UFwqhobt5LPUK14W7Sam4caQ26', '0987654322', '315 Phố Cẩn, Phường Bích, Huyện Liên KhoátCà Mau', 'Male', 'user', 'active', NULL, '2025-03-06 09:55:09', '2025-03-06 09:55:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_vouchers`
--

CREATE TABLE `user_vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `id_voucher` bigint UNSIGNED DEFAULT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_vouchers`
--

INSERT INTO `user_vouchers` (`id`, `id_user`, `id_voucher`, `is_used`, `created_at`, `updated_at`) VALUES
(1, 5, 2, 1, '2025-01-24 21:38:27', NULL),
(2, 5, 9, 1, '2025-02-06 09:03:29', NULL),
(3, 14, 10, 0, '2025-01-05 21:21:52', NULL),
(4, 14, 10, 1, '2025-01-10 18:59:25', NULL),
(5, 6, 1, 1, '2025-02-06 01:27:40', NULL),
(6, 6, 5, 1, '2025-01-05 13:12:48', NULL),
(7, 8, 7, 0, '2025-01-12 16:45:28', NULL),
(8, 8, 2, 1, '2025-02-06 16:57:31', NULL),
(9, 18, 10, 1, '2025-01-22 13:32:23', NULL),
(10, 18, 4, 1, '2025-01-01 11:01:36', NULL),
(11, 2, 9, 0, '2025-02-02 16:04:42', NULL),
(12, 2, 8, 0, '2025-02-01 18:51:36', NULL),
(13, 12, 7, 0, '2025-01-27 01:59:09', NULL),
(14, 12, 8, 0, '2025-02-15 05:20:25', NULL),
(15, 13, 5, 0, '2025-01-13 03:25:31', NULL),
(16, 13, 5, 1, '2025-01-17 10:26:33', NULL),
(17, 11, 9, 1, '2025-01-12 13:10:17', NULL),
(18, 11, 8, 0, '2025-01-24 11:33:34', NULL),
(19, 7, 6, 0, '2025-02-13 18:40:04', NULL),
(20, 7, 3, 1, '2025-02-03 09:09:18', NULL),
(21, 20, 3, 1, '2025-01-12 11:50:00', NULL),
(22, 20, 3, 0, '2025-01-20 23:54:18', NULL),
(23, 4, 9, 1, '2025-01-29 05:39:00', NULL),
(24, 4, 9, 1, '2025-01-29 21:12:24', NULL),
(25, 16, 1, 1, '2025-01-29 09:51:13', NULL),
(26, 16, 3, 1, '2025-01-12 04:46:25', NULL),
(27, 17, 5, 0, '2025-02-14 09:58:24', NULL),
(28, 17, 2, 1, '2025-02-02 05:34:33', NULL),
(29, 9, 7, 1, '2025-02-04 21:13:00', NULL),
(30, 9, 9, 0, '2025-01-07 15:03:18', NULL),
(31, 1, 9, 0, '2025-01-14 14:54:50', NULL),
(32, 1, 10, 1, '2025-02-10 23:41:29', NULL),
(33, 19, 5, 1, '2025-01-29 04:20:35', NULL),
(34, 19, 5, 1, '2025-02-11 22:47:19', NULL),
(35, 10, 1, 1, '2025-01-20 02:51:40', NULL),
(36, 10, 9, 1, '2025-01-21 08:34:35', NULL),
(37, 3, 7, 0, '2025-02-05 03:11:36', NULL),
(38, 3, 4, 0, '2025-02-05 04:56:44', NULL),
(39, 15, 5, 1, '2025-01-10 13:25:56', NULL),
(40, 15, 4, 0, '2025-01-25 12:35:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `variants`
--

CREATE TABLE `variants` (
  `id` bigint UNSIGNED NOT NULL,
  `id_product` bigint UNSIGNED DEFAULT NULL,
  `id_color` bigint UNSIGNED DEFAULT NULL,
  `id_size` bigint UNSIGNED DEFAULT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `status` enum('available','out_of_stock') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variants`
--

INSERT INTO `variants` (`id`, `id_product`, `id_color`, `id_size`, `price`, `quantity`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 41, 2, 5, 1616000, 15, 'available', '2025-01-03 06:54:30', '2025-03-01 21:21:10', NULL),
(2, 41, 5, 1, 1532000, 19, 'available', '2025-01-20 12:46:46', '2025-03-02 08:31:11', NULL),
(3, 41, 1, 7, 1123000, 12, 'available', '2025-01-11 04:13:05', NULL, NULL),
(5, 42, 4, 11, 1837000, 45, 'available', '2025-01-08 04:46:08', '2025-02-23 02:02:58', NULL),
(6, 42, 2, 1, 960000, 16, 'available', '2025-01-20 01:57:34', '2025-02-23 02:03:26', NULL),
(7, NULL, 2, 8, 331000, 35, 'available', '2025-01-16 03:37:09', NULL, NULL),
(8, NULL, 2, 2, 1577000, 39, 'available', '2025-01-14 23:31:23', NULL, NULL),
(9, NULL, 4, 4, 1654000, 4, 'available', '2025-01-14 23:29:23', NULL, NULL),
(10, NULL, 1, 5, 712000, 48, 'available', '2025-01-25 06:09:38', NULL, NULL),
(11, NULL, 1, 2, 778000, 50, 'available', '2025-01-25 22:50:43', NULL, NULL),
(12, NULL, 5, 9, 652000, 8, 'available', '2025-02-04 10:00:15', NULL, NULL),
(13, NULL, 3, 11, 1960000, 23, 'available', '2025-01-13 04:16:57', NULL, NULL),
(14, NULL, 2, 3, 279000, 34, 'available', '2025-02-11 03:34:21', NULL, NULL),
(15, NULL, 1, 5, 227000, 19, 'available', '2025-02-07 18:14:33', NULL, NULL),
(16, NULL, 5, 9, 786000, 35, 'available', '2025-02-08 06:45:54', NULL, NULL),
(17, NULL, 3, 4, 964000, 29, 'available', '2025-01-24 05:09:17', NULL, NULL),
(18, NULL, 3, 6, 1844000, 25, 'available', '2025-02-09 08:19:21', NULL, NULL),
(19, NULL, 3, 11, 1633000, 41, 'available', '2025-01-12 16:47:53', NULL, NULL),
(20, NULL, 2, 6, 1611000, 40, 'available', '2025-01-11 23:32:26', NULL, NULL),
(21, NULL, 1, 5, 924000, 30, 'available', '2025-01-28 00:44:00', NULL, NULL),
(22, NULL, 1, 4, 757000, 33, 'available', '2025-02-02 05:09:03', NULL, NULL),
(23, NULL, 2, 2, 1921000, 41, 'available', '2025-01-19 13:57:48', NULL, NULL),
(24, NULL, 1, 4, 818000, 18, 'available', '2025-01-01 23:23:58', NULL, NULL),
(25, NULL, 2, 6, 1627000, 35, 'available', '2025-02-12 05:54:29', NULL, NULL),
(26, NULL, 4, 5, 1715000, 19, 'available', '2025-01-12 10:59:11', NULL, NULL),
(27, NULL, 4, 9, 1337000, 12, 'available', '2025-01-12 03:28:34', NULL, NULL),
(28, NULL, 1, 9, 1005000, 49, 'available', '2025-02-08 04:06:28', NULL, NULL),
(29, NULL, 4, 8, 825000, 27, 'available', '2025-02-10 03:31:24', NULL, NULL),
(30, NULL, 4, 1, 586000, 15, 'available', '2025-01-01 04:22:57', NULL, NULL),
(31, NULL, 5, 8, 1140000, 18, 'available', '2025-01-31 11:57:00', NULL, NULL),
(32, NULL, 5, 7, 534000, 18, 'available', '2025-01-26 08:05:42', NULL, NULL),
(33, NULL, 1, 6, 820000, 6, 'available', '2025-02-10 21:36:17', NULL, NULL),
(34, NULL, 2, 8, 1377000, 36, 'available', '2025-01-29 14:40:57', NULL, NULL),
(35, NULL, 2, 7, 127000, 8, 'available', '2025-02-11 03:39:04', NULL, NULL),
(36, NULL, 1, 11, 1588000, 41, 'available', '2025-01-08 14:44:00', NULL, NULL),
(37, NULL, 5, 8, 1083000, 4, 'available', '2025-01-06 13:38:19', NULL, NULL),
(38, NULL, 3, 6, 1117000, 44, 'available', '2025-01-02 09:39:50', NULL, NULL),
(39, NULL, 5, 7, 937000, 4, 'available', '2025-01-15 23:51:31', NULL, NULL),
(40, NULL, 3, 2, 497000, 26, 'available', '2025-01-01 07:09:14', NULL, NULL),
(41, NULL, 2, 1, 435000, 19, 'available', '2025-01-04 12:09:56', NULL, NULL),
(42, NULL, 2, 1, 1862000, 2, 'available', '2025-02-12 14:06:11', NULL, NULL),
(43, NULL, 4, 11, 282000, 28, 'available', '2025-02-06 15:37:24', NULL, NULL),
(44, NULL, 3, 4, 1356000, 14, 'available', '2025-01-10 20:22:39', NULL, NULL),
(45, NULL, 5, 9, 1216000, 29, 'available', '2025-01-04 04:32:51', NULL, NULL),
(46, NULL, 5, 8, 888000, 9, 'available', '2025-01-08 01:11:20', NULL, NULL),
(47, NULL, 5, 5, 1394000, 24, 'available', '2025-01-28 06:34:22', NULL, NULL),
(48, NULL, 5, 2, 1001000, 8, 'available', '2025-01-07 21:53:31', NULL, NULL),
(49, NULL, 5, 11, 421000, 28, 'available', '2025-01-30 13:20:47', NULL, NULL),
(50, NULL, 3, 10, 1265000, 32, 'available', '2025-02-11 22:21:03', NULL, NULL),
(51, NULL, 3, 5, 259000, 21, 'available', '2025-01-05 02:18:16', NULL, NULL),
(52, NULL, 4, 6, 645000, 22, 'available', '2025-01-20 04:00:05', NULL, NULL),
(53, NULL, 2, 2, 168000, 21, 'available', '2025-01-24 02:21:44', NULL, NULL),
(54, NULL, 1, 9, 202000, 50, 'available', '2025-01-06 04:14:28', NULL, NULL),
(55, NULL, 2, 8, 503000, 17, 'available', '2025-01-21 00:13:56', NULL, NULL),
(56, NULL, 4, 1, 371000, 11, 'available', '2025-01-03 18:58:16', NULL, NULL),
(57, NULL, 1, 1, 1935000, 21, 'available', '2025-02-05 01:30:14', NULL, NULL),
(58, NULL, 4, 11, 1849000, 43, 'available', '2025-02-03 03:21:24', NULL, NULL),
(59, NULL, 5, 7, 1354000, 19, 'available', '2025-02-04 21:49:17', NULL, NULL),
(60, NULL, 5, 6, 601000, 19, 'available', '2025-01-08 10:14:33', NULL, NULL),
(61, 43, 1, 4, 884000, 21, 'available', '2025-01-09 03:08:12', '2025-03-01 21:26:43', NULL),
(62, 43, 4, 2, 1050000, 34, 'available', '2025-01-10 19:33:31', NULL, NULL),
(63, 43, 4, 7, 262000, 10, 'available', '2025-01-18 22:39:46', NULL, NULL),
(64, 48, 2, 6, 112000, 5, 'available', '2025-01-11 20:09:37', NULL, NULL),
(65, 48, 2, 2, 884000, 8, 'available', '2025-02-04 18:08:01', NULL, NULL),
(66, 48, 5, 11, 171000, 26, 'available', '2025-01-27 10:40:19', NULL, NULL),
(67, 55, 4, 3, 1790000, 46, 'available', '2025-02-10 09:43:08', NULL, NULL),
(68, 55, 3, 7, 1755000, 23, 'available', '2025-01-06 17:57:36', NULL, NULL),
(69, 55, 4, 6, 404000, 17, 'available', '2025-02-07 11:31:45', NULL, NULL),
(70, 58, 1, 3, 859000, 39, 'available', '2025-01-26 22:32:50', NULL, NULL),
(71, 58, 5, 6, 1745000, 31, 'available', '2025-01-21 07:43:24', NULL, NULL),
(72, 58, 4, 11, 1023000, 15, 'available', '2025-01-20 12:10:43', NULL, NULL),
(73, 42, 5, 11, 456000, 44, 'available', '2025-02-13 19:01:59', '2025-02-23 01:53:23', NULL),
(76, 46, 5, 7, 1051000, 3, 'available', '2025-02-05 05:39:42', NULL, NULL),
(77, 46, 3, 11, 602000, 20, 'available', '2025-01-29 19:12:40', NULL, NULL),
(78, 46, 5, 8, 1813000, 17, 'available', '2025-01-09 19:33:54', NULL, NULL),
(79, 49, 1, 8, 1484000, 22, 'available', '2025-01-18 15:54:44', NULL, NULL),
(80, 49, 3, 7, 1228000, 27, 'available', '2025-01-24 01:33:02', NULL, NULL),
(81, 49, 3, 5, 1521000, 35, 'available', '2025-01-02 16:36:31', NULL, NULL),
(82, 50, 3, 6, 914000, 40, 'available', '2025-01-23 15:31:50', NULL, NULL),
(83, 50, 4, 10, 815000, 19, 'available', '2025-01-04 14:09:02', NULL, NULL),
(84, 50, 2, 7, 226000, 13, 'available', '2025-01-21 02:54:18', NULL, NULL),
(85, 53, 4, 10, 1920000, 33, 'available', '2025-01-08 02:27:51', NULL, NULL),
(86, 53, 5, 10, 1564000, 17, 'available', '2025-02-05 23:58:14', NULL, NULL),
(87, 53, 2, 5, 1956000, 24, 'available', '2025-01-27 12:43:31', NULL, NULL),
(88, 56, 3, 4, 373000, 48, 'available', '2025-01-22 09:00:53', NULL, NULL),
(89, 56, 1, 2, 1270000, 12, 'available', '2025-02-15 10:28:01', NULL, NULL),
(90, 56, 2, 4, 1801000, 16, 'available', '2025-02-06 04:42:15', NULL, NULL),
(91, 57, 4, 10, 745000, 16, 'available', '2025-01-25 03:24:53', NULL, NULL),
(92, 57, 5, 11, 538000, 22, 'available', '2025-01-22 19:39:27', NULL, NULL),
(93, 57, 5, 3, 746000, 28, 'available', '2025-02-15 08:34:27', NULL, NULL),
(96, 44, 5, 7, 665000, 44, 'available', '2025-02-01 05:44:50', '2025-03-01 21:29:01', NULL),
(97, 45, 2, 7, 1327000, 25, 'available', '2025-02-06 14:01:43', NULL, NULL),
(98, 45, 4, 1, 615000, 37, 'available', '2025-02-13 07:55:54', NULL, NULL),
(99, 45, 3, 11, 1371000, 8, 'available', '2025-02-11 02:40:26', NULL, NULL),
(100, 47, 5, 9, 1406000, 20, 'available', '2025-02-07 13:59:28', NULL, NULL),
(101, 47, 5, 7, 1025000, 29, 'available', '2025-02-14 04:57:13', NULL, NULL),
(102, 47, 2, 4, 1959000, 10, 'available', '2025-01-25 02:09:54', NULL, NULL),
(103, 52, 4, 8, 1042000, 38, 'available', '2025-01-13 03:36:48', NULL, NULL),
(104, 52, 5, 5, 217000, 37, 'available', '2025-01-08 07:56:00', NULL, NULL),
(105, 52, 3, 6, 1488000, 22, 'available', '2025-02-10 14:38:58', NULL, NULL),
(106, 59, 5, 9, 453000, 35, 'available', '2025-01-27 01:31:07', NULL, NULL),
(107, 59, 5, 11, 234000, 26, 'available', '2025-01-21 04:32:44', NULL, NULL),
(108, 59, 5, 3, 615000, 45, 'available', '2025-01-07 00:43:01', NULL, NULL),
(112, 51, 5, 7, 458000, 12, 'available', '2025-01-27 22:00:47', NULL, NULL),
(113, 51, 4, 10, 524000, 3, 'available', '2025-02-05 12:31:31', NULL, NULL),
(114, 51, 1, 10, 1357000, 14, 'available', '2025-01-28 01:39:55', NULL, NULL),
(115, 54, 3, 7, 127000, 15, 'available', '2025-02-04 10:55:40', NULL, NULL),
(116, 54, 1, 8, 311000, 44, 'available', '2025-01-16 11:16:02', NULL, NULL),
(117, 54, 1, 5, 260000, 25, 'available', '2025-01-07 10:44:22', NULL, NULL),
(118, 60, 2, 8, 1953000, 30, 'available', '2025-01-17 07:04:59', NULL, NULL),
(119, 60, 1, 3, 243000, 42, 'available', '2025-01-30 19:20:09', NULL, NULL),
(120, 60, 3, 3, 1850000, 20, 'available', '2025-02-08 09:39:08', NULL, NULL),
(125, 62, 1, 2, 123456, 1, 'available', '2025-02-22 20:38:02', '2025-02-22 21:33:40', NULL),
(126, 62, 1, 1, 200000, 10, 'available', '2025-02-22 20:41:12', '2025-02-22 21:57:41', NULL),
(128, 44, 1, 1, 200000, 1, 'available', '2025-02-23 02:31:14', '2025-02-23 02:31:14', NULL),
(129, 44, 2, 2, 20000, 1, 'available', '2025-02-23 02:32:02', '2025-02-23 02:32:02', NULL),
(130, 63, 1, 1, 2000, 11, 'available', '2025-02-23 02:36:10', '2025-02-23 02:36:10', NULL),
(131, 63, 1, 2, 200010, 12, 'available', '2025-02-25 08:18:55', '2025-02-25 08:18:55', NULL),
(132, 64, 1, 1, 2000, 12, 'available', '2025-02-25 08:56:07', '2025-02-25 08:56:07', NULL),
(133, 65, 1, 1, 2500000, 10, 'available', '2025-03-01 09:58:37', '2025-03-01 21:13:20', NULL),
(134, 66, 1, 1, 100000, 10, 'available', '2025-03-01 19:54:21', '2025-03-01 19:54:21', NULL),
(136, 61, 1, 4, 20000, 1, 'available', '2025-03-01 20:53:13', '2025-03-01 20:53:13', NULL),
(139, 68, 1, 1, 123456, 12, 'available', '2025-03-02 08:49:54', '2025-03-02 08:49:54', NULL),
(140, 68, 1, 1, 1234, 12, 'available', '2025-03-02 08:49:54', '2025-03-02 08:49:54', NULL),
(141, 69, 1, 1, 100000, 1, 'available', '2025-03-08 19:53:53', '2025-03-08 19:53:53', NULL),
(142, 70, 1, 1, 213543, 12, 'available', '2025-03-08 20:14:22', '2025-03-08 20:14:22', NULL),
(143, 71, 1, 1, 2314, 3, 'available', '2025-03-08 20:16:09', '2025-03-08 20:16:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type` enum('percentage','fixed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_value` int NOT NULL,
  `min_order_value` int DEFAULT NULL,
  `max_discount` int DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `usage_limit` int NOT NULL DEFAULT '1',
  `quantity` int NOT NULL,
  `used_count` int NOT NULL DEFAULT '0',
  `status` enum('active','expired','disabled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `discount_type`, `discount_value`, `min_order_value`, `max_discount`, `start_date`, `end_date`, `usage_limit`, `quantity`, `used_count`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TZV3G0A7', 'fixed', 429000, 521000, NULL, '2025-02-20 00:00:00', '2025-02-21 00:00:00', 1, 0, 0, 'active', '2025-01-07 11:57:33', '2025-02-21 10:42:17'),
(2, 'RFHXDG30', 'percentage', 49, 1782000, 267000, '2025-01-01 08:44:56', '2025-03-09 17:50:54', 3, 0, 0, 'disabled', '2025-01-01 01:44:56', '2025-03-01 07:53:23'),
(3, '37MYAYBM', 'fixed', 474000, 1360000, NULL, '2025-01-06 18:33:41', '2025-03-04 17:50:54', 1, 0, 0, 'disabled', '2025-01-06 11:33:41', '2025-02-25 09:06:31'),
(4, 'WBUOVWYI', 'percentage', 50, 1424000, 125000, '2025-01-27 21:51:28', '2025-03-07 17:50:54', 3, 0, 0, 'active', '2025-01-27 14:51:28', '2025-02-15 10:50:54'),
(5, 'ABALAVX8', 'fixed', 278000, 1902000, NULL, '2025-01-21 18:38:04', '2025-03-07 17:50:54', 3, 0, 0, 'active', '2025-01-21 11:38:04', '2025-02-15 10:50:54'),
(6, 'IPIIYY6K', 'fixed', 414000, 526000, NULL, '2025-01-06 07:17:26', '2025-03-06 17:50:54', 2, 0, 0, 'active', '2025-01-06 00:17:26', '2025-02-15 10:50:54'),
(7, '9EVUWTPK', 'percentage', 10, 1466000, 244000, '2025-02-03 08:32:58', '2025-02-27 17:50:54', 1, 0, 0, 'active', '2025-02-03 01:32:58', '2025-02-15 10:50:54'),
(8, 'RDS6LZ06', 'percentage', 30, 971000, 372000, '2025-01-16 00:35:17', '2025-03-03 17:50:54', 3, 0, 0, 'active', '2025-01-15 17:35:17', '2025-02-15 10:50:54'),
(9, 'BPVQYDIK', 'percentage', 48, 613000, 127000, '2025-02-08 00:42:26', '2025-03-08 17:50:54', 1, 0, 0, 'active', '2025-02-07 17:42:26', '2025-02-15 10:50:54'),
(10, 'TNTR4JDV', 'percentage', 37, 1016000, 442000, '2025-01-29 03:41:35', '2025-03-11 17:50:54', 1, 0, 0, 'active', '2025-01-28 20:41:35', '2025-02-15 10:50:54'),
(11, 'DGHFY', 'fixed', 10000, 10000, NULL, '2025-02-19 00:00:00', '2025-02-21 00:00:00', 1, 0, 0, 'active', '2025-02-19 09:30:56', '2025-02-19 09:30:56'),
(13, 'VIET', 'percentage', 20, 10000, NULL, '2025-02-19 00:00:00', '2025-02-27 00:00:00', 2, 0, 0, 'active', '2025-02-19 09:35:56', '2025-02-19 09:35:56'),
(16, 'VIET2', 'percentage', 10, NULL, NULL, '2025-03-01 00:00:00', '2025-03-10 00:00:00', 1, 10, 0, 'active', '2025-03-01 08:02:03', '2025-03-01 08:02:03'),
(17, 'TZV3G0A723', 'fixed', 210000, NULL, NULL, '2025-03-01 00:00:00', '2025-03-03 00:00:00', 1, 10, 0, 'active', '2025-03-01 08:39:50', '2025-03-01 08:39:50'),
(18, 'TZV3G0A7677', 'fixed', 100000, 100000, NULL, '2025-03-01 00:00:00', '2025-03-02 00:00:00', 1, 10, 0, 'active', '2025-03-01 08:44:32', '2025-03-01 08:56:58'),
(19, 'VIETYSUAN', 'percentage', 10, 100000, 100000, '2025-03-09 00:00:00', '2025-03-16 00:00:00', 1, 10, 0, 'active', '2025-03-08 19:52:11', '2025-03-08 19:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'VND',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `id_user`, `balance`, `currency`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, '3851000.00', 'VND', 'active', '2025-01-19 07:44:32', NULL),
(2, 14, '230000.00', 'VND', 'active', '2025-02-11 06:48:11', NULL),
(3, 6, '1879000.00', 'VND', 'active', '2025-02-06 11:28:35', NULL),
(4, 8, '7369000.00', 'VND', 'active', '2025-01-19 05:41:15', NULL),
(5, 18, '8218000.00', 'VND', 'active', '2025-02-09 01:33:39', NULL),
(6, 2, '4181000.00', 'VND', 'active', '2025-01-09 18:43:23', NULL),
(7, 12, '5559000.00', 'VND', 'active', '2025-01-27 23:06:03', NULL),
(8, 13, '9733000.00', 'VND', 'active', '2025-01-11 00:08:56', NULL),
(9, 11, '4846000.00', 'VND', 'active', '2025-01-25 00:26:29', NULL),
(10, 7, '3395000.00', 'VND', 'active', '2025-01-31 19:26:38', NULL),
(11, 20, '623000.00', 'VND', 'active', '2025-02-08 20:15:36', NULL),
(12, 4, '9545000.00', 'VND', 'active', '2025-02-01 15:30:05', NULL),
(13, 16, '5080000.00', 'VND', 'active', '2025-02-01 20:28:05', NULL),
(14, 17, '6312000.00', 'VND', 'active', '2025-02-10 20:11:52', NULL),
(15, 9, '6171000.00', 'VND', 'active', '2025-02-06 05:25:51', NULL),
(16, 1, '1410000.00', 'VND', 'active', '2025-01-08 23:43:28', NULL),
(17, 19, '2358000.00', 'VND', 'active', '2025-01-12 06:25:46', NULL),
(18, 10, '1035000.00', 'VND', 'active', '2025-02-10 01:19:56', NULL),
(19, 3, '2543000.00', 'VND', 'active', '2025-01-13 13:19:40', NULL),
(20, 15, '3853000.00', 'VND', 'active', '2025-01-16 15:44:13', NULL),
(21, 24, '0.00', 'VND', 'active', '2025-03-06 09:55:09', '2025-03-06 09:55:09');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `id_wallet` bigint UNSIGNED DEFAULT NULL,
  `transaction_type` enum('deposit','withdrawal','purchase','refund') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'deposit',
  `amount` decimal(15,2) NOT NULL,
  `balance_before` decimal(15,2) NOT NULL,
  `balance_after` decimal(15,2) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','completed','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_transactions`
--

INSERT INTO `wallet_transactions` (`id`, `id_wallet`, `transaction_type`, `amount`, `balance_before`, `balance_after`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 16, 'deposit', '740000.00', '1975000.00', '2715000.00', 'Quam distinctio vitae perferendis quod unde sunt.', 'completed', '2025-01-04 07:50:50', NULL),
(2, 6, 'withdrawal', '972000.00', '2632000.00', '1660000.00', 'Qui id impedit modi nostrum nihil autem laboriosam.', 'completed', '2025-01-27 22:54:10', NULL),
(3, 19, 'purchase', '334000.00', '2428000.00', '2094000.00', 'Repellat eligendi odio nemo recusandae.', 'completed', '2025-01-26 02:08:14', NULL),
(4, 12, 'withdrawal', '749000.00', '1329000.00', '580000.00', 'Est assumenda enim omnis laudantium.', 'completed', '2025-01-16 20:55:25', NULL),
(5, 1, 'deposit', '644000.00', '2233000.00', '2877000.00', 'Quibusdam eveniet expedita similique nisi aliquid esse.', 'completed', '2025-01-20 07:27:17', NULL),
(6, 3, 'withdrawal', '797000.00', '1655000.00', '858000.00', 'Earum dicta vel dolor quia et.', 'completed', '2025-01-17 10:20:26', NULL),
(7, 10, 'purchase', '538000.00', '971000.00', '433000.00', 'Autem ut consectetur maiores.', 'completed', '2025-02-02 01:46:44', NULL),
(8, 4, 'purchase', '728000.00', '3260000.00', '2532000.00', 'Ut provident voluptatem alias in cumque quia.', 'completed', '2025-02-07 10:44:13', NULL),
(9, 15, 'withdrawal', '720000.00', '3595000.00', '2875000.00', 'Quas corporis quisquam laboriosam ex doloribus.', 'completed', '2025-02-09 00:28:47', NULL),
(10, 18, 'refund', '553000.00', '4267000.00', '4820000.00', 'Totam unde qui provident voluptatibus ab autem.', 'completed', '2025-01-14 00:36:46', NULL),
(11, 9, 'withdrawal', '252000.00', '803000.00', '551000.00', 'Odio ex culpa mollitia minus consequatur unde.', 'completed', '2025-01-18 00:52:47', NULL),
(12, 7, 'refund', '847000.00', '562000.00', '1409000.00', 'Qui eveniet laudantium dolorum.', 'completed', '2025-01-27 01:24:20', NULL),
(13, 8, 'purchase', '904000.00', '2814000.00', '1910000.00', 'Laboriosam hic ducimus vero distinctio.', 'completed', '2025-01-24 13:10:12', NULL),
(14, 2, 'refund', '543000.00', '2444000.00', '2987000.00', 'Et dolorem omnis hic error in maxime.', 'completed', '2025-01-22 00:31:14', NULL),
(15, 20, 'purchase', '661000.00', '4558000.00', '3897000.00', 'Est minima repellat id consequatur esse aliquid.', 'completed', '2025-02-12 01:41:56', NULL),
(16, 13, 'withdrawal', '175000.00', '1032000.00', '857000.00', 'Dolor expedita reprehenderit est sunt occaecati aut.', 'completed', '2025-01-18 10:56:00', NULL),
(17, 14, 'withdrawal', '268000.00', '3373000.00', '3105000.00', 'Delectus reprehenderit quia officiis voluptates.', 'completed', '2025-01-12 18:53:41', NULL),
(18, 5, 'deposit', '623000.00', '1896000.00', '2519000.00', 'Et beatae optio dignissimos distinctio iusto aut.', 'completed', '2025-01-14 07:40:35', NULL),
(19, 17, 'refund', '925000.00', '4762000.00', '5687000.00', 'Explicabo autem autem fuga ullam voluptas qui sunt.', 'completed', '2025-01-30 01:14:27', NULL),
(20, 11, 'purchase', '657000.00', '828000.00', '171000.00', 'Non nisi tempora molestias natus ut rerum in.', 'completed', '2025-01-23 05:38:09', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_id_user_foreign` (`id_user`),
  ADD KEY `carts_id_variant_foreign` (`id_variant`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `colors_name_unique` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_id_user_foreign` (`id_user`),
  ADD KEY `comments_id_product_foreign` (`id_product`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_username_unique` (`username`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD UNIQUE KEY `employees_phone_unique` (`phone`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_id_user_foreign` (`id_user`),
  ADD KEY `favorites_id_product_foreign` (`id_product`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_employee` (`id_employee`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_id_user_foreign` (`id_user`),
  ADD KEY `orders_id_voucher_foreign` (`id_voucher`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_id_order_foreign` (`id_order`),
  ADD KEY `order_items_id_variant_foreign` (`id_variant`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_id_employee_foreign` (`id_employee`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id_category_foreign` (`id_category`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_id_variant_foreign` (`id_variant`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rates_id_user_id_product_id_order_item_unique` (`id_user`,`id_product`,`id_order_item`),
  ADD KEY `rates_id_product_foreign` (`id_product`),
  ADD KEY `rates_id_order_item_foreign` (`id_order_item`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sizes_size_unique` (`size`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Indexes for table `user_vouchers`
--
ALTER TABLE `user_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_vouvhers_id_user_foreign` (`id_user`),
  ADD KEY `user_vouvhers_id_voucher_foreign` (`id_voucher`);

--
-- Indexes for table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variants_id_product_foreign` (`id_product`),
  ADD KEY `variants_id_color_foreign` (`id_color`),
  ADD KEY `variants_id_size_foreign` (`id_size`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_code_unique` (`code`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallets_id_user_foreign` (`id_user`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_transactions_id_wallet_foreign` (`id_wallet`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_vouchers`
--
ALTER TABLE `user_vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `variants`
--
ALTER TABLE `variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `carts_id_variant_foreign` FOREIGN KEY (`id_variant`) REFERENCES `variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `comments_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `favorites_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`id_employee`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_id_voucher_foreign` FOREIGN KEY (`id_voucher`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_id_order_foreign` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_id_variant_foreign` FOREIGN KEY (`id_variant`) REFERENCES `variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_id_employee_foreign` FOREIGN KEY (`id_employee`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_id_variant_foreign` FOREIGN KEY (`id_variant`) REFERENCES `variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `rates`
--
ALTER TABLE `rates`
  ADD CONSTRAINT `rates_id_order_item_foreign` FOREIGN KEY (`id_order_item`) REFERENCES `order_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rates_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rates_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_vouchers`
--
ALTER TABLE `user_vouchers`
  ADD CONSTRAINT `user_vouvhers_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_vouvhers_id_voucher_foreign` FOREIGN KEY (`id_voucher`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `variants`
--
ALTER TABLE `variants`
  ADD CONSTRAINT `variants_id_color_foreign` FOREIGN KEY (`id_color`) REFERENCES `colors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `variants_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `variants_id_size_foreign` FOREIGN KEY (`id_size`) REFERENCES `sizes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_id_wallet_foreign` FOREIGN KEY (`id_wallet`) REFERENCES `wallets` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
