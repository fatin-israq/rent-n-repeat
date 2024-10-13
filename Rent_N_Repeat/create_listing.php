<?php
session_start();
include('db_connect.php'); 

// Ensuring the user is logged in as a lessor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'lessor') {
    header('Location: login.php');
    exit;
}

// Checking if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = trim($_POST['product_name']);
    $product_type = trim($_POST['product_type']);
    $size = trim($_POST['size']);
    $price_per_day = trim($_POST['price_per_day']);
    $is_available = 1; 
    $lessor_id = $_SESSION['user_id'];
    $description = $_POST['product_description'];

    // Image upload handling
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["product_image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
            // Insert product into the database
            $sql = "INSERT INTO Product (product_name, product_type, size, price_per_day, is_available, user_id, image_path, product_description) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssdiiss", $product_name, $product_type, $size, $price_per_day, $is_available, $lessor_id, $targetFile, $description);

            if (mysqli_stmt_execute($stmt)) {
                echo "Listing created successfully!";
            } else {
                echo "Error creating listing: " . mysqli_error($conn);
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Listing - Clothing Rental</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <h2>Create New Listing</h2>
        <form action="create_listing.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="product_type">Product Type</label>
                <input type="text" name="product_type" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="product_description">Product Description</label>
                <input type="text" name="product_description" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="size">Size</label>
                <input type="text" name="size" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price_per_day">Price per Day ($)</label>
                <input type="text" name="price_per_day" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="product_image">Product Image</label>
                <input type="file" name="product_image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Listing</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>