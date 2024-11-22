<?php
session_start();

// Include the database connection file
include 'db_connect.php'; // Ensure the path to 'db.php' is correct

// Handle the login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    // SQL query to find user by username or email
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";

    if ($stmt = $conn->prepare($sql)) { // Prepare the SQL statement
        $stmt->bind_param("ss", $username_or_email, $username_or_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];

                // Check if password matches the admin password
                if ($password === "admin123456") {
                    header("Location: admin_dashboards.php");
                    exit();
                } else {
                    header("Location: user_dashboards.php");
                    exit();
                }
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that username or email.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
}

$conn->close(); // Close the database connection
?>
