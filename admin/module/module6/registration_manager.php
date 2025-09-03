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
  <title>Registration Manager</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">📝 Registration Manager</h1>

    <!-- Registered Citizens Table -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-lg font-semibold mb-4">Registered Citizens</h2>
      <table class="min-w-full border">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border">Name</th>
            <th class="px-4 py-2 border">Contact</th>
            <th class="px-4 py-2 border">Status</th>
            <th class="px-4 py-2 border">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-4 py-2 border">Juan Dela Cruz</td>
            <td class="px-4 py-2 border">0917-123-4567</td>
            <td class="px-4 py-2 border text-green-600">Approved</td>
            <td class="px-4 py-2 border space-x-2">
              <button class="bg-green-600 text-white px-3 py-1 rounded">Approve</button>
              <button class="bg-yellow-500 text-white px-3 py-1 rounded">Block</button>
              <button class="bg-red-600 text-white px-3 py-1 rounded">Remove</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Import/Export -->
    <div class="bg-white shadow rounded-lg p-4">
      <h2 class="text-lg font-semibold mb-4">Import / Export Records</h2>
      <div class="flex space-x-4">
        <input type="file" class="border rounded p-2">
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Import</button>
        <button class="bg-green-600 text-white px-4 py-2 rounded-lg">Export</button>
      </div>
    </div>
  </div>
</body>
</html>
