<?php
  require_once "../model/class_model.php";

	if(ISSET($_POST)){
		$conn = new class_model();

		$control_no = trim($_POST['control_no']);
		$student_id = trim($_POST['student_id']);
		$document_name = trim($_POST['document_name']);
	    $date_request = trim($_POST['date_request']);

	    // $processing_officer = trim($_POST['processing_officer']);
		$custodian_status = trim($_POST['custodian_status']);
		$request_id = trim($_POST['request_id']);

		$request = $conn->edit_request($control_no, $student_id, $document_name, $date_request, $custodian_status, $request_id, $custodian_status);
		if($request == TRUE){
		    echo '<div class="alert alert-success">Edit Request Successfully!</div><script> setTimeout(function() {  window.history.go(-1); }, 1000); </script>';

		  }else{
			echo '<div class="alert alert-danger">Edit Request Failed!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';
		}
	}
?>

