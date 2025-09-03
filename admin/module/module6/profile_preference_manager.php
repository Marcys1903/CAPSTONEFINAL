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
  <title>Profile & Preferences Manager</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">👤 Profile & Preferences Manager</h1>

    <!-- Citizen Profile Editor -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-lg font-semibold mb-4">Citizen Profile</h2>
      <form class="space-y-4">
        <input type="text" placeholder="Full Name" class="w-full border rounded p-2">
        <input type="text" placeholder="Contact Number" class="w-full border rounded p-2">
        <input type="email" placeholder="Email" class="w-full border rounded p-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Update Profile</button>
      </form>
    </div>

    <!-- Aggregate Statistics -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-lg font-semibold mb-4">Aggregate Statistics</h2>
      <div class="grid grid-cols-3 gap-4">
        <div class="bg-gray-100 p-4 rounded-lg shadow text-center">
          <p class="text-xl font-bold">1,200</p>
          <p class="text-sm">Subscribed to Flood Alerts</p>
        </div>
        <div class="bg-gray-100 p-4 rounded-lg shadow text-center">
          <p class="text-xl font-bold">900</p>
          <p class="text-sm">Subscribed to Earthquake Alerts</p>
        </div>
        <div class="bg-gray-100 p-4 rounded-lg shadow text-center">
          <p class="text-xl font-bold">650</p>
          <p class="text-sm">Subscribed to Health Advisories</p>
        </div>
      </div>
    </div>

    <!-- System-wide Preferences -->
    <div class="bg-white shadow rounded-lg p-4">
      <h2 class="text-lg font-semibold mb-4">System-wide Preferences</h2>
      <form class="space-y-4">
        <div>
          <label class="block font-medium">Default Language</label>
          <select class="w-full border p-2 rounded">
            <option>Filipino</option>
            <option>English</option>
            <option>Cebuano</option>
            <option>Ilocano</option>
          </select>
        </div>
        <div>
          <label class="block font-medium">Default Channel</label>
          <select class="w-full border p-2 rounded">
            <option>SMS</option>
            <option>Email</option>
            <option>Mobile App</option>
          </select>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Save Preferences</button>
      </form>
    </div>
  </div>
</body>
</html>
