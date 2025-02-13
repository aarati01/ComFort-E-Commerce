// for ham-burger

document.addEventListener('DOMContentLoaded', function() {
    const bar = document.getElementById("bar");
    const nav = document.getElementById("navbar");

    if (bar) {
        bar.addEventListener("click", function() {
            nav.classList.toggle("active");
        })
    }
})

//jquery widget

$(document).ready(function() {
    $( "#speed" ).selectmenu();
 
    $( "#files" ).selectmenu();
 
    $( "#number" )
      .selectmenu()
      .selectmenu( "menuWidget" )
        .addClass( "overflow" );
 
    $( "#salutation" ).selectmenu();
  } );
  $(document).ready(function() {
    $( document ).tooltip();
  } );

  // function for available quantity
  
  document.addEventListener("DOMContentLoaded", function() {
    var quantityInput = document.querySelector("input[type='number']");
    var addToCartBtn = document.getElementById("addToCartBtn");
    var availableQuantitySpan = document.getElementById("availableQuantity");

    // Get the initial available quantity from localStorage or set default value
    var availableQuantity = parseInt(localStorage.getItem("availableQuantity")) || 99;

    // Update available quantity display
    availableQuantitySpan.textContent = "Available: " + availableQuantity;

    // Add click event listener to the "Add to Cart" button
    addToCartBtn.addEventListener("click", function() {
        var quantitySelected = parseInt(quantityInput.value);

        // Check if quantity selected is valid and does not exceed available quantity
        if (quantitySelected >= 1 && quantitySelected <= availableQuantity) {
            // Update available quantity based on the selected quantity
            availableQuantity -= quantitySelected;
            availableQuantitySpan.textContent = "Available: " + availableQuantity;

            // Store the updated available quantity in localStorage
            localStorage.setItem("availableQuantity", availableQuantity);

            // Add logic to add the product to the cart (e.g., store in localStorage, update UI)
            addToCart(quantitySelected);
        } else {
            alert("Please enter a valid quantity within the available range.");
        }
    });
});



// For Search function
document.addEventListener("DOMContentLoaded", function() {
    const search = () => {
        const searchbox = document.getElementById("search").value.toUpperCase();
        const productContainers = document.querySelectorAll(".product-list");

        productContainers.forEach(container => {
            const products = container.querySelectorAll(".pro");

            products.forEach(product => {
                const productName = product.querySelector("h5");
                
                if (productName) {
                    const textValue = productName.textContent.toUpperCase();

                    if (textValue.includes(searchbox)) {
                        product.style.display = "block";
                    } else {
                        product.style.display = "none";
                    }
                }
            });
        });
    }

    document.getElementById("search").addEventListener("keyup", search);
});


