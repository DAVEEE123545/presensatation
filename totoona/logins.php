<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0.1;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e8e9f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            width: 80%;
            max-width: 1000px;
            background-color: #3f1919;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            overflow: hidden;
            transition: 0.3s ease;
            position: relative;
        }

        .container:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        }

        .left-section {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f1f1f1;
            padding: 40px;
        }

        .illustration {
            max-width: 100%;
            border-radius: 10px;
        }

        .right-section {
            width: 50%;
            padding: 50px;
            background-color: #f8faff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .header-section {
            position: relative;
            margin-bottom: 30px;
        }

        .header-section img {
            position: absolute;
            top: -10px;
            right: -10px;
            max-width: 175px;
            transition: transform 0.3s ease;
        }

        .header-section h2 {
            font-size: 2.2em;
            color: #0b0c18;
            text-transform: capitalize;
            line-height: 1.2;
            margin: 0;
            padding-top: 30px;
        }

        .login-form {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 14px 20px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .input-group input:focus {
            border-color: #007BFF;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            color: #555;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #555;
        }

        .options a {
            color: #007BFF;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .options a:hover {
            color: #0056b3;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background-color: #191d67;
            color: #e8e9f7;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background-color: #0056b3;
        }

        .signup {
            text-align: center;
            margin-top: 1px;
            font-size: 14px;
            color: #141db8;
        }

        .signup a {
            color: #757be6;
            text-decoration: none;
            font-weight: 600;
        }

        .signup a:hover {
            color: #0056b3;
        }

        /* Media query for mobile devices */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 90%;
            }

            .left-section,
            .right-section {
                width: 100%;
                padding: 20px;
            }

            .header-section h2 {
                font-size: 1.8em;
                text-align: center;
                padding-top: 10px;
            }

            .header-section img {
                position: static;
                margin: 0 auto;
                display: block;
                max-width: 150px;
            }

            .login-btn {
                font-size: 14px;
            }

            .illustration {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="left-section">
            <img src="logo.png" alt="Illustration" class="illustration">
        </div>
        <div class="right-section">
            <div class="header-section">
                <h2>Welcome to,</br> Facility </br> Reservation Management</h2>
            </div>
            <form action="login.php" method="POST" class="login-form">
                <div class="input-group">
                    <input type="text" id="username_or_email" name="username_or_email" placeholder="Username or Email" required>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="eye-icon" id="togglePassword">&#128065;</span>
                </div>
                <div class="options">
                    <label>
                        <input type="checkbox" id="rememberMe"> Remember Me
                    </label>
                    <a href="createpass.html">Forgot Password?</a>
                </div>
                <button type="submit" class="login-btn">Sign In</button>
            </form>
            <div class="signup">
                <p>Don't have an account? <a href="registers.php">Register here</a></p>
            </div>
        </div>
    </div>
    <script>
             document.addEventListener("DOMContentLoaded", function () {
            // Check if remember me is checked and populate the fields
            if (localStorage.getItem("rememberMe") === "true") {
                document.getElementById("username_or_email").value = localStorage.getItem("username_or_email");
                document.getElementById("password").value = localStorage.getItem("password");
                document.getElementById("rememberMe").checked = true;
            }

            // Show/Hide password functionality with open and closed eyes
            const togglePassword = document.getElementById("togglePassword");
            const passwordField = document.getElementById("password");

            togglePassword.addEventListener("click", function () {
                const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
                passwordField.setAttribute("type", type);

                // Change icon based on visibility
                if (type === "password") {
                    this.innerHTML = "&#128065;"; // Closed Eye
                } else {
                    this.innerHTML = "&#128578;"; // Open Eye
                }
            });

            // Store credentials on form submit
            document.querySelector(".login-form").addEventListener("submit", function () {
                const rememberMe = document.getElementById("rememberMe").checked;
                const usernameOrEmail = document.getElementById("username_or_email").value;
                const password = document.getElementById("password").value;

                // Use the "Remember Me" feature to save credentials in localStorage
                if (rememberMe) {
                    localStorage.setItem("rememberMe", "true");
                    localStorage.setItem("username_or_email", usernameOrEmail);
                    localStorage.setItem("password", password); // Store password
                } else {
                    localStorage.removeItem("rememberMe");
                    localStorage.removeItem("username_or_email");
                    localStorage.removeItem("password");
                }

                // Trigger the browser's built-in save password prompt by submitting the form
                // This will allow the browser to offer saving the password to its password manager
            });
        });
    </script>
</body>

</html>
