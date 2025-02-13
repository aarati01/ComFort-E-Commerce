$(document).ready(function() {
  // Add custom validation method for strong password
  jQueryjQuery.validator.addMethod("strongPassword", function(value, element) {
    return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(value);
}, "Password must contain at least one uppercase letter, one lowercase letter, one number, and be at least 8 characters long.");


  jQuery.validator.addMethod("customEmailPattern", function(value, element) {
    return this.optional(element) || /^[a-z0-9._%+-]+@gmail\.com$/.test(value); // Change the pattern as needed
}, "Please enter a valid email address ending with @gmail.com");

  // Initialize form validation
  $("#login-form").validate({
      rules: {
          email: {
              required: true,
              email: true,
              customEmailPattern: true // Use custom validation method for specific email pattern

          },
          password: {
              required: true, // password is required
              minlength: 8, // password should be at least 8 characters long
              strongPassword: true
          },
      },
      messages: {
          email: {
              required: "Please enter  your email address",
              email: "Please enter a valid email address",
              customEmailPattern: "Please enter a valid email address ending with @gmail.com"

          },
          password: {
              required: "Please enter your password",
              minlength: "Password must be at least 8 characters long"
          },
          
      }
  });
});
