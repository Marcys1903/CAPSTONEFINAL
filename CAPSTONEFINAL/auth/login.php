<?php
session_start();
include "../config/config.php"; // database connection

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // plaintext (not hashed, per your request)

    $sql = "SELECT * FROM users WHERE username=? AND password=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Save session variables
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['role']      = $user['role'];
        $_SESSION['username']  = $user['username'];

        // ✅ Log the login into audit_logs
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $log_sql = "INSERT INTO audit_logs (user_id, activity, ip_address) VALUES (?, 'Login', ?)";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->bind_param("is", $user['user_id'], $ip_address);
        $log_stmt->execute();

        // Redirect based on role
        switch ($user['role']) {
            case 'admin':
                header("Location: ../admin/dashboard.php");
                break;
            case 'staff':
                header("Location: ../staff/dashboard.php");
                break;
            default:
                header("Location: ../citizen/dashboard.php");
        }
        exit();
    } else {
        $message = "❌ Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-orange-400 to-orange-600">
  <div class="bg-white shadow-2xl rounded-2xl flex w-[780px] h-[480px] max-w-full overflow-hidden">
    
    <!-- Left: Login Form -->
    <div class="w-1/2 p-10 flex flex-col justify-center">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Login</h2>

      <!-- Message Display -->
      <?php if (!empty($message)): ?>
        <div class="mb-4 p-2 text-center rounded-lg 
          <?php echo (strpos($message, '❌') !== false) ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'; ?>">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm mb-2">Username</label>
          <input type="text" name="username" required 
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm mb-2">Password</label>
          <input type="password" name="password" required 
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none">
        </div>

        <button type="submit" 
          class="w-full py-2 mt-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg shadow-md transition">
          Login
        </button>
      </form>

      <p class="mt-6 text-sm text-gray-600 text-center">
        Don’t have an account? 
        <a href="register_step1.php" class="text-orange-500 hover:underline">Sign Up</a>
      </p>
    </div>

    <!-- Right: Branding / Info -->
    <div class="w-1/2 bg-gray-900 text-white flex flex-col items-center justify-center p-10">
      <h2 class="text-4xl font-extrabold mb-4">QC</h2>
      <h2 class="text-4xl font-extrabold mb-4">Protektado</h2>

      <p class="text-center text-gray-300">
        Stay connected and safe. Login to access<br>
        real-time emergency alerts and notifications.
      </p>
    </div>
  </div>
</body>
</html>
