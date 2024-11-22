<?php
// Get the notification ID from the request
$notificationId = $_GET['id'];

// Connect to the database (replace with your DB credentials)
$conn = new mysqli("localhost:3307", "root", "", "facility_reservation");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL query to delete notification
$sql = "DELETE FROM notifications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $notificationId);

// Execute the query
if ($stmt->execute()) {
    // After deletion, return the updated count of unread notifications
    $result = $conn->query("SELECT COUNT(*) AS unread_count FROM notifications WHERE is_read = 0");
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'unreadCount' => $row['unread_count']]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>
