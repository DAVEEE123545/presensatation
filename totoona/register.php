<?php
require 'db_connect.php'; // Include the database connection

// Database connection
$conn = new mysqli("localhost:3307", "root", "", "user_systems");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fullname = $_POST['fullname']; // Use 'fullname' to match HTML form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; // Use 'confirm_password' to match HTML form
    $gender = $_POST['gender'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Check for strong password (at least 8 characters and one uppercase letter)
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password)) {
        echo "Password must be at least 8 characters long and include at least one uppercase letter.";
        exit();
    }

    // Determine if the user is an admin based on the password
    if (strlen($password) <= 6 && strpos($password, 'admin') === 0) {
        // Admin registration
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare and bind for admin registration
        $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, phone, password, gender, role) VALUES (?, ?, ?, ?, ?, ?, 'admin')");
        $stmt->bind_param("sssssss", $fullname, $username, $email, $phone, $hashed_password, $gender);

        if ($stmt->execute()) {
            echo "Admin registered successfully. Redirecting to admin dashboard...";
            header("Location: admin_dashboards.php"); // Redirect to admin dashboard
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        // Regular user registration
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind for user registration
        $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, phone, password, gender, role) VALUES (?, ?, ?, ?, ?, ?, 'user')");
        $stmt->bind_param("ssssss", $fullname, $username, $email, $phone, $hashed_password, $gender);

        if ($stmt->execute()) {
            echo "User registered successfully. Redirecting to user dashboard...";
            header("Location: user_dashboards.php"); // Redirect to user dashboard
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
