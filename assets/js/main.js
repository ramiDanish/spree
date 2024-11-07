
// assets/js/main.js

// Function to add a product to the cart
function addToCart(productId) {
    $.ajax({
        url: 'ajax/add_to_cart.php',
        type: 'POST',
        dataType: 'json',
        data: {
            product_id: productId
        },
        success: function(response) {
            if (response.success) {
                swal("Success!", "Product added to cart!", "success");
            } else {
                swal("Error!", response.message || "Error adding product to cart.", "error");
            }
        },
        error: function() {
            swal("Error!", "An error occurred. Please try again.", "error");
        }
    });
}

// Function to search for a product to the products menu
function searchProducts() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const productCards = document.querySelectorAll('.product-card');
    const noResult = document.getElementById('searchNone');

    let hasResults = false; // Flag to track if any results found

    productCards.forEach(card => {
        const title = card.querySelector('.card-title').innerText.toLowerCase();
        if (title.includes(input)) {
            card.parentNode.style.display = 'block';
            hasResults = true; // Found a matching product
        } else {
            card.parentNode.style.display = 'none';
        }
    });

    // Show or hide the no results message
    noResult.style.display = hasResults ? 'none' : 'block';
}

$(document).ready(function() {
    // Checkout from submission
    $('#checkoutForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            type: 'POST',
            url: 'ajax/checkout.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {

                if (response.success) {
                    swal("Success!",'Order successful!',"success");
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 3000);
                    
                } else {
                    swal("Error!", response.message || "Error creating order!", "error");
                }
            },
            error: function(e) {
                console.log(e);
                swal("Error!", "An error occurred. Please try again.", "error");
            }
        });
    });
    // Registration form submission
    $('#registerForm').on('submit', function(e) {
        e.preventDefault(); 
        
        // Get form data
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();

        if (password.length < 8) {
            swal("Error!", "Passwords needs to be at least 8 characters long!", "error");
            return;
        }

        if (password !== confirm_password) {
            swal("Error!", "Passwords do not match!", "error");
            return;
        }

        $.ajax({
            url: 'ajax/register.php', 
            type: 'POST',
            dataType: 'json',
            data: {
                name: name,
                email: email,
                password: password
            },
            success: function(response) {
                if (response.success) {
                    swal('Registration successful! You can now log in.',"success");
                    window.location.href = 'user-login.php'; // Redirect to login page
                } else {
                    swal("Error!", response.message || "Error registering!.", "error");
                }
            },
            error: function() {
                swal("Error!", "An error occurred. Please try again.", "error");
            }
        });
    });

    // Login form submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            url: 'ajax/login.php', 
            type: 'POST',
            dataType: 'json',
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = 'index.php'; 
                } else {
                    swal("Error!", response.message || "Error logging you in!", "error");
                }
            },
            error: function(e) {
                console.log(e);
                swal("Error!", "An error occurred. Please try again.", "error");
            }
        });
    });

    $('[data-toggle="tooltip"]').tooltip();
});
$(document).on('submit', '.checkout-form', function(event) {
    event.preventDefault(); 

    $.ajax({
        url: 'ajax/check_quantity.php', 
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            console.log(response)
            if (response.success) {
                window.location.href = 'user-checkout.php';
            } else {
                response.messages.forEach(function(message) {
                    swal("Error!", message || "Check Quantites!", "error");
                });
            }
        },
        error: function(e) {
            console.log(e);
            alert("An unexpected error occurred!");
        }
    });
});

