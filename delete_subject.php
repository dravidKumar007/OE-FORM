<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve selected subject from the form
    $subject = $_POST['subject'] ?? '';

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

    // Prepare SQL statement for deletion
    $sql = "DELETE FROM subjects WHERE subjects = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("s", $subject);
    if ($stmt->execute()) {
        echo "Subject deleted successfully";
        echo"<script>window.location.href='insert.php'</script>";
        exit;
    } else {
        echo "Error deleting subject: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Form submission method not recognized.";
}
?>
