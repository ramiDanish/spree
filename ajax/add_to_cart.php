<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get product ID from the request
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

// Check if the product ID is valid
if ($product_id > 0) {
    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // Increase quantity
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        // Add new product with quantity 1
        $_SESSION['cart'][$product_id] = [
            'quantity' => 1,
        ];
    }

    echo json_encode(["success" => true, "cart" => $_SESSION['cart']]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid product."]);
}
?>