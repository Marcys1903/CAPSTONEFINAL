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
  <title>User Tracking Manager</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">👀 User Tracking Manager</h1>

    <!-- User Activity Table -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-lg font-semibold mb-4">User Activities</h2>
      <table class="min-w-full border">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border">Date</th>
            <th class="px-4 py-2 border">User</th>
            <th class="px-4 py-2 border">Role</th>
            <th class="px-4 py-2 border">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-4 py-2 border">2025-09-03 09:15</td>
            <td class="px-4 py-2 border">Staff01</td>
            <td class="px-4 py-2 border">Staff</td>
            <td class="px-4 py-2 border">Reviewed citizen report</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Suspicious Behavior Alerts -->
    <div class="bg-white shadow rounded-lg p-4">
      <h2 class="text-lg font-semibold mb-4">Suspicious Behavior</h2>
      <ul class="list-disc ml-6">
        <li class="text-red-600">5 failed login attempts - User: staff02</li>
      </ul>
    </div>
  </div>
</body>
</html>
