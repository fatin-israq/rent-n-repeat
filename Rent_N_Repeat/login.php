<?php
include 'db_connect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $sql = "";

    if ($role == 'admin') {
        $sql = "SELECT * FROM admin WHERE email = ?";
    } else if ($role == 'lessee') {
        $sql = "SELECT * FROM lessee WHERE email = ?";
    } else if ($role == 'lessor') {
        $sql = "SELECT * FROM lessor WHERE email = ?";
    }

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    
        if ($role == 'admin') {
            // Direct comparison for admin since the password is not hashed
            if ($password === $user['password']) {
                // Admin password matches
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = 'admin';
                echo "Admin login successful!";
                header("Location: admin_dashboard.php");
                exit;
            } else {
                echo "Invalid admin password!";
            }
        } else {
            // Use password_verify for lessee/lessor
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $role;
                echo "Login successful!";
                header("Location: index.php");
                exit;
            } else {
                echo "Invalid password!";
            }
        }
    } else {
        echo "No user found with that email!";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            padding: 30px 15px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .auth-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
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
            padding: 5px 30px;
        }

        h3 {
            color: #5a4636;
            font-weight: 600;
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
        <div class="auth-header d-flex align-items-center justify-content-center mb-4">
            <img src="./uploads/LOGO.png" alt="Website Logo" class="logo-img">
            <h1 class="ml-3">Rent N Repeat</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">Login</h3>
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" required>
                            <option value="lessee">Lessee</option>
                            <option value="lessor">Lessor</option>
                            <option value="admin">Admin</option> 
                        </select>

                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <small class="form-text text-center mt-3">
                    Don't have an account? <a href="register.php">Register here</a>
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