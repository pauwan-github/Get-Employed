<?php
// Retrieve data from the submission form
$fname = $_POST['fname'] ?? '';
$lname = $_POST['lname'] ?? '';
$mname = $_POST['mname'] ?? '';
$gender = $_POST['gender'] ?? '';
$tel = $_POST['tel'] ?? '';
$alttel = $_POST['alttel'] ?? '';
$id = $_POST['idno'] ?? '';
$email = $_POST['email'] ?? '';
$idfront = $_FILES['idfront'] ?? [];
$idback = $_FILES['idback'] ?? [];
$companyname = $_POST['companyname'] ?? '';
$jobtitle = $_POST['jobtitle'] ?? '';
$no_of_experience = $_POST['no_of_experience'] ?? '';
$referee = $_POST['referee'] ?? '';
$refemail = $_POST['refemail'] ?? '';
$reftel = $_POST['reftel'] ?? '';
$jobpost = $_POST['job-id'] ?? ''; // Retrieve the job ID from the hidden input field
$refletter = $_FILES['refletter'] ?? [];
$post_experience = $_POST['post_experience'] ?? '';
$cv = $_FILES['cv'] ?? [];
$app_letter = $_FILES['app_letter'] ?? [];
$applicantphoto = $_FILES['applicantphoto'] ?? [];

// Connection to the database
$con = new mysqli("sql8.freesqldatabase.com", "sql8768844", "mTEXIPAw7m", "sql8768844");

// Checking if the connection was successful
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Function to handle file uploads
function upload_file($file, $target_dir, $allowed_types, $max_size) {
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

// Upload idfront photo
$img_upload_dir = "idphotos/";
$allowed_image_types = ["jpg", "jpeg", "png"];
$max_img_size = 5000000; // 5MB
$img_file_path = upload_file($idfront, $img_upload_dir, $allowed_image_types, $max_img_size);
if ($_FILES['idfront']['error'] !== UPLOAD_ERR_OK) {
    echo "Error uploading ID front photo: " . $_FILES['idfront']['error'] . "<br>";
}

// Upload idback photo
$imgUploadDir = "idphotos/";
$allowedImageTypes = ["jpg", "jpeg", "png"];
$maxImgSize = 5000000; // 5MB
$imgFilePath = upload_file($idback, $imgUploadDir, $allowedImageTypes, $maxImgSize);
if ($_FILES['idback']['error'] !== UPLOAD_ERR_OK) {
    echo "Error uploading ID back photo: " . $_FILES['idback']['error'] . "<br>";
}

// Upload applicant photo
$applicant_upload_dir = "idphotos/";
$allowed_applicantImage_types = ["jpg", "jpeg", "png"];
$max_applicant_img_size = 5000000; // 5MB
$applicant_img_file_path = upload_file($applicantphoto, $applicant_upload_dir, $allowed_applicantImage_types, $max_applicant_img_size);
if ($_FILES['applicantphoto']['error'] !== UPLOAD_ERR_OK) {
    echo "Error uploading applicant photo: " . $_FILES['applicantphoto']['error'] . "<br>";
}

// Upload CV
$cv_upload_dir = "applicationdocs/";
$allowed_cv_types = ["pdf", "docx", "doc"];
$max_cv_size = 10000000; // 10MB
$cv_file_path = upload_file($cv, $cv_upload_dir, $allowed_cv_types, $max_cv_size);
if ($_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
    echo "Error uploading CV: " . $_FILES['cv']['error'] . "<br>";
}

// Upload application letter
$application_letter_upload_dir = "applicationdocs/";
$allowed_application_files_types = ["pdf", "docx", "doc"];
$allowed_application_size = 10000000; // 10MB
$application_file_path = upload_file($app_letter, $application_letter_upload_dir, $allowed_application_files_types, $allowed_application_size);
if ($_FILES['app_letter']['error'] !== UPLOAD_ERR_OK) {
    echo "Error uploading application letter: " . $_FILES['app_letter']['error'] . "<br>";
}

// Upload reference letter
$reference_letter_upload_dir = "applicationdocs/";
$allowed_reference_letter_type = ["pdf", "docx", "doc"];
$reference_letter_size = 10000000; // 10MB
$reference_letter_file_path = upload_file($refletter, $reference_letter_upload_dir, $allowed_reference_letter_type, $reference_letter_size);
if ($_FILES['refletter']['error'] !== UPLOAD_ERR_OK) {
    echo "Error uploading reference letter: " . $_FILES['refletter']['error'] . "<br>";
}

// If id front, id back, applicant photo, cv, and application letter are uploaded successfully, insert the record into the database
if ($img_file_path && $imgFilePath && $applicant_img_file_path && $cv_file_path && $application_file_path) {
    $sql = "INSERT INTO applications (idno, fname, lname, mname, gender, email, tel, alttel, idfront, idback, companyname, jobtitle, no_of_experience, referee, refemail, reftel, refletter, jobpost, post_experience, cv, app_letter, applicantphoto)
            VALUES ('$id', '$fname', '$lname', '$mname', '$gender', '$email', '$tel', '$alttel', '$img_file_path', '$imgFilePath', '$companyname', '$jobtitle', '$no_of_experience', '$referee', '$refemail', '$reftel', '$reference_letter_file_path', '$jobpost', '$post_experience', '$cv_file_path', '$application_file_path', '$applicant_img_file_path')";

    if ($con->query($sql) === TRUE) {
        echo "<script>
                alert('Hello! {$fname} {$lname}, your application has been submitted successfully.');
                window.location.href = 'jobsearch.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error; // Debugging
    }
} else {
    echo "Sorry, there was an error uploading your files.";
}

// Close the database connection
$con->close();
?>