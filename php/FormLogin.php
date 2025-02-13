<?php
require_once "config.php";
mysqli_set_charset($conn, 'utf8');

// Define database connection variables
$servername = "db";               // Change from 'localhost' to 'db'
$username = "web";                // Keep the same if the user exists in the Docker database
$password = "web";                // Password remains the same
$dbname = "signup_db";           

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // Get form data and sanitize it
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  // Prepare the SQL query to retrieve the user's data
  $sql = "SELECT * FROM users_information WHERE email='$email'";
  

  // Execute the query and get the result
  $result = mysqli_query($conn, $sql);

  // Check if the query returned any rows
  if (mysqli_num_rows($result) > 0) {
    
    // Get the user's data from the result
    $row = mysqli_fetch_assoc($result);
    
    // Check if the password is correct
    if (password_verify($password, $row["password"])) {
      // Password is correct, so set a session variable to indicate the user is logged in
      session_start();
      
      $_SESSION["loggedin"] = true;
      $_SESSION["email"] = $email;
      
      // Redirect the user to a secure page
      header("location: ../index.php");
    } else {
      // Password is incorrect, so show an error message
      header('Location:../HTML/login.html?err=invalid username and password');
      echo "Invalid password";
    }
    
  } else {
    // No rows were returned, so the email is not registered
    echo "Invalid email";
  }
}

// Close the database connection
mysqli_close($conn);

?>