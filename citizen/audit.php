<?php
session_start();
include "../config/config.php";

// ✅ Only citizens can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id']; 
$audit_logs = [];

// ===== FETCH CITIZEN AUDIT LOGS =====
$sql = "
    -- 1. Messages Sent by Citizen
    SELECT 
        m.message_id AS log_id,
        u.username,
        u.full_name,
        u.role AS actor_role,
        r.username AS target,
        r.role AS target_role,
        m.message AS details,
        m.sent_at AS timestamp,
        'Message Sent' AS log_type,
        NULL AS ip_address
    FROM messages m
    JOIN users u ON m.sender_id = u.user_id
    JOIN users r ON m.receiver_id = r.user_id
    WHERE u.user_id = $user_id

    UNION ALL

    -- 2. Citizen System Activities (Login, Logout, etc.)
    SELECT 
        a.audit_id AS log_id,
        u.username,
        u.full_name,
        u.role AS actor_role,
        NULL AS target,
        NULL AS target_role,
        a.activity AS details,
        a.timestamp,
        'System Activity' AS log_type,
        a.ip_address
    FROM audit_logs a
    JOIN users u ON a.user_id = u.user_id
    WHERE u.user_id = $user_id

    UNION ALL

    -- 3. Alerts Received by Citizen
SELECT 
    ca.citizen_alert_id AS log_id,
    u.username,
    u.full_name,
    u.role AS actor_role,
    NULL AS target,
    NULL AS target_role,
    CONCAT('Received Alert: ', al.title, ' - ', al.message) AS details,
    ca.received_at AS timestamp,
    'Alert Received' AS log_type,
    NULL AS ip_address
FROM citizen_alerts ca
JOIN alerts al ON ca.alert_id = al.alert_id
JOIN users u ON ca.citizen_id = u.user_id
WHERE u.user_id = $user_id
";

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $audit_logs[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Audit Logs - LGU Emergency System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        
        function showDetails(logId) {
            document.getElementById("auditModal-" + logId).classList.remove("hidden");
        }
        function closeDetails(logId) {
            document.getElementById("auditModal-" + logId).classList.add("hidden");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body class="bg-gray-100 h-screen flex">

  <?php include "sidebar.php"; ?>


  <!-- Main Content -->
  <main class="flex-1 h-screen overflow-y-auto p-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-6"> My Audit Logs</h1>

      <div class="bg-white p-6 rounded-xl shadow">
          <table class="w-full border-collapse">
              <thead>
                  <tr class="bg-gray-200 text-gray-700 text-left">
                      <th class="p-3">#</th>
                      <th class="p-3">Action Details</th>
                      <th class="p-3">Type</th>
                      <th class="p-3">IP Address</th>
                      <th class="p-3">Timestamp</th>
                      <th class="p-3">Action</th>
                  </tr>
              </thead>
              <tbody>
                  <?php if (!empty($audit_logs)): ?>
                      <?php foreach ($audit_logs as $index => $log): ?>
                          <tr class="border-b hover:bg-gray-50">
                              <td class="p-3 text-sm text-gray-500"><?php echo $index + 1; ?></td>
                              <td class="p-3"><?php echo htmlspecialchars($log['details']); ?></td>
                              <td class="p-3 text-sm font-medium
                                  <?php
                                      if ($log['log_type'] === 'Alert Received') echo 'text-red-600';
                                      elseif ($log['log_type'] === 'Message Sent') echo 'text-blue-600';
                                      elseif ($log['log_type'] === 'System Activity') echo 'text-green-600';
                                      else echo 'text-gray-700';
                                  ?>">
                                  <?php echo $log['log_type']; ?>
                              </td>
                              <td class="p-3 text-sm text-gray-500"><?php echo $log['ip_address'] ? $log['ip_address'] : "-"; ?></td>
                              <td class="p-3 text-sm text-gray-500"><?php echo $log['timestamp']; ?></td>
                              <td class="p-3">
                                  <button onclick="showDetails(<?php echo $log['log_id']; ?>)" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">View</button>
                              </td>
                          </tr>

                          <!-- Modal -->
                          <div id="auditModal-<?php echo $log['log_id']; ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                              <div class="bg-white rounded-xl p-6 w-2/3 max-w-2xl shadow-lg">
                                  <h2 class="text-2xl font-bold mb-4 text-gray-800">Log Details</h2>

                                  <p><strong>User:</strong> <?php echo htmlspecialchars($log['full_name']); ?></p>
                                  <p><strong>Role:</strong> <?php echo ucfirst($log['actor_role']); ?></p>
                                  <p><strong>Type:</strong> <?php echo $log['log_type']; ?></p>
                                  <p><strong>IP Address:</strong> <?php echo $log['ip_address'] ? $log['ip_address'] : "N/A"; ?></p>
                                  <p><strong>Timestamp:</strong> <?php echo $log['timestamp']; ?></p>

                                  <p class="mt-4"><strong>Details:</strong></p>
                                  <div class="bg-gray-100 p-4 rounded mt-2 text-gray-700">
                                      <?php echo nl2br(htmlspecialchars($log['details'])); ?>
                                  </div>

                                  <div class="mt-6 text-right">
                                      <button onclick="closeDetails(<?php echo $log['log_id']; ?>)" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Close</button>
                                  </div>
                              </div>
                          </div>
                      <?php endforeach; ?>
                  <?php else: ?>
                      <tr>
                          <td colspan="6" class="p-6 text-center text-gray-500">No logs available.</td>
                      </tr>
                  <?php endif; ?>
              </tbody>
          </table>
      </div>
  </main>
</body>
</html>
