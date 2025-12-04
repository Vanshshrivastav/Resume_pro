<?php
session_start();

require '../includes/Dbconnection.php';

// --- Validation and Sanitization ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Only allow POST requests
    header('Location: ../Register.php');
    exit();
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password']; // Don't trim password

// 1. Basic empty checks
if (empty($username) || empty($email) || empty($password)) {
    echo "<script>alert('All fields are required.'); window.location.href = '../Register.php';</script>";
    exit();
}

// 2. Email format validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email format.'); window.location.href = '../Register.php';</script>";
    exit();
}

// --- Check for Duplicates ---
$sql_check = "SELECT id FROM users WHERE username = ? OR email = ?";
$stmt_check = mysqli_prepare($con, $sql_check);
mysqli_stmt_bind_param($stmt_check, "ss", $username, $email);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_store_result($stmt_check);

if (mysqli_stmt_num_rows($stmt_check) > 0) {
    echo "<script>alert('Username or email already exists.'); window.location.href = '../Register.php';</script>";
    mysqli_stmt_close($stmt_check);
    mysqli_close($con);
    exit();
}
mysqli_stmt_close($stmt_check);


// --- Secure Password Hashing ---
$hashed_password = password_hash($password, PASSWORD_DEFAULT);


// --- Insert User using Prepared Statement ---
$sql_insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt_insert = mysqli_prepare($con, $sql_insert);
mysqli_stmt_bind_param($stmt_insert, "sss", $username, $email, $hashed_password);

if (mysqli_stmt_execute($stmt_insert)) {
    echo "<script>alert('Registration successful! Please log in.'); window.location.href = '../login.php';</script>";
} else {
    // Generic error for database insertion failure
    error_log("Registration failed: " . mysqli_error($con)); // Log the actual error for the admin
    echo "<script>alert('Registration failed. Please try again later.'); window.location.href = '../Register.php';</script>";
}

mysqli_stmt_close($stmt_insert);
mysqli_close($con);

?>