var emailInput = document.getElementById("email");
var passwordInput = document.getElementById("password");
var loginButton = document.getElementById("loginButton");

function validateForm() {
  // Check if the email is an email
  var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  var isValidEmail = emailPattern.test(emailInput.value);

  // Check that the password is not empty
  var isValidPassword = passwordInput.value.trim() !== "";

  // Activate or deactivate the "Connect" button depending on the validations
  if (isValidEmail && isValidPassword) {
    loginButton.disabled = false;
  } else {
    loginButton.disabled = true;
  }
}

// Add event listeners for input fields
email.addEventListener("input", validateForm);
password.addEventListener("input", validateForm);
