<?php
// severity_manager.php
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Severity Level Manager</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Severity Level Manager</h1>

    <!-- Define Rules -->
    <h2 class="text-xl font-semibold mb-3">Define Severity Rules</h2>
    <div class="flex gap-2 mb-6">
      <input type="text" class="w-full p-2 border rounded-lg" placeholder="Condition (e.g., Earthquake ≥ M6)">
      <select class="p-2 border rounded-lg">
        <option>Normal</option>
        <option>High</option>
        <option>Critical</option>
      </select>
      <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Rule</button>
    </div>

    <!-- AI Suggestions -->
    <h2 class="text-xl font-semibold mb-3">AI Suggested Severities</h2>
    <table class="w-full border text-sm text-gray-700 mb-6">
      <thead class="bg-gray-200">
        <tr>
          <th class="border px-3 py-2">Alert</th>
          <th class="border px-3 py-2">AI Severity</th>
          <th class="border px-3 py-2">Admin Decision</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border px-3 py-2">Earthquake M6.2 detected</td>
          <td class="border px-3 py-2 text-red-600">Critical</td>
          <td class="border px-3 py-2">
            <select class="p-1 border rounded-lg">
              <option selected>Critical</option>
              <option>High</option>
              <option>Normal</option>
            </select>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Severity Dashboard -->
    <h2 class="text-xl font-semibold mb-3">Severity Dashboard</h2>
    <div class="grid grid-cols-3 gap-4 text-center">
      <div class="p-4 bg-green-100 rounded-xl shadow">
        <p class="text-3xl font-bold">12</p>
        <p class="text-gray-700">Normal</p>
      </div>
      <div class="p-4 bg-yellow-100 rounded-xl shadow">
        <p class="text-3xl font-bold">5</p>
        <p class="text-gray-700">High</p>
      </div>
      <div class="p-4 bg-red-100 rounded-xl shadow">
        <p class="text-3xl font-bold">3</p>
        <p class="text-gray-700">Critical</p>
      </div>
    </div>
  </div>
</body>
</html>
