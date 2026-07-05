# Event Registration CRM - Hệ thống Quản lý Đăng ký Sự kiện & Workshop

Ứng dụng được viết bằng mã nguồn PHP thuần tuân thủ mô hình kiến trúc Front Controller + MVC đáp ứng các tiêu chí bảo mật nâng cao và kiểm soát tính toàn vẹn dữ liệu.

## 🛠️ Hướng dẫn cài đặt và vận hành nhanh

1. **Khởi tạo cơ sở dữ liệu**:
   - Truy cập công cụ quản trị Database (phpMyAdmin / MySQL Workbench).
   - Tạo mới database tên là `event_registration_db`.
   - Lần lượt import (chạy file SQL) hai tệp dữ liệu theo thứ tự: `database/schema.sql` rồi đến `database/seed.sql`.

2. **Cập nhật thông tin kết nối**:
   - Mở tệp tin cấu hình tại `config/database.php` và điền chính xác `username` cùng `password` hệ thống MySQL của máy bạn.

3. **Chạy ứng dụng bằng PHP Built-in Server**:
   - Di chuyển terminal vào thư mục gốc của dự án và chạy câu lệnh:
     ```bash
     php -S localhost:8000 -t public
     ```
   - Sử dụng trình duyệt truy cập đường dẫn: `http://localhost:8000`

## 👥 Tài khoản Demo nghiệm thu bài Lab
- **Tài khoản Quản trị**: `admin@eventcrm.vn` | **Mật khẩu**: `123456`
- **Tài khoản Nhân viên**: `staff@eventcrm.vn` | **Mật khẩu**: `123456`

## 🛡️ Điểm nhấn Kỹ thuật bảo mật trong dự án
- **SQL Injection Prevention**: Toàn bộ thao tác đọc ghi dữ liệu từ GET/POST đều được xử lý bóc tách tham số qua PDO Prepared Statements (`bindValue`).
- **XSS Prevention**: Dữ liệu hiển thị lên View được bọc qua hàm helper `e()` thực thi `htmlspecialchars`.
- **Form Trùng lặp Dữ liệu (PRG Pattern)**: Sau khi thực hiện hành vi POST dữ liệu, controller luôn trả về trạng thái điều hướng `redirect()` để ngăn chặn lặp dữ liệu khi người dùng ấn phím F5 làm mới trang.
- **Session Security**: Session Cookie được cấu hình chặt chẽ với các thuộc tính `HttpOnly`, `SameSite=Lax` và tự động kích hoạt `session_regenerate_id(true)` ngay sau khi đăng nhập thành công.