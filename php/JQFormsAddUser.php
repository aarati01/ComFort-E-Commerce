<?php
session_start();

// // Define database connection variables
// $servername = "db";               // Change from 'localhost' to 'db'
// $username = "web";                // Keep the same if the user exists in the Docker database
// $password = "web";                // Password remains the same
// $dbname = "signup_db";           
// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);

$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
  $last_name = mysqli_real_escape_string($conn, $_POST["last_name"]);
  $datepicker = mysqli_real_escape_string($conn, $_POST["datepicker"]);
  $address = mysqli_real_escape_string($conn, $_POST["address"]);
  $city = mysqli_real_escape_string($conn, $_POST["city"]);
  $postal_code = mysqli_real_escape_string($conn, $_POST["postal_code"]);
  $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);
  
  // Assuming $password is retrieved from the form input, make sure it's defined
  $password = mysqli_real_escape_string($conn, $_POST["password"]);
  $hashed_password = password_hash($password, PASSWORD_BCRYPT);

  $sql = "INSERT INTO users_information (username, email, first_name, last_name, datepicker, address, city, phone, postal_code, password)
          VALUES ('$username', '$email', '$first_name', '$last_name', '$datepicker','$address', '$city', '$phone', '$postal_code', '$hashed_password')";
    // Execute the query and check for errors
//   if (mysqli_query($conn, $sql)) {
//     echo "Data added to database successfully";
//   } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//   }
// }

  if(mysqli_query($conn,$sql)){
      echo '<script>window.location.href = "../html/login.html"; alert("Registered successfully!!!")</script>';
      // header('Location:../HTML/login.html?msg=successful signup please login');
      // echo "Data added to database successfully";
  }else{
      header('Location:../index.html?err=signup error occurred please check');
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

mysqli_close($conn);
?>
