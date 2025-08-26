<?php
session_start();
require_once "../config/config.php"; // DB connection

// Block access if not logged in or not citizen
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch all hotlines
$result = $conn->query("SELECT id, hotline_number, agency FROM hotlines ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Citizen | Hotlines</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex">

   <!-- Sidebar -->
  <aside class="w-64 bg-gray-900 text-white flex flex-col">
      <div class="p-6 text-2xl font-bold border-b border-gray-700">
          Citizen Panel
      </div>
      <nav class="flex-1 p-4">
          <a href="dashboard.php" class="block py-2 px-3 rounded hover:bg-gray-700">Dashboard</a>
          <a href="myalerts.php" class="block py-2 px-3 rounded hover:bg-gray-700">My Alerts</a>
          <a href="messages.php" class="block py-2 px-3 rounded hover:bg-gray-700">Messages</a>
          <a href="hotline.php" class="block py-2 px-3 rounded hover:bg-gray-700">Hotline</a>
          <a href="myprofile.php" class="block py-2 px-3 rounded hover:bg-gray-700">My Profile</a>
      </nav>
      <div class="p-4 border-t border-gray-700">
          <a href="../auth/logout.php" class="block py-2 px-3 rounded bg-red-600 text-center hover:bg-red-700">Logout</a>
      </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 h-screen overflow-y-auto p-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">Emergency Hotlines</h1>

      <div class="overflow-x-auto bg-white rounded-xl shadow p-6">
          <table class="w-full border-collapse">
              <thead class="bg-gray-800 text-white">
                  <tr>
                      <th class="px-4 py-3 text-left">#</th>
                      <th class="px-4 py-3 text-left">Hotline</th>
                      <th class="px-4 py-3 text-left">Agency</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                  <?php if ($result && $result->num_rows > 0): ?>
                      <?php while ($row = $result->fetch_assoc()): ?>
                          <tr class="hover:bg-gray-50">
                              <td class="px-4 py-3"><?php echo $row['id']; ?></td>
                              <td class="px-4 py-3 font-semibold text-gray-800"><?php echo htmlspecialchars($row['hotline_number']); ?></td>
                              <td class="px-4 py-3 text-gray-700"><?php echo htmlspecialchars($row['agency']); ?></td>
                          </tr>
                      <?php endwhile; ?>
                  <?php else: ?>
                      <tr>
                          <td colspan="3" class="px-4 py-6 text-center text-gray-500">No hotlines available.</td>
                      </tr>
                  <?php endif; ?>
              </tbody>
          </table>
      </div>
  </main>

</body>
</html>
