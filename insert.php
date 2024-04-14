<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Subjects</title>
    <link rel="stylesheet" href="insert.css">
</head>
<style>body{font-family: Arial, Helvetica, sans-serif;}</style>
<body>
    
    <h2>Insert Subjects</h2>
    <form action="insert_process.php" method="POST">
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" required><br><br>
        <label for="year">Year:</label>
    <select name="year" id="year">
    <option value="" disabled selected>Select Year</option>

        <option value="3">Third year</option>
        <option value="4">Fourth year</option>
    </select><br><br>

        <label for="total_seats">Total Seats:</label>
        <input type="number" id="total_seats" name="total_seats" required><br><br>

        <label for="department">Department:</label>
        <select name="department" id="department">
            <option value="" disabled selected>Select Department</option>
            <option value="ECE">ECE</option>
            <option value="IT">IT</option>
            <option value="MECH">MECH</option>
            <option value="CSE">CSE</option>
            <option value="BME">BME</option>
            <option value="Civil">Civil</option>
            <option value="EEE">EEE</option>
            <option value="AI&DS">AI&DS</option>
            <option value="RA">RA</option>
            <option value="Auto">Auto</option>
            <option value="EIE">EIE</option>
        </select>

        <label for="available_seats">Available Seats:</label>
        <input type="number" id="available_seats" name="available_seats" required><br><br>

        <input type="submit" value="Submit" id="buttt">
    </form>
<br>
    <hr>
    <br>
    <h2>Delete Subject</h2>
    <form action="delete_subject.php" method="POST">
        <label for="subject">Select Subject to Delete:</label>
        <select name="subject" id="subject">
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

            // Fetch subjects from the database
            $sql = "SELECT subjects FROM subjects";
            $result = $conn->query($sql);

            // Populate dropdown menu with fetched subjects
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['subjects'] . '">' . $row['subjects'] . '</option>';
                }
            }
            $conn->close();
            ?>
        </select><br><br>
        <input type="submit" value="Delete"  class="dell">
    </form>

    <br>
    <hr>
    <br>
    
        <h2>Update Arrival Timestamp</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="arrival_timestamp">New Arrival Timestamp:</label>
            <input type="datetime-local" id="arrival_timestamp" name="arrival_timestamp">
            <button type="submit" name="arrival_submit">Update Arrival Timestamp</button>
        </form>
        <br>
    <hr>
    <br>
        <h2>Update Disable Timestamp</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="disable_timestamp">New Disable Timestamp:</label>
            <input type="datetime-local" id="disable_timestamp" name="disable_timestamp">
            <button type="submit" name="disable_submit">Update Disable Timestamp</button>
        </form>

<br><br><br><hr>
    <?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "admin@123";
$dbname = "subjects";
$table_name = "timestamps";

// Function to fetch current timestamp from World Time API
function getCurrentTimestamp() {
    $url = 'https://worldtimeapi.org/api/timezone/Asia/Kolkata';
    $response = file_get_contents($url);
    if ($response === FALSE) {
        die("Error fetching current timestamp from World Time API");
    }
    $data = json_decode($response, TRUE);
    return $data['utc_datetime'];
}

// Function to update arrival_timestamp or disable_timestamp
function updateTimestamp($conn, $timestamp, $columnName) {
    global $table_name;
    $sql = "UPDATE $table_name SET $columnName = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $timestamp);
    if ($stmt->execute()) {
        echo "<p style='color:green'>Timestamp updated successfully.<p>";
    } else {
        echo "Error updating timestamp: " . $stmt->error;
    }
    $stmt->close();
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['arrival_submit'])) {
        $arrival_timestamp = $_POST['arrival_timestamp'];
        updateTimestamp($conn, $arrival_timestamp, "arrival_timestamp");
    }
    if (isset($_POST['disable_submit'])) {
        $disable_timestamp = $_POST['disable_timestamp'];
        updateTimestamp($conn, $disable_timestamp, "disable_timestamp");
    }
}
?>


</body>
</html>