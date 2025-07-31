CREATE DATABASE IF NOT EXISTS 2030_project;
USE 2030_project;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  appointment_id VARCHAR(20) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  appointment_date DATE NOT NULL,
  appointment_time TIME NOT NULL,
  services TEXT NOT NULL,
  vehicle_year INT NOT NULL,
  vehicle_make VARCHAR(50) NOT NULL,
  vehicle_model VARCHAR(50) NOT NULL,
  comments TEXT,
  status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE appointment_counter (
  id INT PRIMARY KEY DEFAULT 1,
  counter INT NOT NULL DEFAULT 1
);

INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO appointment_counter (id, counter) VALUES (1, 1);

-- TEST APPOINTMENTS TO PUT AS INITIAL APPOINTMENTS IN THE DATABASE
INSERT INTO appointments 
(appointment_id, name, email, phone, appointment_date, appointment_time, services, vehicle_year, vehicle_make, vehicle_model, comments, status) 
VALUES 
('APT-2025-000001', 'John Doe', 'john@example.com', '604-123-1234', '2025-08-15', '10:00:00', 'Oil Change,Brake Inspection', 2020, 'Honda', 'Civic', 'Need to check brakes urgently', 'pending'),

('APT-2025-000002', 'Jane Smith', 'jane@example.com', '604-123-1234', '2025-08-16', '14:00:00', 'Engine Diagnostics,Transmission Service', 2019, 'Toyota', 'Camry', '', 'confirmed');