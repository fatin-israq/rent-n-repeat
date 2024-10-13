<?php
include('db_connect.php');

function addToCart($user_id, $product_id) {
    global $conn;
    // Check if the product is already in the cart
    $sql = "SELECT * FROM Cart WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        // If the product is already in the cart, do nothing or show a message
        echo "Product is already in the cart.";
    } else {
        // If the product is not in the cart, insert a new row
        $sql = "INSERT INTO Cart (user_id, product_id, created_at) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($stmt);
    }
}

function removeFromCart($user_id, $product_id) {
    global $conn;
    $sql = "DELETE FROM Cart WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($stmt);
}

function getCartItems($user_id) {
    global $conn;
    $sql = "SELECT Product.* FROM Cart JOIN Product ON Cart.product_id = Product.product_id WHERE Cart.user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cart_items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
    }
    return $cart_items;
}
?>