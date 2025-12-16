-- =======================================================
-- RENTIFY - MASTER DATABASE (FINAL)
-- Framework: CakePHP 4.x / 5.x
-- Tables: 9 (Optimized for IMS566 Guidelines)
-- =======================================================

DROP DATABASE IF EXISTS rentify;
CREATE DATABASE rentify;
USE rentify;

-- ============================
-- 1. USERS (Customers)
-- ============================
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    license_number VARCHAR(50),
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'default_user.png',
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================
-- 2. ADMINS (Staff/Manager)
-- ============================
CREATE TABLE admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('manager','staff') DEFAULT 'staff',
    avatar VARCHAR(255) DEFAULT 'default_admin.png',
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================
-- 3. CAR CATEGORIES (Search Filter)
-- ============================
CREATE TABLE car_categories (
    car_category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL, -- CakePHP uses this for dropdown labels automatically
    description TEXT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================
-- 4. CARS (Inventory)
-- ============================
CREATE TABLE cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    car_category_id INT,
    car_model VARCHAR(100) NOT NULL,
    plate_number VARCHAR(50) UNIQUE NOT NULL,
    brand VARCHAR(50),
    year INT,
    price_per_day DECIMAL(10,2),
    status ENUM('available','booked','maintenance') DEFAULT 'available',
    
    -- Simplified Image Handling (One file per car)
    image VARCHAR(255) DEFAULT 'default_car.jpg', 
    
    -- Real-world Specs
    transmission ENUM('automatic', 'manual') NOT NULL, 
    seats INT NOT NULL,

    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (car_category_id) REFERENCES car_categories(car_category_id) ON DELETE SET NULL
);

-- ============================
-- 5. BOOKINGS (Main Transaction)
-- ============================
CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_price DECIMAL(10,2),
    booking_status ENUM('pending','confirmed','completed','cancelled') DEFAULT 'pending',
    
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(car_id) ON DELETE CASCADE
);

-- ============================
-- 6. INVOICES (For PDF Export)
-- ============================
CREATE TABLE invoices (
    invoice_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    invoice_number VARCHAR(50) UNIQUE NOT NULL, -- e.g., INV-2025-001
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('unpaid', 'paid', 'cancelled') DEFAULT 'unpaid',
    
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
);

-- ============================
-- 7. PAYMENTS (Financial Record)
-- ============================
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('cash','card','online_transfer') NOT NULL,
    payment_date DATETIME NOT NULL,
    payment_status ENUM('paid','unpaid','refunded') DEFAULT 'unpaid',
    
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
);

-- ============================
-- 8. MAINTENANCES (Fleet Management)
-- ============================
CREATE TABLE maintenances (
    maintenance_id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    description TEXT,
    cost DECIMAL(10,2),
    maintenance_date DATE,
    status ENUM('scheduled', 'completed') DEFAULT 'scheduled',
    
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (car_id) REFERENCES cars(car_id) ON DELETE CASCADE
);

-- ============================
-- 9. REVIEWS (User Feedback)
-- ============================
CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    rating INT CHECK (rating >=1 AND rating <=5),
    comment TEXT,
    
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(car_id) ON DELETE CASCADE
);
