<?php
session_start();

include '../includes/db_connection.php'; 

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validate input
if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit();
}

$stmt = $conn->prepare("SELECT id, name , password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

// Check if user exists
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id,$name, $hashed_password);
    $stmt->fetch();

    // Verify the password
    if (password_verify($password, $hashed_password)) {
        // Password is correct, set session variables
        $_SESSION['user_id'] = $id;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name; // Assuming you fetched this from the database


        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid password.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No user found with that email.']);
}

$stmt->close();
$conn->close();
?>