<?php
session_start();
include "../config/config.php";

// --- Security: Block access if not logged in or not a citizen ---
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../auth/login.php");
    exit();
}

// --- Logged-in citizen details ---
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? "Citizen";

// --- Queries ---

// Total alerts in the system
$total_alerts = 0;
$res1 = $conn->query("SELECT COUNT(*) as count FROM alerts");
if ($res1 && $row = $res1->fetch_assoc()) {
    $total_alerts = $row['count'];
}

// My received alerts
$my_alerts = 0;
$res2 = $conn->query("SELECT COUNT(*) as count FROM alert_delivery WHERE user_id = $user_id");
if ($res2 && $row = $res2->fetch_assoc()) {
    $my_alerts = $row['count'];
}

// Messages between citizen and staff/admin
$total_messages = 0;
$res3 = $conn->query("SELECT COUNT(*) as count 
                      FROM citizen_messages 
                      WHERE sender_id = $user_id OR receiver_id = $user_id");
if ($res3 && $row = $res3->fetch_assoc()) {
    $total_messages = $row['count'];
}

// Hotline number (this can later be moved to a `hotline` table for dynamic updates)
$hotline_number = "09263969662";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Citizen Dashboard - LGU Emergency System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body class="bg-gray-100 min-h-screen flex">

    <?php include "sidebar.php"; ?>


    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Welcome, <?php echo htmlspecialchars($username); ?>
        </h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-semibold text-gray-600">Total Alerts</h2>
                <p class="text-3xl font-bold text-red-600"><?php echo $total_alerts; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-semibold text-gray-600">My Alerts</h2>
                <p class="text-3xl font-bold text-blue-600"><?php echo $my_alerts; ?></p>
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
            <a href="alerts.php" class="bg-blue-500 text-white p-6 rounded-xl shadow hover:bg-blue-600 transition text-center font-semibold">View My Alerts</a>
            <a href="messages.php" class="bg-green-500 text-white p-6 rounded-xl shadow hover:bg-green-600 transition text-center font-semibold">Check Messages</a>
            <a href="tel:<?php echo $hotline_number; ?>" class="bg-orange-500 text-white p-6 rounded-xl shadow hover:bg-orange-600 transition text-center font-semibold">Call Hotline</a>
        </div>
    </main>

</body>
</html>
