<?php
// source_identifier.php
session_start();

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'co-admin'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Source Identifier</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Source Identifier</h1>

    <!-- Incoming Alerts Table -->
    <h2 class="text-xl font-semibold mb-3">Incoming Alerts</h2>
    <table class="w-full border text-sm text-gray-700 mb-6">
      <thead class="bg-gray-200">
        <tr>
          <th class="border px-3 py-2">Source</th>
          <th class="border px-3 py-2">Message</th>
          <th class="border px-3 py-2">Received At</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border px-3 py-2">Hotline</td>
          <td class="border px-3 py-2">Report: Flash flood in Barangay 3</td>
          <td class="border px-3 py-2">2025-09-03 13:15</td>
        </tr>
        <tr>
          <td class="border px-3 py-2">Facebook Page</td>
          <td class="border px-3 py-2">Citizen report: Earthquake felt near LGU-4 Hall</td>
          <td class="border px-3 py-2">2025-09-03 13:20</td>
        </tr>
      </tbody>
    </table>

    <!-- Configure Sources -->
    <h2 class="text-xl font-semibold mb-3">Manage Sources</h2>
    <div class="flex gap-2 mb-3">
      <input type="text" class="w-full p-2 border rounded-lg" placeholder="Enter new source (e.g., IoT feed URL)">
      <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Source</button>
    </div>
    <ul class="list-disc pl-6 text-gray-700">
      <li>Hotline</li>
      <li>Facebook Page</li>
      <li>IoT Sensors</li>
    </ul>
  </div>
</body>
</html>
