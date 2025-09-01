<?php
session_start();

require 'Dbconnection.php';

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['id'])) {
   echo 'Login first!'. header("Location: login.php");;
    exit();
}

$user_id = $_SESSION['id'];

// Sanitize and retrieve POST data
$fullname = mysqli_real_escape_string($con, $_POST['Fullname']);
$address = mysqli_real_escape_string($con, $_POST['Address']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$phone = mysqli_real_escape_string($con, $_POST['Phone']);
$college_name = mysqli_real_escape_string($con, $_POST['College_name']);
$degree = mysqli_real_escape_string($con, $_POST['Degree']);
$education_date = mysqli_real_escape_string($con, $_POST['Education_Date']);
$location = mysqli_real_escape_string($con, $_POST['Location']);
$job_title = mysqli_real_escape_string($con, $_POST['Job_Title']);
$employer = mysqli_real_escape_string($con, $_POST['Employer']);
$country = mysqli_real_escape_string($con, $_POST['Country']);
$city = mysqli_real_escape_string($con, $_POST['City']);
$duration = mysqli_real_escape_string($con, $_POST['Duration']);
$skills = mysqli_real_escape_string($con, $_POST['Skills']);
$summary = mysqli_real_escape_string($con, $_POST['Summary']);


// Basic validation
if (
    !empty($fullname) && !empty($address) && !empty($email) && !empty($phone) &&
    !empty($college_name) && !empty($degree) && !empty($education_date) &&
    !empty($job_title) && !empty($employer) && !empty($country) && !empty($city) &&
    !empty($duration) && !empty($skills) && !empty($summary)
) {
    $query = "INSERT INTO resumes (user_id, fullname, address, email, phone, college_name, location, degree, education_date, job_title, employer, country, city, skills, duration, summary) 
              VALUES ('$user_id', '$fullname', '$address', '$email', '$phone', '$college_name', '$location', '$degree', '$education_date', '$job_title', '$employer', '$country', '$city', '$skills', '$duration', '$summary')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Resume data saved successfully.'); window.location.href = 'Resume1.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "'); window.location.href = 'Resume1.php';</script>";
    }
} else {
    echo "<script>alert('Please fill all required fields.'); window.location.href = 'Resume1.php';</script>";
}

mysqli_close($con);
?>