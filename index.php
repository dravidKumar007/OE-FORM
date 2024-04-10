<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <form action="students.php" id="myForm">
       <h1>OPEN ELECTIVE</h1>
    <label for="name">Name:</label>
    <input type="Text" name="name" id="name" placeholder="Enter your name" required><br>
    <label for="Register">Register no:</label>
    <input type="number" name="Register" id="Register" placeholder="Enter Your Register number" min="10" required><br>
    <label for="Dept">Department:</label>
    <select name="Dept" id="Dept" >
    <option disabled selected>Select Department</option>
        <option value="CSE">CSE</option>
        <option value="IT">IT</option>
        <option value="MECH">MECH</option>
        <option value="BIO TECH">BIO TECH</option>
        <option value="EEE">EEE</option>
        <option value="ECE">ECE</option>
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
<button type="submit" id='submitButton' onclick="">Submit</button>  
</form>
   <script src="script.js">

    </script>




</body>
</html>