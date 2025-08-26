<?php
session_start();
include "../config/config.php";

// ✅ Only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$audit_logs = [];

// ===== FETCH AUDIT LOGS =====
$sql = "
    -- 1. Messages
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

    UNION ALL

    -- 2. System Activities (Login, Logout, etc.)
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
    WHERE a.activity NOT LIKE 'Staff sent mass notification%'
      AND a.activity NOT LIKE 'Admin sent mass SMS notification%'
      AND a.activity NOT LIKE 'Added hotline:%'
      AND a.activity NOT LIKE 'Removed hotline:%'

    UNION ALL

    -- 3. Staff Alerts
    SELECT 
        al.alert_id AS log_id,
        u.username,
        u.full_name,
        u.role AS actor_role,
        NULL AS target,
        NULL AS target_role,
        CONCAT('Staff Alert: ', al.title, ' - ', al.message) AS details,
        al.created_at AS timestamp,
        'Staff Alert' AS log_type,
        a.ip_address
    FROM audit_logs a
    JOIN users u ON a.user_id = u.user_id
    JOIN alerts al ON al.created_by = u.user_id
    WHERE a.activity LIKE 'Staff sent mass notification%'

    UNION ALL

    -- 4. Admin Mass Notifications
    SELECT 
        a.audit_id AS log_id,
        u.username,
        u.full_name,
        u.role AS actor_role,
        NULL AS target,
        NULL AS target_role,
        a.activity AS details,
        a.timestamp,
        'Mass SMS' AS log_type,
        a.ip_address
    FROM audit_logs a
    JOIN users u ON a.user_id = u.user_id
    WHERE a.activity LIKE 'Admin sent mass SMS notification%'

    UNION ALL

    -- 5. System Settings Changes
    SELECT 
        ss.setting_id AS log_id,
        u.username,
        u.full_name,
        u.role AS actor_role,
        NULL AS target,
        NULL AS target_role,
        CONCAT('Updated setting: ', ss.setting_name, ' → ', ss.setting_value) AS details,
        ss.updated_at AS timestamp,
        'System Change' AS log_type,
        NULL AS ip_address
    FROM system_settings ss
    JOIN users u ON ss.updated_by = u.user_id

    UNION ALL

    -- 6. Hotline Changes
    SELECT 
        a.audit_id AS log_id,
        u.username,
        u.full_name,
        u.role AS actor_role,
        NULL AS target,
        NULL AS target_role,
        a.activity AS details,
        a.timestamp,
        'Hotline Change' AS log_type,
        a.ip_address
    FROM audit_logs a
    JOIN users u ON a.user_id = u.user_id
    WHERE a.activity LIKE 'Added hotline:%'
       OR a.activity LIKE 'Removed hotline:%'

    ORDER BY timestamp DESC
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
    <title>Audit Logs - LGU Emergency System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function showDetails(logId) {
            document.getElementById("auditModal-" + logId).classList.remove("hidden");
        }
        function closeDetails(logId) {
            document.getElementById("auditModal-" + logId).classList.add("hidden");
        }
    </script>
</head>
<body class="bg-gray-100 h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-gray-900 text-white flex flex-col overflow-y-auto h-screen">
      <div class="p-6 text-2xl font-bold border-b border-gray-700">
          Admin Panel
      </div>
      <nav class="flex-1 p-4 space-y-2">
          <a href="dashboard.php" class="block py-2 px-3 rounded bg-gray-800 hover:bg-gray-700"> Dashboard</a>
          <a href="messages.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Messages</a>
          <a href="massnotify.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Notification</a>
          <a href="hotline.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Hotline</a>
          <a href="audit.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Audit Logs</a>
          <a href="system_settings.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Settings</a>
      </nav>
      <div class="p-4 border-t border-gray-700">
          <a href="../auth/logout.php" class="block py-2 px-3 rounded bg-red-600 text-center hover:bg-red-700">Logout</a>
      </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 h-screen overflow-y-auto p-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-6"> Audit Logs</h1>

      <div class="bg-white p-6 rounded-xl shadow">
          <table class="w-full border-collapse">
              <thead>
                  <tr class="bg-gray-200 text-gray-700 text-left">
                      <th class="p-3">#</th>
                      <th class="p-3">Actor</th>
                      <th class="p-3">Role</th>
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
                              <!-- ✅ Table Actor shows username only -->
                              <td class="p-3 font-semibold"><?php echo htmlspecialchars($log['username']); ?></td>
                              <td class="p-3 text-sm text-gray-600"><?php echo ucfirst($log['actor_role']); ?></td>
                              <td class="p-3"><?php echo htmlspecialchars($log['details']); ?></td>
                              <td class="p-3 text-sm font-medium
                                  <?php
                                      if ($log['log_type'] === 'Staff Alert') echo 'text-red-600';
                                      elseif ($log['log_type'] === 'Mass SMS') echo 'text-blue-600';
                                      elseif ($log['log_type'] === 'System Change') echo 'text-purple-600';
                                      elseif ($log['log_type'] === 'Hotline Change') echo 'text-green-600';
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

                                  <!-- ✅ Full name only -->
                                  <p><strong>Actor:</strong> <?php echo htmlspecialchars($log['full_name']); ?></p>
                                  <!-- ✅ Role only -->
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
                          <td colspan="8" class="p-6 text-center text-gray-500">No logs available.</td>
                      </tr>
                  <?php endif; ?>
              </tbody>
          </table>
      </div>
  </main>
</body>
</html>
