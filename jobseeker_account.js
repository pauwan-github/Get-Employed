document.addEventListener('DOMContentLoaded', function () {
    // Logout functionality
    document.getElementById('logoutBtn').addEventListener('click', function () {
        fetch('logout.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'login.html'; // Redirect to login page
                }
            })
            .catch(error => {
                console.error('Error during logout:', error);
            });
    });

    // Display data on the dashboard
    displayJobSearchStatus(<?php echo json_encode($jobSearchStatus); ?>);
    displayRecommendedJobs(<?php echo json_encode($recommendedJobs); ?>);
    displayRecentActivity(<?php echo json_encode($recentActivity); ?>);
});

function displayJobSearchStatus(status) {
    const container = document.getElementById('jobSearchStatus');
    let html = `<h3>Jobs Applied To: ${status.jobs_applied.length}</h3>`;
    html += `<h3>Interviews Scheduled: ${status.interviews_scheduled.length}</h3>`;
    html += `<h3>Job Offers Received: ${status.job_offers.length}</h3>`;
    container.innerHTML = html;
}

function displayRecommendedJobs(jobs) {
    const container = document.getElementById('recommendedJobs');
    let html = '<ul>';
    jobs.forEach(job => {
        html += `<li>${job.jobname} (ID: ${job.id})</li>`;
    });
    html += '</ul>';
    container.innerHTML = html;
}

function displayRecentActivity(activity) {
    const container = document.getElementById('recentActivity');
    let html = '<h3>Recently Viewed Jobs</h3><ul>';
    activity.recently_viewed.forEach(job => {
        html += `<li>${job.jobname} (${job.company})</li>`;
    });
    html += '</ul><h3>Application Updates</h3><ul>';
    activity.application_updates.forEach(update => {
        html += `<li>${update.jobname}: ${update.progress}</li>`;
    });
    html += '</ul>';
    container.innerHTML = html;
}