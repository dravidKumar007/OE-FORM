<?php
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

// Retrieve department and years from request
$dept = '%'.$_GET['dept'].'%';
$years = $_GET['years'];

// Prepare and execute SQL statement to get subjects with available seats
$stmt = $conn->prepare("SELECT subjects, available_seats FROM subjects WHERE dept not like ? AND years = ?");
$stmt->bind_param("si", $dept, $years);
$stmt->execute();
$stmt->bind_result($subjects, $available_seats);

// Fetch results and store in an array
$subject_list = array();
while ($stmt->fetch()) {
    $subject_list[] = array("subject" => $subjects, "available_seats" => $available_seats);
}

// Close statement and connection
$stmt->close();
$conn->close();

// Return subject list as JSON
echo json_encode($subject_list);
?>
