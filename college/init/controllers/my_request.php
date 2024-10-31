<?php
  require_once "../model/class_model.php";

	if(ISSET($_POST)){
		$conn = new class_model();

		$control_no = trim($_POST['control_no']);
		$studentID_no = trim($_POST['studentID_no']);
		$document_name = trim($_POST['document_name']);
		$date_releasing = trim($_POST['date_releasing']);
	    $ref_number = trim($_POST['ref_number']);
		$proof_ofpayment = trim($_POST['proof_ofpayment']);
		$student_id = trim($_POST['student_id']);
		$Verified = "Verified";
		


		$request = $conn->add_myrequest($control_no, $studentID_no, $document_name, $date_releasing, $ref_number, $proof_ofpayment, $student_id, $Verified);
		if($request == TRUE){
		    echo '<div class="alert alert-success">Add MyRequest Successfully!</div><script> setTimeout(function() {  window.history.go(-1); }, 1000); </script>';

		  }else{
			echo '<div class="alert alert-danger">Add MyRequest Failed!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';
		}
	}
?>

