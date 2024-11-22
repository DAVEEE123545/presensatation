<?php
session_start();
include 'db_connect.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $user_id = $_SESSION['user_id']; // Assuming you have the user ID in the session
    $file = $_FILES['profile_image'];

    // Check for errors
    if ($file['error'] === 0) {
        // Set the upload directory
        $uploadDir = 'uploads/';
        $fileName = basename($file['name']);
        $filePath = $uploadDir . $fileName;

        // Validate the file type (optional)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            echo 'Invalid file type';
            exit;
        }

        // Move the uploaded file to the server
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Update the user's profile image in the database
            $stmt = $db->prepare("UPDATE users SET profile_image = ? WHERE user_id = ?");
            $stmt->execute([$fileName, $user_id]);

            echo 'Profile image updated successfully';
        } else {
            echo 'Error uploading the image';
        }
    } else {
        echo 'Error with the file upload';
    }
} else {
    echo 'No image uploaded';
}
?>
