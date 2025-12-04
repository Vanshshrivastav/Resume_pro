<?php
session_start();
require 'includes/Dbconnection.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// --- Pre-fetch user's master profile data ---
$profile_data = [];
$query_profile = "SELECT * FROM profiles WHERE user_id = ?";
$stmt_profile = mysqli_prepare($con, $query_profile);
mysqli_stmt_bind_param($stmt_profile, "i", $user_id);
if (mysqli_stmt_execute($stmt_profile)) {
    $result = mysqli_stmt_get_result($stmt_profile);
    $profile_data = mysqli_fetch_assoc($result);
}
mysqli_stmt_close($stmt_profile);

// Pre-fetch user's email from users table
$user_email = '';
$query_user = "SELECT email FROM users WHERE id = ?";
$stmt_user = mysqli_prepare($con, $query_user);
mysqli_stmt_bind_param($stmt_user, "i", $user_id);
if (mysqli_stmt_execute($stmt_user)) {
    $result_user = mysqli_stmt_get_result($stmt_user);
    $user_details = mysqli_fetch_assoc($result_user);
    $user_email = $user_details['email'] ?? '';
}
mysqli_stmt_close($stmt_user);


// Helper to get profile data or default to empty string
function get_profile_data($field, $profile_data, $default = '') {
    return htmlspecialchars($profile_data[$field] ?? $default);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Resume - ResumeBuilder Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body class="bg-slate-50">
    <?php
    if (isset($_SESSION['admin'])) {
        include 'includes/Header1.php';
    } else {
        include 'includes/header.php';
    }
    ?>

    <div class="container mx-auto p-4 max-w-6xl">
        <h1 class="text-3xl font-bold text-center mb-6 text-slate-800">Create a New Resume</h1>
        <p class="text-center text-slate-500 mb-6">This form is pre-filled with your master profile data. Modify any field and click "Save New Resume" to create a snapshot.</p>

        <div class="grid lg:grid-cols-2 gap-6">
            <!-- Form -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-slate-800">Resume Details</h2>

                <form action="process/Resume1_process.php" method="post">
                    <!-- Hidden fields for new resume table columns -->
                    <input type="hidden" name="template_id" value="template1">
                    
                    <div class="mb-6">
                        <label for="resume_title" class="font-medium mb-3 text-blue-500">Resume Title</label>
                        <input type="text" name="resume_title" id="resume_title" placeholder="e.g., Resume for Software Engineer Role"
                                class="w-full p-2 border rounded" value="My Resume (<?php echo date('Y-m-d'); ?>)">
                    </div>

                    <!-- Personal Info -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-3 text-blue-500">Personal Information</h3>
                        <div class="space-y-3">
                            <input type="text" name="Fullname" id="Fullname" placeholder="Full Name"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo get_profile_data('full_name', $profile_data); ?>">
                            <input type="email" name="email" id="email" placeholder="Email"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo htmlspecialchars($user_email); ?>">
                            <input type="tel" name="Phone" id="Phone" placeholder="Phone"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo get_profile_data('phone_number', $profile_data); ?>">
                            <input type="text" name="Address" id="Address" placeholder="Address (not saved in snapshot)"
                                class="w-full p-2 border rounded bg-slate-100" oninput="updatePreview()">
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-3 text-blue-500">Education</h3>
                        <div class="space-y-3">
                            <input type="text" name="College_name" id="College_name" placeholder="College/University"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo get_profile_data('university', $profile_data); ?>">
                            <input type="text" name="Degree" id="Degree" placeholder="Degree"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo get_profile_data('degree', $profile_data); ?>">
                            <input type="text" name="Education_Date" id="Education_Date" placeholder="Graduation Year"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo get_profile_data('graduation_year', $profile_data); ?>">
                            <input type="text" name="Location" id="Location" placeholder="Education Location"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo get_profile_data('education_location', $profile_data); ?>">
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-3 text-blue-500">Work Experience</h3>
                        <div class="space-y-3">
                            <input type="text" name="Job_Title" id="Job_Title" placeholder="Job Title"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo get_profile_data('job_title', $profile_data); ?>">
                            <input type="text" name="Employer" id="Employer" placeholder="Company"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo get_profile_data('employer', $profile_data); ?>">
                            
                            <!-- Split job_location for editing -->
                            <?php 
                                $job_location_parts = explode(',', get_profile_data('job_location', $profile_data));
                                $city = trim($job_location_parts[0] ?? '');
                                $country = trim($job_location_parts[1] ?? '');
                            ?>
                            <input type="text" name="City" id="City" placeholder="City"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo $city; ?>">
                            <input type="text" name="Country" id="Country" placeholder="Country"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo $country; ?>">

                            <input type="text" name="Duration" id="Duration" placeholder="Duration (e.g., 2020-2023)"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo get_profile_data('job_duration', $profile_data); ?>">
                            <textarea name="Summary" id="Summary" placeholder="Professional Summary" rows="3"
                                class="w-full p-2 border rounded" oninput="updatePreview()"><?php echo get_profile_data('summary', $profile_data); ?></textarea>
                        </div>
                    </div>

                     <!-- Skills -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-3 text-blue-500">Skills</h3>
                         <input type="text" name="Skills" id="Skills" placeholder="Skills (comma separated)"
                                class="w-full p-2 border rounded" oninput="updatePreview()" value="<?php echo get_profile_data('skills', $profile_data); ?>">
                    </div>


                    <button type="submit"
                        class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600 mt-2">
                        Save New Resume
                    </button>
                    <button type="button" onclick="downloadPDF()"
                        class="w-full bg-green-500 text-white p-3 rounded hover:bg-green-600 mt-2">
                        Download as PDF
                    </button>
                </form>
            </div>

            <!-- Preview -->
            <div id="preview-container" class="bg-white p-6 rounded-lg shadow">
                <!-- Preview content remains the same, will be populated by JS -->
                 <h2 class="text-xl font-semibold mb-4 text-slate-800">Live Preview</h2>
                <div id="resume-preview" class="border p-4 min-h-96">
                    <!-- JS will populate this -->
                </div>
            </div>
        </div>
    </div>

    <script>
       // JS logic from the original file (updatePreview, downloadPDF, etc.) remains unchanged.
       // It reads from the form fields, so it will work correctly with the pre-populated data.
       function updatePreview() {
            // Get form values
            const name = document.getElementById('Fullname').value || 'Your Name';
            const email = document.getElementById('email').value;
            const phone = document.getElementById('Phone').value;
            const address = document.getElementById('Address').value;
            const college = document.getElementById('College_name').value;
            const degree = document.getElementById('Degree').value;
            const eduDate = document.getElementById('Education_Date').value;
            const location = document.getElementById('Location').value;
            const jobTitle = document.getElementById('Job_Title').value;
            const employer = document.getElementById('Employer').value;
            const country = document.getElementById('Country').value;
            const city = document.getElementById('City').value;
            const duration = document.getElementById('Duration').value;
            const skills = document.getElementById('Skills').value;
            const summary = document.getElementById('Summary').value;

            const preview = document.getElementById('resume-preview');
            // Clear previous content
            preview.innerHTML = '';

            // --- Build Preview HTML ---
            let html = `<div class="text-center border-b pb-4 mb-4">
                            <h1 class="text-2xl font-bold text-slate-800">${name}</h1>
                            <div class="text-sm text-slate-600 mt-2">
                                <p>${email}</p>
                                <p>${phone}</p>
                                <p>${address}</p>
                            </div>
                        </div>`;

            if (summary) {
                html += `<div class="mb-4">
                            <h3 class="font-bold text-blue-500 mb-2">SUMMARY</h3>
                            <p class="text-sm text-slate-600">${summary}</p>
                         </div>`;
            }

            if (jobTitle || employer) {
                html += `<div class="mb-4">
                            <h3 class="font-bold text-blue-500 mb-2">EXPERIENCE</h3>
                            <div class="mb-2">
                                <div class="flex justify-between">
                                    <span class="font-semibold text-slate-800">${jobTitle}</span>
                                    <span class="text-sm text-slate-600">${duration}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">${employer}</span>
                                    <span class="text-sm text-slate-600">${city}, ${country}</span>
                                </div>
                            </div>
                         </div>`;
            }
            
            if (degree || college) {
                 html += `<div class="mb-4">
                            <h3 class="font-bold text-blue-500 mb-2">EDUCATION</h3>
                            <div class="mb-2">
                                <div class="flex justify-between">
                                    <span class="font-semibold text-slate-800">${degree}</span>
                                    <span class="text-sm text-slate-600">${eduDate}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">${college}</span>
                                    <span class="text-sm text-slate-600">${location}</span>
                                </div>
                            </div>
                         </div>`;
            }

            if (skills) {
                html += `<div class="mb-4">
                            <h3 class="font-bold text-blue-500 mb-2">SKILLS</h3>
                            <div class="flex flex-wrap gap-2">
                                ${skills.split(',').map(s => `<span class="bg-slate-200 px-2 py-1 rounded text-sm">${s.trim()}</span>`).join('')}
                            </div>
                        </div>`;
            }

            if (!html.includes('h3')) { // If no sections were added
                preview.innerHTML = `<div id="empty-message" class="text-center text-slate-500 py-8">
                                        <p>Start filling the form to see your resume preview</p>
                                     </div>`;
            } else {
                 preview.innerHTML = html;
            }
        }

        function downloadPDF() {
            // Get all the form values
            const data = {
                name: document.getElementById('Fullname').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('Phone').value,
                address: document.getElementById('Address').value,
                college: document.getElementById('College_name').value,
                degree: document.getElementById('Degree').value,
                eduDate: document.getElementById('Education_Date').value,
                location: document.getElementById('Location').value,
                jobTitle: document.getElementById('Job_Title').value,
                employer: document.getElementById('Employer').value,
                country: document.getElementById('Country').value,
                city: document.getElementById('City').value,
                duration: document.getElementById('Duration').value,
                skills: document.getElementById('Skills').value,
                summary: document.getElementById('Summary').value
            };

            for (let field in data) {
                if (!data[field] || data[field].trim() === '') {
                    alert('Please fill all fields before downloading PDF!');
                    return;
                }
            }
            
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('p', 'pt', 'a4');

            const margin = 20;
            let y = margin;
            
            pdf.setFontSize(22).setFont(undefined, 'bold').text(data.name, pdf.internal.pageSize.getWidth()/2, y, {align: 'center'});
            y += 15;
            pdf.setFontSize(10).setFont(undefined, 'normal').text(`${data.email} | ${data.phone} | ${data.address}`, pdf.internal.pageSize.getWidth()/2, y, {align: 'center'});
            y += 30;

            const addSection = (title, content) => {
                pdf.setFontSize(14).setFont(undefined, 'bold').text(title, margin, y);
                y+=15;
                pdf.setFontSize(10).setFont(undefined, 'normal');
                const splitContent = pdf.splitTextToSize(content, pdf.internal.pageSize.getWidth() - margin*2);
                pdf.text(splitContent, margin, y);
                y += (splitContent.length * 12) + 10;
            };

            addSection('Summary', data.summary);
            addSection('Experience', `${data.jobTitle} at ${data.employer} (${data.duration})\n${data.city}, ${data.country}`);
            addSection('Education', `${data.degree} from ${data.college} (${data.eduDate})\n${data.location}`);
            addSection('Skills', data.skills);
            
            pdf.save(`${data.name}_Resume.pdf`);
        }
       
       // Initial call to populate the preview with pre-filled data
       document.addEventListener('DOMContentLoaded', updatePreview);
    </script>
    <?php include 'includes/Footer.php' ?>
</body>

</html>
