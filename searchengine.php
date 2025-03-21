<?php
// Retrieve the search term from the form submission
$search = $_POST['search'] ?? '';

// Create a new MySQLi connection to the database
$con = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");

// Check if the connection to the database was successful
if ($con->connect_error) {
    // If the connection failed, stop the script and print the error
    die("Connection failed: " . $con->connect_error);
}

// Prepare the SQL query to retrieve data from the posts table
// Use the LIKE operator to search for matches in jobname, company, or id
$sql = "SELECT company, country, tel, tel1, email, email1, box_no, place, id, jobname, males, females, country1, post_date, exp_date, descfile, photo, unique_link 
        FROM posts 
        WHERE jobname LIKE ? 
           OR company LIKE ? 
           OR id LIKE ?";

// Prepare the statement
$stmt = $con->prepare($sql);

if ($stmt) {
    // Add wildcards to the search term for partial matching
    $searchTerm = "%$search%";

    // Bind the search term to the placeholders
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Start HTML output
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Job Details</title>
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
            }
            table {
                border-collapse: collapse;
                width: 80%;
                margin: auto;
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

             /* Center the form on the page */
/* Center the form at the top of the page */
form#index {
    display: flex;
    justify-content: center;
    align-items: flex-start; /* Align to the top */
    margin: 0;
    padding: 20px 0; /* Add some padding at the top */
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
        <form id = "index" method="post" action="searchengine.php">
        <fieldset>
          <input type="text" id = "inputIndex" size="50" name="search" placeholder = "Company Name, Job Title, Job Id, Location" required>
          <input type="submit" id = "submitIndex"value="Search" />
        </fieldset>
    </form>
        
            <legend style="color: black;">JOB DETAILS</legend>';

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
                    <th>No. of Positions:</th>
                    <th>Country of Placement</th>
                    <th>Application Duration</th>
                    <th>Job Description File</th>
                    <th>Photo</th>
                    <th>Apply Here</th>
                </tr>';

        // Output the data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td><b>Company:</b><br>' . htmlspecialchars($row["company"]) . '<br><b>Country:</b><br>' . htmlspecialchars($row["country"]) . '<br><b>Location:</b><br>' . htmlspecialchars($row["place"]) . '</td>
                    <td>' . htmlspecialchars($row["tel"]) . ' ' . htmlspecialchars($row["tel1"]) . '</td>
                    <td>' . htmlspecialchars($row["email"]) . ' ' . htmlspecialchars($row["email1"]) . '</td>
                    <td>' . htmlspecialchars($row["box_no"]) . '</td>
                    <td>' . htmlspecialchars($row["id"]) . '</td>
                    <td><a href=" ' . htmlspecialchars($row["unique_link"]) . ' " target="_blank">' . htmlspecialchars($row["jobname"]) . '</a></td>
                    <td><b>Males:</b><center>' . htmlspecialchars($row["males"]) . '</center><b>Females:</b><center>' . htmlspecialchars($row["females"]) . '</center></td>
                    <td>' . htmlspecialchars($row["country1"]) . '</td>
                    <td><b>From</b><br><br>' . htmlspecialchars($row["post_date"]) . '<br><br><b>To</b><br><br> ' . htmlspecialchars($row["exp_date"]) . '</td>
                    <td><a href="' . htmlspecialchars($row["descfile"]) . '" target="_blank">Download</a></td>
                    <td><img src="' . htmlspecialchars($row["photo"]) . '" alt="Job Photo" style="max-width: 100px; max-height: 100px;"></td>
                    <td><a href "' . htmlspecialchars($row["unique_link"]) . '" target="_blank">Click here to apply</a></td>
                  </tr>';
        }
        echo '</table>';
    } else {
        // If no results found, output a message
        echo '<p>No results found for the search term: ' . htmlspecialchars($search) . '</p>';
    }

    // Close the fieldset and HTML body
    echo '

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
                            <p><center><input type="submit" value="Available Jobs"></center>
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