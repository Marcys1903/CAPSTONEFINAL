<?php
// mass_notification.php
session_start();

// Only admin & co-admin allowed
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
  <title>Mass Notification Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
  <div class="max-w-4xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Mass Notification Management</h1>

    <!-- AI Templates -->
    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-2">AI-Suggested Templates</label>
      <select id="aiTemplate" class="w-full p-2 border rounded-lg">
        <option value="">-- Select a Template --</option>
        <option value="weather">Weather Alert</option>
        <option value="earthquake">Earthquake Advisory</option>
        <option value="fire">Fire Emergency</option>
      </select>
    </div>

    <!-- Delivery Channels -->
    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-2">Delivery Channels</label>
      <div class="flex flex-wrap gap-4">
        <label><input type="checkbox" class="mr-2"> SMS</label>
        <label><input type="checkbox" class="mr-2"> Email</label>
        <label><input type="checkbox" class="mr-2"> PA System</label>
        <label><input type="checkbox" class="mr-2"> IoT Devices</label>
        <label><input type="checkbox" class="mr-2"> Mobile App Push</label>
      </div>
    </div>

    <!-- Message -->
    <div class="mb-4">
      <label class="block text-gray-700 font-medium mb-2">Message</label>
      <textarea id="msgContent" rows="4" class="w-full p-3 border rounded-lg" placeholder="Type your message here..."></textarea>
    </div>

    <!-- Action Buttons -->
    <div class="flex space-x-3">
      <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Send Now</button>
      <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Schedule</button>
    </div>
  </div>
</body>
</html>
