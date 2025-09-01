<?php
session_start();

require 'Dbconnection.php';

// Check if username and password were sent from the form
if (isset($_POST['username']) && isset($_POST['password'])) {

    // Get username and password and escape them to prevent SQL injection
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Create the SQL query to find the user
    $sql = "SELECT id, username FROM users WHERE username = '$username' AND password = '$password'";

    // Run the query
    $result = mysqli_query($con, $sql);

    // Check if the query found exactly one user
    if (mysqli_num_rows($result) == 1) {

        // --- LOGIN SUCCESSFUL ---

        // Get the user's data from the query result
        $user = mysqli_fetch_assoc($result);

        // Store the user's ID and username in the session
        $_SESSION['id'] = $user['id']; // This is the main fix for your issue
        $_SESSION['username'] = $user['username'];

        // Check if the user is the admin
        if ($user['username'] === 'admin') {
            $_SESSION['admin'] = $user['username'];
            // Redirect admin to the dashboard
            echo "<script>alert('Admin Login Successful!'); window.location.href = 'Dasboard.php';</script>";
        } else {
            // Redirect regular users to the home page
            echo "<script>alert('Login Successful!'); window.location.href = 'home.php';</script>";
        }

    } else {
        // --- LOGIN FAILED ---
        echo "<script>alert('Invalid Username or Password!'); window.location.href = 'login.php';</script>";
    }

    $con->close();

} else {
    // This runs if the form was submitted without a username or password
    echo "<script>alert('Please enter a username and password.'); window.location.href = 'login.php';</script>";
}
?>