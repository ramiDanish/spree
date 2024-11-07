<?php
session_start();
include '../includes/db_connection.php';

$errors = [];

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $item) {
        $orderedQuantity = (int)$item['quantity'];
        // Fetch product details
        $sql = "SELECT quantity, title FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $product = $result->fetch_assoc();
                $availableQuantity = (int)$product['quantity'];

                if ($orderedQuantity > $availableQuantity) {
                    $errors[] = "The quantity for " . htmlspecialchars($product['title']) . " exceeds available stock.";
                }
            } else {
                $errors[] = "Product not found.";
            }
        } else {
            $errors[] = "Database error. Please try again.";
        }
    }
}

if (!empty($errors)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'messages' => $errors]);
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
}
exit();
?>