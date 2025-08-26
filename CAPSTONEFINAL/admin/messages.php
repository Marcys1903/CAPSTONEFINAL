<?php
session_start();
include "../config/config.php";

// Block access if not logged in or not admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch all messages with sender and receiver info
$query = "
    SELECT 
           m.message_id AS id,
           m.message,
           m.created_at,
           s.username AS sender_name, s.role AS sender_role,
           r.username AS receiver_name, r.role AS receiver_role
    FROM messages m
    JOIN users s ON m.sender_id = s.user_id
    JOIN users r ON m.receiver_id = r.user_id
    ORDER BY m.created_at DESC
";

$messages = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Messages</h1>

        <div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="sticky top-0 bg-gray-200">
                    <tr class="text-left">
                        <th class="p-3">ID</th>
                        <th class="p-3">Sender</th>
                        <th class="p-3">Receiver</th>
                        <th class="p-3">Message</th>
                        <th class="p-3">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($messages->num_rows > 0): ?>
                        <?php while ($row = $messages->fetch_assoc()): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?php echo $row['id']; ?></td>
                                <td class="p-3">
                                    <?php echo htmlspecialchars($row['sender_name']); ?> 
                                    <span class="text-xs text-gray-500">(<?php echo $row['sender_role']; ?>)</span>
                                </td>
                                <td class="p-3">
                                    <?php echo htmlspecialchars($row['receiver_name']); ?> 
                                    <span class="text-xs text-gray-500">(<?php echo $row['receiver_role']; ?>)</span>
                                </td>
                                <td class="p-3"><?php echo htmlspecialchars($row['message']); ?></td>
                                <td class="p-3 text-sm text-gray-500"><?php echo $row['created_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-3 text-center text-gray-500">No messages found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
