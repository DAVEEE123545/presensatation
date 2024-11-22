<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: logins.php"); // Redirect to login page if not logged in
    exit();
}

?>


<html lang="en">
<head>
    <meta name="viewport" content="device-width", initial-scale="1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="admin_dashboards.css">
</head>
<body>
    
<body>
<script>
    // Function to clear the content area
    function clearModuleContent() {
        const moduleContent = document.getElementById("module-content");
        moduleContent.innerHTML = ''; // Clear the existing content
    }

// Function to display dashboard content
function dashboard() {
    clearModuleContent(); // Clear previous module content

    const moduleContent = document.getElementById("module-content");

    // Fetch reservation counts from the server
    fetch('get_reservation_counts.php') // Adjust path if necessary
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // Log the data for debugging
            moduleContent.innerHTML = `
                <style>
                 /* Feedback Icon Styles */
   /* Feedback Icon Animation */
        .feedback-icon {
            fill: #007bff; /* Change to your desired color */
            cursor: pointer;
            transition: transform 0.3s ease; /* Smooth transition */
        }

        .feedback-icon:hover {
            transform: scale(1.1); /* Scale up on hover */
        }
                /* General styles for the feedback dashboard */
  #adminFeedbackDashboard {
    position: fixed; /* Fixed positioning to stay on the right side */
    top: 310px; /* Adjust the vertical position */
    right: 20px; /* Fixed distance from the right edge */
    padding: 3px;
    background-color: #f9f9f9;
    border-radius: 8px;
    width: 20%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease; /* Smooth transitions */
    display: none; /* Initially hidden */
    z-index: 1000; /* Ensure it stays above other elements */
  }

  /* Styles for the feedback list */
  #feedbackList {
    max-height: 300px; /* Increased height for better visibility */
    overflow-y: auto; /* Enable vertical scrolling */
    margin-top: 10px;
    width: 100%;
    padding: 1px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: white;
  }

  /* Styles for each feedback item */
  .feedback-item {
    margin-bottom: 15px; /* Spacing between feedback items */
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #fdfdfd;
    transition: background-color 0.3s ease; /* Smooth background color change */
  }

  .feedback-item:hover {
    background-color: #f1f1f1; /* Highlight on hover */
  }

  /* Other feedback item styles */
  .feedback-item textarea {
    width: 100%;
    margin-top: 5px;
  }

  .feedback-item button {
    margin-top: 10px;
    cursor: pointer;
    background-color: #007bff; /* Primary button color */
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    transition: background-color 0.3s ease; /* Smooth background color transition */
  }

  .feedback-item button:hover {
    background-color: #0056b3; /* Darker shade on hover */
  }

                     .reservation-summary {
                        display: flex;
                        gap: 20px;
                        justify-content: center;
                        margin: 20px 0;
                    }
                    .reservation-card {
                        flex: 1;
                        max-width: 350px;
                        padding: 20px;
                        color: #fff;
                        text-align: center;
                        border-radius: 0px;
                        position: relative;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                        transition: transform 0.3s;
                    }
                    .reservation-card h3 {
                        font-size: 2.5em;
                        margin: 0;
                    }
                    .reservation-card p {
                        margin: 10px 0 0;
                    }
                    .reservation-card.approved {
                        background-color: #28a745; /* Green for approved */
                    }
                    .reservation-card.total {
                        background-color: #007bff; /* Blue for total reservations */
                    }
                    .reservation-card.pending {
                        background-color: #ffc107; /* Yellow for pending */
                    }
                    .reservation-card.rejected {
                        background-color: #dc3545; /* Red for rejected */
                    }
                    .scrollable-container {
                        height: 82vh; /* Full height of the viewport */
                        overflow-y: auto; /* Enable vertical scrolling */
                    }
                    .welcome-section {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                        background-image: url('gay.jpg'); /* Replace with your image URL */
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;
                        color: white;
                        padding: 100px;
                        border-radius: 0px;
                        margin-bottom: 20px; /* Adjust margin below */
                        text-align: center;
                        position: relative;
                        height: 300px; /* Set a fixed height for the welcome section */
                    }
                    .welcome-text {
                        position: absolute; /* Ensure the text stays above the background image */
                        z-index: 0;
                    }
                </style>
                <div class="reservation-summary">
                    <div class="reservation-card approved">
                        <h3>${data.approvedCount}</h3>
                        <p>Total Approved</p>
                    </div>
                    <div class="reservation-card total">
                        <h3>${data.totalReservations}</h3>
                        <p>Total Reservations</p>
                    </div>
                    <div class="reservation-card pending">
                        <h3>${data.pendingCount}</h3>
                        <p>Pending</p>
                    </div>
                    <div class="reservation-card rejected">
                        <h3>${data.rejectedCount}</h3>
                        <p>Rejected</p>
                    </div>
                </div>
                <div class="scrollable-container">
                    <div class="dashboard-container">
                        <!-- Welcome Section -->
                        <div class="welcome-section">
                            <div class="welcome-text">
                                <h1>Welcome to Facility Reservation</h1>
                                <p>Book and manage your facility reservations easily.</p>
                            </div>
                        </div>
                    </div>
                      <!-- Feedback Icon with Animation -->
          <div style="position: fixed; right: 20px; bottom: 20px;">
            <button id="feedbackIcon" onclick="toggleFeedbackDashboard()" style="background: none; border: none; cursor: pointer; outline: none;">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feedback-icon animate-icon"
                style="transition: transform 0.3s;"
              >
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <path d="M3 9l9-7 9 7" />
                <path d="M16 21v-8a4 4 0 0 0-8 0v8" />
              </svg>
            </button>
          </div>

     <!-- Admin Feedback Dashboard (Initially Hidden) -->
<div id="adminFeedbackDashboard">
  <h2>Feedback Dashboard</h2>
  <button onclick="deleteAllFeedbacks()" style="margin-bottom: 10px; background-color: #dc3545; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">Delete All Feedback</button>
  <div id="feedbackList"></div>
</div>
      `;
    })
    .catch(error => {
      console.error('Error fetching reservation counts:', error);
    });
}
// Toggle the feedback dashboard visibility
function toggleFeedbackDashboard() {
  const feedbackDashboard = document.getElementById("adminFeedbackDashboard");
  const isVisible = feedbackDashboard.style.display === "block";

  feedbackDashboard.style.display = isVisible ? "none" : "block"; // Toggle display

  if (!isVisible) {
    loadAdminFeedback(); // Load feedback only when opening the dashboard
  }
}

// Delete all feedback
function deleteAllFeedbacks() {
  if (confirm("Are you sure you want to delete all feedback?")) {
    localStorage.removeItem("userFeedbacks"); // Remove all feedback from storage
    alert("All feedback has been deleted.");
    loadAdminFeedback(); // Refresh feedback list
  }
}

// Delete a specific feedback
function deleteFeedback(index) {
  const feedbacks = JSON.parse(localStorage.getItem("userFeedbacks")) || [];

  if (confirm("Are you sure you want to delete this feedback?")) {
    feedbacks.splice(index, 1); // Remove the specific feedback
    localStorage.setItem("userFeedbacks", JSON.stringify(feedbacks)); // Update storage
    alert("Feedback deleted successfully.");
    loadAdminFeedback(); // Refresh feedback list
  }
}

function loadAdminFeedback() {
  const feedbackList = document.getElementById("feedbackList");
  const feedbacks = JSON.parse(localStorage.getItem("userFeedbacks")) || [];

  feedbackList.innerHTML = ""; // Clear existing feedback

  if (feedbacks.length === 0) {
    // Show a message if no feedback exists
    feedbackList.innerHTML = `
      <div style="text-align: center; color: #888; padding: 20px; font-size: 16px;">
        No feedback available.
      </div>
    `;
  } else {
    // Populate feedbacks
    feedbacks.forEach((feedback, index) => {
      const feedbackItem = document.createElement("div");
      feedbackItem.classList.add("feedback-item");

      feedbackItem.innerHTML = `
        <h3>User Feedback - ${feedback.type}</h3>
        <p><strong>Date:</strong> ${feedback.date}</p>
        <p><strong>Rating:</strong> ${feedback.rating} ⭐</p>
        <p><strong>Comments:</strong> ${feedback.comments}</p>
        <label for="adminResponse${index}">Admin Response:</label>
        <textarea id="adminResponse${index}" placeholder="Respond to feedback...">${feedback.response || ''}</textarea>
        <select id="status${index}">
          <option value="Pending" ${feedback.status === "Pending" ? "selected" : ""}>Pending</option>
          <option value="Reviewed" ${feedback.status === "Reviewed" ? "selected" : ""}>Reviewed</option>
        </select>
        <button onclick="saveAdminResponse(${index})">Save Response</button>
        <button onclick="deleteFeedback(${index})" style="background-color: #dc3545; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer; margin-top: 10px;">Delete Feedback</button>
      `;

      feedbackList.appendChild(feedbackItem);
    });
  }
}


// Save admin response and status update
function saveAdminResponse(index) {
  const feedbacks = JSON.parse(localStorage.getItem("userFeedbacks")) || [];
  const response = document.getElementById(`adminResponse${index}`).value;
  const status = document.getElementById(`status${index}`).value;

  feedbacks[index].response = response;
  feedbacks[index].status = status;

  localStorage.setItem("userFeedbacks", JSON.stringify(feedbacks));
  alert("Response saved successfully!");
  loadAdminFeedback(); // Refresh the feedback list to show updated data
}

// Initialize feedback dashboard on page load
document.addEventListener("DOMContentLoaded", loadAdminFeedback);







 function modules1() {
    clearModuleContent(); // Clear previous module content
    const moduleContent = document.getElementById("module-content");
    moduleContent.innerHTML = `
 <style>
    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    .calendar-container {
    display: flex; /* Use flexbox to align calendar and indicators */
    justify-content: space-between; /* Space between the calendar and indicator */
    align-items: flex-start; /* Align items at the start */
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 100%; /* Set to 100% to fit within the dashboard */
    max-width: 1350px; /* Maximum width for larger screens */
    margin: auto;
     height: 600px; 
    overflow-y: auto;
}

    .calendar {
        flex: 1; /* Allow calendar to take available space */
        margin-right: 60px; /* Space between calendar and indicators */
    }

    .controls {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-bottom: 30px;
    }

    .control-group {
        display: flex;
        flex-direction: column;
        width: 24%;
        margin-right: 10px;
    }

    label {
        margin-bottom: 5px;
        color: #555;
        font-weight: bold;
    }

    select,
    input[type="number"],
    button {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
        font-size: 14px;
        width: 100%;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }

    select:focus,
    input[type="number"]:focus {
        border-color: #4CAF50;
        outline: none;
    }

    button {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
        border: none;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #45a049;
    }

    .calendar-day {
        width: 190px;
        height: 160px;
        border: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
        display: inline-block;
        margin: 10px;
        position: relative;
        background-color: #f9f9f9;
        border-radius: 10px;
        transition: background-color 0.3s ease;
    }

    .calendar-day:hover {
        background-color: #e0e0e0;
        cursor: pointer;
    }

    .facility-status-container {
        height: 150px;
        overflow-y: auto;
        margin-top: 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 5px;
        background-color: #ffffff;
    }

    .facility-status {
        display: block;
        margin-top: 4px;
        font-size: 10px;
        border-radius: 4px;
        color: white;
        text-align: center;
        min-width: 100px;
    }

    .status-available {
        background-color: green;
    }

    .status-unavailable {
        background-color: red;
    }

    .status-maintenance {
        background-color: grey;
    }

    .status-pending {
        background-color: yellow;
        color: black;
    }

    .day-number {
        font-weight: bold;
        margin-bottom: 3px;
        font-size: 20px;
        color: #333;
    }

    .tooltip {
        visibility: hidden;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 5px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .calendar-day:hover .tooltip {
        visibility: visible;
        opacity: 1;
    }

    .indicator-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-top: 20px;
        padding-left: 20px;
    }

    .indicator {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .indicator-color {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
    }

    /* Media queries for responsive design */
    @media (max-width: 600px) {
        h1 {
            font-size: 24px; /* Adjust header size for smaller screens */
        }
        
        .calendar-container {
            flex-direction: column; /* Stack calendar and indicators */
            height: auto; /* Allow height to adjust */
            padding: 10px; /* Reduce padding */
        }

        .calendar {
            margin-right: 0; /* Remove right margin */
            margin-bottom: 20px; /* Add space below the calendar */
            width: 100%; /* Make calendar full width */
        }

        .indicator-container {
            width: 100%; /* Make indicator full width */
            padding-left: 0; /* Remove left padding */
        }

        .controls {
            flex-direction: column; /* Stack controls vertically */
        }

        .control-group {
            width: 100%; /* Make control groups full width */
            margin-right: 0;
            margin-bottom: 10px; /* Space between control groups */
        }

        .calendar-day {
            width: 100%; /* Make each calendar day full width */
            height: auto; /* Allow height to adjust */
        }
    }
</style>

<div class="calendar-container">
    <div class="calendar">
        <div class="controls">
            <div class="control-group">
                <label for="facility">Select Facility:</label>
                <select id="facility">
                    <option value="gym">Gym</option>
                    <option value="community_hall">Community Hall</option>
                    <option value="banquet_hall">Banquet Hall</option>
                    <option value="basketball_court">Basketball Court</option>
                    <option value="conference_room">Conference Room</option>
                </select>
            </div>
            <div class="control-group">
                <label for="month">Month:</label>
                <select id="month" onchange="generateCalendar()">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
            <div class="control-group">
                <label for="year">Year:</label>
                <input type="number" id="year" min="2023" placeholder="Year" onchange="generateCalendar()">
            </div>
            <div class="control-group">
                <label for="status">Set Status:</label>
                <select id="status">
                    <option value="available">Available</option>
                    <option value="unavailable">Unavailable</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="pending">Pending</option>
                </select>
                <input type="hidden" id="selectedDay" />
                <button onclick="setStatus()">Set Status</button>
            </div>
        </div>
        <h3>Calendar:</h3>
        <div id="admin-calendar"></div>
    </div>
    <div class="indicator-container">
        <h4>Status Indicators:</h4>
        <div class="indicator"><div class="indicator-color status-available"></div> <span>Available</span></div>
        <div class="indicator"><div class="indicator-color status-unavailable"></div> <span>Unavailable</span></div>
        <div class="indicator"><div class="indicator-color status-maintenance"></div> <span>Maintenance</span></div>
        <div class="indicator"><div class="indicator-color status-pending"></div> <span>Pending</span></div>
    </div>
</div>


    `;
}
function generateCalendar() {
            const month = document.getElementById("month").value;
            const year = document.getElementById("year").value;
            const calendarContainer = document.getElementById("admin-calendar");

            // Clear previous calendar
            calendarContainer.innerHTML = '';

            if (!year) {
                alert("Please enter a valid year.");
                return;
            }

            // Get number of days in the selected month and year
            const daysInMonth = new Date(year, month, 0).getDate();

            for (let day = 1; day <= daysInMonth; day++) {
                const date = `${year}-${month.padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('calendar-day');
                dayDiv.setAttribute('data-date', date);

                const dayNumber = document.createElement('span');
                dayNumber.classList.add('day-number');
                dayNumber.textContent = day;
                dayDiv.appendChild(dayNumber);

                // Create a container for facility statuses
                const facilityStatusContainer = document.createElement('div');
                facilityStatusContainer.classList.add('facility-status-container');
                dayDiv.appendChild(facilityStatusContainer);

                // Load existing status from localStorage (if any)
                loadFacilityStatus(facilityStatusContainer, date);

                // Tooltip for detailed info
                const tooltip = document.createElement('div');
                tooltip.classList.add('tooltip');
                tooltip.textContent = `Details for ${date}`;
                dayDiv.appendChild(tooltip);

                dayDiv.addEventListener('click', () => {
                    document.getElementById("selectedDay").value = date;
                });

                calendarContainer.appendChild(dayDiv);
            }
        }

        function setStatus() {
            const facility = document.getElementById("facility").value;
            const selectedDay = document.getElementById("selectedDay").value;
            const status = document.getElementById("status").value;

            if (!selectedDay) {
                alert("Please select a day by clicking on it in the calendar.");
                return;
            }

            // Save status for the facility and date
            const facilityStatuses = JSON.parse(localStorage.getItem(selectedDay)) || {};
            facilityStatuses[facility] = status;
            localStorage.setItem(selectedDay, JSON.stringify(facilityStatuses));

            // Update the calendar display
            const facilityStatusContainer = document.querySelector(`.calendar-day[data-date='${selectedDay}'] .facility-status-container`);
            loadFacilityStatus(facilityStatusContainer, selectedDay);
        }

        function loadFacilityStatus(container, date) {
            container.innerHTML = ''; // Clear previous statuses

            const facilityStatuses = JSON.parse(localStorage.getItem(date)) || {};
            for (const [facility, status] of Object.entries(facilityStatuses)) {
                const statusDiv = document.createElement('span');
                statusDiv.classList.add('facility-status');

                // Set the appropriate class based on status
                switch (status) {
                    case 'available':
                        statusDiv.classList.add('status-available');
                        break;
                    case 'unavailable':
                        statusDiv.classList.add('status-unavailable');
                        break;
                    case 'maintenance':
                        statusDiv.classList.add('status-maintenance');
                        break;
                    case 'pending':
                        statusDiv.classList.add('status-pending');
                        break;
                }

                statusDiv.textContent = `${facility.replace(/_/g, ' ')}: ${status.charAt(0).toUpperCase() + status.slice(1)}`;
                container.appendChild(statusDiv);
            }
        }

        // Generate calendar on load
        window.onload = () => {
            const currentDate = new Date();
            document.getElementById("year").value = currentDate.getFullYear();
            generateCalendar();
        };
   





 // Function to load Module 1 content
 function Module2() {
    clearModuleContent(); // Clear previous module content
    const moduleContent = document.getElementById("module-content");
    moduleContent.innerHTML = `
        <style>
           #module-content {
                padding: 20px;
                overflow-y: auto; /* Allow vertical scrolling for the module */
            }
            .header {
                display: flex;
                justify-content: flex-end;
                margin-bottom: 20px;
            }
            .add-button {
                padding: 10px 20px;
                cursor: pointer;
                background-color: #4CAF50;
                color: #fff;
                border: none;
                border-radius: 5px;
                font-size: 16px;
            }
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                justify-content: center;
                align-items: center;
            }
            .modal-content {
                background-color: #fff;
                padding: 20px;
                width: 60%;
                max-width: 600px;
                position: relative;
                border-radius: 8px;
            }
            .modal-body {
                display: flex;
                gap: 20px;
            }
            .left {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .left img {
                width: 100%;
                max-width: 200px;
                height: auto;
                margin-bottom: 10px;
                border-radius: 8px;
                border: 1px solid #ddd;
            }
            .right {
                flex: 2;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            textarea, input[type="text"], input[type="number"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            .modal-footer {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                margin-top: 15px;
            }
            button.save {
                background-color: #4CAF50;
                color: #fff;
                border: none;
                padding: 10px 15px;
                border-radius: 5px;
                cursor: pointer;
            }
            button.cancel {
                background-color: #f44336;
                color: #fff;
                border: none;
                padding: 10px 15px;
                border-radius: 5px;
                cursor: pointer;
            }
            .facility-list {
                display: flex; 
                flex-wrap: wrap; 
                gap: 20px;  
                justify-content: flex-start; 
                overflow-y: auto; 
                max-height: 600px; 
                padding: 10px; 
                border: 1px solid #ccc; 
                border-radius: 8px; 
            }
          .facility-card {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    text-align: left;
    background-color: #fff;
    max-width: 290px;
    flex: 1 1 250px;
}

.facility-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 10px;
}

.facility-card h3 {
    font-size: 18px;
    font-weight: bold;
    margin: 6px 0;
    color: #333;
}

.facility-card p.description {
    font-size: 14px;
    color: #666;
    margin: 8px 0;
}

/* Detailed information styling */
.facility-details {
    display: grid;
    grid-template-columns: 1fr;
    gap: 8px;
    margin-top: 10px;
    border-top: 1px solid #ddd;
    padding-top: 10px;
}

.facility-details .detail-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 10px;
    background-color: #f9f9f9;
    border-radius: 5px;
    color: #555;
    font-size: 13px;
}

.facility-details .detail-item span.label {
    font-weight: bold;
    color: #333;
}

.facility-actions {
    display: flex;
    justify-content: space-between;
    margin-top: auto;
    gap: 10px;
}

.facility-actions button {
    padding: 8px 12px;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.facility-actions button:first-child {
    background-color: #007BFF;
    color: #fff;
}

.facility-actions button:last-child {
    background-color: #DC3545;
    color: #fff;
}
            .close {
                position: absolute;
                right: 15px;
                top: 10px;
                font-size: 24px;
                color: #333;
                cursor: pointer;
            }
            /* Media queries for responsiveness */
            @media (max-width: 768px) {
                .modal-content {
                    width: 90%;
                }
                .modal-body {
                    flex-direction: column; /* Stack the content vertically */
                }
                .left img {
                    max-width: 100px; /* Reduce image size for smaller screens */
                }
                .facility-card {
                    max-width: 100%; 
                }
            }
            @media (max-height: 600px) {
                .facility-list {
                    max-height: 390px; 
                }
            }
            @media (min-width: 769px) {
                .facility-list {
                    max-height: 530px; /* Height for desktop mode */
                }
            }
        </style>

        <div class="header">
            <button class="add-button" onclick="openForm()">+ Add Facility</button>
        </div>

        <div id="facilityForm" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeForm()">&times;</span>
                <h2 id="formTitle">Add Facility</h2>
                <div class="modal-body">
                    <div class="left">
                        <img id="facilityImagePreview" src="#" alt="Facility Image" style="display:none;">
                        <input type="file" id="facilityPhoto" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div class="right">
                        <div class="form-group">
                            <label for="facilityName">Facility Name</label>
                            <input type="text" id="facilityName" placeholder="Facility Name" required>
                        </div>
                        <div class="form-group">
                            <label for="facilityDescription">Description</label>
                            <textarea id="facilityDescription" placeholder="Description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="facilityCapacity">Capacity</label>
                            <input type="number" id="facilityCapacity" placeholder="Capacity" required>
                        </div>
                        <div class="form-group">
                            <label for="facilityAmenities">Amenities</label>
                            <input type="text" id="facilityAmenities" placeholder="Amenities" required>
                        </div>
                        <div class="form-group">
                            <label for="facilityAvailability">Availability</label>
                            <input type="text" id="facilityAvailability" placeholder="Availability" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="save" onclick="addOrUpdateFacility()">Save</button>
                    <button class="cancel" onclick="closeForm()">Cancel</button>
                </div>
            </div>
        </div>

<div id="facilityList" class="facility-list"></div>
    `;
    loadFacilities(); // Load facilities from localStorage when module is loaded
}

let facilities = []; // Array to hold facilities data
let editIndex = -1; // Index for editing facilities

// Function to open the modal form
function openForm() {
    document.getElementById("facilityForm").style.display = "flex";
    resetForm();
    editIndex = -1; // Reset edit index for new entry
}

// Function to reset the form fields
function resetForm() {
    document.getElementById("facilityName").value = '';
    document.getElementById("facilityDescription").value = '';
    document.getElementById("facilityCapacity").value = '';
    document.getElementById("facilityAmenities").value = '';
    document.getElementById("facilityAvailability").value = '';
    document.getElementById("facilityImagePreview").src = '';
    document.getElementById("facilityImagePreview").style.display = "none";
}

// Function to close the modal form
function closeForm() {
    document.getElementById("facilityForm").style.display = "none";
}

// Function to preview uploaded image
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('facilityImagePreview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}

// Function to add or update facility
function addOrUpdateFacility() {
    const name = document.getElementById("facilityName").value;
    const description = document.getElementById("facilityDescription").value;
    const capacity = document.getElementById("facilityCapacity").value;
    const amenities = document.getElementById("facilityAmenities").value;
    const availability = document.getElementById("facilityAvailability").value;
    const photo = document.getElementById("facilityImagePreview").src;

    const facilityData = { name, description, capacity, amenities, availability, photo };

    if (editIndex === -1) {
        facilities.push(facilityData); // Add new facility
    } else {
        facilities[editIndex] = facilityData; // Update existing facility
    }

    saveFacilities(); // Save facilities to localStorage
    renderFacilities(); // Render updated facility list
    closeForm(); // Close the form
}

// Function to save facilities to localStorage
function saveFacilities() {
    localStorage.setItem("facilities", JSON.stringify(facilities));
}

// Function to load facilities from localStorage
function loadFacilities() {
    const storedFacilities = localStorage.getItem("facilities");
    if (storedFacilities) {
        facilities = JSON.parse(storedFacilities);
        renderFacilities();
    } else {
        // If no facilities are stored, load an empty array (or add a message if desired)
        facilities = [];
        renderFacilities();
    }
}

// Function to render the facilities on the page
function renderFacilities() {
    const facilityList = document.getElementById("facilityList");
    facilityList.innerHTML = ''; // Clear existing facilities
    facilities.forEach((facility, index) => {
        const card = document.createElement("div");
        card.classList.add("facility-card");
        card.innerHTML = `
            <img src="${facility.image || 'https://via.placeholder.com/200x150'}" alt="${facility.name}">
            <h3>${facility.name}</h3>
            <p class="description">${facility.description}</p>
            <div class="facility-details">
                <div class="detail-item">
                    <span class="label">Capacity:</span><span>${facility.capacity}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Amenities:</span><span>${facility.amenities}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Availability:</span><span>${facility.availability}</span>
                </div>
            </div>
            <div class="facility-actions">
                <button onclick="editFacility(${index})">Edit</button>
                <button onclick="deleteFacility(${index})">Delete</button>
            </div>
        `;
        facilityList.appendChild(card);
    });
}
// Function to load facilities from localStorage
function loadFacilities() {
    const storedFacilities = localStorage.getItem("facilities");
    console.log(storedFacilities); // This will log the facilities from localStorage
    if (storedFacilities) {
        facilities = JSON.parse(storedFacilities);
        renderFacilities();
    }
}

// Function to render the facilities on the page
function renderFacilities() {
    const facilityList = document.getElementById("facilityList");
    facilityList.innerHTML = ''; // Clear existing facilities
    facilities.forEach((facility, index) => {
        const card = document.createElement("div");
        card.classList.add("facility-card");
        card.innerHTML = `
            <img src="${facility.image || 'https://via.placeholder.com/200x150'}" alt="${facility.name}">
            <h3>${facility.name}</h3>
            <p class="description">${facility.description}</p>
            <div class="facility-details">
                <div class="detail-item">
                    <span class="label">Capacity:</span><span>${facility.capacity}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Amenities:</span><span>${facility.amenities}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Availability:</span><span>${facility.availability}</span>
                </div>
            </div>
            <div class="facility-actions">
                <button onclick="editFacility(${index})">Edit</button>
                <button onclick="deleteFacility(${index})">Delete</button>
            </div>
        `;
        facilityList.appendChild(card);
    });
}


// Function to edit a facility
function editFacility(index) {
    const facility = facilities[index];
    document.getElementById("facilityName").value = facility.name;
    document.getElementById("facilityDescription").value = facility.description;
    document.getElementById("facilityCapacity").value = facility.capacity;
    document.getElementById("facilityAmenities").value = facility.amenities;
    document.getElementById("facilityAvailability").value = facility.availability;
    document.getElementById("facilityImagePreview").src = facility.photo;
    document.getElementById("facilityImagePreview").style.display = "block";

    editIndex = index; // Set index for editing
    document.getElementById("facilityForm").style.display = "flex";
}

// Function to delete a facility
function deleteFacility(index) {
    facilities.splice(index, 1); // Remove facility from array
    saveFacilities(); // Update localStorage
    renderFacilities();
}

// Function to load facilities from localStorage
function loadFacilities() {
    const storedFacilities = localStorage.getItem("facilities");
    if (storedFacilities) {
        facilities = JSON.parse(storedFacilities);
        renderFacilities();
    } else {
        // If no facilities are stored, load an empty array (or add a message if desired)
        facilities = [];
        renderFacilities();
    }
}
// Function to clear localStorage on logout
function logout() {
    localStorage.removeItem("facilities"); // Clears the saved facilities data
    // Perform other logout actions (e.g., redirect, clear user session)
}

// Load facilities on page load
window.onload = loadFacilities;





 // Function to module content
 function toggleSubmodules() {
        clearModuleContent(); // Clear previous module content

        const moduleContent = document.getElementById("module-content");
        moduleContent.innerHTML = `
        <p>Welcome to your module 1!</p>
        <div class="container mt-3">
            <div class="card">
                <div class="card-header">
                    <h4>module 1- Content Here</h4>
                </div>
                <div class="card-body">
                    <p>module 1 content is loaded here.</p>
                </div>
            </div>
        </div>`;
 }
 

  
// Function to load all reservations
function loadSubmodule1() {
    clearModuleContent(); // Clear previous module content
    const moduleContent = document.getElementById("module-content");
    moduleContent.innerHTML =  `<?php
        // Admin dashboard to view and manage reservations
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
        ?>
          <link rel="stylesheet" href="css/reservelist.css"> <!-- Link to your CSS file -->
      <style>
            /* Button Style */
    .add-reservation-btn {
        padding: 10px 20px;
        cursor: pointer;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
    }

   /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        width: 50%;
        max-width: 600px;
        position: relative;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .modal-body {
        display: flex;
        gap: 20px;
        justify-content: flex-start;
    }
 label {
        font-weight: bold;
        margin-top: 10px;
    }

    input[type="text"],
    input[type="email"],
    input[type="date"],
    input[type="time"],
    textarea,
    select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    /* Close button */
    .close {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 24px;
        color: #333;
        cursor: pointer;
    }

    /* Footer buttons */
    .modal-footer {
        display: flex;
        justify-content: flex-start;
        gap: 10px;
        margin-top: 15px;
    }

    button.save {
        background-color: #4CAF50;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    button.cancel {
        background-color: #f44336;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }
            /* Media queries for responsiveness */
            @media (max-width: 768px) {
                .modal-content {
                    width: 90%;
                }
                .modal-body {
                    flex-direction: column; /* Stack the content vertically */
                }
                .left img {
                    max-width: 100px; /* Reduce image size for smaller screens */
                }
                .facility-card {
                    max-width: 100%; 
                }
            }
            @media (max-height: 600px) {
                .facility-list {
                    max-height: 390px; 
                }
            }
            @media (min-width: 769px) {
                .facility-list {
                    max-height: 530px; /* Height for desktop mode */
                }
            }
        </style>

    <div class="form-group">
    <button onclick="openModal()" class="add-reservation-btn">Add Reservation</button>

    <div id="reservationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <form id="reservationForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div>
                        <label for="image">Choose File</label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="right">
                        <label for="user_name">User Name:</label>
                        <input type="text" id="user_name" name="user_name" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="facility_name">Facility Name:</label>
                        <select id="facility_name" name="facility_name" required>
                           <option value="Barangay Multi-purpose Hall">Barangay Multi-purpose Hall</option>
                        <option value="Barangay Covered Court">Barangay Covered Court</option>
                        <option value="Barangay Plaza">Barangay Plaza</option>
                        <option value="Barangay Library">Barangay Library</option>
                        <option value="Barangay Health Center Consultation Rooms">Barangay Health Center Consultation Rooms</option>
                        </select>

                        <label for="reservation_date">Reservation Date:</label>
                        <input type="date" id="reservation_date" name="reservation_date" required>

                        <label for="start_time">Start Time:</label>
                        <input type="time" id="start_time" name="start_time" required>

                        <label for="end_time">End Time:</label>
                        <input type="time" id="end_time" name="end_time" required>

                        <label for="additional_requests">Additional Requests:</label>
                        <textarea id="additional_requests" name="additional_requests" rows="3"></textarea>

                        <label for="purpose">Purpose:</label>
                        <textarea id="purpose" name="purpose" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="addReservation()" class="save">Save</button>
                    <button type="button" onclick="closeModal()" class="cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="scrollable-container">
        <div class="dashboard">
        
            <?php
             if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Set image path based on facility name
                    $imageUrl = '';
                    switch ($row['facility_name']) {
                        case 'Barangay Health Center Consultation Rooms':
                            $imageUrl = 'brgyhealth.jpg';
                            break;
                        case 'Barangay Library':
                            $imageUrl = 'library.jpg';
                            break;
                        case 'Barangay Plaza':
                            $imageUrl = 'plaza.jpg';
                            break;
                        case 'Barangay Covered Court':
                            $imageUrl = 'kort.jpg';
                            break;
                        case 'Barangay Multi-purpose Hall':
                            $imageUrl = 'multipurpose.jpg';
                            break;
                    }
                    ?>
                  <div class="card" data-id="<?php echo $row['id']; ?>">
                    <img src="<?php echo $imageUrl; ?>" alt="<?php echo $row['facility_name']; ?>">
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
                            <button class="edit-btn" onclick="openEditForm(<?php echo $row['id']; ?>)">Edit</button>
                            <button class="delete-btn" onclick="deleteReservation(<?php echo $row['id']; ?>)">Delete</button>
                        </div>
                    </div>
                </div>
                    <?php
                }
            } else {
                echo "No reservations found.";
            }
            ?>
        </div>
    </div>
        </div>`;
        loadReservations(); // Call a function to load existing reservations
 }
 function openModal() {
        document.getElementById("reservationModal").style.display = "flex"; // Use flex to center the modal
    }

    function closeModal() {
        document.getElementById("reservationModal").style.display = "none";
    }

    // Close the modal when the user clicks outside of the modal content
    window.onclick = function(event) {
        const modal = document.getElementById("reservationModal");
        if (event.target == modal) {
            closeModal();
        }
    };

   // Function to add a reservation
    function addReservation() {
        const formData = new FormData(document.getElementById('reservationForm'));

        fetch('add_reservation.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Reservation added successfully!');
                closeModal();
                loadReservations(); // Reload reservations to see the new entry
            } else {
                alert('Failed to add reservation.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

 function updateReservationStatus(id, action) {
    // Create form data to send to PHP
    const formData = new FormData();
    formData.append('id', id);
    formData.append('action', action);

    // Use fetch to send AJAX request
    fetch('update_reservation_status.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Find the card element by ID and update its status
            const card = document.querySelector(`.card[data-id='${id}']`);
            const statusElement = card.querySelector('.status');
            
            // Update the status text and class based on action
            if (action === 'approve') {
                statusElement.textContent = 'Status: Approved';
                statusElement.className = 'status approved'; // Update class for styling
            } else if (action === 'reject') {
                statusElement.textContent = 'Status: Rejected';
                statusElement.className = 'status rejected'; // Update class for styling
            }
        } else {
            alert('Error updating reservation: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function openEditForm(id) {
    // Open a modal or redirect to an edit page with the reservation ID
    window.location.href = `edit_reservation.php?id=${id}`;
}
function deleteReservation(id) {
    if (confirm("Are you sure you want to delete this reservation?")) {
        // Create form data to send to PHP
        const formData = new FormData();
        formData.append('id', id);

        // Use fetch to send AJAX request to delete the reservation
        fetch('delete_reservation.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Remove the card from the UI
                const card = document.querySelector(`.card[data-id='${id}']`);
                if (card) {
                    card.remove(); // Remove the card element from the DOM
                }
            } else {
                alert('Error deleting reservation: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}







// Function to load approved reservations
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
    <style>

/* Main Dashboard Layout */
.dashboard {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Side-by-side grid */
gap: 20px; /* Space between cards */
margin-top: 10px; /* Spacing above the cards */
}

/* Reservation Card Styling */
.card {
background-color: #ffffff;
border-radius: 10px;
box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
overflow: hidden;
transition: transform 0.3s ease; /* For hover effect */
}

.card:hover {
transform: scale(1.03); /* Slightly enlarge on hover */
}
 /* Image Styling */
 .card img {
    width: 100%; /* Make the image take the full width of the card */
    height: 200px; /* Set a fixed height for the image */
    object-fit: cover; /* Ensures the image covers the area without stretching */
    object-position: center; /* Centers the image within the designated space */
}
/* Card Content Styling */
.card-content {
padding: 20px;
color: #333;
}

.card-content h2 {
margin: 0;
font-size: 20px;
color: #3aafa9; /* Primary color */
}

.card-content p {
margin: 10px 0;
font-size: 14px;
color: #666;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .card {
        flex: 1 1 calc(45% - 20px); /* Adjust card layout for medium screens */
    }
}

@media (max-width: 480px) {
    .card {
        flex: 1 1 100%; /* Full width on small screens */
    }
}

/* No Reservations Message */
.no-reservations {
    text-align: center;
    font-size: 1.5em;
    color: #777;
    margin: 20px 0;
}
</style>

    <div class="form-group">
        <div class="scrollable-container">
            <div class="dashboard">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Set image path based on facility name
                        $imageUrl = '';
                        switch ($row['facility_name']) {
                            case 'Barangay Health Center Consultation Rooms': $imageUrl = 'brgyhealth.jpg'; break;
                            case 'Barangay Library': $imageUrl = 'library.jpg'; break;
                            case 'Barangay Plaza': $imageUrl = 'plaza.jpg'; break;
                            case 'Barangay Covered Court': $imageUrl = 'kort.jpg'; break;
                            case 'Barangay Multi-purpose Hall': $imageUrl = 'multipurpose.jpg'; break;
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
                    echo "No approved reservations found.";
                }
                ?>
            </div>
        </div>
    </div>`;
}



// Function to load rejected reservations
function loadSubmodule3() {
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
        $sql = "SELECT * FROM reservations WHERE status = 'rejected'";
        $result = $conn->query($sql);
    ?>
    <style>

/* Main Dashboard Layout */
.dashboard {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Side-by-side grid */
gap: 20px; /* Space between cards */
margin-top: 10px; /* Spacing above the cards */
}

/* Reservation Card Styling */
.card {
background-color: #ffffff;
border-radius: 10px;
box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
overflow: hidden;
transition: transform 0.3s ease; /* For hover effect */
}

.card:hover {
transform: scale(1.03); /* Slightly enlarge on hover */
}
 /* Image Styling */
 .card img {
    width: 100%; /* Make the image take the full width of the card */
    height: 200px; /* Set a fixed height for the image */
    object-fit: cover; /* Ensures the image covers the area without stretching */
    object-position: center; /* Centers the image within the designated space */
}
/* Card Content Styling */
.card-content {
padding: 20px;
color: #333;
}

.card-content h2 {
margin: 0;
font-size: 20px;
color: #3aafa9; /* Primary color */
}

.card-content p {
margin: 10px 0;
font-size: 14px;
color: #666;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .card {
        flex: 1 1 calc(45% - 30px); /* Adjust card layout */
    }
}

@media (max-width: 480px) {
    .card {
        flex: 1 1 100%; /* Full width on small screens */
    }
}

/* No Reservations Message */
.no-reservations {
    text-align: center;
    font-size: 1.5em;
    color: #777;
    margin: 20px 0;
}
</style>
    <div class="form-group">
        <div class="scrollable-container">
            <div class="dashboard">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Set image path based on facility name
                        $imageUrl = '';
                        switch ($row['facility_name']) {
                            case 'Barangay Health Center Consultation Rooms': $imageUrl = 'brgyhealth.jpg'; break;
                            case 'Barangay Library': $imageUrl = 'library.jpg'; break;
                            case 'Barangay Plaza': $imageUrl = 'plaza.jpg'; break;
                            case 'Barangay Covered Court': $imageUrl = 'kort.jpg'; break;
                            case 'Barangay Multi-purpose Hall': $imageUrl = 'multipurpose.jpg'; break;
                        }
                        ?>
                        <div class="card" data-id="<?php echo $row['id']; ?>">
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo $row['facility_name']; ?>">
                            <div class="card-content">
                                <h2><?php echo $row['facility_name']; ?></h2>
                                <p>Reserved by: <?php echo $row['user_name']; ?></p>
                                <p>Status: Rejected</p>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "No rejected reservations found.";
                }
                ?>
            </div>
        </div>
    </div>`;
}

// Function to load pending reservations
function loadSubmodule4() {
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
        $sql = "SELECT * FROM reservations WHERE status = 'pending'";
        $result = $conn->query($sql);
    ?>
       <style>
  
/* Main Dashboard Layout */
.dashboard {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Side-by-side grid */
gap: 20px; /* Space between cards */
margin-top: 10px; /* Spacing above the cards */
}

/* Reservation Card Styling */
.card {
background-color: #ffffff;
border-radius: 10px;
box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
overflow: hidden;
transition: transform 0.3s ease; /* For hover effect */
}

.card:hover {
transform: scale(1.03); /* Slightly enlarge on hover */
}
 /* Image Styling */
 .card img {
    width: 100%; /* Make the image take the full width of the card */
    height: 200px; /* Set a fixed height for the image */
    object-fit: cover; /* Ensures the image covers the area without stretching */
    object-position: center; /* Centers the image within the designated space */
}
/* Card Content Styling */
.card-content {
padding: 20px;
color: #333;
}

.card-content h2 {
margin: 0;
font-size: 20px;
color: #3aafa9; /* Primary color */
}

.card-content p {
margin: 10px 0;
font-size: 14px;
color: #666;
}


/* Responsive Styles */
@media (max-width: 768px) {
    .card {
        flex: 1 1 calc(45% - 30px); /* Adjust card layout */
    }
}

@media (max-width: 480px) {
    .card {
        flex: 1 1 100%; /* Full width on small screens */
    }
}

/* No Reservations Message */
.no-reservations {
    text-align: center;
    font-size: 1.5em;
    color: #777;
    margin: 20px 0;
}
</style>
    <div class="form-group">
        <div class="scrollable-container">
            <div class="dashboard">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Set image path based on facility name
                        $imageUrl = '';
                        switch ($row['facility_name']) {
                            case 'Barangay Health Center Consultation Rooms': $imageUrl = 'brgyhealth.jpg'; break;
                            case 'Barangay Library': $imageUrl = 'library.jpg'; break;
                            case 'Barangay Plaza': $imageUrl = 'plaza.jpg'; break;
                            case 'Barangay Covered Court': $imageUrl = 'kort.jpg'; break;
                            case 'Barangay Multi-purpose Hall': $imageUrl = 'multipurpose.jpg'; break;
                        }
                        ?>
                        <div class="card" data-id="<?php echo $row['id']; ?>">
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo $row['facility_name']; ?>">
                            <div class="card-content">
                                <h2><?php echo $row['facility_name']; ?></h2>
                                <p>Reserved by: <?php echo $row['user_name']; ?></p>
                                <p>Status: Pending</p>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "No pending reservations found.";
                }
                ?>
            </div>
        </div>
    </div>`;
}







 // Function to module content
 function modules3() {
    clearModuleContent(); // Clear previous module content
    const moduleContent = document.getElementById("module-content");
    moduleContent.innerHTML = `
        </div>`;
 }




</script>





<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <!-- Logo for LGU -->
    <img id="lgu-logo" src="logo.png" alt="LGU Logo" class="lgu-logo">
 
        <ul class="sidebar-menu">
        </li>
        <li class="list-group-item">
            <a href="#" onclick="dashboard()"><i class="fas fa-th-large"></i>Dashboard</a></li>
            <ul class="list-group">


            <li class="list-group-item">
            <a href="#" onclick="modules1()"><i class="fas fa-wrench"></i>CALENDAR</a></li>
            <ul class="list-group">
    </li>   

    <li class="list-group-item">
                    <a href="#" onclick="Module2()"><i class="fas fa-wrench"></i>FACILITY MANAGEMENT</a>
                </li>
                

   <!-- Dropdown for Module 1 -->
   <li class="list-group-item">
        <a href="#" id="modules3" onclick="toggleSubmodules('submodule1-dropdown')">
            <i class="fas fa-wrench"></i>RESERVATION MANAGEMENT <i class="fas fa-chevron-down"></i>
        </a>
        <ul class="submodule-dropdown" id="submodule1-dropdown" style="display: none;">
            <li><a href="#" id="submodule1" onclick="loadSubmodule1()">ALL RESERVATION</a></li>
            <li><a href="#" id="submodule2" onclick="loadSubmodule2()">APPROVED</a></li>
            <li><a href="#" id="submodule3" onclick="loadSubmodule3()">REJECTED</a></li>
            <li><a href="#" id="submodule3" onclick="loadSubmodule4()">PENDING</a></li>
        </ul>
    </li>


    <li class="list-group-item">
            <a href="#" onclick="modules3()"><i class="fas fa-wrench"></i>RESERVED</a></li>
            <ul class="list-group">
    </li>
   
 </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <header>
            <div class="menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <div class="header-right">
                <i class="fas fa-comment-dots" id="message-icon"></i>
                <i class="fas fa-bell" id="notification-icon"></i>

                
                <div class="profile" id="profile-icon">
    <div class="profile-container">
        <div class="profile-icon">

            <!-- User Profile Icon and Dropdown -->
            <div class="user-profile" onclick="toggleDropdown()">
                <img src="<?php echo isset($user['profile_image']) ? 'uploads/' . $user['profile_image'] : 'wa.jpg'; ?>" alt="Profile" class="profile-image" id="profileImagePreview">
            </div>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu" id="dropdownMenu">
                <div class="dropdown-header">
                    <img src="<?php echo isset($user['profile_image']) ? 'uploads/' . $user['profile_image'] : 'wa.jpg'; ?>" alt="User Avatar">
                    <h1>Welcome, <span><?php echo ucfirst($_SESSION['username']); ?></span></h1>
                </div>
               
    <ul>
        <li>
            <a href="admin_editprofile.php">
                <i class="fas fa-user icon-profile"></i><span>Edit Profile</span>
                <i class="fas fa-chevron-right arrow-icon"></i>
            </a>
        </li>
        <li>
            <i class="fas fa-cog icon-settings"></i><span>Settings & Privacy</span>
            <i class="fas fa-chevron-right arrow-icon"></i>
        </li>
        <li>
            <i class="fas fa-question-circle icon-help"></i><span>Help & Support</span>
            <i class="fas fa-chevron-right arrow-icon"></i>
        </li>
        <li>
            <i class="fas fa-sign-out-alt icon-logout"></i><a href="logout.php">Logout</a>
            <i class="fas fa-chevron-right arrow-icon"></i>
        </li>
    </ul>
</div>



                  
                </div>
            </div>
        </header>
        <main>
            <h1 id="content-title">Dashboard</h1>
            
        
            <!-- Empty Section for Module Content -->
           <!-- Content Area -->
    <div class="col-9">
        <div id="module-content" class="content-area"></div>
    </div>

        </main>
    </div>

    
    <script>// Toggle sidebar functionality
        document.getElementById("menu-toggle").addEventListener("click", function () {
            document.getElementById("sidebar").classList.toggle("collapsed");
            document.getElementById("main-content").classList.toggle("collapsed");
        });
   
        // Change content based on clicked module
        document.querySelectorAll(".sidebar-menu li a").forEach(item => {
            item.addEventListener("click", function (event) {
                // Remove active class from all menu items
                document.querySelectorAll(".sidebar-menu li").forEach(li => li.classList.remove("active"));
                
                // Add active class to clicked menu item
                event.currentTarget.parentElement.classList.add("active");
        
                // Change the content dynamically
                const contentTitle = document.getElementById("content-title");
                contentTitle.textContent = event.currentTarget.textContent.trim();
            });
        });
        
        // Handle profile, notifications, and messages click
        document.getElementById("profile-icon").addEventListener("click", function () {
            const profileIcon = document.getElementById('profileIcon');
const dropdownMenu = document.getElementById('dropdownMenu');

// Toggle the dropdown menu when the profile icon is clicked
profileIcon.addEventListener('click', function() {
  dropdownMenu.classList.toggle('show');
});

// Close the dropdown menu if clicked outside
window.addEventListener('click', function(e) {
  if (!profileIcon.contains(e.target) && !dropdownMenu.contains(e.target)) {
    dropdownMenu.classList.remove('show');
  }
});
        });

   // Function to toggle dropdown menu
   function toggleDropdown() {
        var dropdown = document.getElementById("dropdownMenu");
        dropdown.classList.toggle("active");
    }

    // Close the dropdown if clicked outside
    window.onclick = function(event) {
        if (!event.target.closest('.user-profile')) {
            document.getElementById("dropdownMenu").classList.remove("active");
        }
    }
        
        document.getElementById("notification-icon").addEventListener("click", function () {
            alert("Notifications clicked!");
        });
        
        document.getElementById("message-icon").addEventListener("click", function () {
            alert("Messages clicked!");
        });

// Function to toggle the dropdown visibility
function toggleSubmodules(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    if (dropdown.style.display === "none" || dropdown.style.display === "") {
        dropdown.style.display = "block";
    } else {
        dropdown.style.display = "none";
    }
}

// Function to load the specific submodule
function loadSubmodule(submoduleNumber) {
    clearModuleContent(); // Clear previous module content
    const moduleContent = document.getElementById("module-content");

    let submoduleTitle = "";
    let submoduleContent = "";

    switch (submoduleNumber) {
        case 1:
            submoduleTitle = "Submodule 1";
            submoduleContent = "Content for Submodule 1 is loaded here.";
            break;
        case 2:
            submoduleTitle = "Submodule 2";
            submoduleContent = "Content for Submodule 2 is loaded here.";
            break;
        case 3:
            submoduleTitle = "Submodule 3";
            submoduleContent = "Content for Submodule 3 is loaded here.";
            break;
        default:
            submoduleTitle = "Module 1";
            submoduleContent = "Default content for Module 1.";
    }

    moduleContent.innerHTML = `
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h4>${submoduleTitle}</h4>
            </div>
            <div class="card-body">
                <p>${submoduleContent}</p>
            </div>
        </div>
    </div>`;
}

// Function to clear previous module content
function clearModuleContent() {
    document.getElementById("module-content").innerHTML = "";
}

    
</script>

</body>
</html>