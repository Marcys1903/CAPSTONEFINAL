<?php
session_start();
include "../config/config.php"; // database connection

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // ✅ Log the logout into audit_logs
    $sql = "INSERT INTO audit_logs (user_id, activity, ip_address) VALUES (?, 'Logout', ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $ip_address);
    $stmt->execute();
}

// Destroy session
session_unset();
session_destroy();

// Redirect to login
header("Location: login.php");
exit();
