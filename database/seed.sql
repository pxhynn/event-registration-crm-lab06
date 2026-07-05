USE event_registration_db;

-- Xóa dữ liệu cũ để làm sạch hệ thống
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE registrations;
TRUNCATE TABLE registrants;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Cập nhật tài khoản hệ thống (Tên ngắn gọn "admin"/"staff", email @gmail.com)
INSERT INTO users (name, email, password_hash, role, status) VALUES
('admin', 'admin@gmail.com', '$2y$10$mCstG.9KzKkM6YI6F6pZpOlG0E/SExn9yU6R9mXj.M86SloYx/mN.', 'admin', 'active'),
('staff', 'staff@gmail.com', '$2y$10$mCstG.9KzKkM6YI6F6pZpOlG0E/SExn9yU6R9mXj.M86SloYx/mN.', 'staff', 'active');

-- 2. Danh sách khách hàng đăng ký tư vấn (Họ tên Việt Nam 2 - 5 từ, email: tenho@gmail.com)
INSERT INTO registrants (name, email, phone, interested_event, status, note) VALUES
('Nguyễn An', 'annguyen@gmail.com', '0901234567', 'Pottery Workshop', 'new', 'Đăng ký suất sáng Thứ 7'),
('Trần Bảo Bình', 'binhtran@gmail.com', '0912345678', 'Baking Masterclass', 'contacted', 'Đã gọi điện tư vấn lộ trình'),
('Lê Thị Minh Chi', 'chile@gmail.com', '0923456789', 'Chill Live Acoustic', 'reserved', 'Đã chuyển khoản đặt cọc'),
('Phạm Nguyễn Khánh Danh', 'danhpham@gmail.com', '0934567890', 'Indie Music Fest', 'cancelled', 'Bận lịch đột xuất'),
('Hoàng Phan Anh Tú Em', 'emhoang@gmail.com', '0945678901', 'Pottery Workshop', 'new', 'Cần chuẩn bị tạp dề riêng không?'),
('Võ Thị Hồng Giang', 'giangvo@gmail.com', '0956789012', 'Baking Masterclass', 'contacted', 'Chờ phản hồi từ phụ huynh'),
('Đỗ Thụy Thanh Hà', 'hado@gmail.com', '0967890123', 'Chill Live Acoustic', 'new', 'Cần đặt chỗ gần sân khấu'),
('Bùi Hoàng Nhật In', 'inbui@gmail.com', '0978901234', 'Indie Music Fest', 'reserved', 'Vé VIP khu vực trung tâm'),
('Đặng Vũ Gia Khánh', 'khanhdang@gmail.com', '0989012345', 'Pottery Workshop', 'new', 'Chưa có kinh nghiệm làm gốm'),
('Ngô Đình Bảo Lâm', 'lamngo@gmail.com', '0990123456', 'Baking Masterclass', 'new', 'Đăng ký lớp bánh ngọt Pháp'),
('Lý Gia Minh', 'minhly@gmail.com', '0908887771', 'Chill Live Acoustic', 'contacted', 'Muốn đi nhóm 3 người'),
('Dương Văn Nam', 'namduong@gmail.com', '0908887772', 'Indie Music Fest', 'new', 'Hỏi về thời gian đổi vòng vé'),
('Phan Lê Tú Oanh', 'oanhphan@gmail.com', '0908887773', 'Pottery Workshop', 'reserved', 'Đã xác nhận thanh toán'),
('Quách Thị Minh Phú', 'phuquach@gmail.com', '0908887774', 'Baking Masterclass', 'cancelled', 'Yêu cầu hoàn hủy do trùng lịch'),
('Vương Đình Quốc', 'quocvuong@gmail.com', '0908887775', 'Chill Live Acoustic', 'new', 'Hỏi về phụ thu nước uống'),
('Tạ Văn Sơn', 'sonta@gmail.com', '0908887776', 'Indie Music Fest', 'contacted', 'Tư vấn hạng vé Standard'),
('Diệp Hải Thảo', 'thaodiep@gmail.com', '0908887777', 'Pottery Workshop', 'new', 'Đăng ký lớp gốm thủ công'),
('Cao Nguyễn Bảo Uyên', 'uyencao@gmail.com', '0908887778', 'Baking Masterclass', 'reserved', 'Đã gửi hóa đơn thanh toán'),
('Tiêu Mỹ Vân', 'vantieu@gmail.com', '0908887779', 'Chill Live Acoustic', 'new', 'Muốn đặt bàn cạnh cửa sổ'),
('Trịnh Hoàng Xuân', 'xuantrinh@gmail.com', '0908887780', 'Indie Music Fest', 'new', 'Hỏi về bãi đỗ xe ô tô');

-- 3. Danh sách đơn xuất vé chính thức
INSERT INTO registrations (registration_code, customer_name, customer_email, ticket_quantity, total_amount, payment_status) VALUES
('REG-POT-0001', 'Nguyễn An', 'annguyen@gmail.com', 2, 700000.00, 'paid'),
('REG-BAK-0002', 'Trần Bảo Bình', 'binhtran@gmail.com', 1, 450000.00, 'pending'),
('REG-IND-0003', 'Bùi Hoàng Nhật In', 'inbui@gmail.com', 4, 2000000.00, 'paid'),
('REG-CHI-0004', 'Lê Thị Minh Chi', 'chile@gmail.com', 1, 300000.00, 'cancelled');