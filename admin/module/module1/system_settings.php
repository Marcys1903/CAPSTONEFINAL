<?php
// system_settings.php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Settings</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-4xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">System Settings</h1>

    <!-- Integrations -->
    <div class="mb-6">
      <h2 class="text-xl font-semibold mb-2">Integrations</h2>
      <label class="block mb-2"><input type="checkbox" class="mr-2"> PAGASA Feed</label>
      <label class="block mb-2"><input type="checkbox" class="mr-2"> PHIVOLCS Feed</label>
      <label class="block mb-2"><input type="checkbox" class="mr-2"> IoT Sensor Integration</label>
    </div>

    <!-- Location Zones -->
    <div class="mb-6">
      <h2 class="text-xl font-semibold mb-2">Location-Based Alert Zones</h2>
      <input type="text" class="w-full p-2 border rounded-lg mb-2" placeholder="Enter new zone...">
      <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Zone</button>
    </div>

    <!-- Multilingual -->
    <div>
      <h2 class="text-xl font-semibold mb-2">Multilingual Support</h2>
      <select class="w-full p-2 border rounded-lg">
        <option>English</option>
        <option>Filipino</option>
        <option>Cebuano</option>
        <option>Ilocano</option>
      </select>
    </div>
  </div>
</body>
</html>
