<?php
session_start();
include('db_connect.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'lessor') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the product ID is provided
if (!isset($_GET['id'])) {
    echo "Listing not found!";
    exit();
}

$product_id = $_GET['id'];

// Fetch product details
$query = "SELECT * FROM Product WHERE product_id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $product_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Listing not found!";
    exit();
}

// Update product details (if form is submitted)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_type = $_POST['product_type'];
    $size = $_POST['size'];
    $price_per_day = $_POST['price_per_day'];

    $update_query = "UPDATE Product SET product_name = ?, product_type = ?, size = ?, price_per_day = ? WHERE product_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "sssdii", $product_name, $product_type, $size, $price_per_day, $product_id, $user_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header('Location: profile.php'); // Redirect to profile page after updating
        exit();
    } else {
        echo "Failed to update the listing!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h2>Edit Listing</h2>
        <form method="POST">
            <div class="form-group">
                <label for="product_name">Cloth Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="product_type">Cloth Type</label>
                <input type="text" class="form-control" id="product_type" name="product_type" value="<?php echo htmlspecialchars($product['product_type']); ?>" required>
            </div>
            <div class="form-group">
                <label for="size">Size</label>
                <input type="text" class="form-control" id="size" name="size" value="<?php echo htmlspecialchars($product['size']); ?>" required>
            </div>
            <div class="form-group">
                <label for="price_per_day">Price per Day</label>
                <input type="text" class="form-control" id="price_per_day" name="price_per_day" value="<?php echo htmlspecialchars($product['price_per_day']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="profile.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>