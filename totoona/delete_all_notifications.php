<?php
// Connect to the database (replace with your DB credentials)
$conn = new mysqli("localhost:3307", "root", "", "facility_reservation");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL query to delete all notifications
$sql = "DELETE FROM notifications";
if ($conn->query($sql) === TRUE) {
    // After deletion, return the updated count of unread notifications
    $result = $conn->query("SELECT COUNT(*) AS unread_count FROM notifications WHERE is_read = 0");
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'unreadCount' => $row['unread_count']]);
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>
