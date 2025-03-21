document.addEventListener('DOMContentLoaded', () => {
    let visibleJobs = 6;
    const jobListings = document.getElementById('job-listings');
    const seeMoreButton = document.getElementById('see-more');
    const jobTable = document.getElementById('job-table');

    // List of prepositions and conjunctions to exclude from title case
    const excludedWords = ['a', 'an', 'the', 'and', 'or', 'but', 'for', 'nor', 'as', 'at', 'by', 'in', 'of', 'on', 'to', 'with'];

    // Function to convert a string to title case, excluding prepositions and conjunctions
    function toTitleCase(str) {
        return str.toLowerCase().split(' ').map((word, index) => {
            if (index !== 0 && excludedWords.includes(word)) {
                return word;
            }
            return word.charAt(0).toUpperCase() + word.slice(1);
        }).join(' ');
    }

    // Fetch job data from the server
    fetch('get_jobs.php')
        .then(response => response.json())
        .then(data => {
            // Display the first 6 jobs in the job listings
            displayJobListings(data.slice(0, visibleJobs));

            // Display all jobs in the table
            displayJobTable(data);

            // Handle "See More" button click
            seeMoreButton.addEventListener('click', () => {
                visibleJobs += 6;
                displayJobListings(data.slice(0, visibleJobs));
                if (visibleJobs >= data.length) {
                    seeMoreButton.style.display = 'none';
                }
            });
        })
        .catch(error => console.error('Error fetching jobs:', error));

    // Function to display jobs in the job listings
    function displayJobListings(jobs) {
        jobListings.innerHTML = jobs.map(job => `
            <a href="job_details.php?link=${job.unique_link}">${toTitleCase(job.jobname)}</a>
        `).join('');
    }

    // Function to display jobs in the table
    function displayJobTable(jobs) {
        let row;
        jobs.forEach((job, index) => {
            if (index % 1 === 0) {
                row = document.createElement('tr');
                jobTable.appendChild(row);
            }

            const cell = document.createElement('td');
            cell.innerHTML = `
                <a href="job_details.php?link=${job.unique_link}">
                    <img src="${job.photo}" alt="${job.jobname}">
                    <div class="job-info">
                        <p>Job ID: ${job.id}</p>
                        <p><strong>${job.jobname}</strong></p>
                        <p>Location: ${job.place}</p>
                        <p>Expires: ${job.exp_date}</p>
                    </div>
                </a>
            `;
            row.appendChild(cell);
        });
    }
});