USE event_registration_db;

-- Làm sạch dữ liệu cũ để tránh xung đột ràng buộc
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE registrations;
TRUNCATE TABLE registrants;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Tài khoản hệ thống
INSERT INTO users (name, email, password_hash, role, status) VALUES
('admin', 'admin@gmail.com', '$2y$10$mCstG.9KzKkM6YI6F6pZpOlG0E/SExn9yU6R9mXj.M86SloYx/mN.', 'admin', 'active'),
('staff', 'staff@gmail.com', '$2y$10$mCstG.9KzKkM6YI6F6pZpOlG0E/SExn9yU6R9mXj.M86SloYx/mN.', 'staff', 'active');

-- 2. Danh sách người đăng ký tư vấn gốc
INSERT INTO registrants (name, email, phone, interested_event, status, note) VALUES
('Nguyễn An', 'annguyen@gmail.com', '0901234567', 'Pottery Workshop', 'đăng ký mới', 'Đăng ký suất sáng Thứ 7'),
('Trần Bảo Bình', 'binhtran@gmail.com', '0912345678', 'Baking Masterclass', 'đang xét duyệt', 'Đã gọi điện tư vấn lộ trình'),
('Lê Thị Minh Chi', 'chile@gmail.com', '0923456789', 'Chill Live Acoustic', 'hoàn tất', 'Đã chuyển khoản đặt cọc'),
('Phạm Nguyễn Khánh Danh', 'danhpham@gmail.com', '0934567890', 'Indie Music Fest', 'đã hủy', 'Bận lịch đột xuất'),
('Hoàng Phan Anh Tú Em', 'emhoang@gmail.com', '0945678901', 'Pottery Workshop', 'đăng ký mới', 'Cần chuẩn bị tạp dề riêng không?'),
('Võ Thị Hồng Giang', 'giangvo@gmail.com', '0956789012', 'Baking Masterclass', 'đang xét duyệt', 'Chờ phản hồi từ phụ huynh'),
('Đỗ Thụy Thanh Hà', 'hado@gmail.com', '0967890123', 'Chill Live Acoustic', 'đăng ký mới', 'Cần đặt chỗ gần sân khấu'),
('Bùi Hoàng Nhật In', 'inbui@gmail.com', '0978901234', 'Indie Music Fest', 'hoàn tất', 'Vé VIP khu vực trung tâm'),
('Đặng Vũ Gia Khánh', 'khanhdang@gmail.com', '0989012345', 'Pottery Workshop', 'đăng ký mới', 'Chưa có kinh nghiệm làm gốm'),
('Ngô Đình Bảo Lâm', 'lamngo@gmail.com', '0990123456', 'Baking Masterclass', 'đăng ký mới', 'Đăng ký lớp bánh ngọt Pháp'),
('Lý Gia Minh', 'minhly@gmail.com', '0908887771', 'Chill Live Acoustic', 'đang xét duyệt', 'Muốn đi nhóm 3 người'),
('Dương Văn Nam', 'namduong@gmail.com', '0908887772', 'Indie Music Fest', 'đăng ký mới', 'Hỏi về thời gian đổi vòng vé'),
('Phan Lê Tú Oanh', 'oanhphan@gmail.com', '0908887773', 'Pottery Workshop', 'hoàn tất', 'Đã xác nhận thanh toán'),
('Quách Thị Minh Phú', 'phuquach@gmail.com', '0908887774', 'Baking Masterclass', 'đã hủy', 'Yêu cầu hoàn hủy do trùng lịch'),
('Vương Đình Quốc', 'quocvuong@gmail.com', '0908887775', 'Chill Live Acoustic', 'đăng ký mới', 'Hỏi về phụ thu nước uống'),
('Tạ Văn Sơn', 'sonta@gmail.com', '0908887786', 'Indie Music Fest', 'đang xét duyệt', 'Tư vấn hạng vé Standard'),
('Diệp Hải Thảo', 'thaodiep@gmail.com', '0908887777', 'Pottery Workshop', 'đăng ký mới', 'Đăng ký lớp gốm thủ công'),
('Cao Nguyễn Bảo Uyên', 'uyencao@gmail.com', '0908887778', 'Baking Masterclass', 'hoàn tất', 'Đã gửi hóa đơn thanh toán'),
('Tiêu Mỹ Vân', 'vantieu@gmail.com', '0908887779', 'Chill Live Acoustic', 'đăng ký mới', 'Muốn đặt bàn cạnh cửa sổ'),
('Trịnh Hoàng Xuân', 'xuantrinh@gmail.com', '0908887780', 'Indie Music Fest', 'đăng ký mới', 'Hỏi về bãi đỗ xe ô tô');

-- 3. Danh sách đơn hàng mở rộng (Đã làm sạch tên nghệ sĩ thành tên thông thường chuẩn hóa)
INSERT INTO registrations (registration_code, customer_name, customer_email, ticket_quantity, total_amount, payment_status, created_at) VALUES
('REG-POT-0001', 'Nguyễn An', 'annguyen@gmail.com', 2, 700000.00, 'đã thanh toán', '2026-07-01 09:00:00'),
('REG-BAK-0002', 'Trần Bảo Bình', 'binhtran@gmail.com', 1, 450000.00, 'chờ thanh toán', '2026-07-01 10:15:00'),
('REG-IND-0003', 'Bùi Hoàng Nhật In', 'inbui@gmail.com', 4, 2000000.00, 'đã thanh toán', '2026-07-01 11:30:00'),
('REG-CHI-0004', 'Lê Thị Minh Chi', 'chile@gmail.com', 1, 300000.00, 'đơn đã hủy', '2026-07-01 14:00:00'),
('REG-POT-0005', 'Đỗ Thụy Thanh Hà', 'hado@gmail.com', 1, 350000.00, 'đã thanh toán', '2026-07-02 08:30:00'),
('REG-BAK-0006', 'Võ Thị Hồng Giang', 'giangvo@gmail.com', 3, 1350000.00, 'đã thanh toán', '2026-07-02 09:45:00'),
('REG-CHI-0007', 'Lý Gia Minh', 'minhly@gmail.com', 2, 600000.00, 'chờ thanh toán', '2026-07-02 11:00:00'),
('REG-IND-0008', 'Dương Văn Nam', 'namduong@gmail.com', 2, 1000000.00, 'đã thanh toán', '2026-07-02 15:20:00'),
('REG-POT-0009', 'Phan Lê Tú Oanh', 'oanhphan@gmail.com', 2, 700000.00, 'đã thanh toán', '2026-07-03 10:00:00'),
('REG-BAK-0010', 'Cao Nguyễn Bảo Uyên', 'uyencao@gmail.com', 2, 900000.00, 'đã thanh toán', '2026-07-03 13:15:00'),
('REG-CHI-0011', 'Tiêu Mỹ Vân', 'vantieu@gmail.com', 1, 300000.00, 'chờ thanh toán', '2026-07-03 14:45:00'),
('REG-IND-0012', 'Trịnh Hoàng Xuân', 'xuantrinh@gmail.com', 5, 2500000.00, 'đã thanh toán', '2026-07-03 16:30:00'),
('REG-POT-0013', 'Phạm Minh Khang', 'khangpham@gmail.com', 3, 1050000.00, 'đã thanh toán', '2026-07-04 09:10:00'),
('REG-BAK-0014', 'Ngô Thanh Vân', 'vanngo@gmail.com', 1, 450000.00, 'đơn đã hủy', '2026-07-04 10:30:00'),
('REG-CHI-0015', 'Đặng Hoài Nam', 'namdang@gmail.com', 4, 1200000.00, 'đã thanh toán', '2026-07-04 11:45:00'),
('REG-IND-0016', 'Bùi Tiến Dũng', 'dungbui@gmail.com', 2, 1000000.00, 'chờ thanh toán', '2026-07-04 13:00:00'),
('REG-POT-0017', 'Phạm Hoàng My', 'mypham@gmail.com', 2, 700000.00, 'đã thanh toán', '2026-07-04 14:20:00'),
('REG-BAK-0018', 'Đỗ Hải Yến', 'yendo@gmail.com', 2, 900000.00, 'đã thanh toán', '2026-07-04 15:30:00'),
('REG-CHI-0019', 'Lê Hoàng Long', 'longle@gmail.com', 3, 900000.00, 'đã thanh toán', '2026-07-04 16:10:00'),
('REG-IND-0020', 'Nguyễn Bích Phương', 'phuongnguyen@gmail.com', 1, 500000.00, 'đã thanh toán', '2026-07-04 17:00:00'),
('REG-POT-0021', 'Trần Đình Quang', 'quangtran@gmail.com', 4, 1400000.00, 'đã thanh toán', '2026-07-04 18:20:00'),
('REG-BAK-0022', 'Phan Thanh Bình', 'binhphan@gmail.com', 2, 900000.00, 'chờ thanh toán', '2026-07-04 19:00:00'),
('REG-CHI-0023', 'Nguyễn Hồng Nhung', 'nhungnguyen@gmail.com', 2, 600000.00, 'đã thanh toán', '2026-07-04 19:40:00'),
('REG-IND-0024', 'Vũ Ngọc Hà', 'havu@gmail.com', 3, 1500000.00, 'đã thanh toán', '2026-07-04 20:15:00'),
('REG-POT-0025', 'Mai Tiến Đạt', 'datmai@gmail.com', 1, 350000.00, 'đơn đã hủy', '2026-07-04 21:00:00'),
('REG-BAK-0026', 'Trịnh Thanh Bình', 'binhtrinh@gmail.com', 1, 450000.00, 'đã thanh toán', '2026-07-04 21:30:00'),
('REG-CHI-0027', 'Lê Yến Nhi', 'nhile@gmail.com', 5, 1500000.00, 'đã thanh toán', '2026-07-04 22:00:00'),
('REG-IND-0028', 'Đặng Cao Thắng', 'thangdang@gmail.com', 2, 1000000.00, 'đã thanh toán', '2026-07-04 22:30:00'),
('REG-POT-0029', 'Nguyễn Thủy Tiên', 'tiennguyen@gmail.com', 2, 700000.00, 'chờ thanh toán', '2026-07-04 23:00:00'),
('REG-BAK-0030', 'Hoàng Minh Sơn', 'sonhoang@gmail.com', 2, 900000.00, 'đã thanh toán', '2026-07-04 23:30:00');