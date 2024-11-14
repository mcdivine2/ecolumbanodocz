<?php
include('../model/config/connection2.php'); // Include the database connection
include('../model/class_model.php'); // Correct relative path to class_model.php

header('Content-Type: application/json'); // Specify JSON output

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $conn = new class_model();

    // Call the forgot_password function
    $user_data = $conn->forgot_password($email);

    if ($user_data) {
        // Prepare email details
        $recipient = $user_data['email_address'];
        $subject = "Password Reset - Your New Password";
        $body = "Hi " . $user_data['first_name'] . " " . $user_data['middle_name'] . " " . $user_data['last_name'] . ",\n\n";
        $body .= "You forgot your password. Here is your new password: \"" . $user_data['new_password'] . "\"\n";
        $body .= "Please log in and change your password. Please contact us at 09515332633 for further clarification of your account.";

        // Use the Google Apps Script for sending email
        $url = "https://script.google.com/macros/s/AKfycbxeZj2u3vOe0nPCfRb4gNAtCdUcgh8eCWMRagQ3DRsvQRq5hn_rGnWQjSKsdLoIy62XXA/exec";
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => http_build_query([
                "recipient" => $recipient,
                "subject" => $subject,
                "body" => $body
            ])
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'A new password has been sent to your email.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send email. Please try again.']);
        }
    } else {
        // Email not found
        echo json_encode(['status' => 'error', 'message' => 'Email address not found.']);
    }
}
