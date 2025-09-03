<?php
// message_dashboard.php
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
  <title>Message Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-6xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Message Dashboard</h1>

    <!-- Filters -->
    <div class="flex gap-4 mb-6">
      <select class="p-2 border rounded-lg">
        <option>All Channels</option><option>SMS</option><option>Facebook</option><option>Hotline</option>
      </select>
      <select class="p-2 border rounded-lg">
        <option>All Locations</option><option>Barangay 1</option><option>Barangay 2</option>
      </select>
      <select class="p-2 border rounded-lg">
        <option>All Severities</option><option>Normal</option><option>High</option><option>Critical</option>
      </select>
      <select class="p-2 border rounded-lg">
        <option>All Staff</option><option>Staff A</option><option>Staff B</option>
      </select>
    </div>

    <!-- Threads -->
    <div class="space-y-4">
      <div class="p-4 border rounded-lg bg-gray-50">
        <p class="font-semibold">Citizen: Maria Santos (SMS)</p>
        <p class="text-gray-700">“We are experiencing aftershocks in Barangay 4.”</p>
        <p class="text-sm text-gray-500">Handled by: Staff A | Severity: High</p>
      </div>
      <div class="p-4 border rounded-lg bg-gray-50">
        <p class="font-semibold">Citizen: Pedro Cruz (FB)</p>
        <p class="text-gray-700">“Fire near market area, heavy smoke visible.”</p>
        <p class="text-sm text-gray-500">Handled by: Staff B | Severity: Critical</p>
      </div>
    </div>
  </div>
</body>
</html>
