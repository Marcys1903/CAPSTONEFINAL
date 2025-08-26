<?php
session_start();

// Database connection (update if needed)
$host = "localhost";
$user = "root"; // change if you set MySQL user
$pass = "";     // change if you set MySQL password
$dbname = "lgu_emergency_system";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Block if not staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch hotlines
$result = $conn->query("SELECT * FROM hotlines ORDER BY id ASC");
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
            <a href="dashboard.php" class="block py-2 px-3 rounded hover:bg-gray-700">Dashboard</a>
            <a href="messages.php" class="block py-2 px-3 rounded hover:bg-gray-700">Messages</a>
            <a href="send_alert.php" class="block py-2 px-3 rounded hover:bg-gray-700">Send Alert</a>
            <a href="view_alerts.php" class="block py-2 px-3 rounded hover:bg-gray-700">View Alerts</a>
            <a href="hotline.php" class="block py-2 px-3 rounded bg-gray-700">Hotline</a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <a href="../auth/logout.php" class="block py-2 px-3 rounded bg-red-600 text-center hover:bg-red-700">Logout</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage Emergency Hotlines</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-xl font-semibold text-gray-700">
                        <?php echo htmlspecialchars($row['agency'] ?: "N/A"); ?>
                    </h2>
                    <p class="text-lg text-gray-600">
                        Hotline: <?php echo htmlspecialchars($row['hotline_number'] ?: "N/A"); ?>
                    </p>
                    <?php if (!empty($row['phone_number'])): ?>
                        <p class="text-md text-gray-500">
                            Phone: <?php echo htmlspecialchars($row['phone_number']); ?>
                        </p>
                    <?php endif; ?>
                    <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Suggest Update
                    </button>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

</body>
</html>
