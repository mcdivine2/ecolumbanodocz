<?php
require_once "../model/class_model.php";

if (isset($_POST)) {
	$conn = new class_model();
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$status = "Active";
	$role = "Custodian";  // Only allows Library role users to log in

	$get_admin = $conn->login($username, $password, $status, $role);

	if ($get_admin['count'] > 0) {
		session_start();
		$_SESSION['user_id'] = $get_admin['user_id'];
		$_SESSION['role'] = $get_admin['role'];  // Store role in session for verification

		echo 1; // Login success
	} else {
		echo 0; // Login failed
	}
}
