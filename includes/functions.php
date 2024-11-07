<?php function getProductDetails($conn, $product_id) {
    $stmt = $conn->prepare("SELECT title, image_url, price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $product = null;
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }

    $stmt->close();
    return $product;
}


?>