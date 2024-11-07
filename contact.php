<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <h2>Contact Us</h2>
    <p>If you have any questions, feel free to reach out to us using the form below:</p>

    <form action="contact_submit.php" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>

    <hr>

    <h5>Contact Information</h5>
    <p>Email: support@example.com</p>
    <p>Phone: (123) 456-7890</p>
</div>

<?php include 'includes/footer.php'; ?>