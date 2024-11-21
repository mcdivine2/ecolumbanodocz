<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$conn = new class_model();

	$control_no = trim($_POST['control_no']);
	$student_id = trim($_POST['student_id']);
	$document_name = trim($_POST['document_name']);
	$date_request = trim($_POST['date_request']);
	$accounting_status = trim($_POST['accounting_status']);
	$request_id = trim($_POST['request_id']);

	// Edit the request
	$request = $conn->edit_request($control_no, $student_id, $document_name, $date_request, $accounting_status, $request_id);

	if ($request) {
		// Fetch statuses from the database
		$statuses = $conn->get_statuses($request_id);

		// Check if all required statuses are "Verified" or meet specific conditions
		if (
			isset($statuses['registrar_status'], $statuses['dean_status'], $statuses['library_status'], $statuses['custodian_status']) &&
			$statuses['registrar_status'] === "Verified" &&
			($statuses['dean_status'] === "Verified" || $statuses['dean_status'] === "Not Included") &&
			$statuses['library_status'] === "Verified" &&
			$statuses['custodian_status'] === "Verified"
		) {
			// Fetch the maximum days_to_process from tbl_document
			$max_days_to_process = $conn->get_max_days_to_process($student_id, $request_id);

			// Calculate the date of release
			$date_of_releasing = date('Y-m-d', strtotime("+$max_days_to_process days"));

			// Update release date and registrar status
			$release_update = $conn->update_release_date($request_id, $date_of_releasing);
			if ($release_update) {
				$conn->update_registrar_status($request_id, "Releasing");
			}
		} else {
			error_log("Not all statuses are verified or meet conditions for request_id: $request_id");
		}
	} else {
		echo '<div class="alert alert-danger">Edit Request Failed!</div>';
	}
}
