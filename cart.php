<?php 
session_start();

include 'includes/db_connection.php'; 
include 'includes/functions.php'; 

// Handle removing items from the cart
if (isset($_POST['remove'])) {
    $product_id = (int)$_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    header("Location: cart.php"); 
    exit();
}

// Handle updating quantity
if (isset($_POST['update_quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $new_quantity = (int)$_POST['quantity'];
    
    if ($new_quantity > 0) {
        $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
    } else {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: cart.php"); 
    exit();
}

// Handle checkout process
if (isset($_POST['checkout'])) {
    $errors = [];

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

    if (!empty($errors)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'messages' => $errors]);
        exit();
    }

    header("Location: user-checkout.php");
    exit();
}

include 'includes/header.php'; 
?>

<div class="container text-center cart">
    <h2>Your Cart</h2>
    <?php 
    $total_amount = 0; 

    if (!empty($_SESSION['cart'])): ?>
        <div class="cart-item mt-4">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $product_id => $item): 
                $product = getProductDetails($conn, $product_id); 
                if ($product): 
                    $subtotal = $item['quantity'] * $product['price']; 
                    $total_amount += $subtotal; 
            ?>
            <tr>
                <td data-label="Image"><img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="product-image_url" /></td>
                <td data-label="Product Name"><?php echo htmlspecialchars($product['title']); ?></td>
                <td data-label="Quantity">
                    <form method="POST" action="" class="quantity-form">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                        <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="quantity-input" />
                        <button class="btn btn-success" type="submit" name="update_quantity">Update</button>
                    </form>
                </td>
                <td data-label="Price">$<?php echo number_format($product['price'], 2); ?></td>
                <td data-label="Subtotal">$<?php echo number_format($subtotal, 2); ?></td>
                <td data-label="Remove">
                    <form method="POST" action="">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                        <button type="submit" name="remove" class="remove-button">Remove</button>
                    </form>
                </td>
            </tr>
            <?php 
                endif; 
            endforeach; 
            ?>
        </tbody>
    </table>
</div>
        <div class="text-center">
            <div class="total-price">Total: $<?php echo number_format($total_amount, 2); ?></div>
            <form method="POST" action="" class="checkout-form">
                <button type="submit" name="checkout" class="checkout-button">Proceed to Checkout</button>
            </form>
        </div>
    <?php else: ?>
        <p style="font-weight: 600; margin-top:150px">Your cart is empty.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
<script src="assets/js/main.js"></script>
<script>

</script>