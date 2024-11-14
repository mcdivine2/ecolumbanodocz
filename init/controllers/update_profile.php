<?php
require_once "../model/class_model.php";

if (isset($_POST['username'], $_POST['password'], $_POST['mobile_number'], $_POST['email_address'], $_POST['student_id'])) {
	$conn = new class_model();

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$mobile_number = trim($_POST['mobile_number']);
	$email_address = trim($_POST['email_address']);
	$student_id = trim($_POST['student_id']);

	$upt = $conn->update_profile($username, $password, $mobile_number, $email_address, $student_id);
	if ($upt) {
		echo '<div class="alert alert-success">Profile Updated Successfully!</div><script> setTimeout(function() { window.location.reload(); }, 1000); </script>';
	} else {
		echo '<div class="alert alert-danger">Profile Update Failed!</div>';
	}
} else {
	echo '<div class="alert alert-danger">Incomplete data provided.</div>';
}
