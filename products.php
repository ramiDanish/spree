<?php

session_start(); 

include 'includes/db_connection.php'; 

// Get selected category from the form submission
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch categories for the filter
$categorySql = "SELECT * FROM categories ORDER BY name";
$categoryResult = $conn->query($categorySql);

// Fetch products based on selected category
if ($selectedCategory) {
    $sql = "SELECT * FROM products WHERE category_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedCategory);
} else {
    $sql = "SELECT * FROM products ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<?php include 'includes/header.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar">
                    <h5>Filter by Category</h5>
                    <form id="filterForm" method="GET" action="products.php">
                        <select class="form-control" name="category" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <?php
                            // Populate categories dynamically
                            if ($categoryResult->num_rows > 0) {
                                while ($category = $categoryResult->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($category['id']) . '"';
                                    if ($selectedCategory == $category['id']) echo ' selected';
                                    echo '>' . htmlspecialchars($category['name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>

            <div class="col-md-9">
                <!-- Search Bar -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search products..." id="searchInput" onkeyup="searchProducts()">
                </div>

                <p id="searchNone" class="search-none mt-4">No products available.</p>

                <div class="row products-list" id="productList">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-md-4 mb-4">';
                            echo '<div class="card product-card">';
                            echo '<img src="' . htmlspecialchars($row['image_url']) . '" class="card-img-top" alt="' . htmlspecialchars($row['title']) . '">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';
                            echo '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
                            echo '<p class="card-text">Price: $' . htmlspecialchars($row['price']) . '</p>';

                            // Check if user is logged in
                            if (isset($_SESSION['user_id'])) {
                                echo '<button class="btn btn-success" onclick="addToCart(' . $row['id'] . ')">Add to Cart</button>';
                            } else {
                                echo '<button class="btn btn-secondary" disabled>You need to login to place order</button>';
                            }

                            echo '</div></div></div>';
                        }
                    } else {
                        echo "<p>No products available.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/main.js"></script>


<?php
$stmt->close();
$conn->close();
?>