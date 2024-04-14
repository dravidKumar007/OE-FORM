<?php
// Check if the request method is POST and subject is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["subject"]) && isset($_POST["register_no"])) {
    // Retrieve register number from POST data
    $registerNo = $_POST["register_no"];
    
    // Retrieve selected subject from POST data
    $subject = $_POST["subject"];

    // Database connection parameters
    $servername = "localhost"; // Change this to your server name
    $username = "root"; // Change this to your MySQL username
    $password = "admin@123"; // Change this to your MySQL password
    $dbname = "subjects"; // Change this to your MySQL database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO selected_subjects (register_no, subjects) VALUES (?, ?)");
    $stmt->bind_param("is", $registerNo, $subject);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Subject saved successfully.";
    } else {
        // Return error if execution fails
        http_response_code(500);
        echo "Error: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Return error for invalid request
    http_response_code(402);
    echo "Invalid request.";
}
?>
