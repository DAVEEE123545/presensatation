<?php
// Database connection
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "facility_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the AJAX request
$id = $_POST['id'];
$action = $_POST['action']; // "approve" or "reject"

// Update the status of the reservation
$status = ($action === 'approve') ? 'approved' : 'rejected';
$sql = "UPDATE reservations SET status='$status' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // Send notification to the user
    $reservation_sql = "SELECT * FROM reservations WHERE id=$id";
    $result = $conn->query($reservation_sql);
    $reservation = $result->fetch_assoc();
    $user_email = $reservation['email'];
    $user_name = $reservation['user_name'];
    $facility_name = $reservation['facility_name'];
    $reservation_date = $reservation['reservation_date'];
    $start_time = $reservation['start_time'];
    $end_time = $reservation['end_time'];
    $status_message = ucfirst($status);

    // Create the notification message
    $notification_message = "Your reservation for $facility_name on $reservation_date from $start_time to $end_time has been $status_message.";
    
    $notification_sql = "INSERT INTO notifications (user_id, message, is_read) 
                         VALUES ('$user_email', '$notification_message', 0)";
    $conn->query($notification_sql);

    // Return a success response in JSON format
    echo json_encode(['status' => 'success', 'message' => 'Reservation status updated and notification sent.']);
} else {
    // Return an error response
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
?>
