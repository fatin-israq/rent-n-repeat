<?php

// Sample function to fetch featured products

function getFeaturedProducts()
{
    include('db_connect.php');

    $sql = "SELECT product_id, product_name, price_per_day, image_path FROM Product WHERE is_available = 1 LIMIT 3";
    $result = mysqli_query($conn, $sql);

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    return $products;
}
