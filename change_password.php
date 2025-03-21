<?php
session_start();
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

$servername = "sql8.freesqldatabase.com";
$username = "sql8768844";
$password = "mTEXIPAw7m";
$dbname = "sql8768844";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword === $confirmPassword) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $email = $_SESSION['reset_email'];
        $sql = "UPDATE users SET password = '$hashedPassword', verificationCode = NULL WHERE email = '$email'";
        if ($conn->query($sql)) {
            session_destroy();
            header("Location: login.html");
            exit();
        } else {
            echo "Error updating password.";
        }
    } else {
        echo "Passwords do not match.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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
    #contain {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 8px 8px 12px rgba(0, 0, 0, 0.1);
}

/* Form Heading */
#contain h2 {
    text-align: center;
    font-size: 24px;
    color: navy;
    margin-bottom: 20px;
}

/* Form Input Fields */
#contain input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
}


#contain input[type="password"]:focus {
    border-color: skyblue;
    outline: none;
    box-shadow: 0 0 5px rgba(135, 206, 235, 0.5);
}


/* Submit Button */
#contain button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: skyblue;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    color: navy;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#contain button[type="submit"]:hover {
    background-color: blue;
    color: white;
}

/* Login Link */
#contain p {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
    color: #333;
}

#contain p a {
    color: navy;
    text-decoration: none;
}

#contain p a:hover {
    text-decoration: underline;
}
    </style>
</head>
<body>
<div id="container" bgcolor="mint">
        <header><img src="pics/location.png" width="30px" height="30px" >&nbsp Roysambu, Jewellery Complex Plaza, Ground Floor</header>
        <header><img src="pics/mail.png.png" width="30px" height="30px" >&nbsp getemployed@gmail.com </header>
        <header><img src="pics/tel.png.png" width="30px" height="30px" >&nbsp +2547446</header>
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
                        <input type="submit" value="Available Jobs" /></center>
                    </form>
                </div></li> 
                <li><a href="gal1.html">Gallery</a></li>
                <li><a href="contactus.html">Contact Us</a></li>    
            </ul>
        </div>
    </header>
    </div>
    
<div id="contain">
<form method="post">
        <h2>Change Password</h2>
        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" id="newPassword" required>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" id="confirmPassword" required>
        <button type="submit">Change Password</button>
        <p>Go back to <a href="login.html">login</a></p>
    </form>
</div>

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
</html>