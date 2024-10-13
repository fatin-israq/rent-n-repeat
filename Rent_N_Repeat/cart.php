<?php
session_start();
include('db_connect.php');
include('cart_functions.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the current user
$sql = "SELECT cart.product_id, product.product_name, product.price_per_day, cart.created_at
        FROM Cart AS cart
        JOIN Product AS product ON cart.product_id = product.product_id
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

if ($total_price == 0) {
    echo '
    <div style="
        display: flex;
        align-items: center;
        justify-content: center;
        height: 90vh;
    ">
        <div style="
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
        ">
            <h1 style="
                color: #5a4636;
                font-size: 24px;
                margin-bottom: 20px;
            ">Your cart is empty!</h1>
            <p style="
                color: #8c6f56;
                font-size: 16px;
                margin-bottom: 30px;
            ">It looks like you haven\'t added anything to your cart yet.</p>
            <a href="./browse.php" style="
                text-decoration: none;
                background-color: #8c6f56;
                color: #fff;
                padding: 10px 20px;
                border-radius: 8px;
                transition: background-color 0.3s ease;
            " onmouseover="this.style.backgroundColor=\'#705541\';" onmouseout="this.style.backgroundColor=\'#8c6f56\';">Continue Shopping</a>
        </div>
    </div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        h1 {
            color: #5a4636;
            font-size: 32px;
            margin-top: 30px;
            text-align: center;
        }

        .table {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #d1bfa8;
            color: #5a4636;
        }

        .table td {
            color: #8c6f56;
        }

        .btn-danger, .btn-success {
            border-radius: 8px;
            font-size: 16px;
            padding: 10px 20px;
        }

        .btn-danger {
            background-color: #d9534f;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }

        .btn-success {
            background-color: #8c6f56;
            border: none;
        }

        .btn-success:hover {
            background-color: #705541;
        }

        .total-price {
            font-weight: 700;
            font-size: 24px;
            color: #5a4636;
            margin-top: 20px;
        }

        .empty-cart {
            text-align: center;
            font-size: 22px;
            font-weight: 600;
            color: #8c6f56;
            margin-top: 50px;
        }

        .empty-cart img {
            width: 150px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container">
        <h1>Your Cart</h1>
        <?php if (empty($cart_items)): ?>
            <div class="empty-cart">
                <h2>Your cart is empty.</h2>
                <img src="path_to_empty_cart_image.png" alt="Empty Cart">
            </div>
        <?php else: ?>
            <table class="table table-striped table-bordered table-hover mt-4">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>$<?php echo htmlspecialchars($item['price_per_day']); ?></td>
                            <td>
                                <a href="remove_from_cart.php?product_id=<?php echo $item['product_id']; ?>" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-right">
                <h4 class="total-price">Total Price: $<?php echo number_format($total_price, 2); ?></h4>
                <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
