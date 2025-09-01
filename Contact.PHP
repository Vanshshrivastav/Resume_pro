<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - ResumeBuilder Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
    <?php include 'header.php'; ?>

    <div class="bg-slate-50 py-12 sm:py-16">
        <div class="container mx-auto max-w-7xl px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-slate-800 sm:text-6xl">Contact Us</h1>
                <p class="mt-6 text-lg leading-8 text-slate-600">
                    We'd love to hear from you! Please fill out the form below to get in touch.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white py-12 sm:py-16">
        <div class="container mx-auto max-w-4xl px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-x-8 gap-y-16 md:grid-cols-2">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-800">Contact Information</h2>
                    <p class="mt-4 text-lg leading-8 text-slate-600">
                        You can also reach us at:
                    </p>
                    <div class="mt-8 space-y-4">
                        <div class="flex items-center">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                            </div>
                            <p class="ml-4 text-base text-slate-600">123 Main Street, Anytown, USA</p>
                        </div>
                        <div class="flex items-center">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 6.75z" />
                                </svg>
                            </div>
                            <p class="ml-4 text-base text-slate-600">+1 (555) 123-4567</p>
                        </div>
                        <div class="flex items-center">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <p class="ml-4 text-base text-slate-600">contact@resumebuilderpro.com</p>
                        </div>
                    </div>
                </div>
                <div>
                    <form action="#" method="POST" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium leading-6 text-slate-800">Full name</label>
                            <div class="mt-2">
                                <input type="text" name="name" id="name" autocomplete="name" class="block w-full rounded-md border-0 py-2 px-3.5 text-slate-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-slate-800">Email address</label>
                            <div class="mt-2">
                                <input type="email" name="email" id="email" autocomplete="email" class="block w-full rounded-md border-0 py-2 px-3.5 text-slate-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium leading-6 text-slate-800">Subject</label>
                            <div class="mt-2">
                                <input type="text" name="subject" id="subject" class="block w-full rounded-md border-0 py-2 px-3.5 text-slate-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium leading-6 text-slate-800">Message</label>
                            <div class="mt-2">
                                <textarea name="message" id="message" rows="4" class="block w-full rounded-md border-0 py-2 px-3.5 text-slate-800 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"></textarea>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="rounded-md bg-blue-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Send message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'Footer.php'; ?>
</body>
</html>