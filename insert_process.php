<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $subject = $_POST['subject'] ?? '';
    $years = isset($_POST['year']) ? (int)$_POST['year'] : 0;
    $total_seats = isset($_POST['total_seats']) ? (int)$_POST['total_seats'] : 0;
    $available_seats = isset($_POST['available_seats']) ? (int)$_POST['available_seats'] : 0;
    $depts = isset($_POST['dept']) ? $_POST['dept'] : [];
    
    // Concatenate selected departments into a single string separated by spaces
    $dept_string = implode(" ", $depts);

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

    // Prepare SQL statement for insertion
    $sql = "INSERT INTO subjects (dept, subjects, years, total_seats, available_seats) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("ssiis", $dept_string, $subject, $years, $total_seats, $available_seats);
    if ($stmt->execute()) {
        echo "Subject inserted successfully";
        header("Location:insert.php");
    } else {
        echo "Error inserting subject: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Form submission method not recognized.";
}
?>
