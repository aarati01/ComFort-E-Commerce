<!DOCTYPE html>
<html>
  <head>
    <title>Logged In</title>
  </head>
  <body>
    <?php 
      // Start the session
      session_start();
    ?>
    <h1>You are now logged in!</h1>
    <?php if (isset($_SESSION['email'])) { ?>
      <p>Welcome, <?php echo $_SESSION['email']; ?>.</p>
      <a href="../HTML/user_info.php"><h2>Edit Profile</h2></a>
    <?php } else { ?>
      <p>Welcome!</p>
    <?php } ?>
  </body>
</html>
