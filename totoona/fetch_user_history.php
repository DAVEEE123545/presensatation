<?php
// Database connection details
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "facility_reservation";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for database connection errors
if ($conn->connect_error) {
    echo "<p>Connection failed: " . htmlspecialchars($conn->connect_error) . "</p>";
    exit;
}

// Prepare the SQL query to retrieve all reservations
$query = $conn->prepare("SELECT * FROM reservations ORDER BY reservation_date DESC");
$query->execute();
$result = $query->get_result(); // Get the result set

// Check if the query returned any results
if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Determine the image URL based on facility name
        $imageUrl = '';
        switch ($row['facility_name']) {
            case 'Barangay Health Center Consultation Rooms': $imageUrl = 'brgyhealth.jpg'; break;
                            case 'Barangay Library': $imageUrl = 'library.jpg'; break;
                            case 'Barangay Plaza': $imageUrl = 'plaza.jpg'; break;
                            case 'Barangay Covered Court': $imageUrl = 'kort.jpg'; break;
                            case 'Barangay Multi-purpose Hall': $imageUrl = 'multipurpose.jpg'; break; // Default image if facility name does not match
        }
        ?>

        <!-- Display each reservation card -->
        <div class="card" data-id="<?php echo htmlspecialchars($row['id']); ?>">
            <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($row['facility_name']); ?>">
            <div class="card-content">
                <h2><?php echo htmlspecialchars($row['facility_name']); ?></h2>
                <p>Reserved by: <?php echo htmlspecialchars($row['user_name']); ?></p>
                <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
                <p>Date: <?php echo htmlspecialchars($row['reservation_date']); ?></p>
                <p>Time: <?php echo htmlspecialchars($row['start_time']); ?> - <?php echo htmlspecialchars($row['end_time']); ?></p>
                <p>Additional Request: <?php echo isset($row['additional_requests']) ? htmlspecialchars($row['additional_requests']) : 'N/A'; ?></p>
                <p>Purpose: <?php echo htmlspecialchars($row['purpose']); ?></p>
               
            </div>
        </div>
        <?php
    }
} else {
    echo "<p>No reservation history found.</p>";
}

// Close the database connection
$query->close();
$conn->close();
?>
