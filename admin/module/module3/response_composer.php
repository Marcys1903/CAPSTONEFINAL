<?php
// response_composer.php
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
  <title>Response Composer</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-4xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Response Composer</h1>

    <!-- AI Quick Replies -->
    <h2 class="text-lg font-semibold mb-3">AI-Powered Quick Replies</h2>
    <div class="flex gap-3 mb-6">
      <button class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg">“Help is on the way.”</button>
      <button class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg">“Please stay calm and safe.”</button>
      <button class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg">“We have alerted the authorities.”</button>
    </div>

    <!-- Response Draft -->
    <textarea rows="4" class="w-full border rounded-lg p-3 mb-4" placeholder="Type your response here..."></textarea>

    <div class="flex justify-end gap-4">
      <button class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Edit Staff Response</button>
      <button class="px-4 py-2 bg-green-600 text-white rounded-lg">Send Response</button>
    </div>
  </div>
</body>
</html>
