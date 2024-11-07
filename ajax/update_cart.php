<?php 
session_start();

// Include database connection
include 'includes/db_connection.php'; 

// Handle quantity update
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['quantity'];

    // Ensure the quantity is a valid number
    if (is_numeric($new_quantity)) {
        if ($new_quantity > 0) {
            $_SESSION['cart'][$product_id]['quantity'] = (int)$new_quantity; // Update quantity
        } else {
            unset($_SESSION['cart'][$product_id]); // Remove item if quantity is zero
        }
    }

    // Send a JSON response back
    echo json_encode(['success' => true]);
    exit();
}
?>