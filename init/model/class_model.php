
<?php

require 'config/connection.php';

class class_model
{

	public $host = db_host;
	public $user = db_user;
	public $pass = db_pass;
	public $dbname = db_name;
	public $conn;
	public $error;

	public function __construct()
	{
		$this->connect();
	}

	private function connect()
	{
		$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
		if (!$this->conn) {
			$this->error = "Fatal Error: Can't connect to database" . $this->conn->connect_error;
			return false;
		}
	}

	public function login_student($username, $password, $status)
	{
		$stmt = $this->conn->prepare("SELECT * FROM `tbl_students` WHERE `username` = ? AND `account_status` = ?") or die($this->conn->error);
		$stmt->bind_param("ss", $username, $status);

		if ($stmt->execute()) {
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$fetch = $result->fetch_assoc();
				$hashed_password = $fetch['password'];

				// Debugging: Output the hashed password and entered password
				if (password_verify($password, $hashed_password)) {
					// Password is correct
					return array(
						'student_id' => htmlentities($fetch['student_id']),
						'count' => 1
					);
				} else {
					// Debugging for incorrect password
					echo json_encode(['status' => 'error', 'message' => 'Password does not match.']);
				}
			}
		}

		// Return null for login failure
		return array(
			'student_id' => null,
			'count' => 0
		);
	}

	public function forgot_password($email)
	{
		// Generate a random temporary password
		$new_password_plaintext = bin2hex(random_bytes(4)); // Example: 8 characters
		$new_password_hashed = password_hash($new_password_plaintext, PASSWORD_DEFAULT);

		// Fetch user details for email
		$stmt = $this->conn->prepare("SELECT * FROM `tbl_students` WHERE `email_address` = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$user_data = $result->fetch_assoc();

			// Update the password in the database
			$update_stmt = $this->conn->prepare("UPDATE `tbl_students` SET `password` = ? WHERE `email_address` = ?");
			$update_stmt->bind_param("ss", $new_password_hashed, $email);
			$update_stmt->execute();

			// Attach new plaintext password to return data for email
			$user_data['new_password'] = $new_password_plaintext;
			return $user_data;
		}
		return null;
	}
	public function update_profile($username, $password, $mobile_number, $email_address, $student_id)
	{
		// Hash the password before updating
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		$stmt = $this->conn->prepare("UPDATE `tbl_students` SET `username` = ?, `password` = ?, `mobile_number` = ?, `email_address` = ? WHERE `student_id` = ?");
		$stmt->bind_param("sssss", $username, $hashed_password, $mobile_number, $email_address, $student_id);

		return $stmt->execute();
	}



	public function student_account($student_id)
	{
		$stmt = $this->conn->prepare("SELECT * FROM `tbl_students` WHERE `student_id` = ?") or die($this->conn->error);
		$stmt->bind_param("i", $student_id);
		if ($stmt->execute()) {
			$result = $stmt->get_result();
			$fetch = $result->fetch_array();
			return array(
				'first_name' => $fetch['first_name'],
				'last_name' => $fetch['last_name'],
				'email_address' => $fetch['email_address'],
			);
		}
	}

	public function student_profile($student_id)
	{
		$stmt = $this->conn->prepare("SELECT * FROM `tbl_students` WHERE `student_id` = ?") or die($this->conn->error);
		$stmt->bind_param("i", $student_id);
		if ($stmt->execute()) {
			$result = $stmt->get_result();
			$fetch = $result->fetch_array();
			return array(
				'student_id' => $fetch['student_id'],
				// 'student_id' => $fetch['student_id'],
				'first_name' => $fetch['first_name'],
				'middle_name' => $fetch['middle_name'],
				'last_name' => $fetch['last_name'],
				'email_address' => $fetch['email_address'],
				'complete_address' => $fetch['complete_address'],
				'mobile_number' => $fetch['mobile_number'],
				'username' => $fetch['username'],
				'password' => $fetch['password'],
				'date_created' => $fetch['date_created']

			);
		}
	}

	public function fetchAll_course()
	{
		$sql = "SELECT * FROM tbl_course";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}


	public function add_payment($trace_no, $ref_no, $control_no, $document_name, $date_ofpayment, $total_amount, $payment_proof, $student_id, $accounting_status)
	{
		// Start a transaction
		$this->conn->begin_transaction();

		try {
			// Insert into tbl_payment
			$stmt = $this->conn->prepare(
				"INSERT INTO `tbl_payment` (`trace_no`, `ref_no`, `control_no`, `document_name`, `date_ofpayment`, `total_amount`, `proof_ofpayment`, `student_id`, `status`) 
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, 'Paid')"
			);

			if (!$stmt) {
				throw new Exception("Failed to prepare statement: " . $this->conn->error);
			}

			$stmt->bind_param("sssssssi", $trace_no, $ref_no, $control_no, $document_name, $date_ofpayment, $total_amount, $payment_proof, $student_id);

			if (!$stmt->execute()) {
				throw new Exception("Failed to execute insert statement: " . $stmt->error);
			}

			// Update the accounting_status in tbl_documentrequest
			$stmt2 = $this->conn->prepare(
				"UPDATE `tbl_documentrequest` SET `accounting_status` = ? WHERE `control_no` = ?"
			);

			if (!$stmt2) {
				throw new Exception("Failed to prepare update statement: " . $this->conn->error);
			}

			$stmt2->bind_param("ss", $accounting_status, $control_no);

			if (!$stmt2->execute()) {
				throw new Exception("Failed to execute update statement: " . $stmt2->error);
			}

			// Commit transaction
			$this->conn->commit();

			// Close the statements and connection
			$stmt->close();
			$stmt2->close();
			$this->conn->close();

			return true;
		} catch (Exception $e) {
			// Rollback transaction in case of error
			$this->conn->rollback();

			// Log the error and return false
			error_log($e->getMessage());
			return false;
		}
	}



	public function fetchAll_documents($student_id)
	{
		$sql = "SELECT * FROM  tbl_document WHERE `student_id` = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function fetchAll_document()
	{
		$sql = "SELECT * FROM  tbl_document ORDER BY date_created DESC";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function edit_document($document_name, $document_decription, $image_size, $student_id, $document_id)
	{

		$sql = "SELECT document_name FROM tbl_document WHERE document_id = ?";
		$stmt2 = $this->conn->prepare($sql);
		$stmt2->bind_param("i", $document_id);
		$stmt2->execute();
		$result2 = $stmt2->get_result();
		$row = $result2->fetch_assoc();
		$imagepath = '../../student/' . $row['document_name'];
		unlink($imagepath);

		$sql = "UPDATE `tbl_document` SET  `document_name` = ?, `document_decription` = ?, `image_size` = ?,  `student_id` = ? WHERE document_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ssssi", $document_name, $document_decription, $image_size, $student_id, $document_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function delete_document($document_id)
	{


		$sql = "SELECT document_name FROM tbl_document WHERE document_id = ?";
		$stmt2 = $this->conn->prepare($sql);
		$stmt2->bind_param("i", $document_id);
		$stmt2->execute();
		$result2 = $stmt2->get_result();
		$row = $result2->fetch_assoc();
		$imagepath = '../../student/' . $row['document_name'];
		unlink($imagepath);

		$sql = "DELETE FROM tbl_document WHERE document_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $document_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function fetchAll_documentrequest($student_id)
	{
		$sql = "SELECT * FROM  tbl_documentrequest WHERE `student_id` = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function fetch_document_by_id($student_id, $request_id)
	{
		$sql = "SELECT * FROM tbl_documentrequest WHERE student_id = ? AND request_id = ?";
		$stmt = $this->conn->prepare($sql);

		if (!$stmt) {
			die("SQL Error: " . $this->conn->error);
		}

		$stmt->bind_param("ii", $student_id, $request_id);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->fetch_assoc();  // Fetch a single row
	}



	public function fetchAll_pendingrequest($student_id)
	{
		$sql = "SELECT * FROM  tbl_documentrequest WHERE `student_id` = ? AND registrar_status = 'Pending' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function fetchAll_processing($student_id)
	{
		$sql = "SELECT * FROM  tbl_documentrequest WHERE `student_id` = ? AND registrar_status = 'Verified' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function fetchAll_paymentpending($student_id)
	{
		$sql = "SELECT * FROM  tbl_documentrequest WHERE `student_id` = ? AND accounting_status = 'Waiting for Payment' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function fetchAll_releaseddocument($student_id)
	{
		$sql = "SELECT * FROM  tbl_documentrequest WHERE `student_id` = ? AND registrar_status = 'Released' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}
	public function fetchAll_declined($student_id)
	{
		$sql = "SELECT * FROM  tbl_documentrequest WHERE `student_id` = ? AND registrar_status = 'Declined' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}
	public function fetchAll_verified($student_id)
	{
		$sql = "SELECT * FROM  tbl_documentrequest WHERE `student_id` = ? AND registrar_status = 'Verified' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function fetchAll_payments($student_id)
	{
		$sql = "SELECT *,CONCAT(tbl_students.first_name, ', ' ,tbl_students.middle_name, ' ' ,tbl_students.last_name) as student_name FROM  tbl_payment INNER JOIN tbl_students ON tbl_students.student_id =  tbl_payment.student_id  WHERE tbl_payment.student_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function fetchAll_payment($payment_id)
	{
		$sql = "SELECT * FROM  tbl_payment WHERE `payment_id` = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $payment_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}


	public function edit_payment($document_controlno, $total_amount, $amount_paid, $date_ofpayment, $proof_ofpayment, $status, $payment_id)
	{
		$sql = "UPDATE `tbl_payment` SET  `document_controlno` = ?, `total_amount` = ?, `amount_paid` = ?, `date_ofpayment` = ?, `proof_ofpayment` = ?, `status` = ?  WHERE payment_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ssssssi", $document_controlno, $total_amount, $amount_paid, $date_ofpayment, $proof_ofpayment, $status, $payment_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function delete_payment($payment_id)
	{
		$sql = "DELETE FROM tbl_payment WHERE payment_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $payment_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}


	public function count_numberofstudents()
	{
		$sql = "SELECT COUNT(student_id) as count_students FROM tbl_student";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function count_numberoftotalrequest($student_id)
	{
		$sql = "SELECT COUNT(request_id) as count_request FROM tbl_documentrequest WHERE student_id = ?";
		$stmt = $this->conn->prepare($sql);

		// Bind the parameter
		$stmt->bind_param("i", $student_id); // "i" denotes integer, adjust if it's not an integer

		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();

		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}

		return $data;
	}

	public function count_Allpayments($student_id)
	{
		$sql = "SELECT COUNT(payment_id) as count_payment FROM tbl_payment WHERE student_id = ?";
		$stmt = $this->conn->prepare($sql);

		// Bind the parameter
		$stmt->bind_param("i", $student_id); // "i" denotes integer, adjust if it's not an integer

		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();

		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}

		return $data;
	}


	public function count_numberoftotalpending($student_id)
	{
		$sql = "SELECT COUNT(request_id) as count_pending FROM tbl_documentrequest WHERE student_id = ? AND accounting_status = 'Waiting for Payment'";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function count_numberoftotalreceived($student_id)
	{
		$sql = "SELECT COUNT(request_id) as count_received FROM tbl_documentrequest WHERE student_id = ? AND registrar_status = 'Pending'";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function count_verified($student_id)
	{
		$sql = "SELECT COUNT(request_id) as count_verified FROM tbl_documentrequest WHERE student_id = ? AND registrar_status = 'Verified'";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function count_numberofreleased($student_id)
	{
		$sql = "SELECT COUNT(request_id) as count_released FROM tbl_documentrequest WHERE student_id = ? AND registrar_status = 'Released'";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}
	public function count_declined($student_id)
	{
		$sql = "SELECT COUNT(request_id) as count_declined FROM tbl_documentrequest WHERE student_id = ? AND registrar_status = 'Declined'";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function change_username($username, $student_id)
	{
		$sql = "UPDATE `tbl_student` SET  `username` = ? WHERE student_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("si", $username, $student_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}


	public function change_password($password, $student_id)
	{
		$sql = "UPDATE `tbl_student` SET  `password` = ? WHERE student_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("si", $password, $student_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function change_email_address($email_address, $student_id)
	{
		$sql = "UPDATE `tbl_student` SET  `email_address` = ? WHERE student_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("si", $email_address, $student_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function change_mobile_number($mobile_number, $student_id)
	{
		$sql = "UPDATE `tbl_student` SET  `mobile_number` = ? WHERE student_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("si", $mobile_number, $student_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function add_request(
		$first_name,
		$middle_name,
		$last_name,
		$complete_address,
		$birthdate,
		$course,
		$civil_status,
		$email_address,
		$control_no,
		$document_name,
		$price,
		$request_type,
		$registrar_status,
		$custodian_status,
		$dean_status,
		$library_status,
		$accounting_status,
		$purpose,
		$student_id,
		$recent_image,
		$date_request
	) {
		// Check if the connection is active
		if (!$this->conn->ping()) {
			error_log('MySQL connection lost');
			return false;
		}

		// Ensure dean_status logic is consistent
		if (stripos($document_name, "Honorable Dismissal w/ TOR for evaluation") !== false) {
			$dean_status = "Pending";
		} else {
			$dean_status = "Not Included";
		}

		// Prepare the SQL statement
		$stmt = $this->conn->prepare(
			"INSERT INTO tbl_documentrequest 
			(first_name, middle_name, last_name, complete_address, birthdate, course, civil_status,
			 email_address, control_no, document_name, price, request_type,
			 registrar_status, custodian_status, dean_status, library_status, 
			 accounting_status, purpose, student_id, recent_image, date_request) 
			 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?)"
		);

		if (!$stmt) {
			error_log('Prepare failed: ' . $this->conn->error);
			return false;
		}

		// Correct bind parameter type string
		$stmt->bind_param(
			"sssssssssssssssssssss", // Updated type definition string (all are strings)
			$first_name,          // 1
			$middle_name,         // 2
			$last_name,           // 3
			$complete_address,    // 4
			$birthdate,           // 5
			$course,              // 6
			$civil_status,              // 6
			$email_address,       // 7
			$control_no,          // 8
			$document_name,       // 9
			$price,               // 10
			$request_type,        // 11
			$registrar_status,    // 12
			$custodian_status,    // 13
			$dean_status,         // 14
			$library_status,      // 15
			$accounting_status,   // 16
			$purpose,             // 17
			$student_id,          // 18
			$recent_image,        // 19
			$date_request         // 20
		);

		// Execute the statement and handle the result
		if ($stmt->execute()) {
			$stmt->close();
			return true;
		} else {
			error_log('Execute failed: ' . $stmt->error);
			$stmt->close();
			return false;
		}
	}





	public function add_myrequest($control_no, $student_id, $document_name, $date_releasing, $ref_number, $proof_ofpayment, $Verified)
	{
		$stmt = $this->conn->prepare("INSERT INTO `tbl_payment` (`control_no`, `student_id`, `document_name`, `date_releasing`, `ref_number`, `proof_ofpayment`, `student_id`,`status`) VALUES( ?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
		$stmt->bind_param("sssssis", $control_no, $student_id, $document_name, $date_releasing, $ref_number, $proof_ofpayment, $Verified);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function edit_request($control_no, $student_id, $document_name, $no_ofcopies, $date_request, $request_id)
	{
		$sql = "UPDATE `tbl_documentrequest` SET `control_no` = ?, `student_id` = ?, `document_name` = ?, `no_ofcopies` = ?, `date_request` = ? WHERE request_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("sssssi", $control_no, $student_id, $document_name, $no_ofcopies, $date_request, $request_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function delete_request($request_id)
	{
		$sql = "DELETE FROM tbl_documentrequest WHERE request_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $request_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}
}
?>