<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Builder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body class="bg-slate-50">
    <?php
    session_start();
    if (isset($_SESSION['admin'])) {
        include 'Header1.php';
    } else {
        include 'header.php';
    }
    ?>

    <div class="container mx-auto p-4 max-w-6xl">
        <h1 class="text-3xl font-bold text-center mb-6 text-slate-800">Resume Builder</h1>

        <div class="grid lg:grid-cols-2 gap-6">
            <!-- Form -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-slate-800">Fill Your Information</h2>

                <form action="Resume1_process.php" method="post">
                    <!-- Personal Info -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-3 text-blue-500">Personal Information</h3>
                        <div class="space-y-3">
                            <input type="text" name="Fullname" id="Fullname" placeholder="Full Name"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <input type="email" name="email" id="email" placeholder="Email"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <input type="tel" name="Phone" id="Phone" placeholder="Phone"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <input type="text" name="Address" id="Address" placeholder="Address"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-3 text-blue-500">Education</h3>
                        <div class="space-y-3">
                            <input type="text" name="College_name" id="College_name" placeholder="College/University"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <input type="text" name="Degree" id="Degree" placeholder="Degree"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <input type="date" name="Education_Date" id="Education_Date"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <input type="text" name="Location" id="Location" placeholder="Location"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-3 text-blue-500">Work Experience</h3>
                        <div class="space-y-3">
                            <input type="text" name="Job_Title" id="Job_Title" placeholder="Job Title"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <input type="text" name="Employer" id="Employer" placeholder="Company"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <input type="text" name="Country" id="Country" placeholder="Country"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <input type="text" name="City" id="City" placeholder="City"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <input type="text" name="Duration" id="Duration" placeholder="Duration (e.g., 2020-2023)"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <input type="text" name="Skills" id="Skills" placeholder="Skills (comma separated)"
                                class="w-full p-2 border rounded" oninput="updatePreview()">
                            <textarea name="Summary" id="Summary" placeholder="Job description" rows="3"
                                class="w-full p-2 border rounded" oninput="updatePreview()"></textarea>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600 mt-2">
                        Submit
                    </button>
                    <button type="button" onclick="downloadPDF()"
                        class="w-full bg-green-500 text-white p-3 rounded hover:bg-green-600 mt-2">
                        Download PDF
                    </button>
                </form>
            </div>

            <!-- Preview -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-slate-800">Live Preview</h2>

                <div id="resume-preview" class="border p-4 min-h-96">
                    <!-- Header -->
                    <div class="text-center border-b pb-4 mb-4">
                        <h1 id="prev-name" class="text-2xl font-bold text-slate-800">Your Name</h1>
                        <div class="text-sm text-slate-600 mt-2">
                            <p id="prev-email" class="hidden"></p>
                            <p id="prev-phone" class="hidden"></p>
                            <p id="prev-address" class="hidden"></p>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div id="summary-section" class="mb-4 hidden">
                        <h3 class="font-bold text-blue-500 mb-2">SUMMARY</h3>
                        <p id="prev-summary" class="text-sm text-slate-600"></p>
                    </div>

                    <!-- Experience -->
                    <div id="experience-section" class="mb-4 hidden">
                        <h3 class="font-bold text-blue-500 mb-2">EXPERIENCE</h3>
                        <div class="mb-2">
                            <div class="flex justify-between">
                                <span id="prev-job" class="font-semibold text-slate-800"></span>
                                <span id="prev-duration" class="text-sm text-slate-600"></span>
                            </div>
                            <div class="flex justify-between">
                                <span id="prev-company" class="text-sm text-slate-600"></span>
                                <span id="prev-work-location" class="text-sm text-slate-600"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Education -->
                    <div id="education-section" class="mb-4 hidden">
                        <h3 class="font-bold text-blue-500 mb-2">EDUCATION</h3>
                        <div class="mb-2">
                            <div class="flex justify-between">
                                <span id="prev-degree" class="font-semibold text-slate-800"></span>
                                <span id="prev-year" class="text-sm text-slate-600"></span>
                            </div>
                            <div class="flex justify-between">
                                <span id="prev-college" class="text-sm text-slate-600"></span>
                                <span id="prev-edu-location" class="text-sm text-slate-600"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div id="skills-section" class="hidden">
                        <h3 class="font-bold text-blue-500 mb-2">SKILLS</h3>
                        <div id="prev-skills" class="flex flex-wrap gap-2"></div>
                    </div>

                    <!-- Empty message -->
                    <div id="empty-message" class="text-center text-slate-500 py-8">
                        <p>Start filling the form to see your resume preview</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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

            // Check if any field has content
            const hasContent = [name, email, phone, address, college, degree, jobTitle, employer, skills, summary].some(field => field && field !== 'Your Name');

            // Show/hide empty message
            document.getElementById('empty-message').style.display = hasContent ? 'none' : 'block';

            // Update basic info
            document.getElementById('prev-name').textContent = name;

            // Update contact info
            updateContact('prev-email', email, 'Email: ');
            updateContact('prev-phone', phone, 'Phone: ');
            updateContact('prev-address', address, '');

            // Update sections
            updateSection('summary-section', summary, 'prev-summary');
            updateSection('experience-section', jobTitle || employer, () => {
                document.getElementById('prev-job').textContent = jobTitle;
                document.getElementById('prev-company').textContent = employer;
                document.getElementById('prev-duration').textContent = duration;
                document.getElementById('prev-work-location').textContent = city && country ? city + ', ' + country : '';
            });

            updateSection('education-section', degree || college, () => {
                document.getElementById('prev-degree').textContent = degree;
                document.getElementById('prev-college').textContent = college;
                document.getElementById('prev-edu-location').textContent = location;
                document.getElementById('prev-year').textContent = eduDate ? new Date(eduDate).getFullYear() : '';
            });

            updateSection('skills-section', skills, () => {
                const skillsContainer = document.getElementById('prev-skills');
                skillsContainer.innerHTML = '';
                if (skills) {
                    skills.split(',').forEach(skill => {
                        if (skill.trim()) {
                            const span = document.createElement('span');
                            span.className = 'bg-slate-200 px-2 py-1 rounded text-sm';
                            span.textContent = skill.trim();
                            skillsContainer.appendChild(span);
                        }
                    });
                }
            });
        }

        function updateContact(id, value, prefix) {
            const element = document.getElementById(id);
            if (value) {
                element.textContent = prefix + value;
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        }

        function updateSection(sectionId, condition, updateContent) {
            const section = document.getElementById(sectionId);
            if (condition) {
                section.classList.remove('hidden');
                if (typeof updateContent === 'function') {
                    updateContent();
                } else if (typeof updateContent === 'string') {
                    document.getElementById(updateContent).textContent = condition;
                }
            } else {
                section.classList.add('hidden');
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

            // Check if any field is empty
            for (let field in data) {
                if (!data[field] || data[field].trim() === '') {
                    alert('Please fill all fields before downloading PDF!');
                    return;
                }
            }

            // Create new PDF
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF();
            let line = 20; // Starting position

            // Name (big and bold)
            pdf.setFontSize(20);
            pdf.setFont(undefined, 'bold');
            pdf.text(data.name, 105, line, { align: 'center' });
            line += 15;

            // Contact info
            pdf.setFontSize(10);
            pdf.setFont(undefined, 'normal');
            pdf.text(`${data.email} | ${data.phone} | ${data.address}`, 105, line, { align: 'center' });
            line += 20;

            // Summary section
            pdf.setFontSize(12);
            pdf.setFont(undefined, 'bold');
            pdf.text('SUMMARY', 20, line);
            line += 8;

            pdf.setFontSize(10);
            pdf.setFont(undefined, 'normal');
            pdf.text(data.summary, 20, line, { maxWidth: 170 });
            line += 20;

            // Experience section
            pdf.setFontSize(12);
            pdf.setFont(undefined, 'bold');
            pdf.text('EXPERIENCE', 20, line);
            line += 8;

            pdf.setFont(undefined, 'normal');
            pdf.text(`${data.jobTitle} at ${data.employer}`, 20, line);
            pdf.text(data.duration, 190, line, { align: 'right' });
            line += 6;
            pdf.text(`${data.city}, ${data.country}`, 20, line);
            line += 20;

            // Education section
            pdf.setFontSize(12);
            pdf.setFont(undefined, 'bold');
            pdf.text('EDUCATION', 20, line);
            line += 8;

            pdf.setFont(undefined, 'normal');
            pdf.text(`${data.degree} from ${data.college}`, 20, line);
            const year = new Date(data.eduDate).getFullYear();
            pdf.text(year.toString(), 190, line, { align: 'right' });
            line += 6;
            pdf.text(data.location, 20, line);
            line += 20;

            // Skills section
            pdf.setFontSize(12);
            pdf.setFont(undefined, 'bold');
            pdf.text('SKILLS', 20, line);
            line += 8;

            pdf.setFont(undefined, 'normal');
            pdf.text(data.skills, 20, line, { maxWidth: 170 });

            // Save the PDF
            pdf.save(`${data.name}_Resume.pdf`);
        }

        // Initialize preview
        updatePreview();
    </script>
    <?php include 'Footer.php' ?>
</body>

</html>