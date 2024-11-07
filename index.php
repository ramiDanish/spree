<?php
session_start();

include 'includes/db_connection.php'; 

function fetchRecentProducts($conn) {
    $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT 6";
    return $conn->query($sql);
}

function fetchFeaturedProducts($conn) {
    $sql = "SELECT * FROM products WHERE featured = 1 ORDER BY created_at DESC LIMIT 6";
    return $conn->query($sql);
}

function renderProductCard($item) {
    $button = isset($_SESSION['user_id']) 
        ? '<button class="btn btn-success" onclick="addToCart(' . $item['id'] . ')">Add to Cart</button>' 
        : '<button class="btn btn-secondary" disabled>You need to login to place order</button>';
    
    return '
        <div class="col-md-4">
            <div class="card product-card mb-4">
                <img src="' . htmlspecialchars($item['image_url']) . '" class="card-img-top" alt="' . htmlspecialchars($item['title']) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($item['title']) . '</h5>
                    <p class="card-text">' . htmlspecialchars($item['description']) . '</p>
                    <p class="card-text">Price: $' . htmlspecialchars($item['price']) . '</p>
                    ' . $button . '
                </div>
            </div>
        </div>';
}

$resultRecent = fetchRecentProducts($conn);
$resultFeatured = fetchFeaturedProducts($conn);
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-4">

    <!-- Promotions Banner -->
    <div class="row promotions-banner mt-4">
        <div class="col-md-12 text-center">
            <h2 class="mt-4 fw-700">Promotions</h2>
            <div class="alert alert-info d-inline-block mt-3">
                <strong>Special Offer!</strong> Get 50% off all products until the end of the month!
            </div>
            <p class="lead mt-2">Don't miss out on our latest deals!</p>
            <div class="promotion-image mb-3">
                <img src="assets/images/promotion.jpg" alt="Promotional Banner" class="img-fluid">
            </div>
            <div class="promotion-details mb-4">
                <h3>Why Shop with Us?</h3>
                
                <ul class="list-unstyled mt-3">
                    <li><i class="la la-check-circle"></i> Free shipping on orders over $50</li>
                    <li><i class="la la-check-circle"></i> 30-day money-back guarantee</li>
                    <li><i class="la la-check-circle"></i> 24/7 customer support</li>
                    <li><i class="la la-check-circle"></i> Exclusive discounts for newsletter subscribers</li>
                </ul>
            </div>
            <div class="mt-3">
                <a href="products.php" class="btn btn-outline-primary btn-lg">Shop Now</a>
            </div>
        </div>
    </div>

    <hr class="section-divider">

    <!-- Recent Products Slider -->
    <h2 class="mt-4">Recent Products</h2>
    <div id="recentProductsCarousel" class="carousel slide multi-item-carousel mt-4" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            if ($resultRecent->num_rows > 0) {
                $items = [];
                while ($row = $resultRecent->fetch_assoc()) {
                    $items[] = $row;
                }

                foreach (array_chunk($items, 3) as $index => $chunk) {
                    echo '<div class="carousel-item' . ($index === 0 ? ' active' : '') . '">';
                    echo '<div class="row">';
                    foreach ($chunk as $item) {
                        echo renderProductCard($item);
                    }
                    echo '</div></div>'; // Close row and carousel-item
                }
            } else {
                echo "<p>No recent products available.</p>";
            }
            ?>
        </div>
    </div>

    <hr class="section-divider">

    <!-- Featured Products Section -->
    <h2 class="mt-4">Featured Products</h2>
    <div class="row mt-4">
        <?php
        if ($resultFeatured->num_rows > 0) {
            while ($row = $resultFeatured->fetch_assoc()) {
                echo renderProductCard($row);
            }
        } else {
            echo "<p>No featured products available.</p>";
        }
        ?>
    </div>

    <hr class="section-divider">

    <!-- Testimonials Section -->
    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <h2>What Our Customers Say</h2>
            <div class="testimonial mt-4">
                <blockquote class="blockquote">
                    <p class="mb-0">"Fantastic products and even better service!"</p>
                    <div class="blockquote-footer">John Doe</div>
                </blockquote>
            </div>
            <div class="testimonial">
                <blockquote class="blockquote">
                    <p class="mb-0">"I love the quality and variety of products!"</p>
                    <div class="blockquote-footer">Jane Smith</div>
                </blockquote>
            </div>
        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>

<script src="assets/js/main.js"></script>

<?php
$conn->close();
?>