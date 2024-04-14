<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">

    <title>View Selected Subjects</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        *{font-family: Poppins;}
    </style>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $('#id').ready(function() {
            // Event listener for department selection change
            $("#Dept").change(function() {
                var selectedDept = $(this).val();
                // AJAX request to fetch data for the selected department
                $.ajax({
                    type: "POST",
                    url: "fetch_subject.php", // Update the URL to the PHP script that fetches data
                    data: { dept: selectedDept },
                    success: function(response) {
                        // Update the table body with the fetched data
                        $("#subjectTableBody").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred while fetching data:", error);
                    }
                });
            });
        });
    </script>
<body>
    <h2>Selected Subjects</h2>
    <select name="Dept" id="Dept" required>
            <option value="" selected>ALL</option>
            <option value="CSE">CSE</option>
            <option value="IT">IT</option>
            <option value="MECH">MECH</option>
            <option value="BME">BME</option>
            <option value="EEE">EEE</option>
            <option value="ECE">ECE</option>
            <option value="AI&DS">AI&DS</option>
            <option value="Civil">Civil</option>
            <option value="RA">RA</option>
            <option value="Auto">Auto</option>
            <option value="EIE">EIE</option>
        </select><br>
        <br>
    <table>

        <thead>
            <tr>
                <th>Register No</th>
                <th>Name</th>
                <th>Department</th>
                <th>Year</th>
                <th>Subject</th>
                <th>insertion_time</th>
            </tr>
        </thead>
        <tbody id='subjectTableBody'>
            
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

            // Fetch data from the selected_subjects table
            $sql = "SELECT s.register_no, s.name,s.years, s.dept,ss.insertion_time , ss.subjects
            FROM students s
            INNER JOIN selected_subjects ss ON s.register_no = ss.register_no;";
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
                echo "<tr><td colspan='6'>No data available</td></tr>";
            }
            $conn->close();

         

            ?>
        </tbody>
    </table>
<br>
<hr>

    <h2>Delete All Selected Subjects</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_all']) ) {
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "admin@123";
        $dbname = "subjects";
        $depts = isset($_POST['Dept']) ? $_POST['Dept'] : '';
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement for deletion
        $sql = "DELETE FROM selected_subjects";

        // Execute the deletion query
        if ($conn->query($sql) === TRUE) {
            echo "All records from selected_subjects table have been deleted successfully.";
            header("Location:view.php");
        } else {
            echo "Error deleting records: " . $conn->error;
        }

        // Close the connection
        $conn->close();
    }
    ?>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <p>Are you sure you want to delete all records from the selected_subjects table?</p>
        <button type="submit" name="delete_all">Delete All selectedSubject</button>
    </form>
<br>
    <hr>
    <h3>Delete all the student(do after deleting the selected_subjects table)</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <p>Are you sure you want to delete all records from the student table?</p>
        <button type="submit" name="delete_stud">Delete All students</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_stud']) ) {
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "admin@123";
        $dbname = "subjects";
        $depts = isset($_POST['Dept']) ? $_POST['Dept'] : '';
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement for deletion
        $sql = "DELETE FROM students";

        // Execute the deletion query
        if ($conn->query($sql) === TRUE) {
            echo "All records from students table have been deleted successfully.";
            header("Location:view.php");
        } else {
            echo "Error deleting records: " . $conn->error;
        }

        // Close the connection
        $conn->close();
    }
    ?>

</body>
</html>