<?php
require_once "../model/class_model.php";

if (isset($_POST)) {
	$conn = new class_model();

	$control_no = trim($_POST['control_no']);
	$student_id = trim($_POST['student_id']);
	$document_name = trim($_POST['document_name']);
	$date_request = trim($_POST['date_request']);
	$custodian_status = trim($_POST['custodian_status']);
	$request_id = trim($_POST['request_id']);

	$request = $conn->edit_request($control_no, $student_id, $document_name, $date_request, $custodian_status, $request_id);

	if ($request == TRUE) {
		// Check if all statuses are "Verified"
		$statuses = $conn->get_statuses($request_id);
		if (
			$statuses['registrar_status'] == "Verified" &&
			$statuses['dean_status'] == "Verified" &&
			$statuses['library_status'] == "Verified" &&
			$statuses['custodian_status'] == "Verified"
		) {

			// Update accounting_status to "Waiting for Payment"
			$conn->update_accounting_status($request_id, "Waiting for Payment");
		}

		echo '<div class="alert alert-success">Edit Request Successfully!</div>
              <script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
	} else {
		echo '<div class="alert alert-danger">Edit Request Failed!</div>
              <script> setTimeout(function() { window.history.go(-1); }, 1000); </script>';
	}
}
