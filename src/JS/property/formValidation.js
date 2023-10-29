// Get the necessary fields
var labelField = document.getElementById("label");
var priceField = document.getElementById("price");
var livingAreaField = document.getElementById("livingArea");
var totalAreaField = document.getElementById("totalArea");
var bedroomField = document.getElementById("bedroom");
var bathroomField = document.getElementById("bathroom");
var toiletField = document.getElementById("toilet");
var descriptionField = document.getElementById("description");
var adTypeField = document.getElementById("adType");
var propertyTypeField = document.getElementById("propertyType");
var energyClassField = document.getElementById("energyClass");
var isSoldField = document.getElementById("isSold");
var imageField = document.getElementById("image");
var submitButton = document.getElementById("submitButton");

function validateNumericInput(input) {
  // Remove non-numeric characters
  input.value = input.value.replace(/\D/g, "");
}

// Function to check if all fields are filled
function checkFormValidity() {
  var isLabelValid = labelField.value.trim() !== "";
  var isPriceValid = priceField.value.trim() !== "";
  var isLivingAreaValid = livingAreaField.value.trim() !== "";
  var isTotalAreaValid = totalAreaField.value.trim() !== "";
  var isBedroomValid = bedroomField.value.trim() !== "";
  var isBathroomValid = bathroomField.value.trim() !== "";
  var isToiletValid = toiletField.value.trim() !== "";

  // Activate or deactivate the button depending on the validity of the fields
  submitButton.disabled = !(
    isLabelValid &&
    isPriceValid &&
    isLivingAreaValid &&
    isTotalAreaValid &&
    isBedroomValid &&
    isBathroomValid &&
    isToiletValid
  );
}

// Listen for input events in necessary fields
labelField.addEventListener("input", checkFormValidity);
priceField.addEventListener("input", checkFormValidity);
livingAreaField.addEventListener("input", checkFormValidity);
totalAreaField.addEventListener("input", checkFormValidity);
bedroomField.addEventListener("input", checkFormValidity);
bathroomField.addEventListener("input", checkFormValidity);
toiletField.addEventListener("input", checkFormValidity);
descriptionField.addEventListener("change", checkFormValidity);
adTypeField.addEventListener("change", checkFormValidity);
propertyTypeField.addEventListener("change", checkFormValidity);
energyClassField.addEventListener("change", checkFormValidity);
isSoldField.addEventListener("change", checkFormValidity);
imageField.addEventListener("change", checkFormValidity);
