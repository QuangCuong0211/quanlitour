-- Tạo bảng categories (Danh Mục)
CREATE TABLE `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL COMMENT 'Tên danh mục',
    `description` TEXT COMMENT 'Mô tả danh mục',
    `slug` VARCHAR(255) UNIQUE COMMENT 'Đường dẫn thân thiện (URL-friendly)',
    `status` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái: 1=hoạt động, 0=ẩn',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật',
    INDEX `idx_slug` (`slug`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu cho categories
INSERT INTO `categories` (`name`, `description`, `slug`, `status`) 
VALUES 
('Tour Miền Bắc', 'Các tour du lịch tại các địa điểm nổi tiếng miền Bắc Việt Nam', 'tour-mien-bac', 1),
('Tour Miền Trung', 'Các tour du lịch tại các địa điểm nổi tiếng miền Trung Việt Nam', 'tour-mien-trung', 1),
('Tour Miền Nam', 'Các tour du lịch tại các địa điểm nổi tiếng miền Nam Việt Nam', 'tour-mien-nam', 1),
('Tour Nước Ngoài', 'Các tour du lịch quốc tế', 'tour-nuoc-ngoai', 1),
('Tour Phiêu Lưu', 'Các tour phiêu lưu hấp dẫn và kịch tính', 'tour-phieu-luu', 1);
