<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: login.html');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "Paul8927!";
$dbname = "jobs";

// Create connection
$conn = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");

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

// Function to fetch job search status
function getJobSearchStatus($userId, $conn) {
    $status = [];

    // Number of jobs applied to
    $sql = "SELECT jobname, id, company FROM dashboard WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $status['jobs_applied'] = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Number of interviews scheduled
    $sql = "SELECT jobtitle, date, time, venue, requirements FROM success WHERE idno = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $status['interviews_scheduled'] = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Number of job offers received
    $sql = "SELECT jobname, id, descfile, males, females, photo FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $status['job_offers'] = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $status;
}

// Function to fetch recommended jobs
function getRecommendedJobs($userId, $conn) {
    $sql = "SELECT jobname, id FROM posts";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $jobs = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $jobs;
}

// Function to fetch recent activity
function getRecentActivity($userId, $conn) {
    $activity = [];

    // Recently viewed jobs
    $sql = "SELECT jobname, id, company FROM posts WHERE id = ? ORDER BY id DESC LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $activity['recently_viewed'] = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Application updates
    $sql = "SELECT jobtitle, progress FROM success WHERE idno = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $activity['application_updates'] = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $activity;
}

// Fetch all data
$jobSearchStatus = getJobSearchStatus($userId, $conn);
$recommendedJobs = getRecommendedJobs($userId, $conn);
$recentActivity = getRecentActivity($userId, $conn);

// Close the connection after all database operations are complete
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link rel="stylesheet" href="jobseeker_account.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
    color: #333;
}

/* Header */
header {
    background-color: #0073b1;
    color: #fff;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header h1 {
    font-size: 24px;
}

.logout-button {
    background-color: #ff4b4b;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
}

.logout-button:hover {
    background-color: #ff1c1c;
}

/* Navigation */
nav {
    background-color: #fff;
    padding: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

nav ul {
    list-style: none;
    display: flex;
    justify-content: space-around;
}

nav ul li a {
    text-decoration: none;
    color: #0073b1;
    font-weight: bold;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

nav ul li a:hover {
    background-color: #0073b1;
    color: #fff;
}

/* Main Content */
main {
    padding: 20px;
}

section {
    background-color: #fff;
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

section h2 {
    font-size: 22px;
    margin-bottom: 15px;
    color: #0073b1;
}

section h3 {
    font-size: 18px;
    margin-top: 10px;
    margin-bottom: 10px;
    color: #333;
}

ul {
    list-style: none;
    padding-left: 20px;
}

ul li {
    margin-bottom: 10px;
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 5px;
    border: 1px solid #ddd;
}

/* Buttons in Quick Actions */
#quick-actions button {
    background-color: #0073b1;
    color: #fff;
    border: none;
    padding: 10px 20px;
    margin: 5px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

#quick-actions button:hover {
    background-color: #005f8d;
}

/* Responsive Design */
@media (max-width: 768px) {
    nav ul {
        flex-direction: column;
        align-items: center;
    }

    nav ul li a {
        display: block;
        width: 100%;
        text-align: center;
    }

    #quick-actions {
        display: flex;
        flex-direction: column;
    }

    #quick-actions button {
        width: 100%;
        margin: 5px 0;
    }
}
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($user['firstName']); ?>!</h1>
        <button id="logoutBtn" class="logout-button" onclick="logout()">Logout</button>
    </header>
    <nav>
        <ul>
            <li><a href="jobseeker_account.html">Dashboard</a></li>
            <li><a href="#profile">Profile</a></li>
        </ul>
    </nav>
    <main>
        <section id="dashboard">
            <h2>Dashboard</h2>
            <div id="dashboardContent">
            <main>
        <section id="job-search-status">
            <h2>Job Search Status</h2>
            <div id="jobSearchStatus">
                <h3>Jobs Applied</h3>
                <ul id="jobs-applied-list">
    <?php if (!empty($jobSearchStatus['jobs_applied'])): ?>
        <?php foreach ($jobSearchStatus['jobs_applied'] as $job): ?>
            <li>
                <strong>Job Title:</strong> <?php echo htmlspecialchars($job['jobname']); ?><br>
                <strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?><br>
                <strong>CV:</strong> <?php echo htmlspecialchars($job['cv']); ?><br>
                <strong>Application Letter:</strong> <?php echo htmlspecialchars($job['app_letter']); ?><br>
                <strong>Reference Letter:</strong> <?php echo htmlspecialchars($job['ref_letter']); ?>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>No jobs applied yet.</li>
    <?php endif; ?>
</ul>
                <h3>Interviews Scheduled</h3>
                <ul id="interviews-list">
    <?php if (!empty($interviews)): ?>
        <?php foreach ($interviews as $interview): ?>
            <li>
                Hello, <strong><?php echo htmlspecialchars($interview['fname']); ?> <?php echo htmlspecialchars($interview['lname']); ?></strong>, 
                you are invited for a job interview at <strong><?php echo htmlspecialchars($interview['venue']); ?></strong> 
                on <strong><?php echo htmlspecialchars($interview['date']); ?></strong> at <strong><?php echo htmlspecialchars($interview['time']); ?></strong>. 
                Kindly carry the following: <strong><?php echo htmlspecialchars($interview['requirements']); ?></strong>. 
                Congratulations on your successful application!
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>No upcoming interviews scheduled.</li>
    <?php endif; ?>
</ul>

                <h3>Job Offers Received</h3>
                <ul id="job-offers-list">
    <?php if (!empty($jobOffers)): ?>
        <?php foreach ($jobOffers as $offer): ?>
            <li>
                Hello <strong><?php echo htmlspecialchars($offer['fname']); ?> <?php echo htmlspecialchars($offer['lname']); ?></strong>, 
                there's an opening <strong><?php echo htmlspecialchars($offer['jobpost']); ?></strong> 
                where there's a vacant position for a <strong><?php echo htmlspecialchars($offer['jobtitle']); ?></strong> 
                that you may be interested in. If interested, please apply before <strong><?php echo htmlspecialchars($offer['exp_date']); ?></strong>.
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>No active job offers available.</li>
    <?php endif; ?>
</ul>
            </div>
        </section>
        <section id="recommended-jobs">
            <h2>Recommended Jobs</h2>
            <div id="recommendedJobs">
                <ul>
                    <?php foreach ($recommendedJobs as $job): ?>
                        <li><?php echo htmlspecialchars($job['jobname']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
        <section id="recent-activity">
            <h2>Recent Activity</h2>
            <div id="recentActivity">
                <h3>Recently Viewed Jobs</h3>
                <ul>
                    <?php foreach ($recentActivity['recently_viewed'] as $job): ?>
                        <li><?php echo htmlspecialchars($job['jobname']); ?> - <?php echo htmlspecialchars($job['company']); ?></li>
                    <?php endforeach; ?>
                </ul>
                <h3>Application Updates</h3>
                <ul>
                    <?php foreach ($recentActivity['application_updates'] as $update): ?>
                        <li><?php echo htmlspecialchars($update['jobname']); ?> - <?php echo htmlspecialchars($update['progress']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
        <section id="notifications">
            <h2>Notifications</h2>
            <div id="notificationsContent"></div>
        </section>
        <section id="quick-actions">
            <h2>Quick Actions</h2>
            
            <a href="jobsearch.php"><button id="searchJobsBtn">Search Jobs</button></a>
            <a href="application.html"><button id="applyJobsBtn">Apply for Jobs</button></a>
        </section>
    </main>

            </div>
        </section>
        <section id="profile">
            <h2>Profile</h2>
            <div id="profileContent">
            <?php if (!empty($user)): ?>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <?php else: ?>
        <p>No user data found.</p>
    <?php endif; ?>
            </div>
        </section>
       
    </main>
    
   
    <script src="jobseeker_accoun.js"></script>

    <script>
        function logout() {
            fetch('logout.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'jobseeker_dashboard.php';
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
    <script src="scripts.js"></script>
</body>
</html>