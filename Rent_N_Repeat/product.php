<?php
session_start();
include('db_connect.php');

if (!isset($_GET['id'])) {
    echo "Product not found!";
    exit;
}

$product_id = $_GET['id'];

$sql = "SELECT * FROM Product WHERE product_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found!";
    exit;
}

function getRelatedProducts($product_type, $current_product_id)
{
    include('db_connect.php');
    $sql = "SELECT * FROM Product WHERE product_type = ? AND product_id != ? LIMIT 3";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $product_type, $current_product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $related_products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $related_products[] = $row;
    }

    return $related_products;
}

// Fetch reviews for the current product
$sql = "SELECT Review.rating, Review.comment, Review.review_date, lessor.name FROM Review JOIN Lessor ON Review.user_id = lessor.user_id WHERE Review.product_id = ? ORDER BY Review.review_date DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$reviews = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reviews[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - Clothing Rental Platform</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="new_style.css">
</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <!-- Product Details Section -->
    <section class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <!-- High Quality Image Section -->
                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="Product Image" class="img-fluid rounded shadow" style="max-height: 700px;">
            </div>
            <div class="col-md-6">
                <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
                <p><strong>Type:</strong> <?php echo htmlspecialchars($product['product_type']); ?></p>
                <p><strong>Size:</strong> <?php echo htmlspecialchars($product['size']); ?></p>
                <p><strong>Price per day:</strong> $<?php echo htmlspecialchars($product['price_per_day']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($product['product_description']); ?></p>

                <!-- Rent Now Button -->
                <a href="add_to_cart.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-beige btn-lg">Add to Cart</a>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-coffee btn-lg" data-toggle="modal" data-target="#reviewModal">
                    Submit a Review
                </button>

                <!-- Modal -->
                <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reviewModalLabel">Submit a Review</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="submit_review.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <div class="form-group">
                                        <label for="rating">Rating</label>
                                        <select name="rating" id="rating" class="form-control">
                                            <option value="5">5 - Excellent</option>
                                            <option value="4">4 - Good</option>
                                            <option value="3">3 - Average</option>
                                            <option value="2">2 - Poor</option>
                                            <option value="1">1 - Terrible</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
                                        <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="container py-5">
        <h3>Related Products</h3>
        <div class="row">
            <?php
            $related_products = getRelatedProducts($product['product_type'], $product['product_id']);

            foreach ($related_products as $related) {
                echo '
                <div class="col-md-4">
                    <div class="card mb-4 h-100">
                        <img src="' . $related['image_path'] . '" class="card-img-top" alt="' . $related['product_name'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $related['product_name'] . '</h5>
                            <p class="card-text">$' . $related['price_per_day'] . ' / day</p>
                            <a href="product.php?id=' . $related['product_id'] . '" class="btn btn-primary">View Product</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>