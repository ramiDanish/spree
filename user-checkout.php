<?php 
session_start();

include 'includes/db_connection.php';
include 'includes/header.php'; 
include 'includes/functions.php'; 

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}
?>

<div class="container checkout">
    <h2>Checkout</h2>
    <form id="checkoutForm">
        <div class="form-group">
            <label for="shipping_address">Shipping Address</label>
            <textarea class="form-control" id="shipping_address" name="shipping_address" required></textarea>
        </div>
        <div class="form-group">
            <label for="notes">Notes (optional)</label>
            <textarea class="form-control" id="notes" name="notes"></textarea>
        </div>
        
        
        <h3>Your Cart Items</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_amount = 0; 
                foreach ($_SESSION['cart'] as $product_id => $item): 
                    $product = getProductDetails($conn, $product_id); 
                    if ($product):
                        $subtotal = $item['quantity'] * $product['price']; 
                        $total_amount += $subtotal; 
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['title']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php 
                    endif; 
                endforeach; 
                ?>
            </tbody>
        </table>
        
        <div class="text-center">
            <div class="total-price">Total: $<?php echo number_format($total_amount, 2); ?></div>
            <input type="hidden" id="total_amount" name="total_amount" value="<?php echo htmlspecialchars($total_amount); ?>">

            <button type="submit" class="btn btn-primary">Place Order</button>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
<script src="assets/js/main.js"></script>

