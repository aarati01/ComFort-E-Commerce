<?php
//    $servername = "db";               // Change from 'localhost' to 'db'
//    $username = "web";                // Keep the same if the user exists in the Docker database
//    $password = "web";                // Password remains the same
//    $dbname = "signup_db";           

//     $conn = mysqli_connect($servername, $username, $password, $dbname);


$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>