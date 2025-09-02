<?php
session_start();
include "../config/config.php"; // DB connection

// ✅ Block access if not logged in or not citizen
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../auth/login.php");
    exit();
}

// Logged-in citizen info
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? "Citizen";

// ✅ Fetch alerts from staff-created alerts + admin/staff mass notifications
$query = "
    SELECT a.alert_id AS id, a.title, a.message, a.severity, a.priority_level, a.created_at,
           u.username AS sender, 'staff_alert' AS source
    FROM alerts a
    JOIN users u ON a.created_by = u.user_id

    UNION ALL

    SELECT n.id AS id, n.type AS title, n.message, 
           'critical' AS severity, NULL AS priority_level, n.created_at,
           u.username AS sender, 'mass_alert' AS source
    FROM notifications n
    JOIN users u ON n.created_by = u.user_id
    WHERE u.role IN ('admin','staff')

    ORDER BY created_at DESC
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Citizen | My Alerts</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body class="bg-gray-100 h-screen flex">

  <?php include "sidebar.php"; ?>


  <!-- Main Content -->
  <main class="flex-1 h-screen overflow-y-auto p-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">
          Alerts from Staff & Admins
      </h1>

      <div class="overflow-x-auto bg-white rounded-xl shadow">
          <table class="w-full border-collapse">
              <thead class="bg-gray-800 text-white">
                  <tr>
                      <th class="px-4 py-3 text-left">#</th>
                      <th class="px-4 py-3 text-left">Title</th>
                      <th class="px-4 py-3 text-left">Message</th>
                      <th class="px-4 py-3 text-left">Severity</th>
                      <th class="px-4 py-3 text-left">Sender</th>
                      <th class="px-4 py-3 text-left">Date & Time</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                  <?php if ($result && $result->num_rows > 0): ?>
                      <?php while ($row = $result->fetch_assoc()): ?>
                          <?php 
                              // Determine severity
                              $severity = strtolower(trim($row['severity'] ?? ''));
                              if (empty($severity)) {
                                  $priority = (int)($row['priority_level'] ?? 0);
                                  if ($priority >= 8) {
                                      $severity = "critical";
                                  } elseif ($priority >= 5) {
                                      $severity = "high";
                                  } elseif ($priority >= 3) {
                                      $severity = "medium";
                                  } else {
                                      $severity = "low";
                                  }
                              }

                              // Badge colors
                              switch ($severity) {
                                  case 'critical':
                                      $badgeClass = "bg-red-600 text-white";
                                      break;
                                  case 'high':
                                      $badgeClass = "bg-orange-500 text-white";
                                      break;
                                  case 'medium':
                                      $badgeClass = "bg-yellow-400 text-black";
                                      break;
                                  case 'low':
                                      $badgeClass = "bg-green-500 text-white";
                                      break;
                                  default:
                                      $badgeClass = "bg-gray-500 text-white";
                              }
                          ?>
                          <tr class="hover:bg-gray-50">
                              <td class="px-4 py-3"><?php echo $row['id']; ?></td>
                              <td class="px-4 py-3 font-semibold text-gray-800"><?php echo htmlspecialchars($row['title']); ?></td>
                              <td class="px-4 py-3"><?php echo htmlspecialchars($row['message']); ?></td>
                              <td class="px-4 py-3">
                                  <span class="px-2 py-1 text-sm rounded <?php echo $badgeClass; ?>">
                                      <?php echo ucfirst($severity); ?>
                                  </span>
                              </td>
                              <td class="px-4 py-3 text-gray-600"><?php echo htmlspecialchars($row['sender']); ?></td>
                              <td class="px-4 py-3 text-gray-600"><?php echo $row['created_at']; ?></td>
                          </tr>
                      <?php endwhile; ?>
                  <?php else: ?>
                      <tr>
                          <td colspan="6" class="px-4 py-6 text-center text-gray-500">No alerts available.</td>
                      </tr>
                  <?php endif; ?>
              </tbody>
          </table>
      </div>
  </main>

</body>
</html>
