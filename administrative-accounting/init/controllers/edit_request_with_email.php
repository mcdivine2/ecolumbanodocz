<?php
require_once "../model/class_model.php"; // Include model file to use class_model

// Initialize the database connection
$conn = new class_model();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input data with checks for missing data
    $control_no = isset($_POST['control_no']) ? trim($_POST['control_no']) : null;
    $student_id = isset($_POST['student_id']) ? trim($_POST['student_id']) : null;
    $document_name = isset($_POST['document_name']) ? trim($_POST['document_name']) : null;
    $date_request = isset($_POST['date_request']) ? trim($_POST['date_request']) : date('Y-m-d'); // Default to current date
    $accounting_status = isset($_POST['accounting_status']) ? trim($_POST['accounting_status']) : null;
    $request_id = isset($_POST['request_id']) ? trim($_POST['request_id']) : null;

    // Check if essential fields are provided
    if (!$control_no || !$student_id || !$document_name || !$accounting_status || !$request_id) {
        echo '<div class="alert alert-danger">Missing required fields. Please try again.</div>';
        exit;
    }

    // Update the request in the database
    $request = $conn->edit_request($control_no, $student_id, $document_name, $date_request, $accounting_status, $request_id);

    if ($request) {
        // Check if all statuses are "Verified"
        $statuses = $conn->get_statuses($request_id);
        if (
            isset($statuses['registrar_status'], $statuses['dean_status'], $statuses['library_status'], $statuses['custodian_status']) &&
            $statuses['registrar_status'] === "Verified" &&
            $statuses['dean_status'] === "Verified" &&
            $statuses['library_status'] === "Verified" &&
            $statuses['custodian_status'] === "Verified"
        ) {
            // Update accounting_status to "Waiting for Payment"
            $conn->update_accounting_status($request_id, "Waiting for Payment");
        }

        // Send email if status is "Declined"
        if ($accounting_status === "Declined") {
            $email_address = isset($_POST['email_address']) ? trim($_POST['email_address']) : null;
            $subject = isset($_POST['subject']) ? trim($_POST['subject']) : null;
            $body = isset($_POST['body']) ? trim($_POST['body']) : null;

            // Ensure email fields are provided
            if ($email_address && $subject && $body) {
                // Use Google Apps Script URL to send the email
                $url = "https://script.google.com/macros/s/AKfycbxeZj2u3vOe0nPCfRb4gNAtCdUcgh8eCWMRagQ3DRsvQRq5hn_rGnWQjSKsdLoIy62XXA/exec";
                $ch = curl_init($url);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_POSTFIELDS => http_build_query([
                        "recipient" => $email_address,
                        "subject" => $subject,
                        "body" => $body
                    ])
                ]);
                $result = curl_exec($ch);
                curl_close($ch);

                if ($result) {
                    echo '<div class="alert alert-success">Request updated and email sent successfully!</div>';
                } else {
                    echo '<div class="alert alert-warning">Request updated, but email failed to send.</div>';
                }
            } else {
                echo '<div class="alert alert-warning">Request updated, but email details are missing or incomplete.</div>';
            }
        } else {
            echo '<div class="alert alert-success">Request updated successfully!</div>';
        }

        // Redirect or reload after success
        echo '<script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
    } else {
        echo '<div class="alert alert-danger">Edit Request Failed!</div>
              <script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid request method.</div>';
}
