<?php
$response = [];

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $response['success'] = true;
    $response['cart'] = $_SESSION['cart'];
} else {
    $response['success'] = false;
}

echo json_encode($response);
?>