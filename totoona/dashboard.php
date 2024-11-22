<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Facility Management</title>
    <style>
        /* Main Dashboard Layout */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }
        
        /* Reservation Card Styling */
        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: scale(1.03);
        }

        /* Image Styling */
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: center;
        }

        /* Card Content Styling */
        .card-content {
            padding: 20px;
            color: #333;
        }

        .card-content h2 {
            margin: 0;
            font-size: 20px;
            color: #3aafa9;
        }

        .card-content p {
            margin: 10px 0;
            font-size: 14px;
            color: #666;
        }

        /* Form Styles */
        .reservation-form {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        /* No Reservations Message */
        .no-reservations {
            text-align: center;
            font-size: 1.5em;
            color: #777;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div id="module-content"></div>

    <script>
        // Function to load approved reservations and add reservation form
        function loadSubmodule2() {
            clearModuleContent(); // Clear previous module content

            const moduleContent = document.getElementById("module-content");
            moduleContent.innerHTML = `<?php
              $servername = "localhost:3307";
              $username = "root";
              $password = "";
              $dbname = "facility_reservation";

              $conn = new mysqli($servername, $username, $password, $dbname);
              if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }

              // Fetch approved reservations
              $sql = "SELECT * FROM reservations WHERE status = 'approved'";
              $result = $conn->query($sql);
              
              if (!$result) {
                  die("Query failed: " . $conn->error); // Debugging output
              }
            ?>

            <div class="reservation-form">
                <h2>Add Reservation</h2>
                <form action="add_reservation.php" method="POST">
                    <div class="form-group">
                        <label for="user_name">Your Name:</label>
                        <input type="text" id="user_name" name="user_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="facility_name">Select Facility:</label>
                        <select id="facility_name" name="facility_name" required>
                            <option value="Conference Room">Conference Room</option>
                            <option value="Basketball Court">Basketball Court</option>
                            <option value="Banquet Hall">Banquet Hall</option>
                            <option value="Gymnasium">Gymnasium</option>
                            <option value="Community Hall">Community Hall</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reservation_date">Reservation Date:</label>
                        <input type="date" id="reservation_date" name="reservation_date" required>
                    </div>
                    <div class="form-group">
                        <label for="start_time">Start Time:</label>
                        <input type="time" id="start_time" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label for="end_time">End Time:</label>
                        <input type="time" id="end_time" name="end_time" required>
                    </div>
                    <div class="form-group">
                        <label for="additional_requests">Additional Requests:</label>
                        <input type="text" id="additional_requests" name="additional_requests">
                    </div>
                    <button type="submit">Add Reservation</button>
                </form>
            </div>

            <style>
            /* Existing styles for reservations display */
            </style>

            <div class="dashboard">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Set image path based on facility name
                        $imageUrl = '';
                        switch ($row['facility_name']) {
                            case 'Basketball Court': $imageUrl = 'kort.jpg'; break;
                            case 'Gymnasium': $imageUrl = 'gym.jpg'; break;
                            case 'Community Hall': $imageUrl = 'brgy.jpg'; break;
                            case 'Banquet Hall': $imageUrl = 'banket.jpg'; break;
                            case 'Conference Room': $imageUrl = 'confe.jpg'; break;
                        }
                        ?>
                        <div class="card" data-id="<?php echo $row['id']; ?>">
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo $row['facility_name']; ?>">
                            <div class="card-content">
                                <h2><?php echo $row['facility_name']; ?></h2>
                                <p>Reserved by: <?php echo $row['user_name']; ?></p>
                                <p>Status: Approved</p>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='no-reservations'>No approved reservations found.</div>";
                }
                ?>
            </div>
            `;
        }

        // Clear module content (this function should be defined according to your application)
        function clearModuleContent() {
            const moduleContent = document.getElementById("module-content");
            moduleContent.innerHTML = "";
        }
    </script>
</body>
</html>
