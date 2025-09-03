<?php
// confirmation_tracker.php
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
  <title>Confirmation Tracker</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Confirmation Tracker</h1>

    <!-- Real-time Delivery Status Table -->
    <table class="w-full border text-sm text-gray-700">
      <thead class="bg-gray-200">
        <tr>
          <th class="border px-3 py-2">Alert ID</th>
          <th class="border px-3 py-2">Message</th>
          <th class="border px-3 py-2">Channel</th>
          <th class="border px-3 py-2">Status</th>
          <th class="border px-3 py-2">Timestamp</th>
        </tr>
      </thead>
      <tbody>
        <!-- Example Rows -->
        <tr>
          <td class="border px-3 py-2">ALRT-001</td>
          <td class="border px-3 py-2">Earthquake Drill Notification</td>
          <td class="border px-3 py-2">SMS</td>
          <td class="border px-3 py-2 text-green-600">Delivered</td>
          <td class="border px-3 py-2">2025-09-03 12:30 PM</td>
        </tr>
        <tr>
          <td class="border px-3 py-2">ALRT-002</td>
          <td class="border px-3 py-2">Flood Warning</td>
          <td class="border px-3 py-2">Email</td>
          <td class="border px-3 py-2 text-yellow-600">Pending</td>
          <td class="border px-3 py-2">2025-09-03 12:35 PM</td>
        </tr>
      </tbody>
    </table>

    <!-- Export Button -->
    <div class="mt-4 flex justify-end">
      <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Export Report</button>
    </div>
  </div>
</body>
</html>
