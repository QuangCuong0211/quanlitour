-- Tạo bảng users cho quản lý tài khoản
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL COMMENT 'Tên người dùng',
    `email` VARCHAR(255) UNIQUE NOT NULL COMMENT 'Email',
    `password` VARCHAR(255) NOT NULL COMMENT 'Mật khẩu (đã mã hóa)',
    `phone` VARCHAR(20) NOT NULL COMMENT 'Số điện thoại',
    `role` ENUM('admin', 'hdv') NOT NULL DEFAULT 'hdv' COMMENT 'Vai trò: admin hoặc hdv (hướng dẫn viên)',
    `status` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái: 1=hoạt động, 0=khóa',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật',
    INDEX `idx_email` (`email`),
    INDEX `idx_role` (`role`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm tài khoản Admin mặc định (email: admin@gmail.com, password: 123456)
INSERT INTO `users` (`name`, `email`, `password`, `phone`, `role`, `status`) 
VALUES (
    'Administrator', 
    'admin@gmail.com', 
    '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/TVm', 
    '0123456789', 
    'admin', 
    1
);

-- Password: 123456 đã được mã hóa bằng password_hash() của PHP
-- Để sinh password khác, dùng công cụ hoặc code PHP:
-- echo password_hash('mật_khẩu_của_bạn', PASSWORD_DEFAULT);
