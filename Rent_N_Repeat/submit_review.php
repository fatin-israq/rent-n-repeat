<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// Debugging output
echo "User ID: $user_id<br>";
echo "Product ID: $product_id<br>";
echo "Rating: $rating<br>";
echo "Comment: $comment<br>";

// Check if the product exists in the database
$sql_check_product = "SELECT * FROM Product WHERE product_id = ?";
$stmt_check_product = mysqli_prepare($conn, $sql_check_product);
mysqli_stmt_bind_param($stmt_check_product, "i", $product_id);
mysqli_stmt_execute($stmt_check_product);
$result_check_product = mysqli_stmt_get_result($stmt_check_product);

if (mysqli_num_rows($result_check_product) == 0) {
    echo "Product not found!";
    exit;
}

// Insert the review into the database
$sql = "INSERT INTO review (product_id, user_id, rating, comment, review_date) VALUES (?, ?, ?, ?, NOW())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iiis", $product_id, $user_id, $rating, $comment);
mysqli_stmt_execute($stmt);

header('Location: product.php?id=' . $product_id);
?>