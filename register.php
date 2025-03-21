<?php
$servername = "localhost";
$username = "root"; // default username for localhost
$password = "Paul8927!"; // default password for localhost
$dbname = "jobs";

// Create connection
$conn = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize input data
$firstName = $conn->real_escape_string($_POST['firstName']);
$lastName = $conn->real_escape_string($_POST['lastName']);
$yearOfBirth = $conn->real_escape_string($_POST['yob']);
$gender = $conn->real_escape_string($_POST['gender']);
$username = $conn->real_escape_string($_POST['username']);
$email = $conn->real_escape_string($_POST['email']);
$phone = $conn->real_escape_string($_POST['phone']);
$userType = $conn->real_escape_string($_POST['userType']);
$company = isset($_POST['company']) ? $conn->real_escape_string($_POST['company']) : null;
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

// Insert into database
$sql = "INSERT INTO users (firstName, lastName, yearOfBirth, gender, username, email, phone, userType, company, password)
VALUES ('$firstName', '$lastName', '$yearOfBirth', '$gender', '$username', '$email', '$phone', '$userType', '$company', '$password')";

if ($conn->query($sql) === TRUE) {
    // Redirect to login.html after successful registration
    header("Location: login.html");
    exit(); // Ensure no further code is executed after the redirect
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// After inserting the user, generate a token and send an email
$verificationToken = bin2hex(random_bytes(50));
$sql = "UPDATE users SET verificationToken='$verificationToken' WHERE email='$email'";
if ($conn->query($sql)) { // Added the missing closing parenthesis here
    $verifyLink = "http://yourwebsite.com/verify.php?token=$verificationToken";
    mail($email, "Verify your email", "Please click on this link to verify your email: $verifyLink");
}

$conn->close();
?>