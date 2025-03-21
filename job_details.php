<?php
// Database connection
$conn = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the unique link from the URL
$unique_link = $_GET['link'];

// Fetch job details
$sql = "SELECT * FROM posts WHERE unique_link = '$unique_link'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $job = $result->fetch_assoc();
} else {
    die("Job not found.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <link rel="stylesheet" href="style.css">
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
    </style>
</head>
<body>
<div id="container">
        <header><img src="pics\location.png" width="30px" length="30px" >&nbsp Roysambu, Jewellery Complex Plaza, Ground Floor</header>
        <header><img src="pics\mail.png.png" width="30px" length="30px" >&nbsp getemployed@gmail.com </header>
        <header><img src="pics\tel.png.png" width="30px" length="30px" >&nbsp +2547446</header>
        <header><a href="login.html">Log Out</a></header>
    </div>
    <div id="container">
        <div class="img">
    <a href="pics/2.png"><img src="pics\2.png" width="500px" height="150px" class="img"></a></div>

    <header>
        <div id="bar">
            <ul>
                <li><a href="#" id="active">Home</a></li>
                <li>
                    <div>
                        <form method="post" action="jobsearch.php"><p><center><input type="submit" value="Available Jobs" /></center></form>
                    </div>
                </li> 
                <li><a href="gal1.html">Gallery</a></li>
                
                <li><a href="contactus.html">Contact Us</a></li>
    
                
            </ul>
            
        </div>
    </header>
    </div>
    <div class="job-page">
        <div class="container">
            <h1><?php echo $job['jobname']; ?></h1>
            <p><strong>Company:</strong> <?php echo $job['company']; ?></p>
            <p><strong>Posted Date:</strong> <?php echo $job['post_date']; ?></p>
            <p><strong>Expiry Date:</strong> <?php echo $job['exp_date']; ?></p>
            <p><strong>Email:</strong> <?php echo $job['email']; ?></p>
            <p><strong>Telephone:</strong> <?php echo $job['tel']; ?></p>
            <p><strong>Box No:</strong> <?php echo $job['box_no']; ?></p>
            <p><strong>Country:</strong> <?php echo $job['country1']; ?></p>
            <p><strong>Males Required:</strong> <?php echo $job['males']; ?></p>
            <p><strong>Females Required:</strong> <?php echo $job['females']; ?></p>
            <p><strong>Description File:</strong> <a href="<?php echo $job['descfile']; ?>">Download</a></p>
            <p><strong>Photo:</strong> <br><img src="<?php echo $job['photo']; ?>" alt="Job Photo" class="job-photo">"
            <p><a href = "<?php echo $job['unique_link']; ?>"><strong><h4>Click Here to Apply</h4></strong></a></p>
            
        </div>
    </div>

    <hr>
    <div class="con">
        <footer>
            <a href="pics/2.png"><img src="pics\2.png" width="150px" height="150px"></a>
        </footer>
        <footer>
            <strong><h3>Quick Links</h3></strong>
            <ul>
                <li><a href="#">Home</a></li>
                <li><div class="dropdown">
                    <button class="cta"><form method="post" action="jobsearch.php"><p><center><input type="submit" value="Available Jobs" /></center></form></button>
                    <div class="dropdown-content">
                        <strong><a href="healthservices.html">Inpatient</a></strong>
                    <strong><a href="outpatient.html">Outpatient</a></strong>
                    <strong><a href="clinic.html">Consultant Clinics</a></strong>
                    <strong><a href="cardiac.html">Cardiac Programs</a></strong>
                    <strong><a href="tele.html">Telemedicine</a></strong>
                    </div>
                </div></a></li>
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
</html>
?>