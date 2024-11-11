<?php
require_once "../model/class_model.php";

if (isset($_POST)) {
	$conn = new class_model();

	// Retrieve and sanitize input data
	$control_no = trim($_POST['control_no']);
	$student_id = trim($_POST['student_id']);
	$document_name = trim($_POST['document_name']);
	$date_request = trim($_POST['date_request']);
	$custodian_status = trim($_POST['custodian_status']);
	$request_id = trim($_POST['request_id']);
	$email_address = trim($_POST['email_address']); // Retrieve email from form data

	// Update the request in the database
	$request = $conn->edit_request($control_no, $student_id, $document_name, $date_request, $custodian_status, $request_id);

	if ($request) {
		// Check if all statuses are "Verified"
		$statuses = $conn->get_statuses($request_id);
		if (
			$statuses['registrar_status'] === "Verified" &&
			($statuses['dean_status'] === "Verified" || $statuses['dean_status'] === "Not Included") &&
			$statuses['library_status'] === "Verified" &&
			$statuses['custodian_status'] === "Verified"
		) {
			// Update accounting_status to "Waiting for Payment"
			$conn->update_accounting_status($request_id, "Waiting for Payment");

			// Prepare email notification for all "Verified" statuses
			$subject = "Your clearance is almost done!";
			$body = "Your clearance is almost done. Please settle your bill and provide a clear screenshot or copy of your bill.";

			// Send email notification
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
			curl_exec($ch);
			curl_close($ch);

			echo '<div class="alert alert-success">Request updated and email sent successfully!</div>';
		} elseif ($custodian_status === "Declined") {
			// If library status is "Declined", send a custom email
			$subject = trim($_POST['subject']);
			$body = trim($_POST['body']);

			// Send email for "Declined" status
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
			echo '<div class="alert alert-success">Request updated successfully!</div>';
		}

		// Redirect or reload after success
		echo '<script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
	} else {
		echo '<div class="alert alert-danger">Edit Request Failed!</div>
              <script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
	}
}
