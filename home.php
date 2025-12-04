<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
<?php
session_start();
if (isset($_SESSION['admin'])) {
    include 'includes/Header1.php';
} else {
    include 'includes/header.php';
}
?>


<!-- Hero Section -->
<main class="bg-slate-50 py-16 px-4">
    <div class="container mx-auto max-w-4xl text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-4 leading-tight">
            Create Resumes That<br>
            <span class="text-blue-500">Get You Hired</span>
        </h1>

        <p class="text-slate-600 text-lg md:text-xl mb-8 max-w-2xl mx-auto leading-relaxed">
            Build professional, ATS-optimized resumes in minutes with our modern templates and
            intuitive drag-and-drop editor. Join over 2 million job seekers who trust us.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-8 py-3 rounded-lg text-lg transition-colors flex items-center">
                <a href="Resume1.php">Start Building Free</a>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <button
                class="bg-transparent hover:bg-slate-200 text-slate-700 font-semibold px-8 py-3 rounded-lg text-lg border border-slate-300 transition-colors">
                <a href="Templetpage.php">Browse Templates</a>
            </button>
        </div>
    </div>
</main>


<!-- Features Section -->
<section class="bg-white py-16 px-4">
    <div class="container mx-auto max-w-6xl">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <div
                class="inline-flex items-center bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                        clip-rule="evenodd"></path>
                </svg>
                Powerful Features
            </div>

            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">
                Everything You Need to <span class="bg-blue-500 text-white px-2 py-1 rounded">Succeed</span>
            </h2>

            <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                Our platform combines cutting-edge technology with beautiful design to give you the
                ultimate resume building experience.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Lightning Fast Builder -->
            <div class="text-center p-6 rounded-lg hover:bg-slate-100 transition-colors">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-800 mb-3">Lightning Fast Builder</h3>
                <p class="text-slate-600">
                    Create stunning resumes in under 5 minutes with our intuitive drag-and-drop editor.
                </p>
            </div>

            <!-- ATS Optimized -->
            <div class="text-center p-6 rounded-lg hover:bg-slate-100 transition-colors">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-800 mb-3">ATS Optimized</h3>
                <p class="text-slate-600">
                    All templates are designed to pass modern Applicant Tracking Systems with ease.
                </p>
            </div>

            <!-- Smart Suggestions -->
            <div class="text-center p-6 rounded-lg hover:bg-slate-100 transition-colors">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-800 mb-3">Smart Suggestions</h3>
                <p class="text-slate-600">
                    AI-powered content suggestions help you write compelling resume sections.
                </p>
            </div>

            <!-- Multiple Formats -->
            <div class="text-center p-6 rounded-lg hover:bg-slate-100 transition-colors">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-800 mb-3">Multiple Formats</h3>
                <p class="text-slate-600">
                    Download as PDF, Word, or share with a custom link for instant access.
                </p>
            </div>
        </div>
    </div>
</section>


<!-- CTA Section -->
<section class="bg-blue-700 py-16 px-4">
    <div class="container mx-auto max-w-4xl text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Ready to Land Your Dream Job?
        </h2>

        <p class="text-blue-100 text-lg md:text-xl mb-8 max-w-2xl mx-auto">
            Join millions of professionals who have successfully created standout resumes with our platform.
        </p>

        <button
            class="bg-blue-400 hover:bg-blue-500 text-white font-semibold px-8 py-3 rounded-lg text-lg transition-colors">
            <a href="Resume1.php">Create Your Resume Now</a>
        </button>
    </div>
</section>


<?php include 'includes/Footer.php' ?>

</body>

</html>