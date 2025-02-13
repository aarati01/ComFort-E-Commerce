<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['email'])) {
    echo '<script>
            window.location.href = "login.html";
            </script>';
}

// Database connection
$servername = "db";               // Change from 'localhost' to 'db'
$username = "web";                // Keep the same if the user exists in the Docker database
$password = "web";                // Password remains the same
$dbname = "signup_db";           

// Create connection
//$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data based on email from session
$email = $_SESSION['email'];
$sql = "SELECT first_name, last_name, address, city, datepicker, postal_code, phone FROM users_information WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($firstName, $lastName, $address, $city, $dateOfBirth, $zipCode, $phoneNumber);
    $stmt->fetch();
} else {
    // Handle the case where user data is not found
    $firstName = "";
    $lastName = "";
    $address = "";
    $city = "";
    $dateOfBirth = "";
    $zipCode = "";
    $phoneNumber = "";
}

// Close the statement
$stmt->close();

// Check if the form is submitted for updating user data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_info'])) {
    // Retrieve and sanitize form data
    $newFirstName = htmlspecialchars($_POST["f_name"]);
    $newLastName = htmlspecialchars($_POST["l_name"]);
    $newAddress = htmlspecialchars($_POST["address"]);
    $newCity = htmlspecialchars($_POST["city"]);
    $newDateOfBirth = htmlspecialchars($_POST["date_of_birth"]);
    $newZipCode = htmlspecialchars($_POST["zip_code"]);
    $newPhoneNumber = htmlspecialchars($_POST["phone"]);

   // Prepare and execute the update query
$updateSql = "UPDATE users_information SET first_name=?, last_name=?, address=?, city=?, datepicker=?, postal_code=?, phone=? WHERE email=?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("ssssssss", $newFirstName, $newLastName, $newAddress, $newCity, $newDateOfBirth, $newZipCode, $newPhoneNumber, $email);
$updateStmt->execute();
$updateStmt->close();

// Set session variable for pop-up message
$_SESSION['profile_updated'] = true;

// Redirect back to profile.php after updating
header("Location: ".$_SERVER['PHP_SELF']);
exit();

}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <script src="../JS/adi-script.js"></script> 

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../CSS/jquery-ui.css">
    <style>
   /* Set body height */
body{
    height: 200px;  
}

/* Styling for the profile header */
#profile_header{
    background-color: black;
    margin-bottom: 0;
    border-radius: 10px;
}

/* Styling for the side list */
#sidelist{
    background-color: rgb(255, 203, 112);
    text-align: center;
    margin-top: 3%;
    margin-left: 3%;
    float: left; 
    width: 20%; 
    padding-right: 20px;
    padding-bottom: 20%;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); 
}

/* Styling for the profile email */
#p_email{
    margin-top: 10%;
    margin-right: 30%;
    margin-left: -5%;
}

/* Styling for the main content area */
#main{
    background-color: #d7f6fc;
    width: 90%;
    margin: 5%;
    padding: 1.6%;
    margin-top: 2%;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);   
}

/* Styling for the hello user section */
#hello_user{
    background-color: antiquewhite;
    border-radius: 10px;
    width: 8%;
}

/* Styling for the user section */
#user_section {
    margin-left: 27%; 
}

/* Styling for sections with id 'one' */
#one{
    background-color: #FFCB70;
    padding: 1%;
    margin: 2%;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

/* Styling for sections with id 'two' */
#two{
    background-color:#FFCB70;
    margin: 2%;
    padding: 2%;
    padding-left: 10%;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);   
}

/* Styling for image */
#img1{
   height: 15px;
   width: 15px;    
}

/* Styling for the header div */
#head_div{
    border-radius: 10px;
    background-color: #131210;
    color: aliceblue;
    padding: 0.5%;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);    
}

/* Styling for sections with id 'one', 'two', 'sidelist', 'main' */
#one, #two, #sidelist,#main {
    border-radius: 10px; 
}

/* Styling for the header div sections and div */
#head_div {
    display: grid;
    grid-template-columns: 1fr 1fr;
}

/* Styling for the header div sections */
#head_div section {
    grid-column: 1;
}

/* Styling for the header div div */
#head_div div {
    grid-column: 2;
    text-align: right;
}

/* Styling for the update info */
#update_info{
    width: 600px;
    height: 24px;
    margin-left: 1%;
}

/* Styling for the photo */
#photo {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: #ccc;
    margin-bottom: 10px;
}

/* Styling for the profile image */
#photo #profileImage{
    width: 100px;
    height: 100px;
    border-radius: 50%;    
}

/* Styling for the profile pt */
#profile_pt {
    font-size: 24px;
    margin-bottom: 5px;
}

/* Styling for the profile email */
#p_email {
    font-size: 16px;
    color: #666;
}

/* Styling for the profile modal */
.pmodal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

/* Styling for the modal content */
.pmodal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    text-align: center;
}

/* Styling for the close button in the modal */
.pclose {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.pclose:hover,
.pclose:focus {
    color: black;
    text-decoration: none;
}

/* Styling for photo option */
.photoOption {
    width: 100px;
    height: 100px;
    margin: 10px;
    cursor: pointer;
}

/* Styling for the background modal */
.modal, .modal_2, .modal_3, .modal_4 {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.4); 
}

/* Styling for the modal content */
.modal-content, .modal-content_2, .modal-content_3, .modal-content_4 {
    background-color: #e0ddd8;
    margin: 15% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
    text-align: justify;
    border-radius: 10px;
}

/* Styling for the close button in the modal content */
.close, .close_2, .close_3, .close_4 {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Styling for the accordion header */
.accordion-header {
    background-color: #f4f4f4;
    color: #333;
    cursor: pointer;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

/* Styling for the accordion content */
.accordion-content {
    display: none;
    padding: 10px;
}

/* Styling for active accordion items */
.accordion-item.active .accordion-content {
    display: block;
}

/* Styling for the header */
#header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 80px;
    width: 90%;
    height: 50px;
    background-color: #FFCB70;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
    z-index: 999;
    position: sticky;
    top: 0;
    left: 0;
}

/* Styling for the logo */
#header img{
    width: 200px;
    height: 170px;
}

/* Styling for the navbar */
#navbar {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Styling for navbar list items */
#navbar li{
    list-style: none;
    padding:0 20px;
    position: relative;
}

/* Styling for navbar links */
#navbar li a{
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    color: black;
    transition: 0.3s ease;
}

/* Styling for navbar links on hover and when active */
#navbar li a:hover,
#navbar li a.active {
    color: #453212;
}

/* Styling for the underline effect on navbar links */
#navbar li a.active::after,
#navbar li a:hover::after{
    content: "";
    width: 30%;
    height: 2px;
    background-color: #5d4419;
    position: absolute;
    bottom: -4px;
    left: 20px;
}

/* Styling for mobile view */
#mobile {
    display: none;
    align-items: center;   
}
/* Styling for the footer */
footer{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    box-shadow: 5px 0px 15px rgba(0, 0, 0, 0.1);
}

/* Styling for columns within the footer */
footer .col {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 20px;
}

/* Styling for footer headings */
footer h4{
    font-family: 'Montserrat', sans-serif;
    font-size: 15px; 
    padding-bottom: 10px;
    margin-bottom: 1px;
    align-items: flex-start;
}

/* Styling for footer paragraphs */
footer p{
    font-family: 'Montserrat', sans-serif;
    font-size: 13px; 
    margin: 0 0 8px 0;
    padding-top: 0;
}

/* Styling for footer links */
footer a{
    text-decoration: none;
    color: #0a0a0a;
    font-family: 'Montserrat', sans-serif;
    font-size: 13px; 
    margin: 0 0 10px 0;
    cursor: pointer;
}

/* Styling for the copyright section */
footer .copyright {
    text-align: center;
    width: 100%;
    padding: 0 0 0 100px;
}

/* Styling for social media icons */
footer i{
    cursor: pointer;
    padding: 0 8px;
}

/* Styling for column 2 in the footer */
footer .col2 {
    align-items: center;
}

/* Styling for footer links and icons on hover */
footer a:hover,
footer i:hover {
    color: #088178;
}

/* Media query for smartphones */
@media screen and (max-width: 600px) {
    /* Styling adjustments for smaller screens */
    #sidelist{
        margin-bottom: 3%;
        width: 95%; 
        padding-right: 0;
        padding-bottom: 0;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }
    #navbar.active {
        right: 0;
    }
    #p_email{
        margin-left: 31%;
    }
    #sidelist ul li{
        display: flex; /* Use flexbox */
        flex-direction: column-reverse; 
        padding-right: 7%;
    }
    #main{
        float: clear;
        overflow: auto;
        display: flex; /* Use flexbox */
        flex-direction: column; 
    }
    #one, #two, #sidelist,#main {
        border-radius: 10px;
    }
    #profile_header{
        background-color: black;
        margin-bottom: 0;
        border-radius: 10px;
    }
    #one {
        display: flex; /* Use flexbox */
        flex-direction: column; 
    }
    #u_email{
        margin-top: 10%;
    }
    #user_section {
        margin-left: 0; 
    }
    #one{
        background-color: #FFCB70;
        padding: 1%;
        margin: 2%;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }
    #f_name, #l_name, #city, #date_of_birth, #zip_code, #phone{
        margin-top: 3%;
        width: 30%;
    }
    #address{
        width: 95%;
    }
    #update{
        margin-left: 36%;
    }
    #two{
        background-color:#FFCB70;
        margin: 2%;
        padding: 2%;
        padding-left: 10%;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        display: flex; /* Use flexbox */
        flex-direction: column;
    }
    #update_info{
        width: auto;
        margin-left: 30%;
    }
}
/* Styles for tablets */
@media only screen and (min-width: 600px) and (max-width: 1024px) {

/* Padding adjustments for account settings */
#account_settings{
    padding-left: 6%;
    padding-right: 2%;
}

/* Styling adjustments for form fields */
#f_name, #l_name, #city, #date_of_birth, #zip_code, #phone{
    margin-top: 3%;
    width: 30%;
}

/* Styling adjustments for navbar in active state */
#navbar.active {
    right: 0;
}

/* Margin and alignment adjustment for email field */
#p_email{
    margin-top: 20%;
    margin-left: -16%;
}

/* Overflow adjustment for #one element */
#one{
    overflow: auto;
}

/* Margin adjustment for update button */
#update{
    margin-left: 36%;
}

/* Width adjustment for update info section */
#update_info{
    width: 55%;
    margin-left: 15%;
}

}

@media only screen and (min-width: 60px) and (max-width: 760px) {

/* Styling adjustments for form fields */
#first_name, #last_name, #city, #date_of_birth, #postal_code, #phone{
    width: 32%;
}

/* Styling adjustments for navbar in active state */
#navbar.active {
    right: 0;
}

/* Width adjustment for address field */
#address{
    width: 82%;
}

/* Margin adjustment for update button */
#update{
    margin-left: 30%;
}

}

@media only screen and (min-width: 600px) and (max-width: 900px) {

/* Width adjustment for address field */
#address{
    width: 85%;
}

/* Margin adjustment for update button */
#update{
    margin-left: 36%;
}

/* Padding adjustment for side list */
#sidelist{
    padding-bottom: 25%;
}

}

@media only screen and (min-width: 900px) and (max-width: 1200px) {

/* Margin adjustment for email field */
#p_email{
    margin-left: -10%;
}

/* Styling adjustments for form fields */
#first_name, #last_name, #city, #date_of_birth, #postal_code, #phone{
    width: 30%;
}

/* Width adjustment for address field */
#address{
    width: 82%;
}

/* Margin adjustment for update button */
#update{
    margin-left: 36%;
}

/* Padding adjustment for side list */
#sidelist{
    padding-bottom: 25%;
}

/* Styling adjustments for form fields */
#f_name, #l_name, #city, #date_of_birth, #zip_code, #phone{
    margin-top: 3%;
    width: 30%;
}

/* Width adjustment for update info section */
#update_info{
    width: 55%;
    margin-left: 15%;
}

}

/* Media query for navbar on smaller screens */
@media (max-width: 900px) {
/* Styling adjustments for navbar */
#navbar {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    position: fixed;
    top:0;
    right: -400px;
    height: 100vh;
    width: 300px;
    background-color: white;
    box-shadow: 0 40px rgba(0, 0, 0, 0.1);
    padding: 80px 0 0 10px;
    transition: 0.3s;
}

/* Styling adjustments for navbar in active state */
#navbar.active {
    right: 0;
}

/* Styling adjustments for mobile navigation */
#mobile #bar{
    display: initial;
}

/* Styling adjustments for navbar list items */
#navbar li{
    margin-bottom: 25px;
}

/* Styling adjustments for mobile navigation */
#mobile {
    display: flex;
    align-items: center;
}

/* Styling adjustments for mobile navigation */
#mobile i{
    text-decoration: none;
    color: #0a0a0a;
    padding: 0 10px;
    cursor: pointer;
}

/* Styling adjustments for navbar */
#bar{
    z-index: 999;
    margin-right: 35px;
}

/* Styling adjustments for banner */
#banner {
    height: 70vh;
    padding: 0 80px;
}

/* Styling adjustments for header */
#header {
    padding: 20px 41px;
}

/* Styling adjustments for product cards */
#trend .pro {
    width: 40%;
    min-width: 250px;
    margin: 15px 15px;
}

/* Styling adjustments for category boxes */
.section-p1 .ce-box {
    width: 120px;
    margin: 10px 5px;
}

/* Styling adjustments for category box images */
#categories .ce-box img {
    height: 120px;
    width: 120px;
}

/* Styling adjustments for banner boxes */
#sm-banner .banner-box {
    min-width: 100%;
    height: 30vh;
}

/* Styling adjustments for small banner */
#sm-banner {
    padding-left: 15px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

/* Styling adjustments for product banner */
#product-banner{
    height: 48vh;
}

}

@media only screen and (min-width: 1200px) and (max-width: 1400px) {

/* Styling adjustments for form fields */
#first_name, #last_name, #city, #date_of_birth, #postal_code, #phone{
    width: 30%;
}

/* Styling adjustments for address field */
#address{
    width: 82%;
}

/* Margin adjustment for email field */
#p_email{
    margin-left: -9%;
}

/* Margin adjustment for update button */
#update{
    margin-left: 36%;
}

/* Padding adjustment for side list */
#sidelist{
    padding-bottom: 20%;
}


#p_email{
    
    margin-left: -9%;
        }

    
        
    
       
   }

     
    </style>


</head>
<body>
<section id="header">
        <a href="#"><img src="../img/comfort.PNG"></a>
        <div>
            <ul id="navbar">
                <li><a href="/">Home</a></li>
                <li><a href="product.html">Products</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="about.html">About</a></li>
                <li><a class="active" href="user_info.php">Profile</a></li>
                <li><i id="cart-icon" class="fa fa-shopping-bag" aria-hidden="true"></i><span id="cart-quantity"></span></li>
            </ul>
        </div>
        <div id="mobile">
            <i id="bar" class="fa fa-bars" aria-hidden="true"></i>
        </div>
    </section>
    
    <div id="popup_message" style="display: none; width: 100%; background-color: #cff307; color: black; text-align: center; padding: 10px; z-index: 1000;">
    User profile updated successfully!
</div>

   

    
      
    <article id="main">
        <div id="head_div">
            <section >
                <h2> Profile Dashboard </h2>
                <h3> Welcome to Comfort+ profile portal </h3>
                
            </section>
           <!--<div >
                <div> Hello, <span> User</span> </div>
            </div>  -->  
        </div>
        <section id="sidelist" > 
    <!-- Account Settings Section -->
    <h3 >Account Settings</h3>
    <ul style="list-style: none; text-align: left; "> 
        <!-- Help and Support Modal Button -->
        <li> <button onclick="openModal()"> <img  id="img1"  src="../img/customer-service.png" > Help and Support</button> </li><br>
        <!-- Security Modal Button -->
        <li> <button onclick="openModal_2()"> <img  id="img1"  src="../img/shield.png" > Security</button> </li><br>
        <!-- Delete Account Modal Button -->
        <li> <button onclick="openModal_3()"><img  id="img1"  src="../img/add-user.png" > Delete Account</button> </li><br>
        <!-- Additional Features Modal Button -->
        <li><button onclick="openModal_4()"><img  id="img1"  src="../img/paper.png" > Additional Features</button> </li><br>
        <!-- Logout Button -->
        <li><button onclick="window.location.href='../php/logout.php';" > <img id="img1" src="../img/power.png"> Log Out </button> </li>
    </ul>

    <!-- Help and Support Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span><br>
            <!-- FAQ Accordion -->
            <div class="accordion">
                <!-- FAQ Items -->
                <div class="accordion-item">
                    <div  class="accordion-header">1. What should I do if I encounter an error while using the platform?</div>
                    <div class="accordion-content">
                        <p>If you encounter any errors or technical issues while using the platform, please try refreshing the page or logging out and logging back in. If the problem persists, please contact our support team for assistance</p>
                    </div>
                </div>
                        <div class="accordion-item">
                        <div class="accordion-header">2. How can I update my account information?</div>
                        <div class="accordion-content">
                            <p>You can update your account information, such as your name, email address, and contact details, by navigating to the "Profile Information" section of your account settings. Make the necessary changes and save them by clicking on the update button.</p>
                                                
                        </div>
                    
                        </div>
                        <div class="accordion-item">
                        <div class="accordion-header">3. Is my personal information secure on this platform?</div>
                        <div class="accordion-content">
                            <p>Yes, we take the security and privacy of your personal information seriously. We employ robust security measures to protect your data from unauthorized access, misuse, or disclosure. For more information about our privacy practices, please refer to our Privacy Policy.</p>
                                    
                        </div>
                        </div>
                        <div class="accordion-item">
                        <div class="accordion-header">4. How can I report an issue or provide feedback?</div>
                        <div class="accordion-content">
                            <p>  If you encounter any issues while using the platform or have suggestions for improvement, we encourage you to reach out to our support team or use the feedback form provided on the platform. Your feedback is valuable to us, and we appreciate your input.</p>
                                                        
                        </div>
                    
                        </div>
                        <div class="accordion-item">
                        <div class="accordion-header">5. What are the system requirements for using this platform? </div>
                        <div class="accordion-content">
                            <p>To ensure optimal performance and compatibility, please make sure you're using a supported web browser and that your device meets the minimum system requirements. You can find more information about supported browsers and system requirements in the platform's documentation.</p>
                                                        
                        </div>
                    
                        </div>
                        <div class="accordion-item">
                        <div class="accordion-header">6. How can I contact customer support for further assistance?</div>
                        <div class="accordion-content">
                            <p>If you need further assistance or have specific questions that aren't addressed in the FAQs, please don't hesitate to contact our customer support team. You can reach us via email, phone, or live chat during our business hours, and we'll be happy to assist you.</p>
                                                        
                        </div>
                    
                        </div>
                        <div class="accordion-item">
                        <div class="accordion-header">7. How do I contact customer support?</div>
                        <div class="accordion-content">
                            <p> You can reach our customer support team by phone, email, or live chat. Our support representatives are available to assist you with any questions or issues you may have.</p>
                                                            
                        </div>
                    
                        </div>
                  </div>
                </div>
            </div>

            <div id="myModal_2" class="modal_2">
                <div class="modal-content_2">
                  <span class="close_2">&times;</span>

                  
                    <div class="accordion">
                      <div class="accordion-item">
                        <div class="accordion-header">Password requirements : </div>
                        <div class="accordion-content">
                            <ol><li>Your password must be at least 8 characters long.</li>
                                <li>Make sure your password is strong:
                                    <ul>
                                        <li>Include numbers</li>
                                        <li> Include alphabets with upper and lower case</li>
                                        <li> Include symbols and characters like @,$ etc.</li>
                                        <li>Make sure you donot use the same password for other sites </li>
                                        <br><br>
                                    </ul>
                                </li>
                                </ol>
                        </div>
                        </div>
                        <div class="accordion-item">
                        <div class="accordion-header">Change your Password : </div>
                        <div class="accordion-content">
                            <p>Click the link below to change your password.</p>
                                <p><a href="../../Week12/html/password_change.html">Change Password</a></p>                  
                        </div>
                    
                        </div>
                        <div class="accordion-item">
                        <div class="accordion-header">Forgot Password : </div>
                            <div class="accordion-content">
                                <p>If you have forgotten your password please click the link below to change your password.</p>
                                    <p><a href="../../Week12/html/forgot_password.html">Forgot Password</a></p>        
                            </div>
                        </div>
    
                      </div>
                    </div>
                </div>
            </div>

            
            <div id="myModal_3" class="modal_3">
                <div class="modal-content_3">
                  <span class="close_3">&times;</span>
        
                  <p style="color: red;"> If you delete this account : </p>
                  <p style="color: red;"> 1. The account will be deleted from all of your devices</p>
                  <p style="color: red;">2. All of your activities and orders will be deleted</p>
                  <p style="color: red;">Your items in the shopping cart will also be removed</p>
                  <br>
                  <br>
                  <div class="accordion">
                    <div class="accordion-item">
                      <div class="accordion-header">Report your problem instead:</div>
                      <div class="accordion-content">
                        <p> To report your problem please either contact the help and support team or use the complaint form provided on the platform </p>
                      
                      </div>
                    </div>
                    <div class="accordion-item">
                      <div class="accordion-header">Delete Account</div>
                      <div class="accordion-content">
                        <div id="message"></div>
            
                            <form id="deleteAccountForm">
                                <label for="confirm">Are you sure you want to delete your account?</label><br>
                                <input type="checkbox" id="confirm" required>
                                <button type="submit">Delete Account</button>
                            </form>
                       </div>
                      </div>
                    </div>
                </div>
                 
                  
                </div>
            </div>
        

            <div id="myModal_4" class="modal_4">
                <div class="modal-content_4">
                  <span class="close_4">&times;</span>
                  <div class="accordion">
                        <div class="accordion-item">
                        <div class="accordion-header">1. Membership Benefits:</div>
                        <div class="accordion-content">
                            <li>Unlock exclusive benefits and access premium features with our membership plans.</li>
                            <li>Enjoy priority support, early access to new features, and member-only discounts.</li>
                            <li>Elevate your experience with personalized content, tailored recommendations, and advanced customization options.</li>
                        
                        </div>
                        </div>
                        <div class="accordion-item">
                        <div class="accordion-header">2. Subscription Plans: </div>
                        <div class="accordion-content">
                            <li>Choose from our flexible subscription plans designed to fit your needs and budget.</li>
                            <li>Select the plan that best suits you, whether it's monthly, annual, or a one-time purchase.</li>
                            <li>Gain unlimited access to our platform with no ads, interruptions, or hidden fees.</li>
                            
                        </div>
                        </div>
                        <div class="accordion-item">
                        <div class="accordion-header">3. Customization Options:</div>
                        <div class="accordion-content">
                            <li>Tailor your subscription experience with customizable settings, preferences, and profiles.</li>
                            <li>Fine-tune your membership to align with your interests, goals, and preferences.</li>
                            <li>Enjoy a personalized experience that adapts to your unique needs and preferences.</li>
                        
                        </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header">4. Cancellation and Refund Policy:</div>
                            <div class="accordion-content">
                                <li>Rest assured with our hassle-free cancellation and refund policy, giving you peace of mind.</li>
                                <li>Cancel your subscription anytime with no strings attached, and receive a prorated refund for unused portions.</li>
                                <li>Our customer support team is here to assist you every step of the way, ensuring a smooth and seamless experience.</li>
                                
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header"> 5. Community Engagement:</div>
                            <div class="accordion-content">
                                <li>Join our vibrant community of members and connect with fellow enthusiasts, experts, and creators.</li>
                                <li>Participate in exclusive events, workshops, and webinars curated specifically for our members.</li>
                                <li>Share your ideas, feedback, and suggestions to help shape the future of our platform and community.</li>
                            
                            </div>
                        </div>
                   </div>
                  
        
                </div>
            </div>
    
        </section>
        <section id="user_section">
    <!-- Profile Information Section -->
    <div id="one" class="main_divs">
        <!-- Profile Photo and Name -->
        <div id="photo">
            <img id="profileImage" src="https://cdn.pixabay.com/photo/2016/08/31/11/54/icon-1633249_640.png " alt="Profile Photo">
        </div>
        <h3 id="profile_pt"><?php echo $firstName; ?></h3>
        <!-- User Email -->
        <p id="p_email"><?php echo $_SESSION['email']; ?></p>
        <!-- Change Photo Button -->
        <div>
            <button style="width: 150px ; height: 30px ;" class="ui-button ui-widget ui-corner-all" id="changePhotoBtn">Change Photo</button>
        </div>
    </div>

    <!-- Photo Selection Modal -->
    <div id="photoModal" class="pmodal">
        <div class="pmodal-content">
            <span class="pclose">&times;</span>
            <h2>Choose Profile Photo</h2>
            <!-- Photo Options -->
            <div id="photoOptions">
                <img class="photoOption" src="https://cdn.pixabay.com/photo/2017/01/31/21/23/avatar-2027366_640.png" alt="Photo 1">
                <img class="photoOption" src="https://cdn.pixabay.com/photo/2014/03/25/16/24/female-296990_640.png" alt="Photo 2">
                <img class="photoOption" src="https://cdn.pixabay.com/photo/2016/08/31/11/54/icon-1633249_640.png" alt="Photo 2">
            </div>
        </div>
    </div>

    <!-- Profile Information Form -->
    <div id="two" class="main_divs"> 
        <h2> Profile Information</h2><br>
        <!-- Profile Information Form -->
        <form id="profileForm" method="POST">
            <!-- First Name and Last Name Fields -->
            <label style="margin-right: 41%;" for="f_name">First Name</label>
            <label for="l_name">Last Name</label><br><br>
            <input style="margin-right: 20%;" type="text" id="f_name" name="f_name" size="30" value="<?php echo $firstName; ?>" required>
            <input type="text" id="l_name" name="l_name" size="30" value="<?php echo $lastName; ?>" required><br><br>
            <!-- Address Field -->
            <label for="address">Address</label><br><br>
            <input id="address" name="address" size="85" value="<?php echo $address; ?>" required><br><br>
            <!-- City and Birth Date Fields -->
            <label style="margin-right: 47%;" for="city">City</label>
            <label for="date_of_birth">Birth Date</label><br><br>
            <input style="margin-right: 20%;" type="text" id="city" name="city" size="30" value="<?php echo $city; ?>" required>
            <input type="text" id="date_of_birth" size="30" name="date_of_birth" value="<?php echo $dateOfBirth; ?>" required><br><br>
            <!-- Zip Code and Phone Number Fields -->
            <label style="margin-right: 43%;" for="zip_code">Zip Code</label>
            <label for="phone">Phone Number</label><br><br>
            <input style="margin-right: 20%;" id="zip_code" name="zip_code" size="30" value="<?php echo $zipCode; ?>" required>
            <input type="tel" id="phone" name="phone" size="30" value="<?php echo $phoneNumber; ?>" required><br><br><br>
            <!-- Update Profile Button -->
            <button type="submit" id="update_info" name="update_info">Update Profile</button>
        </form>
    </div>
</section>

    </article>
    <footer class="section-p1">
    <div class="col">
        <h4>Contact</h4>
        <p><strong>Address:</strong> 512 King street w, Toronto</p>
        <p><strong>Phone:</strong> (+1)4376666669</p>
        <p><strong>Hours:</strong> 10:00 - 18:00, Mon-Sat</p>
    </div>
    <div class="col col2">
        <h4>Follow Us</h4>
        <div class="icon">
        <i class="fa fa-facebook" aria-hidden="true"></i>
        <i class="fa fa-instagram" aria-hidden="true"></i>
        <i class="fa fa-twitter" aria-hidden="true"></i>
        <i class="fa fa-youtube-play" aria-hidden="true"></i>
    </div>
    </div>
<div class="col">
    <h4>About</h4>
    <a href="#">About us</a>
    <a href="#">Privacy Policy</a>
    <a href="#">Terms & Conditions</a>
    <a href="#">Contact Us</a>
</div>
<div class="copyright">
    <p>&copy; 2024, Comfort+</p>
</div>
</footer>
    
    <script>
    // Check if the session variable is set for profile update
    <?php if (isset($_SESSION['profile_updated']) && $_SESSION['profile_updated'] === true): ?>
        document.getElementById('popup_message').style.display = 'block'; // Show the pop-up message
        setTimeout(function() {
            document.getElementById('popup_message').style.display = 'none'; // Hide the pop-up after 3 seconds
        }, 3000);
    <?php
        unset($_SESSION['profile_updated']);
        endif;
    ?>
</script>


    <script src="../js/user_infojs.js"></script>

</body>
</html> -->