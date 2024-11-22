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

// Initialize search variable
$search = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
    $sql = "SELECT * FROM reservations WHERE user_name LIKE '%$search%' OR facility_name LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM reservations";
}

$result = $conn->query($sql);

// Output the search results as HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="card" data-id="<?php echo $row['id']; ?>">
            <img src="path_to_image.jpg" alt="<?php echo $row['facility_name']; ?>">
            <div class="card-content">
                <h2><?php echo $row['facility_name']; ?></h2>
                <p class="facility">Facility: <?php echo $row['facility_name']; ?></p>
                <p>Reserved by: <?php echo $row['user_name']; ?></p>
                <p>Email: <?php echo $row['email']; ?></p>
                <p>Date: <?php echo $row['reservation_date']; ?></p>
                <p>Time: <?php echo $row['start_time']; ?> - <?php echo $row['end_time']; ?></p>
                <p>Additional Request: <?php echo $row['additional_request']; ?></p>
                <p>Purpose: <?php echo $row['purpose']; ?></p>
                <p class="status <?php echo $row['status']; ?>">Status: <?php echo ucfirst($row['status']); ?></p>
                <div class="actions">
                    <button class="approve-btn" onclick="updateReservationStatus(<?php echo $row['id']; ?>, 'approve')">Approve</button>
                    <button class="reject-btn" onclick="updateReservationStatus(<?php echo $row['id']; ?>, 'reject')">Reject</button>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "No reservations found.";
}

$conn->close();
?>
