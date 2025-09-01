<?php
session_start();
include("Dbconnection.php"); // database connection file

// Fetch data from user table
$query = "SELECT * FROM users";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
     <?php include 'Header1.php' ?>

    <div class="container  mx-auto mt-10 justify-center h-screen">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-blue-500 text-white px-6 py-4">
                <h3 class="text-xl font-semibold">All User</h3>
            </div>
            <div class="p-6">
                <table class="min-w-full border border-slate-300 divide-y divide-slate-200">
                    <thead class="bg-slate-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Username</th>
                            <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Remove</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-slate-700'>" . $row['username'] . "</td>";
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm text-slate-700'>" . $row['email'] . "</td>";

                                // Delete Links
                                echo "<td class='px-6 py-4 whitespace-nowrap text-sm'>
                                        <a href='delete.php?id=" . $row['id'] . "' 
                                           class='bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm'
                                           onclick='return confirm(\"Are you sure?\")'>
                                           Delete
                                        </a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center px-6 py-4 text-slate-500'>No Records Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

     <?php include 'Footer.php' ?>
</body>

</html>