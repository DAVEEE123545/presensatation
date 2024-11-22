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
    <link rel="stylesheet" href="user_dashboards.css">
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

        /* Feedback Modal Styles */
        .feedback-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0; /* Initially hidden */
            transition: opacity 0.5s ease; /* Fade in/out effect */
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 500px;
            animation: fadeIn 0.5s; /* Animation effect */
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .hidden {
            display: none; /* Hide elements */
        }

        /* Feedback Icon Animation */
        .feedback-icon {
            fill: #007bff; /* Change to your desired color */
            cursor: pointer;
            transition: transform 0.3s ease; /* Smooth transition */
        }

        .feedback-icon:hover {
            transform: scale(1.1); /* Scale up on hover */
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        select, textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            resize: none; /* Prevent resizing */
        }

        textarea {
            height: 100px; /* Set a fixed height for textarea */
        }

        button {
            background-color: #007bff; /* Primary button color */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s ease; /* Smooth transition */
        }

        button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        /* Thank You Message */
        #thankYouMessage {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #28a745; /* Green background */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
                        background-image: url('bara.jpg'); /* Replace with your image URL */
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;
                        color: white;
                        padding: 100px;
                        border-radius: 8px;
                        margin-bottom: 20px; /* Adjust margin below */
                        text-align: center;
                        position: relative;
                        height: 300px; /* Set a fixed height for the welcome section */
                    }
                    .welcome-text {
                        position: absolute; /* Ensure the text stays above the background image */
                        z-index: 0;
                    }




   /* Styling for the chatbot icon */
       #chatbot-icon {
    position: fixed;
    top: 620px; /* Adjust to top */
    right: 36px;
    width: 40px;
    height: 38px;
    background-color: #0078d7;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    font-size: 28px;
    z-index: 1000;
    transition: all 0.3s ease-in-out;
}


        /* Hover effect for the icon */
        #chatbot-icon:hover {
            background-color: #005fa3;
            transform: scale(1.1); /* Slightly enlarge on hover */
        }

        #chatbot-container {
    width: 320px;
    height: 400px;
    position: fixed;
    top: 200px; /* Adjust to top */
    right: 20px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    font-family: Arial, sans-serif;
    background-color: #ffffff;
    overflow: hidden;
    display: none; /* Initially hidden */
    transform: scale(0.8); /* Initially smaller */
    opacity: 0;
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}
        /* Header styling */
        #chatbot-header {
            background-color: #0078d7;
            color: #fff;
            padding: 10px;
            font-size: 16px;
            text-align: center;
            font-weight: bold;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Chat messages styling */
        #chatbot-messages {
            padding: 10px;
            overflow-y: auto;
            flex: 1;
            background-color: #f9f9f9;
        }

        /* Message bubbles */
        .bot-message, .user-message {
            max-width: 80%;
            margin: 5px 0;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
            line-height: 1.4;
        }

        /* Question (user's message) on the right */
        .user-message {
            background-color: #e7f3ff;
            color: #333;
            text-align: right;
            align-self: flex-end;
        }

        /* Answer (bot's message) on the left */
        .bot-message {
            background-color: #0078d7;
            color: #fff;
            text-align: left;
            align-self: flex-start;
        }

        /* Input area styling */
        #chatbot-input {
            display: flex;
            padding: 10px;
            background-color: #fff;
            border-top: 1px solid #eee;
        }

        #chatbot-input textarea {
            width: 100%;
            padding: 5px;
            border-radius: 8px;
            border: 1px solid #ddd;
            resize: none;
            font-size: 14px;
        }

        #send-button {
            background-color: #0078d7;
            color: #fff;
            padding: 5px 10px;
            margin-left: 8px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        /* Scrollbar styling for chatbot messages */
        #chatbot-messages::-webkit-scrollbar {
            width: 8px;
        }

        #chatbot-messages::-webkit-scrollbar-thumb {
            background-color: #0078d7;
            border-radius: 4px;
        }

        #chatbot-messages::-webkit-scrollbar-track {
            background-color: #f1f1f1;
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
                </div>



    <!-- Chatbot Icon -->
    <div id="chatbot-icon" onclick="toggleChatbot()">💬</div>

    <!-- Chatbot Container -->
    <div id="chatbot-container">
        <div id="chatbot-header">Barangay Facility Reservation Chatbot</div>
        <div id="chatbot-messages"></div>
        <div id="chatbot-input">
            <textarea id="user-input" placeholder="Ask about barangay facility reservations..." rows="2"></textarea>
            <button id="send-button" onclick="handleUserMessage()">Send</button>
        </div>
    </div>



                <!-- Feedback Icon with Animation -->
<div style="position: fixed; right: 20px; bottom: 20px;">
  <button id="feedbackIcon" onclick="openFeedbackModal()" style="background: none; border: none; cursor: pointer; outline: none;">
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

                <!-- User Feedback Modal -->
<div id="userFeedbackModal" class="feedback-modal hidden">
  <div class="modal-content">
    <h2>Submit Feedback</h2>
    <form id="feedbackForm" onsubmit="submitFeedback(event)">
      <label for="feedbackRating">Rating:</label>
      <select id="feedbackRating" required>
        <option value="">Select Rating</option>
        <option value="5">⭐⭐⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="2">⭐⭐</option>
        <option value="1">⭐</option>
      </select>

      <label for="feedbackType">Feedback Type:</label>
      <select id="feedbackType" required>
        <option value="">Select Feedback Type</option>
        <option value="General">General Feedback</option>
        <option value="Facility">Facility Condition</option>
        <option value="Experience">Reservation Experience</option>
      </select>

      <label for="feedbackComments">Comments:</label>
      <textarea id="feedbackComments" rows="4" placeholder="Share your experience..." required></textarea>

      <button type="submit">Submit</button>
      <button type="button" onclick="closeFeedbackModal()">Cancel</button>
    </form>
  </div>
</div>

<!-- Thank You Message -->
<div id="thankYouMessage" class="hidden">Thank you for your feedback!</div>
            `;
        })
        .catch(error => {
            console.error('Error fetching reservation counts:', error);
        });
        
}
 // Chatbot responses for each facility
 const responses = {
            greeting: "Hello! I’m here to assist with your barangay facility reservations. Feel free to ask about our facilities, reservation steps, policies, or other details.",
            
            availableFacilities: "Our barangay offers several facilities:\n\n" +
                "1. **Conference Room**\n2. **Basketball Court**\n3. **Banquet Hall**\n4. **Gymnasium**\n5. **Community Hall**\n\n" +
                "Ask about any facility’s availability, or how to reserve it!",
                
            // Availability status for each facility
            conferenceRoomAvailability: "The **Conference Room** is available for meetings and seminars, generally weekdays and some weekends. To check specific dates or reserve, head to our reservation page.",
            
            basketballCourtAvailability: "The **Basketball Court** is open for sports events and practices. It’s busiest on weekends, so early booking is recommended. Availability details are on our reservation page.",
            
            banquetHallAvailability: "The **Banquet Hall** is popular for large events like weddings and conferences. It's available on a first-come, first-served basis, and early reservation is encouraged as it books up fast!",
            
            gymnasiumAvailability: "The **Gymnasium** is available for sports, fitness events, and community gatherings. It’s typically open weekdays and weekends but fills up quickly, so check our calendar to confirm.",
            
            communityHallAvailability: "The **Community Hall** is ideal for workshops or small gatherings. Generally available on weekdays with limited weekend slots. Reserve through the calendar page to secure your spot.",
            
            // Reservation process and policies
            reservationProcess: "To reserve a facility:\n\n" +
                "1. **Visit the Reservation Page**\n2. **Select Your Facility**\n3. **Choose Date & Time**\n4. **Add Any Special Requests**\n5. **Submit Your Request**\n\n" +
                "Admin will review and confirm based on availability. You’ll receive a confirmation by email.",
            
            cancellationPolicy: "If you wish to cancel your reservation, please notify us at least 48 hours in advance. Cancellations made within 24 hours may be subject to a cancellation fee.",
            
            userFeedback: "We value your feedback! After your reservation, feel free to leave comments about the facility and the booking process. Your input helps us improve our services.",
            
            modifyReservation: "To modify your reservation, please visit the reservation page, select the facility, and choose a new date and time. If changes are required, our team will assist you directly.",
            
            hoursOfOperation: "Our facilities are available from Monday to Saturday, 8:00 AM to 9:00 PM. Closed on Sundays for maintenance.",
            
            paymentInfo: "Payments for reservations can be made directly at the barangay office or online through our official payment portal.",
            
            faq: "Frequently Asked Questions:\n\n1. How do I make a reservation?\n2. What is the cancellation policy?\n3. How can I modify my reservation?\n4. What are the operating hours of the facilities?",
            
            facilityEquipment: "Many of our facilities are equipped with audio-visual equipment, chairs, tables, and projectors. For more details, please specify the facility you're interested in.",
            
            bookingConfirmation: "Once your reservation is confirmed, you’ll receive a notification with all the booking details, including the facility, date, time, and any additional requests.",
            
            depositInfo: "For certain facilities, a deposit may be required to secure your reservation. You’ll be informed of the deposit amount during the booking process.",
            
            facilityRules: "Each facility has its own set of rules. Be sure to check the facility’s rules and regulations before booking to ensure a smooth experience.",
            
            eventTypes: "Our facilities cater to a wide range of events: meetings, seminars, sports, parties, weddings, workshops, and more. Let us know the type of event you're hosting for more tailored information.",
            
            publicHolidays: "Our facilities are closed on public holidays. Please check the holiday schedule before making a reservation to avoid conflicts.",
            
            groupBookings: "For large groups, we offer special packages and discounts. Please contact us for more details on group bookings.",
            
            venueAccessibility: "All of our venues are wheelchair accessible, and we can assist with additional accessibility requirements upon request.",
            
            cleaningServices: "Cleaning services are included with each booking, and facilities will be cleaned before and after each event.",
            
            noiseRestrictions: "Please be mindful of noise levels, especially in residential areas. Events causing excessive noise may be subject to fines or restrictions.",
            
            alcoholPolicy: "Alcohol is permitted in some of our facilities, but you must confirm this during the reservation process and follow local regulations.",
            
            bookingAssistance: "Need help with booking? Our team is here to assist you! Feel free to ask about available slots, prices, or any other queries you may have."
        };

        // Function to toggle the chatbot visibility with animation
        function toggleChatbot() {
            const container = document.getElementById('chatbot-container');
            if (container.style.display === 'none' || container.style.display === '') {
                container.style.display = 'flex';
                setTimeout(() => {
                    container.style.transform = 'scale(1)';
                    container.style.opacity = '1';
                }, 100); // Slight delay for smooth transition
            } else {
                container.style.transform = 'scale(0.8)';
                container.style.opacity = '0';
                setTimeout(() => {
                    container.style.display = 'none';
                }, 300); // Wait for animation to finish
            }
        }

        // Function to handle user input and send a response
        function handleUserMessage() {
            const userInput = document.getElementById('user-input').value;
            if (userInput.trim() === "") return;
            
            const userMessage = document.createElement('div');
            userMessage.classList.add('user-message');
            userMessage.textContent = userInput;
            document.getElementById('chatbot-messages').appendChild(userMessage);
            
            document.getElementById('user-input').value = '';

            // Respond based on the user's message
            let botResponse = "I’m here to assist with facilities reservations at our barangay, but I may not have the information you’re looking for about other topics. If you have any other questions, feel free to reach out to the barangay office directly at [Barangay Contact Number] or visit us during office hours. Let me know if you need any further help with booking a facility";
            
            const normalizedInput = userInput.toLowerCase();
            if (normalizedInput.includes("hello") || normalizedInput.includes("hi")) {
                botResponse = responses.greeting;
            } else if (normalizedInput.includes("facility") || normalizedInput.includes("available")) {
                botResponse = responses.availableFacilities;
            } else if (normalizedInput.includes("conference room")) {
                botResponse = responses.conferenceRoomAvailability;
            } else if (normalizedInput.includes("basketball court")) {
                botResponse = responses.basketballCourtAvailability;
            } else if (normalizedInput.includes("banquet hall")) {
                botResponse = responses.banquetHallAvailability;
            } else if (normalizedInput.includes("gymnasium")) {
                botResponse = responses.gymnasiumAvailability;
            } else if (normalizedInput.includes("community hall")) {
                botResponse = responses.communityHallAvailability;
            } else if (normalizedInput.includes("reservation")) {
                botResponse = responses.reservationProcess;
            } else if (normalizedInput.includes("cancellation")) {
                botResponse = responses.cancellationPolicy;
            } else if (normalizedInput.includes("feedback")) {
                botResponse = responses.userFeedback;
            } else if (normalizedInput.includes("modify") || normalizedInput.includes("change")) {
                botResponse = responses.modifyReservation;
            } else if (normalizedInput.includes("hours")) {
                botResponse = responses.hoursOfOperation;
            } else if (normalizedInput.includes("payment")) {
                botResponse = responses.paymentInfo;
            } else if (normalizedInput.includes("faq")) {
                botResponse = responses.faq;
            } else if (normalizedInput.includes("equipment")) {
                botResponse = responses.facilityEquipment;
            } else if (normalizedInput.includes("confirmation")) {
                botResponse = responses.bookingConfirmation;
            } else if (normalizedInput.includes("deposit")) {
                botResponse = responses.depositInfo;
            } else if (normalizedInput.includes("rules")) {
                botResponse = responses.facilityRules;
            } else if (normalizedInput.includes("event")) {
                botResponse = responses.eventTypes;
            } else if (normalizedInput.includes("holiday")) {
                botResponse = responses.publicHolidays;
            } else if (normalizedInput.includes("group")) {
                botResponse = responses.groupBookings;
            } else if (normalizedInput.includes("accessibility")) {
                botResponse = responses.venueAccessibility;
            } else if (normalizedInput.includes("cleaning")) {
                botResponse = responses.cleaningServices;
            } else if (normalizedInput.includes("noise")) {
                botResponse = responses.noiseRestrictions;
            } else if (normalizedInput.includes("alcohol")) {
                botResponse = responses.alcoholPolicy;
            } else if (normalizedInput.includes("help")) {
                botResponse = responses.bookingAssistance;
            }

            // Display bot response
            const botMessage = document.createElement('div');
            botMessage.classList.add('bot-message');
            botMessage.textContent = botResponse;
            document.getElementById('chatbot-messages').appendChild(botMessage);
        }
   // Opens the feedback modal
   function openFeedbackModal() {
            document.getElementById("userFeedbackModal").style.display = "flex"; // Use flex to center the modal
            document.getElementById("userFeedbackModal").style.opacity = "1"; // Set opacity to 1
        }

        // Closes the feedback modal
        function closeFeedbackModal() {
            document.getElementById("userFeedbackModal").style.opacity = "0"; // Fade out effect
            setTimeout(() => {
                document.getElementById("userFeedbackModal").style.display = "none"; // Hide after fade out
            }, 500);
        }

        // Submits feedback and stores it in localStorage
        function submitFeedback(event) {
            event.preventDefault(); // Prevent form submission

            const rating = document.getElementById("feedbackRating").value;
            const type = document.getElementById("feedbackType").value;
            const comments = document.getElementById("feedbackComments").value;
            const feedback = {
                rating,
                type,
                comments,
                date: new Date().toLocaleDateString(),
                status: "Pending",
            };

            const feedbacks = JSON.parse(localStorage.getItem("userFeedbacks")) || [];
            feedbacks.push(feedback);
            localStorage.setItem("userFeedbacks", JSON.stringify(feedbacks));

            closeFeedbackModal(); // Close the modal
            document.getElementById("thankYouMessage").style.display = "block";

            // Reset the form
            document.getElementById("feedbackForm").reset();

            setTimeout(() => {
                document.getElementById("thankYouMessage").style.display = "none";
            }, 3000);
        }


// Function to load Module 1 content
function loadModule1() {
    clearModuleContent(); // Clear previous module content
    const moduleContent = document.getElementById("module-content");
    // HTML structure for moduleContent
    moduleContent.innerHTML = `
    <style>
        /* Container for scrollable facility cards */
        #userFacilityContainer {
            max-height: 600px; /* Adjust height for desktop mode */
            overflow-y: auto; /* Enable vertical scrolling */
            padding: 10px;
            border: 1px solid #ccc; /* Optional: add a border */
            border-radius: 8px; /* Optional: add rounded corners */
            margin-bottom: 20px; /* Add margin for spacing */
        }

        /* Facility cards container */
        .facility-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
        }

        /* Individual facility card style */
        .facility-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            text-align: left;
            background-color: #fff;
            max-width: 290px;
            flex: 1 1 250px;
            transition: transform 0.3s; /* Add transition effect */
        }

        .facility-card:hover {
            transform: scale(1.03); /* Slightly scale the card on hover */
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
            margin: 10px 0;
            color: #333;
        }

        .facility-card p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        /* Style for capacity, amenities, and availability details */
        .facility-details {
            margin-top: 10px;
            padding: 5px;
            border-top: 1px solid #ddd;
            display: flex;
            flex-direction: column;
        }

        .facility-details span {
            font-weight: bold;
            color: #333;
        }

        .availability {
            font-weight: bold;
            color: green;
        }

        /* Mobile responsiveness */
        @media (max-width: 600px) {
            .facility-card {
                max-width: 100%; /* Make cards full width on small screens */
            }
            #userFacilityContainer {
                max-height: 470px; /* Adjust height for mobile */
            }
        }
    </style>

    <div id="userFacilityContainer">
        <div id="userFacilityList" class="facility-list"></div>
    </div>
    `;
    loadUserFacilities(); // Load facilities when the module is loaded
}
// Function to render facilities on the user dashboard
function renderUserFacilities() {
    const userFacilityList = document.getElementById("userFacilityList");
    userFacilityList.innerHTML = ''; // Clear existing facilities

    if (userFacilities.length === 0) {
        userFacilityList.innerHTML = '<p>No facilities available.</p>'; // Message when no facilities
    } else {
        userFacilities.forEach((facility) => {
            const facilityCard = document.createElement("div");
            facilityCard.classList.add("facility-card");
            facilityCard.innerHTML = `
                <img src="${facility.photo}" alt="${facility.name}">
                <h3>${facility.name}</h3>
                <p>${facility.description}</p>
                <div class="facility-details">
                    <span>Capacity:</span> <p>${facility.capacity}</p>
                    <span>Amenities:</span> <p>${facility.amenities}</p>
                    <span>Availability:</span> <p class="availability">${facility.availability}</p>
                </div>
            `;
            userFacilityList.appendChild(facilityCard);
        });
    }
}

// Function to save facilities to localStorage
function saveFacilities() {
    localStorage.setItem("facilities", JSON.stringify(userFacilities));
}

// Function to load facilities from localStorage for the user dashboard
function loadUserFacilities() {
    const storedFacilities = localStorage.getItem("facilities");
    if (storedFacilities) {
        userFacilities = JSON.parse(storedFacilities); // Update userFacilities array
    } else {
        userFacilities = []; // Ensure array is empty if no data
    }
    renderUserFacilities(); // Render updated facilities
}

// Example function to add a facility (this should be called by admin when adding a facility)
function addFacility(facility) {
    userFacilities.push(facility);
    saveFacilities(); // Save to localStorage after adding
    renderUserFacilities(); // Update the display
}

// Listen for localStorage changes (real-time update for facilities)
window.addEventListener("storage", (event) => {
    if (event.key === "facilities") {
        loadUserFacilities(); // Reload facilities when updated by admin
    }
});

// Initial load for facilities when the user's page is opened
loadUserFacilities();




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
 
  
 // Function to module content
 function loadSubmodule1() {
        clearModuleContent(); // Clear previous module content

        const moduleContent = document.getElementById("module-content");
        moduleContent.innerHTML = `
 <link rel="stylesheet" href="usercss/userreservation.css">

<div class="container">
    <!-- Form Section -->
    <div>
        <form id="reservationForm" method="POST" onsubmit="submitReservation(event);">
            <div class="form-row">
                <div class="form-group">
                    <label for="user_name">Name</label>
                    <input type="text" id="user_name" name="user_name" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="facility_name">Select Facility</label>
                    <select id="facility_name" name="facility_name" required>
                        <option value="" disabled selected>-- Select Facility --</option>
                        <option value="Barangay Multi-purpose Hall">Barangay Multi-purpose Hall</option>
                        <option value="Barangay Covered Court">Barangay Covered Court</option>
                        <option value="Barangay Plaza">Barangay Plaza</option>
                        <option value="Barangay Library">Barangay Library</option>
                        <option value="Barangay Health Center Consultation Rooms">Barangay Health Center Consultation Rooms</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="reservation_date">Reservation Date</label>
                    <input type="date" id="reservation_date" name="reservation_date" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="time" id="start_time" name="start_time" required>
                </div>

                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="time" id="end_time" name="end_time" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group full-width">
                    <label for="additional_request">Additional Requests</label>
                    <textarea id="additional_request" name="additional_request" placeholder="Enter any additional requests" rows="3"></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group full-width">
                    <label for="purpose">Purpose</label>
                    <input type="text" id="purpose" name="purpose" placeholder="Enter the purpose of reservation" required>
                </div>
            </div>

            <button type="submit">Submit Reservation</button>
        </form>
    </div>

    <!-- Facility Information Section -->
    <div class="info-section">
        <h2>Facility Information</h2>
        <p>Ensure you have all the details ready for your reservation.</p>
        <ul>
            <li>Available facilities include:</li>
            <li>Community Hall</li>
            <li>Conference Room</li>
            <li>Basketball Court</li>
            <li>Banquet Hall</li>
            <li>Gymnasium</li>
        </ul>
        <p>Check our calendar for availability on the desired date.</p>
        <p>For any inquiries, please contact our office.</p>
        <p>63+ 919 659 5120</p>
    </div>
</div>

        </div>`;
 }  
 fetchReservations(); // Fetch and display all reservations


// Submit reservation data
function submitReservation(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(document.getElementById("reservationForm"));
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "submit_reservation.php", true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
                alert(response.message); // Show success message
                document.getElementById("reservationForm").reset(); // Reset form after submission
                fetchReservations(); // Refresh the reservations list
            } else {
                alert(response.message); // Show error message
            }
        }
    };
    xhr.send(formData); // Send the form data
}

// Fetch all reservations from the server
function fetchReservations() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_reservations.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("allReservations").innerHTML = xhr.responseText;
        } else {
            document.getElementById("allReservations").innerHTML = "Failed to load reservations.";
        }
    };
    xhr.send();
}






function loadSubmodule2() {
    clearModuleContent(); // Clear previous module content
    const moduleContent = document.getElementById("module-content");
    moduleContent.innerHTML = `
    <style>
        .calendar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 110%;
            max-width: 1000px;
            margin: auto;
            overflow-y: auto; /* Enable vertical scrolling */
            max-height: 80vh; /* Limit height for scrolling */
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
        input[type="number"] {
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

        .calendar-day {
            width: 150px;
            height: 110px;
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
            height: auto;
            overflow-y: auto;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
            background-color: #ffffff;
        }

        .facility-status {
            display: block;
            margin-top: 2px;
            font-size: 10px;
            border-radius: 4px;
            color: white;
            text-align: center;
            min-width: 70px;
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
            margin-bottom: 5px;
            font-size: 20px;
            color: #333;
        }

        /* Tooltip for more information */
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

        @media (max-width: 600px) {
            .controls {
                flex-direction: column;
            }

            .control-group {
                width: 100%;
                margin-right: 0;
                margin-bottom: 10px;
            }

            .calendar-day {
                width: 100%;
            }

            .calendar-container {
                max-height: 70vh; /* Adjust for smaller screens */
            }
        }
    </style>

<div class="calendar-container">
        <div class="controls" style="display: flex; align-items: center;">
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
            <div class="control-group" style="margin-right: 20px;">
                <label for="year">Year:</label>
                <input type="number" id="year" min="2023" placeholder="Year" onchange="generateCalendar()">
            </div>
                <label for="year">Status Indicator:</label>

            <!-- Status Indicators beside Year -->
            <div style="display: flex; align-items: center;">
                <div style="display: flex; align-items: center; margin-right: 8px;">
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: green; border-radius: 50%; margin-right: 4px;"></span>
                    Available
                </div>
                <div style="display: flex; align-items: center; margin-right: 8px;">
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: red; border-radius: 50%; margin-right: 4px;"></span>
                    Unavailable
                </div>
                <div style="display: flex; align-items: center; margin-right: 8px;">
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: grey; border-radius: 50%; margin-right: 4px;"></span>
                    Maintenance
                </div>
                <div style="display: flex; align-items: center;">
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: yellow; border-radius: 50%; margin-right: 4px;"></span>
                    Pending
                </div>
            </div>
        </div>

        <div style="display: flex; width: 100%; justify-content: space-between; margin-top: 20px;">
            <!-- Calendar Area -->
            <div style="flex: 1;">
                <h3>Calendar:</h3>  
                <div id="user-calendar"></div>
            </div>
        </div>
    </div>
    `;
}

function generateCalendar() {
    const month = document.getElementById("month").value;
    const year = document.getElementById("year").value;
    const calendarContainer = document.getElementById("user-calendar");

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

        calendarContainer.appendChild(dayDiv);
    }
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





  
       function loadSubmodule3() {
    clearModuleContent(); // Clear previous module content
    const moduleContent = document.getElementById("module-content");
    moduleContent.innerHTML = `
 
</div>
    `;
}



function modules3() {
    clearModuleContent(); // Clear previous module content
    const moduleContent = document.getElementById("module-content");
    moduleContent.innerHTML = `
    <style>
    /* Container Styling */
    .container {
        padding: 20px;
        background-color: #f3f3f3;
        border-radius: 12px;
        max-width: 100%;
        margin: 0 auto;
    }

    /* Title Styling */
    .container h1 {
        font-size: 2em;
        color: #444;
        text-align: center;
        margin-bottom: 10px;
        font-family: Arial, sans-serif;
    }

    /* Scrollable Reservations Section */
    #allReservations {
        display: flex;
        flex-wrap: wrap; /* Allow wrapping for larger screens */
        gap: 20px;
        max-height: 550px; /* Set max height for scrolling */
        overflow-y: auto; /* Enable vertical scrolling */
        padding: 10px;
    }

    /* Card Styling */
    .card {
        display: flex;
        gap: 15px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        width: 48%; /* Maintain side-by-side layout */
        min-width: 300px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        flex-direction: row; /* Ensure content is laid out horizontally */
    }

    /* Remove Hover Effect */
    .card:hover {
        transform: none; /* No hover transformation */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
    }

    /* Image Styling */
    .card img {
        width: 100px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #ddd;
    }

    /* Content Styling */
    .card-content {
        flex-grow: 1;
        font-family: Arial, sans-serif;
    }

    .card-content h2 {
        margin: 0;
        font-size: 1.2em;
        color: #333;
    }

    .card-content p {
        margin: 5px 0;
        color: #555;
    }

    /* Status Styling */
    .status {
        font-weight: bold;
        color: #007BFF;
        font-size: 1em;
    }

    /* Additional Requests Styling */
    .additional-request {
        font-style: italic;
        color: #888;
    }

    /* Responsive Styling for Mobile */
    @media (max-width: 768px) {
        #allReservations {
            flex-direction: column; /* Stack cards vertically in mobile */
            overflow-y: auto; /* Ensure vertical scrolling is enabled */
            max-height: 400px; /* Adjusted max height for mobile */
        }

        .card {
            width: 100%; /* Full width in mobile */
            min-width: unset; /* Remove minimum width for mobile */
        }

        .container {
            padding: 10px; /* Adjust padding for mobile */
        }
    }
    </style>
    
    <!-- Reservation History Section -->
    <div class="container">
        <h1>Reservation History</h1>
        <div id="allReservations"></div> <!-- Container for displaying user history -->
    </div>
    `;

    fetchUserHistory(); // Fetch and display user's reservation history
}

function fetchUserHistory() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_user_history.php", true);
    xhr.onload = function () {
        const response = xhr.responseText.trim();
        const allReservations = document.getElementById("allReservations");
        
        if (xhr.status === 200) {
            if (response.startsWith("error:")) {
                allReservations.innerHTML = response.substring(6); // Show error message without prefix
            } else {
                allReservations.innerHTML = response;
            }
        } else {
            allReservations.innerHTML = "Failed to load reservation history.";
        }
    };
    xhr.send();
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
                    <a href="#" onclick="loadModule1()"><i class="fas fa-wrench"></i>FACILITY LISTING</a>
                </li>
                

         <!-- Dropdown for Module 1 -->
    <li class="list-group-item">
        <a href="#" id="module2" onclick="toggleSubmodules('submodule1-dropdown')">
            <i class="fas fa-wrench"></i>FACILITY <i class="fas fa-chevron-down"></i>
        </a>
        <ul class="submodule-dropdown" id="submodule1-dropdown" style="display: none;">
            <li><a href="#" id="submodule1" onclick="loadSubmodule1()">FACILITY RESERVATIONS</a></li>
            <li><a href="#" id="submodule2" onclick="loadSubmodule2()">CALENDAR</a></li>
            <li><a href="#" id="submodule3" onclick="loadSubmodule3()">Submodule 3</a></li>
        </ul>
    </li>


    <li class="list-group-item">
            <a href="#" onclick="modules3()"><i class="fas fa-wrench"></i>HISTORY</a></li>
            <ul class="list-group">
    </li>
                
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

                
                
                <i class="fas fa-bell" id="notification-icon">
    <span id="notification-count" class="notification-bubble" style="display: none;">0</span>
</i>
<div class="notification-area" id="notification-area" style="display: none;">
    <div class="notification-header">
        <h3>Notifications</h3>
        <button class="btn-mark-read">Mark All as Read</button>
        <button class="btn-delete-all">Delete All</button>
    </div>
    <div id="notifications-list" class="notification-list">
        <!-- Notifications will be dynamically loaded here -->
    </div>
</div>


<style>
    /* General Styles */
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
    }

    #notification-icon {
        font-size: 24px;
        right: 13;
        color: #555;
        cursor: pointer;
        position: relative;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    #notification-icon:hover {
        color: #007bff;
        transform: scale(1.1);
    }

    /* Notification Area Styles */
    .notification-area {
        position: absolute;
        top: 60px;
        right: 40px;
        width: 300px;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        max-height: 400px;
        overflow-y: auto;
        border-radius: 10px;
        display: none;
        animation: fadeIn 0.3s ease-in-out;
        padding: 15px;
    }

    /* Notification Header */
    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background: linear-gradient(45deg, #4CAF50, #007bff);
        color: #fff;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .notification-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: bold;
    }

    .btn-mark-read {
        background-color: #fff;
        color: #007bff;
        border: 2px solid #007bff;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-mark-read:hover {
        background-color: #007bff;
        color: #fff;
    }

    /* Notification List */
    .notification-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .notification {
        background-color: #fff;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: background-color 0.3s;
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .notification:hover {
        background-color: #f1f9ff;
    }

    .notification.unread {
        background-color: #e6f7ff;
        border-left: 4px solid #007bff;
    }

    .notification.read {
        background-color: #f0f0f0;
        color: #666;
    }

    .notification p {
        margin: 0 0 5px;
        font-size: 14px;
    }

    .notification small {
        color: #999;
        font-size: 12px;
    }

    .notification a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }

    .notification a:hover {
        text-decoration: none;
        color: #007bff;
    }
/* Delete All Button Style */
.btn-delete-all {
    background-color: #f44336;
    color: white;
    border: 2px solid #f44336;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-delete-all:hover {
    background-color: #d32f2f;
    color: white;
}

/* Delete Button inside Notification */
.btn-delete {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 5px 10px;
    font-size: 12px;
    cursor: pointer;
    border-radius: 4px;
    align-self: flex-end;
    transition: background-color 0.3s ease;
}

.btn-delete:hover {
    background-color: #d32f2f;
}
/* Notification Bubble Styles */
.notification-bubble {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: #ff0000;
    color: white;
    font-size: 12px;
    padding: 5px;
    border-radius: 50%;
    min-width: 20px;
    text-align: center;
    display: none;
}
    /* Scrollbar Customization */
    .notification-list::-webkit-scrollbar {
        width: 6px;
    }

    .notification-list::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 3px;
    }

    .notification-list::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }

    /* Mobile Styles */
    @media (max-width: 600px) {
        .notification-area {
            width: 90%;
            right: 5%;
        }
    }

    /* Fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

                <div class="profile" id="profile-icon">

                    <div class="profile-container">
                        <div class="profile-icon">

<!-- User Profile Icon and Dropdown -->
<div class="user-profile" onclick="toggleDropdown()">
    <img src="wa.jpg" alt="Profile" class="profile-image">
</div>

<!-- Dropdown Menu -->
<div class="dropdown-menu" id="dropdownMenu">
    <div class="dropdown-header">
        <img src="aa.jpg" alt="User Avatar">
        <h1>Welcome, <span><?php echo ucfirst($_SESSION['username']); ?></span></h1>

    </div>
    <ul>
        <li>
            <a href="user_editprofile.php">
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
    const notificationArea = document.getElementById("notification-area");
    const notificationsList = document.getElementById("notifications-list");

    // Fetch notifications from the server
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "get_notifications.php", true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const notifications = JSON.parse(xhr.responseText);
            notificationsList.innerHTML = ''; // Clear previous notifications

            if (notifications.length === 0) {
                notificationsList.innerHTML = '<p>No new notifications.</p>';
            } else {
                notifications.forEach(notification => {
                    notificationsList.innerHTML += `
                        <div class="notification ${notification.is_read ? 'read' : 'unread'}">
                            <a href="mark_as_read.php?id=${notification.id}">
                                ${notification.message}
                            </a>
                            <button class="btn-delete" data-id="${notification.id}">Delete</button>
                        </div>
                    `;
                });
                
                // Add event listener to delete buttons
                const deleteButtons = document.querySelectorAll('.btn-delete');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const notificationId = this.getAttribute('data-id');
                        deleteNotification(notificationId);
                    });
                });
            }
        }
    };
    xhr.send();

    // Toggle notification area visibility
    notificationArea.style.display = (notificationArea.style.display === 'none' || notificationArea.style.display === '') ? 'block' : 'none';
});

// Function to delete a single notification
function deleteNotification(notificationId) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `delete_notification.php?id=${notificationId}`, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Remove the notification from the DOM
                const notification = document.querySelector(`.notification .btn-delete[data-id="${notificationId}"]`).parentNode;
                notification.remove();
            } else {
                alert('Failed to delete notification.');
            }
        }
    };
    xhr.send();
}

// Delete All Notifications
document.querySelector('.btn-delete-all').addEventListener('click', function () {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "delete_all_notifications.php", true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Clear all notifications from the list
                document.getElementById("notifications-list").innerHTML = '<p>No new notifications.</p>';
            } else {
                alert('Failed to delete all notifications.');
            }
        }
    };
    xhr.send();
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