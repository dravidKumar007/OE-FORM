

working
<?php
// Include PHPMailer autoload file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $register_no = $_POST["Register"];
    $dept = $_POST["Dept"];
    $year = $_POST["year"];
    $email = $_POST["Email"];
    $password_db = $_POST["Password"];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';        //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'dravidkumardk04@gmail.com';                     //SMTP username
        $mail->Password   = 'wiglmgcnwoqqkozh';                               //SMTP password
        $mail->SMTPSecure = 'ssl';  
        $mail->Port       = 465;                                    //TCP port to connect to
        
        //Recipients
        $mail->setFrom('dravidkumardk04@gmail.com');
        $mail->addAddress($email);                          //Add a recipient
        $mail->isHTML(true);          //Enable implicit TLS encryption

        //Content
        $mail->isHTML(true);                                       //Set email format to HTML
        $mail->Subject = 'Login Success';
        $mail->Body    = "<div style='border:1px solid black ;border-radius:10px; font-family: Arial; box-shadow:0 0 20px black' ><center><h1>Dear $name,</h1><h3 style='color:green'>You have successfully verified  .</h3></center></div>";

        // Send the email
        if ($mail->send()) {
            // Database connection parameters
            $servername = "localhost"; // Change this to your server name
            $username = "root"; // Change this to your MySQL username
            $password = "admin@123"; // Change this to your MySQL password
            $dbname = "subjects"; // Change this to your MySQL database name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Insert data into students table
            $sql = "INSERT INTO students (register_no, name, dept, years, email, password) VALUES ('$register_no', '$name', '$dept', '$year', '$email', '$password_db')";

            if ($conn->query($sql) === TRUE) {
                echo "Record inserted successfully and email sent.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            echo "Email could not be sent.";
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
