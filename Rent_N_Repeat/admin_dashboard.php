<?php
session_start();
include 'db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Function to delete a user
if (isset($_GET['delete_type']) && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $delete_type = $_GET['delete_type'];

    if ($delete_type == 'lessee') {
        $sql = "DELETE FROM lessee WHERE user_id = ?";
    } elseif ($delete_type == 'lessor') {
        $sql = "DELETE FROM lessor WHERE user_id = ?";
    }

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    header("Location: admin_dashboard.php");
    exit;
}

// Fetch lessees and lessors
$lessee_sql = "SELECT * FROM lessee";
$lessee_result = mysqli_query($conn, $lessee_sql);

$lessor_sql = "SELECT * FROM lessor";
$lessor_result = mysqli_query($conn, $lessor_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="new_style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="admin_dashboard.php">
            <img src="./uploads/LOGO.png" alt="Logo" width="40" height="40" class="d-inline-block align-top mr-2">
            <span>RENT N REPEAT</span>
        </a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Admin Dashboard</h2>
    
    <!-- Lessees Table -->
    <h3>Lessees</h3>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($lessee = mysqli_fetch_assoc($lessee_result)): ?>
                <tr>
                    <td><?= $lessee['user_id'] ?></td>
                    <td><?= $lessee['name'] ?></td>
                    <td><?= $lessee['email'] ?></td>
                    <td>
                        <a href="admin_dashboard.php?delete_type=lessee&user_id=<?= $lessee['user_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Lessors Table -->
    <h3>Lessors</h3>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($lessor = mysqli_fetch_assoc($lessor_result)): ?>
                <tr>
                    <td><?= $lessor['user_id'] ?></td>
                    <td><?= $lessor['name'] ?></td>
                    <td><?= $lessor['email'] ?></td>
                    <td>
                        <a href="admin_dashboard.php?delete_type=lessor&user_id=<?= $lessor['user_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
