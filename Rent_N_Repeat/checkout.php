<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the current user
$sql = "SELECT cart.product_id, product.price_per_day, cart.created_at
        FROM cart
        JOIN product ON cart.product_id = product.product_id
        WHERE cart.user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$total_price = 0;
$cart_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $total_price += $row['price_per_day']; 
    $cart_items[] = $row;
}

if (empty($cart_items)) {
    echo "<div class='container mt-5'>
            <div class='alert alert-warning' role='alert'>
                <h4 class='alert-heading'>Your cart is empty!</h4>
                <p>Please add items to your cart before proceeding to checkout.</p>
                <hr>
                <a href='index.php' class='btn btn-primary'>Go to Home</a>
            </div>
          </div>";
    exit;
}

// Fetch lessor_id from the lessor table using product_id
$sql_lessor = "SELECT lessor.user_id AS lessor_id, product.product_id as product_id
               FROM lessor 
               JOIN product ON lessor.user_id = product.user_id 
               WHERE product.product_id = ?";
$stmt_lessor = mysqli_prepare($conn, $sql_lessor);
mysqli_stmt_bind_param($stmt_lessor, "i", $cart_items[0]['product_id']); 
mysqli_stmt_execute($stmt_lessor);
$lessor_result = mysqli_stmt_get_result($stmt_lessor);
$lessor_row = mysqli_fetch_assoc($lessor_result);
$product_id = $lessor_row['product_id'];

if (!$lessor_row) {
    echo "Lessor not found!";
    exit;
}

$lessor_id = $lessor_row['lessor_id'];

// Fetch admin_id from the Admin table
$admin_sql = "SELECT admin_id FROM admin LIMIT 1";
$admin_result = mysqli_query($conn, $admin_sql);
$admin_row = mysqli_fetch_assoc($admin_result);
$admin_id = $admin_row['admin_id'];

if (!$admin_id) {
    echo "Admin account not found!";
    exit;
}

$lessor_portion = $total_price * 0.8; // 80% to lessor
$admin_portion = $total_price * 0.2; // 20% to admin

// Insert a new order
$order_sql = "INSERT INTO `order` (lessor_id, lessee_id, admin_id, start_date, end_date, total_price, lessor_portion, admin_portion)
              VALUES (?, ?, ?, NOW(), NOW(), ?, ?, ?)";
$stmt_order = mysqli_prepare($conn, $order_sql);
mysqli_stmt_bind_param($stmt_order, "iiiddd", $lessor_id, $user_id, $admin_id, $total_price, $lessor_portion, $admin_portion);
mysqli_stmt_execute($stmt_order);

// Get the generated transaction ID
$transaction_id = mysqli_insert_id($conn);

// Insert order details for each product in the cart
foreach ($cart_items as $item) {
    $sql_order_details = "INSERT INTO order_details (product_id, transaction_id, rental_days, price_per_item)
                          VALUES (?, ?, ?, ?)";
    $rental_days = 1;
    $price_per_item = $item['price_per_day'];

    $stmt_order_details = mysqli_prepare($conn, $sql_order_details);
    mysqli_stmt_bind_param($stmt_order_details, "iiid", $item['product_id'], $transaction_id, $rental_days, $price_per_item);
    mysqli_stmt_execute($stmt_order_details);
}

// Insert payment details
$payment_sql = "INSERT INTO payment (transaction_id, payment_date, amount) VALUES (?, NOW(), ?)";
$stmt_payment = mysqli_prepare($conn, $payment_sql);
mysqli_stmt_bind_param($stmt_payment, "id", $transaction_id, $total_price);
mysqli_stmt_execute($stmt_payment);

// Clear cart after payment
$clear_cart_sql = "DELETE FROM cart WHERE user_id = ?";
$stmt_clear_cart = mysqli_prepare($conn, $clear_cart_sql);
mysqli_stmt_bind_param($stmt_clear_cart, "i", $user_id);
mysqli_stmt_execute($stmt_clear_cart);

// Mark product as unavailable after rent
$product_update_sql = "UPDATE product SET is_available = 0 WHERE product_id = ?";
$stmt = mysqli_prepare($conn, $product_update_sql);
mysqli_stmt_bind_param($stmt, "i", $product_id); 
mysqli_stmt_execute($stmt);


echo "Payment successful!";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container">
        <h1>Payment</h1>
        <p>Total Price: $<?php echo number_format($total_price, 2); ?></p>
        <p>Payment successful!</p>
        <a href="index.php" class="btn btn-primary">Go to Home</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>