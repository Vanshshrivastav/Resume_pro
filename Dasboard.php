<?php
session_start();
include("includes/Dbconnection.php"); // database connection file

// --- Security Check: Ensure an admin is logged in ---
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
} 

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

// Fetch all users data including their blocked status
$query = "SELECT id, username, email, is_blocked FROM users";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - User Management</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">

    <?php include 'includes/header.php'; ?>

    <main class="container mx-auto max-w-5xl py-12 px-4 flex-grow">
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

        <div class="bg-white shadow-lg rounded-xl overflow-hidden ">
            <div class="p-6 bg-slate-800 text-white">
                <h1 class="text-2xl font-bold">Admin Dashboard</h1>
                <p class="text-slate-300">User Management</p>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-slate-200 divide-y divide-slate-200">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            <?php
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-slate-700'>" . $row['id'] . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900'>" . htmlspecialchars($row['username']) . "</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-slate-700'>" . htmlspecialchars($row['email']) . "</td>";

                                    // Display Status
                                    if ($row['is_blocked']) {
                                        echo "<td class='px-6 py-4 whitespace-nowrap text-sm'>
                                                <span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800'>
                                                    Blocked
                                                </span>
                                              </td>";
                                    } else {
                                        echo "<td class='px-6 py-4 whitespace-nowrap text-sm'>
                                                <span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800'>
                                                    Active
                                                </span>
                                              </td>";
                                    }

                                    // Action Button (Block/Unblock)
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-center'>";
                                    // Admin cannot block themselves
                                    if ($row['username'] !== 'admin') {
                                        if ($row['is_blocked']) {
                                            echo "<a href='process/toggle_block_user.php?id=" . $row['id'] . "' 
                                                   class='bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors'
                                                   onclick='return confirm(\"Are you sure you want to unblock this user?\")'>
                                                   Unblock
                                                </a>";
                                        } else {
                                            echo "<a href='process/toggle_block_user.php?id=" . $row['id'] . "' 
                                                   class='bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors'
                                                   onclick='return confirm(\"Are you sure you want to block this user?\")'>
                                                   Block
                                                </a>";
                                        }
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center px-6 py-4 text-slate-500'>No user records found.</td></tr>";
                            }
                            mysqli_close($con);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include 'includes/Footer.php'; ?>
</body>

</html>