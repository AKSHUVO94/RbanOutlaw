<?php
$host = "localhost";
$user = "root"; // Update with your DB username
$pass = "";     // Update with your DB password
$dbname = "mysql"; // Update with your database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>