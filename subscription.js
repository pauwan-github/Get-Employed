document.addEventListener('DOMContentLoaded', () => {
    const subscriptionForm = document.getElementById('subscription-form');
    const subscriptionMessage = document.getElementById('subscription-message');

    subscriptionForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = document.getElementById('email').value;

        fetch('subscription.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                subscriptionMessage.textContent = 'Subscription successful!';
                subscriptionMessage.style.color = '#28a745';
            } else {
                subscriptionMessage.textContent = 'Subscription failed. Please try again.';
                subscriptionMessage.style.color = '#dc3545';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            subscriptionMessage.textContent = 'An error occurred. Please try again.';
            subscriptionMessage.style.color = '#dc3545';
        });
    });
});