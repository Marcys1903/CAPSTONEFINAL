<?php
session_start();
include "../config/config.php";

// Only admins or co-admins allowed
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'co-admin'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Helper function to log actions
function log_audit($conn, $user_id, $activity) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    $stmt = $conn->prepare("INSERT INTO audit_logs (user_id, activity, ip_address) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $activity, $ip);
    $stmt->execute();
    $stmt->close();
}

$errors = [];

// Add Hotline
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_hotline'])) {
    $hotline_number = trim($_POST['hotline_number'] ?? '');
    $agency = trim($_POST['agency'] ?? '');

    if ($hotline_number === '' || $agency === '') {
        $errors[] = "Both Hotline Number and Agency are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO hotlines (hotline_number, agency) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $hotline_number, $agency);
            $stmt->execute();
            $stmt->close();

            // Log the action
            log_audit($conn, $_SESSION['user_id'], "Added hotline: {$hotline_number} ({$agency})");

            header("Location: hotline.php?ok=1");
            exit();
        }
    }
}

// Delete Hotline
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    if ($id > 0) {
        // Get details before deleting
        $hotline = $conn->query("SELECT hotline_number, agency FROM hotlines WHERE id = $id")->fetch_assoc();

        $stmt = $conn->prepare("DELETE FROM hotlines WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

            // Log the action
            if ($hotline) {
                log_audit($conn, $_SESSION['user_id'], "Removed hotline: {$hotline['hotline_number']} ({$hotline['agency']})");
            }
        }
    }
    header("Location: hotline.php?ok=1");
    exit();
}

// Fetch all hotlines
$result = $conn->query("SELECT id, hotline_number, agency FROM hotlines ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin | Manage Hotlines</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-gray-900 text-white flex flex-col overflow-y-auto h-screen">
      <div class="p-6 text-2xl font-bold border-b border-gray-700">
          Admin Panel
      </div>
      <nav class="flex-1 p-4 space-y-2">
          <a href="dashboard.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Dashboard</a>
          <a href="messages.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Messages</a>
          <a href="massnotify.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Notification</a>
          <a href="hotline.php" class="block py-2 px-3 rounded bg-gray-800"> Hotline</a>
          <a href="audit.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Audit Logs</a>
          <a href="system_settings.php" class="block py-2 px-3 rounded hover:bg-gray-700"> Settings</a>
      </nav>
      <div class="p-4 border-t border-gray-700">
          <a href="../auth/logout.php" class="block py-2 px-3 rounded bg-red-600 text-center hover:bg-red-700">Logout</a>
      </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 h-screen overflow-y-auto p-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage Emergency Hotlines</h1>

      <!-- Add Hotline Form -->
      <div class="bg-white p-6 rounded-xl shadow mb-6">
          <h2 class="text-xl font-bold mb-4 text-gray-700">Add Hotline</h2>
          <?php if (!empty($errors)): ?>
              <div class="mb-4 text-red-600">
                  <?php foreach ($errors as $error): ?>
                      <p><?php echo htmlspecialchars($error); ?></p>
                  <?php endforeach; ?>
              </div>
          <?php endif; ?>
          <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <input type="text" name="hotline_number" placeholder="Hotline Number" class="p-3 border rounded" required>
              <input type="text" name="agency" placeholder="Agency Name" class="p-3 border rounded" required>
              <button type="submit" name="add_hotline" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add Hotline</button>
          </form>
      </div>

      <!-- Hotline List -->
      <div class="bg-white p-6 rounded-xl shadow">
          <h2 class="text-xl font-bold mb-4 text-gray-700">Hotline Directory</h2>
          <table class="w-full border-collapse">
              <thead class="bg-gray-800 text-white">
                  <tr>
                      <th class="px-4 py-3 text-left">#</th>
                      <th class="px-4 py-3 text-left">Hotline</th>
                      <th class="px-4 py-3 text-left">Agency</th>
                      <th class="px-4 py-3 text-left">Action</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                  <?php if ($result && $result->num_rows > 0): ?>
                      <?php while ($row = $result->fetch_assoc()): ?>
                          <tr class="hover:bg-gray-50">
                              <td class="px-4 py-3"><?php echo $row['id']; ?></td>
                              <td class="px-4 py-3 font-semibold text-gray-800"><?php echo htmlspecialchars($row['hotline_number']); ?></td>
                              <td class="px-4 py-3 text-gray-700"><?php echo htmlspecialchars($row['agency']); ?></td>
                              <td class="px-4 py-3">
                                  <a href="hotline.php?delete=<?php echo $row['id']; ?>" 
                                     onclick="return confirm('Are you sure you want to delete this hotline?');" 
                                     class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                     Delete
                                  </a>
                              </td>
                          </tr>
                      <?php endwhile; ?>
                  <?php else: ?>
                      <tr>
                          <td colspan="4" class="px-4 py-6 text-center text-gray-500">No hotlines available.</td>
                      </tr>
                  <?php endif; ?>
              </tbody>
          </table>
      </div>
  </main>
</body>
</html>
