<?php
session_start();
include "../config/config.php";

// Block access if not logged in or not a citizen
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? "Citizen";

// Handle AJAX requests
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
    <title>Messages - Citizen Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body class="bg-gray-100 min-h-screen flex">

    <?php include "sidebar.php"; ?>


    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Messages</h1>

        <div class="flex gap-6">
            <!-- Staff List -->
            <div class="w-1/4 bg-white rounded-xl shadow p-4">
                <h2 class="text-lg font-semibold mb-3">Staff</h2>
                <ul>
                    <?php
                    $staffs = $conn->query("SELECT user_id, username FROM users WHERE role='staff'");
                    while ($s = $staffs->fetch_assoc()):
                    ?>
                        <li>
                            <button 
                                onclick="openChat(<?php echo $s['user_id']; ?>, '<?php echo $s['username']; ?>')" 
                                class="w-full text-left px-3 py-2 rounded hover:bg-gray-100">
                                <?php echo htmlspecialchars($s['username']); ?>
                            </button>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>

            <!-- Chat Window -->
            <div class="flex-1 bg-white rounded-xl shadow flex flex-col">
                <div id="chat-header" class="p-4 border-b text-lg font-semibold">
                    Select a staff to chat
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
