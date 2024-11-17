<?php include('main_header/header.php'); ?>

<?php include('left_sidebar/sidebar.php'); ?>
<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new class_model();
    $shipping_id = trim($_POST['shipping_id']);

    $isDeleted = $conn->delete_shippingfee($shipping_id);

    if ($isDeleted) {
        echo '<div class="alert alert-success">Shipping fee deleted successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to delete shipping fee!</div>';
    }
}
