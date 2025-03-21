<?php
// Database connection
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

// Start session to get the logged-in user's company
session_start();
if (!isset($_SESSION['email'])) {
    die("User not logged in.");
}
$userEmail = $_SESSION['email'];

// Retrieve the company of the logged-in user
$sql = "SELECT company FROM users WHERE email = '$userEmail'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $company = $user['company'];
} else {
    die("User not found.");
}

// Retrieve job posts
$sql = "SELECT id, jobname, post_date, exp_date, males, females, descfile 
        FROM posts 
        WHERE LOWER(company) = LOWER('$company')";
$jobPosts = $conn->query($sql);

// Retrieve job applications
$sql = "SELECT jobpost, jobtitle, idno, fname, lname, gender, email, tel, cv, app_letter, applicantphoto 
        FROM applications 
        WHERE LOWER(companyname) = LOWER('$company')";
$jobApplications = $conn->query($sql);

// Handle search
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idno'])) {
    $idno = $_POST['idno'];
    $sql = "SELECT jobpost, jobtitle, idno, fname, lname, gender, email, tel, cv, app_letter, applicantphoto 
            FROM applications 
            WHERE idno = '$idno' AND LOWER(companyname) = LOWER('$company')";
    $searchResults = $conn->query($sql);
}

// Handle interview scheduling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date'])) {
    $idno = $_POST['idno'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];
    $requirements = $_POST['requirements'];

    $sql = "INSERT INTO success (jobpost, jobtitle, idno, fname, lname, gender, email, tel, cv, app_letter, applicantphoto, date, time, venue, requirements)
            SELECT jobpost, jobtitle, idno, fname, lname, gender, email, tel, cv, app_letter, applicantphoto, '$date', '$time', '$venue', '$requirements'
            FROM applications
            WHERE idno = '$idno'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Interview scheduled successfully.');</script>";
    } else {
        echo "<script>alert('Error scheduling interview: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>