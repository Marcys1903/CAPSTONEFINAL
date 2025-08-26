<?php
session_start();
include "../config/config.php";

// Block access if not admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Example: fetch system settings from database (you can expand this later)
$system_name = "LGU Emergency Response System";
$timezone = "Asia/Manila";
$date_format = "Y-m-d H:i:s";

// Handle form submissions here (pseudo-code only for now)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Example: Update settings in database
    // $conn->query("UPDATE settings SET ...");
    $success = "Settings saved successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Settings</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function openTab(tabId) {
      document.querySelectorAll(".tab-content").forEach(el => el.classList.add("hidden"));
      document.getElementById(tabId).classList.remove("hidden");
    }
  </script>
</head>
<body class="bg-gray-100 min-h-screen flex">

        <!-- Sidebar -->
  <aside class="w-64 bg-gray-900 text-white flex flex-col overflow-y-auto h-screen">
      <div class="p-6 text-2xl font-bold border-b border-gray-700">
          Admin Panel
      </div>
      <nav class="flex-1 p-4 space-y-2">
          <a href="dashboard.php" class="block py-2 px-3 rounded bg-gray-800 hover:bg-gray-700"> Dashboard</a>
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
  <main class="flex-1 p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">System Settings</h1>

    <?php if (!empty($success)): ?>
      <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
        <?php echo $success; ?>
      </div>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="flex space-x-4 mb-6">
      <button onclick="openTab('account')" class="px-4 py-2 bg-gray-200 rounded">Account</button>
      <button onclick="openTab('system')" class="px-4 py-2 bg-gray-200 rounded">System</button>
      <button onclick="openTab('hotline')" class="px-4 py-2 bg-gray-200 rounded">Hotlines</button>
      <button onclick="openTab('notification')" class="px-4 py-2 bg-gray-200 rounded">Notifications</button>
      <button onclick="openTab('security')" class="px-4 py-2 bg-gray-200 rounded">Security</button>
      <button onclick="openTab('backup')" class="px-4 py-2 bg-gray-200 rounded">Backup</button>
    </div>

    <!-- Account Settings -->
    <div id="account" class="tab-content bg-white p-6 rounded shadow">
      <h2 class="text-xl font-bold mb-4">Account Settings</h2>
      <form method="POST">
        <label class="block mb-2">Change Email</label>
        <input type="email" name="email" class="w-full border rounded p-2 mb-4" placeholder="admin@example.com">
        <label class="block mb-2">Change Password</label>
        <input type="password" name="password" class="w-full border rounded p-2 mb-4" placeholder="New Password">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
      </form>
    </div>

    <!-- System Settings -->
    <div id="system" class="tab-content hidden bg-white p-6 rounded shadow">
      <h2 class="text-xl font-bold mb-4">System Settings</h2>
      <form method="POST">
        <label class="block mb-2">System Name</label>
        <input type="text" name="system_name" value="<?php echo $system_name; ?>" class="w-full border rounded p-2 mb-4">
        <label class="block mb-2">Timezone</label>
        <input type="text" name="timezone" value="<?php echo $timezone; ?>" class="w-full border rounded p-2 mb-4">
        <label class="block mb-2">Date Format</label>
        <input type="text" name="date_format" value="<?php echo $date_format; ?>" class="w-full border rounded p-2 mb-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
      </form>
    </div>

    <!-- Hotline Settings -->
    <div id="hotline" class="tab-content hidden bg-white p-6 rounded shadow">
      <h2 class="text-xl font-bold mb-4">Hotline & Contact Settings</h2>
      <form method="POST">
        <label class="block mb-2">Emergency Hotline Number</label>
        <input type="text" name="hotline" class="w-full border rounded p-2 mb-4" placeholder="e.g. 911">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
      </form>
    </div>

    <!-- Notification Settings -->
    <div id="notification" class="tab-content hidden bg-white p-6 rounded shadow">
      <h2 class="text-xl font-bold mb-4">Notification Settings</h2>
      <form method="POST">
        <label class="block mb-2">SMS API Key</label>
        <input type="text" name="apikey" class="w-full border rounded p-2 mb-4">
        <label class="block mb-2">Default Sender Name</label>
        <input type="text" name="sender" class="w-full border rounded p-2 mb-4" placeholder="LGU-ALERT">
        <label class="block mb-2">Notification Templates</label>
        <textarea name="templates" class="w-full border rounded p-2 mb-4" rows="4" placeholder="Flood Alert, Fire Alert, etc."></textarea>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
      </form>
    </div>

    <!-- Security Settings -->
    <div id="security" class="tab-content hidden bg-white p-6 rounded shadow">
      <h2 class="text-xl font-bold mb-4">Security Settings</h2>
      <form method="POST">
        <label class="block mb-2">Enable 2FA</label>
        <input type="checkbox" name="2fa" class="mr-2"> Two-Factor Authentication
        <br><br>
        <label class="block mb-2">Session Timeout (minutes)</label>
        <input type="number" name="session_timeout" class="w-full border rounded p-2 mb-4" value="30">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
      </form>
    </div>

    <!-- Backup Settings -->
    <div id="backup" class="tab-content hidden bg-white p-6 rounded shadow">
      <h2 class="text-xl font-bold mb-4">Backup & Data Settings</h2>
      <button class="bg-green-600 text-white px-4 py-2 rounded">Create Backup</button>
      <button class="bg-yellow-600 text-white px-4 py-2 rounded ml-2">Restore Backup</button>
    </div>

    

  </main>
</body>
</html>
