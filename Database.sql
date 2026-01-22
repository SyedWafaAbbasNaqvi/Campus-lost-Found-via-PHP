-- Database: lost_and_found
-- Create Database
CREATE DATABASE IF NOT EXISTS lost_and_found;
USE lost_and_found;

-- Users Table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    student_id VARCHAR(50),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Items Table
CREATE TABLE items (
    item_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(50) NOT NULL,
    type ENUM('lost', 'found') NOT NULL,
    status ENUM('active', 'claimed', 'returned') DEFAULT 'active',
    location VARCHAR(200),
    date_lost_found DATE NOT NULL,
    image_path VARCHAR(255) DEFAULT 'default.jpg',
    contact_name VARCHAR(100),
    contact_phone VARCHAR(20),
    contact_email VARCHAR(100),
    posted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Insert sample admin user (password: admin123)
INSERT INTO users (full_name, email, password, phone, student_id, role) 
VALUES ('Admin User', 'admin@campus.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0300-1234567', 'ADMIN001', 'admin');

-- Insert sample regular user (password: user123)
INSERT INTO users (full_name, email, password, phone, student_id, role) 
VALUES ('John Doe', 'john@campus.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0300-9876543', 'STU001', 'user');

-- Insert sample items
INSERT INTO items (user_id, title, description, category, type, status, location, date_lost_found, contact_name, contact_phone, contact_email) 
VALUES 
(2, 'Black iPhone 13', 'Lost black iPhone 13 near library. Has a blue case with my name on it.', 'Electronics', 'lost', 'active', 'Main Library, 2nd Floor', '2026-01-10', 'John Doe', '0300-9876543', 'john@campus.edu'),
(2, 'Blue Notebook', 'Found blue notebook with CSC 337 notes written on cover.', 'Documents', 'found', 'active', 'CS Building, Room 301', '2026-01-12', 'John Doe', '0300-9876543', 'john@campus.edu'),
(1, 'Student ID Card', 'Found student ID card with name Sarah Ahmed.', 'Documents', 'found', 'active', 'Cafeteria', '2026-01-14', 'Admin User', '0300-1234567', 'admin@campus.edu');
