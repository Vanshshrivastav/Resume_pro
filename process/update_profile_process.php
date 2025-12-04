<?php
session_start();
include("../includes/Dbconnection.php"); // database connection file

// Check if user is logged in and the form was submitted
if (!isset($_SESSION['id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit();
}

// --- Security Check: Ensure user is not blocked ---
$user_id = $_SESSION['id'];
$query_user_status = "SELECT is_blocked FROM users WHERE id = ?";
$stmt_status = mysqli_prepare($con, $query_user_status);
mysqli_stmt_bind_param($stmt_status, "i", $user_id);
mysqli_stmt_execute($stmt_status);
$result_status = mysqli_stmt_get_result($stmt_status);
$user_status = mysqli_fetch_assoc($result_status);
mysqli_stmt_close($stmt_status);

if ($user_status && $user_status['is_blocked'] == 1) {
    $_SESSION['error_message'] = "Your account is blocked, so you cannot save changes.";
    header("Location: ../Profile.php"); // Redirect to a safe page
    exit();
}


// --- Data Retrieval and Sanitization ---
$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
$full_name = trim(filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING));
$phone_number = trim(filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING));
$linkedin_url = trim(filter_input(INPUT_POST, 'linkedin_url', FILTER_SANITIZE_URL));
$website_url = trim(filter_input(INPUT_POST, 'website_url', FILTER_SANITIZE_URL));
$summary = trim(filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_STRING));
$skills = trim(filter_input(INPUT_POST, 'skills', FILTER_SANITIZE_STRING));
$job_title = trim(filter_input(INPUT_POST, 'job_title', FILTER_SANITIZE_STRING));
$employer = trim(filter_input(INPUT_POST, 'employer', FILTER_SANITIZE_STRING));
$job_location = trim(filter_input(INPUT_POST, 'job_location', FILTER_SANITIZE_STRING));
$job_duration = trim(filter_input(INPUT_POST, 'job_duration', FILTER_SANITIZE_STRING));
$job_description = trim(filter_input(INPUT_POST, 'job_description', FILTER_SANITIZE_STRING));
$degree = trim(filter_input(INPUT_POST, 'degree', FILTER_SANITIZE_STRING));
$university = trim(filter_input(INPUT_POST, 'university', FILTER_SANITIZE_STRING));
$education_location = trim(filter_input(INPUT_POST, 'education_location', FILTER_SANITIZE_STRING));
$graduation_year = trim(filter_input(INPUT_POST, 'graduation_year', FILTER_SANITIZE_STRING));
$projects = trim(filter_input(INPUT_POST, 'projects', FILTER_SANITIZE_STRING));
$certifications = trim(filter_input(INPUT_POST, 'certifications', FILTER_SANITIZE_STRING));

// --- Comprehensive Validation ---
$required_fields = [
    'full_name' => $full_name,
    'phone_number' => $phone_number,
    'linkedin_url' => $linkedin_url,
    'website_url' => $website_url,
    'summary' => $summary,
    'skills' => $skills,
    'job_title' => $job_title,
    'employer' => $employer,
    'job_location' => $job_location,
    'job_duration' => $job_duration,
    'job_description' => $job_description,
    'degree' => $degree,
    'university' => $university,
    'education_location' => $education_location,
    'graduation_year' => $graduation_year,
    'projects' => $projects,
    'certifications' => $certifications,
];

foreach ($required_fields as $field_name => $field_value) {
    if (empty($field_value)) {
        $formatted_field_name = ucwords(str_replace('_', ' ', $field_name));
        $_SESSION['error_message'] = "The '$formatted_field_name' field is required. Please fill out all fields.";
        header("Location: ../EditProfile.php");
        exit();
    }
}

if (!$user_id) {
    $_SESSION['error_message'] = "User ID must be valid.";
    header("Location: ../EditProfile.php");
    exit();
}

// Ensure the logged-in user is only updating their own profile
if ($user_id != $_SESSION['id']) {
    die("Unauthorized action.");
}

// --- Profile Picture Upload ---
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = '../uploads/';
    // --- Directory Existence and Writable Check ---
    if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
        $_SESSION['error_message'] = "Server error: The upload directory does not exist or is not writable.";
        // Optionally, log this for the admin, as it's a server configuration issue
        error_log("Upload directory issue: $upload_dir is not a directory or not writable.");
    } else 
    // ... (rest of the image upload logic remains the same)
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $file_info = pathinfo($_FILES['profile_image']['name']);
    $file_ext = strtolower($file_info['extension']);

    if (in_array($file_ext, $allowed_types)) {
        if ($_FILES['profile_image']['size'] < 5000000) { // 5MB limit
            $new_filename = uniqid('user_' . $user_id . '_') . '.' . $file_ext;
            $destination = $upload_dir . $new_filename;

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination)) {
                $db_path = 'uploads/' . $new_filename; // Path to store in DB
                // --- Update Database with Image Path ---
                $query_update_image = "UPDATE users SET profile_image_path = ? WHERE id = ?";
                $stmt_update_image = mysqli_prepare($con, $query_update_image);
                mysqli_stmt_bind_param($stmt_update_image, "si", $db_path, $user_id);
                mysqli_stmt_execute($stmt_update_image);
                mysqli_stmt_close($stmt_update_image);
            } else {
                $upload_error = $_FILES['profile_image']['error'];
                $_SESSION['error_message'] = "Could not move uploaded file. PHP Error Code: $upload_error";
            }
        } else {
            $_SESSION['error_message'] = "File is too large. Maximum size is 5MB.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
    }
}


// --- Database Update ---
$success_profile = false;

// Check if a profile entry exists for the user
$check_profile_sql = "SELECT id FROM profiles WHERE user_id = ?";
$stmt_check = mysqli_prepare($con, $check_profile_sql);
mysqli_stmt_bind_param($stmt_check, "i", $user_id);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_store_result($stmt_check);

if (mysqli_stmt_num_rows($stmt_check) > 0) {
    // Profile entry exists, perform UPDATE
    $query_profile = "UPDATE profiles SET
                        full_name = ?, phone_number = ?, linkedin_url = ?, website_url = ?, summary = ?, skills = ?,
                        job_title = ?, employer = ?, job_location = ?, job_duration = ?, job_description = ?,
                        degree = ?, university = ?, education_location = ?, graduation_year = ?,
                        projects = ?, certifications = ?
                      WHERE user_id = ?";
    $stmt_profile = mysqli_prepare($con, $query_profile);
    mysqli_stmt_bind_param($stmt_profile, "sssssssssssssssssi",
        $full_name, $phone_number, $linkedin_url, $website_url, $summary, $skills,
        $job_title, $employer, $job_location, $job_duration, $job_description,
        $degree, $university, $education_location, $graduation_year,
        $projects, $certifications,
        $user_id);
    $success_profile = mysqli_stmt_execute($stmt_profile);
    mysqli_stmt_close($stmt_profile);

} else {
    // No profile entry, perform INSERT
    $query_profile = "INSERT INTO profiles (
                        user_id, full_name, phone_number, linkedin_url, website_url, summary, skills,
                        job_title, employer, job_location, job_duration, job_description,
                        degree, university, education_location, graduation_year,
                        projects, certifications
                      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_profile = mysqli_prepare($con, $query_profile);
    mysqli_stmt_bind_param($stmt_profile, "isssssssssssssssss",
        $user_id, $full_name, $phone_number, $linkedin_url, $website_url, $summary, $skills,
        $job_title, $employer, $job_location, $job_duration, $job_description,
        $degree, $university, $education_location, $graduation_year,
        $projects, $certifications);
    $success_profile = mysqli_stmt_execute($stmt_profile);
    mysqli_stmt_close($stmt_profile);
}
mysqli_stmt_close($stmt_check);


// --- Redirect on Completion ---
if ($success_profile) {
    $_SESSION['success_message'] = "Profile updated successfully!";
} else {
    // Check if we have a more specific message from image upload
    if (!isset($_SESSION['error_message'])) {
        error_log("Profile update failed for user_id: $user_id. Error: " . mysqli_error($con));
        $_SESSION['error_message'] = "There was an error updating your profile. Please try again.";
    }
}

mysqli_close($con);
header("Location: ../Profile.php");
exit();

?>