<?php
   $servername = "db";               // Change from 'localhost' to 'db'
   $username = "web";                // Keep the same if the user exists in the Docker database
   $password = "web";                // Password remains the same
   $dbname = "signup_db";           

    $conn = mysqli_connect($servername, $username, $password, $dbname);


    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>