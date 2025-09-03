<?php
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
  <title>Activity Logger</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">📜 Activity Logger</h1>

    <!-- Logs Table -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-lg font-semibold mb-4">System Logs</h2>
      <table class="min-w-full border">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border">Date</th>
            <th class="px-4 py-2 border">Event</th>
            <th class="px-4 py-2 border">User</th>
            <th class="px-4 py-2 border">Details</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-4 py-2 border">2025-09-03 10:22</td>
            <td class="px-4 py-2 border">Alert Sent</td>
            <td class="px-4 py-2 border">Admin</td>
            <td class="px-4 py-2 border">Flood warning broadcasted</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Export & Retention -->
    <div class="bg-white shadow rounded-lg p-4">
      <h2 class="text-lg font-semibold mb-4">Log Management</h2>
      <div class="flex space-x-4 mb-4">
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Export CSV</button>
        <button class="bg-green-600 text-white px-4 py-2 rounded-lg">Export PDF</button>
      </div>
      <label class="block font-medium mb-2">Log Retention Policy</label>
      <select class="border rounded p-2">
        <option>1 Month</option>
        <option>6 Months</option>
        <option>1 Year</option>
        <option>3 Years</option>
      </select>
      <button class="ml-4 bg-yellow-600 text-white px-4 py-2 rounded-lg">Save Policy</button>
    </div>
  </div>
</body>
</html>
