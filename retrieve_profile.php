<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "Paul8927!"; // Replace with your database password
$dbname = "jobs";

// Create connection
$conn = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session to get the logged-in user's ID
session_start();
if (!isset($_SESSION['id'])) {
    die("User not logged in.");
}
$userId = $_SESSION['id'];

// Retrieve user details
$sql = "SELECT id, firstName, lastName, username, gender, phone, photo, email 
        FROM users 
        WHERE id = '$userId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

// Handle photo upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profilePhoto'])) {
    $targetDir = __DIR__ . "/users_details/"; // Use absolute path
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true); // Create the directory if it doesn't exist
    }

    $targetFile = $targetDir . basename($_FILES['profilePhoto']['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($_FILES['profilePhoto']['tmp_name']);
    if ($check === false) {
        die("File is not an image.");
    }

    // Check file size (5MB limit)
    if ($_FILES['profilePhoto']['size'] > 5000000) {
        die("File is too large. Maximum size is 5MB.");
    }

    // Allow only certain file formats
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
        die("Only JPG, JPEG, and PNG files are allowed.");
    }

    // Resize the image to 100x100 pixels
    list($width, $height) = getimagesize($_FILES['profilePhoto']['tmp_name']);
    $newWidth = 100;
    $newHeight = 100;
    $image = imagecreatetruecolor($newWidth, $newHeight);

    switch ($imageFileType) {
        case 'jpg':
        case 'jpeg':
            $source = imagecreatefromjpeg($_FILES['profilePhoto']['tmp_name']);
            break;
        case 'png':
            $source = imagecreatefrompng($_FILES['profilePhoto']['tmp_name']);
            break;
        default:
            die("Unsupported file format.");
    }

    imagecopyresized($image, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Save the resized image
    $resizedFile = $targetDir . "profile_" . $userId . "." . $imageFileType;
    switch ($imageFileType) {
        case 'jpg':
        case 'jpeg':
            imagejpeg($image, $resizedFile);
            break;
        case 'png':
            imagepng($image, $resizedFile);
            break;
    }

    imagedestroy($image);
    imagedestroy($source);

    // Update the photo path in the database
    $photoPath = "users_details/profile_" . $userId . "." . $imageFileType;
    $updateSql = "UPDATE users SET photo = '$photoPath' WHERE id = '$userId'";
    if ($conn->query($updateSql) === TRUE) {
        echo "<script>alert('Profile picture updated successfully.');</script>";
    } else {
        echo "<script>alert('Error updating profile picture: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>