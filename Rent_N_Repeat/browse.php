<?php
session_start();
include('db_connect.php'); // Include your database connection

// Function to get products based on search or default (all)
function getProducts($conn, $searchTerm = '', $sort = '')
{
    // Base query
    $sql = "SELECT * FROM Product WHERE 1"; // WHERE 1 allows adding additional conditions easily

    // Add search conditions if a search term is provided
    if ($searchTerm) {
        $sql .= " AND (product_name LIKE ? OR product_type LIKE ?)";
    }

    // Add sorting and filtering conditions
    if ($sort == 'name_asc') {
        $sql .= " ORDER BY product_name ASC";
    } elseif ($sort == 'name_desc') {
        $sql .= " ORDER BY product_name DESC";
    } elseif ($sort == 'price_asc') {
        $sql .= " ORDER BY price_per_day ASC";
    } elseif ($sort == 'price_desc') {
        $sql .= " ORDER BY price_per_day DESC";
    } elseif ($sort == 'available') {
        $sql .= " AND is_available = 1"; // Show only available items
    } elseif ($sort == 'unavailable') {
        $sql .= " AND is_available = 0"; // Show only unavailable items
    }

    // Prepare statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind search term if provided
    if ($searchTerm) {
        $searchTerm = "%" . $searchTerm . "%";
        mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
    }

    // Execute statement
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch results
    $products = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }

    return $products;
}



// Check if the user submitted the search form
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : '';

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Fetch products (with or without search)
$products = getProducts($conn, $searchTerm, $sortOption);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Products - Clothing Rental Platform</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="new_style.css">
</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <!-- Search Bar -->
    <section class="container py-3">
        <form method="GET" action="browse.php" class="form-inline justify-content-between">
            <div>
            <input type="text" name="search" class="form-control mr-sm-2" placeholder="Search by name or type" style="width: 500px; " value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit" class="btn" style="background-color: #6f4e37; color: white;">Search</button></div>

            <!-- Sort Dropdown -->
            <select name="sort" class="form-control ml-sm-2" onchange="this.form.submit()">
                <option value="">Sort by</option>
                <option value="name_asc" <?php if ($sortOption == 'name_asc') echo 'selected'; ?>>Name (A-Z)</option>
                <option value="name_desc" <?php if ($sortOption == 'name_desc') echo 'selected'; ?>>Name (Z-A)</option>
                <option value="price_asc" <?php if ($sortOption == 'price_asc') echo 'selected'; ?>>Price (Low to High)</option>
                <option value="price_desc" <?php if ($sortOption == 'price_desc') echo 'selected'; ?>>Price (High to Low)</option>
                <option value="available" <?php if ($sortOption == 'available') echo 'selected'; ?>>Available</option>
                <option value="unavailable" <?php if ($sortOption == 'unavailable') echo 'selected'; ?>>Unavailable</option>
            </select>

        </form>
    </section>

    <!-- Browse Products Section -->
    <section class="container py-5">
        <h2 class="text-center mb-4" style="color: #6f4e37;">Browse Products</h2>
        <div class="row">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <!-- Determine if the product is available -->
                    <?php $isAvailable = $product['is_available'] == 1; ?>

                    <!-- product cards  -->
                    <div class="col-md-4 mb-4 d-flex align-items-stretch">
                        <div class="card w-100 h-100" style="<?php echo !$isAvailable ? 'opacity: 0.6;' : ''; ?>">
                            <!-- Product Image -->
                            <img src="<?php echo htmlspecialchars($product['image_path']); ?>" class="card-img-top img-fluid" alt="Product Image" style="height: 250px; object-fit: cover;">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                <p class="card-text flex-grow-1">
                                    <strong>Type:</strong> <?php echo htmlspecialchars($product['product_type']); ?><br>
                                    <strong>Size:</strong> <?php echo htmlspecialchars($product['size']); ?><br>
                                    <strong>
                                        <h2>$<?php echo htmlspecialchars($product['price_per_day']); ?></h2>
                                    </strong>
                                </p>

                                <?php if ($isAvailable): ?>
                                    <a href="product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-dark-blue mt-auto">View Details</a>
                                <?php else: ?>
                                    <span class="btn btn-danger mt-auto">Unavailable</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No products available at the moment.</p>
            <?php endif; ?>
        </div>

    </section>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>