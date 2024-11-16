<?php
require_once "../model/class_model.php";

if (isset($_POST)) {
	$conn = new class_model();

	$student_id = trim($_POST['student_id']);
	$first_name = trim($_POST['first_name']);
	$middle_name = trim($_POST['middle_name']);
	$last_name = trim($_POST['last_name']);
	$complete_address = trim($_POST['complete_address']);
	$email_address = trim($_POST['email_address']);
	$mobile_number = trim($_POST['mobile_number']);
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$account_status = trim($_POST['account_status']);

	// Call the `edit_student` method
	$is_updated = $conn->edit_student(
		$first_name,
		$middle_name,
		$last_name,
		$complete_address,
		$email_address,
		$mobile_number,
		$username,
		$password,
		$account_status,
		$student_id
	);

	// Check if the update was successful
	if ($is_updated) {
		echo '<div class="alert alert-success">Student updated successfully!</div>';
		echo '<script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
	} else {
		echo '<div class="alert alert-danger">Failed to update student. Please try again.</div>';
		echo '<script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
	}

	//if password was updated change it to hashcode then save it
}
