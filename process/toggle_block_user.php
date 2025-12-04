<?php
session_start();
include("../includes/Dbconnection.php");

// --- Security Check ---
// 1. Ensure an admin is logged in
if (!isset($_SESSION['admin'])) {
    // If not an admin, redirect to the home page or login page
    header("Location: ../login.php");
    exit();
}

// 2. Ensure a user ID is provided
$user_id_to_toggle = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$user_id_to_toggle) {
    // No ID provided, redirect back
    header("Location: ../Dasboard.php");
    exit();
}

// 3. Prevent admin from blocking themselves
if ($user_id_to_toggle == $_SESSION['id']) {
    $_SESSION['error_message'] = "Admins cannot block themselves.";
    header("Location: ../Dasboard.php");
    exit();
}


// --- Toggle Logic ---

// Fetch the current status of the user
$query_current_status = "SELECT is_blocked FROM users WHERE id = ?";
$stmt_current_status = mysqli_prepare($con, $query_current_status);
mysqli_stmt_bind_param($stmt_current_status, "i", $user_id_to_toggle);
mysqli_stmt_execute($stmt_current_status);
$result = mysqli_stmt_get_result($stmt_current_status);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt_current_status);

if ($user) {
    // User found, determine the new status
    $current_status = $user['is_blocked'];
    $new_status = $current_status == 1 ? 0 : 1; // Flip the status

    // Update the user's status in the database
    $query_update_status = "UPDATE users SET is_blocked = ? WHERE id = ?";
    $stmt_update_status = mysqli_prepare($con, $query_update_status);
    mysqli_stmt_bind_param($stmt_update_status, "ii", $new_status, $user_id_to_toggle);
    
    if (mysqli_stmt_execute($stmt_update_status)) {
        $action = $new_status == 1 ? "blocked" : "unblocked";
        $_SESSION['success_message'] = "User has been successfully " . $action . ".";
    } else {
        $_SESSION['error_message'] = "Failed to update user status.";
    }
    mysqli_stmt_close($stmt_update_status);

} else {
    // User ID not found in the database
    $_SESSION['error_message'] = "User not found.";
}

mysqli_close($con);

// Redirect back to the dashboard
header("Location: ../Dasboard.php");
exit();

?>
