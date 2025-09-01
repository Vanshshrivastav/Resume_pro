<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ResumeBuilder Pro</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-50">

    <!-- Register Section -->
    <main class=" py-16 mt-15 justify-center px-4">
        <div class="container mx-auto max-w-md">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-slate-800">Create Your Account</h1>
                    <p class="text-slate-600">Join us and start building your professional resume today.</p>
                </div>

                <form action="register_process.php" method="post">
                    <div class="mb-6">
                        <label for="username" class="block text-slate-700 text-sm font-semibold mb-2">Username</label>
                        <input type="text" id="username" name="username" placeholder="Choose a username"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-slate-700 text-sm font-semibold mb-2">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-slate-700 text-sm font-semibold mb-2">Password</label>
                        <input type="password" id="password" name="password" placeholder="Create a strong password"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-3 rounded-lg text-lg transition-colors">
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="text-center mt-6">
                    <p class="text-sm text-slate-600">
                        Already have an account? <a href="login.php"
                            class="font-semibold text-blue-500 hover:text-blue-600">Log in</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

</body>

</html>