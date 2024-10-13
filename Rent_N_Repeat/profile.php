<?php
session_start();
include('db_connect.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch user profile details based on role
if ($role == 'lessor') {
    $query = "SELECT * FROM lessor WHERE user_id = ?";
} else {
    $query = "SELECT * FROM lessee WHERE user_id = ?";
}

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Update user information (if form is submitted)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $profile_image = $user['profile_image'];

    // Handle profile picture upload
    if ($_FILES['profile_image']['name']) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["profile_image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
                $profile_image = $targetFile; // Set the new profile image path
            } else {
                echo "Failed to upload image.";
                exit();
            }
        } else {
            echo "File is not an image.";
            exit();
        }
    }

    // Update query based on role
    if ($role == 'lessor') {
        $update_query = "UPDATE lessor SET name = ?, contact_no = ?, address = ?, profile_image = ? WHERE user_id = ?";
    } else {
        $update_query = "UPDATE lessee SET name = ?, contact_no = ?, address = ?, profile_image = ? WHERE user_id = ?";
    }

    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $contact, $address, $profile_image, $user_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Refresh page to reflect updated info
        header("Location: profile.php");
        exit();
    } else {
        echo "Failed to update profile!";
    }
}

function getListings($conn, $user_id)
{
    $query = "SELECT * FROM Product WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $listings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $listings[] = $row;
    }
    return $listings;
}

// Function to fetch the lessee's past orders
function getPastOrders($conn, $user_id)
{
    $query = "SELECT o.*, p.product_name as product_name
          FROM `order` as o
          JOIN order_details od ON o.transaction_id = od.transaction_id
          JOIN product p ON od.product_id = p.product_id
          WHERE o.lessee_id = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    return $orders;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile - RENT N REPEAT</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="new_style.css">
</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h2 class="mb-4 text-center"><?php echo ucfirst($role); ?> Profile</h2>

        <div class="card shadow-sm p-4">
            <div class="row align-items-center">
                <!-- Profile Picture Column -->
                <div class="col-md-3 text-center mb-4">
                    <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Picture" class="img-fluid rounded-circle border" style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <!-- User Details Column -->
                <div class="col-md-9">
                    <div class="px-3">
                        <h4 class="mb-3" style="font-weight: 600;"><?php echo htmlspecialchars($user['name']); ?></h4>
                        <p class="mb-2"><i class="fas fa-phone-alt me-2 text-muted"></i><strong>Contact:</strong> <?php echo htmlspecialchars($user['contact_no']); ?></p>
                        <p><i class="fas fa-map-marker-alt me-2 text-muted"></i><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <!-- Update Info Button -->
        <button class="btn btn-coffee mb-3" data-toggle="modal" data-target="#updateInfoModal">Update User Information</button>

        <!-- Update Info Modal -->
        <div class="modal fade" id="updateInfoModal" tabindex="-1" role="dialog" aria-labelledby="updateInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateInfoModalLabel">Update Your Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateInfoForm" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($user['contact_no']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="profile_image">Profile Image</label>
                                <input type="file" class="form-control" id="profile_image" name="profile_image">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Role-based content (Listings or Orders) -->
        <?php if ($role == 'lessor'): ?>
            <h3>Your Listings</h3>
            <a href="create_listing.php" class="btn btn-dark-blue mb-3">Create New Listing</a>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Cloth Name</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Price/Day</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $listings = getListings($conn, $user_id);
                    foreach ($listings as $listing):
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($listing['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($listing['product_type']); ?></td>
                            <td><?php echo htmlspecialchars($listing['size']); ?></td>
                            <td>$<?php echo htmlspecialchars($listing['price_per_day']); ?></td>
                            <td>
                                <a href="edit_listing.php?id=<?php echo $listing['product_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_listing.php?id=<?php echo $listing['product_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($listings)): ?>
                        <tr>
                            <td colspan="5" class="text-center">You have no listings.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        <?php else: ?>
            <h3>Your Past Orders</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Rental Date</th>
                        <th>Return Date</th>
                        <th>Amount Paid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $orders = getPastOrders($conn, $user_id);
                    foreach ($orders as $order):
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['transaction_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['end_date']); ?></td>
                            <td>$<?php echo htmlspecialchars($order['total_price']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="5" class="text-center">You have no past orders.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>