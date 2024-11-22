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

if (isset($_POST['reservation_id']) && isset($_POST['status'])) {
    $reservation_id = $conn->real_escape_string($_POST['reservation_id']);
    $status = $conn->real_escape_string($_POST['status']); // 'approved' or 'rejected'

    // Update the reservation status
    $sql = "UPDATE reservations SET status='$status' WHERE id='$reservation_id'";

    if ($conn->query($sql) === TRUE) {
        // Fetch user details to create a notification
        $sql = "SELECT user_name, email, facility_name, reservation_date, start_time, end_time, additional_request, purpose FROM reservations WHERE id='$reservation_id'";
        $result = $conn->query($sql);
        $reservation = $result->fetch_assoc();

        $user_name = $reservation['user_name'];
        $email = $reservation['email'];
        $facility_name = $reservation['facility_name'];
        $reservation_date = $reservation['reservation_date'];
        $start_time = $reservation['start_time'];
        $end_time = $reservation['end_time'];
        $additional_request = $reservation['additional_request'];
        $purpose = $reservation['purpose'];

        // Create a notification message reflecting the updated status
        $message = "Reservation for $user_name ($email) has been $status.<br>
                    Facility: $facility_name<br>
                    Date: $reservation_date<br>
                    Start Time: $start_time<br>
                    End Time: $end_time<br>
                    Additional Requests: " . ($additional_request ? $additional_request : 'None') . "<br>
                    Purpose: $purpose<br>";

        // Insert the notification into the notifications table
        $sql = "INSERT INTO notifications (user_id, message) VALUES ('$email', '$message')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Reservation status updated and notification sent']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send notification']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update reservation status']);
    }

    $conn->close();
}
?>
