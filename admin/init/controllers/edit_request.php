<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$conn = new class_model();

	// Retrieve and sanitize input data
	$control_no = trim($_POST['control_no']);
	$studentID_no = trim($_POST['studentID_no']);
	$document_name = trim($_POST['document_name']);
	$date_request = trim($_POST['date_request']);
	$date_releasing = isset($_POST['date_releasing']) ? $_POST['date_releasing'] : null;
	$status = trim($_POST['status']);
	$request_id = trim($_POST['request_id']);
	$request_type = isset($_POST['request_type']) ? trim($_POST['request_type']) : '';
	$email = trim($_POST['email_address']);
	$subject = "Request Update for $document_name";



	// Initialize default statuses
	$custodian_status = null;
	$library_status = null;
	$accounting_status = null;

	// If the status is "Released", set specific statuses and prepare email body
	if ($status === "Released") {
		$registrar_status = "Released";
		$custodian_status = "Verified";
		$library_status = "Verified";
		$dean_status = (preg_match("/CPA BOARD EXAM/i", $request_type)) ? "Verified" : "Not Included";
		$accounting_status = "Verified";
		$body = "Hello,<br><br>Your request for <b>$document_name</b> has been marked as <b>Released</b>.<br>";
		$body .= "Please collect it on or after <b>$date_releasing</b>. Reference number: <b>$control_no</b>.<br><br>Thank you.";
	} elseif ($status === "Verified") {
		$registrar_status = "Verified";
		$custodian_status = "Pending";
		$library_status = "Pending";
		// Determine the dean_status based on the request_type
		$dean_status = (preg_match("/CPA BOARD EXAM/i", $request_type)) ? "Pending" : "Not Included";
		$accounting_status = "Pending";
		$body = "Hello,<br><br>Your request for <b>$document_name</b> has been <b>Verified</b>.<br>";
		$body .= "You will receive further updates regarding its processing. Reference number: <b>$control_no</b>.<br><br>Thank you.";
	} elseif ($status === "Processing") {
		$registrar_status = "Processing";
		$custodian_status = "Verified";
		$library_status = "Verified";
		$dean_status = (preg_match("/CPA BOARD EXAM/i", $request_type)) ? "Verified" : "Not Included";
		$accounting_status = "Verified";
		$body = "Hello,<br><br>Your request for <b>$document_name</b> has been <b>Processing</b>.<br>";
		$body .= "You will receive further updates regarding its processing. Reference number: <b>$control_no</b>.<br><br>Thank you.";
	} elseif ($status === "To Be Release") {
		$registrar_status = "To Be Release";


		// Debugging variables
		error_log("date_releasing: " . $date_releasing);
		error_log("request_id: " . $request_id);
		// Check if date_releasing is set
		if (empty($date_releasing)) {
			die("Error: 'date_releasing' is required.");
		}


		// Fetch the maximum queue number for the same releasing date
		$sql_fetch_queue = "SELECT MAX(queue_number) AS max_queue FROM tbl_documentrequest WHERE date_releasing = ?";
		$stmt_fetch_queue = $conn->conn->prepare($sql_fetch_queue);
		if (!$stmt_fetch_queue) {
			die("Prepare Error: " . $conn->conn->error);
		}

		$stmt_fetch_queue->bind_param("s", $date_releasing);
		if (!$stmt_fetch_queue->execute()) {
			die("Execute Error: " . $stmt_fetch_queue->error);
		}

		$result_queue = $stmt_fetch_queue->get_result();
		if (!$result_queue) {
			die("Result Error: " . $stmt_fetch_queue->error);
		}

		$queue_data = $result_queue->fetch_assoc();
		$max_queue = isset($queue_data['max_queue']) ? $queue_data['max_queue'] : 0;
		$queue_number = $max_queue + 1;

		// Debugging queue number
		error_log("Queue number: " . $queue_number);

		// Update the queue number in the database
		$sql_update_queue = "UPDATE tbl_documentrequest SET queue_number = ? WHERE request_id = ?";
		$stmt_update_queue = $conn->conn->prepare($sql_update_queue);
		if (!$stmt_update_queue) {
			die("Prepare Error (Update): " . $conn->conn->error);
		}

		$stmt_update_queue->bind_param("ii", $queue_number, $request_id);
		if (!$stmt_update_queue->execute()) {
			die("Execute Error (Update): " . $stmt_update_queue->error);
		}

		$custodian_status = "Verified";
		$library_status = "Verified";
		$dean_status = (preg_match("/CPA BOARD EXAM/i", $request_type)) ? "Verified" : "Not Included";
		$accounting_status = "Verified";
		$body = "Hello,<br><br>Your request for <b>$document_name</b> has been marked as <b>To Be Release</b>.<br>";
		$body .= "Your queue number is <b>$queue_number</b> for release on <b>$date_releasing</b>.<br>";
		$body .= "Reference number: <b>$control_no</b>.<br><br>Thank you.";
	}


	// Call the edit_request function with the required parameters
	$requestUpdated = $conn->edit_request(
		$control_no,
		$studentID_no,
		$document_name,
		$date_request,
		$date_releasing,
		$registrar_status,
		$custodian_status,
		$library_status,
		$dean_status,
		$accounting_status,
		$request_id
	);

	// Check if the request was updated successfully
	if ($requestUpdated) {
		// Send the email using Google Apps Script
		$url = "https://script.google.com/macros/s/AKfycbxeZj2u3vOe0nPCfRb4gNAtCdUcgh8eCWMRagQ3DRsvQRq5hn_rGnWQjSKsdLoIy62XXA/exec";
		$emailSent = send_email($url, $email, $subject, $body);

		// Display appropriate messages based on email sending status
		if ($emailSent) {
			echo '<div class="alert alert-success" style="text-align: center; margin-top: 100px; font-size: 20px;"><b>Request updated and email sent successfully!</b></div>';
			echo '<script> setTimeout(function() { window.history.go(-2); }, 1000); </script>';
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
