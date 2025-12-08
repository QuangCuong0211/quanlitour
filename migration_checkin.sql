DROP TABLE IF EXISTS `checkins`;
CREATE TABLE `checkins` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `booking_id` INT NOT NULL,
    `customer_name` VARCHAR(255) NOT NULL,
    `customer_phone` VARCHAR(50) DEFAULT NULL,
    `status` ENUM('pending', 'enroute', 'present', 'absent') NOT NULL DEFAULT 'pending',
    `checked_by` VARCHAR(255) DEFAULT NULL,
    `note` TEXT,
    `checkin_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_checkin_booking`
        FOREIGN KEY (`booking_id`)
        REFERENCES `bookings` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;