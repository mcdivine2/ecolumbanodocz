
<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new class_model();
    $document_name = trim($_POST['document_name']);
    $description = trim($_POST['description']);
    $daysto_process = trim($_POST['daysto_process']);
    $price = trim($_POST['price']);
    $document_id = trim($_POST['document_id']);

    // Call the edit function
    $isUpdated = $conn->edit_document($document_name, $description, $daysto_process, $price, $document_id);

    if ($isUpdated) {
        echo '<div class="alert alert-success">Document updated successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to update document!</div>';
    }
}
?>



