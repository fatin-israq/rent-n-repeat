<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Rent N Repeat</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
        }

        .contact-container {
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .contact-info {
            margin-top: 40px;
        }

        .contact-info h4 {
            color: #007bff;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #343a40;
            color: white;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <div class="content">
        <div class="container contact-container">
            <div class="contact-header">
                <h1>Contact Us</h1>
                <p>We'd love to hear from you! Fill out the form below, and we'll get back to you as soon as possible.</p>
            </div>

            <!-- Contact Information -->
            <div class="contact-info text-center mt-5">
                <h4>Our Office</h4>
                <p>United City, Madani Avenue, Vatara, Dhaka, Bangladesh</p>

                <h4>Email</h4>
                <p><a href="mailto:support@rentnrepeat.com">support@rentnrepeat.com</a></p>

                <h4>Phone</h4>
                <p>01777961600</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>