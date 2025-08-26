<?php
$host = "127.0.0.1";   // use 127.0.0.1 instead of localhost
$user = "root";        // default XAMPP user
$pass = "";            // default XAMPP password is empty
$dbname = "lgu_emergency_system";
$port = 3306;          // change to 3307 if your MySQL runs on that port

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("
        <b>Database Connection Failed</b><br>
        Host: $host<br>
        User: $user<br>
        Database: $dbname<br>
        Port: $port<br>
        Error: " . $conn->connect_error
    );
}
?>
