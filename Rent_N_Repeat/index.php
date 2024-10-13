<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Clothing Rental Platform</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="new_style.css">
    <style>
        .hero-content h1 {
            font-weight: 600;
            animation: slideInFromLeft 1s ease-out;
        }

        .hero-content p {
            animation: slideInFromRight 1s ease-out;
        }

        @keyframes slideInFromLeft {
            0% {
                opacity: 0;
                transform: translateX(-100px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInFromRight {
            0% {
                opacity: 0;
                transform: translateX(100px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .btn-beige {
            background-color: beige;
            color: brown;
            /* Choose text color that contrasts well with beige */
            border: 2px solid beige !important;
        }

        .btn-beige:hover {
            background-color: #d2b48c;
            /* Change color on hover */
        }

        .btn-beige:active {
            background-color: #6F4E37;
            /* Change color on button press */
        }

        .btn-outline-coffee {
            color: #6f4e37;
            border-color: #6f4e37;
            border-width: 2px !important;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .btn-outline-coffee:hover {
            background-color: #6f4e37;
            /* Coffee background on hover */
            color: white;
            /* Text turns white when hovered */
        }

        .btn-dark-blue {
            background-color: #495867 !important;
            /* Dark bluish-gray background */
            color: white !important;
            /* White text */
            border: 1px solid #495867;
            /* Ensure the button has a border */
            padding: 0.375rem 0.75rem;
            /* Padding to make it look like a button */
            border-radius: 0.25rem;
            /* Add border-radius to look like Bootstrap buttons */
            display: inline-block;
            /* Make it behave like a button */
        }

        .btn-dark-blue:hover {
            background-color: #394452 !important;
            /* Darker shade on hover */
            border-color: #394452 !important;
            /* Darker border on hover */
        }
    </style>

</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <!-- Hero Section -->
    <section class="bg-light d-flex align-items-center justify-content-center hero-content" style="background-image: url('https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center; height: 70vh; color:white;">
        <div class="container">
            <h1 class="display-4">Rent Clothing Easily & Make Money Renting Out Yours</h1>
            <p class="lead">Discover a wide variety of fashion items, and start renting today! As people say, Fake it till you make it!</p>
            <a href="browse.php" class="btn btn-beige btn-lg me-3">Browse Products</a>
            <a href="register.php" class="btn btn-lg" style="background-color: #6f4e37; color: white;">Become a lessee</a>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured-products py-5">
        <div class="container">
            <h2 class="text-center mb-4" style="color: #6f4e37;">Featured Products</h2>
            <div class="row">
                <?php
                // Assuming a function getFeaturedProducts() that fetches data from your database.
                include('functions.php');
                $products = getFeaturedProducts(); // Retrieve product data from your database.

                foreach ($products as $product) {
                    echo '
                <div class="col-md-4">
                    <div class="card mb-4 h-100">
                        <img src="' . $product['image_path'] . '" class="card-img-top" alt="Product Image" style="height: 250px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">' . $product['product_name'] . '</h5>
                                <h2 class="card-text"><strong>$' . $product['price_per_day'] . '</strong> <small style="font-size: 0.5em;">per day</small></h2>
                                <a href="product.php?id=' . $product['product_id'] . '" class="btn btn-dark-blue mt-auto">Rent Now</a>
                            </div>
                    </div>
                </div>';
                }
                ?>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-5">
        <div class="container">
            <h2 class="mb-4"><strong>How It Works</strong></h2>
            <div class="col-md-6">
                <h3>1. Register</h3>
                <big>
                    <p>Create an account by providing basic details.</p>
                </big>
            </div>
            <div class="col-md-6">
                <h3>2. Lessor</h3>
                <big>
                    <p>If you own items you want to rent out, become a lessor by listing them for others to rent.</p>
                </big>

            </div>
            <div class="col-md-6">
                <h3>3. Lessee</h3>
                <big>
                    <p>If you want to rent products, browse through the listed items and rent as a lessee.</p>
                </big>
            </div>
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