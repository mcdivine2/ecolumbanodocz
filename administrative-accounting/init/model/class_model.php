
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

	public function login($username, $password, $status, $role)
	{
		$stmt = $this->conn->prepare("SELECT * FROM `tbl_usermanagement` WHERE `username` = ? AND `password` = ? AND `status` = ? AND `role` = ?") or die($this->conn->error);
		$stmt->bind_param("ssss", $username, $password, $status, $role);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$fetch = $result->fetch_array();
			return array(
				'count' => $result->num_rows,
				'user_id' => $fetch['user_id'],
				'role' => $fetch['role']
			);
		} else {
			return array('count' => 0);
		}
	}

	public function user_account($user_id)
	{
		$stmt = $this->conn->prepare("SELECT * FROM `tbl_usermanagement` WHERE `user_id` = ?") or die($this->conn->error);
		$stmt->bind_param("i", $user_id);
		if ($stmt->execute()) {
			$result = $stmt->get_result();
			$fetch = $result->fetch_array();
			return array(
				'complete_name' => $fetch['complete_name']
				// 'last_name'=>$fetch['last_name']
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


	public function add_course($course_name, $course_decription)
	{
		$stmt = $this->conn->prepare("INSERT INTO `tbl_course` (course_name, course_decription) VALUES(?, ?)") or die($this->conn->error);
		$stmt->bind_param("ss", $course_name, $course_decription);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}


	public function edit_course($course_name, $course_decription, $course_id)
	{
		$sql = "UPDATE `tbl_course` SET  `course_name` = ?, `course_decription` = ?  WHERE course_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ssi", $course_name, $course_decription, $course_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function delete_course($course_id)
	{
		$sql = "DELETE FROM tbl_course WHERE course_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $course_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}


	public function add_student($IDnumber, $first_name, $middle_name, $last_name, $complete_address, $email_address, $mobile_number, $username, $password, $status)
	{
		$stmt = $this->conn->prepare("INSERT INTO `tbl_students` (`student_id`, `first_name`, `middle_name`, `last_name`, `complete_address`, `email_address`, `mobile_number`, `username`, `password`, `account_status`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
		$stmt->bind_param("ssssssssss", $IDnumber, $first_name, $middle_name, $last_name, $complete_address, $email_address, $mobile_number, $username, $password, $status);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function fetchAll_student()
	{
		$sql = "SELECT * FROM  tbl_students";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function fetchAll_verification()
	{
		$sql = "SELECT * FROM  tbl_verification";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}


	public function fetchAll_hsstudent()
	{
		$sql = "SELECT * FROM  tbl_high_school";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}


	public function delete_student($student_id)
	{
		$sql = "DELETE FROM tbl_student WHERE student_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $student_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
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



	public function delete_document($document_id)
	{


		$sql = "SELECT document_name FROM tbl_document WHERE document_id = ?";
		$stmt2 = $this->conn->prepare($sql);
		$stmt2->bind_param("i", $document_id);
		$stmt2->execute();
		$result2 = $stmt2->get_result();
		$row = $result2->fetch_assoc();
		$imagepath = $_SERVER['DOCUMENT_ROOT'] . "/ORDS/student/" . $row['document_name'];
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

	public function fetchAll_documentrequest()
	{
		$sql = "SELECT * FROM  tbl_documentrequest";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}
	public function fetchAll_paymentrequest()
	{
		// Modify the SQL query to only fetch rows where the status is 'Paid'
		$sql = "SELECT *, CONCAT(tbl_students.first_name, ', ' ,tbl_students.middle_name, ' ' ,tbl_students.last_name) as student_name 
            FROM tbl_payment 
            INNER JOIN tbl_students ON tbl_students.student_id = tbl_payment.student_id 
            ORDER BY tbl_payment.student_id DESC";

		// Prepare the SQL statement
		$stmt = $this->conn->prepare($sql);

		// Check if the statement was prepared successfully
		if ($stmt) {
			// Execute the statement
			$stmt->execute();

			// Get the result set
			$result = $stmt->get_result();
			$data = array();

			// Fetch each row and add it to the data array
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}

			// Close the statement
			$stmt->close();

			// Return the fetched data
			return $data;
		} else {
			// If the statement failed, return an empty array or handle the error
			return array();
		}
	}

	public function print_documentrequest()
	{
		$db = mysqli_connect("localhost", "root", "", "ords_new_db");

		$result = mysqli_query($db, "SELECT * FROM tbl_documentrequest", MYSQLI_USE_RESULT);



		$output = fopen('php://output', 'w');

		fputcsv($output, array('request_id', 'control_no', 'student_id', 'document_name', 'no_ofcopies', 'date_request', 'date_releasing', 'processing_officer', 'status'));

		while ($row = mysqli_fetch_assoc($result)) {
			fputcsv($output, $row);
		}

		fclose($output);
		mysqli_free_result($result);
		mysqli_close($db);
	}

	public function fetchAll_newrequest()
	{
		$sql = "SELECT * FROM  tbl_documentrequest WHERE accounting_status = 'Waiting for Payment' ";

		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function fetchAll_verified()
	{
		// SQL query to fetch all verified payments with modeof_payment and or_no
		$sql = "SELECT tbl_payment.*, 
                   tbl_payment.modeof_payment, 
                   tbl_payment.or_no,
                   tbl_payment.trace_no, 
                   tbl_payment.ref_no,
                   tbl_payment.total_amount,
                   tbl_payment.date_ofpayment,
                   tbl_payment.status,
                   CONCAT(tbl_students.first_name, ', ', tbl_students.middle_name, ' ', tbl_students.last_name) AS student_name
            FROM tbl_payment
            INNER JOIN tbl_students ON tbl_students.student_id = tbl_payment.student_id
            WHERE tbl_payment.status = 'Verified'
            ORDER BY tbl_payment.student_id DESC";

		// Prepare the SQL statement
		$stmt = $this->conn->prepare($sql);

		if ($stmt) {
			// Execute the statement
			$stmt->execute();

			// Get the result set
			$result = $stmt->get_result();
			$data = array();

			// Fetch each row and add it to the data array
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}

			// Close the statement
			$stmt->close();

			// Return the fetched data
			return $data;
		} else {
			// If the statement failed, return an empty array or handle the error
			return array();
		}
	}


	public function fetchAll_released()
	{
		$sql = "SELECT * FROM  tbl_documentrequest WHERE accounting_status = 'Released' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}
	public function fetchAll_pendingpaid()
	{
		$sql = "SELECT * FROM  tbl_documentrequest WHERE accounting_status = 'Waiting for Payment' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}
	public function fetchAll_declined()
	{
		// Modify the SQL query to only fetch rows where the status is 'Paid'
		$sql = "SELECT *, CONCAT(tbl_students.first_name, ', ' ,tbl_students.middle_name, ' ' ,tbl_students.last_name) as student_name 
            FROM tbl_payment 
            INNER JOIN tbl_students ON tbl_students.student_id = tbl_payment.student_id 
            WHERE tbl_payment.status = 'Declined' 
            ORDER BY tbl_payment.student_id DESC";

		// Prepare the SQL statement
		$stmt = $this->conn->prepare($sql);

		// Check if the statement was prepared successfully
		if ($stmt) {
			// Execute the statement
			$stmt->execute();

			// Get the result set
			$result = $stmt->get_result();
			$data = array();

			// Fetch each row and add it to the data array
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}

			// Close the statement
			$stmt->close();

			// Return the fetched data
			return $data;
		} else {
			// If the statement failed, return an empty array or handle the error
			return array();
		}
	}

	public function fetchAll_pendingpayment()
	{
		// Modify the SQL query to only fetch rows where the status is 'Paid'
		$sql = "SELECT *, CONCAT(tbl_students.first_name, ', ' ,tbl_students.middle_name, ' ' ,tbl_students.last_name) as student_name 
            FROM tbl_payment 
            INNER JOIN tbl_students ON tbl_students.student_id = tbl_payment.student_id 
            WHERE tbl_payment.status = 'Paid' 
            ORDER BY tbl_payment.student_id DESC";

		// Prepare the SQL statement
		$stmt = $this->conn->prepare($sql);

		// Check if the statement was prepared successfully
		if ($stmt) {
			// Execute the statement
			$stmt->execute();

			// Get the result set
			$result = $stmt->get_result();
			$data = array();

			// Fetch each row and add it to the data array
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}

			// Close the statement
			$stmt->close();

			// Return the fetched data
			return $data;
		} else {
			// If the statement failed, return an empty array or handle the error
			return array();
		}
	}
	public function fetch_document_by_id($student_id, $control_no)
	{
		$stmt = $this->conn->prepare("SELECT * FROM tbl_documentrequest WHERE student_id = ? AND control_no = ?");
		if (!$stmt) {
			die("Prepare failed: " . $this->conn->error);
		}
		$stmt->bind_param("is", $student_id, $control_no);  // "is" indicates integer and string
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}



	public function edit_request($control_no, $student_id, $document_name, $date_request, $accounting_status, $request_id)
	{
		$this->conn->begin_transaction();

		try {
			// Update tbl_documentrequest
			$sql = "UPDATE `tbl_documentrequest` SET `control_no` = ?, `student_id` = ?, `document_name` = ?, `date_request` = ?, `accounting_status` = ? WHERE `request_id` = ?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("sssssi", $control_no, $student_id, $document_name, $date_request, $accounting_status, $request_id);
			if (!$stmt->execute()) {
				throw new Exception("Failed to update tbl_documentrequest");
			}
			$stmt->close();

			// Update status in tbl_payment based on control_no
			$sql_payment = "UPDATE `tbl_payment` SET `status` = ? WHERE `control_no` = ?";
			$stmt_payment = $this->conn->prepare($sql_payment);
			$stmt_payment->bind_param("ss", $accounting_status, $control_no);
			if (!$stmt_payment->execute()) {
				throw new Exception("Failed to update tbl_payment");
			}
			$stmt_payment->close();

			// Commit transaction
			$this->conn->commit();
			return true;
		} catch (Exception $e) {
			// Rollback transaction if there is an error
			$this->conn->rollback();
			return false;
		}
	}

	// Get current statuses for the request
	public function get_statuses($request_id)
	{
		$sql = "SELECT registrar_status, dean_status, library_status, custodian_status FROM tbl_documentrequest WHERE request_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $request_id);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}
	public function get_max_days_to_process($student_id, $document_names)
	{
		try {
			$max_days = 0;

			foreach ($document_names as $doc_name) {
				$sql = "SELECT MAX(daysto_process) AS max_days
                    FROM tbl_document
                    WHERE document_name = ?";
				$stmt = $this->conn->prepare($sql);
				$stmt->bind_param("s", $doc_name);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc();

				$doc_days = isset($row['max_days']) ? (int)$row['max_days'] : 0;

				if ($doc_days > $max_days) {
					$max_days = $doc_days;
				}
			}

			return $max_days;
		} catch (Exception $e) {
			error_log("Error in get_max_days_to_process: " . $e->getMessage());
			return 0;
		}
	}

	public function update_release_date($request_id, $date_of_releasing)
	{
		try {
			$sql_update = "UPDATE tbl_documentrequest 
                       SET date_releasing = ? 
                       WHERE request_id = ?";
			$stmt = $this->conn->prepare($sql_update);

			if (!$stmt) {
				error_log("Error preparing statement: " . $this->conn->error);
				return false;
			}

			$stmt->bind_param("si", $date_of_releasing, $request_id);
			$result = $stmt->execute();

			if (!$result) {
				error_log("SQL Execution Failed: (" . $stmt->errno . ") " . $stmt->error);
			}

			return $result;
		} catch (Exception $e) {
			error_log("Error in update_release_date: " . $e->getMessage());
			return false;
		}
	}




	public function update_registrar_status($request_id, $status_message)
	{
		try {
			$sql = "UPDATE tbl_documentrequest 
                SET registrar_status = ? 
                WHERE request_id = ?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("si", $status_message, $request_id);
			return $stmt->execute();
		} catch (Exception $e) {
			error_log("Error in update_registrar_status: " . $e->getMessage());
			return false;
		}
	}





	// Update accounting_status
	public function update_accounting_status($request_id, $new_status)
	{
		$sql = "UPDATE tbl_documentrequest SET accounting_status = ? WHERE request_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("si", $new_status, $request_id);
		$stmt->execute();
		$stmt->close();
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

	public function fetchAll_payment()
	{
		// Modify the SQL query to only fetch rows where the status is 'Paid'
		$sql = "SELECT *, CONCAT(tbl_students.first_name, ', ' ,tbl_students.middle_name, ' ' ,tbl_students.last_name) as student_name 
            FROM tbl_payment 
            INNER JOIN tbl_students ON tbl_students.student_id = tbl_payment.student_id 
            WHERE tbl_payment.status = 'Paid' 
            ORDER BY tbl_payment.student_id DESC";

		// Prepare the SQL statement
		$stmt = $this->conn->prepare($sql);

		// Check if the statement was prepared successfully
		if ($stmt) {
			// Execute the statement
			$stmt->execute();

			// Get the result set
			$result = $stmt->get_result();
			$data = array();

			// Fetch each row and add it to the data array
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}

			// Close the statement
			$stmt->close();

			// Return the fetched data
			return $data;
		} else {
			// If the statement failed, return an empty array or handle the error
			return array();
		}
	}
	public function fetchAll_paymentpending()
	{
		$sql = "SELECT tbl_payment.*, 
                   CONCAT(tbl_students.first_name, ', ' ,tbl_students.middle_name, ' ' ,tbl_students.last_name) AS student_name 
            FROM tbl_payment
            INNER JOIN tbl_students ON tbl_students.student_id = tbl_payment.student_id 
            INNER JOIN tbl_documentrequest ON tbl_documentrequest.control_no = tbl_payment.control_no
            WHERE tbl_documentrequest.accounting_status = 'Waiting for Payment' 
            ORDER BY tbl_payment.student_id DESC";

		$stmt = $this->conn->prepare($sql);
		if ($stmt) {
			$stmt->execute();
			$result = $stmt->get_result();
			$data = array();

			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
			$stmt->close();
			return $data;
		} else {
			return array();
		}
	}




	public function edit_payment($control_no, $total_amount, $amount_paid, $date_ofpayment, $proof_ofpayment, $status, $payment_id)
	{
		$sql = "UPDATE `tbl_payment` SET  `control_no` = ?, `total_amount` = ?, `amount_paid` = ?, `date_ofpayment` = ?, `proof_ofpayment` = ?, `status` = ?  WHERE payment_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ssssssi", $control_no, $total_amount, $amount_paid, $date_ofpayment, $proof_ofpayment, $status, $payment_id);
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

	public function add_user($complete_name, $desgination, $email_address, $phone_number, $username, $password, $status)
	{
		$stmt = $this->conn->prepare("INSERT INTO `tbl_usermanagement` (`complete_name`, `desgination`, `email_address`, `phone_number`, `username`, `password`, `status`) VALUES(?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
		$stmt->bind_param("sssssss", $complete_name, $desgination, $email_address, $phone_number, $username, $password, $status);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function add_admin_aide($complete_name, $desgination, $email_address, $phone_number, $username, $password, $status)
	{
		$stmt = $this->conn->prepare("INSERT INTO `tbl_usermanagement` (`complete_name`, `desgination`, `email_address`, `phone_number`, `username`, `password`, `status`) VALUES(?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
		$stmt->bind_param("sssssss", $complete_name, $desgination, $email_address, $phone_number, $username, $password, $status);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function add_admin_assist($complete_name, $desgination, $email_address, $phone_number, $username, $password, $status)
	{
		$stmt = $this->conn->prepare("INSERT INTO `tbl_usermanagement` (`complete_name`, `desgination`, `email_address`, `phone_number`, `username`, `password`, `status`) VALUES(?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
		$stmt->bind_param("sssssss", $complete_name, $desgination, $email_address, $phone_number, $username, $password, $status);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function fetchAll_user()
	{
		$sql = "SELECT * FROM  tbl_usermanagement";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}



	public function edit_user($complete_name, $desgination, $email_address, $phone_number, $username, $password, $status, $user_id)
	{
		$sql = "UPDATE `tbl_usermanagement` SET  `complete_name` = ?, `desgination` = ?, `email_address` = ?, `phone_number` = ?, `username` = ?, `password` = ?, `status` = ?  WHERE user_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("sssssssi", $complete_name, $desgination, $email_address, $phone_number, $username, $password, $status, $user_id);
		if ($stmt->execute()) {
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}



	public function delete_user($user_id)
	{
		$sql = "DELETE FROM tbl_usermanagement WHERE user_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $user_id);
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



	public function count_allstudents()
	{
		$sql = "SELECT (SELECT COUNT(student_id)  FROM tbl_student) as count_students";
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
		$sql = "SELECT COUNT(control_no) as count_request FROM tbl_payment";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function count_numberoftotalpending()
	{
		$sql = "SELECT COUNT(request_id) as count_pending FROM tbl_documentrequest WHERE accounting_status = 'Waiting for Payment'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}



	public function count_numberoftotalpaid()
	{
		$sql = "SELECT COUNT(request_id) as count_paid FROM tbl_documentrequest WHERE accounting_status = 'Paid'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function count_numberoftotalreceived()
	{
		$sql = "SELECT COUNT(request_id) as count_received FROM tbl_documentrequest WHERE accounting_status = 'Received'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}


	public function count_numberofreleased()
	{
		$sql = "SELECT COUNT(request_id) as count_released FROM tbl_documentrequest WHERE accounting_status = 'Releasing'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function count_released()
	{
		$sql = "SELECT COUNT(request_id) as count_released FROM tbl_documentrequest WHERE accounting_status = 'Released'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}

	public function count_decline()
	{
		$sql = "SELECT COUNT(request_id) as count_decline FROM tbl_documentrequest WHERE accounting_status = 'Declined'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}
	public function count_verified()
	{
		$sql = "SELECT COUNT(payment_id) as count_verified FROM tbl_payment WHERE status = 'Verified'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}




	public function count_groupbymonth()
	{
		$sql = "SELECT COUNT(total_amount) as p_amountcount, SUM(total_amount) as p_amountsum, DATE_FORMAT(date_ofpayment, '%M') as month_s FROM tbl_payment GROUP BY DATE_FORMAT(date_ofpayment, '%M') ORDER BY DATE_FORMAT(date_ofpayment, '%M') ASC";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}


	public function count_groupbycourse()
	{
		$sql = "SELECT count(course) as count_coursename,course FROM tbl_student GROUP BY course";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}
}
?>