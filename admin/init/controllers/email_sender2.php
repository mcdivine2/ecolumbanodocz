<?php
if (isset($_POST['submit'])) {
    // Check if required fields are provided
    if (isset($_POST['email_address'], $_POST['subject'], $_POST['body'])) {
        $email = $_POST['email_address'];
        $subject = $_POST['subject'];
        $body = $_POST['body'];

        // Define Google Apps Script URL
        $url = "https://script.google.com/macros/s/AKfycbxeZj2u3vOe0nPCfRb4gNAtCdUcgh8eCWMRagQ3DRsvQRq5hn_rGnWQjSKsdLoIy62XXA/exec";

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => http_build_query([
                "recipient" => $email,
                "subject"   => $subject,
                "body"      => $body,
                "headers"   => "Content-Type: text/html; charset=UTF-8"
            ])
        ]);

        // Execute the cURL request
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Check if the cURL request was successful
        if ($httpCode == 200 && !$curlError) {
            echo '<div class="alert alert-success" style="text-align: center; margin-top: 100px; font-size: 20px;"><b>Email Sent Successfully!</b></div>';
            echo '<script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
        } else {
            // Detailed error message
            $errorMessage = $curlError ? "cURL Error: $curlError" : "HTTP Error Code: $httpCode";
            echo '<div class="alert alert-danger" style="text-align: center; margin-top: 100px; font-size: 20px;">';
            echo '<b>Failed to Send Email. Please try again.</b><br>';
            echo '<small>' . htmlspecialchars($errorMessage) . '</small></div>';
        }
    } else {
        echo '<div class="alert alert-danger" style="text-align: center; margin-top: 100px; font-size: 20px;"><b>Required data missing. Please ensure all fields are filled.</b></div>';
    }
}
?>
