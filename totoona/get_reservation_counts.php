<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "facility_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare counts
$totalReservations = 0;
$approvedCount = 0;
$pendingCount = 0;
$rejectedCount = 0;

// Query to get total reservations
$sql = "SELECT COUNT(*) as count FROM reservations";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $totalReservations = $row['count'];
} else {
    echo "Error: " . $conn->error; // Debug output
}

// Repeat similar error handling for other counts...

// Query to get approved count
$sql = "SELECT COUNT(*) as count FROM reservations WHERE status = 'approved'";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $approvedCount = $row['count'];
} else {
    echo "Error: " . $conn->error; // Debug output
}

// Query to get pending count
$sql = "SELECT COUNT(*) as count FROM reservations WHERE status = 'pending'";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $pendingCount = $row['count'];
} else {
    echo "Error: " . $conn->error; // Debug output
}

// Query to get rejected count
$sql = "SELECT COUNT(*) as count FROM reservations WHERE status = 'rejected'";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $rejectedCount = $row['count'];
} else {
    echo "Error: " . $conn->error; // Debug output
}

// Return counts as JSON
echo json_encode([
    'totalReservations' => $totalReservations,
    'approvedCount' => $approvedCount,
    'pendingCount' => $pendingCount,
    'rejectedCount' => $rejectedCount,
]);

$conn->close();
?>
