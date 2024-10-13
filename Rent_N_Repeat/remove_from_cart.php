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

removeFromCart($user_id, $product_id);

header('Location: cart.php');
?>