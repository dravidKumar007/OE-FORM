<?php
// Start session
session_start();

// Check if register number is set in session
if (isset($_SESSION['register_no'])) {
    // Get register number from session
    $register_no = $_SESSION['register_no'];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "admin@123";
    $dbname = "subjects";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL statement to get department and years
    $stmt = $conn->prepare("SELECT dept, years FROM students WHERE register_no = ?");
    $stmt->bind_param("i", $register_no);
    $stmt->execute();
    $stmt->bind_result($dept, $years);
    $stmt->fetch();

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Return department and years as JSON
    echo json_encode(array("dept" => $dept, "years" => $years));
} else {
    // Register number not set in session
    echo "Register number not found.";
}
?>