<?php
// Initialize variables to avoid "Undefined variable" warnings
$types = ''; // String to hold parameter types
$params = []; // Array to hold parameters for binding

// Retrieve filter inputs from the form
$dateFilter = $_POST['date_filter'] ?? '';
$location = $_POST['location'] ?? '';
$country = $_POST['country'] ?? '';
$country1 = $_POST['country1'] ?? '';
$gender = $_POST['gender'] ?? '';

// Create a new MySQLi connection to the database
$con = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");

// Check if the connection to the database was successful
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Base SQL query
$sql = "SELECT company, country, tel, tel1, email, email1, box_no, place, id, jobname, males, females, country1, post_date, exp_date, descfile, photo, unique_link 
        FROM posts 
        WHERE 1=1"; // 1=1 is a placeholder to simplify adding conditions

// Add filters based on user input
if (!empty($location)) {
    $sql .= " AND place LIKE ?";
    $params[] = "%$location%";
    $types .= 's'; // 's' for string
}

if (!empty($country)) {
    $sql .= " AND country LIKE ?";
    $params[] = "%$country%";
    $types .= 's'; // 's' for string
}

if (!empty($country1)) {
    $sql .= " AND country1 LIKE ?";
    $params[] = "%$country1%";
    $types .= 's'; // 's' for string
}

if (!empty($gender)) {
    if ($gender === 'male') {
        $sql .= " AND males > 0";
    } elseif ($gender === 'female') {
        $sql .= " AND females > 0";
    }
}

// Add date filter
if (!empty($dateFilter)) {
    if ($dateFilter === 'oldest_to_newest') {
        $sql .= " ORDER BY post_date ASC";
    } elseif ($dateFilter === 'newest_to_oldest') {
        $sql .= " ORDER BY post_date DESC";
    }
}

// Prepare the statement
$stmt = $con->prepare($sql);

if ($stmt) {
    // Bind parameters if any
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Start HTML output
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Filtered Job Details</title>
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
                text-align: center;
                background-repeat: no-repeat;
                background-size: cover;
                color: white;
                font-family: Arial, sans-serif;
            }
            .filter-container {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        select, input, button {
            margin-bottom: 10px;
            padding: 5px;
        }
        .dynamic-input {
            display: none; /* Hide dynamic inputs by default */
        }
        .radio-group {
            display: flex;
            gap: 10px; /* Space between radio buttons */
            margin-left: 550px;
        }
        .date-range-inputs {
            display: block;
            gap: 10px; /* Space between date inputs */
        }
            table {
                border-collapse: collapse;
                width: 80%;
                margin:20, auto;
                background-color: white;
                color: black;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
            }
            th {
                background-color: lightseagreen;
                color: white;
            }

            /* General reset for margin and padding */
#body, h1, form, div, label, select, input, button {
    margin: 10;
    padding: 0px;
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
    </div>


    <form method="POST" action="filter_jobs.php">
        <!-- Dropdown for Filter Type -->
        <div class="filter-container">
            <label for="filter_type">Filter By:</label>
            <select id="filter_type" name="filter_type" onchange="showFilterInput()">
                <option value="">-- Select Filter Type --</option>
                
                    <option value="date_filter">Date Range (Oldest/Newest)</option>
                    <option value="date_range">Specific Date Range</option>
                    <option value="location">Companies Location</option>
                    <option value="country">Companies Country</option>
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
            <input type="text" id="country" name="country" placeholder="Enter Companies country">
        </div>
        <div id="country1_input" class="dynamic-input">
            <input type="text" id="country1" name="country1" placeholder="Enter country of placement">
        </div>
        <div id="gender_input" class="dynamic-input">
            <div class="radio-group">
                <label for="male">Male</label>
                <input type="radio" id="male" name="gender" value="male">
                <label for="female">Female</label>
                <input type="radio" id="female" name="gender" value="female">
                
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit">Filter</button>
    </form>

        <fieldset style="width: 80%; margin: auto; padding: 20px;">
            <legend style="color: black;">FILTERED JOB DETAILS</legend>';

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Start the table
        echo '<table>
                <tr>
                    <th>Company</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th>P.O. Box</th>
                    <th>Job ID</th>
                    <th>Job Name</th>
                    <th>No. of Positions</th>
                    <th>Country of Placement</th>
                    <th>Applicatio Duration</th>
                    <th>Job Description File</th>
                    <th>Photo</th>
                    <th>Job Description</th>
                </tr>';

        // Output the data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td><b>Company:</b><br><center>' . htmlspecialchars($row["company"]) . '</center><br><b>Country</b><br><center>' . htmlspecialchars($row["country"]) . '</center><br><b>Location:</b> <br><center>' . htmlspecialchars($row["place"]) . '</center>.</td>
                    <td>' . htmlspecialchars($row["tel"]) . ' ' . htmlspecialchars($row["tel1"]) . '</td>
                    <td>' . htmlspecialchars($row["email"]) . ' ' . htmlspecialchars($row["email1"]) . '</td>
                    <td>' . htmlspecialchars($row["box_no"]) . '</td>
                    <td>' . htmlspecialchars($row["id"]) . '</td>
                    <td><a href=" ' . htmlspecialchars($row["unique_link"]) . ' " target="_blank">' . htmlspecialchars($row["jobname"]) . '</a></td>
                    <td><b>Males:</b><center>' . htmlspecialchars($row["males"]) . ' <b>Females:</b><center>' . htmlspecialchars($row["females"]) . '</center></center></td>
                    <td>' . htmlspecialchars($row["country1"]) . '</td>
                    <td><b><center>From:</center></b><br>' . $row["post_date"] . '<br><br><b><center>To:</center></b><br>' . $row["exp_date"] . '</td>
                    <td><a href="' . htmlspecialchars($row["descfile"]) . '" target="_blank">Download</a></td>
                    <td><img src="' . htmlspecialchars($row["photo"]) . '" alt="Job Photo" style="max-width: 100px; max-height: 100px;"></td>
                    <td><a href "' . htmlspecialchars($row["unique_link"]) . '" target="_blank">Click here to apply</a></td>
                  </tr>';
        }
        echo '</table>';
    } else {
        // If no results found, output a message
        echo '<p>No results found for the selected filters.</p>';
    }

    // Close the fieldset and HTML body
    echo '</fieldset>

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
                            <p><center><input type="submit" value="Available Jobs" /></center>
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
        </div>
    </body>
    </html>';

    // Close the statement
    $stmt->close();
} else {
    echo '<p>Error preparing statement: ' . htmlspecialchars($con->error) . '</p>';
}

// Close the database connection
$con->close();
?>