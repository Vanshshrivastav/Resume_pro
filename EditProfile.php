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

// Fetch basic user data to display
$query_user = "SELECT username, email FROM users WHERE id = ?";
$stmt_user = mysqli_prepare($con, $query_user);
mysqli_stmt_bind_param($stmt_user, "i", $user_id);
mysqli_stmt_execute($stmt_user);
$result_user = mysqli_stmt_get_result($stmt_user);
$user = mysqli_fetch_assoc($result_user);
mysqli_stmt_close($stmt_user);

// Fetch profile data from the 'profiles' table
$query_profile = "SELECT * FROM profiles WHERE user_id = ?";
$stmt_profile = mysqli_prepare($con, $query_profile);
mysqli_stmt_bind_param($stmt_profile, "i", $user_id);
mysqli_stmt_execute($stmt_profile);
$result_profile = mysqli_stmt_get_result($stmt_profile);
$profile_data_db = mysqli_fetch_assoc($result_profile);
mysqli_stmt_close($stmt_profile);

// Initialize profile_data array for display
// Use data from DB if available, otherwise use defaults/user table info
$profile_data = [
    'full_name' => $profile_data_db['full_name'] ?? ($user['username'] ?? ''), // Use full_name from profiles, fallback to username
    'contact_email' => $user['email'] ?? '', // Always use email from users table for contact
    'phone_number' => $profile_data_db['phone_number'] ?? '',
    'linkedin_url' => $profile_data_db['linkedin_url'] ?? '',
    'website_url' => $profile_data_db['website_url'] ?? '',
    'summary' => $profile_data_db['summary'] ?? '',
    'skills' => $profile_data_db['skills'] ?? '',
    
    // Work Experience
    'job_title' => $profile_data_db['job_title'] ?? '',
    'employer' => $profile_data_db['employer'] ?? '',
    'job_location' => $profile_data_db['job_location'] ?? '',
    'job_duration' => $profile_data_db['job_duration'] ?? '',
    'job_description' => $profile_data_db['job_description'] ?? '',
    
    // Education
    'degree' => $profile_data_db['degree'] ?? '',
    'university' => $profile_data_db['university'] ?? '',
    'education_location' => $profile_data_db['education_location'] ?? '',
    'graduation_year' => $profile_data_db['graduation_year'] ?? '',

    // Projects & Certifications
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
    <title>Edit Profile - ResumeBuilder Pro</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50">

    <?php include 'includes/header.php'; ?>

    <main class="container mx-auto max-w-4xl py-12 px-4">
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
                <h1 class="text-3xl font-bold text-slate-800 mb-8 border-b pb-4">Edit Your Profile</h1>
                
                <form action="process/update_profile_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                    <!-- Profile Picture Upload -->
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Profile Picture</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="profile_image" class="block text-sm font-medium text-slate-700 mb-1">Upload New Profile Picture</label>
                            <input type="file" id="profile_image" name="profile_image" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Personal Details -->
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Personal Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                            <input type="text" id="full_name" name="full_name" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['full_name']); ?>">
                        </div>
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-slate-700 mb-1">Contact Email (Read-only)</label>
                            <input type="email" id="contact_email" name="contact_email" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm bg-slate-100 cursor-not-allowed" value="<?php echo htmlspecialchars($profile_data['contact_email']); ?>" readonly>
                        </div>
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['phone_number']); ?>">
                        </div>
                        <div>
                            <label for="linkedin_url" class="block text-sm font-medium text-slate-700 mb-1">LinkedIn Profile URL</label>
                            <input type="url" id="linkedin_url" name="linkedin_url" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['linkedin_url']); ?>">
                        </div>
                        <div>
                            <label for="website_url" class="block text-sm font-medium text-slate-700 mb-1">Personal Website/Portfolio URL</label>
                            <input type="url" id="website_url" name="website_url" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['website_url']); ?>">
                        </div>
                    </div>

                    <!-- Summary -->
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Summary</h2>
                    <div class="mb-8">
                        <label for="summary" class="block text-sm font-medium text-slate-700 mb-1">Summary/Objective</label>
                        <textarea id="summary" name="summary" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($profile_data['summary']); ?></textarea>
                    </div>

                    <!-- Work Experience -->
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Work Experience (Latest/Primary)</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="job_title" class="block text-sm font-medium text-slate-700 mb-1">Job Title</label>
                            <input type="text" id="job_title" name="job_title" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['job_title']); ?>">
                        </div>
                        <div>
                            <label for="employer" class="block text-sm font-medium text-slate-700 mb-1">Company Name</label>
                            <input type="text" id="employer" name="employer" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['employer']); ?>">
                        </div>
                        <div>
                            <label for="job_location" class="block text-sm font-medium text-slate-700 mb-1">Job Location (City, State/Country)</label>
                            <input type="text" id="job_location" name="job_location" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['job_location']); ?>">
                        </div>
                        <div>
                            <label for="job_duration" class="block text-sm font-medium text-slate-700 mb-1">Dates (e.g., Jan 2020 - Present)</label>
                            <input type="text" id="job_duration" name="job_duration" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['job_duration']); ?>">
                        </div>
                        <div class="md:col-span-2">
                            <label for="job_description" class="block text-sm font-medium text-slate-700 mb-1">Key Responsibilities and Achievements</label>
                            <textarea id="job_description" name="job_description" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($profile_data['job_description']); ?></textarea>
                        </div>
                    </div>

                    <!-- Education -->
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Education (Highest/Primary)</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="degree" class="block text-sm font-medium text-slate-700 mb-1">Degree/Qualification</label>
                            <input type="text" id="degree" name="degree" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['degree']); ?>">
                        </div>
                        <div>
                            <label for="university" class="block text-sm font-medium text-slate-700 mb-1">University/Institution Name</label>
                            <input type="text" id="university" name="university" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['university']); ?>">
                        </div>
                        <div>
                            <label for="education_location" class="block text-sm font-medium text-slate-700 mb-1">Education Location (City, State/Country)</label>
                            <input type="text" id="education_location" name="education_location" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['education_location']); ?>">
                        </div>
                        <div>
                            <label for="graduation_year" class="block text-sm font-medium text-slate-700 mb-1">Graduation Year</label>
                            <input type="text" id="graduation_year" name="graduation_year" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['graduation_year']); ?>">
                        </div>
                    </div>

                    <!-- Skills -->
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Skills</h2>
                    <div class="mb-8">
                        <label for="skills" class="block text-sm font-medium text-slate-700 mb-1">Skills (comma-separated)</label>
                        <input type="text" id="skills" name="skills" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?php echo htmlspecialchars($profile_data['skills']); ?>">
                    </div>

                    <!-- Projects -->
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Projects</h2>
                    <div class="mb-8">
                        <label for="projects" class="block text-sm font-medium text-slate-700 mb-1">Projects (e.g., list them or describe in brief)</label>
                        <textarea id="projects" name="projects" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($profile_data['projects']); ?></textarea>
                    </div>

                    <!-- Certifications -->
                    <h2 class="text-xl font-semibold text-slate-700 border-b pb-2 mb-4">Certifications</h2>
                    <div class="mb-8">
                        <label for="certifications" class="block text-sm font-medium text-slate-700 mb-1">Certifications/Awards (e.g., list them)</label>
                        <textarea id="certifications" name="certifications" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($profile_data['certifications']); ?></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 border-t pt-6">
                        <a href="Profile.php" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium px-6 py-2 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-6 py-2 rounded-lg transition-colors">
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <?php include 'includes/Footer.php'; ?>

</body>
</html>