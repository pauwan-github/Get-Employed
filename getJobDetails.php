<?php
// Retrieve the job ID from the query parameter
$jobId = $_GET['id'] ?? '';

// Create a new MySQLi connection to the database
$con = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");

// Check if the connection to the database was successful
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch job details from the database
$sql = "SELECT * FROM posts WHERE id = '$jobId'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode([]);
}

// Close the database connection
$con->close();
?>