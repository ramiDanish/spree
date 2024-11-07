
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">SPREE</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_SERVER['SCRIPT_NAME'] == '/index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_SERVER['SCRIPT_NAME'] == '/products.php') ? 'active' : ''; ?>" href="products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_SERVER['SCRIPT_NAME'] == '/about.php') ? 'active' : ''; ?>" href="about.php">About Us</a>
                </li>
            </ul>
            <div class="nav-icons">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="navbar-text mr-2">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</span>
                    <div class="nav-item cart-icon" id="cartIcon">
                        <a href="cart.php">
                        <i class="las la-shopping-cart" title="View Cart"></i>
                        </a>
                        
                    </div>
                    <a class="nav-item" href="order-history.php" title="Order History">
                        <i class="las la-history"></i>

                    </a>
                    <a class="nav-item" href="ajax/logout.php" title="Logout">
                    <i class="las la-sign-out-alt"></i>
                    </a>
                <?php else: ?>
                    <a class="nav-item" href="user-login.php" title="Login">
                        <i class="las la-user"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
