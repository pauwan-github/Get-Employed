<?php
session_start();
if (!isset($_SESSION['userId'])) {
    echo json_encode(['success' => false]);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "Paul8927!";
$dbname = "jobs";

// Create connection
$conn = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update last logout time
$userId = $_SESSION['userId'];
$sql = "UPDATE users SET lastLogout = NOW() WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->close();
$conn->close();

// Destroy session
session_destroy();
echo json_encode(['success' => true]);
?>