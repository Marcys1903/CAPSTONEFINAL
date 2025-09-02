<?php
session_start();
include "../config/config.php";

// ✅ Block access if not logged in or not admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// ===== INIT DEFAULT VALUES =====
$total_users = $total_citizens = $total_staff = $total_admins = 0;
$alerts_sent = 0;
$total_messages = $citizen_messages = $staff_messages = $admin_messages = 0;
$pagasa_news = [];

// ===== FETCH DASHBOARD STATS =====
// Users
$result = $conn->query("SELECT COUNT(*) as count FROM users");
if ($result && $row = $result->fetch_assoc()) $total_users = $row['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='citizen'");
if ($result && $row = $result->fetch_assoc()) $total_citizens = $row['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='staff'");
if ($result && $row = $result->fetch_assoc()) $total_staff = $row['count'];

$result = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='admin'");
if ($result && $row = $result->fetch_assoc()) $total_admins = $row['count'];

// Alerts Sent
if ($conn->query("SHOW TABLES LIKE 'notifications'")->num_rows > 0) {
    $result = $conn->query("SELECT COUNT(*) as count FROM notifications");
    if ($result && $row = $result->fetch_assoc()) $alerts_sent = $row['count'];
}

// Messages
if ($conn->query("SHOW TABLES LIKE 'messages'")->num_rows > 0) {
    $result = $conn->query("SELECT COUNT(*) as count FROM messages");
    if ($result && $row = $result->fetch_assoc()) $total_messages = $row['count'];

    $result = $conn->query("SELECT COUNT(*) as count FROM messages m JOIN users u ON m.sender_id=u.user_id WHERE u.role='citizen'");
    if ($result && $row = $result->fetch_assoc()) $citizen_messages = $row['count'];

    $result = $conn->query("SELECT COUNT(*) as count FROM messages m JOIN users u ON m.sender_id=u.user_id WHERE u.role='staff'");
    if ($result && $row = $result->fetch_assoc()) $staff_messages = $row['count'];

    $result = $conn->query("SELECT COUNT(*) as count FROM messages m JOIN users u ON m.sender_id=u.user_id WHERE u.role='admin'");
    if ($result && $row = $result->fetch_assoc()) $admin_messages = $row['count'];
}

// ===== FETCH PAGASA NEWS (RSS Feed) =====
$pagasa_feed_url = "https://www.pagasa.dost.gov.ph/rss/tropical-cyclone.xml";
$rss = @simplexml_load_file($pagasa_feed_url);
if ($rss && isset($rss->channel->item)) {
    foreach ($rss->channel->item as $item) {
        $pagasa_news[] = [
            'title' => (string)$item->title,
            'desc'  => strip_tags((string)$item->description),
            'link'  => (string)$item->link,
            'date'  => (string)$item->pubDate
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - LGU Emergency System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-gray-900 text-white flex flex-col overflow-y-auto h-screen">
      <div class="p-6 text-2xl font-bold border-b border-gray-700">
          Admin Panel
      </div>
      <nav class="flex-1 p-4 space-y-2">
          <a href="dashboard.php" class="block py-2 px-3 rounded bg-gray-800"> Dashboard</a>
          <a href="messages.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Messages</a>
          <a href="massnotify.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Notification</a>
          <a href="hotline.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Hotline</a>
          <a href="audit.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Audit Logs</a>
          <a href="system_settings.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Settings</a>
          
      </nav>
      <div class="p-4 border-t border-gray-700">
          <a href="../auth/logout.php" class="block py-2 px-3 rounded bg-red-600 text-center hover:bg-red-700">Logout</a>
      </div>
  </aside>

<!-- Main Content -->
<main class="flex-1 p-8 overflow-y-auto h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Admin"; ?> 👋
    </h1>

    <!-- User Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h2 class="text-lg font-semibold text-gray-600">Total Users</h2>
            <p class="text-3xl font-bold text-orange-600"><?php echo $total_users; ?></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h2 class="text-lg font-semibold text-gray-600">Citizens</h2>
            <p class="text-3xl font-bold text-blue-600"><?php echo $total_citizens; ?></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h2 class="text-lg font-semibold text-gray-600">Staff</h2>
            <p class="text-3xl font-bold text-green-600"><?php echo $total_staff; ?></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <h2 class="text-lg font-semibold text-gray-600">Admins</h2>
            <p class="text-3xl font-bold text-purple-600"><?php echo $total_admins; ?></p>
        </div>
    </div>

    <!-- Alerts Sent -->
    <div class="bg-white p-6 rounded-xl shadow mb-8">
        <h2 class="text-xl font-semibold mb-2">Alerts Sent</h2>
        <p class="text-2xl font-bold text-red-600"><?php echo $alerts_sent; ?></p>
    </div>

    <!-- Messages Overview -->
    <div class="bg-white p-6 rounded-xl shadow mb-8">
        <h2 class="text-xl font-semibold mb-4">Messages Overview</h2>
        <p class="text-2xl font-bold text-gray-800 mb-4">Total Messages: <?php echo $total_messages; ?></p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-100 p-4 rounded-lg shadow text-center">
                <h3 class="text-md font-semibold text-gray-600">Citizen Messages</h3>
                <p class="text-xl font-bold text-blue-600"><?php echo $citizen_messages; ?></p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg shadow text-center">
                <h3 class="text-md font-semibold text-gray-600">Staff Messages</h3>
                <p class="text-xl font-bold text-green-600"><?php echo $staff_messages; ?></p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg shadow text-center">
                <h3 class="text-md font-semibold text-gray-600">Admin Messages</h3>
                <p class="text-xl font-bold text-purple-600"><?php echo $admin_messages; ?></p>
            </div>
        </div>
        <div class="mt-4 text-right">
            <a href="messages.php" class="text-sm text-blue-600 hover:underline">View All Messages →</a>
        </div>
    </div>

    <!-- PAGASA Latest News -->
    <div class="bg-white p-6 rounded-xl shadow mb-8">
        <h2 class="text-xl font-semibold mb-4 text-blue-700">🌧 PAGASA Latest Advisories</h2>
        <?php if (!empty($pagasa_news)): ?>
            <ul class="space-y-3">
                <?php foreach ($pagasa_news as $news): ?>
                    <li class="border-b pb-2">
                        <a href="<?php echo htmlspecialchars($news['link']); ?>" target="_blank" class="text-lg font-semibold text-blue-600 hover:underline">
                            <?php echo htmlspecialchars($news['title']); ?>
                        </a>
                        <p class="text-sm text-gray-700 mt-1"><?php echo htmlspecialchars($news['desc']); ?></p>
                        <p class="text-xs text-gray-500 mt-1">Published: <?php echo htmlspecialchars($news['date']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-gray-500">No advisories available at the moment.</p>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="notifications.php" class="bg-orange-500 text-white p-6 rounded-xl shadow hover:bg-orange-600 transition text-center font-semibold">Send New Alert</a>
        <a href="users.php" class="bg-blue-500 text-white p-6 rounded-xl shadow hover:bg-blue-600 transition text-center font-semibold">Manage Users</a>
        <a href="audit.php" class="bg-gray-700 text-white p-6 rounded-xl shadow hover:bg-gray-800 transition text-center font-semibold">View Audit Logs</a>
    </div>
</main>
</body>
</html>
