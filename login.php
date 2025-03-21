<?php
session_start();
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

// Get form data
$input = $_POST['username'];
$password = $_POST['password'];

// Fetch user from database
$sql = "SELECT * FROM users WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $input, $input);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['userId'] = $user['id'];
        $_SESSION['userType'] = $user['userType'];

        // Update last login time
        $updateSql = "UPDATE users SET lastLogin = NOW() WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $user['id']);
        $updateStmt->execute();

        // Redirect based on user type
        $redirect = ($user['userType'] === 'jobSeeker') ? 'jobseeker_dashboard.php' : 'employer_dashboard.php';
        echo json_encode(['success' => true, 'redirect' => $redirect]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid user or password']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

$stmt->close();
$conn->close();
?>