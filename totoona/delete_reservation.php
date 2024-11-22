<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "facility_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the ID is set
if (isset($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);
    
    // Prepare and execute delete statement
    $sql = "DELETE FROM reservations WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        // Success
        echo json_encode(['status' => 'success']);
    } else {
        // Error
        echo json_encode(['status' => 'error', 'message' => 'Could not delete reservation.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No ID provided.']);
}

$conn->close();
?>
