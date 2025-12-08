-- Thêm dữ liệu mẫu khách hàng
-- Có thể chạy nhiều lần, sử dụng INSERT IGNORE để tránh trùng email
INSERT IGNORE INTO customers (name, email, phone, address, city, identity_number, status) VALUES
('Vũ Minh Anh', 'minhanh@example.com', '0912345678', '123 Lê Lợi, Hà Nội', 'Hà Nội', '123456789', 1),
('Trần Bảo Châu', 'baochau@example.com', '0987654321', '45 Nguyễn Trãi, Hà Nội', 'Hà Nội', '987654321', 1),
('Hoàng Thị Lan', 'thilan@example.com', '0901112233', '12 Trần Phú, Đà Nẵng', 'Đà Nẵng', '456123789', 1),
('Lê Phúc Long', 'phuclong@example.com', '0911223344', '89 Võ Thị Sáu, TP.HCM', 'TP.HCM', '321654987', 1),
('Nguyễn Văn Khoa', 'vankhoa@example.com', '0909998887', '200 Trần Hưng Đạo, Nha Trang', 'Khánh Hòa', '112233445', 1),
('Phạm Thị Yến', 'thiyen@example.com', '0933111222', '5 Lý Tự Trọng, Cần Thơ', 'Cần Thơ', '556677889', 1);
