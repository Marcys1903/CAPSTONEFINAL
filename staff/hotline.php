<?php
session_start();
include "../config/config.php"; // DB connection

// Block if not staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../auth/login.php");
    exit();
}

// Correct SQL to match your DB
$sql = "SELECT id, hotline_number, agency, created_at FROM hotlines ORDER BY id ASC";
$result = $conn->query($sql);

$username = $_SESSION['username'] ?? "Staff";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotlines - Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col overflow-y-auto h-screen">
        <div class="p-6 text-2xl font-bold border-b border-gray-700">
            Staff Panel
        </div>
        <nav class="flex-1 p-4">
            <a href="dashboard.php" class="block py-2 px-3 rounded hover:bg-gray-800">Dashboard</a>
            <a href="messages.php" class="block py-2 px-3 rounded hover:bg-gray-700">Messages</a>
            <a href="send_alert.php" class="block py-2 px-3 rounded hover:bg-gray-700">Send Alert</a>
            <a href="view_alerts.php" class="block py-2 px-3 rounded hover:bg-gray-700">View Alerts</a>
            <a href="hotline.php" class="block py-2 px-3 rounded bg-gray-700">Hotline</a>
            <a href="audit.php" class="block py-2 px-3 rounded hover:bg-gray-700">Audit Logs</a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <a href="../auth/logout.php" class="block py-2 px-3 rounded bg-red-600 text-center hover:bg-red-700">Logout</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage Emergency Hotlines</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php
            if ($result && $result->num_rows > 0):
                while($row = $result->fetch_assoc()):
                    $agency  = $row['agency'] ?? 'N/A';
                    $hotline = $row['hotline_number'] ?? 'N/A';
                    $created = $row['created_at'] ?? '';
            ?>
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-xl font-semibold text-gray-700">
                        <?= htmlspecialchars($agency) ?>
                    </h2>
                    <p class="text-lg text-gray-600">
                        Hotline: <?= htmlspecialchars($hotline) ?>
                    </p>
                    <p class="text-sm text-gray-500">
                        Added on: <?= htmlspecialchars($created) ?>
                    </p>
                    <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Suggest Update
                    </button>
                </div>
            <?php
                endwhile;
            else:
                echo "<p class='text-gray-600'>No hotline records found.</p>";
            endif;
            ?>
        </div>
    </main>

</body>
</html>
