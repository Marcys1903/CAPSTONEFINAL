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
  <title>Localized Delivery</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">📢 Localized Delivery</h1>

    <!-- Channels for Multilingual Alerts -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-lg font-semibold mb-4">Enabled Channels</h2>
      <form class="space-y-2">
        <label class="flex items-center">
          <input type="checkbox" class="mr-2"> SMS
        </label>
        <label class="flex items-center">
          <input type="checkbox" class="mr-2"> Email
        </label>
        <label class="flex items-center">
          <input type="checkbox" class="mr-2"> PA System
        </label>
        <label class="flex items-center">
          <input type="checkbox" class="mr-2"> Mobile App
        </label>
        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg">Save Channels</button>
      </form>
    </div>

    <!-- Multilingual Alert Logs -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-lg font-semibold mb-4">Alert Logs</h2>
      <table class="min-w-full border">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border">Date</th>
            <th class="px-4 py-2 border">Alert</th>
            <th class="px-4 py-2 border">Languages Sent</th>
            <th class="px-4 py-2 border">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-4 py-2 border">2025-09-03</td>
            <td class="px-4 py-2 border">Flood Warning</td>
            <td class="px-4 py-2 border">English, Filipino</td>
            <td class="px-4 py-2 border text-green-600">Sent</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Fallback Options -->
    <div class="bg-white shadow rounded-lg p-4">
      <h2 class="text-lg font-semibold mb-4">Fallback Options</h2>
      <label class="flex items-center mb-2">
        <input type="radio" name="fallback" class="mr-2"> Default to English
      </label>
      <label class="flex items-center mb-2">
        <input type="radio" name="fallback" class="mr-2"> Default to Filipino
      </label>
      <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded-lg">Save Fallback</button>
    </div>
  </div>
</body>
</html>
