$(document).ready(function() {
    // Validation rules using jQuery Validate plugin
    $("#registration-form").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2
            },
            last_name: {
                required: true,
                minlength: 2
            },
            username: {
                required: true,
                minlength: 4,
                alphanumeric: true 

            },
            email: {
                required: true,
                email: true
            },
        
            're-password': {
                required: true,
                equalTo: "#password"
            },
        },
        messages: {
            first_name: {
                required: "Please enter your first name",
                minlength: "Your first name must be at least 2 characters long"
            },
            last_name: {
                required: "Please enter your last name",
                minlength: "Your last name must be at least 2 characters long"
            },
            username: {
                required: "Please enter a username",
                minlength: "Your username must be at least 4 characters long"
            },
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            },
            
            
            're-password': {
                required: "Please confirm your password",
                equalTo: "Your passwords do not match"
            },
        }
        
    });
    
    $( function() {
        $( "#datepicker" ).datepicker({
            maxDate: '0', // Set maximum date
            dateFormat: 'mm-dd-yy'
        });
      } );
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
    

    // Event listener for password input
    var myInput = document.getElementById("password");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
    }

    myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
    }

    myInput.onkeyup = function() {
        // Validate password strength
        var lowerCaseLetters = /[a-z]/g;
        var upperCaseLetters = /[A-Z]/g;
        var numbers = /[0-9]/g;

        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        if (myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        if (myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }    
});