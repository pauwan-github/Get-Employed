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

// Start session to get the logged-in user's email
session_start();
if (!isset($_SESSION['email'])) {
    die("User not logged in.");
}
$userEmail = $_SESSION['email'];

// Query to retrieve job applications for the logged-in user
$sql = "SELECT jobpost, jobtitle, companyname, cv, app_letter, ref_letter 
        FROM applications 
        WHERE email = '$userEmail'";
$result = $conn->query($sql);

$jobSearchStatus = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobSearchStatus['jobs_applied'][] = [
            'jobname' => $row['jobtitle'],
            'company' => $row['companyname'],
            'cv' => $row['cv'],
            'app_letter' => $row['app_letter'],
            'ref_letter' => $row['ref_letter']
        ];
    }
} else {
    $jobSearchStatus['jobs_applied'] = [];
}

$conn->close();
?>