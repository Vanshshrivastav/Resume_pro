<?php
session_start();
include("includes/Dbconnection.php"); // database connection file

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// --- Display Session Messages (Success/Error) ---
$success_message = '';
$error_message = '';
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Fetch basic user data from the 'users' table
$query_user = "SELECT username, email, profile_image_path FROM users WHERE id = ?";
$stmt_user = mysqli_prepare($con, $query_user);
mysqli_stmt_bind_param($stmt_user, "i", $user_id);
mysqli_stmt_execute($stmt_user);
$result_user = mysqli_stmt_get_result($stmt_user);
$user = mysqli_fetch_assoc($result_user);
mysqli_stmt_close($stmt_user);

$profile_image = !empty($user['profile_image_path']) ? $user['profile_image_path'] : 'https://via.placeholder.com/150';

// Fetch profile data from the 'profiles' table
$query_profile = "SELECT * FROM profiles WHERE user_id = ?";
$stmt_profile = mysqli_prepare($con, $query_profile);
mysqli_stmt_bind_param($stmt_profile, "i", $user_id);
mysqli_stmt_execute($stmt_profile);
$result_profile = mysqli_stmt_get_result($stmt_profile);
$profile_data_db = mysqli_fetch_assoc($result_profile);
mysqli_stmt_close($stmt_profile);

// Initialize profile_data array for display
$profile_data = [
    'full_name' => $profile_data_db['full_name'] ?? $user['username'] ?? '', // Use full_name from profiles, fallback to username
    'contact_email' => $user['email'] ?? '', // Always use email from users table
    'phone_number' => $profile_data_db['phone_number'] ?? '',
    'linkedin_url' => $profile_data_db['linkedin_url'] ?? '',
    'website_url' => $profile_data_db['website_url'] ?? '',
    'summary' => $profile_data_db['summary'] ?? '',
    'skills' => $profile_data_db['skills'] ?? '',
    'work_experience' => [
        [
            'title' => $profile_data_db['job_title'] ?? '',
            'company' => $profile_data_db['employer'] ?? '',
            'location' => $profile_data_db['job_location'] ?? '',
            'dates' => $profile_data_db['job_duration'] ?? '',
            'description' => $profile_data_db['job_description'] ?? ''
        ]
    ],
    'education' => [
        [
            'degree' => $profile_data_db['degree'] ?? '',
            'university' => $profile_data_db['university'] ?? '',
            'location' => $profile_data_db['education_location'] ?? '',
            'year' => $profile_data_db['graduation_year'] ?? ''
        ]
    ],
    'projects' => $profile_data_db['projects'] ?? '',
    'certifications' => $profile_data_db['certifications'] ?? ''
];

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - ResumeBuilder Pro</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">

    <?php include 'includes/header.php'; ?>

    <main class="container mx-auto max-w-4xl py-12 px-4 flex-grow">
        <?php if ($success_message): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($success_message); ?></span>
            </div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($error_message); ?></span>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="p-8">
                <!-- Profile Header -->
                <div class="flex flex-col md:flex-row items-center justify-between mb-8">
                    <div class="flex items-center">
                        <img class="w-24 h-24 rounded-full mr-6 border-4 border-blue-500" src="<?php echo htmlspecialchars($profile_image); ?>" alt="User Avatar">
                        <div>
                            <h1 class="text-3xl font-bold text-slate-800"><?php echo htmlspecialchars($profile_data['full_name']); ?></h1>
                            <p class="text-slate-500"><?php echo htmlspecialchars($profile_data['contact_email']); ?></p>
                        </div>
                    </div>
                    <a href="EditProfile.php" class="mt-4 md:mt-0 bg-blue-500 hover:bg-blue-600 text-white font-medium px-6 py-2 rounded-lg transition-colors">
                        Edit Profile
                    </a>
                </div>

                <!-- Contact Info -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Contact Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-slate-600">
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($profile_data['phone_number']); ?></p>
                        <?php if (!empty($profile_data['linkedin_url'])): ?>
                            <p><strong>LinkedIn:</strong> <a href="<?php echo htmlspecialchars($profile_data['linkedin_url']); ?>" class="text-blue-500 hover:underline" target="_blank">View Profile</a></p>
                        <?php endif; ?>
                        <?php if (!empty($profile_data['website_url'])): ?>
                            <p><strong>Website:</strong> <a href="<?php echo htmlspecialchars($profile_data['website_url']); ?>" class="text-blue-500 hover:underline" target="_blank">Visit Site</a></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Summary -->
                <?php if (!empty($profile_data['summary'])): ?>
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Summary</h2>
                    <p class="text-slate-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($profile_data['summary'])); ?></p>
                </div>
                <?php endif; ?>

                <!-- Work Experience -->
                <?php if (!empty($profile_data['work_experience'][0]['title'])): ?>
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Work Experience</h2>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-slate-800"><?php echo htmlspecialchars($profile_data['work_experience'][0]['title']); ?></h3>
                        <p class="text-slate-500">
                            <?php echo htmlspecialchars($profile_data['work_experience'][0]['company']); ?> 
                            <?php echo !empty($profile_data['work_experience'][0]['location']) ? '| ' . htmlspecialchars($profile_data['work_experience'][0]['location']) : ''; ?> 
                            <?php echo !empty($profile_data['work_experience'][0]['dates']) ? '(' . htmlspecialchars($profile_data['work_experience'][0]['dates']) . ')' : ''; ?>
                        </p>
                        <?php if (!empty($profile_data['work_experience'][0]['description'])): ?>
                            <div class="text-slate-600 mt-2"><?php echo nl2br(htmlspecialchars($profile_data['work_experience'][0]['description'])); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Education -->
                <?php if (!empty($profile_data['education'][0]['degree'])): ?>
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Education</h2>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-slate-800"><?php echo htmlspecialchars($profile_data['education'][0]['degree']); ?></h3>
                        <p class="text-slate-500">
                            <?php echo htmlspecialchars($profile_data['education'][0]['university']); ?> 
                            <?php echo !empty($profile_data['education'][0]['location']) ? '| ' . htmlspecialchars($profile_data['education'][0]['location']) : ''; ?> 
                            <?php echo !empty($profile_data['education'][0]['year']) ? '(' . htmlspecialchars($profile_data['education'][0]['year']) . ')' : ''; ?>
                        </p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Skills -->
                <?php if (!empty($profile_data['skills'])): ?>
                <div>
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Skills</h2>
                    <p class="text-slate-600"><?php echo htmlspecialchars($profile_data['skills']); ?></p>
                </div>
                <?php endif; ?>

                <!-- Projects -->
                <?php if (!empty($profile_data['projects'])): ?>
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Projects</h2>
                    <p class="text-slate-600"><?php echo nl2br(htmlspecialchars($profile_data['projects'])); ?></p>
                </div>
                <?php endif; ?>

                <!-- Certifications -->
                <?php if (!empty($profile_data['certifications'])): ?>
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Certifications</h2>
                    <p class="text-slate-600"><?php echo nl2br(htmlspecialchars($profile_data['certifications'])); ?></p>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </main>

    <?php include 'includes/Footer.php'; ?>

</body>
</html>