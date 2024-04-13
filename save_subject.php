<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["subject"])) {
    // Retrieve register number from session
    if (isset($_SESSION["register_no"])) {
        $registerNo = $_SESSION["register_no"];
        
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
        $stmt->bind_param("ss", $registerNo, $subject);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Subject saved successfully.";
        } else {
            http_response_code(500);
            echo "Error: " . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        http_response_code(402);
        echo "Register number not found in session.";
    }
} else {
    http_response_code(402);
    echo "Invalid request.";
}
?>
