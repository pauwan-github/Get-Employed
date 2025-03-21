<?php
// Database connection
$conn = new mysqli('localhost', 'root', 'Paul8927!', 'jobs');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the email from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];

// Insert the email into the subscribers table
$sql = "INSERT INTO subscribers (email) VALUES ('$email')";
if ($conn->query($sql)) { // Corrected: Added missing closing parenthesis
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>