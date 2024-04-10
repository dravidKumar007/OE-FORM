<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "admin@123";
$dbname = "subjects";
$table_name = "timestamps";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch arrival timestamp
$sql = "SELECT arrival_timestamp FROM $table_name LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['arrival_timestamp'];
} else {
    echo "No arrival timestamp found";
}

// Close the connection
$conn->close();
?>
