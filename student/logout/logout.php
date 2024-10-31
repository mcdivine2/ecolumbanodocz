<?php
	session_start();
	session_destroy();
	unset($_SESSION['student_id']);
	header('location:../../index.php');
?>