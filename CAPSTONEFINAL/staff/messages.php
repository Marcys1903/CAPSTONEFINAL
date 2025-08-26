<?php
session_start();
include "../config/config.php";

// Block access if not logged in or not staff
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? "Staff";

// Handle AJAX requests (fetch or send messages)
if (isset($_GET['action'])) {
    header("Content-Type: application/json");

    // Fetch messages
    if ($_GET['action'] === "fetch" && isset($_GET['receiver_id'])) {
        $receiver_id = intval($_GET['receiver_id']);
        $query = "
            SELECT m.message_id, m.message, m.created_at,
                   s.user_id AS sender_id, s.username AS sender_name
            FROM messages m
            JOIN users s ON m.sender_id = s.user_id
            WHERE (m.sender_id = $user_id AND m.receiver_id = $receiver_id)
               OR (m.sender_id = $receiver_id AND m.receiver_id = $user_id)
            ORDER BY m.created_at ASC
        ";
        $result = $conn->query($query);
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        echo json_encode($messages);
        exit();
    }

    // Send message
    if ($_GET['action'] === "send" && isset($_POST['receiver_id'], $_POST['message'])) {
        $receiver_id = intval($_POST['receiver_id']);
        $message = $conn->real_escape_string($_POST['message']);
        $conn->query("INSERT INTO messages (sender_id, receiver_id, message) VALUES ($user_id, $receiver_id, '$message')");
        echo json_encode(["success" => true]);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages - Staff Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex overflow-hidden">

     <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col h-screen overflow-y-auto">
        <div class="p-6 text-2xl font-bold border-b border-gray-700">
            Staff Panel
        </div>
        <nav class="flex-1 p-4">
            <a href="dashboard.php" class="block py-2 px-3 rounded hover:bg-gray-700">Dashboard</a>
            <a href="messages.php" class="block py-2 px-3 rounded hover:bg-gray-700">Messages</a>
            <a href="send_alert.php" class="block py-2 px-3 rounded hover:bg-gray-700">Send Alert</a>
            <a href="view_alerts.php" class="block py-2 px-3 rounded hover:bg-gray-700">View Alerts</a>
            <a href="hotline.php" class="block py-2 px-3 rounded hover:bg-gray-700">Hotline</a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <a href="../auth/logout.php" class="block py-2 px-3 rounded bg-red-600 text-center hover:bg-red-700">Logout</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <div class="p-8 flex-1 flex flex-col overflow-hidden">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Messages</h1>

            <div class="flex gap-6 flex-1 overflow-hidden">
                <!-- Citizens List -->
                <div class="w-1/4 bg-white rounded-xl shadow p-4 overflow-y-auto">
                    <h2 class="text-lg font-semibold mb-3">Citizens</h2>
                    <ul class="space-y-2">
                        <?php
                        $citizens = $conn->query("SELECT user_id, username FROM users WHERE role='citizen'");
                        while ($c = $citizens->fetch_assoc()):
                        ?>
                            <li>
                                <button 
                                    onclick="openChat(<?php echo $c['user_id']; ?>, '<?php echo $c['username']; ?>')" 
                                    class="w-full text-left px-3 py-2 rounded hover:bg-gray-100">
                                    <?php echo htmlspecialchars($c['username']); ?>
                                </button>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>

                <!-- Chat Window -->
                <div class="flex-1 bg-white rounded-xl shadow flex flex-col overflow-hidden">
                    <div id="chat-header" class="p-4 border-b text-lg font-semibold">
                        Select a citizen to chat
                    </div>
                    <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-3">
                        <!-- Messages will load here -->
                    </div>
                    <form id="chat-form" class="p-4 border-t flex gap-3 hidden" onsubmit="sendMessage(event)">
                        <input type="hidden" id="receiver_id" name="receiver_id">
                        <input type="text" id="message" name="message" class="flex-1 border rounded px-3 py-2" placeholder="Type a message...">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

<script>
let currentReceiver = null;
let chatInterval = null;

function openChat(id, name) {
    currentReceiver = id;
    document.getElementById("receiver_id").value = id;
    document.getElementById("chat-header").innerText = "Chat with " + name;
    document.getElementById("chat-form").classList.remove("hidden");
    loadMessages();

    if (chatInterval) clearInterval(chatInterval);
    chatInterval = setInterval(loadMessages, 2000);
}

function loadMessages() {
    if (!currentReceiver) return;
    fetch("?action=fetch&receiver_id=" + currentReceiver)
        .then(res => res.json())
        .then(data => {
            const chatBox = document.getElementById("chat-messages");
            chatBox.innerHTML = "";
            data.forEach(msg => {
                const div = document.createElement("div");
                div.className = msg.sender_id == <?php echo $user_id; ?> 
                    ? "text-right" 
                    : "text-left";
                div.innerHTML = `
                    <div class="inline-block px-3 py-2 rounded-lg ${msg.sender_id == <?php echo $user_id; ?> ? 'bg-blue-500 text-white' : 'bg-gray-200'}">
                        ${msg.message}
                    </div>
                    <div class="text-xs text-gray-400">${msg.created_at}</div>
                `;
                chatBox.appendChild(div);
            });
            // Auto-scroll to latest message
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

function sendMessage(e) {
    e.preventDefault();
    const formData = new FormData(document.getElementById("chat-form"));
    fetch("?action=send", { method: "POST", body: formData })
        .then(res => res.json())
        .then(() => {
            document.getElementById("message").value = "";
            loadMessages();
        });
}
</script>
</body>
</html>
