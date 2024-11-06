<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$conn = new class_model();

	// Retrieve and sanitize input data
	$control_no = trim($_POST['control_no']);
	$student_id = trim($_POST['student_id']);
	$document_name = trim($_POST['document_name']);
	$date_request = trim($_POST['date_request']);
	$date_releasing = trim($_POST['date_releasing']);
	$processing_officer = trim($_POST['processing_officer']);
	$status = trim($_POST['status']);
	$request_id = trim($_POST['request_id']);

	// Execute the update query first
	$request = $conn->edit_request($control_no, $student_id, $document_name, $date_request, $date_releasing, $processing_officer, $status, $request_id);

	if ($request) {
		// If update is successful, prepare and send the email
		$email = trim($_POST['email_address']);
		$subject = trim($_POST['subject']);
		$body = trim($_POST['body']);

		// Define Google Apps Script URL
		$url = "https://script.google.com/macros/s/AKfycbxeZj2u3vOe0nPCfRb4gNAtCdUcgh8eCWMRagQ3DRsvQRq5hn_rGnWQjSKsdLoIy62XXA/exec";

		// Initialize cURL
		$ch = curl_init($url);
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query([
				"recipient" => $email,
				"subject"   => $subject,
				"body"      => $body,
				"headers"   => "Content-Type: text/html; charset=UTF-8"
			])
		]);

		// Execute the cURL request to send the email
		$result = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curlError = curl_error($ch);
		curl_close($ch);

		// Check if the email was sent successfully
		if ($httpCode == 200 && !$curlError) {
			echo '<div class="alert alert-success" style="text-align: center; margin-top: 100px; font-size: 20px;"><b>Request updated and email sent successfully!</b></div>';
			echo '<script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
		} else {
			// If email fails, provide a detailed error message
			$errorMessage = $curlError ? "cURL Error: $curlError" : "HTTP Error Code: $httpCode";
			echo '<div class="alert alert-danger" style="text-align: center; margin-top: 100px; font-size: 20px;">';
			echo '<b>Request updated but failed to send email. Please try again.</b><br>';
			echo '<small>' . htmlspecialchars($errorMessage) . '</small></div>';
		}
	} else {
		// If the update request fails
		echo '<div class="alert alert-danger">Failed to update request. Please try again.</div>';
	}
}
