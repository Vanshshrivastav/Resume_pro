<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Resume Templates</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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
    <!-- Templates Section -->
    <section class="py-16 px-4">
        <div class="container mx-auto max-w-7xl">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">
                    Professional Resume Templates
                </h1>
                <p class="text-slate-600 text-lg max-w-3xl mx-auto">
                    Choose from our collection of 16 professionally designed, ATS-friendly templates. Each
                    template is crafted to help you stand out and land your dream job.
                </p>
            </div>

            <!-- Creative Professional Template -->
            <div class="flex gap-5">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow w-60">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=400&h=300&fit=crop&crop=center"
                            alt="Creative Professional" class="w-full h-48 object-cover">

                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-slate-800 mb-2">Creative Professional</h3>
                        <p class="text-slate-600 text-sm mb-3">Stand out with this creative and colorful design</p>
                        <div class="flex justify-between items-center">
                            <button class="text-blue-500 hover:text-blue-600 font-medium text-sm flex items-center">
                                <a href="Resume1.php"> Select →</a>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow w-60">
                    <div class="relative">
                        <img src="https://i.pinimg.com/736x/b3/65/69/b36569309fd30a916806e524324b876c.jpg"
                            alt="Creative Professional" class="w-full h-48 object-cover">

                        <!-- Coming Soon Badge -->
                        <span
                            class="absolute top-2 left-2 bg-amber-600 text-white text-xs font-semibold px-2 py-1 rounded">
                            Coming Soon
                        </span>
                    </div>

                    <div class="p-4">
                        <h3 class="font-semibold text-slate-800 mb-2">Creative Professional</h3>
                        <p class="text-slate-600 text-sm mb-3">Stand out with this creative and colorful design</p>
                        <div class="flex justify-between items-center">
                            <button class="text-blue-500 hover:text-blue-600 font-medium text-sm flex items-center"
                                disabled>
                                <span class="opacity-50 cursor-not-allowed">Select →</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?PHP include 'includes/Footer.php' ?>
</body>

</html>