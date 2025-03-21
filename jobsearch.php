<?php
// Create a new MySQLi connection to the database
$con = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");

// Check if the connection to the database was successful
if ($con->connect_error) {
    // If the connection failed, stop the script and print the error
    die("Connection failed: " . $con->connect_error);
}

// Prepare the SQL query to retrieve all data from the USERS table
$sql = "SELECT company, country, tel, tel1, email, email1, box_no, place, id, jobname, males, females, country1, post_date, exp_date, descfile, photo, unique_link FROM posts";

// Execute the SQL query
$result = $con->query($sql);

// Start HTML output
echo '<!DOCTYPE html>
<html>
<head>
<title>Retrieve Data</title>
<style>
/* Apply styles for larger screens */
@media only screen and (min-width: 600px) {
    /* Adjust layout for screens wider than 600px */
    .container {
        width: 80%; /* Adjust as needed */
        margin: 0 auto;
    }
}

/* Apply styles for even larger screens */
@media only screen and (min-width: 900px) {
    /* Adjust layout for screens wider than 900px */
    .container {
        width: 60%; /* Adjust as needed */
    }
}
     #container{
            display:flex;
            margin-left: 0px;
            background-color: lightgray;
            padding-left: 50px;
            padding-bottom: 10px;
            list-style: none;
        }
        header{
            margin-left: 30px;
            padding-top: 10px;
            font-size: 18px;
            font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif;
        }
        ul{
            list-style: none;
        }

        .dropdown{
            position: relative;
            display: inline-block;
        }
        .cta{
            display: inline-block;
            padding: 10px 20px;
            background-color: skyblue;
            font-size: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: navy;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .cta:hover{
            background-color: blue;
            opacity: 1;
        }
        .dropdown-content{
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 1;
            opacity: 0.8;
        }
        .dropdown-content a{
            display: inline-block;
            padding: 10px 20px;
            font-size: 15px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .dropdown-content a:hover{
            background-color: #f2f2f2;
        }
        .dropdown:hover .dropdown-content{
            display: block;
        }
        #bar{
            margin-top: 30px;
            background-color: skyblue;
            text-align: center;
            padding-left: 5px;
            padding: 5px;
            border-radius: 5px;
            margin-left: 0px;

        }
        #bar ul li{
             display: inline-flex;  
        }
        #bar ul li a{
            text-decoration: none;
            font-weight: bold;
            padding-left: 5px;
            padding-right: 15px;
            padding-bottom: 10px;
            padding-top: 10px;
            transition: 500ms;
            margin-left: 5px;
            margin-right: 50px;
            margin-bottom: 20px;
        }
        #active{
            background-color: red;
            color: yellow;
            border-radius: 5px;
        }
        #bar ul li a:hover{
            background-color: blue;
            color: white;
            transition: 500ms;
            border-radius: 10px;
        }

        .foot{
    background-color: #333;
    color:#fff;
    text-align: center;
    margin-top: 10px;
    padding: 1px;
    position: fixed;
    bottom: 0;
    width: 100%;
}
.con{
            display:flex;
            margin-left: 0px;
            background-color: lightgray;
            padding-left: 20px;
            margin-bottom: 0px;
            list-style: none;
            margin-top: 10px;
            justify-content: space-evenly;
            margin-bottom: 60px;
            
            
        }
        footer{
            padding-top: 10px;
            padding-left: 25px;
            padding-bottom: 10px;
        }

body {
  text-align: left; /* Align text to the left */
  padding-left: 0px; /* Add 5px padding to the left */
  background-repeat: no-repeat; /* Disable image repetition */
  background-size: cover; /* Cover the entire background */
}
table {
  width: 100%;
  margin: 20px auto;
  border-collapse: collapse;
  background-color: white;
  color: black;
}
th, td {
  padding: 10px;
  border: 1px solid #ddd;
}
th {
  background-color: lightseagreen;
  color: white;
}
img {
  max-width: 100px;
  max-height: 100px;
}

/* Center the form on the page */
/* Center the form at the top of the page */
form#index {
    display: flex;
    justify-content: ;
    align-items: flex-start; /* Align to the top */
    margin: 10px;
    padding: px 20px; /* Add some padding at the top */
}

/* Style the fieldset to remove borders and padding */
form#index fieldset {
    border: none;
    padding: 0;
    margin: 0;
    display: flex;
    align-items: center; /* Align input and button vertically */
}

/* Style the input field */
form#index input[type="text"] {
    height: 40px; /* Set a fixed height */
    padding: 0 10px; /* Add some padding */
    border: 1px solid #ccc; /* Add a border */
    border-radius: 4px 0 0 4px; /* Rounded corners on the left */
    font-size: 16px;
    outline: none; /* Remove the default outline */
}

/* Style the submit button */
form#index input[type="submit"] {
    height: 42px; /* Slightly taller to match input height */
    padding: 0 20px; /* Add some padding */
    background-color: orange; /* Orange background */
    border: none; /* Remove border */
    border-radius: 0 4px 4px 0; /* Rounded corners on the right */
    color: white; /* White text */
    font-size: 16px;
    cursor: pointer; /* Change cursor to pointer on hover */
    transition: background-color 0.3s ease; /* Smooth transition for hover effect */
}

/* Change button color on hover */
form#index input[type="submit"]:hover {
    background-color: darkorange; /* Darker orange on hover */
}


/* General reset for margin and padding */
body, h1, form, div, label, select, input, button {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Center the content on the page */
#body {
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    padding: 20px;
    font-family: Arial, sans-serif;
}

/* Style the heading */
h1 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

/* Style the form container */
form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
    max-width: 400px;
}

/* Style the filter container */
.filter-container {
    margin-bottom: 20px;
    width: 100%;
}

.filter-container label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.filter-container select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

/* Style the dynamic inputs */
.dynamic-input {
    margin-bottom: 15px;
    width: 100%;
    display: none; /* Hidden by default */
}

.dynamic-input label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.dynamic-input input[type="text"],
.dynamic-input input[type="date"],
.dynamic-input select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.date-range-inputs {
    display: flex;
    gap: 10px;
}

.date-range-inputs input {
    flex: 1;
}

.radio-group {
    display: flex;
    gap: 10px;
}

.radio-group label {
    font-weight: normal;
}

/* Style the submit button */
button {
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #0056b3;
}

</style>

<script>
    // Function to convert a string to title case
    function toTitleCase(str) {
        const lowercaseWords = ["and", "or", "the", "a", "an", "in", "on", "at", "for", "with", "to", "by", "of"];
        return str
            .toLowerCase() // Convert the entire string to lowercase
            .split(" ") // Split the string into words
            .map((word, index) => {
                // Capitalize the first letter of each word, except for conjunctions (unless its the first word)
                if (index === 0 || !lowercaseWords.includes(word)) {
                    return word.charAt(0).toUpperCase() + word.slice(1);
                } else {
                    return word;
                }
            })
            .join(" "); // Join the words back into a single string
    }

    // Function to apply title case to all job names in the table
    function applyTitleCaseToJobNames() {
        const jobNameCells = document.querySelectorAll("td a"); // Select all <td> elements containing job names
        jobNameCells.forEach(cell => {
            const jobName = cell.textContent; // Get the text content of the cell
            cell.textContent = toTitleCase(jobName); // Apply title case to the job name
        });
    }

    // Run the function when the page loads
    window.onload = applyTitleCaseToJobNames;



    // JavaScript to show/hide dynamic inputs based on dropdown selection
        function showFilterInput() {
            const filterType = document.getElementById("filter_type").value;
            const dynamicInputs = document.querySelectorAll(".dynamic-input");

            // Hide all dynamic inputs
            dynamicInputs.forEach(input => input.style.display = "none");

            // Show the selected dynamic input
            if (filterType === "date_filter") {
                document.getElementById("date_filter_input").style.display = "block";
            } else if (filterType === "location") {
                document.getElementById("location_input").style.display = "block";
            } else if (filterType === "country") {
                document.getElementById("country_input").style.display = "block";
            } else if (filterType === "country1") {
                document.getElementById("country1_input").style.display = "block";
            } else if (filterType === "gender") {
                document.getElementById("gender_input").style.display = "block";
            } else if (filterType === "date_range") {
                document.getElementById("date_range_input").style.display = "block";
            }
        }
</script>
</head>
<body bgcolor="lightseagreen">
<div id="container">
        <header><img src="pics/location.png" width="30px" height="30px" >&nbsp Roysambu, Jewellery Complex Plaza, Ground Floor</header>
        <header><img src="pics/mail.png.png" width="30px" height="30px" >&nbsp getemployed@gmail.com </header>
        <header><img src="pics/tel.png.png" width="30px" height="30px" >&nbsp +2547446</header>
            <header><a href="register.html">Register</a></header>
    <header><a href="login.html">Login</a></header>
    </div>
    <div id="container">
        <div class="img">
                <a href="pics/2.png"><img src="pics/2.png" width="500px" height="150px" class="img"></a></div>

    <header>
        <div id="bar">
            <ul>
                <li><a href="http://localhost/Exercises/">Home</a></li>
                <li><div>
                    <form method="post" action="jobsearch.php"><p><center>
                        <input type="submit" value="Available Jobs" id="active"></center>
                    </form>
                    
                </div></li> 
                <li><a href="gal1.html">Gallery</a></li>
                
                <li><a href="contactus.html">Contact Us</a></li>
    
                
            </ul>
            
        </div>
    </header>
    </div>';

// Check if the query was successful
if ($result) {
    // Check if there are any results
    if ($result->num_rows > 0) {
        // Start the table
        echo '
        <form method="POST" action="filter_jobs.php" id="body">
        <!-- Dropdown for Filter Type -->
        <div class="filter-container">
            <label for="filter_type">Filter By:</label>
            <select id="filter_type" name="filter_type" onchange="showFilterInput()">
                <option value="">-- Select Filter Type --</option>
                
                    <option value="date_filter">Date Range (Oldest/Newest)</option>
                    <option value="date_range">Specific Date Range</option>
                
                
                    <option value="location">Company Location</option>
                
                    <option value="country">Company Country</option>
    
                
                    <option value="country1">Country of Placement</option>
                
                
                    <option value="gender">Gender</option>
               
            </select>
        </div>

        <!-- Dynamic Inputs -->
        <div id="date_filter_input" class="dynamic-input">
            
            <select id="date_filter" name="date_filter">
                <option value="">-- Select Date Filter --</option>
                <option value="oldest_to_newest">Oldest to Newest</option>
                <option value="newest_to_oldest">Newest to Oldest</option>
            </select>
        </div>

        <div id="date_range_input" class="dynamic-input">
            <label>Select Specific Date Range:</label>
            <div class="date-range-inputs">
                <input type="date" id="from_date" name="from_date" placeholder="From Date">
                <input type="date" id="to_date" name="to_date" placeholder="To Date">
            </div>
        </div>

        <div id="location_input" class="dynamic-input">
            <input type="text" id="location" name="location" placeholder="Enter location">
        </div>

        <div id="country_input" class="dynamic-input">
            <input type="text" id="country" name="country" placeholder="Enter Company country">
        </div>

        <div id="country1_input" class="dynamic-input">
            <input type="text" id="country1" name="country1" placeholder="Enter country of placement">
        </div>

        <div id="gender_input" class="dynamic-input">
            <div class="radio-group">
                <input type="radio" id="male" name="gender" value="male">
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female">
                <label for="female">Female</label>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit">Filter</button>
    </form>
        <form id = "index" method="post" action="searchengine.php">
        <fieldset>
          <input type="text" id = "inputIndex" size="50" name="search" placeholder = "Company Name, Job Title, Job Id, Location" required>
          <input type="submit" id = "submitIndex"value="Search" />
        </fieldset>
    </form>
               <table>
                <tr>
                  <th>Company</th>
                  <th>Telephone</th>
                  <th>Email</th>
                  <th>P.O. Box</th>
                  <th>Job ID</th>
                  <th>Job Name</th>
                  <th>No. of Positions</th>
                  <th>Country of Placement</th>
                  <th>Duration of Application</th>
                  <th>Job Description File</th>
                  <th>Photo</th>
                  <th>Apply Here</th>
                </tr>';

        // Output the data within table rows
        while($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td><b>Name:</b> <center>' . $row["company"] . ' </center><b>Location:</b> <center>' . $row["place"] . ' </center><b>Country:</b> <center>' . $row["country"] . '</center></td>
                    <td>' . $row["tel"] . ' ' . $row["tel1"] . '</td>
                    <td>' . $row["email"] . ' ' . $row["email1"] . '</td>
                    <td>' . $row["box_no"] . '</td>
                    <td><b><center>' . $row["id"] . '</center></b></td>
                    <td><a href=" ' . htmlspecialchars($row["unique_link"]) . ' " target="_blank">' . htmlspecialchars($row["jobname"]) . '</a></td>
                    <td><b>Males: </b><center>' . $row["males"] . ' </center><b>Females: </b> <center>' . $row["females"] . '</center></td>
                    <td><center>' . $row["country1"] . '</center</td>
                    <td><b><center>From:</center></b><br>' . $row["post_date"] . '<br><br><b><center>To:</center></b><br>' . $row["exp_date"] . '</td>
                    <td><a href="' . $row["descfile"] . '" target="_blank">Download</a></td>
                    <td><img src="' . $row["photo"] . '" alt="Job Photo"></td>
                    <td><a href="' . $row["unique_link"] . '" target="_blank">Click Here to Apply</a></td>
                  </tr>';
        }
        echo '</table>
         <hr>
    <div class="con">
        <footer>
            <a href="pics/2.png"><img src="pics\2.png" width="150px" height="150px"></a>
        </footer>
        <footer>
            <strong><h3>Quick Links</h3></strong>
            <ul>
                <li><a href="http://localhost/Exercises/">Home</a></li>
                <li><div>
                        <form method="post" action="jobsearch.php">
                            <p><input type="submit" value="Available Jobs" id="active">
                        </form>
                    </div>
                </li>
                
                        
                <li><a href="gal1.html">Gallery</a></li>
                <li><a href="contactus.html">Contact Us</a></li>
            </ul>
        </footer>
        <footer><strong><h3>Contact Us</h3></strong>
        Get Employed<br>Jewel Complex, Roysambu<br>PO BOX 1212-00100, Nairobi,<br>Kenya<br>TEL: +254 7953<br>+254 7446<br>getemployed@gmail.com
        </footer>
    <footer><strong><h3>Socials</h3></strong>
    <ul>
        
        <li><a href=""><img src="pics\IG.png.png" width="20px" length="20px"> Instagram</a></li>
        <li><a href=""><img src="pics\fb.png.png" width="20px" length="20px"> Facebook</a></li>
        <li><a href=""><img src="pics\twitt.png.png" width="20px" length="20px"> Twitter</a></li>
        <li><a href=""><img src="pics\app.png.png" width="20px" length="20px"> Whatsapp</a></li>
    </ul></footer>
    </div>
        <div class="foot">
            <p>&copy 2025 Get Employed. All rights reserved</p>
        </div>';
    } else {
        // If no results found, output a message
        echo '<p style="color: white;">No records found.</p>';
    }
} else {
    // If there was an error with the query, print the error
    echo '<p style="color: white;">Error: ' . $con->error . '</p>';
}

// Close the HTML output
echo '</body></html>';

// Close the database connection
$con->close();
?>