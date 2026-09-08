-- Physio Care Database
-- Import in phpMyAdmin:
-- 1) Create DB (or let this script create it)
-- 2) Run this SQL

CREATE DATABASE IF NOT EXISTS `physio_care` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `physio_care`;

-- -----------------------------
-- Admins
-- -----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_admins_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default admin login:
-- Username: admin
-- Password: admin123
INSERT INTO `admins` (`username`, `password`) VALUES
('admin', 'admin123');

-- -----------------------------
-- Services
-- -----------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `services` (`title`, `description`, `image`, `is_active`, `sort_order`) VALUES
('Back Pain Therapy', 'Specialized treatment for lower back pain, posture correction, and muscle strengthening exercises.', 'image/backpain.jpg', 1, 1),
('Sports Injury Rehab', 'Rehabilitation programs designed for athletes and active individuals to recover quickly and safely.', 'image/Sports Injury Rehab.jpg', 1, 2),
('Post-Surgery Rehab', 'Guided physiotherapy to regain strength, mobility, and confidence after surgery.', 'image/Post-Surgery Rehab.jpg', 1, 3),
('Neck Pain Treatment', 'Advanced techniques to relieve neck stiffness, pain, and muscle tension.', 'image/Neck Pain Treatment.jpg', 1, 4),
('Stroke Rehabilitation', 'Special therapy plans to improve movement, balance, and daily activity skills.', 'image/Stroke Rehabilitation.jpg', 1, 5),
('Joint Pain Therapy', 'Treatment for knee, shoulder, and hip pain using modern physiotherapy methods.', 'image/Joint Pain Therapy.jpg', 1, 6);

-- -----------------------------
-- Appointments
-- -----------------------------
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `email` VARCHAR(190) NOT NULL,
  `service` VARCHAR(150) NOT NULL,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  `message` TEXT NULL,
  `status` ENUM('new','confirmed','completed','cancelled') NOT NULL DEFAULT 'new',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_appointments_created_at` (`created_at`),
  KEY `idx_appointments_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

