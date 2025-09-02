<?php
session_start();
include "../config/config.php";

// Block access if not logged in or not staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../auth/login.php");
    exit();
}

// Logged-in staff ID
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? "Staff";

// --- Queries ---
// Total citizens
$total_citizens = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='citizen'")
                      ->fetch_assoc()['count'] ?? 0;

// Total alerts (all alerts in system)
$total_alerts = $conn->query("SELECT COUNT(*) as count FROM notifications")
                     ->fetch_assoc()['count'] ?? 0;

// My sent alerts (if notifications table tracks created_by)
$my_sent_alerts = $conn->query("SELECT COUNT(*) as count 
                                FROM notifications 
                                WHERE created_by = $user_id")
                       ->fetch_assoc()['count'] ?? 0;

// Total staff messages (sent or received by this staff)
$total_messages = $conn->query("SELECT COUNT(*) as count 
                                FROM messages 
                                WHERE sender_id = $user_id OR receiver_id = $user_id")
                       ->fetch_assoc()['count'] ?? 0;

// Hotline fallback (static or from DB if available)
$hotline_number = "09263969662";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard - LGU Emergency System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col overflow-y-auto h-screen">
        <div class="p-6 text-2xl font-bold border-b border-gray-700">
            Staff Panel
        </div>
        <nav class="flex-1 p-4">
            <a href="dashboard.php" class="block py-2 px-3 rounded bg-gray-700">Dashboard</a>
            <a href="messages.php" class="block py-2 px-3 rounded hover:bg-gray-700">Messages</a>
            <a href="send_alert.php" class="block py-2 px-3 rounded hover:bg-gray-700">Send Alert</a>
            <a href="view_alerts.php" class="block py-2 px-3 rounded hover:bg-gray-700">View Alerts</a>
            <a href="hotline.php" class="block py-2 px-3 rounded hover:bg-gray-700">Hotline</a>
            <a href="audit.php" class="block py-2 px-3 rounded hover:bg-gray-700">Audi Logs</a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <a href="../auth/logout.php" class="block py-2 px-3 rounded bg-red-600 text-center hover:bg-red-700">Logout</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Welcome, <?php echo htmlspecialchars($username); ?>
        </h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-semibold text-gray-600">Total Citizens</h2>
                <p class="text-3xl font-bold text-blue-600"><?php echo $total_citizens; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-semibold text-gray-600">Total Alerts</h2>
                <p class="text-3xl font-bold text-red-600"><?php echo $total_alerts; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-semibold text-gray-600">My Sent Alerts</h2>
                <p class="text-3xl font-bold text-orange-600"><?php echo $my_sent_alerts; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-semibold text-gray-600">My Messages</h2>
                <p class="text-3xl font-bold text-green-600"><?php echo $total_messages; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-semibold text-gray-600">Hotline</h2>
                <p class="text-xl font-bold text-orange-600"><?php echo $hotline_number; ?></p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="../alerts/send_alert.php" class="bg-orange-500 text-white p-6 rounded-xl shadow hover:bg-orange-600 transition text-center font-semibold">Send New Alert</a>
            <a href="messages.php" class="bg-blue-500 text-white p-6 rounded-xl shadow hover:bg-blue-600 transition text-center font-semibold">Check Messages</a>
            <a href="attendance.php" class="bg-gray-700 text-white p-6 rounded-xl shadow hover:bg-gray-800 transition text-center font-semibold">View Attendance</a>
            <a href="tel:<?php echo $hotline_number; ?>" class="bg-red-500 text-white p-6 rounded-xl shadow hover:bg-red-600 transition text-center font-semibold">Call Hotline</a>
        </div>
    </main>

</body>
</html>
