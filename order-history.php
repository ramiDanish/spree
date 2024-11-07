<?php 
session_start();

include 'includes/db_connection.php';
include 'includes/header.php'; 
include 'includes/functions.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user's orders
$user_id = $_SESSION['user_id'];
$sql = "SELECT o.id AS order_id, o.order_date, o.shipping_address, o.total_amount 
        FROM orders o 
        WHERE o.user_id = ? 
        ORDER BY o.order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container order-history">
    <h2>Your Order History</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Shipping Address</th>
                    <th>Total Price</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars(date('F j, Y', strtotime($order['order_date']))); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></td>
                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td><a href="order-details.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-info">View Details</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>

<style>
.order-history {
    margin: 20px auto;
    max-width: 800px;
}

.order-history h2 {
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

.btn-info {
    background-color: #007bff;
    color: white;
    padding: 8px 12px;
    text-decoration: none;
    border: none;
    border-radius: 4px;
}

.btn-info:hover {
    background-color: #0056b3;
}
</style>