<?php
session_start();
include "../config/config.php";

// ✅ Only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// ======================= SMS Sending Function =======================
function sendSMS($number, $message) {
    $apikey = "YOUR_API_KEY"; // Replace with your Semaphore API key
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://semaphore.co/api/v4/messages");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'apikey' => $apikey,
        'number' => $number,
        'message' => $message,
        'sendername' => 'LGU-ALERT'
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}

// ======================= Email Sending Function =======================
function sendEmail($to, $subject, $message) {
    $headers = "From: LGU Alerts <alerts@lgu.gov>\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    return mail($to, $subject, $message, $headers);
}

// ======================= Fetch PAGASA Auto Message =======================
$pagasa_feed_url = "https://www.pagasa.dost.gov.ph/rss/tropical-cyclone.xml";
$auto_message = "";

$rss = @simplexml_load_file($pagasa_feed_url);
if ($rss && isset($rss->channel->item[0])) {
    $latest = $rss->channel->item[0];
    $title = (string)$latest->title;
    $desc  = strip_tags((string)$latest->description);
    $date  = (string)$latest->pubDate;

    $auto_message = "PAGASA ALERT: $title. $desc (Issued: $date)";
}

// ======================= Define Incident Templates =======================
$incident_templates = [
    "Flood" => "FLOOD ALERT: Citizens are advised to evacuate to higher ground immediately. Bring essentials and proceed to the nearest evacuation center. Stay safe. - LGU",
    "Typhoon" => "TYPHOON ALERT: Strong winds and heavy rain expected. Evacuate to designated centers. - LGU",
    "Fire" => "FIRE ALERT: Fire reported. Citizens in the affected area must evacuate immediately. - LGU",
    "Earthquake" => "EARTHQUAKE ALERT: Evacuate to open spaces away from buildings. Stay calm and alert. - LGU",
    "Landslide" => "LANDSLIDE ALERT: Citizens in affected areas must evacuate to safer ground. - LGU",
];

// ======================= Handle Form Submission =======================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    $selected_category = $_POST['incident_category'] ?? null;
    $user_id = $_SESSION['user_id'];
    $ip_address = $_SERVER['REMOTE_ADDR'];

    if (!empty($message)) {
        $result = $conn->query("SELECT user_id, phone, email FROM users WHERE role='citizen'");

        while ($row = $result->fetch_assoc()) {
            $citizen_id = $row['user_id'];
            $phone      = $row['phone'] ?? null;
            $email      = $row['email'] ?? null;

            // ✅ Send SMS
            if (!empty($phone)) {
                sendSMS($phone, $message);
            }

            // ✅ Send Email
            if (!empty($email)) {
                sendEmail($email, "LGU Emergency Alert", $message);
            }

            // ✅ Insert into system inbox (messages table)
            $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message, sent_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("iis", $user_id, $citizen_id, $message);
            $stmt->execute();

            // ✅ Log in notifications table
            $stmt = $conn->prepare("INSERT INTO notifications (type, message, created_by, created_at) VALUES ('Mass Alert', ?, ?, NOW())");
            $stmt->bind_param("si", $message, $user_id);
            $stmt->execute();
        }

        // ✅ Insert into audit_logs
        $activity = "Admin sent Mass Notification (" . ($selected_category ?: "Custom") . "): " . $message;
        $stmt = $conn->prepare("INSERT INTO audit_logs (user_id, activity, ip_address, timestamp) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $user_id, $activity, $ip_address);
        $stmt->execute();

        $success = "Mass notification sent successfully to all citizens (SMS, Email, System Message).";
    } else {
        $error = "Message cannot be empty.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mass Notify Citizens - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // JS Object for templates
        const templates = <?php echo json_encode($incident_templates); ?>;

        function fillTemplate() {
            let category = document.getElementById("incident_category").value;
            let textarea = document.getElementById("message");

            if (templates[category]) {
                textarea.value = templates[category];
            }
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
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Mass Notify Citizens</h1>

    <?php if (!empty($success)): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            <?php echo $success; ?>
        </div>
    <?php elseif (!empty($error)): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="bg-white p-6 rounded-xl shadow-md space-y-4">

        <!-- Auto-filled PAGASA Alert -->
        <?php if (!empty($auto_message)): ?>
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
                <strong>Latest PAGASA Advisory:</strong><br>
                <?php echo htmlspecialchars($auto_message); ?>
            </div>
        <?php endif; ?>

        <!-- Incident Category Templates -->
        <label class="block">
            <span class="text-gray-700 font-semibold">Select Incident Category (Optional):</span>
            <select name="incident_category" id="incident_category" class="w-full border rounded p-3" onchange="fillTemplate()">
                <option value="">-- None --</option>
                <?php foreach ($incident_templates as $cat => $tpl): ?>
                    <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <!-- Custom Message Box -->
        <label class="block">
            <span class="text-gray-700 font-semibold">Emergency Message:</span>
            <textarea id="message" name="message" rows="4" class="w-full border rounded p-3 focus:ring focus:ring-blue-300"><?php echo htmlspecialchars($auto_message); ?></textarea>
        </label>

        <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
            Send Mass Notification
        </button>
    </form>
</main>
</body>
</html>
