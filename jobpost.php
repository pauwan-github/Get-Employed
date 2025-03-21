<?php
// Retrieve POST data from the form submission
$id = $_POST['id'] ?? '';
$jobname = $_POST['jobname'] ?? '';
$tel = $_POST['tel'] ?? '';
$alttel = $_POST['tel1'] ?? '';
$box = $_POST['box_no'] ?? '';
$location = $_POST['location'] ?? '';
$country = $_POST['country'] ?? '';
$email = $_POST['email'] ?? '';
$altemail = $_POST['email1'] ?? '';
$company = $_POST['company'] ?? '';
$post_date = $_POST['post_date'] ?? '';
$exp_date = $_POST['exp_date'] ?? '';
$no_of_positions = $_POST['no_of_positions'] ?? '';
$males = $_POST['males'] ?? '';
$females = $_POST['females'] ?? '';
$country1 = $_POST['country1'] ?? []; // Array of selected checkbox values
$editor = $_POST['editor'] ?? ''; // Retrieve the editor content
$photo = $_FILES['images'] ?? [];
$descfile = $_FILES['jobdescription'] ?? [];

// Debugging: Display editor content
echo "Editor Content Received: " . htmlspecialchars($editor) . "<br>"; // Debugging

// Convert the checkbox values to a comma-separated string (or JSON)
$country1_str = implode(", ", $country1); // Comma-separated string

// Create a new MySQLi connection to the database
$con = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");

// Check if the connection to the database was successful
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Function to handle file uploads
function uploadFile($file, $target_dir, $allowed_types, $max_size) {
    if (empty($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        echo "No file uploaded for " . $target_dir . "<br>";
        return null;
    }

    if (!isset($file['name']) || !isset($file['size'])) {
        echo "Invalid file data for " . $target_dir . "<br>";
        return null;
    }

    $target_file = $target_dir . basename($file['name']);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    if (!in_array($fileType, $allowed_types)) {
        echo "Sorry, only " . implode(", ", $allowed_types) . " files are allowed for " . $target_dir . "<br>";
        $uploadOk = 0;
    }

    if ($file['size'] > $max_size) {
        echo "Sorry, your file is too large for " . $target_dir . "<br>";
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        echo "Sorry, file already exists in " . $target_dir . "<br>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            return $target_file;
        } else {
            echo "Sorry, there was an error uploading your file to " . $target_dir . "<br>";
            return null;
        }
    } else {
        return null;
    }
}

// Upload the job description file
$doc_upload_dir = "doc_uploads/";
$allowed_doc_types = ["doc", "docx", "pdf"];
$max_doc_size = 5000000; // 5MB
$doc_file_path = uploadFile($descfile, $doc_upload_dir, $allowed_doc_types, $max_doc_size);

// Upload the photo
$img_upload_dir = "img_upload/";
$allowed_img_types = ["jpg", "jpeg", "png", "gif"];
$max_img_size = 5000000; // 5MB
$img_file_path = uploadFile($photo, $img_upload_dir, $allowed_img_types, $max_img_size);

// If both files were uploaded successfully, insert the record into the database
if ($doc_file_path || $img_file_path) {
    // Generate a unique link based on the job ID
    $unique_link = "http://localhost/Exercises/application.html?id=" . $id;

    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO posts (id, jobname, tel, tel1, box_no, place, country, email, email1, company, post_date, exp_date, no_of_positions, males, females, country1, editor, photo, descfile, unique_link) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    $stmt->bind_param("ssssssssssssssssssss", $id, $jobname, $tel, $alttel, $box, $location, $country, $email, $altemail, $company, $post_date, $exp_date, $no_of_positions, $males, $females, $country1_str, $editor, $img_file_path, $doc_file_path, $unique_link);

    if ($stmt->execute()) {
        echo "<script>
                alert('Record successfully added');
                window.location.href = 'jobpost.html';
              </script>";
    } else {
        echo "Error: " . $stmt->error; // Debugging
    }

    $stmt->close();
} else {
    echo "Sorry, there was an error uploading your files.";
}

// Close the database connection
$con->close();
?>