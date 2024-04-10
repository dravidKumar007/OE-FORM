<?php
// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'] ?? '';
    $register_no = $_POST['Register'] ?? '';
    $dept = $_POST['Dept'] ?? '';
    $year = isset($_POST['year']) ? (int)$_POST['year'] : 0;
    $subject = $_POST['Subject'] ?? '';

    // Convert year to integer
    $year = intval($year);

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
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user is already registered
    $check_sql = "SELECT * FROM selected_subjects WHERE register_no = ?";
    $check_stmt = $conn->prepare($check_sql);
    
    if (!$check_stmt) {
        die("Error in prepared statement: " . $conn->error);
    }

    $check_stmt->bind_param("i", $register_no);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        http_response_code(500);
        echo "You are already registered!";
        exit; // Stop further execution
    }

    // Check if the subject is available in the old table and there are available seats
    $sql = "SELECT id,total_seats, available_seats FROM subjects WHERE dept not like ? AND years = ? AND subjects = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Error in prepared statement: " . $conn->error);
    }
    $newdept='%' . $dept . '%';
    $stmt->bind_param("sis", $newdept, $year, $subject);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id=$row['id'];
        $total_seats = $row['total_seats'];
        $available_seats = $row['available_seats'];

        if ($available_seats > 0) {
            // Decrease available seat count in the old table
            $new_available_seats = $available_seats - 1;
            $sql_update = "UPDATE subjects SET available_seats = ? WHERE id = ? AND years = ? AND subjects = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("iiss", $new_available_seats, $id, $year, $subject);

            if ($stmt_update->execute()) {
                // Insert form data into the new table
                $sql_insert = "INSERT INTO selected_subjects (register_no, name, dept, years, subject) VALUES (?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("issss", $register_no, $name, $dept, $year, $subject);

                if ($stmt_insert->execute()) {
                    echo "Record inserted successfully";
                } else {
                    http_response_code(500);
                    echo "Error inserting record: " . $stmt_insert->error;
                }

                $stmt_insert->close();
            } else {
                http_response_code(500);
                echo "Error updating available seats: " . $stmt_update->error;
            }

            $stmt_update->close();
        } else {
            http_response_code(500);
            echo "No available seats for selected subject";
        }
    } else {
        http_response_code(500);
        echo "Subject not found in the old table";
    }

    $stmt->close();
    $conn->close();
}
