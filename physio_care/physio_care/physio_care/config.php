<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "physio_care";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure proper UTF-8 handling
$conn->set_charset("utf8mb4");
?>
