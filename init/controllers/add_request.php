<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new class_model();

    // Sanitize inputs
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $complete_address = trim($_POST['complete_address']);
    $birthdate = trim($_POST['birthdate']);
    $course = trim($_POST['course']);
    $email_address = trim($_POST['email_address']);
    $control_no = trim($_POST['control_no']);
    $student_id = trim($_POST['student_id']);
    $total_price = str_replace('₱', '', trim($_POST['total_price']));

    $document_names = $_POST['document_name'] ?? [];
    $no_ofcopies = $_POST['copies'] ?? [];
    $purposes = $_POST['purpose'] ?? [];
    $request_types = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'request_type_') === 0) {
            $request_types[] = $value;
        }
    }

    // Status fields
    $registrar_status = "Pending";
    $custodian_status = "Pending";
    $dean_status = "Pending";
    $library_status = "Pending";
    $accounting_status = "Pending";

    // Capture current date and time
    $date_request = date("Y-m-d H:i:s");

    $errors = [];
    if (empty($course)) $errors[] = 'Course is required!';
    if (empty($purposes)) $errors[] = 'Purpose is required!';
    if (empty($birthdate)) $errors[] = 'Birthdate is required!';

    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address!';

    $recent_image = "Not Required";

    // Handle specific document file upload
    if (in_array("Honorable Dismissal w/ TOR for evaluation", $document_names)) {
        if ($_FILES["upload_recent"]["error"] === UPLOAD_ERR_OK) {
            $target_dir = __DIR__ . "/../../student/student_uploads/";
            $file_name = uniqid() . '-' . basename($_FILES["upload_recent"]["name"]);
            $target_file = $target_dir . $file_name;
            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];

            if (in_array(mime_content_type($_FILES["upload_recent"]["tmp_name"]), $allowed_types)) {
                if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
                if (move_uploaded_file($_FILES["upload_recent"]["tmp_name"], $target_file)) {
                    $recent_image = "student/student_uploads/" . $file_name;
                } else {
                    $errors[] = 'Failed to upload file!';
                }
            } else {
                $errors[] = 'Invalid file type! Only JPG, PNG, and PDF files are allowed.';
            }
        } else {
            $errors[] = 'Recent image is required for "Honorable Dismissal w/ TOR for evaluation" requests!';
        }
    }

    if (!empty($errors)) {
        echo '<div class="alert alert-danger">' . implode('<br>', $errors) . '</div>';
        exit;
    }

    // Format document data
    $documents = [];
    foreach ($document_names as $index => $document_name) {
        $copies = $no_ofcopies[$index] ?? 1;
        $request_type = $request_types[$index] ?? '';
        $documents[] = "$document_name (x$copies)";
    }

    $request = $conn->add_request(
        $first_name,
        $middle_name,
        $last_name,
        $complete_address,
        $birthdate,
        $course,
        $email_address,
        $control_no,
        implode("<br>", $documents),
        $total_price,
        implode("<br>", $request_types),
        $registrar_status,
        $custodian_status,
        $dean_status,
        $library_status,
        $accounting_status,
        implode(", ", $purposes),
        $student_id,
        $recent_image,
        $date_request
    );

    echo $request
        ? '<div class="alert alert-success">Request added successfully!</div>'
        : '<div class="alert alert-danger">Failed to add request. Please try again.';
}
