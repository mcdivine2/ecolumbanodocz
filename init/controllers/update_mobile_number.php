<?php
  require_once "../model/class_model.php";;
	if(ISSET($_POST)){
		$conn = new class_model();

		$mobile_number = trim($_POST['mobile_number']);
		$student_id = trim($_POST['student_id']);

		$pass = $conn->change_mobile_number($mobile_number, $student_id);
		if($pass == TRUE){
		    echo '<div class="alert alert-success">Update Successfully!</div><script> setTimeout(function() {  window.history.go(-1); }, 1000); </script>';

		  }else{
			echo '<div class="alert alert-danger">Update Failed!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';
		}
	}
?>

