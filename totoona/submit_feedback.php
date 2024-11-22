<?php
// submit_feedback.php

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if feedback is set
if (isset($data['feedback'])) {
    $feedback = $data['feedback'];

    // Save feedback to a JSON file (feedbacks.json)
    $filePath = 'feedbacks.json';
    $feedbacks = [];

    // Check if the file exists and read existing feedbacks
    if (file_exists($filePath)) {
        $feedbacks = json_decode(file_get_contents($filePath), true);
    }

    // Add the new feedback
    $feedbacks[] = ['feedback' => $feedback, 'timestamp' => date('Y-m-d H:i:s')];

    // Save back to the file
    file_put_contents($filePath, json_encode($feedbacks));

    // Send response
    echo json_encode(['message' => 'Feedback submitted successfully!']);
} else {
    echo json_encode(['message' => 'Feedback is required!']);
}
?>
