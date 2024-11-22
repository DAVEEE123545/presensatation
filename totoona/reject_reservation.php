<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "facility_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "UPDATE reservations SET status='Rejected' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboards.php?message=rejected_successfully");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
