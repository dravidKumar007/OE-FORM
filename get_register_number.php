<?php
session_start();

// Check if register number is set in the session
if(isset($_SESSION['register_no'])) {
    // Output the register number
    echo $_SESSION['register_no'];
} else {
    // Output an error message if register number is not set
    echo "Register number not found in session.";
}
?>
