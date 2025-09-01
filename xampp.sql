-- SQL for XAMPP (MySQL/MariaDB)
-- This script creates the `users` and `resumes` tables.

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- The `users` table stores login information.
-- `id` is the primary key and auto-increments.
-- `username` and `email` must be unique.
-- All fields marked with `*` in your notes are set to `NOT NULL`.
--

CREATE TABLE `users` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL UNIQUE,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--
-- The `resumes` table stores all the details for a user's resume.
-- `id` is the primary key.
-- `user_id` is a foreign key that links this table to the `users` table.
-- This creates a one-to-one relationship (one user has one resume).
-- Fields that were not marked with `*` are nullable (e.g., `location`, `github_url`).
--

CREATE TABLE `resumes` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  -- Personal Information
  `fullname` VARCHAR(255) NOT NULL,
  `address` TEXT NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  -- Education
  `college_name` VARCHAR(255) NOT NULL,
  `location` VARCHAR(255) NULL,
  `degree` VARCHAR(255) NOT NULL,
  `education_date` VARCHAR(255) NOT NULL,
  -- Job Experience
  `job_title` VARCHAR(255) NOT NULL,
  `employer` VARCHAR(255) NOT NULL,
  `country` VARCHAR(255) NOT NULL,
  `city` VARCHAR(255) NOT NULL,
  `skills` TEXT NOT NULL,
  `duration` VARCHAR(100) NOT NULL,
  `summary` TEXT NOT NULL,
  -- Links
  `github_url` VARCHAR(255) NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
