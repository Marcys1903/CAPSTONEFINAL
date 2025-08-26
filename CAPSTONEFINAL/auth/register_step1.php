<?php
session_start();
include "../config/config.php"; // database connection

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['reg_fullname']  = $_POST['full_name'];
    $_SESSION['reg_username']  = $_POST['username'];
    $_SESSION['reg_password']  = $_POST['password'];
    $_SESSION['reg_email']     = $_POST['email'];
    $_SESSION['reg_phone']     = $_POST['phone'];
    $_SESSION['reg_address']   = $_POST['address'];
    $_SESSION['reg_language']  = $_POST['language_preference'];

    // Handle QC ID upload
    if (isset($_FILES['qc_id']) && $_FILES['qc_id']['error'] == 0) {
        $upload_dir = "../uploads/qc_ids/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_name = time() . "_" . basename($_FILES["qc_id"]["name"]);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES["qc_id"]["tmp_name"], $target_file)) {
            $_SESSION['reg_qc_id'] = $target_file;
            header("Location: register_step2.php");
            exit();
        } else {
            $message = "❌ Failed to upload QC ID.";
        }
    } else {
        $message = "❌ QC ID upload is required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Step 1</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-orange-400 to-orange-600">
  <div class="bg-white shadow-2xl rounded-2xl flex w-[1000px] h-[650px] max-w-full overflow-hidden">

    <!-- Left: Registration Form -->
    <div class="w-1/2 p-10 flex flex-col justify-center">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Register - Step 1</h2>

      <?php if (!empty($message)): ?>
        <div class="mb-4 p-2 text-center rounded-lg bg-red-100 text-red-700">
          <?= $message ?>
        </div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-2 gap-4">
          <!-- Full Name -->
          <div>
            <label class="block text-gray-700 text-sm mb-2">Full Name</label>
            <input type="text" name="full_name" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
          </div>

          <!-- Username -->
          <div>
            <label class="block text-gray-700 text-sm mb-2">Username</label>
            <input type="text" name="username" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
          </div>

          <!-- Password -->
          <div>
            <label class="block text-gray-700 text-sm mb-2">Password</label>
            <input type="password" name="password" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
          </div>

          <!-- Email -->
          <div>
            <label class="block text-gray-700 text-sm mb-2">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
          </div>

          <!-- Phone -->
          <div>
            <label class="block text-gray-700 text-sm mb-2">Phone</label>
            <input type="text" name="phone" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
          </div>

          <!-- Language -->
          <div>
            <label class="block text-gray-700 text-sm mb-2">Language Preference</label>
            <select name="language_preference" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
              <option value="English">English</option>
              <option value="Filipino">Filipino</option>
            </select>
          </div>
        </div>

        <!-- Address full width -->
        <div class="mt-4">
          <label class="block text-gray-700 text-sm mb-2">Address</label>
          <textarea name="address" rows="2" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500"></textarea>
        </div>

        <!-- QC ID upload full width -->
        <div class="mt-4">
          <label class="block text-gray-700 text-sm mb-2">Upload QC ID</label>
          <input type="file" name="qc_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
        </div>

        <button type="submit" class="w-full mt-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg shadow-md transition">
          Next Step →
        </button>
      </form>
    </div>

    <!-- Right: Branding / Info -->
    <div class="w-1/2 bg-gray-900 text-white flex flex-col items-center justify-center p-10">
      <h2 class="text-4xl font-extrabold mb-4">QC</h2>
      <h2 class="text-4xl font-extrabold mb-4">Protektado</h2>
      <p class="text-center text-gray-300">
        Step 1: Enter your details and upload your<br>
        Quezon City ID for verification.
      </p>
    </div>
  </div>
</body>
</html>
