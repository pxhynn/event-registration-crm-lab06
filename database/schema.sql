CREATE DATABASE IF NOT EXISTS event_registration_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE event_registration_db;

-- 1. Bảng quản trị viên/Nhân viên vận hành
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

-- 2. Module A: Người đăng ký tư vấn / Học viên Workshop tiềm năng
CREATE TABLE registrants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    interested_event ENUM('Pottery Workshop', 'Baking Masterclass', 'Chill Live Acoustic', 'Indie Music Fest') NOT NULL,
    status ENUM('new', 'contacted', 'reserved', 'cancelled') NOT NULL DEFAULT 'new',
    note TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_registrant_email (email),
    INDEX idx_registrants_created_at (created_at),
    INDEX idx_registrants_status_event (status, interested_event)
) ENGINE=InnoDB;

-- 3. Module B: Đơn đăng ký vé / Hoá đơn chính thức
CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_code VARCHAR(50) NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(150) NOT NULL,
    ticket_quantity INT NOT NULL DEFAULT 1,
    total_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    payment_status ENUM('pending', 'paid', 'refunded', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_registration_code (registration_code),
    INDEX idx_registrations_created_at (created_at),
    INDEX idx_registrations_status (payment_status)
) ENGINE=InnoDB;