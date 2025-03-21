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

// Query to retrieve interview details for the logged-in user
$sql = "SELECT fname, lname, date, time, venue, requirements 
        FROM success 
        WHERE email = '$userEmail'";
$result = $conn->query($sql);

$interviews = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $interviewDateTime = $row['date'] . ' ' . $row['time'];
        $currentDateTime = date('Y-m-d H:i:s');

        // Check if the interview date and time are in the future
        if (strtotime($interviewDateTime) > strtotime($currentDateTime)) {
            $interviews[] = [
                'fname' => $row['fname'],
                'lname' => $row['lname'],
                'date' => $row['date'],
                'time' => $row['time'],
                'venue' => $row['venue'],
                'requirements' => $row['requirements']
            ];
        }
    }
}

$conn->close();
?>