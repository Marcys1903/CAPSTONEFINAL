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
  <title>Translation Engine</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">🌐 Translation Engine</h1>

    <!-- Supported Languages -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-lg font-semibold mb-4">Supported Languages</h2>
      <form class="space-y-2">
        <label class="flex items-center">
          <input type="checkbox" class="mr-2"> Filipino
        </label>
        <label class="flex items-center">
          <input type="checkbox" class="mr-2"> English
        </label>
        <label class="flex items-center">
          <input type="checkbox" class="mr-2"> Cebuano
        </label>
        <label class="flex items-center">
          <input type="checkbox" class="mr-2"> Ilocano
        </label>
        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg">Save Languages</button>
      </form>
    </div>

    <!-- Translation Templates -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-lg font-semibold mb-4">Translation Templates</h2>
      <table class="min-w-full border">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border">Phrase</th>
            <th class="px-4 py-2 border">Translations</th>
            <th class="px-4 py-2 border">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-4 py-2 border">Evacuate immediately</td>
            <td class="px-4 py-2 border">Filipino: Lumikas agad</td>
            <td class="px-4 py-2 border">
              <button class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Approve/Edit Translations -->
    <div class="bg-white shadow rounded-lg p-4">
      <h2 class="text-lg font-semibold mb-4">Approve/Edit AI Translations</h2>
      <textarea class="w-full border p-2 rounded-lg mb-4" rows="4">[AI-generated translation preview...]</textarea>
      <button class="bg-green-600 text-white px-4 py-2 rounded-lg">Approve</button>
      <button class="bg-red-600 text-white px-4 py-2 rounded-lg">Reject</button>
    </div>
  </div>
</body>
</html>
