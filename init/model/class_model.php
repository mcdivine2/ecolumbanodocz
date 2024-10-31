
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
		$stmt = $this->conn->prepare("SELECT * FROM `tbl_students` WHERE `username` = ? AND `password` = ? AND `account_status` = ?") or die($this->conn->error);
		$stmt->bind_param("sss", $username, $password, $status);
		if ($stmt->execute()) {
			$result = $stmt->get_result();
			$valid = $result->num_rows;
			$fetch = $result->fetch_array();
			return array(
				'student_id' => htmlentities($fetch['student_id']),
				'count' => $valid
			);
		}
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
				'student_id' => $fetch['student_id'],
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
		$sql = "SELECT * FROM  tbl_documentrequest WHERE `student_id` = ? AND registrar_status = 'Received' ";
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
		$stmt->bind_param("i", $document_id);
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

	public function count_numberoftotalrequest()
	{
		$sql = "SELECT COUNT(request_id) as count_request FROM tbl_documentrequest";
		$stmt = $this->conn->prepare($sql);
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
		$sql = "SELECT COUNT(request_id) as count_received FROM tbl_documentrequest WHERE student_id = ? AND registrar_status = 'Received'";
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

	public function update_profile($username, $password, $mobile_number, $email_address, $student_id)
	{
		$sql = "UPDATE `tbl_student` SET  `username` = ?, `password` = ?, `mobile_number` = ?, `email_address` = ? WHERE student_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ssssi", $username, $password, $mobile_number, $email_address, $student_id);
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
		$email_address,
		$control_no,
		$document_name,
		$price,
		$request_type,
		$date_request,
		$registrar_status,
		$custodian_status,
		$dean_status,
		$library_status,
		$accounting_status,
		$purpose,
		$mode_request,
		$student_id
	) {
		// Ensure the connection is active
		if ($this->conn->ping()) {
			// Prepare the SQL statement with 20 placeholders
			$stmt = $this->conn->prepare("INSERT INTO tbl_documentrequest 
						(first_name, middle_name, last_name, complete_address, birthdate, 
						course, email_address, control_no, document_name, price, request_type, 
						date_request, registrar_status, custodian_status, dean_status, 
						library_status, accounting_status, purpose, mode_request, student_id) 
						VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

			if ($stmt === false) {
				die('Prepare failed: (' . $this->conn->errno . ') ' . $this->conn->error);
			}

			// Bind parameters: 19 strings and 1 integer for student_id
			$stmt->bind_param(
				"sssssssssssssssssssi",
				$first_name,
				$middle_name,
				$last_name,
				$complete_address,
				$birthdate,
				$course,
				$email_address,
				$control_no,
				$document_name,
				$price,
				$request_type,
				$date_request,
				$registrar_status,
				$custodian_status,
				$dean_status,
				$library_status,
				$accounting_status,
				$purpose,
				$mode_request,
				$student_id
			);

			// Execute the statement
			if ($stmt->execute()) {
				$stmt->close();
				return true;
			} else {
				// Log or handle errors as needed
				error_log('Execute failed: (' . $stmt->errno . ') ' . $stmt->error);
				$stmt->close();
				return false;
			}
		} else {
			// Handle lost connection
			die('MySQL connection lost');
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