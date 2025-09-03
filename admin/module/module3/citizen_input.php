<?php
// citizen_input.php
session_start();

// Only admins/co-admins can access
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin','co-admin'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Citizen Input Collector</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-6xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Citizen Input Collector</h1>

    <!-- Incoming Reports -->
    <h2 class="text-lg font-semibold mb-3">Incoming Citizen Reports</h2>
    <table class="w-full border text-sm text-gray-700 mb-6">
      <thead class="bg-gray-200">
        <tr>
          <th class="border px-3 py-2">Channel</th>
          <th class="border px-3 py-2">Message</th>
          <th class="border px-3 py-2">Citizen</th>
          <th class="border px-3 py-2">Received At</th>
          <th class="border px-3 py-2">Assign To</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border px-3 py-2">SMS</td>
          <td class="border px-3 py-2">Barangay 5 flooding</td>
          <td class="border px-3 py-2">Juan Dela Cruz</td>
          <td class="border px-3 py-2">2025-09-03 14:00</td>
          <td class="border px-3 py-2">
            <select class="p-1 border rounded-lg">
              <option>Staff A</option>
              <option>Staff B</option>
            </select>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Input Channel Control -->
    <h2 class="text-lg font-semibold mb-3">Enabled Input Channels</h2>
    <div class="flex gap-6">
      <label><input type="checkbox" checked> SMS</label>
      <label><input type="checkbox" checked> Hotline</label>
      <label><input type="checkbox"> Facebook</label>
      <label><input type="checkbox" checked> Web Forms</label>
    </div>
  </div>
</body>
</html>
