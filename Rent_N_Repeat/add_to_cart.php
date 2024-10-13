<?php
session_start();
include('db_connect.php');
include('cart_functions.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'];

// Checking if the user is a lessee
$sql = "SELECT * FROM lessee WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    // If the user is not a lessee, show an error message
    echo "<script>alert('You need to be a lessee to add items to the cart.'); window.location.href = 'browse.php';</script>";
    exit;
}

// Proceed with adding to the cart
addToCart($user_id, $product_id);

header('Location: cart.php');
?>
