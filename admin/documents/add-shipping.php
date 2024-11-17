<?php include('main_header/header.php'); ?>

<?php include('left_sidebar/sidebar.php'); ?>
<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new class_model();
    $location = trim($_POST['location']);
    $price = trim($_POST['price']);

    $isAdded = $conn->add_shippingfee($location, $price);

    if ($isAdded) {
        echo '<div class="alert alert-success">Shipping fee added successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to add shipping fee!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Shipping Fee</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Add Shipping Fee</h2>
        <form method="POST">
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" required>
            </div>
            <div class="form-group">
                <label for="price">Shipping Fee</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Enter shipping fee" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Shipping Fee</button>
            <a href="document.php" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</body>

</html>