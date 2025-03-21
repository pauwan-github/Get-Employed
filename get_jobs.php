<?php
// Database connection
$conn = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all jobs
$sql = "SELECT id, jobname, place, exp_date, photo, unique_link FROM posts";
$result = $conn->query($sql);

$jobs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }
}

echo json_encode($jobs);

$conn->close();
?>