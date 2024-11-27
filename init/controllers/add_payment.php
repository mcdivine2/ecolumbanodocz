<?php
// Include your database connection and model
require_once "../model/class_model.php";

$conn = new class_model(); // Initialize your model class with the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from POST request and sanitize inputs
    $control_no = isset($_POST['control_no']) ? trim($_POST['control_no']) : '';
    $modeof_payment = isset($_POST['modeof_payment']) ? trim($_POST['modeof_payment']) : '';
    $or_no = isset($_POST['or_no']) ? trim($_POST['or_no']) : 'Not Included'; // Default value
    $trace_no = isset($_POST['trace_no']) ? trim($_POST['trace_no']) : 'Not Included'; // Default value
    $ref_no = isset($_POST['ref_no']) ? trim($_POST['ref_no']) : 'Not Included'; // Default value
    $document_name = isset($_POST['document_name']) ? trim($_POST['document_name']) : '';
    $date_ofpayment = isset($_POST['date_ofpayment']) ? trim($_POST['date_ofpayment']) : ''; // Ensure date_ofpayment is captured
    $total_amount = isset($_POST['total_amount']) ? trim($_POST['total_amount']) : '';
    $student_id = trim($_POST['student_id']);

    // Adjust logic based on mode of payment
    if ($modeof_payment === "PalawanPay") {
        $or_no = 'Not Included'; // Set OR # as Not Included
    } elseif ($modeof_payment === "Onsite Pay") {
        $trace_no = 'Not Included'; // Set Trace No. and Ref. No. as Not Included
        $ref_no = 'Not Included';
    }

    // Initialize accounting status
    $accounting_status = "Paid";

    // Handle file upload for payment proof
    if (isset($_FILES["proof_ofpayment"]) && $_FILES["proof_ofpayment"]["error"] === UPLOAD_ERR_OK) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/student/student_uploads/";
        $file_name = uniqid() . '-' . basename($_FILES["proof_ofpayment"]["name"]);
        $target_file = $target_dir . $file_name;

        // Check if the file is a valid image
        $check = getimagesize($_FILES["proof_ofpayment"]["tmp_name"]);
        if ($check !== false) {
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            if (move_uploaded_file($_FILES["proof_ofpayment"]["tmp_name"], $target_file)) {
                $proof_ofpayment = "student_uploads/" . $file_name;

                // Call the add_payment method
                if (method_exists($conn, 'add_payment') && $conn->add_payment($modeof_payment, $or_no, $trace_no, $ref_no, $control_no, $document_name, $date_ofpayment, $total_amount, $proof_ofpayment, $student_id, $accounting_status)) {
                    echo '<div class="alert alert-success">Payment recorded successfully!</div>';
                    echo '<script>setTimeout(function() { window.history.go(-1); }, 1000);</script>';
                } else {
                    echo '<div class="alert alert-danger">Failed to record payment. Please try again.</div>';
                    echo '<script>setTimeout(function() { window.history.go(-1); }, 1000);</script>';
                }
            } else {
                echo '<div class="alert alert-danger">Failed to move uploaded file.</div>';
                echo '<script>setTimeout(function() { window.history.go(-1); }, 1000);</script>';
            }
        } else {
            echo '<div class="alert alert-danger">File is not a valid image.</div>';
            echo '<script>setTimeout(function() { window.history.go(-1); }, 1000);</script>';
        }
    } else {
        echo '<div class="alert alert-danger">No proof of payment uploaded or upload error.</div>';
        echo '<script>setTimeout(function() { window.history.go(-1); }, 1000);</script>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid request method.</div>';
    echo '<script>setTimeout(function() { window.history.go(-1); }, 1000);</script>';
}
