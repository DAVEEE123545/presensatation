<?php
// Get the reservation ID from the URL
$id = $_GET['id'];

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "facility_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the existing reservation details
$sql = "SELECT * FROM reservations WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Reservation not found.";
    exit();
}

$update_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $facility_name = $_POST['facility_name'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $reservation_date = $_POST['reservation_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $additional_request = $_POST['additional_request'];
    $purpose = $_POST['purpose'];

    $update_sql = "UPDATE reservations SET 
        facility_name='$facility_name',
        user_name='$user_name',
        email='$email',
        reservation_date='$reservation_date',
        start_time='$start_time',
        end_time='$end_time',
        additional_request='$additional_request',
        purpose='$purpose'
        WHERE id=$id";

    if ($conn->query($update_sql) === TRUE) {
        $update_success = true;
    } else {
        echo "Error updating reservation: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
            margin-top: 40px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: #333;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="email"], input[type="date"], input[type="time"], textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus, textarea:focus {
            border-color: #3aafa9;
            box-shadow: 0 0 8px rgba(58, 175, 169, 0.2);
        }

        textarea {
            resize: none;
            height: 100px;
            width: 100%; /* Ensures textareas take the full width of their container */
        }

        .full-width {
            grid-column: span 2;
        }

        .side-by-side {
            display: flex;
            gap: 20px;
            grid-column: span 2;
        }

        .side-by-side div {
            flex: 1; /* Equal width for both textareas */
        }

        .btn-container {
            grid-column: span 2;
            text-align: center;
        }

        input[type="submit"] {
            background-color: #3aafa9;
            color: white;
            padding: 10px 20px; /* Adjusted for smaller size */
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2b7e6e;
        }

        .cancel-button {
            background-color: #f44336; /* Red color for cancel button */
            color: white;
            padding: 10px 20px; /* Adjusted for smaller size */
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-left: 10px; /* Space between buttons */
        }

        .cancel-button:hover {
            background-color: #c62828; /* Darker red on hover */
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Mobile View (Less than 768px) */
        @media (max-width: 768px) {
            form {
                grid-template-columns: 1fr; /* Single-column layout for smaller screens */
            }

            .full-width {
                grid-column: span 1;
            }

            .side-by-side {
                flex-direction: column; /* Stack fields on top of each other */
                gap: 10px; /* Reduce gap size */
            }

            .cancel-button {
                margin-top: 10px; /* Add space above the cancel button */
            }
        }

        /* Tablet View (768px to 1024px) */
        @media (min-width: 768px) and (max-width: 1024px) {
            .container {
                padding: 25px;
            }

            form {
                gap: 15px; /* Reduce gap size */
            }
        }
    </style>
</head>
<body>

<div class="container">
    <?php if ($update_success): ?>
        <div class="success-message">
            <script>
                alert('Edit successfully');
                window.location.href = 'admin_dashboards.php';  // Redirect after the alert
            </script>
        </div>
    <?php endif; ?>

    <h2>Edit Reservation</h2>
    <form method="post" action="edit_reservation.php?id=<?php echo $id; ?>">
        <div>
            <label for="facility_name">Facility Name</label>
            <input type="text" id="facility_name" name="facility_name" value="<?php echo $row['facility_name']; ?>" required>
        </div>
        <div>
            <label for="user_name">Reserved by</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo $row['user_name']; ?>" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
        </div>
        <div>
            <label for="reservation_date">Reservation Date</label>
            <input type="date" id="reservation_date" name="reservation_date" value="<?php echo $row['reservation_date']; ?>" required>
        </div>
        <div>
            <label for="start_time">Start Time</label>
            <input type="time" id="start_time" name="start_time" value="<?php echo $row['start_time']; ?>" required>
        </div>
        <div>
            <label for="end_time">End Time</label>
            <input type="time" id="end_time" name="end_time" value="<?php echo $row['end_time']; ?>" required>
        </div>
        <div class="side-by-side">
            <div>
                <label for="additional_request">Additional Request</label>
                <textarea id="additional_request" name="additional_request"><?php echo $row['additional_request']; ?></textarea>
            </div>
            <div>
                <label for="purpose">Purpose</label>
                <textarea id="purpose" name="purpose"><?php echo $row['purpose']; ?></textarea>
            </div>
        </div>
        <div class="btn-container">
            <input type="submit" value="Update Reservation">
            <button type="button" class="cancel-button" onclick="window.location.href='admin_dashboards.php'">Cancel</button>
        </div>
    </form>
</div>

</body>
</html>
