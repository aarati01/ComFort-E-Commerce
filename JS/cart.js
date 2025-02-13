document.addEventListener("DOMContentLoaded", function() {
    const addToCartBtn = document.getElementById("addToCartBtn");
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

    // Function to add an item to the cart or update its quantity if already present
    function addToCart(productName, productPrice, productQuantity, productImage) {
        const existingItem = cartItems.find(item => item.name === productName);

        if (existingItem) {
            existingItem.quantity += parseInt(productQuantity);
            existingItem.totalPrice += parseFloat(productPrice) * parseInt(productQuantity);
        } else {
            cartItems.push({
                name: productName,
                price: parseFloat(productPrice),
                quantity: parseInt(productQuantity),
                image: productImage,
                totalPrice: parseFloat(productPrice) * parseInt(productQuantity)
            });
        }

        saveCartItems();
        renderCart();
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

    // Event listener for adding a product to the cart
    addToCartBtn.addEventListener("click", function() {
        const productName = document.querySelector(".single-pro-details h4").textContent;
        const productPrice = parseFloat(document.querySelector(".single-pro-details h2").textContent.replace('$', ''));
        const productQuantity = parseInt(document.querySelector(".single-pro-details input[type='number']").value);
        const productImage = document.querySelector(".single-pro-image img").src;

        addToCart(productName, productPrice, productQuantity, productImage);
        cartQuantitySpan.textContent = cartItems.reduce((total, item) => total + item.quantity, 0);
    });

    // Event listener for clicking the cart icon to show the cart modal
    cartIcon.addEventListener("click", function() {
        cartModal.style.display = "block";
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
        const productName = document.querySelector(".cart-item h4").textContent;
        const existingItem = cartItems.find(item => item.name === productName);

        if (existingItem && existingItem.quantity > 1) {
            existingItem.quantity--;
            existingItem.totalPrice -= existingItem.price;
        } else {
            removeFromCart(productName);
        }

        saveCartItems();
        renderCart();
        cartQuantitySpan.textContent = cartItems.reduce((total, item) => total + item.quantity, 0);
    });

    // Event listener for increasing the quantity
    incrementQuantityBtn.addEventListener("click", function() {
        const productName = document.querySelector(".cart-item h4").textContent;
        const existingItem = cartItems.find(item => item.name === productName);

        if (existingItem) {
            existingItem.quantity++;
            existingItem.totalPrice += existingItem.price;
            saveCartItems();
            renderCart();
            cartQuantitySpan.textContent = cartItems.reduce((total, item) => total + item.quantity, 0);
        }
    });

    // Render the initial cart items on page load
    renderCart();
    cartQuantitySpan.textContent = cartItems.reduce((total, item) => total + item.quantity, 0);
});