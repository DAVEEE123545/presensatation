<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "facility_reservation";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $user_name = $conn->real_escape_string(trim($_POST['user_name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $facility_name = $conn->real_escape_string(trim($_POST['facility_name']));
    $reservation_date = $conn->real_escape_string(trim($_POST['reservation_date']));
    $start_time = $conn->real_escape_string(trim($_POST['start_time']));
    $end_time = $conn->real_escape_string(trim($_POST['end_time']));
    $additional_requests = $conn->real_escape_string(trim($_POST['additional_requests']));
    $purpose = $conn->real_escape_string(trim($_POST['purpose']));
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        
        // Check if the upload directory exists, create if it doesn't
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Prepare the SQL query
            $sql = "INSERT INTO reservations (user_name, email, facility_name, reservation_date, start_time, end_time, additional_request, purpose, image_path) 
                    VALUES ('$user_name', '$email', '$facility_name', '$reservation_date', '$start_time', '$end_time', '$additional_requests', '$purpose', '$target_file')";
            
            // Execute the query
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Image upload failed."]);
        }
    } else {
        // Handle the case where no image is uploaded
        echo json_encode(["status" => "error", "message" => "No image uploaded or there was an upload error."]);
    }
}

// Close the connection
$conn->close();
?>
