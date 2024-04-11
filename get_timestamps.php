<?php
// Fetch current timestamp from World Time API
$url = 'https://worldtimeapi.org/api/timezone/Asia/Kolkata';
$response = file_get_contents($url);
if ($response === FALSE) {
    die("Error fetching current timestamp from World Time API");
}
$data = json_decode($response, TRUE);
$current_timestamp = strtotime($data['datetime']);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "admin@123";
$dbname = "subjects"; // Updated database name
$table_name = "timestamps"; // Updated table name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch arrival and disable timestamps
$sql = "SELECT arrival_timestamp, disable_timestamp FROM $table_name LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $timestamps = array(
        'current_timestamp' => $current_timestamp,
        'arrival_timestamp' => strtotime($row['arrival_timestamp']),
        'disable_timestamp' => strtotime($row['disable_timestamp'])
    );
    echo json_encode($timestamps);
} else {
    echo "No timestamps found";
}

// Close the connection
$conn->close();
?>
