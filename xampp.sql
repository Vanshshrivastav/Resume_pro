-- SQL for XAMPP (MySQL/MariaDB)
-- This script deletes and recreates the `users`, `profiles`, and `resumes` tables.
-- It is designed to be run multiple times without causing errors.

-- Drop tables in reverse order of creation to avoid foreign key errors.
DROP TABLE IF EXISTS `resumes`;
DROP TABLE IF EXISTS `profiles`;
DROP TABLE IF EXISTS `users`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL UNIQUE,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `profile_image_path` VARCHAR(255) NULL DEFAULT NULL,
  `is_blocked` TINYINT(1) NOT NULL DEFAULT 0 -- 0 = not blocked, 1 = blocked
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `profiles` (previously `resumes`)
-- This table stores the master profile information for a user.
--
CREATE TABLE `profiles` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL UNIQUE, -- UNIQUE enforces a one-to-one relationship with users
  
  -- Personal Information
  `full_name` VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(50) NULL,
  `linkedin_url` VARCHAR(255) NULL,
  `website_url` VARCHAR(255) NULL,
  
  -- Summary/Objective
  `summary` TEXT NULL,
  
  -- Skills
  `skills` TEXT NULL,
  
  -- Work Experience (can be stored as JSON or in separate tables for multi-entry)
  `job_title` VARCHAR(255) NULL,
  `employer` VARCHAR(255) NULL,
  `job_location` VARCHAR(255) NULL,
  `job_duration` VARCHAR(100) NULL,
  `job_description` TEXT NULL,

  -- Education (can be stored as JSON or in separate tables for multi-entry)
  `degree` VARCHAR(255) NULL,
  `university` VARCHAR(255) NULL,
  `education_location` VARCHAR(255) NULL,
  `graduation_year` VARCHAR(10) NULL,

  -- Projects & Certifications
  `projects` TEXT NULL,
  `certifications` TEXT NULL,
  
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `resumes` (new)
-- This table stores multiple resume snapshots for each user.
--
CREATE TABLE `resumes` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `resume_title` VARCHAR(255) NOT NULL DEFAULT 'My Resume',
  `template_id` VARCHAR(50) NOT NULL DEFAULT 'default', -- Identifier for the template used
  
  -- The following fields are a snapshot of the profile data at the time of resume creation
  `full_name` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  `phone_number` VARCHAR(50) NULL,
  `linkedin_url` VARCHAR(255) NULL,
  `website_url` VARCHAR(255) NULL,
  `summary` TEXT NULL,
  `skills` TEXT NULL,
  `job_title` VARCHAR(255) NULL,
  `employer` VARCHAR(255) NULL,
  `job_location` VARCHAR(255) NULL,
  `job_duration` VARCHAR(100) NULL,
  `job_description` TEXT NULL,
  `degree` VARCHAR(255) NULL,
  `university` VARCHAR(255) NULL,
  `education_location` VARCHAR(255) NULL,
  `graduation_year` VARCHAR(10) NULL,
  `projects` TEXT NULL,
  `certifications` TEXT NULL,
  
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
