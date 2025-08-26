<?php
session_start();
include "../config/config.php"; 

// ✅ Allow only staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../login.php");
    exit();
}

// ===== FETCH INCIDENT TEMPLATES =====
$templates = [];
$template_result = $conn->query("SELECT * FROM incident_templates");
if ($template_result && $template_result->num_rows > 0) {
    while ($row = $template_result->fetch_assoc()) {
        $templates[] = $row;
    }
}

// ===== SEVERITY DETECTION FUNCTION =====
function detectSeverity($message) {
    $text = strtolower($message);

    // Critical keywords
    $critical_keywords = ['explosion','bomb','earthquake','tsunami','terrorist','shooting','massive fire','category 5'];
    foreach ($critical_keywords as $word) {
        if (strpos($text, $word) !== false) {
            return 'Critical';
        }
    }

    // High severity keywords
    $high_keywords = ['fire','flood','landslide','typhoon','outbreak','power outage','category 4'];
    foreach ($high_keywords as $word) {
        if (strpos($text, $word) !== false) {
            return 'High';
        }
    }

    // Medium severity keywords
    $medium_keywords = ['heavy rain','storm','accident','protest','category 2','category 3'];
    foreach ($medium_keywords as $word) {
        if (strpos($text, $word) !== false) {
            return 'Medium';
        }
    }

    // Default
    return 'Low';
}

// ===== HANDLE ALERT SUBMISSION =====
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alert_title = trim($_POST['title']);
    $alert_message = trim($_POST['message']);
    $user_id = $_SESSION['user_id'];
    $ip_address = $_SERVER['REMOTE_ADDR'];

    if (!empty($alert_title) && !empty($alert_message)) {
        // 🔥 Auto-detect severity
        $severity = detectSeverity($alert_title . " " . $alert_message);
        $priority_level = ($severity === 'Critical') ? 5 : (($severity === 'High') ? 3 : (($severity === 'Medium') ? 2 : 1));

        // 1️⃣ Insert into alerts table
        $stmt = $conn->prepare("
            INSERT INTO alerts (alert_type, title, message, severity, priority_level, created_by, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        $alert_type = "Other"; 
        $stmt->bind_param("sssisi", $alert_type, $alert_title, $alert_message, $severity, $priority_level, $user_id);
        $stmt->execute();
        $alert_id = $stmt->insert_id;

        // 2️⃣ Send to all citizens
        $success_count = 0;
        $failure_count = 0;

        $citizens = $conn->query("SELECT user_id FROM users WHERE role='citizen'");
        if ($citizens && $citizens->num_rows > 0) {
            while ($citizen = $citizens->fetch_assoc()) {
                $cid = $citizen['user_id'];
                $stmtMsg = $conn->prepare("
                    INSERT INTO messages (sender_id, receiver_id, message, sent_at) 
                    VALUES (?, ?, ?, NOW())
                ");
                $msg = "[ALERT][$severity] " . $alert_title . " - " . $alert_message;
                $stmtMsg->bind_param("iis", $user_id, $cid, $msg);
                if ($stmtMsg->execute()) {
                    $success_count++;
                } else {
                    $failure_count++;
                }

                // also log in citizen_alerts
                $stmtAlert = $conn->prepare("
                    INSERT INTO citizen_alerts (citizen_id, alert_id, is_read) 
                    VALUES (?, ?, 'No')
                ");
                $stmtAlert->bind_param("ii", $cid, $alert_id);
                $stmtAlert->execute();
            }
        }

        // 3️⃣ Log delivery summary into notification_logs
        $stmt = $conn->prepare("
            INSERT INTO notification_logs (alert_id, sent_by, total_recipients, success_count, failure_count, timestamp) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $total = $success_count + $failure_count;
        $stmt->bind_param("iiiii", $alert_id, $user_id, $total, $success_count, $failure_count);
        $stmt->execute();

        // 4️⃣ Log staff action into audit_logs
        $stmt = $conn->prepare("
            INSERT INTO audit_logs (user_id, activity, ip_address) 
            VALUES (?, ?, ?)
        ");
        $activity = "Staff sent mass notification: " . $alert_title;
        $stmt->bind_param("iss", $user_id, $activity, $ip_address);
        $stmt->execute();

        $success = "✅ Alert sent successfully to all citizens. 
                    (Severity: $severity | Priority: $priority_level | Success: $success_count, Failures: $failure_count)";
    } else {
        $error = "❌ Please enter both title and message.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Send Alerts - Staff Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function loadTemplate() {
        const templates = <?php echo json_encode($templates); ?>;
        const selectedId = document.getElementById("templateSelect").value;
        const template = templates.find(t => t.template_id == selectedId);
        if (template) {
            document.getElementById("title").value = template.title;
            document.getElementById("message").value = template.message;
        }
    }
  </script>
</head>
<body class="bg-gray-100 min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-gray-900 text-white flex flex-col overflow-y-auto h-screen">
      <div class="p-6 text-2xl font-bold border-b border-gray-700">
          Staff Panel
      </div>
      <nav class="flex-1 p-4">
          <a href="dashboard.php" class="block py-2 px-3 rounded hover:bg-gray-700">Dashboard</a>
          <a href="messages.php" class="block py-2 px-3 rounded hover:bg-gray-700">Messages</a>
          <a href="send_alert.php" class="block py-2 px-3 rounded bg-gray-700">Send Alert</a>
          <a href="view_alerts.php" class="block py-2 px-3 rounded hover:bg-gray-700">View Alerts</a>
          <a href="hotline.php" class="block py-2 px-3 rounded hover:bg-gray-700">Hotline</a>
      </nav>
      <div class="p-4 border-t border-gray-700">
          <a href="../auth/logout.php" class="block py-2 px-3 rounded bg-red-600 text-center hover:bg-red-700">Logout</a>
      </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Send Alert</h1>

    <?php if (!empty($success)): ?>
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg"><?php echo $success; ?></div>
    <?php elseif (!empty($error)): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Choose Template</label>
        <select id="templateSelect" onchange="loadTemplate()" class="w-full px-4 py-2 border rounded-lg">
          <option value="">-- Select a template --</option>
          <?php foreach ($templates as $t): ?>
            <option value="<?php echo $t['template_id']; ?>">
              <?php echo htmlspecialchars($t['category']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Alert Title</label>
        <input type="text" id="title" name="title" required 
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Alert Message</label>
        <textarea id="message" name="message" rows="4" required 
          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"></textarea>
      </div>

      <button type="submit" 
        class="w-full py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md">
        Send Alert
      </button>
    </form>
  </main>

</body>
</html>
