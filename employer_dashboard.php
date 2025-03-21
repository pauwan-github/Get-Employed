<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['userType'] !== 'employer') {
    header('Location: login.html');
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

// Fetch user details
$userId = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();


// Retrieve job posts
$company = $user['company'];
$sql = "SELECT id, jobname, post_date, exp_date, males, females, descfile 
        FROM posts 
        WHERE LOWER(company) = LOWER('$company')";
$jobPosts = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <style>
        
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 0px;
}
        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .dashboard-container h1 {
            color: #333;
        }
        .logout-button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 1120px;
            margin-bottom: 0;
        }
        .logout-button:hover {
            background-color: #c82333;
            
        }
        header {
    background-color: skyblue;
    color: #fff;
    padding: 20px;
    text-align: center;
}

header button {
    background-color: #fff;
    color: #0073b1;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
}

header button:hover {
    background-color: #f0f0f0;
}

section {
    background-color: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

table th, table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

table th {
    background-color: skyblue;
    color: #fff;
}

button {
    background-color: #0073b1;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background-color: #005f8d;
}

textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
}
input[type="date"],
input[type="time"],
input[type="text"],
textarea {
    width: 25%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
}

input[type="date"]:focus,
input[type="time"]:focus,
input[type="text"]:focus,
textarea:focus {
    border-color: #0073b1;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 115, 177, 0.5);
}

textarea {
    resize: vertical;
    min-height: 100px;
}
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($user['firstName']); ?>!</h1>
        <p>Last Login: <?php echo htmlspecialchars($user['lastLogin']); ?></p>
        <button class="logout-button" onclick="logout()">Logout</button>
    </div>

    <header>
        <h1>Employer Dashboard</h1>
        <a href="jobpost.html"><button>Post a Job</button></a>
    </header>

    <section id="jobPosts">
        <h2>Job Posts</h2>
        <table id="jobPostsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Job Name</th>
                    <th>Post Date</th>
                    <th>Expiry Date</th>
                    <th>Males</th>
                    <th>Females</th>
                    <th>Description File</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamically populated by PHP -->
            </tbody>
        </table>
        <button id="showMoreJobPosts">Show More</button>
        <button id="showLessJobPosts" style="display: none;">Show Less</button>
    </section>

    <section id="jobApplications">
        <h2>Job Applications</h2>
        <table id="jobApplicationsTable">
            <thead>
                <tr>
                    <th>Job Post</th>
                    <th>Job Title</th>
                    <th>ID No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>CV</th>
                    <th>Application Letter</th>
                    <th>Applicant Photo</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamically populated by PHP -->
            </tbody>
        </table>
        <button id="showMoreJobApplications">Show More</button>
        <button id="showLessJobApplications" style="display: none;">Show Less</button>
    </section>

    <section id="searchApplicant">
        <h2>Search Applicant</h2>
        <form id="searchForm">
            <input type="text" id="idno" name="idno" placeholder="Enter ID No" required>
            <button type="submit">Search</button>
        </form>
        <table id="searchResultsTable">
            <thead>
                <tr>
                    <th>Job Post</th>
                    <th>Job Title</th>
                    <th>ID No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>CV</th>
                    <th>Application Letter</th>
                    <th>Applicant Photo</th>
                </tr>
            </thead>
            <?php if ($jobPosts->num_rows > 0): ?>
                    <?php while ($row = $jobPosts->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['jobname']); ?></td>
                            <td><?php echo htmlspecialchars($row['post_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['exp_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['males']); ?></td>
                            <td><?php echo htmlspecialchars($row['females']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($row['descfile']); ?>" target="_blank">View File</a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No job posts found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <section id="scheduleInterview">
        <h2>Schedule Interview</h2>
        <form id="interviewForm">
            <input type="date" id="date" name="date" required>
            <input type="time" id="time" name="time" required>
            <input type="text" id="venue" name="venue" placeholder="Venue" required>
            <textarea id="requirements" name="requirements" placeholder="Requirements"></textarea><br>
            <button type="submit">Schedule Interview</button>
        </form>
    </section>

    <script src="scrpts.js"></script>








    <script>
        function logout() {
            fetch('logout.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'login.html';
                    }
                });
        }

        // Auto-logout after 30 minutes of inactivity
        let inactivityTime = 0;
        const logoutTime = 30 * 60 * 1000; // 30 minutes

        function resetInactivityTime() {
            inactivityTime = 0;
        }

        setInterval(() => {
            inactivityTime += 1000;
            if (inactivityTime >= logoutTime) {
                logout();
            }
        }, 1000);

        document.addEventListener('mousemove', resetInactivityTime);
        document.addEventListener('keypress', resetInactivityTime);
    </script>
</body>
</html>