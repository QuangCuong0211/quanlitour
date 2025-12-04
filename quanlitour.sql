-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 04, 2025 lúc 06:08 AM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlitour`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `booking_code` varchar(50) DEFAULT NULL,
  `tour_id` varchar(50) DEFAULT NULL,
  `tour_name` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `departure` varchar(255) DEFAULT NULL,
  `tour_type` varchar(50) DEFAULT NULL,
  `slot` int DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `identity_number` varchar(50) DEFAULT NULL,
  `adult` int DEFAULT NULL,
  `child` int DEFAULT NULL,
  `baby` int DEFAULT NULL,
  `special_request` text,
  `total_price` decimal(12,2) DEFAULT NULL,
  `deposit` decimal(12,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `staff` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `channel` varchar(50) DEFAULT NULL,
  `note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `booking_code`, `tour_id`, `tour_name`, `start_date`, `end_date`, `departure`, `tour_type`, `slot`, `customer_name`, `gender`, `phone`, `email`, `address`, `identity_number`, `adult`, `child`, `baby`, `special_request`, `total_price`, `deposit`, `payment_method`, `payment_date`, `booking_date`, `staff`, `status`, `channel`, `note`) VALUES
(10, 'BK-2025-94543', '4', NULL, '2025-11-29', '2025-12-02', NULL, NULL, NULL, 'Quang Cường', NULL, '0369813955', 'assss@gmail.com', NULL, NULL, 4, 1, NULL, NULL, 1645000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chill'),
(14, 'BK-2025-21522', '6', NULL, '2025-11-29', '2025-11-04', NULL, NULL, NULL, 'Quang Cường', NULL, '0369813955', 'assss@gmail.com', NULL, NULL, 15, 0, NULL, NULL, 1800000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'k'),
(15, 'BK-2025-99765', '6', NULL, '2025-11-22', '2025-11-23', NULL, NULL, NULL, 'Quang Cường', NULL, '0369813955', 'assss@gmail.com', NULL, NULL, 1, 0, NULL, NULL, 120000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aaaa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên danh mục',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Mô tả danh mục',
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Đường dẫn thân thiện (URL-friendly)',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái: 1=hoạt động, 0=ẩn',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tour Miền Bắc', 'Các tour du lịch tại các địa điểm nổi tiếng miền Bắc Việt Nam', 'tour-mien-bac', 1, '2025-11-21 10:50:03', '2025-11-21 10:50:03'),
(2, 'Tour Miền Trung', 'Các tour du lịch tại các địa điểm nổi tiếng miền Trung Việt Nam', 'tour-mien-trung', 1, '2025-11-21 10:50:03', '2025-11-21 10:50:03'),
(3, 'Tour Miền Nam', 'Các tour du lịch tại các địa điểm nổi tiếng miền Nam Việt Nam', 'tour-mien-nam', 1, '2025-11-21 10:50:03', '2025-11-21 10:50:03'),
(4, 'Tour Nước Ngoài', 'Các tour du lịch quốc tế', 'tour-nuoc-ngoai', 1, '2025-11-21 10:50:03', '2025-11-21 10:50:03'),
(5, 'Tour Phiêu Lưu', 'Các tour phiêu lưu hấp dẫn và kịch tính', 'tour-phieu-luu', 1, '2025-11-21 10:50:03', '2025-11-21 10:50:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên khách hàng',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Email',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Số điện thoại',
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Địa chỉ',
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Thành phố',
  `identity_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Số CMND/CCCD',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái: 1=hoạt động, 0=khóa',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departures`
--

CREATE TABLE `departures` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL COMMENT 'ID của tour',
  `departure_date` date NOT NULL COMMENT 'Ngày khởi hành',
  `return_date` date NOT NULL COMMENT 'Ngày kết thúc/trở về',
  `guide_id` int NOT NULL COMMENT 'ID hướng dẫn viên',
  `seats_available` int NOT NULL DEFAULT '0' COMMENT 'Số ghế có sẵn',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT 'Trạng thái lịch khởi hành',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `guide`
--

CREATE TABLE `guide` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tours`
--

CREATE TABLE `tours` (
  `id` int NOT NULL,
  `tour_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `departure_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `customer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guide` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`id`, `tour_id`, `name`, `description`, `price`, `departure_date`, `status`, `customer`, `guide`, `note`) VALUES
(8, 'T001', 'Hà Nội - Hạ Long 3N2Đ', 'Khởi hành từ Hà Nội, thăm Vịnh Hạ Long – di sản thiên nhiên thế giới.', 3500000, '2025-02-10', 1, 'Nguyễn Văn A', 'Trần Minh Hùng', 'Xe du lịch 29 chỗ'),
(9, 'T002', 'Đà Nẵng - Hội An 4N3Đ', 'Tham quan Cầu Rồng, Ngũ Hành Sơn, Phố cổ Hội An.', 5200000, '2025-03-05', 1, 'Trần Thị B', 'Lê Hải Nam', 'Bao gồm buffet sáng'),
(10, 'T003', 'Sài Gòn - Phú Quốc 3N2Đ', 'Resort 4 sao, vé máy bay khứ hồi, tham quan đảo.', 6800000, '2025-03-20', 0, 'Phạm Minh C', 'Ngô Thanh Tùng', 'Tạm ngưng do mưa bão'),
(11, 'T004', 'Huế - Quảng Bình 5N4Đ', 'Khám phá cố đô Huế, động Phong Nha – Kẻ Bàng.', 7400000, '2025-04-15', 1, 'Lê Hồng D', 'Hoàng Vũ', 'Giảm 10% cho nhóm trên 5 người'),
(12, 'T005', 'Hà Giang - Đồng Văn 3N2Đ', 'Check-in đèo Mã Pí Lèng, Cao nguyên đá Đồng Văn.', 4200000, '2025-05-01', 1, 'Vũ Thu E', 'Phạm Quang Huy', 'Yêu cầu chuẩn bị áo ấm'),
(13, '111', 'từ thiện', 'h', 10000, '2025-12-02', 1, 'm12g', 'Phạm Quang Huy', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên người dùng',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Email',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mật khẩu (đã mã hóa)',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Số điện thoại',
  `role` enum('admin','hdv') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hdv' COMMENT 'Vai trò: admin hoặc hdv (hướng dẫn viên)',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái: 1=hoạt động, 0=khóa',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/TVm', '0123456789', 'admin', 1, '2025-11-21 10:50:58', '2025-11-21 10:50:58');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_status` (`status`);

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_phone` (`phone`),
  ADD KEY `idx_status` (`status`);

--
-- Chỉ mục cho bảng `departures`
--
ALTER TABLE `departures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tour_id` (`tour_id`),
  ADD KEY `idx_guide_id` (`guide_id`),
  ADD KEY `idx_departure_date` (`departure_date`),
  ADD KEY `idx_status` (`status`);

--
-- Chỉ mục cho bảng `guide`
--
ALTER TABLE `guide`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `departures`
--
ALTER TABLE `departures`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `guide`
--
ALTER TABLE `guide`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `departures`
--
ALTER TABLE `departures`
  ADD CONSTRAINT `departures_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `departures_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
