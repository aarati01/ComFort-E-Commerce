<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page after logout
header("location: ../html/login.html");
exit;
?>