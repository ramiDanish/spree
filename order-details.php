<?php 
session_start();

include 'includes/db_connection.php';
include 'includes/header.php'; 
include 'includes/functions.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order details
$user_id = $_SESSION['user_id'];
$sql = "SELECT o.order_date, o.shipping_address, o.total_amount, p.title, p.price, op.quantity 
        FROM orders o 
        JOIN order_products op ON o.id = op.order_id 
        JOIN products p ON op.product_id = p.id 
        WHERE o.id = ? AND o.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

?>

<div class="container order-details">
    <h2>Order Details</h2>
    
    <?php if ($order): ?>
        <h4>Order ID: <?php echo htmlspecialchars($order_id); ?></h4>
        <p><strong>Date:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($order['order_date']))); ?></p>
        <p><strong>Shipping Address:</strong> <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
        <p><strong>Total Price:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>

        <h4>Products:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Resetting the statement to fetch products
                $stmt->execute();
                $products = $stmt->get_result();

                while ($product = $products->fetch_assoc()):
                    
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['title']); ?></td>
                    <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Order not found.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>

<style>
.order-details {
    margin: 20px auto;
    max-width: 800px;
}

.order-details h2 {
    text-align: center;
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 12px;
    text-align: left;
}

.table th {
    background-color: #f8f9fa;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}
</style>