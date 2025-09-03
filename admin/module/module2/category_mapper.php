<?php
// category_mapper.php
session_start();

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'co-admin'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Category Mapper</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Category Mapper</h1>

    <!-- AI Classifications -->
    <h2 class="text-xl font-semibold mb-3">AI Classifications</h2>
    <table class="w-full border text-sm text-gray-700 mb-6">
      <thead class="bg-gray-200">
        <tr>
          <th class="border px-3 py-2">Alert</th>
          <th class="border px-3 py-2">AI Category</th>
          <th class="border px-3 py-2">Manual Override</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border px-3 py-2">Flood reported in Barangay 2</td>
          <td class="border px-3 py-2">Weather</td>
          <td class="border px-3 py-2">
            <select class="p-1 border rounded-lg">
              <option selected>Weather</option>
              <option>Earthquake</option>
              <option>Fire</option>
              <option>Other</option>
            </select>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Category Dictionary -->
    <h2 class="text-xl font-semibold mb-3">Category Dictionary</h2>
    <div class="flex gap-2 mb-3">
      <input type="text" class="w-full p-2 border rounded-lg" placeholder="Add new category...">
      <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Add</button>
    </div>
    <ul class="list-disc pl-6 text-gray-700">
      <li>Weather</li>
      <li>Earthquake</li>
      <li>Fire</li>
      <li>Flood</li>
    </ul>
  </div>
</body>
</html>
