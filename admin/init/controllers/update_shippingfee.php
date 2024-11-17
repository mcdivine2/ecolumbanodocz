<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new class_model();
    $shipping_id = trim($_POST['shipping_id']);
    $location = trim($_POST['location']);
    $price = trim($_POST['price']);

    $isUpdated = $conn->update_shippingfee($shipping_id, $location, $price);

    if ($isUpdated) {
        echo '<div class="alert alert-success">Shipping fee updated successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to update shipping fee!</div>';
    }
}
