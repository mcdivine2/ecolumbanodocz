<?php
  require_once "../model/class_model.php";
	if(ISSET($_POST)){
		$conn = new class_model();
		$document_name = trim($_POST['document_name']);
		$description = trim($_POST['description']);
		$daysto_process = trim($_POST['daysto_process']);
		$price = trim($_POST['price']);
		$doc = $conn->add_document($document_name, $description, $daysto_process, $price);
		if($doc == TRUE){
		    echo '<div class="alert alert-success">Add Document Successfully!</div><script> setTimeout(function() {  window.history.go(-1); }, 1000); </script>';

		  }else{
			echo '<div class="alert alert-danger">Add Document Failed!</div><script> setTimeout(function() {  window.history.go(-0); }, 1000); </script>';
		}
	}
?>