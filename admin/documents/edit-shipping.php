<?php include('main_header/header.php'); ?>

<?php include('left_sidebar/sidebar.php'); ?>

<?php
if (isset($_GET['shipping_id'])) {
    $conn = new class_model();
    $shipping_id = $_GET['shipping_id'];
    $shippingData = $conn->fetch_shipping_by_id($shipping_id); // Fetch the specific shipping fee details
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new class_model();
    $shipping_id = $_POST['shipping_id'];
    $location = trim($_POST['location']);
    $price = trim($_POST['price']);

    $isUpdated = $conn->update_shippingfee($shipping_id, $location, $price);

    if ($isUpdated) {
        echo '<div class="alert alert-success">Shipping fee updated successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to update shipping fee!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Shipping Fee</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Shipping Fee</h2>
        <form method="POST" action="">
            <input type="hidden" name="shipping_id" value="<?= $shippingData['id']; ?>">
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?= $shippingData['location']; ?>" placeholder="Enter location" required>
            </div>
            <div class="form-group">
                <label for="price">Shipping Fee</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $shippingData['price']; ?>" placeholder="Enter shipping fee" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Shipping Fee</button>
            <a href="document.php" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</body>

</html>