<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new class_model();

    // Sanitize and validate inputs
    function sanitize($data)
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    $first_name = sanitize($_POST['first_name']);
    $middle_name = sanitize($_POST['middle_name']);
    $last_name = sanitize($_POST['last_name']);
    $complete_address = sanitize($_POST['complete_address']);
    $birthdate = sanitize($_POST['birthdate']);
    $course = sanitize($_POST['course']);
    $email_address = sanitize($_POST['email_address']);
    $control_no = sanitize($_POST['control_no']);
    $student_id = sanitize($_POST['student_id']);
    $total_price = filter_var(str_replace('₱', '', $_POST['total_price']), FILTER_VALIDATE_FLOAT);

    $document_names = $_POST['document_name'] ?? [];
    $no_ofcopies = $_POST['copies'] ?? [];
    $purposes = $_POST['purpose'] ?? [];
    $request_types = $_POST['request_type'] ?? [];

    $registrar_status = "Pending";
    $custodian_status = "Pending";
    $dean_status = "Pending";
    $library_status = "Pending";
    $accounting_status = "Pending";

    $date_request = date("Y-m-d H:i:s");

    $errors = [];
    if (empty($course)) $errors[] = 'Course is required.';
    if (empty($purposes)) $errors[] = 'Purpose is required.';
    if (empty($birthdate)) $errors[] = 'Birthdate is required.';
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
    if (!is_numeric($total_price)) $errors[] = 'Invalid total price.';

    $recent_image = "Not Required";

    if (in_array("Honorable Dismissal w/ TOR for evaluation", $document_names)) {
        if (isset($_FILES["upload_recent"]) && $_FILES["upload_recent"]["error"] === UPLOAD_ERR_OK) {
            $target_dir = __DIR__ . "/../../student/student_uploads/";
            $file_name = uniqid() . '-' . basename($_FILES["upload_recent"]["name"]);
            $target_file = $target_dir . $file_name;
            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];

            if (in_array(mime_content_type($_FILES["upload_recent"]["tmp_name"]), $allowed_types)) {
                if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
                if (move_uploaded_file($_FILES["upload_recent"]["tmp_name"], $target_file)) {
                    $recent_image = "student/student_uploads/" . $file_name;
                } else {
                    $errors[] = 'Failed to upload file.';
                }
            } else {
                $errors[] = 'Invalid file type. Only JPG, PNG, and PDF are allowed.';
            }
        } else {
            $errors[] = 'Recent image is required for "Honorable Dismissal w/ TOR for evaluation".';
        }
    }

    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
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

    echo json_encode([
        'status' => $request ? 'success' : 'error',
        'message' => $request ? 'Request added successfully!' : 'Failed to add request. Please try again.'
    ]);
}
