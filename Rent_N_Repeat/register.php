<?php
// Include database connection file
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $nid = $_POST['nid'];
    $role = $_POST['role'];  // lessee or lessor
    $contact_no = $_POST['contact_no'];
    $address = $_POST['address'];

    if ($role == 'lessee') {
        // Insert into lessee table
        $sql = "INSERT INTO lessee (nid, name, email, password, contact_no, address) VALUES ('$nid', '$name', '$email', '$password', '$contact_no', '$address')";
    } else if ($role == 'lessor') {
        // Insert into lessor table
        $sql = "INSERT INTO lessor (nid, name, email, password, contact_no, address) VALUES ('$nid', '$name', '$email', '$password', '$contact_no', '$address')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3e7dc;
            font-family: 'Roboto', sans-serif;
        }

        .auth-container {
            max-width: 420px;
            margin: 0 auto;
            margin-top: 30px;
            padding: 10px 15px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .auth-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .auth-header img {
            width: 60px;
        }

        .auth-header h1 {
            font-size: 28px;
            margin-left: 15px;
            color: #5a4636;
        }

        .card {
            border: none;
        }

        .card-body {
            padding: 0px 30px;
        }

        h3 {
            color: #5a4636;
            font-weight: 600;
            margin: 0;
        }

        .form-group label {
            color: #8c6f56;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #d1bfa8;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #a07449;
        }

        .btn-primary {
            background-color: #8c6f56;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #705541;
        }

        .form-text a {
            color: #8c6f56;
            font-weight: 500;
        }

        .form-text a:hover {
            color: #705541;
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <!-- Logo and Website Name -->
        <div class="auth-header d-flex align-items-center justify-content-center mb-4" style="margin: 0px !important;">
            <img src="./uploads/LOGO.png" alt="Website Logo" class="logo-img">
            <h1 class="ml-3">Rent N Repeat</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">Register</h3>
                <form action="register.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="nid">NID</label>
                        <input type="text" class="form-control" name="nid" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" class="form-control" name="contact_no" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" required>
                            <option value="lessee">lessee</option>
                            <option value="lessor">lessor</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
                <small class="form-text text-center mt-3">
                    Already have an account? <a href="login.php">Login here</a>
                </small>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>