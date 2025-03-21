// Function to track inactivity and log out the user
let inactivityTime = function () {
    let time;

    // Reset the timer on user activity
    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(logout, 1800000); // 30 minutes = 1,800,000 milliseconds
    }

    // Logout function
    function logout() {
        fetch('logout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ action: 'logout' })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'login.html'; // Redirect to login page
                }
            });
    }

    // Event listeners to reset the timer on user activity
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onclick = resetTimer;
    document.onscroll = resetTimer;
};

// Function to check session validity
function checkSession() {
    fetch('logout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: 'check_session' })
    })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert(data.message);
                window.location.href = 'login.html'; // Redirect to login page
            }
        });
}

// Start tracking inactivity
inactivityTime();

// Check session every 5 minutes
setInterval(checkSession, 300000); // 300,000 milliseconds = 5 minutes

// Add event listener for logout button
document.getElementById('logoutBtn').addEventListener('click', function () {
    fetch('logout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: 'logout' })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'login.html'; // Redirect to login page
            }
        });
});