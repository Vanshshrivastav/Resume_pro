-- Basic SQL
-- This script provides a more generic version of the table creation queries.

--
-- Table structure for table `users`
--
CREATE TABLE users (
  id INTEGER PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

--
-- Table structure for table `resumes`
--
CREATE TABLE resumes (
  id INTEGER PRIMARY KEY,
  user_id INTEGER NOT NULL,
  fullname VARCHAR(255) NOT NULL,
  address TEXT NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(50) NOT NULL,
  college_name VARCHAR(255) NOT NULL,
  location VARCHAR(255),
  degree VARCHAR(255) NOT NULL,
  education_date VARCHAR(255) NOT NULL,
  job_title VARCHAR(255) NOT NULL,
  employer VARCHAR(255) NOT NULL,
  country VARCHAR(255) NOT NULL,
  city VARCHAR(255) NOT NULL,
  skills TEXT NOT NULL,
  duration VARCHAR(100) NOT NULL,
  summary TEXT NOT NULL,
  github_url VARCHAR(255),
  FOREIGN KEY (user_id) REFERENCES users(id)
);
