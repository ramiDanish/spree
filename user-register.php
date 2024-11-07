<?php include 'includes/header.php'; ?>

    <div class="login-forum">
    <div class="register-container">
        <h2 class="text-center">Register</h2>
        <form id="registerForm">
            <div class="form-group">
                <input type="text" class="form-control" id="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" id="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="user-login.php">Login here</a></p>
        </div>
    </div>
    </div>
<?php include 'includes/footer.php'; ?>

<script src="assets/js/main.js"></script>

