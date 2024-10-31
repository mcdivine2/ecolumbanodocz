<?php
  require_once "../model/class_model.php";

  if(ISSET($_POST['student_id'])){
	  $conn = new class_model();
	  $student_id = trim($_POST['student_id']);
	  
	  // Call delete_student function
	  $student = $conn->delete_student($student_id);
	  
	  if($student == TRUE){
		  echo '<div class="alert alert-success">Delete Student Successfully!</div>
				<script> setTimeout(function() { window.location.reload(); }, 1000); </script>';
	  } else {
		  // Add error logging for debugging purposes
		  echo '<div class="alert alert-danger">Delete Student Failed!</div>
				<script> setTimeout(function() { window.location.reload(); }, 1000); </script>';
	  }
  } else {
	  echo '<div class="alert alert-danger">Student ID not received.</div>';
  }
  
?>

