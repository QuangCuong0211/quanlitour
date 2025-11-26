-- Tạo bảng departures (Lịch Khởi Hành)
CREATE TABLE `departures` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tour_id` INT NOT NULL COMMENT 'ID của tour',
    `departure_date` DATE NOT NULL COMMENT 'Ngày khởi hành',
    `return_date` DATE NOT NULL COMMENT 'Ngày kết thúc/trở về',
    `guide_id` INT NOT NULL COMMENT 'ID hướng dẫn viên',
    `seats_available` INT NOT NULL DEFAULT 0 COMMENT 'Số ghế có sẵn',
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active' COMMENT 'Trạng thái lịch khởi hành',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật',
    FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`guide_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
    INDEX `idx_tour_id` (`tour_id`),
    INDEX `idx_guide_id` (`guide_id`),
    INDEX `idx_departure_date` (`departure_date`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng customers (Danh Sách Khách Hàng)
CREATE TABLE `customers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL COMMENT 'Tên khách hàng',
    `email` VARCHAR(255) UNIQUE NOT NULL COMMENT 'Email',
    `phone` VARCHAR(20) NOT NULL COMMENT 'Số điện thoại',
    `address` TEXT NOT NULL COMMENT 'Địa chỉ',
    `city` VARCHAR(100) NOT NULL COMMENT 'Thành phố',
    `identity_number` VARCHAR(20) COMMENT 'Số CMND/CCCD',
    `status` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái: 1=hoạt động, 0=khóa',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật',
    INDEX `idx_email` (`email`),
    INDEX `idx_phone` (`phone`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng bookings (Đặt Tour - liên kết khách hàng với lịch khởi hành)
CREATE TABLE `bookings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `departure_id` INT NOT NULL COMMENT 'ID lịch khởi hành',
    `customer_id` INT NOT NULL COMMENT 'ID khách hàng',
    `booking_date` DATE NOT NULL COMMENT 'Ngày đặt',
    `num_of_people` INT NOT NULL DEFAULT 1 COMMENT 'Số người đi',
    `total_price` DECIMAL(15, 2) NOT NULL DEFAULT 0 COMMENT 'Tổng giá tiền',
    `status` ENUM('pending', 'confirmed', 'cancelled') NOT NULL DEFAULT 'pending' COMMENT 'Trạng thái đặt tour',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật',
    FOREIGN KEY (`departure_id`) REFERENCES `departures`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE,
    INDEX `idx_departure_id` (`departure_id`),
    INDEX `idx_customer_id` (`customer_id`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu cho departures (nếu đã có tours)
-- INSERT INTO `departures` (`tour_id`, `departure_date`, `return_date`, `guide_id`, `seats_available`, `status`) 
-- VALUES (1, '2025-12-15', '2025-12-20', 1, 30, 'active');

-- Thêm dữ liệu mẫu cho customers
-- INSERT INTO `customers` (`name`, `email`, `phone`, `address`, `city`, `identity_number`, `status`) 
-- VALUES 
-- ('Nguyễn Văn A', 'vana@example.com', '0912345678', '123 Nguyễn Huệ, Q1', 'TP.HCM', '123456789', 1),
-- ('Trần Thị B', 'tranb@example.com', '0987654321', '456 Lê Lợi, Q1', 'Hà Nội', '987654321', 1);
