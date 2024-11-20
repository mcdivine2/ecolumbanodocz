<?php
require_once "../model/class_model.php";

if (isset($_POST)) {
	$conn = new class_model();

	$studentID_no = trim($_POST['studentID_no']);
	$first_name = trim($_POST['first_name']);
	$middle_name = trim($_POST['middle_name']);
	$last_name = trim($_POST['last_name']);
	$complete_address = trim($_POST['complete_address']);
	$email_address = trim($_POST['email_address']);
	$mobile_number = trim($_POST['mobile_number']);
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$account_status = trim($_POST['account_status']);

	// Hash the password before saving
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	$course = $conn->add_student(
		$studentID_no,
		$first_name,
		$middle_name,
		$last_name,
		$complete_address,
		$email_address,
		$mobile_number,
		$username,
		$hashed_password, // Pass the hashed password
		$account_status
	);

	if ($course == true) {
		// Prepare email details
		$subject = "Welcome to Our System - Account Created Successfully!";
		$body = "Hi $first_name $middle_name $last_name,\n\n";
		$body .= "Your account has been successfully created. Here are your login details:\n";
		$body .= "Username: $username\n";
		$body .= "Password: $password\n"; // Send the plaintext password for initial login
		$body .= "Please log in and change your password after your first login for security purposes.\n";
		$body .= "Please visit us in ecolumbanodocz.com \n";
		$body .= "If you have any questions, feel free to contact us.";

		// Email sender using Google Apps Script
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
			echo '<div class="alert alert-success">Account Created and Email Sent Successfully!</div><script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
		} else {
			echo '<div class="alert alert-warning">Account Created, but Email Sending Failed.</div><script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
		}
	} else {
		echo '<div class="alert alert-danger">Account Creation Failed!</div><script> setTimeout(function() { window.history.go(-0); }, 1000); </script>';
	}
}
