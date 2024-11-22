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

// Insert reservation into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $conn->real_escape_string($_POST['user_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $facility_name = $conn->real_escape_string($_POST['facility_name']);
    $reservation_date = $conn->real_escape_string($_POST['reservation_date']);
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);
    $additional_request = $conn->real_escape_string($_POST['additional_request']);
    $purpose = $conn->real_escape_string($_POST['purpose']);

    // Insert reservation into the reservations table
    $sql = "INSERT INTO reservations (user_name, email, facility_name, reservation_date, start_time, end_time, additional_request, purpose)
            VALUES ('$user_name', '$email', '$facility_name', '$reservation_date', '$start_time', '$end_time', '$additional_request', '$purpose')";

    if ($conn->query($sql) === TRUE) {
        // Get the last inserted reservation ID
        $reservation_id = $conn->insert_id;

        // Create the notification message
        $notification_message = "Reservation for $user_name ($email)<br>
                                 Facility: $facility_name<br>
                                 Date: $reservation_date<br>
                                 Start Time: $start_time<br>
                                 End Time: $end_time<br>
                                 Additional Requests: " . ($additional_request ?: 'None') . "<br>
                                 Purpose: $purpose<br>
                                 Status: pending";

        // Insert notification into the notifications table
        $notification_sql = "INSERT INTO notifications (user_id, message, is_read) 
                             VALUES ('$email', '$notification_message', 0)"; // Use $email as the user_id

        if ($conn->query($notification_sql) === TRUE) {
            // Return a success response in JSON format
            echo json_encode(['status' => 'success', 'message' => 'Reservation created successfully']);
        } else {
            // Return an error response for the notification
            echo json_encode(['status' => 'error', 'message' => 'Reservation created, but failed to create notification: ' . $conn->error]);
        }
    } else {
        // Return an error response in JSON format
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
    }

    $conn->close();
}
?>
