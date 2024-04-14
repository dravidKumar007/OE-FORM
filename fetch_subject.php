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

// Fetch data based on the selected department
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dept'])) {
    $dept = $_POST['dept'];
    
    // Prepare SQL statement with a WHERE clause to filter by department
    $sql = "SELECT s.register_no, s.name, s.dept, s.years, ss.insertion_time, ss.subjects
            FROM students s
            INNER JOIN selected_subjects ss ON s.register_no = ss.register_no
            WHERE s.dept like '%$dept%'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["register_no"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["dept"] . "</td>";
            echo "<td>" . $row["years"] . "</td>";
            echo "<td>" . $row["subjects"] . "</td>";
            echo "<td>" . $row["insertion_time"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No data available for the selected department</td></tr>";
    }
} else {
    echo "<tr><td colspan='6'>Invalid request</td></tr>";
}

$conn->close();
?>
