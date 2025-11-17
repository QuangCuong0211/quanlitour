-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 17, 2025 lúc 08:54 AM
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
-- Cơ sở dữ liệu: `quanly_tour`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baocaocongviec`
--

CREATE TABLE `baocaocongviec` (
  `id` int NOT NULL,
  `guide_id` int NOT NULL,
  `tour_id` int NOT NULL,
  `report_type` varchar(100) DEFAULT NULL,
  `content` text,
  `report_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `baocaocongviec`
--

INSERT INTO `baocaocongviec` (`id`, `guide_id`, `tour_id`, `report_type`, `content`, `report_date`) VALUES
(1, 2, 1, 'hàng ngày', 'Đưa đoàn đi thăm động Thiên Cung và Hang Đầu Gỗ. Thời tiết đẹp, khách hài lòng.', '2025-11-20'),
(2, 3, 2, 'sự cố', 'Một khách bị say xe nhẹ, đã được hỗ trợ.', '2025-12-05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cauhinhhethong`
--

CREATE TABLE `cauhinhhethong` (
  `id` int NOT NULL,
  `config_name` varchar(255) DEFAULT NULL,
  `config_value` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `cauhinhhethong`
--

INSERT INTO `cauhinhhethong` (`id`, `config_name`, `config_value`, `description`) VALUES
(1, 'email_support', 'support@tour.com', 'Email hỗ trợ khách hàng'),
(2, 'max_tours_per_guide', '3', 'Số lượng tour tối đa một hướng dẫn viên có thể phụ trách'),
(3, 'currency', 'VND', 'Đơn vị tiền tệ mặc định');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgiadiem`
--

CREATE TABLE `danhgiadiem` (
  `id` int NOT NULL,
  `place_id` int NOT NULL,
  `guide_id` int NOT NULL,
  `content` text,
  `rating` int DEFAULT NULL
) ;

--
-- Đang đổ dữ liệu cho bảng `danhgiadiem`
--

INSERT INTO `danhgiadiem` (`id`, `place_id`, `guide_id`, `content`, `rating`) VALUES
(1, 1, 2, 'Điểm tham quan tuyệt vời, khách rất thích chụp ảnh.', 5),
(2, 2, 2, 'Khung cảnh đẹp, cần thêm thời gian tham quan.', 4),
(3, 3, 3, 'Quảng trường rất đẹp, khách hào hứng chụp hình.', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dattour`
--

CREATE TABLE `dattour` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `tour_id` int NOT NULL,
  `booking_date` date DEFAULT NULL,
  `num_people` int DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `dattour`
--

INSERT INTO `dattour` (`id`, `customer_id`, `tour_id`, `booking_date`, `num_people`, `status`) VALUES
(1, 1, 1, '2025-11-01', 2, 'đã xác nhận'),
(2, 2, 2, '2025-11-05', 3, 'chờ xác nhận'),
(3, 3, 3, '2025-10-28', 4, 'đã xác nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diemthamquan`
--

CREATE TABLE `diemthamquan` (
  `id` int NOT NULL,
  `place_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `description` text,
  `itinerary_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `diemthamquan`
--

INSERT INTO `diemthamquan` (`id`, `place_name`, `address`, `description`, `itinerary_id`) VALUES
(1, 'Động Thiên Cung', 'Vịnh Hạ Long, Quảng Ninh', 'Hang động đẹp và nổi tiếng nhất vịnh.', 1),
(2, 'Hang Đầu Gỗ', 'Vịnh Hạ Long, Quảng Ninh', 'Hang đá tự nhiên kỳ vĩ.', 1),
(3, 'Quảng trường Lâm Viên', 'Đà Lạt', 'Biểu tượng của thành phố ngàn hoa.', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `id` int NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`id`, `full_name`, `phone`, `email`, `address`) VALUES
(1, 'Lê Thị Mai', '0987654321', 'maile@gmail.com', 'Hà Nội'),
(2, 'Nguyễn Văn Hùng', '0912345678', 'hungnv@gmail.com', 'Hồ Chí Minh'),
(3, 'Phạm Thanh Tùng', '0978123456', 'tungpham@gmail.com', 'Đà Nẵng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichtrinh`
--

CREATE TABLE `lichtrinh` (
  `id` int NOT NULL,
  `itinerary_name` varchar(255) DEFAULT NULL,
  `day` date DEFAULT NULL,
  `description` text,
  `tour_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `lichtrinh`
--

INSERT INTO `lichtrinh` (`id`, `itinerary_name`, `day`, `description`, `tour_id`) VALUES
(1, 'Ngày 1: Khởi hành và tham quan vịnh', '2025-11-20', 'Khởi hành từ Hà Nội, tham quan động Thiên Cung, hang Đầu Gỗ.', 1),
(2, 'Ngày 2: Tự do tham quan', '2025-11-21', 'Tự do chụp ảnh, tham quan và tắm biển.', 1),
(3, 'Ngày 1: Đến Đà Lạt', '2025-12-05', 'Tham quan Quảng trường Lâm Viên và hồ Xuân Hương.', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id` int NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `full_name`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Admin Hệ Thống', 'admin@tour.com', '123456', 'admin', 'hoạt động', '2025-11-10 10:14:35'),
(2, 'Nguyễn Văn Hướng', 'huongdan1@tour.com', '123456', 'huongdanvien', 'hoạt động', '2025-11-10 10:14:35'),
(3, 'Trần Minh Long', 'huongdan2@tour.com', '123456', 'huongdanvien', 'hoạt động', '2025-11-10 10:14:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phanconghuongdan`
--

CREATE TABLE `phanconghuongdan` (
  `id` int NOT NULL,
  `guide_id` int NOT NULL,
  `tour_id` int NOT NULL,
  `rating` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `phanconghuongdan`
--

INSERT INTO `phanconghuongdan` (`id`, `guide_id`, `tour_id`, `rating`) VALUES
(1, 2, 1, '4.8'),
(2, 3, 2, '4.9');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhtoan`
--

CREATE TABLE `thanhtoan` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `thanhtoan`
--

INSERT INTO `thanhtoan` (`id`, `booking_id`, `amount`, `payment_date`, `payment_method`, `status`) VALUES
(1, 1, 7000000.00, '2025-11-02', 'chuyển khoản', 'đã thanh toán'),
(2, 2, 12600000.00, '2025-11-06', 'tiền mặt', 'chưa thanh toán');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongke`
--

CREATE TABLE `thongke` (
  `id` int NOT NULL,
  `total_tours` int DEFAULT NULL,
  `total_customers` int DEFAULT NULL,
  `total_revenue` decimal(15,2) DEFAULT NULL,
  `report_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `thongke`
--

INSERT INTO `thongke` (`id`, `total_tours`, `total_customers`, `total_revenue`, `report_date`) VALUES
(1, 3, 3, 21600000.00, '2025-11-10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour`
--

CREATE TABLE `tour` (
  `id` int NOT NULL,
  `tour_name` varchar(255) DEFAULT NULL,
  `description` text,
  `price` decimal(12,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `admin_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tour`
--

INSERT INTO `tour` (`id`, `tour_name`, `description`, `price`, `status`, `admin_id`, `created_at`) VALUES
(1, 'Du lịch Hạ Long 3N2Đ', 'Tham quan vịnh Hạ Long – kỳ quan thiên nhiên thế giới.', 3500000.00, 'còn chỗ', 1, '2025-11-10 10:14:35'),
(2, 'Khám phá Đà Lạt 4N3Đ', 'Hành trình đến thành phố ngàn hoa, tận hưởng khí hậu mát mẻ quanh năm.', 4200000.00, 'còn chỗ', 1, '2025-11-10 10:14:35'),
(3, 'Tour Miền Tây 2N1Đ', 'Khám phá chợ nổi Cái Răng, thưởng thức ẩm thực miền sông nước.', 2200000.00, 'hết chỗ', 1, '2025-11-10 10:14:35');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `baocaocongviec`
--
ALTER TABLE `baocaocongviec`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guide_id` (`guide_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `cauhinhhethong`
--
ALTER TABLE `cauhinhhethong`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `danhgiadiem`
--
ALTER TABLE `danhgiadiem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `guide_id` (`guide_id`);

--
-- Chỉ mục cho bảng `dattour`
--
ALTER TABLE `dattour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `diemthamquan`
--
ALTER TABLE `diemthamquan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itinerary_id` (`itinerary_id`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `lichtrinh`
--
ALTER TABLE `lichtrinh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `phanconghuongdan`
--
ALTER TABLE `phanconghuongdan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guide_id` (`guide_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `thongke`
--
ALTER TABLE `thongke`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `baocaocongviec`
--
ALTER TABLE `baocaocongviec`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cauhinhhethong`
--
ALTER TABLE `cauhinhhethong`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `danhgiadiem`
--
ALTER TABLE `danhgiadiem`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `dattour`
--
ALTER TABLE `dattour`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `diemthamquan`
--
ALTER TABLE `diemthamquan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `lichtrinh`
--
ALTER TABLE `lichtrinh`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `phanconghuongdan`
--
ALTER TABLE `phanconghuongdan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `thongke`
--
ALTER TABLE `thongke`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tour`
--
ALTER TABLE `tour`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `baocaocongviec`
--
ALTER TABLE `baocaocongviec`
  ADD CONSTRAINT `baocaocongviec_ibfk_1` FOREIGN KEY (`guide_id`) REFERENCES `nguoidung` (`id`),
  ADD CONSTRAINT `baocaocongviec_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`);

--
-- Các ràng buộc cho bảng `danhgiadiem`
--
ALTER TABLE `danhgiadiem`
  ADD CONSTRAINT `danhgiadiem_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `diemthamquan` (`id`),
  ADD CONSTRAINT `danhgiadiem_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `nguoidung` (`id`);

--
-- Các ràng buộc cho bảng `dattour`
--
ALTER TABLE `dattour`
  ADD CONSTRAINT `dattour_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `khachhang` (`id`),
  ADD CONSTRAINT `dattour_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`);

--
-- Các ràng buộc cho bảng `diemthamquan`
--
ALTER TABLE `diemthamquan`
  ADD CONSTRAINT `diemthamquan_ibfk_1` FOREIGN KEY (`itinerary_id`) REFERENCES `lichtrinh` (`id`);

--
-- Các ràng buộc cho bảng `lichtrinh`
--
ALTER TABLE `lichtrinh`
  ADD CONSTRAINT `lichtrinh_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`);

--
-- Các ràng buộc cho bảng `phanconghuongdan`
--
ALTER TABLE `phanconghuongdan`
  ADD CONSTRAINT `phanconghuongdan_ibfk_1` FOREIGN KEY (`guide_id`) REFERENCES `nguoidung` (`id`),
  ADD CONSTRAINT `phanconghuongdan_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`);

--
-- Các ràng buộc cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD CONSTRAINT `thanhtoan_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `dattour` (`id`);

--
-- Các ràng buộc cho bảng `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `tour_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `nguoidung` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
