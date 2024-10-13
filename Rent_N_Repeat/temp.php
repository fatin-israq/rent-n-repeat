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

    // Handle profile picture upload
    if ($_FILES['profile_image']['name']) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["profile_image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
                $profile_image = $targetFile; 
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        $profile_image = $user['profile_image']; 
    }

    // Update query based on role
    if ($role == 'lessor') {
        $update_query = "UPDATE lessor SET name = ?, contact_no = ?, address = ?, profile_image = ? WHERE user_id = ?";
    } else {
        $update_query = "UPDATE lessee SET name = ?, contact_no = ?, address = ?, profile_image = ? WHERE user_id = ?";
    }

    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "sssii", $name, $contact, $address, $profile_image, $user_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Failed to update profile!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h2>Your Profile (<?php echo ucfirst($role); ?>)</h2>

        <!-- Display profile picture -->
        <div class="mb-4">
            <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Picture" class="img-thumbnail" width="150" height="150">
        </div>

        <div class="mb-4">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Contact:</strong> <?php echo htmlspecialchars($user['contact_no']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
        </div>

        <!-- Update Info Button -->
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#updateInfoModal">Update User Information</button>

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
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>