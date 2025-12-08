-- Thêm tài khoản HDV mẫu (role = 'hdv')
-- Có thể chạy thêm nhiều lần vì dùng INSERT IGNORE tránh duplicate email

INSERT IGNORE INTO users (name, email, password, phone, role, status) VALUES
('Nguyen Van A', 'hdv1@example.com', MD5('hdv123'), '0900000001', 'hdv', 1),
('Tran Thi B', 'hdv2@example.com', MD5('hdv123'), '0900000002', 'hdv', 1),
('Le Van C', 'hdv3@example.com', MD5('hdv123'), '0900000003', 'hdv', 1);

-- Đảm bảo mỗi tài khoản có hồ sơ trong bảng guide nếu cần
INSERT IGNORE INTO guide (id, name, email, sdt, img, exp, language, status, user_id)
SELECT NULL, u.name, u.email, u.phone, NULL, 'Kinh nghiệm 3 năm', 'Tiếng Anh', 1, u.id
FROM users u
LEFT JOIN guide g ON g.user_id = u.id
WHERE u.role = 'hdv' AND g.id IS NULL;
