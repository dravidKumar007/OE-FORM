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

// Fetch subjects based on department and year
$dept = isset($_POST['dept']) ? '%' . $_POST['dept'] . '%' : '';
$year = $_POST['year'] ?? '';

// Prepare and bind the SQL statement
$sql = "SELECT subjects, total_seats, available_seats FROM subjects WHERE dept not like ? AND years = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("ss", $dept, $year);

// Execute the statement
if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
}

// Get the result
$result = $stmt->get_result();

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Calculate available seats by subtracting total seats from available seats
        $available_seats =$row['available_seats'];
        if($available_seats > 0) {
        echo "<option value='". $row["subjects"]. "'>".$row["subjects"]." (Available Seats: ".$available_seats.")</option>";
    }}
} else {
    echo "<option value=''>No subjects available</option>";
}

// Close the statement and connection
$stmt->close();
$conn->close();