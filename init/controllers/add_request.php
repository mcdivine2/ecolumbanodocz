<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new class_model();

    function sanitize($data)
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    $studentID_no = sanitize($_POST['studentID_no']);
    $first_name = sanitize($_POST['first_name']);
    $middle_name = sanitize($_POST['middle_name']);
    $last_name = sanitize($_POST['last_name']);
    $complete_address = sanitize($_POST['complete_address']);
    $email_address = sanitize($_POST['email_address']);
    $course = sanitize($_POST['course']);
    $civil_status = sanitize($_POST['civil_status']);
    $last_term = sanitize($_POST['last_term']);
    $control_no = sanitize($_POST['control_no']);
    $student_id = sanitize($_POST['student_id']);
    $total_price = filter_var(str_replace('₱', '', $_POST['total_price']), FILTER_VALIDATE_FLOAT);
    $document_names = $_POST['document_name'] ?? [];
    $no_ofcopies = $_POST['copies'] ?? [];
    $purposes = $_POST['purpose'] ?? [];
    $request_types = $_POST['request_type'] ?? []; // This comes as a flat array

    $registrar_status = "Pending";
    $custodian_status = "TBA";
    $library_status = "TBA";
    $accounting_status = "TBA";

    $dean_status = "TBA"; // Default value
    $date_request = date("Y-m-d H:i:s");

    $errors = [];
    if (empty($course)) $errors[] = 'Course is required.';
    if (empty($civil_status)) $errors[] = 'Civil Status is required.';
    if (empty($last_term)) $errors[] = 'Last Term is required.';
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
    if (!is_numeric($total_price)) $errors[] = 'Invalid total price.';

    $recent_image = "Not Required";

    if (!empty($_FILES['photo_attachment']['name'])) {
        foreach ($_FILES['photo_attachment']['name'] as $index => $fileName) {
            if ($_FILES['photo_attachment']['error'][$index] === UPLOAD_ERR_OK) {
                $target_dir = __DIR__ . "/../../student/student_uploads/";
                $file_name = uniqid() . '-' . basename($fileName);
                $target_file = $target_dir . $file_name;
                $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];

                if (in_array(mime_content_type($_FILES['photo_attachment']['tmp_name'][$index]), $allowed_types)) {
                    if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
                    if (move_uploaded_file($_FILES['photo_attachment']['tmp_name'][$index], $target_file)) {
                        $recent_image = "student/student_uploads/" . $file_name;
                    } else {
                        $errors[] = "Failed to upload file: $fileName.";
                    }
                } else {
                    $errors[] = "Invalid file type for $fileName. Only JPG, PNG, and PDF are allowed.";
                }
            }
        }
    } else {
        if (in_array("Honorable Dismissal w/ TOR for evaluation", $document_names)) {
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

    $price = $total_price;
    $request = $conn->add_request(
        $studentID_no,
        $first_name,
        $middle_name,
        $last_name,
        $complete_address,
        $email_address,
        $course,
        $civil_status,
        $last_term,
        $control_no,
        implode("<br>", $documents),
        $price,
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
