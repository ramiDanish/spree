<?php 
session_start();

// Include database connection
include '../includes/db_connection.php';

// Redirect if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Your cart is empty.']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shipping_address = trim($_POST['shipping_address']);
    $notes = trim($_POST['notes']);
    $total_amount = $_POST['total_amount'];
    $user_id = $_SESSION['user_id'];

    // Create a new order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, shipping_address, notes, total_amount, order_date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("issd", $user_id, $shipping_address, $notes, $total_amount);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id; // Get the new order ID
        $stmt->close();

        // Insert order items and decrease stock quantity
        foreach ($_SESSION['cart'] as $product_id => $item) {
            // Insert order items
            $stmt = $conn->prepare("INSERT INTO order_products (order_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $order_id, $product_id, $item['quantity']);
            $stmt->execute();
            $stmt->close();

            // Decrease product quantity in the products table
            $stmt = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
            $stmt->bind_param("ii", $item['quantity'], $product_id);
            $stmt->execute();
            $stmt->close();
        }

        // Clear the cart after checkout
        unset($_SESSION['cart']);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create order.']);
    }
}
?>