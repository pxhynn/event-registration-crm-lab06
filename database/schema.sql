CREATE DATABASE IF NOT EXISTS event_registration_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE event_registration_db;

-- Tắt kiểm tra khóa ngoại tạm thời để xóa các bảng theo bất kỳ thứ tự nào không bị kẹt
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS registrants;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Tạo bảng quản trị viên/Nhân viên vận hành
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Tạo bảng người đăng ký tư vấn (Với ENUM trạng thái tiếng Việt mới)
CREATE TABLE registrants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    interested_event ENUM('Pottery Workshop', 'Baking Masterclass', 'Chill Live Acoustic', 'Indie Music Fest') NOT NULL,
    status ENUM('đăng ký mới', 'đã hủy', 'đang xét duyệt', 'hoàn tất') NOT NULL DEFAULT 'đăng ký mới',
    note TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_registrant_email (email),
    INDEX idx_registrants_created_at (created_at),
    INDEX idx_registrants_status_event (status, interested_event)
) ENGINE=InnoDB;

-- 3. Tạo bảng đơn đăng ký vé / Hoá đơn chính thức (Với ENUM trạng thái tiếng Việt mới)
CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_code VARCHAR(50) NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(150) NOT NULL,
    ticket_quantity INT NOT NULL DEFAULT 1,
    total_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    payment_status ENUM('đơn đã hủy', 'chờ thanh toán', 'đã thanh toán') NOT NULL DEFAULT 'chờ thanh toán',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_registration_code (registration_code),
    INDEX idx_registrations_created_at (created_at),
    INDEX idx_registrations_status (payment_status)
) ENGINE=InnoDB;