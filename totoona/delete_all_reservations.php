<?php
$servername = "localhost:3307";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "facility_reservation"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the reservation ID from POST
$reservationId = $_POST['id'];

// Sanitize the input to prevent SQL injection
$reservationId = intval($reservationId);

// Check if reservation exists before deleting
$checkQuery = "SELECT * FROM reservations WHERE id = $reservationId";
$result = $conn->query($checkQuery);

$response = array();

// If the reservation exists
if ($result->num_rows > 0) {
    // Prepare the SQL query to delete the reservation
    $query = "DELETE FROM reservations WHERE id = $reservationId";

    if ($conn->query($query) === TRUE) {
        // Return success in JSON format
        $response['status'] = 'success';
    } else {
        // Return error in JSON format
        $response['status'] = 'error';
        $response['message'] = $conn->error;
    }
} else {
    // Return error if reservation doesn't exist
    $response['status'] = 'error';
    $response['message'] = 'Reservation ID does not exist.';
}

echo json_encode($response); // Return the response as JSON

$conn->close();
?>
