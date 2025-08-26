<?php
session_start();

// If user is logged in, redirect them based on role
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php");
        exit();
    } elseif ($_SESSION['role'] == 'staff') {
        header("Location: staff/dashboard.php");
        exit();
    } elseif ($_SESSION['role'] == 'citizen') {
        header("Location: citizen/dashboard.php");
        exit();
    }
} else {
    // If not logged in, go to login page
    header("Location: auth/login.php");
    exit();
}
?>
