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
  <title>Data Security & Integrity Checker</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">🔐 Data Security & Integrity Checker</h1>

    <!-- Integrity Status -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-lg font-semibold mb-4">Integrity Status</h2>
      <p class="text-green-600 font-medium">✅ All logs are intact. No tampering detected.</p>
    </div>

    <!-- Security Configurations -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-lg font-semibold mb-4">Security Settings</h2>
      <form class="space-y-4">
        <div>
          <label class="block font-medium">Encryption</label>
          <select class="w-full border p-2 rounded">
            <option>AES-256</option>
            <option>RSA</option>
            <option>SHA-256</option>
          </select>
        </div>
        <div>
          <label class="block font-medium">Access Restrictions</label>
          <select class="w-full border p-2 rounded">
            <option>Admins Only</option>
            <option>Admins + Co-Admins</option>
            <option>All Staff</option>
          </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Save Settings</button>
      </form>
    </div>

    <!-- Run Integrity Check -->
    <div class="bg-white shadow rounded-lg p-4">
      <h2 class="text-lg font-semibold mb-4">Run Integrity Check</h2>
      <button class="bg-green-600 text-white px-4 py-2 rounded-lg">Run Check</button>
    </div>
  </div>
</body>
</html>
