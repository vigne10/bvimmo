// REGEX check of email
function validateEmail(email) {
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

// Password REGEX verification
function validatePassword(password) {
  var passwordRegex =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
  return passwordRegex.test(password);
}

// Function to update check icon
function updateVerificationIcon(elementId, isValid) {
  var iconElement = $("#" + elementId);
  if (isValid) {
    iconElement.attr("class", "fa-solid fa-circle-check");
    iconElement.css("color", "#36cd18");
  } else {
    iconElement.attr("class", "fa-solid fa-circle-xmark");
    iconElement.css("color", "#ff0000");
  }
}

$(document).ready(function () {
  // Disable the ability to copy/paste in the email and password verification fields
  $("#email_confirmation, #password_confirmation").on(
    "cut copy paste",
    function (e) {
      e.preventDefault();
    }
  );

  // Checking email and displaying the result
  $("#email").on("input", function () {
    var email = $(this).val();
    var isValid = validateEmail(email);
    updateVerificationIcon("email_icon", isValid);
  });

  // Checking confirmation email and displaying the result
  $("#email_confirmation").on("input", function () {
    var email = $(this).val();
    var originalEmail = $("#email").val();
    var isValid = validateEmail(email) && email === originalEmail;
    updateVerificationIcon("email_confirmation_icon", isValid);
  });

  // Checking password and displaying the result
  $("#password").on("input", function () {
    var password = $(this).val();
    var isValid = validatePassword(password);
    updateVerificationIcon("password_icon", isValid);
  });

  // Checking password confirmation and displaying the result
  $("#password_confirmation").on("input", function () {
    var password = $(this).val();
    var originalPassword = $("#password").val();
    var passwordConfirmationIsValid = password === originalPassword;
    updateVerificationIcon(
      "password_confirmation_icon",
      passwordConfirmationIsValid
    );
  });

  // Checking name and surname and displaying the result
  $("#name_surname").on("input", function () {
    var name_surname = $(this).val();
    var isValid = name_surname !== "";
    updateVerificationIcon("name_surname_icon", isValid);
  });

  // Checking address and displaying the result
  $("#address").on("input", function () {
    var address = $(this).val();
    var isValid = address !== "";
    updateVerificationIcon("address_icon", isValid);
  });

  // Function to check if all information is filled in correctly
  function validateForm() {
    var email = $("#email").val();
    var email_confirmation = $("#email_confirmation").val();
    var isEmailValid = validateEmail(email);
    var isEmailConfirmationValid = email === email_confirmation;
    var password = $("#password").val();
    var password_confirmation = $("#password_confirmation").val();
    var isPasswordValid = validatePassword(password);
    var isPasswordConfirmationValid = password === password_confirmation;
    var isNameSurnameValid = $("#name_surname").val() !== "";
    var isAddressValid = $("#address").val() !== "";
    var isCountryValid = $("#country").val() !== "";
    var isCityValid = $("#city").val() !== "";
    var isConditionsAccepted = $("#conditions").is(":checked");

    // Check if all information is valid
    var isFormValid =
      isEmailValid &&
      isEmailConfirmationValid &&
      isPasswordValid &&
      isPasswordConfirmationValid &&
      isNameSurnameValid &&
      isAddressValid &&
      isCountryValid &&
      isCityValid &&
      isConditionsAccepted;

    // Update the state of the "Register" button
    if (isFormValid) {
      $("#register_button").prop("disabled", false);
    } else {
      $("#register_button").prop("disabled", true);
    }
  }

  // Call check function when fields are changed
  $("input").on("input", validateForm);
  $("select").on("change", validateForm);
  $("#conditions").on("change", validateForm);

  // Disable the "Subscribe" button on page load
  $("#register_button").prop("disabled", true);
});
