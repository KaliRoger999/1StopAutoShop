
-- Create database (if not exists)
CREATE DATABASE IF NOT EXISTS `2030_project` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `2030_project`;

-- Create users table for admin login
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create appointments table
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `appointment_id` varchar(20) NOT NULL UNIQUE,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `services` text NOT NULL,
  `vehicle_year` int(4) NOT NULL,
  `vehicle_make` varchar(50) NOT NULL,
  `vehicle_model` varchar(50) NOT NULL,
  `comments` text,
  `status` enum('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_appointment_id` (`appointment_id`),
  INDEX `idx_appointment_date` (`appointment_date`),
  INDEX `idx_status` (`status`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (username: admin, password: admin123)
-- Password is hashed using PHP's password_hash function
INSERT INTO `users` (`username`, `password`) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Create a counter table for generating unique appointment IDs
CREATE TABLE IF NOT EXISTS `appointment_counter` (
  `id` int(1) NOT NULL DEFAULT 1,
  `counter` bigint(20) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert initial counter value
INSERT INTO `appointment_counter` (`id`, `counter`) VALUES (1, 1);

-- Sample appointments for testing (optional)
INSERT INTO `appointments` 
(`appointment_id`, `name`, `email`, `phone`, `appointment_date`, `appointment_time`, 
 `services`, `vehicle_year`, `vehicle_make`, `vehicle_model`, `comments`, `status`) 
VALUES 
('APT-2025-000001', 'John Doe', 'john@example.com', '555-0123', '2025-08-15', '10:00:00', 
 'Oil Change,Brake Inspection', 2020, 'Honda', 'Civic', 'Need to check brakes urgently', 'pending'),
('APT-2025-000002', 'Jane Smith', 'jane@example.com', '555-0456', '2025-08-16', '14:00:00', 
 'Engine Diagnostics,Transmission Service', 2019, 'Toyota', 'Camry', '', 'confirmed');