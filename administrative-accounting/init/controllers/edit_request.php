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
			// Clean and process document names
			$cleaned_documents = extract_document_names($document_name);

			// Calculate the maximum days to process
			$max_days_to_process = $conn->get_max_days_to_process($student_id, $cleaned_documents);

			if ($max_days_to_process > 0) {
				$date_of_releasing = calculate_release_date($max_days_to_process);

				$release_update = $conn->update_release_date($request_id, $date_of_releasing);
				if ($release_update) {
					$conn->update_registrar_status($request_id, "Processing");

					echo "Date of Release: $date_of_releasing";
				} else {
					error_log("Failed to update release date for request_id: $request_id");
				}
			} else {
				error_log("Invalid max_days_to_process for request_id: $request_id");
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

/**
 * Function to clean and extract document names
 * 
 * @param string $document_name The raw document name string
 * @return array An array of cleaned document names
 */
function extract_document_names($document_name)
{
	// Replace newlines, tabs, and <br> tags with a consistent delimiter
	$document_name = preg_replace('/[\n\r\t]+/', '<br>', $document_name); // Replace \n, \r, and tabs with <br>
	$document_name = str_replace('<br>', ',', $document_name); // Use commas as a consistent delimiter

	// Remove (xN) patterns
	$document_name = preg_replace('/\(x\d+\)/', '', $document_name);

	// Split by the consistent delimiter (comma in this case)
	$documents = array_map('trim', explode(',', $document_name));

	return $documents;
}
