<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new class_model();

    // Trim input values
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $complete_address = trim($_POST['complete_address']);
    $price = str_replace('₱', '', trim($_POST['price']));
    $birthdate = trim($_POST['birthdate']);
    $course = trim($_POST['course']);
    $email_address = trim($_POST['email_address']);
    $control_no = trim($_POST['control_no']);
    $date_request = trim($_POST['date_request']);
    $mode_request = trim($_POST['mode_request']);
    $student_id = trim($_POST['student_id']);

    // Array inputs
    $document_names = $_POST['document_name'] ?? [];
    $no_ofcopies = $_POST['no_ofcopies'] ?? [];
    $purposes = $_POST['purpose'] ?? [];
    $request_types = $_POST['request_type'] ?? [];

    // Initialize status fields
    $registrar_status = "Pending";
    $custodian_status = "Pending";
    $dean_status = " ";
    $library_status = "Pending";
    $accounting_status = "Pending";

    // Input validation
    $errors = [];

    // Required fields validation
    if (empty($first_name)) $errors[] = 'First name is required!';
    if (empty($middle_name)) $errors[] = 'Middle name is required!';
    if (empty($last_name)) $errors[] = 'Last name is required!';
    if (empty($complete_address)) $errors[] = 'Complete address is required!';
    if (empty($birthdate)) $errors[] = 'Birthdate is required!';
    if (empty($course)) $errors[] = 'Course is required!';
    if (empty($email_address)) $errors[] = 'Email address is required!';
    if (empty($request_types)) $errors[] = 'Request type is required!';
    if (empty($control_no)) $errors[] = 'Control number is required!';
    if (empty($date_request)) $errors[] = 'Date request is required!';
    if (empty($mode_request)) $errors[] = 'Mode of request is required!';
    if (empty($student_id)) $errors[] = 'Student ID is required!';
    if (empty($purposes)) $errors[] = 'At least one purpose is required!';

    // Check if document names, copies, and request types match
    if (count($document_names) !== count($no_ofcopies)) {
        $errors[] = 'Document names and copies mismatch!';
    }
    if (count($document_names) !== count($request_types)) {
        $errors[] = 'Document names and request types mismatch!';
    }

    // Validate email format
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address!';
    }

    // Handle file upload and check if the image is required
    if (empty($_FILES["upload_recent"]["name"])) {
        $errors[] = 'Recent image is required!';
    } else {
        $recent_image = null;
        if ($_FILES["upload_recent"]["error"] === UPLOAD_ERR_OK) {
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/student/student_uploads/";
            $file_name = uniqid() . '-' . basename($_FILES["upload_recent"]["name"]);
            $target_file = $target_dir . $file_name;

            // Check if the file is a valid image or PDF
            $file_type = mime_content_type($_FILES["upload_recent"]["tmp_name"]);
            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];

            if (in_array($file_type, $allowed_types)) {
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }

                if (move_uploaded_file($_FILES["upload_recent"]["tmp_name"], $target_file)) {
                    $recent_image = "student_uploads/" . $file_name;
                } else {
                    $errors[] = 'Failed to upload file!';
                }
            } else {
                $errors[] = 'Invalid file type! Only JPG, PNG, and PDF files are allowed.';
            }
        }
    }

    // If there are validation errors, display them
    if (!empty($errors)) {
        echo '<div class="alert alert-danger">' . implode('<br>', $errors) . '</div>';
        exit;
    }

    // Process requests
    $documents = [];
    $request_type_entries = [];
    foreach ($document_names as $index => $document_name) {
        $copies = $no_ofcopies[$index] ?? 1;
        $request_type = $request_types[$index] ?? null;

        // Handle "other (please specify)" input if applicable
        $other_input_name = 'other_specify_' . ($index + 1);
        if ($request_type === 'other' && !empty(trim($_POST[$other_input_name]))) {
            $request_type = "other: " . trim($_POST[$other_input_name]);
        }

        if (empty($request_type)) {
            $errors[] = "Request type is missing for document $document_name.";
            break;
        }

        $documents[] = "$document_name (x$copies)";
        $request_type_entries[] = ($index + 1) . ". $request_type";
    }

    if (!empty($errors)) {
        echo '<div class="alert alert-danger">' . implode('<br>', $errors) . '</div>';
        exit;
    }

    $document_string = implode("<br>", $documents);
    $request_type_string = implode("<br>", $request_type_entries);

    $request = $conn->add_request(
        $first_name,
        $middle_name,
        $last_name,
        $complete_address,
        $birthdate,
        $course,
        $email_address,
        $control_no,
        $document_string,
        $price,
        $request_type_string,
        $date_request,
        $registrar_status,
        $custodian_status,
        $dean_status,
        $library_status,
        $accounting_status,
        implode(", ", $purposes),
        $mode_request,
        $student_id,
        $recent_image
    );

    if ($request) {
        echo '<div class="alert alert-success">Request added successfully!</div>';
        echo '<script>setTimeout(function() { window.history.go(-1); }, 1000);</script>';
    } else {
        echo '<div class="alert alert-danger">Failed to add request. Please try again.</div>';
        echo '<script>setTimeout(function() { window.history.go(-1); }, 1000);</script>';
    }
}
?>
