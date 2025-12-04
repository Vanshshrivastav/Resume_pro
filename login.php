<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ResumeBuilder Pro</title>
        <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50">

    <!-- Login Section -->
    <main class="py-16 mt-15 justify-center px-4">
        <div class="container mx-auto max-w-md">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-slate-800">Welcome Back</h1>
                    <p class="text-slate-600">Sign in to continue to your account.</p>
                </div>

                <form action="process/login_process.php" method="post">
                    <div class="mb-6">
                        <label for="email" class="block text-slate-700 text-sm font-semibold mb-2">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email address"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-slate-700 text-sm font-semibold mb-2">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            required>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-500 focus:ring-blue-500 border-slate-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-slate-800">Remember me</label>
                        </div>
                        <a href="#" class="text-sm text-blue-500 hover:text-blue-600">Forgot password?</a>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-3 rounded-lg text-lg transition-colors">
                            Login
                        </button>
                    </div>
                </form>

                <div class="text-center mt-6">
                    <p class="text-sm text-slate-600">
                        Don't have an account? <a href="Register.php" class="font-semibold text-blue-500 hover:text-blue-600">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>