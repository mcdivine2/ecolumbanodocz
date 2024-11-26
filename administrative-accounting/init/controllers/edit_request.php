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
			$date_of_releasing = calculate_release_date($max_days_to_process);

			// Update release date and registrar status
			$release_update = $conn->update_release_date($request_id, $date_of_releasing);
			if ($release_update) {
				$conn->update_registrar_status($request_id, "Processing");

				// Fetch the updated queue number for the release date
				$sql_fetch_queue = "SELECT queue_number FROM tbl_documentrequest WHERE request_id = ?";
				$stmt_fetch_queue = $conn->conn->prepare($sql_fetch_queue);
				$stmt_fetch_queue->bind_param("i", $request_id);
				$stmt_fetch_queue->execute();
				$result_queue = $stmt_fetch_queue->get_result();
				$queue_data = $result_queue->fetch_assoc();

				$queue_number = isset($queue_data['queue_number']) ? $queue_data['queue_number'] : 'N/A';

				echo "Date of Release: $date_of_releasing #$queue_number";
			}
		} else {
			error_log("Not all statuses are verified or meet conditions for request_id: $request_id");
		}
	} else {
		echo '<div class="alert alert-danger">Edit Request Failed!</div>';
	}
}

/**
 * Function to calculate the release date by excluding weekends (Saturday and Sunday)
 * 
 * @param int $max_days The number of weekdays to add
 * @return string The calculated release date in 'Y-m-d' format
 */
function calculate_release_date($max_days)
{
	$current_date = date('Y-m-d'); // Start from today
	$days_added = 0;

	while ($days_added < $max_days) {
		$current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
		$day_of_week = date('N', strtotime($current_date)); // 1 (Mon) to 7 (Sun)

		// Exclude Saturdays (6) and Sundays (7)
		if ($day_of_week < 6) {
			$days_added++;
		}
	}

	return $current_date;
}
