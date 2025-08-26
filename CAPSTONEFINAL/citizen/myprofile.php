<?php
session_start();
include "../config/config.php"; // DB connection

// Block access if not logged in or not citizen
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $language = trim($_POST['language_preference']);

    $qc_id_path = null;

    // Handle file upload if new QC ID is provided
    if (!empty($_FILES['qc_id']['name'])) {
        $upload_dir = "../uploads/qc_ids/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES['qc_id']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['qc_id']['tmp_name'], $target_file)) {
            $qc_id_path = $target_file;
        }
    }

    // Update query
    if ($qc_id_path) {
        $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone=?, address=?, language_preference=?, qc_id_path=? WHERE user_id=?");
        $stmt->bind_param("ssssssi", $full_name, $email, $phone, $address, $language, $qc_id_path, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone=?, address=?, language_preference=? WHERE user_id=?");
        $stmt->bind_param("sssssi", $full_name, $email, $phone, $address, $language, $user_id);
    }

    if ($stmt->execute()) {
        header("Location: myprofile.php?success=1");
        exit();
    }
}

// Fetch citizen data
$query = "SELECT full_name, username, email, phone, address, language_preference, qc_id_path, created_at 
          FROM users 
          WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Citizen | My Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-gray-900 text-white flex flex-col h-screen overflow-y-auto">
      <div class="p-6 text-2xl font-bold border-b border-gray-700">
          Citizen Panel
      </div>
      <nav class="flex-1 p-4">
          <a href="dashboard.php" class="block py-2 px-3 rounded hover:bg-gray-700">Dashboard</a>
          <a href="myalerts.php" class="block py-2 px-3 rounded hover:bg-gray-700">My Alerts</a>
          <a href="messages.php" class="block py-2 px-3 rounded hover:bg-gray-700">Messages</a>
          <a href="hotline.php" class="block py-2 px-3 rounded hover:bg-gray-700">Hotline</a>
          <a href="myprofile.php" class="block py-2 px-3 rounded bg-gray-700">My Profile</a>
      </nav>
      <div class="p-4 border-t border-gray-700">
          <a href="../auth/logout.php" class="block py-2 px-3 rounded bg-red-600 text-center hover:bg-red-700">Logout</a>
      </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 h-screen overflow-y-auto p-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">
          My Profile
      </h1>

      <div class="overflow-x-auto bg-white rounded-xl shadow p-6">
          <?php if ($user): ?>
              <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                  <div>
                      <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                      <dd class="mt-1 text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($user['full_name']); ?></dd>
                  </div>
                  <div>
                      <dt class="text-sm font-medium text-gray-500">Username</dt>
                      <dd class="mt-1 text-lg text-gray-800"><?php echo htmlspecialchars($user['username']); ?></dd>
                  </div>
                  <div>
                      <dt class="text-sm font-medium text-gray-500">Email</dt>
                      <dd class="mt-1 text-lg text-gray-800"><?php echo htmlspecialchars($user['email']); ?></dd>
                  </div>
                  <div>
                      <dt class="text-sm font-medium text-gray-500">Phone</dt>
                      <dd class="mt-1 text-lg text-gray-800"><?php echo htmlspecialchars($user['phone']); ?></dd>
                  </div>
                  <div class="md:col-span-2">
                      <dt class="text-sm font-medium text-gray-500">Address</dt>
                      <dd class="mt-1 text-lg text-gray-800"><?php echo htmlspecialchars($user['address']); ?></dd>
                  </div>
                  <div>
                      <dt class="text-sm font-medium text-gray-500">Language Preference</dt>
                      <dd class="mt-1 text-lg text-gray-800"><?php echo htmlspecialchars($user['language_preference']); ?></dd>
                  </div>
                  <div>
                      <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                      <dd class="mt-1 text-lg text-gray-800"><?php echo $user['created_at']; ?></dd>
                  </div>
                  <?php if (!empty($user['qc_id_path'])): ?>
                  <div class="md:col-span-2">
                      <dt class="text-sm font-medium text-gray-500">QC ID Uploaded</dt>
                      <dd class="mt-2">
                          <!-- Thumbnail -->
                          <img src="<?php echo htmlspecialchars($user['qc_id_path']); ?>" 
                               alt="QC ID" 
                               class="w-32 cursor-pointer border rounded-lg shadow hover:opacity-80 transition"
                               onclick="openModal('<?php echo htmlspecialchars($user['qc_id_path']); ?>')">
                      </dd>
                  </div>
                  <?php endif; ?>
              </dl>

              <!-- Edit Profile Button -->
              <div class="mt-8">
                  <button onclick="openEditModal()" 
                          class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                      Edit Profile
                  </button>
              </div>
          <?php else: ?>
              <p class="text-gray-600">Unable to load your profile information.</p>
          <?php endif; ?>
      </div>
  </main>

  <!-- Modal for Image Preview -->
  <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50" onclick="closeModal(event)">
      <span class="absolute top-4 right-6 text-white text-3xl font-bold cursor-pointer" onclick="closeModal()">&times;</span>
      <img id="modalImage" src="" alt="QC ID Full" class="max-h-[90%] max-w-[90%] rounded-lg shadow-lg">
  </div>

  <!-- Modal for Editing Profile -->
  <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white rounded-xl p-6 w-full max-w-2xl shadow-lg">
          <h2 class="text-2xl font-bold mb-4 text-gray-800">Edit Profile</h2>
          <form method="POST" enctype="multipart/form-data" class="space-y-4">
              <input type="hidden" name="update_profile" value="1">
              <div>
                  <label class="block text-sm font-medium text-gray-600">Full Name</label>
                  <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" class="w-full border p-2 rounded" required>
              </div>
              <div>
                  <label class="block text-sm font-medium text-gray-600">Email</label>
                  <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full border p-2 rounded" required>
              </div>
              <div>
                  <label class="block text-sm font-medium text-gray-600">Phone</label>
                  <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" class="w-full border p-2 rounded" required>
              </div>
              <div>
                  <label class="block text-sm font-medium text-gray-600">Address</label>
                  <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" class="w-full border p-2 rounded" required>
              </div>
              <div>
                  <label class="block text-sm font-medium text-gray-600">Language Preference</label>
                  <input type="text" name="language_preference" value="<?php echo htmlspecialchars($user['language_preference']); ?>" class="w-full border p-2 rounded">
              </div>
              <div>
                  <label class="block text-sm font-medium text-gray-600">Update QC ID</label>
                  <input type="file" name="qc_id" accept="image/*" class="w-full border p-2 rounded">
              </div>
              <div class="text-right">
                  <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
                  <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save Changes</button>
              </div>
          </form>
      </div>
  </div>

  <script>
  function openModal(src) {
      document.getElementById("modalImage").src = src;
      document.getElementById("imageModal").classList.remove("hidden");
      document.getElementById("imageModal").classList.add("flex");
  }
  function closeModal(e = null) {
      if (!e || e.target.id === "imageModal" || e.target.tagName === "SPAN") {
          document.getElementById("imageModal").classList.remove("flex");
          document.getElementById("imageModal").classList.add("hidden");
      }
  }
  function openEditModal() {
      document.getElementById("editModal").classList.remove("hidden");
  }
  function closeEditModal() {
      document.getElementById("editModal").classList.add("hidden");
  }
  </script>

</body>
</html>
