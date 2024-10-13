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

// Fetch product details to verify ownership
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

// Delete product
if (isset($_POST['confirm_delete'])) {
    $delete_query = "DELETE FROM Product WHERE product_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "ii", $product_id, $user_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header('Location: profile.php'); // Redirect to profile after deletion
        exit();
    } else {
        echo "Failed to delete the listing!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Listing</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h2>Delete Listing</h2>
        <p>Are you sure you want to delete the listing for <strong><?php echo htmlspecialchars($product['product_name']); ?></strong>?</p>
        <form method="POST">
            <button type="submit" name="confirm_delete" class="btn btn-danger">Yes, Delete</button>
            <a href="profile.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>