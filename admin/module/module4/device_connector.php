<?php
// device_connector.php
session_start();

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin','co-admin'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Device Connector</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-6xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Device Connector</h1>

    <!-- Add Device -->
    <h2 class="text-lg font-semibold mb-3">Add New Device/Sensor</h2>
    <form class="mb-6 space-y-3">
      <input type="text" placeholder="Device Name" class="w-full border p-2 rounded-lg">
      <input type="text" placeholder="Device Type (Flood Gauge, Fire Alarm...)" class="w-full border p-2 rounded-lg">
      <input type="text" placeholder="API Endpoint / IP Address" class="w-full border p-2 rounded-lg">
      <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">Add Device</button>
    </form>

    <!-- Device List -->
    <h2 class="text-lg font-semibold mb-3">Connected Devices</h2>
    <table class="w-full border text-sm text-gray-700 mb-6">
      <thead class="bg-gray-200">
        <tr>
          <th class="border px-3 py-2">Device Name</th>
          <th class="border px-3 py-2">Type</th>
          <th class="border px-3 py-2">Status</th>
          <th class="border px-3 py-2">Last Checked</th>
          <th class="border px-3 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border px-3 py-2">Flood Gauge 01</td>
          <td class="border px-3 py-2">Water Sensor</td>
          <td class="border px-3 py-2 text-green-600">Online</td>
          <td class="border px-3 py-2">2025-09-03 14:30</td>
          <td class="border px-3 py-2 flex gap-2">
            <button class="px-2 py-1 bg-yellow-500 text-white rounded">Test</button>
            <button class="px-2 py-1 bg-red-600 text-white rounded">Remove</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- API Config -->
    <h2 class="text-lg font-semibold mb-3">Agency API Connections</h2>
    <div class="space-y-3">
      <label class="block">PAGASA API Key <input type="text" class="w-full border p-2 rounded-lg mt-1"></label>
      <label class="block">PHIVOLCS API Key <input type="text" class="w-full border p-2 rounded-lg mt-1"></label>
      <label class="block">DOH API Key <input type="text" class="w-full border p-2 rounded-lg mt-1"></label>
    </div>
  </div>
</body>
</html>
