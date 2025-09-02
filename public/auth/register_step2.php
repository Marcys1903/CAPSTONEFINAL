<?php
session_start();
include "../config/config.php";

if (!isset($_SESSION['reg_username'])) {
    header("Location: register_step1.php");
    exit();
}

$message = "";

// Generate verification code (once per session)
if (!isset($_SESSION['verification_code'])) {
    $_SESSION['verification_code'] = rand(100000, 999999); // 6-digit code
    // TODO: Send via email/SMS in production
}

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = $_POST['verification_code'];

    if ($entered_code == $_SESSION['verification_code']) {
        // Collect user data from Step 1
        $role       = "citizen";
        $username   = $_SESSION['reg_username'];
        $password   = $_SESSION['reg_password'];
        $full_name  = $_SESSION['reg_fullname'];
        $email      = $_SESSION['reg_email'];
        $phone      = $_SESSION['reg_phone'];
        $address    = $_SESSION['reg_address'];
        $language   = $_SESSION['reg_language'];
        $qc_id_path = $_SESSION['reg_qc_id'];

        // Insert into DB
        $stmt = $conn->prepare("INSERT INTO users 
            (role, username, password, full_name, email, phone, address, language_preference, qc_id_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $role, $username, $password, $full_name, $email, $phone, $address, $language, $qc_id_path);

        if ($stmt->execute()) {
            // Clear session temp data
            unset($_SESSION['reg_fullname'], $_SESSION['reg_username'], $_SESSION['reg_password'], 
                  $_SESSION['reg_email'], $_SESSION['reg_phone'], $_SESSION['reg_address'], 
                  $_SESSION['reg_language'], $_SESSION['reg_qc_id'], $_SESSION['verification_code']);

            header("Location: login.php");
            exit();
        } else {
            $message = "❌ Registration failed: " . $conn->error;
        }
    } else {
        $message = "❌ Invalid verification code. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Step 2</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-orange-400 to-orange-600">
  <div class="bg-white shadow-2xl rounded-2xl flex w-[880px] h-[480px] max-w-full overflow-hidden">

    <!-- Left: Verification Form -->
    <div class="w-1/2 p-10 flex flex-col justify-center">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Register - Step 2</h2>

      <?php if (!empty($message)): ?>
        <div class="mb-4 p-2 text-center rounded-lg bg-red-100 text-red-700">
          <?= $message ?>
        </div>
      <?php endif; ?>

      <p class="mb-4 text-gray-700">
        A 6-digit verification code has been sent to your email/phone.<br>
        Enter the code below to complete your registration.
      </p>

      <!-- ⚠️ For demo only: show the generated code -->
      <div class="mb-4 p-2 bg-yellow-100 text-yellow-800 rounded text-center">
        Demo Code: <strong><?= $_SESSION['verification_code'] ?></strong>
      </div>

      <form method="POST">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm mb-2">Verification Code</label>
          <input type="text" name="verification_code" maxlength="6" required
                 class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 text-center text-lg tracking-widest">
        </div>

        <button type="submit" class="w-full py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg shadow-md transition">
          Complete Registration
        </button>
      </form>
    </div>

    <!-- Right: Branding / Info -->
    <div class="w-1/2 bg-gray-900 text-white flex flex-col items-center justify-center p-10">
      <h2 class="text-4xl font-extrabold mb-4">QC</h2>
      <h2 class="text-4xl font-extrabold mb-4">Protektado</h2>
      <p class="text-center text-gray-300">
        Step 2: Enter the verification code<br>
        to activate your account securely.
      </p>
    </div>
  </div>
</body>
</html>
          