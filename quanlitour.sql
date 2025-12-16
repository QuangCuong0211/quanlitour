-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 16, 2025 lúc 07:24 PM
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
  `booking_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `departure` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slot` int DEFAULT NULL,
  `customer_name` text COLLATE utf8mb4_unicode_ci,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci,
  `email` text COLLATE utf8mb4_unicode_ci,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adult` int DEFAULT NULL,
  `child` int DEFAULT NULL,
  `baby` int DEFAULT NULL,
  `special_request` text COLLATE utf8mb4_unicode_ci,
  `total_price` decimal(12,2) DEFAULT NULL,
  `deposit` decimal(12,2) DEFAULT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `staff` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `channel` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `customer_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `booking_code`, `tour_id`, `tour_name`, `start_date`, `end_date`, `departure`, `tour_type`, `slot`, `customer_name`, `gender`, `phone`, `email`, `address`, `identity_number`, `adult`, `child`, `baby`, `special_request`, `total_price`, `deposit`, `payment_method`, `payment_date`, `booking_date`, `staff`, `status`, `channel`, `note`, `customer_id`) VALUES
(1, 'BK-2025-87085', '1', NULL, '2025-12-16', '2025-12-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, NULL, NULL, 16100000.00, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, 'Gia đình 5 người', NULL),
(2, 'BK-2025-78198', '2', NULL, '2025-12-11', '2025-12-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, NULL, NULL, 24440000.00, NULL, NULL, NULL, NULL, NULL, 'done', NULL, 'Đã cọc 50%', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_customers`
--

CREATE TABLE `booking_customers` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` enum('adult','child') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_customers`
--

INSERT INTO `booking_customers` (`id`, `booking_id`, `name`, `phone`, `email`, `type`) VALUES
(7, 1, 'Trần Quang Cường', '0912345678', 'cuong@gmail.com', 'adult'),
(8, 1, 'Nguyễn Văn A', '0912345679', 'a@gmail.com', 'adult'),
(9, 1, 'Lê Thị B', '0912345680', 'b@gmail.com', 'adult'),
(10, 1, 'Bé Minh', '0912345681', 'minh@gmail.com', 'child'),
(11, 1, 'Bé Lan', '0912345682', 'lan@gmail.com', 'child'),
(37, 2, 'Phạm Văn C', '0987654321', 'c@gmail.com', 'adult'),
(38, 2, 'Nguyễn Thị D', '0987654322', 'd@gmail.com', 'adult'),
(39, 2, 'Hoàng Văn E', '0987654323', 'e@gmail.com', 'adult'),
(40, 2, 'Trần Văn F', '0987654324', 'f@gmail.com', 'adult'),
(41, 2, 'Bé Nam', '0987654325', 'nam@gmail.com', 'child');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_status_history`
--

CREATE TABLE `booking_status_history` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `old_status` varchar(20) DEFAULT NULL,
  `new_status` varchar(20) DEFAULT NULL,
  `changed_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_status_logs`
--

CREATE TABLE `booking_status_logs` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `old_status` varchar(20) DEFAULT NULL,
  `new_status` varchar(20) DEFAULT NULL,
  `changed_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_status_logs`
--

INSERT INTO `booking_status_logs` (`id`, `booking_id`, `old_status`, `new_status`, `changed_at`) VALUES
(1, 16, NULL, 'pending', '2025-12-05 15:17:11'),
(2, 16, 'pending', 'done', '2025-12-05 15:17:15'),
(3, 16, 'done', 'cancel', '2025-12-05 15:17:47'),
(4, 16, 'cancel', 'done', '2025-12-05 15:17:50'),
(5, 16, 'done', 'deposit', '2025-12-05 16:35:35');

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
(5, 'Tour Phiêu Lưu', 'Các tour phiêu lưu hấp dẫn và kịch tính', 'tour-phieu-luu', 1, '2025-11-21 10:50:03', '2025-12-16 18:04:54');

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

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `city`, `identity_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Quang Cường', 'assss@gmail.com', '0369813955', 'hoai duc\r\nlai xa', 'hanoi', '', 1, '2025-12-05 10:11:43', '2025-12-05 10:11:43'),
(6, 'aaa', 'asss@gmail.com', '1233', '', '', '', 1, '2025-12-05 10:49:07', '2025-12-05 10:49:07');

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
-- Cấu trúc bảng cho bảng `guides`
--

CREATE TABLE `guides` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sdt` varchar(20) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `status` tinyint DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `guides`
--

INSERT INTO `guides` (`id`, `name`, `email`, `sdt`, `img`, `status`) VALUES
(1, 'Trần Quang Cường', 'kamitest2005@gmail.com', '0369813955', '1765906587_6941989baed6b.jpg', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tours`
--

CREATE TABLE `tours` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `status` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `guide_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`id`, `name`, `price`, `status`, `created_at`, `guide_id`, `category_id`) VALUES
(1, 'tour 20k', 20000.00, 1, '2025-12-16 08:48:44', NULL, NULL),
(2, 'tour 55k 1N', 55000.00, 1, '2025-12-16 08:55:01', NULL, NULL),
(3, 'tour 50k', 50000.00, 1, '2025-12-16 17:10:16', 1, NULL),
(4, 'tour 100k', 100000.00, 1, '2025-12-16 17:43:39', NULL, 5);

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
(1, 'Administrator', 'admin@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0123456789', 'admin', 1, '2025-11-21 10:50:58', '2025-12-05 10:19:47');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `booking_customers`
--
ALTER TABLE `booking_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `booking_status_history`
--
ALTER TABLE `booking_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `booking_status_logs`
--
ALTER TABLE `booking_status_logs`
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
-- Chỉ mục cho bảng `guides`
--
ALTER TABLE `guides`
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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `booking_customers`
--
ALTER TABLE `booking_customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `booking_status_history`
--
ALTER TABLE `booking_status_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `booking_status_logs`
--
ALTER TABLE `booking_status_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `departures`
--
ALTER TABLE `departures`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `guides`
--
ALTER TABLE `guides`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `booking_customers`
--
ALTER TABLE `booking_customers`
  ADD CONSTRAINT `booking_customers_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `booking_status_history`
--
ALTER TABLE `booking_status_history`
  ADD CONSTRAINT `booking_status_history_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);

--
-- Các ràng buộc cho bảng `departures`
--
ALTER TABLE `departures`
  ADD CONSTRAINT `departures_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
