<?php
session_start();

    // Check if user is logged in
    if (isset($_SESSION['email'])) {
        // Include database credentials
    //     $servername = "db";               // Change from 'localhost' to 'db'
    //     $username = "web";                // Keep the same if the user exists in the Docker database
    //     $password = "web";                // Password remains the same
    //     $dbname = "signup_db";           

    //     // Create a new mysqli connection
    //    // $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    //    $conn = new mysqli($servername, $username, $password, $dbname);


    //Get Heroku ClearDB connection information
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
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch user's first name from the database based on the session email
        $email = $_SESSION['email'];
        $sql = "SELECT first_name FROM users_information WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $firstName = $row["first_name"];
            }
        } else {
            $firstName = "User";
        }

        // Close connection
        $conn->close();
    } else {
        $firstName = "User";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comfort+</title>
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="./JS/adi-script.js"></script>
    <link rel="stylesheet" href="./CSS/cart.css">
    <script src="./JS/cart.js"></script>
</head>
<body>
<section id="header">
    <!-- Logo -->
    <a href="#"><img src="./img/comfort.PNG"></a>
    <!-- Navigation Bar -->
    <div>
        <ul id="navbar">
            <!-- Navigation Links -->
            <li><a class="active" href="#">Home</a></li>
            <li><a href="./HTML/product.html">Products</a></li>
            <li><a href="./HTML/contact.html">Contact</a></li>
            <li><a href="./HTML/about.html">About</a></li>
            <li><a href="./HTML/user_info.php">Profile</a></li>
            <!-- Cart Icon -->
            <li><i id="cart-icon" class="fa fa-shopping-bag" aria-hidden="true"></i><span id="cart-quantity"></span></li>
        </ul>
    </div>
    <!-- Mobile Navigation -->
    <div id="mobile">
        <i id="bar" class="fa fa-bars" aria-hidden="true"></i>
    </div>
</section>

<!-- Popup Message -->
<div id="popup_message" style="background-color: #cff307; color: black; text-align: center; padding: 10px; z-index: 1000;">
    Welcome back, <?php echo $firstName; ?>
</div>

<!-- Cart Modal -->
<div id="cartModal" class="modal">
    <div class="modal-content">
        <!-- Close Button -->
        <span id="closeCartModalBtn" class="close">&times;</span>
        <!-- Title -->
        <h2>Cart</h2>
        <!-- Cart Items Container -->
        <div id="cartItems" class="cart-items">
            <!-- Cart items will be dynamically added here -->
        </div>
        <!-- Cart Actions (Increment/Decrement Quantity) -->
        <div id="cartActions" class="cart-actions">
            <button id="decrementQuantityBtn">-</button>
            <button id="incrementQuantityBtn">+</button>
        </div>
        <!-- Cart Buttons (Checkout/Close) -->
        <div class="cart-buttons">
            <button id="checkoutBtn">Checkout</button>
            <button id="closeCartBtn">Close</button>
        </div>
    </div>
    <!-- Total Price Container -->
    <div id="totalPriceContainer" class="total-price-container">
        <hr>
        <p>Total Price: <span id="totalPrice">0.00</span></p>
    </div>
</div>

      
<section id="banner">
    <!-- Banner Heading -->
    <h4>Every step feels like a home</h4>
    <!-- Brand Name -->
    <h3>Comfort+</h3>
    <!-- Shop Now Button -->
    <button onclick="window.location.href='./HTML/product.html';">Shop Now</button>
</section>

<section id="trend" class="section-p1">
    <!-- Trending Section Heading -->
    <h2>Join the Trend!!!</h2>
    <!-- Trending Section Description -->
    <p>Latest trending Shoes for Summer</p>
    <!-- Product Container -->
    <div class="pro-container" onclick="window.location.href='./HTML/sproduct.html';">
    <!-- Product 1 -->
    <div class="pro">
        <!-- Product Image -->
        <img src="./img/shoe3.jpg">
        <div class="descrip">
            <!-- Brand Name -->
            <span>comfort+</span>
            <!-- Product Title -->
            <h5>Zesty Steps: New Orange Footwear with Urban Flair</h5>
            <!-- Star Ratings -->
            <div class="star">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
            </div>
            <!-- Product Price -->
            <h4>$79</h4>
        </div>
    </div>
    <!-- Product 2 -->
    <div class="pro">
        <!-- Product Image -->
        <img src="./img/shoe2.jpg">
        <div class="descrip">
            <!-- Brand Name -->
            <span>comfort+</span>
            <!-- Product Title -->
            <h5>Ethereal Elegance: White Pointed-Toe High Heels</h5>
            <!-- Star Ratings -->
            <div class="star">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
            </div>
            <!-- Product Price -->
            <h4>$99</h4>
        </div>
    </div>
    <!-- Product 3 -->
    <div class="pro">
        <!-- Product Image -->
        <img src="./img/shoe4.jpg">
        <div class="descrip">
            <!-- Brand Name -->
            <span>comfort+</span>
            <!-- Product Title -->
            <h5>Forest Path Favorites: Stylish Grey Footwear with a Pop of Orange</h5>
            <!-- Star Ratings -->
            <div class="star">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
            </div>
            <!-- Product Price -->
            <h4>$49</h4>
        </div>
    </div>
    <!-- Product 4 -->
    <div class="pro">
        <!-- Product Image -->
        <img src="./img/shoe9.jpeg">
        <div class="descrip">
            <!-- Brand Name -->
            <span>comfort+</span>
            <!-- Product Title -->
            <h5>Elevate Your Style: Floating Burgundy Shoe with Classic Design</h5>
            <!-- Star Ratings -->
            <div class="star">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
            </div>
            <!-- Product Price -->
            <h4>$89</h4>
        </div>
    </div>
            <div class="pro">
                <!-- Product 5 -->
                <img src="./img/shoe6.jpg">
                <div class="descrip">
                    <span>comfort+</span>
                    <h5>Heel Haven: A play on “heel” and “haven,” suggesting a sanctuary for shoe lovers.</h5>
                    <div class="star">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>

                    </div>
                    <h4>$129</h4>
                </div>
            </div>
            <div class="pro">
                <!-- Product 6 -->
                <img src="./img/shoe5.jpg">
                <div class="descrip">
                    <span>comfort+</span>
                    <h5>StrideStyle: Combining “stride” with “style” to highlight both functionality and fashion.</h5>
                    <div class="star">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>

                    </div>
                    <h4>$199</h4>
                </div>
            </div>
            <div class="pro">
                <!-- Product 7 -->
                <img src="./img/shoe8.jpg">
                <div class="descrip">
                    <span>comfort+</span>
                    <h5>Tied Elegance: Emphasizes the sophistication and attention to detail in your shoe collection.</h5>
                    <div class="star">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>

                    </div>
                    <h4>$69</h4>
                </div>
            </div>
            <div class="pro">
                <!-- Product 8 -->
                <img src="./img/shoe7.jpg">
                <div class="descrip">
                    <span>comfort+</span>
                    <h5>Footwear Craftsmanship: Highlights the skill and care put into creating each pair of shoes</h5>
                    <div class="star">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>

                    </div>
                    <h4>$89</h4>
                </div>
            </div>
        </div>
    </section>
<!-- Section for exploring categories -->
<h2 id="categorie">Explore our categories</h2>
<section id="categories" class="section-p1">
    <!-- Category: Man -->
    <div class="ce-box" onclick="window.location.href='./HTML/product.html#man';">
        <img src="./img/ce1.jpeg">
        <h6>Man</h6>
    </div>
    <!-- Category: Woman -->
    <div class="ce-box" onclick="window.location.href='./HTML/product.html#woman';">
        <img src="./img/ce2.jpeg">
        <h6>Woman</h6>
    </div>
    <!-- Category: Kids -->
    <div class="ce-box" onclick="window.location.href='./HTML/product.html#kid';">
        <img src="./img/ce3.jpeg">
        <h6>Kids</h6>
    </div>
</section>

<!-- Section for more information -->
<section id="more">
    <div class="m1">
        <h1>#More</h1>
    </div>
</section>

<!-- Section for small banners -->
<section id="sm-banner" class="section-p1">
    <!-- Small banner 1: Crazy deals -->
    <div class="banner-box" onclick="window.location.href='./HTML/product.html';">
        <h4>Crazy deals</h4>
        <h2>Save money with 50% off</h2>
        <span>For limited time only!!!</span>
        <button>Learn More</button>
    </div>
    <!-- Small banner 2: How we started -->
    <div class="banner-box banner-box2" onclick="window.location.href='./HTML/about.html';">
        <h4>How we started</h4>
        <h2>#KnowUs</h2>
        <button>Learn More</button>
    </div>
</section>

<!-- Footer section -->
<footer class="section-p1">
    <!-- Column 1: Contact -->
    <div class="col">
        <h4>Contact</h4>
        <p><strong>Address:</strong> 512 King street w, Toronto</p>
        <p><strong>Phone:</strong> (+1)4376666669</p>
        <p><strong>Hours:</strong> 10:00 - 18:00, Mon-Sat</p>
    </div>
    <!-- Column 2: Follow Us -->
    <div class="col col2">
        <h4>Follow Us</h4>
        <div class="icon">
            <i class="fa fa-facebook" aria-hidden="true"></i>
            <i class="fa fa-instagram" aria-hidden="true"></i>
            <i class="fa fa-twitter" aria-hidden="true"></i>
            <i class="fa fa-youtube-play" aria-hidden="true"></i>
        </div>
    </div>
    <!-- Column 3: About -->
    <div class="col">
        <h4>About</h4>
        <a href="#">About us</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms & Conditions</a>
        <a href="#">Contact Us</a>
    </div>
    <!-- Copyright -->
    <div class="copyright">
        <p>&copy; 2024, Comfort+</p>
    </div>
</footer>

<!--welcome message-->
<script>
$(document).ready(function(){
            setTimeout(function() {
                $("#popup_message").slideUp(1000); // Slide down with animation duration 1000ms (1 second)
            }, 7000); // 5000 milliseconds = 5 seconds delay
        });

    document.addEventListener("DOMContentLoaded", function() {
    const cartIcon = document.getElementById("cart-icon");
    const cartModal = document.getElementById("cartModal");
    const closeCartBtn = document.getElementById("closeCartBtn");
    const closeCartModalBtn = document.getElementById("closeCartModalBtn");
    const checkoutBtn = document.getElementById("checkoutBtn");
    const cartItemsContainer = document.getElementById("cartItems");
    const totalPriceDisplay = document.getElementById("totalPrice");
    const decrementQuantityBtn = document.getElementById("decrementQuantityBtn");
    const incrementQuantityBtn = document.getElementById("incrementQuantityBtn");
    const cartQuantitySpan = document.getElementById("cart-quantity");

    // Retrieve cart items from localStorage or initialize an empty array
    let cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

    // Function to save cart items to localStorage
    function saveCartItems() {
        localStorage.setItem("cartItems", JSON.stringify(cartItems));
    }

    // Function to remove an item from the cart
    function removeFromCart(productName) {
        cartItems = cartItems.filter(item => item.name !== productName);
        saveCartItems();
        renderCart();
    }

    // Function to render the cart items in the cart modal
    function renderCart() {
        cartItemsContainer.innerHTML = '';
        let totalPrice = 0;

        cartItems.forEach(item => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.innerHTML = `
                <img src="${item.image}" alt="Product Image">
                <div class="cart-item-details">
                    <h4>${item.name}</h4>
                    <p>Price: $${item.price.toFixed(2)}</p>
                    <p>Quantity: ${item.quantity}</p>
                    <p>Total: $${item.totalPrice.toFixed(2)}</p>
                </div>
            `;
            cartItemsContainer.appendChild(cartItem);
            totalPrice += item.totalPrice;
        });

        totalPriceDisplay.textContent = `$${totalPrice.toFixed(2)}`;
    }

    // Event listener for clicking the cart icon to show the cart modal
    cartIcon.addEventListener("click", function() {
        cartModal.style.display = "block";
        renderCart(); // Render the cart items when the modal is opened
    });

    // Event listener for closing the cart modal using the close button
    closeCartBtn.addEventListener("click", function() {
        cartModal.style.display = "none";
    });

    // Event listener for closing the cart modal using the close button inside the modal
    closeCartModalBtn.addEventListener("click", function() {
        cartModal.style.display = "none";
    });

    // Event listener for the checkout button
    checkoutBtn.addEventListener("click", function() {
        // Implement checkout functionality here
        alert("Implement checkout functionality here!");
    });

    // Event listener for decreasing the quantity
    decrementQuantityBtn.addEventListener("click", function() {
        // Implement quantity decrement logic
    });

    // Event listener for increasing the quantity
    incrementQuantityBtn.addEventListener("click", function() {
        // Implement quantity increment logic
    });

    // Render the initial cart items on page load
    renderCart();
    cartQuantitySpan.textContent = cartItems.reduce((total, item) => total + item.quantity, 0);
});

</script>



</body>
</html>