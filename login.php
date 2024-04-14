

<?php

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Database connection parameters
    $servername = "localhost"; // Change this to your server name
    $username = "root"; // Change this to your MySQL username
    $password_db = "admin@123"; // Change this to your MySQL password
    $dbname = "subjects"; // Change this to your MySQL database name

    // Attempt to establish a connection to the database
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        // If connection failed, return a 500 error with an error message
        http_response_code(500);
        echo "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare SQL statement to retrieve the register_no for the provided email
        $stmt = $conn->prepare("SELECT register_no, password FROM students WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if a row is returned
        if ($stmt->num_rows > 0) {
            // Bind the result variables
            $stmt->bind_result($register_no, $hashed_password);
            $stmt->fetch();

            // Verify the password
            if ($password=== $hashed_password) {

                // Return a 200 success response
                http_response_code(200);
                echo "success";
            } else {
                // Password is incorrect, return a 403 Forbidden status
                http_response_code(403);
                echo "Incorrect password.$hashed_password";
            }
        } else {
            // No user found with the provided email, return a 404 Not Found status
            http_response_code(404);
            echo "No user found with the provided email.";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>
