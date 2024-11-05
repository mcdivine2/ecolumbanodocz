<?php
require_once "../model/class_model.php";

function createRandomIDnumber()
{
    $chars = "003232303232023232023456789";
    srand((float)microtime() * 1000000);
    $i = 0;
    $ran = '';
    while ($i <= 7) {
        $num = rand() % strlen($chars);
        $tmp = substr($chars, $num, 1);
        $ran = $ran . $tmp;
        $i++;
    }
    return $ran;
}

if (isset($_POST)) {
    $conn = new class_model();

    // Validate and sanitize input fields
    $studentID_no = isset($_POST['studentID_no']) ? trim($_POST['studentID_no']) : null; // Optional field

    // Only generate a new ID if the user did not provide one
    if (empty($studentID_no)) {
        $studentID_no = createRandomIDnumber();
    }

    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $complete_address = trim($_POST['complete_address']);
    $email_address = trim($_POST['email_address']);
    $mobile_number = trim($_POST['mobile_number']);
    $status = "Active";
    $is_highschool = "No";

    // Check if file is uploaded
    if (isset($_FILES['id_upload']) && $_FILES['id_upload']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['id_upload']['tmp_name'];
        $file_name = addslashes($_FILES['id_upload']['name']);
        $file_size = $_FILES['id_upload']['size'];
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/Online-Document-Request-System-main/student/student_uploads/";

        // Ensure the upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $upload_file = $upload_dir . $file_name;

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($file_tmp_path, $upload_file)) {
            // File path to store in the database
            $id_upload = "student_uploads/" . $file_name;

            // Insert student information into the database
            $stud = $conn->register($studentID_no, $first_name, $middle_name, $last_name, $complete_address, $email_address, $mobile_number, $id_upload, $status, $is_highschool);

            if ($stud == TRUE) {
                echo '<div class="alert alert-success">Student Registered Successfully!</div><script> setTimeout(function() { window.location.reload(); }, 1000); </script>';
            } else {
                echo '<div class="alert alert-danger">Registration Failed!</div>';
                echo "Error: " . $conn->error;
            }
        } else {
            echo '<div class="alert alert-danger">Failed to move uploaded file.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">No file uploaded or upload error.</div>';
    }
}
