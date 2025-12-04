<?php
session_start();

require '../includes/Dbconnection.php';

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Sanitize and retrieve POST data
$resume_title = mysqli_real_escape_string($con, $_POST['resume_title'] ?? 'My Resume'); // New field for resume title
$template_id = mysqli_real_escape_string($con, $_POST['template_id'] ?? 'template1'); // New field for template

$fullname = mysqli_real_escape_string($con, $_POST['Fullname']);
$address = mysqli_real_escape_string($con, $_POST['Address']); // This field does not exist in the new resumes table
$email = mysqli_real_escape_string($con, $_POST['email']);
$phone = mysqli_real_escape_string($con, $_POST['Phone']);
$college_name = mysqli_real_escape_string($con, $_POST['College_name']);
$degree = mysqli_real_escape_string($con, $_POST['Degree']);
$education_date = mysqli_real_escape_string($con, $_POST['Education_Date']);
$job_title = mysqli_real_escape_string($con, $_POST['Job_Title']);
$employer = mysqli_real_escape_string($con, $_POST['Employer']);
$country = mysqli_real_escape_string($con, $_POST['Country']);
$city = mysqli_real_escape_string($con, $_POST['City']);
$duration = mysqli_real_escape_string($con, $_POST['Duration']);
$skills = mysqli_real_escape_string($con, $_POST['Skills']);
$summary = mysqli_real_escape_string($con, $_POST['Summary']);

// Combine location fields
$job_location = $city . ', ' . $country;


// Basic validation
if (empty($fullname) || empty($email)) {
    echo "<script>alert('Please fill all required fields.'); window.location.href = '../Resume1.php';</script>";
    exit();
}

// --- Database Operation: Always INSERT a new resume ---

$query = "INSERT INTO resumes (
            user_id, resume_title, template_id, full_name, email, phone_number, 
            university, degree, graduation_year, job_title, employer, job_location, 
            job_duration, skills, summary
          ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "issssssssssssss",
    $user_id,
    $resume_title,
    $template_id,
    $fullname,
    $email,
    $phone,
    $college_name, // Mapped to university
    $degree,
    $education_date, // Mapped to graduation_year
    $job_title,
    $employer,
    $job_location,
    $duration, // Mapped to job_duration
    $skills,
    $summary
);

// Execute the prepared statement
if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('New resume snapshot saved successfully!'); window.location.href = '../Resume1.php';</script>"; // Consider redirecting to a new 'MyResumes.php' page
} else {
    echo "<script>alert('Error: " . mysqli_stmt_error($stmt) . "'); window.location.href = '../Resume1.php';</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
