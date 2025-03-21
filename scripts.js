// Example: Add interactivity to the list
document.addEventListener('DOMContentLoaded', function () {
    const jobList = document.getElementById('jobs-applied-list');
    if (jobList.children.length === 1 && jobList.children[0].textContent === 'No jobs applied yet.') {
        jobList.style.color = '#888'; // Gray out the "No jobs applied yet" message
    }
});

// Example: Add interactivity to the list
document.addEventListener('DOMContentLoaded', function () {
    const interviewList = document.getElementById('interviews-list');
    if (interviewList.children.length === 1 && interviewList.children[0].textContent === 'No upcoming interviews scheduled.') {
        interviewList.style.color = '#888'; // Gray out the "No upcoming interviews" message
    }
});

document.getElementById('profilePhotoForm').addEventListener('submit', function (e) {
    e.preventDefault();
    if (confirm("Do you want to change your profile picture?")) {
        this.submit();
    } else {
        alert("Profile picture not changed.");
    }
});

