<?php
  require_once "../model/class_model.php";;
	if(ISSET($_POST)){
		$conn = new class_model();

		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$mobile_number = trim($_POST['mobile_number']);
		$email_address = trim($_POST['email_address']);
		$student_id = trim($_POST['student_id']);

		$upt = $conn->update_profile($username, $password, $mobile_number, $email_address, $student_id);
		if($upt == TRUE){
		    echo '<div class="alert alert-success">Profile Updated  Successfully!</div><script> setTimeout(function() {  window.history.go(-1); }, 1000); </script>';

		  }else{
			echo '<div class="alert alert-danger">Profile Updated   Failed!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';
		}
	}
?>

