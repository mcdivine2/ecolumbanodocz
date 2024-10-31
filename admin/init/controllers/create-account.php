<?php
  require_once "../model/class_model.php";

	if(ISSET($_POST)){
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
		$course = $conn->add_student($student_id, $first_name, $middle_name, $last_name, $complete_address, $email_address, $mobile_number, $username, $password, $account_status);
		if($course == TRUE){
		    echo '<div class="alert alert-success">Edit Student Successfully!</div><script> setTimeout(function() {  window.history.go(-1); }, 1000); </script>';

		  }else{
			echo '<div class="alert alert-danger">Edit Student Failed!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';
		}
	}
?>

