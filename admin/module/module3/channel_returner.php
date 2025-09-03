<?php
// channel_returner.php
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
  <title>Channel Returner</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Channel Returner</h1>

    <!-- Channel Config -->
    <h2 class="text-lg font-semibold mb-3">Configure Response Routing</h2>
    <div class="space-y-4 mb-6">
      <label class="block">SMS Gateway API Key <input type="text" class="w-full border rounded-lg p-2 mt-1"></label>
      <label class="block">Facebook Messenger API Token <input type="text" class="w-full border rounded-lg p-2 mt-1"></label>
      <label class="block">Other Channels <input type="text" class="w-full border rounded-lg p-2 mt-1"></label>
    </div>

    <!-- Delivery Logs -->
    <h2 class="text-lg font-semibold mb-3">Message Delivery Logs</h2>
    <table class="w-full border text-sm text-gray-700">
      <thead class="bg-gray-200">
        <tr>
          <th class="border px-3 py-2">Channel</th>
          <th class="border px-3 py-2">Message</th>
          <th class="border px-3 py-2">Status</th>
          <th class="border px-3 py-2">Timestamp</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border px-3 py-2">SMS</td>
          <td class="border px-3 py-2">Flood alert sent to Barangay 5</td>
          <td class="border px-3 py-2 text-green-600">Delivered</td>
          <td class="border px-3 py-2">2025-09-03 15:20</td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
