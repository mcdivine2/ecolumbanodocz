<?php 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$conn = new mysqli("localhost", "u396836176_MaCayaTech", "@Group_10", "u396836176_ords_new_db");
	if($conn->connect_error) {
	  exit('Error connecting to database'); //Should be a message a typical user could understand in production
	}

?>