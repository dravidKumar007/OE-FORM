<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OE Form</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">

</head>
<body>
    <form action="students.php" name="submit-to-google-sheet" id="myForm">
       <h1>OPEN ELECTIVE</h1>
    <label for="name">Name:</label>
    <input type="Text" name="name" id="name" placeholder="Enter your name" required><br>
    <label for="Register">Register no:</label>
    <input type="number" name="Register" id="Register" placeholder="Enter Your Register number" min="100000000000" required><br>
    <label for="Dept">Department:</label>
    <select name="Dept" id="Dept" >
    <option disabled selected>Select Department</option>
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
    <label for="year">Year:</label>
    <select name="year" id="year">
    <option value="" disabled selected>Select Year</option>

        <option value="3">Third year</option>
        <option value="4">Fourth year</option>
    </select>
<br>
<label for="Subject">Subject</label>
<select name="Subject" id="subject">
<option value="" disabled selected>Select Department and Year first</option>

<?php

?>
</select><br>
<button type="submit" id='submitButton' >Submit</button>  
</form>
   <script src="script.js">

    </script>




</body>
</html>