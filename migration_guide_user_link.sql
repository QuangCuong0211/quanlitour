-- Thêm liên kết giữa tác vụ HDV và tài khoản trong bảng users
-- Cột user_id, ràng buộc và chỉ mục được tạo khi chưa tồn tại để script có thể chạy lại nhiều lần.

-- 1. Tạo cột user_id nếu chưa có
DROP PROCEDURE IF EXISTS ensure_guide_user_link;
DELIMITER $$
CREATE PROCEDURE ensure_guide_user_link()
BEGIN
    DECLARE col_count INT;
    SELECT COUNT(*) INTO col_count
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'guide'
      AND COLUMN_NAME = 'user_id';

    IF col_count = 0 THEN
        SET @sql = 'ALTER TABLE guide ADD COLUMN user_id INT NULL AFTER id';
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END IF;
END$$
CALL ensure_guide_user_link$$
DROP PROCEDURE ensure_guide_user_link$$
DELIMITER ;

-- 2. Đồng bộ email để link các hồ sơ hiện tại
UPDATE guide g
JOIN users u ON u.email COLLATE utf8mb4_0900_ai_ci = g.email COLLATE utf8mb4_0900_ai_ci
  AND u.role = 'hdv'
SET g.user_id = u.id;

-- 3. Tạo foreign key nếu chưa có
DROP PROCEDURE IF EXISTS ensure_guide_fk;
DELIMITER $$
CREATE PROCEDURE ensure_guide_fk()
BEGIN
    DECLARE fk_count INT;
    SELECT COUNT(*) INTO fk_count
    FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
    WHERE CONSTRAINT_SCHEMA = DATABASE()
      AND TABLE_NAME = 'guide'
      AND CONSTRAINT_NAME = 'fk_guide_user';

    IF fk_count = 0 THEN
        ALTER TABLE guide
          ADD CONSTRAINT fk_guide_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;
    END IF;
END$$
CALL ensure_guide_fk$$
DROP PROCEDURE ensure_guide_fk$$
DELIMITER ;

-- 4. Tạo chỉ mục unique nếu chưa có
DROP PROCEDURE IF EXISTS ensure_guide_index;
DELIMITER $$
CREATE PROCEDURE ensure_guide_index()
BEGIN
    DECLARE idx_count INT;
    SELECT COUNT(*) INTO idx_count
    FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'guide'
      AND INDEX_NAME = 'uq_guide_user';

    IF idx_count = 0 THEN
        CREATE UNIQUE INDEX uq_guide_user ON guide(user_id);
    END IF;
END$$
CALL ensure_guide_index$$
DROP PROCEDURE ensure_guide_index$$
DELIMITER ;
