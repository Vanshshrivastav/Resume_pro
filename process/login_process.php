<?php
session_start();
require '../includes/Dbconnection.php';

// Check if email and password were sent from the form
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['email']) || !isset($_POST['password'])) {
    header('Location: ../login.php');
    exit();
}

// --- Fetch User and Verify Password ---
$email = $_POST['email'];
$password = $_POST['password'];

// 1. Prepare statement to fetch user by email
$sql = "SELECT id, username, password, is_blocked FROM users WHERE email = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// 2. Check if a user was found
if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);

    // 3. Verify the password against the stored hash
    if (password_verify($password, $user['password'])) {
        
        // 4. Check if the user is blocked
        if ($user['is_blocked'] == 1) {
            // --- LOGIN FAILED (User Blocked) ---
            echo "<script>alert('Your account has been blocked. Please contact support.'); window.location.href = '../login.php';</script>";
            exit();
        }

        // --- LOGIN SUCCESSFUL ---

        // Store user's ID and username in the session
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect based on user role (admin or regular user)
        if ($user['username'] === 'admin') {
            $_SESSION['admin'] = $user['username'];
            echo "<script>alert('Admin Login Successful!'); window.location.href = '../Dasboard.php';</script>";
        } else {
            echo "<script>alert('Login Successful!'); window.location.href = '../home.php';</script>";
        }
        exit(); // Important to exit after redirect header/script

    } else {
        // --- LOGIN FAILED (Incorrect Password) ---
        echo "<script>alert('Invalid Email or Password!'); window.location.href = '../login.php';</script>";
        exit(); // <-- FIX: Add exit()
    }
} else {
    // --- LOGIN FAILED (User Not Found) ---
    echo "<script>alert('Invalid Email or Password!'); window.location.href = '../login.php';</script>";
    exit(); // <-- FIX: Add exit()
}

mysqli_stmt_close($stmt);
mysqli_close($con);

?>