<?php
// auto_alert_dispatcher.php
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
  <title>Auto-Alert Dispatcher</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-6xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Auto-Alert Dispatcher</h1>

    <!-- Automation Rules -->
    <h2 class="text-lg font-semibold mb-3">Automation Rules</h2>
    <form class="mb-6 space-y-3">
      <input type="text" placeholder="Condition (e.g., water_level > 2m)" class="w-full border p-2 rounded-lg">
      <input type="text" placeholder="Action (e.g., Send Flood Alert)" class="w-full border p-2 rounded-lg">
      <button class="px-4 py-2 bg-green-600 text-white rounded-lg">Add Rule</button>
    </form>

    <!-- Existing Rules -->
    <table class="w-full border text-sm text-gray-700 mb-6">
      <thead class="bg-gray-200">
        <tr>
          <th class="border px-3 py-2">Condition</th>
          <th class="border px-3 py-2">Action</th>
          <th class="border px-3 py-2">Approval Required</th>
          <th class="border px-3 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border px-3 py-2">water_level > 2m</td>
          <td class="border px-3 py-2">Send Flood Alert</td>
          <td class="border px-3 py-2">Yes</td>
          <td class="border px-3 py-2 flex gap-2">
            <button class="px-2 py-1 bg-yellow-500 text-white rounded">Edit</button>
            <button class="px-2 py-1 bg-red-600 text-white rounded">Remove</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Logs -->
    <h2 class="text-lg font-semibold mb-3">Automated Alert Logs</h2>
    <table class="w-full border text-sm text-gray-700">
      <thead class="bg-gray-200">
        <tr>
          <th class="border px-3 py-2">Timestamp</th>
          <th class="border px-3 py-2">Condition Triggered</th>
          <th class="border px-3 py-2">Alert Sent</th>
          <th class="border px-3 py-2">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border px-3 py-2">2025-09-03 15:00</td>
          <td class="border px-3 py-2">water_level > 2m</td>
          <td class="border px-3 py-2">Flood Alert</td>
          <td class="border px-3 py-2 text-green-600">Sent</td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
