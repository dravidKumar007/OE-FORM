<?php
// Database connection parameters
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = "admin@123"; // Change this to your database password
$database = "subjects"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get email from GET request
$email = $_GET['email']; // Assuming the email is sent via GET method

// Prepare SQL statement to retrieve registration number by email
$sql = "SELECT register_no,dept,years FROM students WHERE email = '$email'";

// Execute SQL statement
$result = $conn->query($sql);
if ($result) {
if ($result->num_rows > 0) {
    // Fetch registration number from the result
    $row = $result->fetch_assoc();
  
// Prepare an array with all the data
$responseData = array(
    "registrationNumber" => $row["register_no"],
    "years" => $row["years"],
    "dept" => $row["dept"]
);

// Return the data as JSON response
echo json_encode($responseData);
} else {
    http_response_code(500);
    // If no result found, return an error message
    echo "No registration number found for the given email.";
}
} else {
    http_response_code(500);
    // Handle query execution error
    echo "Error executing query: " . $connection->error;
}
// Close database connection
$conn->close();
?>
