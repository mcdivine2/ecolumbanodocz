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

	// Execute the update query
	$requestUpdated = $conn->edit_request(
		$control_no,
		$student_id,
		$document_name,
		$date_request,
		$date_releasing,
		$processing_officer,
		$status,
		$request_id
	);

	if ($requestUpdated) {
		// Check statuses and update accounting_status if necessary
		$statuses = $conn->get_statuses($request_id);

		if (
			$statuses['registrar_status'] === "Verified" &&
			$statuses['dean_status'] === "Verified" &&
			$statuses['library_status'] === "Verified" &&
			$statuses['custodian_status'] === "Verified"
		) {
			// Update accounting_status to "Waiting for Payment"
			$conn->update_accounting_status($request_id, "Waiting for Payment");
		}

		// Prepare and send the email
		$email = trim($_POST['email_address']);
		$subject = trim($_POST['subject']);
		$body = trim($_POST['body']);

		// Google Apps Script URL for email sending
		$url = "https://script.google.com/macros/s/AKfycbxeZj2u3vOe0nPCfRb4gNAtCdUcgh8eCWMRagQ3DRsvQRq5hn_rGnWQjSKsdLoIy62XXA/exec";
		$emailSent = send_email($url, $email, $subject, $body);

		if ($emailSent) {
			echo '<div class="alert alert-success" style="text-align: center; margin-top: 100px; font-size: 20px;"><b>Request updated and email sent successfully!</b></div>';
			echo '<script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
		} else {
			echo '<div class="alert alert-danger" style="text-align: center; margin-top: 100px; font-size: 20px;"><b>Request updated but failed to send email. Please try again.</b></div>';
		}
	} else {
		echo '<div class="alert alert-danger">Failed to update request. Please try again.</div>';
	}
}

/**
 * Sends an email using a Google Apps Script endpoint.
 *
 * @param string $url The Google Apps Script URL.
 * @param string $recipient The recipient's email address.
 * @param string $subject The email subject.
 * @param string $body The email body content.
 * @return bool True if email sent successfully, False otherwise.
 */
function send_email($url, $recipient, $subject, $body)
{
	$ch = curl_init($url);
	curl_setopt_array($ch, [
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => http_build_query([
			"recipient" => $recipient,
			"subject"   => $subject,
			"body"      => $body,
			"headers"   => "Content-Type: text/html; charset=UTF-8"
		])
	]);

	$result = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$curlError = curl_error($ch);
	curl_close($ch);

	return ($httpCode === 200 && !$curlError);
}
