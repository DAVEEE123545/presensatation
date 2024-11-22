<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #84fab0, #8fd3f4);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 800px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: row;
        }

        .container:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .left-section {
            width: 35%;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            padding: 30px;
            text-align: center;
            border-right: 1px solid #e0e0e0;
            color: white;
        }

        .left-section img {
            border-radius: 50%;
            width: 140px;
            height: 140px;
            object-fit: cover;
            margin-bottom: 15px;
            border: 4px solid white;
        }

        .left-section h2 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .left-section p {
            color: #ddd;
            font-size: 14px;
        }

        .right-section {
            width: 65%;
            padding: 20px;
        }

        .profile-info {
            margin-bottom: 30px;
        }

        .profile-info h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #333;
        }

        .profile-info p {
            margin-bottom: 8px;
            color: #555;
            font-size: 14px;
        }

        .profile-info p strong {
            font-weight: 600;
        }

        .project-status {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .status-card {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .status-card h4 {
            font-size: 15px;
            margin-bottom: 10px;
            color: #777;
        }

        .status-card p {
            margin-bottom: 6px;
            font-size: 13px;
            color: #666;
        }

        .progress-bar {
            height: 6px;
            background-color: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar span {
            display: block;
            height: 100%;
            background-color: #007bff;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .left-section {
                width: 100%;
                padding: 20px;
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
            }

            .right-section {
                width: 100%;
                padding: 20px;
            }

            .project-status {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .left-section img {
                width: 100px;
                height: 100px;
            }

            .left-section h2 {
                font-size: 18px;
            }

            .profile-info h3 {
                font-size: 18px;
            }

            .profile-info p {
                font-size: 13px;
            }

            .status-card h4 {
                font-size: 13px;
            }

            .status-card p {
                font-size: 12px;
            }

            .progress-bar {
                height: 5px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <img src="wa.jpg" alt="Profile Picture">
            <h2>User</h2>
            <p>Full Stack Developer<br>Quezon city, Sauyo rd. Lipton st.</p>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="profile-info">
                <h3>Profile Information</h3>
                <p><strong>Full Name:</strong> User</p>
                <p><strong>Email:</strong> user1@example.com</p>
                <p><strong>Phone:</strong> 123456</p>
                <p><strong>Mobile:</strong> 123456</p>
                <p><strong>Address:</strong> Quezon city, Sauyo rd. Lipton st.</p>
            </div>

            <div class="project-status">
                <div class="status-card">
                    <h4>STATUS</h4>
                    <p>Facility Member</p>
                    <div class="progress-bar">
                        <span style="width: 80%;"></span>
                    </div>
                    <p>Website Markup</p>
                    <div class="progress-bar">
                        <span style="width: 65%;"></span>
                    </div>
                    <p>One Page</p>
                    <div class="progress-bar">
                        <span style="width: 90%;"></span>
                    </div>
                </div>

                <div class="status-card">
                    <h4>ROLE</h4>
                    <p>Mobile Template</p>
                    <div class="progress-bar">
                        <span style="width: 60%;"></span>
                    </div>
                    <p>Facility Coordinator</p>
                    <div class="progress-bar">
                        <span style="width: 85%;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
