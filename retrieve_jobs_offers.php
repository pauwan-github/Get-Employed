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

// Query to retrieve job offers and expiration dates
$sql = "SELECT s.fname, s.lname, s.jobOffer, s.jobpost, s.jobtitle, a.exp_date 
        FROM success s
        JOIN applications a ON s.email = a.email
        WHERE s.email = '$userEmail'";
$result = $conn->query($sql);

$jobOffers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expDate = $row['exp_date'];
        $currentDateTime = date('Y-m-d H:i:s');

        // Check if the expiration date is in the future
        if (strtotime($expDate) > strtotime($currentDateTime)) {
            $jobOffers[] = [
                'fname' => $row['fname'],
                'lname' => $row['lname'],
                'jobpost' => $row['jobpost'],
                'jobtitle' => $row['jobtitle'],
                'exp_date' => $row['exp_date']
            ];
        }
    }
}

$conn->close();
?>