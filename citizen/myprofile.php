<?php
session_start();
include "../config/config.php"; // DB connection

// Block access if not logged in or not citizen
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Citizen | My Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 h-screen flex">

  <?php include "sidebar.php"; ?>

  <!-- Main Content -->
  <main class="flex-1 h-screen overflow-y-auto p-8">
      <!-- Template Heading -->
      <h1 class="text-3xl font-bold text-gray-800 mb-6">
          My Profile
      </h1>

      <!-- Template Container -->
      <div class="bg-white rounded-xl shadow p-6">
          <p class="text-gray-600">
              Select an option from the submenu:
          </p>
          <ul class="mt-4 list-disc list-inside text-gray-700">
              <li><strong>View Profile:</strong> See and edit your account details.</li>
              <li><strong>Audit Logs:</strong> View your recent activity inside the system.</li>
          </ul>
      </div>
  </main>

</body>
</html>
