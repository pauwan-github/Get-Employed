<?php
session_start();
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

$servername = "sql8.freesqldatabase.com";
$username = "sql8768844";
$password = "mTEXIPAw7m";
$dbname = "sql8768844";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $conn->real_escape_string($_POST['code']);

    // Verify the code
    $email = $_SESSION['reset_email'];
    $sql = "SELECT * FROM users WHERE email = '$email' AND verificationCode = '$code'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        header("Location: change_password.php");
        exit();
    } else {
        echo "Invalid verification code.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
</head>
<body>
    <h1>Verify Code</h1>
    <form method="post">
        <label for="code">Enter the verification code:</label>
        <input type="text" name="code" id="code" required>
        <button type="submit">Verify</button>
    </form>
</body>
</html>